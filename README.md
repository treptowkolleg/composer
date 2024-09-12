# PHP Framework Template

## Einrichtung

### Repository klonen

Erstelle ein neues Projekt, indem du ``Get from VCS`` wählst
und diesen Repository klonst.

![Neues Projekt klonen](docs/img.png)

### Packages installieren

Verwende ``composer install`` zum Installieren aller Packages.

### Environment einrichten

Die Datei ``/config/env.bak.yaml`` muss nach ``config/env.yaml``
umbenannt werden.

In dieser Datei kannst du zum Beispiel Angaben zur Datenbank-Verbindung
machen. Außerdem kannst du festlegen, ob das Projekt im Entwicklungs- oder
Produktionsmodus laufen soll.

``APP_ENV: dev`` stellt den Entwicklungsmodus ein. Alle anderen Werte setzen
den Produktionsmodus aktiv. Während er Entwicklung können so detaillierte
Fehlermeldungen ausgegeben werden. Im Live-Betrieb ist dies unerwünscht.

### Routing

In der Datei ``config/routes.yaml`` sind bereits einige Routen zu
Demonstrationszwecken angelegt. Passe diese deinen Wünschen an. Die
Routen zeigen auf deine Controller-Klassen.

````yaml
# config/routes.yaml
app_index:
  expression: '/'
  controller: 'App\Controller\AppController'
  method: 'index'
  request: 'get'
````

Das oben gezeigte Beispiel zeigt bei der url ``https//web.domain/`` auf
den Controller ``src/Controller/AppController.php`` und ruft die Methode
``index()`` auf. Allerdings sind hier nur ``GET``-Requests erlaubt. ``POST``-Requests
ignorieren diese Route.

### Controller

Unter ``src/Controller`` bzw. im **Namespace** ``App\Controller`` legst
du deine Controller-Klassen an. Deine Routen kannst du auf diese
Controller bzw. seine Methoden leiten.

````php
<?php
# src/Controller/AppController.php

namespace App\Controller;

class AppController
{

    public function index(): string
    {
        return "Hello World!";
    }

}
````

Passend zur obigen Route wurde hier die Controller-Klasse erzeugt. Für
erweiterte Funktionalitäten können deine Controller-Klassen auch von
``Core\Controller\AbstractController`` erben. Dazu später mehr.