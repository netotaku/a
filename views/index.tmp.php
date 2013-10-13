<?php include "elements/header.tmp.php"; ?>
<article>
  <?php if(!$g->in_progress()) : ?>
      <p><a href="/start">New Game</a></p>
  <? else : ?>
    <ul class="anagram">
      <?php foreach ($g->anagram() as $letter) : ?>
        <li><span><?=$letter?></span></li>
      <?php endforeach;?>
    </ul>
    <pre>
      <?php 
        //var_dump();
      ?>    
    </pre>
  <?php endif; ?>
</article>
<?php include "elements/footer.tmp.php"; ?>