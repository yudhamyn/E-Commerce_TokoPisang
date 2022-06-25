
var courierCodeSelected = null;

function render_courier()
{
    let courier = [
        {
            name: 'JNE',
            code: 'jne'
        },
        {
            name: 'J&T',
            code: 'jnt'
        },
        {
            name: 'TIKI',
            code: 'tiki'
        },
    ]

    let content = ''
    $.each(courier, function(i,key){
        let itemIds = randId(9)
        content += `<div class="col-md-6 mb-4">
                        <div class="card card-courier ${itemIds}" style="cursor: pointer;">
                            <img src="${url('static/images/courier/'+key.code+'.png')}" alt="${key.name}">
                        </div>
                    </div>`

        $(document).on('click','.'+itemIds, function(e){
            e.preventDefault()
            $(this).addClass('active')
            $('#courier--list .card-courier').not($(this)).removeClass('active')
            courierCodeSelected = key.code
        })
                    
    })
    $('#courier--list').html(content)
}

render_courier()

var inputErrorEl = {
    '.error--address-name': 'address.name',
    '.error--address-phone': 'address.phone',
    '.error--address-address': 'address.address',
    '.error--courier': 'courier',
}

function request_cart()
{
    $.ajax({
        url: api_url('cart?checked=1'),
        type: 'GET',
        dataType: 'json',
        headers: HttpHeaders,
        error: function() {
            $('#order--btn').prop('disabled',true)
        },
        success: function(res) {
            
            if(res.status){

                let data = res.data;

                let content = ''

                $.each(data,function(i,key){
                    let detailIds = randId(11),
                        itemClass = randId(3)+'-'+randId(5);
                    content += `<tr class="${itemClass}">
                                    <td class="image" data-title="No">
                                        <img src="${url(key.product.image)}" alt="${key.product.name}" class="img-thumbnail ${detailIds}">
                                    </td>
                                    <td class="product-des" data-title="Description">
                                        <p class="product-name"><a href="" class="${detailIds}">${key.product.name}</a></p>
                                    </td>
                                    <td class="price" data-title="Price"><span>Rp. ${toIdr(key.product.price)}</span></td>
                                    <td class="qty" data-title="Qty">
                                        ${key.qty}
                                    </td>
                                    <td class="total-amount" data-title="Total"><span>Rp. ${toIdr(key.qty * key.product.price)}</span></td>
                                </tr>`

                })
                $('#cart--data tbody').html(content)

                $('.cart--subtotal').text('Rp'+toIdr(res.details.subtotal))
                $('.cart--subtotal-pay').text('Rp'+toIdr(res.details.subtotal + shippingPrice))
                if(res.details.subtotal == 0)
                {
                    $('#order--btn').prop('disabled',true)
                }else{
                    $('#order--btn').prop('disabled',false)
                }
                
            }else{
                
                $('.cart--subtotal').text('Rp0')
                $('#cart--data tbody').html(`<tr>
                    <td colspan="7" align="center">
                        <small>Belum ada produk di keranjang</small>
                    </td>
                </tr>`)
                $('#order--btn').prop('disabled',true)

            }

        }
    });
}

request_cart()

function checkout()
{
    $.ajax({
        url: api_url('checkout'),
        data: JSON.stringify({
            address: {
                name: $('#address--name').val(),
                phone: $('#address--phone').val(),
                address: $('#address--address').val(),
            },
            courier: courierCodeSelected
        }),
        type: 'POST',
        dataType: 'json',
        headers: HttpHeaders,
        error: function(err) {
            let res = err.responseJSON
            showInputErrors(inputErrorEl,res.errors)
        },
        success: function(res) {

            if(res.status)
            {
                redirectWithNotif('user/transactions',{
                    selector: '#alert-message',
                    type: 'success',
                    message: res.message,
                    scroll: true,
                })
            }else{
                _notif('#alert-message','danger',res.message)
            }

        }
    })
}

$(document).on('click','#order--btn', function(e){
    e.preventDefault()
    checkout()
})