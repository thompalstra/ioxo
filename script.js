function showPageCode( querySelector, url ){
    Scope.get({
        url: url,
        onsuccess: function(xhr){
            var toggler = document.findOne( querySelector ).appendChild( document.create('div', {
                className: 'col xs12 code-toggle',
                innerHTML: 'toggle code'
            }) );
            var pre = document.findOne( querySelector ).appendChild( document.create('pre', {
                className: 'code-preview',
                style: 'height: 0px; padding-top: 0px; padding-bottom: 0px',
                innerHTML: xhr.response.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;")
            }) );
            toggler.listen('click',function(e){
                document.findOne(querySelector + ' .code-preview').slideToggle(300);
            });
        }
    });
}
