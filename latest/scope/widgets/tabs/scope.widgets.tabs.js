window['Tabs'] = window['Scope']['widgets']['Tabs'] = function( element ){
    this.element = element;

    document.on( 'ready', function(e){
        this.element.find('[data-target]').forEach(function(el){
            el.on('click', function(event){
                this.show( event.target.attr('data-target') );
            }.bind(this));
        }.bind(this));
    }.bind(this) );
}

extend( Tabs ).with({
    show: function( target ){

        this.element.find('.tabcontrols [data-target]').forEach(function(el){
            el.removeClass('active');
        });

        this.element.find('.tabcontent li').forEach(function(el){
            el.removeClass('active');
        });

        targetTabs = this.element.findOne(target);
        targetControl = this.element.findOne('[data-target="'+target+'"]');

        ( ( targetTabs ) ? targetTabs.addClass('active') : console.warn('unknown element') );
        ( ( targetControl ) ? targetControl.addClass('active') : console.warn('unknown element') );
    }
})
