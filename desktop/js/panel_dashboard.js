if (!ismobile) {

    $('.datetimepicker').datepicker({
        'format': 'yyyy-m-d',
        'autoclose': true
    }).datepicker("setDate", "0");

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


    /*jeedom.config.load({
        configuration: $('#param_prevision').getValues('.configKey')[0],
        plugin: 'conso',
        error: function(error) {
            $('#div_DashboardAlert').showAlert({ message: error.message, level: 'danger' });
        },
        success: function(data) {
            $('#param_prevision').setValues(data, '.configKey');
            modifyWithoutSave = false;
        }
    });*/

    /*Enregistrement previsions / objectifs*/
    /*$('.saveprevi').focusout(function() {
        //sauvegarde
        jeedom.config.save({
            configuration: $('#param_prevision').getValues('.configKey')[0],
            plugin: 'conso',
            error: function(error) {
                $('#div_DashboardAlert').showAlert({ message: error.message, level: 'danger' });
            },
            success: function() {
                jeedom.config.load({
                    configuration: $('#param_prevision').getValues('.configKey')[0],
                    plugin: 'conso',
                    error: function(error) {
                        $('#div_DashboardAlert').showAlert({ message: error.message, level: 'danger' });
                    },
                    success: function(data) {
                        $('#param_prevision').setValues(data, '.configKey');
                    }
                });
            }
        });
    });*/

    function showPrevision(data, datayear_old) {

        $('.TableauBox').hide(); /*Masque les 2 tableaux*/

        if (data.result.HC_data_old.length > 0 /*&& (data.result.type_ecq=='electricity' || data.result.type_ecq=='electprod')*/ ) {
            $('#Consobox').html(''); /*Vide le tableau Conso*/
            if (data.result.type_ecq == 'electricity' || data.result.type_ecq == 'electprod') {
                getPrevision('kWh', data, datayear_old.result.year.debut, data.result.type_ecq);
            } else getPrevision('m3', data, datayear_old.result.year.debut, data.result.type_ecq);
            $('#tableau_prix .icon_flip, #previewbox .icon_flip,#Consobox .icon_flip').show(); /*Affichage des pastilles*/
            $('#previsionbox').show(); /*Affiche les prevision*/
        } else {

            $('#Consobox').html($('#tableau_prix .back').html()); /*Insere la consommation dans le tableauBox*/
            $('#tableau_prix .icon_flip, #previewbox .icon_flip, #Consobox .icon_flip').hide(); /*Masque les pastilles*/
            $('#Consobox').show(); /*Affiche le tableauBox*/

        }

    }


}

function changeColorTheme(style) {
    if (style != 'cssdefault') { /*Affichage du theme dark*/
        //$('.highcharts-xaxis-labels text').removeAttr('style').addClass('xtitle_'+style);/* xAxis Categorie Label des graphiques */
        $('.highcharts-yaxis-title').removeAttr('style').removeClass().addClass('ytitle_' + style);
        /*yAxis Tire des graphiques*/
        $('.highcharts-xaxis-labels text').removeAttr('style').removeClass().addClass('axis_' + style);
        /*yAxis Tire des graphiques*/
        $('.highcharts-yaxis-labels text').removeAttr('style').removeClass().addClass('label_' + style);
        /*Titre carousel*/
        $('.carousel-caption').removeClass('defautcss').addClass('label_' + style);
        /*yAxis Label des graphiques*/
        $('#carousel-example-generic .highcharts-data-labels text').removeAttr('style').removeClass().addClass('info_' + style);
        /*yAxis Label des informations*/
        //$('.highcharts-legend-item text').removeAttr('style').addClass('legend_'+style); /*yAxis Label des informations*/
        //$('#YearTaxe text').removeAttr('style').removeClass().addClass('taxe_label_' + style);

        /*yAxis Label des informations*/
    }
}


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

function verifParam() {

    $.ajax({
        type: 'POST',
        url: 'plugins/conso/core/ajax/conso.ajax.php',
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

$('#validedatecurrent').click(function() {
    if (($('#current_debut').val() != '' && $('#current_fin').val() != '') && (($('#current_debut').val() < $('#current_fin').val()) || ($('#current_debut').val() == $('#current_fin').val()))) {
        var ecq = $('#conso_ecq').val();
        //console.debug('date selectionnée pour l equipement : ' + ecq);
        //alert('validedatecurrent' + ecq);
        $.ajax({
            type: 'POST',
            url: 'plugins/conso/core/ajax/conso.ajax.php',
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
                        showCurrentTrame(data.result.current_trame, data.result.yesterday_trame, data.result.max_current_trame, data.result.min_current_trame,
                            data.result.type_abo, data.result.type, data.result.abo_power);
                    } else {
                        console.debug('Aucune valeur du jour trouvée');
                    }
                }
            }
        });
    }
});

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

function getNbJoursMois(mois, annee) {
    var lgMois = ['31', '28', '31', '30', '31', '30', '31', '31', '30', '31', '30', '31'];

    if ((annee % 4 == 0 && annee % 100 != 0) || annee % 400 == 0) {
        lgMois[1] = '29';
    }
    return parseInt(lgMois[mois]); // 0 < mois <11
}

