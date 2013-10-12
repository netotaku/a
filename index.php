<?php

session_start(); 

include "config.php";

$params = explode('/',ltrim(rtrim($_SERVER["REQUEST_URI"], '/'), '/'));

switch($params[0]){
  case "":
  case "hard":
  case "medium":
  case "easy":
    include "views/index.tmp.php";
  break;
  case "start":
    if(!isset($_SESSION['game'])){
      $_SESSION['game'] = array();
    }
    header('Location: /');     
  break;
  case "quit":
    session_destroy(); 
    header('Location: /');   
  case "hint":
    echo "hint";
  break;
  default:
    echo "404";
  break;
}



?>