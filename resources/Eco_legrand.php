<?php
  require_once dirname(__FILE__).'/../../../core/php/core.inc.php';
function start(){
  $pid_file = jeedom::getTmpFolder('Eco_legrand') . '/Eco_legrand.pid';
  $pid=getmypid();
  file_put_contents($pid_file, $pid);
  // Eco_legrand::add_log( 'info', "pid $pid enregistré dans $pid_file");
  // Eco_legrand::add_log( 'info', "Listage des eqLogics ");
  $nb_eqLogics=0;
  while (1==1){
    
    $eqLogics = eqLogic::byType('Eco_legrand');
    if(count((array)$eqLogics) != $nb_eqLogics){
      if (count((array)$eqLogics) > 1){
        Eco_legrand::add_log( 'info', count((array)$eqLogics)." eqLogics trouvés");
      }else{
        Eco_legrand::add_log( 'info', count((array)$eqLogics)." eqLogic trouvé");
      }
    }
    
    $nb_eqLogics=count((array)$eqLogics);
    foreach ($eqLogics as $eqLogic){
      $fullname=jeedom::getTmpFolder('Eco_legrand') . '/Eco_legrand_'.$eqLogic->getId().'.pid';
      if (file_exists($fullname)){
        if (@posix_getsid(trim(file_get_contents($fullname))))
        {              
          continue;
        }
      }
      exec("sudo /usr/bin/php ".__FILE__." ".$eqLogic->getId()." > /dev/null 2>/dev/null &");
    }
    //  Eco_legrand::add_log( 'info',"Fin de lancement des eqLogics");
    sleep(10);
  }

    sleep(10);
  //}
}
function recupData($id){
  $pid_file = jeedom::getTmpFolder('Eco_legrand') . '/Eco_legrand_'.$id.'.pid';
  $pid=getmypid();
  file_put_contents($pid_file,$pid);
  //Eco_legrand::add_log( 'info',$pid);
  $eqLogic=eqLogic::byId($id);
  $Dernière_execution_function_démon = $eqLogic->getConfiguration("Dernière execution functions du démon","01/01/2000 00:00");
  $dernier_démon_minute = date('i', $Dernière_execution_function_démon);
  $dernier_démon_heure = date('H', $Dernière_execution_function_démon);
  $dernier_démon_jour = date('D', $Dernière_execution_function_démon);
  $importation_en_cours = $eqLogic->getConfiguration("Importation en cours",0);
  while(1==1){
    if($eqLogic->getIsEnable() == 1){
      $démon_minute = date("i");
      $démon_heure = date("H");
      if ($démon_minute != $dernier_démon_minute){
        $dernier_démon_minute = $démon_minute;
        //Eco_legrand::getInformations($eqLogic);
        //Eco_legrand::getData($eqLogic);
        Eco_legrand::get_TIC_instantanées($eqLogic);
        //Eco_legrand::add_log('debug',$Dernière_execution_function_démon);
        if($Dernière_execution_function_démon == "01/01/2000 00:00"){
          $dernier_démon_heure = $démon_heure;
          $eqLogic->setConfiguration("Importation en cours",1);
          $eqLogic->save(true);
          $importation_en_cours = 1;
          Eco_legrand::getConsoElec($eqLogic);
          $eqLogic->setConfiguration("Importation en cours",0);
          $eqLogic->save(true);
          $Dernière_execution_function_démon = date("d/m/Y H:i");
          $importation_en_cours = 0;
        }
        $eqLogic->setConfiguration("Dernière execution functions du démon",date("d/m/Y H:i"));
        $eqLogic->save(true);
      }
    
      
      if ($démon_heure != $dernier_démon_heure && $démon_minute == 4 ){
        if( $importation_en_cours != 1){
          $dernier_démon_heure = $démon_heure;
          $eqLogic->setConfiguration("Importation en cours",1);
          $eqLogic->save(true);
          $importation_en_cours = 1;
          Eco_legrand::getConsoElec($eqLogic);
          $eqLogic->setConfiguration("Importation en cours",0);
          $eqLogic->save(true);
          $importation_en_cours = 0;
        }
        
      }
      

      sleep(1);
    }
  }
}

 
if (strtoupper($argv[1])=="START"){
  Eco_legrand::add_log( 'info',"Démarrage du démon");
  start();
} else if(is_numeric($argv[1])){
  // Eco_legrand::add_log( 'info',"Recupération des données de $argv[1]");
  recupData($argv[1]);
}
?>