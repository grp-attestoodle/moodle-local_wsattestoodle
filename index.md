# Service Web Attestoodle

Le service web d'Attestoodle fournit les informations de la dernière attestation réalisée pour un apprenant.

Il utilise le protocole XML-RPC.

L'utilsation est illustrée avec le source /client/testws.php

On appel la méthode :  
    **getlastcertificate($username)**  
    
Le paramètre $username correspond au login de l'apprenant dont on souhaite obtenir les informations de la dernière attestation.

Le résultat est fournit dans une structure JSON, celle-ci nous informe
 * De l'issue de la recherche via 'result'.
 * Dans le cas nominale de l'ensemble des temps crédités exprimés en minutes. 

Exemple :  

    {
     "result": "true",
     "certif": {
        "training": "Dev attestoodle 2019-2020",
        "lastname": "Leconte",
        "firstname": "Marc",
        "period": "du 2018-09-01 au 2019-07-31",
        "total": 21,
        "milestones": [
            {
                "module": "nouv dev",
                "creditedtime": "2"
            },
            {
                "module": "dernier ajout",
                "creditedtime": "4"
            },
            {
                "module": "devoir_add",
                "creditedtime": "15"
            }
        ]
     }
    }

En cas d'erreur on peut obtenir :  

    {
     "result": "false",
     "cause": "Aucune attestation n'existe pour cet apprenant"
    }

ou  

    {
     "result": "false",
     "cause": "L'utilisateur n'existe pas !"
    }

 
 ## Qualité du code
 
| Module Travis |  Resultat |
|---------------|-----------|
| phplint       |     OK    |
| phplint       |     OK    |
| phpcpd        | OK 474 total lines of code      |
| phpmd         | FOUND 0 ERRORS AND 2 VIOLATIONS |
| codechecker   |     OK    |
| validate      |     OK    |
| savepoints      |     OK    |
| mustache      |     OK    |
| grunt      |     OK    |

