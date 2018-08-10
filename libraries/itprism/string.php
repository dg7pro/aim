<?php
/**
 * @package      ITPrism Library
 * @subpackage   String
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
 * This class contains methods that are used for handling strings.
 * 
 * @package 	ITPrism Library
 * @subpackage  String
 */
abstract class ITPrismString {
    
    /**
     * The method generates random string. 
     * You can set a prefix and specify the length of the string.
     *
     * <code>
     *
     * jimport("itprism.string");
     * $hash = ITPrismString::generateRandomString(32, "GEN");
     * 
     * </code>
     *
     * @param integer  The length of the string, that will be generated.
     * @param string   A prefix, which will be added at the beginning of the string.
     *
     * @return string
     */
    public static function generateRandomString($length = 10, $prefix = "") {
        
        // Generate string
        $hash = md5(uniqid(time() + mt_rand(), true));
        $hash = substr($hash, 0, $length);
        
        // Add prefix
        if(!empty($prefix)) {
            $hash = $prefix . $hash;
        }
        
        return $hash;
    }
    
    /**
     * Generate a string of amount based on location.
     * The method uses PHP NumberFormatter ( Internationalization Functions ).
     * If the internationalization library is not loaded, the method generates a simple string ( 100 USD, 500 EUR,... )
     * 
     * <code>
     * 
     * jimport("itprism.string");
     * $amount = ITPrismString::getAmount(100, GBP, "en_GB");
     * 
     * </code>
     * 
     * @param float  Amount
     * @param string Currency Code ( GBP, USD, EUR,...)
     * @param string This is locale code ( en_GB, us_US, de_DE,... ) 
     * 
     * @return string
     */
    public static function getAmount($amount, $currency, $locale = null) {
        
        if(extension_loaded('intl')) { // Generate currency string using 
        
            // Get locale code
            if(!$locale) {
                $language = JFactory::getLanguage();
                $locale   = $language->getName();
            }
            
            $numberFormat = new NumberFormatter($locale, NumberFormatter::CURRENCY);
            $amount       = $numberFormat->formatCurrency($amount, $currency);
        
        } else {
            $amount   = $amount.$currency;
        }
        
        
        return $amount;
    }
    
}
