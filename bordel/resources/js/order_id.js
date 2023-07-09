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

    $('#editModal').click(function () {
        showModal('#myModalEdit');
    })

    $('#peopleModal').click(function () {
        showModal('#myModalPeople');
    });

    $('.close-modal, .my-modal-space').click(function (event) {
        if (event.target === this) {
            hideModal();
        }
    })

    // var selectElement = document.querySelector('.form-select');
    // var priceInput = document.querySelector('.modal-price-input');
    //
    // selectElement.addEventListener('change', function () {
    //     var selectedOption = selectElement.options[selectElement.selectedIndex];
    //     var price = selectedOption.getAttribute('data-price');
    //     priceInput.value = price;
    // });

    var addProductURL = $('#addProductButton').data('add-product-url');
    var deleteProductURL = $('#deleteProductButton').data('delete-product-url');

    function calculatePrice(price, amount) {
        return price * amount;
    }

    function updateTableIndex() {
        var tableRows = $('.data-table1 tbody tr');

        tableRows.each(function (index) {
            $(this).find('td:first-child').text(index + 1);
        });
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
                                        <td class="table-data">${response.id}</td>
                                        <td class="table-data">${response.name}</td>
                                        <td class="table-data product-price" data-product-id="${response.id}">${response.price}</td>
                                        <td class="table-data grid">
                                            <button class="btn-minus">&minus;</button>
                                            <div class="product-amount">${response.amount}</div>
                                            <button class="btn-plus">&plus;</button>
                                        </td>
                                        <td>
                                            <button class="delete-button" data-product-id="${response.id}">X</button>
                                        </td>
                                    </tr>`;

                $('.data-table1 tbody').append(addedProducts);
                updateTableIndex();
                $('#productNameInput').val('');
                $('#productAmountInput').val('');
                $('#productPriceInput').val('');
                $('#productCommentInput').val('');
                $('#myModalProduct').hide();
                updateTotalPrice();
            }
        });
    });

    $('.data-table1 tbody').on('click', '.btn-plus, .btn-minus', function() {
        var amountElement = $(this).siblings('.product-amount');
        var priceElement = $(this).closest('tr').find('.product-price');
        var price = parseFloat(priceElement.text());
        var currentAmount = parseFloat(amountElement.text());
        var newAmount = $(this).hasClass('btn-plus') ? currentAmount + 1 : currentAmount - 1;
        var productID = $(this).closest('tr').data('product-id');

        if (newAmount > 0) updateProductData(price, newAmount, amountElement, productID);
    });


    function updateProductData(price, newAmount, amountElement, productID) {
        var unitPrice = price / parseFloat(amountElement.text());
        var totalPrice = unitPrice * newAmount;
        var data = {
            _method: 'PUT',
            amount: newAmount,
            price: totalPrice,
            productID: productID,
        }

        $.ajax({
            url: amountProductURL,
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('.product-price[data-product-id="' + productID + '"]').html(response.price);
                amountElement.html(response.amount);
                updateTotalPrice();
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
            }
        });
    }

    $('.delete-product').click(function () {
        var productID = $(this).closest('tr').data('product-id');
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
                                    <td>
                                        <button class="delete-button" data-people-id="${response.orderUserID}">X</button>
                                    </td>
                                </tr>`;

                $('.data-table2 tbody').append(addedPeople);
                $('#peopleSelect').val('');
                $('#myModalPeople').hide();
            }
        })
    })

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
            }
        });
    }

    $('.delete-people').click(function () {
        var peopleID = $(this).closest('tr').data('people-id');
        deletePeople(peopleID);
    });

    var editOrderURL = $('#editOrderButton').data('edit-order-url');
    var orderStatus = $('#datas').data('order-status');
    var currentStatus = orderStatus;

    function updateOrderButtons(status) {
        if (status == 2) {
            $('#changeStatusClosed').show();
            $('#changeStatusOrdered').hide();
        } else if (status == 3) {
            $('.btn-plus, .btn-minus, .delete-product').addClass('disabled').prop('disabled', true);
            $('#editModal, #productModal, #peopleModal, .delete-people').hide()
            $('#productPaid, .people-debt').show();
        }
    }

    function updateOrderStatus(name, status) {
        var data = {
            _method: 'PUT',
            status: status,
        };

        if (name !== '') {
            data.name = name;
        }

        $.ajax({
            url: editOrderURL,
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                $('.order-name').html('Имя заказа: ' + response.order.name);
                $('.my-modal-content input').val('');
                $('.order-status').html('Статус заказа: ' + response.order.status);
                orderStatus = response.order.status;
                $('#myModalEdit').hide();
                updateOrderButtons(response.order.status);
            }
        });
    }

    $('#editOrder').click(function () {
        var name = $('#orderNameInput').val();
        updateOrderStatus(name, orderStatus);
    });

    $('#changeStatusOrdered').click(function () {
        updateOrderStatus('', 2);
    });

    $('#changeStatusClosed').click(function () {
        $('#myModalSure').show();
    });

    $('#confirmButton').click(function () {
        updateOrderStatus('', 3);
        $('.btn-minus, .btn-plus, .delete-product').addClass('disabled').prop('disabled', true);
        $('#productModal, #peopleModal, #myModalEdit, #myModalSure, #editModal, .delete-people').hide();
        $('#productPaid, .people-debt').show();
    });

    $('#cancelButton').click(function () {
        orderStatus = currentStatus;
        $('#myModalSure').hide();
    });

    updateOrderButtons(orderStatus);

    var isOwner = $('#datas').data('is-owner');

    if (!isOwner) {
        $('#editModal, #peopleModal, .delete-people').hide();
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
