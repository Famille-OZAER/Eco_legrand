<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

$deamon_statut =  Eco_legrand::deamon_info();
if($deamon_statut['state'] == 'nok'){
    Eco_legrand::add_log( 'debug', 'Chargement du Panel - Deamon non lancée - Redemarre le Deamon');
    Eco_legrand::deamon_stop();
    Eco_legrand::deamon_start();
}
			//Eco_legrand::CheckOptionIsValid();
$cron = cron::byClassAndFunction('conso', 'StartDeamon');

if (is_object($cron)) {
	sendVarToJS('refreshTime', $cron->getDeamonSleepTime());
}
include_file('3rdparty', 'bootstrap-select', 'css', 'Eco_legrand');
include_file('3rdparty', 'jquery.datetimepicker', 'css', 'Eco_legrand');
include_file('3rdparty', 'datatable', 'css', 'Eco_legrand');
include_file('desktop', 'ionicons', 'css', 'conso');
include_file('desktop', 'panel', 'css', 'Eco_legrand');
/*Theme*/
include_file('desktop', 'style', 'css', 'Eco_legrand');
include_file('desktop/css/theme', 'font-awesome', 'css', 'conso');
//sendVarToJS('date_abo', config::byKey('date_abo', 'Eco_legrand', '01-01'));
//sendVarToJS('versiontheme', "v4");
//sendVarToJS('stylecss', 'cssdefault');
//sendVarToJS('bgmodalcolorvar', "var(--bg-modal-color)");
//sendVarToJS('txtcolor', "var(--txt-color)");
//	echo '<style type="text/css">
//	.highcharts-axis-labels text tspan {fill: var(--txt-color) !important;}
//	.highcharts-yaxis-labels > text {fill: var(--txt-color) !important;}
//	#gauge .highcharts-yaxis-labels > text {fill: #484343 !important;}
//	#widget_statBox .highcharts-label > text {fill: var(--txt-color) !important;}
//	#widget_statBox .carousel-caption {fill: var(--txt-color) !important;}
//	.container {width: 1300px;}
//	</style>';

$eqLogics = eqLogic::byType('Eco_legrand');

$eqlogic_actif=false;
 foreach ($eqLogics as $eqLogic) {
	if ( $eqLogic->getIsEnable() && $eqLogic->getConfiguration("afficher_panel",0) == 1) {
        $eqlogic_actif = true;
		//$power = Eco_legrand::getPower($eqLogic->getId());
		//$powerperso = Eco_legrand::getPowerPerso($eqLogic->getId());
		//$powerpersostatus = Eco_legrand::getPowerPersoStatus($eqLogic->getId());
		$type_abo = Eco_legrand::get_type_abo($eqLogic->getId());
		//$type = Eco_legrand::getType($eqLogic->getId());
		$eqLogic_default = $eqLogic->getId();
       // var_dump( $type_abo);
	}
}
if (!$eqlogic_actif) {
   
	/*echo '
    <div style="width: 100%; padding: 7px 35px 7px 15px; margin-bottom: 5px; overflow: auto; max-height: 675px; z-index: 9999;" class=" alert-danger">
       <span class="displayError">Aucun équipement trouvé merci de parametrer au moins 1 équipement actif et afficher dans le panel.</span>
    </div>';*/
   
  // echo '</div></div>';
   exit(0);
	//die();
}

