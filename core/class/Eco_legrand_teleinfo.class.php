<?php
require_once dirname(__FILE__) . '/../../core/php/Eco_legrand.inc.php';

class Eco_legrand_teleinfo
{

	public $timestamp;
	public $date;
	public $heure;
	public $index_hp;
	public $index_hc;
	public $ptec;
	public $int_instant = 0;
	public $puissance_totale = 0;
	public $index_total;
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
	public $temperature;
	public $Eqlogic_ID;
	
// gettteur	
	public function get_timestamp() { return $this->timestamp; }

	public function get_date() { return $this->date; }

	public function get_heure() { return $this->heure; }

	public function get_index_hp() { return (float)$this->index_hp; }

	public function get__index_hc() { return (float)$this->index_hc; }

	public function get_ptec() { return $this->ptec; }

	public function get_int_instant() { return (float)$this->int_instant; }

	public function get_puissance_totale() { return (int)$this->puissance_totale; }

	public function get_index_circuit1() { return (int)$this->index_circuit1; }

	public function get_index_circuit2() { return (int)$this->index_circuit2; }

	public function get_index_circuit3() { return (int)$this->index_circuit3; }

	public function get_index_circuit4() { return (int)$this->index_circuit4; }

	public function get_index_circuit5() { return (int)$this->index_circuit5; }

	public function get_inst_circuit1() { return (int)$this->inst_circuit1; }

	public function get_inst_circuit2() { return (int)$this->inst_circuit2; }

	public function get_inst_circuit3() { return (int)$this->inst_circuit3; }

	public function get_inst_circuit4() { return (int)$this->inst_circuit4; }

	public function get_inst_circuit5() { return (int)$this->inst_circuit5; }

	public function get_index_pulse1() { return (int)$this->index_pulse1; }

	public function get_index_pulse2() { return (int)$this->index_pulse2; }

	public function get_inst_pulse1() { return (int)$this->inst_pulse1; }

	public function get_inst_pulse2() { return (int)$this->inst_pulse2; }
		
	public function get_Eqlogic_ID() { return $this->Eqlogic_ID; }

	public function get_temperature() { return (float)$this->temperature; }
//


//  setteur
	public function set_timestamp($data) { return $this->timestamp = $data;}

	public function set_date($data) { return $this->date = $data;}

	public function set_heure($data) { return $this->heure = $data; }

	public function set_index_hp($data) { return $this->index_hp = $data; }

	public function set_index_hc($data) { return $this->index_hc = $data;}

	public function set_ptec($data) {return $this->ptec = $data; }

	public function set_int_instant($data) { return $this->int_instant = $data;}

	public function set_puissance_totale($data) { return $this->puissance_totale = $data;}

	public function set_index_circuit1($data) { return $this->index_circuit1 = $data;}

	public function set_index_circuit2($data) { return $this->index_circuit2 = $data; }

	public function set_index_circuit3($data) { return $this->index_circuit3 = $data; }

	public function set_index_circuit4($data) { return $this->index_circuit4 = $data; }

	public function set_index_circuit5($data) {return $this->index_circuit5 = $data; }

	public function set_inst_circuit1($data) { return $this->inst_circuit1 = $data; }

	public function set_inst_circuit2($data) { return $this->inst_circuit2 = $data;}

	public function set_inst_circuit3($data) { return $this->inst_circuit3 = $data;}

	public function set_inst_circuit4($data) { return $this->inst_circuit4 = $data;}

	public function set_inst_circuit5($data) { return $this->inst_circuit5 = $data;}

	public function set_index_pulse1($data) { return $this->index_pulse1 = $data;}

	public function set_index_pulse2($data) { return $this->index_pulse2 = $data;}

	public function set_inst_pulse1($data) { return $this->inst_pulse1 = $data;}

	public function set_inst_pulse2($data) {return $this->inst_pulse2 = $data;}
		
	public function set_Eqlogic_ID($data) { return $this->Eqlogic_ID = $data;}

	public function set_temperature($data) { return $this->temperature = $data;}
	
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
			case "Eqlogic_ID":
				return $this->Eqlogic_ID = $data;
				break;
			case "temperature":
				return $this->temperature = $data;
				break;
			case "index_total":
				return $this->index_total = $data;
				break;
		}
	}
