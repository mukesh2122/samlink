<?php
class EmailNotifications {

    function __construct() {
        $this->mail = new DooMailer();

        Doo::loadController('SnController');
        $this->controller = new SnController();
    }

    /**
     * Enter description here...
     *
     */
    public function changeemailConfirmation(Players $p) {
        $snController = new SnController();

        //registration_confirmation(html|txt).
        $this->mail->addTo($p->EMail, $p->NickName);
        $this->mail->setSubject($snController->__("Email changed Confirmation"));

        $arr = array('player' => $p);
        $txt = $this->controller->renderBlock('emails/emailchanged_confirmation_txt', $arr);
        $html = $this->controller->renderBlock('emails/emailchanged_confirmation_html', $arr);

        $this->mail->setBodyText($txt);
        $this->mail->setBodyHtml($html);
        $this->mail->setFrom(Doo::conf()->emailFrom, $snController->__('PlayNation Team'));
        return $this->mail->send();
    }
	
    /**
     * Enter description here...
     *
     */
    public function registrationConfirmation(Players $p) {
        $snController = new SnController();

        //registration_confirmation(html|txt).
        $this->mail->addTo($p->EMail, $p->NickName);
        $this->mail->setSubject($snController->__("Registration Confirmation"));

        $arr = array('player' => $p);
        $txt = $this->controller->renderBlock('emails/registration_confirmation_txt', $arr);
        $html = $this->controller->renderBlock('emails/registration_confirmation_html', $arr);

        $this->mail->setBodyText($txt);
        $this->mail->setBodyHtml($html);
        $this->mail->setFrom(Doo::conf()->emailFrom, $snController->__('PlayNation Team'));
        return $this->mail->send();
    }

	/**
	 * Enter description here...
	 *
	 */
	public function registrationConfirmationAdmin(Players $p) {
		$snController = new SnController();
		//---- Find ID_USERGROUP for Site Admin ----
		$userGroups = Doo::conf()->userGroups;
		$siteAdminGroup = $siteAdmins = false;
		foreach ($userGroups as $key => $record) {
			if ($record['label'] == 'Site Admin') {
				$siteAdminGroup = $key;
				break;
			}
        }
        //---- Find all Site Admins ----
		if ($siteAdminGroup) {
			$siteAdmins = Doo::db()->find('Players', array('where' => 'ID_USERGROUP = '.$siteAdminGroup));
		}
		//---- Abort if no Site Admins to mail ----
		if (empty($siteAdmins)) {
			return false;
		}
		$mailResult = false;   // Success if at least one mail is succeeded
		//---- Send mails to admins ----
		foreach ($siteAdmins as $admin) {
			$this->mail->addTo($admin->EMail, $admin->NickName);

			//registration_confirmation(html|txt).
			$this->mail->setSubject($snController->__("Registration Confirmation"));
	
			$arr = array('player' => $p);
			$txt = $this->controller->renderBlock('emails/registration_confirmation_txt', $arr);
			$html = $this->controller->renderBlock('emails/registration_confirmation_html', $arr);
	
			$this->mail->setBodyText($txt);
			$this->mail->setBodyHtml($html);
			$this->mail->setFrom(Doo::conf()->emailFrom, $snController->__('PlayNation Team'));
			if ($this->mail->send()) {
				$mailResult = true;
			}
		}
		return $mailResult;
    }

    /**
     * Enter description here...
     *
     */
    public function registrationSuccessful(Players $p) {
        $snController = new SnController();

        //registration_successful(html|txt).
        $this->mail->addTo($p->EMail, $p->NickName);
        $this->mail->setSubject($snController->__("Registration Successful"));

        $arr = array('player' => $p);
        $txt = $this->controller->renderBlock('emails/registration_successful_txt', $arr);
        $html = $this->controller->renderBlock('emails/registration_successful_html', $arr);

        $this->mail->setBodyText($txt);
        $this->mail->setBodyHtml($html);
        $this->mail->setFrom(Doo::conf()->emailFrom, $snController->__('PlayNation Team'));
        return $this->mail->send();
    }

    /**
     * Enter description here...
     *
     */
    public function friendRequest() {

    }

    /**
     * Enter description here...
     *
     */
    public function passwordReminder(Players $p) {
        $snController = new SnController();

        //registration_successful(html|txt).
        $this->mail->addTo($p->EMail, $p->NickName);
        $this->mail->setSubject($snController->__("New Password"));

        $arr = array('player' => $p);
        $txt = $this->controller->renderBlock('emails/password_reminder_txt', $arr);
        $html = $this->controller->renderBlock('emails/password_reminder_html', $arr);

        $this->mail->setBodyText($txt);
        $this->mail->setBodyHtml($html);
        $this->mail->setFrom(Doo::conf()->emailFrom, $snController->__('PlayNation Team'));
        return $this->mail->send();
    }

