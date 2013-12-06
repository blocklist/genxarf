<?php
#######################################################
##
##      Projekt:   X-ARF
##      Datei:     config.inc.php
##      Version:   1.2
##      Datum:     05.05.2010
##      Copyright: Martin Schiftan
##      license:   http://opensource.org/licenses/gpl-license.php GNU Public License
##
#######################################################

####
##  Sender der Reports (Sender)
####
$config['sender']       = 'noreply@Domain1.tld';
$config['sendername']   = 'Abuse-Team';


####
##  Sender der Reports (Sender)
####
$config['useragent']    = 'V0.0.1 domain.tld';


####
##  Default-Typ of X-ARF Version 0.1 = 'yes'. Version 0.2 = Plain|Secure|Bulk. new in Version 0.2
####
$config['xarfreporttyp'] = 'yes';

###
##   X-ARF Version (currently V0.2) (When Version is 0.1, xarfreporttyp will be set to yes, else "$config[xarfreporttyp]", whenn 0.2)
###
$config['xarfversion'] = '0.2';

####
##  Signatur/Footer fuer die Complaints
####
$config['footer']       = 'footer with pgp-signature and more stuff';


####
##  Betreff der Mail
####
$config['subject']      = 'abuse report about {IP} - {DATUM}';


####
##  Der Text der Complaints (menschen-lesbarer Teil 1)
####
$config['text']         = 'Hello Abuse-Team,

your Server with the IP: {IP} has attacked one of our server on the service:
"{DIENST}"  on Time: {DATUM}
The IP was automatically blocked for more than 10 minutes. To block an IP, it needs
3 failed Logins, one match for "invalid user" or a 5xx-Error-Code (eg. Blacklist)!

Please check the machine behind the IP {IP} ({HOST}) and fix the problem.

You can parse this Mail with X-ARF-Tools (1. attachment = Details, 2. attachment = Logs).
You found more Information about X-Arf under http://www.x-arf.org/specification.html

In the attachment of this mail you can find the original protocols of our systems.

';

####
##  Werte, welche von {XXXXX} durch die Variable => 'xxx' ersetzt werden sollen.
####
$config['replacewords'] = array(
                               '{IP}' => 'ip',
                               '{HOST}' => 'host',
                               '{DATUM}' => 'datum',
                               '{DIENST}' => 'dienst',
                               );



#####
##  Dienste welche reportet werden als array('name', 'name...'); andere werden ignoriert
##  Die Namen nur klein schreiben!
####
$config['dienste'] = array(
                                       'ssh' => array(
                                             'name' => 'ssh',
                                             'port' => '22',
                                             'category' => 'abuse',
                                             'reporttype' => 'login-attack',
                                             'schema' => 'http://www.x-arf.org/schema/abuse_login-attack_0.1.2.json'
                                             ),
                                       'mail' => array(
                                               'name' => 'mail',
                                               'port' => '25',
                                               'category' => 'info',
                                               'reporttype' => 'harvesting',
                                               'schema' => 'http://www.blocklist.de/downloads/schema/info_0.1.1.json'
                                              ),
                                       'amavis' => array(
                                               'name' => 'amavis',
                                               'port' => '25',
                                               'category' => 'info',
                                               'reporttype' => 'harvesting',
                                               'schema' => 'http://www.blocklist.de/downloads/schema/info_0.1.1.json'
                                              ),
                                       'pop3' => array(
                                                'name' => 'pop3',
                                                'port' => '110',
                                                'category' => 'abuse',
                                                'reporttype' => 'login-attack',
                                                'schema' => 'http://www.x-arf.org/schema/abuse_login-attack_0.1.2.json'
                                               ),
                                       'imap' => array(
                                                'name' => 'imap',
                                                'port' => '143',
                                                'category' => 'abuse',
                                                'reporttype' => 'login-attack',
                                                'schema' => 'http://www.x-arf.org/schema/abuse_login-attack_0.1.2.json'
                                               ),
                                       'sasl' => array(
                                                'name' => 'sasl',
                                                'port' => '25',
                                                'category' => 'abuse',
                                                'reporttype' => 'login-attack',
                                                'schema' => 'http://www.x-arf.org/schema/abuse_login-attack_0.1.2.json'
                                               ),
                                       'w00tw00t' => array(
                                                'name' => 'apache-sans attack',
                                                'port' => '80',
                                                'category' => 'abuse',
                                                'reporttype' => 'login-attack',
                                                'schema' => 'http://www.x-arf.org/schema/abuse_login-attack_0.1.2.json'
                                               ),
                                       'badbot' => array(
                                                'name' => 'badbot',
                                                'port' => '80',
                                                'category' => 'info',
                                                'reporttype' => 'info',
                                                'schema' => 'http://www.blocklist.de/downloads/schema/info_0.1.1.json'
                                               ),
                                       'php-url-fopen' => array(
                                                'name' => 'apache rfi attack',
                                                'port' => '80',
                                                'category' => 'abuse',
                                                'reporttype' => 'login-attack',
                                                'schema' => 'http://www.x-arf.org/schema/abuse_login-attack_0.1.2.json'
                                               ),
                                       'webmin' => array(
                                                'name' => 'webmin bruteforce',
                                                'port' => '80',
                                                'category' => 'abuse',
                                                'reporttype' => 'login-attack',
                                                'schema' => 'http://www.x-arf.org/schema/abuse_login-attack_0.1.2.json'
                                               ),
                                       'rfi-attack' => array(
                                                'name' => 'apache rfi attack',
                                                'port' => '80',
                                                'category' => 'abuse',
                                                'reporttype' => 'login-attack',
                                                'schema' => 'http://www.x-arf.org/schema/abuse_login-attack_0.1.2.json'
                                               ),
                                       'apacheddos' => array(
                                                'name' => 'Apache',
                                                'port' => '80',
                                                'category' => 'abuse',
                                                'reporttype' => 'login-attack',
                                                'schema' => 'http://www.blocklist.de/downloads/schema/info_0.1.1.json'
                                               ),
                                       'portflood' => array(
                                                'name' => 'Portflood',
                                                'port' => '80',
                                                'category' => 'info',
                                                'reporttype' => 'info',
                                                'schema' => 'http://www.blocklist.de/downloads/schema/info_0.1.1.json'
                                               ),
                                       'ircbot' => array(
                                                'name' => 'C&C Bot',
                                                'port' => '6667',
                                                'category' => 'abuse',
                                                'reporttype' => 'ircbot',
                                                'schema' => 'http://www.blocklist.de/downloads/schema/info_0.1.1.json'
                                               ),
                                       'regbot' => array(
                                                'name' => 'regBot',
                                                'port' => '80',
                                                'category' => 'abuse',
                                                'reporttype' => 'reg-bot',
                                                'schema' => 'http://www.blocklist.de/downloads/schema/info_0.1.1.json'
                                               ),
                                       'ftp' => array(
                                                'name' => 'ftp',
                                                'port' => '21',
                                                'category' => 'abuse',
                                                'reporttype' => 'login-attack',
                                                'schema' => 'http://www.x-arf.org/schema/abuse_login-attack_0.1.2.json'
                                               ),
                                       'asterisk' => array(
                                                'name' => 'asterisk',
                                                'port' => '5060',
                                                'category' => 'info',
                                                'reporttype' => 'login-attack',
                                                'schema' => 'http://www.blocklist.de/downloads/schema/info_0.1.1.json'
                                               )
                          );


