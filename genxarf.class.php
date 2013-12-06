<?php
#######################################################
##
##      Projekt:   X-ARF
##      Datei:     genxarf.class.php
##      Version:   1.2
##      Datum:     12.12.2011
##      Copyright: Martin Schiftan
##      license:   http://opensource.org/licenses/gpl-license.php GNU Public License
##
#######################################################
require_once('config.inc.php');




/**
  * @package: X-Arf
  * @author:  Martin Schiftan
  * @version: 1.1$
  * @descrip: Hauptclasse zum generieren von X-ARF-Reports
  * @Classes: xarf
  *
 * Die Classe erstellt den Header und Body fuer die X-ARF-Reports
 */


class xarf
  {
    function __construct($config)
      {
        $this->checkconfig($config);
      }


    public function setfehler($msg)
      {
        die("\n\n".$msg."\n\n");
      }



    /**
      * @name: checkconfig
      * uerberprueft ob alle noetigen Variablen/Einstellungen gesetzt sind und ob das System alle Anforderungen erfuellt
      *
      * @param
      * @return Boolean
    */
    private function checkconfig($config)
      {
        $this->config = $config;
        $return       = 0;
        if((!isset($config['sender']) || (empty($config['sender']))))
          {
            $return = "\n".'Bitte geben Sie eine Sender-Adresse mit $classe->config[\'sender\'] an.';
          }
        if(!is_array($config['dienste']))
          {
            $return = "\n".'Bitte geben Sie die Dienste im Array mit $classe->config[\'dienste\'] = array(\'ssh\' => array(name => \'xx\', port => \'xx\'...)); an.';
          }

        $domain = explode('@', $config['sender']);
        $this->domain = $domain[1];

        if($return !== 0)
          {
            $this->setfehler($return);
          }
        return(1);
      }




    /**
      * @name: getsubject()
      * gibt den Betreff zurueck
      *
      * @param
      * @return Text
    */
    public function getsubject()
      {
         $subject = $this->replacetext($this->config['subject']);
         return($subject);
      }




    /**
      * @name: genheader()
      * generiert den Header der Mail
      *
      * @param
      * @return Text
    */
    public function genheader()
      {
        $this->checkdatum();
        $this->genboundary();

        $header  = "MIME-Version: 1.0\n";
        $header .= 'Reply-To: "'.$this->config['sendername'].'" <'.$this->config['sender'].'>'."\n";
        $header .= 'From: "'.$this->config['sendername'].'" <'.$this->config['sender'].">\n";
        $header .= "Sender: ".$this->config['sender']."\n";
        $header .= "Errors-To: ".$this->config['sender']."\n";
        $header .= "Auto-Submitted: auto-generated\n";
        $header .= "Content-Transfer-Encoding: 7bit\n";
        $header .= "Subject: ".$this->replacetext($this->config['subject'])."\n";
        $header .= "Content-Type: multipart/mixed; \n\t boundary=\"Abuse-".$this->boundary."\";\n";
                $this->xheader = 'X-XARF:';
                if($this->config['xarfversion'] == '0.1')
                  {
                    $this->xarfreporttyp = 'yes';
                        $this->xheader = 'X-ARF:';
                  }
        $header .= $this->xheader.' '.$this->xarfreporttyp."\n";
        $this->header = $header;

        return($header);
      }






    /**
      * @name: genbody()
      * generiert den Body der Mail
      *
      * @param
      * @return Text
    */
    public function genbody()
      {
        if((!isset($this->dienst) || (empty($this->dienst))))
          {
            $this->setfehler("\nBitte geben Sie den Dienst mit \$classe->dienst vorher an.");
          }
        if((!isset($this->logs)) || (empty($this->logs)))
          {
            $this->logfile = 'No';
            $part[3]       = '';
          }
        else
          {
            $this->logfile = 'text/plain';
            $part[3]       = $this->part3();
          }
        $boundary       = $this->boundary;
        $this->reportid = time().$this->genrid().'@'.$this->domain;
        $part[1]        = $this->part1();
        $part[2]        = $this->part2();
        // $part[3] wird vorher schon generiert (ob Logs da sind oder nicht...)

        $this->body = $part[1].$part[2].$part[3];
        return($this->body);
      }






    /**
      * @name: part1()
      * generiert den ersten, menschenlesbaren Teil mit $config['text']...
      *
      * @param
      * @return Text
    */
    public function part1()
      {
        $body  = '--Abuse-'.$this->boundary.'
MIME-Version: 1.0
Content-Transfer-Encoding: 7bit
Content-Type: text/plain; charset=utf-8;

'.$this->replacetext($this->config['text']).'

'.$this->replacetext($this->config['footer']).'
';
        return($body);
      }






    /**
      * @name: part2()
      * generiert den zweiten, X-ARF Teil mit $config['dienste']...
      *
      * @param
      * @return Text
    */
    public function part2()
      {
        if((!isset($this->logs)) || (empty($this->logs)))
          {
            $this->logfile = 'No';
          }
        else
          {
            $this->logfile = 'text/plain';
          }
        $body  = '--Abuse-'.$this->boundary.'
MIME-Version: 1.0
Content-Transfer-Encoding: 7bit
Content-Type: text/plain; charset=utf-8; name="report.txt";

---
Reported-From: '.$this->config['sender'].'
Category: '.$this->config['dienste'][$this->dienst]['category'].'
Report-Type: '.$this->config['dienste'][$this->dienst]['reporttype'].'
Service: '.$this->dienst.'
Version: '.$this->config['xarfversion'].'
User-Agent: '.$this->config['useragent'].'
Date: '.$this->getdatum().'
Source-Type: '.$this->config['dienste'][$this->dienst]['sourcetype'].'
Source: '.$this->ip.'
Port: '.$this->config['dienste'][$this->dienst]['port'].'
Report-ID: '.$this->reportid.'
Schema-URL: '.$this->config['dienste'][$this->dienst]['schema'].'
Attachment: '.$this->logfile.'

';
        return($body);
      }






    /**
      * @name: part3()
      * generiert den dritten, Logs Teil mit den Logs fals noetig oder Header/Spam...
      *
      * @param
      * @return Text
    */
    public function part3()
      {
        $body  = '--Abuse-'.$this->boundary.'
MIME-Version: 1.0
Content-Transfer-Encoding: 7bit
Content-Type: text/plain; charset=utf-8; name="logfile.log";

'.$this->logs.'

--Abuse-'.$this->boundary.'--';

        return($body);
      }






    /**
      * @name: genboundary()
      * generiert den Boundary
      *
      * @param
      * @return string[boundary]
    */
    public function genboundary()
      {
         $boundary = md5(date('r', time()));
         $this->boundary = $boundary;
         return($boundary);
      }




    /**
      * @name: checkdate()
      * prueft und wandelt das Datum um
      *
      * @param
      * @return string[datum]
    */
    public function checkdatum()
      {
        if((!isset($this->datum) || (empty($this->datum))))
          {
            $this->setfehler("\nBitte geben Sie ein Datum mit \$classe->datum an.");
          }
        else
          {
            if(is_numeric($this->datum))
              {
                $this->datum = date('D, d M Y H:i:s O', $this->datum);
              }
            else if((strpos($this->datum, ',')) && (preg_match('#([A-Za-z]){3}, ?.(.[\d]{1,2}) ([0-9]){4} ([\d]{2}:[\d]{2}:[\d]{2})(.*)$#is', $this->datum)))
              {
                $this->datum = $this->datum;
              }
            else
              {
                $this->setfehler("\nBitte das Datum entweder als Unix-Timestamp oder im Format: D, d M Y H:i:s O uebergeben.");
              }
          }
        return($this->datum);
      }




    /**
      * @name: replacetext()
      * ersetzt die Platzhalter in {XXXX} mit dem Value => .....
      *
      * @param
      * @return Text
    */
    public function replacetext($text)
      {
        foreach($this->config['replacewords'] as $key => $value)
          {
            $text = str_replace($key, $this->$value, $text);
          }
        return($text);
      }




    /**
      * @name: getdatum()
      * gibt das formatierte Datum zurueck
      *
      * @param
      * @return string[datum]
    */
    public function getdatum()
      {
         return($this->datum);
      }




    /**
      * @name: genrid()
      * generiert nen ZufallsString
      *
      * @param
      * @return string[rid]
    */
    private function genrid()
      {
        $pd = '';
        $pool = "0123456789";
        srand ((double)microtime()*1000000);
        for($index = 0; $index < 8; $index++)
          {
            $pd .= substr($pool,(rand()%(strlen ($pool))), 1);
          }
        $this->rid = $pd;
        return($this->rid);
      }
  }

