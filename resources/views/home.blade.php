<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('jquery.min.js') }}"></script>
    <title>Home</title>
    @vite(['resources/css/app.css'])
</head>
<body>
@php
        $activeMenuItem = 'menu-item-orders'; // Идентификатор активного пункта меню
 @endphp
    <nav class="sidenav">
        <ul>
            <li id="menu-item-orders" class="{{ $activeMenuItem == 'menu-item-orders' ? 'active' : '' }}">
                <a href="#">
                    <i class="fas fa-shopping-cart"></i>
                    Заказы
                </a>
            </li>
            <li id="menu-item-logout" class="{{ $activeMenuItem == 'menu-item-logout' ? 'active' : '' }}">
                <a id="logout"  href="#">
                    <i class="fas fa-sign-out-alt"></i>
                    Выход
                </a>
            </li>
        </ul>
    </nav>


    <div class="main">
        <h2>Номер паспорта {{$data['passportNumber']}}</h2>
        <h1>Мои заказы</h1>
        <div class="overlay_popup">
            <div class="container-form">
                <div class="form-header">
                    <span>Оформить заказ</span>
                    <span class="close-btn" onclick="showOrderForm()">X</span>
                </div>
                <form id="order-form">
                    @csrf
                    <div id="errors" class="alert-errors">
                        <ul></ul>
                    </div>
                    <label for="product">Товар:</label>
                    <select id="product" name="product" required>
                        @foreach($data['products'] as $product)
                            <option value="{{ $product->brand }}-{{ $product->model }}">{{ $product->brand }}-{{ $product->model }}</option>
                        @endforeach
                    </select>

                    <label for="category">Категория:</label>
                    <select id="category" name="category" required>
                        @foreach($data['categories'] as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <label for="deliveryDate">Дата Поставки:</label>
                    <input type="date" id="deliveryDate" name="deliveryDate"  required>

                    <label for="quantity">Количество:</label>
                    <input type="number" id="quantity" name="quantity" min="1" required
                    >

                    <label for="price">Цена:</label>
                    <input type="text" id="price" name="price" min="1" readonly>

                    <button type="submit">Оформить заказ</button>
                </form>
            </div>
        </div>
        <table  id="orders-table">
            <thead>
            <button type="button" onclick="showOrderForm()">Оформить заказ</button>
            <tr>
                <th>Производитьль</th>
                <th>Модель</th>
                <th>Дата заказа</th>
                <th>Дота Поставки</th>
                <th>Количество</th>
                <th>Цена</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

<script>
    $('#logout').on('click', function (e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route('api.logout') }}',
            type: 'POST',
            headers: {
                'Authorization': 'Bearer {{ $data['token'] }}'
            },
            success: function() {
                {{--$.ajax({--}}
                {{--    url: '{{ route('index') }}',--}}
                {{--    type: 'GET',--}}
                {{--    success: function(data) {--}}
                {{--      //  sessionStorage.setItem('cachedContent', data);--}}
                {{--      // $('main').html(data);--}}
                {{--    },--}}
                {{--    error: function(error) {--}}
                {{--        console.log('Error:', error);--}}
                {{--    }--}}
                {{--});--}}
                    window.location.href = '{{ route('index') }}';
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });
    });
    let showOrderFormFlag =false;
    function showOrderForm() {
        var overlay = document.querySelector('.overlay_popup');

        if (showOrderFormFlag) {

            overlay.style.display = 'none';
            showOrderFormFlag = false;
        } else {

            overlay.style.display = 'block';
            showOrderFormFlag = true;
        }
    }
    $('#order-form').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission
        var brand =$('#product').val().split('-');
        var data = {
            productBrand:brand[0],
            category: $('#category').val(),
            quantity: $('#quantity').val(),
            deliveryDate:$('#deliveryDate').val(),
            price: $('#price').val()
        };
        $.ajax({
            url: '{{ route('api.orders.store') }}?token='+ encodeURIComponent('{{ $data['token'] }}'),
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                $('#errors ul li').empty();
                showOrderForm();
                $("#order-form").trigger('reset');
                $('#errors').css('display', 'block');
                var order = response.order;
                var tableBody = $('#orders-table tbody');
                var row = $('<tr>');
                row.append('<td>' + order.productBrand + '</td>');
                row.append('<td>' + order.productModel + '</td>');
                row.append('<td>' + order.orderDate + '</td>');
                row.append('<td>' + order.deliveryDate + '</td>');
                row.append('<td>' + order.quantityProduct + '</td>');
                row.append('<td>' + order.price + '</td>');
                tableBody.append(row);
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    $('#errors ul li').empty();
                    $('#errors').css('display', 'block');
                    var errorsValidator = xhr.responseJSON.errors;
                    var $errorsList = $('#errors').find('ul');

                    $.each(errorsValidator, function (key, value) {
                        $errorsList.append('<li>' + value[0] + '</li>');
                    });
                }

            }
        });
    });
    $(document).ready(function() {

        $.ajax({
            url: '{{ route('api.orders.index') }}?token='+ encodeURIComponent('{{ $data['token'] }}'),
            type: 'GET',
            success: function(response) {
                var orders = response.orders; // Assuming the data is returned as an object with a 'orders' property
                var tableBody = $('#orders-table tbody');

                if (orders && Array.isArray(orders)) {
                    orders.forEach(function (order) {
                        var row = $('<tr>');
                        row.append('<td>' + order.productBrand + '</td>');
                        row.append('<td>' + order.productModel + '</td>');
                        row.append('<td>' + order.orderDate + '</td>');
                        row.append('<td>' + order.deliveryDate + '</td>');
                        row.append('<td>' + order.quantityProduct + '</td>');
                        row.append('<td>' + order.price + '</td>');
                        tableBody.append(row);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log(error); // Handle error appropriately
            }
        });
        $("li").on('click',function() {
            $("li").removeClass("active"); // Удаляем класс active у всех пунктов
            $(this).addClass("active"); // Добавляем класс active к выбранному пункту

        });
        var productDictionary = {};
        @foreach($data['products'] as $product)
            productDictionary["{{ $product->brand }}-{{ $product->model }}"] = {{ $product->price }};
        @endforeach

        $('#quantity').val(1);
        var selectedProduct = $('#product').val();
        var price = productDictionary[selectedProduct];
        var quantity = $('#quantity').val();
        var totalPrice = price * quantity;
        $('#price').val(totalPrice);

        $('#product').on('change', function() {
            var selectedProduct = $(this).val();
            var price = productDictionary[selectedProduct];
            var quantity = $('#quantity').val();
            var totalPrice = price * quantity;
            $('#price').val(totalPrice);
            //console.log(totalPrice);
        });

        $('#quantity').on('change',function() {
            var selectedProduct = $('#product').val();
            var price = productDictionary[selectedProduct];
            var quantity = $(this).val();
            var totalPrice = price * quantity;
            $('#price').val(totalPrice);
            //console.log(totalPrice);
        });
    });

</script>
</body>
</html>
