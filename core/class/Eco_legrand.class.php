<?php

  /* This file is part of Jeedom.
  *
  * Jeedom is free software: you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation, either version 3 of the License, or
  * (at your option) any later version.
  *
  * Jeedom is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  * GNU General Public License for more details.
  *
  * You should have received a copy of the GNU General Public License
  * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
  */

  require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class Eco_legrand extends eqLogic {

 
  public function add_log($level = 'debug',$Log){
    if (is_array($Log)) $Log = json_encode($Log);
      $ligne = debug_backtrace(false, 2)[0]['line'];
    if (isset(debug_backtrace(false, 2)[1]['function'])) {
      $function_name = debug_backtrace(false, 2)[1]['function'];
      $msg =  $function_name .' (' . $ligne . '): '.$Log;
  
    }else{
      $msg =  '(' . $ligne . '): '.$Log;
    }
    log::add('Eco_legrand' , $level,$msg);
  
  }

  public function preUpdate() {
    if ($this->getConfiguration('addr') == '') {
      throw new Exception(__('L\'adresse ne peut être vide',__FILE__));
    }
  }

   public function checkCmdOk($_type_data, $_subtype, $_name,$_logical_id, $_template,$_unite) {
    $Eco_legrandCmd = Eco_legrandCmd::byEqLogicIdAndLogicalId($this->getId(),$_logical_id);
    if (!is_object($Eco_legrandCmd)) {
      //self::add_log('debug', 'Création de la commande ' . $_name);
      $Eco_legrandCmd = new Eco_legrandCmd();
      $Eco_legrandCmd->setName(__($_type_data . ' - ' . $_name, __FILE__));
      $Eco_legrandCmd->setEqLogic_id($this->getId());
      $Eco_legrandCmd->setEqType('Eco_legrand');
      $Eco_legrandCmd->setLogicalId($_logical_id);
      $Eco_legrandCmd->setType('info');
      $Eco_legrandCmd->setSubType($_subtype);
      $Eco_legrandCmd->setIsVisible('1');
      $Eco_legrandCmd->setDisplay('showNameOndashboard', 1);
      $Eco_legrandCmd->setDisplay('showIconAndNamedashboard', 1);
      $Eco_legrandCmd->setDisplay('showStatsOndashboard', 1);
      $Eco_legrandCmd->setConfiguration('lastvalue', 0);
      $Eco_legrandCmd->setIsHistorized(1);
      $Eco_legrandCmd->setConfiguration('type', $_type_data);
      $Eco_legrandCmd->setUnite($_unite);
      $Eco_legrandCmd->setConfiguration('repeatEventManagement', 'always');
      $Eco_legrandCmd->setConfiguration('historizeMode', 'none');
      $Eco_legrandCmd->setTemplate("mobile",'line' );
      $Eco_legrandCmd->setTemplate("dashboard",'line' );
      $Eco_legrandCmd->setDisplay('icon', $_template);
      $Eco_legrandCmd->save();
      // $Eco_legrandCmd->event(0);
    }
    $nom=$Eco_legrandCmd->getName();
    if($Eco_legrandCmd->getName() != $_name){
      //self::add_log( 'info', 'nom ' . $nom . "|" .$_type_data . ' - ' . $_name);
      $Eco_legrandCmd->setConfiguration('type', $_type_data);
      $Eco_legrandCmd->setName($_name);
      $Eco_legrandCmd->save();
    }
  }

  public function postSave() {
    $pid_file = jeedom::getTmpFolder('Eco_legrand') . '/Eco_legrand_'.$this->getId().'.pid';
		if (file_exists($pid_file)) {
			$pid = intval(trim(file_get_contents($pid_file)));
			system::kill($pid);
		}
	}

  public function preRemove(){
    $pid_file = jeedom::getTmpFolder('Eco_legrand') . '/Eco_legrand_'.$this->getId().'.pid';
		if (file_exists($pid_file)) {
			$pid = intval(trim(file_get_contents($pid_file)));
			system::kill($pid);
		}
  } 

  function getInformations($eqLogic) {
   
    if(strpos( $eqLogic->getConfiguration('addr', ''), "https://")===0 || strpos( $eqLogic->getConfiguration('addr', ''), "http://")===0){
      $URL =  $eqLogic->getConfiguration('addr', '');
    }else {
      $URL = "http://" . $eqLogic->getConfiguration('addr', '');
    }
    $devAddr = $URL . '/instant.json';
    
    $request_http = new com_http($devAddr);
    $devResult = $request_http->exec(30);
     //self::add_log( 'info', $devAddr);
     //self::add_log( 'debug', print_r($devResult, true));
    if ($devResult === false) {
      self::add_log( 'error', 'problème de connexion ' . $devAddr);
    } else {
      $devResbis = utf8_encode($devResult);
      $devList = json_decode($devResbis, true);
       //self::add_log( 'debug', print_r($devList, true));
      $i=1;
      foreach($devList as $name => $value) {
        if ($name === 'classe' || $name === 'minute') {
          // pas de traitement sur l'heure
        } else {
         
          $eqLogic->checkCmdOk('inst','numeric', trim($name), 'inst_circuit' . $i , '<i class="fas fa-bolt"></i>',"W");
         
  
          $eqLogic->checkCmdOk('csv_heure','numeric', "Consommation " .trim($name) . " par heure","conso_circuit".$i ."_heure",'<i class="fas fa-bolt"></i>',"kW");
          $eqLogic->checkCmdOk('calcul_pourcent','numeric', "Pourcentage " .trim($name) . " par heure","pourcent_circuit".$i ."_heure",'<i class="fas fa-bolt"></i>',"%");
  
          $eqLogic->checkCmdOk('csv_heure','numeric', "Consommation totale par heure","conso_totale_heure",'<i class="fas fa-bolt"></i>',"kW");
          $eqLogic->checkCmdOk('calcul_pourcent','numeric', "Pourcentage totale par heure","pourcent_totale_heure",'<i class="fas fa-bolt"></i>',"%");
          
          $eqLogic->checkCmdOk('csv_heure','numeric', "Consommation Autre par heure" ,"conso_autre_heure",'<i class="fas fa-bolt"></i>',"kW");
          $eqLogic->checkCmdOk('calcul_pourcent','numeric', "Pourcentage Autre par heure","pourcent_autre_heure",'<i class="fas fa-bolt"></i>',"%");
          
          $eqLogic->checkCmdOk('csv_jour','numeric', "Consommation " .trim($name) . " journalière","conso_circuit".$i ."_jour",'<i class="fas fa-bolt"></i>',"kW");
          $eqLogic->checkCmdOk('calcul_pourcent','numeric', "Pourcentage " .trim($name) . " journalière","pourcent_circuit".$i ."_jour",'<i class="fas fa-bolt"></i>',"%");
  
         
          $eqLogic->checkCmdOk('csv_jour','numeric', "Consommation totale journalière",'conso_totale_jour','<i class="fas fa-bolt"></i>',"kW");
          $eqLogic->checkCmdOk('calcul_pourcent','numeric', "Pourcentage totale journalière",'pourcent_totale_jour','<i class="fas fa-bolt"></i>',"%");
  
          $eqLogic->checkCmdOk('csv_jour','numeric', "Consommation Autre journalière" ,'conso_autre_jour','<i class="fas fa-bolt"></i>',"kW");
          $eqLogic->checkCmdOk('calcul_pourcent','numeric', "Pourcentage Autre journalière",'pourcent_autre_jour','<i class="fas fa-bolt"></i>',"%");
  
          $eqLogic->checkAndUpdateCmd('inst_circuit' . $i, $value);
          $i=$i+1;
        }
      }
    }
    $eqLogic->refreshWidget();
  }
  
  function getData($eqLogic) {
    
    if(strpos($eqLogic->getConfiguration('addr', ''), "https://")===0 || strpos($eqLogic->getConfiguration('addr', ''), "http://")===0){
      $URL = $eqLogic->getConfiguration('addr', '');
    }else {
      $URL = "http://" .$eqLogic->getConfiguration('addr', '');
    }
    $devAddr = $URL . '/ti.json';
  
    $request_http = new com_http($devAddr);
    $devResult = $request_http->exec(30);
    //self::add_log( 'info',  $devAddr);
    if ($devResult === false) {
      self::add_log( 'error', 'problème de connexion ' . $devAddr);
    } else {
      $devResbis = utf8_encode($devResult);
      $corrected = preg_replace('/\s+/', '', $devResbis);
      $corrected = preg_replace('/\:0,/', ': 0,', $corrected);
      $corrected = preg_replace('/\:[0]+/', ":", $corrected);
      $devList = json_decode($corrected, true);
      //self::add_log( 'debug', print_r($devList, true));
      if (json_last_error() == JSON_ERROR_NONE) {
        foreach($devList as $name => $value) {
          if ($name === 'classe') {
            // pas de traitement sur ces données
          }else if ($name === 'OPTARIF'){
            $eqLogic->checkCmdOk('teleinfo','string', 'Option tarifaire',trim($name), '<i class="fas fa-info-circle"></i>',"");
            $eqLogic->checkAndUpdateCmd($name, str_replace('..','',$value) );
          }else if ($name === 'PTEC'){
            $eqLogic->checkCmdOk('teleinfo','string', 'Période Tarifaire en cours',trim($name), '<i class="fas fa-random"></i>',"");
            $eqLogic->checkAndUpdateCmd($name, str_replace('..','',$value) );
          } else {
            if ($value != 0){
              $eqLogic->checkCmdOk('teleinfo','numeric', str_replace('conso','index',$name),trim($name), '<i class="fas fa-bolt"></i>',"kWh");
              if ($value > 100){
                $eqLogic->checkAndUpdateCmd($name, round($value/1000,0));
              }else{
                $eqLogic->checkAndUpdateCmd($name,$value );
              }
  
  
            }
          }
        }
      }
    }
    $eqLogic->refreshWidget();
  }

  function getConsoElec($eqLogic) {
    if(strpos($eqLogic->getConfiguration('addr', ''), "https://")===0 || strpos($eqLogic->getConfiguration('addr', ''), "http://")===0){
      $URL = $eqLogic->getConfiguration('addr', '');
    }else {
      $URL = "http://" .$eqLogic->getConfiguration('addr', '');
    }
    //$devAddr = $URL . '/LOG2.csv';
    $jour_heure = "jour";
    $num_fichier = 1;
    $ext = "old";
    
    redo:
    $nom_log = "log" . $num_fichier . "." . $ext;
    $devAddr = $URL .'/'. $nom_log;
    $devResult = fopen($devAddr, "r");
    //self::add_log( 'info', $eqLogic->getName() . " " . $devAddr);
    //self::add_log( 'info', $eqLogic->getId() . " " .$eqLogic->getName());
    /*
      jour	mois	annee	heure	minute	energie_tele_info	prix_tele_info	energie_circuit1	prix_circuit1	energie_cirucit2	prix_circuit2	energie_circuit3	prix_circuit3	energie_circuit4	prix_circuit4	energie_circuit5	prix_circuit5	volume_entree1	volume_entree2	tarif	energie_entree1	energie_entree2	prix_entree1	prix_entree2
      17	   8	  15	   20	   2	     0.000	         0.000	          0.000	             0.000	      0.000	            0.000	         0.000	           0.000	       0.000	          0.000	        0.000	              0.000	          0.000	            0.000	     0	   0.000	          0.000	         0.000	        0.000
      17	8	15	21	2	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	11	0.000	0.000	0.000	0.000
      */
    if ($devResult === false) {
      if(substr($devAddr, -3) == 'csv'){
        self::add_log( 'error', 'problème de connexion ' . $devAddr);
      }
    } else {


      $Eco_legrandCmd_conso_totale = Eco_legrandCmd::byEqLogicIdAndLogicalId($eqLogic->getId(),'conso_totale_'.$jour_heure);
      $valeur_precedente_conso_totale=$Eco_legrandCmd_conso_totale->getConfiguration('lastvalue');
      $Eco_legrandCmd_conso_circuit1 = Eco_legrandCmd::byEqLogicIdAndLogicalId($eqLogic->getId(),'conso_circuit1_'.$jour_heure);
      $valeur_precedente_conso_circuit1=$Eco_legrandCmd_conso_circuit1->getConfiguration('lastvalue');
      $Eco_legrandCmd_conso_circuit2 = Eco_legrandCmd::byEqLogicIdAndLogicalId($eqLogic->getId(),'conso_circuit2_'.$jour_heure);
      $valeur_precedente_conso_circuit2=$Eco_legrandCmd_conso_circuit2->getConfiguration('lastvalue');
      $Eco_legrandCmd_conso_circuit3 = Eco_legrandCmd::byEqLogicIdAndLogicalId($eqLogic->getId(),'conso_circuit3_'.$jour_heure);
      $valeur_precedente_conso_circuit3=$Eco_legrandCmd_conso_circuit3->getConfiguration('lastvalue');
      $Eco_legrandCmd_conso_circuit4 = Eco_legrandCmd::byEqLogicIdAndLogicalId($eqLogic->getId(),'conso_circuit4_'.$jour_heure);
      $valeur_precedente_conso_circuit4=$Eco_legrandCmd_conso_circuit4->getConfiguration('lastvalue');
      $Eco_legrandCmd_conso_circuit5 = Eco_legrandCmd::byEqLogicIdAndLogicalId($eqLogic->getId(),'conso_circuit5_'.$jour_heure);
      $valeur_precedente_conso_circuit5=$Eco_legrandCmd_conso_circuit5->getConfiguration('lastvalue');
      $Eco_legrandCmd_conso_autre = Eco_legrandCmd::byEqLogicIdAndLogicalId($eqLogic->getId(),'conso_autre_'.$jour_heure);
      $valeur_precedente_conso_autre=$Eco_legrandCmd_conso_autre->getConfiguration('lastvalue');
      
      while ( ($data = fgetcsv($devResult,1000,";") ) !== FALSE ) {
        $jour = $data[0];
        $mois = $data[1];
        $annee = $data[2];
        $heure = $data[3];
        $date =  $annee . '-' . $mois . '-' . $jour .' ' . $heure .':00:00';
        //self::add_log('info', $eqLogic->getName() . " " . implode(",",$data));
        $valeur=round($data[5],2);
        if($valeur > $valeur_precedente_conso_totale){
          if ($valeur_precedente_conso_totale == 0 ){
            $valeur_precedente_conso_totale = $valeur;
          }
          $valeur=round($data[5],2);
          self::add_log('debug', 'ajout valeur ' . $Eco_legrandCmd_conso_totale->getName() . ":" . $date . "=>". round($valeur - $valeur_precedente_conso_totale,2));
          $eqLogic->checkAndUpdateCmd('conso_totale_'.$jour_heure,round($valeur - $valeur_precedente_conso_totale,2),$date);
          $valeur_precedente_conso_totale = $valeur;
        }
        

        $valeur=round($data[7],2);
        if($valeur > $valeur_precedente_conso_circuit1){
          if ($valeur_precedente_conso_circuit1 == 0 ){
            $valeur_precedente_conso_circuit1 = $valeur;
          }
          self::add_log('debug', 'ajout valeur ' . $Eco_legrandCmd_conso_circuit1->getName().":" . $date . "=>". round($valeur- $valeur_precedente_conso_circuit1,2));
          $eqLogic->checkAndUpdateCmd('conso_circuit1_'.$jour_heure,round($valeur- $valeur_precedente_conso_circuit1,2),$date);
          $valeur_precedente_conso_circuit1 = $valeur;
        }
        

        $valeur=round($data[9],2);
        if ($valeur > $valeur_precedente_conso_circuit2){
          if ($valeur_precedente_conso_circuit2 == 0 ){
            $valeur_precedente_conso_circuit2 = $valeur;
          }
          self::add_log( 'debug', 'ajout valeur ' . $Eco_legrandCmd_conso_circuit2->getName().":" . $date . "=>". round($valeur - $valeur_precedente_conso_circuit2,2));
          $eqLogic->checkAndUpdateCmd('conso_circuit2_'.$jour_heure,round($valeur - $valeur_precedente_conso_circuit2,2),$date);
          $valeur_precedente_conso_circuit2 = $valeur;
        }
        

        $valeur=round($data[11],2);
        if($valeur > $valeur_precedente_conso_circuit3){
          if ($valeur_precedente_conso_circuit3 == 0 ){
            $valeur_precedente_conso_circuit3 = $valeur;
          }
          self::add_log( 'debug', 'ajout valeur ' . $Eco_legrandCmd_conso_circuit3->getName().":" . $date . "=>". round($valeur - $valeur_precedente_conso_circuit3,2));
          $eqLogic->checkAndUpdateCmd('conso_circuit3_'.$jour_heure,round($valeur - $valeur_precedente_conso_circuit3,2),$date);
          $valeur_precedente_conso_circuit3 = $valeur;
        }
       
        $valeur=round($data[13],2);
        if($valeur > $valeur_precedente_conso_circuit4){
          if ($valeur_precedente_conso_circuit4 == 0 ){
            $valeur_precedente_conso_circuit4 = $valeur;
          }
          self::add_log( 'debug', 'ajout valeur ' . $Eco_legrandCmd_conso_circuit4->getName().":" . $date . "=>". round($valeur - $valeur_precedente_conso_circuit4,2));
          $eqLogic->checkAndUpdateCmd('conso_circuit4_'.$jour_heure,round($valeur - $valeur_precedente_conso_circuit4,2),$date);
          $valeur_precedente_conso_circuit4 = $valeur;

        }
       
        $valeur=round($data[15],2);
        if($valeur > $valeur_precedente_conso_circuit5){
          if ($valeur_precedente_conso_circuit5 == 0 ){
            $valeur_precedente_conso_circuit5 = $valeur;
          }
          self::add_log( 'debug', 'ajout valeur ' . $Eco_legrandCmd_conso_circuit5->getName().":" . $date . "=>". round($valeur - $valeur_precedente_conso_circuit5,2));
          $eqLogic->checkAndUpdateCmd('conso_circuit5_'.$jour_heure,round($valeur - $valeur_precedente_conso_circuit5,2),$date);
          $valeur_precedente_conso_circuit5 = $valeur;
        }
       

        $valeur=round($data[5]-$data[7]- $data[9]-$data[11]-$data[13]-$data[15],2);
        if($valeur > $valeur_precedente_conso_autre){
          if ($valeur_precedente_conso_autre == 0 ){
            $valeur_precedente_conso_autre = $valeur;
          }
          self::add_log( 'debug', 'ajout valeur ' . $Eco_legrandCmd_conso_autre->getName().":" . $date . "=>". round($valeur - $valeur_precedente_conso_autre,2));
          $eqLogic->checkAndUpdateCmd('conso_autre_'.$jour_heure,round($valeur - $valeur_precedente_conso_autre,2),$date);
          $valeur_precedente_conso_autre = $valeur;
        }
       

      }
      if( $Eco_legrandCmd_conso_totale->getConfiguration('lastvalue') != $valeur_precedente_conso_totale) {
        $Eco_legrandCmd_conso_totale->setConfiguration('lastvalue', $valeur_precedente_conso_totale );
        $Eco_legrandCmd_conso_totale->save();
      }

      if( $Eco_legrandCmd_conso_circuit1->getConfiguration('lastvalue') != $valeur_precedente_conso_circuit1) {
        $Eco_legrandCmd_conso_circuit1->setConfiguration('lastvalue',$valeur_precedente_conso_circuit1);
        $Eco_legrandCmd_conso_circuit1->save();
      }

      if( $Eco_legrandCmd_conso_circuit2->getConfiguration('lastvalue') != $valeur_precedente_conso_circuit2) {
        $Eco_legrandCmd_conso_circuit2->setConfiguration('lastvalue',$valeur_precedente_conso_circuit2);
        $Eco_legrandCmd_conso_circuit2->save();
      }

      if( $Eco_legrandCmd_conso_circuit3->getConfiguration('lastvalue') != $valeur_precedente_conso_circuit3) {
        $Eco_legrandCmd_conso_circuit3->setConfiguration('lastvalue',$valeur_precedente_conso_circuit3);
        $Eco_legrandCmd_conso_circuit3->save();
      }

      if( $Eco_legrandCmd_conso_circuit4->getConfiguration('lastvalue') != $valeur_precedente_conso_circuit4) {
        $Eco_legrandCmd_conso_circuit4->setConfiguration('lastvalue',$valeur_precedente_conso_circuit4);
        $Eco_legrandCmd_conso_circuit4->save();
      }

      if( $Eco_legrandCmd_conso_circuit5->getConfiguration('lastvalue') != $valeur_precedente_conso_circuit5) {
        $Eco_legrandCmd_conso_circuit5->setConfiguration('lastvalue',$valeur_precedente_conso_circuit5);
        $Eco_legrandCmd_conso_circuit5->save();
      }
     
      if( $Eco_legrandCmd_conso_autre->getConfiguration('lastvalue') != $valeur_precedente_conso_autre) {
        $Eco_legrandCmd_conso_autre->setConfiguration('lastvalue',$valeur_precedente_conso_autre);
        $Eco_legrandCmd_conso_autre->save();
      }
     
    }
    if ($jour_heure == "jour" && $ext == "old"){
      $ext ="csv";
      goto redo;
    }
    if ($jour_heure == "jour" && $ext == "csv"){
      $jour_heure = "heure";
      $ext ="old";
      $num_fichier = 2;
      goto redo;
    }
    if ($jour_heure == "heure" && $ext == "old"){
      $ext ="csv";
      goto redo;
    }
    $eqLogic->setConfiguration("Importation en cours",0);
    $eqLogic->save(true);
  }
 
  public static function deamon_info() {
		$return = array();
		$return['log'] = 'Eco_legrand';
		$return['state'] = 'nok';
		$pid_file = jeedom::getTmpFolder('Eco_legrand') . '/Eco_legrand.pid';
		if (file_exists($pid_file)) {
      
			if (@posix_getsid(trim(file_get_contents($pid_file)))) {
				$return['state'] = 'ok';
			} else {
				shell_exec(system::getCmdSudo() . 'rm -rf ' . $pid_file . ' 2>&1 > /dev/null;rm -rf ' . $pid_file . ' 2>&1 > /dev/null;');
			}
		}
		$return['launchable'] = 'ok';
		return $return;
	}
	
	public static function deamon_start() {
		self::deamon_stop();
		self::deamon_info();
		$cmd = 'sudo /usr/bin/php ' . realpath(dirname(__FILE__) . '/../..') . '/resources/Eco_legrand.php start';
		//self::add_log('info', 'Lancement démon Eco_legrand : ' . $cmd);
		exec($cmd . ' >> ' . log::getPathToLog('Eco_legrand') . ' 2>&1 &');
		return true;
	}
	
	public static function deamon_stop() {
		$pid_file = jeedom::getTmpFolder('Eco_legrand') . '/Eco_legrand.pid';
		if (file_exists($pid_file)) {
			$pid = intval(trim(file_get_contents($pid_file)));
			system::kill($pid);
		}
		system::kill('Eco_legrand.php');
	}
   
}

class Eco_legrandCmd extends cmd {
  public function dontRemoveCmd() {
    return true;
  }
}

?>