/**declare application**/
var Application = function(query){
    if(typeof query == 'string'){
        if(query[0] == '<'){
            var div = document.createElement('div')
            div.innerHTML = query;
            return new Element(div.childNodes);
        } else {
            return new Element(document.querySelectorAll(query));
        }
    } else if(typeof query == 'object'){
        if(query === document) {
            return new Element([document]);
        } else {
            return new Element([query]);
        }
    }
}
var ioxo = io = _ = Application;
/**declare element**/
var Element = function(arguments){
    for(var i = 0; i < arguments.length; i++){
        this[i] = arguments[i];
    }
    this.length = arguments.length;
    if(this[0] == document){
        this.ready = function(callable){
            document.addEventListener('DOMContentLoaded', callable);
        }
    }
}
var ioxoElement = ioElement = _Element = Element;
/**extend element with DOM manipulation**/
Element.prototype.hasClass = function(className){
    return this[0].classList.contains( className );
}
Element.prototype.addClass = function(className){
    for(var i = 0; i < this.length; i++){
        this[i].classList.add( className );
    }
}
Element.prototype.removeClass = function(className){
    for(var i = 0; i < this.length; i++){
        this[i].classList.remove( className );
    }
}
Element.prototype.toggleClass = function(className){
    for(var i = 0; i < this.length; i++){
        if( this[i].classList.contains( className ) ){
            this[i].classList.remove( className );
        } else {
            this[i].classList.add( className );
        }
    }
}
Element.prototype.attribute = function(key, value){
    if(this.length > 0){
        if (typeof value == 'undefined'){
            return this[0].getAttribute(key);
        } else {
            if(value === false || value === null){
                return this[0].removeAttribute(key);
            } else {
                return this[0].setAttribute(key, value);
            }
        }
    }
}
Element.prototype.style = function(key, value){
    if(this.length > 0){
        if (typeof value == 'undefined'){
            var returnValue = this[0].style[key];

            if(returnValue == ''){
                returnValue = window.getComputedStyle(this[0])[key];
            }

            return returnValue;

        } else {
            if(value === false || value === null){
                return this[0].style[key] = null;
            } else {
                return this[0].style[key] = value;
            }
        }
    }
}
Element.prototype.property = function(key, value){
    if(this.length > 0){
        if (typeof value == 'undefined'){
            return this[0][key];
        } else {
            if(value === false || value === null){
                return this[0][key] = null;
            } else {
                return this[0][key] = value;
            }
        }
    }
}
Element.prototype.html = function(value){
    if(this.length > 0){
        if (typeof value == 'undefined'){
            return this[0].innerHTML;
        } else {
            return this[0].innerHTML = value;
        }
    }
}
Element.prototype.remove = function(){
    for(var i = 0; i < this.length; i++){
        this[i].remove();
    }
}
Element.prototype.insert = function( elements ){
    for(var i = 0; i < elements.length; i++){
        this[0].appendChild( elements[i] );
    }
}
Element.prototype.insertAt = function( elements, index ){
    var referenceNode = this[0].childNodes[index];
    for(var i = 0; i < elements.length; i++){
        this[0].insertBefore(elements[i], referenceNode);
    }
}
Element.prototype.removeFrom = function( index ){
    if(typeof index == 'undefined'){    throw new Error("Undefined index: expected numeric value.");    }

    var node = this[0].childNodes[index];

    if(typeof node != 'undefined' && node.remove){
        return node.remove();
    } else {
        return false;
    }
}

// var domManipulationTimeout;
var rebinding = false;

document.addEventListener("DOMContentLoaded", function(event) {
    document.body.addEventListener('DOMNodeInserted', function (e) {
        rebind();
    }, false);

    function rebind(){
        if(!rebinding){
            console.log('binding events...');
            if(document.events){
                for(var i = 0; i < document.events.length; i++){
                    var ev = document.events[i];
                    var elements = document.querySelectorAll(ev.argB);
                    if(elements.length > 0){
                        for(var el = 0; el < elements.length; el++){
                            var element = elements[el];
                            element.addEventListener(ev.argA, ev.argC);
                        }
                    }
                }
            }
            rebinding = false;
        }
    }
    rebind();
});


/**extend element with event support**/
Element.prototype.when = function(argA, argB, argC, argD){
    var p = this[0];
    if(p === document){
        // delegate
        var events = document.events;
        if(typeof events == 'undefined'){
            document.events = [];
        }

        document.events.push({
            'argA': argA,
            'argB': argB,
            'argC': argC,
            'argD': argD
        });

        var elements = document.querySelectorAll(argB);

        for(var i = 0; i < elements.length; i++){
            elements[i].addEventListener(argA, argC);
        }

    } else {
        // direct
        for(var i = 0; i < this.length; i++){
            this[i].addEventListener(argA, argB);
        }

    }
}



Element.prototype.each = function(callable){
    for(var i = 0; i < this.length; i++){
        callable.call(this[i], i);
    }
}
Element.prototype.findParent = function(query){
    var arr = [];
    function up(node){
        arr.push(node);
        if(node && node.nodeType != 9){
            if(node.matches(query)){
                return arr;
            } else {
                return up(node.parentNode);
            }
        }
    }
    return up(this[0]).reverse();
}
Element.prototype.find = function(query){
    return this[0].querySelectorAll(query);
}
Element.prototype.siblings = function(query){
    var sourceNode = this[0];
    var node = sourceNode.parentNode.firstChild;

    c = true;

    var r = [];

    if(typeof query == 'undefined'){
        query = '*';
    }

    var elements = sourceNode.parentNode.querySelectorAll(query);

    for(var i = 0; i < elements.length; i++){
        if(elements[i] !== sourceNode){
            r.push(elements[i]);
        }
    }
    return new Element(r);
}



/**extend element with animatibles**/
Element.prototype.height = function(){
    var returnValue = this.style('height');
    if(returnValue == 'auto'){
        returnValue = window.getComputedStyle(this[0])['height'];
        if(isNaN(returnValue)){
            returnValue = 0;
        }

    }
    return parseFloat( returnValue );
}
Element.prototype.outerHeight = function(){
    return this[0].clientHeight;
}


Element.prototype.slideDown = function( speed ){
    var el = this;

    this.style('transition', false);

    var oldHeight = this.style('height');
    var display = this.style('display');

    this.style('display', 'inherit');

    var newHeight = this.style('height');
    var newPadding = this.style('padding');

    this.style('height', '0px');
    this.style('padding', '0px');
    this.style('overflow', 'hidden');

    var transition = "all "+speed+"ms ease-in-out";

    setTimeout(function(e){
        el.style('transition', transition);
        el.style('padding', false);
        el.style('height', parseFloat(newHeight) + "px");
    }, 1);

}
Element.prototype.slideUp = function( speed ){
    var el = this;

    this.style('transition', false);

    var newHeight = 0;

    var transition = "all "+speed+"ms ease-in-out";

    el.style('transition', transition);

    setTimeout(function(e){

        el.style('height', '0px');
        el.style('padding', '0px 0px 0px 0px');

        setTimeout(function(e){
            el.style('display', 'none');
            el.style('padding', false);
            el.style('height', false);
            el.style('transition', false);
        }, speed);
    },1);
}
Element.prototype.slideToggle = function(speed){
    if(this.style('display') == 'none'){
        this.slideDown(speed);
    } else {
        this.slideUp(speed);
    }
}
Element.prototype.value = function(value){
    if(typeof value == 'undefined'){
        return this[0].value;
    } else {
        this[0].value = value;
    }
}
Element.prototype.trigger = function(eventType){

    e = new Event(eventType);

    this[0].dispatchEvent(e);
}
