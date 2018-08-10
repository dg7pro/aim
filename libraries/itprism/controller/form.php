<?php
/**
* @package      ITPrism Library
* @subpackage   Controllers
* @author       Todor Iliev
* @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
* @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
* ITPrism Library is free software. This vpversion may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined('JPATH_PLATFORM') or die;

jimport('joomla.application.component.controllerform');

/**
 * This class contains common methods and properties 
 * used in work with forms.
 * 
 * @package      ITPrism Library
 * @subpackage   Controllers
 * 
 * @todo Use traits when PHP 5.4 becomes more widely used.
 */
class ITPrismControllerForm extends JControllerForm {
    
	/**
     * A default link to the extension
     * @var string
     */
     protected $defaultLink = '';
     
     public function __construct($config){
        parent::__construct($config);
        $this->defaultLink = 'index.php?option='.JString::strtolower($this->option);
     }
    
    /**
     * 
     * Display a notice and redirect to a page
     * @param mixed 	$messages	Could be array or string
     * @param object 	$controller The currenct controller
     * @param string 	$options
     * array(
     *      "view"    => $view,
     *      "layout"  => $layout,
     *      "id" 	  => $itemId,
     *      "url_var" => $urlVar
     * );
     */
    protected function displayNotice($messages, $options) {
        
        $message = $this->prepareMessage($messages);
        $this->setMessage($message, "notice");
        
        $link = $this->prepareRedirectLink($options);
        $this->setRedirect(JRoute::_($link, false));
            
    }
    
    /**
     * 
     * Display a warning and redirect to a page
     * @param mixed 	$messages	Could be array or string
     * @param object 	$controller The currenct controller
     * @param string 	$options
     * array(
     *      "view"    => $view,
     *      "layout"  => $layout,
     *      "id"      => $itemId,
     *      "url_var" => $urlVar
     * );
     */
    protected function displayWarning($messages, $options) {
        
        $message = $this->prepareMessage($messages);
        $this->setMessage($message, "warning");
        
        $link = $this->prepareRedirectLink($options);
        $this->setRedirect(JRoute::_($link, false));
            
    }
    
	/**
     * 
     * Display a error and redirect to a page
     * @param mixed 	$messages	Could be array or string
     * @param object 	$controller The currenct controller
     * @param string 	$options
     * array(
     *      "view"    => $view,
     *      "layout"  => $layout,
     *      "id"      => $itemId,
     *      "url_var" => $urlVar
     * );
     */
    protected function displayError($messages, $options) {
        
        $message = $this->prepareMessage($messages);
        $this->setMessage($message, "error");
        
        $link = $this->prepareRedirectLink($options);
        $this->setRedirect(JRoute::_($link, false));
            
    }
    
	/**
     * 
     * Display a message and redirect to a page
     * @param mixed 	$messages	Could be array or string
     * @param object 	$controller The currenct controller
     * @param string 	$options
     * array(
     *      "view"    => $view,
     *      "layout"  => $layout,
     *      "id" 	  => $itemId,
     *      "url_var" => $urlVar,
     * );
     */
    protected function displayMessage($messages, $options) {
        
        $message = $this->prepareMessage($messages);
        $this->setMessage($message, "message");
        
        $link = $this->prepareRedirectLink($options);
        $this->setRedirect(JRoute::_($link, false));
            
    }
    
    /**
     * 
     * Thos method parse the message. 
     * It could be array, object ( Exception,... ), string,...
     * 
     * @param mixed $message
     */
    protected function prepareMessage($message) {
        
        $result = "";
        
        if(is_array($message)) {
            
            foreach($message AS $value) {
                
                if( is_object($value) ) {
                    if($value instanceof Exception) {
                        $result .= (string)$value->getMessage() ."\n";
                    }
                } else {
                    $result .= (string)$value ."\n";
                }    
                            
            }
            
        } else if(is_object($message)) {
            
            if($message instanceof Exception) {
                $result ."\n"; (string)$message->getMessage();
            } else {
                $result .= (string)$value ."\n";
            }
            
        } else {
            $result = (string)$message;
        }
        
        return $result;
        
    }
    
	/**
     * 
     * This method prepare a link where the user will be redirected 
     * after action he has done.
     * @param array $options URL parameters used for generating redirect link
     */
    protected function prepareRedirectLink($options) {
        
        $link     = $this->defaultLink;
        
        $view     = JArrayHelper::getValue($options, "view");
        $layout   = JArrayHelper::getValue($options, "layout");
        $itemId   = JArrayHelper::getValue($options, "id", 0, "uint");
        $urlVar   = JArrayHelper::getValue($options, "url_var", "id");
        
        // Remove standard parameters
        unset($options["view"]);
        unset($options["layout"]);
        unset($options["url_var"]);
        unset($options["id"]);
        
        // Redirect to different of common views
        if(!empty($view)) {
            $link .= "&view=".$view;
        }
        if(!empty($layout)) {
            $link .= "&layout=".$layout;
        }
        
        if(!empty($itemId)) {
            $link .= $this->getRedirectToItemAppend($itemId, $urlVar);
        } else {
            $link .= $this->getRedirectToListAppend();
        }
        
        // Generate additional parameters
        $extraParams = $this->prepareExtraParameters($options);
        
        return $link.$extraParams;
    }
    
    /**
     * Generate URI string from additional parameters.
     * @param array $options
     */
    protected function prepareExtraParameters($options) {
        
        $uriString = "";
        
        if(!empty($options)) {
            
            foreach($options as $key => $value) {
                $uriString .= "&".$key."=".$value;
            }
            
        }
        
        return $uriString;
    }
    
    
    /**
     * This method does cancel action
     */
    public function cancel(){
        $this->setRedirect(JRoute::_($this->defaultLink . "&view=".$this->view_list. $this->getRedirectToListAppend(), false));
    }
    
}

