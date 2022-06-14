
function userSigned()
{
    $.ajax({
        url: api_url('profile'),
        type: 'GET',
        dataType: 'json',
        headers: HttpHeaders,
        error: function() {
            
        },
        success: function(res) {
            
            if(res.status){

                let data = res.data;

                $('#navbar--user-name').html(data.name)

            }

        }
    });
}

userSigned()