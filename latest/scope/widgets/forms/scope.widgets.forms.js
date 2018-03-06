window['Form'] = window['Scope']['widgets']['Form'] = function( element ){
    this.element = element;

    this.element.listen('submit', function(e){
        this.element.attr('submitted', 'true');
        this.element.attr('novalidate', null);
        if( !this.element.checkValidity() ){
            e.preventDefault();
        } else if( this.element.attr('ajax-submit') ) {
            e.preventDefault();
            var event = this.element.dispatch('beforeajax');
            if( event.defaultPrevented == false ){

                var url = location.href;
                if( this.element.attr('action') ){
                    url = this.element.attr('action');
                }

                Scope.post({
                    url: url,
                    data: this.element.serialize(),
                    dataType: 'json',
                    responseType: 'json',
                    onsuccess: function( xhr ){
                        this.element.dispatch( 'afterajax', {
                            xhr: xhr
                        } );
                    }.bind(this),
                    onerror: function( err ){
                        console.log('could not submit');
                    }
                })
            }

        }
    }.bind(this));
}



extend( HTMLFormElement ).with({
    toFormData: function(){
        var fd = new FormData();
        this.elements.forEach( function(el){
            fd.append( el.name, el.value );
        } );
        return fd;
    },
    serialize: function(){
        var data = {};
        this.elements.forEach( function(el){
            if( !( el.tagName.toLowerCase() == 'button' ) ){
                data[ el.name ] = el.value;
            }
        } );
        return data;
    }
});

extend(HTMLFormControlsCollection).with({

})
