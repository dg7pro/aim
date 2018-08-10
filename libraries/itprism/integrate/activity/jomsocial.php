<?php
/**
* @package      ITPrism Library
* @subpackage   Integrate Activity
* @author       Todor Iliev
* @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
* @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
* ITPrism Library is free software. This vpversion may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined('JPATH_PLATFORM') or die;

jimport("itprism.integrate.interface.activity");

/**
 * This class provides functionality to 
 * integrate extensions with the activities of Social Community.
 * 
 * @package      ITPrism Library
 * @subpackage   Integrate Activity
 */
class ITPrismIntegrateActivityJomSocial implements ITPrismIntegrateInterfaceActivity  {
    
    protected $id;
    protected $content;
    protected $url;
    protected $created;
    protected $app = "gamification.activity";
    
    /**
     * This is the status of the activity.
     * @var integer
     */
    protected $archived = 0;
    
    /**
     * This is a link to image.
     * @var string
     */
    protected $image;
    
    /**
     * This is the user that has done the activity.
     * @var integer
     */
    protected $actor;
    
    /**
     * Initialize the object, setting a user id 
     * and information about the activity.
     * 
     * @param  integer $userId	User ID
     * @param  string  $info	Information about the activity.
     */
    public function __construct($userId = 0, $info = "") {
        $this->actor     = $userId;
        $this->content   = $info;
    }
    
    public function bind($data) {
        
        if(!empty($data)) {
            
            foreach($data as $key => $value) {
                $this->$key = $value;
            }
            
        }
    }    
    
    public function store($info = "") {
        
        if(!empty($info)) {
            $this->content = $info;
        }
        
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        
        $date = new JDate();
        
        $query
            ->insert("#__community_activities")
            ->set( $db->quoteName("actor")   ."=". (int)$this->actor)
            ->set( $db->quoteName("content") ."=". $db->quote($this->content))
            ->set( $db->quoteName("archived")."=". $db->quote($this->archived))
            ->set( $db->quoteName("app")     ."=". $db->quote($this->app))
            ->set( $db->quoteName("created") ."=". $db->quote($date->toSql()) );
        
        $db->setQuery($query);
        $db->query();
        
    }
    
    /**
     * @return the $id
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @return the $info
     */
    public function getInfo() {
        return $this->content;
    }
    
    /**
     * @return the $image
     */
    public function getImage() {
        return $this->image;
    }
    
    /**
     * @return the $url
     */
    public function getUrl() {
        return $this->url;
    }
    
    /**
     * @return the $created
     */
    public function getCreated() {
        return $this->created;
    }
    
    /**
     * @return the $read
     */
    public function getRead() {
        return $this->archived;
    }
    
    /**
     * @return the $user_id
     */
    public function getUserId() {
        return $this->actor;
    }
    
    /**
     * @param integer $id
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    /**
     * @param string $info
     */
    public function setInfo($info) {
        $this->content = $info;
    }
    
    /**
     * @param string $image
     */
    public function setImage($image) {
        $this->image = $image;
    }
    
    /**
     * @param string $url
     */
    public function setUrl($url) {
        $this->url = $url;
    }
    
    /**
     * @param string $created
     */
    public function setCreated($created) {
        $this->created = $created;
    }
    
    /**
     * @param integer $read
     */
    public function setRead($read) {
        $this->archived = $read;
    }
    
    /**
     * @param integer $user_id
     */
    public function setUserId($user_id) {
        $this->actor = $user_id;
    }
    
    /**
     * @param string $app
     */
    public function setApp($app) {
        $this->app = $app;
    }
}

