
var convertType = function (value){
    var v = Number (value); 
    return !isNaN(v) ? v : value === "undefined" ? undefined : value === "null" ? null : value === "true" ? true : value === "false" ? false : value 
};

function set_cookie(key,value)
{
    return $.cookie(key, value, {path: '/'});
}
function get_cookie(key)
{
    return $.cookie(key);
}
function remove_cookie(key)
{
    return $.removeCookie(key, {path: '/' });
}

function set_session(key,value)
{
    sessionStorage.setItem(key, JSON.stringify(value));
}
function get_session(key)
{
    if(convertType(sessionStorage.getItem(key)))
    { 
        return JSON.parse(sessionStorage.getItem(key)) 
    }
}
function remove_session(key)
{
    if (Array.isArray(key)) { 
        for (var i = 0; i < key.length; i++) { 
            sessionStorage.removeItem(key[i]) 
        } 
    } else { 
        sessionStorage.removeItem(key) 
    }
}

const isObject = (obj) => {
    return Object.prototype.toString.call(obj) === '[object Object]';
};

function redirect(endpoint = '',blank = false) {
    var props = endpoint.split('://'), 
    base = ''; 
    if ((props[0] == 'http') || (props[0] == 'https')) {
        base = endpoint 
    } else {
        base = url(endpoint) 
    } 

    if (blank) {
        window.open(base,'_blank') 
    }else{
        window.location = base 
    } 
}

function randId(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function url(endpoint = '')
{
    var props = endpoint.split('//'), 
    base = '', protocols = BASE_URL; 
    if (props[0] == location.protocol) { 
        return endpoint
    } else { 
        endpoint = endpoint.replace("\/\/", "/");
        let urlBases = endpoint.split('/')

        if(urlBases[0] == '')
        {
            urls = protocols+endpoint
        }else{
            urls = protocols+'/'+endpoint
        }
        return urls
    } 
}

function api_url(endpoint = '')
{
    return url('api/'+endpoint)
}

let HttpHeaders = {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
}

if(get_cookie('_token'))
{
    HttpHeaders = {
        ...HttpHeaders,
        'Authorization': "Bearer "+get_cookie('_token')
    }
}

function scrollElement(selector) { 
    var el = $('body'); 
    if ($(selector).length) { 
        el = $(selector) 
    } 
    $('html, body').animate({ 
        scrollTop: el.offset().top - 90 
    }, 1000); 
}

function showInputErrors(selectors,errorData)
{
    if((Array.isArray(selectors) || isObject(selectors)) && (Array.isArray(errorData) || isObject(errorData)))
    {
        $.each(selectors,function(e,key){
            let content = `<ul class="p-0 m-0 list-unstyled">`
            $.each(errorData,function(i,errs){
                if(key == i)
                {
                    $.each(errs,function(j,err){
                        content += `<li class="${randId(9)+e} pl-3">${err}❗</li>`
                    })
                }
            })
            content += `</ul>`
            $(`${e}`).html(content)
        })
    }
}

function resetInputErrors(arr)
{
    if(Array.isArray(arr) || isObject(arr))
    {
        $.each(arr,function(i,key){
            $(`${i}`).html('')
        })
    }
}

let _notif = function(selector,type,msg,scroll = true){
    let sl = $(selector)
    if(sl.length)
    {
        if(msg.length == 0)
        {
            sl.html('')
            return false
        }
        /*
            <button type="button" class="btn-close-alert" data-dismiss="alert" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="24" height="24" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                    <line x1="18" y1="6" x2="6" y2="18" class="text-${type}"></line>
                    <line x1="6" y1="6" x2="18" y2="18" class="text-${type}"></line>
                </svg>
            </button>
        */
        let content = `
        <div class="alert alert-${type} alert-outline alert-outline-coloured alert-dismissible user-select-none" role="alert">
        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
            </div>
            <div class="alert-message">
            ${msg}
            </div>
        </div>`
        sl.html(content)
        scrollElement(sl) 
    }else{
        console.log('the "'+selector+'" selector not found!')
        return false;
    }
}

let MyNotif = new class {
    constructor()
    {
        this.defaultSelector = '#single-session'
        this.run()
    }
    run()
    {
        let key = get_session('NotifClassable');
        if(key)
        {
            let data = atob(get_session(key));
            if(data)
            {
                data = JSON.parse(data)

                var action = ''

                if(data.dismiss == true)
                {
                    action = `<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>`
                }

                var time = data.time
                
                var _html = `
                    <div class="alert alert-${data.type} alert-outline alert-outline-coloured alert-dismissible user-select-none" role="alert">
                        ${action}
                        <div class="alert-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        </div>
                        <div class="alert-message">
                        ${data.message} ${time > 0? '<span class="counter-down fw-600"></span>' : ''}
                        </div>
                    </div>
                `;
                if(data.selector !== 'default')
                {
                    if($(data.selector).length)
                    {
                        $(data.selector).html(_html)
                        if (data.scroll == true) { 
                            scrollElement(data.selector) 
                        }
                        if(time > 0)
                        {
                            var countdown = setInterval(function(){
                                $(data.selector+' .counter-down').text(`(${time--}s)`)
                                if (time == -1) {
                                    clearInterval(countdown)
                                    $(data.selector).html('')
                                }
                            },1000)
                        }
                        remove_session([
                            'NotifClassable',
                            get_session('NotifClassable')
                        ])
                        return true;
                    }
                }else{
                    if($(this.defaultSelector).length)
                    {
                        $(this.defaultSelector).html(_html)
                        if (data.scroll == true) { 
                            scrollElement(this.defaultSelector) 
                        }
                        if(time > 0)
                        {
                            var countdown = setInterval(function(){
                                $(this.defaultSelector+' .counter-down').text(`(${time--}s)`)
                                if (time == -1) {
                                    clearInterval(countdown)
                                    $(this.defaultSelector).html('')
                                }
                            },1000)
                        }
                        remove_session([
                            'NotifClassable',
                            get_session('NotifClassable')
                        ])
                        return true;
                    }
                }
            }
            return false;
        }

    }
    set(p)
    {
        let cnf = {
            type: p.type?? '',
            url: p.url? url(p.url): 'default',
            selector: p.selector? p.selector : 'default',
            message: p.message?? '',
            dismiss: p.dismiss?? true,
            scroll: p.scroll == true? true : false,
            time: p.time? p.time : 0
        }
        let rand = randId(7);
        if(p)
        {
            set_session('NotifClassable',rand)
            set_session(rand,btoa(JSON.stringify(cnf)))
            return true;
        }
    }
}

function redirectWithNotif(url,config)
{
    MyNotif.set(config)
    redirect(url)
} 

function toIdr(number) {
    if(number == null){
        return 0;
    }
    return (number.toString().replace('.',',')).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}