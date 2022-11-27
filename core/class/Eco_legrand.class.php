<?php
require_once dirname(__FILE__) . '/../../core/php/Eco_legrand.inc.php';
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
  public function preRemove() {
       
		$sql="DELETE FROM Eco_legrand_teleinfo where eqLogicID = " . $this->getId();
    DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
    $sql="DELETE FROM Eco_legrand_prix where eqLogicID = " . $this->getId();
    DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
    $sql="DELETE FROM Eco_legrand_jour where eqLogicID = " . $this->getId();
    DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
   public function checkCmdOk($_type_data, $_subtype, $_name,$_logical_id, $_template,$_unite) {
    $Eco_legrandCmd = Eco_legrandCmd::byEqLogicIdAndLogicalId($this->getId(),$_logical_id);
    if (!is_object($Eco_legrandCmd)) {
      //self::add_log('debug', 'Création de la commande ' . $_name);
      $Eco_legrandCmd = new Eco_legrandCmd();
      $Eco_legrandCmd->setName($_name);
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
    //if($Eco_legrandCmd->getName() != $_name){
      //self::add_log( 'info', 'nom ' . $nom . "|" .$_type_data . ' - ' . $_name);
      $Eco_legrandCmd->setConfiguration('type', $_type_data);
      $Eco_legrandCmd->setName($_name);
      $Eco_legrandCmd->save();
    //}
  }
 
  function get_all_datas($eqLogic){
    if(strpos($eqLogic->getConfiguration('addr', ''), "https://")===0 || strpos($eqLogic->getConfiguration('addr', ''), "http://")===0){
      $URL = $eqLogic->getConfiguration('addr', '');
    }else {
      $URL = "http://" .$eqLogic->getConfiguration('addr', '');
    }
  
    $nom_fichier = "ti.json";
    $jour_heure = "jour";
    $conso_hc = 0;
    $conso_hp = 0;
    $ppap=0;
    $date=date_create(date("Y-m-d H:i:00"));
    $date=date("Y-m-d H:i:00");
    //self::add_log("debug",$date->getTimestamp());
    //self::add_log("debug",date_format($date,"Y-m-d"));
    //self::add_log("debug",date_format($date,"H:i:00"));
    //self::add_log( 'info',  $devAddr);
    $Eco_legrand_teleinfo = new Eco_legrand_teleinfo();
    $Eco_legrand_teleinfo->set_value('timestamp',date_create($date)->getTimestamp());
    $Eco_legrand_teleinfo->set_value('date',date_format(date_create($date),"Y-m-d"));
    $Eco_legrand_teleinfo->set_value('heure',date_format(date_create($date),"H:i:00"));
    $Eco_legrand_teleinfo->set_value('eqLogicId',$eqLogic->getId());
    $Eco_legrand_teleinfo->set_value("temperature",jeedom::evaluateExpression($eqLogic->getConfiguration('température extérieure',0)));
    redo:
    $devAddr = $URL . '/' . $nom_fichier; 
    try {
     //self::add_log( 'info',  $devAddr);
      if (substr($nom_fichier , -4) == 'json'){
        $request_http = new com_http($devAddr);
        $devResult = $request_http->exec(30);
        //$devResult = fopen($devAddr, "r");
        
        
        if ($devResult === false) {
          self::add_log( 'error', 'problème de connexion ' . $devAddr);
        } else {
          $devResbis = utf8_encode($devResult);
          $corrected = preg_replace('/\s+/', '', $devResbis);
          $corrected = preg_replace('/\:0,/', ': 0,', $corrected);
          $corrected = preg_replace('/\:[0]+/', ":", $corrected);
          $devList = json_decode($devResbis, true);
          //self::add_log( 'debug', print_r($devList, true));
          $i=1;
          //if (json_last_error() == JSON_ERROR_NONE) {
          foreach($devList as $name => $value) {
            if ($name === 'classe') {
              // pas de traitement sur ces données
            }else if ($name === 'OPTARIF'){
              $eqLogic->checkCmdOk('teleinfo','string', 'Option tarifaire',trim($name), '<i class="fas fa-info-circle"></i>',"");
              
              $eqLogic->checkAndUpdateCmd($name, str_replace('..','',$value),$date);
            }else if ($name === 'PTEC'){
              $eqLogic->checkCmdOk('teleinfo','string', 'Période Tarifaire en cours',trim($name), '<i class="fas fa-random"></i>',"");
              $eqLogic->checkAndUpdateCmd($name, str_replace('..','',$value),$date);
              $Eco_legrand_teleinfo->set_value("ptec",str_replace('..','',$value));
            } else {
              if ($nom_fichier  == "ti.json"){
                if ($value != 0){
                  
                  $eqLogic->checkCmdOk('teleinfo','numeric', trim(str_replace('conso','index',$name)),trim(str_replace('conso','index',$name)), '<i class="fas fa-bolt"></i>',"Wh");
                  $eqLogic->checkCmdOk('teleinfo','numeric', ucfirst( $name),$name, '<i class="fas fa-bolt"></i>',"W");
                  
                  if (str_replace('conso','index',$name) == "index_hc"){
                    $cmd_index_hc=Eco_legrandCmd::byEqLogicIdAndLogicalId($eqLogic->getId(),"index_hc");
                    if (is_object($cmd_index_hc)){
                      $conso_hc = ($value - $cmd_index_hc->execCmd());
                    
                      if ($cmd_index_hc->execCmd() <= $value){
                        $eqLogic->checkAndUpdateCmd('conso_hc', $conso_hc*60,$date);
                        $eqLogic->checkAndUpdateCmd(trim(str_replace('conso','index',$name)), $value,$date);
                        $Eco_legrand_teleinfo->set_value(trim(str_replace('conso','index',$name)),$value);
                        $ppap += $conso_hc*60;
                      }else{
                       
                        $Eco_legrand_teleinfo->set_value(trim(str_replace('conso','index',$name)),$cmd_index_hc->execCmd());
                        $ppap += 0;
                      }
                    }
                  }
                  if (str_replace('conso','index',$name) == "index_hp"){
                    $cmd_index_hp=Eco_legrandCmd::byEqLogicIdAndLogicalId($eqLogic->getId(),"index_hp");
                    if (is_object($cmd_index_hp)){
                      $conso_hp = ($value - $cmd_index_hp->execCmd());
                      //self::add_log("debug", $cmd_index_hp->execCmd());
                      if ($cmd_index_hp->execCmd() <= $value){
                        $eqLogic->checkAndUpdateCmd('conso_hp', $conso_hp*60,$date);
                        $eqLogic->checkAndUpdateCmd(trim(str_replace('conso','index',$name)), $value,$date);
                        $Eco_legrand_teleinfo->set_value(trim(str_replace('conso','index',$name)),$value);
                        $ppap+=$conso_hp*60;
                      }else{
                        $Eco_legrand_teleinfo->set_value(trim(str_replace('conso','index',$name)),$cmd_index_hp->execCmd());
                        $ppap +=0;
                      }                 
                    }
                  }
                  $Eco_legrand_teleinfo->set_value("puissance_totale",$ppap);
                  if ($ppap>0){
                    $Eco_legrand_teleinfo->set_value("int_instant",round($ppap/230),0);
                  }else{
                    $Eco_legrand_teleinfo->set_value("int_instant",0);
                  }
                }
              }else{
                $eqLogic->checkCmdOk('inst','numeric', trim($name), 'inst_circuit' . $i , '<i class="fas fa-bolt"></i>',"W");
              
                $eqLogic->checkCmdOk('csv','numeric', "Consommation " .trim($name) . " par heure","conso_circuit".$i ."_heure",'<i class="fas fa-bolt"></i>',"kW");
              // $eqLogic->checkCmdOk('calcul_pourcent','numeric', "Pourcentage " .trim($name) . " par heure","pourcent_circuit".$i ."_heure",'<i class="fas fa-bolt"></i>',"%");
        
                $eqLogic->checkCmdOk('csv','numeric', "Consommation totale par heure","conso_totale_heure",'<i class="fas fa-bolt"></i>',"kW");
                //$eqLogic->checkCmdOk('calcul_pourcent','numeric', "Pourcentage totale par heure","pourcent_totale_heure",'<i class="fas fa-bolt"></i>',"%");
                
                $eqLogic->checkCmdOk('csv','numeric', "Consommation Autre par heure" ,"conso_autre_heure",'<i class="fas fa-bolt"></i>',"kW");
                //$eqLogic->checkCmdOk('calcul_pourcent','numeric', "Pourcentage Autre par heure","pourcent_autre_heure",'<i class="fas fa-bolt"></i>',"%");
                
                $eqLogic->checkCmdOk('csv','numeric', "Consommation " .trim($name) . " journalière","conso_circuit".$i ."_jour",'<i class="fas fa-bolt"></i>',"kW");
              // $eqLogic->checkCmdOk('calcul_pourcent','numeric', "Pourcentage " .trim($name) . " journalière","pourcent_circuit".$i ."_jour",'<i class="fas fa-bolt"></i>',"%");
        
              
                $eqLogic->checkCmdOk('csv','numeric', "Consommation totale journalière",'conso_totale_jour','<i class="fas fa-bolt"></i>',"kW");
                //$eqLogic->checkCmdOk('calcul_pourcent','numeric', "Pourcentage totale journalière",'pourcent_totale_jour','<i class="fas fa-bolt"></i>',"%");
        
                $eqLogic->checkCmdOk('csv','numeric', "Consommation Autre journalière" ,'conso_autre_jour','<i class="fas fa-bolt"></i>',"kW");
              // $eqLogic->checkCmdOk('calcul_pourcent','numeric', "Pourcentage Autre journalière",'pourcent_autre_jour','<i class="fas fa-bolt"></i>',"%");
        
                $eqLogic->checkAndUpdateCmd('inst_circuit' . $i, $value,$date);
                $Eco_legrand_teleinfo->set_value('inst_circuit' . $i ,$value);
              
                $i=$i+1;

              }
              
            }
          }
          
          
        }
      
        
      }elseif(substr($nom_fichier , -3) == 'csv' || substr($nom_fichier , -3) == 'old'){
        $devResult = fopen($devAddr, "r");

        //self::add_log( 'info', $eqLogic->getName() . " " . $devAddr);

        //self::add_log( 'info', $eqLogic->getId() . " " .$eqLogic->getName());
        /*
        jour	mois	annee	heure	minute	energie_tele_info	prix_tele_info	energie_circuit1	prix_circuit1	energie_cirucit2	prix_circuit2	energie_circuit3	prix_circuit3	energie_circuit4	prix_circuit4	energie_circuit5	prix_circuit5	volume_entree1	volume_entree2	tarif	energie_entree1	energie_entree2	prix_entree1	prix_entree2
        17	   8	  15	   20	   2	     0.000	         0.000	          0.000	             0.000	      0.000	            0.000	         0.000	           0.000	       0.000	          0.000	        0.000	              0.000	          0.000	            0.000	     0	   0.000	          0.000	         0.000	        0.000
        17	8	15	21	2	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	11	0.000	0.000	0.000	0.000
        */

        if ($devResult === false) {
          if(substr($nom_fichier, -3) == 'csv'){
            //self::add_log( 'error', 'problème de connexion ' . $devAddr);
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
          while(!feof($devResult)){
            $line = fgets($devResult);
            $data= explode(";",$line);
            $jour = $data[0];
            $mois = $data[1];
            $annee = $data[2];
            $heure = $data[3];
            if(substr($nom_fichier,0,4) == 'log1'){
              $date = date('Y-m-d H:i:s', strtotime($annee . '-' . $mois . '-' . $jour .' ' . $heure .':00:00'. ' + 1 hours'));
            }else{
              $date =  $annee . '-' . $mois . '-' . $jour .' ' . $heure .':00:00';
            }
            

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
           
            $Eco_legrand_teleinfo->set_value('index_total_circuits' ,$valeur*1000);

            $valeur=round($data[7],2);
            if($valeur > $valeur_precedente_conso_circuit1){
              if ($valeur_precedente_conso_circuit1 == 0 ){
                $valeur_precedente_conso_circuit1 = $valeur;
              }
              self::add_log('debug', 'ajout valeur ' . $Eco_legrandCmd_conso_circuit1->getName().":" . $date . "=>". round($valeur- $valeur_precedente_conso_circuit1,2));
              $eqLogic->checkAndUpdateCmd('conso_circuit1_'.$jour_heure,round($valeur- $valeur_precedente_conso_circuit1,2),$date);
              $valeur_precedente_conso_circuit1 = $valeur;
            }
            $Eco_legrand_teleinfo->set_value('index_circuit1' ,$valeur*1000);

            $valeur=round($data[9],2);
            if ($valeur > $valeur_precedente_conso_circuit2){
              if ($valeur_precedente_conso_circuit2 == 0 ){
                $valeur_precedente_conso_circuit2 = $valeur;
              }
              self::add_log( 'debug', 'ajout valeur ' . $Eco_legrandCmd_conso_circuit2->getName().":" . $date . "=>". round($valeur - $valeur_precedente_conso_circuit2,2));
              $eqLogic->checkAndUpdateCmd('conso_circuit2_'.$jour_heure,round($valeur - $valeur_precedente_conso_circuit2,2),$date);
              $valeur_precedente_conso_circuit2 = $valeur;
            }
            $Eco_legrand_teleinfo->set_value('index_circuit2' ,$valeur*1000);

            $valeur=round($data[11],2);
            if($valeur > $valeur_precedente_conso_circuit3){
              if ($valeur_precedente_conso_circuit3 == 0 ){
                $valeur_precedente_conso_circuit3 = $valeur;
              }
              self::add_log( 'debug', 'ajout valeur ' . $Eco_legrandCmd_conso_circuit3->getName().":" . $date . "=>". round($valeur - $valeur_precedente_conso_circuit3,2));
              $eqLogic->checkAndUpdateCmd('conso_circuit3_'.$jour_heure,round($valeur - $valeur_precedente_conso_circuit3,2),$date);
              $valeur_precedente_conso_circuit3 = $valeur;
            }
            $Eco_legrand_teleinfo->set_value('index_circuit3' ,$valeur*1000);

            $valeur=round($data[13],2);
            if($valeur > $valeur_precedente_conso_circuit4){
              if ($valeur_precedente_conso_circuit4 == 0 ){
                $valeur_precedente_conso_circuit4 = $valeur;
              }
              self::add_log( 'debug', 'ajout valeur ' . $Eco_legrandCmd_conso_circuit4->getName().":" . $date . "=>". round($valeur - $valeur_precedente_conso_circuit4,2));
              $eqLogic->checkAndUpdateCmd('conso_circuit4_'.$jour_heure,round($valeur - $valeur_precedente_conso_circuit4,2),$date);
              $valeur_precedente_conso_circuit4 = $valeur;
            }
            $Eco_legrand_teleinfo->set_value('index_circuit4' ,$valeur*1000);

            $valeur=round($data[15],2);
            if($valeur > $valeur_precedente_conso_circuit5){
              if ($valeur_precedente_conso_circuit5 == 0 ){
                $valeur_precedente_conso_circuit5 = $valeur;
              }
              self::add_log( 'debug', 'ajout valeur ' . $Eco_legrandCmd_conso_circuit5->getName().":" . $date . "=>". round($valeur - $valeur_precedente_conso_circuit5,2));
              $eqLogic->checkAndUpdateCmd('conso_circuit5_'.$jour_heure,round($valeur - $valeur_precedente_conso_circuit5,2),$date);
              $valeur_precedente_conso_circuit5 = $valeur;
            }
            $Eco_legrand_teleinfo->set_value('index_circuit5' ,$valeur*1000);

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
      
          if($Eco_legrandCmd_conso_totale->getConfiguration('lastvalue') != $valeur_precedente_conso_totale) {
          $Eco_legrandCmd_conso_totale->setConfiguration('lastvalue', $valeur_precedente_conso_totale );
          $Eco_legrandCmd_conso_totale->save();
          }

          if($Eco_legrandCmd_conso_circuit1->getConfiguration('lastvalue') != $valeur_precedente_conso_circuit1) {
          $Eco_legrandCmd_conso_circuit1->setConfiguration('lastvalue',$valeur_precedente_conso_circuit1);
          $Eco_legrandCmd_conso_circuit1->save();
          }

          if($Eco_legrandCmd_conso_circuit2->getConfiguration('lastvalue') != $valeur_precedente_conso_circuit2) {
          $Eco_legrandCmd_conso_circuit2->setConfiguration('lastvalue',$valeur_precedente_conso_circuit2);
          $Eco_legrandCmd_conso_circuit2->save();
          }

          if($Eco_legrandCmd_conso_circuit3->getConfiguration('lastvalue') != $valeur_precedente_conso_circuit3) {
          $Eco_legrandCmd_conso_circuit3->setConfiguration('lastvalue',$valeur_precedente_conso_circuit3);
          $Eco_legrandCmd_conso_circuit3->save();
          }

          if($Eco_legrandCmd_conso_circuit4->getConfiguration('lastvalue') != $valeur_precedente_conso_circuit4) {
          $Eco_legrandCmd_conso_circuit4->setConfiguration('lastvalue',$valeur_precedente_conso_circuit4);
          $Eco_legrandCmd_conso_circuit4->save();
          }

          if($Eco_legrandCmd_conso_circuit5->getConfiguration('lastvalue') != $valeur_precedente_conso_circuit5) {
          $Eco_legrandCmd_conso_circuit5->setConfiguration('lastvalue',$valeur_precedente_conso_circuit5);
          $Eco_legrandCmd_conso_circuit5->save();
          }

          if($Eco_legrandCmd_conso_autre->getConfiguration('lastvalue') != $valeur_precedente_conso_autre) {
          $Eco_legrandCmd_conso_autre->setConfiguration('lastvalue',$valeur_precedente_conso_autre);
          $Eco_legrandCmd_conso_autre->save();
          }

        }
       
        
        fclose($devResult);

      }
    
      if ($nom_fichier  == "ti.json"){
        $nom_fichier  = "instant.json";
        goto redo;
      }
      if ($nom_fichier  == "instant.json"){
        $jour_heure = "jour";
        $nom_fichier  = "log1.old";
        goto redo;
      }
      if ($nom_fichier  == "log1.old"){
        $jour_heure = "jour";
        $nom_fichier  = "log1.csv";
        goto redo;
      }
      if ($nom_fichier  == "log1.csv"){
        $jour_heure = "heure";
        $nom_fichier  = "log2.old";
        goto redo;
      }
      if ($nom_fichier  == "log2.old"){
        $jour_heure = "heure";
        $nom_fichier  = "log2.csv";
        goto redo;
      }
    
      $Eco_legrand_teleinfo->save();
      
      $eqLogic->setConfiguration("Importation en cours",0);
      $eqLogic->save(true);
      $eqLogic->refreshWidget();
    } catch (Exception $e) { 
      self::add_log("debug","erreur get_all_datas");
      self::add_log("debug",$e->getMessage());
    }
  }
	public static function cron(){
		//self::add_log( 'debug', 'Synchronisation  du Jour.');
		Eco_legrand_teleinfo::crontabJour();
		//	conso_teleinfo::crontabSemaine();
	}

	public static function cronDaily(){
		//self::add_log('debug', 'Synchronisation de tous les jours');
		Eco_legrand_teleinfo::crontabAllJour(true);
	}
  static function getDateAbo($eqLogicId){

		/*ABONNEMENT FACTURE*/
		$date = new DateTime();
    $eqLogic=eqLogic::byId($eqLogicId);
    $c=$eqLogic->getConfiguration("date_abo","01/01");
    $d=explode("/",$c)[1] . "-" .explode("/",$c)[0];
    self::add_log( 'debug',$d);


		//$d = config::byKey('date_abo', 'conso', '01-01');
		$date_abo_year = config::byKey('date_abo_year', 'conso', 'Y');
		$date_debut = $date->format('Y-' . $d);
		$date_debut_graph = date("Y-m-d", strtotime('-11 month', strtotime($date->format('Y-m-' . '01'))));
		$date_fin = date("Y-m-d", strtotime('+1 year -1 day', strtotime($date->format('Y-' . $d))));

		if ($date_abo_year != 'Y') {//annee en cours -1
			if ($date_abo_year < 0) {
				$date_debut = date("Y-m-d", strtotime('-1 year', strtotime($date->format('Y-' . $d))));
				$date_fin = $date->format('Y-' . $d);
			}
		}


		$date_debut_old = date("Y-m-d", strtotime('-1 year', strtotime($date->format($date_debut))));
		$date_fin_old = date("Y-m-d", strtotime('-1 year', strtotime($date->format($date_fin))));


		$dju = new conso_dju();
		return  array(
			
			'date_debut_fact' => $date_debut, /*debut de l'abonnement (onglet outils)*/
			'date_fin_fact' => $date_fin,/*fin de l'abonnement (onglet outils)*/
			'date_debut_graph' => $date_debut_graph,
		  'date_debut_fact_old' => $date_debut_old, /*debut de l'abonnement prevision année -1 (onglet outils)*/
			'date_fin_fact_old' => $date_fin_old/*fin de l'abonnement prevision année -1  (onglet outils)*/

		);

	}

  public static function get_type_abo($id){
    
    $eqLogics = eqLogic::byId($id);
    $cmd_type_abo=Eco_legrandCmd::byEqLogicIdAndLogicalId($id,"OPTARIF");
    if (is_object($cmd_type_abo)){
      $type_abo=$cmd_type_abo->execCmd();
    }
		

		return $type_abo;
	}
  public static function get_intensite_max($id){
    
    $eqLogics = eqLogic::byId($id);
    $cmd_type_abo=Eco_legrandCmd::byEqLogicIdAndLogicalId($id,"ISOUC");
    if (is_object($cmd_type_abo)){
      $type_abo=$cmd_type_abo->execCmd();
    }
		

		return $type_abo;
	}
  
  static function CheckOptionIsValid(){

		$txt = '';
		$sql = "SELECT COUNT(*) AS nb FROM  Eco_legrand_prix WHERE IFNULL(`type`,'') = ''";
		$result = DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
		if ($result['nb'] > 0) {
			self::add_log( 'error', 'Configuration Prix  -> Merci de mettre a jour le type dans le prix ( Editer puis re-sauvegarder les prix ) ');
			$txt .= '<li>Configuration Prix  -> Merci de mettre a jour le type dans le prix ( Editer puis re-sauvegarder les prix ) </li>';
		}
				
		$sql = "SELECT COUNT(*) AS nb FROM  Eco_legrand_jour WHERE IFNULL(eqlogicID,0) = 0 ";
		$result = DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
		if ($result['nb'] > 0) {
			$sql = "delete FROM  Eco_legrand_jour WHERE IFNULL(id_eq,0) = 0 ";
			$result = DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
			Eco_legrand_teleinfo::crontabJour(false,2);
				}

		
		
		$sql = "SELECT COUNT(*) AS nb FROM  Eco_legrand_prix WHERE current_date() between date_debut and date_fin ";
		$result = DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
		if ($result['nb'] < 1) {
			self::add_log( 'error', 'Configuration Prix  -> Aucun prix n\'est configuré sur la periode en cours . Merci de renseigner un prix dans onglet Configuration Prix');
			$txt .= '<li>Configuration Prix  -> Aucun prix n\'est configuré sur la periode en cours . Merci de renseigner un prix dans onglet Configuration Prix </li>';
		}

		return $txt;
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
    self::install_sql();
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

  public static function install_sql(){
 
    $sql  = "CREATE TABLE IF NOT EXISTS `Eco_legrand_jour` (
      `timestamp` bigint(10) DEFAULT NULL,
      `date` date NOT NULL ,
      `conso_totale_hp` float DEFAULT '0',
      `conso_totale_hc` float DEFAULT '0',
      `index_total_max_hp` bigint(9) NOT NULL DEFAULT '0',
      `index_total_min_hp` bigint(9) NOT NULL DEFAULT '0',
      `index_total_max_hc` bigint(9) NOT NULL DEFAULT '0',
      `index_total_min_hc` bigint(9) NOT NULL DEFAULT '0',
      `Eqlogic_ID` int(11) NOT NULL DEFAULT '0',
      `temperature_max` float DEFAULT NULL,
      `temperature_min` float DEFAULT NULL,
      `temperature_moy` float DEFAULT NULL,
      `eqlogicID` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`date`,`eqlogicID`));";
    DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW, PDO::FETCH_CLASS, __CLASS__);
    $sql="CREATE TABLE IF NOT EXISTS `Eco_legrand_prix` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `hc` float DEFAULT NULL,
      `hp` float DEFAULT NULL,
      `date_debut` date ,
      `date_fin` date ,
      `type` varchar(255) DEFAULT 'electricité',
      `eqlogicID` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`));";
    DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW, PDO::FETCH_CLASS, __CLASS__);
      /*$sql="CREATE TABLE IF NOT EXISTS `Eco_legrand_teleinfo` (
        `timestamp` bigint(10) NOT NULL DEFAULT '0',
        `date` date NOT NULL ,
        `time` time NOT NULL DEFAULT '00:00:00',
        `index_hp` bigint(9) NOT NULL DEFAULT '0',
        `index_hc` bigint(9) NOT NULL DEFAULT '0',
        `ptec` varchar(2)  NOT NULL,
        `intensité_instantanée` tinyint(3) NOT NULL DEFAULT '0',
        `puissance_totale` int(5) NOT NULL DEFAULT '0',
        `index_circuit1` int(5) NOT NULL DEFAULT '0',
        `inst_circuit1` int(5) NOT NULL DEFAULT '0',
        `index_circuit2` int(5) NOT NULL DEFAULT '0',
        `inst_circuit2` int(5) NOT NULL DEFAULT '0',
        `index_circuit3` int(5) NOT NULL DEFAULT '0',
        `inst_circuit3` int(5) NOT NULL DEFAULT '0',
        `index_circuit4` int(5) NOT NULL DEFAULT '0',
        `inst_circuit4` int(5) NOT NULL DEFAULT '0',
        `index_circuit5` int(5) NOT NULL DEFAULT '0',
        `inst_circuit5` int(5) NOT NULL DEFAULT '0',
        `index_pulse1` int(5) NOT NULL DEFAULT '0',
        `inst_pulse1` int(5) NOT NULL DEFAULT '0',
        `index_pulse2` int(5) NOT NULL DEFAULT '0',
        `inst_pulse2` int(5) NOT NULL DEFAULT '0',
        `Eqlogic_ID` int(11) NOT NULL DEFAULT '0',
        `temperature` float DEFAULT NULL,
        PRIMARY KEY (`timestamp`,`Eqlogic_ID`),
        UNIQUE KEY `timestamp` (`timestamp`),
        KEY `date` (`date`),
        KEY `date_time` (`date`,`time`),
        KEY `time` (`time`),
        KEY `index_hc` (`index_hc`));";*/
      $sql="CREATE TABLE IF NOT EXISTS `Eco_legrand_teleinfo` (
        `timestamp` bigint(10) NOT NULL DEFAULT '0',
        `date` date NOT NULL ,
        `heure` time NOT NULL DEFAULT '00:00:00',
        `index_hp` bigint(9) NOT NULL DEFAULT '0',
        `index_hc` bigint(9) NOT NULL DEFAULT '0',
        `ptec` varchar(2)  NOT NULL,
        `int_instant` tinyint(3) NOT NULL DEFAULT '0',
        `puissance_totale` int(5) NOT NULL DEFAULT '0',
        `index_total_circuits` bigint(9) NOT NULL DEFAULT '0',
        `index_circuit1` bigint(9) NOT NULL DEFAULT '0',
        `index_circuit2` bigint(9) NOT NULL DEFAULT '0',
        `index_circuit3` bigint(9) NOT NULL DEFAULT '0',
        `index_circuit4` bigint(9) NOT NULL DEFAULT '0',
        `index_circuit5` bigint(9) NOT NULL DEFAULT '0',
        `index_pulse1` bigint(9) NOT NULL DEFAULT '0',
        `index_pulse2` bigint(9) NOT NULL DEFAULT '0',
        `eqlogicID` int(11) NOT NULL DEFAULT '0',
        `temperature` float DEFAULT NULL,
        PRIMARY KEY (`timestamp`,`eqlogicID`),
        KEY `date` (`date`),
        KEY `date_heure` (`date`,`heure`),
        KEY `heure` (`heure`),
        KEY `index_hc` (`index_hc`));";
    DB::Prepare($sql,array(), DB::FETCH_TYPE_ROW, PDO::FETCH_CLASS, __CLASS__);
  }
}

class Eco_legrandCmd extends cmd {
  public function dontRemoveCmd() {
    return true;
  }
}

?>