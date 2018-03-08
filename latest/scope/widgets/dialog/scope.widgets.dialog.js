window['Dialog'] = window['Scope']['widgets']['Dialog'] = function( element ){
    this.element = element;

    if( this.element.attr('data-backdrop') == true ){
        var backdrop = this.element.parentNode.insertBefore( document.create( 'backdrop', {}) , this.element.nextSibling);

        if( this.element.attr('data-backdrop-dismiss') == true ){
            backdrop.listen('click', function(e){
                this.element.dispatch( 'dismiss' );
            }.bind(this));
        }
    }

    this.registerListeners();
}

extend( Dialog ).with({
    registerListeners: function(){
        this.element.listen('show', function(e){
            this.show();
        }.bind(this));
        this.element.listen('dismiss', function(e){
            this.dismiss();
        }.bind(this));
        this.element.listen('ok', function(e){
            console.log('native ok');
            this.dismiss();
        }.bind(this));
        this.element.listen('toggle', function(e){
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
