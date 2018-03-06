window['Popover'] = window['Scope']['tools']['Popover'] = function( element ){
    this.element = element;
    this.pop;


    this.create();
}

extend( Popover ).with({
    create: function(){

        this.element.find('.pop').forEach(function(el){
            el.remove();
        })

        this.popover = this.element.appendChild( document.create( 'div', {
            className: 'pop'
        } ) );

        if( this.element.attr('pop-title') ){
            this.popover.appendChild( document.create( 'h4', {
                className: 'title',
                innerHTML: this.element.attr('pop-title')
            } ) )
        }

        if( this.element.attr('pop-content') ){
            this.popover.appendChild( document.create( 'div', {
                className: 'content',
                innerHTML: this.element.attr('pop-content')
            } ) )
        }
    },
});
