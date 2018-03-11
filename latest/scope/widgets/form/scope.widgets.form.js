window['Form'] = window['Scope']['widgets']['Form'] = function( element ){
    this.element = element;
    this.validateOnInput = false
    this.validateOnChange = false;
    this.ajax = false;

    if( typeof this.element.attr('data-validate-on-input') === 'string' ){
        this.validateOnInput = true;
    }

    if( typeof this.element.attr('data-validate-on-change') === 'string' ){
        this.validateOnChange = true;
    }

    if( typeof this.element.attr('data-ajax') === 'string' ){
        this.ajax = true;
    }

    this.registerListeners();
}

extend( Form ).with({
    registerListeners: function(){
        if( this.ajax ){
            this.element.on('submit', function( event ){
                event.preventDefault();
                var beforeajax = this.element.do('beforeajax');
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
                            this.element.do( 'afterajax', {
                                xhr: xhr
                            } );
                        }.bind(this),
                        onerror: function( err ){
                            this.element.do( 'afterajax', {
                                xhr: xhr
                            } );
                        }.bind(this)
                    });
                }
            }.bind(this));
        }

        var on = [];

        if( this.validateOnInput ){
            on.push('input');
        }
        if( this.validateOnChange ){
            on.push('change');
        }



        if( on.length > 0 ){
            on = on.join(' ');
            this.element.on(on, '*', function(event){
                if( !this.checkValidity() ){
                    this.attr('data-error', '');
                    this.attr('data-no-error', null);
                } else {
                    this.attr('data-error', null);
                    this.attr('data-no-error', '');
                }
            })
        }

        this.element.find('input[type="search"][search-for]').on('input', function(e){
            var target = sc( this.attr('search-for'), true);
            search = this.value.toLowerCase();
            if( target ){
                target.find('[data-search-value]').forEach(function(el){
                    var value = el.attr('data-search-value').toLowerCase();
                    console.log( value.indexOf( search ) );
                    if( value.indexOf( search ) != -1 ){
                        console.log('showing', el);
                        el.show();
                    } else {
                        el.hide();
                    }
                })
            }
        });
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
