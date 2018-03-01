window['Cjax'] = window['Scope']['widgets']['Cjax'] = function( element ){
    this.element = element;
}

extend( Cjax ).with({
    load: function( url ){
        console.log(this.element);
        this.element.load({
            url: url
        });
    }
});

document.listen('click', '[sc-cjax] a:not([sc-cjax="false"]):not([sc-cjax="0"])', function(e){
    e.preventDefault();
    var cjax = new Scope.widgets.Cjax( this.closest(['[sc-cjax]']) );
    cjax.load( this.attr('href') );
})
