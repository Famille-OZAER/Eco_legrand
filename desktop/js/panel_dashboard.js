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








function getNbJoursMois(mois, annee) {
    var lgMois = ['31', '28', '31', '30', '31', '30', '31', '31', '30', '31', '30', '31'];

    if ((annee % 4 == 0 && annee % 100 != 0) || annee % 400 == 0) {
        lgMois[1] = '29';
    }
    return parseInt(lgMois[mois]); // 0 < mois <11
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



function toTimestamp(strDate) {
    var datum = Date.parse(strDate);
    return datum / 1000;
}