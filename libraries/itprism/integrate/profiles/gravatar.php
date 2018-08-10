<?php
/**
* @package      ITPrism Library
* @subpackage   Integrate Profile
* @author       Todor Iliev
* @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
* @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
* ITPrism Library is free software. This vpversion may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined('JPATH_PLATFORM') or die;

jimport("itprism.integrate.interface.profiles");

/**
 * This class provides functionality used for integrating
 * extensions with the profile of Kunena.
 * 
 * @package      ITPrism Library
 * @subpackage   Integrate Profile
 */
class ITPrismIntegrateProfilesGravatar implements ITPrismIntegrateInterfaceProfiles {
    
    protected $profiles = array();
    
    /**
     * Database driver
     *
     * @var JDatabaseMySQLi
     */
    protected $db;
    
    /**
     * Initilazie the object
     * @param  array $ids	Users IDs
     */
    public function __construct($ids) {
        
        $this->db   = JFactory::getDbo();
        
        if(!empty($ids)) {
            $this->load($ids);
        }
        
    }
	
    public function load($ids) {
        
        if(!empty($ids)) {
            
            // Create a new query object.
            $query  = $this->db->getQuery(true);
            $query
                ->select("a.id AS user_id, a.email")
                ->from($this->db->quoteName("#__users") . ' AS a')
                ->where("a.id IN ( ". implode(",", $ids) . ")");
            
            $this->db->setQuery($query);
            $results = $this->db->loadObjectList();
            
            if(!empty($results)) {
                foreach($results AS $result) {
                    $this->profiles[$result->user_id] = $result;
                }
            }
            
        }
        
    }
    
    /**
     * Get a link to user avatar.
     * @param integer $userId
     * @param integer $size
     * @return string
     */
    public function getAvatar($userId, $size = 50) {
        
        if(!isset($this->profiles[$userId])) {
            $link = "";
        } else {
            $link = "http://www.gravatar.com/avatar/".md5($this->profiles[$userId]->email);
            
            if(!empty($size)) {
                $link .= "?s=".$size;
            }
            
        }
        return $link;
    }
    
    /**
     * Get a link to user profile.
     * 
     * @param integer $userId
     * @return string
     */
    public function getLink($userId) {
        
        if(!isset($this->profiles[$userId])) {
            $link = "";
        } else {
            $link = "http://www.gravatar.com/".md5($this->profiles[$userId]->email);
        }
        
        return $link;
    }
}

