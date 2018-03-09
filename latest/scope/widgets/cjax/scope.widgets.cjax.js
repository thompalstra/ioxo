window['Cjax'] = window['Scope']['widgets']['Cjax'] = function( element ){
    this.element = element;
    this.url = null;
    this.allowJS = ( typeof this.element.attr('data-js') === 'string' );

    if( typeof this.element.attr('data-js') === 'string' ){
        this.allowJS = true;
    }

    this.element.on('beforeload', function(e){
        this.beforeload(e);
    }.bind(this));

    this.element.on('afterload', function(e){
        this.afterload(e);
    }.bind(this));

    if( typeof this.element.attr('data-url') === 'string' ){
        this.load( this.element.attr('data-url') );
    }
}

extend( Cjax ).with({
    beforeload: function(){

    },
    load: function( url, element ){

        this.allowJS = ( typeof this.element.attr('data-js') === 'string' );

        var beforeload = this.element.do('beforeload', {
            url: url,
            source: element
        });
        if( !beforeload.defaultPrevented ){
            this.element.load({
                url: url,
                onsuccess:function(xhr){
                    this.element.do('afterload', {
                        xhr: xhr
                    });
                }.bind(this)
            } );
        }
    },
    afterload: function(e){
        if( this.allowJS ){
            this.evaluate();
        }
        this.registerListeners();
    },
    registerListeners: function(){
        this.element.find('a:not([sc-ajax="0"])').forEach(function(element){
            element.on('click', function(event){
                event.prev();
                event.stop();
                this.cjax.load( this.element.attr('href'), this.element );
            }.bind({
                cjax: this,
                element: element
            }));
        }.bind(this));
    },
    evaluate: function(){
        var scripts = this.element.find('script');
        if( scripts.length > 0){

            var beforeeval = this.element.do('beforeeval', {
                scripts: scripts
            });

            if( !beforeeval.defaultPrevented ){
                scripts.forEach(function(script){
                    eval( script.innerHTML );
                });

                var aftereval = this.element.do('aftereval');
            }
        }

    }
});