function getPrevision(unity, data, date, type_ecq) {

    //if (!active_prevision)
    //	return;

    /*recuperation de la date de fin de la periode choisie mettre le parametre date*/
    //actuellement prend la date du jour
    var x = 12; //or whatever offset
    var CurrentDate = new Date();

    /*Attention si janviers alors il faut rester sur la meme année*/
    var submonth = CurrentDate.getMonth() - 1;
    var _month = CurrentDate.getMonth();
    var _year = CurrentDate.getFullYear();
    var _year_start = CurrentDate.getFullYear() // periode année en cours;

    /*Gestion de janviers*/
    if (CurrentDate.getMonth() == 0) {
        submonth = 11;
        _month = 12;
        _year = CurrentDate.getFullYear();
        _year_start = _year;
    }


    var jour_sub = getNbJoursMois(submonth, CurrentDate.getFullYear());
    var date_debut = _year_start + '-01-01';
    var date_sub = new Date(CurrentDate.setMonth(CurrentDate.getMonth() - x));
    var date_fin = _year_start + '-' + ("0" + (date_sub.getMonth() + 1)).slice(-2) + '-' + getNbJoursMois(date_sub.getMonth(), _year_start);


    now = new Date();
    annee = now.getFullYear();
    mois = now.getMonth();
    Mymonth = (now.getMonth() + 1);
    jour = now.getDate();
    nb_jour = getNbJoursMois(mois, annee);
    //console.log(Mymonth+'---'+now.getMonth());
    /*recuperation des données de l année derniere de janviers a decembre*/
    $.ajax({
        type: 'POST',
        url: 'plugins/conso/core/ajax/graph.ajax.php?prevision',
        data: {
            id_ecq: $('#conso_ecq').val(),
            debut: date_debut,
            /*date onglet outils exemple 2015-09-01 */
            fin: date_fin,
            /*date  onglet outils exemple 2016-08-31 */
            old: true,
            libelle: '',
            graph_mode: 0, //0 Watt ou 1 prix
            graph_type: "mois",
            prevision: true,
            type_graphHP: 'column',
            type_graphHC: 'column',
            type_graphHP_OLD: 'spline',
            type_graphHC_OLD: 'spline'
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_DashboardAlert'));
        },
        success: function(data_res) {
            //console.debug(data);
            if (data_res.state != 'ok') {
                $('#div_DashboardAlert').showAlert({ message: data_res.result, level: 'danger' });

            } else {
                /*Chargement du tableau prevision Back*/
                tabPrevision = '';
                EurospreviHT = 0;
                EurosmontantHT = 0;
                economie = 0;
                previ_month = "";
                previ_year = 0;
                EurospreviHT_year = 0;
                EurosmontantHT_year = 0;
                economie_year = 0;
                consomme_year = 0;

                /*Vide les cases du tableau*/
                $('.previcasevalue').html('');
                $('.previcase').hide();

                /*Prevision du mois en cours*/
                if (type_ecq == 'gaz') {
                    EurospreviHT = data_res.result.MonthOld.total_hp; //Prevision du mois en Euros HT
                    EurosmontantHT = data.result.HP_data_prix[data.result.HP_data_prix.length - 1]; //Cout du mois en cours en Euros HT
                } else {
                    EurospreviHT = data_res.result.MonthOld.total_hc + data_res.result.MonthOld.total_hp; //Prevision du mois en Euros HT
                    EurosmontantHT = data.result.HC_data_prix[data.result.HC_data_prix.length - 1] + data.result.HP_data_prix[data.result.HP_data_prix.length - 1]; //Cout du mois en cours en Euros HT
                }
                economie = EurospreviHT - EurosmontantHT; //Prevision du mois en Euros HT
                previ_month = data_res.result.MonthOld.total; //Prevision du mois en Wh


                /*Boucle sur les données de l'année precendente a partir de la date de facture*/
                $.each(data_res.result.HP_data, function(key, value) {
                    /*Remplissage du tableau back prevision de l annee precedente*/
                    if (value !== null) {
                        $('#month_' + key).html(data_res.result.categories[key]); //remplissage des cases  libelles
                        if (type_ecq == 'gaz') {
                            tabPrevision = data_res.result.HP_data[key];
                        } else {
                            tabPrevision = data_res.result.HC_data[key] + data_res.result.HP_data[key];
                        }
                        $('#previ_annee_' + key).html(parseInt(tabPrevision)); //remplissage des cases année-1
                        $('#previ_annee_' + key + '_hp').html(' ( ' + parseInt(data_res.result.HP_data[key]) + ' / '); //remplissage des cases année-1 hp
                        $('#previ_annee_' + key + '_hc').html(parseInt(data_res.result.HC_data[key]) + ' )'); //remplissage des cases année-1 hc
                        $('.previcase_' + key).show();
                    }
                    if (data_res.result.num_annee[key] == annee) {
                        if (type_ecq == 'gaz') {
                            EurosmontantHT_year += data_res.result.HP_data_prix[key]; //Cout  a partir de la date de la facture en Euros HT
                            consomme_year += data_res.result.HP_data[key]; //Prevision de l'année en Wh
                        } else {
                            EurosmontantHT_year += data_res.result.HC_data_prix[key] + data_res.result.HP_data_prix[key]; //Cout  a partir de la date de la facture en Euros HT
                            consomme_year += data_res.result.HC_data[key] + data_res.result.HP_data[key]; //Prevision de l'année en Wh
                        }
                    }
                });
                /*Recuperation de l'année derniere*/
                //debugger;
                $.each(data_res.result.HP_data_old, function(ke, val) {
                    if (val !== null) {
                        previ_year += (data_res.result.HC_data_old[ke] + data_res.result.HP_data_old[ke]); //Consommation de l'année en cours
                        /*Cout sur l'année depuis la periode parametrée dans l'onglet outils*/
                        EurospreviHT_year += (data_res.result.HC_data_old_prix[ke] + data_res.result.HP_data_old_prix[ke]); //Prevision a partir de la date de la facture
                    }
                });

                $('#Eurosprevi').html(EurospreviHT.toFixed(2)); //affichage de prix previsionel
                $('#Eurosmontant').html(EurosmontantHT.toFixed(2)); //affichage de prix du mois
                $('#economie').html(economie.toFixed(2)); //economie du mois

                economie_year = EurospreviHT_year - EurosmontantHT_year; //Prevision  a partir de la date de la facture en Euros HT
                $('#Eurosprevi_year').html(EurospreviHT_year.toFixed(2)); //affichage de prix previsionel
                $('#Eurosmontant_year').html(EurosmontantHT_year.toFixed(2)); //affichage de prix du mois ( cout sur 1 an)
                $('#economie_year').html(economie_year.toFixed(2)); //economie du mois
                /************************/

                //var objectif = $('#previ_' + mois).value();
                var percentage = 0;
                var percentage_conso = 0;
                var percentage_year = 0;
                var percentage_conso_year = 0;
                var prevision = 0;
                var prevision_year = 0;
                var budget = 0;
                var budget_year = 0;
                var consomme = parseInt($('#month_totalw').html()); //Recuperation dans le tableau Watt
                //var consomme_year = parseInt($('#year_totalw').html());//Recuperation dans le tableau Watt
                var reste = 0;
                var reste_year = 0;

                /*Si objectif de renseigné alors il est prioritaire*/
                //if (objectif != "") {
                //	budget = parseInt(objectif)+unity;
                //	//prevision = ((parseInt(objectif) * nb_jour) / jour);
                //	percentage = (100 * parseInt(objectif) / prevision);
                //	reste = (parseInt(objectif) - consomme)+unity;
                //}
                ////Sinon si il y a une valeur de l année derniere
                //else
                if (previ_month != "") {
                    budget = parseInt(previ_month) + unity;
                    percentage_conso = 100 * (consomme / parseInt(previ_month));
                    percentage = 100 * (EurosmontantHT / EurospreviHT);
                    reste = (parseInt(parseInt(previ_month) - consomme)) + unity;

                    percentage_conso_year = 100 * (consomme_year / parseInt(previ_year));
                    percentage_year = 100 * (EurosmontantHT_year / EurospreviHT_year);
                    budget_year = parseInt(previ_year) + unity;
                    reste_year = (parseInt(parseInt(previ_year) - parseInt(consomme_year))) + unity;

                } //Sinon il faut afficher un message
                else {
                    budget = "à  configurer";
                    prevision = "à  configurer";
                    reste = "à  configurer";
                    prevision_year = "à  configurer";
                    reste_year = "à  configurer";
                }

                var img = getImgCharge(parseInt(percentage_conso), unity);
                var imgyear = getImgCharge(parseInt(percentage_conso_year), unity);

                /*Chargement des données */
                $('#consomme').text(consomme + unity);
                $('#consomme_year').text(parseInt(consomme_year) + unity);

                $('#budget').text(budget);
                $('#budget_year').text(budget_year);

                $('#reste').text(reste);
                $('#reste_year').text(reste_year);
                $('#percent_Montant').text(' (' + parseInt(percentage) + '%)');
                $('#percent_Montant_year').text(' (' + parseInt(percentage_year) + '%)');

                /*Chargement de l image Pile*/
                $('.img_charge').fadeOut(function() {
                    $('#imgcharge').attr('src', img);
                    $('#imgcharge_year').attr('src', imgyear);
                    $('#imgcharge').attr('title', percentage_conso.toFixed(2) + '%');
                    $('#imgcharge_year').attr('title', percentage_conso_year.toFixed(2) + '%');
                });

                $('.img_charge').fadeIn();

                /*Chargement des données d'estimation*/
            }
        }
    });
}

