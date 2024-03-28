<html lang="fr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <!-- <h2>Votre code d'inscription sur la plateforme du SENAFID de l'A.E.E.M.B.</h2> -->
    <p>Bonjour M./Mme {{ $details['nom'] }} {{ $details['prenom'] }}</p>
    <p>Ce mail vous est transmis pour notification de validation à la suite d'une étude de votre demande de création d'entreprise
        sous la dénomination <strong> {{ $details['nom_commercial'] }} </strong>
    </p>
    <strong><p>Nous vous prions d'apporter le dossier physique au {{$details['cefore']}} pour la suite du traitement</p></strong>
    <p>NB : Bien vouloir vous connecter sur la plateforme <a href="https://creerentreprise.me.bf/"> E-création </a> pour suivre le statut de votre demande<br>
     Pour toutes informations veuillez contacter le (+226) 02 21 21 21 - 58 80 77 77 - 56 62 02 02 </p>
  </body>
</html>
