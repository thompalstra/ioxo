window['CardGallery'] = window['Scope']['widgets']['CardGallery'] = function( element ){
    this.element = element;
    this.element.attr('sc-widget-status', 'pending');

    this.registerListeners();


}

extend( CardGallery ).with({

    registerListeners: function(){
        document.on('ready', function(e){
            this.element.on('click', '.next', function( event ){
                this.next();
            }.bind(this));
            this.element.on('click', '.prev', function( event ){
                this.previous();
            }.bind(this));
            this.element.attr('sc-widget-status', null);
        }.bind(this));
    },

    getActive: function(){
        return this.element.findOne('.active');
    },
    next: function(){
        var active = this.getActive();
        var next = active.nextElementSibling;
        if( next ){
            active.removeClass('active');
            next.addClass('active');
        }

        this.ui();
    },
    previous: function(){
        var active = this.getActive();
        var previous = active.previousElementSibling;
        if( previous ){
            active.removeClass('active');
            previous.addClass('active');
        }
        this.ui();
    },
    to: function(){

    },
    ui: function(){
        var active = this.element.findOne('.active');
        if( active && active.nextElementSibling ){
            this.element.findOne('.next').attr('show', '');
            this.element.findOne('.next').attr('hide', null);
        } else {
            this.element.findOne('.next').attr('show', null);
            this.element.findOne('.next').attr('hide', '');
        }
        if( active && active.previousElementSibling ){
            this.element.findOne('.prev').attr('show', '');
            this.element.findOne('.prev').attr('hide', null);
        } else {
            this.element.findOne('.prev').attr('show', null);
            this.element.findOne('.prev').attr('hide', '');
        }
    }
})
