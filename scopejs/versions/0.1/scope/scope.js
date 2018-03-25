let extend;
let define;

let doc = document;
let webComponents = document.webComponents = {};
let body = document.body;
let head = document.head;

document.addEventListener( 'DOMContentLoaded', function( event ){
    document.dispatchEvent( new CustomEvent( 'loaded' ) );
} );

extend = function(){
    return {
        arg: arguments,
        with: function( obj ){
            for( var i in this.arg ){
                var x = ( typeof this.arg[i].prototype == 'undefined' ) ? this.arg[i] : this.arg[i].prototype;
                for( var i in obj ){
                    x[i] = obj[i];
                }
            }
        }
    }
}
define = function( tag, options ){
    if( typeof customElements == 'undefinde' ){
        document.createElement( tag, options );
    } else {
        customElements.define( tag, options );
    }
}

extend( Document, HTMLElement ).with({
    one: function( q ){
        return this.querySelector( q );
    },
    all: function( q ){
        return this.querySelectorAll( q )
    },
    on: function( eventTypes, b, c, d ){
        eventTypes.split(' ').forEach(function(eventType){
            // target.on( eventType, callback, options );
            // target.on( eventType, targets, callback, options );
            if( typeof b === 'function' ){
                if( typeof c === 'undefined' ){
                    c = true;
                }
                this.addEventListener( eventType, b, c );
            } else if( typeof b === 'string' ){
                if( typeof d === 'undefined' ){
                    d = true;
                }
                this.addEventListener( eventType, function( originalEvent ){
                    if( event.target.matches( b ) ){
                        event.target.do( eventType, originalEvent );
                        if( originalEvent.defaultPrevented ){
                            return;
                        }
                    } else if( ( d == true || d.capture == true ) && closest == event.target.closest( b ) ){
                        closest.do( eventType, originalEvent );
                        if( originalEvent.defaultPrevented ){
                            return;
                        }
                    }
                } );
            }
        }.bind(this));
    },
    do: function( eventType, options ){
        var customEvent = new CustomEvent( eventType, options );
        this.dispatchEvent( customEvent );
        return customEvent;
    }
})

extend( Document ).with({
    make: function( tag, options ){
        var el = document.createElement( tag );
        if( typeof options === 'object' ){
            for(var i in options){
                if( typeof el[i] !== 'undefined' ) {
                    el[i] = options[i];
                } else {
                    el.setAttribute(i, options[i]);
                }
            }
        }
        return el;
    }
})
