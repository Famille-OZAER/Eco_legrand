hideall();
verifParam();


$(".mainnav li.bt_dashboard").addClass('active');

var ecq = $('#Eco_legrand_ecq').val();
var datesynchro = $('#datesynchro').val();

loadingDash(ecq, datesynchro);

$('#conso_dashboard').show();

$('#Eco_legrand_ecq').on('change', function() {
    var ecq = $(this).val();
    $(".mainnav li.active").click();
    loadingDash(ecq); // chargement du dashboard
});
$('.datetimepicker').datepicker({ 'format': 'yyyy-m-d', 'autoclose': true }).datepicker("setDate", "0");

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

$('.back').hide();
/*clique pour basculer sur le graph temperature*/
$('.icon_flip, .icon_return').click(function() {
    $(this).parents('.card').find('.front').slideToggle();
    $(this).parents('.card').find('.back').slideToggle();

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
$('.changeType button').click(function() {
    var serie_selected = 'CurrentSerie';
    series = ChartCurrentTrame.get(serie_selected);
    for (i = 0; i < ChartCurrentTrame.series.length; i++) {
        if (ChartCurrentTrame.series[i].name == "Aujourd'hui") {
            series = ChartCurrentTrame.series[i];
        }
    }
    series.update({ data: series.options.data, type: (series.type == 'column' ? "areaspline" : "column") });
});

$('#validedatecurrent').click(function() {
    if (($('#current_debut').val() != '' && $('#current_fin').val() != '') && (($('#current_debut').val() < $('#current_fin').val()) || ($('#current_debut').val() == $('#current_fin').val()))) {
        var ecq = $('#Eco_legrand_ecq').val();

        $.ajax({
            type: 'POST',
            url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
            global: true,
            data: {
                id_ecq: ecq,
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
                        console.log(data.result)
                        showCurrentTrame(data.result.trame_du_jour, data.result.trame_hier, data.result.max_current_trame, data.result.min_current_trame,
                            data.result.type_abo, data.result.isous);
                    } else {
                        console.debug('Aucune valeur du jour trouvée');
                    }
                }
            }
        });
    }
});

function hideall() {

    $('#Eco_legrand_dashboard').hide();
    //$('#Eco_legrand_tab').hide();
    $('#cEco_legrand_outil').hide();
    //$('#Eco_legrand_graph').hide();
    //$('#Eco_legrand_graph_cat').hide();
    $('#Eco_legrand').hide();
    //$('#Eco_legrand_table').hide();
    $('.mainnav li').removeClass('active');
    $('.btn-group').hide();
}

$('.bt_graph_cat').on('click', function() {
    hideall();
    var ecq = $('#Eco_legrand_ecq').val();
    refreshGraphCat(ecq);
    //showGraph();
    $('.bt_graph_cat').addClass('active');
    $('#Eco_legrand_graph_cat').show();

});

$('.bt_temperature').on('click', function() {
    hideall();
    getDateMysql();
    showTemperature();
    $('.bt_temperature').addClass('active');
    $('#cEco_legrand_temperature').show();
});

$('.bt_graph').on('click', function() {
    hideall();
    refreshGraph();
    $('.bt_graph').addClass('active');
    $('#Eco_legrand_graph').show();
});

$('.bt_tab').on('click', function() {
    hideall();
    showTab();
    $('.bt_tab').addClass('active');
    $('#Eco_legrand_tab').show();
});

$('.bt_dashboard').on('click', function() {
    hideall();
    var ecq = $('#Eco_legrand_ecq').val();
    loadingPie(ecq); // chargement des statistiques
    loadingDash(ecq); // chargement du dashboard
    $('.bt_dashboard').addClass('active');
    $('#Eco_legrand_dashboard').show();
    $(window).resize();

});



$('.bt_backup').on('click', function() {
    hideall();
    $('.bt_backup').addClass('active');
    $('#Eco_legrand_backup').show();
});

$('.bt_outil').on('click', function() {
    hideall();
    getDateMysql();
    $('.bt_outil').addClass('active');
    $('#Eco_legrand_outil').show();
});



$('.bt_Eco_legrand').on('click', function() {
    hideall();
    $('.bt_Eco_legrand').addClass('active');
    $('#Eco_legrand').show();
});

$('.bt_synthese').on('click', function() {

    hideall();
    refreshSynthese();
    $('.bt_synthese').addClass('active');
    $('#Eco_legrand_synthese').show();
});

$('.bt_table').on('click', function() {
    hideall();
    $('.bt_table').addClass('active');
    $('#Eco_legrand_table').show();
    showTeleinfo();

});

