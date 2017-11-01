var Dialog = function( element ){
    this.element = element;

    var dialog = this;

    var dialogOk = this.element.getAttribute('dialog-ok');
    var dialogCancel = this.element.getAttribute('dialog-cancel');

    if(dialogOk || dialogCancel){

        var btnRow = this.element.querySelector('.row.btn-row');
        if(btnRow){
            btnRow.remove();
        }

        var btnRow = document.createElement('div');
        btnRow.className = 'row btn-row';

        if(typeof dialogOk == 'string'){
            var btnOk = document.createElement('button');
            btnOk.className = 'btn btn-dialog ok';
            btnOk.setAttribute('dialog-event', 'ok');
            btnOk.innerHTML = dialogOk;

            btnOk.addEventListener('click', function(e){

                var okEvent = new CustomEvent('ok', {cancelable: true});

                dialog.element.dispatchEvent(okEvent);
                if(!okEvent.defaultPrevented){
                    dialog.hide();
                }
            });

            btnRow.append( btnOk );
        }

        if(typeof dialogCancel == 'string'){
            var btnCancel = document.createElement('button');
            btnCancel.className = 'btn btn-dialog cancel';
            btnCancel.setAttribute('dialog-event', 'cancel');

            btnCancel.addEventListener('click', function(e){

                var cancelEvent = new CustomEvent('cancel', {cancelable: true});

                dialog.element.dispatchEvent(cancelEvent);
                if(!cancelEvent.defaultPrevented){
                    dialog.hide();
                }
            });

            btnCancel.innerHTML = dialogCancel;

            btnRow.append( btnCancel );
        }

        this.element.append( btnRow );
    }
}
Dialog.prototype.show = function( e ){
    var beforeShowEvent = new CustomEvent('beforeShow', {cancelable: true});

    this.element.dispatchEvent(beforeShowEvent);

    if(!beforeShowEvent.defaultPrevented){
        this.element.setAttribute('open', '');
    }

    var afterShowEvent = new CustomEvent('afterShow', {cancelable: true});

    this.element.dispatchEvent(afterShowEvent);
}
Dialog.prototype.hide = function( e ){
    var beforeHideEvent = new CustomEvent('beforeHide', {cancelable: true});

    this.element.dispatchEvent(beforeHideEvent);

    if(!beforeHideEvent.defaultPrevented){
        this.element.removeAttribute('open');
    }

    var afterHideEvent = new CustomEvent('afterHide', {cancelable: true});

    this.element.dispatchEvent(afterHideEvent);
}
Dialog.prototype.content = function( html ){
    if(typeof html == 'undefined'){
        return this.element.innerHTML;
    } else {
        this.element.innerHTML = html;
    }
}
_(document).when('ok', '#my-dialog', function(e){
    console.log('ok');
});
_(document).when('cancel', '#my-dialog', function(e){
    console.log('cancel');
});
_(document).when('beforeShow', '#my-dialog', function(e){
    console.log('beforeShow');
});
_(document).when('afterShow', '#my-dialog', function(e){
    console.log('afterShow');
});
_(document).when('beforeHide', '#my-dialog', function(e){
    console.log('beforeHide');
});
_(document).when('afterHide', '#my-dialog', function(e){
    console.log('afterHide');
});
