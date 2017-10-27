// toggle
_(document).ready(function(e){
    _(document).when('click', '.toolstrip.list', function(e){

        e.stopPropagation();
        e.preventDefault();

        var row = this.parentNode;
        $(row).siblings().each(function(e){
            var ul = $($(this).find('ul'));
            if(ul.length > 0){
                ul.addClass('hidden');
            }
        });
        $($(this).find('ul')).toggleClass('hidden');
    });
    // close
    _(document).when('click', ":not(.toolstrip)", function(e){
        $(".toolstrip.list ul:not(.hidden)").each(function(index){
            $(this).addClass('hidden');
        });
    });
    // select value
    _(document).when('click', '.toolstrip.list > ul > li', function(e){

        e.stopPropagation();
        e.preventDefault();

        var ul = _(this.parentNode);
        var value = _(this).attribute('value');

        var input = _( ul.find('input')[0] );

        input.value(value);

        _(this).siblings('.active').each(function(i){
            _(this).removeClass('active');
        });
        _(this).addClass('active');

        input.trigger('input');

        _( _(this.parentNode.parentNode).find('.value strong') ).html(  this.innerHTML ) ;
        _(this.parentNode).addClass('hidden');
    });

    _(document).when('input', 'form[autosubmit] input', function(e){
        console.log('dsa');
        $(this).closest('form').submit();
    })

    _(document).when('click', '.datatable td', function(e){
        if(e.target.tagName != "INPUT"){
            var p = this.parentNode;
            var input = p.querySelectorAll('input[type="checkbox"]');
            if(input.length > 0){
                input[0].checked = (input[0].checked) ? false : true;
            }
        }
    });

    _(document).when('click', ".dropdown", function(e){

        e.stopPropagation();
        var el = this;

        _('.dropdown.open > ul').each(function(e){
            var p = this.parentNode;
            if(p != el){
                _(p).removeClass('open');
                _(this).slideUp(200);
            }
        });

        var ul = _(this).find('ul');
        if(ul.length > 0){
            _(this).toggleClass('open');
            _(ul[0]).slideToggle(200);
            console.log(ul);
        }
    });

    _(document).when('click', 'body', function(e){
        _('.dropdown.open').each(function(e){
            var ul = _(this).find('ul');
            if(ul.length > 0){
                _(this).removeClass('open');
                _(ul[0]).slideUp(200);
            }
        });
    });

    _(document).when('click', ".slidebox", function(e){
        var input = this.querySelector('input');
        var value = input.value;
        if(value == 'true'){
            return input.value = 'false';
        }
        return input.value = 'true';
    });
});
