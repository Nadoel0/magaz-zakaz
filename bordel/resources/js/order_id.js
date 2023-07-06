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

    var selectElement = document.querySelector('.form-select');
    var priceInput = document.querySelector('.modal-price-input');

    selectElement.addEventListener('change', function () {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var price = selectedOption.getAttribute('data-price');
        priceInput.value = price;
    });

    var addProductURL = $('#addProductButton').data('add-product-url');
    var deleteProductURL = $('#deleteProductButton').data('delete-product-url');

    $(document).on('click', '.product-block', function () {
        var selectedProductName = $(this).data('product-name');
        var selectedProductPrice = $(this).data('product-price');

        $('#productNameInput').val(selectedProductName);
        $('#productPriceInput').val(selectedProductPrice);

        $('#myModalProduct').hide();
        $('#editProductModal').show();
    });

    $('#addProduct').click(function () {
        var addProductURL = $('#addProductButton').data('add-product-url');
        var productName = $('#productNameInput').val();
        var productPrice = $('#productPriceInput').val();
        var productComment = $('#productCommentInput').val();

        var data = {
            product_id: productName,
            comment: productComment,
            price: productPrice,
        };

        $.ajax({
            url: addProductURL,
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var addedProducts = `<tr data-product-id="${response.basketID}">
                                        <td class="table-data">${response.product.id}</td>
                                        <td class="table-data">${productComment ? productComment : productName}</td>
                                        <td class="table-data">${productPrice}</td>
                                        <td>
                                            <button class="delete-button" data-product-id="${response.basketID}">X</button>
                                        </td>
                                    </tr>`;

                $('.data-table1 tbody').append(addedProducts);
                $('#productSelect').val('');
                $('.my-modal-content textarea').val('');
                $('.my-modal-content input[placeholder="Price"]').val('');
                $('#editProductModal').hide();
            }
        });
    });

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
            }
        });
    }

    $(document).on('click', '.delete-button', function () {
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
    });

    $(document).on('click', '.delete-button', function () {
        var peopleID = $(this).closest('tr').data('people-id');
        deletePeople(peopleID);
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
            }
        });
    }

    var editOrderURL = $('#editOrderButton').data('edit-order-url');

    $(document).on('click', '#editOrder, #changeStatusButton', function () {
        var newName = $('#orderNameInput').val();
        var newStatus = '';

        var data = {
            _method: 'PUT',
        };

        if (newName !== '') {
            data.name = newName;
        }

        if (orderStatus === 1) {
            newStatus = 2;
        } else if (orderStatus === 2) {
            newStatus = 3;
        }

        if (newStatus !== '') {
            data.status = newStatus;
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

                if (response.order.status === 2) {
                    $('#changeStatusButton[data-status="ordered"]').hide();
                } else if (response.order.status === 3) {
                    $('#changeStatusButton').hide();
                }

                $('#myModalEdit').hide();
            }
        });
    });

    var isOwner = $('#isOwner').data('is-owner');

    if (!isOwner) {
        $('#editModal').hide();
        $('#peopleModal').hide();
        $('#closeOrder').hide();
        $('.delete-people').hide();
    }

    var modal = $('#myModalSure');
    var orderDebtURL = $('#debtButton').data('debt-url');
    var confirmButton = $('#confirmButton');
    var cancelButton = $('#cancelButton');
    var orderStatus = $('#orderIDs').data('order-status');
    var currentStatus = orderStatus;

    $(document).on('change', '#orderStatusInput', function () {
        var newStatus = $(this).val();

        if (newStatus === '3') {
            $('#closeOrder').show();
        } else $('#closeOrder').hide();
    });

    $("#closeOrder").click(function () {
        modal.show();
    });

    confirmButton.click(function () {
        window.location.href = orderDebtURL;
    });

    cancelButton.click(function () {
        orderStatus = currentStatus;
        modal.hide();
    });
});
