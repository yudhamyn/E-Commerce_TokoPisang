
$(document).on('keyup','.chat--page .chat--page-message textarea', function(){
    $(this).css('height','auto')
    $(this).css('height',(this.scrollHeight) + 'px')

    console.log($(this).height())
    let mt = (($(this).height()/2+5))
    if(mt == 17)
    {
        mt = 0;
    }
    let mt_r = (mt == 0? 0 : mt*-1+'px')
    $('.chat--page .chat--page-message .message--footer').css({
        marginTop: mt_r
    })
})

function bodyScrollMsg()
{
    $('.chat--page .chat--page-message .message--body').scrollTop($('.chat--page .chat--page-message .message--body')[0].scrollHeight,'slow')
}
bodyScrollMsg()

$(document).on('click','.message--footer .msg-to-top', function(e){
    e.preventDefault()
    let down = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z"/></svg>`
    let top = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M352 352c-8.188 0-16.38-3.125-22.62-9.375L192 205.3l-137.4 137.4c-12.5 12.5-32.75 12.5-45.25 0s-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25C368.4 348.9 360.2 352 352 352z"/></svg>`
    if($('.chat--page .chat--page-message .message--body').scrollTop() == 0)
    {
        bodyScrollMsg()
        $(this).html(top)
    }else{
        $('.chat--page .chat--page-message .message--body').scrollTop(0,'slow')
        $(this).html(down)
    }

})

function loadMsg(id)
{
    // $('#empty--chat').removeClass('d-none')
    // $('#message--list').html('')
    // $('#message--list').addClass('d-none')
    $.ajax({
        url: api_url('chat/message'),
        type: 'POST',
        data: JSON.stringify({
            receiver: id
        }),
        headers: HttpHeaders,
        error: function() {
            
        },
        success: function(res) {
            
            if(res.status){

                let data = res.data;
                let content = ''
                let last = data.length
                $.each(data, function(i,key){
                    let itemIds = randId(9)
                    content += `<li class="message--item ${key.sender? '' : 'receiver'}">
                                    <div class="message--item-inner">
                                        <p class="message--content">
                                            ${key.message.replaceAll(/(?:\r\n|\r|\n)/g, '<br>')}
                                        </p>
                                        <span class="message--time">${key.created_at}</span>
                                    </div>
                                </li>`
                    if((i+1) == last)
                    {
                        $('#chat--list .chat--page-item.active .item--last-msg').html(key.message)
                    }
                    
                })
                $('#message--list').html(content)
                $('#empty--chat').addClass('d-none')
                $('#message--list').removeClass('d-none')
                bodyScrollMsg()

            }else{
                
                $('#empty--chat').removeClass('d-none')
                $('#message--list').html('')
                $('#message--list').addClass('d-none')

            }

        }
    });
}

function sendChat(id)
{
    $.ajax({
        url: api_url('chat'),
        data: JSON.stringify({
            receiver: id,
            message: $('#input--message').val()
        }),
        type: 'POST',
        headers: HttpHeaders,
        error: function() {            
            $('#chat--send').prop('disabled',false)
        },
        success: function(res) {
            
            $('#chat--send').prop('disabled',false)

            if(res.status){

                $('#input--message').val('')

                let data = res.data;
                
                let content = `<li class="message--item ${data.sender? '' : 'receiver'}">
                                    <div class="message--item-inner">
                                        <p class="message--content">
                                            ${data.message}
                                        </p>
                                        <span class="message--time">${data.created_at}</span>
                                    </div>
                                </li>`
                
                if($('#message--list .message--item').length)
                {
                    $('#message--list').append(content)
                }else{
                    $('#message--list').html(content)
                }
                $('#chat--list .chat--page-item.active .item--last-msg').html(data.message)

                bodyScrollMsg()
                

            }else{
                
            }

        }
    });
}

function loadChat()
{
    var timeLoadMsg;
    $.ajax({
        url: api_url('chat'),
        type: 'GET',
        headers: HttpHeaders,
        error: function() {
            
        },
        success: function(res) {
            
            if(res.status){

                let data = res.data;
                let content = ''
                $.each(data, function(i,key){
                    let itemIds = randId(9)
                    content += `<li class="chat--page-item ${itemIds}">

                                    <div class="item--img">
                                        <img src="${url('static/panel/img/undraw_profile.svg')}" alt="Img" width="100%">
                                    </div>
                    
                                    <div class="item--content">
                    
                                        <h5 class="item--title">${key.name}</h5>
                    
                                        <p class="item--last-msg">
                                            ${key.last_message? key.last_message.message : ''}
                                        </p>
                    
                                    </div>
                    
                                </li>`
                    $(document).on('click', '.'+itemIds, function(e){
                        e.preventDefault()
                        clearInterval(timeLoadMsg)
                        $(this).addClass('active')
                        $('#chat--list .chat--page-item').not($(this)).removeClass('active')
                        $('#chat--message-content .header--title').text(key.name)
                        loadMsg(key.receiver_id)
                        $('#chat--message-content').removeClass('d-none')

                        $(document).on('click','#chat--send', function(e){
                            e.preventDefault()
                            $(this).prop('disabled',true)
                            sendChat(key.receiver_id)
                        })

                        timeLoadMsg = setInterval(function(){
                            loadMsg(key.receiver_id)
                        },3000)

                    })
                })
                $('#chat--list').html(content)

            }else{
                
            }

        }
    });
}

loadChat()