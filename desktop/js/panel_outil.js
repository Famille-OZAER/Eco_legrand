function getDateMysql() {
    console.info('Récuperation des dates des tables mysql');
    $.ajax({
        type: 'POST',
        url: 'plugins/conso/core/ajax/conso.ajax.php?dateMysql',
        data: {
            action: 'LastDateInfo',
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_outilAlert'));
        },
        success: function(data) {
            if (data.state != 'ok') {
                $('#div_outilAlert').showAlert({ message: data.result, level: 'danger' });
                return;
            } else {
                $('#date_trame').html(data.result.trame);
                $('#date_day').html(data.result.day);
                $('#date_mysql').html(data.result.mysql);

                //	$('#date_week').html(data.result.week);
            }
        }
    });
}


/*$('#savebtnreturn').on('click', function(event) {

    var lien = $('#consobtn_return').val();

    jeedom.config.save({
        configuration: $('#conso_outil').getValues('.configKey')[0],
        plugin: 'conso',
        error: function(error) {
            $('#div_outilAlert').showAlert({ message: error.message, level: 'danger' });
        },
        success: function() {
            jeedom.config.load({
                configuration: $('#conso_outil').getValues('.configKey')[0],
                plugin: 'conso',
                error: function(error) {
                    $('#div_outilAlert').showAlert({ message: error.message, level: 'danger' });
                },
                success: function(data) {
                    $('#conso_outil').setValues(data, '.configKey');

                    modifyWithoutSave = false;
                    $('#div_outilAlert').showAlert({ message: '{{Sauvegarde réussie}}', level: 'success' });
                }
            });
        }
    });
});*/


$('#updateModule').on('click', function(event) {

    if (confirm("Etes vous sur de vouloir mettre a jour le plugin ?")) {
        $.ajax({
            type: 'POST',
            url: 'plugins/conso/core/ajax/conso.ajax.php',
            data: {
                action: 'UpdatePlugin',
            },
            dataType: 'json',
            error: function(request, status, error) {
                handleAjaxError(request, status, error, $('#div_outilAlert'));
            },
            success: function(data) {
                if (data.state != 'ok') {
                    $('#div_outilAlert').showAlert({ message: data.result, level: 'danger' });
                    return;
                } else {
                    $('#div_outilAlert').showAlert({
                        message: '{{plugin mis a jour }}',
                        level: 'success'
                    });
                }
            }
        });
    }
});


$('#purger').on('click', function(event) {
    if (confirm("Etes vous sur de vouloir supprimer toutes les données historisées ?")) {
        $.ajax({
            type: 'POST',
            url: 'plugins/conso/core/ajax/conso.ajax.php',
            data: {
                action: 'purger',
            },
            dataType: 'json',
            error: function(request, status, error) {
                handleAjaxError(request, status, error, $('#div_outilAlert'));
            },
            success: function(data) {
                if (data.state != 'ok') {
                    $('#div_outilAlert').showAlert({ message: data.result, level: 'danger' });
                    return;
                } else {
                    $('#div_outilAlert').showAlert({
                        message: '{{Données supprimées avec succès}}',
                        level: 'success'
                    });
                }
            }
        });
    }
});

$('#deamon_relaod').on('click', function(event) {
    $.ajax({
        type: 'POST',
        url: 'plugins/conso/core/ajax/conso.ajax.php',
        data: {
            action: 'ReStartDeamon',
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_outilAlert'));
        },
        success: function(data) {
            if (data.state != 'ok') {
                $('#div_outilAlert').showAlert({ message: data.result, level: 'danger' });
                return;
            }
        }
    });
});

$('#synch_day').on('click', function(event) {
    $.ajax({
        type: 'POST',
        url: 'plugins/conso/core/ajax/conso.ajax.php',
        data: {
            action: 'crontabAllJour',
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_outilAlert'));
        },
        success: function(data) {
            if (data.state != 'ok') {
                $('#div_outilAlert').showAlert({ message: data.result, level: 'danger' });
                return;
            } else {
                $('#div_outilAlert').showAlert({
                    message: '{{Synchro des jours Terminée}}',
                    level: 'success'
                });
            }
        }
    });
});

