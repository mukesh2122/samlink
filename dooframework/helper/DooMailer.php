<?php

/**
 * DooMailer class file.
 * @package doo.helper
 * @author Milos Kovacki <kovacki@gmail.com>
 * @link http://www.doophp.com/
 * @copyright Copyright &copy; 2009 Leng Sheng Hong
 * @license http://www.doophp.com/license
 */

/**
 * DooMailer class, for sending e-mails
 *
 * @author Milos Kovacki <kovacki@gmail.com>
 * @copyright &copy; 2009 Milos Kovacki
 * @license http://www.doophp.com/license
 */

include(dirname(__FILE__) . '/../../SwiftMailer-5.0.3/lib/swift_required.php');

class DooMailer {

	/**
	 * Mail charset set
	 * @var string
	 */
	protected $_charset = NULL;

	/**
	 * Mail headers
	 */
	protected $_headers = NULL;

	/**
	 * From address
	 * @var string
	 */
	protected $_from = NULL;

	/**
	 * To address
	 * @var string
	 */
	protected $_to = NULL;

	/**
	 * Email subject
	 * @var string
	 */
	protected $_subject = NULL;

	/**
	 * Email date
	 * @var string
	 */
	protected $_date = NULL;

	/**
	 * Email body text
	 * @var string
	 */
	protected $_bodyText = FALSE;

	/**
	 * Email body HTML
	 */
	protected $_bodyHtml = FALSE;

	/**
	 * Email content type
	 */
	protected $_type = NULL;

	/**
	 * Attachments for email
	 *
	 * @var array
	 */
	protected $_attachments = array();

	/**
	 * End of line combo to use in headers
	 * Some OS / Mail Servers require an alternative line ending
	 * @var string
	 */
	protected $_headerEOL = "\r\n";

	/**
	 * Flag if email has attachments
	 * @var bool
	 */
	public $hasAttachments = FALSE;

	/**
	 * Class constructor
	 *
	 * @param string $charset Charset for mail, default (utf-8)
	 * @param string $headerEOL The string to use for end of line in the mail headers (Note: Use double quotes when defining this)
	 */
	public function __construct($charset = 'UTF-8', $headerEOL = NULL) {
		if($headerEOL === NULL) {
			$os = strtoupper(substr(PHP_OS, 0, 3));
			if($os === 'WIN') { $this->_headerEOL = "\r\n"; }
            elseif($os === 'MAC') { $this->_headerEOL = "\r"; }
            else { $this->_headerEOL = "\n"; };
		} else { $this->_headerEOL = "\r\n"; };
        $this->_charset = $charset;
	}

	/**
	 * Set body text
	 *
	 * @param string $bodyText Text for message body
	 */
	public function setBodyText($bodyText) {
		$this->_bodyText = $bodyText;
	}

	/**
	 * Set body HTML
	 *
	 * @param string $bodyHtml HTML for message body
	 */
	public function setBodyHtml($bodyHtml) {
		$this->_bodyHtml = $bodyHtml;
	}

	/**
	 * Set email subject
	 * @param string $subject Email subject
	 * @param bool $encode Force encoding of subject
	 */
	public function setSubject($subject, $encode = FALSE) {
		if($encode === TRUE) { $this->_subject = '=?' . $this->_charset . '?B?' . base64_encode($subject) . '?='; }
        else { $this->_subject = $subject; };
	}

	/**
	 * Set from field
	 *
	 * @param string $email Email address for from field
	 * @param string $name Name of sender
	 */
	public function setFrom($email, $name = NULL) {
        if(!empty($email)) { $this->_from = array('email' => $email, 'name' => $name); };
	}

	/**
	 * Add email address for to field
	 *
	 * @param string $email Email for reciever
	 * @param string $name Name of person you are sending email
	 */
	public function addTo($email, $name = NULL) {
		if(!empty($email)) { $this->_to = array('email' => $email, 'name' => $name); };
//		if($email !== "") { array_push($this->_to, array($email, $name)); };
	}

	/**
	 * Add attachment to email
	 *
	 * @var string $file
	 */
	public function addAttachment($file, $filename = NULL) {
		if(file_exists($file) && (is_file($file))) {
			// read file
			$tmpFile = fopen($file, 'rb');
			$data = fread($tmpFile, filesize($file));
			fclose($tmpFile);
			// add to array

			if(empty($filename)) { $filename = basename($file); };

			array_push(
				$this->_attachments,
				array(
					'file_name' => $filename,
					'file_type' => filetype($file),
					'file_data' => $data
				)
			);
			$this->hasAttachments = TRUE;
		};
	}

	/**
	 * Get to functon returns all recievers of email
	 *
	 * @param bool $header If header is true (first value true) it will return
	 * to params for header.
	 */
	private function getTo($headers = FALSE) {
		$tmp = "";
		foreach($this->_to as $to) {
			if(isset($to[0])) {
				$name = (isset($to[1])) ? $to[1] : '';
                if(!$headers) { $tmp .= $to[0] . ', '; }
                else { $tmp .= $name . '<' . $to[0] . '>, '; };
			};
		};
		return substr($tmp, 0, -2);
	}

