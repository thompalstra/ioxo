window['YouTubePlayer'] = window['Scope']['widgets']['YouTubePlayer'] = function( source ){
    this.element = null;
    this.source = source;
    this.list = [];
    this.videos = [];

    this.apiKey = this.source.attr('data-api-key');



    this.title = this.source.attr('data-title') || 'My title';
    this.playlist = this.source.attr('data-playlist') || true;
    this.autoplayFirst = this.source.attr('data-autoplay-first') || true;
    this.autoplay = this.source.attr('data-autoplay') || true;

    var ctr = 0;
    var group = [];

    this.source.children.forEach(function(el){
        if( ctr == 20 ){
            group.push( el.value );
            this.list.push( group.join(',') );
            group = [];
            ctr = 0;
        } else {
            group.push( el.value );
            ctr++;
        }
    }.bind(this));

    if( group.length > 0 ){
        this.list.push( group.join(',') );
        group = [];
    }

    var wrapper = document.create('div', {
        className: 'youtube-player',
        'sc-widget-status': 'pending',
        'data-playlist': this.playlist == true ? '1' : '0'
    });

    this.source.parentNode.replaceChild( wrapper, this.source );
    this.element = wrapper;

    this.fetch( 0, this.list, function(){
        this.createWidget();
    }.bind(this) )
}

extend( YouTubePlayer ).with({
    fetch: function( index, list, complete ){
        if( index < list.length ){

            var url = "https://www.googleapis.com/youtube/v3/videos?id={id}&key={apiKey}&part=snippet";
            url = url.replace('{id}', list[index]);
            url = url.replace('{apiKey}', this.apiKey);

            Scope.get( {
                url: url,
                responseType: 'json',
                onsuccess: function( xhr ){
                    xhr.response.items.forEach(function(item){
                        this.videos.push({
                            id: item.id,
                            channelTitle: item.snippet.channelTitle,
                            title: item.snippet.title,
                            thumbnail_medium: item.snippet.thumbnails.medium
                        });
                    }.bind(this))

                    var newIndex = index + 1;
                    this.fetch( newIndex, list, complete );
                }.bind(this),
                onerror: function(){
                }
            });
        } else {
            complete.call(this, null);
        }
    },
    createWidget: function( ){
        var topWrapper = this.element.appendChild( document.create('div', {
            className: 'top-wrapper'
        } ) );

        var iframeWrapper = topWrapper.appendChild( document.create('div',{
            className: 'iframe-wrapper'
        } ) );

        var iframe = iframeWrapper.appendChild( document.create('iframe', {
            frameBorder: 0
        } ) );

        iframe.style['height'] = iframe.offsetWidth * 9/16;

        if( this.playlist == true ){
            var listWrapper = topWrapper.appendChild( document.create('div') );
            listWrapper.className = 'playlist-wrapper';
            var header = document.create('p', {
                className: 'playlist-header',
                innerHTML: this.title
            });

            var list = document.create('ul', {
                'sc-scroll-default': ''
            });

            for(var i in this.videos){
                var content = "\
                    <div class='thumb'><img src='"+this.videos[i].thumbnail_medium.url+"'/></a></div>\
                    <div class='content'><normal>" + this.videos[i].title+ "</normal>" + "</br><small>" + this.videos[i].channelTitle + "</small></div>\
                ";

                var item = document.create('li', {
                    innerHTML: content,
                    'data-id': this.videos[i].id,
                    title: this.videos[i].title
                });

                item = list.appendChild(item);
                item.on('click', function(e){
                    this.player.playIndex( this.element.index(), this.player.autoplay );
                }.bind({
                    player: this,
                    element: item
                }));
            }
            listWrapper.appendChild(header);
            listWrapper.appendChild(list);
        }

        var videoDetailWrapper = this.element.appendChild( document.create('div', {
            className: 'video-detail-wrapper'
        }) );

        var videoDetailTitle = videoDetailWrapper.appendChild( document.create('normal', {
            className: 'title'
        }) );

        var videoDetailChannel = videoDetailWrapper.appendChild( document.create('small', {
            className: 'channel'
        }) );

        iframeWrapper.appendChild( videoDetailWrapper.cloneNode(true) );

        window.addEventListener('resize', function(e){
            this.element.findOne('iframe').css({
                'height': iframe.offsetWidth * 9/16
            });
        }.bind(this));

        this.playIndex(0,this.autoplayFirst);

        this.element.attr('sc-widget-status', 'done');
    },
    playIndex: function( index, autoplay ){
        var frame = this.element.findOne('iframe');

        if( this.playlist == true ){
            var items = this.element.find('ul li');
            items.forEach(function(el){
                el.removeClass('active');
            })
            var item = items[index];
            item.addClass('active');
        }

        this.element.find('.video-detail-wrapper .title').forEach(function(el){
            el.innerHTML = this.videos[index].title;
        }.bind(this));

        this.element.find('.video-detail-wrapper .channel').forEach(function(el){
            el.innerHTML = this.videos[index].channelTitle;
        }.bind(this));

        this.setVideoId( this.videos[index].id, autoplay );
    },
    setVideoId: function( videoId, autoplay ){
        var frame = this.element.findOne('iframe');

        if( autoplay == true ){
            frame.attr('src', 'https://www.youtube.com/embed/' + videoId + "?autoplay=1");
        } else {
            frame.attr('src', 'https://www.youtube.com/embed/' + videoId);
        }
    }
});
