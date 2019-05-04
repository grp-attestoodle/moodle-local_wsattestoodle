# Service Web Attestoodle

Le service web d'Attestoodle fournit les informations de la dernière attestation réalisée pour un apprenant.

Il utilise le protocole XML-RCP.

L'utilsation est illustrée avec le source /client/testws.php

On appel la méthode :
    getlastcertificate($username)  
    
Le paramètre $username correspond au login de l'apprenant dont on souhaite obtenir les informations de la dernière attestation.

Le resultat est fournit au format JSON  
Exemple

En cas d'erreur on peut obtenir :