function getImgCharge(percent, unity) {


    var image = '';
    if (unity == 'm3') {
        if (percent <= 10)
            image = 'plugins/conso/desktop/css/theme/img/charge/energysgreen.png';
        else if (percent <= 25)
            image = 'plugins/conso/desktop/css/theme/img/charge/energysblues.png';
        else if (percent <= 60)
            image = 'plugins/conso/desktop/css/theme/img/charge/energysorange.png';
        else if (percent <= 85)
            image = 'plugins/conso/desktop/css/theme/img/charge/energysorange.png';
        else if (percent < 95)
            image = 'plugins/conso/desktop/css/theme/img/charge/energysred.png';
        else if (percent >= 100)
            image = 'plugins/conso/desktop/css/theme/img/charge/energyswarning.png';
        else
            image = 'plugins/conso/desktop/css/theme/img/charge/energysred.png';
    } else {

        if (percent <= 10)
            image = 'plugins/conso/desktop/css/theme/img/charge/charge_100.png';
        else if (percent <= 25)
            image = 'plugins/conso/desktop/css/theme/img/charge/charge_75.png';
        else if (percent <= 60)
            image = 'plugins/conso/desktop/css/theme/img/charge/charge_50_green.png';
        else if (percent <= 85)
            image = 'plugins/conso/desktop/css/theme/img/charge/charge_25.png';
        else if (percent < 95)
            image = 'plugins/conso/desktop/css/theme/img/charge/charge_10.png';
        else if (percent > 100)
            image = 'plugins/conso/desktop/css/theme/img/charge/charge_0_warning.png';
        else
            image = 'plugins/conso/desktop/css/theme/img/charge/charge.png';
    }
    return image;
}

