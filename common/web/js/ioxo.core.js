$(document).on('click', ".menu.menu-default > li.dropdown" ,function(e){

    e.stopPropagation();

    var ul = $(this).find('ul');
    if(ul.length > 0){
        $(this).toggleClass('open');
        ul.slideToggle(200);
    }
    $(this).siblings('.open').each(function(e){

        var ul = $(this).find('ul');
        $(this).removeClass('open');
        if(ul.length > 0){
            ul.slideUp(200);
        }
    });
})
$(document).on('click', "*:not(.menu *)", function(e){
    $('.open').each(function(e){
        var ul = $(this).find('ul');
        if(ul.length > 0){
            $(this).removeClass('open');
            ul.slideUp(200);
        }
    });
});


var ioxo = function(){

}

$(document).on('click', '.slidebox', function(e){
    var input = $( $(this).find('input') )
    var value = input.val();
    if(value == 'true'){
        return input.val('false');
    }
    return input.val('true');
})
