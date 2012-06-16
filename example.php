<?php
#######################################################
##
##      Projekt:   X-ARF
##      Datei:     example.php
##      Version:   1.2
##      Datum:     12.12.2011
##      Copyright: Martin Schiftan
##      license:   http://opensource.org/licenses/gpl-license.php GNU Public License
##
#######################################################

require_once('./genxarf.class.php');


$ip     = '89.149.xxx.xxx';
$host   = 'geht auch mit gethostbyaddr($ip)';
$datum  = time();       # oder date('D, d M Y H:i:s O');
$dienst = 'ssh';        # wie im Array $config['dienste']
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

# hier report senden:
mail($to, $subject, $body, $header);

