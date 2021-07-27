$(function () {
    $('.add-to-cart').on('click', addToCart);
});

function addToCart(event) {
    event.preventDefault();
    let url = $(this).data('url');

    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: url,
        success: function (data) {
            if (data.code == 200) {
                Swal.fire('Thêm vào giỏ hàng thành công!')
                if (data.cartNumber > 0) {
                    var cartNumber = data.cartNumber;
                    var htmlObj = document.getElementById('span-cart');
                    htmlObj.innerHTML = cartNumber;
                }
            }
        },
        error: function () {

        }
    });
};
