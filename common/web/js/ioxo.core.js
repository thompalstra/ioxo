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
})
