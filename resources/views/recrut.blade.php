<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="id01">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ООО «ТРУБКА.ПРО» - Сервис поиска удалённой работы</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100&display=swap" rel="stylesheet">
    <link href='/css/app.css' rel='stylesheet' type='text/css'>
    <link href='/css/app.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>

</head>
<body>
<div>

    <script>
        function checkCookies(){
            let cookieDate = localStorage.getItem('cookieDate');
            let cookieNotification = document.getElementById('cookie_notification');
            let cookieBtn = cookieNotification.querySelector('.cookie_accept');

            if( !cookieDate || (+cookieDate + 31536000000) < Date.now() ){
                cookieNotification.classList.add('show');
            }

            cookieBtn.addEventListener('click', function(){
                localStorage.setItem( 'cookieDate', Date.now() );
                cookieNotification.classList.remove('show');
            })
        }
        $(document).ready(function(){
            checkCookies();
        })

    </script>



    {{--            @if (Route::has('login'))--}}
    {{--                <div class="top-right links">--}}
    {{--                    @auth--}}
    {{--                        <a href="{{ url('/home') }}">Home</a>--}}
    {{--                    @else--}}
    {{--                        <a href="{{ route('login') }}">Login</a>--}}

    {{--                        @if (Route::has('register'))--}}
    {{--                            <a href="{{ route('register') }}">Register</a>--}}
    {{--                        @endif--}}
    {{--                    @endauth--}}
    {{--                </div>--}}
    {{--            @endif--}}

    <div class="content recrut">
        <div class="header">
            <div class="header-images"></div>
            <div class="logo-line">
                <div class="logo-container">
                    <div class="logo"></div>
                </div>
                <div class="navigation">
                    <a href="/">Клиентам</a>
                    <a href="/recrut">Сотрудникам</a>
                    <a href="/home/login"><i class="fa fa-sign-in" aria-hidden="true"></i> Вход</a>
                </div>
                <div class="question">
                    задать вопрос
                </div>
            </div>
            <div class="text-line">
                <div class="left-part">
                    <div class="title">В сфере коммерции</div>
                    <div class="subtitle">
                        Сервис поиска удалённой работы
                    </div>
                    <a href="/home/register?role=recrut"><div class="orange-button">попробовать сейчас</div></a>

                </div>
                <div class="right-part"></div>
            </div>
        </div>
        <div class="can">
            <div class="can-item">
                <div class="title">Здесь вы можете:</div>
                <div class="text">
                    <div class="list-item"> Выбрать один или несколько проектов; </div>
                    <div class="list-item"> Работать из любой точки мира;</div>
                    <div class="list-item"> Самостоятельно планировать график работы;</div>
                    <div class="list-item"> Не ограничивать себя в уровне дохода;</div>
                    <div class="list-item"> Работать с любого устройства (включая смартфон)</div>
                </div>
            </div>
            <div class="can-item">
                <div class="title">Мы обеспечим вас:</div>
                <div class="text">
                    <div class="list-item">Необходимыми для работы ресурсами (телефония, базы, тех. поддержка, удобное ПО);</div>
                    <div class="list-item">  Знаниями (нет опыта – научим, есть вопросы – ответим)</div>
                </div>
            </div>
            <div class="can-item">
                <div class="title">С нами безопасно:</div>
                <div class="text">
                    <div class="list-item"> Мы предлагаем официальное трудоустройство;</div>
                    <div class="list-item"> Наши кураторы сами отстаивают ваши интересы перед заказчиками</div>
                </div>
            </div>
        </div>
        <div class="how">
            <div class="title">Как это работает:</div>
            <div class="items-list">
                <div class="item">Регистрация</div>
                <div class="item">модерация</div>
                <div class="item">обучение и аттестация</div>
                <div class="item">выбор проекта</div>
            </div>
            <div class="video">
                <iframe  src="https://www.youtube.com/embed/8Me-0kXbC78" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div class="how-images"></div>
            <div class="how-images2"></div>
        </div>

        <div class="preim">
            <div class="title">Для работы в сервисе тебе достаточно:</div>
            <div class="items-list">
                <div class="item">Смартфон
                <div class="subitem">
                    также можно работать
                    на ноутбуке, планшете,
                    компьютере
                </div>
                </div>
                <div class="item">Гарнитура</div>
                <div class="item">Стабильный интернет</div>
                <div class="item">Тихое помещение</div>
            </div>
        </div>
        <div class="cost">
            <div class="left-part"></div>
            <div class="right-part">
                <div class="title">Подать заявку</div>
                <div class="subtitle">Дополнительная информация о регистрации и условиях участия в проекте</div>
                <div class="text">
                    <form action="">
{{--                        <input type="text" placeholder="Ваше имя"/>--}}
{{--                        <input type="text" placeholder="Телефон"/>--}}
                        <a style="display: block" class="white-button"  href="/home/register?role=recrut">зарегистрироваться</a>
{{--                        <input type="submit" class="white-button" value="зарегистрироваться"/>--}}
{{--                        <div class="checkbox">--}}
{{--                            <input type="checkbox" id="raz"/><label for="raz">Согласие с политикой конфиденциальности</label>--}}
{{--                        </div>--}}

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="cookie_notification">
    <p>Для улучшения работы сайта и его взаимодействия с пользователями мы используем файлы cookie. Продолжая работу с сайтом, Вы разрешаете использование cookie-файлов. Вы всегда можете отключить файлы cookie в настройках Вашего браузера.</p>
    <a target="_blank" href="/cookie" class="podr">Подробнее</a>
    <button class="button cookie_accept">Принять</button>

</div>

<div class="footer">
    <div class="footer-container">
{{--        <div class="left">8 (920) 757-64-59</div>--}}
        <div class="right">2021 ООО «ТРУБКА.ПРО» © Все права защищены</div>
    </div>
    <div class="footer-docs">
        <div class="footer-rules"><a target="_blank" href="/cookie">Правила в отношении использования файлов cookie</a></div>
        <div class="footer-rules"><a target="_blank" href="/policy">Политика в отношении обработки персональных данных</a></div>
        <div class="footer-rules"><a target="_blank" href="/terms">Пользовательское соглашение</a></div>
    </div>
</div>
</body>
<script src="/js/script.js"></script>
</html>
