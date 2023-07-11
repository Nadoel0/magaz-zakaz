$(document).ready(function () {
    function showModal(modalID) {
        $(modalID).show();
    }

    function hideModal() {
        $('.my-modal-space').hide();
    }

    $('#productModal').click(function () {
        showModal('#myModalProduct');
    });

    $('#peopleModal').click(function () {
        showModal('#myModalPeople');
    });

    $('.product-edit').click(function () {
        var productID = $(this).data('product-id');
        $('#productID').val(productID);
        var productName = $(this).closest('tr').find('.table-data.product-name').text();
        var productPrice = $(this).closest('tr').find('.table-data.product-price').text();
        var productAmount = $(this).closest('tr').find('.product-amount').text();
        var price = productPrice / productAmount;

        $('#editProductNameInput').val(productName);
        $('#editProductPriceInput').val(price);
        $('#editProductAmountInput').val(productAmount);

        showModal('#myModalProductEdit')
    });

    $('.close-modal, .my-modal-space').click(function (event) {
        if (event.target === this) {
            hideModal();
        }
    })

    var addProductURL = $('#addProductButton').data('add-product-url');
    var deleteProductURL = $('#deleteProductButton').data('delete-product-url');

    function calculatePrice(price, amount) {
        return price * amount;
    }

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

    var amountProductURL = $('#amountProductButtons').data('product-amount-url');
    var totalPriceURL = $('#totalPrice').data('total-price-url');
    var userID = $('#datas').data('user-id');

    function updateTotalPrice() {
        var totalPrice = calculateTotalPrice();
        $('.total-price').text('Итог: ' + totalPrice);

        var data = {
            _method: 'PUT',
            user_id: userID,
            debt: totalPrice,
        }

        $.ajax({
            url: totalPriceURL,
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response)
            }
        });
    }

    updateTotalPrice();

    $('#addProduct').click(function () {
        var productName = $('#productNameInput').val();
        var productAmount = $('#productAmountInput').val();
        var productPrice = $('#productPriceInput').val();
        var productComment = $('#productCommentInput').val();

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
                var addedProducts = `<tr data-product-id="${response.id}">
                                        <td class="table-data">${response.name}</td>
                                        <td class="table-data product-price" data-product-id="${response.id}">${response.price}</td>
                                        <td class="table-data grid">
                                            <button class="btn-minus">&minus;</button>
                                            <div class="product-amount">${response.amount}</div>
                                            <button class="btn-plus">&plus;</button>
                                        </td>
                                        <td>
                                            <button class="product-edit" data-product-id="{{ $product->id }}">изменить</button>
                                        </td>
                                    </tr>`;

                $('.data-table1 tbody').append(addedProducts);
                $('#productNameInput').val('');
                $('#productAmountInput').val('');
                $('#productPriceInput').val('');
                $('#productCommentInput').val('');
                $('#myModalProduct').hide();
                updateTotalPrice();
            }
        });
    });

    $('.data-table1 tbody').on('click', '.btn-plus, .btn-minus', function () {
        var amountElement = $(this).siblings('.product-amount');
        var priceElement = $(this).closest('tr').find('.product-price');
        var price = parseFloat(priceElement.text());
        var currentAmount = parseFloat(amountElement.text());
        var newAmount = $(this).hasClass('btn-plus') ? currentAmount + 1 : currentAmount - 1;
        var productID = $(this).closest('tr').data('product-id');

        if (newAmount > 0) updateProductData(price, newAmount, amountElement, productID);
    });

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

            targetElement.find('.product-name').text(response.name);
            targetElement.find('.product-price').text(response.price);
            targetElement.find('.product-amount').text(response.amount);

            $('#myModalProductEdit').hide();
            updateTotalPrice();
        });
    });

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

    $('#deleteProduct').click(function () {
        var productID = $('#productID').val();
        deleteProduct(productID);
    });

    var addPeopleURL = $('#addPeopleButton').data('add-people-url');
    var deletePeopleURL = $('#deletePeopleButton').data('delete-people-url');

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
                var addedPeople = `<tr data-people-id="${response.orderUserID}">
                                    <td class="table-data">${response.userData.name} ${response.userData.email}</td>
                                    <td class="table-data people-debt" style="display: none">Долг: </td>
                                    <td colspan="1">
                                        <button class="delete-button delete-people" data-people-id="${response.orderUserID}">X</button>
                                    </td>
                                </tr>`;
                $('.data-table2 tbody').append(addedPeople);
                $('#peopleSelect').empty();
                $.each(response.usersNotInOrder, function (index, user) {
                    $('#peopleSelect').append(`<option value="${user.id}" data-user-id="${user.id}">
                                        ${user.name} ${user.email}
                                    </option>`);
                });
                $('#myModalPeople').hide();
            }
        });
    });

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
                $('#peopleSelect').empty();
                $.each(response.usersNotInOrder, function (index, user) {
                    $('#peopleSelect').append(`<option value="${user.id}" data-user-id="${user.id}">
                                        ${user.name} ${user.email}
                                    </option>`);
                });
            }
        });
    }

    $(document).on('click', '.delete-people', function () {
        var peopleID = $(this).closest('tr').data('people-id');
        deletePeople(peopleID);
    });

    var editOrderURL = $('#editOrderButton').data('edit-order-url');
    var orderStatus = $('#datas').data('order-status');
    var currentStatus = orderStatus;

    function checkOrderStatus(status) {
        if (status === 1) $('.order-status').html('Статус заказа: создано')
        else if (status === 2) $('.order-status').html('Статус заказа: доставлено');
    }

    checkOrderStatus(orderStatus)

    function updateOrderButtons(status) {
        if (status == 2) {
            $('.btn-plus, .btn-minus, .product-edit').addClass('disabled').prop('disabled', true);
            $('#productModal, #peopleModal, #changeStatusClosed, .delete-people').hide()
            $('#productPaid, .people-debt').show();
        }
    }

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

    $('#changeStatusClosed').click(function () {
        $('#myModalSure').show();
    });

    $('#confirmButton').click(function () {
        updateOrderStatus('', 2);
        $('.btn-minus, .btn-plus, .product-edit').addClass('disabled').prop('disabled', true);
        $('#productModal, #peopleModal, #myModalSure, .delete-people').hide();
        $('#productPaid, .people-debt').show();
    });

    $('#cancelButton').click(function () {
        orderStatus = currentStatus;
        $('#myModalSure').hide();
    });

    updateOrderButtons(orderStatus);

    var isOwner = $('#datas').data('is-owner');

    if (!isOwner) {
        $('.box-table-user').hide();
    }

    $('#productPaid').click(function () {
        $('#productPaid').hide();
        var personID = $('#productPaid').data('order-user-id');
        var data = {
            _method: 'PUT',
            user_id: userID,
            paid: 1,
        }

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
});
