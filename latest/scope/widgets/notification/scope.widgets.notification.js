window['Notification'] = window['Scope']['widgets']['Notification'] = function( element ){
    this.element = element;
    this.timeout = 5000;
}

extend( Notification ).with({
    add: function( text, options ){

        var message = document.create('div', options );
        var element;
        if( this.element.hasClass('bottom') ){
            var lastNode;
            if( this.element.children.length > 1 ){
                lastNode = this.element.childNodes[ this.element.children.length - 1 ];
                element = this.element.insertBefore( message , lastNode.nextSibling);
            } else {
                element = this.element.appendChild( message );
            }
        } else {
            element = this.element.appendChild( message );
        }


        element.attr('data-content', text);
        element.attr('timeout', this.timeout);
        var nm = new Scope.widgets.NotificationMessage( element );
    },
    dismiss: function(){

    }
})

window['NotificationMessage'] = window['Scope']['widgets']['NotificationMessage'] = function( element ){
    this.element = element;
    this.timeout = parseFloat( element.attr('timeout') );

    this.element.appendChild( document.create( 'div', {
        className: 'content',
        innerHTML: this.element.attr('data-content')
    } ) );

    if( typeof this.element.attr('data-dismissable') == 'string' ){
        var dismiss = this.element.appendChild( document.create( 'div',{
            className: 'dismiss',
            innerHTML: '<i class="material-icons">&#xE5CD;</i>'
        } ) );

        dismiss.listen('click', function(e){
            this.dismiss( );
        }.bind(this))
    }

    this.element.timeout = setTimeout(function(e){
        this.dismiss( );
    }.bind(this), this.timeout );

    this.element.attr('height', this.element.offsetHeight);
}

extend( NotificationMessage ).with({
    dismiss: function(){
        this.element.addClass('dismiss');
        this.element.timeout = setTimeout( function(e){
            this.element.remove();
        }.bind(this), 2000 );
    }
})
