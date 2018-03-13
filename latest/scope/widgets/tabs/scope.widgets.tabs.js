window['Tabs'] = window['Scope']['widgets']['Tabs'] = function( element ){
    this.element = element;

    this.registerElements();
    this.registerGetSet();
    this.registerListeners();

    if( typeof element.attr('data-tab') == 'string' ){
        console.log('derp');
        this.tab = element.attr('data-tab')
    }
}

extend( Tabs ).with({
    registerElements: function(){
        this.tabControls = this.element.findOne('.tabcontrols');
        this.tabContent = this.element.findOne('.tabcontent');
    },
    registerGetSet: function(){
        Object.defineProperty( this, 'tab', { get: this.getTab, set: this.setTab } );
    },
    registerListeners: function(){
        this.element.find('[data-target]').forEach(function(el){
            el.on('click', function(event){
                this.tabs.tab = this.element.attr('data-target');
            }.bind({
                element: el,
                tabs: this
            }));
        }.bind(this));
    },
    setTab: function( value ){
        this.setTabControl( value );
        this.setTabContent( value );
        this.element.setAttribute('data-tab', value);
    },
    getTab: function( value ){
        return this.element.getAttribute('data-tab');
    },
    setTabControl: function( value ){
        this.tabControls.children.forEach(function(el){
            if( el.attr('data-target') == value ){
                el.addClass('active');
            } else {
                el.removeClass('active');
            }
        });
    },
    setTabContent: function( value ){
        this.tabContent.children.forEach(function(el){
            if( el.matches( value ) ){
                el.addClass('active');
                this.tab = value;
            } else {
                el.removeClass('active');
            }
        });
    }
})
