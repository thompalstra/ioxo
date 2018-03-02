<div class='wrapper'>
    <div id='w0-tabs' class='tabs'>
        <ul class="tabcontrols">
            <li sc-target="#w0-tabs-about-ioxo" class="active">About <strong>IOXO</strong></li>
            <li sc-target="#w0-tabs-widgets">Widgets</li>
            <li sc-target="#w0-tabs-tools">Tools</li>
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
                <p>
                    <h2 id='toggle-jquery-vs-scope' class='code-toggle col xs12' style='margin: 0;'>jQuery vs ScopeJS</h2>
                    <pre class='col xs12' style='background-color: #333; margin: 0; color: #f2f2f2; padding-top: 0; padding-bottom: 0; height: 0; overflow: hidden;'><code>
                <strong>Casting</strong>

                    var myDiv = $('.my-div');

                    <span style='color: #8BC34A'>// returns a jQuery object which servers as a wrapper for one or more native elements.
                    // Matched elements get wrapped inside a jQuery object which has it's own functionality
                    // this means each element inside the wrapper does NOT support any of the functions and
                    // are required to be casted back to jQuery like: $( HTMLElement ) or $( jQueryElements[0] )</span>

                    var myDiv = document.find('.my-div');

                    <span style='color: #8BC34A'>// returns an object of the NodeList class, which is the native wrapper standard
                    // finding elements don't get wrapped so when dealing with large amounts of elements, queries will be quicker</span>

                <strong>Document queries</strong>

                    <span style='color: #8BC34A'>// accessing the native/first element in jQuery could be done as</span>

                    var myNativeDiv = myDiv[0];

                    <span style='color: #8BC34A'>// or</span>

                    var myNativeDiv = myDiv.element();

                    <span style='color: #8BC34A'>// getting a single element in ScopeJS is done by using a different find method</span>

                    var myDiv = document.findOne('.my-div');

                    <span style='color: #8BC34A'>// this means you can shorten the times it takes to query drastically,
                    // because this means the browser can decide to return only one element, as opposed to ALL element matching</span>

                <strong>Internal functions</strong>

                    <strong>addClass</strong>

                    <span style='color: #8BC34A'>// ScopeJS uses native methods to perform simple tasks, such as adding a class</span>

                    HTMLElement.protoype.addClass = function( className ){
                        this.classList.add( className );
                    }

                    <span style='color: #8BC34A'>// whereas jQuery uses a more "compatible" mode</span>

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

                <strong>Conclusion</strong>

                    <span style='color: #8BC34A'>// whilst ScopeJS utilizes native methodology that is the current <a href="https://html.spec.whatwg.org/dev/" style='color: white'>Living Standard</a>,
                    // it might not be compatible with "very old" platforms.
                    // Always be sure to check the platforms you're building for, to see what is the <a href="https://html.spec.whatwg.org/dev/" style='color: white'>Living Standard</a> for that platform.</span>

                </code></pre>
                </p>
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
                    <a href="/latest/scope/widgets/datatable/sidebar.html">
                        <li>
                            Sidebar
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
                    <a href="/latest/scope/widgets/slide/example.html">
                        <li>
                            Slide
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
                </ul>
            </li>
        </ul>
    </div>
</div>
<script>
    var w0tabs = new Tabs( document.findOne('#w0-tabs') );

    sc('#toggle-jquery-vs-scope').listen('click', function(e){
        sc('#toggle-jquery-vs-scope + pre')[0].slideToggle(1000);
    })
</script>
