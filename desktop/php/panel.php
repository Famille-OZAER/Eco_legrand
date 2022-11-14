<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

$deamon_statut =  conso::deamon_info();
if($deamon_statut['state'] == 'nok'){
				log::add('conso_trame', 'debug', 'Chargement du Panel - Deamon non lancée - Redemarre le Deamon');
				conso::deamon_stop();
				conso::deamon_start();
}
			//conso_tools::CheckOptionIsValid();
$cron = cron::byClassAndFunction('conso', 'StartDeamon');

if (is_object($cron)) {
	sendVarToJS('refreshTime', $cron->getDeamonSleepTime());
}
include_file('3rdparty', 'bootstrap-select/dist/css/bootstrap-select', 'css', 'conso');
include_file('3rdparty', 'datetimepicker/jquery.datetimepicker', 'css', 'conso');
include_file('3rdparty', 'datetimepicker/jquery.datetimepicker', 'css', 'conso');
include_file('3rdparty', 'datetimepicker/jquery.datetimepicker', 'css', 'conso');
include_file('3rdparty', 'datatable/datatable', 'css', 'conso');
include_file('desktop', 'ionicons', 'css', 'conso');
include_file('desktop', 'panel', 'css', 'conso');
/*Theme*/
include_file('desktop/css/theme', 'style', 'css', 'conso');
include_file('desktop/css/theme', 'font-awesome', 'css', 'conso');

//if ($_SESSION['user']->getOptions('bootstrap_theme') == 'darksobre') {
//	include_file('desktop/theme', 'dark', 'css', 'conso');
//	sendVarToJS('stylecss', 'cssdark');
//} else {
	sendVarToJS('stylecss', 'cssdefault');
	sendVarToJS('Devise', config::byKey('Devise', 'conso'));

//}


	sendVarToJS('bgmodalcolorvar', "var(--bg-modal-color)");
	sendVarToJS('txtcolor', "var(--txt-color)");
	echo '<style type="text/css">
	.highcharts-axis-labels text tspan {fill: var(--txt-color) !important;}
	.highcharts-yaxis-labels > text {fill: var(--txt-color) !important;}
	#gauge .highcharts-yaxis-labels > text {fill: #484343 !important;}
	#widget_statBox .highcharts-label > text {fill: var(--txt-color) !important;}
	#widget_statBox .carousel-caption {fill: var(--txt-color) !important;}
	.container {width: 1300px;}
	</style>';

/*Date abonnement de l'onglet outils*/
sendVarToJS('date_abo', config::byKey('date_abo', 'conso', '01-01'));
sendVarToJS('versiontheme', "v4");
//$sql = 'ALTER TABLE `test`.`conso_periode` ADD COLUMN `libelle` VARCHAR(255) NULL AFTER `position`; ';
//$result =  DB::Prepare($sql,  array(), DB::FETCH_TYPE_ALL);
$eqLogics = eqLogic::byType('conso');
if (!$eqLogics) {
	echo '
<div style="width: 100%; padding: 7px 35px 7px 15px; margin-bottom: 5px; overflow: auto; max-height: 675px; z-index: 9999;" class=" alert-danger">
<span href="#" style="position : relative; left : 30px;color : grey" class="btn_closeAlert pull-right cursor">×</span>
<span class="displayError">Aucun équipement trouvé merci de parametrer au moins 1 équipement.
</span>
</div>';
	die();
}

		$power = (count($eqLogics) == 0 ? 6 : conso::getPower($eqLogics[0]->getId()));
		$powerperso = (count($eqLogics) == 0 ? 6 : conso::getPowerPerso($eqLogics[0]->getId()));
		$powerpersostatus = (count($eqLogics) == 0 ? 6 : conso::getPowerPersoStatus($eqLogics[0]->getId()));
		$type_abo = (count($eqLogics) == 0 ? 'HCHP' : conso::getAbo($eqLogics[0]->getId()));
		$type = (count($eqLogics) == 0 ? 'electricity' : conso::getType($eqLogics[0]->getId()));
		$eqLogic_default = $eqLogics[0]->getId();

foreach ($eqLogics as $eqLogic) {
	if ((int)$eqLogic->getConfiguration('default') > 0 && $eqLogic->getIsEnable() == 1) {
		$power = conso::getPower($eqLogic->getId());
		$powerperso = conso::getPowerPerso($eqLogic->getId());
		$powerpersostatus = conso::getPowerPersoStatus($eqLogic->getId());
		$type_abo = conso::getAbo($eqLogic->getId());
		$type = conso::getType($eqLogic->getId());
		$eqLogic_default = $eqLogic->getId();
	}
}

$display = ($type_abo == 'HCHP' ? '' : 'displaynone');
$title = ($type_abo == 'HCHP' ? 'HP' : '');
if ($type == 'water' or $type == 'oil' or $type == 'gaz') $title = 'M3';

