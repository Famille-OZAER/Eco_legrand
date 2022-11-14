<?php

try {
    require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
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
    if (init('action') == 'Ajout_teleinfo') {
        $Eco_legrand = eqLogic::byId(init('id'));
        $timestamp = time();
        $time = date('H:i:s');
        $date = date('Y-m-d');


        $trame = new Eco_legrand_teleinfo();
        $trame->set_timestamp($timestamp);
        $trame->set_date($date);
        $trame->set_heure($time);
        $trame->set_index_hp(222222);
        $trame->set_index_hc(111111);
        $trame->set_ptec('HP');//$ptec
        $trame->set_int_instant(1);
        $trame->set_puissance_totale(230);
        $trame->set_index_circuit1(0);
        $trame->set_index_circuit2(0);
        $trame->set_index_circuit3(0);
        $trame->set_index_circuit4(0);
        $trame->set_index_circuit5(0);
        $trame->set_inst_circuit1(0);
        $trame->set_inst_circuit2(0);
        $trame->set_inst_circuit3(0);
        $trame->set_inst_circuit4(0);
        $trame->set_inst_circuit5(0);
        $trame->set_index_pulse1(0);
        $trame->set_index_pulse2(0);
        $trame->set_inst_pulse1(0);
        $trame->set_inst_pulse2(0);
        $trame->set_Eqlogic_ID($Eco_legrand->getId());
        ///"température extérieure"
        $temp = jeedom::evaluateExpression($Eco_legrand->getConfiguration('température extérieure',0));
        $trame->set_temperature($temp);
        //log::add('conso_trame', 'debug',' Enregistrement ->eq_id : ' . $conso->getId() . '   timestamp : ' . $timestamp . '  rec_date : ' . $rec_date .' rec_time :' . $rec_time . ' papp : ' .$papp .' pulse : '.$pulse.' $papp = (int)$pulse - (int)$result[old]' . $papp.' = '.(int)$pulse.' - '.(int)$result['old'].' ' );
        $trame->save(false);
        ajax::success();
    }
    if (init('action') == 'TabConso' && init('id_ecq')) {

		$eqLogic = Eco_legrand::byId(init('id_ecq'));

		$type_abo = (!$eqLogic ? 'HCHP' : Eco_legrand::getAbo($eqLogic->getId()));
		$type = 'electricity';
        //		$type_abo = (!$eqLogic ? 'HCHP' : $eqLogic->getConfiguration('type_abo') );
        //		$type = (!$eqLogic ? 'electricity' : $eqLogic->getConfiguration('type') );
		$display = ($type_abo == 'HCHP' ? true : false);
		$titletype = ($type_abo == 'HCHP' ? 'HP' : 'HB');

		$conso_jour = Eco_legrand_teleinfo::get_conso_jour(init('id_ecq'));
		//$yesterday_conso = Eco_legrand_teleinfo::getYesterdayConso(init('id_ecq'));
		//$week_conso = Eco_legrand_teleinfo::getWeekConso(init('id_ecq'));
		//$month_conso = Eco_legrand_teleinfo::getMonthConso(init('id_ecq'));
		//$year_conso = Eco_legrand_teleinfo::getYearConso(init('id_ecq'));

		$tab_data = array();

		$tab_data['day_conso'] = $conso_jour;
		//$tab_data['yesterday_conso'] = $yesterday_conso;
		//$tab_data['week_conso'] = $week_conso;
		//$tab_data['month_conso'] = $month_conso;

		//$tab_data['year_conso'] = $year_conso;
		//$tab_data['display'] = $display;
		//$tab_data['titletype'] = $titletype;

		$d = conso_tools::getDateAbo();
		$tab_data['title'] = 'Du '.$d['date_debut_fact'].' au '.$d['date_fin_fact'].' : vous pouvez changer cette date dans l\'onglet outils ';
		$tab_data['titleold'] = 'Du '.$d['date_debut_fact_old'].' au '.$d['date_fin_fact_old'].' : vous pouvez changer cette date dans l\'onglet outils ';

		 ajax::success($tab_data);

	}
    throw new Exception(__('Aucune methode correspondante à : ', __FILE__) . init('action'));
    /*     * *********Catch exeption*************** */
} catch (Exception $e) {
    ajax::error(displayExeption($e), $e->getCode());
}
?>
 