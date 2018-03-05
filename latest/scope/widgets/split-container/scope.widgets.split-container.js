window['SplitContainer'] = window['Scope']['widgets']['SplitContainer'] = function( element ){
    this.element = element;

    this.registerListeners();
}

extend( SplitContainer ).with({
    registerListeners: function(e){
        this.element.listen('mousedown', function(e){
            if( e.target.matches('.splitter.vertical') || e.target.parentNode.matches('.splitter.horizontal') ){

                if( e.target.matches('.splitter.vertical') ){
                    this.splitter = e.target;
                } else if( e.target.parentNode.matches('.splitter.horizontal') ){
                    this.splitter = e.target.parentNode;
                }

                if( this.splitter.matches('.vertical') ){
                    node = this.splitter.previousElementSibling;
                    while( node = node.previousElementSibling ){
                        if( node.matches('.column') ){
                            node.width = node.offsetWidth;
                        }
                    }
                } else if( this.splitter.matches('.horizontal') ){
                    node = this.splitter.previousElementSibling;
                    while( node = node.previousElementSibling ){
                        if( node.matches('.row') ){
                            node.setAttribute('height', node.offsetHeight);
                        }
                    }
                }
            }
        }.bind(this));
        this.element.listen('mousemove', function(e){
            if( this.splitter ){
                if( this.splitter.matches('.vertical') ){
                    splitterLeft = this.splitter.offsetLeft - 10;
                    paneLeft = this.splitter.previousElementSibling.offsetLeft;
                    relX = e.pageX - this.element.offsetLeft;
                    width = relX - paneLeft;
                    this.splitter.previousElementSibling.width = width;
                } else if( this.splitter.matches('.horizontal') ){
                    splitterTop = this.splitter.offsetTop - 10;
                    paneTop = this.splitter.previousElementSibling.offsetTop;
                    relY = e.pageY - this.element.offsetTop;

                    height = relY - paneTop;
                    this.splitter.previousElementSibling.setAttribute('height', height);
                }
            }
        }.bind(this))
        this.element.listen('mouseup mouseleave', function(e){
            console.log(e.type);
            this.splitter = null;
        }.bind(this))
    }
})
