# Pagination
* afficher 10 posts par page
* afficher la page actuelle
* afficher le nb de page en bas du feed


## afficher le nb de page en bas du feed :
1. x = récupérer le nb de posts total
2. nb = x / 10
3. boucle for en bas du feed
4. link chaque lien a la bonne page /?page=3

## afficher la page actuelle :
1. /?page=X
2. isset($_GET['page'])
3. envoyer $_GET['page'] to controller

## afficher 1 posts :
1. récupérer bon numéro page
2. query "... LIMIT " . 10 * (n - 1) . ", 10"
