<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('jquery.min.js') }}"></script>
    <script src="{{ asset('jquery.inputmask.min.js') }}"></script>
    <title>Home</title>
    @vite(['resources/css/app.css'])
</head>
<body>
<div class="overlay_popup">
    <div class="container-registration-form">
        <div class="container-form">
            <form id="registration-form" method="post" action="">
                @csrf
                <div class="form-header">
                    <span>Регистрация</span>
                    <span class="close-btn" onclick="showRegistrationForm()">X</span>
                </div>
                <div id="registration-form-errors" class="alert-errors">
                    <ul></ul>
                </div>

                <div class="form-group">
                    <label for="passportNumber">Номер паспорта:</label>
                    <input type="text" id="passportNumber" name="passportNumber">
                </div>

                <div class="form-group">
                    <label for="firstName">Имя:</label>
                    <input type="text" id="firstName" name="firstName">
                </div>

                <div class="form-group">
                    <label for="lastName">Фамилия:</label>
                    <input type="text" id="lastName" name="lastName">
                </div>

                <div class="form-group">
                    <label for="login">Логин:</label>
                    <input type="text" id="login" name="login">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                </div>

                <div class="form-group">
                    <label for="pass">Пароль:</label>
                    <input type="password" id="pass" name="pass">
                </div>

                <div class="form-group">
                    <label for="address">Адрес:</label>
                    <input type="text" id="address" name="address">
                </div>

                <div class="form-group">
                    <label for="phoneNumber">Номер телефона:</label>
                    <input type="text" id="phoneNumber" name="phoneNumber">
                </div>

                <div class="form-group">
                    <label for="dateOfBirth">Дата рождения:</label>
                    <input type="date" id="dateOfBirth" name="dateOfBirth">
                </div>

                <button id="submitButton" type="submit">Регистрация</button>
            </form>
        </div>
    </div>
    <div class="container-login-form">
        <div class="container-form">
            <form id="login-form" method="post" action="">
                @csrf
                <div class="form-header">
                    <span>Вход</span>
                    <span class="close-btn" onclick="showLoginForm()">X</span>
                </div>
                <div id="errors" class="alert-errors">
                    <ul></ul>
                </div>
                <label for="username">Email или логин:</label>
                <input type="text" id="username" name="username">

                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password">

                <button  id="submitButton" type="submit">Вход</button>
            </form>
        </div>
    </div>
</div>
<div id="welcome_ms" class="welcome_ms">
    <p class="tm-page-header">
        Добро пожаловать<br>
        Продажа гальванических изделий<br>
        Виды товаров<br>
    </p>
    <div class="previews-product-conteiner">

        <div class="previews-product" style="width: 125px; height: 90px">
            <svg xmlns="http://www.w3.org/2000/svg" width="50px" height="50px" fill="currentColor" class="bi bi-calendar-range" viewBox="0 0 16 16"> <path d="M9 7a1 1 0 0 1 1-1h5v2h-5a1 1 0 0 1-1-1zM1 9h4a1 1 0 0 1 0 2H1V9z"/> <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/> </svg>
            <br>
            Оборудование для нанесения покрытий
        </div>
        <div class="previews-product" style="width: 100px; height: 90px">
            <svg fill="#000000" width="60px" height="50px" viewBox="0 0 24 24" id="molecule" data-name="Flat Line" xmlns="http://www.w3.org/2000/svg" class="icon flat-line"><circle id="secondary" cx="12" cy="12" r="4" style="fill: rgb(44, 169, 188); stroke-width: 2;"></circle><path id="primary" d="M15,9l2-2m-2,8,2,2M9,15,7,17M9,9,7,7m5,1a4,4,0,1,0,4,4A4,4,0,0,0,12,8Zm7-5a2,2,0,1,0,2,2A2,2,0,0,0,19,3Zm2,16a2,2,0,1,0-2,2A2,2,0,0,0,21,19ZM5,21a2,2,0,1,0-2-2A2,2,0,0,0,5,21ZM3,5A2,2,0,1,0,5,3,2,2,0,0,0,3,5Z" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></svg>
            <br>
            Химические реактивы
        </div>
    </div>
    <button id="Register" type="button" onclick="showRegistrationForm()" class="myBtn">Регистрация</button>
    ИЛИ
    <button id="Login" type="button" class="myBtn" onclick="showLoginForm()">Вход</button>