	public function invitation(SnInvitations $invitation){
        $snController = new SnController();

		$p = User::getUser();

		if($p){
			$this->mail->addTo($invitation->EMail);
			$this->mail->setSubject($snController->__("Invitation to PlayNation.eu"));

			$txt = $this->controller->renderBlock('emails/invitation_txt', array('player' => $p, 'invitation' => $invitation));
			$html = $this->controller->renderBlock('emails/invitation_html', array('player' => $p, 'invitation' => $invitation));

			$this->mail->setBodyText($txt);
			$this->mail->setBodyHtml($html);
			$this->mail->setFrom(Doo::conf()->emailFrom, $snController->__('PlayNation Team'));
			return $this->mail->send();
		}
	}

	public function orderComplete(FiOrders $order) {
        $snController = new SnController();

	    $player = User::getById($order->ID_PLAYER);
	    $originalOrderProducts = new FiPurchases();
		$originalOrderProducts->ID_ORDER = $order->ID_ORDER;
		$originalOrderProducts = $originalOrderProducts->find();
        
        if($originalOrderProducts) {
			foreach($originalOrderProducts as $item) {
                $itemId = $item->ID_PRODUCT;
                if($itemId >= '4' && $itemId <= '14'){
                    $this->mail->addTo($player->EMail);
                    $this->mail->setSubject($snController->__("Voice Service Login Infromation"));

                    $arr = array('player' => $player);
                    $txt = $this->controller->renderBlock('emails/order/voice_client_details_txt', $arr);
                    $html = $this->controller->renderBlock('emails/order/voice_client_details_html', $arr);

                    $this->mail->setBodyText($txt);
                    $this->mail->setBodyHtml($html);
                    $this->mail->setFrom(Doo::conf()->emailFrom, $snController->__('PlayNation Team'));
                    return $this->mail->send();
                }
            }
		}

		$this->mail->addTo($player->EMail);
        $this->mail->setSubject($snController->__("Order Complete"));

		Order::appendOrderItems($order);
        $arr = array('player' => $player, 'order' => $order);
        $txt = $this->controller->renderBlock('emails/order/order_complete_txt', $arr);
        $html = $this->controller->renderBlock('emails/order/order_complete_html', $arr);

        $this->mail->setBodyText($txt);
        $this->mail->setBodyHtml($html);
        $this->mail->setFrom(Doo::conf()->emailFrom, $snController->__('PlayNation Team'));
        return $this->mail->send();
	}

	public function recruitment($user, $rec) {
        $snController = new SnController();

		$this->mail->addTo('recruitment@playnation.eu');
//		$this->mail->addTo('l.ceslovas@gmail.com');
        $this->mail->setSubject($snController->__("Application"));

		$arr = array('user' => $user, 'rec' => $rec);
        $txt = $this->controller->renderBlock('emails/recruitment_txt', $arr);
        $html = $this->controller->renderBlock('emails/recruitment_html', $arr);

        $this->mail->setBodyText($txt);
        $this->mail->setBodyHtml($html);
        $this->mail->setFrom($rec['email'], $rec['name']);
        return $this->mail->send();
	}

    public function newBugreport(SyBugReports $br, Players $p) {
        $snController = new SnController();

        $this->mail->addTo($p->EMail, $p->DisplayName);
        $this->mail->setSubject($snController->__("New bug report: ").$br->ErrorName);

        $arr = array('bugreport' => $br, 'player' => $p);
        $txt = $this->controller->renderBlock('emails/new_bugreport_txt', $arr);
        $html = $this->controller->renderBlock('emails/new_bugreport_html', $arr);

        $this->mail->setBodyText($txt);
        $this->mail->setBodyHtml($html);
        $this->mail->setFrom(Doo::conf()->emailFrom, $snController->__('PlayNation Team'));
        return $this->mail->send();
    }

    public function updatedBugreport(SyBugReports $br, Players $p, $changed) {
        $snController = new SnController();

        $this->mail->addTo($p->EMail, $p->DisplayName);
        $this->mail->setSubject($snController->__("Updated support ticket: ").$br->ErrorName);

        $arr = array('bugreport' => $br, 'player' => $p, 'changed' => $changed);
        $txt = $this->controller->renderBlock('emails/updated_bugreport_txt', $arr);
        $html = $this->controller->renderBlock('emails/updated_bugreport_html', $arr);

        $this->mail->setBodyText($txt);
        $this->mail->setBodyHtml($html);
        $this->mail->setFrom(Doo::conf()->emailFrom, $snController->__('PlayNation Team'));
        return $this->mail->send();
    }
}
?>