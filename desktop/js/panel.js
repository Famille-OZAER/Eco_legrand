hideall();
verifParam();
//$(".mainnav li.bt_elec").addClass('active');
//$('.bt_elec').removeClass('cursor');
//$('#Eco_legrand_elec').show();
//loadingDash($('#Eco_legrand_ecq').val(), true);

refreshPrix();
$('#Eco_legrand_tarifs').show();
$(".mainnav li.bt_tarifs").addClass('active');
$('.bt_tarifs').removeClass('cursor');



$('#Eco_legrand_ecq').on('change', function() {

    $(".mainnav li.active").click();
    loadingDash($('#Eco_legrand_ecq').val(), true); // chargement du dashboard
});
//$('.datetimepicker').datepicker({ 'format': 'yyyy-m-d', 'autoclose': true }).datepicker("setDate", "0");

jQuery(function($) {

    //circle = Circles.create({
    //	id: 'circles-1',
    //	value: refreshTime,
    //	text: function (value) {
    //		return parseInt(value);
    //	},
    //	radius: 20,
    //	width: 7,
    //	maxValue: refreshTime,
    //	colors: ['#303030', '#b2afaa']
    //});

    $('[data-toggle="tooltip"]').tooltip();


});


/*clique pour basculer sur le graph temperature*/
$('.icon_flip, .icon_return').click(function() {
    /*
    $(this).parents('.card').find('.front').fadeToggle("fast");
   
    $(this).parents('.card').find('.back').fadeToggle("fast");*/
    if ($(this).parents('.card').find('.front').is(":visible")) {
        if ($(this).parents('.card').find('.back').length) {
            $(this).parents('.card').find('.back').fadeToggle();
        }
        if ($(this).parents('.card').find('.back1').length) {

            $(this).parents('.card').find('.back1').fadeToggle();
        }
        $(this).parents('.card').find('.front').hide()
    } else if ($(this).parents('.card').find('.back').is(":visible")) {
        $(this).parents('.card').find('.front').fadeToggle();
        $(this).parents('.card').find('.back').hide()
    } else if ($(this).parents('.card').find('.back1').is(":visible")) {
        $(this).parents('.card').find('.back2').fadeToggle();
        $(this).parents('.card').find('.back1').hide()
    } else if ($(this).parents('.card').find('.back2').is(":visible")) {
        $(this).parents('.card').find('.front').fadeToggle();
        $(this).parents('.card').find('.back2').hide()
    }

    $('.chart').each(function() {
        let highcharts = $(this).highcharts();
        if (!(highcharts === undefined)) {
            highcharts.reflow();
        }
    });

});