$('.bt_correcteur').on('click', function() {
    hideall();
    $('.bt_correcteur').addClass('active');
    $('#Eco_legrand_correcteur').show();
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



/*
 * Génération d un graphique  pour la temeprature min, max et moyenne
 * */
function show_graph_temp(data, conteneur, legend) {

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
                    if ($('#' + legend).length) {
                        $('#' + legend).html(data.subtitle);
                    }

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

function show_graph(data, conteneur, legend, mystyle) {

    var type_ecq = data.type_ecq;
    var HC_name = data.HC_name;
    var HP_name = data.HP_name;

    if (data.affichage == 0 || data.affichage == "0") { /*Affichage des KWH*/

        var HP_data = data.HP_data;
        var HC_data = data.HC_data;

        var HP_data_old = data.HP_data_old;
        var HC_data_old = data.HC_data_old;


        var title_text = ' kWh';
        var title_text2 = '';
        var tooltip_text = ' ';
        var tooltip_text2 = 'kWh';

    } else { /*Affichage des prix */
        if (conteneur == 'YearTaxe') {
            var HP_data = data.HP_data_prix_ttc;
            var HC_data = data.HC_data_prix_ttc;
            var HC_name = data.HC_name + ' TTC';
            var HP_name = data.HP_name + ' TTC';

        } else {
            var HP_data = data.HP_data_prix;
            var HC_data = data.HC_data_prix;
        }

        var HP_data_old = data.HP_data_old_prix;
        var HC_data_old = data.HC_data_old_prix;

        var title_text = Devise;
        var title_text2 = Devise;
        var tooltip_text = Devise;
        var tooltip_text2 = Devise;
    }


    if (timezonebis == null) {
        var timezonebis = "Europe/Brussels";
    }
    //console.log(timezonebis + "| Bibligrap : " + conteneur);
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
                    if ($('#' + legend).length) {
                        $('#' + legend).html(data.subtitle);
                    }




                    /*-------------------------------------------------*/
                    /*------------------TAXE----------------------*/
                    /*-------------------------------------------------*/
                    if (conteneur == 'YearTaxe') {

                        this.addSeries({
                            name: data.fixe_name,
                            data: data.total_fixe,
                            stack: 'current',
                            index: 90,
                            id: 'serie_fixe',
                            color: '#7F7F7F',
                            dataLabels: {
                                enabled: true,
                                color: "var(--txt-color)",
                                y: 0,
                                formatter: function() {
                                    return parseFloat(this.y) + Devise;
                                },
                                style: {
                                    textOutline: false,
                                    textShadow: false,
                                    fontSize: '8px !important',
                                    font: 'normal 13px Verdana, sans-serif'
                                }
                            },
                            type: data.HP_type_graph,
                            showInLegend: true

                        });

                        this.addSeries({
                            name: data.inte_name,
                            data: data.total_inte,
                            stack: 'current',
                            color: '#333333',
                            index: 80,
                            id: 'serie_inte',
                            dataLabels: {
                                enabled: true,
                                color: "var(--txt-color)",
                                y: 0,
                                formatter: function() {
                                    return parseFloat(this.y) + Devise;
                                },
                                style: {
                                    textOutline: false,
                                    fontSize: '8px !important',
                                    font: 'normal 13px Verdana, sans-serif'
                                }
                            },
                            type: data.HP_type_graph,
                            showInLegend: true
                        });
                    }


                    /*Année précédente HP*/
                    if (data.enabled_old) {
                        this.addSeries({
                            name: data.HP_name_old,
                            data: HP_data_old,
                            stack: 'old',
                            index: undefined,
                            id: 'serie_hp_old',
                            color: '#F18221',
                            dataLabels: {
                                enabled: (data.enabled_old === true ? false : false),
                                color: "var(--txt-color)",
                                y: 0,
                                formatter: function() {
                                    return parseFloat(this.y) + title_text2;
                                },
                                style: {
                                    textOutline: false,
                                    font: 'normal 10px Verdana, sans-serif'
                                }
                            },
                            type: (conteneur != 'YearTaxe' ? data.HP_type_graph_old : 'column'),
                            showInLegend: true
                        });



                        /*Année précédente HC*/
                        this.addSeries({
                            name: data.HC_name_old,
                            data: HC_data_old,
                            id: 'serie_hc_old',
                            stack: 'old',
                            visible: ((data.tarif_type == "HCHP" && (type_ecq == 'electricity' || type_ecq == 'electprod')) ? true : false),
                            index: undefined,
                            color: '#7CB5EC',
                            dataLabels: {
                                enabled: (data.enabled_old ? false : false),
                                color: "var(--txt-color)",
                                y: 0,
                                formatter: function() {
                                    return parseFloat(this.y) + title_text2;
                                },
                                style: {
                                    textOutline: false,
                                    font: 'normal 10px Verdana, sans-serif'
                                }
                            },
                            type: (conteneur != 'YearTaxe' ? data.HC_type_graph_old : 'column'),
                            showInLegend: ((data.tarif_type == "HCHP" && (type_ecq == 'electricity' || type_ecq == 'electprod')) ? true : false)
                        });
                    }


                }
            },
            defaultSeriesType: data.type_graph,
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
            //text : data.title
            text: ''
        },

        subtitle: {
            text: ''
                // ,
                //        align: 'center',
                //        y: 297
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

                var title = "HP";
                var display = '';
                if (data.tarif_type != "HCHP" || type_ecq == 'water' || type_ecq == 'oil' || type_ecq == 'gaz') {
                    title = 'HB';
                    display = 'displaynone';
                    if (type_ecq == 'water') {
                        title = 'Eau';
                    }
                    if (type_ecq == 'oil') {
                        title = 'Fioul';
                    }
                    if (type_ecq == 'gaz') {
                        title = 'Gaz';
                    }
                }

                //			console.debug(this.point);
                //			console.debug(data);

                var old = true;

                var prix_HP = data.HP_data_prix[this.point.index];
                var prix_HC = data.HC_data_prix[this.point.index];

                var prix_old_HP = data.HP_data_old_prix[this.point.index];
                var prix_old_HC = data.HC_data_old_prix[this.point.index];

                var fixe = Highcharts.numberFormat(data.total_fixe[this.point.index], 2);
                var inte = Highcharts.numberFormat(data.total_inte[this.point.index], 2);


                if (prix_old_HP == null && prix_old_HC == null)
                    old = false;


                var watt_HP = data.HP_data[this.point.index];
                var watt_HC = data.HC_data[this.point.index];
                var watt_old_HP = data.HP_data_old[this.point.index];
                var watt_old_HC = data.HC_data_old[this.point.index];
                var libelle_tooltip = this.x.replace(/<[^>]*>/g, " au ");

                var colorhp = '#AA4643';
                var colorhc = '#4572A7';

                var tooltipv2 = '<table class="tg">';
                tooltipv2 += '<tr><th class="tg-031e bold" colspan="7">' + libelle_tooltip + '</div>' + ' ' + this.series.name + '  ' + Highcharts.numberFormat(this.y, 2) + tooltip_text2 + '</th></tr>';
                tooltipv2 += '<tr><th class="tg-031e" rowspan="2"></th><th class="tg-031e bold tg-s6z2" ' + (data.tarif_type == "HCHP" && type_ecq != 'water' && type_ecq != 'oil' && type_ecq != 'gaz' ? 'colspan="3" ' : ' ') + ' >Année</th><th class="tg-031e tg-s6z2 bold" ' + (data.tarif_type == "HCHP" && type_ecq != 'water' && type_ecq != 'oil' && type_ecq != 'gaz' ? 'colspan="3" ' : ' ') + '>Année-1</th></tr>';
                tooltipv2 += '<tr>';
                tooltipv2 += '<td class="tg-s6z2 bold backredcolor">' + title + '</td><td class="' + display + ' tg-s6z2 bold backbluecolor">HC</td><td class="' + display + ' tg-s6z2 backgreycolor bold">TOTAL</td><td class="tg-s6z2 bold backredcolor">' + title + '</td><td class="' + display + ' tg-s6z2 bold backbluecolor">HC</td><td class="' + display + ' tg-s6z2 backgreycolor bold">TOTAL</td>';
                tooltipv2 += '</tr>';
                tooltipv2 += '<tr>';
                tooltipv2 += '<td class="bold tg-031e backgreycolor">Prix</td>';
                tooltipv2 += '<td class="tg-031e backredcolor">' + Highcharts.numberFormat(prix_HP, 2) + Devise + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backbluecolor">' + Highcharts.numberFormat(prix_HC, 2) + Devise + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backgreycolor bold">' + Highcharts.numberFormat((prix_HP + prix_HC), 2) + Devise + '</td>';
                tooltipv2 += '<td class="tg-031e backredcolor">' + Highcharts.numberFormat(prix_old_HP, 2) + Devise + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backbluecolor">' + Highcharts.numberFormat(prix_old_HC, 2) + Devise + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backgreycolor bold">' + Highcharts.numberFormat((prix_old_HP + prix_old_HC), 2) + Devise + '</td>';
                tooltipv2 += '</tr>';
                tooltipv2 += '<tr>';

                var diff_pxhp = Highcharts.numberFormat(prix_HP - prix_old_HP, 2) + Devise;
                var diff_pxhc = Highcharts.numberFormat(prix_HC - prix_old_HC, 2) + Devise;
                var diff_px = Highcharts.numberFormat(((prix_HP + prix_HC) - (prix_old_HP + prix_old_HC)), 2) + Devise;

                var old_diff_pxhp = Highcharts.numberFormat(prix_old_HP - prix_HP, 2) + Devise;
                var old_diff_pxhc = Highcharts.numberFormat(prix_old_HC - prix_HC, 2) + Devise;
                var old_diff_px = Highcharts.numberFormat(((prix_old_HP + prix_old_HC) - (prix_HP + prix_HC)), 2) + Devise;

                tooltipv2 += '<td class="bold tg-031e backgreycolor">Diff</td>';
                tooltipv2 += '<td class="tg-031e backredcolor">' + diff_pxhp + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backbluecolor">' + diff_pxhc + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backgreycolor bold">' + diff_px + '</td>';
                tooltipv2 += '<td class="tg-031e backredcolor">' + old_diff_pxhp + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backbluecolor">' + old_diff_pxhc + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backgreycolor bold">' + old_diff_px + '</td>';
                tooltipv2 += '</tr>';
                tooltipv2 += '<tr>';
                tooltipv2 += '<td class="bold tg-031e backgreycolor">Conso</td>';
                tooltipv2 += '<td class="tg-031e backredcolor">' + Highcharts.numberFormat((watt_HP), 2) + (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'kWh' : 'M3') + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backbluecolor">' + Highcharts.numberFormat((watt_HC), 2) + (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'kWh' : 'M3') + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backgreycolor bold">' + Highcharts.numberFormat((watt_HP + watt_HC), 2) + (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'kWh' : 'M3') + '</td>';
                tooltipv2 += '<td class="tg-031e backredcolor">' + Highcharts.numberFormat((watt_old_HP), 2) + (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'kWh' : 'M3') + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backbluecolor">' + Highcharts.numberFormat((watt_old_HC), 2) + (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'kWh' : 'M3') + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backgreycolor bold">' + Highcharts.numberFormat((watt_old_HP + watt_old_HC), 2) + (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'kWh' : 'M3') + '</td>';
                tooltipv2 += '</tr>';
                tooltipv2 += '<tr>';

                var diff_wthp = Highcharts.numberFormat(watt_HP - watt_old_HP, 2) + (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'kWh' : 'M3');
                var diff_wthc = Highcharts.numberFormat(watt_HC - watt_old_HC, 2) + (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'kWh' : 'M3');
                var diff_wt = Highcharts.numberFormat(((watt_HP + watt_HC) - (watt_old_HP + watt_old_HC)), 2) + (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'kWh' : 'M3');

                var old_diff_wthp = Highcharts.numberFormat(watt_old_HP - watt_HP, 2) + (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'kWh' : 'M3');
                var old_diff_wthc = Highcharts.numberFormat(watt_old_HC - watt_HC, 2) + (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'kWh' : 'M3');
                var old_diff_wt = Highcharts.numberFormat(((watt_old_HP + watt_old_HC) - (watt_HP + watt_HC)), 2) + (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'kWh' : 'M3');

                tooltipv2 += '<td class="bold tg-031e backgreycolor">Diff</td>';
                tooltipv2 += '<td class="tg-031e backredcolor">' + diff_wthp + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backbluecolor">' + diff_wthc + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backgreycolor bold">' + diff_wt + '</td>';
                tooltipv2 += '<td class="tg-031e backredcolor">' + old_diff_wthp + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backbluecolor ">' + old_diff_wthc + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backgreycolor bold">' + old_diff_wt + '</td>';
                tooltipv2 += '</tr>';
                tooltipv2 += '<tr>';
                tooltipv2 += '<td class="bold tg-031e backgreycolor">Abonnement</td>';
                tooltipv2 += '<td class="tg-031e backgreycolor bold" ' + (data.tarif_type == "HCHP" && type_ecq != 'water' && type_ecq != 'oil' && type_ecq != 'gaz' ? 'colspan="2" ' : ' ') + ' >' + Devise + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backgreycolor bold">' + Highcharts.numberFormat((prix_HP + prix_HC), 2) + Devise + '</td>';
                tooltipv2 += '<td class="tg-031e backgreycolor bold" ' + (data.tarif_type == "HCHP" && type_ecq != 'water' && type_ecq != 'oil' && type_ecq != 'gaz' ? 'colspan="2" ' : ' ') + ' >' + Devise + '</td>';
                tooltipv2 += '<td class="' + display + ' tg-031e backgreycolor bold">' + Highcharts.numberFormat((prix_old_HP + prix_old_HC), 2) + Devise + '</td>';
                tooltipv2 += ' </tr>';
                if (data.tarif_type != "HCHP" || type_ecq == 'water' || type_ecq == 'oil' || type_ecq == 'gaz') {
                    tooltipv2 += '<tr>';
                    tooltipv2 += '<td class="bold tg-031e backgreycolor ">Total</td>';
                    tooltipv2 += '<td class="bold tg-031e backgreycolor" >' + Highcharts.numberFormat((prix_HP), 2) + Devise + '</td>';
                    tooltipv2 += '<td class="bold tg-031e backgreycolor" >' + Highcharts.numberFormat((prix_old_HP), 2) + Devise + '</td>';
                    tooltipv2 += ' </tr>';
                }


                tooltipv2 += '</table>';

                if (conteneur == 'YearTaxe' || old == false) {
                    return '<span style="color:' + this.series.color + '">' + this.series.name + '</span>: <b>' + this.y + tooltip_text2 + '</b><br/>';
                } else {
                    return tooltipv2;

                }

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
                color: ((type_ecq == "electricity" || type_ecq == "electprod") ? '#AA4643' : ((type_ecq == "gaz") ? '#ead61c' : ((type_ecq == "oil") ? '#9d622b' : '#4572A7'))),
                stack: 'current',
                index: 60,
                dataLabels: {
                    enabled: ((data.tarif_type == "HCHP" || (data.tarif_type != "HCHP" && (type_ecq == "electricity" || type_ecq == "electprod"))) ? true : false),
                    color: (!data.enabled_old || conteneur == 'YearTaxe' || (type_ecq != "electricity" && type_ecq != "electprod") || data.tarif_type != "HCHP" ? "var(--txt-color)" : '#AA4643'),
                    shadow: false,
                    rotation: (!data.enabled_old || conteneur == 'YearTaxe' || (type_ecq != "electricity" && type_ecq != "electprod") || data.tarif_type != "HCHP" ? 0 : -90),
                    y: (!data.enabled_old || conteneur == 'YearTaxe' || (type_ecq != "electricity" && type_ecq != "electprod") || data.tarif_type != "HCHP" ? 0 : -25),
                    formatter: function() {
                        return parseFloat(this.y) + title_text2;
                    },
                    style: {
                        //textOutline: false,
                        fontSize: (type_ecq == "electricity" || type_ecq == "electprod" ? '8px !important' : '10px !important'),
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
                visible: ((data.tarif_type == "HCHP" && (type_ecq == "electricity" || type_ecq == "electprod")) ? true : false),
                index: 50,
                stack: 'current',
                color: '#4572A7',
                dataLabels: {
                    enabled: true,
                    color: (!data.enabled_old || conteneur == 'YearTaxe' || type_ecq != "electricity" || type_ecq != "electprod" ? "var(--txt-color)" : '#4572A7'),
                    //rotation: -90,
                    //align: 'right',
                    rotation: (!data.enabled_old || conteneur == 'YearTaxe' ? 0 : -90),
                    y: (!data.enabled_old || conteneur == 'YearTaxe' ? 0 : -25),
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

function loadingDash(id_equipement, datesynchro) {


    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        global: true,
        data: {
            id_ecq: id_equipement,
            action: 'loadingDash',
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
                    //console.log(data.result)
                    initDashBoard(data.result.trame_du_jour, data.result.trame_hier, data.result.isous, data.result.max_current_trame, data.result.min_current_trame, datesynchro);
                } else {
                    console.info('Aucune valeur du jour trouvée verifier les équipements');
                }
            }
        }
    });
    return true;
}

function initDashBoard(trame_du_jour, trame_hier, isous, max, min, datesynchro) {

    deferred = $.Deferred();
    /*Affichage tablo conso PUIS Affichage Graphique Jours Semaine Mois*/
    TabConso()

    showDashGraph()






    /*affichage données detail dans le menu*/
    Tabdetail(trame_du_jour, true);

    /*la puissance_totale n est pas renseigné */

    if (parseInt(trame_du_jour[trame_du_jour.length - 1].puissance_totale) < 0) {
        $('#tab_info').hide();
        $('#gauge').hide();
        $('#Currentbar').hide();

        var txt = 'Pour visualiser la gauge merci de renseigner la Puissance instantanée dans la configuration de votre équipement';
        $('#tab_list').append('Pour visualiser la gauge merci de renseigner la Puissance instantanée dans la configuration de votre équipement');
        $('#contentegauge').append('Pour visualiser les variations merci de renseigner la Puissance instantanée dans la configuration de votre équipement');
        $('#contentebar').append('Pour visualiser le graphique merci de renseigner la Puissance instantanée dans la configuration de votre équipement');
    }

    /*Affichage tableau variations*/
    TabVariation(trame_du_jour, true);

    /*Affichage de la gauge*/

    Gauge(trame_du_jour, true, isous);

    $('.datesynchro').html(datesynchro);


    $('.navinfo').show();
    $('#widgetgauge').show();
    $('#Temp7jBox').show();
    $('#Temp4sBox').show();
    $('#Temp12mBox').show();
    $('#TempaBox').show();
    $('.bt_tab').show();

    /*Affichage du graph du jour*/
    showCurrentTrame(trame_du_jour, trame_hier, max, min);


    /*Affichage Graphique Jours Semaine Mois */
    //showDashGraph(style);

    $(window).resize();

    return true;
}

function TabConso() {

    console.log('Chargement du tableau Conso.');
    //console.log($('#Eco_legrand_ecq').val());
    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        global: true,
        data: {
            id_ecq: $('#Eco_legrand_ecq').val(),
            action: 'TabConso'
        },
        dataType: 'json',

        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_DashboardAlert'));
        },
        success: function(data) {

            //console.log(data);

            if (data.state != 'ok') {
                $('#div_DashboardAlert').showAlert({ message: data.result, level: 'danger' });
                return;
            } else {

                var unity = ' kWh';
                var title_tb2 = 'Watt';



                //$('#title_tb2').text(title_tb2);

                Devise = ' €'
                if (data.result.day_conso !== false) {
                    /****************/
                    /*JOUR Euro*/
                    /****************/
                    $('#day_hp').html(data.result.day_conso.total_hp_ttc + Devise);
                    $('#day_hc').html(data.result.day_conso.total_hc_ttc + Devise);
                    var day_total = data.result.day_conso.total_ttc;
                    $('#day_total').html(day_total.toFixed(2) + Devise);

                    /****************/
                    /*JOUR Watt*/
                    /****************/
                    var day_totalw = (data.result.day_conso.hp + data.result.day_conso.hc);


                    $('#day_hpw').html(data.result.day_conso.hp.toFixed(2) + unity);
                    $('#day_hcw').html(data.result.day_conso.hc.toFixed(2) + unity);
                    $('#day_totalw').text(day_totalw.toFixed(2) + unity);

                } else {
                    $('#day_hp').html('Indispo.');
                    $('#day_hc').html('Indispo.');
                    $('#day_total').html('Indispo.');
                    $('#day_hpw').html('Indispo.');
                    $('#day_hcw').html('Indispo.');
                    $('#day_totalw').html('Indispo.');
                }

                if (data.result.yesterday_conso !== false) {
                    /****************/
                    /*HIER Euro*/
                    /****************/
                    $('#yesterday_hp').html(data.result.yesterday_conso.total_hp_ttc + Devise);
                    $('#yesterday_hc').html(data.result.yesterday_conso.total_hc_ttc + Devise);
                    var yesterday_total = data.result.yesterday_conso.total_ttc;
                    $('#yesterday_total').html(yesterday_total.toFixed(2) + Devise);

                    /****************/
                    /*HIER Watt*/
                    /****************/
                    var yesterday_totalw = (data.result.yesterday_conso.hp + data.result.yesterday_conso.hc);

                    $('#yesterday_hpw').html(data.result.yesterday_conso.hp + unity);
                    $('#yesterday_hcw').html(data.result.yesterday_conso.hc + unity);
                    $('#yesterday_totalw').text(yesterday_totalw.toFixed(2) + unity);


                } else {
                    $('#yesterday_hp').html('Indispo.');
                    $('#yesterday_hc').html('Indispo.');
                    $('#yesterday_total').html('Indispo.');
                    $('#yesterday_hpw').html('Indispo.');
                    $('#yesterday_hcw').html('Indispo.');
                    $('#yesterday_totalw').html('Indispo.');
                }

                if (data.result.week_conso !== false) {
                    /****************/
                    /*SEMAINE Euro*/
                    /****************/
                    $('#week_hp').html(data.result.week_conso.total_hp_ttc + Devise);
                    $('#week_hc').html(data.result.week_conso.total_hc_ttc + Devise);
                    var week_total = data.result.week_conso.total_ttc;
                    $('#week_total').html(week_total.toFixed(2) + Devise);

                    /****************/
                    /*SEMAINE Watt*/
                    /****************/
                    var week_totalw = (data.result.week_conso.hp + data.result.week_conso.hc);

                    $('#week_hpw').html(data.result.week_conso.hp + unity);
                    $('#week_hcw').html(data.result.week_conso.hc + unity);
                    $('#week_totalw').text(week_totalw.toFixed(2) + unity);

                } else {
                    $('#week_hp').html('Indispo.');
                    $('#week_hc').html('Indispo.');
                    $('#week_total').html('Indispo.');
                    $('#week_hpw').html('Indispo.');
                    $('#week_hcw').html('Indispo.');
                    $('#week_totalw').html('Indispo.');
                }
                if (data.result.month_conso !== false) {
                    /****************/
                    /*MOIS Euro*/
                    /****************/
                    $('#month_hp').html(data.result.month_conso.total_hp_ttc + Devise);
                    $('#month_hc').html(data.result.month_conso.total_hc_ttc + Devise);
                    var month_total = data.result.month_conso.total_ttc;
                    $('#month_total').html(month_total.toFixed(2) + Devise);

                    /****************/
                    /*MOIS Watt*/
                    /****************/
                    var month_totalw = (data.result.month_conso.hp + data.result.month_conso.hc);

                    $('#month_hpw').html(data.result.month_conso.hp + unity);
                    $('#month_hcw').html(data.result.month_conso.hc + unity);
                    $('#month_totalw').text(month_totalw.toFixed(2) + unity);

                } else {
                    $('#month_hp').html('Indispo.');
                    $('#month_hc').html('Indispo.');
                    $('#month_total').html('Indispo.');
                    $('#month_hpw').html('Indispo.');
                    $('#month_hcw').html('Indispo.');
                    $('#month_totalw').html('Indispo.');
                }
                if (data.result.year_conso !== false) {
                    /****************/
                    /*ANNEE Euro*/
                    /****************/
                    $('#year_hp').html(data.result.year_conso.total_hp_ttc + Devise);
                    $('#year_hc').html(data.result.year_conso.total_hc_ttc + Devise);
                    var year_total = data.result.year_conso.total_ttc;
                    $('#year_total').html(year_total.toFixed(2) + Devise);
                    /****************/
                    /*ANNEE Watt*/
                    /****************/
                    var year_totalw = (data.result.year_conso.hp + data.result.year_conso.hc);

                    $('#year_hpw').html(data.result.year_conso.hp.toFixed(2) + unity);
                    $('#year_hcw').html(data.result.year_conso.hc.toFixed(2) + unity);
                    $('#year_totalw').text(year_totalw.toFixed(2) + unity);


                    $('.datefact').attr('title', data.result.title);
                    $('.datefactyearold').attr('title', data.result.titleold);


                } else {
                    $('#year_hp').html('Indispo.');
                    $('#year_hc').html('Indispo.');
                    $('#year_total').html('Indispo.');
                    $('#year_hpw').html('Indispo.');
                    $('#year_hcw').html('Indispo.');
                    $('#year_totalw').html('Indispo.');
                }

                $('.tts').html('HP TTC');
                $('.tts2').html('HP');
                var refreshdate = getDateRefresh();
                $('.date_refresh').html(refreshdate);

            }
            deferred.resolve();
        }
    });
    return deferred.promise();
}

