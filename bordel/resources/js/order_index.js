$(document).ready(function () {
    // Обработчик клика на кнопки переключения
    $('.toggle-btn').click(function () {
        var target = $(this).data('target');
        $('.toggle-btn').removeClass('active');
        $(this).addClass('active');
        $('.order-block').hide();
        $('#' + target).show();
        if (target == 'closed-orders') {
            $('.create-order-container').hide();
        } else {
            $('.create-order-container').show();
        }
    });

    // Обработчик клика на кнопку "Создать заказ"
    $('.btn-create-order').click(function () {
        $('#myModalCreateOrder').show();
    });

    // Обработчик клика на блок заказа
    $('.order-cart').click(function () {
        window.location.href = $(this).data('order-show-url');
    });

    // Обработчик клика на кнопку "Создать заказ" в модальном окне
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
        };

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
                window.location.href = $('#createOrder').data('order-show-url').replace('__order_id__', response.id);
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
