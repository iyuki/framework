# Framework

MVP framework, který byl použit v projektu LitKeep. Je uvolněn pod licencí MIT, tudíž jej můžete užívat, editovat, atp., pokud to nezasáhne do pravidel dané licence.

## Modely

Modely se nacházejí ve složce Model. Jedná se o obyčejnou třídu s jmenným prostorem Model. Do databáze má přístup díky statické třídě Database. Ta obsahuje základní metody "simple" a "parameters". Jak už název napovídá, simple vytvoří jednoduchý dotaz bez parametrů, parameters obyčejný s parametry. Občas zlobí nastavení integeru, tudíž musíte v modelu přímo volat $connection, bindParam a execute.

## Pohledy

Pohledy jsou uloženy ve složce View. Jedná se o soubory .phtml. Do pohledu můžete přiřadit proměnou v presenteru nebo v komponentě a to pomocí pole Vendor\Pattern::data. Pohled se vykreslí metodou Vendor\Pattern::renderView() - parametrem je cesta pohledu bez složky Model a bez přípony .phtml.

## Presenter

Presentery se nachází ve složce Presenter. Dědí z třídy Vendor\Pattern a mají jmenný prostor s názvem Presenter. Můžete v nich vytvořit čtyři nepovinné metody: start(), která se chová jako konstruktor, end(), což je vlastně destruktor, render<view>(), která obsahuje veškerou logiku pro zobrazení pohledů a action<view>(), která řídí chod aplikace.

## Komponenty

Komponenty se chovají a vypadají stejně jako Presentery. Jediný rozdíl je v tom, že je musíte někde volat (nejlépe v Presenteru). Jejich jmenným prostorem je Component. Místo metody start() je vhodné užít obyčejného konstruktoru.

## Konfigurační soubory

Ty se nacházejí ve složce Config. Prvním je Config\config.json. V něm naleznete základní konfiguraci aplikace, včetně databázové konfigurace. V proměnné workspace je uložen název složky, který nesouvisí s frameworkem. Pokud je aplikace na localhost/test_framework/public/index.php, potom se dá "test_framework/public" počítat jako nesouvisející. Na hostingu může být proměnná prázdná.

V souboru Config\routes.json se nachází povolené adresy ve formátu:

"article/<id>": "Article:show"

První parametr je URL adresa. Proměnná se dá zapsat do ostrých závorek. Druhý parametr je cesta ve formátu "Presenter:pohled".

## Veřejné soubory

Soubory, které budou vidět na hostingu. Nachází se ve složce "Public". Zde se také nachází soubor .htaccess, obrázky, JS skripty, CSS soubory, atp.

## Vendor

Vendor jsou knihovny třetí strany, včetně samotného frameworku. Nachází se ve složce Vendor. Jedná-li se o framework, má jmenný prostor Vendor.