$btnreturn = config::byKey('btn_return', 'Eco_legrand', false);
$datesynchro =  date("d-m-Y H:i:s");
//sendVarToJS('ismobile', false);
sendVarToJS('eqType', 'Eco_legrand');
/*sendVarToJS('datesynchro', $datesynchro);
sendVarToJS('abo_power', $power);
sendVarToJS('abo_power_perso', $powerperso);
sendVarToJS('abo_power_perso_status', $powerpersostatus);
sendVarToJS('type_abo', $type_abo);
sendVarToJS('display', $display);
sendVarToJS('type', $type);*/
?>
    <div id="md_eau"></div>
    <div id="md_gaz"></div>

	
	<div class="subnavbar">
		<div class="subnavbar-inner">
			<div class="container" style="padding:0px;">
				<ul class="mainnav">
					<?php
					if ($btnreturn) {
						echo '<li class="cursor bt_dashboard"><a href="' . $btnreturn . '"><i class="icon-arrow-left"></i><span>Retour</span></a></li>';
					}
					?>

					<li class="menu_equipement cursor"><span>Equipement :
                        <select id="Eco_legrand_ecq">
                            <?php
                                foreach ($eqLogics as $eqLogic) {

                                    if ($eqLogic->getIsEnable() && $eqLogic->getConfiguration("afficher_panel",0) == 1) {
                                        if ($eqLogic->getConfiguration('parent_id') == "") {
                                            echo '<option  ' . ($eqLogic_default == $eqLogic->getId() ? 'selected' : '') . ' data-id="' . $eqLogic->getId() . '" value=' . $eqLogic->getId() . ' >(' . $eqLogic->getId() . ') ' . $eqLogic->getHumanName(true) . '</option>';
                                            $valueid = $eqLogic->getId();
                                            foreach ($eqLogics as $eqLogic) {
                                                if ($eqLogic->getIsEnable()) {
                                                    if ($eqLogic->getConfiguration('parent_id') == $valueid) {
                                                        echo '<option  ' . ($eqLogic_default == $eqLogic->getId() ? 'selected' : '') . ' data-id="' . $eqLogic->getId() . '" value=' . $eqLogic->getId() . ' > ⇒ (' . $eqLogic->getId() . ') ' . $eqLogic->getHumanName(true) . '</option>';
                                                        $valueid2 = $eqLogic->getId();
                                                        foreach ($eqLogics as $eqLogic) {
                                                            if ($eqLogic->getIsEnable()) {
                                                                if ($eqLogic->getConfiguration('parent_id') == $valueid2) {
                                                                    echo '<option  ' . ($eqLogic_default == $eqLogic->getId() ? 'selected' : '') . ' data-id="' . $eqLogic->getId() . '" value=' . $eqLogic->getId() . ' > ⇒⇒ (' . $eqLogic->getId() . ') ' . $eqLogic->getHumanName(true) . '</option>';
                                                                    $valueid3 = $eqLogic->getId();
                                                                    foreach ($eqLogics as $eqLogic) {
                                                                        if ($eqLogic->getIsEnable()) {
                                                                            if ($eqLogic->getConfiguration('parent_id') == $valueid3) {
                                                                                echo '<option  ' . ($eqLogic_default == $eqLogic->getId() ? 'selected' : '') . ' data-id="' . $eqLogic->getId() . '" value=' . $eqLogic->getId() . ' > ⇒⇒⇒ (' . $eqLogic->getId() . ') ' . $eqLogic->getHumanName(true) . '</option>';

                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            ?>
                        </select>
					</li>
					<li class="cursor bt_dashboard"><i class="icon kiko-electricity"></i><span>Electricité</span></li>
                    <li class="cursor bt_tab"><i class="icon kiko-water-supply "></i><span>Eau</span></li>
                    <li class="cursor bt_tab"><i class="icon kiko-gas "></i><span>Gaz</span></li>
					<li class=" bt_synthese "><i class="icon-list" aria-hidden="true"></i><span>Synthése</span></li>
					<li class="cursor bt_outil tabgestion expertModeVisible"><i class="icon-wrench"></i><span>Outils</span></li>
					<li class="navinfo">
						<div id="tab_detail" class="inner">
							<div class="infoblock first">
								<i title="Période" class="tooltips iconeptec shortcut-icon icon-bookmark-empty">
									<span id="Eco_legrand_ptec"></span>
									</i>
							</div>
							<div class="infoblock middle">
								<i title="Intensité instantanée totale" class="tooltips iconeptec shortcut-icon icon-bookmark-empty">
									<span class="ints1" id="Eco_legrand_ints1"></span>
									</i>
							</div>
							
							
							
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row row-overflow" id="div_conso">
	    <input type="hidden" value="<?php echo $datesynchro ?>" id="datesynchro">
        <div  class="col-lg-12" id="conso_dashboard" style="height:100%;">
		    <div id="div_DashboardAlert" style="display: none;"></div>

		        <div class="span6">
                    <!-- ligne 1 -->
			        <div class="row">
				        <div class="col-lg-4" id="widget_tableau_prix">
					        <div class="widget flip" id="tableau_prix">
					            <div class="card">
                                    <div class="face front">
                                        <img style="position: absolute;top: 2px;right: 2px;width: 35px; "class="icon_flip" src="plugins/Eco_legrand/desktop/img/euro.png" title="Voir le coût">
                                        <div class="widget-header">
                                            <i class="icon-money"></i>
                                            <h3>Consommation en KWh</h3>
                                            <span class="datesynchro" style="position: absolute; right: 35px;"></span>
                                        </div>
                                        <div style="height:240px;" class="widget-content">
                                            <table data-role="table" id="table-column-toggle2 "  class="tableauwatt movie-list table table-striped table-bordered ui-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>Périodes</th>
                                                        <th class="tts2" ></th>
                                                        <th class="dds ">HC</th>
                                                        <th class="dds ">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Jour</td>
                                                        <td id="day_hpw" ></td>
                                                        <td  id="day_hcw" class="dds "></td>
                                                        <td id="day_totalw" class="dds "></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hier</td>
                                                        <td id="yesterday_hpw" ></td>
                                                        <td id="yesterday_hcw" class="dds "></td>
                                                        <td id="yesterday_totalw" class="dds"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Semaine </td>
                                                        <td id="week_hpw" ></td>
                                                        <td  id="week_hcw" class="dds "></td>
                                                        <td id="week_totalw" class="dds "></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mois </td>
                                                        <td id="month_hpw" ></td>
                                                        <td  id="month_hcw" class=" dds "></td>
                                                        <td id="month_totalw" class="dds "></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Année 
                                                            <i data-toggle="tooltip"  data-placement="right" title="" class="fas fa-info-circle datefact"></i>
                                                        </td>
                                                        <td id="year_hpw"></td>
                                                        <td  id="year_hcw" class=" dds "></td>
                                                        <td id="year_totalw" class="dds "></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
						            <div class="face back">
						                <img style="position: absolute;top: 2px;right: 2px;width: 35px; " class="icon_flip" src="plugins/Eco_legrand/desktop/img/elec.png" title="Voir la consommation">
						                <div class="widget-header">
							                <i class="icon-money"></i>
							                <h3>Montant en €uros</h3>
							                <span class="datesynchro" style="position: absolute; right: 35px;"></span>
						                </div>
						                <div style="height:240px;" class="widget-content">
                                            <div class="col-xs-1 changeType" style="display:none;">
                                                <button type="button" class="icon-eye-open btn btn-default"></button>
                                            </div>
                                            <table data-role="table" id="table-column-toggle" class="tableaueuros movie-list table table-striped table-bordered ui-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>Périodes</th>
                                                        <th class="tts" data-placement="top" data-toggle="tooltip" title="Prix HT + TVA!" ></th>
                                                        <th class=" dds " data-placement="top" data-toggle="tooltip" title="Prix HT + TVA">HC TTC</th>
                                                        <th data-placement="top" data-toggle="tooltip" title="Prix TTC + Abonnement (Si équipement Total) + TVA + Taxes">Total TTC</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Jour </td>
                                                        <td id="day_hp" ></td>
                                                        <td id="day_hc" class="dds "></td>
                                                        <td id="day_total"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hier </td>
                                                        <td id="yesterday_hp" ></td>
                                                        <td id="yesterday_hc" class="dds "></td>
                                                        <td id="yesterday_total"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Semaine </td>
                                                        <td id="week_hp"></td>
                                                        <td id="week_hc" class="dds "></td>
                                                        <td id="week_total" ></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mois </td>
                                                        <td id="month_hp"></td>
                                                        <td id="month_hc" class="dds "></td>
                                                        <td id="month_total" ></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Année <i data-toggle="tooltip"  data-placement="right" title="" class="fas fa-info-circle datefact"></i></td>
                                                        <td id="year_hp"></td><td id="year_hc" class="dds "></td>
                                                        <td id="year_total"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
						                </div>
					                </div>
                                    
                                </div>
                            </div>
                        </div>
 				
                        <div class="col-lg-4" id="widget_gauge">
                            <div id="widgetgauge" >
                                <div class="widget">
                                    <div class="widget-header">
                                        <i class="icon-bolt"></i>
                                        <h3>Puissance</h3>
                                        <span class="date_isrefresh"></span>
                                    </div>
                                    <div style="height:240px;" class="widget-content">
                                        <div class="shortcuts" >
                                            <div id="contentegauge" class="box-body no-padding">
                                            <!--<div class="circle" id="circles-1"></div>	-->
                                            <div  id="gauge" class="inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" id="widget_variation">
                            <div class="widget">
                                <div class="widget-header">
                                    <i class="icon-list-alt"></i>
                                    <h3>Variation</h3>
                                    <span class="date_isrefresh"></span>
                                </div>
                                <div id="widgetvariation" style="height:240px;" class="widget-content">
                                    <div id="tab_list" class="shortcuts" >
                                        <div class="box-body no-padding">
                                            <table data-role="table" id="tab_info" class="movie-list table table-striped ui-responsive"></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
			        </div>
                    <!-- ligne 2 -->
                    <div class="row">
                        <div id ="widget_currentBox">
                            <div id="currentBox" class="col-lg-8">
                                <div class="widget">
                                    <div class="widget-header">
                                        <div class="col-lg-7" style="display:block">
                                            <i class="icon-bar-chart"></i>
                                            <h3>Consommation du jour</h3>
                                            <span class="date_isrefresh"></span>
                                        </div>
                                        <div class="col-xs-1 changeType" style="display:none;"><button type="button" class="icon-eye-open btn btn-default"></button></div>
                                        <div class="col-lg-4">
                                            <div class="input-group input-daterange">
                                                <span class="input-group-addon">Du</span>
                                                <input id="current_debut" type="text" class="datecurrent datetimepicker form-control" value="">
                                                <span class="input-group-addon">au</span>
                                                <input id="current_fin" type="text" class=" datecurrent datetimepicker form-control" value="">
                                                <span id="validedatecurrent" class="input-group-addon">OK</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div  class="widget-content">
                                        <div class="shortcuts" >
                                            <div id="contentebar" class="box-body no-padding">
                                                <div class="chart" id="Currentbar"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="widget_statBox">
                            <div id="statBox" class="col-lg-4" style="height:320px">
                                <div class="widget">
                                    <div class="widget-header">
                                        <div class="col-lg-8" style="display:block">
                                            <i class="icon-bar-chart"></i>
                                            <h3>Statistique</h3>
                                            <span class="datesynchro" style="position: absolute; right: 35px;"></span>
                                        </div>
                                    </div>
                                    <div  class="widget-content">
                                        <div class="shortcuts" >
                                       
                                            <?php
                                                //include('panel_carousel.php');
                                                    echo '</div>'
                                            ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- ligne 3 -->
                    <div class="row">
                        <div class="col-lg-4" id="widget_Temp7jBox">
                            <div class="flip widget">
                                <div class="card">
                                    <div class="face front">
                                        <img id="Temp7jBox" class="icon_flip" src="plugins/Eco_legrand/desktop/img/temp.png" title="Voir les températures de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>7 derniers jours</h3>
                                            <span class="datesynchro" style="position: absolute; right: 35px;"></span>
                                        </div>
                                        <div style="height:340px;" class="  widget-content">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="Day" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="face back">
                                        <img class="icon_flip" src="plugins/Eco_legrand/desktop/img/elec.png" title="Voir la consommation de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>Température 7 derniers jours</h3>
                                            <span class="datesynchro"></span>
                                        </div>
                                        <div style="height:340px;" class="widget-content">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="TempDay" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4" id="widget_Temp4sBox">
                            <div class="flip widget">
                                <div class="card">
                                    <div class="face front">
                                        <img id="Temp4sBox" class="icon_flip" src="plugins/Eco_legrand/desktop/img/temp.png" title="Voir les températures de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>4 dernières semaines</h3>
                                            <span class="datesynchro" style="position: absolute; right: 35px;"></span>
                                        </div>
                                        <div style="height:340px;" class="  widget-content">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="Month" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="face back">
                                        <img class="icon_flip" src="plugins/Eco_legrand/desktop/img/elec.png" title="Voir la consommation de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>Température 4 dernières semaines</h3>
                                            <span class="datesynchro" style="position: absolute; right: 35px;"></span>
                                        </div>
                                        <div style="height:340px;" class="  widget-content">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="TempMonth" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4" id="widget_Temp12mBox">
                            <div class="flip widget">
                                <div class="card">
                                    <div class="face front">
                                        <img id="Temp12mBox" class="icon_flip" src="plugins/Eco_legrand/desktop/img/temp.png" title="Voir les températures de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>12 derniers mois</h3>
                                            <span class="datesynchro" style="position: absolute; right: 35px;"></span>
                                        </div>
                                        <div style="height:340px;" class="  widget-content">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="Year" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="face back">
                                        <img class="icon_flip" src="plugins/Eco_legrand/desktop/img/elec.png" title="Voir la consommation de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>Température 12 derniers mois</h3>
                                            <span class="datesynchro" style="position: absolute; right: 35px;"></span>
                                        </div>
                                        <div style="height:340px;" class="  widget-content">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="TempYear" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ligne 4 -->
                    <div class="row">
                        <div class=" col-lg-4" id="widget_DJU7jBox">
                            <div class="flip widget">
                                <div class="card">
                                    <div class="face front">
                                       <!-- <img id="DJU7jBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/dju.png" title="Voir les DJU  de cette période">-->
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>7 derniers jours en €uros (HT)</h3>
                                            <span class="datesynchro"></span>
                                        </div>
                                        <div style="height:340px;" class="widget-content">
                                            <div class="shortcuts" >
                                                <div class="box-body no-padding">
                                                    <div class="chart" id="DayEuro" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="face back">
                                        <img class="icon_flip" src="plugins/conso/desktop/css/theme/img/euro.png" title="Voir  la consommation de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>DJU des 7 derniers jours</h3>
                                            <span class="datesynchro"></span>
                                        </div>
                                        <div style="height:340px;" class="  widget-content">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="DayDJU" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div class=" col-lg-4" id="widget_DJU4sBox">
                            <div class="flip widget">
                                <div class="card">
                                    <div class="face front">
                                            <!--<img id="DJU4sBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/dju.png" title="Voir les DJU de cette période ">-->
                                            <div class="widget-header">
                                                <i class="icon-bar-chart"></i>
                                                <h3>4 dernières semaines en €uros (HT)</h3>
                                                <span class="datesynchro"></span>
                                            </div>
                                            <div style="height:340px;" class="widget-content">
                                                <div class="shortcuts" >
                                                    <div class="box-body no-padding">
                                                            <div class="chart" id="MonthEuro" style="height:300px;"></div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="face back">
                                        <img class="icon_flip" src="plugins/conso/desktop/css/theme/img/euro.png" title="Voir la consommation de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>DJU des 4 dernières semaines</h3>
                                            <span class="datesynchro"></span>
                                        </div>
                                        <div style="height:340px;" class="  widget-content">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="MonthDJU" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div class=" col-lg-4" id="widget_DJU12mBox">
                            <div class="flip widget">
                                <div class="card">
                                    <div class="face front">
                                       <!-- <img id="DJU12mBox" class="icon_flip" src="plugins/Eco_legrand/desktop/img/dju.png" title="Voir les DJU de cette période">-->
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>12 derniers mois en €uros (HT)</h3>
                                            <span class="datesynchro" style="position: absolute; right: 35px;"></span>
                                        </div>
                                        <div style="height:340px;" class="widget-content">
                                            <div class="shortcuts" >
                                                <div class="box-body no-padding">
                                                    <div class="chart" id="YearEuro" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="face back">
                                        <img class="icon_flip" src="plugins/Eco_legrand/desktop/img//euro.png" title="Voir la consommation de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>DJU des 12 derniers mois</h3>
                                            <span class="datesynchro" style="position: absolute; right: 35px;"></span>
                                        </div>
                                        <div style="height:340px;" class="  widget-content">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="YearDJU" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ligne 5 -->
                    <div class="row">
                        <div class="col-lg-6" id="widget_YearTaxe">
                            <div class="widget">
                                <div class="widget-header">
                                    <i class="icon-bar-chart"></i>
                                    <h3>12 derniers mois TTC</h3>
                                    <span class="datesynchro" style="position: absolute; right: 35px;"></span>
                                </div>
                                <div style="height:340px;" class="widget-content">
                                    <div class="shortcuts" >
                                        <div class="box-body no-padding">
                                            <div class="chart" id="YearTaxe" style="height:300px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ligne 6 -->
                    <div class="row">
                        <div class="col-lg-6" id="widget_PluriYear">
                            <div class="flip widget">
                                <div class="card">
                                    <div class="face front">
                                        <img id="Temp12mBox" class="icon_flip" src="plugins/Eco_legrand/desktop/img/temp.png" title="Voir les températures de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>Pluriannuel en KWh</h3>
                                            <span class="datesynchro" style="position: absolute; right: 35px;"></span>
                                        </div>
                                        <div style="height:340px;" class="widget-content">
                                            <div class="shortcuts" >
                                                <div class="box-body no-padding">
                                                    <div class="chart" id="pluri" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="face back">
                                        <img class="icon_flip" src="plugins/Eco_legrand/desktop/img/elec.png" title="Voir la consommation de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>Température pluriannuelles</h3>
                                            <span class="datesynchro" style="position: absolute; right: 35px;"></span>
                                        </div>
                                        <div style="height:340px;" class="  widget-content">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="pluriTemp" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6" id="widget_PluriYearEuro">
                            <div class="flip widget">
                                <div class="card">
                                    <div class="face front">
                                        <!--<img id="DJUaBox" class="icon_flip" src="plugins/Eco_legrand/desktop/img/dju.png" title="Voir les DJU de cette période">-->
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>Pluriannuel en €uros (HT)</h3>
                                            <span class="datesynchro" style="position: absolute; right: 35px;"></span>
                                        </div>
                                        <div style="height:340px;" class="widget-content">
                                            <div class="shortcuts" >
                                                <div class="box-body no-padding">
                                                    <div class="chart" id="pluriEuro" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="face back">
                                        <img class="icon_flip" src="plugins/Eco_legrand/desktop/img/euro.png" title="Voir la consommation de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>DJU pluriannuels</h3>
                                            <span class="datesynchro" style="position: absolute; right: 35px;"></span>
                                        </div>
                                        <div style="height:340px;" class="  widget-content">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="pluriDJU" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
		</div>
	</div>
		

        <div  class="col-lg-12" id="Eco_legrand_tab" style="padding-right:25px;border-left: solid 1px #EEE; padding-left: 25px;display:none;">
            <div id="div_tabAlert" style="display: none;"></div>
        </div>

        

        <div  class="col-lg-12" id="conso_graph" style="padding-right:25px;border-left: solid 1px #EEE; padding-left: 25px;display:none;">
            <div id="div_GraphAlert" style="display: none;"></div>
        </div>
        <div  class="col-lg-12" id="conso_graph_cat" style="padding-right:25px;border-left: solid 1px #EEE; padding-left: 25px;display:none;">
            <div id="div_GraphAlert" style="display: none;"></div>
        </div>
        <div  class="col-lg-12" id="conso_synthese" style="padding-right:25px;border-left: solid 1px #EEE; padding-left: 25px;display:none;">
            <div id="div_TableAlert" style="display: none;"></div>
        </div>

        <?php
		?>
	</div>

<?php
include_file('3rdparty', 'bootstrap-select/dist/js/bootstrap-select', 'js', 'conso');
include_file('3rdparty', 'bootstrap-select/dist/js/bootstrap-select.min', 'js', 'conso');
//include_file('3rdparty', 'datetimepicker/jquery.datetimepicker', 'js', 'Eco_legrand');
//include_file('3rdparty', 'jquery.fileTree/jquery.easing.1.3', 'js');
//include_file('3rdparty', 'jquery.fileTree/jqueryFileTree', 'js');
//include_file('3rdparty', 'datatable/datatable', 'js', 'Eco_legrand');
//include_file('3rdparty', 'circles/circles.min', 'js', 'Eco_legrand');
//include_file('desktop', 'gauge', 'js', 'Eco_legrand');
//include_file('desktop', 'bib_graph', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_temperature', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_dashboard', 'js', 'Eco_legrand');
//include_file('desktop', 'pie', 'js', 'Eco_legrand');
include_file('desktop', 'panel', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_price', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_periode', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_groupe', 'js', 'Eco_legrand');
//nclude_file('desktop', 'panel_taxe', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_tva', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_tab', 'js', 'Eco_legrand');
//include_file('desktop', 'statistique/categorie/panel_graph_categorie', 'js', 'Eco_legrand');
//include_file('desktop', 'statistique/periode/panel_graph_periode', 'js', 'Eco_legrand');
//include_file('desktop', 'statistique/synthese/panel_graph_synthese', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_table', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_correcteur', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_abo', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_outil', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_backup', 'js', 'Eco_legrand');
include_file('3rdparty', 'jqueryflip/jquery.flip.min', 'js', 'conso');


//include_file('desktop', 'statistique', 'js', 'Eco_legrand');


?>
