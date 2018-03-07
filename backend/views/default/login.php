<div class='wrapper'>
    <form id='login-form' class='form' method='POST' data-ajax="1" >
        <div class='col xs12'>
            <label id='login-form-status-label' data-status="Error" class='warning hidden'></label>
        </div>
        <div class='row col xs12'>
            <input
                class='input sky bordered default'
                type="username"
                name='LoginForm[username]'
                value='<?=$loginForm->username?>'
                pattern=".{5,35}"
                title="Username must be between 5 and 35 characters."
                placeholder="username"
                required />
        </div>
        <div class='row col xs12'>
            <input
                class='input sky bordered default'
                type="password"
                name='LoginForm[password]'
                value='<?=$loginForm->password?>'
                pattern=".{5,}"
                title="Password must be at least 6 characters."
                placeholder="password"
                required/>
        </div>
        <button type='submit' class='btn btn-default success default'>login</button>

        <a href="/login-recover" class='btn btn-default action flat'>forgot password</a>
    </form>
</div>

<script>
    var loginForm = new Scope.widgets.Form( document.findOne('#login-form') );
    loginForm.element.listen('afterajax', function(event){
        var statusLabel = document.findOne('#login-form-status-label');
        statusLabel.className = 'hidden';
        if( event.params.xhr.response.success == true ){
            statusLabel.attr('data-status', 'Success');
            statusLabel.className = 'status-label success';
            statusLabel.innerHTML = event.params.xhr.response.message;

            setTimeout(function(e){
                location.href = event.params.xhr.response.data.href;
            }, 1500);

        } else if( event.params.xhr.response.success == false ){
            statusLabel.className = 'status-label warning';
            statusLabel.attr('data-status', 'Error');
            statusLabel.innerHTML = event.params.xhr.response.message;
            console.log(event.params.xhr.response);
        } else {
            alert("Something went wrong whilst attempting to reach the server. \n Please refresh the browser or try again later..");
        }
    });
</script>