Highcharts.setOptions({
    lang: {
        // months: Permet de définir le nom des mois en Français
        months: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
        // shortMonths: Permet de définir l'abréviation du nom des mois en Français (Utilisées par la tooltip)
        shortMonths: ['Janv', 'Fevr', 'Mars', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec'],
        // weekdays: Les jours de la semaine en Français, en commençant par Dimanche
        weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        // download: Tous les textes liés au module d'exportation
        downloadPNG: "T&eacute;l&eacute;charger au format PNG",
        downloadJPEG: "T&eacute;l&eacute;charger au format JPEG",
        downloadPDF: "T&eacute;l&eacute;charger au format PDF",
        downloadSVG: "T&eacute;l&eacute;charger au format SVG",
        // rangeSelector: Texte entre les deux cases de sélection de dates à  droite du graphique
        rangeSelectorFrom: "De",
        rangeSelectorTo: "a"
    }
});


$('#validedatecurrent').click(function() {
    if (($('#current_debut').val() != '' && $('#current_fin').val() != '') && (($('#current_debut').val() < $('#current_fin').val()) || ($('#current_debut').val() == $('#current_fin').val()))) {


        $.ajax({
            type: 'POST',
            url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
            global: true,
            data: {
                id_ecq: $('#Eco_legrand_ecq').val(),
                action: 'loadingDash',
                date_debut: $('#current_debut').val(),
                date_fin: $('#current_fin').val()
            },
            dataType: 'json',
            error: function(request, status, error) {
                handleAjaxError(request, status, error, $('#div_DashboardAlert'));
            },
            success: function(data) {
                if (data.state != 'ok') {
                    $('#div_DashboardAlert').showAlert({ message: data.result, level: 'danger' });

                } else {
                    if (data.result.nb_trame > 0) {
                        showCurrentTrame(data.result);
                    } else {
                        console.debug('Aucune valeur du jour trouvée');
                    }
                }
            }
        });
    }
});


function hideall() {
    for (i = 0; i < $('.row-overflow').length; i++) {
        document.getElementById($('.row-overflow')[i]['id']).style.display = "none";
    }
    for (i = 0; i < $('.mainnav li').length; i++) {
        var element = document.getElementsByClassName($('.mainnav li')[i]['className'])[0]
        if (element.className.includes('bt_') && !element.className.includes('cursor')) {
            element.className += " cursor";
        }

    }
    $('.mainnav li').removeClass('active');

}



$('.bt_elec').on('click', function() {
    if (!$('.bt_elec').hasClass('active')) {
        hideall();
        $('.bt_elec').addClass('active');
        $('.bt_elec').removeClass('cursor');

        loadingDash($('#Eco_legrand_ecq').val(), true); // chargement du dashboard
        $('#Eco_legrand_elec').show();
    };
});

$('.bt_eau').on('click', function() {
    if (!$('.bt_eau').hasClass('active')) {
        hideall();
        $('.bt_eau').removeClass('cursor');
        $('.bt_eau').addClass('active');
        $('#Eco_legrand_eau').show();
    };
});
$('.bt_gaz').on('click', function() {
    if (!$('.bt_gaz').hasClass('active')) {
        hideall();
        $('.bt_gaz').removeClass('cursor');
        $('.bt_gaz').addClass('active');
        $('#Eco_legrand_gaz').show();
    };
});
$('.bt_synthese').on('click', function() {
    if (!$('.bt_synthese').hasClass('active')) {
        hideall();
        $('.bt_synthese').removeClass('cursor');
        $('.bt_synthese').addClass('active');
        $('#Eco_legrand_synthese').show();
    };

});
$('.bt_tarifs').on('click', function() {
    if (!$('.bt_tarifs').hasClass('active')) {
        hideall();
        $('.bt_tarifs').removeClass('cursor');
        $('.bt_tarifs').addClass('active');
        refreshPrix();
        $('#Eco_legrand_tarifs').show();
    };
});
$('.bt_database').on('click', function() {
    if (!$('.bt_database').hasClass('active')) {
        hideall();
        showTeleinfo();
        $('.bt_database').removeClass('cursor');
        $('.bt_database').addClass('active');
        $('#Eco_legrand_database').show();

    };


});
$('#bt_refresh_synthese_mois').click(function() {
    refreshSynthese('mois');
});
$('#bt_refresh_synthese_jour').click(function() {
    refreshSynthese('jours');
});
$('#bt_refresh_synthese_semaine').click(function() {
    refreshSynthese('semaine');
});
$('#bt_refresh_synthese_annee').click(function() {
    refreshSynthese('annee');
});

$('.dtimepicker').datetimepicker({
    lang: 'fr',
    format: 'Y-m-d',
    timepicker: false,
    step: 15
});

$('.dtimepickerTime').datetimepicker({
    lang: 'fr',
    timepicker: true,
    step: 5
});
$('.datetimepicker').datepicker({
    'format': 'yyyy-m-d',
    'autoclose': true
}).datepicker("setDate", "0");


HTMLElement.prototype.hasClass = function(cls) {
    var i;
    var classes = this.className.split(" ");
    for (i = 0; i < classes.length; i++) {
        if (classes[i] == cls) {
            return true;
        }
    }
    return false;
};

function show_graph_temp(data, conteneur) {

    if (timezonebis == null) {
        var timezonebis = "Europe/Brussels";
    }
    //if(data.TEMP_moy==false && data.TEMP_max ==false && data.TEMP_min ==false)
    //$('#'+conteneur).html('Aucune température trouvée dans la base, merci de renseigner la commande dans votre équipement')

    var dataTempMoy = data.TEMP_moy;
    var dataTempMax = data.TEMP_max;
    var dataTempMin = data.TEMP_min;

    return {
        chart: {
            renderTo: conteneur,
            ignoreHiddenSeries: true,
            time: {
                timezone: timezonebis
            },
            events: {
                load: function(chart) {
                    this.myTooltip = new Highcharts.Tooltip(this, this.options.tooltip);
                    // if ($('#' + legend).length) {
                    //     $('#' + legend).html(data.subtitle);
                    // }

                }
            },
            defaultSeriesType: 'spline'
        },
        legend: {
            itemStyle: {
                font: 'Trebuchet MS, Verdana, sans-serif',
                color: "#333333"
            },
            itemHoverStyle: {
                color: "#000"
            },
            itemHiddenStyle: {
                color: "#CCC"
            }
        },
        credits: {
            enabled: false
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'datetime',
            categories: data.categories,
            labels: {
                style: {
                    color: "var(--txt-color)",
                    font: '11px  Verdana, sans-serif'
                },
                rotation: -45,
                align: 'right'
            }
        },
        yAxis: { // Secondary yAxis
            labels: {
                style: {
                    color: "var(--txt-color)"
                }
            },
            title: {
                text: 'Température °C'
            },
            min: -10,
        },

        //***** MIN ***********
        series: [{
                id: 'temp_min',
                name: 'Minimum',
                data: dataTempMin,
                color: '#4572A7',
                tooltip: {
                    valueSuffix: ' °C',
                    valueDecimals: 2,
                },
                dataLabels: {
                    enabled: false,
                    color: "var(--txt-color)",
                    //rotation: -90,
                    //align: 'right',
                    rotation: -45,
                    y: -15,
                    formatter: function() {
                        return parseFloat(this.y) + '°C';
                    },
                    style: {
                        font: 'bold 13px Verdana, sans-serif'
                    }
                },
                type: 'spline',
                showInLegend: true,
            },
            //***** MAX ***********
            {
                id: 'temp_max',
                name: 'Maximum',
                data: dataTempMax,
                color: '#AA4643',
                tooltip: {
                    valueSuffix: ' °C',
                    valueDecimals: 2,
                },
                dataLabels: {
                    enabled: false,
                    color: "var(--txt-color)",
                    //rotation: -90,
                    //align: 'right',
                    rotation: -45,
                    y: -15,
                    formatter: function() {
                        return parseFloat(this.y) + '°C';
                    },
                    style: {
                        font: 'bold 13px Verdana, sans-serif'
                    }
                },
                type: 'spline',
                showInLegend: true,
            },
            //***** MOYENNE ***********
            {
                id: 'temp_moy',
                name: 'Moyenne',
                data: dataTempMoy,
                color: '#FF9214',
                tooltip: {
                    valueSuffix: ' °C',
                    valueDecimals: 2,
                },
                dataLabels: {
                    enabled: false,
                    color: "var(--txt-color)",
                    //rotation: -90,
                    //align: 'right',
                    rotation: -45,
                    y: -15,
                    formatter: function() {
                        return parseFloat(this.y) + '°C';
                    },
                    style: {
                        font: 'bold 13px Verdana, sans-serif'
                    }
                },
                type: 'spline',
                showInLegend: true,
            }
        ],
        navigation: {
            menuItemStyle: {
                fontSize: '10px'
            }
        }
    }

}

function show_graph(data, conteneur) {
    var HC_name = data.HC_name;
    var HP_name = data.HP_name;
    if (!conteneur.includes("Euro")) { /*Affichage des KWH*/

        var HP_data = data.HP_data;
        var HC_data = data.HC_data;
        var title_text = ' kWh';
        var title_text2 = '';
        var tooltip_text = '';
        var tooltip_text2 = ' kWh';

    } else { /*Affichage des prix */

        var HP_data = data.HP_data_prix_ttc;
        var HC_data = data.HC_data_prix_ttc;
        var title_text = ' €';
        var tooltip_text = ' €';
        var title_text2 = ' €';
        var tooltip_text2 = ' €';

    }


    if (timezonebis == null) {
        var timezonebis = "Europe/Brussels";
    }

    return {
        chart: {
            renderTo: conteneur,
            ignoreHiddenSeries: true,
            time: {
                timezone: timezonebis
            },
            events: {
                load: function(chart) {
                    this.myTooltip = new Highcharts.Tooltip(this, this.options.tooltip);
                }
            },

            Type: 'column',
        },
        legend: {
            itemStyle: {
                font: 'Trebuchet MS, Verdana, sans-serif',
                color: "#333333"
            },
            itemHoverStyle: {
                color: "#000"
            },
            itemHiddenStyle: {
                color: "#CCC"
            }
        },
        credits: {
            enabled: false
        },
        title: {
            text: ''
        },

        subtitle: {
            text: ''

        },

        xAxis: [{
            type: 'datetime',
            categories: data.categories,
            labels: {
                style: {
                    color: "var(--txt-color)",
                    textOutline: false,
                    font: '11px  Verdana, sans-serif'
                },
                rotation: -45,
                align: 'right'
            }
        }],

        yAxis: { // Secondary yAxis
            title: {
                text: title_text
            },
            min: 0,
            minorGridLineWidth: 0,
            labels: {
                formatter: function() { return this.value + title_text },
                style: {
                    color: "var(--txt-color)"
                }
            },
            stackLabels: {
                enabled: true,
                formatter: function() {
                    return this.total + tooltip_text;
                },
                style: {
                    textOutline: false,
                    fontWeight: 'bold',
                    color: "var(--txt-color)"
                }
            }
        },

        tooltip: {
            enabled: true,
            useHTML: true,
            share: true,
            formatter: function() {
                return '<span style="color:' + this.series.color + '">' + this.series.name + '</span>: <b>' + this.y + tooltip_text2 + '</b><br/>';
            }
        },
        /*regroupe les colonnes sur 1 */
        plotOptions: {
            series: {
                stickyTracking: false,
                borderWidth: 0,
                events: {
                    click: function(evt) {
                        this.chart.myTooltip.refresh(evt.point, evt);
                    },
                    mouseOut: function() {
                        this.chart.myTooltip.hide();
                    }
                }

            },
            column: {
                stacking: ((data.enabled_old && conteneur != 'YearTaxe') ? false : 'normal')
            }
        },
        //***** HP***********
        series: [{
                id: 'serie_hp',
                name: HP_name,
                data: HP_data,
                color: '#AA4643',
                stack: 'current',
                index: 60,
                dataLabels: {
                    enabled: true,
                    color: "var(--txt-color)",
                    shadow: false,
                    formatter: function() {
                        return parseFloat(this.y) + title_text2;
                    },
                    style: {
                        //textOutline: false,
                        fontSize: '8px !important',
                        font: 'bold 8px Verdana, sans-serif !important'
                    }
                },
                type: data.HP_type_graph,
                showInLegend: true,
            },
            //***** HC***********
            {
                id: 'serie_hc',
                name: HC_name,
                data: HC_data,
                visible: true,
                index: 50,
                stack: 'current',
                color: '#4572A7',
                dataLabels: {
                    enabled: true,
                    color: "var(--txt-color)",
                    //rotation: -90,
                    //align: 'right',

                    formatter: function() {
                        return parseFloat(this.y) + title_text2;
                    },
                    style: {
                        //textOutline: false,
                        fontSize: '8px !important',
                        font: 'bold 8px Verdana, sans-serif !important'
                    }
                },
                type: data.HP_type_graph,
                showInLegend: true,
            }
        ],
        navigation: {
            menuItemStyle: {
                fontSize: '10px'
            }
        }
    }
}

function verifParam() {

    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        data: {
            action: 'VerifParam'
        },
        dataType: 'json',
        global: false,
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_VerifParam'));
        },
        success: function(data) {
            if (data.result != '') {

                $('#div_VerifParam').showAlert({ message: '<ul>' + data.result + '</ul>', level: 'danger' });

            }
        }
    });
}

