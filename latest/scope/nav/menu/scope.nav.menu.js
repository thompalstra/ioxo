window['Nav'] = window['Scope']['nav']['Menu'] = function( element ){
    this.element = element;

    this.element.listen('click', 'li[is-dropdown]', function(e){
        if( typeof this.attr('show') == 'string' ){
            this.attr('show', null);
            this.find('[show]').forEach(function(el){
                el.attr('show', null);
            })
        } else {
            this.attr('show', '');
        }
    });
}

extend( Nav ).with({

});

document.listen('click', '*', function(e){
    if( !e.target.closest('[is-dropdown]') ){
        document.find('.nav-menu li[show]').forEach(function(el){
            el.attr('show', null);
        })
    }
})
