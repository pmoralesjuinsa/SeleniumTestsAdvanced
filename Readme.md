lanzar manualmente un fichero de test:
 bin/behat --lang=es ./features/juinsa.ping.feature 
 
lanzar sólo los pings:
    bin/behat --tags ping

Instalar librería para teams:

    composer require sebbmeyer/php-microsoft-teams-connector