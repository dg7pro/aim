<?php
/**
 * @package      ITPrism Library
 * @subpackage   UI
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * ITPrism Library is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// no direct access
defined('_JEXEC') or die;

/**
 * ITPrism UI Html Helper
 *
 * @package      ITPrism Library
 * @subpackage   UI
 * @since		 1.6
 */
abstract class ITPrismUI {
    
    /**
     * @var   array   array containing information for loaded files
     */
    protected static $loaded = array();
    
    public static function pnotify() {
    
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }
    
        $document = JFactory::getDocument();
        
        $document->addStylesheet(JUri::root().'libraries/itprism/ui/css/jquery.pnotify.css');
        $document->addScript(JUri::root().'libraries/itprism/ui/js/jquery.pnotify.min.js');
        
        self::$loaded[__METHOD__] = true;
    
        return;
    
    }
    
    public static function bootstrap() {
    
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }
    
        $document = JFactory::getDocument();
        
        $document->addStylesheet(JUri::root().'libraries/itprism/ui/css/bootstrap.min.css');
        $document->addScript(JUri::root().'libraries/itprism/ui/js/bootstrap.min.js');
        
        self::$loaded[__METHOD__] = true;
    
        return;
    
    }
    
    public static function bootstrap_rowlink() {
    
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }
    
        $document = JFactory::getDocument();
        
        $document->addStylesheet(JUri::root().'libraries/itprism/ui/css/bootstrap-rowlink.min.css');
        $document->addScript(JUri::root().'libraries/itprism/ui/js/bootstrap-rowlink.min.js');
        
        self::$loaded[__METHOD__] = true;
    
        return;
    
    }
    
    public static function bootstrap_editable() {
    
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }
    
        $document = JFactory::getDocument();
        
        $document->addStylesheet(JUri::root().'libraries/itprism/ui/css/bootstrap-editable.css');
        $document->addScript(JUri::root().'libraries/itprism/ui/js/bootstrap-editable.js');
        
        self::$loaded[__METHOD__] = true;
    
        return;
    
    }
    
    public static function bootstrap_maxlength() {
    
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }
    
        $document = JFactory::getDocument();
        
        $document->addScript(JUri::root().'libraries/itprism/ui/js/bootstrap-maxlength.min.js');
        
        self::$loaded[__METHOD__] = true;
    
        return;
    
    }
    
    public static function bootstrap_fileupload() {
    
        JLog::add("ITPrismUI::bootstrap_fileupload is deprecated. Use bootstrap_ITPrismUI::bootstrap_fileuploadstyle.");
        
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }
    
        $document = JFactory::getDocument();
        
        $document->addStylesheet(JUri::root().'libraries/itprism/ui/css/bootstrap-fileupload.min.css');
        $document->addScript(JUri::root().'libraries/itprism/ui/js/bootstrap-fileupload.min.js');
        
        self::$loaded[__METHOD__] = true;
    
    }
    
    public static function bootstrap_fileuploadstyle() {
    
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }
    
        $document = JFactory::getDocument();
    
        $document->addStylesheet(JUri::root().'libraries/itprism/ui/css/bootstrap-fileuploadstyle.min.css');
        $document->addScript(JUri::root().'libraries/itprism/ui/js/bootstrap-fileuploadstyle.min.js');
    
        self::$loaded[__METHOD__] = true;
    
    }
    
    public static function bootstrap_typeahead() {
    
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }
    
        $document = JFactory::getDocument();
        $document->addScript(JUri::root().'libraries/itprism/ui/js/bootstrap-typeahead.min.js');
    
        self::$loaded[__METHOD__] = true;
    
        return;
    
    }
    
    public static function parsley() {
    
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }
    
        $document = JFactory::getDocument();
        $document->addScript(JUri::root().'libraries/itprism/ui/js/parsley.min.js');
    
        self::$loaded[__METHOD__] = true;
    
        return;
    
    }
    
    public static function fileupload() {
    
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }
    
        $document = JFactory::getDocument();
        $document->addStylesheet(JUri::root().'libraries/itprism/ui/css/jquery.fileupload-ui.css');
        
        $document->addScript(JUri::root().'libraries/itprism/ui/js/fileupload/jquery.ui.widget.js');
        $document->addScript(JUri::root().'libraries/itprism/ui/js/fileupload/jquery.iframe-transport.js');
        $document->addScript(JUri::root().'libraries/itprism/ui/js/fileupload/jquery.fileupload.js');
    
        self::$loaded[__METHOD__] = true;
    
        return;
    
    }
    
}
