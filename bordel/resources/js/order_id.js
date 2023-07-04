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

    $('#addProduct').click(function () {
        var selectedProduct = $('#productSelect').val();
        var selectedPrice = $('#productSelect option:selected').data('price');
        var comment = $('.my-modal-content textarea').val();
        var price = $('.my-modal-content input[placeholder="Price"]').val();
        var inputPrice = comment ? price : selectedPrice;
        var data = {
            product_id: selectedProduct,
            comment: comment,
            price: inputPrice,
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
                                <td class="table-data">${response.product.name}</td>
                                <td class="table-data">${response.product.price}</td>
                                <td>
                                    <button class="delete-button" data-product-id="${response.basketID}">X</button>
                                </td>
                            </tr>`;
                $('.data-table1 tbody').append(addedProducts);
                $('#productSelect').val('');
                $('.my-modal-content textarea').val('');
                $('.my-modal-content input[placeholder="Price"]').val('');
                $('#myModalProduct').hide();
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
});
