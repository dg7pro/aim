<?php
/**
* @package      ITPrism Library
* @subpackage   Integrate Notification
* @author       Todor Iliev
* @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
* @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
* ITPrism Library is free software. This vpversion may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined('JPATH_PLATFORM') or die;

jimport("itprism.integrate.interface.notification");

/**
 * This class provides functionality to 
 * integrate extensions with the notifications of social community.
 * 
 * @package      ITPrism Library
 * @subpackage   Integrate Notification
 */
class ITPrismIntegrateNotificationSocialCommunity implements ITPrismIntegrateInterfaceNotification  {
    
    protected $id;
    protected $note;
    protected $image;
    protected $url;
    protected $created;
    protected $read;
    
    protected $user_id;
    
    /**
     * Initialize the object, setting a user id and a notice.
     * 
     * @param  integer $userId	User ID
     * @param  string  $note	Notice to user.
     * 
     */
    public function __construct($userId = 0, $note = "") {
        $this->user_id  = $userId;
        $this->note     = $note;
    }
    
    public function bind($data) {
        
        if(!empty($data)) {
            
            foreach($data as $key => $value) {
                $this->$key = $value;
            }
            
        }
    }    
    
    public function send($note = "") {
        
        if(!empty($note)) {
            $this->note = $note;
        }
        
        jimport("socialcommunity.notification");
        $notification           = new SocialCommunityNotification();
        
        $notification->note     = $this->getNote();
        $notification->user_id  = $this->getUserId();
        
        if(!empty($this->image)) {
            $notification->image    = $this->getImage();
        }
        
        if(!empty($this->url)) {
           $notification->url      = $this->getUrl();
        }
        
        $notification->store();
        
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
    public function getNote() {
        return $this->note;
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
    public function setNote($note) {
        $this->note = $note;
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
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }
    
}

