<?php
/**
 * @package      ITPrism Library
 * @subpackage   PayPal
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

/** 
 * This class contains methods that verify PayPal transaction.
 * 
 * @package 	ITPrism Library
 * @subpackage  PayPal
 */
class ITPrismPayPalVerify {
    
    const VERIFIED     = "VERIFIED";
    const INVALID      = "INVALID";
    
    protected $url     = "";
    protected $data    = array();
    protected $status  = null;
    
    public function __construct($url, $data) {
        $this->url     = $url;
        $this->data    = $data;
    }
    
    public function isVerified() {
        
        if($this->status == self::VERIFIED) {
            return true;
        }
        
        return false;
    }
    
    public function verify() {
        
        // Strip slashes if magic quotes are enabled
        if (function_exists('get_magic_quotes_gpc')) {
            
            if (1 == get_magic_quotes_gpc()) {
                foreach ( $this->data as $key => $value ) {
                    $this->data[$key] = stripslashes($value);
                }
            }
        
        }
        
        $this->data['cmd'] = '_notify-validate';
        
        $ch = curl_init($this->url);
        if (false === $ch) {
            throw new Exception("CURL library has not been loaded.", 500);
        }
        
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $this->data ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
//        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
//        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        // In wamp like environments that do not come bundled with root authority certificates,
        // please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path 
        // of the certificate as shown below.
        // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
        $result = curl_exec($ch);
        
        if (false === $result) {
            throw new Exception(curl_error($ch), 500);
        }
        
        // If the payment is verified then set the status as verified.
        if ($result == "VERIFIED") {
            $this->status = self::VERIFIED;
        } else {
            $this->status = self::INVALID;
        }
        
    }

}