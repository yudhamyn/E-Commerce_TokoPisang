

var inputErrorEl = {
    '.error--email': 'email',
    '.error--password': 'password',
}

function request_login()
{
    resetInputErrors(inputErrorEl)
    $.ajax({
        url: api_url('login'),
        data: JSON.stringify({
            email: $('#login--form #login--email').val(),
            password: $('#login--form #login--password').val()
        }),
        method: 'POST',
        headers: HttpHeaders,
        error: function(err) {
            
            let res = err.responseJSON

            showInputErrors(inputErrorEl,res.errors)

        },
        success: function(res) {
            
            if(res.status)
            {
                _notif('#alert-message','success',res.message)
                set_cookie('_token',res.data.token)
                if(res.data.primary)
                {
                    redirect('admin')
                }else{
                    redirect('')
                }
            }else{
                _notif('#alert-message','danger',res.message)
            }

        }
    });
}

$(document).on('submit','#login--form', function(e){
    e.preventDefault()
    request_login()
})