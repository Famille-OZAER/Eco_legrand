<?php
//require_once dirname(__FILE__) . '/../../core/php/Eco_legrand.inc.php';

class Eco_legrand_teleinfo
{
// declaration
	public $timestamp;
	public $date;
	public $heure;
	public $index_hp;
	public $index_hc;
	public $ptec="AA";
	public $int_instant = 0;
	public $puissance_totale = 0;
	public $index_total_circuits;
	public $index_circuit1;
	public $index_circuit2;
	public $index_circuit3;
	public $index_circuit4;
	public $index_circuit5;
	//public $inst_circuit1;
	//public $inst_circuit2;
	//public $inst_circuit3;
	//public $inst_circuit4;
	//public $inst_circuit5;
	//public $index_pulse1;
	//public $index_pulse2;
	//public $inst_pulse1;
	//public $inst_pulse2;
	public $temperature=0;
	public $eqLogicId=0;

	public function get_value($nom_param,$data){
			
		switch ($nom_param) {
			case "timestamp":
				return $this->timestamp;
				break;
			case "date":
				return $this->date;
				break;
			case "heure":
				return $this->heure;
				break;
			case "index_hp":
				return $this->index_hp;
				break;
			case "index_hc":
				return $this->index_hc;
				break;
			case "ptec":
				return $this->ptec;
				break;
			case "int_instant":
				return $this->int_instant;
				break;
			case "puissance_totale":
				return $this->puissance_totale;
				break;
			case "index_circuit1":
				return $this->index_circuit1;
				break;
			case "index_circuit2":
				return $this->index_circuit2;
				break;
			case "index_circuit3":
				return $this->index_circuit3;
				break;
			case "index_circuit4":
				return $this->index_circuit4;
				break;
			case "index_circuit5":
				return $this->index_circuit5;
				break;
			case "index_pulse1":
				return $this->index_pulse1;
				break;
			case "index_pulse2":
				return $this->index_pulse2;
				break;
			case "eqLogicId":
				return $this->eqLogicId;
				break;
			case "temperature":
				return $this->temperature;
				break;
			case "index_total_circuits":
				return $this->index_total_circuits;
				break;
		}
	}
	
