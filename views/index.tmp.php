<?php include "elements/header.tmp.php"; ?>
<article>
  <?php if(!$g->in_progress()) : ?>
    <header>
      <h1>Anagram</h1>
    </header>  
    <form action="/start" method="post">
      <!-- <p><label for="initails">Initials ( required )</label></p>
      <p><input type="text" name="initials" class="initials" required maxlength="3"></p> -->
      <p><button>Start game</button></p>
    </form>
  <? else : 
    $puzzels = $_SESSION['game'];
    $current = array_pop($puzzels);
    $puzzels = array_reverse($puzzels);
    $anagram = str_split($current['anagram']);
    $counter = count($_SESSION['game']); 
  ?>
    <header>
      <h1>#<?=$counter--?>.</h1>
      <p class="score">Score <?=round($_SESSION['score'])?></p>
    </header>
    <ul class="tiles anagram">
      <?php for($i=0; $i < count($anagram); $i++) : ?>
        <?php $letter = $anagram[$i]; ?>
        <li><span id="letter-<?=$i?>" data-letter="<?=$letter?>"><?=$letter?></span></li>
      <?php endfor;?>
    </ul>
    <p>( <em>Drag &amp; drop your solution</em> )</p>
    <ul class="tiles solution">
      <?php foreach ($anagram as $letter) : ?>
        <li><span data-drop-id="">&nbsp;</span></li>
      <?php endforeach;?>
    </ul>
    
    <p>
      <a href="/hint" class="hint">Hint</a><br>
      <small>Using a hint reduces your word score by 50%</small>
    </p>
    
    <div id="hint"></div>

    <form id="solution" method="post" action="/solution">
      <input type="hidden" name="solution" value="">
      <button id="submit" class="submit" disabled>Submit</button>
    </form>    

    <p><a href="/quit">Quit</a></p>

    <div class="puzzels">
      <div class="container">
        <?php for($i = 0; $i < count($puzzels); $i++) : ?>
          <?php $puzzel = $puzzels[$i]; ?>
          <div class="twelve columns offset-by-four">
            <h2>#<?=$counter--?>. <span class=""><?=$puzzel['wrd']->word?></span></h2>
            <?php
              // echo $puzzel['start_time'] . '<br>';
              // echo $puzzel['end_time'] . '<br>';
              // echo $puzzel['answer'] . '<br>';
            ?>
            <ul>  
            <?php foreach($puzzel['def'] as $def) : ?>
              <li><?=$def->text?></li>
            <?php endforeach; ?>
            </ul>
          </div>
        <?php endfor; ?>
      </div>
    </div>
  <?php endif; ?>
</article>
<?php include "elements/footer.tmp.php"; ?>