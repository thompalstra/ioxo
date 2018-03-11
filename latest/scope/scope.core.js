// compatibility
(function() {
    if( typeof window.CustomEvent !== "function" ) {
        function CustomEvent(event, params) {
            params = params || {
                bubbles: false,
                cancelable: false,
                detail: undefined
            };
            var evt = document.createEvent('CustomEvent');
            evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
            return evt;
        }

        CustomEvent.prototype = window.Event.prototype;

        window.prototype.CustomEvent = CustomEvent;
    }

    if (typeof Element.prototype.matches !== 'function'){
        Element.prototype.matches = function(selector) {
            var node = this,
                nodes = (node.parentNode || node.document).querySelectorAll(selector),
                i = -1;
            while (nodes[++i] && nodes[i] != node);
            return !!nodes[i];
        }
    }

    if( typeof Element.prototype.closest !== 'function' ){
        Element.prototype.closest = function(query) {
            if (this.matches(query)) {
                return this;
            }
            if (!this.parentElement) {
                return false;
            } else if (this.parentElement.matches(query)) {
                return this.parentElement;
            }
            return this.parentElement.closest(query);
        };
    }

    if (typeof Element.prototype.remove !== 'function'){
        Element.prototype.remove = function() {
            if (this.parentNode) {
                this.parentNode.removeChild(this);
            }
        };
    }
})();

// if( typeof customElements !== 'undefined' ){
//
//     class ScopeWidget extends HTMLElement {
//         constructor() {
//             super();
//         }
//         connectedCallback() {
//             var widget = this.getAttribute('data-widget');
//             var list = widget.split('.');
//             var instance = null;
//             for (var i in list) {
//                 if (instance == null) {
//                     instance = window[list[i]];
//                 } else {
//                     instance = instance[list[i]];
//                 }
//             }
//             if (!this.id) {
//                 var c = (++Scope.widgetCount);
//                 var widgetName = widget.toLowerCase();
//                 widgetName = widgetName.replace(/\./g, '-');
//                 widgetName = widgetName.replace(/_/g, '-');
//                 this.id ='w' + c + '-' + widgetName;
//             }
//             var beforeload = this.do('beforeload');
//             if (!beforeload.defaultPrevented) {
//                 window[this.id] = new instance(this);
//                 this.do('afterload');
//             }
//         }
//     }
//
//     customElements.define('sc-widget', ScopeWidget);
// }

window['extend'] = function(){
    this.collection = arguments
    this.with = function( args, forceProperty ){
        for (var i = 0; i < this.collection.length; i++) {
            var item = this.collection[i];
            if (item.hasOwnProperty('prototype') && forceProperty !== true) {
                for (var b in args) {
                    item.prototype[b] = args[b];
                }
            } else {
                for (var b in args) {
                    item[b] = args[b];
                }
            }
        }
    }
    return this;
}

window['define'] = function( as, obj ){
    if( typeof as == 'string' ){
        if( typeof window[ as ] == 'undefined' ){
            window[ as ] = obj;
        } else {
            console.warn("window[" + as + "] is already in use");
        }
    } else {
        for(var i in as){
            if( typeof window[ as[i] ] == 'undefined' ){
                window[ as[i] ] = obj;
            } else {
                console.warn("window[" + as[i] + "] is already in use");
            }
        }
    }
}

window['serialize'] = function(obj,prefix){
    var str = [],
    p;

    if (typeof prefix == 'undefined') {
        prefix = '';
    }

    for (p in obj) {
        if (obj.hasOwnProperty(p)) {
            var k = prefix ? prefix + "[" + p + "]" : p,
                v = obj[p];
            str.push((v !== null && typeof v === "object") ?
                serialize(v, k) :
                encodeURIComponent(k) + "=" + encodeURIComponent(v));
        }
    }
    return str.join("&");
}

window['Scope'] = function( query, forceSingle ){
    if( forceSingle === true ){
        return document.querySelector( query );
    } else {
        return document.querySelectorAll( query );
    }
}

define( ['sc', '_'], window['Scope'] );