function Tabdetail(data, init) {

    console.info('Chargement des informations menu.');

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

function TabVariation(data, init) {
    console.info('Chargement du tableau des variations.');
    var diff = 0;
    var image = '<i class="icon-hand-down"></i>';

    if (init) {
        var DataElement = data;
        //console.debug(DataElement);
        var old_val = '-';
        var old_heure = '';
        var old_ptec = '';
        $("#tab_info").html('');
        $("#tab_info").append('<input type="hidden" value="" name="old_watt_input" id="old_watt_input">');
        $.each(DataElement, function(key, value) {
            diff = 0;
            if (old_val != '-') {
                diff = parseInt(old_val) - parseInt(value.puissance_totale);
                if (parseInt(diff) > 0) { //positif
                    diff = '+' + diff + ' W';
                    image = '<i class="icon-hand-up"></i>';
                } else if (diff == 0) {
                    image = "";
                    var diff = '';
                } else { //negatif
                    diff = diff + ' W';
                    image = '<i class="icon-hand-down"></i>';
                }
            } else {
                image = "";
                diff = '';
                $('#old_watt_input').val(parseInt(value.puissance_totale));
            }

            var nb = $('#tab_info tr').length;

            if (old_ptec == "HC")
                var tclass = ' class="bluecolor" ';
            else
                var tclass = ' class="redcolor" ';
            //console.debug(value.heure + ' '+ value.puissance_totale);
            if (nb <= 9 && diff != '' && diff != '-') { //Si pas de variation on n affiche rien
                $("#tab_info").append('<tr  ' + tclass + '><td ' + tclass + '>' + old_heure + '</td><td ' + tclass + ' >' + parseInt(old_val) + ' W' + '</td><td  ' + tclass + '>' + image + '  ' + diff + '</td><td  ' + tclass + '>' + old_ptec + '</td></tr>');
            }

            //highlight
            old_val = value.puissance_totale;
            old_heure = value.heure;
            old_ptec = value.ptec;

        });
    } else {
        image = '<i class="icon-hand-down"></i>';
        diff = parseInt(data.puissance_totale) - parseInt($('#old_watt_input').val());

        if (parseInt(diff) > 0) {
            diff = '+' + diff + ' W';
            image = '<i class="icon-hand-up"></i>';
        } else if (diff == 0) {
            image = "-";
            diff = '-';
        } else {
            diff = diff + ' W';
            image = '<i class="icon-hand-down"></i>';
        }

        var nb = $('#tab_info tr').length;
        if (nb > 9 && diff != '' && diff != '-') {
            $('#tab_info tr').last().remove();
        }

        if (data.ptec == "HC")
            var tclass = ' class="bluecolor" ';
        else
            var tclass = ' class="redcolor" ';
        if (diff != '' && diff != '-') {
            $("#tab_info").prepend('<tr><td ' + tclass + '>' + data.heure + '</td><td  ' + tclass + '>' + data.puissance_totale + ' W' + '</td><td ' + tclass + '>' + image + '  ' + diff + '</td><td  ' + tclass + ' >' + data.ptec + '</td></tr>');
        }
        $('#old_watt_input').val(parseInt(data.puissance_totale));
    }

    var refreshdate = getDateRefresh();
    $('.date_isrefresh').html(refreshdate);
}

function Gauge(data, init, isous) {


    console.log('Chargement de la gauge.');
    power = isous * 230;


    if (init)
        data = data[0];


    if (timezonebis == null) {
        var timezonebis = "Europe/Brussels";
    }
    //console.log(timezonebis + "| Gauge");
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
                    valueSuffix: 'Watt'
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
                            console.info('cette gauge n\'existe plus on supprime.');
                            clearInterval(timergauge);
                            return;
                        }
                        var point = chart.series[0].points[0],
                            watt;
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
                                //console.debug(data);
                                if (data_init.state != 'ok') {
                                    $('#div_DashboardAlert').showAlert({ message: data_init.result, level: 'danger' });
                                    return;
                                } else {
                                    var data = data_init.result;
                                    watt = data.puissance_totale;

                                    /*msie a jour du  detail a coté de la gauge*/
                                    Tabdetail(data_init.result, false);
                                    console.info('Mise a jour de la gauge : ' + parseInt(watt));
                                    point.update(parseInt(watt)); /*Mise a jour de la gauge*/

                                    TabVariation(data_init.result, false); /*Mise a jour du tableau des conso*/

                                    /*Mise a jour de la courbe d hier*/
                                    //									var series_yesterday = CurrentTrame.get('Hier');
                                    //									series_yesterday.addPoint([data.timestamp*1000, parseInt(data.yesterday_papp)]);

                                    /*Mise a jour du graphique du jour*/
                                    var serie_selected = 'CurrentSerie';
                                    series = ChartCurrentTrame.get(serie_selected);
                                    series.addPoint([data.timestamp * 1000, parseInt(data.puissance_totale)]);

                                    /*Mise a jour du graphique du jour Température*/
                                    var serie_selected_temp = 'Temp';
                                    series_temp = ChartCurrentTrame.get(serie_selected_temp);
                                    series_temp.addPoint([data.timestamp * 1000, parseFloat(data.temperature)]);


                                    /*Mise a jour de la date de la derniere trame teleinfo dans panel_outil*/
                                    $('#trame_date').html(data.date);
                                    $('.date_isrefresh').html(data.date);


                                }
                            }
                        });
                    }


                }, refreshTime * 1000);
                var point = chart.series[0].points[0],
                    watt;
                point.update(parseInt(watt));

            }

        });

}

