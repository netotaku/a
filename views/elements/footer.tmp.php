  <footer>
    Powered by <a href="#">Wordnik</a> | <?=$g->solution()?>
  </footer>
  <script type="text/html" id="tmp-hint">
    <ul>
      <% $.each(items, function(){ %>
        <li><%=this.text%></li>
      <% }) %>
    </ul>
  </script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="/bower_components/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.2.1/lodash.min.js"></script>
  <script type="text/javascript">
    
    $(".anagram span").draggable({
      start:function(ui){
        $("[data-drop-id='"+$(this).css('z-index', 1).attr('id')+"']")
          .attr('data-drop-id', '')
          .droppable('enable');
      }
    });

    $(".solution span").droppable({
      drop: function(e, ui){
        $(this)
          .attr('data-drop-id', $(ui.draggable.context)
            .css('z-index', 0)
            .attr('id'))
          .droppable('disable');
        ui.draggable.position({of: $(this),my: 'left top',at: 'left top'});
      },
      tolerance: "intersect"
    });

    $('#solution').on('submit', function(e){
      var solution = '';
      $.each($('.solution li span'), function(){
        solution += $('#'+$(this).data('drop-id')).html();
      });
      $('[name=solution]').val(solution);
    });

    $('.hint').on('click', function(e){
      e.preventDefault();
      $.getJSON('/hint', function(data){
        $("#hint").html(_.template($('#tmp-hint').html(),{items:data}));
      });
    });

  </script>
</body>
</html>