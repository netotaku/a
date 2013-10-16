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
        "correct" => false,
        "hint" => false
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
    if(!$this->in_progress() && $_POST['initials'] != ''){
      $_SESSION['game'] = array();
      $_SESSION['initials'] = strip_tags(strtoupper(substr($_POST['initials'], 0, 3)));
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
      $_SESSION['game'][$this->end()]['correct'] = true;
      $_SESSION['game'][$this->end()]['end_time'] = time();
    }
    header('Location: /');
  }
  public function score(){
    $score  = 0;
    $correct = 0;
    foreach ($_SESSION['game'] as $anagram) {
      if(isset($anagram['correct']) && $anagram['correct'] == true) {
        $correct++;
        $wordScore = 1000-($anagram['end_time'] - $anagram['start_time']);
        if($anagram['hint']){
          $wordScore*=0.5;    
        }
        $score += round($wordScore);
      }
    }
    $total = count($_SESSION['game'])-1;
    return array(
      "total" => ($total < 0 ? 0 : $total),
      "correct" => $correct,
      "score" => $score
    );
  }
  public function hint(){
    $_SESSION['game'][$this->end()]['hint'] = true;
    header('Content-type: application/json');
    $def = $this->latest()['def'];
    if($def){
      echo json_encode($this->latest()['def']);  
    } else {
      echo '[{"text":"Oops, no hint"}]';
    }
    
  }
  public function end(){
    return count($this->game())-2;
  }
  public function submit_score(){
    $fh = fopen("leaderboard.txt", 'a+') or die("can't open file");
    fwrite($fh, $_SESSION['initials']."----".$this->score()['score']."\n");
    fclose($fh);
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
  case "submit-score":
    $g->submit_score();
  break;
  default:
    echo "404";
  break;
}



?>