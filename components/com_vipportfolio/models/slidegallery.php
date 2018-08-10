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

jimport('joomla.application.component.modellist');

class VipPortfolioModelSlideGallery extends JModelList {
    
    /**
     * Constructor.
     *
     * @param   array   An optional associative array of configuration settings.
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array()){
        if(empty($config['filter_fields'])){
            $config['filter_fields'] = array(
            	'id', 'a.id', 
            	'catid', 'a.catid', 
            	'ordering', 'a.ordering'
            );
        }
        
        parent::__construct($config);
    }
    
    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @return  void
     * @since   1.6
     */
    protected function populateState($ordering = 'ordering', $direction = 'ASC'){
        
        $app = JFactory::getApplication();
        /** @var $app JSite **/
        
        $params = $app->getParams();
        $this->setState('params', $params);
        
        $value = $app->input->getInt('id');
        $this->setState('filter.catid', $value);

        $orderCol = $app->input->getCmd('filter_order', 'a.ordering');
        if(!in_array($orderCol, $this->filter_fields)){
            $orderCol = 'a.ordering';
        }
        $this->setState('list.ordering', $orderCol);
        
        $listOrder = $app->input->getCmd('filter_order_Dir', 'ASC');
        if(!in_array(strtoupper($listOrder), array('ASC', 'DESC', ''))){
            $listOrder = 'ASC';
        }
        $this->setState('list.direction', $listOrder);
        
    }
    
    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param   string      $id A prefix for the store id.
     *
     * @return  string      A store id.
     * @since   1.6
     */
    protected function getStoreId($id = ''){
        
        // Compile the store id.
        $id .= ':' . $this->getState('filter.catid');
        
        return parent::getStoreId($id);
    }
    
    /**
     * Get the master query for retrieving a list of projects to the model state.
     *
     * @return  JDatabaseQuery
     * @since   1.6
     */
    public function getListQuery(){
        
        // Create a new query object.
        $db     = $this->getDbo();
        /** @var $db JDatabaseMySQLi **/
        
        $query  = $db->getQuery(true);
        
        // Select the required fields from the table.
        $query->select(
            $this->getState(
            'list.select', 
            'a.id, a.title, a.alias, a.description, ' . 
            'a.url, a.catid, a.thumb, a.image '));
        
        $query->from('#__vp_projects AS a');
        
        // Use article state if badcats.id is null, otherwise, force 0 for unpublished
        $query->where('a.published = 1');
        
        // Filter by a single or group of categories
        $categoryId = $this->getState('filter.catid');
        
        if(!empty($categoryId)){
            $query->where('a.catid = ' . (int)$categoryId);
        }
        
        // Add the list ordering clause.
        $orderCol   = $this->getState('list.ordering', 'a.ordering');
        $orderDirn  = $this->getState('list.direction', 'ASC');
        
        $query->order($db->escape($orderCol.' '.$orderDirn));
        
        return $query;
    }
    
}