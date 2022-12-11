$('#type_elec').click(function() {
    $('#type_eau').removeClass("btn-success").addClass("btn-danger");
    $('#type_gaz').removeClass("btn-success").addClass("btn-danger");
    $('#type_elec').addClass("btn-success").removeClass("btn-danger");
    $('input[data-l1key="type"]').val('electricité');
    $('#labelhc').text('Prix unitaire HT HC:');
    $('#labelhp').text('Prix unitaire HT HP:');
    $('#saisiehc').show();
});

$('#type_eau').click(function() {
    $('#type_elec').removeClass("btn-success").addClass("btn-danger");
    $('#type_gaz').removeClass("btn-success").addClass("btn-danger");
    $('#type_eau').addClass("btn-success").removeClass("btn-danger");
    $('input[data-l1key="type"]').val('eau');
    $('#labelhc').text('Confirmer le prix au M3:');
    $('#labelhp').text('Prix au M3:');
    $('#saisiehc').hide();

});

$('#type_gaz').click(function() {
    $('#type_elec').removeClass("btn-success").addClass("btn-danger");
    $('#type_eau').removeClass("btn-success").addClass("btn-danger");
    $('#type_gaz').addClass("btn-success").removeClass("btn-danger");
    $('input[data-l1key="type"]').val('gaz');
    $('#labelhc').text('Coefficent m3/kWh:');
    $('#labelhp').text('Prix au M3:');
    $('#saisiehc').show();
});




$('.PrixAction[data-action=ajoutprix]').on('click', function() {
    var donnee = $(this).closest('.prixformulaire').getValues('.prixAttr');
    donnee = donnee[0];
    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        data: {
            action: 'Ajout_MAJPrix',
            event: json_encode(donnee),
            eqlogicid: $('.eqLogicAttr[data-l1key=id]').value()
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_alert'));
        },
        success: function(data) {
            if (data.state != 'ok') {
                $('#div_alert').showAlert({ message: data.result, level: 'danger' });
                return;
            }
            refreshPrix();
            $('#md_GestionPrix').dialog('close');
        }
    });

});



$('.dtimepicker').datepicker({
    lang: 'fr',
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true
});