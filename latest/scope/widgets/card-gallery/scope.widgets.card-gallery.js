window['CardGallery'] = function( element ){
    this.element = element;
}
document.listen('click', '.swipe-gallery .next', function(event){
    var cg = new CardGallery( this.closest('.swipe-gallery') );
     cg.next();
});
document.listen('click', '.swipe-gallery .prev', function(event){
    var cg = new CardGallery( this.closest('.swipe-gallery') );
     cg.previous();
});

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