function showCurrentTrame(data_init, yesterday_trame, max, min) {
    //var debug = true;
    console.info('Chargement du graphique du jour.');



    //console.debug();
    var dataHier = [];
    var lastvalue = null;

    var old_ptec = false;
    var dataCurrent = [];
    var dataZone = [];
    var dataTemp = [];
    var point_start = 0;
    var color_byHP = "#AA4643";
    var color_byHC = "#4572A7";
    var last_color = false;
    var last_timestamp = false;
    var max_temp = 0;

    $.each(data_init.reverse(), function(key, value) {

        dataCurrent.push([value.timestamp * 1000, parseInt(value.puissance_totale)]);

        dataTemp.push([value.timestamp * 1000, (parseFloat(value.temperature) > 0 ? parseFloat(value.temperature) : null)]);

        if (parseFloat(value.temperature) > parseFloat(max_temp))
            max_temp = parseFloat(value.temperature);

        if (key == 0) {
            //dataZone.push({value: value.timestamp*1000, color: (value.ptec=="HP" ? color_byHP  : color_byHC)});
            point_start = value.timestamp * 1000;
        }
        /*Couleur Heure pleine*/
        /*ATTENTION INVERSE SI HC ALORS LES ROUGE SE TERMINE ICI */
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
        last_color = (value.ptec == "HP" ? color_byHP : color_byHC);


    });

    dataZone.push({ value: last_timestamp, color: last_color });

    if (yesterday_trame.length > 0)
        $.each(yesterday_trame.reverse(), function(key, value) {
            var d = new Date(value.timestamp * 1000);
            var d2 = d.setDate(d.getDate() + 1); // -1 Jour
            dataHier.push([d2, parseInt(value.puissance_totale)]);
        });

    //if(parseInt(instmax)==0)
    //	instmax = null;

    if (timezonebis == null) {
        var timezonebis = "Europe/Brussels";
    }
    //console.log(timezonebis + " CurrentBar");

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
                name: 'Aujourd\'hui',
                data: dataCurrent,
                //visible: ((tarif_type == "HCHP") ? true : false ),
                visible: true,
                id: 'CurrentSerie',
                //color: "#4572A7"
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
                id: 'Temp',
                data: dataTemp,
                dashStyle: 'dash',
                color: '#006635',
                tooltip: {
                    valueSuffix: ' °C',
                    valueDecimals: 2,
                },
                visible: false,
                yAxis: 0
            },
            {
                type: 'flags',
                name: 'Min',
                yAxis: 1,
                data: [{
                    x: min.timestamp * 1000,
                    title: 'Min ' + min.puissance_totale + ' Watt / ' + min.int_instant + ' A',
                    text: 'Puissance minimale (Watt)'
                }],
                onSeries: 'CurrentSerie',
                shape: 'squarepin',
                color: '#7CBA0B',
                fillColor: '#7CBA0B',
                style: { // text style
                    color: 'white'
                },

                states: {
                    hover: {
                        fillColor: '#7CBA0B',
                    }
                }
            },
            {
                type: 'flags',
                name: 'Max',
                yAxis: 1,
                data: [{
                    x: max.timestamp * 1000,
                    title: 'Max ' + max.puissance_totale + ' Watt / ' + max.int_instant + ' A',
                    text: 'Puissance Maximale atteinte'

                }],
                onSeries: 'CurrentSerie',
                shape: 'squarepin',
                color: '#EEAD51',
                fillColor: '#EEAD51',

                style: { // text style
                    fillColor: 'white'
                },

                states: {
                    hover: {
                        fillColor: '#EEAD51',
                    }
                }
            }
        ]
    });

}