	/*
	 * Create headers and send email
	 *
	 * @return bool Returns true if mail is sent.
	 */
	public function send() {

		// add from
		$from = $this->_from;
		$fromName = (isset($from['name'])) ? $from['name'] : '';
		$fromEmail = (isset($from['email'])) ? $from['email'] : '';

        // Initialize Swiftmailer
        Swift::init($this->swiftmailer_configurator());

        // Set up mailserver array, in case of one failing next will be used in round-robin manner (topdown)
        $transports = array();
        $transports[0] = Swift_SmtpTransport::newInstance()
            ->setUsername('registration@playnation.eu')
            ->setPassword('UaJg9Z87re')
            ->setHost('mail.playnation.eu')
            ->setPort(587)
            ->setEncryption('tls');
        $transports[1] = Swift_SmtpTransport::newInstance()
            ->setUsername('mailer@gsn-hosting.com')
            ->setPassword('taf35gC57B')
            ->setHost('smtp.gsn-hosting.com')
            ->setPort(587)
            ->setEncryption('tls');
        // THE OLDIES
//        $transports[2] = Swift_SmtpTransport::newInstance()
//            ->setUsername('testmail@gsn-hosting.com')
//            ->setPassword('SgWbH3Y9PQ')
//            ->setHost('smtp.gsn-hosting.com')
//            ->setPort(587)
//            ->setEncryption('tls');
//        $transports[3] = Swift_SmtpTransport::newInstance()
//            ->setUsername('henrik@playnation.eu')
//            ->setPassword('paddeHat')
//            ->setHost('mail.playnation.eu')
//            ->setPort(8880)
//            ->setEncryption('tls');
//        $transports[4] = Swift_SmtpTransport::newInstance()
//            ->setUsername('info@playnation.eu')
//            ->setPassword('p14yMa1L')
//            ->setPassword('playnation')
//            ->setHost('mail.playnation.eu')
//            ->setPort(8880)
//            ->setEncryption('tls');
//            ->setAuthMode()
//            ->setTimeout()
//            ->setLocalDomain()
//            ->setSourceIp()

        $transport = Swift_FailoverTransport::newInstance($transports);

        // Instantiate mail object
        $mailer = Swift_Mailer::newInstance($transport);

        // add to
		$to = $this->_to;
		$toName = (isset($to['name'])) ? $to['name'] : '';
		$toEmail = (isset($to['email'])) ? $to['email'] : '';

        // Set message body
        $body = '';
        if($this->_bodyHtml !== FALSE) {
			$body = $this->_bodyHtml;
		};
//        if($this->_bodyText !== FALSE) {
//            $body = $this->_bodyText;
//		};
//        $body .= $this->_headerEOL;

        // Set our Playnation mail header
//        $PlaynationBanner = Swift_Attachment::fromPath(MainHelper::site_url('global/img/mail_header.gif'));

        // Create the message
        $message = Swift_Message::newInstance()
          // Set unique ID for message, usually containing the domain name and time generated
//            ->setId('<' . time() . '@' . $_SERVER['SERVER_NAME'] . '>' . $this->_headerEOL)
          // Set the caracter set
            ->setCharset($this->_charset)
          // Set encoding scheme in the message
            ->setEncoder(Swift_Encoding::get8BitEncoding())
          // Set maximum characters (1000 is safe according to RFC 2822)
            ->setMaxLineLength(1000)
          // Set highest priority of message
//            ->setPriority(1)
          // Set send date
            ->setDate(time())
          // Give the message a subject
            ->setSubject($this->_subject)
          // Set visible sender address (necessary with multiple from)
            ->setSender(Doo::conf()->emailFrom)
          // Set the From address with an associative array
            ->setFrom(array($fromEmail => $fromName))
          // Set the To addresses with an associative array
            ->setTo(array($toEmail => $toName))
          // Give it a body
            ->setBody($body, 'text/html');
          // And optionally an alternative body
//            ->addPart('<q>Here is the message itself</q>', 'text/plain', 'UTF-8')
          // Optionally add any attachments
//            ->attach($PlaynationBanner);
        if($this->_bodyText !== FALSE) {
            $message->addPart($this->_bodyText, 'text/plain');
		};
//        if($this->_bodyHtml !== FALSE) {
//            $message->addPart($this->_bodyHtml, 'text/html');
//		};

        // Add attachments
		if($this->hasAttachments === TRUE) {
			foreach($this->_attachments as $a) {
                $message->attach(Swift_Attachment::fromPath($a));
            };
        };

        // Send the mail
        $failures = array();
        $errTxt = '';
        $result = $mailer->send($message, $failures);
        if(empty($failures)) { return TRUE; }
        else {
            $failNum = count($failures);
            $errTxt .= $failNum . ' deliver' . (($failNum === 1) ? 'y' : 'ies') . ' from : ' . $fromEmail . ' failed...' . $this->_headerEOL . 'Listing recipients : ' . $this->_headerEOL;
            for($i = 0; $i < $failNum; ++$i) { $errTxt .= $failures[$i] . $this->_headerEOL; };
            if($result > 0) { $errTxt .= $this->_headerEOL . $result . ' receivers succeeded.'; };
            return $errTxt;
        };
	}

    public function swiftmailer_configurator() {
        // configure Swift Mailer
//        Swift_DependencyContainer::getInstance()->
        Swift_Preferences::getInstance()->setCharset('UTF-8');
    }
}
?>