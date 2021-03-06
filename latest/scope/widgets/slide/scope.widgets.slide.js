window['Slide'] = window['Scope']['widgets']['Slide'] = function( element ){
    this.element = element;

    this.element.attr('sc-widget-status', 'pending');

    document.on('ready', function(event){
        this.ul = this.element.findOne('ul');
        this.wrapper = this.element.findOne('.wrapper');
        this.images = [];
        this.index = 1;

        var count = this.ul.children.length;
        var itemWidth = ( 100 / count ).toFixed(6) + "%";

        this.ul.css({
            'width': ( 100 * count ) + "%"
        } );

        this.ul.children.forEach(function(el){
            this.images.push( el.style['background-image'] );
            el.style['width'] = itemWidth;
            el.style['background-image'] = '';
        }.bind(this));

        lazyload.call(this, null);

        function lazyload(){
            var imageCount = this.images.length;
            var index = 0;

            next.call(this, index);

            function next( index ){
                var img = document.createElement('img');
                url = this.images[index];

                url = url.substring(5, url.length - 2);
                img.src = url;

                var onload = function(){
                    this.ul.children[index].style['background-image'] = this.images[index];
                    if( (index + 1) < imageCount ){
                        next.call( this, ++index );
                    } else {
                        finish.call( this );
                    }
                }.bind(this)

                img.onload = onload;
            }
        }

        function finish(){
            this.ul.on('swipeleft', function(event){
                event.preventDefault();
                event.stopImmediatePropagation();
                this.prev();
            }.bind(this));
            this.ul.on('swiperight', function(event){
                event.prev();
                event.stop();
                this.next();
            }.bind(this));
            this.element.attr('sc-widget-status', 'done');
        }
    }.bind(this));
}

extend( window['Scope']['widgets']['Slide'] ).with({
    next: function(){
        var currentIndex = this.getIndex();
        var newIndex = currentIndex + 1;
        if( newIndex <= this.ul.children.length ){
            this.to( newIndex );
        } else {
            this.to( 1 );
        }
    },
    prev: function(){
        var currentIndex = this.getIndex();
        var newIndex = currentIndex - 1;
        if( newIndex >= 1 ){
            this.to( newIndex );
        } else {
            this.to( this.ul.children.length );
        }
    },
    to: function( i ){
        this.setIndex(i);
        var i = i - 1;

        var step = ( 100 / this.ul.children.length );

        var perc = step * i;

        var offsetLeft = -(perc) + "%";

        this.ul.css({
            transform: 'translateX(' + offsetLeft + ')'
        });
    },
    getIndex: function( i ){
        return this.index;
    },
    setIndex: function( i ){
        this.index = i;
    }
})
