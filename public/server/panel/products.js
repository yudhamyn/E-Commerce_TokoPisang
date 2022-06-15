function requestProducts()
{
    $('#product--data').DataTable().destroy();
    $('#product--data').DataTable({
        serverSide: true,
        deferRender: true,
        ajax: {
            url: api_url('admin/product'),
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
                data: null,
                render: function(key){
                    return `<img src="${url(key.image)}" alt="${key.name}" class="img-thumbnail" width="150px">`
                }
            },
            {
                data: 'name'
            },
            {
                data: null,
                render: function(key){
                    return 'Rp'+toIdr(key.price)
                }
            },
            {
                data: null,
                render: function(key){
                    if(key.stock == 0)
                    {
                        return `<small class="text-muted">Stok habis</small>`
                    }else{
                        return `<small class="text-muted">Stok <b>${key.stock}</b></small>`
                    }
                }
            },
            {
                data: 'weight'
            },
            {
                data: null,
                render: function(key){
                    let btnId = randId(7)

                    $(document).on('click','.'+btnId+'-edit', function(e){
                        e.preventDefault()
                        $('#modalEdit .image--preview').attr('src',url(key.image))
                        $('#modalEdit [name="name"]').val(key.name)
                        $('#modalEdit [name="description"]').val(key.description)
                        $('#modalEdit [name="price"]').val(key.price)
                        $('#modalEdit [name="stock"]').val(key.stock)
                        $('#modalEdit [name="weight"]').val(key.weight)
                        $('#modalEdit').modal('show')

                        $(document).on('submit','#modalEdit form', function(e){
                            e.preventDefault()
                            updateProduct(key.id)
                        })

                    })

                    $(document).on('click','.'+btnId+'-delete', function(e){
                        e.preventDefault()
                        $('#modalDelete').modal('show')

                        $(document).on('click','#modalDelete button[type="submit"]', function(e){
                            e.preventDefault()
                            deleteProduct(key.id)
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

requestProducts()


var inputErrorEl = {
    '#modalAdd .error--image': 'image',
    '#modalAdd .error--name': 'name',
    '#modalAdd .error--description': 'description',
    '#modalAdd .error--price': 'price',
    '#modalAdd .error--stock': 'stock',
    '#modalAdd .error--weight': 'weight',
}

function saveProduct()
{
    resetInputErrors(inputErrorEl)
    let data = new FormData()
    data.append('image',$('#modalAdd [name="image"]')[0].files[0])
    data.append('name',$('#modalAdd [name="name"]').val())
    data.append('description',$('#modalAdd [name="description"]').val())
    data.append('price',$('#modalAdd [name="price"]').val())
    data.append('stock',$('#modalAdd [name="stock"]').val())
    data.append('weight',$('#modalAdd [name="weight"]').val())
    $.ajax({
        url: api_url('admin/product'),
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

                requestProducts()

            }else{

                _notif('#modalAdd .alert--message','danger',res.message)

            }
        }
    })
}

var inputErrorEl2 = {
    '#modalEdit .error--image': 'image',
    '#modalEdit .error--name': 'name',
    '#modalEdit .error--description': 'description',
    '#modalEdit .error--price': 'price',
    '#modalEdit .error--stock': 'stock',
    '#modalEdit .error--weight': 'weight',
}

function updateProduct(id)
{
    resetInputErrors(inputErrorEl2)
    let data = new FormData()
    data.append('image',$('#modalEdit [name="image"]')[0].files[0]? $('#modalEdit [name="image"]')[0].files[0] : '')
    data.append('name',$('#modalEdit [name="name"]').val())
    data.append('description',$('#modalEdit [name="description"]').val())
    data.append('price',$('#modalEdit [name="price"]').val())
    data.append('stock',$('#modalEdit [name="stock"]').val())
    data.append('weight',$('#modalEdit [name="weight"]').val())
    $.ajax({
        url: api_url('admin/product/'+id+'/update'),
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

                requestProducts()

            }else{

                _notif('#modalEdit .alert--message','danger',res.message)

            }
        }
    })
}

function deleteProduct(id)
{
    $.ajax({
        url: api_url('admin/product/'+id),
        type: 'DELETE',
        headers: HttpHeaders,
        error: function(err) {
            
        },
        success: function(res) {
            $('#modalDelete').modal('hide')
            if(res.status)
            {
                _notif('#alert-message','success',res.message)

                requestProducts()

            }else{

                _notif('#alert-message','danger',res.message)

            }
        }
    })
}

$(document).on('submit', '#modalAdd form', function(e){
    e.preventDefault()
    saveProduct()
})