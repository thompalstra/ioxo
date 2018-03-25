class HTMLScopeElement extends HTMLElement{
    constructor(){
        super();
    }

    get show(){
        return this.dataset.show || false;
    }
    set show( value ){
        this.dataset.show = value;
    }
}

class HTMLScopeAppElement extends HTMLScopeElement{

}
class HTMLScopeViewElement extends HTMLScopeElement{
    constructor(){
        super();

        this.xhr = null;
    }
    connectedCallback(){
        if( this.src ){
            this.loadHTML()
        }
    }

    loadHTML(){
        if( this.xhr === null ){
            var beforeLoadEvent = new CustomEvent( 'loading', {bubbles: false, cancelable: true } );
            this.dispatchEvent( beforeLoadEvent );
            if( !beforeLoadEvent.defaultPrevented ){
                this.xhr = new XMLHttpRequest();
                this.xhr.open( 'GET', this.src );
                this.xhr.responseType = 'document';
                this.xhr.onreadystatechange = function( event ){
                    if( this.xhr.readyState == 4 && this.xhr.status == 200 ){
                        this.innerHTML = this.xhr.response.head.innerHTML + this.xhr.response.body.innerHTML;
                        if( typeof this.evalJs == 'string' ){
                            this.all( 'script' ).forEach( (script) => {
                                eval( script.innerHTML );
                            } )
                        }
                        this.xhr = null;
                        var afterLoadEvent = new CustomEvent( 'loaded', {bubbles: false, cancelable: true } );
                        afterLoadEvent.preventDefault();
                        this.dispatchEvent( afterLoadEvent );
                    }
                }.bind(this);
                this.xhr.onerror = function( err ){
                    this.xhr = null;
                }
                this.xhr.send();
            }
        }
    }
    get src (){
        return this.getAttribute( 'src' );
    }
    set src( value ){
        this.setAttribute( 'src', value );
        if( value.length > 0 ){
            this.loadHTML();
        }
    }
    get evalJs (){
        return this.getAttribute('data-eval-js');
    }
    set evalJs( value ){
        this.setAttribute( 'data-eval-js', value );
    }
}

define( 'scope-app', HTMLScopeAppElement );
define( 'scope-view', HTMLScopeViewElement );
