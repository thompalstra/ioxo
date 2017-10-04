$(document).on('click', ".menu.menu-default > li.dropdown" ,function(e){
    var ul = $(this).find('ul');

    if(ul.length > 0){
        $(this).toggleClass('open');
        ul.slideToggle(200);
    }

})
