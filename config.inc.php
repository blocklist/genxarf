<?php
#######################################################
##
##      Projekt:   X-ARF
##      Datei:     config.inc.php
##      Version:   1.1
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
                                    'sourcetype' => 'ip-address',
                                    'schema' => 'http://www.x-arf.org/schema/abuse_login-attack_0.1.1.json'
                                   ),
                            'postfix' => array(
                                         'name' => 'mail',
                                         'port' => '25',
                                         'category' => 'info',
                                         'reporttype' => 'harvesting',
                                         'sourcetype' => 'ip-address',
                                         'schema' => 'http://www.x-arf.org/schema/info_0.1.0.json'
                                        ),
                            'courierpop3' => array(
                                             'name' => 'courierpop3',
                                             'port' => '110',
                                             'category' => 'abuse',
                                             'reporttype' => 'login-attack',
                                             'sourcetype' => 'ip-address',
                                             'schema' => 'http://www.x-arf.org/schema/abuse_login-attack_0.1.1.json'
                                            ),
                            'courierimap' => array(
                                             'name' => 'courierimap',
                                             'port' => '143',
                                             'category' => 'abuse',
                                             'reporttype' => 'login-attack',
                                             'sourcetype' => 'ip-address',
                                             'schema' => 'http://www.x-arf.org/schema/abuse_login-attack_0.1.1.json'
                                            ),
                            'apache' => array(
                                        'name' => 'apache-sans attack',
                                        'port' => '80',
                                        'category' => 'abuse',
                                        'reporttype' => 'hack-attack',
                                        'sourcetype' => 'ip-address',
                                        'schema' => 'http://www.x-arf.org/schema/abuse_hack-attack_0.1.0.json'
                                       )
                            );


?>
