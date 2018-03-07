<div class='wrapper'>
    <sc-widget data-widget='Scope.widgets.Tabs' id='w0-tabs' class='tabs'>
        <ul class="tabcontrols">
            <li data-target="#w0-tabs-about-ioxo" class="active">About <strong>IOXO</strong></li>
            <li data-target="#w0-tabs-widgets">Widgets</li>
            <li data-target="#w0-tabs-tools">Tools</li>
            <li data-target="#w0-tabs-nav">Nav</li>
        </ul>
        <ul class="tabcontent">
            <li id='w0-tabs-about-ioxo' class="active">
                <h2>About <strong>IOXO</strong></h2>
                <p>
                    IOXO is the home of <strong>Scope</strong>.
                </p>
                <p>
                    <strong>Scope</strong> is a collection of tools that are designed to broaden the functionality of native functions and is available as a full <strong><a href="https://www.php.net">PHP</a></strong> framework or as separate <strong><a href="">Javascript</a></strong> modules.
                </p>
                <h2>ScopeJS</h2>

                <p>
                    <strong>ScopeJS</strong> is by definition an extension of the current HTML-standards.<br/>
                    By extending the standard HTML classes, defined by <strong><a href="https://www.w3.org">W3</a></strong>, and therefore adding functionality.<br/>
                </p>
                <p>
                    Compared to other frameworks, ScopeJS does not declare new classes and does nu use wrapper-classes around element. </br>
                    An example (using jQuery) would be as such:
                </p>
                <h4>Basics <a class='toggle-code-wrapper btn btn-small flat-to-default epic' data-target='#cw-casting'>show</a></h4>
                <div id='cw-casting' class='code-wrapper' style='height: 0px; padding-top: 0; padding-bottom: 0;'>
                    <div class='col xs6'>
                    <strong>ScopeJS</strong>
                        <pre><code>
var myDiv = sc('.my-div');

<span style='color: #8BC34A'>/*
    returns an object of the NodeList class, which is the native wrapper standard
    finding elements don't get wrapped so when dealing with large amounts of elements, queries will be quicker
*/</span>
                        </code></pre>
                    </div>
                    <div class='col xs6'>
                    <strong>jQuery</strong>
                        <pre><code>
var myDiv = $('.my-div');

<span style='color: #8BC34A'>/*
    returns a jQuery object which servers as a wrapper for one or more native elements.
    matched elements get wrapped inside a jQuery object which has it's own functionality
    this means each element inside the wrapper does NOT support any of the functions and
    are required to be casted back to jQuery like: $( HTMLElement ) or $( jQueryElements[0] )
*/</span>
                        </code></pre>
                    </div>
                </div>

                <h4>Searches <a class='toggle-code-wrapper btn btn-small flat-to-default epic' data-target='#cw-queries' >show</a></h4>
                <div id='cw-queries' class='code-wrapper' style='height: 0px; padding-top: 0; padding-bottom: 0;'>
                    <div class='col xs6'>
                    <strong>ScopeJS</strong>
                        <pre><code>
<span style='color: #8BC34A'>/*
    getting a single element in ScopeJS is done by using the <strong>findOne</strong> method
*/</span>

var myDiv = document.findOne('.my-div');
                        </code></pre>
                    </div>
                    <div class='col xs6'>
                    <strong>jQuery</strong>
                        <pre><code>
<span style='color: #8BC34A'>/*
    accessing the native/first element in jQuery could be done as
*/</span>

var myDiv = $('.my-div');

var myNativeDiv = myDiv[0] || myDiv.element();

<span style='color: #8BC34A'>/*
    this means you cannot simply query a single element and will ALWAYS query the full document, resulting in unwanted delays when dealing with largely populated DOMs
*/</span>
                        </code></pre>
                    </div>
                </div>

                <h4>Internal functions <a class='toggle-code-wrapper btn btn-small flat-to-default epic' data-target='#cw-internal' >show</a></h4>
                <div id='cw-internal' class='code-wrapper' style='height: 0px; padding-top: 0; padding-bottom: 0;'>
                    <div class='col xs6'>
                    <strong>ScopeJS</strong>
                        <pre><code>
<span style='color: #8BC34A'>/*
    ScopeJS uses native methods to perform simple tasks, such as adding a class
*/</span>

HTMLElement.protoype.addClass = function( className ){
    this.classList.add( className );
}
                        </code></pre>
                    </div>
                    <div class='col xs6'>
                    <strong>jQuery</strong>
                        <pre><code>
<span style='color: #8BC34A'>/*
    whereas jQuery uses a more "compatible" mode to make sure all platforms support the method
    as a result however, will be that simple procedures require too much time/space/code
    to support "all" platforms
*/</span>