function TabConso(type, showgraph) {

    console.debug('Chargement du tableau Conso.');
    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        global: true,
        data: {
            id_ecq: $('#conso_ecq').val(),
            action: 'TabConso'
        },
        dataType: 'json',
        complete: showgraph,
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

                if (type == "water" || type == "oil" || type == "gaz") {
                    unity = 'M3';
                    title_tb2 = 'Mètre cube';
                }

                //$('#title_tb2').text(title_tb2);


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
                    if (type == "water" || type == "oil") {
                        /*Si Eau affiche des M3 et des Litres*/
                        $('#day_hpw').html(data.result.day_conso.hp.toFixed(3) + unity + ' / ' + (data.result.day_conso.hp * 1000) + 'L');
                        //$('#day_hcw').html((data.result.day_conso.hc).toFixed(4) + unity + ' / ' + (data.result.day_conso.hc * 1000).toFixed(0) + 'L');
                        $('#day_totalw').text(day_totalw.toFixed(2) + unity + ' / ' + (day_totalw * 1000).toFixed(2) + 'L');
                    } else if (type == "gaz") {
                        $('#day_hpw').html(data.result.day_conso.hp.toFixed(3) + unity + ' / ' + data.result.day_conso.kwh + 'kWh');
                        //$('#day_hcw').html((data.result.day_conso.hc).toFixed(4) + unity + ' / ' + (data.result.day_conso.hc*1000) + 'L');
                        $('#day_totalw').text(day_totalw.toFixed(2) + unity + ' / ' + day_totalw.toFixed(2) + 'kWh');
                    } else {
                        $('#day_hpw').html(data.result.day_conso.hp.toFixed(2) + unity);
                        $('#day_hcw').html(data.result.day_conso.hc.toFixed(2) + unity);
                        $('#day_totalw').text(day_totalw.toFixed(2) + unity);
                    }
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
                    if (type == "water" || type == "oil") {
                        /*Si Eau affiche des M3 et des Litres*/
                        $('#yesterday_hpw').html(data.result.yesterday_conso.hp.toFixed(3) + unity + ' / ' + (data.result.yesterday_conso.hp * 1000) + 'L');
                        //$('#yesterday_hcw').html(data.result.yesterday_conso.hc.toFixed(4) + unity + ' / ' + (data.result.yesterday_conso.hc*1000) + 'L');
                        $('#yesterday_totalw').text(yesterday_totalw.toFixed(2) + unity + ' / ' + (yesterday_totalw * 1000).toFixed(4) + 'L');
                    } else if (type == "gaz") {
                        $('#yesterday_hpw').html(data.result.yesterday_conso.hp.toFixed(3) + unity + ' / ' + data.result.yesterday_conso.kwh + 'kWh');
                        data.result.yesterday_conso.kwh;
                        $('#yesterday_totalw').text(yesterday_totalw.toFixed(2) + unity + ' / ' + yesterday_totalw.toFixed(4) + 'kWh');
                    } else {
                        $('#yesterday_hpw').html(data.result.yesterday_conso.hp + unity);
                        $('#yesterday_hcw').html(data.result.yesterday_conso.hc + unity);
                        $('#yesterday_totalw').text(yesterday_totalw.toFixed(2) + unity);
                    }

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
                    if (type == "water" || type == "oil") {
                        /*Si Eau affiche des M3 et des Litres*/
                        $('#week_hpw').html(data.result.week_conso.hp.toFixed(3) + unity + ' / ' + (data.result.week_conso.hp * 1000) + 'L');
                        //$('#week_hcw').html(data.result.week_conso.hc + unity + ' / ' + (data.result.week_conso.hc * 1000) + 'L');
                        var week_total_Litre = (week_totalw * 1000);
                        $('#week_totalw').text(week_totalw.toFixed(2) + unity + ' / ' + week_total_Litre.toFixed(2) + 'L');
                    } else if (type == "gaz") {
                        /*Si Eau affiche des M3 et des Litres*/
                        $('#week_hpw').html(data.result.week_conso.hp.toFixed(3) + unity + ' / ' + data.result.week_conso.kwh + 'kWh');
                        var week_total_kWh = data.result.week_conso.kwh;
                        $('#week_totalw').text(week_totalw.toFixed(2) + unity + ' / ' + week_total_kWh.toFixed(2) + 'kWh');
                    } else {
                        $('#week_hpw').html(data.result.week_conso.hp + unity);
                        $('#week_hcw').html(data.result.week_conso.hc + unity);
                        $('#week_totalw').text(week_totalw.toFixed(2) + unity);
                    }
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
                    if (type == "water" || type == "oil") {
                        /*Si Eau affiche des M3 et des Litres*/
                        $('#month_hpw').html(data.result.month_conso.hp.toFixed(3) + unity + ' / ' + (data.result.month_conso.hp * 1000) + 'L');
                        //$('#month_hcw').html(data.result.month_conso.hc + unity + ' / ' + (data.result.month_conso.hc * 1000) + 'L');
                        var month_total_Litre = (month_totalw * 1000);
                        $('#month_totalw').text(month_totalw.toFixed(2) + unity + ' / ' + month_total_Litre.toFixed(2) + 'L');
                        $('#budget').text(month_totalw.toFixed(2) + unity + ' / ' + month_total_Litre.toFixed(2) + 'L');
                    } else if (type == "gaz") {
                        /*Si Eau affiche des M3 et des Litres*/
                        month_totalw = data.result.month_conso.hp;
                        $('#month_hpw').html(data.result.month_conso.hp.toFixed(3) + unity + ' / ' + data.result.month_conso.kwh + 'kWh');
                        var month_total_kwh = data.result.month_conso.kwh;
                        $('#month_totalw').text(month_totalw.toFixed(2) + unity + ' / ' + month_total_kwh.toFixed(2) + 'kWh');
                        $('#budget').text(month_totalw.toFixed(2) + unity + ' / ' + month_total_kwh.toFixed(2) + 'kWh');
                    } else {
                        $('#month_hpw').html(data.result.month_conso.hp + unity);
                        $('#month_hcw').html(data.result.month_conso.hc + unity);
                        $('#month_totalw').text(month_totalw.toFixed(2) + unity);
                    }
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
                    if (type == "water" || type == "oil") {
                        /*Si Eau affiche des M3 et des Litres*/
                        $('#year_hpw').html(data.result.year_conso.hp.toFixed(3) + unity + ' / ' + (data.result.year_conso.hp * 1000) + 'L');
                        //$('#year_hcw').html(data.result.year_conso.hc + unity + ' / ' + (data.result.year_conso.hc * 1000) + 'L');
                        var year_total_Litre = (year_totalw * 1000);
                        $('#year_totalw').text(year_totalw.toFixed(2) + unity + ' / ' + year_total_Litre.toFixed(2) + 'L');
                    } else if (type == "gaz") {
                        $('#year_hpw').html(data.result.year_conso.hp.toFixed(3) + unity + ' / ' + data.result.year_conso.kwh + 'kWh');
                        var year_total_kwh = data.result.year_conso.kwh;
                        $('#year_totalw').text(year_totalw.toFixed(2) + unity + ' / ' + year_total_kwh.toFixed(2) + 'kWh');
                    } else {
                        $('#year_hpw').html(data.result.year_conso.hp.toFixed(2) + unity);
                        $('#year_hcw').html(data.result.year_conso.hc.toFixed(2) + unity);
                        $('#year_totalw').text(year_totalw.toFixed(2) + unity);
                    }

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
                if (data.result.display)
                    $('.dds').show();
                else
                    $('.dds').hide();

                $('.tts').html(data.result.titletype + ' TTC');
                $('.tts2').html(data.result.titletype);
                var refreshdate = getDateRefresh();
                $('.date_refresh').html(refreshdate);

            }
            deferred.resolve();
        }
    });
    return deferred.promise();
}