function loadingDash(id_equipement, all) {


    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        global: true,
        data: {
            id_ecq: id_equipement,
            action: 'loadingDash',
        },
        global: false,
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_DashboardAlert'));
        },
        success: function(data) {
            if (data.state != 'ok') {
                $('#div_DashboardAlert').showAlert({ message: data.result, level: 'danger' });

            } else {
                if (data.result.nb_trame > 0) {
                    initDashBoard(data.result, all);

                } else {
                    console.info('Aucune valeur du jour trouvée verifier les équipements');
                }
            }
        }
    });
    return true;
}

function initDashBoard(datas, all) {

    deferred = $.Deferred();
    /*Affichage tablo conso PUIS Affichage Graphique Jours Semaine Mois*/

    MAJ_menu(datas.trame_du_jour, true);
    if (!all) {
        return
    }

    Tableau_Conso()
    showDashGraph()
        /*affichage données detail dans le menu*/


    /*la puissance_totale n est pas renseigné */

    if (parseInt(datas.trame_du_jour[datas.trame_du_jour.length - 1].puissance_totale) < 0) {
        $('#tab_info').hide();
        $('#gauge').hide();
        $('#Currentbar').hide();

        var txt = 'Pour visualiser la gauge merci de renseigner la Puissance instantanée dans la configuration de votre équipement';
        $('#tab_list').append('Pour visualiser la gauge merci de renseigner la Puissance instantanée dans la configuration de votre équipement');
        $('#contentegauge').append('Pour visualiser les variations merci de renseigner la Puissance instantanée dans la configuration de votre équipement');
        $('#contentebar').append('Pour visualiser le graphique merci de renseigner la Puissance instantanée dans la configuration de votre équipement');
    }

    Gauge(datas.trame_du_jour, true, datas.isous);

    /*Affichage du graph du jour*/
    showCurrentTrame(datas);
    loadingPie($('#Eco_legrand_ecq').val())

    /*Affichage Graphique Jours Semaine Mois */
    //showDashGraph(style);

    $(window).resize();

    return true;
}

function Tableau_Conso() {

    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        global: false,
        data: {
            id_ecq: $('#Eco_legrand_ecq').val(),
            action: 'TabConso'
        },
        dataType: 'json',

        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_DashboardAlert'));
        },
        success: function(data) {


            if (data.state != 'ok') {
                $('#div_DashboardAlert').showAlert({ message: data.result, level: 'danger' });
                return;
            } else {

                var unity = ' kWh';
                var title_tb2 = 'Watt';



                $('#title_tb2').text(title_tb2);

                Devise = ' €'
                if (data.result.conso_jour !== false) {
                    /****************/
                    /*JOUR Euro*/
                    /****************/
                    $('#day_hp').html(data.result.conso_jour.total_hp_ttc.toFixed(2) + Devise);
                    $('#day_hc').html(data.result.conso_jour.total_hc_ttc.toFixed(2) + Devise);
                    $('#day_total').html(data.result.conso_jour.total_ttc.toFixed(2) + Devise);

                    /****************/
                    /*JOUR Watt*/
                    /****************/


                    $('#day_hpw').html(data.result.conso_jour.hp.toFixed(2) + unity);
                    $('#day_hcw').html(data.result.conso_jour.hc.toFixed(2) + unity);
                    $('#day_totalw').text((data.result.conso_jour.hp + data.result.conso_jour.hc).toFixed(2) + unity);

                } else {
                    $('#day_hp').html('Indispo.');
                    $('#day_hc').html('Indispo.');
                    $('#day_total').html('Indispo.');
                    $('#day_hpw').html('Indispo.');
                    $('#day_hcw').html('Indispo.');
                    $('#day_totalw').html('Indispo.');
                }

                if (data.result.conso_hier !== false) {
                    /****************/
                    /*HIER Euro*/
                    /****************/
                    $('#yesterday_hp').html(data.result.conso_hier.total_hp_ttc.toFixed(2) + Devise);
                    $('#yesterday_hc').html(data.result.conso_hier.total_hc_ttc.toFixed(2) + Devise);
                    $('#yesterday_total').html(data.result.conso_hier.total_ttc.toFixed(2) + Devise);

                    /****************/
                    /*HIER Watt*/
                    /****************/
                    $('#yesterday_hpw').html(data.result.conso_hier.hp.toFixed(2) + unity);
                    $('#yesterday_hcw').html(data.result.conso_hier.hc.toFixed(2) + unity);
                    $('#yesterday_totalw').text((data.result.conso_hier.hp + data.result.conso_hier.hc).toFixed(2) + unity);


                } else {
                    $('#yesterday_hp').html('Indispo.');
                    $('#yesterday_hc').html('Indispo.');
                    $('#yesterday_total').html('Indispo.');
                    $('#yesterday_hpw').html('Indispo.');
                    $('#yesterday_hcw').html('Indispo.');
                    $('#yesterday_totalw').html('Indispo.');
                }

                if (data.result.conso_semaine !== false) {
                    /****************/
                    /*SEMAINE Euro*/
                    /****************/
                    $('#week_hp').html(data.result.conso_semaine.total_hp_ttc.toFixed(2) + Devise);
                    $('#week_hc').html(data.result.conso_semaine.total_hc_ttc.toFixed(2) + Devise);

                    $('#week_total').html(data.result.conso_semaine.total_ttc.toFixed(2) + Devise);

                    /****************/
                    /*SEMAINE Watt*/
                    /****************/
                    $('#week_hpw').html(data.result.conso_semaine.hp.toFixed(2) + unity);
                    $('#week_hcw').html(data.result.conso_semaine.hc.toFixed(2) + unity);
                    $('#week_totalw').text((data.result.conso_semaine.hp + data.result.conso_semaine.hc).toFixed(2) + unity);

                } else {
                    $('#week_hp').html('Indispo.');
                    $('#week_hc').html('Indispo.');
                    $('#week_total').html('Indispo.');
                    $('#week_hpw').html('Indispo.');
                    $('#week_hcw').html('Indispo.');
                    $('#week_totalw').html('Indispo.');
                }
                if (data.result.conso_mois !== false) {
                    /****************/
                    /*MOIS Euro*/
                    /****************/
                    $('#month_hp').html(data.result.conso_mois.total_hp_ttc.toFixed(2) + Devise);
                    $('#month_hc').html(data.result.conso_mois.total_hc_ttc.toFixed(2) + Devise);
                    $('#month_total').html(data.result.conso_mois.total_ttc.toFixed(2) + Devise);

                    /****************/
                    /*MOIS Watt*/
                    /****************/

                    $('#month_hpw').html(data.result.conso_mois.hp.toFixed(2) + unity);
                    $('#month_hcw').html(data.result.conso_mois.hc.toFixed(2) + unity);
                    $('#month_totalw').text((data.result.conso_mois.hp + data.result.conso_mois.hc).toFixed(2) + unity);
                    $('.datefactmois').attr('title', data.result.title_mois);
                } else {
                    $('#month_hp').html('Indispo.');
                    $('#month_hc').html('Indispo.');
                    $('#month_total').html('Indispo.');
                    $('#month_hpw').html('Indispo.');
                    $('#month_hcw').html('Indispo.');
                    $('#month_totalw').html('Indispo.');
                    $('.datefactmois').attr('title', data.result.title_mois);
                }
                if (data.result.conso_année !== false) {
                    /****************/
                    /*ANNEE Euro*/
                    /****************/
                    $('#year_hp').html(data.result.conso_année.total_hp_ttc.toFixed(2) + Devise);
                    $('#year_hc').html(data.result.conso_année.total_hc_ttc.toFixed(2) + Devise);
                    $('#year_total').html(data.result.conso_année.total_ttc.toFixed(2) + Devise);
                    /****************/
                    /*ANNEE Watt*/
                    /****************/
                    $('#year_hpw').html(data.result.conso_année.hp.toFixed(2) + unity);
                    $('#year_hcw').html(data.result.conso_année.hc.toFixed(2) + unity);
                    $('#year_totalw').text((data.result.conso_année.hp + data.result.conso_année.hc).toFixed(2) + unity);

                    $('.datefact').attr('title', data.result.title_année);
                    //$('.datefactyearold').attr('title', data.result.titleold);


                } else {
                    $('#year_hp').html('Indispo.');
                    $('#year_hc').html('Indispo.');
                    $('#year_total').html('Indispo.');
                    $('#year_hpw').html('Indispo.');
                    $('#year_hcw').html('Indispo.');
                    $('#year_totalw').html('Indispo.');
                }

                $('.tts').html('HP');
                $('.tts2').html('HP');
                var refreshdate = getDateRefresh();
                $('.date_refresh').html(refreshdate);

            }
            deferred.resolve();
        }
    });
    return deferred.promise();
}

