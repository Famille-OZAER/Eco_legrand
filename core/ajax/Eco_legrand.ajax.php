<?php

try {
    require_once dirname(__FILE__) . '/../../core/php/Eco_legrand.inc.php';
    include_file('core', 'authentification', 'php');

    if (!isConnect('admin')) {
        throw new Exception(__('401 - Accès non autorisé', __FILE__));
    }
    
    ajax::init();
    if (!function_exists('is_countable')) {
		function is_countable($var) {
			return (is_array($var) || $var instanceof Countable);
		}
	}
	 function get_lundi_dimanche_from_week($week,$year,$format="d/m/Y") {
		//log::add('conso', 'debug', 'week:'.$week. ' year:'.$year));
		$firstDayInYear=date("N",mktime(0,0,0,1,1,$year));
		if ($firstDayInYear<5)
			$shift=-($firstDayInYear-1)*86400;
		else
			$shift=(8-$firstDayInYear)*86400;

		if ($week>1) $weekInSeconds=($week-1)*604800; else $weekInSeconds=0;
		$timestamp=mktime(0,0,0,1,1,$year)+$weekInSeconds+$shift;
		$timestamp_vendredi=mktime(0,0,0,1,5,$year)+$weekInSeconds+$shift;
		$dimanche = $timestamp + (6 * 60 * 60 * 24);

		return  date($format,$timestamp).'<br>'. date($format,$dimanche);

	}

	function checkPrice($value){
		if((float)$value>0)
			return (float)number_format(str_replace(",", ".", $value),2,'.','');
		return 0;
	}

	function NbJours($debut, $fin) {

		$tDeb = explode("-", $debut);
		$tFin = explode("-", $fin);

		$diff = mktime(0, 0, 0, $tFin[1], $tFin[2], $tFin[0]) -
				mktime(0, 0, 0, $tDeb[1], $tDeb[2], $tDeb[0]);

		return(round($diff / 86400,0)+1);

	}
    
    
    if (init('action') == 'Supp_Prix') {
        // $prix->id = init('id');
         $sql = 'DELETE FROM `Eco_legrand_prix` WHERE `id`='.init('id');
         $row =  DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
         ajax::success();
    }

    if (init('action') == 'Récup_Prix') {
        //$sql = 'SELECT * FROM Eco_legrand_prix ORDER BY  type ASC, date_debut';
        //return DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL, PDO::FETCH_CLASS, __CLASS__);
        $prix = Eco_legrand_prix::byEqLogicId(init('id'));
        foreach ( $prix as $Eco_legrand_prix){
            $Eco_legrand_prix->setDate_debut(Eco_legrand_prix::dateFr($Eco_legrand_prix->getDate_debut()));
            $Eco_legrand_prix->setDate_fin(Eco_legrand_prix::dateFr($Eco_legrand_prix->getDate_fin()));
            }
        ajax::success($prix);
    }
  
 	if (init('action') == 'Ajout_MAJPrix') {
        $prixSave = json_decode(init('event'), true);
        $prix = null;
        if ($prixSave['id']!="") {
            $prix = Eco_legrand_prix::byId($prixSave['id']);
			$prix->setEqLogicId(init('id'));
        }
        if (!is_object($prix)) {
            $prix = new Eco_legrand_prix();
            $prix->setEqLogicId(init('id'));
        }
        utils::a2o($prix, jeedom::fromHumanReadable($prixSave));
        $prix->save();

        ajax::success($prix);
    }
    
    if (init('action') == 'TabConso' && init('id_ecq')) {

		$conso_jour = Eco_legrand_teleinfo::get_conso_jour(init('id_ecq'));
		$conso_hier = Eco_legrand_teleinfo::get_conso_hier(init('id_ecq'));
		$conso_semaine = Eco_legrand_teleinfo::get_conso_semaine(init('id_ecq'));
		$conso_mois = Eco_legrand_teleinfo::get_conso_mois(init('id_ecq'));
		$conso_année = Eco_legrand_teleinfo::get_conso_annee(init('id_ecq'));

		$tab_data = array();
		$tab_data['conso_jour'] = $conso_jour;
		$tab_data['conso_hier'] = $conso_hier;
		$tab_data['conso_semaine'] = $conso_semaine;
		$tab_data['conso_mois'] = $conso_mois;
		$tab_data['conso_année'] = $conso_année;
		
		$d = Eco_legrand::getDateAbo(init('id_ecq'));
		$tab_data['title_année'] = 'Du '.$d['date_debut_fact'].' au '.$d['date_fin_fact'].' : vous pouvez changer cette date dans la configurtion de l\'équipement ';
		$tab_data['title_mois'] = 'Du '.$d['date_debut_mois'].' au '.$d['date_fin_mois'].' : vous pouvez changer cette date dans la configurtion de l\'équipement ';
		
		 ajax::success($tab_data);

	}
   
  	if (init('action') == 'loadingDash' && init('id_ecq')) {
		
		$date_debut = init('date_debut',false);
		$date_fin = init('date_fin',false);

		$current_trame = Eco_legrand_teleinfo::get_trame_actuelle(false,false,false,false,$date_debut,$date_fin,init('id_ecq')); /*Retourne les valeur d aujourd hui*/
		$max_current_trame = Eco_legrand_teleinfo::get_trame_actuelle(1,false,true,false,$date_debut,$date_fin,init('id_ecq')); /*retourne le max d aujourd hui*/
		$min_current_trame = Eco_legrand_teleinfo::get_trame_actuelle(1,false,false,true,$date_debut,$date_fin,init('id_ecq')); /*retourne le min d aujourd hui*/

		$yesterday_trame = array();
		if(!$date_debut & !$date_fin){
			$yesterday_trame = Eco_legrand_teleinfo::get_trame_actuelle(false,true,false,false,$date_debut,$date_fin,init('id_ecq')); /*Retourne les valeurs d hier*/
		}

		$eqLogics = eqLogic::byId(init('id_ecq'));
		
		$tab_data = array();
		$tab_data['nb_trame'] = count($current_trame);
		$tab_data['trame_du_jour'] = $current_trame;
		$tab_data['trame_hier'] = $yesterday_trame;
		$tab_data['max_current_trame'] = $max_current_trame;
		$tab_data['min_current_trame'] = $min_current_trame;
		$tab_data['isous'] = Eco_legrand::get_intensite_max(init('id_ecq'));
		//$tab_data['abo_power_perso'] = $powerperso;
		//$tab_data['abo_power_perso_status'] = $powerpersostatus;
		$tab_data['type_abo'] = Eco_legrand::get_type_Abo(init('id_ecq'));
		

		/* Déterminer s'il y a plusieurs équipements électrique dépendant d'un total*/
		$sql = 'select distinct eqLogicID from Eco_legrand_jour where eqLogicID > 0';
		$result = DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
		if ($result) {
			$id_eq = init('id_ecq');
			$nb_equipement = 1;
			foreach ($result as $key => $val) {
				$eqLogics = eqLogic::byId($id_eq);
				if($eqLogics) {					
					$nb_equipement += 1;
				}
			}
		}else {
			$nb_equipement = 1;
		}
		
		$tab_data['nb_equipement'] = $nb_equipement;
       
		ajax::success($tab_data);

	}

    //if (init('action') == 'crontabAllJour') {
		/*insert table jours a faire 1 fois par jours a 00h00 */
		
		//	conso_teleinfo::crontabJour(true);
		//	ajax::success();
	//}

	//if (init('action') == 'crontabJour') {
		/*Uniquement la date du jour  */
		//conso_teleinfo::deleteNullValue();
		//conso_teleinfo::crontabJour();
		//ajax::success();

	//}
	if (init('action') == 'get_date_actuelle' && init('id_ecq')) {

		$tab_data = array();

		/*retourne la date de debut et de fin de la semaine en cours*/
		//	$data_day = conso_teleinfo::getWeekStarAndEnd(true);
		$data_day['debut'] = date('Y-m-d', strtotime('-6 day'));
		$data_day['fin'] = date("Y-m-d");
		$tab_data['day'] = $data_day;

		//$tz_object = new DateTimeZone('Europe/Paris');
		//date_default_timezone_set('Europe/Paris');
		$date = new DateTime();
		//$datetime->setTimezone($tz_object);
		//$datetime->format('Y\-m\-d\ h:i:s');

		/*date de fin de la semaine en cours*/
		$data_week = array();
		//recupere la date de debut par rapport au numero de la semaine -3 semaines
		$data_week['debut']  = Eco_legrand_teleinfo::get_lundi_vendredi_from_week(date('W', strtotime('-3 weeks')),date('Y-m-d', strtotime('-3 weeks')));
		$data_week['fin']  = Eco_legrand_teleinfo::get_lundi_vendredi_from_week(date('W'),date('Y-m-d'),"Y-m-d",'fin');
		$tab_data['week'] = $data_week;

		//$data_month['debut'] = date('Y-m-d', strtotime('-3 weeks'));
		$data_month = array();
		/*retourne la date de fin du mois en cours*/
		$data_month['fin'] = $date->format('Y-m-t');
		$tab_data['month'] = $data_month;

		/*retourne la date de debut et de fin de l annee en cours*/
		$d = Eco_legrand::getDateAbo(init('id_ecq'));

		$data_year['debut'] = $d['date_debut_fact'];
		$data_year['debut_graph'] = $d['date_debut_graph'];
		$data_year['fin'] = $d['date_fin_fact'];
		$tab_data['year'] = $data_year;

		$data_year_old = array();
		$data_year_old['debut'] = date('Y-m-d', strtotime('-1 year', strtotime(date('Y-01-01'))));
		$data_year_old['fin'] =date('Y-m-d', strtotime('-1 year', strtotime(date('Y-12-31'))));
		$tab_data['year_old'] = $data_year_old;

		ajax::success($tab_data);
}
  
	if (init('action') == 'Trame_actuelle' && init('id_ecq')) {
		//ajax::success();
		//log::add('conso_debug', 'debug', 'Action CurrentTrame '.init('yesterday',false));
			

		$data = Eco_legrand_teleinfo::get_trame_actuelle(init('limit'),false,false,false,false,false,init('id_ecq'));
		if (init('yesterday',false) && init('yesterday') != 'false') {
		//     log::add('conso_debug', 'debug', 'Action CurrentTrame Yesterday');
				$yesterday= Eco_legrand_teleinfo::get_trame_actuelle(init('limit'),true,false,false,false,false,init('id_ecq'));
				$data['yesterday_papp'] =  $yesterday['papp'];
		}else{
			$data['yesterday_papp'] = '';
		}
			

		
		
		//$data['type'] = $type;
		
		ajax::success($data);
	}
  
	if (init('action') == 'Graphique' && init('id_ecq')) {
		
		$xlabel = 'du '. init('debut') .' au '.init('fin');
		$pdate_debut = init('debut');
		$pdate_fin = init('fin');
		$timestampdebut = strtotime($pdate_debut);
		$timestampfin = strtotime($pdate_fin);

		$year_old = init('old',false);
		$type_graph =  init('graph_type',false);
		$type_graphHP = "column";
		$type_graphHC =  "column";
		$type_graphHP_OLD =  'spline';
		$type_graphHC_OLD = 'spline';
		
		$result = Eco_legrand_teleinfo::get_calcul_prix($pdate_debut,$pdate_fin,$type_graph,init('id_ecq'));

		$num_rows = is_array($result) && count($result) ;

		if($num_rows==0){
			$data =  array(
			'trouv' => false,
			'title' => "Aucune donnée à charger"
			);
			ajax::success(jeedom::toHumanReadable($data));
		return;
		}
		$data_year_old = false;
		if($year_old && $year_old!='false'){
			/************************************/
			/*Afficher année précedente*/
			/************************************/
	
			$kwhhp_old = array();
			$kwhhc_old = array();
			//log::add('conso', 'debug', 'year_old date deb:'.$pdate_debut.' date fin:'.$pdate_fin);
			$result_old = Eco_legrand_teleinfo::get_calcul_prix($pdate_debut,$pdate_fin,$type_graph,init('id_ecq'),true);/*Année derniere*/
			$num_rows_old = is_array($result_old) && count($result_old) ;
			if($num_rows_old>0 && $result_old[0]['rec_date'] != 0){
					$data_year_old = true;
			}
			$i=0;
		}
		$no=0;
		if($result){
			foreach  ($result as  $row){
			
					/************************************/
					/*Afficher année précedente*/
					/************************************/
					if($data_year_old){
			
							$day_old = false;
			
							foreach ($result_old as $row_old )  {
									if (
										($type_graph=='jours' && ((int)$row_old['jour'] == (int)$row['jour'])  && ((int)$row_old['mois'] == (int)$row['mois']) && ((int)$row_old['annee'] == (int)$row['annee']-1) )
										||
										($type_graph=='semaines' && $row_old['semaine'] == $row['semaine'] && (int)$row_old['annee'] == (int)$row['annee']-1 )
										||
										($type_graph=='mois' && (int)$row_old['mois'] == (int)$row['mois'] && (int)$row_old['annee'] == (int)$row['annee']-1 )
									){
										$day_old = true;
			
											
										$val_kwhhp_old = checkPrice($row_old["hp"]);
										$val_kwhhc_old = checkPrice($row_old["hc"]) ;
										$val_kw = $val_kwhhp_old + $val_kwhhc_old;
										//log::add('conso', 'debug', 'kw_old:'.$val_kw);
										$val_total_hp_old_prix =  checkPrice($row_old["total_hp"]);
										$val_total_hc_old_prix = checkPrice($row_old["total_hc"]) ;
										$val_total_periode_old_hp =  (($row_old["total_hp"]*$row_old["tva"])/100 ) +$row_old["total_hp"]  ;
										$val_total_periode_old_hc = (($row_old["total_hc"]*$row_old["tva"])/100 ) +$row_old["total_hc"]  ;
			
										if(isset($row_old["annee"]))
											$graph_year_old = $row_old["annee"];
			
										$abo_old[$i] = checkPrice($row_old["abonnement"]);
										$timestp_old[$i] = $row_old["categorie"];
										$mois_old[$i] = $row_old["mois"];
										$kwhhp_old[$i] = ($val_kwhhp_old > 0 ? $val_kwhhp_old : null);
										$kwhhc_old[$i] = ($val_kwhhc_old > 0 ? $val_kwhhc_old : null);
										$total_hp_old_prix[$i] = ($val_total_hp_old_prix > 0 ? $val_total_hp_old_prix : null);
										$total_hc_old_prix[$i] = ($val_total_hc_old_prix > 0 ? $val_total_hc_old_prix : null);
										$total_periode_old_hp += $val_total_periode_old_hp;
										$total_periode_old_hc += $val_total_periode_old_hc;
			
										//$i++;
										break;
								}
							}
							
							$abo_old[$i]=null;
							$kwhhp_old[$i]=null;
							$kwhhc_old[$i]=null;
							$timestp_old[$i] = null;
							$mois_old[$i] = null;
							$total_hp_old_prix[$i] = null;
							$total_hc_old_prix[$i] = null;
			
							
							$i++;
					}
			
				/*conversion semaine en date*/
				if (substr($row["categorie"], 0, 3) == 'sem'){
			
					$year = substr($row["categorie"],-2);
					$week = substr($row["categorie"], 4,2);
					$row["categorie"] = get_lundi_dimanche_from_week($week, (int)$year+2000);
				// $row["categorie"] = $row["rec_date"];
				}
			
				//if ($date_deb==0) {
				//	$date_deb = strtotime($row["date"]);
				//}
			
				$date[$no] = $row["date"] ;
				$timestp[$no] = $row["categorie"];
				$mois[$no] = $row["mois"];
				$annee[$no] = $row["annee"];
			
			
				
			
				$hp = checkPrice($row["hp"]);
				$hc = checkPrice($row["hc"]);
				$val_total_hp =  checkPrice($row["total_hp"]);
				$val_total_hc = checkPrice($row["total_hc"]);
			
				
			
				/*Temperature*/
				$temp_moy[$no] =   ($row["temp_moy"] != 0 ? (float)number_format(str_replace(",", ".", $row["temp_moy"]),2,'.','') : null);
				$temp_min[$no] =  ($row["temp_min"] != 0 ?   (float)number_format(str_replace(",", ".", $row["temp_min"]),2,'.','') : null);
				$temp_max[$no] =  ($row["temp_max"] != 0 ? (float)number_format(str_replace(",", ".", $row["temp_max"]),2,'.','') : null);
			
				$eqLogic = eqLogic::byId(init('id_ecq'));
				$tva=$eqLogic->getConfiguration("tva",1);
				$ttc_hp =  (($val_total_hp * $tva) / 100) + $val_total_hp;
				$ttc_hc =  (($val_total_hc * $tva) / 100) + $val_total_hc;
			
				$kwhhp[$no] = ($hp > 0 ? $hp : null);
				$kwhhc[$no] = ($hc > 0 ? $hc : null);
			
				$total_hp[$no] =  ($val_total_hp > 0 ? $val_total_hp : null);
				$total_hc[$no] =  ($val_total_hc > 0 ? $val_total_hc : null);
			
				$total_hp_ttc[$no] = (checkPrice($ttc_hp) > 0 ?  checkPrice($ttc_hp) : null);
				$total_hc_ttc[$no] = (checkPrice($ttc_hc) > 0 ?  checkPrice($ttc_hc)  : null);
			
				//$total_fixe[$no] = ($fixe> 0 ? checkPrice(round($fixe/round(((strtotime($pdate_fin)-strtotime($pdate_debut))/86400)+1,0)*date('j',strtotime($date[$no])),2)) + $abon : null );
				//log::add('conso', 'debug', 'datedeb:'.$date[$no].' mois:'. $mois[$no].' Taxe fixe:'.$total_fixe[$no].' '.$pdate_fin.' '.$pdate_debut.' '.date('j',strtotime($date[$no])).' '.round(((strtotime($pdate_fin)-strtotime($pdate_debut))/86400)+1,0));
				//$total_periode_hp += (($row["total_hp"]*$row["tva"])/100) +$row["total_hp"] ;
				//$total_periode_hc += (($row["total_hc"]*$row["tva"])/100) +$row["total_hc"] ;
				$no++ ;
			
			}
		}
		if($result){
			//if(!isset($date[count($date) -1])){
			if(!isset($date[is_countable($date) || count($date) -1])){
				$date_dernier_releve = "-";
			}else{
			//$date_digits_dernier_releve=explode("-", $date[count($date) -1]) ;
			$date_digits_dernier_releve=explode("-", $date[is_countable($date) || count($date) -1]) ;
			if(!isset($date_digits_dernier_releve[1])){
					$date_dernier_releve = '-';
			}else{
					$date_dernier_releve =  Date('d/m/Y', gmmktime(0,0,0, $date_digits_dernier_releve[1] ,$date_digits_dernier_releve[2], $date_digits_dernier_releve[0])) ;
			}
			}
		}
	
		/*
		* TEMPERATURES
		* test si le tableau contient que des null*/
		$arrayTEMP_moy = (isset($temp_moy) ? array_filter($temp_moy, function($var){ return (!($var == '' || is_null($var)));}) : false);
		$arrayTEMP_max =  (isset($temp_max) ? array_filter($temp_max, function($var){ return (!($var == '' || is_null($var)));}): false);
		$arrayTEMP_min = (isset($temp_min) ?  array_filter($temp_min, function($var){ return (!($var == '' || is_null($var)));}): false);
		
		$subtitle = '';
	
	  	$data =  array(
		//'debut' =>  $date_deb*1000,
	   	
		/*HEURE PLEINE*/
		'HP_name' => 'Heures Pleines',
		'HP_data_prix' => (!isset($total_hp) ? null : $total_hp),
		'HP_data_prix_ttc' => (!isset($total_hp_ttc) ? null : $total_hp_ttc),
		'HP_data' => (!isset($kwhhp) ? null : $kwhhp),
		'HP_type_graph' => $type_graphHP ,
	
		/*HEURE CREUSE*/
		'HC_name' =>   'Heures Creuses',
		'HC_data_prix' => (!isset($total_hc) ? null :  $total_hc),
		'HC_data_prix_ttc' =>  (!isset($total_hc_ttc) ? null :  $total_hc_ttc),
		'HC_data' => (!isset($kwhhc) ? null :  $kwhhc),
		'HC_type_graph' => (!isset($type_graphHC) ? null :  $type_graphHC),
	
	
	
		/*TEMPERATURES*/
		'TEMP_moy' => (is_array($arrayTEMP_moy) && count($arrayTEMP_moy) > 0 && $arrayTEMP_moy!==false ? $temp_moy : false),
		'TEMP_max' => (is_array($arrayTEMP_max) && count($arrayTEMP_max) > 0 && $arrayTEMP_max!==false ? $temp_max : false),
		'TEMP_min' => (is_array($arrayTEMP_min) && count($arrayTEMP_min) > 0 && $arrayTEMP_min!==false ? $temp_min : false),
	
	
		//'point_start_day' => date("d", strtotime($pdate_debut)),
		//'point_start_month' => date("m", strtotime($pdate_debut)),
		//'point_start_year' => date("Y", strtotime($pdate_debut)),
		'affichage' => 0,/*0=Watt,1=Prix*/
		'tarif_type' => "HCHP",
		//'libelle_year_old' =>$graph_year_old,
		'enabled_old' =>  false ,
		'categories' => (!isset($timestp) ? null :  $timestp),
		//'MonthOld' => ($prevision ? $monthOld : false ) // prévision du mois de l 'année derniere
		);

		ajax::success($data);
	}
  
	if (init('action') == 'VerifParam') {
		$result = Eco_legrand::CheckOptionIsValid();
        ajax::success($result);
    }
  
	if (init('action') == 'Synchroniser_teleinfo' && init('id_ecq')) {
		ajax::success(Eco_legrand_teleinfo::get_conso_tores_hp_hc(init('id_ecq')));
		//$result = Eco_legrand::CheckOptionIsValid();
		//$erreurs = Eco_legrand_teleinfo::get_erreur(init('id_ecq'));
		
        //ajax::success($erreurs);
    }
  
	if (init('action') == 'loadingPie') {
		$res = Eco_legrand_teleinfo::GetPie(init('id_ecq',false),init('type',false));
		ajax::success($res);
	}

    throw new Exception(__('Aucune methode correspondante à : ', __FILE__) . init('action'));
    /*     * *********Catch exeption*************** */
} catch (Exception $e) {
    ajax::error(displayExeption($e), $e->getCode());
}
?>