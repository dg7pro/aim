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
class ITPrismIntegrateNotificationJomSocial implements ITPrismIntegrateInterfaceNotification  {
    
    protected $id;
    
    protected $actor;
    protected $target;
    protected $content;
    protected $type     = 0;
    protected $cmd_type = "notif_gamification_notification";
    protected $status   = 0;
    protected $created;
    
    protected $image;
    protected $url;
    
    /**
     * Initialize the object, setting a user id and a notice.
     * 
     * @param  integer $userId	User ID
     * @param  string  $note	Notice to user.
     * 
     */
    public function __construct($userId = 0, $note = "") {
        $this->target   = $userId;
        $this->content  = $note;
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
            $this->content = $note;
        }
        
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        
        if(!empty($this->image)) {
            $params["image"]        = $this->image;
        }
        
        if(!empty($this->url)) {
            $params["url"]          = $this->url;
        }
        
        $date = new JDate();
        
        $query
            ->insert("#__community_notifications")
            ->set( $db->quoteName("target")  ."=". (int)$this->target)
            ->set( $db->quoteName("content") ."=". $db->quote($this->content))
            ->set( $db->quoteName("cmd_type")."=". $db->quote($this->cmd_type))
            ->set( $db->quoteName("type")    ."=". $db->quote($this->type))
            ->set( $db->quoteName("status")  ."=". (int)$this->status)
            ->set( $db->quoteName("created") ."=". $db->quote($date->toSql()) );
        
        if(!empty($params)) {
            $params = json_encode($params);
            $query->set($db->quoteName("params")."=". $db->quote($params));
        }
        
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
     * @return the $note
     */
    public function getNote() {
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
        return $this->status;
    }
    
    /**
     * @return the $user_id
     */
    public function getUserId() {
        return $this->target;
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
        $this->content = $note;
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
        $this->status = $read;
    }
    
    /**
     * @param integer $user_id
     */
    public function setUserId($user_id) {
        $this->target = $user_id;
    }
    
}

