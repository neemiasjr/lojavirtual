$(document).ready(function () {

    $('#formComprar').on('click', function (e) {

        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(), // serializes the form's elements.
            success: function (data) {
                console.log('Produto Inserido com sucesso no carrinho!!');
            }
        });
    });

});