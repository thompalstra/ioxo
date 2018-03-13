<div class='wrapper'>
    <h2>ScopeJS</h2>
    <p>
        <strong>ScopeJS</strong> is by definition an extension of the current HTML-standards.<br/>
        By extending the standard HTML classes defined by <strong><a href="https://www.w3.org">W3</a></strong>, this is how ScopeJS adds functionality to elements, without compromising the existing methods.<br/>
    </p>
    <p>
        Compared to other frameworks, ScopeJS does not declare new classes and does nu use wrapper-classes around element. </br>
        An example (using jQuery) would be as such:
    </p>


    <a href="/scope-js/basics" class='btn btn-default flat-to-default epic' sc-on="click" sc-for="#dialog-basics" sc-trigger="toggle">Basics</a>

    <sc-widget id='dialog-basics' class='dialog' data-widget='Scope.widgets.Dialog' data-anim="0" data-backdrop='1' data-backdrop-dismiss='1'>
        <div class='title'>
            Basics
        </div>
        <div class='actions'>
            <button class='btn btn-default flat-to-default turqoise pull-right' sc-on='click' sc-trigger='ok'>OK</button>
        </div>
        <div class='content'>
            <div class='code-wrapper'>
<div class='col xs6'>
<strong>ScopeJS</strong>
    <pre class='pre-code'><code>
var myDiv = sc('.my-div');

<span style='color: #8BC34A'>/*
returns an object of the NodeList class, which is the native wrapper standard
finding elements don't get wrapped so when dealing with large amounts of elements, queries will be quicker
*/</span>
    </code></pre>
</div>
<div class='col xs6'>
<strong>jQuery</strong>
    <pre class='pre-code'><code>
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
        </div>
    </sc-widget>



    <a href="/scope-js/searches" class='btn btn-default flat-to-default epic' sc-on='click' sc-for='#dialog-searches' sc-trigger='toggle'>Searches</a>

    <sc-widget id='dialog-searches' class='dialog' data-widget='Scope.widgets.Dialog' data-anim="0" data-backdrop='1' data-backdrop-dismiss='1'>
        <div class='title'>
            Searches
        </div>
        <div class='actions'>
            <button class='btn btn-default flat-to-default turqoise pull-right' sc-on='click' sc-trigger='ok'>OK</button>
        </div>
        <div class='content'>
            <div class='code-wrapper'>
<div class='col xs6'>
<strong>ScopeJS</strong>
    <pre><code>
<span style='color: #8BC34A'>/*
getting a single element in ScopeJS is done by using the <strong>findOne</strong> method or by calling the Scope variable as a method.
*/</span>

