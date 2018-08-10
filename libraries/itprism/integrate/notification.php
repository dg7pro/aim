<?php
/**
 * @package      ITPrism Library
 * @subpackage   Integrate Profile
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * ITPrism Library is free software. This vpversion may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods which creates notification object,
 * based on social extension name.
 * 
 * @package      ITPrism Library
 * @subpackage   Integrate Profile
 */
abstract class ITPrismIntegrateNotification {

    /**
     * Create an object based on social extension name.
     *
     * @param  string $mechanic This is the name, on which is based the results.
     * @param  array  $keys     These are the keys, which will be used for loading users data.
     *  
     * @return object
     * @throws Exception
     */
    public static function factory($name)  {
    
        $name     = JString::strtolower($name);
        $loaded   = jimport("itprism.integrate.notification.".$name);
        
        if(!$loaded) {
            throw new Exception('The integration for this social extension does not exists.');
        } else {
            // Build the name of the class, instantiate, and return
            $className = 'ITPrismIntegrateNotification'.ucfirst($name);
            return new $className();
        }
    }
    
}

