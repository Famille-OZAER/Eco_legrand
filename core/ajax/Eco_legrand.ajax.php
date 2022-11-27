<?php

try {
    require_once dirname(__FILE__) . '/../../core/php/Eco_legrand.inc.php';
    include_file('core', 'authentification', 'php');

    if (!isConnect('admin')) {
        throw new Exception(__('401 - Accès non autorisé', __FILE__));
    }
    
    ajax::init();
    
    
    
    
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
        if (isset($prixSave['id'])) {
            $prix = Eco_legrand_prix::byId($prixSave['id']);
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

		$eqLogic = Eco_legrand::byId(init('id_ecq'));
		$conso_jour = Eco_legrand_teleinfo::get_conso_jour(init('id_ecq'));
		$yesterday_conso = Eco_legrand_teleinfo::get_conso_hier(init('id_ecq'));
		$week_conso = Eco_legrand_teleinfo::get_conso_semaine(init('id_ecq'));
		$month_conso = Eco_legrand_teleinfo::get_conso_mois(init('id_ecq'));
		$year_conso = Eco_legrand_teleinfo::get_conso_annee(init('id_ecq'));


		$tab_data = array();
		$tab_data['day_conso'] = $conso_jour;
		$tab_data['yesterday_conso'] = $yesterday_conso;
		$tab_data['week_conso'] = $week_conso;
		$tab_data['month_conso'] = $month_conso;

		$tab_data['year_conso'] = $year_conso;
		

		$d = Eco_legrand::getDateAbo(init('id_ecq'));
		$tab_data['title'] = 'Du '.$d['date_debut_fact'].' au '.$d['date_fin_fact'].' : vous pouvez changer cette date dans la configurtion de l\'équipement ';
		$tab_data['titleold'] = 'Du '.$d['date_debut_fact_old'].' au '.$d['date_fin_fact_old'].' :  vous pouvez changer cette date dans la configurtion de l\'équipement ';

		 ajax::success($tab_data);

	}
    if (init('action') == 'loadingDash' && init('id_ecq')) {
		
		$date_debut = init('date_debut',false);
		$date_fin = init('date_fin',false);

		Eco_legrand::add_log( 'debug', 'Action loadingDash équipement:'.init('id_ecq'));
		$current_trame = Eco_legrand_teleinfo::get_trame_actuelle(false,false,false,false,$date_debut,$date_fin,init('id_ecq')); /*Retourne les valeur d aujourd hui*/
		$max_current_trame = Eco_legrand_teleinfo::get_trame_actuelle(1,false,true,false,$date_debut,$date_fin,init('id_ecq')); /*retourne le max d aujourd hui*/
		$min_current_trame = Eco_legrand_teleinfo::get_trame_actuelle(1,false,false,true,$date_debut,$date_fin,init('id_ecq')); /*retourne le min d aujourd hui*/

		$yesterday_trame = array();
		if(!$date_debut & !$date_fin){
			Eco_legrand::add_log( 'debug','Action loadingDash équipement:'.init('id_ecq').' trame hier');
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
		//$tab_data['type'] = 'electricité';

		/*if(count($current_trame)==0) {
			$sql = 'CREATE OR REPLACE VIEW `conso_current`  AS (SELECT * FROM conso_teleinfo WHERE rec_date = CURRENT_DATE() OR rec_date = DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY))';
			$row = DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
			Eco_legrand::add_log( 'debug', 'Création de la table conso_current car aucune valeur ne ressort.');
		}*/

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
		Eco_legrand::add_log( 'debug', ' Nb équipement:'.$nb_equipement);
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
		//log::add('conso', 'debug', 'Action GetDateCurrent debut:'.$data_week['debut'].' fin:'.$data_week['fin']);
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
		try {
	

			$eqLogics = eqLogic::byId(init('id_ecq'));
			$power= 0;
			$type_abo = Eco_legrand::get_type_Abo(init('id_ecq'));
			$type = 'electricity';

			$data = Eco_legrand_teleinfo::get_trame_actuelle(init('limit'),false,false,false,false,false,init('id_ecq'));
			if (init('yesterday',false) && init('yesterday') != 'false') {
			//     log::add('conso_debug', 'debug', 'Action CurrentTrame Yesterday');
					$yesterday= Eco_legrand_teleinfo::get_trame_actuelle(init('limit'),true,false,false,false,false,init('id_ecq'));
					$data['yesterday_papp'] =  $yesterday['papp'];
			}else{
				$data['yesterday_papp'] = '';
			}
				

			
			
			$data['type'] = $type;
		} catch (exeption $th) {
			throw new Exception($th);
		}
		ajax::success($data);
	}
	if (init('action') == 'VerifParam') {
		$result = Eco_legrand::CheckOptionIsValid();
        ajax::success($result);
    }
	if (init('action') == 'Synchroniser_teleinfo' && init('id_ecq')) {
		$result = Eco_legrand::CheckOptionIsValid();
		$teleinfo = Eco_legrand_teleinfo::byeqlogicID(init('id_ecq'));
		
        ajax::success($result);
    }
    throw new Exception(__('Aucune methode correspondante à : ', __FILE__) . init('action'));
    /*     * *********Catch exeption*************** */
} catch (Exception $e) {
    ajax::error(displayExeption($e), $e->getCode());
}
?>
 