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

class VipPortfolioModelCategories extends JModelList {
    
    protected $numbers = array();
    
    /**
     * Constructor.
     *
     * @param   array   An optional associative array of configuration settings.
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'name', 'a.name',
                'published', 'a.published',
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
     * @since   1.6
     */
    protected function populateState($ordering = null, $direction = null) {

        // Load the filter state.
        $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '', 'string');
        $this->setState('filter.published', $published);

        // Load the parameters.
        $params = JComponentHelper::getParams($this->option);
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.ordering', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param   string      $id A prefix for the store id.
     * @return  string      A store id.
     * @since   1.6
     */
    protected function getStoreId($id = '') {
        
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.published');

        return parent::getStoreId($id);
    }
       /**
     * Build an SQL query to load the list data.
     *
     * @return  JDatabaseQuery
     * @since   1.6
     */
    protected function getListQuery() {
        
        // Create a new query object.
        $db     = $this->getDbo();
        /** @var $db JDatabaseMySQLi **/
        $query  = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
            $this->getState(
                'list.select',
                'a.id, a.name, a.desc, a.alias, a.image, ' .
                'a.published, a.ordering, ' . 
                'a.meta_title, a.meta_desc, a.meta_keywords, a.meta_canonical'
            )
        );
        $query->from('`#__vp_categories` AS a');

        // Filter by published state
        $published = $this->getState('filter.published');
        if (is_numeric($published)) {
            $query->where('a.published = '.(int) $published);
        } else if ($published === '') {
            $query->where('(a.published IN (0, 1))');
        }

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = '.(int) substr($search, 3));
            } else {
                $search = $db->quote('%'.$db->escape($search, true).'%');
                $query->where('(a.name LIKE '.$search.' OR a.alias LIKE '.$search.')');
            }
        }

        // Add the list ordering clause.
        $orderCol   = $this->state->get('list.ordering');
        $orderDirn  = $this->state->get('list.direction');
        
        $query->order($db->escape($orderCol.' '.$orderDirn));

        return $query;
    }
    
    public function getNumbers() {
        
        // Get a storage key.
		$storeNumbers = $this->getStoreId("getNumbers");

		// Try to load the data from internal storage.
		if (isset($this->cache[$storeNumbers])) {
			return $this->cache[$storeNumbers];
		}
            
        // Get a storage key.
		$storeData = $this->getStoreId();

		// Try to load the data from internal storage.
		if (isset($this->cache[$storeData])){
			$data = $this->cache[$storeData];
		} else {
		    $data = $this->getItems();
		}
		
		$itemsIds = array();
		foreach( $data as $item ) {
		    $itemsIds[] = $item->id;
		}
		
		// Get the number of projects in categories
		$results = array();
		if(!empty($itemsIds)) {
            $db     = JFactory::getDbo();
            $query  = $db->getQuery(true);
            
            $query
                ->select("catid, COUNT(*) AS number")
                ->from("#__vp_projects")
                ->where("catid IN (" . implode(",", $itemsIds) . ")")
                ->group("catid");
            
            $db->setQuery($query);
            $results = $db->loadAssocList("catid", "number");
            
            if(!$results) {
                $results = array(); 
            }
		}
        
        // Add the items to the internal cache.
		$this->cache[$storeNumbers] = $results;

		return $this->cache[$storeNumbers];
        
    }
    
}