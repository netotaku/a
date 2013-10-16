  <footer>
    Powered by <a href="#">Wordnik</a> | <?=$g->solution()?>
  </footer>
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="/bower_components/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script type="text/javascript">
    $( ".anagram span" ).draggable({
      stop:function(){
        // console.log('dropped anyway');
      },
      start:function(ui){
        $(this).css('z-index', 1);
        var id = $(this).attr('id');
        $("[data-drop-id='"+id+"']")
          .droppable('enable')
          .data('drop-id', '');
      }
    });
    $( ".solution span" ).droppable({
      drop: function(e, ui){
        $dEL = $(ui.draggable.context).css('z-index', 0);
        $this = $(this);
        // console.log($dEL.attr('id'));
        $this.attr('data-drop-id', $dEL.attr('id'));
        if (ui.draggable.element !== undefined) {
          ui.draggable.element.droppable('enable');
        }
        $this.droppable('disable');
        ui.draggable.position({of: $(this),my: 'left top',at: 'left top'});
        // ui.draggable.draggable('option', 'revert', "invalid");
        ui.draggable.element = $this;
      },
      tolerance: "intersect"
    });

    $('#solution').on('submit', function(e){
      //e.preventDefault();
      var solution = '';
      $.each($('.solution li span'), function(){
        solution += $('#'+$(this).data('drop-id')).html();
      });
      $('[name=solution]').val(solution);
    });

  </script>
</body>
</html>