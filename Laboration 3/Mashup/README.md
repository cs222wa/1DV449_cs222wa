# 1DV449_cs222wa

## [Körbar version av applikationen](http://cs222wa.node365.se/1dv449/mashup/Index.php)

##Reflektionsfrågor - Laboration 3
###Vad finns det för krav du måste anpassa dig efter i de olika API:erna?
Gällande Open Street Map så ville de i stort sett bara att man skulle ge dem ett igenkännande genom att använda "© OpenStreetMap contributors" någonstans på sin sida.
Man bör hålla nere antal http requests, enligt mig även om det inte står som ett uttryckligt krav, just för att visa respekt och allmän hänsyn.
Sveriges Radio hade ett krav om att "Materialet som tillhandahålls via API får inte användas på ett sådant sätt att det skulle kunna skada Sveriges Radios oberoende eller trovärdighet."

###Hur och hur länga cachar du ditt data för att slippa anropa API:erna i onödan?
Under arbetet uppdaterade jag var 15'e minut för att  hålla nere antalet anrop, men ändrade det till 1 minut när jag lade upp sidan på servern för att hålla informationen så aktuell som möjligt. Information från SR lagras i en js-fil som ett json objekt och jag har en if-sats som kontrollerar om filen redan existerar samt använder sig av filemtime()  för ta redan på hur lång tid som i så fall gått sedan filen skapades, då ny information försöks hämtas ner.

###Vad finns det för risker kring säkerhet och stabilitet i din applikation?
Det finns inga input fält för fritext i applikationen, vilket minimerar säkerhetsriskerna mycket då input är begränsat till förvalda värden.
Gällande stabiliteten är jag beroende av att de script jag läst in som tillhandagavs av leaflet. Även inladdning av kartan etc är en stabilitetsrisk, i det långa loppet.

###Hur har du tänkt kring säkerheten i din applikation?
Inga inputfält (se föregående fråga), ingen inloggning, plus att jag inte använder mig av någon form av databas för att lagra informationen jag får in.
I övrigt har jag inte tänkt så mycket på just säkerheten under den här labben då det har strulat mycket för mig att bara kunna hämta ut informationen som behövdes ifrån API'et. Jag är medveten om att det finns mycket man borde kontrollerat, ex. validering av datan man får tillbaka av API'et, kontroll av koden som används i de script jag läser in utifrån etc.

###Hur har du tänkt kring optimeringen i din applikation?
Jag har all relevant kod i en js-fil, men har dock inte använt någon form av minimering själv, utan har bara det i de externa scripten som laddas in i applikationen.
Jag har även lagt CSS-filerna i headern och mina script precis innan </body> taggen för att inläsningen av respektive fil ska göras i mest effektiv ordning.
Vissa resurser som tillhör OpenStreetMaps (scripts/css) läses in från extern källa, snarare än min egna server.
För att undvika långa CSS-filer där inte allt kommer användas skrev jag en egen CSS-fil som bara innehåller relevant CSS till element som berörs på sidan.


