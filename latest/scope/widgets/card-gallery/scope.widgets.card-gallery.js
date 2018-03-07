window['CardGallery'] = window['Scope']['widgets']['CardGallery'] = function( element ){
    this.element = element;
    this.element.attr('sc-widget-status', 'pending');

    document.listen('ready', function(e){
        this.element.findOne('.next', function( event ){
            this.next()();
        }.bind(this));
        this.element.findOne('.prev', function( event ){
            this.previous();
        }.bind(this));


        this.element.attr('sc-widget-status', null);
    }.bind(this));
}

extend( CardGallery ).with({
    getActiveItem: function(){
        return this.element.findOne('.item.active');
    },
    next: function(){
        var active = this.getActiveItem();
        var next = active.nextElementSibling;
        if( next ){
            active.removeClass('active');
            next.addClass('active');

        }

        this.ui();
    },
    previous: function(){
        var active = this.getActiveItem();
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
            // console.log('has next');
            this.element.findOne('.next').attr('show', '');
            this.element.findOne('.next').attr('hide', null);
        } else {
            // console.log('no next');
            this.element.findOne('.next').attr('show', null);
            this.element.findOne('.next').attr('hide', '');
        }
        if( active && active.previousElementSibling ){
            console.log('has previous');
            this.element.findOne('.prev').attr('show', '');
            this.element.findOne('.prev').attr('hide', null);
        } else {
            console.log('no prev');
            this.element.findOne('.prev').attr('show', null);
            this.element.findOne('.prev').attr('hide', '');
        }
    }
})
