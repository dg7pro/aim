<?php
/**
 * @package      ITPrism Library
 * @subpackage   Libraries
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * ITPrism Library is free software. This vpversion may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('JPATH_BASE') or die;

/**
 * This class extends the native PHP class Simple XML
 * 
 * @package 	 ITPrism Library
 * @subpackage   Libraries
 */
class ITPrismXmlSimple extends SimpleXMLElement {
    
    public function addCData($cdataText) {
        
        $node = dom_import_simplexml($this); 
        $no   = $node->ownerDocument; 
        $node->appendChild($no->createCDATASection($cdataText)); 
    }

}