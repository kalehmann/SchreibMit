### Entwicklung

Generelle Schritte

- Docker Stack starten: `docker-compose up`
- Datenbankschema erstellen:
    ```
    docker-compose run php bash
    composer install
    php bin/console doctrine:schema:create
    ```
- Geodaten der Postleitzahlen einlesen
  * Die [Postleitzahlendatenbank](https://launix.de/launix/wp-content/uploads/2019/06/PLZ.csv) herunterladen
  * Die Datenbank importieren
      ```
      docker-compose run php bash
      php bin/console drk:import PLZ.csv
      ```
- einen Administrator für das Backend erstellen
    ```
    docker-compose run php bash
    php bin/console drk:create-admin
    ```
- die Tests ausführen
    ```
    docker-compose run php bash
    vendor/bin/codecept run
    ```

Die einzelnen Funktionen sind unter folgenden URLs erreichbar:

1. Die Anwendung unter [http://localhost:80](http://localhost:80)
2. Das Backend unter [http://localhost:80/admin](http://localhost:80/admin)
3. Das E-Mail testing Tool [MailHog](https://github.com/mailhog/MailHog) unter [http://localhost:81](http://localhost:81)