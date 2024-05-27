
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
                position: 'top-start',
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

function load_produk(page = 1)
{
    $.ajax({
        url: api_url('product')+'?page='+page,
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
                                    <div class="single-product shadow">
                                        <div class="product-img">
                                            <a href="" class="${detailIds} product-img-content">
                                                <img class="default-img" src="${url(key.image)}" alt="${key.name}">
                                            </a>
                                            <div class="button-head">
                                                <div class="product-action-2 order-0">
                                                    ${addToCartBtn}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h3><a href="" class="${detailIds}">${key.name}</a></h3>
                                            <div class="product-price">
                                                <span>Rp. ${toIdr(key.price)}</span>
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
                        $('#productDetail #product-detail-price').text(`Rp. `+toIdr(key.price))
                        $('#productDetail #product-detail-description').html("Deskripsi : "+key.description)
                        $('#productDetail #product-detail-weight').html("Berat : "+key.weight)
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

                let paging = res.pagination,
                    pagingBtnId = randId(9),
                    pagingContent = `<button class="btn btn-sm btn-primary ${pagingBtnId}">Lihat Selengkapnya</button>`
                if(paging.current_page == paging.last_page)
                {
                    $('#paging-btn').html('')
                }else{
                    $('#paging-btn').html(pagingContent)
                }

                $(document).on('click','.'+pagingBtnId, function(e){
                    e.preventDefault()
                    load_produk(paging.current_page+1)
                })

                if(paging.start == 0)
                {                
                    $('#product--list').html(content)
                }else{
                    $('#product--list').append(content)
                }


            }

        }
    });
}

load_produk()