var myDiv = document.findOne('.my-div');
var myDiv = sc('.my-div', true);
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
        </div>
    </sc-widget>


    <a href="/scope-js/internal" class='btn btn-default flat-to-default epic' sc-on="click" sc-trigger="toggle" sc-for="#dialog-internal">Internal</a>

    <sc-widget id='dialog-internal' class='dialog' data-widget='Scope.widgets.Dialog' data-anim="0" data-backdrop='1' data-backdrop-dismiss='1'>
        <div class='title'>
            Internal
        </div>
        <div class='actions'>
            <button class='btn btn-default flat-to-default turqoise pull-right' sc-on='click' sc-trigger='ok'>OK</button>
        </div>
        <div class='content'>
            <div class='code-wrapper'>
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
        </div>
    </sc-widget>


    <a href="/scope-js/conclusion" class='btn btn-default flat-to-default epic' sc-on="click" sc-for="#dialog-conclusion" sc-trigger="toggle">Conclusion</a>

    <sc-widget id='dialog-conclusion' class='dialog' data-widget='Scope.widgets.Dialog' data-anim="0" data-backdrop='1' data-backdrop-dismiss='1'>
        <div class='title'>
            Conclusion
        </div>
        <div class='actions'>
            <button class='btn btn-default flat-to-default turqoise pull-right' sc-on='click' sc-trigger='ok'>OK</button>
        </div>
        <div class='content'>
            <div class='code-wrapper'>
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
        </div>
    </sc-widget>
    <form id='search-form' class='form'>
        <input id='data-search' type="search" list='searchList' search-for="#search-wrapper" name="search" placeholder="search" class="input sky" autocomplete="off"/>
        <datalist id='searchList'>
            <option value='Widgets'/>
            <option value='Tools'/>
            <option value='Nav'/>
        </datalist>
    </form>
    <div id='search-wrapper' class='col xs12'>
        <h2>Widgets</h2>
        <p data-search-value="">
            http://www.ioxo.nl/latest/scope/widgets/<b>widgetname</b> <br/>
            JS at: <br/> http://www.ioxo.nl/latest/scope/widgets/<b>widgetname</b>/scope.widgets.<b>widgetname</b>.js <br/>
            CSS at: <br/> http://www.ioxo.nl/latest/scope/widgets/<b>widgetname</b>/scope.widgets.<b>widgetname</b>.css <br/>
            Examples: <br/> http://www.ioxo.nl/latest/scope/widgets/<b>widgetname</b>/example.html
        </p>
        <ul class='datalist'>
            <a href="/latest/scope/widgets/card-gallery/example.html">
                <li data-search-value="Widgets Card Gallery">
                    Card Gallery
                </li>
            </a>
            <a href="/latest/scope/widgets/cjax/example.html">
                <li data-search-value="Widgets CJAX">
                    CJAX
                </li>
            </a>
            <a href="/latest/scope/widgets/datatable/example.html">
                <li data-search-value="Widgets Datatable">
                    Datatable
                </li>
            </a>
            <a href="/latest/scope/widgets/dialog/example.html">
                <li data-search-value="Widgets Dialog">
                    Dialog
                </li>
            </a>
            <a href="/latest/scope/widgets/form/example.html">
                <li data-search-value="Widgets Form">
                    Form
                </li>
            </a>
            <a href="/latest/scope/widgets/notification/example.html">
                <li data-search-value="Widgets Notification">
                    Notification
                </li>
            </a>
            <a class='deprecated' href="/latest/scope/widgets/sidebar/example.html">
                <li data-search-value="Widgets Sidebar">
                    Sidebar <strong style='color: red;'>(deprecated)</strong>
                </li>
            </a>
            <a href="/latest/scope/widgets/slide/example.html">
                <li data-search-value="Widgets Slide">
                    Slide
                </li>
            </a>
            <a href="/latest/scope/widgets/split-container/example.html">
                <li data-search-value="Widgets SplitContainer">
                    SplitContainer
                </li>
            </a>
            <a href="/latest/scope/widgets/tabs/example.html">
                <li data-search-value="Widgets Tabs">
                    Tabs
                </li>
            </a>
            <a href="/latest/scope/widgets/youtube-player/example.html">
                <li data-search-value="Widgets Youtube player">
                    Youtube player
                </li>
            </a>
        </ul>
        <h2>Tools</h2>
        <p data-search-value="">
            http://www.ioxo.nl/latest/scope/tools/<b>toolname</b> <br/>
            JS at: <br/> http://www.ioxo.nl/latest/scope/tools/scope.tools.js <br/>
            CSS at: <br/> http://www.ioxo.nl/latest/scope/tools/scope.tools.css <br/>
            Examples: <br/> http://www.ioxo.nl/latest/scope/tools/<b>toolname</b>/example.html
        </p>
        <ul class='datalist'>
            <a href="/latest/scope/tools/datalist/example.html">
                <li data-search-value="Tools Datalist">
                    Datalist
                </li>
            </a>
            <a href="/latest/scope/tools/checkbox/example.html">
                <li data-search-value="Tools Checkbox">
                    Checkbox
                </li>
            </a>
            <a href="/latest/scope/tools/pop-over/example.html">
                <li data-search-value="Tools Popover">
                    Popover
                </li>
            </a>
            <a href="/latest/scope/tools/slidebox/example.html">
                <li data-search-value="Tools Slidebox">
                    Slidebox
                </li>
            </a>
        </ul>
        <h2>Nav</h2>
        <p data-search-value="">
            http://www.ioxo.nl/latest/scope/nav/<b>navname</b> <br/>
            JS at: <br/> http://www.ioxo.nl/latest/scope/nav/scope.nav.js <br/>
            CSS at: <br/> http://www.ioxo.nl/latest/scope/nav/scope.nav.css <br/>
            Examples: <br/> http://www.ioxo.nl/latest/scope/nav/<b>navname</b>/example.html
        </p>
        <ul class='datalist'>
            <a href="/latest/scope/nav/sidebar/example.html">
                <li data-search-value="Nav Sidebar">
                    Sidebar
                </li>
            </a>
            <a href="/latest/scope/nav/menu/example.html">
                <li data-search-value="Nav Menu">
                    Menu
                </li>
            </a>
        </ul>
    </div>
</div>


<sc-widget id='deprecated-dialog' class='dialog' data-widget='Scope.widgets.Dialog' data-backdrop='1' data-backdrop-dismiss='1'>
    <div class='title'>
        Deprecation warning
    </div>
    <div class='actions'>
        <button class='btn btn-default flat-to-default turqoise pull-right' sc-on='click' sc-trigger='dismiss'>CANCEL</button>
        <button class='btn btn-default flat-to-default turqoise pull-right' sc-on='click' sc-trigger='ok'>OK</button>
    </div>
    <div class='content'>
        This item will soon be removed from the code pool. <br/>
        Are you sure you want to continue?
    </div>
</sc-widget>

<script>
    sc('.deprecated').on('click', function(event){
        event.prev();
        url = this.attr('href');
        window['deprecated-dialog'].show();
    });
    sc('#deprecated-dialog').on('ok', function(event){
        location.href = url;
    })


    var searchForm = new Scope.widgets.Form( document.findOne('#search-form') );
</script>