	public function set_value($nom_param,$data){
		
		switch ($nom_param) {
			case "timestamp":
				return $this->timestamp = $data;
				break;
			case "date":
				return $this->date = $data;
				break;
			case "heure":
				return $this->heure = $data;
				break;
			case "index_hp":
				return $this->index_hp = $data;
				break;
			case "index_hc":
				return $this->index_hc = $data;
				break;
			case "ptec":
				return $this->ptec = $data;
				break;
			case "int_instant":
				return $this->int_instant = $data;
				break;
			case "puissance_totale":
				return $this->puissance_totale = $data;
				break;
			case "index_circuit1":
				return $this->index_circuit1 = $data;
				break;
			case "index_circuit2":
				return $this->index_circuit2 = $data;
				break;
			case "index_circuit3":
				return $this->index_circuit3 = $data;
				break;
			case "index_circuit4":
				return $this->index_circuit4 = $data;
				break;
			case "index_circuit5":
				return $this->index_circuit5 = $data;
				break;
			case "inst_circuit1":
				return $this->inst_circuit1 = $data;
				break;
			case "inst_circuit2":
				return $this->inst_circuit2 = $data;
				break;
			case "inst_circuit3":
				return $this->inst_circuit3 = $data;
				break;
			case "inst_circuit4":
				return $this->inst_circuit4 = $data;
				break;
			case "inst_circuit5":
				return $this->inst_circuit5 = $data;
				break;
			case "index_pulse1":
				return $this->index_pulse1 = $data;
				break;
			case "index_pulse2":
				return $this->index_pulse2 = $data;
				break;
			case "inst_pulse1":
				return $this->inst_pulse1 = $data;
				break;
			case "inst_pulse2":
				return $this->inst_pulse2 = $data;
				break;
			case "eqLogicId":
				return $this->eqLogicId = $data;
				break;
			case "temperature":
				return $this->temperature = $data;
				break;
			case "index_total_circuits":
				return $this->index_total_circuits = $data;
				break;
		}
	}

	
	public static function byId($_id){
		$values = array('id' => $_id);
		$sql = 'SELECT ' . DB::buildField(__CLASS__) . 'FROM Eco_legrand_teleinfo WHERE eqlogicID=:id';

		return DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW, PDO::FETCH_CLASS, __CLASS__);
	}

	public static function crontabAllJour(){
		self::crontabJour(true);

		return;
	}
	
	public static function crontabJour($tous_les_jours=false){
		$sql = "REPLACE INTO Eco_legrand_jour ";
		$sql .= "(`timestamp`,";
		$sql .= "`date`,";
		$sql .= "`conso_totale_hp`,";
		$sql .= "`conso_totale_hc`,";
		$sql .= "`index_total_max_hp`,";
		$sql .= "`index_total_min_hp`,";
		$sql .= "`index_total_max_hc`,";
		$sql .= "`index_total_min_hc`,";
		$sql .= "`eqLogicID`,";
		$sql .= "`temperature_max`,";
		$sql .= "`temperature_min`,";
		$sql .= "`temperature_moy`)";
		$sql .= "SELECT ";
		$sql .= "MIN(`timestamp`) AS `timestamp`,";
		$sql .= "`Eco_legrand_teleinfo`.`date` AS `date`,";
		$sql .= "((MAX(`index_hp`) - MIN(`index_hp`)) / 1000)  AS `conso_totale_hp`,";
		$sql .= "((MAX(`index_hc`) - MIN(`index_hc`)) / 1000)  AS `conso_totale_hc`,";
		$sql .= "MAX(index_hp) as `index_total_max_hp`,";
		$sql .= "MIN(index_hp) as `index_total_min_hp`,";
		$sql .= "MAX(index_hc) as `index_total_max_hc`,";
		$sql .= "MIN(index_hc) as `index_total_min_hc`,";
		$sql .= "`eqLogicID`,";
		$sql .= "FORMAT(MAX(temperature),2) AS `temperature_max`,";
		$sql .= "FORMAT(MIN(NULLIF(temperature,0)),2) AS `temperature_min`,";
		$sql .= "FORMAT(AVG(NULLIF(temperature,0)),2) AS `temperature_moy`";
		$sql .= "FROM `Eco_legrand_teleinfo`	INNER JOIN eqLogic ON id=eqLogicID ";

		//if (!$tous_les_jours && $nb_jour == 0) $sql .= " where date = CURDATE() ";
		if (!$tous_les_jours) $sql .= " where date = CURRENT_DATE ";

		$sql .= "GROUP BY date,eqLogicID";
		//Eco_legrand::add_log('info', 'CrontabJour:'. $sql);
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}

	public function save( $day = false){//OK

		/*$day permet de creer la derniere Trame du jour et la premiere trame du lendemain*/
		if ($day) {
			/*Force le dernier relevé du jour*/
			$rec_date = date('Y-m-d', strtotime("-1 day"));
			$rec_time = date('23:59:59');
			$timestamp = strtotime($rec_date . ' ' . $rec_time);
			$this->settimestamp($timestamp);
			$this->setrec_date($rec_date);
			$this->setrec_time($rec_time);
			if ($consommation || $power) {
				//log::add('conso_trame', 'debug', '(' . $conso->getId() . ') Mode  POWER Je n ai que la puissance de mon équipement activé.');
				Eco_legrand_teleinfo::SaveConsommation($this,$hchp_unity,$confConso,$power); /*Si consommation alors il faut gerer la coupure de courant*/
			} else {
				DB::save($this, false, true);
			}
			/*Force le premier relevé du lendemain*/
			$rec_date = date('Y-m-d');
			$rec_time = date('00:00:00');
			$timestamp = strtotime($rec_date . ' ' . $rec_time);
			$this->settimestamp($timestamp);
			$this->setrec_date($rec_date);
			$this->setrec_time($rec_time);

			if ($consommation || $power) {
				return Eco_legrand_teleinfo::SaveConsommation($this,$hchp_unity,$confConso,$power);
			} else {
				Eco_legrand::add_log("debug","sauvegarde");
				return DB::save($this, false, true);
			}

		} else {

			return DB::save($this, false, true);
			
		}
	}

	static public function get_calcul_prix($pdate_debut, $pdate_fin, $type_graph = 'mois', $old = false, $limit = false, $id_periode = false, $yesterday = false, $id_ecq, $group_by = false){
		$query_limit = '';
	
		$eqLogics = eqLogic::byId($id_ecq);
		DB::Prepare("SET lc_time_names = 'fr_BE'", array(), DB::FETCH_TYPE_ALL);

		$query = ' SELECT ';
		$query .= $id_ecq . ' as EqlogicID,
				tva,
				annee,
				mois,
				jour
				semaine,
				sum(hp) as hp,
				sum(hc) as hc, 
				sum(total_hp) as total_hp,
				sum(total_hc) as total_hc , 
				prix_hp,
				prix_hc,
				temp_min,
				temp_max,
				temp_moy,
				mois,
				' . ($type_graph == 'mois' ? ' cat_month ' : ($type_graph == 'jours' ? ' cat_jours ' : ($type_graph == 'year' ? ' annee ' : ' cat_semaine '))) . '  as categorie  ,
				`date` FROM (
				    SELECT
						FORMAT(MIN(temperature_min),2) AS temp_min,
						FORMAT(MAX(temperature_max),2) AS temp_max,
						FORMAT(AVG(temperature_moy),2) AS temp_moy,
						`timestamp`,
						`date`,
						`date` as cat_jours,
						DATE_FORMAT(s.`date`,"%Y") AS annee,
						DATE_FORMAT(s.`date`,"%c") AS mois,
						DATE_FORMAT(s.`date`,"%e") AS jour,
						IF(DATE_FORMAT(s.`date`,"%c") = 12 AND DATE_FORMAT(s.`date`,"%v") = 1,52,DATE_FORMAT(s.`date`,"%v")) AS semaine,
						IF(DATE_FORMAT(s.`date`,"%c") = 1 AND DATE_FORMAT(s.`date`,"%v") in (52,53),CONCAT(DATE_FORMAT(s.`date`,"sem %v")," ",DATE_FORMAT(DATE_SUB(s.`date`, INTERVAL 1 YEAR),"%y")) , IF(DATE_FORMAT(s.`date`,"%c") = 12 AND DATE_FORMAT(s.`date`,"%v") = 1,CONCAT(DATE_FORMAT(s.`date`,"sem %v")," ",DATE_FORMAT(DATE_ADD(s.`date`, INTERVAL 1 YEAR),"%y")),DATE_FORMAT(s.`date`,"sem %v %y"))) AS cat_semaine, 
						DATE_FORMAT(s.`date`,"%b %y") AS cat_month,
						DATE_FORMAT(s.`date`,"%y") AS cat_anne,
						ROUND(SUM(s.conso_totale_hp),2) AS hp,
						ROUND(SUM(s.conso_totale_hc),2) AS hc,
						(SELECT SUM(FORMAT(hc,4)) AS hc FROM Eco_legrand_prix  where  `type` like "electricité" AND UNIX_TIMESTAMP(DATE_FORMAT(`date` , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP( DATE_FORMAT( date_debut,  "%Y-%m-%d" ) ) AND UNIX_TIMESTAMP( DATE_FORMAT( date_fin,  "%Y-%m-%d" ) ) ) as prix_hc,
						(SELECT SUM(FORMAT(hp,4)) AS hp FROM Eco_legrand_prix  where  `type` like "electricité" AND UNIX_TIMESTAMP(DATE_FORMAT(`date` , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP( DATE_FORMAT( date_debut,  "%Y-%m-%d" ) ) AND UNIX_TIMESTAMP( DATE_FORMAT( date_fin,  "%Y-%m-%d" ) ) ) as prix_hp,
						(SELECT  FORMAT(valeur ,2)  FROM conso_tva where UNIX_TIMESTAMP(DATE_FORMAT(`date` , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP( DATE_FORMAT( date_debut,  "%Y-%m-%d" ) ) AND UNIX_TIMESTAMP( DATE_FORMAT( date_fin,  "%Y-%m-%d")) and global = 1 limit 0,1) as tva, 	
		
						ROUND(SUM((SELECT SUM(FORMAT(hc,4)) AS hc 
							FROM Eco_legrand_prix 
							WHERE   `type` like "electricité" AND UNIX_TIMESTAMP(DATE_FORMAT(`date` , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP(DATE_FORMAT(date_debut, "%Y-%m-%d")) AND UNIX_TIMESTAMP(DATE_FORMAT(date_fin, "%Y-%m-%d")) ) * s.conso_totale_hc ),2) AS total_hc,
						ROUND(SUM((SELECT SUM(FORMAT(hp,4)) AS hp 
							FROM Eco_legrand_prix 
							WHERE   `type` like "electricité" AND UNIX_TIMESTAMP(DATE_FORMAT(`date` , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP(DATE_FORMAT(date_debut, "%Y-%m-%d")) AND UNIX_TIMESTAMP(DATE_FORMAT(date_fin, "%Y-%m-%d")) ) * s.conso_totale_hp ),2) AS total_hp
								FROM  Eco_legrand_jour s
								WHERE eqlogicID = ' . $id_ecq . ' AND ';


		/*Periode demandée - 1 an*/
		if ($old) {
			$query_periode = '	( timestamp BETWEEN UNIX_TIMESTAMP(DATE_SUB("' . $pdate_debut . '", INTERVAL 372 DAY)) and UNIX_TIMESTAMP(DATE_SUB("' . $pdate_fin . '", INTERVAL 1 YEAR))
                                    or
                                    `date` BETWEEN   DATE_SUB("' . $pdate_debut . '", INTERVAL 372 DAY) AND DATE_SUB("' . $pdate_fin . '", INTERVAL 1 YEAR) )';

		} elseif ($yesterday) {
			$query_periode = '( timestamp BETWEEN UNIX_TIMESTAMP(DATE_SUB("' . $pdate_debut . '", INTERVAL 1 DAY)) and UNIX_TIMESTAMP(DATE_SUB("' . $pdate_fin . '", INTERVAL 1 DAY))
                                    or
                                    `date` BETWEEN   DATE_SUB("' . $pdate_debut . '", INTERVAL 1 DAY) AND DATE_SUB("' . $pdate_fin . '", INTERVAL 1 DAY) )';

		} else {
			/*Periode demandée*/
			$query_periode = ' (	`timestamp` BETWEEN   UNIX_TIMESTAMP("' . $pdate_debut . '") AND UNIX_TIMESTAMP("' . $pdate_fin . '") or `date` BETWEEN   "' . $pdate_debut . '" AND "' . $pdate_fin . '" ) ';
		}


		if (!$group_by) {
			/*Par jours , par mois , par année */
			$query_group = ' GROUP BY  ' . ($type_graph == 'mois' ? ' cat_month ' : ($type_graph == 'jours' ? ' cat_jours ' : ($type_graph == 'year' ? ' cat_anne ' : ' cat_semaine '))) . ' ORDER BY `date` ASC) as req
										GROUP by ' . ($type_graph == 'mois' ? ' req.cat_month ' : ($type_graph == 'jours' ? ' req.cat_jours ' : ($type_graph == 'year' ? ' req.cat_anne ' : ' req.cat_semaine '))) . '  ORDER BY req.date ASC	';
		} else {
			/*Group by personalisé */
			$query_group = ' GROUP BY ' . $group . ' ORDER BY `date` ASC) as req  GROUP BY ' . $group . '  ORDER BY req.date ASC	';
		}

		if ($limit) $query_limit = '	LIMIT 0,' . $limit;

		$sql = $query . $query_periode . $query_group . $query_limit;

		
		Eco_legrand::add_log("debug",$sql);
		
		
		$result = DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
		if ($result) {
			return $result;
		} else{
			return false;
		}
	}

	static public function Trame_hier( $id_ecq = false){
	
		$sql = '';
		$eqLogics = eqLogic::byId($id_ecq);
		$consoYesterday = $eqLogics->getConfiguration('consoyesterday');
		//log::add('conso', 'debug', 'get_trame_actuelle consoYesterday'.$consoYesterday );
		
		$sql .= 'select * from (select timestamp,index_hp,index_hc,ptec,puissance_totale,int_instant,heure,temperature,eqLogicID,DATE_FORMAT(FROM_UNIXTIME(`timestamp`), "%d-%m-%Y %H:%i") as date';
		$sql .= ' From Eco_legrand_teleinfo WHERE ';
		$sql .= 'date = DATE_SUB(current_date(), INTERVAL 1 DAY)';
		$sql .= ' AND eqLogicID = ' . $id_ecq;
		$sql .= ' order by timestamp desc';
		$sql .= ') as req order by req.timestamp desc';
		
		Eco_legrand::add_log('debug', 'requête sql: '.$sql);
		$row = DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
		return $row;

	}

	static public function get_trame_actuelle($limit = false, $yesterday = false, $max = false, $min = false, $date_debut = false, $date_fin = false, $id_ecq = false){
	
		$sql = '';
		$eqLogics = eqLogic::byId($id_ecq);
		$consoYesterday = $eqLogics->getConfiguration('consoyesterday');
		//log::add('conso', 'debug', 'get_trame_actuelle consoYesterday'.$consoYesterday );
		if ($yesterday) $sql .= 'select * from (';

		$sql .= 'select timestamp,index_hp,index_hc,ptec,puissance_totale,int_instant,heure,temperature,eqLogicID,DATE_FORMAT(FROM_UNIXTIME(`timestamp`), "%d-%m-%Y %H:%i") as date ';

		if (!$date_debut) {
			$sql .= ' From Eco_legrand_teleinfo WHERE ';
			if (!$yesterday and !$consoYesterday) $sql .= 'date = current_date() '; else
				$sql .= 'date = DATE_SUB(current_date(), INTERVAL 1 DAY)';
		} else {
			$sql .= ' From Eco_legrand_teleinfo WHERE ';

			if (!$yesterday and !$consoYesterday) $sql .= 'date between "' . $date_debut . '" AND "' . $date_fin . '"'; else
				$sql .= 'date between DATE_SUB("' . $date_debut . '", INTERVAL 1 DAY) AND DATE_SUB("' . $date_fin . '", INTERVAL 1 DAY)';

		}
		$sql .= ' AND eqLogicID = ' . $id_ecq;

		if ($max) $sql .= ' order by puissance_totale desc limit 1 '; elseif ($min) $sql .= ' order by puissance_totale asc limit 1 ';
		else
			$sql .= ' order by timestamp desc';


		$sql .= ($limit && !$max && !$min ? ' limit ' . $limit : ' ');

		if ($yesterday) $sql .= ') as req order by req.timestamp desc';
		
		/*Eco_legrand::add_log('debug', 'limit: '.$limit);
		Eco_legrand::add_log('debug', 'yesterday: '.$yesterday);
		Eco_legrand::add_log('debug', 'max: '.$max);
		Eco_legrand::add_log('debug', 'min: '.$min);
		Eco_legrand::add_log('debug', 'date_debut: '.$date_debut);
		Eco_legrand::add_log('debug', 'date_fin: '.$date_fin);
		Eco_legrand::add_log('debug', 'date_fin: '.$date_fin);
		Eco_legrand::add_log('debug', 'id_ecq: '.$id_ecq);*/
		Eco_legrand::add_log('debug', 'requête sql: '.$sql);
		if (!$limit) $row = DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL); else
			$row = DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);

		return $row;

	}

	static public function consoResult($tab, $type = 'day', $date_debut, $date_fin, $id_equipement){//OK
		//log::add('conso', 'debug','date_deb:'.$date_debut.' date_fin:'.$date_fin);
		//log::add('conso', 'debug', '-------------------Calcul du tableau ' . $type . ' -------------');
		$conso = array('prix_hp' => 0,'total_hp' => 0, 'total_hc' => 0, 'total' => 0, 'hp' => 0, 'hc' => 0, 'total_hc_ttc' => 0, 'total_hp_ttc' => 0,  'total_ttc' => 0,  'total_ht'=> 0);
		$eqLogics = eqLogic::byId($id_equipement);
		foreach ($tab as $key => $cs) {
			$conso['hp'] += $cs['hp'];
			$conso['hc'] += $cs['hc'];
			$conso['prix_hp'] = (float)$cs['prix_hp'];
			$conso['prix_hc'] = (float)$cs['prix_hc'];
			$conso['total'] += ($cs['hp'] + $cs['hc']);
			$conso['total_hp'] += $cs['total_hp'];
			$conso['total_hc'] += $cs['total_hc'];
			$tva=$eqLogics->getConfiguration("tva",1);
			$conso['total_hp_ttc'] += (($cs['total_hp']  * $tva) / 100) + $cs['total_hp'] ;
			$conso['total_hc_ttc'] += (($cs['total_hc']  * $tva) / 100) + $cs['total_hc'] ;
			$conso['total_ttc'] = round($conso['total_hp_ttc'] + $conso['total_hc_ttc'],2) ;
			$conso['total_ht'] = round($conso['total_hp'] + $conso['total_hc'],2) ;  
			//Eco_legrand::add_log("debug", 'consoResult total_ttc:'.$conso['total_ttc'].' total_hp:'.$conso['total_hp'].' total_hp_ttc:'.$conso['total_hp_ttc']. 'total_hc_ttc:'.$conso['total_hc_ttc']);
		}
		//log::add('conso', 'debug', '---------------------FIN-------------------------');
		$conso['total_hp'] = round($conso['total_hp'],2);
		$conso['total_hp_ttc'] = round($conso['total_hp_ttc'],2);
		$conso['total_hc'] = round($conso['total_hc'],2);
		$conso['total_hc_ttc'] = round($conso['total_hc_ttc'],2);
		
		return $conso;
	}

	static public function get_conso_jour($eqLogicID){//OK
		$day_conso = Eco_legrand_teleinfo::get_calcul_prix(date("Y-m-d"), date("Y-m-d"), "jours", false, false, false, false, $eqLogicID); /*Conso du jour */
		if ($day_conso !== false) {
			return Eco_legrand_teleinfo::consoResult($day_conso, 'day', date("Y-m-d"), date("Y-m-d"), $eqLogicID);
		} else {
			return false;
		}
	}

	static public function get_conso_hier($id_ecq){
		$hier = new DateTime('-1 day');
		$day_conso = Eco_legrand_teleinfo::get_calcul_prix($hier->format('Y-m-d'), $hier->format('Y-m-d'), "jours", false, false, false, false, $id_ecq); /*Conso du jour */
		if ($day_conso !== false) {
			return Eco_legrand_teleinfo::consoResult($day_conso, 'day', $hier->format('Y-m-d'), $hier->format('Y-m-d'), $id_ecq);
		} else {
			return false;
		}
	}

	static public function get_conso_semaine($id_ecq){//OK
		$date_week = Eco_legrand_teleinfo::get_debut_fin_semaine(true); /*retourne la date de debut et de fin de la semaine en cours*/
		$week_conso = Eco_legrand_teleinfo::get_calcul_prix($date_week['debut'], $date_week['fin'], "semaine", false, false, false, false, $id_ecq); /*Conso de la semaine en cours  */
		if ($week_conso !== false) {
			return Eco_legrand_teleinfo::consoResult($week_conso, 'week', $date_week['debut'], $date_week['fin'], $id_ecq);
		} else {
			return false;
		}
	}

	static public function get_conso_mois($id_ecq){//OK
		$date = new DateTime();
		$month_conso = Eco_legrand_teleinfo::get_calcul_prix($date->format('Y-m-01'), $date->format('Y-m-t'), "mois", false, false, false, false, $id_ecq); /*Conso du mois en cours  */
		if ($month_conso !== false) {
			return Eco_legrand_teleinfo::consoResult($month_conso, 'month', $date->format('Y-m-01'), $date->format('Y-m-t'), $id_ecq);
		} else {
			return false;
		}
	}

	static public function get_conso_annee($id_ecq){
		$date = new DateTime();
		$d = Eco_legrand::getDateAbo($id_ecq);
		Eco_legrand::add_log("debug",$d);
		$year_conso = Eco_legrand_teleinfo::get_calcul_prix($date->format($d['date_debut_fact']), $date->format($d['date_fin_fact']), "mois", false, false, false, false, $id_ecq); /*Conso de  l année en cours  */
		if ($year_conso !== false) {
			return Eco_legrand_teleinfo::consoResult($year_conso, 'year', $date->format($d['date_debut_fact']), $date->format($d['date_fin_fact']), $id_ecq);
		} else {
			return false;
		}
	}

	public static function get_debut_fin_semaine($firstDayIsMonday = false, $format = 'Y-m-d'){

		//   $weekStartTime = mktime(0, 0, 0, date('m'), date('d') - date('w'), date('Y'));
		$weekStartTime = mktime(0, 0, 0, date('m'), date('d') - date('N') + 1, date('Y'));

		// $weekStartTime += ($firstDayIsMonday)? 86400 : 0;
		//log::add('conso', 'debug', 'date week debut:'.$weekStartTime. 'fin:'.date($format, strtotime('+6 days', $weekStartTime)));
		return array('debut' => date($format, $weekStartTime), 'fin' => date($format, strtotime('+6 days', $weekStartTime)));
	}

	public static function get_lundi_vendredi_from_week($week,$date,$format="Y-m-d",$type='debut') {

		$JourEnCours = date("N",strtotime($date));
		$shiftDeb = $JourEnCours - 1;
		//log::add('conso', 'debug','get_lundi_vendredi_from_week debut:'.$date.' type:'.$type.' jourencours:'.$JourEnCours.' shiftdeb:'.$shiftDeb);
		if ($JourEnCours >= 5) {
			$shiftFin = $JourEnCours - 5;
		} 
		else {
			$shiftFin = 5 - $JourEnCours;
		}	
		$timestamp=strtotime($date)-($shiftDeb*86400);
		$timestamp_vendredi=strtotime($date)+($shiftFin*86400);
		
		/*$firstDayInYear=date("N",mktime(0,0,0,1,1,$year));
		if ($firstDayInYear<5)
		$shift=-($firstDayInYear-1)*86400;
		else
		$shift=(8-$firstDayInYear)*86400;
		if ($week>1) $weekInSeconds=($week-1)*604800; else $weekInSeconds=0;
		$timestamp=mktime(0,0,0,1,1,$year)+$weekInSeconds+$shift;
		$timestamp_vendredi=mktime(0,0,0,1,7,$year)+$weekInSeconds+$shift;*/
			
	
		if($type == "debut") {
				//log::add('conso', 'debug','get_lundi_vendredi_from_week debut:'.date($format,$timestamp));
				return  date($format,$timestamp);
		}
		else {
				//log::add('conso', 'debug','get_lundi_vendredi_from_week fin:'.date($format,$timestamp_vendredi));
				return  date($format,$timestamp_vendredi);
		}
	
	
		//	return array("Lundi " . date($format,$timestamp),"Vendredi " . date($format,$timestamp_vendredi));
	
	}


	static function getMaxIndexByEcq($eqLogicId){
		$values = array('eqLogicId' => $eqLogicId);

		$sql = 'select MAX(hchp) as max_hp , MAX(hchc) as max_hc FROM Eco_legrand_teleinfo where eqLogicId = :eqLogicId';

		return DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	}

	
	/*retourne la consommation du mois en cours par heure */
	static public function MonthPowerWeek(){
		$sql = 'SELECT * FROM Eco_legrand_jour WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) GROUP BY WEEK(date) order by timestamp';

		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
	}
	/*retourne la consommation de la semaine en cours par heure */
	static public function WeekPowerHour(){
		$sql = 'SELECT * FROM Eco_legrand_jour WHERE WEEK(date) = WEEK(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) order by timestamp';

		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
	}
	/*retourne la consommation de l annees  en cours par mois */
	static public function YearPowerMonth(){
		$sql = 'SELECT * FROM Eco_legrand_jour WHERE WEEK(date) = WEEK(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) GROUP BY YEAR(date) order by timestamp';

		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
	}

	

	public static function getTableInfoSize(){

		$sql ='SELECT table_name  AS "Table", round(((data_length + index_length) / 1024 / 1024), 2)  as size FROM information_schema.TABLES WHERE  table_name = "Eco_legrand_teleinfo";';
		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);

	}
	
	function Execute_Requete($sql, $premiere_ligne, $nom_fichier, $saut_line = true){
		global $link;
		$resultat = mysql_query($sql, $link);
		if ($resultat) {
			if (file_exists($nom_fichier)) {
				unlink($nom_fichier);
			}
			$fichier = fopen($nom_fichier, 'w+');
			fwrite($fichier, $premiere_ligne . PHP_EOL);

			while ($ligne = mysql_fetch_array($resultat)) {
				if ($saut_line) fwrite($fichier, $ligne[0] . PHP_EOL); else
					fwrite($fichier, $ligne[0] . ';');
			}
			fclose($fichier);
		}
	}

	public function DeletebyMonth($month = 0){

		if ((int)$month > 0) {

			$sql = 'delete from Eco_legrand_teleinfo where rec_date < (curdate() - interval ' . (int)$month . ' month) ';

			$cmd = 'echo "Supprime l\'historique de plus de ' . $month . ' mois \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			$cmd = 'echo "' . $sql . ' \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			$cmd = 'echo "Suppression en cours ........ \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
			$cmd = 'echo "Suppression Terminée) \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			$cmd = 'echo "[END CONSO_HISTORIQUE SUCCESS]\n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

		} else {

			$cmd = 'echo "On ne supprime pas  l\'historique de plus de ' . $month . ' mois dans la table Eco_legrand_teleinfo \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);
			$cmd = 'echo "Soit le fichier n\'existe pas soit le dump est vide \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			$cmd = 'echo "[END CONSO_HISTORIQUE ERROR]\n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

		}


	}

	public static function DumpTable($dbhost, $dbuser, $dbpass, $backup_file, $table, $type = 'sql', $path = false, $param = ''){

		$nb = 0;
		if (!$path) {
			$nb = config::byKey('keepMonth', 'conso', 0);
			if (substr(config::byKey('path', 'conso'), 0, 1) != '/') {
				$tmp = dirname(__FILE__) . '/../../' . config::byKey('path', 'conso');
			} else {
				$tmp = config::byKey('path', 'conso');
			}
		} else {
			$tmp = $path;
		}
		//mysqldump -hlocalhost -ujeedom -pb9755552f521f05 -t Eco_legrand_teleinfo -T/usr/share/nginx/www/jeedom/plugins/conso/core/class/../../ressources/backup/.historique_2015-09-21_16_38_22.sql [jeedom] --fields-enclosed-by=" --fields-terminated-by=; --where="rec_date < (curdate() - interval 6 month)"
		if(!is_dir($tmp)){
		   mkdir($tmp);
		}

		exec('sudo chmod 777 ' . $tmp);

		$where = " ";
		$where_libelle = " ";
		if ((int)$nb > 0) {
			$where = ($type != 'coco' ? " --where=\"rec_date < (curdate() - interval " . $nb . " month)\" " : "WHERE  rec_date > DATE_SUB(CURRENT_DATE(), INTERVAL " . $nb . " MONTH)");
			$where_libelle = ' de plus de ' . $nb . ' mois ';
		}


		$cmd = 'echo "***********************Historisation **************************** \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		if ($type == 'sql') {

			$cmd = 'echo "Sauvegarde en SQL \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			$backup_file = $backup_file . '_' . date("Y-m-dHis") . '.sql';
			$command = "mysqldump --opt -h$dbhost -u$dbuser -p$dbpass " . "jeedom " . $table . " " . $param . " " . $where . "  > " . $tmp . $backup_file;

			log::add('conso', 'debug', $command);

			$cmd = 'echo "Préparation de la sauvegarde ' . $where_libelle . ' (' . $tmp . $backup_file . ') \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			$cmd = 'echo "' . $command . ' \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			$cmd = 'echo "Création de la Sauvegarde en cours ........ \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			exec($command, $op, $result);

			$cmd = 'echo "Sauvegarde terminée avec Succès \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			$cmd = 'echo "[END CONSO_HISTORIQUE SUCCESS] \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

		} elseif ($type == 'csv') {
			$cmd = 'echo "Sauvegarde en CSV \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			$backup_file = $backup_file . '_' . date("Y-m-d_H_i_s") . '.csv';
			$file = $tmp . $backup_file;

			$command = "mysql -h$dbhost -u$dbuser -p$dbpass -e \"SELECT * from $table\" jeedom | sed 's/\\t/\",\"/g;s/^/\"/;s/$/\"/' > " . $tmp . $backup_file;

			$cmd = 'echo "Préparation de la sauvegarde ' . "$where_libelle" . ' (' . $tmp . $backup_file . ') \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			log::add('conso', 'debug', $command);

			$cmd = 'echo "Création de la Sauvegarde en cours ........ \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			exec($command, $op, $result);

			$cmd = 'echo "Sauvegarde terminée avec Succès  \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			$cmd = 'echo "[END CONSO_HISTORIQUE SUCCESS] \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

		} else {
			$backup_file = $backup_file . '_' . date("Y-m-d_H_i_s") . '.sql.gz';

			//$command = "mysqldump --opt -h$dbhost -u$dbuser -p$dbpass " . "jeedom " . $table . " " . $where . " | gzip > " . $tmp . $backup_file;
			$command = "mysqldump --skip-add-drop-table --no-create-info --add-locks --quick --extended-insert --lock-tables --set-charset --disable-keys -h$dbhost -u$dbuser -p$dbpass " . "jeedom " . $table . " " . $where . " | gzip > " . $tmp . $backup_file;

			log::add('conso', 'debug', $command);

			$cmd = 'echo "Sauvegarde en GZ \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			$cmd = 'echo "Préparation de la sauvegarde' . $where_libelle . ' (' . $tmp . $backup_file . ') \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			$cmd = 'echo "' . str_replace('"','\"',$command) . '\n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			$cmd = 'echo "Création de la Sauvegarde en cours ........\n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			exec($command, $op, $retour);


			if ($retour == 0) {
				$cmd = 'echo "Sauvegarde terminée avec Succès\n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
				exec($cmd);

				$cmd = 'echo "[END CONSO_HISTORIQUE SUCCESS] \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
				exec($cmd);
				return true;
			} else {
				$cmd = 'echo "POUIMMMMP -- ERRRRROOOOOR \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
				exec($cmd);

				$cmd = 'echo "[END CONSO_HISTORIQUE ERROR] \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
				exec($cmd);
				return false;
			}


		}

		//log::clear('conso_historique');
		//************Dump Fichier SQL******/
		//	$backup_file = $backup_file . '_'.date("Y-m-d-H-i-s") . '.sql';
		//	$command2 = "mysqldump --opt -h$dbhost -u$dbuser -p$dbpass ". "jeedom ".$table." --where=\"rec_date < (curdate() - interval 6 month)\"  > ".$tmp.$backup_file;
		//	exec($command2);

	}

	

	static public function getLastDateTrame(){
		
		$sql = 'select DATE_FORMAT(FROM_UNIXTIME(`timestamp`), "%d-%m-%Y %H:%i") as date from Eco_legrand_teleinfo order by timestamp DESC limit 1;';
		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}

	static public function getLastDateDay(){
		$sql = 'select DATE_FORMAT(FROM_UNIXTIME(`timestamp`), "%d-%m-%Y") as date  from Eco_legrand_jour order by timestamp DESC limit 1;';
		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}

	static public function getDateMysql(){
		
		$sql = 'select FROM_UNIXTIME(UNIX_TIMESTAMP(), "%d-%m-%Y %H:%i") as date ;';

		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}

	function gauge(){
		global $table;

		$query = "SELECT timestamp, date, time, ptec, papp, int_inst AS iinst1 FROM `$table` ORDER BY timestamp DESC LIMIT 1 ";
		$result = mysql_query($query) or die ("<b>Erreur</b> dans la requète <b>" . $query . "</b> : " . mysql_error() . " !<br>");
		$row = mysql_fetch_array($result);

		return array('gauge_watt' => intval($row["papp"]), 'gauge_date' => $row["date"], 'gauge_time' => $row["heure"], 'gauge_type' => $row["ptec"]);
	}

	


	
	
	static public function getMonthOldConso($id_ecq){
		$date = new DateTime();
		//log::add('conso', 'debug', 'getMonthOldConso ');
		$month_conso = Eco_legrand_teleinfo::get_calcul_prix($date->modify('-1 year')->format('Y-m-01'), $date->format('Y-m-t'), "mois", false, false, false, false, $id_ecq); /*Conso du mois en cours  */
		if ($month_conso !== false) {
			return Eco_legrand_teleinfo::consoResult($month_conso, 'month', $date->modify('-1 year')->format('Y-m-01'), $date->format('Y-m-t'), $id_ecq);
		} else {
			return false;
		}
	}

	

	

	static public function GetTabPie($sql_periode, $group_type = 'myid', $id_ecq = false){
		if ($sql_periode == 'hier%d%c%Y') {
			$sql_periode2 = '%d%c%Y';
			$decalage = 1;
		} else {
			$sql_periode2 = $sql_periode;
			$decalage = 0;
		}
		$eqLogics = eqLogic::byId((int)$id_ecq);
		$parent_id = $eqLogics->getConfiguration('parent_id');
		if ($parent_id) {
			$id_ecq = $parent_id;
		}
		$eqLogics = eqLogic::byId((int)$id_ecq);
		$production = false;
		//log::add('conso', 'info', 'parametre:'.$eqLogics->getConfiguration('production_sup'));
		if ($eqLogics->getConfiguration('production_sup')) {
			//log::add('conso', 'info', 'production sup true');
			$production = true;
		}

		$liste = '';
		//log::add('conso', 'debug', 'GetTabPie Requete:'.$group_type.' '.$id_ecq);
		//log::add('conso', 'debug', 'GetTabPie group type:'.$group_type.' '.$id_ecq);
		$sql = 'SELECT 	distinct id_eq  from conso_jour where id_eq > 0';
		$result = DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
		if ($result) {
			$nb_ecq = 0;
			foreach ($result as $key => $val) {
				$eqLogics = eqLogic::byId((int)$val['id_eq']);
				if($eqLogics) {
					$parent_id = $eqLogics->getConfiguration('parent_id');
					if ((int)$parent_id == $id_ecq or (int)$val['id_eq'] == $id_ecq ) {
						$nb_ecq += 1;
						if ((int)$parent_id == $id_ecq) {
							$liste = $liste.$val['id_eq'].',';
						}
					}
				}
			}
		}
		$liste = $liste.$id_ecq;


		$sql = 'SELECT
				myid AS id,
				' . ($group_type == 'myid' ? ' myname ' : ' IF(IFNULL(istotal,0)>0 ,"Total",IF(categorie="NC",myname,categorie)) ') . ' AS name_cat,
				isHCHP ,
				istotal ,
				IFNULL(SUM(shc),0) AS totalhc,
				IFNULL(SUM(shp),0) AS totalhp,
				IFNULL(ROUND(SUM(shp)+SUM(shc),2),0) AS total,

				ROUND(SUM(hcprix),2) AS  prixhc,
				ROUND(SUM(hpprix),2) AS  prixhp,
				ROUND(SUM(totalprix),2) AS prix,

				IFNULL(ROUND(SUM(shc)*100/(case WHEN (SUM(shc)+SUM(shp)) > (res.totalhc+res.totalhp) THEN (SUM(shc)+SUM(shp)) ELSE (res.totalhc+res.totalhp) END),2),0) AS total_percent_ecq_hc,
				IFNULL(ROUND(SUM(shp)*100/(case WHEN (SUM(shc)+SUM(shp)) > (res.totalhc+res.totalhp) THEN (SUM(shc)+SUM(shp)) ELSE (res.totalhc+res.totalhp) END),2),0) AS total_percent_ecq_hp,
				IFNULL(SUM(shc)*100/(SUM(shp)+SUM(shc)),0) AS percent_ecq_hc,
				IFNULL(SUM(shp)*100/(SUM(shp)+SUM(shc)),0) AS percent_ecq_hp,

				IFNULL(ROUND((SUM(shc)+SUM(shp))*100/ (case WHEN (SUM(shc)+SUM(shp)) > (res.totalhc+res.totalhp) THEN (SUM(shc)+SUM(shp)) ELSE (res.totalhc+res.totalhp) END),2),0) AS percent_ecq_reel,
				IFNULL(ROUND((SUM(shc)+SUM(shp))*100/ (res.totalhc+res.totalhp),2),0) AS percent_ecq,
				myid
			FROM (
				SELECT
					CASE
						WHEN configuration  like  \'%"visibleConsumptionLight":"1"%\' THEN "Lumieres"
						WHEN configuration  like  \'%"visibleConsumptionElectrical":"1"%\' THEN "Electromenager"
						WHEN configuration  like  \'%"visibleConsumptionAutomatism":"1"%\' THEN "Automatisme"
						WHEN configuration  like  \'%"visibleConsumptionHeating":"1"%\' THEN "Chauffage"
						WHEN configuration  like  \'%"visibleConsumptionMultimedia":"1"%\' THEN "Multimedia"
						WHEN configuration  LIKE  \'%"visibleConsumptionVehicules":"1"%\' THEN "Véhicules"
						WHEN configuration  LIKE  \'%"visibleConsumptionHardware":"1"%\' THEN "Mat. Informatique"
						WHEN configuration  LIKE  \'%"visibleConsumptionAirConditioner":"1"%\' THEN "Climatisation"
						WHEN configuration  LIKE  \'%"visibleConsumptionSwimmingPool":"1"%\' THEN "Piscine"
						WHEN configuration  LIKE  \'%"visibleConsumptionAutomation":"1"%\' THEN "Domotique"
						WHEN configuration  LIKE  \'%"visibleConsumptionOther":"1"%\' THEN "Autres"
						ELSE "NC"
					END as categorie,
				id AS myid,
				IF(INSTR(configuration, \'"type_abo":"HCHP"\' )>0 , 1 , 0 ) AS isHCHP ,
				IF(INSTR(configuration, \'"total":"1"\' )>0 , 1 , 0 ) AS istotal ,
				NAME AS myname,
				/* MIN(j.rec_date) AS DATE,*/
				periode,
				hc AS shc,
				hp AS shp,
				totalhp,
				totalhc,
				prix_hc * hc AS hcprix,
				prix_hp * hp AS hpprix,
				(prix_hc * hc) + (prix_hp * hp)  AS totalprix,
				DATE_FORMAT(j.`rec_date`,"' . $sql_periode2 . '") AS mois,
				j.`rec_date`,
				p.id_eq
				FROM conso_jour j
				INNER JOIN
				(
					SELECT jo.id_eq,
					DATE_FORMAT(jo.`rec_date`,"' . $sql_periode2 . '"),
					jo.rec_date,
					SUM(hp) AS totalhp,
					SUM(hc) AS totalhc,
					(SELECT FORMAT(hc,4) AS hc FROM conso_price  WHERE type_ecq LIKE "%elect%" AND UNIX_TIMESTAMP(DATE_FORMAT(jo.rec_date , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP( DATE_FORMAT( date_debut,  "%Y-%m-%d" ) ) AND UNIX_TIMESTAMP( DATE_FORMAT( date_fin,  "%Y-%m-%d" ) ) LIMIT 0,1) AS prix_hc,
					(SELECT FORMAT(hp,4) AS hc FROM conso_price  WHERE type_ecq LIKE "%elect%" AND UNIX_TIMESTAMP(DATE_FORMAT(jo.rec_date , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP( DATE_FORMAT( date_debut,  "%Y-%m-%d" ) ) AND UNIX_TIMESTAMP( DATE_FORMAT( date_fin,  "%Y-%m-%d" ) ) LIMIT 0,1 ) AS prix_hp
					FROM
						conso_jour jo
					INNER JOIN
						eqLogic eqc ON eqc.id = jo.id_eq
					WHERE
						jo.id_eq in ('.$liste.') and
						DATE_FORMAT(jo.`rec_date`,"' . $sql_periode2 . '")  = DATE_FORMAT(CURDATE()- INTERVAL '.$decalage.' DAY,"' . $sql_periode2 . '")
						AND   configuration LIKE "%elect%"
						AND configuration LIKE \'%"total":"1"%\'
					GROUP BY
						DATE_FORMAT(jo.`rec_date`,"' . $sql_periode2 . '"), jo.id_eq
				    ) AS p ON DATE_FORMAT(p.`rec_date`,"' . $sql_periode2 . '") = DATE_FORMAT(j.`rec_date`,"' . $sql_periode2 . '")

				INNER JOIN eqLogic eq ON eq.id = j.id_eq AND isEnable = 1
				WHERE
				j.id_eq in ('.$liste.') and
				DATE_FORMAT(j.`rec_date`,"' . $sql_periode2 . '")  = DATE_FORMAT(CURDATE()- INTERVAL '.$decalage.' DAY,"' . $sql_periode2 . '")  AND
				configuration LIKE "%elect%"
				/* GROUP BY  j.id_eq*/
			) AS res
			 GROUP BY  DATE_FORMAT(res.`rec_date`,"' . $sql_periode2 . '"), name_cat ORDER BY istotal DESC ';
		//log::add('conso', 'debug', 'GetTabPie Requete:'.$sql);
		$result = DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
		if ($result) {
			$other_total = 0;
			$other_hp = 0;
			$other_hc = 0;
			$total_hp = 0;
			$total_hc = 0;
			$total = 0;

			$prix_hp = 0;
			$prix_hc = 0;
			$prix = 0;

			$nb_total = 0;
			$totalkey = -1;
			$ishphc = false;

			foreach ($result as $key => $val) {

				//$eqLogics = eqLogic::byId((int)$val['id']);
				//$parent_id = $eqLogics->getConfiguration('parent_id');
				//log::add('conso', 'debug', 'GetTabPie parent_id:'.$parent_id.' id:'.$val['id'].' result0 id:'.$result[0]['id']);
				/*if ((int)$parent_id == $id_ecq or (int)$val['id'] == $id_ecq ) {
					$nb_ecq += 1;
				}*/
				if ((int)$val['istotal'] > 0) {
					//log::add('conso', 'debug', 'GetTabPie total id:'.$val['id']);
					$nb_total += 1;
					$totalkey = $key;
				} else {
					//Il ne faut prendre que les equipements qui on comme pere le total.
					//log::add('conso', 'debug', 'GetTabPie detail avant id:'.$val['id']);
					//if ((int)$parent_id == $id_ecq) {
						//log::add('conso', 'debug', 'GetTabPie detail id:'.$val['id']);
						$tab['info']['categories'][] = $val['name_cat'];
						if ((int)$val['isHCHP'] > 0) $ishphc = true;
						/*Calcul pour connaitre le delta avec le total si il est connu*/
						$other_total += $val['percent_ecq'];
						$other_hp += $val['percent_ecq_hp'];
						$other_hc += $val['percent_ecq_hc'];

						$total_hp += $val['totalhp'];
						$total_hc += $val['totalhc'];
						$total += $val['total'];

						$prix_hp += $val['prixhp'];
						$prix_hc += $val['prixhc'];
						$prix += $val['prix'];

						/**********************/

						$tab['categorie'][$val['name_cat']] = array(
															'percent_hp' => (float)$val['percent_ecq_hp'],
															'percent_hc' => (float)$val['percent_ecq_hc'],
															'prix_hp' => (float)$val['prixhp'],
															'prix_hc' => (float)$val['prixhc'],
															'conso_hc' => (float)$val['totalhc'],
															'conso_hp' => (float)$val['totalhp']);

							$tab['detail'][] = array('name' => $val['name_cat'], 'percent' => (float)$val['percent_ecq_reel'], 'tooltip_data' => (((float)$result[$totalkey]['percent_ecq'] - (float)$other_total) < 0 ? $total : (float)$val['total']),
							'drilldown' => array('categories' => ((int)$val['isHCHP'] > 0 ? ['HP', 'HC'] : ['HB']),
								'data' => ((int)$val['isHCHP'] > 0 ?
									[(float)$val['total_percent_ecq_hp'],(float)$val['total_percent_ecq_hc']] :
									[(float)$val['total_percent_ecq_hp']]),
								'color' => ((int)$val['isHCHP'] > 0 ? ['#AA4643', '#4572A7'] : ['#AA4643']),
								'tooltip_data' => ($ishphc ? ['Conso : ' . (((float)$result[$totalkey]['percent_ecq'] - (float)$other_total) < 0 ? $total_hp : (float)$val['totalhp']) . 'kWh<br>Prix : ' . (((float)$result[$totalkey]['percent_ecq'] - (float)$other_total) < 0 ? $prix_hp : (float)$val['prixhp']) .config::byKey('Devise', 'conso'), 'Conso : ' . (((float)$result[$totalkey]['percent_ecq'] - (float)$other_total) < 0 ? $total_hc : (float)$val['totalhc']) . 'kWh<br>Prix : ' . (((float)$result[$totalkey]['percent_ecq'] - (float)$other_total) < 0 ? $prix_hc : (float)$val['prixhc']) . config::byKey('Devise', 'conso')] : ['Conso : ' . (((float)$result[$totalkey]['percent_ecq'] - (float)$other_total) < 0 ? $total : (float)$val['total']) . 'Kwh<br>Prix : ' . (((float)$result[$totalkey]['percent_ecq'] - (float)$other_total) < 0 ? $prix : (float)$val['prix']) . config::byKey('Devise', 'conso')])));
					//	}
				}
			}

			if ($totalkey >= 0) {

				if(((float)$result[$totalkey]['percent_ecq'] - (float)$other_total) < 0){
					if ($production) {
						// On prend la somme des enfants si consommation > à celle du père et que la case production est coché
						$result[$totalkey]['percent_ecq'] = 100;
						$result[$totalkey]['percent_ecq_hp'] = $other_hp;
						$result[$totalkey]['percent_ecq_hc'] = $other_hc;
						$result[$totalkey]['prixhp'] = $prix_hp;
						$result[$totalkey]['prixhc'] = $prix_hc;
						$result[$totalkey]['totalhc'] = $total_hc;
						$result[$totalkey]['totalhp'] = $total_hp;
					}
					ELSE {
						switch ($sql_periode) {
							case "%c%Y":
								$periode = "mois";
								break;
							case "%Y":
								$periode = "année";
								break;
							case "%v%c%Y":
								$periode = "semaine";
								break;
							case "hier%d%c%Y":
								$periode = "hier";
								break;
							case "%d%c%Y":
								$periode = "jour";
								break;
						}
						log::add('conso', 'error', 'La somme des sous-équipements est supérieure au total de l\'équipement père pour la période '.$periode.'. Le camembert ne peut plus être affiché. Total père: '.$result[$totalkey]['percent_ecq'].'% Total sous-équipements: '.$other_total.'%');
						$tab['nb_equipement'] = 1;

						$tab['havetotal'] = $nb_total;
						$tab['retour'] = 'ok';
						$tab['other'] = 'no'; //ne pas afficher le camembert
						return $tab;
					}
				}

				$tab['info']['categories'][] = 'Indéfini';
				$tab['categorie']['Indéfini'] = array(
					'percent_hp' =>(float)($result[$totalkey]['totalhc'] + $result[$totalkey]['totalhp'] - $total_hp - $total_hc == 0 ? 0 : (((float)$result[$totalkey]['totalhp'] - (float)$total_hp) * 100) / ($result[$totalkey]['totalhc'] + $result[$totalkey]['totalhp'] - $total_hp - $total_hc)), //((float)$result[$totalkey]['percent_ecq'] - (float)$other_total),
					'percent_hc' =>(float)($result[$totalkey]['totalhc'] + $result[$totalkey]['totalhp'] - $total_hp - $total_hc == 0 ? 0 : (((float)$result[$totalkey]['totalhc'] - (float)$total_hc) * 100) / ($result[$totalkey]['totalhc'] + $result[$totalkey]['totalhp'] - $total_hp - $total_hc)), //((float)$result[$totalkey]['percent_ecq'] - (float)$other_total),
					'prix_hp' => ((float)$result[$totalkey]['prixhp'] - (float)$prix_hp),
					'prix_hc' => ((float)$result[$totalkey]['prixhc'] - (float)$prix_hc),
					'conso_hc' => ((float)$result[$totalkey]['totalhc'] - (float)$total_hc),
					'conso_hp' => ((float)$result[$totalkey]['totalhp'] - (float)$total_hp));
					log::add('conso', 'debug', 'GetTabpie id:'.$result[$totalkey]['id'].' Total HC:'.$result[$totalkey]['totalhc'].' Total HP:'.$result[$totalkey]['totalhp']);
					$tab['detail'][] = array('name' => 'Non relevé - ' . $result[$totalkey]['name_cat'],
														'percent' => (float)$result[(float)$totalkey]['percent_ecq'] - (float)$other_total,
														'tooltip_data' =>  (float)$result[$totalkey]['total'],
														'drilldown' => array(
														'categories' => ($ishphc ? ['HP', 'HC'] : ['HB']),
														'data' => ($ishphc ? [	(float)(($result[$totalkey]['totalhp'] - $total_hp) * 100) / ($result[$totalkey]['totalhc'] + $result[$totalkey]['totalhp'] == 0 ? 0.1 : $result[$totalkey]['totalhc'] + $result[$totalkey]['totalhp']),
																(float)(($result[$totalkey]['totalhc'] - $total_hc) * 100) / ($result[$totalkey]['totalhc'] + $result[$totalkey]['totalhp'] == 0 ? 0.1 : $result[$totalkey]['totalhc'] + $result[$totalkey]['totalhp'])] :
																[(float)(($result[$totalkey]['totalhp'] - $total_hp) * 100) / ($result[$totalkey]['totalhp'] == 0 ? 0.1 :$result[$totalkey]['totalhp'])]),
																	'color' => ($ishphc ? ['#AA4643', '#4572A7'] : ['#AA4643']), 'tooltip_data' => ($ishphc ? ['Conso : ' . ((float)$result[$totalkey]['totalhp'] - (float)$total_hp) . 'Kwh
																	<br>Prix : ' . ((float)$result[$totalkey]['prixhp'] - (float)$prix_hp) . config::byKey('Devise', 'conso'), 'Conso : ' . ((float)$result[$totalkey]['totalhc'] - (float)$total_hc) . 'Kwh
																	<br>Prix : ' . ((float)$result[$totalkey]['prixhc'] - (float)$prix_hc) . config::byKey('Devise', 'conso')] : ['Conso : ' . ((float)$result[$totalkey]['total'] - (float)$total) . 'Kwh
																	<br>Prix : ' . ((float)$result[$totalkey]['prix'] - (float)$prix) . config::byKey('Devise', 'conso')])));
			}
			$tab['retour'] = 'ok';
			$tab['havetotal'] = $nb_total;
			$tab['abonnement'] = ($ishphc ? 'HCHP' : 'HB');
			$tab['nb_equipement'] = $nb_ecq;
			$tab['other'] = 'visible';
			log::add('conso', 'debug', 'GetTabPie Equipement:'.$nb_ecq);
			return $tab;

		} else{
			$tab['havetotal'] = 0;
			$tab['retour'] = 'ko';
			$tab['other'] = 'hidden';
			}

		return $tab;
	}

	static public function GetPie($periode = 'all', $type = 'myid', $id_ecq = false){

		switch ($periode) {
			case "mois":
				$sql_periode = "%c%Y";
				break;
			case "annee":
				$sql_periode = "%Y";
				break;
			case "semaine":
				$sql_periode = "%v%c%Y";
				break;
			case "hier":
				$sql_periode = "hier%d%c%Y";
				break;
			case "jour":
				$sql_periode = "%d%c%Y";
				break;
		}
		//log::add('conso', 'debug', 'GetPie Equipement:'.$periode.' '.$id_ecq);
		if ($periode == 'all') {

			$tabresult = array();

			$tabresult['jour'] = self::GetTabPie("%d%c%Y", $type, $id_ecq);
			$tabresult['hier'] = self::GetTabPie("hier%d%c%Y", $type, $id_ecq);
			$tabresult['mois'] = self::GetTabPie("%c%Y", $type, $id_ecq);
			$tabresult['semaine'] = self::GetTabPie("%v%c%Y", $type, $id_ecq);
			$tabresult['annee'] = self::GetTabPie("%Y", $type, $id_ecq);

			return $tabresult;

		} else {
			return self::GetTabPie($sql_periode, 'myid', $id_ecq);
		}
	}

	static public function getSyntheseByMonth($type = 'electricity'){

		$sql = 'SELECT id_eq,
					MIN(NULLIF(temp_min,0)) as temp_min ,
					MAX(temp_max) as temp_max ,
					AVG(NULLIF(temp_moy,0)) as temp_moy ,
					concat(id_eq, " ",name, " (" ,
					CASE
						WHEN configuration  LIKE  \'%"visibleConsumptionLight":"1"%\' THEN "Lumieres"
						WHEN configuration  LIKE  \'%"visibleConsumptionElectrical":"1"%\' THEN "Electromenager"
						WHEN configuration  LIKE  \'%"visibleConsumptionAutomatism":"1"%\' THEN "Automatisme"
						WHEN configuration  LIKE  \'%"visibleConsumptionHeating":"1"%\' THEN "Chauffage"
						WHEN configuration  LIKE  \'%"visibleConsumptionMultimedia":"1"%\' THEN "Multimedia"
						WHEN configuration  LIKE  \'%"visibleConsumptionVehicules":"1"%\' THEN "Véhicules"
						WHEN configuration  LIKE  \'%"visibleConsumptionHardware":"1"%\' THEN "Mat. Informatique"
						WHEN configuration  LIKE  \'%"visibleConsumptionAirConditioner":"1"%\' THEN "Climatisation"
						WHEN configuration  LIKE  \'%"visibleConsumptionSwimmingPool":"1"%\' THEN "Piscine"
						WHEN configuration  LIKE  \'%"visibleConsumptionAutomation":"1"%\' THEN "Domotique"
						ELSE "Autres"
						END, ")"
					) as name,
					"non" AS id_parent,
					`timestamp`,
					min(rec_date) as rec_date,
					min(rec_date) AS cat_jours,
					DATE_FORMAT(s.`rec_date`,"%Y") AS annee,
					DATE_FORMAT(s.`rec_date`,"%c") AS mois,
					DATE_FORMAT(s.`rec_date`,"%e") AS jour,
					DATE_FORMAT(s.`rec_date`,"%e") AS hier,
					DATE_FORMAT(s.`rec_date`,"%v") AS semaine,
					DATE_FORMAT(s.`rec_date`,"sem %v %y") AS cat_semaine,
					DATE_FORMAT(s.`rec_date`,"%M %y") AS cat_month,
					DATE_FORMAT(s.`rec_date`,"%y") AS cat_anne,
					CASE
					WHEN configuration  LIKE  \'%"visibleConsumptionLight":"1"%\' THEN "Lumieres"
					WHEN configuration  LIKE  \'%"visibleConsumptionElectrical":"1"%\' THEN "Electromenager"
					WHEN configuration  LIKE  \'%"visibleConsumptionAutomatism":"1"%\' THEN "Automatisme"
					WHEN configuration  LIKE  \'%"visibleConsumptionHeating":"1"%\' THEN "Chauffage"
					WHEN configuration  LIKE  \'%"visibleConsumptionMultimedia":"1"%\' THEN "Multimedia"
					WHEN configuration  LIKE  \'%"visibleConsumptionVehicules":"1"%\' THEN "Véhicules"
					WHEN configuration  LIKE  \'%"visibleConsumptionHardware":"1"%\' THEN "Mat. Informatique"
					WHEN configuration  LIKE  \'%"visibleConsumptionAirConditioner":"1"%\' THEN "Climatisation"
					WHEN configuration  LIKE  \'%"visibleConsumptionSwimmingPool":"1"%\' THEN "Piscine"
					WHEN configuration  LIKE  \'%"visibleConsumptionAutomation":"1"%\' THEN "Domotique"
					ELSE "Autres"
					END AS categorie,
					CASE WHEN "'.$type.'" in ("water","oil","gaz") then ROUND(SUM(s.hp/1000),3) ELSE ROUND(SUM(s.hp),2) END AS hp,
					CASE WHEN "'.$type.'" in ("water","oil","gaz") then 0 ELSE ROUND(SUM(s.hc),2) END AS hc,
					(SELECT SUM(FORMAT(montant,2) * (1 + cst.valeur/100)) AS abo FROM conso_abo aa INNER JOIN conso_tva cst on cst.id = aa.id_tva where type_ecq like "'.$type.'" AND UNIX_TIMESTAMP(DATE_FORMAT(rec_date , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP( DATE_FORMAT( aa.date_debut,  "%Y-%m-%d" ) ) AND UNIX_TIMESTAMP( DATE_FORMAT( aa.date_fin,  "%Y-%m-%d" ) ) ) as abonnement,
					(SELECT cst.valeur tva_abo FROM conso_abo aa INNER JOIN conso_tva cst ON cst.id = aa.id_tva WHERE type_ecq LIKE "electricity%" AND UNIX_TIMESTAMP(DATE_FORMAT(rec_date , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP( DATE_FORMAT( aa.date_debut,  "%Y-%m-%d" ) ) AND UNIX_TIMESTAMP( DATE_FORMAT( aa.date_fin,  "%Y-%m-%d" ) ) LIMIT 0,1 ) AS tva_abo,
					(SELECT ROUND(SUM(FORMAT(hc,4)),4) AS hc FROM conso_price  WHERE type_ecq LIKE "'.$type.'" AND `rec_date` BETWEEN `date_debut` AND `date_fin` ) AS prix_hc,
					(SELECT ROUND(SUM(FORMAT(hp,4)),4) AS hc FROM conso_price  WHERE type_ecq LIKE "'.$type.'" AND `rec_date` BETWEEN `date_debut` AND `date_fin` ) AS prix_hp,
					(SELECT  CASE WHEN "'.$type.'" in ("water","oil") THEN 5.5 ELSE FORMAT(valeur ,2) END FROM conso_tva WHERE `rec_date` BETWEEN `date_debut` AND `date_fin` and global = 1 LIMIT 0,1) AS tva,
					ROUND(SUM((SELECT SUM(FORMAT(hc,4)) FROM conso_price WHERE  type_ecq LIKE "'.$type.'" AND `rec_date` BETWEEN `date_debut` AND `date_fin`  ) * CASE WHEN "'.$type.'" in ("water","oil","gaz") then 0 ELSE s.hc END),2) AS total_hc,
					CASE WHEN "'.$type.'" = "gaz" THEN ROUND(SUM((SELECT SUM(FORMAT(hp,4)*hc) FROM conso_price WHERE  type_ecq LIKE "'.$type.'" AND `rec_date` BETWEEN `date_debut` AND `date_fin`  ) * s.hp/1000) ,2)
					                              ELSE ROUND(SUM((SELECT SUM(FORMAT(hp,4)) FROM conso_price WHERE  type_ecq LIKE "'.$type.'" AND `rec_date` BETWEEN `date_debut` AND `date_fin`  ) * CASE WHEN "'.$type.'" in ("water","oil","gaz") then s.hp/1000 ELSE s.hp END),2) END AS total_hp,
					0 as kwh
					FROM  conso_jour s
					INNER JOIN eqLogic eqc ON eqc.id = s.id_eq

					WHERE /*id_eq = 13*/ isEnable = 1  AND  eqc.configuration LIKE \'%"type":"'.$type.'"%\' AND  (
					 `rec_date` BETWEEN DATE_SUB(CURRENT_DATE(), INTERVAL 1 YEAR)   AND CURRENT_DATE()  )
					GROUP BY   id_eq,cat_month ORDER BY id_eq,rec_date DESC';
		//log::add('conso', 'debug', 'requete synthese par mois:'.$sql);
		$result = DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
		$details = array();

		foreach ($result as $key => &$row) {
			$details[$key] = self::consoResult(array($row), 'month', date("Y-m", strtotime($row['rec_date'])).'-01', date("Y-m-t", strtotime($row['rec_date'])), $row['id_eq']);
			$details[$key]['id_eq'] = $row['id_eq'];
			$details[$key]['name'] = $row['name'];
			$details[$key]['id_parent'] = $row['id_parent'];
			$details[$key]['cat_month'] = $row['cat_month'];
			$details[$key]['abonnement'] = $row['abonnement'];
			$details[$key]['tva'] = $row['tva'];
			$details[$key]['tva_abo'] = $row['tva_abo'];
			$details[$key]['prix_hc'] = $row['prix_hc'];
			$details[$key]['prix_hp'] = $row['prix_hp'];
			$details[$key]['temp_min'] = $row['temp_min'];
			$details[$key]['temp_max'] = $row['temp_max'];
			$details[$key]['temp_moy'] = $row['temp_moy'];
			$details[$key]['kwh'] = $row['kwh'];
		}

		if ($result) {
			return $details;
		} else return false;
	}
}
