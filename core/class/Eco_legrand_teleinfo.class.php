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

  public $puissance_circuit1;
  public $puissance_circuit2;
  public $puissance_circuit3;
  public $puissance_circuit4;
  public $puissance_circuit5;
  //public $index_pulse1;
  //public $index_pulse2;
  //public $inst_pulse1;
  //public $inst_pulse2;
  public $temperature=0;
  public $eqLogicId=0;
  //
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
      case "puissance_circuit1":
        return $this->puissance_circuit1 = $data;
        break;
      case "puissance_circuit2":
        return $this->puissance_circuit2 = $data;
        break;
      case "puissance_circuit3":
        return $this->puissance_circuit3 = $data;
        break;
      case "puissance_circuit4":
        return $this->puissance_circuit4 = $data;
        break;
      case "puissance_circuit5":
        return $this->puissance_circuit5 = $data;
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

  public static function byEqlogicId($_id){
    $values = array('id' => $_id);
    $sql = 'SELECT * FROM Eco_legrand_teleinfo WHERE eqlogicID=:id';

    return DB::Prepare($sql, $values, DB::FETCH_TYPE_ALL);
  }

  public static function crontabAllJour(){
    self::crontabJour(true);
    return;
  }

  public static function crontabJour($tous_les_jours=false){
    foreach (EqLogic::byType('Eco_legrand') as $eqLogic) {
      $eqLogicID=$eqLogic->getId();
      $aujourdhui=date('Y-m-d', strtotime(' + 0 days'));
      $date=date('Y-m-d', strtotime(' + 0 days'));
      $sql="SELECT min(`date`) as `date` from Eco_legrand_teleinfo WHERE eqLogicID=" .$eqLogicID;
      $result=DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
      $date_min=0;
      if($result){
        $date_min=$result["date"];;
      }


      while ($date_min < $date):

      $sql = "REPLACE INTO Eco_legrand_jour ";
      $sql .= "(`timestamp`,";
      $sql .= "`date`,";
      $sql .= "`conso_totale_hp`,";
      $sql .= "`conso_totale_hc`,";
      $sql .= "`conso_circuit1`,";
      $sql .= "`conso_circuit2`,";
      $sql .= "`conso_circuit3`,";
      $sql .= "`conso_circuit4`,";
      $sql .= "`conso_circuit5`,";
      $sql .= "`conso_autre`,";
      $sql .= "`eqLogicID`,";
      $sql .= "`temperature_min`,";
      $sql .= "`temperature_max`,";
      $sql .= "`temperature_moy`)";
      $sql .= "SELECT ";
      $sql .= "MIN(`timestamp`) AS `timestamp`,";
      $sql .= "`Eco_legrand_teleinfo`.`date` AS `date`,";
      $sql .= "((MAX(`index_hp`) - MIN(`index_hp`)) / 1000)  AS `conso_totale_hp`,";
      $sql .= "((MAX(`index_hc`) - MIN(`index_hc`)) / 1000)  AS `conso_totale_hc`,";
      $sql .= "((MAX(`index_circuit1`) - MIN(`index_circuit1`)) / 1000)  AS `conso_circuit1`,";
      $sql .= "((MAX(`index_circuit2`) - MIN(`index_circuit2`)) / 1000)  AS `conso_circuit2`,";
      $sql .= "((MAX(`index_circuit3`) - MIN(`index_circuit3`)) / 1000)  AS `conso_circuit3`,";
      $sql .= "((MAX(`index_circuit4`) - MIN(`index_circuit4`)) / 1000)  AS `conso_circuit4`,";
      $sql .= "((MAX(`index_circuit5`) - MIN(`index_circuit5`)) / 1000)  AS `conso_circuit5`,";
      $sql .= "((MAX(`index_hp`) - MIN(`index_hp`)) / 1000) + ((MAX(`index_hc`) - MIN(`index_hc`)) / 1000) -((MAX(`index_circuit1`) - MIN(`index_circuit1`)) / 1000)-((MAX(`index_circuit2`) - MIN(`index_circuit2`)) / 1000)-((MAX(`index_circuit3`) - MIN(`index_circuit3`)) / 1000)-((MAX(`index_circuit4`) - MIN(`index_circuit4`)) / 1000)-((MAX(`index_circuit5`) - MIN(`index_circuit5`)) / 1000) AS autre,";
      $sql .= $eqLogicID .",";
      $sql .= "FORMAT(MIN(NULLIF(temperature,0)),2) AS `temperature_min`,";
      $sql .= "FORMAT(MAX(temperature),2) AS `temperature_max`,";
      $sql .= "FORMAT(AVG(NULLIF(temperature,0)),2) AS `temperature_moy`";
      $sql .= "FROM `Eco_legrand_teleinfo`";
      $sql .= " where date ='" . $date . "'";
      $sql .= " GROUP BY date";		
      //Eco_legrand::add_log("debug",$sql);
      DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);

      if($tous_les_jours){
        $date=date('Y-m-d', strtotime($date . '- 1 days'));
      }elseif($date == $aujourdhui){
        $date=date('Y-m-d', strtotime($date . '- 1 days'));
      }else{
        break;
      }

      endwhile;


    }
  }

  public function save(){//OK
    return DB::save($this, false, true);	
  }

  static public function get_erreur($id_ecq){
    $sql = 'SELECT * FROM Eco_legrand_teleinfo where EqlogicID = ' . $id_ecq . ' ORDER BY timestamp ASC';
    $lignes = DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
    $i=0;
    $sql ="";
    $index_total_circuits=0;
    $index_circuit1=0;
    $index_circuit2=0;
    $index_circuit3=0;
    $index_circuit4=0;
    $index_circuit5=0;
    foreach($lignes as $ligne){
      $correction_sql=false;

      if($i >0){
        if ($index_total_circuits==0 OR $index_total_circuits < $ligne["index_total_circuits"]){
          $index_total_circuits=$ligne["index_total_circuits"];
        }
        if ($index_circuit1==0 OR $index_circuit1 < $ligne["index_total_circuits"]){
          $index_circuit1=$lignes[$i-1]["index_circuit1"];
        }
        if ($index_circuit2==0 OR $index_circuit2 < $ligne["index_total_circuits"]){
          $index_circuit2=$lignes[$i-1]["index_circuit2"];
        }
        if ($index_circuit3==0 OR $index_circuit3 < $ligne["index_total_circuits"]){
          $index_circuit3=$lignes[$i-1]["index_circuit3"];
        }
        if ($index_circuit4==0 OR $index_circuit4 < $ligne["index_total_circuits"]){
          $index_circuit4=$lignes[$i-1]["index_circuit4"];
        }
        if ($index_circuit5==0 OR $index_circuit5 < $ligne["index_total_circuits"]){
          $index_circuit5=$lignes[$i-1]["index_circuit5"];
        }
        if($ligne["index_total_circuits"] < $index_total_circuits){
          $ligne["index_total_circuits"]=$index_total_circuits;
          $correction_sql=true;
        }
        if($ligne["index_circuit1"] < $index_circuit1){
          $ligne["index_circuit1"]=$index_circuit1;
          $correction_sql=true;
        }
        if($ligne["index_circuit2"] < $index_circuit2){
          $ligne["index_circuit2"]=$index_circuit2;
          $correction_sql=true;
        }
        if($ligne["index_circuit3"] < $index_circuit3){
          $ligne["index_circuit3"]=$index_circuit3;
          $correction_sql=true;
        }
        if($ligne["index_circuit4"] < $index_circuit4){
          $ligne["index_circuit4"]=$index_circuit4;
          $correction_sql=true;
        }
        if($ligne["index_circuit5"] < $index_circuit5){
          $ligne["index_circuit5"]=$index_circuit5;
          $correction_sql=true;
        }
        if( $ligne["puissance_totale"] == 0 OR $ligne["index_total_circuits"] == 0 ){
          $correction_sql=true;
        }
        //if($ligne["index_total_circuits"] ==0){$ligne["index_total_circuits"]=$lignes[$i-1]["index_total_circuits"];}
        //if($ligne["index_circuit1"] ==0){$ligne["index_circuit1"]=$lignes[$i-1]["index_circuit1"];}
        //if($ligne["index_circuit2"] ==0){$ligne["index_circuit2"]=$lignes[$i-1]["index_circuit2"];}
        //if($ligne["index_circuit3"] ==0){$ligne["index_circuit3"]=$lignes[$i-1]["index_circuit3"];}
        //if($ligne["index_circuit4"] ==0){$ligne["index_circuit4"]=$lignes[$i-1]["index_circuit4"];}
        //if($ligne["index_circuit5"] ==0){$ligne["index_circuit5"]=$lignes[$i-1]["index_circuit5"];}
        $nb_minute=($ligne["timestamp"]-$lignes[$i-1]["timestamp"])/60;
        //return($nb_minute);
        $différence_hp=$ligne["index_hp"]-$lignes[$i-1]["index_hp"];
        $différence_hc=$ligne["index_hc"]-$lignes[$i-1]["index_hc"];
        $différence_moyenne=($différence_hp + $différence_hc) / $nb_minute*60;
        $intensité_moyenne=round($différence_moyenne/230,0);
        if($différence_moyenne < 0){
          $différence_moyenne=0;
          $intensité_moyenne=0;
          if($ligne["index_hc"]<$lignes[$i-1]["index_hc"]){
            $ligne["index_hc"]=$lignes[$i-1]["index_hc"];
          }
          if($ligne["index_hp"]<$lignes[$i-1]["index_hp"]){
            $ligne["index_hp"]=$lignes[$i-1]["index_hp"];
          }
        }

        if ($différence_moyenne>0 and $correction_sql){
          $sql .= "UPDATE Eco_legrand_teleinfo SET 
		puissance_totale = " . $différence_moyenne . ",
		int_instant = " . $intensité_moyenne. ",
		index_hc = " . $ligne["index_hc"] . ",
		index_hp = " . $ligne["index_hp"]. ",
		index_total_circuits = " . $ligne["index_total_circuits"] .",
		index_circuit1 = " . $ligne["index_circuit1"] .",
		index_circuit2 = " . $ligne["index_circuit2"] .",
		index_circuit3 = " . $ligne["index_circuit3"] .",
		index_circuit4 = " . $ligne["index_circuit4"] .",
		index_circuit5 = " . $ligne["index_circuit5"] .
            " WHERE `timestamp` = " . $ligne["timestamp"] . 
            ' AND eqLogicID = ' . $id_ecq .";\n";

        }


        //return	($différence_moyenne);
      }
      $i++;
    }	
    if ($sql !=""){
      //var_dump($sql);
      Eco_legrand::add_log("info",$sql);
      //DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
    }
    return($sql);
  }

  static public function get_calcul_prix($pdate_debut, $pdate_fin, $type_graph = 'mois', $id_ecq, $old = false, $log=false){
    $query_limit = '';

    //$eqLogics = eqLogic::byId($id_ecq);
    //DB::Prepare("SET lc_time_names = 'fr_BE'", array(), DB::FETCH_TYPE_ALL);

    $query = ' SELECT ';
    $query .= $id_ecq . ' as EqlogicID,annee,mois,jour,semaine,sum(hp) as hp,sum(hc) as hc,sum(total_hp) as total_hp,sum(total_hc) as total_hc ,prix_hp,prix_hc,temp_min,temp_max,temp_moy,mois,' ;
    if($type_graph== 'mois'){
      $query .="cat_month";
    }elseif($type_graph== 'year'){
      $query .="annee";
    }elseif($type_graph== 'jours'){
      $query .="cat_jours";
    }else{
      $query .="cat_semaine";
    }
    $query .= '  as categorie,`date` FROM (';
    $query .= 'SELECT ';
    $query .= 'FORMAT(MIN(temperature_min),2) AS temp_min,';
    $query .= 'FORMAT(MAX(temperature_max),2) AS temp_max,';
    $query .= 'FORMAT(AVG(temperature_moy),2) AS temp_moy,';
    $query .= '`timestamp`,';
    $query .= '`date`,';
    $query .= '`date` as cat_jours,';
    $query .= 'DATE_FORMAT(s.`date`,"%Y") AS annee,';
    $query .= 'DATE_FORMAT(s.`date`,"%c") AS mois,';
    $query .= 'DATE_FORMAT(s.`date`,"%e") AS jour,';
    $query .= 'IF(DATE_FORMAT(s.`date`,"%c") = 12 AND DATE_FORMAT(s.`date`,"%v") = 1,52,DATE_FORMAT(s.`date`,"%v")) AS semaine,';
    $query .= 'IF(DATE_FORMAT(s.`date`,"%c") = 1 AND DATE_FORMAT(s.`date`,"%v") in (52,53),CONCAT(DATE_FORMAT(s.`date`,"sem %v")," ",DATE_FORMAT(DATE_SUB(s.`date`, INTERVAL 1 YEAR),"%y")) , IF(DATE_FORMAT(s.`date`,"%c") = 12 AND DATE_FORMAT(s.`date`,"%v") = 1,CONCAT(DATE_FORMAT(s.`date`,"sem %v")," ",DATE_FORMAT(DATE_ADD(s.`date`, INTERVAL 1 YEAR),"%y")),DATE_FORMAT(s.`date`,"sem %v %y"))) AS cat_semaine, ';
    $query .= 'DATE_FORMAT(s.`date`,"%b %y") AS cat_month,';
    $query .= 'DATE_FORMAT(s.`date`,"%y") AS cat_anne,';
    $query .= 'ROUND(SUM(s.conso_totale_hp),2) AS hp,';
    $query .= 'ROUND(SUM(s.conso_totale_hc),2) AS hc,';
    $query .= '(SELECT SUM(FORMAT(hc,4)) AS hc FROM Eco_legrand_prix  where  `type` like "électricité" AND UNIX_TIMESTAMP(DATE_FORMAT(`date` , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP( DATE_FORMAT( date_debut,  "%Y-%m-%d" ) ) AND UNIX_TIMESTAMP( DATE_FORMAT( date_fin,  "%Y-%m-%d" ) ) ) as prix_hc,';
    $query .= '(SELECT SUM(FORMAT(hp,4)) AS hp FROM Eco_legrand_prix  where  `type` like "électricité" AND UNIX_TIMESTAMP(DATE_FORMAT(`date` , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP( DATE_FORMAT( date_debut,  "%Y-%m-%d" ) ) AND UNIX_TIMESTAMP( DATE_FORMAT( date_fin,  "%Y-%m-%d" ) ) ) as prix_hp,';

    $query .= 'ROUND(SUM((SELECT SUM(FORMAT(hc,4)) AS hc ';
    $query .= 'FROM Eco_legrand_prix ';
    $query .= 'WHERE   `type` like "électricité" AND UNIX_TIMESTAMP(DATE_FORMAT(`date` , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP(DATE_FORMAT(date_debut, "%Y-%m-%d")) AND UNIX_TIMESTAMP(DATE_FORMAT(date_fin, "%Y-%m-%d")) ) * s.conso_totale_hc ),2) AS total_hc,';
    $query .= 'ROUND(SUM((SELECT SUM(FORMAT(hp,4)) AS hp ';
    $query .= 'FROM Eco_legrand_prix ';
    $query .= 'WHERE   `type` like "électricité" AND UNIX_TIMESTAMP(DATE_FORMAT(`date` , "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP(DATE_FORMAT(date_debut, "%Y-%m-%d")) AND UNIX_TIMESTAMP(DATE_FORMAT(date_fin, "%Y-%m-%d")) ) * s.conso_totale_hp ),2) AS total_hp ';
    $query .='FROM  Eco_legrand_jour s ';
    $query .='WHERE eqlogicID = ' . $id_ecq . ' AND ';


    /*Periode demandée - 1 an*/
    if ($old) {
      $query_periode = '	(timestamp BETWEEN UNIX_TIMESTAMP(DATE_SUB("' . $pdate_debut . '", INTERVAL 372 DAY)) and UNIX_TIMESTAMP(DATE_SUB("' . $pdate_fin . '", INTERVAL 1 YEAR))
						or
						`date` BETWEEN   DATE_SUB("' . $pdate_debut . '", INTERVAL 372 DAY) AND DATE_SUB("' . $pdate_fin . '", INTERVAL 1 YEAR) )';

    } else {
      /*Periode demandée*/
      $query_periode = ' (`timestamp` BETWEEN   UNIX_TIMESTAMP("' . $pdate_debut . '") AND UNIX_TIMESTAMP("' . $pdate_fin . '") or `date` BETWEEN   "' . $pdate_debut . '" AND "' . $pdate_fin . '" ) ';
    }



    if($type_graph == 'mois'){
      $query_group = ' GROUP BY  cat_month';
    } elseif($type_graph == 'jours'){
      $query_group = ' GROUP BY  cat_jours';
    } elseif($type_graph == 'year'){
      $query_group = ' GROUP BY  cat_anne';
    }else{
      $query_group = ' GROUP BY  cat_semaine';
    }
    $query_group .=' ORDER BY `date` ASC) as req';
    if($type_graph == 'mois'){
      $query_group .= ' GROUP BY  req.cat_month';
    } elseif($type_graph == 'jours'){
      $query_group .= ' GROUP BY  req.cat_jours';
    } elseif($type_graph == 'year'){
      $query_group .= ' GROUP BY  req.cat_anne';
    }else{
      $query_group .= ' GROUP BY  req.cat_semaine';
    }
    $query_group .=' ORDER BY req.`date` ASC';
    /*Par jours , par mois , par année */



    $sql = $query . $query_periode . $query_group . $query_limit;



    if($log){
      Eco_legrand::add_log("debug",$sql);
    }
    $result = DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
    if ($result) {
      return $result;
    } else{
      return false;
    }
  }

  static public function Trame_hier( $id_ecq = false){

    $sql = '';
    $sql .= 'select * from (select timestamp,index_hp,index_hc,ptec,puissance_totale,int_instant,heure,temperature,eqLogicID,DATE_FORMAT(FROM_UNIXTIME(`timestamp`), "%d-%m-%Y %H:%i") as date';
    $sql .= ' From Eco_legrand_teleinfo WHERE ';
    $sql .= 'date = DATE_SUB(current_date(), INTERVAL 1 DAY)';
    $sql .= ' AND eqLogicID = ' . $id_ecq;
    $sql .= ' order by timestamp desc';
    $sql .= ') as req order by req.timestamp desc';


    $row = DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
    return $row;

  }

  static public function get_trame_actuelle($limit = false, $yesterday = false, $date_debut = false, $date_fin = false, $id_ecq = false){
    $sql = '';
    if ($yesterday) $sql .= 'select * from (';

    //$sql .= 'select timestamp,index_hp,index_hc,index_circuit1,index_circuit2,index_circuit3,index_circuit4,index_circuit5,index_total_circuits,ptec,puissance_totale,int_instant,heure,temperature,eqLogicID,DATE_FORMAT(FROM_UNIXTIME(`timestamp`), "%d-%m-%Y %H:%i") as date ';
    $sql .= 'select timestamp,ptec,puissance_totale,puissance_circuit1,puissance_circuit2,puissance_circuit3,puissance_circuit4,puissance_circuit5,int_instant,heure,temperature,eqLogicID ';
    //$sql .= 'select timestamp,ptec,puissance_totale,int_instant,heure,temperature,eqLogicID ';

    $sql .= ' From Eco_legrand_teleinfo WHERE ';
    if (!$date_debut) {
      if (!$yesterday ){
        $sql .= 'date = current_date() ';
      }else{
        $sql .= 'date = DATE_SUB(current_date(), INTERVAL 1 DAY)';
      }				
    } else {
      if (!$yesterday ){
        $sql .= 'date between "' . $date_debut . '" AND "' . $date_fin . '"';
      }else{
        $sql .= 'date between DATE_SUB("' . $date_debut . '", INTERVAL 1 DAY) AND DATE_SUB("' . $date_fin . '", INTERVAL 1 DAY)';
      }
    }
    $sql .= ' AND eqLogicID = ' . $id_ecq;
    $sql .= ' order by timestamp desc ';

    if($limit){
      $sql .= 'limit ' . $limit;
    }
    if ($yesterday){
      $sql .= ') as req order by req.timestamp desc';
    } 
    if (!$limit){
      $row = DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
    }  else{
      $row = DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
    }

    return $row;

  }

  static public function consoResult($tab, $id_equipement){//OK
    $conso = array('prix_hp' => 0,'total_hp' => 0, 'total_hc' => 0, 'total' => 0, 'hp' => 0, 'hc' => 0, 'total_hc_ttc' => 0, 'total_hp_ttc' => 0,  'total_ttc' => 0,  'total_ht'=> 0,'temp_min'=> 0,'temp_moy'=> 0,'temp_max'=> 0);
    $eqLogic = eqLogic::byId($id_equipement);

    $nb=0;
    foreach ($tab as $key => $cs) {
      $conso['hp'] += $cs['hp'];
      $conso['hc'] += $cs['hc'];
      $conso['prix_hp'] = (float)$cs['prix_hp'];
      $conso['prix_hc'] = (float)$cs['prix_hc'];
      $conso['total'] += ($cs['hp'] + $cs['hc']);
      $conso['total_hp'] += round($cs['total_hp'],2);
      $conso['total_hc'] += round($cs['total_hc'],2);
      $tva=$eqLogic->getConfiguration("tva",1);
      $conso['total_hp_ttc'] += (($cs['total_hp']  * $tva) / 100) + $cs['total_hp'] ;
      $conso['total_hc_ttc'] += (($cs['total_hc']  * $tva) / 100) + $cs['total_hc'] ;
      $conso['total_ttc'] = round($conso['total_hp_ttc'] + $conso['total_hc_ttc'],2) ;
      $conso['total_ht'] = round($conso['total_hp'] + $conso['total_hc'],2) ;  

      if($nb == 0){
        $conso['temp_min'] = $cs['temp_min'];
        $conso['temp_max'] = $cs['temp_max'];
        $conso['temp_moy'] = $cs['temp_moy'];
      }else{
        if( $cs['temp_min'] < $conso['temp_min']){
          $conso['temp_min'] = $cs['temp_min'];
        }
        if( $cs['temp_max'] > $conso['temp_max']){
          $conso['temp_max'] = $cs['temp_max'];
        }
        $conso['temp_moy'] = $conso['temp_moy'] + $cs['temp_moy'];
      }
      $nb=1;

    }
    $conso['total_hp'] = round($conso['total_hp'],2);
    $conso['total_hp_ttc'] = round($conso['total_hp_ttc'],2);
    $conso['total_hc'] = round($conso['total_hc'],2);
    $conso['total_hc_ttc'] = round($conso['total_hc_ttc'],2);
    $conso['temp_moy'] = round($conso['temp_moy']/count($tab),1);
    return $conso;
  }

  static public function get_conso_jour($eqLogicID){//OK

    $day_conso = self::get_calcul_prix(date("Y-m-d"), date("Y-m-d"), "jours", $eqLogicID); /*Conso du jour */
    if ($day_conso !== false) {
      return self::consoResult($day_conso, $eqLogicID);
    } else {
      return false;
    }
  }

  static public function get_conso_hier($eqLogicID){
    $hier = new DateTime('-1 day');
    $day_conso = self::get_calcul_prix($hier->format('Y-m-d'), $hier->format('Y-m-d'), "jours", $eqLogicID); /*Conso du jour */
    if ($day_conso !== false) {
      return self::consoResult($day_conso, $eqLogicID);
    } else {
      return false;
    }
  }

  static public function get_conso_semaine($eqLogicID){//OK
    $date_week = self::get_debut_fin_semaine(); /*retourne la date de debut et de fin de la semaine en cours*/
    $week_conso = self::get_calcul_prix($date_week['debut'], $date_week['fin'], "semaine", $eqLogicID); /*Conso de la semaine en cours  */
    if ($week_conso !== false) {
      return self::consoResult($week_conso, $eqLogicID);
    } else {
      return false;
    }
  }

  static public function get_conso_mois($eqLogicID){//OK
    $date = new DateTime();
    $d = Eco_legrand::getDateAbo($eqLogicID);
    //$month_conso = self::get_calcul_prix($date->format('Y-m-01'), $date->format('Y-m-t'), "mois",  $eqLogicID); /*Conso du mois en cours  */
    $month_conso = self::get_calcul_prix($date->format($d['date_debut_mois']), $date->format($d['date_fin_mois']), "mois", $eqLogicID); /*Conso du mois en cours  */

    //Eco_legrand::add_log('debug',$month_conso);
    if ($month_conso !== false) {

      return self::consoResult($month_conso, $eqLogicID);
    } else {
      return false;
    }
  }

  static public function get_conso_annee($eqLogicID){//OK
    $date = new DateTime();
    $d = Eco_legrand::getDateAbo($eqLogicID);

    $year_conso = self::get_calcul_prix($date->format($d['date_debut_fact']), $date->format($d['date_fin_fact']), "mois", $eqLogicID); /*Conso de  l année en cours  */
    if ($year_conso !== false) {
      return self::consoResult($year_conso, $eqLogicID);
    } else {
      return false;
    }
  }

  public static function get_debut_fin_semaine(){//OK
    $format = 'Y-m-d';	
    $weekStartTime = mktime(0, 0, 0, date('m'), date('d') - date('N') + 1, date('Y'));
    return array('debut' => date($format, $weekStartTime), 'fin' => date($format, strtotime('+6 days', $weekStartTime)));
  }

  public static function get_lundi_vendredi_from_week($week,$date,$format="Y-m-d",$type='debut') {//OK

    $JourEnCours = date("N",strtotime($date));
    $shiftDeb = $JourEnCours - 1;
    if ($JourEnCours >= 5) {
      $shiftFin = $JourEnCours - 5;
    } 
    else {
      $shiftFin = 5 - $JourEnCours;
    }	
    $timestamp=strtotime($date)-($shiftDeb*86400);
    $timestamp_vendredi=strtotime($date)+($shiftFin*86400);
    if($type == "debut") {
      return  date($format,$timestamp);
    }
    else {
      return  date($format,$timestamp_vendredi);
    }



  }
  public static function get_périodes_hc_hp($eqLogicID,$date){

    $sql="SELECT heure,ptec FROM `Eco_legrand_teleinfo` WHERE `date`='". $date ."' AND `heure`>='00:00' AND eqLogicID = ".$eqLogicID." GROUP BY ptec,`date` ORDER BY `date`";
    $result=DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
    $périodes=[];
    while (count($result)==2) {
      $période=[];
      $période["début"]=$result[0]["heure"];
      $période["fin"]=$result[1]["heure"];
      $période["ptec"]=$result[0]["ptec"];
      array_push($périodes,$période);
      $heure=$result[1]["heure"];
      $sql="SELECT heure,ptec FROM `Eco_legrand_teleinfo` WHERE `date`='". $date ."' AND `heure`>='".$heure."' AND eqLogicID = ".$eqLogicID." GROUP BY ptec,`date` ORDER BY `date`";
      $result=DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);

    }
    if(count($result)==1){
      $période=[];
      $période["début"]=$result[0]["heure"];
      $période["fin"]='23:59:00';
      $période["ptec"]=$result[0]["ptec"];
      array_push($périodes,$période);
    }
    return $périodes;

  }
  public static function get_conso_tores_hp_hc($type,$eqLogicID){
    if ($type == "jour"){
      $date_debut=date('Y-m-d', strtotime(' + 0 days'));
      $date_fin=date('Y-m-d', strtotime(' + 0 days'));
    }
    if ($type == "hier"){
      $date_debut=date('Y-m-d', strtotime(' - 1 days'));
      $date_fin=date('Y-m-d', strtotime(' - 1 days'));
    }



    $sql="SELECT conso_circuit1, conso_circuit2, conso_circuit3, conso_circuit4, conso_circuit5, conso_autre
,conso_totale_hp + conso_totale_hc as conso_totale
FROM `Eco_legrand_jour` where UNIX_TIMESTAMP(DATE_FORMAT(`date` , '%Y-%m-%d')) BETWEEN UNIX_TIMESTAMP(DATE_FORMAT('" . $date_debut . "', '%Y-%m-%d')) AND UNIX_TIMESTAMP(DATE_FORMAT('" . $date_fin . "', '%Y-%m-%d')) AND eqLogicID = " . $eqLogicID ;
    //Eco_legrand::add_log("debug",$sql);
    $result=DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);

    if($result){
      $result=$result[0];
      $conso_circuit1 = $result['conso_circuit1'];
      $conso_circuit2 = $result['conso_circuit2'];
      $conso_circuit3 = $result['conso_circuit3'];
      $conso_circuit4 = $result['conso_circuit4'];
      $conso_circuit5 = $result['conso_circuit5'];
      $conso_autre = $result['conso_autre'];
      $conso_totale = $result['conso_totale'];
    }



    $data = [];
    $categorie = [];
    $color =["#D7FF82", "#FCC646", "#E62EF7", "#007DFF", "#E8FBFF", "#FFE400", "#5DFFF5", "#77a1e5", "#c42525", "#a6c96a","#f26d7d","#8781bd","#c7b299", "#fff799"];
    $tooltip_data = [];
    $color_byHP = "#AA4643";
    $color_byHC = "#4572A7";


    array_push($data, $conso_circuit1/$conso_totale*100);
    array_push($data, $conso_circuit2/$conso_totale*100);
    array_push($data, $conso_circuit3/$conso_totale*100);
    array_push($data, $conso_circuit4/$conso_totale*100);
    array_push($data, $conso_circuit5/$conso_totale*100);
    array_push($data, $conso_autre/$conso_totale*100);
    array_push($categorie, Cmd::byEqLogicIdAndLogicalId($eqLogicID,"inst_circuit1")->getName());
    array_push($categorie, Cmd::byEqLogicIdAndLogicalId($eqLogicID,"inst_circuit2")->getName());
    array_push($categorie, Cmd::byEqLogicIdAndLogicalId($eqLogicID,"inst_circuit3")->getName());
    array_push($categorie, Cmd::byEqLogicIdAndLogicalId($eqLogicID,"inst_circuit4")->getName());
    array_push($categorie, Cmd::byEqLogicIdAndLogicalId($eqLogicID,"inst_circuit5")->getName());
    array_push($categorie, "Autre");
    array_push($tooltip_data, "Conso: " . round($conso_circuit1,2) . "kWh");
    array_push($tooltip_data, "Conso: " . round($conso_circuit2,2) . "kWh");
    array_push($tooltip_data, "Conso: " . round($conso_circuit3,2) . "kWh");
    Array_push($tooltip_data, "Conso: " . round($conso_circuit4,2) . "kWh");
    array_push($tooltip_data, "Conso: " . round($conso_circuit5,2) . "kWh");
    array_push($tooltip_data, "Conso: " . round($conso_autre,2) . "kWh");
    $tab= array(
      'categorie' => $categorie,
      'data' => $data,
      'color' => $color,
      'tooltip_data' => $tooltip_data);
    return $tab;
  }

  static public function GetTabPie($sql_periode,  $id_ecq = false){//O
    if ($sql_periode=="jour"){
      $result=self::get_conso_jour($id_ecq);
    }elseif ($sql_periode=="hier") {
      $result=self::get_conso_hier($id_ecq);
    }elseif ($sql_periode=="semaine") {
      $result=self::get_conso_semaine($id_ecq);
    }elseif ($sql_periode=="mois") {
      $result=self::get_conso_mois($id_ecq);
    }elseif ($sql_periode=="année") {
      $result=self::get_conso_annee($id_ecq);
    }


    //{"prix_hp":0.1374,"total_hp":1.06,"total_hc":0.43,"total":11.64,"hp":7.72,"hc":3.92,"total_hc_ttc":0.52,"total_hp_ttc":1.27,"total_ttc":1.79,"total_ht":1.49,"prix_hc":0.1092}


    if ($result) {



      $conso_hp = $result['hp'];
      $conso_hc = $result['hc'];
      $conso_totale = $result['total'];
      $pourcent_hp=$conso_hp/$conso_totale*100;
      $pourcent_hc=$conso_hc/$conso_totale*100;


      $montant_hp = $result['total_hp_ttc'];
      $montant_hc = $result['total_hc_ttc'];
      $montant_total = $result['total_hp_ttc'] + $result['total_hc_ttc'];

      $color_byHP = "#AA4643";
      $color_byHC = "#4572A7";
      $color=[];
      if(Eco_legrand::get_type_abo($id_ecq)=="HC"){
        array_push($color, $color_byHP);
        array_push($color, $color_byHC);
      }else{
        array_push($color, $color_byHP);
      }
      $tooltip_data=[];

      array_push($tooltip_data, "Conso: " . round($conso_hp,2) . 'kWh<br>Prix: ' . round($montant_hp,2)."€");
      array_push($tooltip_data, "Conso: " . round($conso_hc,2) . 'kWh<br>Prix: ' .round($montant_hc,2)."€");



      $tab= array(
        'categorie' =>  ['HP', 'HC'],
        'data' =>[$pourcent_hp,$pourcent_hc],
        'color' => $color,
        'tooltip_data' => $tooltip_data);


      return $tab;	
    }


    //$day_conso = self::get_calcul_prix(date("Y-m-d"), date("Y-m-d"), "jours", $eqLogicID); /*Conso du jour */





  }

  static public function GetPie($id_ecq = false,$type=false){
    $tabresult = array();
    if ($type=="jour"){
      $tabresult = self::GetTabPie("jour", $id_ecq);
    }else{
      $tabresult['jour'] = self::GetTabPie("jour", $id_ecq);
      $tabresult['jour_tores'] = self::get_conso_tores_hp_hc("jour",$id_ecq);
      $tabresult['hier'] = self::GetTabPie("hier", $id_ecq);
      $tabresult['hier_tores'] = self::get_conso_tores_hp_hc("hier",$id_ecq);
      $tabresult['mois'] = self::GetTabPie("mois", $id_ecq);
      $tabresult['semaine'] = self::GetTabPie("semaine", $id_ecq);
      $tabresult['annee'] = self::GetTabPie("année", $id_ecq);

    }


    return $tabresult;

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

      Eco_legrand::add_log( 'debug', $command);

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

      Eco_legrand::add_log( 'debug', $command);

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

      Eco_legrand::add_log( 'debug', $command);

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

  static public function getSynthese($id_ecq,$type){
    $all=false;

    if ($type=='all'){
      $array = array('mois' => 0,'jours' => 0, 'annee' => 0, 'semaine' => 0);
      $all=true;
      $type = 'mois';
    }
    redo:
    if($type == 'mois'){
      $type_cat='cat_month';
    }elseif($type == 'jours'){
      $type_cat='cat_jours';
    }elseif($type == 'annee'){
      $type_cat='cat_annee';
    }elseif($type == 'semaine'){
      $type_cat='cat_semaine';
    }

   
    $eqLogic = eqLogic::byId($id_ecq);
    $tva=$eqLogic->getConfiguration("tva",1);
      $sql = "SELECT
      $tva AS Tva,
      1066 AS EqlogicID,
      annee,
      mois,
      SUM(hp) AS hp,
      SUM(hc) AS hc,
      ROUND(total_hp,2) AS total_prix_hp,
      ROUND(total_hc,2) AS total_prix_hc,
      ROUND(total_hc + total_hp,2) AS total_prix,
      ROUND(total_hp_ttc,2) AS total_prix_hp_ttc,
      ROUND(total_hc_ttc,2) AS total_prix_hc_ttc,
      ROUND(total_hp_ttc,2) + ROUND(total_hc_ttc,2) AS total_prix_ttc,
      prix_hp,
      prix_hc,
      temp_min,
      temp_max,
      temp_moy,
      $type_cat AS categorie
      
    FROM
      (
        SELECT
          FORMAT(MIN(temperature_min),
          2) AS temp_min,
          FORMAT(MAX(temperature_max),
          2) AS temp_max,
          FORMAT(AVG(temperature_moy),
          2) AS temp_moy,
          `timestamp`,
          `date` as date,
          `date` as cat_jours,
          DATE_FORMAT(Eco_legrand_jour.`date`, '%Y') AS annee,
          DATE_FORMAT(Eco_legrand_jour.`date`, '%c') AS mois,
          DATE_FORMAT(Eco_legrand_jour.`date`, '%M %y') AS cat_month,
          DATE_FORMAT(Eco_legrand_jour.`date`,'%y') AS cat_annee,
          IF(DATE_FORMAT(Eco_legrand_jour.`date`,'%c') = 12 AND DATE_FORMAT(Eco_legrand_jour.`date`,'%v') = 1,52,DATE_FORMAT(Eco_legrand_jour.`date`,'%v')) AS semaine,
          IF(DATE_FORMAT(Eco_legrand_jour.`date`,'%c') = 1 AND DATE_FORMAT(Eco_legrand_jour.`date`,'%v') in (52,53),CONCAT(DATE_FORMAT(Eco_legrand_jour.`date`,'sem %v'),' ',DATE_FORMAT(DATE_SUB(Eco_legrand_jour.`date`, INTERVAL 1 YEAR),'%y')) , IF(DATE_FORMAT(Eco_legrand_jour.`date`,'%c') = 12 AND DATE_FORMAT(Eco_legrand_jour.`date`,'%v') = 1,CONCAT(DATE_FORMAT(Eco_legrand_jour.`date`,'sem %v'),' ',DATE_FORMAT(DATE_ADD(Eco_legrand_jour.`date`, INTERVAL 1 YEAR),'%y')),DATE_FORMAT(Eco_legrand_jour.`date`,'sem %v %y'))) AS cat_semaine, 
   
          ROUND(SUM(Eco_legrand_jour.conso_totale_hp),2) AS hp,
          ROUND(SUM(Eco_legrand_jour.conso_totale_hc),2) AS hc,
          (
            SELECT
              SUM(FORMAT(hc, 4)) AS hc
            FROM
              Eco_legrand_prix
            WHERE
              `type` LIKE 'électricité' AND UNIX_TIMESTAMP(DATE_FORMAT(`date`, '%Y-%m-%d')) BETWEEN UNIX_TIMESTAMP(
                DATE_FORMAT(date_debut, '%Y-%m-%d')
              ) AND UNIX_TIMESTAMP(
                DATE_FORMAT(date_fin, '%Y-%m-%d')
              )
          ) AS prix_hc,
          (
            SELECT
              SUM(FORMAT(hp, 4)) AS hp
            FROM
              Eco_legrand_prix
            WHERE
              `type` LIKE 'électricité' AND UNIX_TIMESTAMP(DATE_FORMAT(`date`, '%Y-%m-%d')) BETWEEN UNIX_TIMESTAMP(
                DATE_FORMAT(date_debut, '%Y-%m-%d')
              ) AND UNIX_TIMESTAMP(
                DATE_FORMAT(date_fin, '%Y-%m-%d')
              )
          ) AS prix_hp,
          ROUND(
            SUM(
              (
              SELECT
                SUM(FORMAT(hc, 4)) AS hc
              FROM
                Eco_legrand_prix
              WHERE
                `type` LIKE 'électricité' AND UNIX_TIMESTAMP(DATE_FORMAT(`date`, '%Y-%m-%d')) BETWEEN UNIX_TIMESTAMP(
                  DATE_FORMAT(date_debut, '%Y-%m-%d')
                ) AND UNIX_TIMESTAMP(
                  DATE_FORMAT(date_fin, '%Y-%m-%d')
                )
            ) * Eco_legrand_jour.conso_totale_hc
            ),
            2
          ) AS total_hc,
          ROUND(
            SUM(
              (
              SELECT
                SUM(FORMAT(hc, 4)) AS hc
              FROM
                Eco_legrand_prix
              WHERE
                `type` LIKE 'électricité' AND UNIX_TIMESTAMP(DATE_FORMAT(`date`, '%Y-%m-%d')) BETWEEN UNIX_TIMESTAMP(
                  DATE_FORMAT(date_debut, '%Y-%m-%d')
                ) AND UNIX_TIMESTAMP(
                  DATE_FORMAT(date_fin, '%Y-%m-%d')
                )
            ) * Eco_legrand_jour.conso_totale_hc
            ),
            2
          ) + ROUND(
            SUM(
              (
              SELECT
                SUM(FORMAT(hc, 4)) AS hc
              FROM
                Eco_legrand_prix
              WHERE
                `type` LIKE 'électricité' AND UNIX_TIMESTAMP(DATE_FORMAT(`date`, '%Y-%m-%d')) BETWEEN UNIX_TIMESTAMP(
                  DATE_FORMAT(date_debut, '%Y-%m-%d')
                ) AND UNIX_TIMESTAMP(
                  DATE_FORMAT(date_fin, '%Y-%m-%d')
                )
            ) * Eco_legrand_jour.conso_totale_hc
            ),
            2
          ) *$tva/100 AS total_hc_ttc,
          ROUND(
            SUM(
              (
              SELECT
                SUM(FORMAT(hp, 4)) AS hp
              FROM
                Eco_legrand_prix
              WHERE
                `type` LIKE 'électricité' AND UNIX_TIMESTAMP(DATE_FORMAT(`date`, '%Y-%m-%d')) BETWEEN UNIX_TIMESTAMP(
                  DATE_FORMAT(date_debut, '%Y-%m-%d')
                ) AND UNIX_TIMESTAMP(
                  DATE_FORMAT(date_fin, '%Y-%m-%d')
                )
            ) * Eco_legrand_jour.conso_totale_hp
            ),
            2
          ) AS total_hp,
          ROUND(
            SUM(
              (
              SELECT
                SUM(FORMAT(hp, 4)) AS hp
              FROM
                Eco_legrand_prix
              WHERE
                `type` LIKE 'électricité' AND UNIX_TIMESTAMP(DATE_FORMAT(`date`, '%Y-%m-%d')) BETWEEN UNIX_TIMESTAMP(
                  DATE_FORMAT(date_debut, '%Y-%m-%d')
                ) AND UNIX_TIMESTAMP(
                  DATE_FORMAT(date_fin, '%Y-%m-%d')
                )
            ) * Eco_legrand_jour.conso_totale_hp
            ),
            2
          ) + ROUND(
            SUM(
              (
              SELECT
                SUM(FORMAT(hp, 4)) AS hp
              FROM
                Eco_legrand_prix
              WHERE
                `type` LIKE 'électricité' AND UNIX_TIMESTAMP(DATE_FORMAT(`date`, '%Y-%m-%d')) BETWEEN UNIX_TIMESTAMP(
                  DATE_FORMAT(date_debut, '%Y-%m-%d')
                ) AND UNIX_TIMESTAMP(
                  DATE_FORMAT(date_fin, '%Y-%m-%d')
                )
            ) * Eco_legrand_jour.conso_totale_hp
            ),
            2
          ) *$tva/100 AS total_hp_ttc
          FROM
            Eco_legrand_jour Eco_legrand_jour
          WHERE
            eqlogicID = 1066
          GROUP BY
            $type_cat
          ORDER BY
            `date` ASC
          ) AS req
        GROUP BY
          req.$type_cat
        ORDER BY
          req.`date` ASC";





	 
    $result = DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
    if ($result) {
      if($all){
       
        $array[$type] = $result;
        if($type == 'mois'){
          $type = 'jours';
        }elseif($type == 'jours'){
          $type = 'annee';
        }elseif($type == 'annee'){
          $type = 'semaine';
        }elseif($type == 'semaine'){
          return $array;
        }
       
        goto redo;
      }else{
        $array[$type] = $result;
        return $array;
      }
      
    } else{
      return false;
    }
    //self::get_conso_annee($eqLogicID);
    //var_dump($year_conso);


  } 
}