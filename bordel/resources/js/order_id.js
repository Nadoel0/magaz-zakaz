$(document).ready(function () {
    // Функция для отображения модального окна
    function showModal(modalID) {
        $(modalID).show();
    }

    // Функция для скрытия модального окна
    function hideModal() {
        $('.my-modal-space').hide();
    }

    // Обработчик клика на кнопку открытия модального окна "Product"
    $('#productModal').click(function () {
        showModal('#myModalProduct');
    });

    // Обработчик клика на кнопку открытия модального окна "People"
    $('#peopleModal').click(function () {
        showModal('#myModalPeople');
    });

    // Обработчик клика на кнопку "Редактировать" продукта
    $('.product-edit').click(function () {
        // Получение данных продукта
        var productID = $(this).data('product-id');
        var productName = $(this).closest('tr').find('.table-data.product-name').text();
        var productPrice = $(this).closest('tr').find('.table-data.product-price').text();
        var productAmount = $(this).closest('tr').find('.product-amount').text();
        var price = productPrice / productAmount;

        // Заполнение полей модального окна "Product Edit" данными продукта
        $('#productID').val(productID);
        $('#editProductNameInput').val(productName);
        $('#editProductPriceInput').val(price);
        $('#editProductAmountInput').val(productAmount);

        showModal('#myModalProductEdit');
    });

    // Обработчик клика на кнопку "Закрыть" модального окна или на пустую область вне модального окна
    $('.close-modal, .my-modal-space').click(function (event) {
        if (event.target === this) {
            hideModal();
        }
    });

    // Получение URL для добавления продукта и удаления продукта
    var addProductURL = $('#addProductButton').data('add-product-url');
    var deleteProductURL = $('#deleteProductButton').data('delete-product-url');

    // Функция для расчета общей стоимости продуктов
    function calculatePrice(price, amount) {
        return price * amount;
    }

    // Функция для расчета общей стоимости всех продуктов
    function calculateTotalPrice() {
        var totalPrice = 0;

        $('.product-price').each(function () {
            var price = parseFloat($(this).text());
            if (!isNaN(price)) {
                totalPrice += price;
            }
        });

        return totalPrice;
    }

    // Получение URL для обновления количества продукта и общей стоимости
    var amountProductURL = $('#amountProductButtons').data('product-amount-url');
    var totalPriceURL = $('#totalPrice').data('total-price-url');
    var userID = $('#datas').data('user-id');

    // Обновление общей стоимости
    function updateTotalPrice() {
        var totalPrice = calculateTotalPrice();
        $('.total-price').text('Итог: ' + totalPrice);

        var data = {
            _method: 'PUT',
            user_id: userID,
            debt: totalPrice,
        };

        $.ajax({
            url: totalPriceURL,
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response);
            }
        });
    }

    // Инициализация обновления общей стоимости
    updateTotalPrice();

    // Обработчик клика на кнопку "Добавить продукт"
    $('#addProduct').click(function () {
        // Получение данных продукта из полей ввода
        var productName = $('#productNameInput').val();
        var productAmount = $('#productAmountInput').val();
        var productPrice = $('#productPriceInput').val();
        var productComment = $('#productCommentInput').val();

        // Расчет общей стоимости продукта
        var totalPrice = calculatePrice(productPrice, productAmount);

        var data = {
            name: productName,
            amount: productAmount,
            comment: productComment,
            price: totalPrice,
        };

        $.ajax({
            url: addProductURL,
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                // Генерация HTML-кода для добавленного продукта
                var addedProducts = `<tr data-product-id="${response.id}">
                                        <td class="table-data">${response.name}</td>
                                        <td class="table-data product-price" data-product-id="${response.id}">${response.price}</td>
                                        <td class="table-data grid">
                                            <button class="btn-minus">&minus;</button>
                                            <div class="product-amount">${response.amount}</div>
                                            <button class="btn-plus">&plus;</button>
                                        </td>
                                        <td>
                                            <button class="product-edit" data-product-id="${response.id}">изменить</button>
                                        </td>
                                    </tr>`;

                // Добавление HTML-кода продукта в таблицу
                $('.data-table1 tbody').append(addedProducts);

                // Очистка полей ввода
                $('#productNameInput').val('');
                $('#productAmountInput').val('');
                $('#productPriceInput').val('');
                $('#productCommentInput').val('');

                // Скрытие модального окна "Product"
                $('#myModalProduct').hide();

                // Обновление общей стоимости
                updateTotalPrice();
            }
        });
    });

    // Обработчик клика на кнопки "Плюс" и "Минус" для изменения количества продукта
    $('.data-table1 tbody').on('click', '.btn-plus, .btn-minus', function () {
        var amountElement = $(this).siblings('.product-amount');
        var priceElement = $(this).closest('tr').find('.product-price');
        var price = parseFloat(priceElement.text());
        var currentAmount = parseFloat(amountElement.text());
        var newAmount = $(this).hasClass('btn-plus') ? currentAmount + 1 : currentAmount - 1;
        var productID = $(this).closest('tr').data('product-id');

        if (newAmount > 0) {
            updateProductData(price, newAmount, amountElement, productID);
        }
    });

    // Обработчик клика на кнопку "Изменить" продукта
    $('#editProduct').click(function () {
        var productID = $('#productID').val();
        var productName = $('#editProductNameInput').val();
        var productAmount = $('#editProductAmountInput').val();
        var productPrice = $('#editProductPriceInput').val();
        var productComment = $('#editProductCommentInput').val();
        var totalPrice = calculatePrice(productPrice, productAmount);

        var data = {
            productID: productID,
            name: productName,
            amount: productAmount,
            comment: productComment,
            price: totalPrice,
        };

        sendDataToServer(amountProductURL, data, function (response) {
            var targetElement = $(`.data-table1 tbody tr[data-product-id="${response.id}"]`);

            targetElement.find('.table-data.product-name').text(response.name);
            targetElement.find('.table-data.product-price').text(response.price);
            targetElement.find('.product-amount').text(response.amount);

            $('#myModalProductEdit').hide();

            updateTotalPrice();
        });
    });

    // Функция для обновления данных продукта
    function updateProductData(price, newAmount, amountElement, productID) {
        var unitPrice = price / parseFloat(amountElement.text());
        var totalPrice = unitPrice * newAmount;
        var data = {
            amount: newAmount,
            price: totalPrice,
            productID: productID,
        };

        sendDataToServer(amountProductURL, data, function (response) {
            $('.product-price[data-product-id="' + productID + '"]').html(response.price);
            amountElement.html(response.amount);

            updateTotalPrice();
        });
    }

    // Функция для отправки данных на сервер
    function sendDataToServer(url, data, successCallback) {
        $.ajax({
            url: url,
            type: 'PUT',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                successCallback(response);
            }
        });
    }

    // Функция для удаления продукта
    function deleteProduct(productID) {
        var data = {
            _method: 'DELETE',
            product_id: productID,
        };

        $.ajax({
            url: deleteProductURL,
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('.data-table1 tbody tr[data-product-id="' + productID + '"]').remove();

                updateTotalPrice();
                $('#myModalProductEdit').hide();
            }
        });
    }

    // Обработчик клика на кнопку "Удалить" продукта
    $('#deleteProduct').click(function () {
        var productID = $('#productID').val();
        deleteProduct(productID);
    });

    // Получение URL для добавления пользователей и удаления пользователей
    var addPeopleURL = $('#addPeopleButton').data('add-people-url');
    var deletePeopleURL = $('#deletePeopleButton').data('delete-people-url');

    // Обработчик клика на кнопку "Добавить" пользователя
    $('#addPeople').click(function () {
        var selectedUserID = $('#peopleSelect option:selected').data('user-id');
        var url = addPeopleURL.replace('__user_id__', selectedUserID);
        var data = {};

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                // Генерация HTML-кода для добавленного пользователя
                var addedPeople = `<tr data-people-id="${response.orderUserID}">
                                    <td class="table-data">${response.userData.name} ${response.userData.email}</td>
                                    <td class="table-data people-debt" style="display: none">Долг: </td>
                                    <td colspan="1">
                                        <button class="delete-button delete-people" data-people-id="${response.orderUserID}">X</button>
                                    </td>
                                </tr>`;
                $('.data-table2 tbody').append(addedPeople);

                // Очистка списка выбора пользователей и обновление списка
                $('#peopleSelect').empty();
                $.each(response.usersNotInOrder, function (index, user) {
                    $('#peopleSelect').append(`<option value="${user.id}" data-user-id="${user.id}">
                                        ${user.name} ${user.email}
                                    </option>`);
                });

                // Скрытие модального окна "People"
                $('#myModalPeople').hide();
            }
        });
    });

    // Функция для удаления пользователя
    function deletePeople(peopleID) {
        var data = {
            _method: 'DELETE',
            people_id: peopleID,
        };

        $.ajax({
            url: deletePeopleURL,
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('.data-table2 tbody tr[data-people-id="' + peopleID + '"]').remove();

                // Очистка списка выбора пользователей и обновление списка
                $('#peopleSelect').empty();
                $.each(response.usersNotInOrder, function (index, user) {
                    $('#peopleSelect').append(`<option value="${user.id}" data-user-id="${user.id}">
                                        ${user.name} ${user.email}
                                    </option>`);
                });
            }
        });
    }

    // Обработчик клика на кнопку "Удалить" пользователя
    $(document).on('click', '.delete-people', function () {
        var peopleID = $(this).closest('tr').data('people-id');
        deletePeople(peopleID);
    });

    // Получение URL для редактирования заказа
    var editOrderURL = $('#editOrderButton').data('edit-order-url');
    var orderStatus = $('#datas').data('order-status');
    var currentStatus = orderStatus;

    // Функция для проверки статуса заказа и отображения соответствующего сообщения
    function checkOrderStatus(status) {
        if (status === 1) {
            $('.order-status').html('Статус заказа: создано');
        } else if (status === 2) {
            $('.order-status').html('Статус заказа: доставлено');
        }
    }

    // Отображение текущего статуса заказа
    checkOrderStatus(orderStatus);

    // Функция для обновления кнопок заказа в зависимости от статуса
    function updateOrderButtons(status) {
        if (status == 2) {
            $('.btn-plus, .btn-minus, .product-edit').addClass('disabled').prop('disabled', true);
            $('#productModal, #peopleModal, #changeStatusClosed, .delete-people').hide();
            $('#productPaid, .people-debt').show();
        }
    }

    // Функция для обновления статуса заказа
    function updateOrderStatus(name, status) {
        var data = {
            _method: 'PUT',
            status: status,
        };

        $.ajax({
            url: editOrderURL,
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                $('.order-status').html('Статус заказа: доставлено');
                orderStatus = response.order.status;
                updateOrderButtons(response.order.status);
            }
        });
    }

    // Обработчик клика на кнопку "Изменить статус на Закрыто"
    $('#changeStatusClosed').click(function () {
        $('#myModalSure').show();
    });

    // Обработчик клика на кнопку "Подтвердить" закрытия заказа
    $('#confirmButton').click(function () {
        updateOrderStatus('', 2);
        $('.btn-minus, .btn-plus, .product-edit').addClass('disabled').prop('disabled', true);
        $('#productModal, #peopleModal, #myModalSure, .delete-people').hide();
        $('#productPaid, .people-debt').show();
    });

    // Обработчик клика на кнопку "Отмена" закрытия заказа
    $('#cancelButton').click(function () {
        orderStatus = currentStatus;
        $('#myModalSure').hide();
    });

    // Обновление кнопок заказа в зависимости от статуса
    updateOrderButtons(orderStatus);

    // Проверка, является ли текущий пользователь владельцем заказа
    var isOwner = $('#datas').data('is-owner');

    if (!isOwner) {
        $('.box-table-user').hide();
    }

    // Обработчик клика на кнопку "Оплачено" продукта
    $('#productPaid').click(function () {
        $('#productPaid').hide();
        var personID = $('#productPaid').data('order-user-id');
        var data = {
            _method: 'PUT',
            user_id: userID,
            paid: 1,
        };

        $.ajax({
            url: totalPriceURL,
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                $('.data-table2 tbody tr[data-people-id="' + personID + '"]').remove();
            }
        });
    });

    // Обработчик клика на кнопку "Назад"
    $('.btn-back').click(function () {
        window.location.href = $(this).data('back');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.login-input');

    inputs.forEach(input => {
        const label = input.nextElementSibling;

        input.addEventListener('input', function() {
            label.style.opacity = input.validity.valid ? '0' : '0';
        });
    });

    const menuButton = document.getElementById("menu-button");
    const username = document.getElementById("username");
    const logoutButton = document.querySelector(".logout-button");

    menuButton.addEventListener("click", function() {
        username.classList.toggle("show");
        logoutButton.classList.toggle("show");
    });
});