jQuery.fn.addClass = function( value ) {
    var classes, elem, cur, clazz, j, finalValue,
        i = 0,
        len = this.length,
        proceed = typeof value === "string" && value;

    if ( jQuery.isFunction( value ) ) {
        return this.each(function( j ) {
            jQuery( this ).addClass( value.call( this, j, this.className ) );
        });
    }

    if ( proceed ) {
        // The disjunction here is for better compressibility (see removeClass)
        classes = ( value || "" ).match( rnotwhite ) || [];

        for ( ; i < len; i++ ) {
            elem = this[ i ];
            cur = elem.nodeType === 1 && ( elem.className ?
                ( " " + elem.className + " " ).replace( rclass, " " ) :
                " "
            );

            if ( cur ) {
                j = 0;
                while ( (clazz = classes[j++]) ) {
                    if ( cur.indexOf( " " + clazz + " " ) < 0 ) {
                        cur += clazz + " ";
                    }
                }

                // only assign if different to avoid unneeded rendering.
                finalValue = jQuery.trim( cur );
                if ( elem.className !== finalValue ) {
                    elem.className = finalValue;
                }
            }
        }
    }

    return this;
}
                        </code></pre>
                    </div>
                </div>


                <h4>Conclusion <a class='toggle-code-wrapper btn btn-small flat-to-default epic' data-target='#cw-conclusion'>show</a></h4>
                <div id='cw-conclusion' class='code-wrapper' style='height: 0px; padding-top: 0; padding-bottom: 0;'>
                    <div class='col xs12'>
                        <pre><code>
<span style='color: #8BC34A'>/*
    whilst ScopeJS utilizes native methodology that is the current <a href="https://html.spec.whatwg.org/dev/" style='color: white'>Living Standard</a>,
    it might not be compatible with "old" platforms.
    always be sure to check the platforms you're building for, to see what is the <a href="https://html.spec.whatwg.org/dev/" style='color: white'>Living Standard</a> for that platform
*/</span>

<span style='color: #8BC34A'>/*
    interested in the using ScopeJS?
    if you're using <span style='color: white;'>Chrome</span>, <span style='color: white;'>Firefox</span>, <span style='color: white;'>Internet Explorer</span> or <span style='color: white;'>Opera</span>: press <span style='color: white;'>F12</span>, go to <span style='color: white;'>console</span> and try typing the following:

    <span style='color: white;'>document.find('div').describeAll();</span>
    <span style='color: white;'>document.findOne('div').describeAll();</span>
    <span style='color: white;'>document.findOne('div').children.describeAll();</span>
*/</span>
                        </code></pre>
                    </div>
                </div>
            </li>
            <li id='w0-tabs-widgets'>
                <h2>Widgets</h2>
                <ul class='datalist'>
                    <a href="/latest/scope/widgets/card-gallery/example.html">
                        <li>
                            Card Gallery
                        </li>
                    </a>
                    <a href="/latest/scope/widgets/cjax/example.html">
                        <li>
                            CJAX
                        </li>
                    </a>
                    <a href="/latest/scope/widgets/datatable/example.html">
                        <li>
                            Datatable
                        </li>
                    </a>
                    <a href="/latest/scope/widgets/dialog/example.html">
                        <li>
                            Dialog
                        </li>
                    </a>
                    <a href="/latest/scope/widgets/form/example.html">
                        <li>
                            Form
                        </li>
                    </a>
                    <a href="/latest/scope/widgets/notification/example.html">
                        <li>
                            Notification
                        </li>
                    </a>
                    <a href="/latest/scope/widgets/datatable/sidebar.html">
                        <li>
                            Sidebar <strong style='color: red;'>(deprecated)</strong>
                        </li>
                    </a>
                    <a href="/latest/scope/widgets/slide/example.html">
                        <li>
                            Slide
                        </li>
                    </a>
                    <a href="/latest/scope/widgets/split-container/example.html">
                        <li>
                            SplitContainer
                        </li>
                    </a>
                    <a href="/latest/scope/widgets/tabs/example.html">
                        <li>
                            Tabs
                        </li>
                    </a>
                    <a href="/latest/scope/widgets/yt-player/example.html">
                        <li>
                            Youtube player
                        </li>
                    </a>
                </ul>
            </li>
            <li id='w0-tabs-tools'>
                <h2>Tools</h2>
                <ul class='datalist'>
                    <a href="/latest/scope/tools/datalist/example.html">
                        <li>
                            Datalist
                        </li>
                    </a>
                    <a href="/latest/scope/tools/checkbox/example.html">
                        <li>
                            Checkbox
                        </li>
                    </a>
                    <a href="/latest/scope/tools/pop-over/example.html">
                        <li>
                            Popover
                        </li>
                    </a>
                </ul>
            </li>
            <li id='w0-tabs-nav'>
                <h2>Nav</h2>
                <ul class='datalist'>
                    <a href="/latest/scope/nav/sidebar/example.html">
                        <li>
                            Sidebar
                        </li>
                    </a>
                    <a href="/latest/scope/nav/menu/example.html">
                        <li>
                            Menu
                        </li>
                    </a>
                </ul>
            </li>
        </ul>
    </div>
</div>
<script>
    var w0tabs = new Tabs( document.findOne('#w0-tabs') );

    sc('.toggle-code-wrapper').listen('click', function(e){
        var target = this.attr('data-target');

        sc('.code-wrapper').forEach(function(el){
            if( !el.matches( target ) ){
                el.slideUp( 1000 );
                document.findOne( '[data-target="#'+el.id+'"]' ).innerHTML = 'show';
            }
        });

        var target = document.findOne( target );

        console.log( parseFloat( target.style['height'] ) );

        if( parseFloat( target.style['height'] ) == 0 ){
            this.innerHTML = 'hide';
        } else {
            this.innerHTML = 'show';
        }

        target.slideToggle( 1000 );
    });
</script>