function MAJ_menu(data, init) {

    if (init)
        data = data[0];

    /*AFFICHAGE DE L ICONE PERIODE DU MENU*/
    if (data.ptec == 'HC') {
        $('.iconeptec').removeClass('redcolor').addClass('bluecolor');
    } else {
        $('.iconeptec').removeClass('bluecolor').addClass('redcolor');
    }
    /*AFFICHAGE DE L ICONE intensité DU MENU*/
    if (data.int_instant > 9) {
        $('#Eco_legrand_ints1').removeClass('ints1simple').addClass('ints1double');
    } else {
        $('#Eco_legrand_ints1').removeClass('ints1double').addClass('ints1simple');
    }

    $('#Eco_legrand_ptec').text(data.ptec);
    /*Affichage de la période*/

    /*La puissance_totale n est pas renseigné */
    if (parseInt(data.int_instant) <= 0) {
        $('#tab_detail .middle').hide();
    } else {
        $('#tab_detail .middle').show();
        $('#Eco_legrand_ints1').text(data.int_instant + 'A');
        /*Affichage de intensité*/
    }

    /*La puissance_totale n est pas renseigné */
    if (parseInt(data.imax) <= 0) {
        $('#tab_detail .last').hide();
    } else {
        $('#tab_detail .last').show();
        /*Affichage de intensité*/
    }

}

function pad(n) {
    return n < 10 ? '0' + n : n
}

function getDateRefresh() {

    var now = new Date();
    var annee = now.getFullYear();
    var mois = (now.getMonth() + 1);
    var jour = now.getDate();
    var heure = now.getHours();
    var minute = now.getMinutes();
    var seconde = now.getSeconds();

    return pad(jour) + "/" + pad(mois) + "/" + annee + " " + pad(heure) + ":" + pad(minute) + ":" + pad(seconde);
}

function Gauge(data, init, isous) {


    power = isous * 230;
    if (init)
        data = data[0];


    if (timezonebis == null) {
        var timezonebis = "Europe/Brussels";
    }
    GaugeTrame = new Highcharts.Chart({
            chart: {
                renderTo: 'gauge',
                type: 'gauge',
                height: 200,
                time: {
                    timezone: timezonebis
                },
                plotBackgroundColor: '',
                plotBackgroundImage: '',
                plotBorderWidth: 0,
                plotShadow: false
            },

            title: {
                enabled: false,
                text: ''
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            pane: {
                startAngle: -150,
                endAngle: 150,
                background: [{
                    backgroundColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#FFF'],
                            [1, '#333']
                        ]
                    },
                    borderWidth: 0,
                    outerRadius: '109%'
                }, {
                    backgroundColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#333'],
                            [1, '#FFF']
                        ]
                    },
                    borderWidth: 0,
                    outerRadius: '107%'
                }, {
                    // default background
                }, {
                    backgroundColor: '#DDD',
                    borderWidth: 0,
                    outerRadius: '105%',
                    innerRadius: '103%'
                }]
            },

            // the value axis
            yAxis: {
                min: 0,
                max: power,
                minorTickInterval: 'auto',
                minorTickWidth: 1,
                minorTickLength: 10,
                minorTickPosition: 'inside',
                minorTickColor: '#000000',
                tickPixelInterval: 50,
                tickWidth: 2,
                tickPosition: 'inside',
                tickLength: 15,
                tickColor: '#000000',
                labels: {
                    step: 1,
                    //step: 1,
                    rotation: 'auto',
                    style: {
                        color: '#484343',
                        fontWeight: "bold"
                    }
                },
                title: {

                    text: 'Watt',
                    y: 90
                },
                plotBands: [{
                    from: 0,
                    to: (((power - 2000) / 3) * 1),
                    color: '#55BF3B' // green
                }, {
                    from: (((power - 2000) / 3) * 1),
                    to: (((power - 2000) / 3) * 2),
                    color: '#DDDF0D' // yellow
                }, {
                    from: (((power - 2000) / 3) * 2),
                    to: (power - 2000),
                    color: '#FF7F00' // yellow
                }, {
                    from: (power - 2000),
                    to: power,
                    color: '#FF0000' // red
                }]
            },

            series: [{
                name: 'Consommation totale',
                data: [parseInt(data.puissance_totale)],
                tooltip: {
                    valueSuffix: ' Watt'
                }
            }]
        },

        // Add some life
        function(chart) {
            if (!chart.renderer.forExport) {
                var timergauge = setInterval(function() {
                        if ($('#contentebar').length == 0) {
                            console.info('Suivi Conso - arret de la mise a jour du graphique jour.');
                            clearInterval(timergauge);
                        } else {
                            if (typeof chart.series === 'undefined') {
                                clearInterval(timergauge);
                                return;
                            }
                            var point = chart.series[0].points[0],
                                watt;
                            //MAJ graphiq trame actuelle
                            $.ajax({
                                type: 'POST',
                                global: false,
                                url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
                                data: {
                                    id_ecq: data.eqLogicID,
                                    action: "Trame_actuelle",
                                    yesterday: false,
                                    limit: '1'
                                },
                                dataType: 'json',
                                error: function(request, status, error) {
                                    handleAjaxError(request, status, error, $('#div_DashboardAlert'));
                                },
                                success: function(data_init) {
                                    if (data_init.state != 'ok') {
                                        $('#div_DashboardAlert').showAlert({ message: data_init.result, level: 'danger' });
                                        return;
                                    } else {
                                        //var data = data_init.result;
                                        watt = data_init.result.puissance_totale;

                                        /*msie a jour du  detail a coté de la gauge*/
                                        MAJ_menu(data_init.result, false);
                                        point.update(parseInt(watt)); /*Mise a jour de la gauge*/


                                        /*Mise a jour du graphique du jour*/
                                        series = ChartCurrentTrame.get('Total');

                                        //loadingDash(data.eqLogicID, "")
                                        var color_byHP = "#AA4643";
                                        var color_byHC = "#4572A7";

                                        var date = new Date(data_init.result.timestamp * 1000);

                                        if (date.getHours() == 0 & date.getMinutes() == 0 & series.points.length > 50) {
                                            loadingDash(data_init.result.eqLogicID, true)
                                            return
                                        }

                                        series.addPoint([data_init.result.timestamp * 1000, parseInt(data_init.result.puissance_totale)]);
                                        //création de nouvelles zones pour le maintient des bonnes couleurs lors de la mise à jour de données
                                        zones = series.zones
                                        dataZone = []

                                        zones.forEach((item, index) => {
                                            if (index < zones.length - 1) {
                                                dataZone.push({ value: item.value, color: item.color });
                                            }
                                        })
                                        if (data_init.result.ptec == "HP") {
                                            if (dataZone[dataZone.length - 1].color == color_byHP) {
                                                dataZone[dataZone.length - 1].value = data_init.result.timestamp * 1000
                                            } else {
                                                dataZone.push({ value: data_init.result.timestamp * 1000, color: color_byHP });
                                            }
                                        }
                                        if (data_init.result.ptec == "HC") {
                                            if (dataZone[dataZone.length - 1].color == color_byHC) {
                                                dataZone[dataZone.length - 1].value = data_init.result.timestamp * 1000
                                            } else {
                                                dataZone.push({ value: data_init.result.timestamp * 1000, color: color_byHC });
                                            }
                                        }
                                        series.update({
                                            zones: dataZone
                                        });
                                        series = ChartCurrentTrame.get('circuit1');
                                        series.addPoint([data_init.result.timestamp * 1000, parseInt(data_init.result.puissance_circuit1)]);
                                        series = ChartCurrentTrame.get('circuit2');
                                        series.addPoint([data_init.result.timestamp * 1000, parseInt(data_init.result.puissance_circuit2)]);
                                        series = ChartCurrentTrame.get('circuit3');
                                        series.addPoint([data_init.result.timestamp * 1000, parseInt(data_init.result.puissance_circuit3)]);
                                        series = ChartCurrentTrame.get('circuit4');
                                        series.addPoint([data_init.result.timestamp * 1000, parseInt(data_init.result.puissance_circuit4)]);
                                        series = ChartCurrentTrame.get('circuit5');
                                        series.addPoint([data_init.result.timestamp * 1000, parseInt(data_init.result.puissance_circuit5)]);



                                        /*Mise a jour du graphique du jour Température*/

                                        series_temp = ChartCurrentTrame.get('Température');
                                        //console.log(data_init.result.temperature)
                                        series_temp.addPoint([data_init.result.timestamp * 1000, parseFloat(data_init.result.temperature)]);

                                        /*Mise a jour de la date de la derniere trame teleinfo dans panel_outil*/
                                        $('#trame_date').html(data_init.result.date);
                                        $('.date_isrefresh').html(data_init.result.date);
                                        $.ajax({
                                            type: 'POST',
                                            url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
                                            data: {
                                                action: 'loadingPie',
                                                id_ecq: data_init.result.eqLogicID,
                                                type: "jour",
                                            },
                                            global: false,
                                            // dataType: 'json',
                                            error: function(request, status, error) {
                                                handleAjaxError(request, status, error, $('#div_DashboardAlert'));
                                            },
                                            success: function(data) {
                                                if (data.state != 'ok') {
                                                    $('#div_DashboardAlert').showAlert({ message: data.result, level: 'danger' });
                                                } else {
                                                    series = pieStatDAY.get('StatDAY');
                                                    if (series.points[0].percentage.toFixed(2) != data.result.data[0].toFixed(2) || series.points[1].percentage.toFixed(2) != data.result.data[1].toFixed(2)) {
                                                        series.points[0].tooltip_data = data.result.tooltip_data[0]
                                                        series.points[1].tooltip_data = data.result.tooltip_data[1]
                                                        series.points[0].update(data.result.data[0])
                                                        series.points[1].update(data.result.data[1])
                                                            //MAJ tableau des données
                                                        Tableau_Conso()
                                                    }



                                                }
                                            }

                                        });

                                    }
                                }
                            });
                            //MAJ camemberts


                        }


                    },
                    60000);
                var point = chart.series[0].points[0],
                    watt;
                point.update(parseInt(watt));

            }

        });

}

