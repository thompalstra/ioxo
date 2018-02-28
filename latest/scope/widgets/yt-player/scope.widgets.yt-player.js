window['ScopeYTPlayer'] = window['Scope']['widgets']['YTPlayer'] = function( querySelector ){
    this.source = document.findOne( querySelector );
    this.list = [];
    this.videos = [];
    this.apiKey = this.source.attr('widget-api-key');
    this.title = this.source.attr('widget-title');
    this.autoplayFirst = this.source.attr('widget-autoplay-first') || true;
    this.autoplay = this.source.attr('widget-autoplay') || true;

    this.source.children.forEach(function(el){
        this.list.push(el.value);
    }.bind(this));

    var wrapper = document.createElement('div');

    wrapper.className = 'scope-yt-player';
    wrapper.attr('sc-widget-status', 'pending');

    this.source.parentNode.replaceChild( wrapper, this.source );
    this.element = wrapper;

    this.fetch( 0, this.list, function(){
        this.createWidget();
    }.bind(this) )
}

extend( ScopeYTPlayer ).with({
    fetch: function( index, list, complete ){
        if( index < list.length ){
            var url = "https://www.googleapis.com/youtube/v3/videos?id=" + list[index] + "&key=" + this.apiKey + "&part=snippet";
            Scope.get( {
                url: url,
                responseType: 'json',
                onsuccess: function( xhr ){
                    var item = xhr.response.items[0].snippet;
                    this.videos.push({
                        id: xhr.response.items[0].id,
                        channelTitle: item.channelTitle,
                        title: item.title,
                        thumbnail_medium: item.thumbnails.medium
                    });
                    var newIndex = index + 1;
                    this.fetch( newIndex, list, complete );
                }.bind(this),
                onerror: function(){
                    console.log('error');
                }
            });
        } else {
            complete.call(this, null);
        }
    },
    createWidget: function( ){

        var topWrapper = this.element.appendChild( document.createElement('div') );
        topWrapper.className = 'top-wrapper';

        var iframeWrapper = topWrapper.appendChild( document.createElement('div') );
        iframeWrapper.className = 'iframe-wrapper';
        var iframe = iframeWrapper.appendChild( document.createElement('iframe') );
        iframe.attr('frameborder', '0');

        iframe.css({
            'height': iframe.offsetWidth * 9/16
        });

        var listWrapper = topWrapper.appendChild( document.createElement('div') );
        listWrapper.className = 'playlist-wrapper';
        var header = document.createElement('p');
        header.className = 'playlist-header';
        header.innerHTML = this.title;
        var list = document.createElement('ul');
        list.attr('sc-scroll-default', '');

        for(var i in this.videos){
            var item = document.createElement('li');
            item.innerHTML =
                "<div class='thumb'><img src='"+this.videos[i].thumbnail_medium.url+"'/></a></div>"+
                "<div class='content'><normal>" + this.videos[i].title+ "</normal>" + "</br><small>" + this.videos[i].channelTitle + "</small></div>";
            item.attr('data-id', this.videos[i].id);
            item.attr('title', this.videos[i].title);
            item = list.appendChild(item);
            item.listen('click', function(e){
                this.player.playIndex( this.element.index(), this.player.autoplay );
            }.bind({
                player: this,
                element: item
            }));
        }
        listWrapper.appendChild(header);
        listWrapper.appendChild(list);

        var videoDetailWrapper = this.element.appendChild( document.createElement('div') );
        videoDetailWrapper.className = 'video-detail-wrapper';

        var videoDetailTitle = videoDetailWrapper.appendChild( document.createElement('normal') );
        videoDetailTitle.className = 'title';
        videoDetailTitle.innerHTML = '';

        var videoDetailChannel = videoDetailWrapper.appendChild( document.createElement('small') );
        videoDetailChannel.className = 'channel';
        videoDetailChannel.innerHTML = '';

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
        var items = this.element.find('ul li');
        items.forEach(function(el){
            el.removeClass('active');
        })
        var item = items[index];
        item.addClass('active');

        this.element.find('.video-detail-wrapper .title').forEach(function(el){
            el.innerHTML = this.videos[index].title;
        }.bind(this));

        this.element.find('.video-detail-wrapper .channel').forEach(function(el){
            el.innerHTML = this.videos[index].channelTitle;
        }.bind(this));

        this.setVideoId( item.attr('data-id'), autoplay );
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
