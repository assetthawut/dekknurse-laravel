<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Tidtag</title>
    </head>
    <body>
        <div id="app">
            {{-- <navbar-component></navbar-component> --}}
            <post-tag-view-component></post-tag-view-component>
            {{-- <login-footer-component></login-footer-component> --}}
        </div>
      
        <script type="text/javascript" src="../js/app.js?v=12392836"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-XP1054ZM85"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-XP1054ZM85');
        </script>        
    </body> 
</html>