function showCurrentTrame(datas) {
    var dataHier = [];

    var old_ptec = false;
    var puissance_totale = [];
    var puissance_circuit1 = [];
    var puissance_circuit2 = [];
    var puissance_circuit3 = [];
    var puissance_circuit4 = [];
    var puissance_circuit5 = [];
    var dataZone = [];
    var dataZone_circuit1 = [];
    var dataZone_circuit2 = [];
    var dataZone_circuit3 = [];
    var dataZone_circuit4 = [];
    var dataZone_circuit5 = [];
    var dataTemp = [];
    var point_start = 0;
    var color_byHP = "#AA4643";
    var color_byHC = "#4572A7";
    var last_color = false;
    var last_timestamp = false;
    var max_temp = 0;

    $.each(datas.trame_du_jour.reverse(), function(key, value) {

        puissance_totale.push([value.timestamp * 1000, parseInt(value.puissance_totale)]);
        puissance_circuit1.push([value.timestamp * 1000, parseInt(value.puissance_circuit1)]);
        puissance_circuit2.push([value.timestamp * 1000, parseInt(value.puissance_circuit2)]);
        puissance_circuit3.push([value.timestamp * 1000, parseInt(value.puissance_circuit3)]);
        puissance_circuit4.push([value.timestamp * 1000, parseInt(value.puissance_circuit4)]);
        puissance_circuit5.push([value.timestamp * 1000, parseInt(value.puissance_circuit5)]);

        dataTemp.push([value.timestamp * 1000, (parseFloat(value.temperature) > 0 ? parseFloat(value.temperature) : null)]);

        if (parseFloat(value.temperature) > parseFloat(max_temp))
            max_temp = parseFloat(value.temperature);

        if (key == 0) {
            //dataZone.push({value: value.timestamp*1000, color: (value.ptec=="HP" ? color_byHP  : color_byHC)});
            point_start = value.timestamp * 1000;
        }
        /*Couleur Heure pleine*/

        if (value.ptec == "HC") {
            if (old_ptec != value.ptec) {
                dataZone.push({ value: value.timestamp * 1000, color: color_byHP });
                old_ptec = value.ptec;
            }
            /*Couleur Heure creuse*/
        } else {
            if (old_ptec != value.ptec) {
                dataZone.push({ value: value.timestamp * 1000, color: color_byHC });
                old_ptec = value.ptec;
            }
        }

        lastvalue = [value.timestamp * 1000, parseInt(value.puissance_totale)];
        last_timestamp = value.timestamp * 1000;

        if (value.ptec == "HP") {
            last_color = color_byHP
        } else {
            last_color = color_byHC
        }



    });

    dataZone.push({ value: last_timestamp, color: last_color });

    if (datas.trame_hier.length > 0)
        $.each(datas.trame_hier.reverse(), function(key, value) {
            var d = new Date(value.timestamp * 1000);
            var d2 = d.setDate(d.getDate() + 1); // -1 Jour
            dataHier.push([d2, parseInt(value.puissance_totale)]);
        });

    //if(parseInt(instmax)==0)
    //	instmax = null;

    if (timezonebis == null) {
        var timezonebis = "Europe/Brussels";
    }

    ChartCurrentTrame = new Highcharts.StockChart({
        chart: {
            renderTo: 'Currentbar',
            time: {
                timezone: timezonebis,
                useUTC: false
            },
            height: 300,
            ignoreHiddenSeries: true

        },

        legend: {
            enabled: true,
            itemStyle: {
                font: 'Trebuchet MS, Verdana, sans-serif',
                color: "#333333"
            },
            itemHoverStyle: {
                color: "#000"
            },
            itemHiddenStyle: {
                color: "#CCC"
            }
        },
        navigator: {
            enabled: true,
            maskInside: 2
        },
        //      tooltip: {
        //        valueSuffix: 'W',
        //        valueDecimals: 0
        //    },
        rangeSelector: {
            enabled: false,
            buttons: [{
                count: 1,
                type: 'minute',
                text: '1M'
            }, {
                count: 5,
                type: 'minute',
                text: '5M'
            }, {
                type: 'all',
                text: 'All'
            }],
            inputEnabled: true,
            selected: 0
        },
        credits: {
            enabled: false
        },
        scrollbar: {
            enabled: true
        },
        title: {
            enabled: false
        },
        time: {
            timezone: 'Europe/Berlin',
            useUTC: false
        },
        xAxis: {
            type: 'datetime',
            className: 'colorlabelxaxis'
        },
        yAxis: [{ // Primary yAxis
                max: max_temp,
                valueDecimals: 0,
                labels: {
                    align: 'left',
                    format: '{value} °C',
                    style: {
                        color: '#006635',
                        font: 'bold 13px Verdana, sans-serif'
                    }
                },
                title: {
                    text: '',
                    style: {
                        color: '#006635',
                        font: 'normal 13px Verdana, sans-serif'
                    }
                },
                opposite: true
            },
            {

                // Secondary yAxis
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }],
                title: {
                    text: 'Puissance (Watt)',
                    style: {
                        color: '#808080',
                        font: 'normal 13px Verdana, sans-serif'
                    }
                },
                labels: {
                    align: 'left',
                    // format: '{value} Watt',
                    style: {
                        color: '#808080',
                        font: 'normal 13px Verdana, sans-serif'
                    }
                }

            }
        ],
        exporting: {
            enabled: false
        },
        series: [{
                type: 'areaspline',
                name: 'Total',
                data: puissance_totale,
                //visible: ((tarif_type == "HCHP") ? true : false ),
                visible: true,
                id: 'Total',
                pointStart: point_start,
                pointIntervalUnit: 'month',
                tooltip: {
                    valueSuffix: ' W',
                    valueDecimals: 0
                },
                zoneAxis: 'x',
                zones: dataZone,
                yAxis: 1
            },
            {
                type: 'areaspline',
                name: datas.nom_circuit1,
                data: puissance_circuit1,
                //visible: ((tarif_type == "HCHP") ? true : false ),
                visible: false,
                id: 'circuit1',
                color: "#D7FF82",
                pointStart: point_start,
                pointIntervalUnit: 'month',
                tooltip: {
                    valueSuffix: ' W',
                    valueDecimals: 0,
                },
                zoneAxis: 'x',
                zones: dataZone_circuit1,
                yAxis: 1
            }, {
                type: 'areaspline',
                name: datas.nom_circuit2,
                data: puissance_circuit2,
                //visible: ((tarif_type == "HCHP") ? true : false ),
                visible: false,
                id: 'circuit2',
                color: "#FCC646",
                pointStart: point_start,
                pointIntervalUnit: 'month',
                tooltip: {
                    valueSuffix: ' W',
                    valueDecimals: 0
                },
                zoneAxis: 'x',
                zones: dataZone_circuit2,
                yAxis: 1
            }, {
                type: 'areaspline',
                name: datas.nom_circuit3,
                data: puissance_circuit3,
                //visible: ((tarif_type == "HCHP") ? true : false ),
                visible: false,
                id: 'circuit3',
                color: "#E62EF7",
                pointStart: point_start,
                pointIntervalUnit: 'month',
                tooltip: {
                    valueSuffix: ' W',
                    valueDecimals: 0
                },
                zoneAxis: 'x',
                zones: dataZone_circuit3,
                yAxis: 1
            }, {
                type: 'areaspline',
                name: datas.nom_circuit4,
                data: puissance_circuit4,
                //visible: ((tarif_type == "HCHP") ? true : false ),
                visible: false,
                id: 'circuit4',
                color: "#007DFF",
                pointStart: point_start,
                pointIntervalUnit: 'month',
                tooltip: {
                    valueSuffix: ' W',
                    valueDecimals: 0
                },
                zoneAxis: 'x',
                zones: dataZone_circuit4,
                yAxis: 1
            }, {
                type: 'areaspline',
                name: datas.nom_circuit5,
                data: puissance_circuit5,
                //visible: ((tarif_type == "HCHP") ? true : false ),
                visible: false,
                id: 'circuit5',
                color: "#E8FBFF",
                pointStart: point_start,
                pointIntervalUnit: 'month',
                tooltip: {
                    valueSuffix: ' W',
                    valueDecimals: 0
                },
                zoneAxis: 'x',
                zones: dataZone_circuit5,
                yAxis: 1
            },

            {
                type: 'spline',
                name: 'Hier',
                id: 'Hier',
                tooltip: {
                    valueSuffix: ' W',
                    valueDecimals: 0
                },
                data: dataHier,
                color: "#f7a35c",
                visible: false,
                yAxis: 1
            },
            {
                type: 'spline',
                name: 'Température',
                id: 'Température',
                data: dataTemp,
                dashStyle: 'dash',
                color: '#04db28',
                tooltip: {
                    valueSuffix: ' °C',
                    valueDecimals: 2,
                },
                visible: true,
                yAxis: 0
            }
        ]
    });

}

