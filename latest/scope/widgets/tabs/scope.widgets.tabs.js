window['Tabs'] = window['Scope']['widgets']['Tabs'] = function( element ){
    this.element = element;
    
    this.element.listen('click', '.tabcontrols [sc-target]', function(e){
        var tabs = new Tabs( this.closest('.tabs') );
        tabs.show( this.attr('sc-target') );
    });
}

extend( Tabs ).with({
    show: function( target ){
        this.element.find('.tabcontrols [sc-target]').forEach(function(el){
            el.removeClass('active');
        });
        this.element.find('.tabcontent li').forEach(function(el){
            el.removeClass('active');
        });
        this.element.findOne('[sc-target="'+target+'"]').addClass('active');
        this.element.findOne(target).addClass('active');
    }
})
