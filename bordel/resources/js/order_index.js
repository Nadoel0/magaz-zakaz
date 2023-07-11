$(document).ready(function () {
    $('.toggle-btn').click(function () {
        var target = $(this).data('target');
        $('.toggle-btn').removeClass('active');
        $(this).addClass('active');
        $('.order-block').hide();
        $('#' + target).show();
        if (target == 'closed-orders') $('.create-order-container').hide();
        else $('.create-order-container').show();
    });

    $('.btn-create-order').click(function () {
        $('#myModalCreateOrder').show();
    });

    $('.close-modal, .my-modal-space').click(function (event) {
        if (event.target === this) {
            $('.my-modal-space').hide();
        }
    });

    $('.order-cart').click(function () {
        window.location.href = $(this).data('order-show-url');
    })

    $('#createOrder').click(function () {
        var orderName = $('#orderName').val();
        var selectedUsers = $('#userSelect').val();
        var ownerID = $('#createOrderButton').data('owner-id');
        var orderCreateURL = $('#createOrderButton').data('order-create-url');
        var data = {
            name: orderName,
            user_id: selectedUsers,
            owner_id: ownerID,
            status: 1
        }

        $.ajax({
            url: orderCreateURL,
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#nameError').text('');
                $('#userError').text('');
                var targetElement = $('#opened-orders');
                var orderData = `<div class="order-cart" data-order-id="${response.id}">
                    <h5>Заказ №${response.id}</h5>
                    <p>Имя заказа: ${response.name}</p>
                    <p>Дата заказа: ${response.date}</p>
                </div>`;
                targetElement.append(orderData);
                $('#orderName').val('');
                $('#userSelect').val('');
                $('#nameError').val('');
                $('#userError').val();
                $('#myModalCreateOrder').hide();
            },
            error: function (error) {
                var errors = error.responseJSON.errors;
                if (errors.hasOwnProperty('name')) {
                    $('#nameError').text(errors.name[0]);
                } else {
                    $('#nameError').text('');
                }
                if (errors.hasOwnProperty('user_id')) {
                    $('#userError').text(errors.user_id[0]);
                } else {
                    $('#userError').text('');
                }
            }
        });
    });
});
