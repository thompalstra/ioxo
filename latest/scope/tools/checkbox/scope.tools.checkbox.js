document.listen( 'click', 'input[type="checkbox"].sc-checkbox', function(e){
    this.attr('checked', this.checked );
})
