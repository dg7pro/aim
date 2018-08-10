<?php
/**
* @package      ITPrism Library
* @subpackage   Integrate
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
 * This class provides functionality 
 * to integrate extensions with activity services.
 * 
 * @package      ITPrism Library
 * @subpackage   Integrate
 */
interface ITPrismIntegrateInterfaceActivity {
    
    public function store();
    
}