extend( Scope ).with({
    widgetCount: 0,
    nav: {},
    tools: {},
    widgets: {},
    getUserAgent: function() {
        var data = {
            name: 'netscape',
            ua: window.navigator.userAgent
        };
        var ua = window.navigator.userAgent.toLowerCase();

        if (ua.indexOf('.net') !== -1) {
            data.name = 'ie';
        } else if (ua.indexOf('edge') !== -1) {
            data.name = 'edge';
        } else if (ua.indexOf('chrome') !== -1) {
            data.name = 'chrome';
        } else if (ua.indexOf('firefox') !== -1) {
            data.name = 'ff';
        }
        return data;
    },
    request: {
        validate: function(obj) {
            if (!obj.hasOwnProperty('method')) {
                obj['method'] = 'GET';
            }
            if (!obj.hasOwnProperty('onsuccess')) {
                obj['onsuccess'] = function() {};
            }
            if (!obj.hasOwnProperty('onerror')) {
                obj['onerror'] = function() {};
            }
            if (!obj.hasOwnProperty('data')) {
                obj['data'] = {};
            }
            if (!obj.hasOwnProperty('responseType')) {
                obj['responseType'] = '';
            }
            if (!obj.hasOwnProperty('headers')) {
                obj['headers'] = [];
            }
            if (obj.method.toUpperCase() == 'POST') {
                obj.headers['Content-Type'] = 'application/x-www-form-urlencoded';
            }
            return obj;
        },
        send: function(obj) {
            var xhr = new XMLHttpRequest();
            xhr.obj = this.validate(obj);

            xhr.open(xhr.obj.method, xhr.obj.url);

            xhr.responseType = obj.responseType;

            if (xhr.obj.method.toUpperCase() == 'POST') {
                xhr.obj.data = serialize(xhr.obj.data);
            } else {
                if (xhr.obj.data) {
                    xhr.obj.url = xhr.obj.url + '?' + serialize(xhr.obj.data);
                    xhr.obj.data = '';
                }
            }

            for (var i in xhr.obj.headers) {
                xhr.setRequestHeader(i, xhr.obj.headers[i]);
            }

            xhr.onreadystatechange = function(res) {
                if (this.readyState == 4 && xhr.status == 200) {
                    return this.obj.onsuccess.call(this, this);
                }
            }
            xhr.onerror = xhr.obj.onerror;
            xhr.send(xhr.obj.data);
        }
    },
    get: function(obj) {
        obj.method = 'GET';
        return window.Scope.request.send(obj);
    },
    post: function(obj) {
        obj.method = 'POST';
        return window.Scope.request.send(obj);
    },
    ajax: function(obj) {
        return window.Scope.request.send(obj);
    },
}, true);

extend(Element, Document, Window).with({
    on: function(a, b, c) {
        var split = a.split(' ');
        for (var i in split) {
            var event = split[i];
            if (typeof c === 'undefined') {
                // direct
                this.addEventListener(event, b);
            } else {
                // delegate
                this.addEventListener(event, function(originalEvent) {
                    if (typeof originalEvent.target.matches == 'function') {
                        if (originalEvent.target.matches(b)) {
                            // direct;
                            return c.call(originalEvent.target, originalEvent);
                        } else if (closest = originalEvent.target.closest(b)) {
                            // via child
                            return c.call(closest, originalEvent);
                        }
                    }

                })
            }
        }
    },
    do: function(eventType, params) {
        var event = new CustomEvent(eventType, {
            cancelable: true,
            bubbles: true
        });

        event.params = {};

        if (typeof params == 'object') {
            for (var i in params) {
                event.params[i] = params[i];
            }
        }

        this.dispatchEvent(event);
        return event;
    }
});

extend(Element, Document).with({
    find: function(query) {
        return this.querySelectorAll(query);
    },
    findOne: function(query) {
        return this.querySelector(query);
    },
});
extend(Document).with({
    create: function(tagName, properties) {
        if (typeof properties != 'undefined') {
            var node = document.createElement(tagName);
            for (var i in properties) {
                if (typeof node[i] == 'undefined') {
                    node.setAttribute(i, properties[i]);
                } else {
                    node[i] = properties[i];
                }
            }
            return node;
        } else {
            return document.createElement(tagName);
        }
    }
});
extend(Element).with({
    index: function() {
        for (i = 0; i < this.parentNode.children.length; i++) {
            if (this.parentNode.children[i] == this) {
                return i;
            }
        }
    },
    show: function() {
        this.style['display'] = '';
    },
    hide: function() {
        this.style['display'] = 'none';
    },
    addClass: function(className) {
        this.classList.add(className);
    },
    hasClass: function(className){
        return this.classList.contains(className);
    },
    removeClass: function(className) {
        this.classList.remove(className);
    },
    toggleClass: function(className) {
        this.classList.toggle(className);
    },
    replaceClass: function(from, to) {
        this.classList.replace(from, to);
    },
    load: function(obj) {
        onsuccess = obj.onsuccess;
        onerror = obj.onerror;
        obj.onsuccess = function(res) {
            this.innerHTML = res.response;
            if (typeof onsuccess == 'function') {
                onsuccess.call(this, res);
            }
        }.bind(this);
        obj.onerror = function(err) {
            if (typeof onerror == 'function') {
                onerror.call(this, err);
            }
        }.bind(this);
        Scope.get(obj);
    },
    attr: function(a, b) {
        if (b === null) {
            this.removeAttribute(a);
        } else if (typeof b === 'undefined') {
            return this.getAttribute(a);
        } else {
            this.setAttribute(a, b);
        }
    },
    css: function(args) {
        for (var i in args) {
            this.style[i] = args[i];
        }
    },
    slideUp: function(speed) {

        if( !speed ){
            speed = 1000;
        }

        var height = this.offsetHeight;
        this.style.height = height;
        this.style.transition = speed + 'ms';
        window.setTimeout(function(e) {
            this.style.height = '0px';
            this.style['padding-top'] = '0px';
            this.style['padding-bottom'] = '0px';
            this.attr('sc-slided-up', '');
            this.attr('sc-slided-down', null);
        }.bind(this), 10);
    },
    slideDown: function(speed) {

        if( !speed ){
            speed = 1000;
        }

        this.style.height = '';
        var height = this.offsetHeight;
        this.style.height = '0px';
        this.style.transition = speed + 'ms';
        window.setTimeout(function(e) {
            this.style.height = height;
            this.style['padding-top'] = '';
            this.style['padding-bottom'] = '';
            this.attr('sc-slided-up', null);
            this.attr('sc-slided-down', '');
        }.bind(this), 10);

        console.log(height);
    },
    slideToggle: function(speed) {
        if (parseInt(this.style.height) == 0) {
            this.slideDown(speed);
        } else {
            this.slideUp(speed);
        }
    },
});

