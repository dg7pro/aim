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

if(!defined("SOCIALCOMMUNITY_PATH_COMPONENT_SITE")) {
    define("SOCIALCOMMUNITY_PATH_COMPONENT_SITE", JPATH_SITE . DIRECTORY_SEPARATOR. "components" . DIRECTORY_SEPARATOR ."com_socialcommunity");
}

JLoader::register("SocialCommunityHelperRoute", SOCIALCOMMUNITY_PATH_COMPONENT_SITE . DIRECTORY_SEPARATOR . "helpers" . DIRECTORY_SEPARATOR . "route.php");

/**
 * This class provides functionality used for integrating
 * extensions with the profile of SocialCommunity.
 * 
 * @package      ITPrism Library
 * @subpackage   Integrate Profile
 */
class ITPrismIntegrateProfilesSocialCommunity implements ITPrismIntegrateInterfaceProfiles {
    
    protected $profiles = array();
    
    protected $path;
    
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
            
            // Set path to pictures
            $params  = JComponentHelper::getParams("com_socialcommunity");
            $path    = $params->get("images_directory", "images/profiles");
            
            $this->setPath($path);
        }
        
    }
	
    public function load($ids) {
        
        if(!empty($ids)) {
        
            // Create a new query object.
            $query  = $this->db->getQuery(true);
            $query
                ->select(
                    "a.id AS user_id, a.image_square AS avatar, " .
                    $query->concatenate(array("a.id", "a.alias"), ":")  . " AS slug"
                )
                ->from($this->db->quoteName("#__itpsc_profiles") . ' AS a')
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
     * @param integer  $userId
     * @param itneger  $size
     * @return string
     */
    public function getAvatar($userId, $size) {
        
        if(!isset($this->profiles[$userId])) {
            $link = "";
        } else {
            
            if(!$this->profiles[$userId]->avatar) {
                $link = JUri::base()."media/com_socialcommunity/images/no-profile.png";
            } else {
                $link = JUri::base().$this->path."/".$this->profiles[$userId]->avatar;
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
            $link = SocialCommunityHelperRoute::getProfileRoute($this->profiles[$userId]->slug);
        }
        
        return $link;
    }
    
    /**
     * Set the path to the images folder.
     * @param string $path
     */
    public function setPath($path) {
        $this->path = $path;
    }
}

