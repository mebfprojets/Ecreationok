<html lang="fr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <!-- <h2>Votre code d'inscription sur la plateforme du SENAFID de l'A.E.E.M.B.</h2> -->
    <p>Bonjour M./Mme {{ $details['nom'] }} {{ $details['prenom'] }}</p>
    <p>Ce mail vous est transmis pour notification de rejet à la suite d'une etude de votre demande de création d'entreprise
        sous la dénomination <strong> {{ $details['nom_commercial'] }} </strong>
    </p>
    <strong><p>Motif Rejet: {{ $details['motif'] }}</p></strong>
    <p>NB : Bien vouloir vous connecter sur la plateforme https://creerentreprise.me.bf/ afin d'apporter la correction demandée pour un traitement de votre demande.<br>
     Pour toutes informations veuillez contacter le (+226) 02 21 21 21 - 58 80 77 77 - 56 62 02 02 </p>
  </body>
</html>
