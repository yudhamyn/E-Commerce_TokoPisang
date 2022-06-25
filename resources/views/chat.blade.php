@extends('layouts.panel.index')
@section('body')
<div class="chat--page">

    <div class="chat--page-list">
        
        <h5 class="p-3 mb-0">CHAT</h5>

        <ul class="chat--page-content" id="chat--list"></ul>

    </div>

    <div class="chat--page-message d-none" id="chat--message-content">

        <div class="message--header">
            <span class="close-message-icon">
                <i class="fa fa-angle-left"></i>
            </span>
            <div class="header--img">
                <img src="{{ asset('static/panel') }}/img/undraw_profile.svg" alt="" width="100%">
            </div>

            <div class="header--content">

                <h5 class="header--title">{name}</h5>

            </div>
        </div>

        <div class="message--body">

            <div class="empty--chat d-none" id="empty--chat">

                <span class="empty--chat-msg">
                    Belum ada pesan disini
                </span>

            </div>

            <ul class="message--list d-none" id="message--list"></ul>

        </div>

        <div class="message--footer">
            {{-- <div class="msg-to-top">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M352 352c-8.188 0-16.38-3.125-22.62-9.375L192 205.3l-137.4 137.4c-12.5 12.5-32.75 12.5-45.25 0s-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25C368.4 348.9 360.2 352 352 352z"/></svg>
            </div> --}}
            <div class="footer--input">
                <textarea rows="1" class="form-control" placeholder="Masukkan pesan disini" id="input--message"></textarea>
            </div>
            <div class="footer--btn">
                <button class="btn btn-warning" id="chat--send">
                    Kirim
                </button>
            </div>
        </div>

    </div>

</div>
@endsection

@section('css')

