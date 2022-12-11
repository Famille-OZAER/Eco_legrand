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
$cron = cron::byClassAndFunction('Eco_legrand', 'cron_minute');

if (!is_object($cron)) {
    $cron = new cron();
    $cron->setClass('Eco_legrand');
    $cron->setFunction('cron_minute');
    $cron->setSchedule('* * * * *');   
    $cron->save();
    $cron->start();
}
$cron = cron::byClassAndFunction('Eco_legrand', 'cron_heure');

if (!is_object($cron)) {
	$cron = new cron();
    $cron->setClass('Eco_legrand');
    $cron->setFunction('cron_jour');
    $cron->setSchedule('00 00 * * *');
    $cron->save();
    //$cron->start();
}
include_file('3rdparty', 'css/bootstrap-select', 'css', 'Eco_legrand');
include_file('3rdparty', 'css/jquery.datetimepicker', 'css', 'Eco_legrand');
include_file('3rdparty', 'css/datatable', 'css', 'Eco_legrand');
//include_file('desktop', 'css/font-awesome', 'css', 'Eco_legrand');
//include_file('desktop', 'css/ionicons', 'css', 'Eco_legrand');



//include_file('desktop', 'panel', 'css', 'Eco_legrand');
/*Theme*/
include_file('desktop', 'style', 'css', 'Eco_legrand');

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

