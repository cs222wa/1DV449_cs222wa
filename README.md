# 1DV449_cs222wa

##Reflektionsfrågor - Laboration 1
###Finns det några etiska aspekter vid webbskrapning. Kan du hitta något rättsfall?
Några etiska aspekter kan vara att datorer läser information från webbsidor betydligt snabbare än en människa kan.
Hackare utnyttjar detta i en taktik som kallas för "Denial of Service" för att överbelasta servrarna så ingen annan kan komma åt webbsidan i fråga.
I övrig handlar det mycket om vad man gör med den skrapade datan, då den kan, med rätt angivna vilkor, gälla under samma regler som vilken annan copyright skyddad information som helst. Förutom frågan om man faktiskt FÅR skrapa datan så måste man fundera på vad man får lov att göra med den när man väl har den. Får man publicera den på nytt? Kan datan, om publicerad, skada någon?

Exempel på rättsfall: År 2000 stämde Ebay en annan webbsida som hette BiddersEdge (nu nedlagd).
Ebay ansåg att användandet av bots/skrapor på deras webbplats utan deras tillåtelse störde deras webbsida och påverkade den negativt.
Ebay vann ärendet eftersom användare som registrerar sig på Ebay först måste godkänna ett terms of service dokument innan de får använda sidan, plus att ett stort antal robotar som konstant jobbar mot sidan faktiskt kunde påverka Ebay's datasystem negativt. Parterna gjorde till slut upp i godo, men den lagliga aspekten av det hela var redan bstämt då det hände.

###Finns det några riktlinjer för utvecklare att tänka på om man vill vara "en god skrapare" mot serverägarna?
*Läs igenom riktlinjerna (Terms & Conditions) för webbsidan och dess innehåll. Finns det speciella clausuler gällande skrapning?
*Fråga webbplatsens ägare om man är osäker.
*Om det är en liten webbsida (ex. privat ägd) - håll isär anropen så servern får tid att 'andas'. Skrapa när sidan inte är belastad ex. på natten.
*Identifiera dig själv i HTTP headern, ex via en User Agent.

###Begränsningar i din lösning- vad är generellt och vad är inte generellt i din kod?
Dynamik (man kan)
*Byta starturl för skrapningen  
*Få fram film och middags resultat för mer än en dag om vännerna är lediga då

Begränsningar (man kan inte)
*Få fram resultat om länkarna på sidan som skall skrapas byter plats. (Går dock om man läser ut nodvärdet av ett länkobjekt i $StartLink arrayen istället för bara dess index placering.)
*Lägga till fler kalendrar - applikationen är begränsad till 3 vänner.

###Vad kan robots.txt spela för roll?
Innehåller information ifall en robot får lov att besöka webbsidan eller i vissa fall enstaka sidor på webbplatsen. (Disallow)
Dock kan robotar/skrapor ignorera denna filen. Alla kan även se vad som står i den, dvs. den ska INTE användas till att gömma information.