<style>

    .chat--page {
        width: 100%;
        height: 80vh;
        min-height: 644px;
        display: flex;
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 4px rgba(0,0,0,.15);
        margin-bottom: 20px;
        position: relative;
    }

    .chat--page .chat--page-list::-webkit-scrollbar {
        width: 0;
    }

    .chat--page .chat--page-list {
        width: 20rem;
        height: 100%;
        background: #f7f7f7;
        overflow: auto;
        position: relative;
    }

    .chat--page .chat--page-list .chat--page-content {
        width: 100%;
        position: relative;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .chat--page .chat--page-list .chat--page-item {
        width: 100%;
        display: flex;
        align-items: center;
        padding: .5rem 1rem;
        border-bottom: 5px solid #dedede;
        background: #fff;
        user-select: none;
        cursor: pointer;
    }

    .chat--page .chat--page-list .chat--page-item.active {
        background: rgb(246, 194, 62,.15);
    }
    
    /* .chat--page .chat--page-list .chat--page-item.active .item--title,
    .chat--page .chat--page-list .chat--page-item.active .item--last-msg {
        color: #fff;
    } */

    .chat--page .chat--page-list .chat--page-item:last-child {
        border-color: transparent;
    }
    
    .chat--page .chat--page-list .chat--page-item .item--img {
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
        overflow: hidden;
        border: 1px solid #ddd;
    }
    
    .chat--page .chat--page-list .chat--page-item .item--content {
        flex: 1;
        width: 100%;
        padding-left: 1rem;
    }

    .chat--page .chat--page-list .chat--page-item .item--title {
        font-size: 17px;
        margin-bottom: 6px;
        font-weight: 700;
    }
    
    .chat--page .chat--page-list .chat--page-item .item--last-msg {
        font-size: 14px;
        margin: 0;
        max-width: 200px;
        text-overflow:ellipsis;
        overflow:hidden;
        white-space:nowrap;
    }

    .chat--page .chat--page-message {
        flex: 1;
        width: 100%;
        background: #fff;
    }

    .close-message-icon {
        display: none;
    }

    @media screen and (max-width: 720px){
        .chat--page .chat--page-message {
            position: absolute;
            left: 0;
            top: 0;
        }
        .close-message-icon {
            display: flex;
            align-items:  center;
            justify-content: center;
            width: 40px;
            height:  40px;
            border-radius: 8px;
            background: #fff;
            margin-right:  10px;
        }
    }
    
    .chat--page .chat--page-message .message--header {
        width: 100%;
        display: flex;
        align-items: center;
        padding: .5rem 1rem;
        background: #f1f1f1;
        user-select: none;
    }

    .chat--page .chat--page-message .message--header .header--img {
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
        overflow: hidden;
        border: 1px solid #ddd;
    }
    
    .chat--page .chat--page-message .message--header .header--content {
        padding-left: 1rem;
        flex: 1;
        width: 100%;
    }

    .chat--page .chat--page-message .message--header .header--title {
        font-size: 17px;
        margin-bottom: 6px;
        font-weight: 700;
    }

    .chat--page .chat--page-message .message--body {
        display: flex;
        height: 63vh;
        min-height: 495px;
        position: relative;
        overflow: auto;
    }

    .chat--page .chat--page-message .message--footer .msg-to-top {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 0 4px rgba(0,0,0,.15);
        position: absolute;
        top: -3rem;
        right: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .chat--page .chat--page-message .message--footer .msg-to-top svg {
        width: 25px;
        height: 25px;
        fill: #aaa;
    }

    .chat--page .chat--page-message .message--body::-webkit-scrollbar-track{
        border-radius:5px;
        background-color:#f5f5f5;
        margin-top:8px
    }
    .chat--page .chat--page-message .message--body::-webkit-scrollbar{
        width:6px;
        background-color:#f5f5f5
    }
    .chat--page .chat--page-message .message--body::-webkit-scrollbar-thumb{
        border-radius:5px;
        background-color:#ddd
    }

    .chat--page .chat--page-message .empty--chat {
        display: flex;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        background: #fff;
        align-items: center;
        justify-content: center;
        user-select: none;
    }

    .chat--page .chat--page-message .empty--chat-msg {
        background: rgba(0,0,0,.6);
        color: #fff;
        font-size: 14px;
        padding: .25rem .5rem;
        border-radius: 1rem;
    }

    .chat--page .chat--page-message .message--list {
        list-style: none;
        position: relative;
        width: 100%;
        padding: 0;
    }
    .chat--page .chat--page-message .message--list .message--item {
        width: 100%;
        position: relative;
        display: flex;
        padding: .6rem 1rem;
    }
    
    .chat--page .chat--page-message .message--list .message--item:not(.msg-date) .message--item-inner {
        max-width: 60%;
        padding: .5rem 1rem;
        border-radius: 10px;
        background: #fff;
        border: 1px solid #f1f1f1;
        margin-left: auto;
        margin-right: 0;
    }
        
    .chat--page .chat--page-message .message--list .message--item.receiver .message--item-inner {
        border-bottom-left-radius: 0px;
        background: #f1f1f1;
        margin-right: auto;
        margin-left: 0;
    }
    
    .chat--page .chat--page-message .message--list .message--item .message--item-inner .message--time {
        font-size: 12px;
        display: block;
        text-align: right;
    }

    .chat--page .chat--page-message .message--footer {
        padding: 1rem;
        display: flex;
        position: relative;
        height: 107px;
        z-index: 10;
        margin-top: 0;
    }

    .chat--page .chat--page-message .message--footer .footer--input {
        flex: 1;
        width: 100%;
    }

    .chat--page .chat--page-message .message--footer .footer--btn {
        width: 80px;
        padding: 0 1rem;
    }

    .chat--page .chat--page-message .message--footer .footer--btn .btn:focus {
        box-shadow: none;
    }

    .chat--page .chat--page-message .message--footer .footer--input textarea {
        resize: none;
        min-height: 38px !important;
        max-height: 76px !important;
        border-radius: 20px;
        overflow: hidden;
    }

    .chat--page .chat--page-message .message--footer .footer--input textarea:focus {
        box-shadow: none;
    }

</style>

@endsection

@section('js')
<script src="{{ asset('server/panel/userChat.js') }}"></script>
@endsection