window['Panels'] = window['Scope']['widgets']['Panels'] = function( element ){
    this.element = element;

    this.registerListeners();
}

extend( Panels ).with({
    registerListeners: function(){
        this.element.on('mousedown', function(e){
            if( e.target.matches('.divider') ){

                var relX = e.pageX - e.target.parentNode.offsetLeft;
                var relY = e.pageY - e.target.parentNode.offsetTop;

                e.target.attr('is-mousedown', '1');
                this.attr('is-mousedown', '1');
            }
        });

        this.element.on('mouseup', function(e){
            this.find('.divider[is-mousedown="1"]').forEach(function(divider){
                divider.removeAttribute('is-mousedown');
                console.log(this);
                this.removeAttribute('is-mousedown');
            }.bind(this))
        });

        this.element.on('mousemove', function(e){
            var divider = this.findOne('.divider[is-mousedown="1"]');
            if(divider){

                var relX = e.pageX - this.offsetLeft - 5;
                var relY = e.pageY - this.offsetTop - 5;

                if( divider.classList.contains('vertical')){

                    relX = relX - this.parentNode.offsetLeft;

                    divider.nextElementSibling.attr('width', null);
                    divider.previousElementSibling.attr('width', relX);
                } else if( divider.classList.contains('horizontal') ){
                    divider.parentNode.nextElementSibling.attr('height', null);
                    divider.parentNode.previousElementSibling.attr('height', relY);
                }
            }
        });
    }
});