$btnreturn = config::byKey('btn_retour', 'Eco_legrand', false);
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
					<li class="cursor bt_elec"><i class="icon kiko-electricity"></i><span>Electricité</span></li>
                    <li class="cursor bt_tab"><i class="icon kiko-water-supply "></i><span>Eau</span></li>
                    <li class="cursor bt_tab"><i class="icon kiko-gas "></i><span>Gaz</span></li>
					<li class=" bt_synthese "><i class="icon-list" aria-hidden="true"></i><span>Synthése</span></li>
					<li class="cursor bt_outil tabgestion expertModeVisible"><i class="icon-wrench"></i><span>Outils</span></li>
					<li class="navinfo">
						<div id="tab_detail" class="inner">
							<div class="infoblock first">
								<i title="Période" class="tooltips iconeptec shortcut-icon far fa-bookmark">
									<span id="Eco_legrand_ptec"></span>
									</i>
							</div>
							<div class="infoblock middle">
								<i title="Intensité instantanée totale" class="tooltips iconeptec shortcut-icon far fa-bookmark">
									<span class="ints1" id="Eco_legrand_ints1"></span>
									</i>
							</div>
							
							
							
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row row-overflow" id="Eco_legrand_elec">
	    <input type="hidden" value="<?php echo $datesynchro ?>" id="datesynchro">
        <div  class="col-lg-12" id="conso_dashboard" style="height:100%;">

		        <div class="span6">
                    <!-- ligne 1 -->
			        <div class="row ligne_1">
				        <div class="col-lg-4" >
					        <div class="widget flip">
					            <div class="card">
                                    <img style="position: absolute;top: 2px;right: 2px;width: 35px; " class="icon_flip front" src="plugins/Eco_legrand/desktop/img/euro.png" title="Voir le coût">
                                    <img style="position: absolute;top: 2px;right: 2px;width: 35px;display:none; " class="icon_flip back" src="plugins/Eco_legrand/desktop/img/elec.png" title="Voir la consommation">
						            <div class="widget-header">
                                            <i class="far fa-money-bill-alt"></i>
                                            <h3 class ="titre front">Consommation en KWh</h3>
                                            <h3 class ="titre back" style="display:none">Montant en €uros TTC</h3>
                                           <!-- <span class="datesynchro" style="position: absolute; right: 35px;"></span>-->
                                        </div>
                                        <div style="height:240px;" class="widget-content">
                                            <div class="face front">
                                        
                                        
                                                <table data-role="table" id="table-column-toggle2 "  class="tableauwatt movie-list table table-striped table-bordered ui-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:25%;">Périodes</th>
                                                            <th style="width:25%;" class="tts2">HP</th>
                                                            <th style="width:25%;" class="dds">HC</th>
                                                            <th style="width:25%;" class="dds ">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Jour</td>
                                                            <td id="day_hpw" ></td>
                                                            <td  id="day_hcw" class="dds"></td>
                                                            <td id="day_totalw" class="dds"></td>
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
                                            <div class="face back" style="display:none">
                                            <table data-role="table" id="table-column-toggle" class="tableaueuros movie-list table table-striped table-bordered ui-responsive">
                                                <thead>
                                                    <tr>
                                                        <th style="width:25%;">Périodes</th>
                                                        <th style="width:25%;"class="tts">HP</th>
                                                        <th style="width:25%;"class="dds">HC</th>
                                                        <th style="width:25%;">Total</th>
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
                        
 				
                        <div class="col-lg-4">
                            <div id="widgetgauge" >
                                <div class="widget">
                                    <div class="widget-header">
                                        <i class="fas fa-bolt"></i>
                                        <h3>Puissance</h3>
                                        <!--<span class="date_isrefresh"></span>-->
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
                        <!--<div class="col-lg-4" id="widget_variation">
                            <div class="widget">
                                <div class="widget-header">
                                    <i class="icon-list-alt"></i>
                                    <h3>Variation</h3>
                                    <span class="date_isrefresh"></span>
                                </div>
                                <div id="widgetvariation" style="height:240px;" class="widget-content">
                                    <div id="tab_list" class="" >
                                        <div class="box-body no-padding">
                                            <table data-role="table" id="tab_info" class="movie-list table table-striped ui-responsive"></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                        <div id="widget_statBox">
                            <div id="statBox" class="col-lg-4">
                                <div class="widget">
                                    <div class="widget-header">
                                        
                                            <i class="fas fa-chart-pie"></i>
                                            <h3>Statistique</h3>
                                            <!--<span class="datesynchro" style="position: absolute; right: 35px;"></span>-->
                                       
                                    </div>
                                    <div  class="widget-content" style="height:240px;">
                                        <div class="shortcuts" >
                                            <div id="carousel-example-generic" data-interval="false" class="carousel slide"  >
                                                <div class="carousel-inner" role="listbox">
                                                    <div class="item active">
                                                       <div class="chart" id="StatDAY" style="height:235px;"></div>
                                                       <div class="carousel-caption defautcss">Aujourd'hui</div>
                                                    </div>
                                                    <div class="item">
                                                       <div class="chart" id="StatYESTERDAY" style="height:235px;"></div>
                                                       <div class="carousel-caption defautcss">Hier</div>
                                                    </div>
                                                    <div class="item">
                                                       <div class="chart" id="StatWEEK" style="height:235px;"></div>
                                                       <div class="carousel-caption defautcss">Semaine</div>
                                                    </div>
                                                    <div class="item">
                                                        <div class="chart" id="Stat" style="height:235px;"></div>
                                                        <div class="carousel-caption defautcss"> Mois</div>
                                                    </div>
                                                    <div class="item">
                                                       <div class="chart" id="StatYEAR" style="height:235px;"></div>
                                                       <div class="carousel-caption defautcss">Année</div>
                                                     </div>
                                                </div>
                                             
                                               <!-- <i class="icon-wrench"></i>
                                             Controls -->
                                               <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                                 <span class="fas fa-chevron-left defautcss" aria-hidden="true"></span>
                                                 <span class="sr-only">Previous</span>
                                               </a>
                                               <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                                 <span class="fas fa-chevron-right defautcss" aria-hidden="true"></span>
                                                 <span class="sr-only">Next</span>
                                               </a>
                                             </div>
                                        </div>  
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
			        </div>
                    <!-- ligne 2 -->
                    <div class="row ligne_2">
                        <div id ="widget_currentBox">
                            <div id="currentBox" class="col-lg-12">
                                <div class="widget">
                                    <div class="widget-header">
                                        <div class="col-lg-7" style="display:block">
                                            <i class="far fa-chart-bar"></i>
                                            <h3>Consommation du jour</h3>
                                            <!--<span class="date_isrefresh"></span>-->
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
                        

                    </div>
                    <!-- ligne 3 -->
                    <div class="row ligne_3">
                        <div class="col-lg-6" >
                            <div class="widget flip">
                                <div class="card">
                                    <img style="position: absolute;top: 2px;right: 2px;width: 35px; " class="icon_flip front" src="plugins/Eco_legrand/desktop/img/euro.png" title="Voir la consommation de cette période en €uros">
                                    <img style="position: absolute;top: 2px;right: 2px;width: 35px;display:none; " class="icon_flip back1" src="plugins/Eco_legrand/desktop/img/temp.png" title="Voir les températures de cette période">
                                    <img style="position: absolute;top: 2px;right: 2px;width: 35px;display:none; " class="icon_flip back2" src="plugins/Eco_legrand/desktop/img/elec.png" title="Voir la consommation de cette période en Kwh">
                                    <div class="widget-header">
                                        <i class="far fa-chart-bar"></i>
                                        <h3 class ="titre front">Consommation des 7 derniers jours</h3>
                                        <h3 class ="titre back1" style="display:none">Montant TTC des 7 derniers jours</h3>
                                        <h3 class ="titre back2" style="display:none">Température des 7 derniers jours</h3>
                                        
                                        <!-- <span class="datesynchro" style="position: absolute; right: 35px;"></span>-->
                                    </div>
                                    <div style="height:340px;" class="widget-content">
                                        <div class="face front">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="Day" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="face back1" style="display:none">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="DayEuro" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="face back2" style="display:none">
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
                        <div class="col-lg-6" >
                            <div class="widget flip">
                                <div class="card">
                                    <img style="position: absolute;top: 2px;right: 2px;width: 35px; " class="icon_flip front" src="plugins/Eco_legrand/desktop/img/euro.png" title="Voir la consommation de cette période en €uros">
                                    <img style="position: absolute;top: 2px;right: 2px;width: 35px;display:none; " class="icon_flip back1" src="plugins/Eco_legrand/desktop/img/temp.png" title="Voir les températures de cette période">
                                    <img style="position: absolute;top: 2px;right: 2px;width: 35px;display:none; " class="icon_flip back2" src="plugins/Eco_legrand/desktop/img/elec.png" title="Voir la consommation de cette période en Kwh">
                                    <div class="widget-header">
                                        <i class="far fa-chart-bar"></i>
                                        <h3 class ="titre front">Consommation des 4 dernières semaines</h3>
                                        <h3 class ="titre back1" style="display:none">Montant TTC des 4 dernières semaines</h3>
                                        <h3 class ="titre back2" style="display:none">Température des 4 dernières semaines</h3>
                                        
                                        <!-- <span class="datesynchro" style="position: absolute; right: 35px;"></span>-->
                                    </div>
                                    <div style="height:340px;" class="widget-content">
                                        <div class="face front">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="Month" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="face back1" style="display:none">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="MonthEuro" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="face back2" style="display:none">
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
                        
                       
                    </div>
                    <!-- ligne 4 -->           
                    <div class="row ligne_4">
                        <div class="col-lg-6" >
                            <div class="widget flip">
                                <div class="card">
                                    <img style="position: absolute;top: 2px;right: 2px;width: 35px; " class="icon_flip front" src="plugins/Eco_legrand/desktop/img/euro.png" title="Voir la consommation de cette période en €uros">
                                    <img style="position: absolute;top: 2px;right: 2px;width: 35px;display:none; " class="icon_flip back1" src="plugins/Eco_legrand/desktop/img/temp.png" title="Voir les températures de cette période">
                                    <img style="position: absolute;top: 2px;right: 2px;width: 35px;display:none; " class="icon_flip back2" src="plugins/Eco_legrand/desktop/img/elec.png" title="Voir la consommation de cette période en Kwh">
                                    <div class="widget-header">
                                        <i class="far fa-chart-bar"></i>
                                        <h3 class ="titre front">Consommation des 12 derniers mois</h3>
                                        <h3 class ="titre back1" style="display:none">Montant TTC des 12 derniers mois</h3>
                                        <h3 class ="titre back2" style="display:none">Température des 12 derniers mois</h3>
                                        
                                        <!-- <span class="datesynchro" style="position: absolute; right: 35px;"></span>-->
                                    </div>
                                    <div style="height:340px;" class="widget-content">
                                        <div class="face front">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="Year" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="face back1" style="display:none">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="YearEuro" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="face back2" style="display:none">
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
                    <div class="col-lg-6" >
                            <div class="widget flip">
                                <div class="card">
                                    <img style="position: absolute;top: 2px;right: 2px;width: 35px; " class="icon_flip front" src="plugins/Eco_legrand/desktop/img/euro.png" title="Voir la consommation de cette période en €uros">
                                    <img style="position: absolute;top: 2px;right: 2px;width: 35px;display:none; " class="icon_flip back1" src="plugins/Eco_legrand/desktop/img/temp.png" title="Voir les températures de cette période">
                                    <img style="position: absolute;top: 2px;right: 2px;width: 35px;display:none; " class="icon_flip back2" src="plugins/Eco_legrand/desktop/img/elec.png" title="Voir la consommation de cette période en Kwh">
                                    <div class="widget-header">
                                        <i class="far fa-chart-bar"></i>
                                        <h3 class ="titre front">Consommation pluriannuelle</h3>
                                        <h3 class ="titre back1" style="display:none">Montant Pluriannuel en €uros</h3>
                                        <h3 class ="titre back2" style="display:none">Température pluriannuelle</h3>
                                        
                                        <!-- <span class="datesynchro" style="position: absolute; right: 35px;"></span>-->
                                    </div>
                                    <div style="height:340px;" class="widget-content">
                                        <div class="face front">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="pluri" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="face back1" style="display:none">
                                            <div class=" shortcuts" >
                                                <div class=" box-body no-padding">
                                                    <div class="chart" id="pluriEuro" style="height:300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="face back2" style="display:none">
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
                       
                    </div>
		</div>
	</div>
		

        <div  class="col-lg-12" id="Eco_legrand_tab" style="padding-right:25px;border-left: solid 1px #EEE; padding-left: 25px;display:none;">
            
        </div>

        

        <div  class="col-lg-12" id="conso_graph" style="padding-right:25px;border-left: solid 1px #EEE; padding-left: 25px;display:none;">
            
        </div>
        <div  class="col-lg-12" id="conso_graph_cat" style="padding-right:25px;border-left: solid 1px #EEE; padding-left: 25px;display:none;">
           
        </div>
        <div  class="col-lg-12" id="conso_synthese" style="padding-right:25px;border-left: solid 1px #EEE; padding-left: 25px;display:none;">
            
        </div>

        <?php
		?>
	</div>

<?php
include_file('3rdparty', 'js/bootstrap-select', 'js', 'Eco_legrand');
//include_file('3rdparty', 'js/bootstrap-select.min', 'js', 'Eco_legrand');
//include_file('3rdparty', 'datetimepicker/jquery.datetimepicker', 'js', 'Eco_legrand');
//include_file('3rdparty', 'jquery.fileTree/jquery.easing.1.3', 'js');
//include_file('3rdparty', 'jquery.fileTree/jqueryFileTree', 'js');
//include_file('3rdparty', 'datatable/datatable', 'js', 'Eco_legrand');
//include_file('3rdparty', 'circles/circles.min', 'js', 'Eco_legrand');
//include_file('desktop', 'gauge', 'js', 'Eco_legrand');
//include_file('desktop', 'bib_graph', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_temperature', 'js', 'Eco_legrand');
//include_file('desktop', 'panel_dashboard', 'js', 'Eco_legrand');
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
include_file('3rdparty', 'js/jquery.flip', 'js', 'Eco_legrand');


//include_file('desktop', 'statistique', 'js', 'Eco_legrand');


?>
