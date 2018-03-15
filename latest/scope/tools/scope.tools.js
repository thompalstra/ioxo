window['PopOver'] = window['Scope']['tools']['PopOver'] = function( element ){
    this.element = element;

    this.registerElements();
    this.registerGetSet();
    this.registerListeners();
}

extend( PopOver ).with({
    registerElements: function(){
        this.pop = this.element.appendChild( document.create('div', {
            className: 'pop'
        }) );

        if( typeof this.element.attr('data-mast') == 'string' ){
            this.mastElement = this.pop.appendChild( document.create( 'div', {
                className: 'mast',
                style: "background-image: url( " + this.element.attr('data-mast-image') + ')'
            } ) );

            this.mastContent = this.mastElement.appendChild( document.create( 'div', {
                className: 'content',
                innerHTML: this.element.attr('data-mast-content')
            } ) );
        }

        if( typeof this.element.attr('data-title') == 'string' ){
            this.titleElement = this.pop.appendChild( document.create( 'div', {
                className: 'title',
                innerHTML: this.element.attr('data-title')
            } ) );
        }

        if( typeof this.element.attr('data-content') == 'string' ){
            this.contentElement = this.pop.appendChild( document.create( 'div', {
                className: 'content',
                innerHTML: this.element.attr('data-content')
            } ) );
        }
    },
    registerGetSet: function(){
        Object.defineProperty( this, 'title', { get: this.getTitle, set: this.setTitle } );
        Object.defineProperty( this, 'content', { get: this.getContent, set: this.setContent } );
        Object.defineProperty( this, 'actions', { get: this.getActions, set: this.setActions } );
    },

    registerListeners: function(){

    }
})

document.on( 'click', '.sc-checkbox input[type="checkbox"]', function(e){
    this.attr('checked', this.checked );
})
