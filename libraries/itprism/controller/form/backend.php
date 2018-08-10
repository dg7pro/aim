<?php
/**
* @package      ITPrism Library
* @subpackage   Controllers
* @author       Todor Iliev
* @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
* @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
* ITPrism Libraries is free software. This vpversion may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined('JPATH_PLATFORM') or die;

jimport('itprism.controller.form');

/**
 * This class contains common methods and properties 
 * used in work with forms on the back-end.
 * 
 * @package      ITPrism Library
 * @subpackage   Controllers
 */
class ITPrismControllerFormBackend extends ITPrismControllerForm {
   
    /**
     * This method prepare a link where the user will be redirected 
     * after action he has done.
     * @param integer $itemId
     */
    protected function prepareRedirectLink($options) {
        
        $view              = JArrayHelper::getValue($options, "view");
        $layout            = JArrayHelper::getValue($options, "layout");
        $task              = JArrayHelper::getValue($options, "task");
        $itemId            = JArrayHelper::getValue($options, "id", 0, "uint");
        $urlVar            = JArrayHelper::getValue($options, "url_var", "id");
        $forceDirection    = JArrayHelper::getValue($options, "force_direction");
        
        // Remove standard parameters
        unset($options["view"]);
        unset($options["layout"]);
        unset($options["task"]);
        unset($options["id"]);
        unset($options["url_var"]);
        unset($options["force_direction"]);
        
        $link   = $this->defaultLink;
        
        // Redirect to different of common views
        if(!empty($view)) {
            $link .= "&view=".$view;
            if(!empty($itemId)) {
                $link .= $this->getRedirectToItemAppend($itemId, $urlVar);
            } else {
                $link .= $this->getRedirectToListAppend();
            }
            
            return $link;
        }
        
        // Prepare redirection
        switch($task) {
            case "apply":
                $link .= "&view=".$this->view_item . $this->getRedirectToItemAppend($itemId, $urlVar);
                break;
                
            case "save2new":
                $link .= "&view=".$this->view_item . $this->getRedirectToItemAppend();
                break;
                
            default:
                $link .= "&view=".$this->view_list . $this->getRedirectToListAppend();
                break;
        }
        
        // Generate additional parameters
        $extraParams = $this->prepareExtraParameters($options);
        
        return $link.$extraParams;
    }
    
}

