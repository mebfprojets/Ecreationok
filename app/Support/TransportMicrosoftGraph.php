<?php

namespace App\Support;

use Illuminate\Mail\Transport\Transport;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Swift_Mime_Attachment;
use Swift_Mime_EmbeddedFile;
use Swift_Mime_SimpleMessage;

/**
 * Envoi des e-mails de l'application par l'API Microsoft Graph (MAIL_MAILER=graph).
 *
 * L'application s'authentifie elle-même (identifiant + secret client) : aucun compte utilisateur,
 * donc pas de double authentification. Tous les envois (Mail::to()->send(), Mail::send()...) passent par ici sans modification.
 * L'expéditeur est la boîte de MAIL_FROM_ADDRESS. Une erreur lève une exception, notée dans envois_mail comme une erreur SMTP.
 */
class TransportMicrosoftGraph extends Transport
{
    private const CLE_JETON = 'microsoft_graph_jeton';
    private const DELAI_SECONDES = 30;

    /** @var array tenant_id, client_id, client_secret */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        $expediteur = array_key_first((array) $message->getFrom());
        // saveToSentItems à false : des milliers d'e-mails automatiques ne doivent pas remplir la boîte d'envoi
        $reponse = Http::timeout(self::DELAI_SECONDES)->withToken($this->jeton())
            ->post('https://graph.microsoft.com/v1.0/users/'.rawurlencode($expediteur).'/sendMail', [
                'message' => $this->convertir($message),
                'saveToSentItems' => false,
            ]);

        if ($reponse->status() === 401) {
            Cache::forget(self::CLE_JETON);   // jeton refusé (secret renouvelé...) : le prochain envoi en redemande un
        }
        if (!$reponse->successful()) {
            throw new RuntimeException('Microsoft Graph (HTTP '.$reponse->status().') : '
                .$reponse->json('error.code').' - '.$reponse->json('error.message'));
        }

        $this->sendPerformed($message);

        return $this->numberOfRecipients($message);
    }

    /** Jeton d'accès de l'application, réutilisé jusqu'à 5 minutes avant son expiration (environ 1 h). */
    private function jeton(): string
    {
        if ($jeton = Cache::get(self::CLE_JETON)) {
            return $jeton;
        }
        if (blank($this->config['tenant_id'] ?? null) || blank($this->config['client_id'] ?? null) || blank($this->config['client_secret'] ?? null)) {
            throw new RuntimeException('Microsoft Graph : renseigner MS_TENANT_ID, MS_CLIENT_ID et MS_CLIENT_SECRET dans le fichier .env.');
        }

        $reponse = Http::timeout(self::DELAI_SECONDES)->asForm()
            ->post('https://login.microsoftonline.com/'.rawurlencode($this->config['tenant_id']).'/oauth2/v2.0/token', [
                'client_id' => $this->config['client_id'],
                'client_secret' => $this->config['client_secret'],
                'scope' => 'https://graph.microsoft.com/.default',
                'grant_type' => 'client_credentials',
            ]);

        if (!$reponse->successful() || blank($reponse->json('access_token'))) {
            throw new RuntimeException('Microsoft Graph, authentification refusée (HTTP '.$reponse->status().') : '
                .$reponse->json('error').' - '.$reponse->json('error_description'));
        }

        Cache::put(self::CLE_JETON, $reponse->json('access_token'), max(60, (int) $reponse->json('expires_in') - 300));

        return $reponse->json('access_token');
    }

    /** Message au format attendu par Graph ; le logo intégré au gabarit (cid:...) devient une pièce « en ligne ». */
    private function convertir(Swift_Mime_SimpleMessage $message): array
    {
        return array_filter([
            'subject' => $message->getSubject(),
            'body' => $this->corps($message),
            'toRecipients' => $this->adresses($message->getTo()),
            'ccRecipients' => $this->adresses($message->getCc()),
            'bccRecipients' => $this->adresses($message->getBcc()),
            'replyTo' => $this->adresses($message->getReplyTo()),
            'attachments' => $this->piecesJointes($message),
        ]);
    }

    /** Version HTML du message si elle existe (Graph n'accepte qu'un seul corps), sinon le texte brut. */
    private function corps(Swift_Mime_SimpleMessage $message): array
    {
        if ($message->getBodyContentType() === 'text/html') {
            return ['contentType' => 'HTML', 'content' => $message->getBody()];
        }
        foreach ($message->getChildren() as $partie) {
            if (!$partie instanceof Swift_Mime_Attachment && $partie->getContentType() === 'text/html') {
                return ['contentType' => 'HTML', 'content' => $partie->getBody()];
            }
        }

        return ['contentType' => 'Text', 'content' => (string) $message->getBody()];
    }

    private function adresses($adresses): array
    {
        return collect((array) $adresses)->map(fn ($nom, $adresse) => [
            'emailAddress' => array_filter(['address' => $adresse, 'name' => $nom]),
        ])->values()->all();
    }

    private function piecesJointes(Swift_Mime_SimpleMessage $message): array
    {
        return collect($message->getChildren())->filter(fn ($partie) => $partie instanceof Swift_Mime_Attachment)
            ->map(function ($piece) {
                $enLigne = $piece instanceof Swift_Mime_EmbeddedFile;

                return array_filter([
                    '@odata.type' => '#microsoft.graph.fileAttachment',
                    'name' => $piece->getFilename() ?: 'piece-jointe',
                    'contentType' => $piece->getContentType(),
                    'contentBytes' => base64_encode($piece->getBody()),
                    'contentId' => $enLigne ? $piece->getId() : null,
                    'isInline' => $enLigne,
                ], fn ($valeur) => $valeur !== null);
            })->values()->all();
    }
}
