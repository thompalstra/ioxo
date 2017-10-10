$(document).on('click', '.toolstrip.list', function(e){

    var row = this.parentNode;

    $(row).siblings().each(function(e){
        var ul = $($(this).find('ul'));
        if(ul.length > 0){
            ul.addClass('hidden');
        }
    });
    $($(this).find('ul')).toggleClass('hidden');
});
$(document).on('click', '.toolstrip.list li', function(e){
    var ul = $(this.parentNode);
    var value = $(this).attr('value');

    var input = $( ul.find('input') );
    input.val(value);

    $(this).siblings('.active').each(function(i){
        $(this).removeClass('active');
    });
    $(this).addClass('active');

    input.trigger('input');
});
$(document).on('input', '.toolstrip input', function(e){
    var form = $(this).parents('form');
    form.submit();
});
