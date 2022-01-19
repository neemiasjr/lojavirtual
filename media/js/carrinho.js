$(document).ready(function () {
  // validar frete
  $('#buscar_frete').click(function (e) {
    var CEP_CLIENTE = $('#cep_frete').val()
    var PESO_FRETE = $('#peso_frete').val()

    if (CEP_CLIENTE.length !== 8) {
      $('.errormsg').notify('Digite seu CEP corretamente, 8 dígitos e sem traço ou ponto', 'error');
      $('#cep_frete').focus();
    } else {
      $('#frete').html(
        '<img src="view/images/loader.gif"> <b>Carregando...</b>');
      $('#frete').addClass(' text-center text-danger');

      // carrego o combo com os bairros

      $('#frete').load('controller/frete.php?cepcliente='+CEP_CLIENTE+'&pesofrete='+PESO_FRETE);
      // $('#formBuscarFrete').submit(function (e) {
      //   $.ajax({
      //     type: 'GET',
      //     url: 'controller/frete.php',
      //     data: {
      //       cepcliente: CEP_CLIENTE,
      //       pesofrete: PESO_FRETE
      //     },
      //     success: function (data) {
      //       $('#frete').html(data);
      //     },
      //     error: function (data) {
      //       console.log('An error occurred.')
      //       console.log(data)
      //     },
      //   });
      // });
    } // fim do IF digitei o CEP
  }) // fim do change
}) // fim do ready
