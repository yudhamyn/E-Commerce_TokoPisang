
function requestDashboard()
{
    $.ajax({
        url: api_url('admin/dashboard'),
        type: 'GET',
        headers: HttpHeaders,
        error: function(err) {
            
        },
        success: function(res) {
            if(res.status)
            {
                
                let data = res.data

                $('#product--count').html(data.productCount)
                $('#transaction--income').html('Rp'+toIdr(data.transactionIncome))
                $('#transaction--count').html(data.transactionCount)
                $('#transaction--pending-count').html(data.transactionPendingCount)

            }
        }
    })
}

requestDashboard()

function requestProduct()
{
    $.ajax({
        url: api_url('admin/dashboard/interested-product'),
        type: 'GET',
        headers: HttpHeaders,
        error: function(err) {
            
        },
        success: function(res) {
            if(res.status)
            {
                
                let data = res.data
                
                let content = '<div class="row">'
                
                $.each(data, function(e,key){
                    let progress_color = 'danger'
                    if(key.percent >= 25)
                    {
                        progress_color = 'warning'
                    }
                    if(key.percent >= 50)
                    {
                        progress_color = 'primary'
                    }
                    if(key.percent >= 75)
                    {
                        progress_color = 'success'
                    }
                    content += `<div class="col-md-6">
                                <h4 class="small font-weight-bold">${key.name} <span class="float-right">${key.sold}</span></h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar bg-${progress_color}" role="progressbar" style="width: ${key.percent}%"
                                        aria-valuenow="${key.percent}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>`
                })
                content += `</div>`
                $('#interest--product').html(content)


            }
        }
    })
}

requestProduct()