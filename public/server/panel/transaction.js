
function requestTransaction()
{
    $('#transaction--data').DataTable().destroy();
    $('#transaction--data').DataTable({
        serverSide: true,
        deferRender: true,
        ajax: {
            url: api_url('admin/transactions'),
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
                    return `<h5 class="mb-1"><b>${key.purchase_order}</b></h5>
                    <span>${key.user.name}</span> `
                }
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
                        btnProcess = btnIds+'-process',
                        btnReject = btnIds+'-reject',
                        btnSent = btnIds+'-sent',
                        btnDone = btnIds+'-done';
                        
                    actionBtn = `<button class="btn btn-sm btn-info m-2 ${btnDetail}">Detail</button>`
                    if(key.status == 0)
                    {
                        actionBtn += `<button class="btn btn-sm btn-danger m-2 ${btnReject}">Tolak</button>`
                        actionBtn += `<button class="btn btn-sm btn-primary m-2 ${btnProcess}">Proses</button>`

                    }else if(key.status == 1){
                        actionBtn += `<button class="btn btn-sm btn-primary m-2 ${btnSent}">Kirim</button>`
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

                    $(document).on('click','.'+btnReject, function(e){
                        e.preventDefault()
                        $('#modalReject').modal('show')

                        $(document).on('click','#modalReject button[type="submit"]', function(e){
                            transactionReject(key.id)
                        })
                    })
                    
                    $(document).on('click','.'+btnProcess, function(e){
                        e.preventDefault()
                        $('#modalProcess').modal('show')

                        $(document).on('click','#modalProcess button[type="submit"]', function(e){
                            transactionProcess(key.id)
                        })
                    })

                    $(document).on('click','.'+btnSent, function(e){
                        e.preventDefault()
                        $('#modalSent #courier').html(key.courier)
                        $('#modalSent').modal('show')

                        $(document).on('click','#modalSent button[type="submit"]', function(e){
                            e.preventDefault()
                            transactionSent(key.id)
                        })

                    })

                    return actionBtn
                }
            },
        ],
    });
}

requestTransaction()

function transactionReject(id)
{
    $.ajax({
        url: api_url('admin/transaction/'+id+'/reject'),
        type: 'PUT',
        dataType: 'json',
        headers: HttpHeaders,
        error: function() {
            
        },
        success: function(res) {
            $('#modalReject').modal('hide')
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

function transactionSent(id)
{
    var inputErrorEl = {
        '#modalSent .error--waybill': 'waybill',
    }
    $.ajax({
        url: api_url('admin/transaction/'+id+'/sent'),
        type: 'PUT',
        dataType: 'json',
        headers: HttpHeaders,
        error: function(err) {
            let res = err.responseJSON

            showInputErrors(inputErrorEl,res.errors)
        },
        success: function(res) {
            $('#modalSent').modal('hide')
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

function transactionProcess(id)
{
    $.ajax({
        url: api_url('admin/transaction/'+id+'/process'),
        type: 'PUT',
        dataType: 'json',
        headers: HttpHeaders,
        error: function() {
            
        },
        success: function(res) {
            $('#modalProcess').modal('hide')
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