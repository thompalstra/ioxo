(function() {
    if (typeof window.CustomEvent === "function") return false; //If not IE

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
})();
(function() {

    if (typeof Element.prototype.closest === 'function') return false;

    Element.prototype.matches = function(selector) {
        var node = this,
            nodes = (node.parentNode || node.document).querySelectorAll(selector),
            i = -1;
        while (nodes[++i] && nodes[i] != node);
        return !!nodes[i];
    }
})();
(function() {
    if (typeof Element.prototype.remove === 'function') return false;

    Element.prototype.remove = function() {
        if (this.parentNode) {
            this.parentNode.removeChild(this);
        }
    };
})();
(function() {
    if (typeof Element.closest === 'function') return false;
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
})();



window['extend'] = function() {
    return new Extender(arguments);
}

Extender = function(collection) {
    this.collection = collection;
}
Extender.prototype.with = function(args, forceVariable) {
    for (i = 0; i < this.collection.length; i++) {
        var item = this.collection[i];
        if (item.hasOwnProperty('prototype') && forceVariable !== true) {
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

window['serialize'] = function(obj, prefix) {
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

window['Scope'] = function(arg) {
    return document.find(arg);
}

if (typeof window['sc'] == 'undefined') {
    window['sc'] = window['Scope'];
}
if (typeof window['_'] == 'undefined') {
    window['_'] = window['Scope'];
}

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
    listen: function(a, b, c) {
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
    dispatch: function(eventType, params) {
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
    listen: function(a, b, c) {
        var split = a.split(' ');
        for (var i in split) {
            var event = split[i];
            for (i = 0; i < this.length; i++) {
                if (typeof c == 'undefined') {
                    this[i].listen(event, b);
                } else {
                    this[i].listen(event, b, c);
                }
            }
        }
    },
    dispatch: function(a) {
        for (i = 0; i < this.length; i++) {
            this[i].dispatch(a);
        }
    },
    forEach: function(callable) {
        for (i = 0; i < this.length; i++) {
            callable.call(this, this[i]);
        }
    },
});

// extend(HTMLCollection).with({
//     forEach: function(callable) {
//         for (i = 0; i < this.length; i++) {
//             callable.call(this, this[i]);
//         }
//     },
// });

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
    listen: "\
Listens for an event of the given type (and of the optionally matching query) and executes the supplied callback.\n\n\
%cx.listen('click', query, callback) or x.listen('click', callback)",
    dispatch: "\
Dispatches an event of the supplied type.\n\n\
%cx.dispatch('click')"
}


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

class ScopeWidget extends HTMLElement {
    constructor() {
        super();
    }
    connectedCallback() {

        var widget = this.getAttribute('data-widget');
        var list = widget.split('.');
        var instance = null;
        for (var i in list) {
            if (instance == null) {
                instance = window[list[i]];
            } else {
                instance = instance[list[i]];
            }
        }
        if (!this.id) {
            var c = (++Scope.widgetCount);
            var widgetName = widget.toLowerCase();
            widgetName = widgetName.replace(/\./g, '-');
            widgetName = widgetName.replace(/_/g, '-');
            this.id ='w' + c + '-' + widgetName;
        }
        var beforeload = this.dispatch('beforeload');
        if (!beforeload.defaultPrevented) {
            window[this.id] = new instance(this);
            this.dispatch('afterload');
        }
    }
}

customElements.define('sc-widget', ScopeWidget);

document.listen('DOMContentLoaded', function(e) {
    document.dispatch('ready');
});

document.listen('click', '[sc-on="click"]', function(e) {
    var target = this.attr('sc-for');
    var trigger = this.attr('sc-trigger');

    if (target) {
        var target = document.findOne(target);
        if (target) {
            target.dispatch(trigger);
        } else {
            console.error('Trying to trigger "' + trigger + '" on unknown element "' + target + '".');
        }

    } else {
        this.dispatch(trigger);
    }
})

document.listen('touchstart mousedown', '*', function(event) {
    this.isMouseDown = true;

    this[event.type] = {
        x: (event.type == 'mousedown' ? event.pageX : event.touches[0].pageX) - this.offsetLeft,
        y: (event.type == 'mousedown' ? event.pageY : event.touches[0].pageY) - this.offsetTop
    };

    this.longpressTimeout = window.setTimeout(function() {
        this.dispatch('longpress');
    }.bind(this), 1500);
});
document.listen('touchmove mousemove', '*', function(event) {

    if (this.isMouseDown) {

        var startX = (this[(event.type == 'touchmove' ? 'touchstart' : 'mousedown')]).x;
        var startY = (this[(event.type == 'touchmove' ? 'touchstart' : 'mousedown')]).y;

        var currentX = (event.type == 'mousemove' ? event.pageX : event.touches[0].pageX) - this.offsetLeft;
        var currentY = (event.type == 'mousemove' ? event.pageY : event.touches[0].pageY) - this.offsetTop;

        var diffX = Math.abs(startX - currentX);
        var diffY = Math.abs(startY - currentY);

        this['swiping'] = {
            x: {
                start: startX,
                current: currentX,
                diff: diffX
            },
            y: {
                start: startY,
                current: currentY,
                diff: diffY
            },
        };

        var swiping = this.dispatch('swiping');

        if (diffX > 0 || diffY > 0) {
            window.clearTimeout(this.longpressTimeout);
        }

        if (swiping.defaultPrevented) {
            this.isMouseDown = false;
            return;
        }

        if (startX > currentX) {
            if (diffX > 15) {
                var swipright = this.dispatch('swiperight');
                if (swipright.defaultPrevented) {
                    this.isMouseDown = false
                }
            }
        } else if (startX < currentX) {
            if (diffX > 15) {
                var swipeleft = this.dispatch('swipeleft');
                if (swipeleft.defaultPrevented) {
                    this.isMouseDown = false
                }
            }
        }
    }
});

document.listen('touchend mouseup', '*', function(event) {
    window.clearTimeout(this.longpressTimeout);
    this.isMouseDown = false;
});
