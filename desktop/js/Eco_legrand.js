$('.dtimepickerMonth').datepicker({
    lang: 'fr',
    dateFormat: 'dd/mm',
    changeMonth: true,
    changeYear: false,
    showButtonPanel: false,
    showButtonPanel: false
});

$('#div_pageContainer').on('click', '.cmdAction[data-action=testinfo]', function(event) {

    expression = $(this).closest('.form-group').find('input').value();

    jeedom.scenario.testExpression({
        expression: expression,
        error: function(error) {
            $('#div_alertExpressionTest').showAlert({ message: error.message, level: 'danger' });
        },
        success: function(data) {
            $('#div_alert').showAlert({ message: 'Commande : ' + expression + '. Résultat : ' + data.result, level: 'success' });
        }
    });
});

$("#div_pageContainer").delegate(".listCmdInfo", 'click', function() {
    var el = $(this).closest('.form-group').find('input');
    jeedom.cmd.getSelectModal({ cmd: { type: 'info' } }, function(result) {
        // el.atCaret('insert', result.human);
        el.value(result.human);
    });
});

$(".li_eqLogic").on('click', function(event) {
    if (event.ctrlKey) {
        var type = $('body').attr('data-page')
        var url = '/index.php?v=d&m=' + type + '&p=' + type + '&id=' + $(this).attr('data-eqlogic_id')
        window.open(url).focus()
    } else {
        jeedom.eqLogic.cache.getCmd = Array();
        if ($('.eqLogicThumbnailDisplay').html() != undefined) {
            $('.eqLogicThumbnailDisplay').hide();
        }
        $('.eqLogic').hide();
        if ('function' == typeof(prePrintEqLogic)) {
            prePrintEqLogic($(this).attr('data-eqLogic_id'));
        }
        if (isset($(this).attr('data-eqLogic_type')) && isset($('.' + $(this).attr('data-eqLogic_type')))) {
            $('.' + $(this).attr('data-eqLogic_type')).show();
        } else {
            $('.eqLogic').show();
        }
        $(this).addClass('active');
        $('.nav-tabs a:not(.eqLogicAction)').first().click()
        $.showLoading()
        jeedom.eqLogic.print({
            type: isset($(this).attr('data-eqLogic_type')) ? $(this).attr('data-eqLogic_type') : eqType,
            id: $(this).attr('data-eqLogic_id'),
            status: 1,
            error: function(error) {
                $.hideLoading();
                $('#div_alert').showAlert({ message: error.message, level: 'danger' });
            },
            success: function(data) {
                $('body .eqLogicAttr').value('');
                if (isset(data) && isset(data.timeout) && data.timeout == 0) {
                    data.timeout = '';
                }
                $('body').setValues(data, '.eqLogicAttr');
                if ('function' == typeof(printEqLogic)) {
                    printEqLogic(data);
                }
                if ('function' == typeof(addCmdToTable)) {
                    $('.cmd').remove();
                    for (var i in data.cmd) {
                        addCmdToTable(data.cmd[i]);
                    }
                }
                $('body').delegate('.cmd .cmdAttr[data-l1key=type]', 'change', function() {
                    jeedom.cmd.changeType($(this).closest('.cmd'));
                });

                $('body').delegate('.cmd .cmdAttr[data-l1key=subType]', 'change', function() {
                    jeedom.cmd.changeSubType($(this).closest('.cmd'));
                });
                addOrUpdateUrl('id', data.id);
                $.hideLoading();
                modifyWithoutSave = false;
                setTimeout(function() {
                    modifyWithoutSave = false;
                }, 1000)
            }
        });
    }
    return false;
});

function printEqLogic(_eqLogic) {
    refreshPrix()
}

