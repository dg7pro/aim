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

jimport("itprism.integrate.interface.profile");

if(!defined("SOCIALCOMMUNITY_PATH_COMPONENT_SITE")) {
    define("SOCIALCOMMUNITY_PATH_COMPONENT_SITE", JPATH_SITE . DIRECTORY_SEPARATOR. "components" . DIRECTORY_SEPARATOR ."com_socialcommunity");
}

JLoader::register("SocialCommunityHelperRoute", SOCIALCOMMUNITY_PATH_COMPONENT_SITE . DIRECTORY_SEPARATOR . "helpers" . DIRECTORY_SEPARATOR . "route.php");

/**
 * This class provides functionality to 
 * integrate extensions with the profile of Social Community.
 * 
 * @package      ITPrism Library
 * @subpackage   Integrate Profile
 */
class ITPrismIntegrateProfileSocialCommunity implements ITPrismIntegrateInterfaceProfile  {
    
    protected $user_id;
    protected $avatar;
    protected $slug;
    protected $path;
    
    /**
     * Database driver
     * @var JDatabaseMySQLi
     */
    protected $db;
    
    protected static $instances = array();
    
    /**
     * Initilazie the object
     * 
     * @param  $id	It is user id
     */
    public function __construct($id) {
        
        $this->db = JFactory::getDbo();
        if(!empty($id)) {
            $this->load($id);
        }
        
    }
    
    /**
     * Create an object
     *
     * @param  array $keys
     * @return multitype:
     */
    public static function getInstance($id)  {
    
        if (empty(self::$instances[$id])){
            $item = new ITPrismIntegrateProfileSocialCommunity($id);
            self::$instances[$id] = $item;
        }
    
        return self::$instances[$id];
    }
    
    /**
     * Load user data
     *
     * @param array $id
     */
    public function load($id) {
    
        // Create a new query object.
        $query  = $this->db->getQuery(true);
        $query
            ->select(
                "a.id AS user_id, a.image_square AS avatar, " .
                $query->concatenate(array("a.id", "a.alias"), ":")  . " AS slug"
            )
            ->from($this->db->quoteName("#__itpsc_profiles") . ' AS a')
            ->where("a.id = ". (int)$id);
    
        $this->db->setQuery($query);
        $result = $this->db->loadAssoc();
    
        if(!empty($result)) { // Set values to variables
            $this->bind($result);
        }
    
    }
    
    public function bind($data) {
    
        foreach($data as $key => $value) {
            $this->$key = $value;
        }
    
    }
    
    
	/**
     * Provide a link to social profile.
     * 
     *  @return string
     */
    public function getLink() {
        
        $link = "";
        if(!empty($this->slug)) {
            $link    = JRoute::_(SocialCommunityHelperRoute::getProfileRoute($this->slug));
        }
        
        return $link;
    }
    
	/**
     * Provide a link to social avatar. 
     * 
     * @return string
     */
    public function getAvatar() {
        
        $link = "";
        
        if(!empty($this->avatar)) {
            $link    = Juri::base().$this->path.$this->avatar;
        }
                
        return $link;
    }
    
    /**
     * Set the path to the images folder.
     * 
     * @param string $path
     */
    public function setPath($path) {
        $this->path = $path;
    }
    
}