function showDashGraph() {

    var ecq = $('#Eco_legrand_ecq').val();

    console.info('Chargement des graphiques stat.');
    var debug = false;
    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        data: {
            action: 'get_date_actuelle',
            id_ecq: ecq
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_DashboardAlert'));
        },
        success: function(datares) {
            //console.debug(datares);
            if (datares.state != 'ok') {
                $('#div_DashboardAlert').showAlert({ message: datares.result, level: 'danger' });

            } else {
                console.info('Hebdomadaire.');
                $.ajax({
                    type: 'POST',
                    url: 'plugins/Eco_legrand/core/ajax/graph.ajax.php?graphique=7jours',
                    data: {
                        id_ecq: ecq,
                        debut: datares.result.day.debut,
                        fin: datares.result.day.fin,
                        old: true,
                        libelle: 'Consommation de la semaine par jours',
                        graph_mode: 0, //0 Watt ou 1 prix
                        graph_type: "jours",
                        type_graphHP: 'column',
                        type_graphHC: 'column',
                        type_graphHP_OLD: 'spline',
                        type_graphHC_OLD: 'spline'
                    },
                    dataType: 'json',
                    error: function(request, status, error) {
                        handleAjaxError(request, status, error, $('#div_DashboardAlert'));
                    },
                    success: function(data) {

                        //console.debug(data);
                        if (data.state != 'ok') {
                            $('#div_DashboardAlert').showAlert({ message: data.result, level: 'danger' });

                        } else {

                            new Highcharts.Chart(show_graph(data.result, 'Day', 'none'));
                            /*data,id,id_legend*/
                            new Highcharts.Chart(show_graph_temp(data.result, 'TempDay', 'none'));
                            /*température*/


                            data.result.affichage = 1;
                            new Highcharts.Chart(show_graph(data.result, 'DayEuro', 'none'));
                            /*data,id,id_legend*/

                        }
                    }
                });
                //return;
                console.info('Mensuel.');
                $.ajax({
                    type: 'POST',
                    url: 'plugins/Eco_legrand/core/ajax/graph.ajax.php?graphique=4semaines',
                    data: {
                        id_ecq: ecq,
                        debut: datares.result.week.debut,
                        fin: datares.result.week.fin,
                        old: true,
                        libelle: 'Consommation du mois par semaine',
                        graph_mode: 0, //0 Watt ou 1 prix
                        graph_type: "semaines",
                        type_graphHP: 'column',
                        type_graphHC: 'column',
                        type_graphHP_OLD: 'spline',
                        type_graphHC_OLD: 'spline'
                    },
                    dataType: 'json',
                    error: function(request, status, error) {
                        handleAjaxError(request, status, error, $('#div_DashboardAlert'));
                    },
                    success: function(data) {
                        //console.debug(data);
                        if (data.state != 'ok') {
                            $('#div_DashboardAlert').showAlert({ message: data.result, level: 'danger' });

                        } else {
                            //console.debug(data.result);
                            new Highcharts.Chart(show_graph(data.result, 'Month', 'none'));
                            /*data,id,id_legend*/
                            new Highcharts.Chart(show_graph_temp(data.result, 'TempMonth', 'none'));
                            /*température*/

                            data.result.affichage = 1;
                            new Highcharts.Chart(show_graph(data.result, 'MonthEuro', 'none'));
                            /*data,id,id_legend*/
                        }
                    }
                });
                console.info('Annuel.');
                $.ajax({
                    type: 'POST',
                    url: 'plugins/Eco_legrand/core/ajax/graph.ajax.php?graphique=12Month',
                    data: {
                        id_ecq: ecq,
                        debut: datares.result.year.debut_graph,
                        fin: datares.result.month.fin,
                        old: true,
                        libelle: 'Consommation par mois sur 1 an',
                        graph_mode: 0, //0 Watt ou 1 prix
                        graph_type: "mois",
                        type_graphHP: 'column',
                        type_graphHC: 'column',
                        type_graphHP_OLD: 'spline',
                        type_graphHC_OLD: 'spline',
                    },
                    dataType: 'json',
                    error: function(request, status, error) {
                        handleAjaxError(request, status, error, $('#div_DashboardAlert'));
                    },
                    success: function(data) {
                        //console.debug(data);
                        if (data.state != 'ok') {
                            $('#div_DashboardAlert').showAlert({ message: data.result, level: 'danger' });

                        } else {

                            new Highcharts.Chart(show_graph(data.result, 'Year', 'none'));
                            /*Graphique year conso*/
                            new Highcharts.Chart(show_graph_temp(data.result, 'TempYear', 'none'));
                            /*Graphique year température*/


                            data.result.affichage = 1;
                            new Highcharts.Chart(show_graph(data.result, 'YearEuro', 'none'));
                            data.result.enabled_old = false;
                            new Highcharts.Chart(show_graph(data.result, 'YearTaxe', 'none'));

                        }
                    }
                });



                console.info('Pluriannuel.');
                $.ajax({
                    type: 'POST',
                    url: 'plugins/Eco_legrand/core/ajax/graph.ajax.php?graphique=pluriannuel',
                    data: {
                        id_ecq: ecq,
                        debut: '2000-01-01', //datares.result.year.debut_graph,
                        fin: datares.result.month.fin,
                        old: true,
                        libelle: 'Consommation par année',
                        graph_mode: 0, //0 Watt ou 1 prix
                        graph_type: "year",
                        type_graphHP: 'column',
                        type_graphHC: 'column',
                        type_graphHP_OLD: 'spline',
                        type_graphHC_OLD: 'spline',
                    },
                    dataType: 'json',
                    error: function(request, status, error) {
                        handleAjaxError(request, status, error, $('#div_DashboardAlert'));
                    },
                    success: function(data) {
                        //console.debug(data);
                        if (data.state != 'ok') {
                            $('#div_DashboardAlert').showAlert({ message: data.result, level: 'danger' });

                        } else {

                            new Highcharts.Chart(show_graph(data.result, 'pluri', 'none'));
                            /*Graphique year conso*/
                            new Highcharts.Chart(show_graph_temp(data.result, 'pluriTemp', 'none'));
                            /*Graphique year température*/

                            data.result.affichage = 1;
                            new Highcharts.Chart(show_graph(data.result, 'pluriEuro', 'none'));

                        }
                    }
                });
            }
        }
    });


}