extend(HTMLCollection, NodeList).with({
    forEach: function(callable) {
        for (i = 0; i < this.length; i++) {
            callable.call(this, this[i]);
        }
    },
    delegate: function( fn, args ){
        for (i = 0; i < this.length; i++) {
            this[i][fn].apply( this[i], args );
        }
    },
    on: function() {
        this.delegate( 'on', arguments );
    },
    do: function() {
        this.delegate( 'do', arguments );
    },
    attr: function(){
        this.delegate( 'attr', arguments );
    },
    addClass: function(){
        this.delegate( 'addClass', arguments );
    },
    removeClass: function(){
        this.delegate( 'addClass', arguments );
    }
});

extend( Event ).with({
    prev: Event.prototype.preventDefault,
    stop: Event.prototype.stopPropagation
})



extend(Document, Element, NodeList, HTMLCollection).with({
    describe: function(property) {
        if (typeof Scope['documentation'] != 'undefined' && typeof Scope['documentation'][property] == 'string') {
            var name = (this.constructor.prototype.hasOwnProperty(property)) ? this.constructor.name.toString() : 'this';
            var documentation = Scope.documentation[property];
            console.log("%c" + name + "%c.%c" + property + "%c\n" + documentation, "color:blue;", "color: black;", "color:blue;", "color:black;", "color:#999");
        }
    },
    describeAll: function() {
        for (var property in this) {
            this.describe(property);
        }
    }
})

extend( Scope ).with({
    describe: Document.prototype.describe,
    describeAll: Document.prototype.describeAll,
}, true);

document.on('DOMContentLoaded', function(e) {
    document.do('ready');
});

document.on('click', '[sc-on="click"]', function(e) {
    var target = this.attr('sc-for');
    var trigger = this.attr('sc-trigger');
    var fn = this.attr('sc-function');

    if( trigger ){
        if (target) {
            var target = document.findOne(target);
            if (target) {
                e.prev();

                target.do(trigger);
            } else {
                console.error('Trying to trigger "' + trigger + '" on unknown element "' + target + '".');
            }
        } else {
            e.prev();
            this.do(trigger);
        }
    } else if( fn ){
        if( target ){
            var target = document.findOne(target);
            if( target && typeof target[fn] == 'function' ){
                e.prev();
                target[fn].call(target, null);
            } else {
                console.error('Trying to execute function "' + fn + '" on unknown element "' + target + '".');
            }
        }
    }


})

/* Swipe Events */

Element.prototype.swipe = {
    pressed: false,
    dispatched: {
        swiping: false,
        swipeleft: false,
        swiperight: false,
        swipingleft: false,
        swipingright: false,
    },
    relative: {
        start: {
            x: null,
            y: null,
        },
        current: {
            x: null,
            y: null,
        },
        diff: {
            x: null,
            y: null
        }
    },
    page: {
        start: {
            x: null,
            y: null,
        },
        current: {
            x: null,
            y: null,
        },
        diff: {
            x: null,
            y: null
        }
    }
};

