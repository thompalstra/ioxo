window['Dialog'] = window['Scope']['widgets']['Dialog'] = function( element ){
    this.element = element;
    this.registerElements();
    this.registerGetSet();
    this.registerAttributes();
    this.registerListeners();
}



extend( Dialog ).with({
    registerElements: function(){
        this._title = this.element.findOne('.title');
        this._content = this.element.findOne('.content');
        this._actions = this.element.findOne('.actions');
    },
    registerGetSet: function(){
        Object.defineProperty( this, 'title', { get: this.getTitle, set: this.setTitle } );
        Object.defineProperty( this, 'content', { get: this.getContent, set: this.setContent } );
        Object.defineProperty( this, 'actions', { get: this.getActions, set: this.setActions } );
    },
    registerAttributes(){
        if( this.element.attr('data-backdrop') == true ){
            var backdrop = this.element.parentNode.insertBefore( document.create( 'backdrop', {}) , this.element.nextSibling);

            if( this.element.attr('data-backdrop-dismiss') == true ){
                backdrop.on('click', function(e){
                    this.element.do( 'dismiss' );
                }.bind(this));
            }
        }
    },
    registerListeners: function(){
        this.element.on('show', function(e){
            this.show();
        }.bind(this));
        this.element.on('dismiss', function(e){
            this.dismiss();
        }.bind(this));
        this.element.on('ok', function(e){
            console.log('native ok');
            this.dismiss();
        }.bind(this));
        this.element.on('toggle', function(e){
            this.toggle();
        }.bind(this));
    },
    show: function( e ){
        document.body.style['overflow'] = 'hidden';
        this.element.attr( 'show', '' );
    },
    dismiss: function( e ){
        document.body.style['overflow'] = '';
        this.element.attr( 'show', null );
    },
    toggle: function( ){
        if( typeof this.element.attr('show') == 'string' ){
            this.dismiss();
        } else {
            this.show();
        }
    },
    load: function( url ){
        this.element.load(url);
    },
    getTitle: function() {
        return ( this._title ) ? this._title.innerHTML : null;
    },
    setTitle: function(value){
        return ( this._title ) ? ( this._title.innerHTML = value ) : null;
    },
    getContent: function(){
        return ( this._content ) ? this._content.innerHTML : null;
    },
    setContent: function(value){
        return ( this._content ) ? ( this._content.innerHTML = value ) : null;
    },
    getActions: function(){
        return ( this._actions ) ? this._actions.innerHTML : null;
    },
    setActions: function(value){
        return ( this._actions ) ? ( this._actions.innerHTML = value ) : null;
    }
});
