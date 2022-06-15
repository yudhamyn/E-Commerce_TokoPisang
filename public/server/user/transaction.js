
function requestTransaction()
{
    $('#transaction--data').DataTable().destroy();
    $('#transaction--data').DataTable({
        serverSide: true,
        deferRender: true,
        ajax: {
            url: api_url('user/transactions'),
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
                data: 'purchase_order'
            },
            {
                data: 'created_at'
            },
            {
                data: null,
                render: function(key){
                    return 'Rp'+toIdr(key.total)
                }
            },
            {
                data: null,
                render: function(key){
                    let st_badge = '',
                        btnPngiriman = randId(5)+'-log-sent'
                    if(key.status == '0')
                    {
                        st_badge = `<span class="badge badge-warning">Menunggu</span>`
                    }else if(key.status == '1'){
                        st_badge = `<span class="badge badge-primary">Diproses</span>`
                    }else if(key.status == '2'){
                        st_badge = `<span class="badge badge-info">Dikirim</span>`
                    }else if(key.status == '3'){
                        st_badge = `<span class="badge badge-success">Diterima</span>`
                    }else if(key.status == '4'){
                        st_badge = `<span class="badge badge-success">Selesai</span>`
                    }else if(key.status == '5'){
                        st_badge = `<span class="badge badge-danger">Ditolak</span>`
                    }else if(key.status == '6'){
                        st_badge = `<span class="badge badge-danger">Dibatalkan</span>`
                    }else{
                        st_badge = `<span class="badge badge-secondary">Tidak Diketahui</span>`
                    }

                    return st_badge
                }
            },
            {
                data: null,
                render: function(key){
                    let actionBtn = '',
                        btnIds = randId(7),
                        btnDetail = btnIds+'-detail',
                        btnCancel = btnIds+'-cancel',
                        btnReceived = btnIds+'-received',
                        btnDone = btnIds+'-done';
                        
                    actionBtn = `<button class="btn btn-sm btn-info m-2 ${btnDetail}">Detail</button>`
                    if(key.status == 0)
                    {
                        actionBtn += `<button class="btn btn-sm btn-danger m-2 ${btnCancel}">Batalkan</button>`

                    }else if(key.status == 2){
                        actionBtn += `<button class="btn btn-sm btn-success m-2 ${btnReceived}">Terima Pesanan</button>`
                    }else if(key.status == 3){
                        actionBtn += `<button class="btn btn-sm btn-success m-2 ${btnDone}">Selesaikan</button>`
                    }

                    $(document).on('click', '.'+btnDetail,function(e){
                        e.preventDefault()
                        let st_badge = '',
                            btnPngiriman = randId(5)+'-log-sent'
                        if(key.status == '0')
                        {
                            st_badge = `<span class="badge badge-warning">Menunggu</span>`
                        }else if(key.status == '1'){
                            st_badge = `<span class="badge badge-primary">Diproses</span>`
                        }else if(key.status == '2'){
                            st_badge = `<span class="badge badge-info">Dikirim</span>`
                        }else if(key.status == '3'){
                            st_badge = `<span class="badge badge-success">Diterima</span>`
                        }else if(key.status == '4'){
                            st_badge = `<span class="badge badge-success">Selesai</span>`
                        }else if(key.status == '5'){
                            st_badge = `<span class="badge badge-danger">Ditolak</span>`
                        }else if(key.status == '6'){
                            st_badge = `<span class="badge badge-danger">Dibatalkan</span>`
                        }else{
                            st_badge = `<span class="badge badge-secondary">Tidak Diketahui</span>`
                        }

                        $('#modalTransactionDetail #purchase--order').html(key.purchase_order)
                        $('#modalTransactionDetail .modal-title .transaction--status').html(st_badge)
                        $('#modalTransactionDetail #transaction--created').html(key.created_at)

                        //address
                        $('#modalTransactionDetail #address--name').html(key.user_address.name)
                        $('#modalTransactionDetail #address--phone').html(key.user_address.phone)
                        $('#modalTransactionDetail #address--address').html(key.user_address.address)

                        $('#modalTransactionDetail .transaction--subtotal').html('Rp'+toIdr(key.total))
                        $('#modalTransactionDetail .transaction--subtotal-pay').html('Rp'+toIdr(key.total))

                        if(key.status == '4')
                        {
                            $('#modalTransactionDetail .title--subtotal-pay').text('Dibayar')
                        }else{
                            $('#modalTransactionDetail .title--subtotal-pay').text('Yang harus dibayar')
                        }

                        let content = ''

                        $.each(key.details, function(i,val){
                            content += `<tr>
                                <td class="image" width="50px">
                                    <img src="${url(val.product.image)}" alt="${val.product.name}" class="img-thumbnail">
                                </td>
                                <td width="50px">
                                    <p class="product-name">${val.product.name}</p>
                                </td>
                                <td width="50px" align="center"><span>Rp${toIdr(val.price)}</span></td>
                                <td width="50px" align="center">
                                    ${val.qty}
                                </td>
                                <td width="50px" align="center"><span>Rp${toIdr(val.subtotal)}</span></td>
                            </tr>`
                        })
                        $('#modalTransactionDetail #detail-product--data tbody').html(content)
                        
                        $('#modalTransactionDetail').modal('show')
                    })

                    $(document).on('click','.'+btnCancel, function(e){
                        e.preventDefault()
                        $('#modalCancelation').modal('show')

                        $(document).on('click','#modalCancelation button[type="submit"]', function(e){
                            transactionCancel(key.id)
                        })
                    })

                    $(document).on('click','.'+btnReceived, function(e){
                        e.preventDefault()
                        $('#modalReceived').modal('show')

                        $(document).on('click','#modalReceived button[type="submit"]', function(e){
                            e.preventDefault()
                            transactionReceived(key.id)
                        })

                    })

                    $(document).on('click','.'+btnDone, function(e){
                        e.preventDefault()
                        $('#modalFinish').modal('show')

                        $(document).on('click','#modalFinish button[type="submit"]', function(e){
                            e.preventDefault()
                            transactionDone(key.id)
                        })

                    })

                    return actionBtn
                }
            },
        ],
    });
}

requestTransaction()

function transactionCancel(id)
{
    $.ajax({
        url: api_url('user/transaction/'+id+'/cancel'),
        type: 'PUT',
        dataType: 'json',
        headers: HttpHeaders,
        error: function() {
            
        },
        success: function(res) {
            $('#modalCancelation').modal('hide')
            if(res.status)
            {
                requestTransaction()
                _notif('#alert-message','success',res.message)
            }else{
                _notif('#alert-message','danger',res.message)
            }
        }
    })
}

function transactionReceived(id)
{
    $.ajax({
        url: api_url('user/transaction/'+id+'/received'),
        type: 'PUT',
        dataType: 'json',
        headers: HttpHeaders,
        error: function() {
            
        },
        success: function(res) {
            $('#modalReceived').modal('hide')
            if(res.status)
            {
                requestTransaction()
                _notif('#alert-message','success',res.message)
            }else{
                _notif('#alert-message','danger',res.message)

            }
        }
    })
}

function transactionDone(id)
{
    $.ajax({
        url: api_url('user/transaction/'+id+'/finish'),
        type: 'PUT',
        dataType: 'json',
        headers: HttpHeaders,
        error: function() {
            
        },
        success: function(res) {
            $('#modalFinish').modal('hide')
            if(res.status)
            {
                requestTransaction()
                _notif('#alert-message','success',res.message)
            }else{
                _notif('#alert-message','danger',res.message)
            }
        }
    })
}