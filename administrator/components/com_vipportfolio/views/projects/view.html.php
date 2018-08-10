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

class VipPortfolioViewProjects extends JView {
    
    protected $items;
    protected $pagination;
    protected $state;
    
    public function display($tpl = null){
        
        $this->state      = $this->get('State');
        $this->items      = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        
        $this->categories = VipPortfolioHelper::getCategoriesOption();
        
        // Prepare filters
        $this->listOrder  =  $this->escape($this->state->get('list.ordering'));
        $this->listDirn   =  $this->escape($this->state->get('list.direction'));
        $this->saveOrder  =  (strcmp($this->listOrder, 'a.ordering') != 0 ) ? false : true;
        
        // Add submenu
        VipPortfolioHelper::addSubmenu($this->getName());
        
        // Prepare actions
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
        
        // Set toolbar items for the page
        JToolBarHelper::title(JText::_('COM_VIPPORTFOLIO_PROJECTS'), 'vip-projects');
        JToolBarHelper::addNew('project.add');
        JToolBarHelper::editList('project.edit');
        JToolBarHelper::divider();
        JToolBarHelper::publishList("projects.publish");
        JToolBarHelper::unpublishList("projects.unpublish");
        JToolBarHelper::divider();
        JToolBarHelper::deleteList(JText::_("COM_VIPPORTFOLIO_DELETE_ITEMS_QUESTION"), "projects.delete");
        JToolBarHelper::divider();
        JToolBarHelper::custom('projects.backToDashboard', "vip-properties-back", "", JText::_("COM_VIPPORTFOLIO_DASHBOARD"), false);
        
    }
    
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() {
		$this->document->setTitle(JText::_('COM_VIPPORTFOLIO_PROJECTS'));
	}
    
}