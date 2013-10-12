<?php include "elements/header.tmp.php"; ?>
<article>

<?php

    if(!isset($_SESSION['game'])){
      ?>
        <p><a href="/start">New Game</a></p>
      <?
    } else {

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
        "start_time" => date()
      );

      ?>

        <pre>
          <?php 
            var_dump(str_shuffle($wrd->word));
            var_dump($wrd);
            var_dump($def);
          ?>    
        </pre>

      <?php

    }

?>
</article>
<?php include "elements/footer.tmp.php"; ?>