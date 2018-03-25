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

doc.webComponents.idb = new Idb();
doc.webComponents.idb.settings = new IdbComponent( 'user.settings', function(e){ } );