function loadingPie(id_equipement) {
    $.ajax({
        type: 'POST',
        url: 'plugins/conso/core/ajax/conso.ajax.php?pi=day',
        data: {
            action: 'pi',
            id_ecq: id_equipement
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

                if (data.result.mois.havetotal == 0 || data.result.mois.retour == 'ko') {
                    $('#div_DashboardAlert').html('Impossible de charger les statistiques. Il vous faut 1 equipement de configuré comme Total. <br> La téléinformation est généralement un Total')
                } else {
                    if (data.result.mois.havetotal > 1) {
                        $('#div_DashboardAlert').html('Impossible de charger les statistiques.Vous avez plus de 2 equipements configurés comme TOTAL');
                    } else {
                        if (data.result.mois.nb_equipement > 1 && data.result.jour.nb_equipement > 1) {
                            if (data.result.jour.other != 'no') {
                                console.info('Chargement Camembert Jour');
                                constructPi(data.result.jour, 'StatDAY');
                            }
                            if (data.result.hier.other != 'no') {
                                console.info('Chargement Camembert Hier');
                                constructPi(data.result.hier, 'StatYESTERDAY');
                            }
                            if (data.result.semaine.other != 'no') {
                                console.info('Chargement Camembert Semaine');
                                constructPi(data.result.semaine, 'StatWEEK');
                            }
                            if (data.result.mois.other != 'no') {
                                console.info('Chargement Camembert Mois');
                                constructPi(data.result.mois, 'Stat');
                            }
                            if (data.result.annee.other != 'no') {
                                console.info('Chargement Camembert Année');
                                constructPi(data.result.annee, 'StatYEAR');
                            }
                            $('#statBox').show();
                            $('#currentBox').removeClass("col-lg-12").addClass("col-lg-8");
                        } else {
                            /*masque*/
                            $('#graph_par_categorie').hide();
                            $('#statBox').hide();
                            $('#currentBox').removeClass("col-lg-8").addClass("col-lg-12");
                        }
                    }
                }
            }
        }
    });
    return true;
}

function loadingDash(id_equipement, datesynchro, mobile, style) {

    //alert('loadindDash' + id_equipement);
    $.ajax({
        type: 'POST',
        url: 'plugins/conso/core/ajax/conso.ajax.php?id_equipement=' + id_equipement,
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
                if (data.result.nb_trame > 0)
                    initDashBoard(data.result.current_trame, data.result.yesterday_trame, data.result.abo_power, data.result.abo_power_perso, data.result.abo_power_perso_status, data.result.max_current_trame, data.result.min_current_trame, data.result.type_abo, data.result.type, datesynchro, mobile, style, data.result.nb_equipement);
                else {
                    console.info('Aucune valeur du jour trouvée verifier les équipements');
                }
            }
        }
    });
    return true;
}

function initDashBoard(current_trame, yesterday_trame, abo_power, abo_power_perso, abo_power_perso_status, max, min, tarif_type, type, datesynchro, mobile, style, nb_equipement) {

    //alert('initDashBoard' + nb_equipement);
    deferred = $.Deferred();
    /*Affichage tablo conso PUIS Affichage Graphique Jours Semaine Mois*/
    //alert('initDashBoard' + type);
    TabConso(type)
        //TabConso(type).then(function() {
        //   showDashGraph(style)
        //});
    return;

    /*Affichage tablo conso*/

    /*Affichage du graph du jour*/
    //showCurrentTrame(current_trame, yesterday_trame, max, min, tarif_type, type, abo_power, style);

    /*affichage données detail dans le menu*/
    Tabdetail(current_trame, true);

    /*Le papp n est pas renseigné */
    /*if (parseInt(current_trame[current_trame.length - 1].papp) < 0 && (type == 'electricity' || type == 'electprod')) {
        $('#tab_info').hide();
        $('#gauge').hide();
        $('#Currentbar').hide();

        var txt = 'Pour visualiser la gauge merci de renseigner la Puissance instantanée dans la configuration de votre équipement';
        $('#tab_list').append('Pour visualiser la gauge merci de renseigner la Puissance instantanée dans la configuration de votre équipement');
        $('#contentegauge').append('Pour visualiser les variations merci de renseigner la Puissance instantanée dans la configuration de votre équipement');
        $('#contentebar').append('Pour visualiser le graphique merci de renseigner la Puissance instantanée dans la configuration de votre équipement');
    }*/

    /*Affichage tableau variations*/
    TabVariation(current_trame, true, type, mobile);

    /*Affichage de la gauge*/
    abo_power_max = (Math.ceil(max.papp / 1000));
    if (abo_power_max == 0) {
        abo_power_max = 1;
    }
    Gauge(current_trame, true, abo_power, abo_power_perso, abo_power_perso_status, abo_power_max, mobile, style);

    $('.datesynchro').html(datesynchro);

    if (type == "water" || type == "oil" || type == "gaz") {
        $('.navinfo').hide();
        $('#widgetgauge').hide();
        $('#statBox').hide();
        if (type == "water") {
            $('#Temp7jBox').hide();
            $('#Temp4sBox').hide();
            $('#Temp12mBox').hide();
            $('#TempaBox').hide();
        } else {
            $('#Temp7jBox').show();
            $('#Temp4sBox').show();
            $('#Temp12mBox').show();
            $('#TempaBox').show();
        }
        $('#currentBox').removeClass("col-lg-8").addClass("col-lg-12");
        $('.bt_tab').show();
        //	$('.bt_graph').hide();
    } else {
        $('.navinfo').show();
        $('#widgetgauge').show();
        $('#Temp7jBox').show();
        $('#Temp4sBox').show();
        $('#Temp12mBox').show();
        $('#TempaBox').show();
        $('.bt_tab').show();
    }

    /*Affichage du graph du jour*/
    showCurrentTrame(current_trame, yesterday_trame, max, min, tarif_type, type, abo_power, style);


    /*Affichage Graphique Jours Semaine Mois */
    //showDashGraph(style);

    $(window).resize();

    return true;
}


