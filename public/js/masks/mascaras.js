$('.mdata').mask('00/00/0000');
$('.mcpf').mask('000.000.000-00');
$('.mcredit_card').mask('0000 0000 0000 0000');
$('.mcnpj').mask('00.000.000/0000-00');
$('.mcep').mask('00000-000');
$('.mcelular').mask('(00) 00000-0000');
$('.mtelefone').mask('(00) 00000-0000');
$('.mhora').mask('00:00');
$('.porcentagem').mask('0.00000');
$('.porcentagem_dia').mask('00.0000');
$('.porcentagem_mes').mask('00.00');
$('.price').priceFormat({
    prefix: 'R$ ',
    centsSeparator: ',',
    thousandsSeparator: '.'
});
