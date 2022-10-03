<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="id01">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ООО «ТРУБКА.ПРО» - Лиды и клиенты для бизнеса</title>

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

        <div>
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

            <div class="content main">
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
                            <div class="title">Лиды и клиенты
                                для бизнеса</div>
                            <div class="subtitle">
                                с помощью холодных звонков
                            </div>
                            <div class="text">
                                <b>Лид в TRUBKA.PRO</b> – это потенциальный клиент, который может и хочет купить ваш
                                продукт или услугу. С ним пообщался наш специалист от лица вашей компании, проверил и подтвердил потребность, бюджет и соответствие вашей целевой аудитории
                            </div>
                            <a href="/home/register"><div class="orange-button">попробовать сейчас</div></a>

                        </div>
                        <div class="right-part"></div>
                    </div>
                </div>
                <div class="can">
                    <div class="left-part"></div>
                    <div class="right-part">
                        <div class="title">Здесь вы можете:</div>
                        <div class="text">
                           <div class="list-item"> Купить пакет лидов вместо пакета минут;</div>
                           <div class="list-item"> Выбрать любое, нужное вам количество лидов (начиная от 5 штук), предварительно задав критерии их качества;</div>
                           <div class="list-item"> Приобрести готовый скрипт или задать его самостоятельно;</div>
                           <div class="list-item">Заказать ручной сбор базы вашей целевой аудитории или загрузить базу самостоятельно</div>
                        </div>
                    </div>
                </div>
                <div class="how">
                    <div class="title">Как это работает:</div>
                    <div class="items-list">
                        <div class="item">Регистрация</div>
                        <div class="item">Заведение проекта</div>
                        <div class="item">Модерация</div>
                        <div class="item">Получение готовых лидов</div>
                    </div>
                    <div class="video">
                        <iframe  src="https://www.youtube.com/embed/8Me-0kXbC78" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="how-images"></div>
                    <div class="how-images2"></div>
                </div>

                <div class="preim">
                    <div class="title">Преимущества нашего сервиса:</div>
                    <div class="items-list">
                        <div class="item">Вы оплачиваете только лиды подтвержденного уровня качества.</div>
                        <div class="item">Вы не тратите время на отбор и обучение специалистов</div>
                        <div class="item">Вы экономите время на контроле проекта и получаете готовый результат в виде лидов</div>
                    </div>
                </div>
                <div class="cost">
                    <div class="left-part"></div>
                    <div class="right-part">
                        <div class="title">Сколько это стоит?</div>
                        <div class="subtitle">Доступ к сервису всего 3800 в месяц.</div>
                        <div class="text">
                            <form action="">
{{--                                <input type="text" placeholder="Ваше имя"/>--}}
{{--                                <input type="text" placeholder="Телефон"/>--}}
                                <a style="display: block" class="white-button"  href="/home/register">хочу попробовать</a>
{{--                                <div class="checkbox">--}}
{{--                                    <input type="checkbox" id="raz"/><label for="raz">Согласие с политикой конфиденциальности</label>--}}
{{--                                </div>--}}

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
{{--            <div class="left">8 (920) 757-64-59</div>--}}
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
