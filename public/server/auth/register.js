

var inputErrorEl = {
    '.error--name': 'name',
    '.error--email': 'email',
    '.error--phone': 'phone',
    '.error--password': 'password',
    '.error--password-confirmation': 'password_confirmation',
}

function request_register()
{
    resetInputErrors(inputErrorEl)
    $.ajax({
        url: api_url('register'),
        data: JSON.stringify({
            name: $('#register--form #register--name').val(),
            email: $('#register--form #register--email').val(),
            phone: $('#register--form #register--phone').val(),
            password: $('#register--form #register--password').val(),
            password_confirmation: $('#register--form #register--password-confirmation').val()
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
                redirectWithNotif('login',{
                    selector: '#alert-message',
                    type: 'success',
                    message: res.message,
                    scroll: true,
                })
            }else{
                _notif('#alert-message','danger',res.message)
            }

        }
    });
}

$(document).on('submit','#register--form', function(e){
    e.preventDefault()
    request_register()
})