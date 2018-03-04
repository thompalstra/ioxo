<?php
Scope::$app->controller->layout = 'page-edit';
header('X-XSS-Protection: 0');
?>

<style>
    html, body{
        margin: 0;
    }
    .page-editor{
        width: 100%;
        height: 100%;
    }

    .page-editor .preview,
    .page-editor .preview iframe,
    .page-editor .content,
    .page-editor .content [contenteditable="true"]{
        width: 100%;
        height: 100%;
    }

    .page-editor .code{
        width: 100%;
        height: 100%;
    }

    .page-editor .page-editor-actions,
    .page-editor .code-actions{
        list-style: none;
        padding: 0;
        margin: 0;
        height: 50px;
    }

    .page-editor .page-editor-action,
    .page-editor .code-action{
        min-width: 50px;
        height: 50px;
        line-height: 50px;
        display: inline-block;
        float: left;
    }

    .page-editor .page-editor-action.in,
    .page-editor .code-action.in{
        background-color: #ddd;
        color: #111;
    }

    .page-editor .page-editor-action[icon]:after,
    .page-editor .code-action[icon]:after{
        content: attr(icon);
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-family: "Material Icons";
        display: inline-block;
        text-align: center;
        font-size: 25px;
    }

    .page-editor .code textarea{
        height: calc( 100% - 50px );
        width: 100%;
    }


    .page-editor[code-text-wrap="1"] textarea{
        white-space: nowrap;
    }

    .page-editor .panels[is-mousedown="1"] .column{
        -webkit-user-select: none;  /* Chrome all / Safari all */
        -moz-user-select: none;     /* Firefox all */
        -ms-user-select: none;      /* IE 10+ */
        user-select: none;          /* Likely future */
    }
</style>

    <form method='POST' id='w0-form'>

        <div id='w0-page-editor' class='page-editor' mode='code'>
            <ul class='page-editor-actions'>
                <li class='page-editor-action' page-editor-action='save' icon='save'></li>
            </ul>

            <table id='w0-panels-1' class='panels' style='height: calc( 100% - 50px ); width: 100%'>
                <tr>
                    <td class='column' width=50%>
                        <table id='w0-panels-1' class='panels' height=100% width=100%>
                            <!-- <tr height="50%"> -->
                            <tr id='code'>
                                <td>
                                    <div class='code'>
                                        <ul class='code-actions'>
                                            <li class='code-action' code-action='toggleTextWrap' icon='wrap_text'>
                                            </li>
                                        </ul>
                                        <?php foreach( Scope::$app->_language->supported as $lang ) { ?>
                                            <textarea name='Page[content][<?=$lang?>]' class='<?=( ( $lang !== $language ) ? "hidden" : "" )?>' >
                                                <?=$model->content[$lang]?>
                                            </textarea>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class='column divider horizontal' height=10></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class='content'>
                                        <div contenteditable="true">
                                            <?=$model->content[$lang]?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class='column divider vertical' width=10>
                    </td>
                    <td class='column'>
                        <div>
                            <iframe id='iframe' src="http://ioxo.nl/scope-cms-page/scope-cms-page-preview?id=<?=$model->id?>&language=<?=$language?>" frameborder=0></iframe>
                        </div>
                    </td>
                </tr>
        </div>
    </form>
<script>

sc("[name^='Page[content]']").forEach(function(el){
    el.onscroll = function(e){
        localStorage.setItem( 'scroll_' + el.name, el.scrollTop );
    }
    el.scrollTop = localStorage.getItem( 'scroll_' + el.name );
})

window['PageEditor'] = window['Scope']['widgets']['PageEditor'] = function( element ){
    this.element = element;

    var panels1 = new Scope.widgets.Panels( document.findOne('#w0-panels-1') );

    this.registerListeners();
}

extend( window['PageEditor'] ).with({
    editorActions: {
        save: function(){
            console.log(this.element);
             // this.element.closest('form').submit();
             document.findOne('#w0-form').submit();
        }
    },
    codeActions: {
        toggleTextWrap: function( target ){
            if( this.element.attr('code-text-wrap') == true ){
                this.element.attr('code-text-wrap', '0');
                target.removeClass('in');
                localStorage.setItem( 'code_text_wrap', false  );
                    console.log('false');
            } else {
                this.element.attr('code-text-wrap', '1')
                target.addClass('in');
                localStorage.setItem( 'code_text_wrap', true  );
                console.log('true');
            }
        }
    },
    registerListeners: function(){
        if( localStorage.getItem( 'code_text_wrap' ) == 'true' ){
            this.element.attr('code-text-wrap', '1')
            this.element.find('[code-action="toggleTextWrap"]').forEach(function(el){

                el.addClass('in');
            });

        }

        this.element.listen('keydown', function(e){
            if( e.ctrlKey == true && e.keyCode == 83 ){
                e.preventDefault();
                var textarea = this.element.findOne('textarea');
                this.editorActions['save'].call(this, e.target);
            }
        }.bind(this));
        this.element.find('[contenteditable="true"]').listen('input', function(e){
            var textarea = this.closest('#w0-page-editor').findOne('.code textarea:not(.hidden)');
            textarea.innerHTML = this.innerHTML;
        });

        this.element.find('.code-actions .code-action').listen('click', function(e){
            var action = e.target.attr('code-action');
            if( typeof this.codeActions[action] == 'function' ){
                this.codeActions[action].call(this, e.target);
            }
        }.bind(this))

        this.element.find('.page-editor-actions .page-editor-action').listen('click', function(e){
            var action = e.target.attr('page-editor-action');

            if( typeof this.editorActions[action] == 'function' ){
                this.editorActions[action].call(this, e.target);
            }
        }.bind(this))


    }
});

var pa = new Scope.widgets.PageEditor( document.findOne('#w0-page-editor') );


</script>
