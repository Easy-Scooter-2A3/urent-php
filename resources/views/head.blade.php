<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>

    <!-- Material Design -->
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    {{-- <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


    <!-- Styles -->
    <link href="/css/tailwindcss.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">  

    {!! htmlScriptTagJsApi([
        'action' => 'homepage',
    ]) !!}

    <script>
        window.addEventListener("load", function(event) {
            mdc.autoInit();
        });
    </script>

    <call-us 
        style="position: fixed; right: 20px; bottom: 20px; 
            font-family: Arial; 
            z-index: 99999; 
            --call-us-form-header-background:#373737;
            --call-us-main-button-background:#f40018;
            --call-us-client-text-color:#d4d4d4;
            --call-us-agent-text-color:#eeeeee;
            --call-us-form-height:330px;" 
        id="wp-live-chat-by-3CX" 
        channel-url="https://urent.on3cx.fr" 
        files-url="https://urent.on3cx.fr" 
        minimized="true" 
        animation-style="none" 
        party="websupport" 
        minimized-style="BubbleRight" 
        allow-call="true" 
        allow-video="false" 
        allow-soundnotifications="true" 
        enable-mute="true" 
        enable-onmobile="true" 
        offline-enabled="true" 
        enable="true" 
        ignore-queueownership="false" 
        authentication="both" 
        operator-name="Support" 
        show-operator-actual-name="true" 
        channel="phone" 
        aknowledge-received="true" 
        gdpr-enabled="true" 
        gdpr-message="I agree that my personal data to be processed and for the use of cookies in order to engage in a chat processed by COMPANY, for the purpose of Chat/Support for the time of  30 day(s) as per the GDPR." 
        message-userinfo-format="both" 
        message-dateformat="both" 
        start-chat-button-text="Chat" 
        window-title="Urent support" 
        button-icon-type="Default" 
        invite-message="Hello! How can we help you today?" 
        authentication-message="Could we have your name and email?" 
        unavailable-message="We are away, leave us a message!" 
        offline-finish-message="We received your message and we'll contact you soon." 
        ending-message="Your session is over. Please feel free to contact us again!" 
        greeting-visibility="none" 
        greeting-offline-visibility="none" 
        chat-delay="2000" 
        offline-name-message="Could we have your name?" 
        offline-email-message="Could we have your email?" 
        offline-form-invalid-name="I'm sorry, the provided name is not valid." 
        offline-form-maximum-characters-reached="Maximum characters reached" 
        offline-form-invalid-email="I'm sorry, that doesn't look like an email address. Can you try again?" 
        enable-direct-call="true" 
        enable-ga="false" 
        >
    </call-us>


    <script defer src="https://cdn.3cx.com/livechat/v1/callus.js" id="tcx-callus-js"></script>

    <title>Document</title>
</head>