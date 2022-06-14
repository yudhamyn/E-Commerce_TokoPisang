
function updateQty(data,qty,inputEl = '',itemCls = '')
{
    $.ajax({
        url: api_url('cart/'+data.id),
        data: JSON.stringify({
            qty: qty
        }),
        type: 'PUT',
        dataType: 'json',
        headers: HttpHeaders,
        error: function() {
            
        },
        success: function(res) {

            if(res.status)
            {
                if(itemCls)
                {
                    $('.'+itemCls).css({
                        background: 'rgb(40,167,69,.15)'
                    })
                    setTimeout(function(){
                        $('.'+itemCls).removeAttr('style')
                    },500)
                }

                $('.'+itemCls+' .total-amount').html('Rp'+toIdr(data.product.price * qty))

            }else{
                if(itemCls)
                {
                    $('.'+itemCls).css({
                        background: 'rgb(220,53,69,.15)'
                    })
                    setTimeout(function(){
                        $('.'+itemCls).removeAttr('style')
                    },500)
                }
                inputEl.val(res.stock).trigger('change')

            }

        }
    })
}


function changeCheck(id)
{
    $.ajax({
        url: api_url('cart/checked'),
        data: JSON.stringify({
            id: id
        }),
        type: 'POST',
        dataType: 'json',
        headers: HttpHeaders,
        error: function() {
            
        },
        success: function(res) {

            request_cart()

        }
    })
}

function request_cart()
{
    $.ajax({
        url: api_url('cart'),
        type: 'GET',
        dataType: 'json',
        headers: HttpHeaders,
        error: function() {
            $('#checkout--btn').addClass('disabled')
        },
        success: function(res) {
            
            if(res.status){

                let data = res.data;

                let content = ''

                $.each(data,function(i,key){
                    let detailIds = randId(11),
                        inputIds = randId(9),
                        itemClass = randId(3)+'-'+randId(5),
                        removeBtn = randId(12),
                        checkIds = randId(6)
                    content += `<tr class="${itemClass}">
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="${checkIds}" ${key.chosen == '1'? 'checked' : ''}>
                                            <label class="custom-control-label" for="${checkIds}"></label>
                                        </div>
                                    </td>
                                    <td class="image" data-title="No">
                                        <img src="${url(key.product.image)}" alt="${key.product.name}" class="img-thumbnail ${detailIds}">
                                    </td>
                                    <td class="product-des" data-title="Description">
                                        <p class="product-name"><a href="" class="${detailIds}">${key.product.name}</a></p>
                                    </td>
                                    <td class="price" data-title="Price"><span>Rp${toIdr(key.product.price)}</span></td>
                                    <td class="qty" data-title="Qty">
                                        <div class="input-group">
                                            <div class="button minus">
                                                <button type="button" class="btn btn-primary btn-number" ${key.qty == 1? 'disabled="disabled"' : ''} data-type="minus" data-field="${inputIds}">
                                                    <i class="ti-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" name="${inputIds}" class="input-number"  data-min="1" data-max="100" value="${key.qty}">
                                            <div class="button plus">
                                                <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="${inputIds}">
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="total-amount" data-title="Total"><span>Rp${toIdr(key.qty * key.product.price)}</span></td>
                                    <td class="action" data-title="Remove"><a href="#" class="${removeBtn}"><i class="ti-trash remove-icon"></i></a></td>
                                </tr>`

                        $(document).on('change','[name="'+inputIds+'"]', function(){
                            if($(this).val() != 0 && $(this).val() != '')
                            {
                                updateQty(key, $(this).val(),$(this),itemClass)
                            }
                        })
                        
                        $(document).on('change','input#'+checkIds, function(){
                            changeCheck(key.id)
                        })

                        $(document).on('click','.'+removeBtn, function(e){
                            e.preventDefault()
                            cartRemove(key.id)
                        })

                        $(document).on('click','.'+detailIds, function(e){
                            e.preventDefault()
                            $('#productDetail #product-detail-img').attr('src',url(key.product.image))
                            $('#productDetail #product-detail-name').text(key.product.name)
                            $('#productDetail #product-detail-price').text(`Rp`+toIdr(key.product.price))
                            $('#productDetail #product-detail-description').html(key.product.description)
                            $('#productDetail #product-detail-stock').html(key.product.stock > 0? `<i class="fa fa-check-circle-o"></i> Stok tersedia` : `<i class="fa fa-times-circle"></i> Stok kosong`)
                            $('#product-detail-cart-qty').val(key.qty)
                            $('#productDetail').modal('show')
    
                            $(document).on('click','#productDetail #product-detail-add-to-cart', function(e){
                                e.preventDefault()
    
                                updateQty(key.id, $('#product-detail-cart-qty').val(),itemClass)
                                $('#productDetail').modal('hide')
                                
                            })
    
    
                        })
                })
                $('#cart--data tbody').html(content)
                niceInputNumber()

                $('.cart--subtotal').text('Rp'+toIdr(res.details.subtotal_all))
                $('.cart--subtotal-pay').text('Rp'+toIdr(res.details.subtotal))
                if(res.details.subtotal == 0)
                {
                    $('#checkout--btn').addClass('disabled')
                }else{
                    $('#checkout--btn').removeClass('disabled')
                }
                
            }else{
                
                $('.cart--subtotal').text('Rp0')
                $('#cart--data tbody').html(`<tr>
                <td colspan="7" align="center">
                    <small>Belum ada produk di keranjang</small>
                </td>
            </tr>`)
            $('#checkout--btn').addClass('disabled')

            }

        }
    });
}

request_cart()

function checkAll(checked = 0)
{
    $.ajax({
        url: api_url('cart/checked/all'),
        data: JSON.stringify({
            checked: checked
        }),
        type: 'POST',
        dataType: 'json',
        headers: HttpHeaders,
        error: function() {
            
        },
        success: function(res) {

            request_cart()

        }
    })
}

$(document).on('change','#check--all', function(e){
    checkAll(this.checked? 1 : 0)
})