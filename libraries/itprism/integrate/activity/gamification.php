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
 * integrate extensions with the activities of Gamification Platform.
 * 
 * @package      ITPrism Library
 * @subpackage   Integrate Activity
 */
class ITPrismIntegrateActivityGamification implements ITPrismIntegrateInterfaceActivity  {
    
    protected $id;
    protected $info;
    protected $image;
    protected $url;
    protected $created;
    protected $read;
    
    protected $user_id;
    
	/**
     * Initialize the object, setting a user id 
     * and information about the activity.
     * 
     * @param  integer $userId	User ID
     * @param  string  $info	Information about the activity.
     */
    public function __construct($userId = 0, $info = "") {
        $this->user_id  = $userId;
        $this->info     = $info;
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
            $this->info = $info;
        }
        
        jimport("gamification.activity");
        $activity           = new GamificationActivity();
        
        $activity->info     = $this->getInfo();
        $activity->user_id  = $this->getUserId();
        
        if(!empty($this->image)) {
            $activity->image    = $this->getImage();
        }
        
        if(!empty($this->url)) {
           $activity->url      = $this->getUrl();
        }
        
        $activity->store();
        
    }
    
    /**
     * @return the $id
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @return the $note
     */
    public function getInfo() {
        return $this->info;
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
        return $this->read;
    }
    
    /**
     * @return the $user_id
     */
    public function getUserId() {
        return $this->user_id;
    }
    
    /**
     * @param integer $id
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    /**
     * @param string $note
     */
    public function setInfo($info) {
        $this->info = $info;
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
        $this->read = $read;
    }
    
    /**
     * @param integer $user_id
     */
    public function setUserId($userId) {
        $this->user_id = $userId;
    }
    
    
}

