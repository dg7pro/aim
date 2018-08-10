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

class VipPortfolioViewCategory extends JView {
    
    protected $state;
    protected $item;
    protected $form;
    
    protected $documentTitle;
    protected $option;
    
    public function __construct($config) {
        parent::__construct($config);
        $this->option = JFactory::getApplication()->input->get("option");
    }
    
    /**
     * Display the view
     */
    public function display($tpl = null){
        $this->state  = $this->get('State');
        $this->item   = $this->get('Item');
        $this->form   = $this->get('Form');

        $this->params = $this->state->get("params");
        
        // Prepare actions, behaviors, scritps and document
        $this->addToolbar();
        $this->setDocument();
        
        parent::display($tpl);
    }
    
    /**
     * Add the page title and toolbar.
     *
     * @since   1.6
     */
    protected function addToolbar(){
        
        JFactory::getApplication()->input->set('hidemainmenu', true);
        
        $isNew = ($this->item->id == 0);
        $this->documentTitle= $isNew ? JText::_('COM_VIPPORTFOLIO_CATEGORY_ADD')
                                      : JText::_('COM_VIPPORTFOLIO_CATEGORY_EDIT');
                                      
        // Set toolbar items for this page
        if(!$isNew) {
            JToolBarHelper::title($this->documentTitle, 'vip-categories-edit');
        } else {
            JToolBarHelper::title($this->documentTitle, 'vip-categories-new');
        }
		                             
        JToolBarHelper::apply('category.apply');
        JToolBarHelper::save2new('category.save2new');
        JToolBarHelper::save('category.save');
    
        if(!$isNew){
            JToolBarHelper::cancel('category.cancel', 'JTOOLBAR_CANCEL');
        }else{
            JToolBarHelper::cancel('category.cancel', 'JTOOLBAR_CLOSE');
        }
        
    }
    
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() {
	    
	    // Add behaviors
	    JHtml::_('behavior.keepalive');
        JHtml::_('behavior.tooltip');
        JHtml::_('behavior.formvalidation');
        
        $this->document->setTitle($this->documentTitle);
		// Add scripts
		$this->document->addScript('../media/'.$this->option.'/js/admin/'.strtolower($this->getName()).'.js');
	}
	

}