$btnreturn = config::byKey('btn_return', 'conso', false);
$datesynchro = config::byKey('date_update_conso_jour', 'conso', date("d-m-Y H:i:s"));
$datesynchro =  date("d-m-Y H:i:s");
sendVarToJS('ismobile', false);
sendVarToJS('eqType', 'conso');
sendVarToJS('datesynchro', $datesynchro);
sendVarToJS('abo_power', $power);
sendVarToJS('abo_power_perso', $powerperso);
sendVarToJS('abo_power_perso_status', $powerpersostatus);
sendVarToJS('type_abo', $type_abo);
sendVarToJS('display', $display);
sendVarToJS('type', $type);
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
                        <select id="conso_ecq">
                            <?php
                                foreach ($eqLogics as $eqLogic) {

                                    if ($eqLogic->getIsEnable()) {
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
									<span id="conso_ptec"></span>
									</i>
							</div>
							<div class="infoblock middle">
								<i title="Intensité instantanée totale" class="tooltips iconeptec shortcut-icon icon-bookmark-empty">
									<span class="ints1" id="conso_ints1"></span>
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
                                        <img style="position: absolute;top: 2px;right: 2px;width: 35px; "class="icon_flip" src="plugins/conso/desktop/css/theme/img/euro.png" title="Voir le coût">
                                        <div class="widget-header">
                                            <i class="icon-money"></i>
                                            <h3>Consommation en KWh</h3>
                                            <span class="datesynchro"></span>
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
						                <img style="position: absolute;top: 2px;right: 2px;width: 35px; " class="icon_flip" src="plugins/conso/desktop/css/theme/img/elec.png" title="Voir la consommation">
						                <div class="widget-header">
							                <i class="icon-money"></i>
							                <h3>Montant en €uros</h3>
							                <span class="datesynchro"></span>
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
                                            <span class="datesynchro"></span>
                                        </div>
                                    </div>
                                    <div  class="widget-content">
                                        <div class="shortcuts" >';
                                            include('panel_carousel.php');
                                                    echo '</div>
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
                                        <img id="Temp7jBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/temp.png" title="Voir les températures de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>7 derniers jours</h3>
                                            <span class="datesynchro"></span>
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
                                        <img class="icon_flip" src="plugins/conso/desktop/css/theme/img/elec.png" title="Voir la consommation de cette période">
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
                                        <img id="Temp4sBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/temp.png" title="Voir les températures de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>4 dernières semaines</h3>
                                            <span class="datesynchro"></span>
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
                                        <img class="icon_flip" src="plugins/conso/desktop/css/theme/img/elec.png" title="Voir la consommation de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>Température 4 dernières semaines</h3>
                                            <span class="datesynchro"></span>
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
                                        <img id="Temp12mBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/temp.png" title="Voir les températures de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>12 derniers mois</h3>
                                            <span class="datesynchro"></span>
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
                                        <img class="icon_flip" src="plugins/conso/desktop/css/theme/img/elec.png" title="Voir la consommation de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>Température 12 derniers mois</h3>
                                            <span class="datesynchro"></span>
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
                                       <!-- <img id="DJU12mBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/dju.png" title="Voir les DJU de cette période">-->
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>12 derniers mois en €uros (HT)</h3>
                                            <span class="datesynchro"></span>
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
                                        <img class="icon_flip" src="plugins/conso/desktop/css/theme/img/euro.png" title="Voir la consommation de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>DJU des 12 derniers mois</h3>
                                            <span class="datesynchro"></span>
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
                                    <span class="datesynchro"></span>
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
                                        <img id="Temp12mBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/temp.png" title="Voir les températures de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>Pluriannuel en KWh</h3>
                                            <span class="datesynchro"></span>
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
                                        <img class="icon_flip" src="plugins/conso/desktop/css/theme/img/elec.png" title="Voir la consommation de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>Température pluriannuelles</h3>
                                            <span class="datesynchro"></span>
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
                                        <!--<img id="DJUaBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/dju.png" title="Voir les DJU de cette période">-->
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>Pluriannuel en €uros (HT)</h3>
                                            <span class="datesynchro"></span>
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
                                        <img class="icon_flip" src="plugins/conso/desktop/css/theme/img/euro.png" title="Voir la consommation de cette période">
                                        <div class="widget-header">
                                            <i class="icon-bar-chart"></i>
                                            <h3>DJU pluriannuels</h3>
                                            <span class="datesynchro"></span>
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
		

        <div  class="col-lg-12" id="conso_tab" style="padding-right:25px;border-left: solid 1px #EEE; padding-left: 25px;display:none;">
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
//include_file('3rdparty', 'datetimepicker/jquery.datetimepicker', 'js', 'conso');
//include_file('3rdparty', 'jquery.fileTree/jquery.easing.1.3', 'js');
//include_file('3rdparty', 'jquery.fileTree/jqueryFileTree', 'js');
//include_file('3rdparty', 'datatable/datatable', 'js', 'conso');
include_file('3rdparty', 'circles/circles.min', 'js', 'conso');
include_file('desktop', 'gauge', 'js', 'conso');
include_file('desktop', 'bib_graph', 'js', 'conso');
//include_file('desktop', 'panel_temperature', 'js', 'conso');
include_file('desktop', 'panel_dashboard', 'js', 'Eco_legrand');
//include_file('desktop', 'pie', 'js', 'conso');
include_file('desktop', 'panel', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_price', 'js', 'conso');
//include_file('desktop', 'panel_periode', 'js', 'conso');
//include_file('desktop', 'panel_groupe', 'js', 'conso');
//nclude_file('desktop', 'panel_taxe', 'js', 'conso');
//include_file('desktop', 'panel_tva', 'js', 'conso');
//include_file('desktop', 'panel_tab', 'js', 'conso');
//include_file('desktop', 'statistique/categorie/panel_graph_categorie', 'js', 'conso');
//include_file('desktop', 'statistique/periode/panel_graph_periode', 'js', 'conso');
//include_file('desktop', 'statistique/synthese/panel_graph_synthese', 'js', 'conso');
//include_file('desktop', 'panel_table', 'js', 'conso');
//include_file('desktop', 'panel_correcteur', 'js', 'conso');
//include_file('desktop', 'panel_abo', 'js', 'conso');
include_file('desktop', 'panel_outil', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_backup', 'js', 'conso');
include_file('3rdparty', 'jqueryflip/jquery.flip.min', 'js', 'conso');


//include_file('desktop', 'statistique', 'js', 'conso');


?>
