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

/**
 * This class provides functionality to 
 * integrate extensions with the profile of Kunena.
 * 
 * @package      ITPrism Library
 * @subpackage   Integrate Profile
 */
class ITPrismIntegrateProfileKunena implements ITPrismIntegrateInterfaceProfile  {
    
    protected $user_id;
    protected $avatar;
    
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
     * Create an object.
     *
     * @param  array $keys
     * @return multitype:
     */
    public static function getInstance($id)  {
    
        if (empty(self::$instances[$id])){
            $item = new ITPrismIntegrateProfileKunena($id);
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
            ->select("a.userid AS user_id, a.avatar")
            ->from($this->db->quoteName("#__kunena_users") . ' AS a')
            ->where("a.userid = ". (int)$id);
    
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
     * @return string Return a link to the profile.
     */
    public function getLink() {
        return KunenaRoute::_("index.php?option=com_kunena&view=profile&userid=".$this->user_id, false );
    }
    
	/**
     * Provide a link to social avatar. 
     * 
     * @param $size  It is avatar size.
     * 
     * @return string Return a link to the picture.
     */
    public function getAvatar($size = 72) {
        
        $link = "";
        
        if(!$this->avatar) {
            $link = JUri::base()."media/kunena/avatars/nophoto.jpg";
        } else {
            $link = JUri::base()."media/kunena/avatars/resized/size".(int)$size."/".$this->avatar;
        }
        
        return $link;
    }
    
}

