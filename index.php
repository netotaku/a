<?php

session_start(); 

class game{
  function __construct(){
    if($this->in_progress()){
      $this->set_word();
    }
  }
  public function set_word(){
    include "config.php";
    $uri = $wrdURL;
    foreach($wrdQS as $key => $val){
      $uri .= $key."=".$val."&";
    }
    $wrd = json_decode(file_get_contents(rtrim($uri, '&')));
    $uri = $defURL.$wrd->word.'/definitions?';
    foreach($defQS as $key => $val){
      $uri .= $key."=".$val."&";
    }
    $def = json_decode(file_get_contents(rtrim($uri, '&')));
    $_SESSION['game'][] = array(
      "wrd" => $wrd,
      "def" => $def,
      "start_time" => time(),
      "end_time" => null,
      "anagram" => str_shuffle($wrd->word)
    );
  }
  public function latest(){
    return end($_SESSION['game']);  
  }
  public function in_progress(){
    return isset($_SESSION['game']);
  }
  public function start_game(){
    if(!$this->in_progress()){
      $_SESSION['game'] = array();
      $this->set_word();
    }
    header('Location: /');
  }
  public function end_game(){
    session_destroy();
    header('Location: /');
  }
  public function anagram(){
    return str_split($this->latest()['anagram']); 
  }
  public function solution(){
    return $this->latest()['wrd']->word;  
  }
}

$g = new game();

switch(explode('/',ltrim(rtrim($_SERVER["REQUEST_URI"], '/'), '/'))[0]){
  case "":
  case "hard":
  case "medium":
  case "easy":
    include "views/index.tmp.php";
  break;
  case "start":
    $g->start_game();
  break;
  case "quit":
    $g->end_game();
  break;  
  case "hint":
    echo "hint";
  break;
  default:
    echo "404";
  break;
}



?>