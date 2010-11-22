<?php
#######################################################
##
##      Projekt:   X-ARF
##      Datei:     example.php
##      Version:   1.1
##      Datum:     05.05.2010
##      Copyright: Martin Schiftan
##      license:   http://opensource.org/licenses/gpl-license.php GNU Public License
##
#######################################################

require_once('genxarf.class.php');


$ip     = '89.149.25.4.4.';
$host   = 'geht auch mit gethostbyaddr($ip)';
$datum  = time();       # oder date('D, d M Y H:i:s O');
$dienst = 'ssh';
$logs   = 'logfiles/Spam-Mail/Header....';
// Ohne $class->logs wird das 3 Attachment nicht generiert und Attachment in 2. auf No gestellt.


$xarf         = new xarf($config);
$xarf->ip     = $ip;
$xarf->host   = $host;
$xarf->datum  = $datum;
$xarf->dienst = $dienst;
$xarf->logs   = $logs;

$header  = $xarf->genheader();
$body    = $xarf->genbody();
$subject = $xarf->getsubject();

echo $header;
echo "\n\n";
echo $body;
echo "\n\n";

# mail($to, $subject, $body, $header);

?>
