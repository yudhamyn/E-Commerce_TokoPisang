let monthNames = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni","Juli", "Agustus", "September", "Oktober", "November", "Desember"];

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
        url: api_url('admin/dashboard/transaction-product'),
        type: 'GET',
        headers: HttpHeaders,
        error: function(err) {

        },
        success: function(res) {
            if(res.status)
            {


                let month = []
                let total_monthly = []

                $.each(res.data, (i, val) => {
                    let val_month = val.month
                    month.push(monthNames[val_month])
                    total_monthly.push(val.total_monthly)

                    if(val.month == new Date().getMonth()+1){
                        $("#newClientCountThisMonth").html(val.total_monthly) 
                    }

                })

                var ctx = document.getElementById("chartClientPerMonth");
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: month,
                        datasets: [{
                            label: "Jumlah Transaksi",
                            lineTension: 0.3,
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: total_monthly,
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                          padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 7
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                maxTicksLimit: 5,
                                padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return value;
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ' + tooltipItem.yLabel;
                        }
                    }
                }
            }
        });


            }
        }
    })
}

requestProduct()