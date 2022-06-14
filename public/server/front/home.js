
function request_addToCart(product_id, qty)
{
    $.ajax({
        url: api_url('cart'),
        data: JSON.stringify({
            product: product_id,
            qty: qty
        }),
        type: 'POST',
        headers: HttpHeaders,
        error: function() {
            
        },
        success: function(res) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            if(res.status)
            {
                userCart()
                Toast.fire({
                    icon: 'success',
                    title: res.message
                })
            }else{
                Toast.fire({
                    icon: 'error',
                    title: res.message
                })
            }
        }
    })
}

function load_produk()
{
    $.ajax({
        url: api_url('product'),
        type: 'GET',
        dataType: 'json',
        headers: HttpHeaders,
        error: function() {
            
        },
        success: function(res) {
            
            if(res.status){

                let data = res.data;

                let content = ``
                $.each(data, function(i,key){

                    let detailIds = randId(9),
                        addToCart = randId(10)

                    let addToCartBtn = ''
                    if(res.action)
                    {
                        addToCartBtn = `${key.stock > 0? `<a title="Tambah ke keranjang" href="" class="${addToCart}">Tambah ke keranjang</a>` : ` <span class="text-danger">Stok habis</span>`}`
                    }

                    content += `<div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <a href="" class="${detailIds} product-img-content">
                                                <img class="default-img" src="${url(key.image)}" alt="${key.name}">
                                            </a>
                                            <div class="button-head">
                                                <div class="product-action order-1">
                                                    <a title="Detail" href="" class="${detailIds}"><i class=" ti-eye"></i><span>Detail</span></a>
                                                </div>
                                                <div class="product-action-2 order-0">
                                                    ${addToCartBtn}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h3><a href="" class="${detailIds}">${key.name}</a></h3>
                                            <div class="product-price">
                                                <span>Rp${toIdr(key.price)}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>`

                    $(document).on('click','.'+addToCart, function(e){
                        e.preventDefault()
                        request_addToCart(key.id, 1)
                    })

                    $(document).on('click','.'+detailIds, function(e){
                        e.preventDefault()
                        $('#productDetail #product-detail-img').attr('src',url(key.image))
                        $('#productDetail #product-detail-name').text(key.name)
                        $('#productDetail #product-detail-price').text(`Rp`+toIdr(key.price))
                        $('#productDetail #product-detail-description').html(key.description)
                        $('#productDetail #product-detail-stock').html(key.stock > 0? `<i class="fa fa-check-circle-o"></i> Stok tersedia` : `<i class="fa fa-times-circle text-danger"></i> Stok kosong`)
                        $('#productDetail').modal('show')

                        if(key.stock > 0)
                        {
                            $('#productDetail #product-detail-qty').removeClass('d-none')
                            $('#productDetail #product-detail-add-to-cart').removeClass('d-none')
                        }else{
                            $('#productDetail #product-detail-qty').addClass('d-none')
                            $('#productDetail #product-detail-add-to-cart').addClass('d-none')
                        }

                        $(document).on('click','#productDetail #product-detail-add-to-cart', function(e){
                            e.preventDefault()

                            request_addToCart(key.id, $('#product-detail-cart-qty').val())
                            $('#productDetail').modal('hide')
                            $('#product-detail-cart-qty').val(1)
                        })


                    })
                })

                $('#product--list').html(content)

            }

        }
    });
}

load_produk()