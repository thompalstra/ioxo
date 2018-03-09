window['Dialog'] = window['Scope']['widgets']['Dialog'] = function( element ){
    this.element = element;

    if( this.element.attr('data-backdrop') == true ){
        var backdrop = this.element.parentNode.insertBefore( document.create( 'backdrop', {}) , this.element.nextSibling);

        if( this.element.attr('data-backdrop-dismiss') == true ){
            backdrop.on('click', function(e){
                this.element.do( 'dismiss' );
            }.bind(this));
        }
    }

    this.registerListeners();
}

extend( Dialog ).with({
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
        this.element.attr( 'show', '' );
    },
    dismiss: function( e ){
        this.element.attr( 'show', null );
    },
    toggle: function( ){
        if( typeof this.element.attr('show') == 'string' ){
            this.dismiss();
        } else {
            this.show();
        }
    }
});
