// toggle
$(document).on('click', '.toolstrip.list', function(e){

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
$(document).on('click', "*:not(.toolstrip.list)", function(e){
    $(".toolstrip.list ul:not(.hidden)").each(function(index){
        $(this).addClass('hidden');
    });
});

// select value
$(document).on('click', '.toolstrip.list > ul > li', function(e){

    e.stopPropagation();
    e.preventDefault();

    var ul = $(this.parentNode);
    var value = $(this).attr('value');

    var input = $( ul.find('input') );
    input.val(value);

    $(this).siblings('.active').each(function(i){
        $(this).removeClass('active');
    });
    $(this).addClass('active');

    input.trigger('input');
    $( $(this.parentNode.parentNode).find('.value strong') ).html(  this.innerHTML ) ;
    $(this.parentNode).addClass('hidden');
});

// submit on select
// $(document).on('input', '.toolstrip input', function(e){
//     var form = $(this).parents('form');
//     form.submit();
// });


$(document).on('input', 'form[autosubmit] *', function(e){
    $(this).parents('form').submit();
})
