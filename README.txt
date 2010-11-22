#######################################################
##
##      Projekt:   X-ARF
##      Datei:     genxarf.class.php
##      Version:   1.1
##      Datum:     05.05.2010
##      Copyright: Martin Schiftan
##      license:   http://opensource.org/licenses/gpl-license.php GNU Public License
##
#######################################################


1. config.inc.php oeffnen und entsprechend die Texte und Werte anpassen.
2. example.php oeffnen und anschauen ;-)
3. ausfuehren.


Allgemein braucht man nur folgende Daten:

IP-Adresse + Host,
Datum,
Dienst,
Logfiles,

Dann kann man mit:

$xarf         = new xarf($config);
$xarf->ip     = $ip;
$xarf->host   = $host;
$xarf->datum  = $datum;
$xarf->dienst = $dienst;
$xarf->logs   = $logs;

die Classe aufrufen und die neuen Werte uebergeben und dann mit:
$header  = $xarf->genheader();
$body    = $xarf->genbody();
$subject = $xarf->getsubject();

den Header, den Body und den Betreff generieren lassen.....

Bei Fragen, einfach mailen :-)

root@blocklist.de


