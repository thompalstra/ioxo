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

    .page-editor .page-editor-action input{
        height: 50px;
        width: 200px;
        padding: 0 10px;
        margin: 0 10px;
        border: 0;
        background-color: #f2f2f2;
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

    .page-editor iframe{
        width: 100%;
        height: 100%;
    }

    .page-editor .code textarea{
        height: calc( 100% - 50px );
        width: 100%;
    }

    .page-editor textarea{
        background-color: #333;
        color: #f2f2f2;
        resize: none;
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

    .page-editor[mode="code"] #c2-tr2{
        display: none;
    }
    .page-editor[mode="content"] #c2-tr1{
        display: none;
    }
    .page-editor[mode="content"] #w1-split-container-2 .splitter,
    .page-editor[mode="code"] #w1-split-container-2 .splitter{
        display: none;
    }

    .split-container[resizing] td,
    .split-container[resizing] tr,
    .split-container[resizing] iframe,
    .split-container[resizing] [contenteditable]{
        pointer-events: none;
    }
</style>

    <form method='POST' id='w0-form' style='margin-bottom: 0;'>
        <div id='w0-page-editor' class='page-editor' mode='code'>
            <ul class='page-editor-actions'>
                <li class='page-editor-action' page-editor-action='save' icon='save'></li>
                <li class='page-editor-action' page-editor-action='modeCode' icon='code'></li>
                <li class='page-editor-action' page-editor-action='modeBoth' icon='create'></li>
                <li class='page-editor-action' page-editor-action='modeContent' icon='pageview'></li>
                <li class='page-editor-action'>
                    <?php foreach( Scope::$app->_language->supported as $lang ) { ?>
                        <input title="This page's title" name='Page[title][<?=$lang?>]' value='<?=$model->title[$language]?>'  class='<?=( ( $lang !== $language ) ? "hidden" : "" )?>'/>
                    <?php } ?>
                </li>
                <li class='page-editor-action'>
                    <?php foreach( Scope::$app->_language->supported as $lang ) { ?>
                        <input title="This page's url" name='Page[url][<?=$lang?>]' value='<?=$model->url[$language]?>'  class='<?=( ( $lang !== $language ) ? "hidden" : "" )?>'/>
                    <?php } ?>
                </li>
            </ul>
            <table id='w0-split-container-1' class='split-container' style='height: calc( 100% - 50px ); width: 100%'>
                <tr class='row'>
                    <td id='c1-td1' class='column' width=200>
                        <table id='w1-split-container-2' class='split-container' height=100% width=100%>
                            <!-- <tr height="50%"> -->
                            <tr id='c2-tr1' class='row'>
                                <td id='c2-td1' class='column'>
                                    <div class='code'>
                                        <ul class='code-actions'>
                                            <li class='code-action' code-action='toggleTextWrap' icon='wrap_text'></li>
                                        </ul>
                                        <?php foreach( Scope::$app->_language->supported as $lang ) {
                                            $content = $model->content[$lang];
                                            $name = "Page[content][$lang]";
                                            $class = ( $lang !== $language ) ? "hidden" : "";
                                            echo "<textarea name='$name' class='$class'>$content</textarea>";
                                        } ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class='splitter horizontal' height=10>
                                <td></td>
                            </tr>
                            <tr id='c2-tr2' class='row'>
                                <td id='c2-td2' class='column'>
                                    <div class='content'>
                                        <div contenteditable="true">
                                            <?=$model->content[$lang]?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class='splitter vertical' width=10>
                    </td>
                    <td id='c1-td2' class='column'>
                        <iframe id='iframe' src="http://ioxo.nl/scope-cms-page/scope-cms-page-preview?id=<?=$model->id?>&language=<?=$language?>" frameborder=0></iframe>
                    </td>
                </tr>
            </table>
        </div>
    </form>
<script>



window['PageEditor'] = window['Scope']['widgets']['PageEditor'] = function( element ){
    this.element = element;

    var splitContainer = new Scope.widgets.SplitContainer( document.findOne('#w0-split-container-1') );
    var splitContainer2 = new Scope.widgets.SplitContainer( document.findOne('#w1-split-container-2') );

    document.findOne('#w0-split-container-1').listen('afterresize', this.savePanelSizes );
    document.findOne('#w1-split-container-2').listen('afterresize', this.savePanelSizes );

    this.registerListeners();
    this.restoreScrolling();
    this.restorePanelSizes();
}

extend( window['PageEditor'] ).with({
    restorePanelSizes: function(){
        sc("tr.row").forEach(function(el){
            var id = el.id;
            if( id ){
                var saved = JSON.parse( localStorage.getItem( el.id ) );
                if( saved ){
                    el.setAttribute('height', saved.offsetHeight);
                }
            }
        })
        sc("td.column").forEach(function(el){
            var id = el.id;
            if( id ){
                var saved = JSON.parse( localStorage.getItem( el.id ) );
                if( saved ){
                    el.width = saved.offsetWidth;
                    console.log( el, saved, el.offsetWidth );
                }
            }
        })

        var mode = localStorage.getItem('mode');

        if( mode ){
            switch( mode ){
                case 'code':
                    this.editorActions.modeCode.call( this, null );
                break;
                case 'both':
                    this.editorActions.modeBoth.call( this, null );
                break;
                case 'content':
                    this.editorActions.modeContent.call( this, null );
                break;
            }
        }
    },
    savePanelSizes: function(){
        sc("tr.row").forEach(function(el){
            var id = el.id;
            if( id ){
                localStorage.setItem( id, JSON.stringify( {
                    offsetHeight: el.offsetHeight
                } ) );
            }
        })
        sc("td.column").forEach(function(el){
            var id = el.id;
            if( id ){
                localStorage.setItem( id, JSON.stringify( {
                    offsetWidth: el.offsetWidth
                } ) );
            }
        })
    },
    editorActions: {
        save: function(){
             document.findOne('#w0-form').submit();
        },
        modeCode: function(e){
            this.element.attr('mode', 'code');
            localStorage.setItem('mode',  'code');
        },
        modeBoth: function(e){
            this.element.attr('mode', 'both');
            localStorage.setItem('mode',  'both');
        },
        modeContent: function(e){
            this.element.attr('mode', 'content');
            localStorage.setItem('mode',  'content');
        }
    },
    restoreScrolling: function(){
        sc("[name^='Page[content]']").forEach(function(el){
            el.onscroll = function(e){
                localStorage.setItem( 'scroll_' + el.name, el.scrollTop );
            }
            el.scrollTop = localStorage.getItem( 'scroll_' + el.name );
        })
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
