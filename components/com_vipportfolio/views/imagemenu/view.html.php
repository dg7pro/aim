<?php
/**
 * @package      ITPrism Components
 * @subpackage   Vip Portfolio
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * Vip Portfolio is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class VipPortfolioViewImageMenu extends JView {
    
    protected $state;
    protected $items;
    
    protected $option;
    protected $tmpl;
    
    public function __construct($config) {
        parent::__construct($config);
        $this->option = JFactory::getApplication()->input->get("option");
    }
    
    public function display($tpl = null) {
        
        $app = JFactory::getApplication();
        /** @var $app JSite **/
        
        // Initialise variables
        $this->state          = $this->get('State');
        $this->items          = $this->get('Items');
        $this->params         = $this->state->params;
        
        $this->projectsView   = $app->input->get("projecs_view", "list", "string");
        
        // Set tmpl parameter if the the page is loaded from Facebook 
        $tmpl = $app->input->get("tmpl");
        if(!empty($tmpl)) {
            $this->tmpl           = "&tmpl=component";
        }
        
        $this->prepareDocument();
                
        parent::display($tpl);
    }
    
    
    /**
     * Prepares the document
     */
    protected function prepareDocument(){
        $app = JFactory::getApplication();
        $menus = $app->getMenu();
        
        //Escape strings for HTML output
        $this->pageclass_sfx = htmlspecialchars($this->params->get('pageclass_sfx'));
        
        // Because the application sets a default page title,
        // we need to get it from the menu item itself
        $menu = $menus->getActive();
        if($menu){
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        }else{
            $this->params->def('page_heading', JText::_('COM_VIPPORTFOLIO_CATEGORIES_DEFAULT_PAGE_TITLE'));
        }
        
        // Set page title
        $title = $this->params->get('page_title', '');
        if(empty($title)){
            $title = $app->getCfg('sitename');
        }elseif($app->getCfg('sitename_pagetitles', 0)){
            $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
        }
        $this->document->setTitle($title);
        
        // Meta Description
        if($this->params->get('menu-meta_description')){
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }
        
        // Meta keywords
        if($this->params->get('menu-meta_keywords')){
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }

        
        // JavaScript and Styles
        
        JHTML::_('behavior.framework', true);
        
       $view = JString::strtolower($this->getName());
        
        // Add template style
        $this->document->addStyleSheet('media/'.$this->option.'/categories/' . $view . '/style.css', 'text/css', null );
        $this->document->addScript('media/'.$this->option.'/js/'.$view.'/ImageMenu.js');
        
        $cssStyles = "";
        foreach($this->items as $item) {
            $cssStyles .= "
            #itp-vp-image-menu ul li.item" .$item->id."  a {
                background: url('". $this->params->get("images_directory", "images/vipportfolio")."/" . $item->image."') repeat scroll 0%;
            }
            ";
        }
        
        if(!empty($cssStyles)) {
            $this->document->addStyleDeclaration($cssStyles);
        }
        
        $js = "window.addEvent('domready', function(){
    	  var myMenu = new ImageMenu(
    	    $$('#itp-vp-image-menu a'),{
        	    openWidth:" . $this->params->get("cimgmenuOpenWidth", 310) .", 
        	    border:" . $this->params->get("cimgmenuBorder", 2).", 
        	    duration:" .  $this->params->get("cimgmenuDuration", 400).", 
    	    	OnClickOpen:function(e,i){ 
        	     window.location = e;
        	    }
    	    });
        });";
        
        $this->document->addScriptDeclaration($js);
        
        // If tmpl is set that mean the user loads the page from Facebook
        // So we should Auto Grow the tab.
        $tmpl = $app->input->get("tmpl");
        if(!empty($tmpl)) {
            if($this->params->get("fbpp_auto_grow") ){
                VipPortfolioHelper::facebookAutoGrow($this->document, $this->params);
            }            
        }
    }
    
}