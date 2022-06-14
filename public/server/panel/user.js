
function requestUsers()
{
    $('#user--data').DataTable().destroy();
    $('#user--data').DataTable({
        serverSide: true,
        deferRender: true,
        ajax: {
            url: api_url('admin/user'),
            type: "GET",
            headers: HttpHeaders,
            dataSrc: 'data',
            processing: true
        },
        columns: [
            {
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1 + '.';
                }
            },
            {
                data: 'name'
            },
            {
                data: 'phone'
            },
            {
                data: 'email'
            },
            {
                data: 'level.name'
            },
            {
                data: null,
                render: function(key){
                    let btnId = randId(7)

                    $(document).on('click','.'+btnId+'-edit', function(e){
                        e.preventDefault()
                        $('#modalEdit [name="role"]').val(key.level_id).trigger('change')
                        $('#modalEdit [name="phone"]').val(key.phone)
                        $('#modalEdit [name="name"]').val(key.name)
                        $('#modalEdit [name="email"]').val(key.email)
                        $('#modalEdit').modal('show')

                        $(document).on('submit','#modalEdit form', function(e){
                            e.preventDefault()
                            updateUser(key.id)
                        })

                    })

                    $(document).on('click','.'+btnId+'-delete', function(e){
                        e.preventDefault()
                        $('#modalDelete').modal('show')

                        $(document).on('click','#modalDelete button[type="submit"]', function(e){
                            e.preventDefault()
                            deleteUser(key.id)
                        })

                    })

                    return `
                        <button class="btn btn-primary btn-sm m-1 ${btnId}-edit">Edit</button>
                        <button class="btn btn-danger btn-sm m-1 ${btnId}-delete">Hapus</button>
                    `
                }
            },
        ],
    });
}

requestUsers()


var inputErrorEl = {
    '#modalAdd .error--role': 'role',
    '#modalAdd .error--name': 'name',
    '#modalAdd .error--phone': 'phone',
    '#modalAdd .error--email': 'email',
    '#modalAdd .error--password': 'password',
    '#modalAdd .error--password-confirmation': 'password_confirmation',
}

function saveUser()
{
    resetInputErrors(inputErrorEl)
    let data = new FormData()
    data.append('role',$('#modalAdd [name="role"]').val())
    data.append('name',$('#modalAdd [name="name"]').val())
    data.append('phone',$('#modalAdd [name="phone"]').val())
    data.append('email',$('#modalAdd [name="email"]').val())
    data.append('password',$('#modalAdd [name="password"]').val())
    data.append('password_confirmation',$('#modalAdd [name="password_confirmation"]').val())
    $.ajax({
        url: api_url('admin/user'),
        data: data,
        type: 'POST',
        contentType: false,
        processData: false,
        headers: {
            'Authorization': "Bearer "+get_cookie('_token')
        },
        error: function(err) {
            let res = err.responseJSON

            showInputErrors(inputErrorEl,res.errors)
        },
        success: function(res) {
            if(res.status)
            {
                $('#modalAdd').modal('hide')
                $('#modalAdd form')[0].reset()
                _notif('#alert-message','success',res.message)

                requestUsers()

            }else{

                _notif('#modalAdd .alert--message','danger',res.message)

            }
        }
    })
}

var inputErrorEl2 = {
    '#modalEdit .error--role': 'role',
    '#modalEdit .error--name': 'name',
    '#modalEdit .error--phone': 'phone',
    '#modalEdit .error--email': 'email',
    '#modalEdit .error--password': 'password',
    '#modalEdit .error--password-confirmation': 'password_confirmation',
}

function updateUser(id)
{
    resetInputErrors(inputErrorEl2)
    let data = new FormData()
    data.append('role',$('#modalEdit [name="role"]').val())
    data.append('name',$('#modalEdit [name="name"]').val())
    data.append('phone',$('#modalEdit [name="phone"]').val())
    data.append('email',$('#modalEdit [name="email"]').val())
    data.append('password',$('#modalEdit [name="password"]').val())
    data.append('password_confirmation',$('#modalEdit [name="password_confirmation"]').val())
    $.ajax({
        url: api_url('admin/user/'+id+'/update'),
        data: data,
        type: 'POST',
        contentType: false,
        processData: false,
        headers: {
            'Authorization': "Bearer "+get_cookie('_token')
        },
        error: function(err) {
            let res = err.responseJSON

            showInputErrors(inputErrorEl2,res.errors)
        },
        success: function(res) {
            if(res.status)
            {
                $('#modalEdit').modal('hide')
                $('#modalEdit form')[0].reset()
                _notif('#alert-message','success',res.message)

                requestUsers()

            }else{

                _notif('#modalEdit .alert--message','danger',res.message)

            }
        }
    })
}

function deleteUser(id)
{
    $.ajax({
        url: api_url('admin/user/'+id),
        type: 'DELETE',
        headers: HttpHeaders,
        error: function(err) {
            
        },
        success: function(res) {
            $('#modalDelete').modal('hide')
            if(res.status)
            {
                _notif('#alert-message','success',res.message)

                requestUsers()

            }else{

                _notif('#alert-message','danger',res.message)

            }
        }
    })
}

$(document).on('submit', '#modalAdd form', function(e){
    e.preventDefault()
    saveUser()
})