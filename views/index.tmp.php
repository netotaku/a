<?php include "elements/header.tmp.php"; ?>
<article>
  <?php if(!$g->in_progress()) : ?>
    <form action="/start" method="post">
      <p><label for="initails">Initials ( required )</label></p>
      <p><input type="text" name="initials" class="initials" required maxlength="3"></p>
      <p><button>Start game</button></p>
    </form>
  <? else : ?>
    <ul class="tiles anagram">
      <?php $i=0; ?>
      <?php foreach ($g->anagram() as $letter) : ?>
        <li><span id="letter-<?=$i++?>" data-letter="<?=$letter?>"><?=$letter?></span></li>
      <?php endforeach;?>
    </ul>
    <p>( <em>Drag &amp; drop your solution</em> )</p>
    <ul class="tiles solution">
      <?php foreach ($g->anagram() as $letter) : ?>
        <li><span data-drop-id="">&nbsp;</span></li>
      <?php endforeach;?>
    </ul>
    <p>
      <a href="/hint" class="hint">Hint</a><br>
      <small>Using a hint reduces your word score by 50%</small>
    </p>
    <div id="hint"></div>
    <?php $result = $g->score() ?>
    <form id="solution" method="post" action="/solution">
      <input type="hidden" name="solution" value="">
      <button class="submit">Submit</button>
    </form>    
    <p>Score <?=$result['correct']?> / <?=$result['total']?>
      <span class="score"><?=$result['score']?></span>
      <a href="/submit-score">Finish and submit your score</a> 
    </p>
    <pre><?php //var_dump(); ?></pre>
  <?php endif; ?>
</article>
<?php include "elements/footer.tmp.php"; ?>