window['Form'] = window['Scope']['widgets']['Form'] = function( element ){
    this.element = element;
    this.validateOnInput = false
    this.validateOnChange = false;
    this.ajax = false;
    this.inline = false;

    if( typeof this.element.attr('data-validate-on-input') === 'string' ){
        this.validateOnInput = true;
    }

    if( typeof this.element.attr('data-validate-on-change') === 'string' ){
        this.validateOnChange = true;
    }

    if( typeof this.element.attr('data-ajax') === 'string' ){
        this.ajax = true;
    }

    if( typeof this.element.attr('data-inline') == 'string' ){
        this.inline = true;
    }

    this.registerListeners();
}

extend( Form ).with({
    registerListeners: function(){

        this.element.find('component').on('focusin mousedown click', function(e){
            this.attr('focusin', '');
            this.attr('focusout', null);
        })
        this.element.find('component').on('focusout', function(e){
            this.attr('focusin', null);
            this.attr('focusout', '');
        })


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
            this.search( e.target, sc( e.target.attr('search-for'), true), false );
        }.bind(this));
    }
})

extend( Form ).with({
    search: function( input, target, strict ){

        if( typeof strict == 'undefined' ){
            strict = false;
        }

        var filterValues = input.value.split(' ');
        target.querySelectorAll('[data-search-value]').forEach(function(el){
            var score = 0;
            for(var i in filterValues){
                if( strict === true ){
                    if( el.dataset.searchValue.indexOf( filterValues[i] ) != -1 ){
                        score++;
                    }
                } else {

                    if( el.dataset.searchValue.toLowerCase().indexOf( filterValues[i].toLowerCase() ) != -1 ){
                        score++;
                        console.log( el, score );
                    }
                }

                if( score == 0 ){
                    el.style['order'] = null;
                    el.classList.add('hidden');
                } else {
                    el.style['order'] = score;
                    el.classList.remove('hidden');
                }
            }
        });

        var count = target.querySelectorAll('[data-search-value]:not(.hidden)').length;

        if( count == 0 ){
            emptyMessage = target.findOne('.sc-empty-search-message');
            if( !( emptyMessage ) ){
                emptyMessage = target.appendChild( document.create( 'div', {
                    className: 'sc-empty-search-message'
                } ) );
            }

            console.log( emptyMessage );

            emptyMessage.innerHTML = target.dataset.emptyText;
        }
    },
});

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


window['InlineForm'] = window['Scope']['widgets']['InlineForm'] = function( element ){
    this.element = element;

    this.registerElements();
    this.registerGetSet();
    this.registerListeners();

    console.log('iunline');
}

extend( InlineForm ).with({
    registerElements: function(){

    },
    registerGetSet: function(){

    },
    registerListeners: function(){
        this.element.find('[contenteditable="true"]').on('focusin', function(e){
            console.log(e.type);
        });
        this.element.find('[contenteditable="true"]').on('focusout', function(e){
            console.log(e.type);
        });
    }
})