function showDashGraph() {


    var debug = false;
    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        data: {
            action: 'get_date_actuelle',
            id_ecq: $('#Eco_legrand_ecq').val()
        },
        dataType: 'json',
        global: false,
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_DashboardAlert'));
        },
        success: function(datares) {
            if (datares.state != 'ok') {
                $('#div_DashboardAlert').showAlert({ message: datares.result, level: 'danger' });

            } else {
                $.ajax({
                    type: 'POST',
                    url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
                    data: {
                        action: "Graphique",
                        id_ecq: $('#Eco_legrand_ecq').val(),
                        debut: datares.result.day.debut,
                        fin: datares.result.day.fin,
                        libelle: 'Consommation de la semaine par jours',
                        graph_type: "jours"
                    },
                    global: false,
                    dataType: 'json',
                    error: function(request, status, error) {
                        handleAjaxError(request, status, error, $('#div_DashboardAlert'));
                    },
                    success: function(data) {

                        if (data.state != 'ok') {
                            $('#div_DashboardAlert').showAlert({ message: data.result, level: 'danger' });

                        } else {

                            new Highcharts.Chart(show_graph(data.result, 'Day'));
                            new Highcharts.Chart(show_graph_temp(data.result, 'TempDay'));
                            new Highcharts.Chart(show_graph(data.result, 'DayEuro'));

                        }
                    }
                });


                $.ajax({
                    type: 'POST',
                    url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
                    data: {
                        action: "Graphique",
                        id_ecq: $('#Eco_legrand_ecq').val(),
                        debut: datares.result.week.debut,
                        fin: datares.result.week.fin,
                        old: true,
                        libelle: 'Consommation du mois par semaine',
                        graph_type: "semaines",
                    },
                    global: false,
                    dataType: 'json',
                    error: function(request, status, error) {
                        handleAjaxError(request, status, error, $('#div_DashboardAlert'));
                    },
                    success: function(data) {
                        if (data.state != 'ok') {
                            $('#div_DashboardAlert').showAlert({ message: data.result, level: 'danger' });

                        } else {
                            new Highcharts.Chart(show_graph(data.result, 'Month'));
                            new Highcharts.Chart(show_graph_temp(data.result, 'TempMonth'));
                            new Highcharts.Chart(show_graph(data.result, 'MonthEuro'));
                        }
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
                    data: {
                        action: "Graphique",
                        id_ecq: $('#Eco_legrand_ecq').val(),
                        debut: datares.result.year.debut,
                        fin: datares.result.month.fin,
                        old: true,
                        libelle: 'Consommation par mois sur 1 an',
                        graph_type: "mois",
                    },
                    global: false,
                    dataType: 'json',
                    error: function(request, status, error) {
                        handleAjaxError(request, status, error, $('#div_DashboardAlert'));
                    },
                    success: function(data) {
                        if (data.state != 'ok') {
                            $('#div_DashboardAlert').showAlert({ message: data.result, level: 'danger' });

                        } else {

                            new Highcharts.Chart(show_graph(data.result, 'Year'));
                            /*Graphique year conso*/
                            new Highcharts.Chart(show_graph_temp(data.result, 'TempYear'));
                            /*Graphique year température*/

                            new Highcharts.Chart(show_graph(data.result, 'YearEuro'));

                        }
                    }
                });



                $.ajax({
                    type: 'POST',
                    url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
                    data: {
                        id_ecq: $('#Eco_legrand_ecq').val(),
                        action: "Graphique",
                        debut: '2000-01-01', //datares.result.year.debut_graph,
                        fin: datares.result.month.fin,
                        old: true,
                        libelle: 'Consommation par année',
                        graph_type: "year",

                    },
                    global: false,
                    dataType: 'json',
                    error: function(request, status, error) {
                        handleAjaxError(request, status, error, $('#div_DashboardAlert'));
                    },
                    success: function(data) {
                        if (data.state != 'ok') {
                            $('#div_DashboardAlert').showAlert({ message: data.result, level: 'danger' });

                        } else {

                            new Highcharts.Chart(show_graph(data.result, 'pluri'));
                            /*Graphique year conso*/
                            new Highcharts.Chart(show_graph_temp(data.result, 'pluriTemp'));
                            /*Graphique year température*/

                            new Highcharts.Chart(show_graph(data.result, 'pluriEuro'));

                        }
                    }
                });
            }
        }
    });


}