</div>
<script>
    let showRegistrationFormFlag = false;

    function showRegistrationForm() {
        var overlay = document.querySelector('.overlay_popup');

        if (!showRegistrationFormFlag) {
            overlay.style.display = 'block';
            $('.container-registration-form').css('display', 'block');
            $('.container-login-form').css('display', 'none');
            showRegistrationFormFlag = true;
        } else {
            overlay.style.display = 'none';
            $('.container-registration-form').css('display', 'none');
            showRegistrationFormFlag = false;
        }
    }

    let showLoginFormFlag = false;
    function showLoginForm() {
        var overlay = document.querySelector('.overlay_popup');

        if (!showLoginFormFlag) {
            $('.container-login-form').css('display', 'block');
            $('.container-registration-form').css('display', 'none');
            overlay.style.display = 'block';
            showLoginFormFlag = true;
        } else {
            overlay.style.display = 'none';
            $('.container-login-form').css('display', 'none');
            showLoginFormFlag = false;
        }
    }
    $('#registration-form').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission
        var data = {
            passportNumber: $('#passportNumber').val(),
            firstName: $('#firstName').val(),
            lastName: $('#lastName').val(),
            login: $('#login').val(),
            email: $('#email').val(),
            pass: $('#pass').val(),
            address: $('#address').val(),
            phoneNumber: $('#phoneNumber').val(),
            dateOfBirth: $('#dateOfBirth').val()
        };
        console.log(data)
        $.ajax({
            url: '{{ route('api.register') }}',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                $('#errors ul li').empty();
                $("#registration-form").trigger('reset');
                $('#errors').css('display', 'block');
                var token = response.token;
                window.location.href = `{{ route('home') }}?token=` + token;
            },
            error: function(xhr) {

                if (xhr.status === 422) {
                    $('#registration-form-errors ul li').empty();
                    $('#registration-form-errors').css('display', 'block');
                    var errorsValidator = xhr.responseJSON.errors;
                    var $errorsList = $('#registration-form-errors').find('ul');

                    $.each(errorsValidator, function (key, value) {
                        $errorsList.append('<li>' + value[0] + '</li>');
                    });
                    $("#registration-form").trigger('reset');
                } else {
                    if (xhr.status === 401) {
                        console.log( xhr.responseJSON.error)
                        $('#registration-form-errors ul li').empty();
                        $('#registration-form-errors').css('display', 'block');
                        var errorsValidator = xhr.responseJSON.errors;
                        var $errorsList = $('#registration-form-errors').find('ul');

                        $.each(errorsValidator, function (key, value) {
                            $errorsList.append('<li>' + value[0] + '</li>');
                        });

                        $errorsList.append('<li>' + xhr.responseJSON.message + '</li>');
                        $("#registration-form").trigger('reset');
                    }
                    else {
                        alert('Произошла ошибка. Пожалуйста, попробуйте еще раз.');
                        $("#registration-form").trigger('reset');
                    }
                }
            }
        });
    });
    $('#login-form').submit(function(event) {
        event.preventDefault();

        var username = $('#username').val();
        var password = $('#password').val();


        var credentials = {
            username: username,
            password: password
        };
        $.ajax({
            url: '{{route('api.login')}}',
            type: 'POST',
            data: credentials,
            dataType: 'json',
            success: function(response) {
                $('#errors ul li').empty();
                $('#errors').css('display', 'none');
                $("#login-form").trigger('reset');
                var token = response.authorization.token;


                {{--$.ajax({--}}
                    {{--    url: '{{route('home')}}',--}}
                    {{--    type: 'GET',--}}
                    {{--    headers: {--}}
                    {{--        'Authorization': 'Bearer ' + token--}}
                    {{--    },--}}
                    {{--    success: function (data) {--}}
                    {{--       // sessionStorage.setItem('cachedContent', data);--}}
                    {{--       // $('main').html(data);--}}
                    {{--        window.location.href = `{{ route('home') }}?token=` + token;--}}
                    {{--    },--}}
                    {{--    error: function (error) {--}}
                    {{--        console.log('Error:', error);--}}
                    {{--    }--}}
                    {{--});--}}
                    window.location.href = `{{ route('home') }}?token=` + token;
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    $('#errors ul li').empty();
                    $('#errors').css('display', 'block');
                    var errorsValidator = xhr.responseJSON.errors;
                    var $errorsList = $('#errors').find('ul');

                    $.each(errorsValidator, function (key, value) {
                        $errorsList.append('<li>' + value[0] + '</li>');
                    });
                    $("#login-form").trigger('reset');
                } else {
                    if (xhr.status === 401) {
                        $('#errors ul').empty();
                        $('#errors').css('display', 'block');
                        var $errorsList = $('#errors ul');

                        $errorsList.append('<li>' + xhr.responseJSON.message + '</li>');
                        $("#login-form").trigger('reset');
                    }
                    else {
                        alert('Произошла ошибка. Пожалуйста, попробуйте еще раз.');
                        $("#login-form").trigger('reset');
                    }
                }
            }
        });
    });
    // При обновлении страницы
    $(document).ready(function () {
        $('#phoneNumber').inputmask({
            mask: '+7 (999) 999-99-99',
            placeholder: '+7 (___) ___-__-__',
            clearMaskOnLostFocus: false
        });
        // Проверка наличия сохраненных данных в sessionStorage
        //     var cachedContent = sessionStorage.getItem('cachedContent');
        //
        //     if (cachedContent) {
        //         // Восстановление сохраненных данных
        //         //$('main').html(cachedContent);
        //     }

    });
</script>
</body>
</html>

