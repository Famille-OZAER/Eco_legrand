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