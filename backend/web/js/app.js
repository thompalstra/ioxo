var App = function(){
};
App.prototype.stringToParams = function( string ){
    var out = {};
    if(string != null){
        var split = string.split(';');
        for(var i in split){
            var innerSplit = split[i].split('=');
            out[innerSplit[0]] = innerSplit[1];
        }
    }
    return out;
}
var actions = {
    addNewsContent: function(params){
        params.e.preventDefault();

        var id = params.datakey;
        var type = params.type;

        var type = $(this).attr('type');
        $.ajax({
            url: '/news/new-content',
            method: 'POST',
            data: {
                'news_item_id': params.datakey,
                'type': params.type,
            },
            success: function(resp){
                $('#newsitem-content_old').load( location.href + " #newsitem-content_old-inner" );
            }
        });
    },
    removeNewsContent: function(params){
        params.e.preventDefault();

        var id = params.datakey;

        var type = $(this).attr('type');
        $.ajax({
            url: '/news/remove-content',
            method: 'POST',
            data: {
                'news_content_id': params.datakey
            },
            success: function(resp){
                $('#newsitem-content_old').load( location.href + " #newsitem-content_old-inner" );
            }
        });
    },
    addNewCategory: function(params){
        params.e.preventDefault();

        showTitlePrompt();

        function showTitlePrompt(title){
            var title = prompt("Title", (title == null ) ? '' : title );
            if(title){
                if(validateTitle(title) == true){
                    showUrlPrompt(title, null);
                } else {
                    showTitlePrompt(title);
                }
            }
        }
        function validateTitle(str){
            if(str.length <= 2){
                alert("Title must be longer than 2 characters");
            } else if(str.length >= 40){
                alert("Title must be shorter than 40 characters");
            } else {
                return true;
            }
        }
        function showUrlPrompt(title, url){
            var url = prompt("Url", (url == null ) ? '' : url );
            var title = title;
            if(url){
                if(validateUrl(url) == true){
                    $.ajax({
                        url: '/news/new-category',
                        method: 'POST',
                        data: {
                            'url': url,
                            'title': title
                        },
                        success: function(resp){
                            $("[name='NewsItem[news_category_id]']").load( location.href + " [name='NewsItem[news_category_id]'] > *" );
                        }
                    });
                } else {
                    showUrlPrompt(title, url);
                }
            }
        }
        function validateUrl(str){

            console.log( /^([A-Za-z]|[0-9]|_|-)+$/.test(str) );

            if(str.length <= 2){
                alert("Url must be longer than 2 characters");
            } else if(str.length >= 40){
                alert("Url must be shorter than 40 characters");
            } else if(!/^([A-Za-z]|[0-9]|_|-)+$/.test(str)){
                alert("Url may only contain (a-z, A-Z, 0-9, -, _) ");
            } else {
                return true;
            }
        }
    }
};



App.prototype.actions = actions;


var app = new App();

_(document).when('click', '[action]', function(e){

    var action = this.getAttribute('action');
    var params = app.stringToParams( this.getAttribute('params') );

    params.e = e;

    return app.actions[action].call(this, params );
});
