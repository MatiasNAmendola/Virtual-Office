<?php

/*
 * Board with staff task
 */
?>
<div class="planned">
    <div class="title">В планах</div>
    <div class="data">
        <div class="task task1">
            <div class="text">Написать отчет о поездке</div>
        </div>
    </div>
</div>
<div class="current">
    <div class="title">В процессе</div>
    <div class="data">
        
    </div>
</div>
<div class="completed">
    <div class="title">Выполненные</div>
    <div class="data">
        
    </div>
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

            $('.office .page .right .task .text').dblclick(function(){
                var text = $(this).html();
                $(this).html('<textarea>'+text+'</textarea>');
                var textarea = $(this).children('textarea');
                $(textarea).focus();
                $(this).keydown(function(){
                    if(event.keyCode == 13)
                        $(this).html($(textarea).val());
                    if(event.keyCode == 27)
                        $(this).html(text);
                });
            });
</script>