//
	
	public static function byId($_id){
		$values = array('id' => $_id);
		$sql = 'SELECT ' . DB::buildField(__CLASS__) . 'FROM Eco_legrand_teleinfo WHERE timestamp=:id';

		return DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW, PDO::FETCH_CLASS, __CLASS__);
	}

	static function getMaxIndexByEcq($id_ecq){
		$values = array('id_equipement' => $id_ecq);

		$sql = 'select MAX(hchp) as max_hp , MAX(hchc) as max_hc FROM Eco_legrand_teleinfo where id_equipement = :id_equipement';

		return DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	}

	/*public function save($power=false , $consommation = false, $day = false,$hchp_unity = '',$confConso){

		//$day permet de creer la derniere Trame du jour et la premiere trame du lendemain
		if ($day) {
			//Force le dernier relevé du jour
			$rec_date = date('Y-m-d', strtotime("-1 day"));
			$rec_time = date('23:59:59');
			$timestamp = strtotime($rec_date . ' ' . $rec_time);
			$this->settimestamp($timestamp);
			$this->setrec_date($rec_date);
			$this->setrec_time($rec_time);
			if ($consommation || $power) {
				//log::add('conso_trame', 'debug', '(' . $conso->getId() . ') Mode  POWER Je n ai que la puissance de mon équipement activé.');
				Eco_legrand_teleinfo::SaveConsommation($this,$hchp_unity,$confConso,$power); //Si consommation alors il faut gerer la coupure de courant
			} else {
				DB::save($this, false, true);
			}
			//Force le premier relevé du lendemain
			$rec_date = date('Y-m-d');
			$rec_time = date('00:00:00');
			$timestamp = strtotime($rec_date . ' ' . $rec_time);
			$this->settimestamp($timestamp);
			$this->setrec_date($rec_date);
			$this->setrec_time($rec_time);

			if ($consommation || $power) {
				return Eco_legrand_teleinfo::SaveConsommation($this,$hchp_unity,$confConso,$power);
			} else {
				return DB::save($this, false, true);
			}

		} else {
			//Sauvegarde du deamon
			if ($consommation  || $power) {
				return Eco_legrand_teleinfo::SaveConsommation($this,$hchp_unity,$confConso,$power); //Si consommation alors il faut gerer la coupure de courant
			} else {
				return DB::save($this, false, true);
			}
		}
	}*/
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
				return DB::save($this, false, true);
			}

		} else {
			return DB::save($this, false, true);
			
		}
	}
	static public function GetLast($obj){

		$sql = 'SELECT * from conso_tmp   where id_ecq = ' . $obj->id_equipement;

		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);

	}

	static public function DeleteLineConfiguration($id_ecq){

		log::add('conso_correcteur', 'debug', 'Suppression dans le log Conso_Configuration');
			$path =  log::getPathToLog('Conso_Configuration');//recuperation des valeurs dans le log
			//Supprimer la valeur dans le log Conso_Configuration
			$tab_configuration = @file($path);//== Récupérer données dans le tableau
			if($tab_configuration!==false){//verifier si le fichier existe
				foreach( $tab_configuration as $key => $line )
				{
				if (strpos(trim($line),  '|HP_'.$id_ecq.'_') !== FALSE) {
				unset($tab_configuration[$key]);
				}

				if (strpos(trim($line),  '|HC_'.$id_ecq.'_') !== FALSE) {
				unset($tab_configuration[$key]);
				}

				}
				file_put_contents($path,implode("\n", $tab_configuration));
				log::add('conso_correcteur', 'debug', 'Suppression de la ligne |HP_'.$id_ecq.'_ dans le log Conso_Configuration');
				log::add('conso_correcteur', 'debug', 'Suppression de la ligne |HC_'.$id_ecq.'_ dans le log Conso_Configuration');

			}
	}

	static public function  CorrectMyData($debut=false,$fin=false,$id_ecq=false,$operator=false,$value=false,$column=false,$mode=false){

		if($id_ecq=='' || $id_ecq===false) return ;

		$set = '';
		if($mode=='correct'){//Je souhaite corriger une période

			switch ($column) {
			    case "hchp&hchc":
			        $set = 'hchp = hchp'.$operator.$value.' , hchc = hchc'.$operator.$value;
			        $setTmp = 'hp = hp'.$operator.$value.' , hc = hc'.$operator.$value;
			        break;
			    case "hchp":
			        $set = 'hchp = hchp'.$operator.$value;
			        $setTmp = 'hp = hp'.$operator.$value;
			        break;
			    case "hchc":
			        $set = 'hchc = hchc'.$operator.$value;
			        $setTmp = 'hc = hc'.$operator.$value;
			        break;
			}

			$where = '';
			$sql_tmp = false;

			if($fin=='' || $fin === false){
					$where = ' AND timestamp >= '.(int)$debut;
					$sql_tmp = 'update   conso_tmp set '.$setTmp.' where id_ecq = '.$id_ecq;//Supprime la valeur dans conso_tmp
					log::add('conso_correcteur', 'debug', $sql_tmp);
					DB::Prepare($sql_tmp, array(), DB::FETCH_TYPE_ROW);
					Eco_legrand_teleinfo::DeleteLineConfiguration($id_ecq);//Supprimer la valeur dans le log Conso_Configuration
			}else{
				$where = ' AND  timestamp >= '.(int)$debut.' AND timestamp <= '.(int)$fin;
			}

			$sql = 'Update Eco_legrand_teleinfo SET '.$set.' where id_equipement = '.$id_ecq.$where;
			log::add('conso_correcteur', 'debug', $sql);
			DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);

			/*Mise jour de la table conso_tmp*/
			//$sqltmp = 'update conso_tmp set hp = , hc = where id_ecq = '.$id_ecq;
		}
	}

	static public function SaveConsommation($obj,$hchp_unity=1000,$confConso,$power){
		Eco_legrand_teleinfo::checkdateMysql();
		log::add('conso_trame_module', 'debug', '--------------EQUIPEMENT : '.$obj->id_equipement.'-------------------------------- ');
		log::add('conso', 'debug', '--------------EQUIPEMENT : '.$obj->id_equipement.'-------------------------------- ');

        $mode_variation = config::save('mode_variation',config::byKey('mode_variation','conso',false), 'conso');
        $mode_puissance = config::save('mode_puissance',config::byKey('mode_puissance','conso', false), 'conso');

		log::add('conso_trame_module', 'debug', 'Mode puissance uniquement activé :  ' .($mode_puissance ? 'Oui' : 'Non'));
		log::add('conso_trame_module', 'debug', 'Mode Variation uniquement activé :  ' .($mode_variation ? 'Oui' : 'Non'));
		log::add('conso', 'debug', 'Mode puissance uniquement activé :  ' .($mode_puissance ? 'Oui' : 'Non'));
		log::add('conso', 'debug', 'Mode Variation uniquement activé :  ' .($mode_variation ? 'Oui' : 'Non'));

		$etat = (isset($confConso['etat']) ? $confConso['etat'] : '');

		if($confConso['papp'] != "" && $etat != '' && $power) {
			$conso = $obj->papp ;
		}else {

				$conso_tmp = $obj->hchp * $hchp_unity;
				$conso = (int)$conso_tmp;
		}

		if($mode_puissance){
			if($obj->papp > 50000 ) return ;//ici ajouter le parametre dans la config.

		}
		$type = ($obj->ptec == "HC" ? 'hc' : 'hp'); /**/
		$lastvalue = 0;
		$variation = 0;
		$tmp_value = 0;

		if ($last = Eco_legrand_teleinfo::GetLast($obj)) {

			/***********************************************************/
			/*calcul de la conso en fonction de la puissance*/
			/***********************************************************/

			if($confConso['papp'] != "" && $etat != '' && $power){
				log::add('conso_trame_module', 'debug', '--------------Calcul de la conso en fonction de la puissance-------------------------------- ');
				log::add('conso', 'debug', '--------------Calcul de la conso en fonction de la puissance-------------------------------- ');
				$etat = jeedom::evaluateExpression($etat);
				$obj->setpapp($etat*(int)$obj->papp);
				if($etat > 0) {
					$variation = (($obj->papp * (strtotime('now') - strtotime($last['date_upd']))) / 3600); /// 1000; donne un résultat W.s ->donne un résultat W.h ->donne un résultat kW.h
					log::add('conso_trame_module', 'debug', 'Puissance :' .jeedom::evaluateExpression($confConso['papp']));
					log::add('conso_trame_module', 'debug', 'CALCUL :(('.(int)$obj->papp.' * ('.strtotime('now').' - '.strtotime($last['date_upd']).')) / 3600)');
					log::add('conso', 'debug', 'Puissance :' .jeedom::evaluateExpression($confConso['papp']));
					log::add('conso', 'debug', 'CALCUL :(('.(int)$obj->papp.' * ('.strtotime('now').' - '.strtotime($last['date_upd']).')) / 3600)');
					/*incrementer les valeurs des 1w pour inserer cette valeur */
					$tmp_value = $last['tmp_value'] + $variation;
					log::add('conso_trame_module', 'debug', 'tmp_value  : '.$last['tmp_value'] .'+'.$variation.'='.$tmp_value);
					log::add('conso_trame_module', 'debug', 'Consommation sur 1 minute :  '.(float)$variation.' W/Min');
					log::add('conso', 'debug', 'tmp_value  : '.$last['tmp_value'] .'+'.$variation.'='.$tmp_value);
					log::add('conso', 'debug', 'Consommation sur 1 minute :  '.(float)$variation.' W/Min');
					if($tmp_value>1) {

						$variation =  (int)$tmp_value;/*variation seront donc de 1 ou plus*/
						$tmp_value -= (int)$tmp_value;/*Enleve la valeur de la variable temporaire*/
						$conso = $variation + $last['lastvalue']; /*La conso sera modifié*/
						log::add('conso_trame_module', 'debug', 'Conso Insérée : '.$conso.'W  - Reste a stocker : '.$tmp_value.'W');
						log::add('conso', 'debug', 'Conso Insérée : '.$conso.'W  - Reste a stocker : '.$tmp_value.'W');

					}
				}else{
					log::add('conso_trame_module', 'debug', 'Equipement  éteint ' );
					log::add('conso', 'debug', 'Equipement  éteint ' );
					//$conso = $last['lastvalue']; /*La conso sera modifié*/
					$tmp_value = $last['tmp_value'];
					$conso = $last['lastvalue'];/*Si l equipement est etient il faut recuperer l ancienne valeur*/
					$variation = 0;

				}
			}else{ /* cas FGD212 */
				log::add('conso_trame_module', 'debug', 'Cas FGD212 ' );
				$lastvalue = ($last['lastvalue'] == '' ? 0 : $last['lastvalue']); /**/
				$variation = ($conso < $last['lastvalue'] ? 0 : $conso - $lastvalue); /**/
			}

			if($mode_variation && $variation==0 ){
				log::add('conso_trame_module', 'debug', 'VARIATION : '.$variation.'W MODE Variation Uniquement activée, pas d enregistrement'  );
				log::add('conso', 'debug', 'VARIATION : '.$variation.'W MODE Variation Uniquement activée, pas d enregistrement'  );
				 /* return ;*/
			}

			/*securite si la variation est > à valeur définie dans l'équipement*/
			$VariationMax = ($confConso['variationmax'] >= 0 ? $confConso['variationmax'] : 0);
			if((int)$variation > $VariationMax and $VariationMax > 0) {
				log::add('conso_trame_module', 'debug', 'Attention Variation('.$variation.') > à la variation max ('.$VariationMax.') autorisé sur l\'équipement: pas d\'enregistrement effectué');
				log::add('conso', 'debug', 'Attention Variation('.$variation.') > à la variation max ('.$VariationMax.') autorisé sur l\'équipement: pas d\'enregistrement effectué');
				$variation = 0;
			}

			$lasthp = (int)$last['hp'];
			$lasthc = (int)$last['hc'];
			$newhp = (int)$last['hp'] + $variation;
			$newhc = (int)$last['hc'] + $variation;

			//log::add('conso_trame_module', 'debug', 'VALEUR : '.$conso_tmp.'('.$obj->hchp.' * '.$hchp_unity.')');
			//log::add('conso_trame_module', 'debug', 'VARIATION : '.$variation.'W');
			//log::add('conso_trame_module', 'debug', '('.$conso.'<'.$last['lastvalue'].')');

			/*securite si la variation est > 5000*/
			if(((int)$variation > 5000 || $conso < $last['lastvalue']) && $last['lastvalue']!=""){ /* Si la variation est > 5000 ou que la variation est inferieur a la derniere données il faut attendre 3min de confirmation.*/
				log::add('conso_trame_module', 'debug', '--------------EQUIPEMENT : '.$obj->id_equipement.'-------------------------------- ');
				log::add('conso_trame_module', 'debug', 'Attention Variation > 5000 ou conso < a la derniere conso ('.$conso.'<'.$last['lastvalue'].')');
				log::add('conso_trame_module', 'debug', 'VARIATION : '.$variation.'W');
				/*Si la variation conserne un interval de moins de 2min c'est impossible*/
				$last_time = strtotime($last['date_upd']); // Conversion de la date de création en timestamp Unix
				$current_time = time(); // Récupération du timestamp Unix actuel
				$differenceSecondes = $current_time - $last_time;  // Récupération de la différence (en secondes)
				$differenceMinutes = round($differenceSecondes / 60, 1);// Conversion de cette différence en minutes
				log::add('conso_trame_module', 'debug', 'INTERVAL : '.$differenceMinutes.' minutes');
				if($differenceMinutes < 3){
					log::add('conso_trame_module', 'debug', 'Attention Variation pendant  un interval de '.$differenceMinutes.' minute(s), pas d enregistrement ( attente de 3 minutes pour que cette variation soit valide ) ');
					return;
				}else{
					log::add('conso_trame_module', 'debug', 'Variation pendant un interval de  '.$differenceMinutes.' minute(s), il faut enregistrer ');
					log::add('conso_correction', 'debug', '--------------EQUIPEMENT : '.$obj->id_equipement.'-------------------------------- ');
					log::add('conso_correction', 'debug', 'Variation de : '.$variation.'W');
					log::add('conso_correction', 'debug', 'Pour corriger cette variation merci d executer les 2 requetes suivantes');
					log::add('conso_correction', 'debug', 'UPDATE Eco_legrand_teleinfo SET hchp = hchp-'.$variation.' WHERE id_equipement = '.$obj->id_equipement.' AND TIMESTAMP >= '.$obj->timestamp);
					log::add('conso_correction', 'debug', 'UPDATE conso_tmp SET hp = hp - '.$variation.' WHERE id_ecq = '.$obj->id_equipement);

				}
			}
			//Revoir les requetes !

			$sql = 'REPLACE INTO Eco_legrand_teleinfo (timestamp , rec_date, rec_time ,hchp,hchc,ptec,inst1,papp,imax1,id_equipement,temp) VALUES (' . $obj->timestamp . ',"' . $obj->rec_date . '","' . $obj->rec_time . '",' . ($obj->ptec != 'HC' ? $newhp : $lasthp) . ',' . ($obj->ptec == 'HC' ? $newhc : $lasthc) . ',"' . $obj->ptec . '",' . (int)$obj->inst1 . ',' . $obj->papp . ',' . $obj->imax1 . ',' . $obj->id_equipement . ',' . $obj->temp . ')';
			log::add('conso_trame_module', 'debug', $sql);

			DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
			log::add('conso_trame_module', 'debug', 'Consommation : '.$obj->hchp.' ('.$obj->hchp.' * '.$hchp_unity.') unity : '.$hchp_unity.' '. $obj->ptec . ' last value : ' . $lastvalue . '---variation :' . $variation . ' last hp : ' . $lasthp . '---lasthc : ' . $lasthc . '----newshp : ' . $newhp . '---newshc : ' . $newhc);
			$valeur = ($obj->ptec == 'HC' ? $newhc : $newhp);

			$sql = 'UPDATE conso_tmp	SET ' . $type . ' = ' . $valeur . ',ptec = "' . $obj->ptec . '", tmp_value = '.$tmp_value.',variation = ' . $variation . ',lastvalue = ' . $conso . ',date_upd = NOW() WHERE	 id_ecq = ' . $obj->id_equipement;
			log::add('conso_trame_module', 'debug', $sql);
			return DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);

		} else {
			log::add('conso_trame_module', 'debug', '--------------INIT : '.$obj->id_equipement.'-------------------------------- ');
			$sql = 'REPLACE INTO conso_tmp (id_ecq,' . $type . ',ptec,variation,lastvalue,date_upd,tmp_value) VALUES 	('.$obj->id_equipement . ',' . $conso . ',"' . $obj->ptec . '",' . $variation . ',' . $conso . ',NOW(),0)';
			log::add('conso_trame_module', 'debug', 'Init->' . $sql);
			log::add('conso', 'debug', 'Init->' . $sql);

			return DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
		}
	}

	/*retourne la consommation du mois en cours par heure */
	static public function MonthPowerWeek(){
		$sql = 'SELECT * FROM conso_jour WHERE MONTH(rec_date) = MONTH(CURRENT_DATE()) AND YEAR(rec_date) = YEAR(CURRENT_DATE()) GROUP BY WEEK(rec_date) order by timestamp';

		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
	}
	/*retourne la consommation de la semaine en cours par heure */
	static public function WeekPowerHour(){
		$sql = 'SELECT * FROM conso_jour WHERE WEEK(rec_date) = WEEK(CURRENT_DATE()) AND YEAR(rec_date) = YEAR(CURRENT_DATE()) order by timestamp';

		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
	}
	/*retourne la consommation de l annees  en cours par mois */
	static public function YearPowerMonth(){
		$sql = 'SELECT * FROM conso_jour WHERE WEEK(rec_date) = WEEK(CURRENT_DATE()) AND YEAR(rec_date) = YEAR(CURRENT_DATE()) GROUP BY YEAR(rec_date) order by timestamp';

		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
	}

	public static function getWeekStarAndEnd($firstDayIsMonday = false, $format = 'Y-m-d'){

		//   $weekStartTime = mktime(0, 0, 0, date('m'), date('d') - date('w'), date('Y'));
		$weekStartTime = mktime(0, 0, 0, date('m'), date('d') - date('N') + 1, date('Y'));

		// $weekStartTime += ($firstDayIsMonday)? 86400 : 0;
		//log::add('conso', 'debug', 'date week debut:'.$weekStartTime. 'fin:'.date($format, strtotime('+6 days', $weekStartTime)));
		return array('debut' => date($format, $weekStartTime), 'fin' => date($format, strtotime('+6 days', $weekStartTime)));
	}

	public static function getTableInfoSize(){

		$sql ='SELECT table_name  AS "Table", round(((data_length + index_length) / 1024 / 1024), 2)  as size FROM information_schema.TABLES WHERE  table_name = "Eco_legrand_teleinfo";';
		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);

	}

	public static function RestaureParam($dbhost, $dbuser, $dbpass, $backup_file, $tmp){
		/*il faut arreter le demon avant*/
		$cron = cron::byClassAndFunction('conso', 'StartDeamon');
		$cron->halt();
		if ($cron->running()) return false;

		$ext = pathinfo($tmp . $backup_file, PATHINFO_EXTENSION);

		if ($ext == 'sql') {
			$command = 'mysql -h' . $dbhost . ' -u' . $dbuser . ' -p' . $dbpass . ' jeedom < "' . $tmp . $backup_file . '"';
		} else {

			$cmd = 'echo "ERREUR -> Merci d utiliser un fichier SQL \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			$cmd = 'echo "[END CONSO_HISTORIQUE ERROR]\n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			return false;
		}

		$cmd = 'echo "****************Import de la configuration ********************* \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$cmd = 'echo "Restauration de  la configuration ' . $backup_file . ' \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$cmd = 'echo " ' . $command . '  \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		/*Vide les tables */
		$sql = "TRUNCATE TABLE conso_taxe;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
		$cmd = 'echo "Nettoyage des Taxes terminée. \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$sql = "TRUNCATE TABLE  conso_tva;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
		$cmd = 'echo "Nettoyage de la TVA terminée. \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$sql = "TRUNCATE TABLE  conso_price;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
		$cmd = 'echo "Nettoyage des Prix terminée. \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$sql = "TRUNCATE TABLE conso_abo;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
		$cmd = 'echo "Nettoyage des Abonnements  terminée. \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$cmd = 'echo "Import de la nouvelle configuration en cours ...... \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		exec($command, $op);

		$cmd = 'echo "Import Terminée \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$cmd = 'echo "[END CONSO_HISTORIQUE SUCCESS]\n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$cmd = 'echo " Synchronisation en cours merci de patienter ( la roue crantrée doit disparaitre ) \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		return true;

	}

	public static function Restauregz($dbhost, $dbuser, $dbpass, $backup_file, $table){

		/*il faut arreter le demon avant*/
		$cron = cron::byClassAndFunction('conso', 'StartDeamon');
		$cron->halt();
		if ($cron->running()) return false;

		if (substr(config::byKey('path', 'conso'), 0, 1) != '/') {
			$tmp = dirname(__FILE__) . '/../../' . config::byKey('path', 'conso');
		} else {
			$tmp = config::byKey('path', 'conso');
		}

		$ext = pathinfo($tmp . $backup_file, PATHINFO_EXTENSION);

		if ($ext == 'csv') {
			$cmd = 'echo "Fichier CSV non pris en charge pour les imports merci d utiliser une fichier SQL \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);
			$cmd = 'echo "[END CONSO_HISTORIQUE ERROR]\n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
			exec($cmd);

			return false;
		}

		if ($ext == 'sql') {
			$command = 'mysql -h' . $dbhost . ' -u' . $dbuser . ' -p' . $dbpass . ' jeedom < "' . $tmp . $backup_file . '"';
		} elseif ($ext == 'csv') {

			//$command = 'LOAD DATA LOCAL INFILE "' . $tmp.$backup_file . '" REPLACE INTO TABLE  Eco_legrand_teleinfo character set latin1 FIELDS TERMINATED BY ";"	(timestamp,rec_date,rec_time,hchp,hchc,ptec,inst1,imax1,pmax,papp,id_equipement,temp);';
			//DB::Prepare($command, array(), DB::FETCH_TYPE_ALL);
			$command = 'mysqlimport  --fields-terminated-by=";" --columns="timestamp,rec_date,rec_time,hchp,hchc,ptec,inst1,imax1,pmax,papp,id_equipement,temp" -h' . $dbhost . ' -u' . $dbuser . ' -p' . $dbpass . ' jeedom.Eco_legrand_teleinfo ' . $tmp . $backup_file;

		} else
			$command = 'gunzip < ' . $tmp . $backup_file . ' | mysql  -h' . $dbhost . ' -u' . $dbuser . ' -p' . $dbpass . ' jeedom';


		$cmd = 'echo "****************Import de l\historique ********************* \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$cmd = 'echo "Restauration de  l\'historique ' . $backup_file . ' \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$cmd = 'echo " ' . $command . '  \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$cmd = 'echo "Restauration en cours ...... \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		exec($command, $op);

		$cmd = 'echo "Restauration Terminée \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$cmd = 'echo "[END CONSO_HISTORIQUE SUCCESS]\n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);


		return true;
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

	static public function GetDistant($host = false, $login = false, $pass = false, $type = 'all', $nb_month = 0){
		global $CONFIG;

		if (substr(config::byKey('path', 'conso'), 0, 1) != '/') {
			$tmp = dirname(__FILE__) . '/../../' . config::byKey('path', 'conso');
		} else {
			$tmp = config::byKey('path', 'conso');
		}

		if (file_exists($tmp . 'distant_file.sql')) {
			unlink($tmp . 'distant_file.sql');
		}
		if (file_exists($tmp . 'distant_file_jour.sql')) {
			unlink($tmp . 'distant_file_jour.sql');
		}

		$where = " ";
		$where_libelle = " ";

		if ($type == 'all') {
			$where_sql = 'truncate table Eco_legrand_teleinfo';
			DB::Prepare($where_sql, array(), DB::FETCH_TYPE_ROW);
			$where = "";
			$where_libelle = '  ';
		} elseif ($type == 'day') {
			$where = ' --where="rec_date > (curdate() - interval 1 day)" ';
			$where_sql = ' delete from Eco_legrand_teleinfo  WHERE rec_date > (curdate() - interval 1 day) ';
			DB::Prepare($where_sql, array(), DB::FETCH_TYPE_ROW);
			$where_libelle = ' du jour ';
		} elseif ($type == 'mois') {
			if ($nb_month > 0) {
				$where = ' --where="rec_date > (curdate() - interval ' . (int)$nb . ' month)" ';
				$where_sql = ' delete from Eco_legrand_teleinfo  WHERE rec_date > (curdate() - interval ' . (int)$nb . ' month) ';
				DB::Prepare($where_sql, array(), DB::FETCH_TYPE_ROW);
				$where_libelle = ' des ' . $nb . ' derniers mois ';
			} else {
				$where = ' --where="rec_date > (curdate() - interval 1 month)" ';
				$where_sql = ' WHERE rec_date > (curdate() - interval 1 month) ';
				DB::Prepare($where_sql, array(), DB::FETCH_TYPE_ROW);
				$where_libelle = ' du derniere mois ';
			}
		}


		$cmd = 'echo "****************Récuperation des données sur le distant ********************* \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);
		/*********************************/
		/********Table Conso Teleinfo**********/
		/*********************************/
		$cmd = 'echo "Table Eco_legrand_teleinfo -- Création du fichier SQL ' . $where_libelle . ' import depuis le distant en cours ...  \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$command = 'mysqldump -h' . $host . ' -u' . $login . ' -p' . $pass . ' jeedom Eco_legrand_teleinfo ' . $where . ' --replace  --skip-add-drop-table --no-create-info > ' . $tmp . 'distant_file.sql;';
		//	$cmd = 'echo "'.$command.' \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		//	exec($cmd);
		exec($command);

		$cmd = 'echo "Table Eco_legrand_teleinfo -- Création du fichier SQL d import depuis le distant Terminé.  \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$cmd = 'echo "Table Eco_legrand_teleinfo --  Import du fichier sql sur le local en cours .....  \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$command = 'mysql -h' . $CONFIG['db']['host'] . ' -u' . $CONFIG['db']['username'] . ' -p' . $CONFIG['db']['password'] . ' jeedom < "' . $tmp . 'distant_file.sql"';
		//	$cmd = 'echo " '.$command.' \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		//	exec($cmd);
		exec($command);

		$cmd = 'echo "Table Eco_legrand_teleinfo -- Import  des données sur le local terminé. \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		/*********************************/
		/********Table JOUR**********/
		/*********************************/
		$cmd = 'echo "Table Conso_jour --  Création du fichier SQL d import ' . $where_libelle . ' depuis le distant en cours ...  \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$command = 'mysqldump -h' . $host . ' -u' . $login . ' -p' . $pass . ' jeedom conso_jour ' . $where . ' --replace  --skip-add-drop-table --no-create-info > ' . $tmp . 'distant_file_jour.sql;';
		//	$cmd = 'echo "'.$command.' \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		//	exec($cmd);
		exec($command);

		$cmd = 'echo "Table Conso_jour -- Création du fichier SQL d import depuis le distant Terminé.  \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		$cmd = 'echo "Table Conso_jour -- Import du fichier sql sur le local en cours .....  \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);

		//$command = 'mysql -h'.$CONFIG['db']['host'].' -u'.$CONFIG['db']['username'].' -p'.$CONFIG['db']['password']. ' jeedom < "'.$tmp.'distant_file_jour.sql"';

		$command = 'mysql -h' . $CONFIG['db']['host'] . ' -u' . $CONFIG['db']['username'] . ' -p' . $CONFIG['db']['password'] . ' jeedom  < "' . $tmp . 'distant_file_jour.sql"';

		//	$cmd = 'echo " '.$command.' \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		//	exec($cmd);
		exec($command);

		$cmd = 'echo "Table Conso_jour --  Import  des données sur le local terminé. \n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);


		//	if (file_exists($tmp.'distant_file.sql')) { unlink($tmp.'distant_file.sql'); }
		//	if (file_exists($tmp.'distant_file_jour.sql')) { unlink($tmp.'distant_file_jour.sql'); }

		$cmd = 'echo "[END CONSO_HISTORIQUE SUCCESS]\n"  >> ' . log::getPathToLog('conso_historique') . ' 2>&1 &';
		exec($cmd);


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
		//mysqldump -hlocalhost -ujeedom -pb9755552f521f05 -tEco_legrand_teleinfo -T/usr/share/nginx/www/jeedom/plugins/conso/core/class/../../ressources/backup/.historique_2015-09-21_16_38_22.sql [jeedom] --fields-enclosed-by=" --fields-terminated-by=; --where="rec_date < (curdate() - interval 6 month)"
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

	public static function crontabAllJour(){
		Eco_legrand_teleinfo::crontabJour(true);

		return;
	}

	public static function getIdByType($type){
		$water = array();
		$eqLogics = eqLogic::byType('conso');
		foreach ($eqLogics as $eqLogic) {
			if ($eqLogic->getConfiguration('type') == $type) $water[] = $eqLogic->getId();
		}

		$id_water = false;
		if (count($water) > 0) $id_water = implode(",", $water);

		return $id_water;
	}

	public static function deleteNullValue(){

		$eqLogics = eqLogic::byType('conso');
		$type_abo = 'HB';
		foreach ($eqLogics as $eqLogic) {
			if ($eqLogic->getConfiguration('type') != 'water' && $eqLogic->getConfiguration('type') != 'oil' && $eqLogic->getConfiguration('type') != 'gaz' &&  $eqLogic->getIsEnable() == 1)  {
				$type_abo = conso::getAbo($eqLogic->getId());
				break;
			}
		}
		//$type_abo = (!$eqLogics ? 'HCHP' : conso::getAbo($eqLogics[0]->getId()));

		if ($type_abo != 'HCHP') {
			$sql = '	DELETE FROM Eco_legrand_teleinfo WHERE hchp < 5 ';
		} else {
			$sql = '	DELETE FROM Eco_legrand_teleinfo WHERE hchc  < 5 OR hchp < 5 ';
		}
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}

	public static function SQLDJU($date_debut, $date_fin){

		$debut = strtotime(str_replace("-", "/", $date_debut."-".date('Y')));
		$fin = strtotime(str_replace("-", "/", $date_fin."-".date('Y')));
		/*GESTION DE LA DATE POUR LE DJU*/
		if ($fin < $debut) {

			$sql = "WHEN DATE_FORMAT(rec_date, '%m-%d') NOT BETWEEN
							DATE_FORMAT(STR_TO_DATE('" . $date_debut . "', '%m-%d'), '%m-%d') AND	'12-31' AND

						DATE_FORMAT(rec_date, '%m-%d') NOT BETWEEN	'01-01' AND
							DATE_FORMAT(STR_TO_DATE('" . $date_fin . "', '%m-%d'), '%m-%d')  THEN 0 ";
		} else {

			$sql = "WHEN DATE_FORMAT(rec_date, '%m-%d') NOT BETWEEN
						    DATE_FORMAT(STR_TO_DATE('" . $date_debut . "', '%m-%d'), '%m-%d') AND
						    DATE_FORMAT(STR_TO_DATE('" . $date_fin . "', '%m-%d'), '%m-%d')  THEN 0 ";
		}

		return $sql;
	}

	public static function crontabJour($all = false, $nb_jour = 1){

		conso_tools::IsSQLDocker(config::byKey('docker', 'conso', false));

		config::save('date_update_conso_jour', date("d-m-Y H:i:s"), 'conso');
		$id_water = Eco_legrand_teleinfo::getIdByType('water');
		$id_oil = Eco_legrand_teleinfo::getIdByType('oil');
		$id_gaz = Eco_legrand_teleinfo::getIdByType('gaz');
		$id_autre = '';
		if ($id_gaz) $id_autre = $id_gaz;
		if ($id_oil and $id_autre) $id_autre = $id_oil. ',' .$id_autre;
		if ($id_oil and !$id_autre) $id_autre = $id_oil;
		if ($id_water and $id_autre) $id_autre = $id_water. ',' .$id_autre;
		if ($id_water and !$id_autre) $id_autre = $id_water;

		//log::add('conso', 'info', 'Table des jours indexée'. $id_autre);
		$sql = "REPLACE INTO conso_jour (`timestamp`,rec_date,periode,hp,hc,idx_max_hp,idx_min_hp,idx_max_hc,idx_min_hc,id_eq,temp_max,temp_min,temp_moy,dju_clim,dju)
				SELECT
				MIN(`timestamp`) AS `timestamp`  ,
				`Eco_legrand_teleinfo`.`rec_date` AS `rec_date`,
				DATE_FORMAT(`Eco_legrand_teleinfo`.`rec_date`,'%a %e %y') AS `periode`, ";
		if (!$id_water and !$id_oil and !$id_gaz) {
			$sql .= "	((MAX(`hchp`) - MIN(`hchp`)) / 1000)  AS hp,((MAX(`hchc`) - MIN(`hchc`)) / 1000)  AS hc,";
		} else {
			$sql .= "	CASE WHEN id_equipement IN (" . $id_autre . ") THEN ((MAX(`hchp`) - MIN(`hchp`)))	ELSE ((MAX(`hchp`) - MIN(`hchp`)) / 1000)  END AS hp,
			                CASE WHEN id_equipement IN (" . $id_autre . ") THEN  ((MAX(`hchc`) - MIN(`hchc`)))	ELSE  ((MAX(`hchc`) - MIN(`hchc`)) / 1000)  END AS hc, ";
		}

		$sql .= "MAX(hchp) as idx_max_hp,
				MIN(hchp) as idx_min_hp,
				MAX(hchc) as idx_max_hc,
				MIN(hchc) as idx_min_hc,
				id_equipement,
				FORMAT(MAX(temp),2) AS temp_max,
				FORMAT(MIN(NULLIF(temp,0)),2) AS temp_min,
				FORMAT(AVG(NULLIF(temp,0)),2) AS temp_moy,";
		/************************/
		/*GESTION DU DJU*/
		/************************/
		$temp_ref = config::byKey('temp_ref', 'conso', '20');
		$temp_ref -= 2; /*2°C de chauffage seront apportés "gratuitement" par le soleil, l'éclairage, les personnes, les machines*/
		$dates = conso_tools::getDateAbo();
		/*CLIM*/
		$sql .= ' CASE ' . self::SQLDJU($dates['date_debut_clim'], $dates['date_fin_clim']);
		$sql .= "WHEN " . (int)$temp_ref . " = 0 THEN 0
		WHEN FORMAT(AVG(NULLIF(temp,0)),2) = 0 THEN 0
		WHEN " . (int)$temp_ref . " >= FORMAT(MAX(temp),2) THEN 0
		WHEN " . (int)$temp_ref . " <= FORMAT(MIN(NULLIF(temp,0)),2) THEN FORMAT(AVG(NULLIF(temp,0)),2)-" . (int)$temp_ref . "
		WHEN FORMAT(MIN(NULLIF(temp,0)),2) < " . (int)$temp_ref . " AND " . (int)$temp_ref . " <= FORMAT(MAX(temp),2) THEN (FORMAT(MAX(temp),2)-" . (int)$temp_ref . ") * (0.08+0.42* (FORMAT(MAX(NULLIF(temp,0)),2)-" . (int)$temp_ref . ") / (FORMAT(MAX(temp),2) - FORMAT(MIN(NULLIF(temp,0)),2)))
		END AS dju_clim, ";
		/*CHAUFFAGE*/
		$sql .= ' CASE ' . self::SQLDJU($dates['date_debut_chauff'], $dates['date_fin_chauff']);
		$sql .= " WHEN " . (int)$temp_ref . " = 0 THEN 0
		WHEN 	FORMAT(AVG(NULLIF(temp,0)),2) = 0 THEN 0
		WHEN " . (int)$temp_ref . " >= FORMAT(MAX(temp),2) THEN " . (int)$temp_ref . " - FORMAT(AVG(NULLIF(temp,0)),2)
		WHEN " . (int)$temp_ref . " <= FORMAT(MIN(NULLIF(temp,0)),2) THEN 0
		WHEN FORMAT(MIN(NULLIF(temp,0)),2) < " . (int)$temp_ref . " AND " . (int)$temp_ref . " <= FORMAT(MAX(temp),2) THEN (" . (int)$temp_ref . "-FORMAT(MIN(NULLIF(temp,0)),2)) * (0.08+0.42* (" . (int)$temp_ref . "-FORMAT(MIN(NULLIF(temp,0)),2)) / (FORMAT(MAX(temp),2) - FORMAT(MIN(NULLIF(temp,0)),2)))
		END AS dju ";

		/************************/
		/************************/
		/************************/
		$sql .= "	 FROM `Eco_legrand_teleinfo`	INNER JOIN eqLogic ON id=id_equipement ";

		if (!$all && $nb_jour == 0) $sql .= "	where rec_date = CURDATE() ";
		if (!$all && $nb_jour > 0) $sql .= "	where rec_date >= SUBDATE(CURRENT_DATE, INTERVAL " . $nb_jour . " DAY) ";

		$sql .= "GROUP BY rec_date,id_equipement";
		log::add('conso', 'info', 'CrontabJour:'. $sql);
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}

	public static function crontabEpur(){
		global $CONFIG;
		$res = Eco_legrand_teleinfo::DumpTable($CONFIG['db']['host'],$CONFIG['db']['username'],$CONFIG['db']['password'],'save','Eco_legrand_teleinfo','',false,"--no-create-info");
		log::add('conso', 'debug', 'Epuration Eco_legrand_teleinfo: ' . $res);
		if ($res) {
			$month = config::byKey('keepMonth', 'conso', 0);
			$sql = 'delete from Eco_legrand_teleinfo where rec_date < (curdate() - interval ' . (int)$month . ' month) ';
			log::add('conso', 'debug', 'Epuration Eco_legrand_teleinfo: ' . $sql);
			DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
		}
	}

	static public function getLastDateTrame(){
		Eco_legrand_teleinfo::checkdateMysql();
		$sql = 'select DATE_FORMAT(FROM_UNIXTIME(`timestamp`), "%d-%m-%Y %H:%i") as date from Eco_legrand_teleinfo order by timestamp DESC limit 1;';

		//$sql ='select CONCAT(rec_date, " ", rec_time)  as date from Eco_legrand_teleinfo order by timestamp DESC limit 1;';

		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}

	static public function getLastDateDay(){
		Eco_legrand_teleinfo::checkdateMysql();
		$sql = 'select DATE_FORMAT(FROM_UNIXTIME(`timestamp`), "%d-%m-%Y") as date  from conso_jour order by timestamp DESC limit 1;';

		//$sql ='select  CONCAT(rec_date, " ", rec_time)  as date  from conso_jour order by timestamp DESC limit 1;';
		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}

	static public function getDateMysql(){
		Eco_legrand_teleinfo::checkdateMysql();
		$sql = 'select FROM_UNIXTIME(UNIX_TIMESTAMP(), "%d-%m-%Y %H:%i") as date ;';

		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}

	static public function getLastDateWeek(){
		Eco_legrand_teleinfo::checkdateMysql();
		$sql = 'select DATE_FORMAT(FROM_UNIXTIME(`timestamp`), "%d-%m-%Y %H:%i") as date from conso_semaine order by timestamp DESC limit 1;';

		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}

	function gauge(){
		global $table;

		$query = "SELECT timestamp, rec_date, rec_time, ptec, papp, inst1 AS iinst1 FROM `$table` ORDER BY timestamp DESC LIMIT 1 ";
		$result = mysql_query($query) or die ("<b>Erreur</b> dans la requète <b>" . $query . "</b> : " . mysql_error() . " !<br>");
		$row = mysql_fetch_array($result);

		return array('gauge_watt' => intval($row["papp"]), 'gauge_date' => $row["rec_date"], 'gauge_time' => $row["rec_time"], 'gauge_type' => $row["ptec"]);
	}

	static public function CurrentTrame($limit = false, $yesterday = false, $max = false, $min = false, $date_debut = false, $date_fin = false, $id_ecq = false){

		//log::add('conso_debug', 'debug', 'CurrentTrame acces');
		Eco_legrand_teleinfo::checkdateMysql();
		$sql = '';
		$eqLogics = eqLogic::byId($id_ecq);
		$pulse = (!$eqLogics->getConfiguration('pulse') ? 1 : (float)$eqLogics->getConfiguration('pulse'));
		$consoYesterday = $eqLogics->getConfiguration('consoyesterday');
		//log::add('conso', 'debug', 'CurrentTrame consoYesterday'.$consoYesterday );
		if ($yesterday) $sql .= 'select * from (';

		$sql .= '  select timestamp,rec_date,hchp*'.$pulse.',hchc*'.$pulse.',ptec,papp*'.$pulse.' as papp,inst1,rec_time,imax1,temp,id_equipement,
				DATE_FORMAT(FROM_UNIXTIME(`timestamp`), "%d-%m-%Y %H:%i") as date ';

		if (!$date_debut) {
			$sql .= ' From conso_current WHERE ';
			if (!$yesterday and !$consoYesterday) $sql .= 'rec_date = current_date() '; else
				$sql .= 'rec_date = DATE_SUB(current_date(), INTERVAL 1 DAY)';
		} else {
			$sql .= ' From Eco_legrand_teleinfo WHERE ';

			if (!$yesterday and !$consoYesterday) $sql .= 'rec_date between "' . $date_debut . '" AND "' . $date_fin . '"'; else
				$sql .= 'rec_date between DATE_SUB("' . $date_debut . '", INTERVAL 1 DAY) AND DATE_SUB("' . $date_fin . '", INTERVAL 1 DAY)';

		}
		$sql .= ' AND id_equipement = ' . $id_ecq;

		if ($max) $sql .= ' order by papp desc limit 1 '; elseif ($min) $sql .= ' order by papp asc limit 1 ';
		else
			$sql .= ' order by timestamp desc';


		$sql .= ($limit && !$max && !$min ? ' limit ' . $limit : ' ');

		if ($yesterday) $sql .= ') as req order by req.timestamp desc';


		//if($yesterday)
		//	print $sql;
		//log::add('conso', 'debug', 'CurrentTrame Requete: '.$sql);
		if (!$limit) $row = DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL); else
			$row = DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);

		return $row;

	}

	static public function GetCalculPrice($pdate_debut, $pdate_fin, $type_graph = 'mois', $old = false, $limit = false, $id_periode = false, $yesterday = false, $id_ecq, $group_by = false){
		$query_limit = '';
	
		$eqLogics = eqLogic::byId($id_ecq);
		$type = (!$eqLogics->getConfiguration('type') ? 'electricity' : $eqLogics->getConfiguration('type'));
		$parent_id = (!$eqLogics->getConfiguration('parent_id') || $eqLogics->getConfiguration('parent_id') == "" ? 'non' : 'oui');
		$abon = ($parent_id == 'oui' && $eqLogics->getConfiguration('abonnement') == "0") ? false : true;

		/*LITRE OU M3*/
		if (stripos($type, 'elect') === false) {
			/*LITRE*/
			if ($type_graph == 'jours') $water_unity = ''; ///*M3*/
			else
				/*Tout est affiché en M3*/
				$water_unity = ' * 0.001';
		}


		DB::Prepare("SET lc_time_names = 'fr_BE'", array(), DB::FETCH_TYPE_ALL);
		$query = ' SELECT
                            ' . $id_ecq . ' as id_equipement,
                            id_parent,';
    	$query .= ((stripos($type, 'elect') !== false or $type == 'oil' or $type == 'gaz') ? 'tva,' : '5.5 as tva,');
		$query .= 'tva_abo,'
						    .($abon? ' abonnement,' : ' 0 as abonnement,').'
						    annee,
						    mois,
						    jour,
						    semaine,';
		$query .= (stripos($type, 'elect') !== false? ' sum(hp) as hp,sum(hc) as hc , ' : ($type == 'gaz'? ' ((sum(hp) ' . $water_unity . ') ) '.($type_graph == 'jours' ? ' /1000 ' : '').' as hp, 0 as hc ,' :' ((sum(hp) ' . $water_unity . ') ) '.($type_graph == 'jours' ? ' /1000 ' : '').' as hp,((0 ' . $water_unity . ') )  '.($type_graph == 'jours' ? ' /1000 ' : '').' as hc ,'));
		$query .= ((stripos($type, 'elect') !== false or $type == 'gaz') ? ' sum(total_hp) as total_hp,sum(total_hc) as total_hc , ' : ' ((sum(total_hp) ' . $water_unity . ')) '.($type_graph == 'jours' ? '/1000 ' : '').' as total_hp,((sum(total_hc) ' . $water_unity . ')) '.($type_graph == 'jours' ? ' /1000 ' : '').'  as total_hc ,');
		$query .= '	sum(kwh) as kwh,
							prix_hp,
						    prix_hc,
							temp_min,
							temp_max,
							temp_moy,
							dju,
							dju_clim,
							mois,
						    ' . ($type_graph == 'mois' ? ' cat_month ' : ($type_graph == 'jours' ? ' cat_jours ' : ($type_graph == 'year' ? ' annee ' : ' cat_semaine '))) . '  as categorie  ,
						    rec_date FROM (
						    SELECT
								FORMAT(MIN(temp_min),2) AS temp_min,
								FORMAT(MAX(temp_max),2) AS temp_max,
								FORMAT(AVG(temp_moy),2) AS temp_moy,
								SUM(dju) AS dju,
								SUM(dju_clim) AS dju_clim,
						        "' . $parent_id . '" as id_parent,
								`timestamp`,
								rec_date,
								rec_date as cat_jours,
								DATE_FORMAT(s.`rec_date`,"%Y") AS annee,
								DATE_FORMAT(s.`rec_date`,"%c") AS mois,
								DATE_FORMAT(s.`rec_date`,"%e") AS jour,
								IF(DATE_FORMAT(s.`rec_date`,"%c") = 12 AND DATE_FORMAT(s.`rec_date`,"%v") = 1,52,DATE_FORMAT(s.`rec_date`,"%v")) AS semaine,
								IF(DATE_FORMAT(s.`rec_date`,"%c") = 1 AND DATE_FORMAT(s.`rec_date`,"%v") in (52,53),CONCAT(DATE_FORMAT(s.`rec_date`,"sem %v")," ",DATE_FORMAT(DATE_SUB(s.`rec_date`, INTERVAL 1 YEAR),"%y")) , IF(DATE_FORMAT(s.`rec_date`,"%c") = 12 AND DATE_FORMAT(s.`rec_date`,"%v") = 1,CONCAT(DATE_FORMAT(s.`rec_date`,"sem %v")," ",DATE_FORMAT(DATE_ADD(s.`rec_date`, INTERVAL 1 YEAR),"%y")),DATE_FORMAT(s.`rec_date`,"sem %v %y"))) AS cat_semaine, /*Ajout du 1er janviers 2017 dans la semaie 52 de 2016*/
								/* DATE_FORMAT(s.`rec_date`,"sem %v %y") AS cat_semaine,*/
								DATE_FORMAT(s.`rec_date`,"%b %y") AS cat_month,
								DATE_FORMAT(s.`rec_date`,"%y") AS cat_anne,
								ROUND(SUM(s.hp),2) AS hp,
								ROUND(SUM(s.hc),2) AS hc,
								ROUND(SUM((SELECT SUM(ifnull(hc,0)) AS hp FROM conso_price WHERE  type_ecq like "' . $type . '" AND UNIX_TIMESTAMP(DATE_FORMAT(rec_date , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP(DATE_FORMAT(date_debut, "%Y-%m-%d")) AND UNIX_TIMESTAMP(DATE_FORMAT(date_fin, "%Y-%m-%d")) ) * s.hp/1000 ),2) AS kwh,
								(SELECT SUM(FORMAT(montant,2) * (1 + cst.valeur/100)) AS abo FROM conso_abo aa INNER JOIN conso_tva cst on cst.id = aa.id_tva where type_ecq like "' . $type . '" AND UNIX_TIMESTAMP(DATE_FORMAT(rec_date , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP( DATE_FORMAT( aa.date_debut,  "%Y-%m-%d" ) ) AND UNIX_TIMESTAMP( DATE_FORMAT( aa.date_fin,  "%Y-%m-%d" ) ) ) as abonnement,
								(SELECT cst.valeur tva_abo FROM conso_abo aa	INNER JOIN conso_tva cst on cst.id = aa.id_tva	where type_ecq like "' . $type . '" AND UNIX_TIMESTAMP(DATE_FORMAT(rec_date , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP( DATE_FORMAT( aa.date_debut,  "%Y-%m-%d" ) ) AND UNIX_TIMESTAMP( DATE_FORMAT( aa.date_fin,  "%Y-%m-%d" ) ) limit 0,1 ) as tva_abo,
								(SELECT SUM(FORMAT(hc,4)) AS hc FROM conso_price  where type_ecq like "' . $type . '" AND UNIX_TIMESTAMP(DATE_FORMAT(rec_date , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP( DATE_FORMAT( date_debut,  "%Y-%m-%d" ) ) AND UNIX_TIMESTAMP( DATE_FORMAT( date_fin,  "%Y-%m-%d" ) ) ) as prix_hc,
								(SELECT SUM(FORMAT(hp,4)) AS hp FROM conso_price  where type_ecq like "' . $type . '" AND UNIX_TIMESTAMP(DATE_FORMAT(rec_date , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP( DATE_FORMAT( date_debut,  "%Y-%m-%d" ) ) AND UNIX_TIMESTAMP( DATE_FORMAT( date_fin,  "%Y-%m-%d" ) ) ) as prix_hp,
							    (SELECT  FORMAT(valeur ,2)  FROM conso_tva where UNIX_TIMESTAMP(DATE_FORMAT(rec_date , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP( DATE_FORMAT( date_debut,  "%Y-%m-%d" ) ) AND UNIX_TIMESTAMP( DATE_FORMAT( date_fin,  "%Y-%m-%d")) and global = 1 limit 0,1) as tva,
								CASE WHEN "'.$type.'" IN ("gaz","oil","water") THEN 0
							    ELSE ROUND(SUM((SELECT SUM(FORMAT(hc,4)) AS hc FROM conso_price WHERE  type_ecq like "' . $type . '" AND UNIX_TIMESTAMP(DATE_FORMAT(rec_date , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP(DATE_FORMAT(date_debut, "%Y-%m-%d")) AND UNIX_TIMESTAMP(DATE_FORMAT(date_fin, "%Y-%m-%d")) ) * s.hc ),2) END AS total_hc,
								CASE WHEN "'.$type.'" = "gaz" THEN
									ROUND(SUM((SELECT SUM(FORMAT(hp,4) * hc) AS hp FROM conso_price WHERE  type_ecq like "' . $type . '" AND UNIX_TIMESTAMP(DATE_FORMAT(rec_date , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP(DATE_FORMAT(date_debut, "%Y-%m-%d")) AND UNIX_TIMESTAMP(DATE_FORMAT(date_fin, "%Y-%m-%d")) ) * s.hp/1000  ),2)
							    ELSE ROUND(SUM((SELECT SUM(FORMAT(hp,4)) AS hp FROM conso_price WHERE  type_ecq like "' . $type . '" AND UNIX_TIMESTAMP(DATE_FORMAT(rec_date , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP(DATE_FORMAT(date_debut, "%Y-%m-%d")) AND UNIX_TIMESTAMP(DATE_FORMAT(date_fin, "%Y-%m-%d")) ) * s.hp ),2) END AS total_hp
								FROM  conso_jour s
								WHERE id_eq = ' . $id_ecq . ' AND ';


		/*Periode demandée - 1 an*/
		if ($old) {
			$query_periode = '	( timestamp BETWEEN UNIX_TIMESTAMP(DATE_SUB("' . $pdate_debut . '", INTERVAL 372 DAY)) and UNIX_TIMESTAMP(DATE_SUB("' . $pdate_fin . '", INTERVAL 1 YEAR))
                                    or
                                    `rec_date` BETWEEN   DATE_SUB("' . $pdate_debut . '", INTERVAL 372 DAY) AND DATE_SUB("' . $pdate_fin . '", INTERVAL 1 YEAR) )';

		} elseif ($yesterday) {
			$query_periode = '( timestamp BETWEEN UNIX_TIMESTAMP(DATE_SUB("' . $pdate_debut . '", INTERVAL 1 DAY)) and UNIX_TIMESTAMP(DATE_SUB("' . $pdate_fin . '", INTERVAL 1 DAY))
                                    or
                                    `rec_date` BETWEEN   DATE_SUB("' . $pdate_debut . '", INTERVAL 1 DAY) AND DATE_SUB("' . $pdate_fin . '", INTERVAL 1 DAY) )';

		} else {
			/*Periode demandée*/
			$query_periode = ' (	`timestamp` BETWEEN   UNIX_TIMESTAMP("' . $pdate_debut . '") AND UNIX_TIMESTAMP("' . $pdate_fin . '") or `rec_date` BETWEEN   "' . $pdate_debut . '" AND "' . $pdate_fin . '" ) ';
		}


		if (!$group_by) {
			/*Par jours , par mois , par année */
			$query_group = ' GROUP BY  ' . ($type_graph == 'mois' ? ' cat_month ' : ($type_graph == 'jours' ? ' cat_jours ' : ($type_graph == 'year' ? ' cat_anne ' : ' cat_semaine '))) . ' ORDER BY rec_date ASC) as req
										GROUP by ' . ($type_graph == 'mois' ? ' req.cat_month ' : ($type_graph == 'jours' ? ' req.cat_jours ' : ($type_graph == 'year' ? ' req.cat_anne ' : ' req.cat_semaine '))) . '  ORDER BY req.rec_date ASC	';
		} else {
			/*Group by personalisé */
			$query_group = ' GROUP BY ' . $group . ' ORDER BY rec_date ASC) as req  GROUP BY ' . $group . '  ORDER BY req.rec_date ASC	';
		}

		if ($limit) $query_limit = '	LIMIT 0,' . $limit;

		$sql = $query . $query_periode . $query_group . $query_limit;

		//log::add('conso', 'debug', 'GetCalculPrice Date deb: '. $pdate_debut.' Date fin:'. $pdate_fin.' Type graph:'.$type_graph. ' Requete: '.$sql);

		//if ($old)  print $sql;
		//if($type_graph=='mois' && $old){
		//	print '<hr>';
		//print $sql;
		//	print '<hr>';
		//	}

		$result = DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
		if ($result) {
			return $result;
		} else{
			return false;
		}
	}

	static public function getYesterdayConso($id_ecq){
		$hier = new DateTime('-1 day');
		$day_conso = Eco_legrand_teleinfo::GetCalculPrice($hier->format('Y-m-d'), $hier->format('Y-m-d'), "jours", false, false, false, false, $id_ecq); /*Conso du jour */
		if ($day_conso !== false) {
			return Eco_legrand_teleinfo::consoResult($day_conso, 'day', $hier->format('Y-m-d'), $hier->format('Y-m-d'), $id_ecq);
		} else {
			return false;
		}
	}

	static public function getDayConso($id_ecq){
		$day_conso = Eco_legrand_teleinfo::GetCalculPrice(date("Y-m-d"), date("Y-m-d"), "jours", false, false, false, false, $id_ecq); /*Conso du jour */
		if ($day_conso !== false) {
			return Eco_legrand_teleinfo::consoResult($day_conso, 'day', date("Y-m-d"), date("Y-m-d"), $id_ecq);
		} else {
			return false;
		}
	}
	static public function get_conso_jour($id_ecq){
		$day_conso = Eco_legrand_teleinfo::GetCalculPrice(date("Y-m-d"), date("Y-m-d"), "jours", false, false, false, false, $id_ecq); /*Conso du jour */
		if ($day_conso !== false) {
			return Eco_legrand_teleinfo::consoResult($day_conso, 'day', date("Y-m-d"), date("Y-m-d"), $id_ecq);
		} else {
			return false;
		}
	}
	
	static public function getWeekConso($id_ecq){
		$date_week = Eco_legrand_teleinfo::getWeekStarAndEnd(true); /*retourne la date de debut et de fin de la semaine en cours*/
		$week_conso = Eco_legrand_teleinfo::GetCalculPrice($date_week['debut'], $date_week['fin'], "semaine", false, false, false, false, $id_ecq); /*Conso de la semaine en cours  */
		if ($week_conso !== false) {
			return Eco_legrand_teleinfo::consoResult($week_conso, 'week', $date_week['debut'], $date_week['fin'], $id_ecq);
		} else {
			return false;
		}
	}

	static public function getMonthConso($id_ecq){
		$date = new DateTime();
		$month_conso = Eco_legrand_teleinfo::GetCalculPrice($date->format('Y-m-01'), $date->format('Y-m-t'), "mois", false, false, false, false, $id_ecq); /*Conso du mois en cours  */
		if ($month_conso !== false) {
			return Eco_legrand_teleinfo::consoResult($month_conso, 'month', $date->format('Y-m-01'), $date->format('Y-m-t'), $id_ecq);
		} else {
			return false;
		}
	}
	
	static public function getMonthOldConso($id_ecq){
		$date = new DateTime();
		//log::add('conso', 'debug', 'getMonthOldConso ');
		$month_conso = Eco_legrand_teleinfo::GetCalculPrice($date->modify('-1 year')->format('Y-m-01'), $date->format('Y-m-t'), "mois", false, false, false, false, $id_ecq); /*Conso du mois en cours  */
		if ($month_conso !== false) {
			return Eco_legrand_teleinfo::consoResult($month_conso, 'month', $date->modify('-1 year')->format('Y-m-01'), $date->format('Y-m-t'), $id_ecq);
		} else {
			return false;
		}
	}

	static public function getYearConso($id_ecq){
		$date = new DateTime();
		$d = conso_tools::getDateAbo();

		$year_conso = Eco_legrand_teleinfo::GetCalculPrice($date->format($d['date_debut_fact']), $date->format($d['date_fin_fact']), "mois", false, false, false, false, $id_ecq); /*Conso de  l année en cours  */
		if ($year_conso !== false) {
			return Eco_legrand_teleinfo::consoResult($year_conso, 'year', $date->format($d['date_debut_fact']), $date->format($d['date_fin_fact']), $id_ecq);
		} else {
			return false;
		}
	}

	static public function consoResult($tab, $type = 'day', $date_debut, $date_fin, $id_equipement){
		//log::add('conso', 'debug','date_deb:'.$date_debut.' date_fin:'.$date_fin);
		//log::add('conso', 'debug', '-------------------Calcul du tableau ' . $type . ' -------------');
		$conso = array('prix_hp' => 0, 'tprix_hc' => 0,'total_hp' => 0, 'total_hc' => 0, 'total' => 0, 'hp' => 0, 'hc' => 0, 'total_hc_ttc' => 0, 'total_hp_ttc' => 0, 'total_abo' => 0, 'total_ttc' => 0, 'total_fixe' => 0, 'total_inte' => 0, 'total_multi_ttc' => 0, 'kwh' => 0, 'total_ht'=> 0);
		$eqLogics = eqLogic::byId($id_equipement);
		$type_eq = (!$eqLogics->getConfiguration('type') ? 'electricity' : $eqLogics->getConfiguration('type'));
		$parent_id = (!$eqLogics->getConfiguration('parent_id') || $eqLogics->getConfiguration('parent_id') == "" ? false : true);
		$pulse = (!$eqLogics->getConfiguration('pulse') ? 1 : (float)$eqLogics->getConfiguration('pulse'));
		$result_taxe = conso_tva::GetTaxe($id_equipement, $date_debut, $date_fin, $type, $pulse);


		$fixe = 0;
		$inte = 0;
		$multi_ttc = 0;
		/************************/
		/*Gestion des taxes*/
		/************************/

		//log::add('conso', 'debug', '********Taxes variables************');
		if($result_taxe!==false)
			foreach ($result_taxe as $taxes => $taxe) {
				switch ($type) {
					case 'day':
						/*if (!$parent_id)*/ $fixe += $taxe['fixe_day'];
						break;
					case 'week':
						/*if (!$parent_id)*/ $fixe += $taxe['fixe_week'];
						break;
					case 'month':
						/*if (!$parent_id)*/ $fixe += $taxe['fixe_month'];
						break;
					case 'year':
						/*if (!$parent_id)*/ $fixe += $taxe['fixe_year'];
						break;
				}
				$inte += $taxe['total_inte']; // Taxe variable
				$multi_ttc += round($taxe['multi_ttc'],2);
			}

		$conso['total_fixe'] = $fixe;
		$conso['total_inte'] = $inte;
		$conso['total_multi_ttc'] = $multi_ttc;

		/************************/
		/*Gestion de L'abonnement*/
		/************************/
		$abo = 0;
		//log::add('conso', 'debug', '********Abonnement************');
		foreach ($tab as $key => $cs) {
			switch ($type) {
				case 'day':
					$abo = (($cs['abonnement'] * 12) / 365); /*Abonnement au mois * 12 mois / 365 semaines */
					//$abo = (($ab * $cs["tva_abo"]) / 100) + $ab; /*ajoute la tva*/
					break;
				case 'week':
					$abo = (($cs['abonnement'] * 12) / 52); /*Abonnement au mois * 12 mois / 52 */
					//$abo = (($ab * $cs["tva_abo"]) / 100) + $ab; /*ajoute la tva*/
					break;
				case 'month':
					$abo = $cs['abonnement'];
					//$abo = (($ab * $cs["tva_abo"]) / 100) + $ab; /*ajoute la tva*/
					break;
				case 'year':
					$abo = $cs['abonnement'];
					//$abo = (($ab * $cs["tva_abo"]) / 100) + $ab; /*ajoute la tva*/
					break;
				default:
					$abo = 0;
					break;
			}
			if ($parent_id && $eqLogics->getConfiguration('abonnement') == "0") $abo = 0;

			$conso['hp'] += $cs['hp']*$pulse;
			$conso['hc'] += $cs['hc']*$pulse;
			$conso['kwh'] += $cs['kwh']*$pulse;
			$conso['prix_hp'] = (float)$cs['prix_hp'];
			$conso['prix_hc'] = (float)$cs['prix_hc'];
			if ($type_eq == 'gaz') {
				$conso['total'] += $cs['hp']*$pulse;
			}
			else {
				$conso['total'] += ($cs['hp'] + $cs['hc'])*$pulse;
			}
			$conso['total_hp'] += $cs['total_hp']*$pulse;
			$conso['total_hc'] += $cs['total_hc']*$pulse;
			$conso['total_abo'] += $abo; /*ajoute la tva*/

			$conso['total_hp_ttc'] += (($cs['total_hp'] *$pulse * $cs["tva"]) / 100) + $cs['total_hp'] * $pulse;
			$conso['total_hc_ttc'] += (($cs['total_hc'] *$pulse * $cs["tva"]) / 100) + $cs['total_hc'] * $pulse;

			if (stripos($type_eq, 'elect') !== false) {
				$conso['total_ttc'] = round($conso['total_hp_ttc'],2) + round($conso['total_hc_ttc'],2) + round($conso['total_multi_ttc'] + $conso['total_abo'],2) + round($conso['total_fixe'],2);
				$conso['total_ht'] = round($conso['total_hp'],2) + round($conso['total_hc'],2);
			}
			else {
				$conso['total_ttc'] = round($conso['total_hp_ttc'],2)+ round($conso['total_multi_ttc'] + $conso['total_abo'],2) + round($conso['total_fixe'],2);
				$conso['total_ht'] = round($conso['total_hp'],2);
			}
			//$total_hp = (($cs['total_hp'] * $cs["tva"]) / 100) + $cs['total_hp'];
			//log::add('conso', 'debug', 'consoResult total_ttc:'.$conso['total_ttc'].' total_hp:'.$total_hp.' total_hp_ttc:'.$conso['total_hp_ttc']. 'total_hc_ttc:'.$conso['total_hc_ttc'].' total_multi_ttc:'.$conso['total_multi_ttc'].' total_abo:'.$conso['total_abo'].' total_fixe:'.$conso['total_fixe']);
		}
		//log::add('conso', 'debug', '---------------------FIN-------------------------');
		$conso['total_hp'] = round($conso['total_hp'],2);
		$conso['total_hp_ttc'] = round($conso['total_hp_ttc'],2);
		if (stripos($type_eq, 'elect') == false) {
			$conso['total_hc'] = round($conso['total_hc'],2);
			$conso['total_hc_ttc'] = round($conso['total_hc_ttc'],2);
		}
		return $conso;
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
