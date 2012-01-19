<?php

/*
 * Staff list
 */
?>
<div class="title">Задачи</div>
<div class="left">
    <ul>
        <li class="active">Мои задачи</li>
        <li>Выполненные</li>
        <li>В процессе</li>
        <li>Невыполненные</li>
    </ul>
</div>
<div class="right">
    <?include('tasks/my.php');?>
</div>
<script type="text/javascript">
    $('.office .page .right .task').draggable({
            stack: 'div',
            helper : 'clone',
            opacity : 0.9
    });

    $('.office .page .right .planned .data').droppable({
            tolerance : 'fit',
            accept : 'div.task',
            drop : function(event, ui) {
                    $(this).append(ui.draggable);
            }
    });
    
    $('.office .page .right .current .data').droppable({
            tolerance : 'fit',
            accept : 'div.task',
            drop : function(event, ui) {
                    $(this).append(ui.draggable);
            }
    });
    
    $('.office .page .right .completed .data').droppable({
            tolerance : 'fit',
            accept : 'div.task',
            drop : function(event, ui) {
                    $(this).append(ui.draggable);
            }
    });
    
    var rightHeight = $('.office .page .right').outerHeight();
    var titleHeight = $('.office .page .right .completed .title').innerHeight();
    var dataHeight = rightHeight-titleHeight;
    $('.office .page .right .data').css('height',dataHeight+'px');
    $('.office .page .right .task .text').dblclick(function(){
        var text = $(this).html();
        var classMathRandom = Math.random();
        $(this).html('<textarea class="textEdit'+classMathRandom+'">'+text+'</textarea>');
        $(this).keydown(function(){
            var classRoot = '.'+$(this).attr('class');
            if(event.keyCode == 13)
                $(this).html($(classRoot+' textarea').val());
            if(event.keyCode == 27)
                $(this).html(text);
        });
    });
</script>