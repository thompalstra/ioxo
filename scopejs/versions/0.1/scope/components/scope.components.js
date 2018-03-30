class Idb{
    constructor(){
        this.db;
        this.objectStore;
        this.indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB;
        this.IDBTransaction = window.IDBTransaction || window.webkitIDBTransaction || window.msIDBTransaction || {READ_WRITE: "readwrite"}; // This line should only be needed if it is needed to support the object's constants for older browsers
        this.IDBKeyRange = window.IDBKeyRange || window.webkitIDBKeyRange || window.msIDBKeyRange;
    }
    connect( storeName, version, onsuccess, onerror ){
        var request = this.indexedDB.open( storeName, version );
        request.onerror = function(event) {
            onerror.call( window, event.target.errorCode );
        }.bind(this);
        request.onupgradeneeded = function(event) {
            this.db = event.target.result;
            this.objectStore = this.db.createObjectStore( storeName, { keyPath: 'id' });
        };
        request.onsuccess = function(event) {
            this.db = event.target.result;
            onsuccess.call( window, this );
        }.bind(this);
    }
}

class IdbComponent{
    constructor( storeName, callback ){
        this.idb = new Idb();
        this.storeName = storeName;
        this.idb.connect( storeName, 1, function(data){

            this.db = data;
            this.all(function(data){
                if( data.length > 0 ){
                    data.forEach(function(x){
                        Object.defineProperty( this, x.id, {
                            value: x.value,
                            readable: true,
                            writable: true,
                            enumerable: true
                        } );
                    }.bind(this));
                }
                callback.call( this, data );
            }.bind(this));
        }.bind(this));
    }
    createTransaction(){
        return this.db.db.transaction([ this.storeName ], "readwrite");
    }
    get( id, onsuccess ){
        this.createTransaction().objectStore( this.storeName ).get( id ).onsuccess = function( event ){
            onsuccess.call( this, event.target.result )
        };
    }
    all( onsuccess ){
        this.createTransaction().objectStore( this.storeName ).getAll().onsuccess = function( event ){
            onsuccess.call( this, event.target.result )
        };
    }
    add( data, onsuccess ){
        if( !data.hasOwnProperty('id') ){
            alert('An ID is required');
        }
        this.createTransaction().objectStore( this.storeName ).add( data ).onsuccess = function( event ){
            onsuccess.call( this, event.target.result )
        };
    }
    put( data, onsuccess ){
        if( !data.hasOwnProperty('id') ){
            alert('An ID is required');
        }
        this.createTransaction().objectStore( this.storeName ).put( data ).onsuccess = function( event ){
            if( typeof onsuccess === 'function' ){
                onsuccess.call( this, event.target.result )
            }
        };
    }
    delete( identifier, onsuccess ){
        this.createTransaction().objectStore( this.storeName ).delete( identifier ).onsuccess = function( event ){
            onsuccess.call( this, true )
        };
    }
    save( callback ){
        var keys = Object.keys( this );
        (function put( i ){
            if( i < keys.length ){
                var index = keys[i];
                if( [ 'idb', 'db', 'storeName' ].indexOf( index ) !== -1 ){
                     put.call( this, ++i );
                } else {
                    this.setItem( index, this[index], function(data){
                        put.call( this, ++i );
                    }.bind(this) )
                }
            } else {
                callback.call( this, null );
            }
        }.bind(this))(0);
    }
    setItem( id, value, callback ){
        this[id] = value;
        this.put( {
            id: id,
            value: value
        }, callback);
    }
    getItem( key ){
        return this.get( key );
    }
}

//doc.customComponents.idb = new Idb();
//doc.customComponents.idb = new IdbComponent( 'user.settings', function(e){ } );

const COMPONENT_STATE_CONNECTING = 0;
const COMPONENT_STATE_CONNECTED = 1;
const COMPONENT_STATE_INTERMEDIATE = 2;
const COMPONENT_STATE_LOADING = 3;
const COMPONENT_STATE_DONE = 4;
const COMPONENT_STATE_NAMES = ['connected', 'connecting', 'intermediate', 'loading', 'done'];