$('#search_error').on('click', function(event) {
    $('#md_GestionTrameError').dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        /*height: auto,*/
        width: 1024,
        title: "{{Valeurs à verifier}}"
    });
    $('#md_GestionTrameError').load('index.php?v=d&plugin=conso&modal=GestionErreurTrame&action=search');
    $("#md_GestionTrameError").dialog({
        open: function(event, ui) {
            $(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        },
        buttons: {
            'Fermer': function() {
                $(this).dialog('close');
            }
        }
    });
    $('#md_GestionTrameError').dialog('open');
});


$('#date_abo_year').on('change', function(event) { changeDateAbo(); });
$('#date_abo').on('change', function(event) { changeDateAbo(); });


function changeDateAbo() {
    var date = $('#date_abo').val();
    var year = $('#date_abo_year').val();

    var today = new Date();
    var currentYear = today.getFullYear();
    var old = new Date(new Date().setFullYear(new Date().getFullYear() - 1))
    var newyear = new Date(new Date().setFullYear(new Date().getFullYear() + 1))

    if (year < 0)
        var date_year = 'Du ' + date + '-' + old.getFullYear() + ' au ' + date + '-' + currentYear;
    else
        var date_year = 'Du ' + date + '-' + currentYear + ' au ' + date + '-' + newyear.getFullYear();

    $('#result_date').html(date_year);

}


$('.dtimepickerMonth').datepicker({
    lang: 'fr',
    dateFormat: 'mm-dd',
    changeMonth: true,
    changeYear: false,
    showButtonPanel: false
});

$('#id_equip').on('click', function(event) {
    $('#md_change_id_ecq').dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        height: 420,
        width: 600,
        title: "{{Changement équipement ID}}"
    });
    $('#md_change_id_ecq').load('index.php?v=d&plugin=conso&modal=GestionEcq&action=change');
    $("#md_change_id_ecq").dialog({
        open: function(event, ui) {
            $(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        },
        buttons: {
            'Fermer': function() {
                //do something
                $(this).dialog('close');
            },
            "Enregistrer": {
                click: function() {
                    $('.ChangeAction').click();
                },
                text: 'Enregistrer',
                class: 'btn btn-success'
            }
        }
    });
    $('#md_change_id_ecq').dialog('open');
});

$('#del_id_equip').on('click', function(event) {
    $('#md_change_id_ecq').dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        height: 420,
        width: 600,
        title: "{{Supprimer les données d'un  équipement}}"
    });
    $('#md_change_id_ecq').load('index.php?v=d&plugin=conso&modal=GestionEcq&action=del');
    $("#md_change_id_ecq").dialog('option', 'buttons', {
        "{{Fermer}}": function() {
            $(this).dialog("close");
        }
    });
    $('#md_change_id_ecq').dialog('open');
});





$('#synch_this').on('click', function(event) {
    $.ajax({
        type: 'POST',
        url: 'plugins/conso/core/ajax/conso.ajax.php',
        data: {
            action: 'crontabJour',
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_outilAlert'));
        },
        success: function(data) {
            if (data.state != 'ok') {
                $('#div_outilAlert').showAlert({ message: data.result, level: 'danger' });
                return;
            } else {
                $('#div_outilAlert').showAlert({
                    message: '{{Synchro du jours Terminée}}',
                    level: 'success'
                });
            }
        }
    });
});


/*jeedom.config.load({
    configuration: $('#conso_outil').getValues('.configKey')[0],
    plugin: 'conso',
    error: function(error) {
        $('#div_outilAlert').showAlert({ message: error.message, level: 'danger' });
    },
    success: function(data) {
        $('#conso_outil').setValues(data, '.configKey');
    }
});*/