//function ajaxDonut(){
//
//		console.info('Chargement du donut.');
//		$.ajax({
//			type: 'POST',
//			url: 'plugins/conso/core/ajax/graph.ajax.php?graphique=week',
//			data: {
//				action : donuts,
//				debut : datares.result.day.debut,
//				fin : datares.result.day.fin,
//				old : true,
//				libelle : 'Consommation de la semaine par jours',
//				graph_mode : 0,//0 Watt ou 1 prix
//				graph_type : "jours",
//				type_graphHP : 'column',
//				type_graphHC : 'column',
//				type_graphHP_OLD : 'spline',
//				type_graphHC_OLD : 'spline'
//			},
//			dataType: 'json',
//			error: function (request, status, error) {
//				handleAjaxError(request, status, error, $('#div_DashboardAlert'));
//			},
//			success: function (data) {
//			//console.debug(data);
//				if (data.state != 'ok') {
//					$('#div_DashboardAlert').showAlert({message: data.result, level: 'danger'});
//					return;
//				}else{
//					    new Highcharts.Chart(show_graph(data.result,'Day','none')); /*data,id,id_legend*/
//					    data.result.affichage = 1;
//					    new Highcharts.Chart(show_graph(data.result,'DayEuro','none')); /*data,id,id_legend*/
//
//				}
//			}
//		});
//
//}

function showDashGraph(style) {

    var ecq = $('#conso_ecq').val();

    console.info('Chargement des graphiques stat.');
    var debug = false;
    $.ajax({
        type: 'POST',
        url: 'plugins/conso/core/ajax/conso.ajax.php',
        data: {
            action: 'GetDateCurrent'
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
                $.ajax({
                    type: 'POST',
                    url: 'plugins/conso/core/ajax/graph.ajax.php?graphique=7jours',
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

                            new Highcharts.Chart(show_graph(data.result, 'Day', 'none', style));
                            /*data,id,id_legend*/
                            new Highcharts.Chart(show_graph_temp(data.result, 'TempDay', 'none', style));
                            /*température*/
                            //new Highcharts.Chart(show_graph_dju(data.result, 'DayDJU', 'none', style));
                            /*DJU*/

                            data.result.affichage = 1;
                            new Highcharts.Chart(show_graph(data.result, 'DayEuro', 'none', style));
                            /*data,id,id_legend*/

                        }
                    }
                });

                //alert('debut:'+datares.result.week.debut+' fin:'+datares.result.week.fin);
                $.ajax({
                    type: 'POST',
                    url: 'plugins/conso/core/ajax/graph.ajax.php?graphique=4semaines',
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
                            new Highcharts.Chart(show_graph(data.result, 'Month', 'none', style));
                            /*data,id,id_legend*/
                            new Highcharts.Chart(show_graph_temp(data.result, 'TempMonth', 'none', style));
                            /*température*/
                            //new Highcharts.Chart(show_graph_dju(data.result, 'MonthDJU', 'none', style));
                            /*DJU*/
                            data.result.affichage = 1;
                            new Highcharts.Chart(show_graph(data.result, 'MonthEuro', 'none', style));
                            /*data,id,id_legend*/
                        }
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: 'plugins/conso/core/ajax/graph.ajax.php?graphique=12Month',
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

                            new Highcharts.Chart(show_graph(data.result, 'Year', 'none', style));
                            /*Graphique year conso*/
                            new Highcharts.Chart(show_graph_temp(data.result, 'TempYear', 'none', style));
                            /*Graphique year température*/
                            //new Highcharts.Chart(show_graph_dju(data.result, 'YearDJU', 'none', style));
                            /*DJU*/

                            data.result.affichage = 1;
                            new Highcharts.Chart(show_graph(data.result, 'YearEuro', 'none', style));
                            data.result.enabled_old = false;
                            new Highcharts.Chart(show_graph(data.result, 'YearTaxe', 'none', style));

                            /*Chargement du tableau prevision Front */
                            if (!ismobile) showPrevision(data, datares);

                        }
                    }
                });


                $.ajax({
                    type: 'POST',
                    url: 'plugins/conso/core/ajax/conso.ajax.php?GetDJU',
                    data: {
                        action: 'GetDJU',
                        id_ecq: ecq
                    },
                    dataType: 'json',
                    error: function(request, status, error) {
                        handleAjaxError(request, status, error, $('#div_DashboardAlert'));
                    },
                    success: function(data) {
                        if (data.state != 'ok') {
                            $('#div_DashboardAlert').showAlert({ message: data.result, level: 'danger' });

                        } else {
                            //new Highcharts.Chart(show_graph_dju(data.result, 'DJUYear', 'none', style));
                            /*Graphique year DJU*/
                        }
                    }
                });
                console.info('Avant pluriannuel.');
                $.ajax({
                    type: 'POST',
                    url: 'plugins/conso/core/ajax/graph.ajax.php?graphique=pluriannuel',
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

                            new Highcharts.Chart(show_graph(data.result, 'pluri', 'none', style));
                            /*Graphique year conso*/
                            new Highcharts.Chart(show_graph_temp(data.result, 'pluriTemp', 'none', style));
                            /*Graphique year température*/
                            //new Highcharts.Chart(show_graph_dju(data.result, 'pluriDJU', 'none', style));
                            /*DJU*/

                            data.result.affichage = 1;
                            new Highcharts.Chart(show_graph(data.result, 'pluriEuro', 'none', style));

                        }
                    }
                });
            }
        }
    });


}

