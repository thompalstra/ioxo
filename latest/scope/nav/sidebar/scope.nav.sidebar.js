window['Sidebar'] = window['Scope']['nav']['Sidebar'] = function( element ){
    this.element = element;

    this.element.listen('toggle', function(e){
        this.toggle( this.element.attr('speed') );
    }.bind(this));
    this.element.listen('hide', function(e){
        this.hide( this.element.attr('speed') );
    }.bind(this));
    this.element.listen('show', function(e){
        this.show( this.element.attr('speed') );
    }.bind(this));

    this.element.listen('click', 'li', function(e){
        if( this.matches('[is-dropdown]') ){
            if( typeof this.attr('show') == 'string' ){
                this.attr('show', null);
            } else {
                this.attr('show', '');
            }
        }
    });

    if( this.element.attr('data-backdrop') == true ){
        var backdrop = this.element.parentNode.insertBefore( document.create( 'backdrop', {}) , this.element.nextSibling);
        backdrop.listen('click', function(e){
            this.element.dispatch( 'dismiss' );
        }.bind(this));
    }

    this.element.listen( 'dismiss', function(e){
        this.dismiss();
    }.bind(this) );
    this.element.listen( 'show', function(e){
        this.show();
    }.bind(this) );
}

extend( Sidebar ).with({
    setSpeed: function( speedInMs ){
        speed = 1000;
        if( speedInMs ){
            speed = speedInMs;
        }
        this.element.style['transition-duration'] = speed + "ms";

        if( this.element.nextElementSibling.tagName.toLowerCase() == 'backdrop' ){
            this.element.nextElementSibling.style['transition-duration'] = speed + "ms";
        }
    },
    toggle: function( speedInMs ){
        if( typeof this.element.attr('show') == 'string' ){
            this.dismiss( speedInMs );
        } else {
            this.show( speedInMs );
        }
    },
    dismiss: function( speedInMs ){
        this.setSpeed( speedInMs );
        this.element.attr('show', null);
    },
    show: function( speedInMs ){
        this.setSpeed( speedInMs );
        this.element.attr('show', '');

    }
})
