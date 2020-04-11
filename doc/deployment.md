## Deployment 

### Erstmalige Installation

- Initialisierung der Datenbank, siehe die Schritte der [Entwicklung](entwicklung.md)
- einen Dump der Datenbank erstellen:
   ```
   docker-compose run db bash -c 'mysqldump -u $MYSQL_USER -p$MYSQL_PASSWORD -h db -P 3306 drk' > dump.sql
   ```
- die Datenbank in der Anwendung konfigurieren indem man die Variable `DATABASE_URL` in der `.env` Datei ändert.
- den Dump auf den Server übertragen:
   ```
   mysql -u <user> -p -h <host> <database> < dump.sql 
   ```
- falls der Server nicht von außen erreichbar ist, kann man sich behelfen in dem man folgenden Controller unter
  `src/Controller/InitController.php` anlegt:
   ```php
   <?php
   
   namespace DrkDD\SchreibMit\Controller;
   
   use Doctrine\ORM\EntityManagerInterface;
   use Symfony\Component\HttpFoundation\Response;
   use Symfony\Component\Routing\Annotation\Route;
   
   class InitController
   {
       /**
        * @Route("/init")
        */
       public function initAction(EntityManagerInterface $em)
       {
           $dump = file_get_contents(__DIR__ . '/../../dump.sql');
   
           $pdo = $em->getConnection()->getWrappedConnection();
           $pdo->beginTransaction();
           try {
               $statement = $pdo->prepare($dump);
               $statement->execute();
               while ($statement->nextRowset()) {}
               $pdo->commit();
           } catch (\Exception $e) {
               $pdo->rollBack();
               throw $e;
           }
   
           return new Response('success');
       }
   }
   ```
   anschließend legt man den Datenbankdump in das Projektverzeichnis und ruft einmal `/init` auf.
   **Danach den Controller wieder löschen!**
- Weiterleitung auf HTTPS erzwingen indem man den Block `<IfModule mod_rewrite.c>` um folgendes erweitert:
   ```
   RewriteCond %{SERVER_PORT} 80
   RewriteRule ^(.*)$ https://schreibmit.drksachsen.de/$1 [R,L]
   ```
- Konfiguration des Mailservers indem man die Variable `MAILER_URL` in der `.env` Datei ändert.
- Ändern der Variable `APP_SECRET` in der `.env` Datei
- Ändern der Variable `APP_ENV` auf `prod` in der `.env` Datei


### Spätere Updates

- nach Änderungen des Codes immer den Ordner `/var/cache` löschen