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
    .page-editor .split-container .column{
        position: relative;
        padding: 0;
    }
    .page-editor .split-container .inner{
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
    }

    .page-editor .split-container .inner iframe#iframe{
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        height: 100%;
        width: 100%;
    }

    .page-editor .page-editor-actions,
    .page-editor .code-actions{
        list-style: none;
        padding: 0;
        margin: 0;
        /* height: 50px; */
    }

    .page-editor .page-editor-actions{
        height: 50px;
    }

    .page-editor .code-actions{
        height: 25px;
    }

    .page-editor .page-editor-action,
    .page-editor .code-action{
        min-width: 50px;
        height: 50px;
        line-height: 50px;
        display: inline-block;
        float: left;
        color: #ddd;
        box-sizing: border-box;
    }

    .page-editor .page-editor-action.in,
    .page-editor .code-action.in{
        background-color: #ddd;
        color: #111;
    }

    .page-editor .page-editor-action input{
        height: 25px;
        width: 200px;
        padding: 0 10px;
        margin: 12.5px 10px;
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

    .page-editor .code textarea{
        height: calc( 100% - 25px );
        width: 100%;
        border: 0;
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

    .page-editor .page-editor-action[icon][page-editor-action="save"]:after{
        background-color: green;
        color: white;
    }

    .page-editor-action[page-editor-action="modeCode"],
    .page-editor-action[page-editor-action="modeBoth"],
    .page-editor-action[page-editor-action="modeContent"]{
        margin: 12.5px 0;
        height: 25px;
        line-height: 25px;
        border: 1px solid #ddd;
    }
    .page-editor .page-editor-action[icon][page-editor-action="modeCode"]:after,
    .page-editor .page-editor-action[icon][page-editor-action="modeBoth"]:after,
    .page-editor .page-editor-action[icon][page-editor-action="modeContent"]:after{
        line-height: 25px;
        height: 25px;
        width: 50px;
    }
    .page-editor .page-editor-action[icon][page-editor-action="modeCode"]{
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        border-right: 0;
        margin-left: 12.5px;
    }
    .page-editor .page-editor-action[icon][page-editor-action="modeContent"]{
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        border-left: 0;
        margin-right: 12.5px;
    }
    .page-editor .code-action{
        height: 25px;
        line-height: 25px;
    }

    .page-editor .code-action[icon]:after{
        height: 25px;
        line-height: 25px;
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
                                    <div class='inner'>
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
                                    </div>
                                </td>
                            </tr>
                            <tr class='splitter horizontal' height=10>
                                <td></td>
                            </tr>
                            <tr id='c2-tr2' class='row'>
                                <td id='c2-td2' class='column'>
                                    <div class='inner'>
                                        <div class='content'>
                                            <div contenteditable="true">
                                                <?=$model->content[$lang]?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class='splitter vertical' width=10>
                    </td>
                    <td id='c1-td2' class='column'>
                        <div class='inner'>
                            <iframe id='iframe' src="http://ioxo.nl/scope-cms-page/scope-cms-page-preview?id=<?=$model->id?>&language=<?=$language?>" frameborder=0></iframe>
                        </div>
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

    document.findOne('#w0-split-container-1').on('afterresize', this.savePanelSizes );
    document.findOne('#w1-split-container-2').on('afterresize', this.savePanelSizes );

    this.registeroners();
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
            this.element.find('[page-editor-action="modeCode"]').forEach(function(el){
                el.addClass('in');
            });
            this.element.find('[page-editor-action="modeBoth"]').forEach(function(el){
                el.removeClass('in');
            });
            this.element.find('[page-editor-action="modeContent"]').forEach(function(el){
                el.removeClass('in');
            });
        },
        modeBoth: function(e){
            this.element.attr('mode', 'both');
            localStorage.setItem('mode',  'both');
            this.element.find('[page-editor-action="modeCode"]').forEach(function(el){
                el.removeClass('in');
            });
            this.element.find('[page-editor-action="modeBoth"]').forEach(function(el){
                el.addClass('in');
            });
            this.element.find('[page-editor-action="modeContent"]').forEach(function(el){
                el.removeClass('in');
            });
        },
        modeContent: function(e){
            this.element.find('[page-editor-action="modeCode"]').forEach(function(el){
                el.removeClass('in');
            });
            this.element.find('[page-editor-action="modeBoth"]').forEach(function(el){
                el.removeClass('in');
            });
            this.element.find('[page-editor-action="modeContent"]').forEach(function(el){
                el.addClass('in');
            });
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
    registeroners: function(){
        if( localStorage.getItem( 'code_text_wrap' ) == 'true' ){
            this.element.attr('code-text-wrap', '1')
            this.element.find('[code-action="toggleTextWrap"]').forEach(function(el){

                el.addClass('in');
            });

        }

        this.element.on('keydown', function(e){
            if( e.ctrlKey == true && e.keyCode == 83 ){
                e.preventDefault();
                var textarea = this.element.findOne('textarea');
                this.editorActions['save'].call(this, e.target);
            }
        }.bind(this));
        this.element.find('[contenteditable="true"]').on('input', function(e){
            var textarea = this.closest('#w0-page-editor').findOne('.code textarea:not(.hidden)');
            textarea.innerHTML = this.innerHTML;
        });

        this.element.find('.code-actions .code-action').on('click', function(e){
            var action = e.target.attr('code-action');
            if( typeof this.codeActions[action] == 'function' ){
                this.codeActions[action].call(this, e.target);
            }
        }.bind(this))

        this.element.find('.page-editor-actions .page-editor-action').on('click', function(e){
            var action = e.target.attr('page-editor-action');

            if( typeof this.editorActions[action] == 'function' ){
                this.editorActions[action].call(this, e.target);
            }
        }.bind(this))


    }
});

var pa = new Scope.widgets.PageEditor( document.findOne('#w0-page-editor') );


</script>
