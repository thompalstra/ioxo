window['PopOver'] = window['Scope']['tools']['PopOver'] = function( element ){
    this.element = element;
    this.pop = this.element.appendChild( document.create('div', {
        className: 'pop'
    }) );

    this.pop.innerHTML = "<h4 class='title'>" + (this.element.attr('data-title') || 'My popover') + "</h4><div class='content'>" + (this.element.attr('data-content') || 'My content') + "</div>";
}
