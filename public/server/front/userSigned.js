


function cartRemove(id)
{
    $.ajax({
        url: api_url('cart/'+id),
        type: 'DELETE',
        dataType: 'json',
        headers: HttpHeaders,
        error: function() {

        },
        success: function(res) {
            
            if(res.status){

                userCart()
                
                if(typeof request_cart == 'function')
                {
                    request_cart()
                }

            }else{
                

            }

        }
    });
}

function userSigned()
{
    $.ajax({
        url: api_url('profile'),
        type: 'GET',
        dataType: 'json',
        headers: HttpHeaders,
        error: function() {
            redirect('logout')
        },
        success: function(res) {
            
            if(res.status){

                let data = res.data;

                $('#navbar--user-name').html(`<a href="${data.level.primary? 'admin' : 'user'}" class="single-icon"><i class="fa fa-user-circle-o mr-1" aria-hidden="true"></i>
                <small>${data.name}</small></a>`)
                if(data.level.primary)
                {
                    $('#navbar--user-cart').remove()
                }else{
                    $('#navbar--user-cart').removeClass('d-none')
                }

            }else{
                redirect('logout')
            }

        }
    });
}

function userCart()
{
    $.ajax({
        url: api_url('cart'),
        type: 'GET',
        dataType: 'json',
        headers: HttpHeaders,
        error: function() {
            
        },
        success: function(res) {
            
            if(res.status){

                $('#navbar--user-cart .shopping-item').removeClass('d-none')

                let data = res.data;

                let content = ''

                $.each(data,function(i,key){
                    let removeBtnids = randId(9)
                    content += `<li>
                                    <a href="" class="remove ${removeBtnids}" title="Remove this item"><i
                                            class="fa fa-remove"></i></a>
                                    <a class="cart-img" href="${url('cart')}"><img src="${url(key.product.image)}" alt="${key.product.name}"></a>
                                    <h4><a href="${url('cart')}">${key.product.name}</a></h4>
                                    <p class="quantity">${key.qty}x - <span class="amount">Rp${toIdr(key.product.price * key.qty)}</span></p>
                                </li>`
                    $(document).on('click','.'+removeBtnids, function(e){
                        e.preventDefault()
                        cartRemove(key.id)
                    })
                })
                $('#navbar--user-cart #cart--list').html(content)

                
                
                $('#navbar--user-cart .cart--count').html(data.length)
                $('#navbar--user-cart #cart--subtotal').html('Rp'+toIdr(res.details.subtotal_all))


            }else{
                $('#navbar--user-cart .cart--count').html(0)
                $('#navbar--user-cart #cart--subtotal').html('Rp'+toIdr(0))
                $('#navbar--user-cart .shopping-item').addClass('d-none')

            }

        }
    });
}

if(get_cookie('_token'))
{
    userSigned()
}