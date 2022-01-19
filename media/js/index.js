$(document).ready(function () {
  let frm = $('#formBuscarProduto')

  frm.submit(function (e) {
    $('.errormsg').notify('Procurando o produto: ' + $('.txt_buscar').val(), 'info')
    $.ajax({
      type: 'POST',
      url: 'produto',
      data: frm.serialize(),
      success: function (data) {
        console.log(data)
      },
      error: function (data) {
        console.log('An error occurred.')
        console.log(data)
      },
    })
  });
});
