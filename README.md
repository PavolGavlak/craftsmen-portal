# Craftsmen Portal

Website: https://craftsmen-portal.free.nf/index.php  ((! Webová aplikácia je nasadená na free hostingu, pretože slúži iba ako ukážka pracovného portfólia. Rýchlosť načítania je približne 3,5 sekundy.))

## O projekte
Craftsmen Portal je webová aplikácia zameraná na prezentáciu remeselníkov a ich tvorby. Projekt slúži ako verejný katalóg remeselníkov, kde si návštevník môže pozrieť schválené profily, fotografie prác a články z prostredia tradičných remesiel.

Súčasťou projektu je aj administračná a používateľská časť. Bežný používateľ si vie spravovať vlastný profil a fotografie, zatiaľ čo administrátor má prístup ku všetkým registrovaným účtom a ich obsahu.

## Použité technológie
- PHP 8.2
- MySQL / phpMyAdmin
- HTML5
- CSS3
- JavaScript
- PHPMailer
- GLightbox
- XAMPP (lokálne prostredie)

## Funkcionalita aplikácie
Aplikácia obsahuje najmä tieto časti:

- verejnú domovskú stránku s hero sekciou, aktualitami, článkami a kontaktom
- verejný zoznam schválených remeselníkov
- verejný detail profilu remeselníka s galériou fotografií
- filtrovanie remeselníkov podľa mena a druhu remesla
- registráciu a prihlásenie používateľov
- používateľský profil, kde si remeselník môže upravovať vlastné údaje
- nahrávanie, mazanie a nastavovanie profilovej fotografie
- administračnú správu všetkých používateľov
- možnosť administrátora upravovať alebo mazať používateľské účty
- sekciu článkov s detailom jednotlivých článkov
- kontaktný formulár s odosielaním e-mailu

## Používateľské roly
### Verejný návštevník
- vidí schválených remeselníkov
- môže si prezerať profily, fotografie a články

### Prihlásený používateľ
- spravuje iba svoj vlastný profil
- upravuje svoje údaje
- nahráva a spravuje svoje fotografie
- môže vymazať svoj účet

### Administrátor
- vidí všetkých registrovaných používateľov
- môže otvárať a upravovať všetky profily
- spravuje fotografie všetkých používateľov
- môže mazať používateľské účty

## Spustenie projektu
Projekt bol vyvíjaný lokálne cez XAMPP.

### Postup:
1. nakopírovať projekt do priečinka `htdocs`
2. spustiť Apache a MySQL v XAMPP
3. vytvoriť databázu `craftsmen`
4. importovať potrebné tabuľky do databázy
5. upraviť prihlasovacie údaje k databáze v súbore `classes/Database.php`
6. otvoriť projekt v prehliadači, napríklad:
   `http://localhost/craftsmen-portal/`

## Čo som sa na projekte naučil
Na projekte som si precvičil najmä praktický vývoj menšej full-stack webovej aplikácie bez frameworku. Naučil som sa:

- navrhovať štruktúru aplikácie v čistom PHP
- pracovať s databázou MySQL a prepájať ju s PHP logikou
- riešiť používateľské roly a oprávnenia
- vytvárať CRUD operácie pre používateľov a fotografie
- navrhovať responzívne rozhranie v HTML/CSS
- pracovať s JavaScriptom pri interaktívnych prvkoch
- prepájať externé knižnice do projektu
- upratovať a refaktorovať existujúci kód
- riešiť reálne UX/UI problémy počas vývoja

## Cieľ projektu
Cieľom projektu bolo vytvoriť prehľadnú a funkčnú webovú aplikáciu pre prezentáciu remeselníkov, ich tvorby a sprievodného obsahu v podobe článkov a aktualít.

## Autor
Autor projektu: Pavol Gavlák
