<?php
class AJAXChatPlugin{
  private $plugin = [];
  
  public function __construct($ajaxchat){
    foreach($ajaxchat->getConfig("plugin") as $dir){
      if(file_exists("./lib/plugin/".$dir."/plugin.php")){
        $this->loadPlugin($dir);
      }
    }
  }
  
  public function event($name, $arg){
    foreach($this->plugin as $plugin){
      if(!call_user_func_array([$plugin, "event"], $arg))
        return false;
    }
    return true;
  }
  
  private function loadPlugin($dir){
    include "./lib/plugin/".$dir."/plugin.php";
    if(class_exists($dir))
      $this->plugin[] = new $dir();
  }
}
