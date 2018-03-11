<div class='wrapper'>
    <div class='col xs12 text-center'>
        <h2>Welcome to IOXO</h2>
        <p>
            Home of ScopeJS and ScopePHP. The minimialistic platforms.
        </p>
    </div>
    <div class='col xs12'>
        <div class='col xs12 ml10 left-ml1 right-ml1'>
            <div class='col xs4 hpad'>
                <div class='col xs12 sky pad'>
                    <h2>ScopeJS</h2>
                    <a href="/scope-js" class='btn btn-default flat-to-default epic pull-right'>more</a>
                </div>
            </div>
            <div class='col xs4 hpad'>
                <div class='col xs12 sky pad'>
                    <h2>ScopePHP</h2>
                    <a href="/scope-php" class='btn btn-default flat-to-default epic pull-right'>more</a>
                </div>
            </div>
            <div class='col xs4 hpad'>
                <div class='col xs12 sky pad'>
                    <h2>Support us</h2>
                    <a href="/support-us" class='btn btn-default flat-to-default epic pull-right'>more</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.on('ready', function(e){
        sc('.footer').on('swipestart', function(e){
            console.log( e.type );
        })
        sc('.footer').on('swipingleft', function(e){
            console.log( e.type, this.swipe.dispatched.swipingleft );
        })
        sc('.footer').on('swipeleft', function(e){
            console.log( e.type, this.swipe.dispatched.swipeleft );
        })
        sc('.footer').on('swipingright', function(e){
            console.log( e.type, this.swipe.dispatched.swipingright );
        })
        sc('.footer').on('swiperight', function(e){
            console.log( e.type, this.swipe.dispatched.swiperight );
        })
        sc('.footer').on('swipeend', function(e){
            console.log( e.type );
        })
    })
</script>
