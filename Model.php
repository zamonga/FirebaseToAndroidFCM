<?php
class Notification{
	private $title;
	private $image_url;
	private $original_url;
	private $post_id;
	private $click_action;
	
	function __construct(){
         
	}
 
	public function setTitle($title){
		$this->title = $title;
	}
 
	public function setImage($imageUrl){
		$this->image_url = $imageUrl;
	}
 
	public function setOriginal_url($originalUrl){
		$this->original_url = $originalUrl;
	}
 
	public function setPost_id($postID){
		$this->post_id = $postID;
	}
 
	public function setClick_action($clickAction){
		$this->click_action = $clickAction;
	}
 
		
	public function getNotificatin(){
		$notification = array();
		$notification['title'] = $this->title;
		$notification['imageUrl'] = $this->image_url;
		$notification['originalURL'] = $this->original_url;
		$notification['postID'] = $this->post_id;
		$notification['click_action'] = $this->click_action;
		return $notification;
	}
}
?>