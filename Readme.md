## PflegeFinder

Die Anwendung soll es Menschen ermöglichen anhand ihrer Postleitzahl eine Pflegeeinrichtung in ihrer Nähe zu finden und
sie zur Kontaktaufnahme zu der Einrichtung animieren.

### Geplanter Workflow

#### Aus Sicht eines Nutzers

- Besuch der Website
- Angabe von
  * Name oder Pseudonym
  * E-Mail-Adresse zur späteren Kontaktaufnahme
  * Postleitzahl zur Bestimmung der am nähsten liegenden Pflegeeinrichtung
  * Optional das Alter
 - Erhalt einer E-Mail mit Kontaktinformationen der am nächsten liegenden Pflegeeinrichtung
 
 #### Aus Sicht eines Administrators
 
 - Besuch des geschützten Bereiches
 - Hinzufügen der Informationen einer Pflegeeinrichtung mit
   * Name der Einrichtung
   * Kontaktadresse der Einrichtung
   * Maximale Anzahl an Kontakteinladungen
   * Longitude und Latitude der Einrichtung
- Einsehen der Zahl versendeten Kontakteinladungen pro Einrichtung
- Einsehen der Nutzerdaten
- Löschen von Einrichtungen und Nutzerdaten

### Datenmodel

#### Pflegeheim

* id (int)
* name (string)
* city (string)
* postal_code (string)
* street (string)
* contact_person (string)
* max_contacts (int)
* longitude (double)
* latitude (double)

#### PostalCode

* postal_code (string)
* longitude (double)
* latitude (double)

#### User

* id (int)
* name (string)
* email (string)
* postal_code (string)
* age (int)
* registration_date (datetime)
* pflegeheim_id (int)

### Design

Das Design soll von der Website des JRK Sachsen übernommen werden. Es bietet sich speziell die
[Kontaktseite](https://jrksachsen.de/informationen/kontakt/) an, da auf dieser auch Formularelemente 
verwendet werden.

### Postleitzahl-Geodaten

Für die Verknüpfung von Postleitzahlen mit Geodaten wird die 
[PLZ-Datenbank von Launix](https://launix.de/launix/launix-gibt-plz-datenbank-frei/)
verwendet.  

### Entwicklung

- Stack starten: `docker-compose up`
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