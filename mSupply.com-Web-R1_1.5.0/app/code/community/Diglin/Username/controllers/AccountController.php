<?php
/**
 * Diglin GmbH
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php

 *
 * @category    Diglin
 * @package     Diglin_Username
 * @copyright   Copyright (c) 2008-2015 Diglin GmbH - Switzerland (http://www.diglin.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

require_once 'Mage/Customer/controllers/AccountController.php';

class Diglin_Username_AccountController extends Mage_Customer_AccountController
{
    /**
     * Rewrite to allow support of Username
     *
     */
   public function forgotPasswordPostAction()
    {
        $email = (string) $this->getRequest()->getPost('email');
        if ($email) {
			$findme   = '@';
			$pos = strpos($email, $findme);
			if ($pos === false) {
				echo'mobile';
				/** @var $customer Mage_Customer_Model_Customer */
				$customer = Mage::getModel('customer/customer')
					->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
					->loadByUsername($email);
					
			} else {
				echo'email';
				/** @var $customer Mage_Customer_Model_Customer */
				$customer = $this->_getModel('customer/customer')
					->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
					->loadByEmail($email);
			}


            if (!$customer->getId() && !Zend_Validate::is($email, 'EmailAddress')) {
                $this->_getSession()->setForgottenEmail($email);
                $this->_getSession()->addError($this->__('Please Enter Registered Mobile No.'));
                $this->_redirect('*/*/forgotpassword');
                return;
            } else if (!$customer->getId()) {
                // Load by Email if username not found and email seems to be valid
                $customer
                    ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                    ->loadByEmail($email);
            }
            if ($customer->getId()) {
                try {
                    //$newResetPasswordLinkToken = $this->_getHelper('customer')->generateResetPasswordLinkToken();
                   // $customer->changeResetPasswordLinkToken($newResetPasswordLinkToken);
                   // $customer->sendPasswordResetConfirmationEmail();
				   $this->_getSession()
						->addSuccess( $this->_getHelper('customer')
						->__('Your Mail/SMS has been sent successfully.',
                        $this->_getHelper('customer')->escapeHtml($email)));
					$this->_redirect('*/*/forgotpassword');
					return;
                } catch (Exception $exception) {
                    $this->_getSession()->addError($exception->getMessage());
                    $this->_redirect('*/*/forgotpassword');
                    return;
                }
            }
            $this->_getSession()
                ->addSuccess( $this->_getHelper('customer')
                    ->__('Your Mail/SMS has been sent successfully.',
                        $this->_getHelper('customer')->escapeHtml($email)));
            $this->_redirect('*/*/');
            return;
        } else {
            $this->_getSession()->addError(Mage::helper('username')->__('Please Enter Registered Mobile No.'));
            $this->_redirect('*/*/forgotpassword');
            return;
        }
    }
 
}