function toTimestamp(strDate) {
    var datum = Date.parse(strDate);
    return datum / 1000;
}

function showCurrentTrame(data_init, yesterday_trame, max, min, tarif_type, type_ecq, abo_power, mystyle) {
    //var debug = true;
    console.info('Chargement du graphique du jour.');

    //console.debug(data_init);
    var dataHp = [];
    var dataHc = [];

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
    var color_gaz = "#ead61c"
    var color_oil = "#9d622b"
    var last_color = false;
    var last_timestamp = false;
    var max_temp = 0;

    $.each(data_init.reverse(), function(key, value) {

        dataCurrent.push([value.timestamp * 1000, parseInt(value.papp)]);

        dataTemp.push([value.timestamp * 1000, (parseFloat(value.temp) > 0 ? parseFloat(value.temp) : null)]);

        if (parseFloat(value.temp) > parseFloat(max_temp))
            max_temp = parseFloat(value.temp);

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

        lastvalue = [value.timestamp * 1000, parseInt(value.papp)];
        last_timestamp = value.timestamp * 1000;
        last_color = (value.ptec == "HP" ? color_byHP : ((type_ecq == 'gaz') ? color_gaz : ((type_ecq == 'oil') ? color_oil : color_byHC)));


    });

    dataZone.push({ value: last_timestamp, color: last_color });

    if (yesterday_trame.length > 0)
        $.each(yesterday_trame.reverse(), function(key, value) {
            var d = new Date(value.timestamp * 1000);
            var d2 = d.setDate(d.getDate() + 1); // -1 Jour
            dataHier.push([d2, parseInt(value.papp)]);
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
                color: (mystyle == "cssdefault" ? "#333333" : '#b2afaa')
            },
            itemHoverStyle: {
                color: (mystyle == "cssdefault" ? "#000" : '#DEDEDE')
            },
            itemHiddenStyle: {
                color: (mystyle == "cssdefault" ? "#CCC" : '#1c1e22')
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
                //   max : ( type_ecq=='electricity' ? abo_power*1000 :null)  ,
                // Secondary yAxis
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }],
                title: {
                    text: (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'Puissance (Watt)' : (type_ecq == 'gaz' ? 'Conso. (dm3)' : 'Conso. (Litres)')),
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
                type: (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'areaspline' : 'column'),
                name: 'Aujourd\'hui',
                data: dataCurrent,
                //visible: ((tarif_type == "HCHP") ? true : false ),
                visible: true,
                id: 'CurrentSerie',
                //color: "#4572A7"
                pointStart: point_start,
                pointIntervalUnit: 'month',
                tooltip: {
                    valueSuffix: (type_ecq == 'electricity' || type_ecq == 'electprod' ? ' W' : (type_ecq == 'gaz' ? ' dm3' : ' L')),
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
                    valueSuffix: (type_ecq == 'electricity' || type_ecq == 'electprod' ? ' W' : (type_ecq == 'gaz' ? ' dm3' : ' L')),
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
                    title: (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'Min ' + min.papp + ' Watt / ' + min.inst1 + ' A' : (type_ecq == 'gaz' ? ' Min ' + min.papp + 'dm3' : ' Min ' + min.papp + 'L')),
                    text: (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'Puissance (Watt)' : (type_ecq == 'gaz' ? 'Consommation (dm3)' : 'Consommation (Litres)'))
                }],
                onSeries: 'CurrentSerie',
                shape: 'squarepin',
                //color : (min.ptec=='HC' ? '#4572A7' :'#AA4643'),
                //fillColor :  (min.ptec=='HC' ? '#4572A7' :'#AA4643'),
                color: '#7CBA0B',
                fillColor: '#7CBA0B',
                style: { // text style
                    color: 'white'
                },

                states: {
                    hover: {
                        //    color : (max.ptec=='HC' ? '#AA4643' :'#4572A7'),
                        // fillColor:  (min.ptec=='HC' ? '#4572A7' :'#AA4643'),
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
                    title: (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'Max ' + max.papp + ' Watt / ' + max.inst1 + ' A' : (type_ecq == 'gaz' ? 'Max ' + max.papp + 'dm3' : 'Max ' + max.papp + 'L')),
                    text: (type_ecq == 'electricity' || type_ecq == 'electprod' ? 'Puissance Maximale atteinte' : (type_ecq == 'gaz' ? 'Consommation Max (dm3)' : 'Consommation Max (Litres)'))

                }],
                onSeries: 'CurrentSerie',
                shape: 'squarepin',
                //color : (max.ptec=='HC' ? '#4572A7' :'#AA4643'),
                //fillColor :  (max.ptec=='HC' ? '#4572A7' :'#AA4643'),
                color: '#EEAD51',
                fillColor: '#EEAD51',

                style: { // text style
                    color: 'white'
                },

                states: {
                    hover: {
                        //color : (max.ptec=='HC' ? '#AA4643' :'#4572A7'),
                        // fillColor:  (max.ptec=='HC' ? '#4572A7' :'#AA4643'),
                        fillColor: '#EEAD51',
                    }
                }
            }
        ]
    });

}

