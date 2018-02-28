window['Tabs'] = window['Scope']['widgets']['Tabs'] = function( element ){
    this.element = element;

    this.element.find('.tabcontrols [sc-target]').forEach(function(el){
        el.listen('click', function(event){
            this.tabcontrol.show( this.element.attr('sc-target') );
        }.bind({
            element: el,
            tabcontrol: this
        }));
    }.bind(this));
}

extend( Tabs ).with({
    show: function( query ){
        this.element.find('.tabcontrols [sc-target]').forEach(function(el){
            el.removeClass('active');
        });
        this.element.find('.tabcontent li').forEach(function(el){
            el.removeClass('active');
        })

        this.element.findOne('[sc-target="'+query+'"]').addClass('active');
        this.element.findOne(query).addClass('active');
    }
})