function addCmdToTable(_cmd) {
    if (!isset(_cmd)) {
        var _cmd = { configuration: {} };
    }
    if (!isset(_cmd.configuration)) {
        _cmd.configuration = {};
    }

    if (init(_cmd.type) == 'info') {
        var disabled = (init(_cmd.configuration.virtualAction) == '1') ? 'disabled' : '';
        var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
        tr += '<td>';
        tr += '<span class="cmdAttr" data-l1key="id"></span>';
        tr += '</td>';
        tr += '<td>';
        tr += '<div class="row">';
        /*      µ tr += '<div class="col-lg-2">';
             tr += '<span class="cmdAttr" data-l1key="display" data-l2key="icon" style="margin-left : 10px;"></span>';
            tr += '</div>';*/
        tr += '<div class="col-lg-10">';
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="name">';
        tr += '</div>';

        tr += '</div>';
        tr += '</td>';
        /* tr += '<td>';
            tr += '<div class="col-lg-10">';
            tr += '<input class="cmdAttr form-control input-sm" data-l1key="logicalId">';
            tr += '</div>';
            tr += '</td>';*/
        tr += '<td>';
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="unite" style="width : 90px;" placeholder="{{Unite}}">';
        tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr checkbox-inline" data-l1key="isHistorized" checked/>{{Historiser}}</label></span> ';
        tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr checkbox-inline" data-l1key="isVisible" checked/>{{Afficher}}</label></span> ';
        tr += '</td>';
        if (typeof jeeFrontEnd !== 'undefined' && jeeFrontEnd.jeedomVersion !== 'undefined') {
            tr += '<td>';
            tr += '<span class="cmdAttr" data-l1key="htmlstate"></span>';
            tr += '</td>';
        }
        tr += '<td>';
        if (is_numeric(_cmd.id)) {
            tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fas fa-cogs"></i></a> '
            tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fas fa-rss"></i> {{Tester}}</a>'


        }
        if (init(_cmd.isHistorized == 1)) {

            tr += '<a class = "btn btn-default btn-xs historique" id = ' + init(_cmd.id) + '>'
            tr += '<i class = "fas fa-history"> </i> Afficher historique'
            tr += '</a>';


        }
        tr += '</td>';
        if (init(_cmd.configuration.type) == 'inst') {
            $('#inst_cmd tbody').append(tr);
            var tr = $('#inst_cmd tbody tr:last');
        } else if (init(_cmd.configuration.type) == 'csv') {
            $('#csv_cmd tbody').append(tr);
            var tr = $('#csv_cmd tbody tr:last');
        } else if (init(_cmd.configuration.type) == 'teleinfo') {
            $('#teleinfo_cmd tbody').append(tr);
            var tr = $('#teleinfo_cmd tbody tr:last');
        }

    }

    jeedom.eqLogic.builSelectCmd({
        id: $(".li_eqLogic.active").attr('data-eqLogic_id'),
        filter: { type: 'info' },
        error: function(error) {
            $('#div_alert').showAlert({ message: error.message, level: 'danger' });
        },
        success: function(result) {
            tr.find('.cmdAttr[data-l1key=value]').append(result);
            tr.setValues(_cmd, '.cmdAttr');
            jeedom.cmd.changeType(tr, init(_cmd.subType));
        }
    });
    $('.historique').off('click').on('click', function() {
        $('#md_modal3').dialog({
            title: "Historique"
        }).load('index.php?v=d&modal=cmd.history&id=' + this.id).dialog('open')
    })
}