function loadingPie(id_equipement) {

    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        data: {
            action: 'loadingPie',
            id_ecq: id_equipement
        },
        global: true,
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_DashboardAlert'));
        },
        success: function(data) {

            if (data.state != 'ok') {
                $('#div_DashboardAlert').showAlert({ message: data.result, level: 'danger' });
            } else {

                if (timezonebis == null) {
                    var timezonebis = "Europe/Brussels";
                }

                var tooltip = {
                    useHTML: true,
                    share: true,
                    formatter: function() {
                        var html_detail = '<b>' + this.key + ' :</b> ' + this.y.toFixed(2) + '%';
                        html_detail += '<br><b> ' + this.point.tooltip_data
                        return html_detail;
                    }
                }
                var chart = {
                    type: "pie",
                    renderTo: "",
                    time: {
                        timezone: timezonebis,
                        useUTC: false
                    },

                    ignoreHiddenSeries: true

                }

                var plotOptions = {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                textOutline: false,
                                color: "var (--txt - color) !important" // (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                }
                chart.renderTo = StatDAY

                var ser = [{
                        name: 'Consommation',
                        id: chart.renderTo.id,
                        data: get_categories(data.result.jour),
                        visible: true,
                        size: '80%',
                        dataLabels: {
                            enabled: false,
                            formatter: function() {
                                return this.y > 1 ? '<b>' + this.point.name + ':</b> ' + this.y + '%' : null;
                            }
                        }
                    },
                    {
                        name: 'Consommation par tores',
                        /*desactive le tooltips*/
                        data: get_categories(data.result.jour_tores),
                        visible: true,
                        size: '80%',
                        innerSize: '70%',
                        dataLabels: {
                            enabled: false,
                            formatter: function() {
                                // display only if larger than 1
                                return this.y > 1 ? '<b>' + this.point.name + ':</b> ' + this.y + '%' : null;
                            }
                        }
                    }
                ]
                if (data.result.jour) {
                    pieStatDAY = new Highcharts.Chart({
                        chart: chart,
                        title: {
                            text: ''
                        },

                        credits: {
                            enabled: false
                        },
                        plotOptions: plotOptions,
                        tooltip: tooltip,
                        series: ser

                    })
                }

                if (data.result.hier) {

                    chart.renderTo = StatYESTERDAY
                    ser[0].data = get_categories(data.result.hier)
                    ser[1].data = get_categories(data.result.hier_tores)
                    pieStatYESTERDAY = new Highcharts.Chart({
                        chart: chart,
                        title: {
                            text: ''
                        },

                        credits: {
                            enabled: false
                        },
                        plotOptions: plotOptions,
                        tooltip: tooltip,
                        series: ser

                    })
                }
                if (data.result.semaine) {
                    chart.renderTo = StatWEEK

                    ser[0].data = get_categories(data.result.semaine)
                    ser[1].data = get_categories(data.result.semaine)
                    ser[1].visible = false
                    pieStatWEEK = new Highcharts.Chart({
                        chart: chart,
                        title: {
                            text: ''
                        },

                        credits: {
                            enabled: false
                        },
                        plotOptions: plotOptions,
                        tooltip: tooltip,
                        series: ser

                    })
                }
                if (data.result.mois) {
                    chart.renderTo = Stat

                    ser[0].data = get_categories(data.result.mois)
                    ser[1].data = get_categories(data.result.mois)
                    ser[1].visible = false
                    pieStatMonth = new Highcharts.Chart({
                        chart: chart,
                        title: {
                            text: ''
                        },

                        credits: {
                            enabled: false
                        },
                        plotOptions: plotOptions,
                        tooltip: tooltip,
                        series: ser

                    })
                }
                if (data.result.annee) {
                    chart.renderTo = StatYEAR

                    ser[0].data = get_categories(data.result.annee)
                    ser[1].data = get_categories(data.result.annee)
                    ser[1].visible = false
                    pieStatYEAR = new Highcharts.Chart({
                        chart: chart,
                        title: {
                            text: ''
                        },

                        credits: {
                            enabled: false
                        },
                        plotOptions: plotOptions,
                        tooltip: tooltip,
                        series: ser

                    })
                }

            }
        }

    });
    return true;
}

function get_categories(data) {
    categorieData = [];
    $(data.data).each(function(index, value) {
        brightness = 0.2 - (index / data.length) / 5;
        categorieData.push({
            name: data.categorie[index],
            y: Math.round(value * 100) / 100,
            tooltip_data: data.tooltip_data[index],
            color: {
                linearGradient: { x1: 0, x2: 0, y1: 0, y2: 1 },
                stops: [
                    [0, data.color[index]],
                    [1, data.color[index]]
                ]
            }
        });
    });

    return (categorieData)
}

function traduction_mois(item) {

    Object.keys(item).forEach(function(col) {
        item[col] = item[col].replace(/january/i, 'Janvier');
        item[col] = item[col].replace(/february/i, 'Février');
        item[col] = item[col].replace(/march/i, 'Mars');
        item[col] = item[col].replace(/april/i, 'Avril');
        item[col] = item[col].replace(/may/i, 'Mai');
        item[col] = item[col].replace(/june/i, 'Juin');
        item[col] = item[col].replace(/july/i, 'Juillet');
        item[col] = item[col].replace(/august/i, 'Août');
        item[col] = item[col].replace(/september/i, 'Septembre');
        item[col] = item[col].replace(/october/i, 'Octobre');
        item[col] = item[col].replace(/november/i, 'Novembre');
        item[col] = item[col].replace(/december/i, 'Décembre');
        item[col] = item[col].replace(/janvier/i, 'Janvier');
        item[col] = item[col].replace(/février/i, 'Février');
        item[col] = item[col].replace(/mars/i, 'Mars');
        item[col] = item[col].replace(/avril/i, 'Avril');
        item[col] = item[col].replace(/mai/i, 'Mai');
        item[col] = item[col].replace(/juin/i, 'Juin');
        item[col] = item[col].replace(/juillet/i, 'Juillet');
        item[col] = item[col].replace(/août/i, 'Août');
        item[col] = item[col].replace(/septembre/i, 'Septembre');
        item[col] = item[col].replace(/octobre/i, 'Octobre');
        item[col] = item[col].replace(/novembre/i, 'Novembre');
        item[col] = item[col].replace(/décembre/i, 'Décembre');
    })


    return item
}


