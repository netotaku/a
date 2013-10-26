<?php

session_start(); 
// error_reporting(E_ERROR | E_WARNING | E_PARSE);

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
        "anagram" => strtoupper(str_shuffle($wrd->word)),
        "correct" => false,
        "hint" => false,
        "solution" => strtoupper($wrd->word),
        "answer" => '',
        "score" => 0
      );
    }
  }
  public function in_progress(){
    return isset($_SESSION['game']);
  }
  public function start_game(){
    // if(!$this->in_progress() && $_POST['initials'] != ''){
      $_SESSION['game'] = array();
      $_SESSION['score'] = 0;
     // $_SESSION['initials'] = strip_tags(strtoupper(substr($_POST['initials'], 0, 3)));
    // }
    $this->set_word();
    header('Location: /');
  }
  public function end_game(){
    session_destroy();
    header('Location: /');
  }
  public function mark($answer){
    $last = &$_SESSION['game'][$this->end()];
    $last['answer'] = $answer;
    $last['end_time'] = time();
    if($answer == $last['solution']){ 
      $last['correct'] = true;
      $score = 1000 - ($last['end_time'] - $last['start_time']);
      if($last['hint']){
        $score *= 0.5;
      }
      $last['score'] = $score;
      $_SESSION['score'] = $_SESSION['score']+$score;
    }
    $this->set_word();
    header('Location: /');
  }
  public function hint(){
    $last = &$_SESSION['game'][$this->end()];
    $last['hint'] = true;
    header('Content-type: application/json');
    $def = $last['def'];
    if($def){
      echo json_encode($def);  
    } else {
      echo '[{"text":"Oops, no hint"}]';
    }
    
  }
  public function end(){
    return count($_SESSION['game'])-1;
  }
  // public function submit_score(){
  //   $score = $this->score();
  //   $fh = fopen("leaderboard.txt", 'a+') or die("can't open file");
  //   fwrite($fh, $_SESSION['initials']."----".$score['score']."\n");
  //   fclose($fh);
  // }
  // public function leaderboard(){
  //   $scores = array();
  //   $line = ".......................................................";
  //   foreach (file('leaderboard.txt') as $row) {
  //     $data = explode('----', $row);
  //     $user = $data[0];
  //     $score = $data[1];
  //     $space = substr($line, 0, -strlen($user));
  //     $space = substr($space, 0, -strlen($score));
  //     $scores[] = $user . ' ' . $space . ' ' . $score;
  //   }
  //   return $scores;
  // }
}

$g = new game();

$params = explode('/',ltrim(rtrim($_SERVER["REQUEST_URI"], '/'), '/'));

switch($params[0]){
  case "":
  case "hard":
  case "medium":
  case "easy":
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
    // $g->submit_score();
  break;
  default:
    echo "404";
  break;
}

?>

   
