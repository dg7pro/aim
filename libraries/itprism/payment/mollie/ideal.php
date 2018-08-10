<?php
/**
 * @package      ITPrism Library
 * @subpackage   Payment Gateways
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * ITPrism Library is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// no direct access
defined('JPATH_PLATFORM') or die;

require_once dirname(__FILE__) .DIRECTORY_SEPARATOR."ideal".DIRECTORY_SEPARATOR."Payment.php";

/** 
 * This class contains methods that interact 
 * with iDEAL payment gateway via Mollie service.
 * 
 * @package 	ITPrism Library
 * @subpackage  Payment Gateways
 */
class ITPrismPaymentMollieIdeal {
    
    private $payment;
    
    public function __construct($partnerId) {
        $this->payment = new Mollie_iDEAL_Payment($partnerId);
    }
    
    public function getBanks() {
        return $this->payment->getBanks();
    }
    
    public function enableTestmode() {
        $this->payment->setTestmode(true);
    }
    
    public function createPayment($options) {
        
        $bankId      = JArrayHelper::getValue($options, "bank_id");
        $amount      = JArrayHelper::getValue($options, "amount");
        $description = JArrayHelper::getValue($options, "description");
        $returnUrl   = JArrayHelper::getValue($options, "return_url");
        $reportUrl   = JArrayHelper::getValue($options, "report_url");
        
        if(!$this->payment->createPayment($bankId, $amount, $description, $returnUrl, $reportUrl)) {
            throw new Exception($this->payment->getErrorMessage());
        }
        
    }
    
    public function getBankURL() {
        return $this->payment->getBankURL();
    }
    
    public function getTransactionId() {
        return $this->payment->getTransactionId();
    }
    
    public function checkPayment($transactionId) {
        return $this->payment->checkPayment($transactionId);
    }
    
    public function getPaidStatus() {
        return $this->payment->getPaidStatus();
    }
    
    public function getConsumerInfo() {
        return $this->payment->getConsumerInfo();
    }
    
    public function getAmount() {
        return $this->payment->getAmount();
    }
    
    public function getBankStatus() {
        return $this->payment->getBankStatus();
    }
}