function refreshSynthese(type) {
    loadingDash($('#Eco_legrand_ecq').val(), false);

    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        dataType: 'json',
        data: {
            action: 'synthese',
            id_ecq: $('#Eco_legrand_ecq').val(),
            type: type
        },
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_TableAlert'));
        },
        success: function(data) {
            if (data.state != 'ok') {
                $('#div_TableAlert').showAlert({ message: data.result, level: 'danger' });
                return;
            }
            $("#tableau_synthese tr").remove();
            var tableau = '';
            var widget = '';
            var num_colonne = 0;
            var all = false
            if (type == 'all') {
                all = true;
                type = 'jours';
            }
            var tb
            while (all) {
                var tb = ''
                tb = '<table id="tableau_synthese_' + type + '" class = "table-striped table table-bordered table-hover" > ';
                tb += '<thead>';
                tb += '<tr class="widget-header">';
                tb += '<th style="display:none">Nom</th>';
                tb += '<th>Année</th>';
                if (type == 'jours') {
                    tableau = "#tableau_synthese_jours"
                    widget = ".synthese_jours"
                    tb += '<th>Jour</th>';
                    num_colonne = 2
                } else if (type == 'semaine') {
                    tableau = "#tableau_synthese_semaine"
                    widget = ".synthese_semaine"
                    tb += '<th>Semaine</th>';
                    num_colonne = 1
                } else if (type == 'mois') {
                    tableau = "#tableau_synthese_mois"
                    widget = ".synthese_mois"
                    tb += '<th>Mois</th>';
                    num_colonne = 1
                } else if (type == 'annee') {
                    tableau = "#tableau_synthese_annee"
                    widget = ".synthese_annee"
                    tb += '<th style="display:none">Année</th>';
                    num_colonne = 2
                }
                tb += '<th>Conso HP</th>';
                tb += '<th>Conso HC</th>';
                tb += '<th>Prix HP</th>';
                tb += '<th>Prix HC</th>';
                tb += '<th>Total HC (TTC/HT)</th>';
                tb += '<th>Total HC (TTC/HT)</th>';
                tb += '<th>Total (TTC/HT)</th>';
                tb += '<th>Temp min</th>';
                tb += '<th>Temp max</th>';
                tb += '<th>Temp moy</th>';
                tb += '</tr>';
                tb += '</thead>';
                tb += '<tbody class="tableau_synthese">';
                tb += '</tbody>';
                tb += '</table>';
                $(tableau).remove();
                $(tableau + '_wrapper').remove();
                $(widget).append(tb);


                //$(tableau + " tbody").children().remove()

                data.result.data[type].forEach(function(item) {

                    item = traduction_mois(item)


                    var tr = '<tr>'
                    tr += '<td style="display:' + $(tableau + " thead th")[0].style["display"] + '" > '

                    tr += item['EqlogicID'];
                    tr += '</td >'
                    tr += '<td style="display:' + $(tableau + " thead th")[1].style["display"] + '" > '
                    tr += item['annee'];
                    tr += '</td>'
                    tr += '<td style="display:' + $(tableau + " thead th")[2].style["display"] + '" > '
                    tr += item['categorie'];
                    tr += '</td>'

                    tr += '<td style="display:' + $(tableau + " thead th")[3].style["display"] + '" > '
                    tr += item['hp'] + ' Kwh'
                    tr += '</td>'
                    tr += '<td style="display:' + $(tableau + " thead th")[4].style["display"] + '" > '
                    tr += item['hc'] + ' Kwh'
                    tr += '</td>'
                    tr += '<td style="display:' + $(tableau + " thead th")[5].style["display"] + '" > '
                    tr += item['prix_hp'] + ' €'
                    tr += '</td>'
                    tr += '<td style="display:' + $(tableau + " thead th")[6].style["display"] + '" > '
                    tr += item['prix_hc'] + '€'
                    tr += '</td>'
                    tr += '<td style="display:' + $(tableau + " thead th")[7].style["display"] + '" > '
                    tr += item['total_prix_hp'] + '€' + ' / ' + item['total_prix_hp_ttc'] + '€'
                    tr += '</td>'
                    tr += '<td style="display:' + $(tableau + " thead th")[8].style["display"] + '" > '
                    tr += item['total_prix_hc'] + '€' + ' / ' + item['total_prix_hc_ttc'] + '€'

                    tr += '</td>'
                    tr += '<td style="display:' + $(tableau + " thead th")[9].style["display"] + '" > '

                    tr += item['total_prix'] + '€' + ' / ' + item['total_prix_ttc'] + '€'
                    tr += '</td>'
                    tr += '<td style="display:' + $(tableau + " thead th")[10].style["display"] + '" > '
                    tr += item['temp_min'] + '°C'
                    tr += '</td>'
                    tr += '<td style="display:' + $(tableau + " thead th")[11].style["display"] + '" > '
                    tr += item['temp_moy'] + '°C'
                    tr += '</td>'

                    tr += '<td style="display:' + $(tableau + " thead th")[12].style["display"] + '" > '
                    tr += item['temp_max'] + '°C'
                    tr += '</td>'
                    tr += '</tr>'

                    $(tableau + " tbody").append(tr);

                });

                set_datatable(tableau, num_colonne);
                if (type == 'jours') {
                    type = 'mois'
                } else if (type == 'mois') {
                    type = 'semaine'
                } else if (type == 'semaine') {
                    type = 'annee'
                } else if (type == 'annee') {
                    all = false;
                    return;
                }




            }
        }
    });


}

function set_datatable(element, numero_colonne_sort) {
    if (!$.fn.dataTable.isDataTable(element)) {
        var nb2 = $(element).DataTable({

            language: { url: 'plugins/Eco_legrand/3rdparty/datatable/fr_FR.json' },
            dom: 'T<"clear">lfrtip',
            //"columnDefs": [ { "visible": false, "targets": 0 }
            //],
            "pageLength": 10,

            fnDrawCallback: function(settings) {
                $(".tr_hidden").css("display", "table-row")
            },
            "order": [numero_colonne_sort, 'desc']

        });
    }
}


/*
Tarifs
 */
function PopupPrix(id_prix, type) {
    var prix = '';
    if (typeof id_prix !== 'undefined') {
        prix = '&id_prix=' + id_prix;
    } else {
        $('#bsIsPrwater_type').removeClass("btn-success");
        $('#bsIsPrgaz_type').removeClass("btn-success");
        $('#bsIsPrelec_type').addClass("btn-success");
        $('input[data-l1key="type"]').val('électricité');
        $('input[data-l1key="type"]').val('électricité');
    }
    if (type.includes('électricité')) {
        type = "électricité"
    } else if (type.includes('gaz')) {
        type = "gaz"
    } else if (type.includes('eau')) {
        type = "eau"
    }


    $('#md_GestionPrix').dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        width: 610,
        title: "{{Administration du tarif " +
            type.toUpperCase() + "}}"
    });
    $('#md_GestionPrix').load('index.php?v=d&plugin=Eco_legrand&modal=ajoutprix' + prix + '&eqlogic_id=' + $('#Eco_legrand_ecq').val() + '&type=' + type);
    $('#md_GestionPrix').dialog('open');
}
$('.ajout_prix').on('click', function() {
    PopupPrix('', $(this)[0].className);
})
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
    $(this).removeClass("ajout_prix");
    PopupPrix(Prix.id, $(this)[0].className);
    $(this).addClass("ajout_prix")
});



function refreshPrix() {
    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        data: {
            action: 'Récup_Prix',
            id: $('#Eco_legrand_ecq').val(),

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
                if (data.result[i]['type'] == "électricité") {
                    var tr_elec = '<tr  class="li_prix bt_sortable" data-prix_id="' + data.result[i]['id'] + '">'
                    tr_elec += '<td>'
                    tr_elec += '<div class="btn btn-success btn-sm updprix électricité">'
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
                    tr_gaz += '<div class="btn btn-success btn-sm updprix gaz">'
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
                    tr_eau += '<div class="btn btn-success btn-sm updprix eau">'
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