<?php include "elements/header.tmp.php"; ?>
<article>
  <?php if(!$g->in_progress()) : ?>
      <p><a href="/start">New Game</a></p>
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
    <p><a href="/hint" class="hint">Hint</a></p>
    <div id="hint"></div>
    <p>Score <?=$g->score()?></p>
    <form id="solution" method="post" action="/solution">
      <input type="hidden" name="solution" value="">
      <button class="submit">Submit</button>
    </form>
    <pre><?php //var_dump(); ?></pre>
  <?php endif; ?>
</article>
<?php include "elements/footer.tmp.php"; ?>