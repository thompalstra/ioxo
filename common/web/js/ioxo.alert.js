var Alert = function( element ){
    this.element = element;

    var btnRow = this.element.querySelector('.row.btn-row');

    if(btnRow){
        btnRow.remove();
    }

    var btnDismiss = this.element.querySelector('.alert-dismiss');

    if(btnDismiss){
        btnDismiss.remove();
    }

    var btnRow = document.createElement('div');
    btnRow.className = 'row btn-row';

    btnOk = document.createElement('button');
    btnOk.className = 'btn btn-alert';
    var alertOk = this.element.getAttribute('alert-ok');
    btnOk.innerHTML = alertOk ? alertOk : 'Ok';
    btnOk.addEventListener('click', function(){

        var okEvent = new CustomEvent('ok', {cancelable: true});
        this.element.dispatchEvent(okEvent);
        if(!okEvent.defaultPrevented){
             this.hide();
         }

    }.bind(this));

    btnRow.appendChild( btnOk );

    btnDismiss = document.createElement('button');
    btnDismiss.className = 'alert-dismiss';

    btnDismiss.addEventListener('click', function(){

        var dismissEvent = new CustomEvent('dismiss', {cancelable: true});
        this.element.dispatchEvent(dismissEvent);
        if(!dismissEvent.defaultPrevented){
            this.hide();
        }

    }.bind(this));

    this.element.appendChild( btnDismiss );

    this.element.appendChild( btnRow );
}


Alert.prototype.show = function( e ){
    var beforeShowEvent = new CustomEvent('beforeShow', {cancelable: true});

    this.element.dispatchEvent(beforeShowEvent);

    if(!beforeShowEvent.defaultPrevented){
        this.element.setAttribute('open', '');
    }

    var afterShowEvent = new CustomEvent('afterShow', {cancelable: true});

    this.element.dispatchEvent(afterShowEvent);
}
Alert.prototype.hide = function( e ){
    var beforeHideEvent = new CustomEvent('beforeHide', {cancelable: true});

    this.element.dispatchEvent(beforeHideEvent);

    if(!beforeHideEvent.defaultPrevented){
        this.element.removeAttribute('open');
    }

    var afterHideEvent = new CustomEvent('afterHide', {cancelable: true});

    this.element.dispatchEvent(afterHideEvent);
}
