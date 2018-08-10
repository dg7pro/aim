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

jimport( 'joomla.application.component.controller' );

/**
 * Dashboard Controller
 *
 * @package		ITPrism Components
 * @subpackage	Vip Portfolio
  */
class VipPortfolioController extends JController {
    
    protected $option;
    
	public function __construct($config = array())	{
		parent::__construct($config);
        $this->option = JFactory::getApplication()->input->getCmd("option");
	}

	public function display($cachable = false, $urlparams = false) {

		$document = JFactory::getDocument();
		/** @var $document JDocumentHtml **/
		
		// Add component style
        $document->addStyleSheet('../media/'.$this->option.'/css/style.css');
        
        $viewName      = JFactory::getApplication()->input->getCmd('view', 'dashboard');
        JFactory::getApplication()->input->set("view", $viewName);

        parent::display();
        return $this;
	}

}