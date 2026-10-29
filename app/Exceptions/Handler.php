<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Messages affichés aux usagers (jamais de détail technique).
     */
    public const MESSAGES = [
        400 => 'La demande envoyée n’a pas pu être traitée. Vérifiez les informations saisies puis réessayez.',
        403 => 'Vous n’avez pas l’autorisation d’effectuer cette action.',
        404 => 'L’élément demandé est introuvable.',
        405 => 'Cette action n’est pas possible depuis cette page.',
        413 => 'Les fichiers envoyés sont trop volumineux. Réduisez leur taille puis réessayez.',
        419 => 'Votre session a expiré pour des raisons de sécurité. Vérifiez vos informations puis renvoyez le formulaire.',
        429 => 'Trop de tentatives en peu de temps. Patientez une minute puis réessayez.',
        500 => 'Une erreur est survenue lors du traitement de votre demande. Réessayez dans quelques instants ; si le problème persiste, contactez le CEFORE.',
        503 => 'La plateforme est en maintenance. Merci de réessayer un peu plus tard.',
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // Erreurs HTTP (session expirée, fichier trop gros, trop de tentatives, 404...)
        $this->renderable(function (HttpExceptionInterface $e, $request) {
            $code = $e->getStatusCode();
            $message = self::MESSAGES[$code] ?? self::MESSAGES[500];

            if ($request->expectsJson()) {
                return response()->json(['message' => $message], $code, $e->getHeaders());
            }

            // Formulaire envoyé avec une session expirée ou des fichiers trop gros :
            // retour au formulaire avec un message, plutôt qu'une page d'erreur.
            if (in_array($code, [413, 419], true) && ! $request->isMethod('GET')) {
                return redirect()->back()
                    ->withInput($request->except(array_merge($this->dontFlash, ['_token'])))
                    ->with('error', $message);
            }

            return null; // page resources/views/errors/{code}.blade.php
        });

        // Appels AJAX : erreur imprévue -> message en français (le détail reste dans les journaux)
        $this->renderable(function (Throwable $e, $request) {
            if (! $request->expectsJson() || config('app.debug')
                || $e instanceof ValidationException
                || $e instanceof AuthenticationException
                || $e instanceof HttpResponseException
                || $e instanceof HttpExceptionInterface) {
                return null;
            }

            return response()->json(['message' => self::MESSAGES[500]], 500);
        });
    }
}