function refreshPrix() {
    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        data: {
            action: 'Récup_Prix',
            id: $('.eqLogicAttr[data-l1key=id]').value(),

        },
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_PrixAlert'));
        },
        success: function(data) {
            if (data.state != 'ok') {
                $('#div_alert').showAlert({ message: data.result, level: 'danger' });
                return;
            }

            $('#ul_Gestprix_elec  tbody').empty();
            $('#ul_Gestprix_gaz  tbody').empty();
            $('#ul_Gestprix_eau  tbody').empty();

            for (var i = 0; i < data.result.length; i++) {
                if (data.result[i]['type'] == "electricité") {
                    var tr_elec = '<tr  class="li_prix bt_sortable" data-prix_id="' + data.result[i]['id'] + '">'
                    tr_elec += '<td>'
                    tr_elec += '<div class="btn btn-success btn-sm updprix">'
                    tr_elec += '<i class="fas fa-pencil-alt "></i>'
                    tr_elec += '</div>'
                    tr_elec += '</td>'
                    tr_elec += '<td style="display: none;">'
                    tr_elec += '<input type="text" class="prixAttr form-control " data-l1key="id" style="display: none;" value="' + data.result[i]['id'] + '">'
                    tr_elec += '</td>'
                    tr_elec += '<td>'
                    tr_elec += '<div style="float:left">' + data.result[i]['date_debut'] + '</div>'
                    tr_elec += '</td>'
                    tr_elec += ' <td>'
                    tr_elec += '<div style="float:left">' + data.result[i]['date_fin'] + '</div>'
                    tr_elec += '</td>'
                    tr_elec += '<td>'
                    tr_elec += ' <div style="float:left">' + data.result[i]['hp'] + '</div>'
                    tr_elec += '</td>'
                    tr_elec += '<td>'
                    tr_elec += '<div style="float:left">' + data.result[i]['hc'] + '</div>'
                    tr_elec += '</td>'
                    tr_elec += '<td>'
                    tr_elec += '<center>'
                    tr_elec += '<a class="btn btn-danger supp_prix"><i class="fas fa-trash"></i></a>'
                    tr_elec += '</center>'
                    tr_elec += '</td>'
                    tr_elec += '</tr>'
                    $('#ul_Gestprix_elec tbody').append(tr_elec);
                } else if (data.result[i]['type'] == "gaz") {
                    var tr_gaz = '<tr class="li_prix bt_sortable" data-prix_id="' + data.result[i]['id'] + '">'
                    tr_gaz += '<td>'
                    tr_gaz += '<div class="btn btn-success btn-sm updprix">'
                    tr_gaz += '<i class="fas fa-pencil-alt "></i>'
                    tr_gaz += '</div>'
                    tr_gaz += '</td>'
                    tr_gaz += '<td style="display: none;">'
                    tr_gaz += '<input type="text" class="prixAttr form-control " data-l1key="id" style="display: none;" value="' + data.result[i]['id'] + '">'
                    tr_gaz += '</td>'
                    tr_gaz += '<td>'
                    tr_gaz += '<div style="float:left">' + data.result[i]['date_debut'] + '</div>'
                    tr_gaz += '</td>'
                    tr_gaz += ' <td>'
                    tr_gaz += '<div style="float:left">' + data.result[i]['date_fin'] + '</div>'
                    tr_gaz += '</td>'
                    tr_gaz += '<td>'
                    tr_gaz += ' <div style="float:left">' + data.result[i]['hp'] + '</div>'
                    tr_gaz += '</td>'
                    tr_gaz += '<td>'
                    tr_gaz += '<div style="float:left">' + data.result[i]['hc'] + '</div>'
                    tr_gaz += '</td>'
                    tr_gaz += '<td>'
                    tr_gaz += '<center>'
                    tr_gaz += '<a class="btn btn-danger supp_prix"><i class="fas fa-trash"></i></a>'
                    tr_gaz += '</center>'
                    tr_gaz += '</td>'
                    tr_gaz += '</tr>'
                    $('#ul_Gestprix_gaz tbody').append(tr_gaz);
                } else if (data.result[i]['type'] == "eau") {
                    var tr_eau = '<tr class="li_prix bt_sortable" data-prix_id="' + data.result[i]['id'] + '">'
                    tr_eau += '<td>'
                    tr_eau += '<div class="btn btn-success btn-sm updprix">'
                    tr_eau += '<i class="fas fa-pencil-alt "></i>'
                    tr_eau += '</div>'
                    tr_eau += '</td>'
                    tr_eau += '<td style="display: none;">'
                    tr_eau += '<input type="text" class="prixAttr form-control " data-l1key="id" style="display: none;" value="' + data.result[i]['id'] + '">'
                    tr_eau += '</td>'
                    tr_eau += '<td>'
                    tr_eau += '<div style="float:left">' + data.result[i]['date_debut'] + '</div>'
                    tr_eau += '</td>'
                    tr_eau += ' <td>'
                    tr_eau += '<div style="float:left">' + data.result[i]['date_fin'] + '</div>'
                    tr_eau += '</td>'
                    tr_eau += '<td>'
                    tr_eau += ' <div style="float:left">' + data.result[i]['hp'] + '</div>'
                    tr_eau += '</td>'
                    tr_eau += '<td>'
                    tr_eau += '<center>'
                    tr_eau += '<a class="btn btn-danger supp_prix"><i class="fas fa-trash"></i></a>'
                    tr_eau += '</center>'
                    tr_eau += '</td>'
                    tr_eau += '</tr>'
                    $('#ul_Gestprix_eau tbody').append(tr_eau);
                }


            }




        }
    })

}

function PopupPrix(id_prix) {
    var prix = '';
    if (typeof id_prix !== 'undefined') {
        prix = '&id_prix=' + id_prix;
    } else {
        $('#bsIsPrwater_type').removeClass("btn-success");
        $('#bsIsPrgaz_type').removeClass("btn-success");
        $('#bsIsPrelec_type').addClass("btn-success");
        $('input[data-l1key="type"]').val('electricité');
    }

    $('#md_GestionPrix').dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        width: 610,
        title: "{{Administration du Prix}}"
    });
    $('#md_GestionPrix').load('index.php?v=d&plugin=Eco_legrand&modal=ajoutprix' + prix);
    $('#md_GestionPrix').dialog('open');
}

$('body').on('click', '.ajout_prix', function() {
    PopupPrix();
});
$('body').on('click', '.supp_prix', function() {
    //$('body').delegate('.btn.btn-danger.supp_prix', 'click', function() {
    var Prix = $(this).closest('.li_prix').getValues('.prixAttr');
    Prix = Prix[0];

    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        data: {
            action: 'Supp_Prix',
            id: Prix.id
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_PrixAlert'));
        },
        success: function(data) {
            if (data.state != 'ok') {
                $('#div_alert').showAlert({ message: data.result, level: 'danger' });
                return;
            }

        }
    });
    $(this).closest('.li_prix').remove();
    $('#div_alert').showAlert({ message: "Suppression réussie.", level: 'success' });
});
$('body').on('click', '.updprix', function() {
    var Prix = $(this).closest('.li_prix').getValues('.prixAttr');
    Prix = Prix[0];
    PopupPrix(Prix.id);
});
$('body').on('click', '.tester_ajout_teleinfo', function() {
    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        data: {
            action: 'Ajout_teleinfo',
            id: $('.eqLogicAttr[data-l1key=id]').value(),
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
        }
    });
});