<?php

session_start(); 

class game{
  function __construct(){

  }
  public function set_word(){
    if($this->in_progress()){
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
        "anagram" => str_shuffle($wrd->word),
        "correct" => false
      );
    }
  }
  public function &game(){
    return $_SESSION['game'];
  }
  public function latest(){
    if(isset($_SESSION['game'])){
      return end($this->game());
    } else {
      return false;
    } 
  }
  public function in_progress(){
    return isset($_SESSION['game']);
  }
  public function start_game(){
    if(!$this->in_progress()){
      $_SESSION['game'] = array();
    }
    header('Location: /');
  }
  public function end_game(){
    session_destroy();
    header('Location: /');
  }
  public function anagram(){
    return str_split(strtoupper($this->latest()['anagram'])); 
  }
  public function solution(){
    if($this->latest()){
      return $this->latest()['wrd']->word;  
    } else {
      return false;
    }
  }
  public function mark($answer){
    if($answer == strtoupper($this->solution())){
      $last = count($this->game())-2;
      $_SESSION['game'][$last]['correct'] = true;
      $_SESSION['game'][$last]['end_time'] = time();
    }
    header('Location: /');
  }
  public function score(){
    $correct = 0;
    foreach ($_SESSION['game'] as $anagram) {
      if(isset($anagram['correct']) && $anagram['correct'] == true) {
        $correct++;
      }
    }
    $total = count($_SESSION['game'])-2;
    return $correct . ' / ' . ($total < 0 ? 0 : $total);
  }
  public function hint(){
    header('Content-type: application/json');
    echo json_encode($this->latest()['def']);
  }
}

$g = new game();

switch(explode('/',ltrim(rtrim($_SERVER["REQUEST_URI"], '/'), '/'))[0]){
  case "":
  case "hard":
  case "medium":
  case "easy":
    $g->set_word();
    include "views/index.tmp.php";
  break;
  case "solution":
    $g->mark($_POST["solution"]);
  break;
  case "start":
    $g->start_game();
  break;
  case "quit":
    $g->end_game();
  break;  
  case "hint":
    $g->hint();
  break;
  default:
    echo "404";
  break;
}



?>