function Tabdetail(data, init) {

    console.info('Chargement des informations menu.');

    if (init)
        data = data[0];

    /*alert(data.ptec);
    alert(data.inst1);
    alert(data.imax1);*/
    /*AFFICHAGE DE L ICONE PERIODE DU MENU*/
    if (data.ptec == 'HC') {
        $('.iconeptec').removeClass('redcolor').addClass('bluecolor');
    } else {
        $('.iconeptec').removeClass('bluecolor').addClass('redcolor');
    }

    if (data.inst1 > 9)
        $('#conso_ints1').removeClass('ints1simple').addClass('ints1double');
    else
        $('#conso_ints1').removeClass('ints1double').addClass('ints1simple');


    if (data.imax1 > 9)
        $('#conso_imax1').removeClass('imax1simple').addClass('imax1double');
    else
        $('#conso_imax1').removeClass('imax1double').addClass('imax1simple');


    $('#conso_ptec').text(data.ptec);
    /*Affichage de la période*/

    /*Le papp n est pas renseigné */
    if (parseInt(data.inst1) <= 0) {
        $('#tab_detail .middle').hide();
    } else {
        $('#tab_detail .middle').show();
        $('#conso_ints1').text(data.inst1 + 'A');
        /*Affichage de intensité*/
    }

    /*Le papp n est pas renseigné */
    if (parseInt(data.imax1) <= 0) {
        $('#tab_detail .last').hide();
    } else {
        $('#tab_detail .last').show();
        $('#conso_imax1').text(data.imax1 + 'A');
        /*Affichage de intensité*/
    }

    //console.info('versiontheme:' + versiontheme);
    //console.info('versionplugin:' + versionplugin);
    //$('#conso_theme').text(versiontheme).addClass('imax1simple');

    //$('#conso_version').text(versionplugin).addClass('versdouble');

    //console.debug(data);
}


function TabVariation(data, init, type_ecq, mobile) {
    console.info('Chargement du tableau des variations.');

    var diff = 0;
    var image = '<i class="icon-hand-down"></i>';

    if (init) {
        var DataElement = data;
        //console.debug(DataElement);
        var old_val = '-';
        var old_rec_time = '';
        var old_papp = '';
        var old_ptec = '';
        $("#tab_info").html('');
        $("#tab_info").append('<input type="hidden" value="" name="old_watt_input" id="old_watt_input">');
        $.each(DataElement, function(key, value) {
            diff = 0;
            if (old_val != '-') {
                diff = parseInt(old_val) - parseInt(value.papp);
                if (parseInt(diff) > 0) { //positif
                    diff = '+' + diff + (type_ecq == 'electricity' || type_ecq == 'electprod' ? ' W' : (type_ecq == 'gaz' ? ' dm3' : ' L'));
                    image = '<i class="icon-hand-up"></i>';
                } else if (diff == 0) {
                    image = "";
                    var diff = '';
                } else { //negatif
                    diff = diff + (type_ecq == 'electricity' || type_ecq == 'electprod' ? ' W' : (type_ecq == 'gaz' ? ' dm3' : ' L'));
                    image = '<i class="icon-hand-down"></i>';
                }
            } else {
                image = "";
                diff = '';
                $('#old_watt_input').val(parseInt(value.papp));
            }

            var nb = $('#tab_info tr').length;

            if (old_ptec == "HC")
                var tclass = ' class="bluecolor" ';
            else
                var tclass = ' class="redcolor" ';
            //console.debug(value.rec_time + ' '+ value.papp);
            if (nb <= 9 && diff != '' && diff != '-') { //Si pas de variation on n affiche rien
                $("#tab_info").append('<tr  ' + tclass + '><td ' + tclass + '>' + old_rec_time + '</td><td ' + tclass + ' >' + parseInt(old_val) + (type_ecq == 'electricity' || type_ecq == 'electprod' ? ' W' : (type_ecq == 'gaz' ? ' dm3' : ' L')) + '</td><td  ' + tclass + '>' + image + '  ' + diff + '</td><td  ' + tclass + '>' + old_ptec + '</td></tr>');
            }

            //highlight
            old_val = value.papp;
            old_rec_time = value.rec_time;
            old_ptec = value.ptec;

        });
    } else {
        image = '<i class="icon-hand-down"></i>';
        diff = parseInt(data.papp) - parseInt($('#old_watt_input').val());

        if (parseInt(diff) > 0) {
            diff = '+' + diff + (type_ecq == 'electricity' || type_ecq == 'electprod' ? ' W' : (type_ecq == 'gaz' ? ' dm3' : ' L'));
            image = '<i class="icon-hand-up"></i>';
        } else if (diff == 0) {
            image = "-";
            diff = '-';
        } else {
            diff = diff + (type_ecq == 'electricity' || type_ecq == 'electprod' ? ' W' : (type_ecq == 'gaz' ? ' dm3' : ' L'));
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
            $("#tab_info").prepend('<tr><td ' + tclass + '>' + data.rec_time + '</td><td  ' + tclass + '>' + data.papp + (type_ecq == 'electricity' || type_ecq == 'electprod' ? ' W' : (type_ecq == 'gaz' ? ' dm3' : ' L')) + '</td><td ' + tclass + '>' + image + '  ' + diff + '</td><td  ' + tclass + ' >' + data.ptec + '</td></tr>');
        }
        $('#old_watt_input').val(parseInt(data.papp));
    }

    var refreshdate = getDateRefresh();
    $('.date_isrefresh').html(refreshdate);
}

function checkerror() {
    $.ajax({
        type: 'POST',
        url: 'plugins/conso/core/ajax/conso.ajax.php',
        data: {
            action: 'checkAboTva'
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#error_abo_id_tva'));
        },
        success: function(data) {
            //console.debug(data);
            if (data.state != 'ok') {
                $('#error_abo_id_tva').showAlert({
                    message: 'ALERTE : Merci d\'associer une TVA à  votre abonnement : Onglet Abo ( mettre 5.5 ).',
                    level: 'danger'
                });

            }
        }
    });
}