document.on('mousedown touchstart', function( event ){
    if( event.target !== document ){
        event.target.swipe.pressed = true;
        event.target.swipe.relative.start.y = event.pageY - event.target.parentNode.offsetTop;
        event.target.swipe.relative.start.x = event.pageX - event.target.parentNode.offsetLeft;
    }
});
document.on('mousemove touchmove', function( event ){
    if( event.target !== document && event.target.swipe.pressed === true ){

        event.target.swipe.relative.current.y = event.pageY - event.target.parentNode.offsetTop;
        event.target.swipe.relative.current.x = event.pageX - event.target.parentNode.offsetLeft;

        event.target.swipe.relative.diff.y = event.target.swipe.relative.start.y - event.target.swipe.relative.current.y;
        event.target.swipe.relative.diff.x = event.target.swipe.relative.start.x - event.target.swipe.relative.current.x;

        if( event.target.swipe.dispatched.swiping == false ){
            if( event.target.do('swipestart').defaultPrevented ){
                return;
            }
        }

        event.target.do('swiping');

        if( event.target.swipe.dispatched.swiping == false ){
            event.target.swipe.dispatched.swiping = true;
        }

        if( event.target.swipe.relative.diff.x > 10 ){
            if( !event.target.do('swipingleft').defaultPrevented ){
                if( event.target.swipe.dispatched.swipeleft == false && !event.target.do('swipeleft').defaultPrevented ){
                    event.target.swipe.dispatched.swipeleft = true;
                }
                if( event.target.swipe.dispatched.swipingleft == false ){
                    event.target.swipe.dispatched.swipingleft = true;
                }
            }

        } else if(event.target.swipe.relative.diff.x < -10 ){
            if( !event.target.do('swipingright').defaultPrevented ){
                if( event.target.swipe.dispatched.swiperight == false && !event.target.do('swiperight').defaultPrevented ){
                    event.target.swipe.dispatched.swiperight = true;
                }
                if( event.target.swipe.dispatched.swipingright == false ){
                    event.target.swipe.dispatched.swipingright = true;
                }
            }
        }
    }


});
document.on('mouseup mouseleave touchend', function(e){
    if( event.target !== document &&  event.target.swipe.pressed === true ){

        event.target.do('swipeend');

        event.target.swipe = {
            pressed: false,
            dispatched: {
                swiping: false,
                swipeleft: false,
                swiperight: false,
                swipingleft: false,
                swipingright: false,
            },
            relative: {
                start: {
                    x: null,
                    y: null,
                },
                current: {
                    x: null,
                    y: null,
                },
                diff: {
                    x: null,
                    y: null
                }
            },
            page: {
                start: {
                    x: null,
                    y: null,
                },
                current: {
                    x: null,
                    y: null,
                },
                diff: {
                    x: null,
                    y: null
                }
            }
        };
    }
});

Scope.documentation = {
    getUserAgent: "\
Gets the current useragent\n\n\
%cScope.getUserAgent()",
    request: "\
Sends an XMLHttpRequest with the given properties\n\n\
%cScope.request.send( obj )",
    get: "\
Sends an XMLHttpRequest with the GET method and the given properties\n\n\
%cScope.get( obj )",
    post: "\
Sends an XMLHttpRequest with the POST method and the given properties\n\n\
%cScope.post( obj )",
    ajax: "\
Send an AJAX request with the given properties.\n\n\
%cScope.ajax( obj )",
    create: "\
Creates an element of the given tagname and optional options\n\n\
%cdocument.create( 'div', {\n\
    className: 'my-div is-awesome'\n\
    'data-id': 22\n\
} )",
    index: "\
Returns the index of this element's child index in the given class\n\n\
%cx.index()",
    addClass: "\
Adds the given class\n\n\
%cx.addClass( className )",
    removeClass: "\
Removes the given class\n\n\
%cx.removeClass( className )",
    toggleClass: "\
Sets the given class when it is not set, or unsets when it is\n\n\
%cx.toggleClass( className )",
    replaceClass: "\
Replaces the given class with another\n\n\
%cx.replaceClass( oldClass , newClass )",
    load: "\
Replaces the content of the current element, with data from the given url.\n\n\
%cx.load({ url: url })",
    attr: "\
Sets, unsets or returns an attribute\n\n\
%cx.attr( key ) // returns value \n\
x.attr( key , value ) // sets \n\
x.attr( key , null) // unsets",
    css: "\
Sets one or more css attributes.\n\n\
%cx.css({ 'height': '250px', 'background-color': 'red' })",
    slideUp: "\
Slides up the element until reaching it's '0' height.\n\n\
%cx.slideUp( speedInMs )",
    slideDown: "\
Slides down the element until reaching it's 'natural' height.\n\n\
%cx.slideDown( speedInMs )",
    slideToggle: "\
Toggles between slideUp and slideDown, depending on the current state.\n\n\
%cx.slideToggle( speedInMs )\
",
    forEach: "\
Adds forEach support, the argument in it's callback is always the iterated element.\n\n\
%cx.forEach(function(item){console.log(item)})",
    on: "\
ons for an event of the given type (and of the optionally matching query) and executes the supplied callback.\n\n\
%cx.on('click', query, callback) or x.on('click', callback)",
    do: "\
does an event of the supplied type.\n\n\
%cx.do('click')"
}
