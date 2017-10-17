// $(document).on('click', ".menu.menu-default > li.dropdown" ,function(e){
_(document).when('click', ".menu.menu-default > li.dropdown", function(e){
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
// _(document).when('click', "*:not(.menu) *:not(.item)", function(e){
// // $(document).on('click', "*:not(.menu *)", function(e){
//     $('.open').each(function(e){
//         var ul = $(this).find('ul');
//         if(ul.length > 0){
//             $(this).removeClass('open');
//             ul.slideUp(200);
//         }
//     });
// });

// $(document).on('click', '.slidebox', function(e){
_(document).when('click', ".slidebox", function(e){

    console.log(this);

    var input = this.querySelector('input');
    var value = input.value;
    if(value == 'true'){
        return input.value = 'false';
    }
    return input.value = 'true';
})
