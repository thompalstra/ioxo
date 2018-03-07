window['Form'] = window['Scope']['widgets']['Form'] = function( element ){
    this.element = element;

    this.registerListeners();
}

extend( Form ).with({
    registerListeners: function(){
        if( this.element.attr('data-ajax') == true ){
            this.element.listen('submit', function( event ){
                event.preventDefault();
                var beforeajax = this.element.dispatch('beforeajax');
                if( !beforeajax.defaultPrevented ){
                    var url = location.href;

                    if( typeof this.element.attr('action') == 'string' ){
                        url = this.element.attr('action');
                    }

                    var data = this.element.serialize();

                    Scope.post({
                        url: url,
                        dataType: 'json',
                        responseType: 'json',
                        data: data,
                        onsuccess: function( xhr ){
                            this.element.dispatch( 'afterajax', {
                                xhr: xhr
                            } );
                        }.bind(this),
                        onerror: function( err ){
                            this.element.dispatch( 'afterajax', {
                                xhr: xhr
                            } );
                        }.bind(this)
                    });
                }
            }.bind(this));
        }
    }
})

extend( HTMLFormElement ).with({
    serialize: function(){
        var data = {};
        this.elements.forEach(function(el){
            if( el.tagName.toLowerCase() != 'button' ){
                data[ el.name ] = el.value;
            }

        });
        return data;
    }
})