class ScopeComponent{
    constructor( element ){
        this.state = COMPONENT_STATE_CONNECTING;
        if( element instanceof HTMLElement ){
            this.element = element;
            this.state = COMPONENT_STATE_CONNECTED;
            this.state = COMPONENT_STATE_LOADING;
        } else {
            console.warn( 'invalid argument supplied for constructor: expecting argument of type HTMLElement' );
        }
    }
    set state( value ){
        this._state = value;
        this.readystatechange.call(this, value);
        this[  COMPONENT_STATE_NAMES[value]].call(this, null);
    }
    get state(  ){
        return this._state;
    }

    connecting(){ }
    connected(){ }
    loading(){ }
    done(){ }
    readystatechange( state ){ }
}

class ScopeTabsComponent extends ScopeComponent{
    connecting(){ }
    connected(){ }
    loading(){ }
    done(){
        this.controls = this.element.one('.controls');
        this.controls.children.forEach( ( node ) => {
            node.on( 'click', ( e ) => {
                this.showTab( node.dataset.target );
            } )
        } )
        this.content = this.element.one('.content');
        this.activeTab = ( this.element.dataset.tab ? this.element.dataset.tab : this.controls.children[0].dataset.target );
        this.showTab.call( this, this.activeTab );
    }
    readystatechange( state ){ }

    showTab( querySelector ){
        this.controls.children.forEach( ( node ) => {
            if( node.matches( '[data-target="'+querySelector+'"]' ) ){
                node.classList.add('active');
            } else {
                node.classList.remove('active');
            }
        } )
        this.content.children.forEach( ( node ) => {
            if( node.matches( querySelector ) ){
                node.classList.add('active');
            } else {
                node.classList.remove('active');
            }
        } )
    }
}
class ScopeDialogComponent extends ScopeComponent{
    connecting(){ }
    connected(){ }
    loading(){ }
    done(){ }
    readystatechange( state ){ }
}
class ScopePopoverComponent extends ScopeComponent{
    connecting(){ }
    connected(){ }
    loading(){ }
    done(){ }
    readystatechange( state ){ }
}
class ScopeNotificationComponent extends ScopeComponent{
    connecting(){ }
    connected(){ }
    loading(){ }
    done(){ }
    readystatechange( state ){ }
}

extend( Scope ).with({
    tabs: ScopeTabsComponent,
    dialog: ScopeDialogComponent,
    popover: ScopePopoverComponent,
    notification: ScopeNotificationComponent
}, true);

const MUTATION_TYPE_CHILDLIST = 'childList';

const ELEMENT_NODE = 1;
const ATTRIBUTE_NODE = 2;
const TEXT_NODE = 3;
const SCOPE_COMPONENT_QUERY = 'sc-component';
const SCOPE_COMPONENT_ATTRIBUTE = 'data-component';

new MutationObserver(function(mutations){
    mutations.forEach(function(mutation){
        if( mutation.type == MUTATION_TYPE_CHILDLIST ){
             mutation.addedNodes.forEach(function(node){
                 if( node.nodeType === ELEMENT_NODE && node.matches( SCOPE_COMPONENT_QUERY + "[" + SCOPE_COMPONENT_ATTRIBUTE + "]" ) ){
                     var split = node.getAttribute( SCOPE_COMPONENT_ATTRIBUTE ).split('.');
                     var instance = null;

                     for(var i in split){
                        if( instance === null && typeof window[ split[i] ] == 'function' ){
                            instance = window[ split[i] ];
                        } else if( instance !== null && typeof instance[ split[i] ] == 'function' ) {
                            instance = instance[ split[i] ];
                        } else {
                            console.error( node.getAttribute( SCOPE_COMPONENT_ATTRIBUTE ) + " is not a valid constructor." );
                            break;
                        }
                     }
                     doc.customComponents[ ( node.id.length > 0 ) ? node.id : node.uniqid() ] = new instance( node );
                 }
             })
        }
    });
}).observe(document, { attributes: true, childList: true, subtree: true } );

doc.on('DOMContentLoaded', function(event){
    for( var i in doc.customComponents ){
        doc.customComponents[i].state = COMPONENT_STATE_DONE;
    }
})
