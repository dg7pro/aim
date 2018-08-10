<?php
/**
 * @package      ITPrism Library
 * @subpackage   Video
 * @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * ITPrism Library is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// no direct access
defined('_JEXEC') or die;

/**
 * This class provides functionality for parsing video URLs 
 * and generating HTML code that can be used for embedding into websites.
 *
 * @package 	 ITPrism Library
 * @subpackage   Video
 */
class ITPrismVideoEmbed {
    
    protected $url;
    protected $code;
    protected $service;
    
    protected $patternYouTube = '#(?<=(?:v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+#';
    protected $patternVimeo   = '#^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)#';
    
    public function __construct($url = null){
        
        if(!empty($url)) {
            $this->url = $url;
            $this->parse();
        }
    }
    
    /**
     * Parse the URL of video service
     * 
     * @param string $url
     */
    public function parse($url = null) {
        
        if(!empty($url)) {
            $this->url = $url;
        }
        
        $uri  = new JURI($this->url);
        $host = $uri->getHost();
        
        // Youtube
        if(false !== strpos($host, "youtu")) {
            if(preg_match($this->patternYouTube, $this->url, $matches)) {
                $this->code = $matches[0];
                $this->service = "youtube";
                return;
            }
        }
        
        // Vimeo
        if(false !== strpos($host, "vimeo")) {
            if( preg_match($this->patternVimeo, $this->url, $matches) ) {
                $this->code    = $matches[5];
                $this->service = "vimeo";
                return;
            }
        }
        
    }
    
    /**
     * Return the ID of the video.
     */
    public function getCode() {
        return $this->code;
    }
    
    /**
     * Return an HTML code that can be used for embedding.
     */
    public function getHtmlCode() {
        
        $html = "";
        
        switch($this->service) {
            
            case "youtube":
                $html = '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.$this->code.'" frameborder="0" allowfullscreen></iframe>';
                break;
                
            case "vimeo":
                $html = '<iframe src="http://player.vimeo.com/video/'.$this->code.'" width="500" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                break;
                
            default:
                $html = "Invalid video service.";
                break;
        }
        
        return $html;
    }
    
}