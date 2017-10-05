$(document).on('click', ".menu.menu-default > li.dropdown" ,function(e){
    // e.stopPropagation();

    var ul = $(this).find('ul');
    if(ul.length > 0){
        $(this).toggleClass('open');
        ul.slideToggle(200);
    }
})
$(document).on('click', ":not(.menu *)", function(e){
    // e.stopPropagation();
    // e.preventDefault();
    //
    // console.log(e.target);
    //
    // $('.open').each(function(e){
    //     console.log(this);
    //     var ul = $(this).find('ul');
    //     if(ul.length > 0){
    //         $(this).removeClass('open');
    //         ul.slideUp(200);
    //     }
    // });
})
