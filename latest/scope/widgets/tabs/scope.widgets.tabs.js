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



        targetTabs = this.element.findOne(target);
        targetControl = this.element.findOne('[sc-target="'+target+'"]');

        if( targetTabs ){
            targetTabs.addClass('active');
        } else {
            console.warn('unknown element');
        }

        if( targetControl ){
            targetControl.addClass('active');
        } else {
            console.warn('unknown element');
        }
    }
})
