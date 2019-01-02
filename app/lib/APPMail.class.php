<?php
namespace Lib;

require_once LIB_PATH.'PHPMailer/class.phpmailer.php';
require_once LIB_PATH.'PHPMailer/class.smtp.php';

class APPMail extends \PHPMailer{

        private $smtp_smtpdebug;
        private $smtp_debugoutput;
        private $smtp_host;
        private $smtp_port;
        private $smtp_smtpsecure;
        private $smtp_smtpauth;
        private $smtp_username;
        private $smtp_password;
        private $from_name;
        private $from_email;
        private $send_name;
        private $send_email;
        private $send_msm;
        private $send_asunto;
        private $send_addattachment;
        
        
        public function __construct()
        {
        
                $config = \Lib\Config::singleton();
                $sessionData = $config->get('SESSION_DATA');       
                $sessionData =$sessionData['SI_CF_PARAM'];
                        
                $this->isSMTP();
                //Enable SMTP debugging
                // 0 = off (for production use)
                // 1 = client messages
                // 2 = client and server messages    
                $this->set_smtp_smtpdebug(0);
                //Ask for HTML-friendly debug output                
                $this->set_smtp_debugoutput('html');
                //Set the hostname of the mail server
                $this->set_smtp_host($sessionData["SMTP_SERVER"]);
                // use
                // $this->Host = gethostbyname('smtp.gmail.com');
                // if your network does not support SMTP over IPv6
                //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
                $this->set_smtp_port($sessionData["SMTP_PORT"]);
                //Set the encryption system to use - ssl (deprecated) or tls
                $this->set_smtp_smtpsecure($sessionData["SMTP_SECURE"]);
                //Whether to use SMTP authentication
                $this->set_smtp_smtpauth($sessionData["SMTP_AUTH"]) ;
                //Username to use for SMTP authentication - use full email address for gmail
                $this->set_smtp_username($sessionData["SMTP_USER"]);
                //Password to use for SMTP authentication
                $this->set_smtp_password($sessionData["SMTP_PW"]);  
                //Set who the message is to be sent from     
                $this->set_from_name($sessionData["EMAILFROM"]);
                $this->set_from_email($sessionData["EMAILFROM_NAME"]);
                                
        }

        //Metodos de encapsulamiento
        //Get y Set
        public function &set_smtp_smtpdebug($smtp_smtpdebug) {
                $this->smtp_smtpdebug = $smtp_smtpdebug;
                $this->SMTPDebug=$smtp_smtpdebug;
                return $this;
        }
        
        public function &get_smtp_smtpdebug() {
                return $this->smtp_smtpdebug;
        } 

        public function &set_smtp_debugoutput($smtp_debugoutput) {
                $this->smtp_debugoutput = $smtp_debugoutput;
                $this->Debugoutput = $smtp_debugoutput;
                return $this;
        }
        
        public function &get_smtp_debugoutput() {
                return $this->smtp_debugoutput;
        } 

        public function &set_smtp_host($smtp_host) {
                $this->smtp_host = $smtp_host;
                $this->Host= $smtp_host;
                return $this;
        }
        
        public function &get_smtp_host() {
                return $this->smtp_host;
        } 

        public function &set_smtp_port($smtp_port) {
                $this->smtp_port = $smtp_port;
                $this->Port = $smtp_port; 
                return $this;
        }
        
        public function &get_smtp_port() {
                return $this->smtp_port;
        } 

        public function &set_smtp_smtpsecure($smtp_smtpsecure) {
                $this->smtp_smtpsecure = $smtp_smtpsecure;
                $this->SMTPSecure= $smtp_smtpsecure;
                return $this;
        }
        
        public function &get_smtp_smtpsecure() {
                return $this->smtp_smtpsecure;
        } 

        public function &set_smtp_smtpauth($smtp_smtpauth) {
                $this->smtp_smtpauth = $smtp_smtpauth;
                $this->SMTPAuth= $smtp_smtpauth;
                return $this;
        }
        
        public function &get_smtp_smtpauth() {
                return $this->smtp_smtpauth;
        } 
                
        public function &set_smtp_username($smtp_username) {
                $this->smtp_username = $smtp_username;
                $this->Username= $smtp_username;
                return $this;
        }
        
        public function &get_smtp_username() {
                return $this->smtp_username;
        }     

        public function &set_smtp_password($smtp_password) {
                $this->smtp_password = $smtp_password;
                $this->Password = $smtp_password;
                return $this;
        }
        
        public function &get_smtp_password() {
                return $this->smtp_password;
        }  

        public function &set_from_name($from_name) {
                $this->from_name = $from_name;
                return $this;
        }
        
        public function &get_from_name() {
                return $this->from_name;
        }  

        public function &set_from_email($from_email) {
                $this->from_email = $from_email;
                return $this;
        }
        
        public function &get_from_email() {
                return $this->from_email;
        } 

        public function &set_send_name($send_name) {
                $this->send_name = $send_name;
                return $this;
        }
        
        public function &get_send_name() {
                return $this->send_name;
        } 

        public function &set_send_email($send_email) {
                $this->send_email = $send_email;
                return $this;
        }
        
        public function &get_send_email() {
                return $this->send_email;
        } 

        public function &set_send_msm($send_msm) {
                $this->send_msm = $send_msm;
                return $this;
        }
        
        public function &get_send_msm() {
                return $this->send_msm;
        } 

        public function &set_send_asunto($send_asunto) {
                $this->send_asunto = $send_asunto;
                return $this;
        }
        
        public function &get_send_asunto() {
                return $this->send_asunto;
        } 

         public function &set_send_addattachment($send_addattachment) {
                $this->send_addattachment = $send_addattachment;
                return $this;
        }
        
        public function &get_send_addattachment() {
                return $this->send_addattachment;
        } 

        //Metodo para enviar mensaje
        public function sendMail(){ 
                $retornar=false;                
                //Set who the message is to be sent from
                $from_name=$this->get_from_name();
                $from_email=$this->get_from_email();
                $this->setFrom($from_name,$from_email);        
                //Set parametros para envio de Email
                $send_name=$this->get_send_name();
                $send_email=$this->get_send_email();
                $send_msm=$this->get_send_msm();                
                $send_asunto=$this->get_send_asunto();
                $send_addattachment=$this->get_send_addattachment();
                if (!empty($send_name) && !empty($send_email) && !empty($send_msm) && !empty($send_asunto) && !empty($from_name) && !empty($from_email)) {
                        //Set an alternative reply-to address
                        //$this->addReplyTo('replyto@example.com', 'First Last');
                        //Set who the message is to be sent to
                        $this->addAddress($send_email, $send_name);
                        //Set the subject line
                        $this->Subject = $send_asunto;
                        //Read an HTML message body from an external file, convert referenced images to embedded,
                        //convert HTML into a basic plain-text alternative body
                        $this->msgHTML($send_msm);
                        //Replace the plain text body with one created manually
                        $this->AltBody = $send_msm;                        
                        //Attach an image file
                        $this->addAttachment($send_addattachment); 
                        //Envio de Mensaje 
                        if($this->Send()) {
                               // echo "Mensaje enviado correctamente";
                               $retornar=true;
                        }else{
                                // echo "Error: " . $this->ErrorInfo;                               
                        }
                }
                else{
                       // echo 'Mensaje no enviado, error.';
                }
                return $retornar;
        }
      
}