<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';


setlocale(LC_ALL , "fr_FR" );
date_default_timezone_set("Europe/Paris");

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

if (!function_exists('is_countable')) {
    function is_countable($var) {
        return (is_array($var) || $var instanceof Countable);
    }
}

$abo_view =1;
$id_ecq = init('id_ecq');
$eqLogics = eqLogic::byId($id_ecq);
$pulse = (!$eqLogics->getConfiguration('pulse') ? 1 : (float)$eqLogics->getConfiguration('pulse'));

$tarif_type=  'HCHP';
$type_ecq = "electricity";


$id_periode =init('id',false);
$prevision = (isset($_POST['prevision']) ? $_POST['prevision'] : false);

//log::add('conso', 'debug', 'init(id):'.init('id'));
if(init('id')){
	$periodes = conso_periode::GetPeriodes($id_periode);
	$xlabel = 'du '. $periodes[0]['date_debut'] .' au '.$periodes[0]['date_fin'];
	$timestampdebut = $periodes[0]['date_debut_timestamp'];
	$timestampfin = $periodes[0]['date_fin_timestamp'] ;

	$debut_old = $periodes[0]['date_debut_year_old'];
	$fin_old = $periodes[0]['date_fin_year_old'] ;

	$pdate_debut = $periodes[0]['date_debut'];
	$pdate_fin = $periodes[0]['date_fin'];
	$year_old = (int)$periodes[0]['year_old'];
	$yesterday = (int)$periodes[0]['year_old'];

	$libelle = $periodes[0]['libelle'];
	$graph_mode = $periodes[0]['type'];

	$type_graph = $periodes[0]['graph'];

	$type_graphHP = $periodes[0]['type_graphHP'];
	$type_graphHC =$periodes[0]['type_graphHC'];
	$type_graphHP_OLD = $periodes[0]['type_graphHP_OLD'];
	$type_graphHC_OLD = $periodes[0]['type_graphHC_OLD'];

}else{
	if(init('debut',false) && init('fin',false) && init('graph_type',false)){
		//log::add('conso', 'debug', 'init autre du '. init('debut') .' au '.init('fin'));
		$xlabel = 'du '. init('debut') .' au '.init('fin');


		$pdate_debut = init('debut');
		$pdate_fin = init('fin');
		$timestampdebut = strtotime($pdate_debut);
		$timestampfin = strtotime($pdate_fin);

		$year_old = init('old',false);
		$yesterday =  init('yesterday',false);
		$libelle = init('libelle',false);

		$graph_mode =  init('graph_mode',false);
		$type_graph =  init('graph_type',false);

		$type_graphHP = init('type_graphHP',false);
		$type_graphHC = init('type_graphHC',false);
		$type_graphHP_OLD =  init('type_graphHP_OLD',false);
		$type_graphHC_OLD = init('type_graphHC_OLD',false);
	}

}

$total_hp_old_prix = 0;
$total_hc_old_prix = 0;
$timestp_old  = 0;


$result = Eco_legrand_teleinfo::get_calcul_prix($pdate_debut,$pdate_fin,$type_graph,false,false,$id_periode,false,$id_ecq);

$num_rows = is_array($result) && count($result) ;

if($num_rows==0){
	$data =  array(
	'trouv' => false,
	'title' => "Aucune donnée à charger"
	);
	ajax::success(jeedom::toHumanReadable($data));
return;
}

$abonnement  = 0;
$abo_annuel = 0;
$no_old = 0 ;
$no_hier = 0 ;
$mois = array();
$annee = array();
$kwhhc_old = array();
$kwhhp_old = array();
$total_hp_old_prix = array();
$total_hc_old_prix = array();
$abo_old = array();
$timestp_old = array();
$mois_old = array();
$graph_year_old ='';

$total_periode_old_hp = 0;
$total_periode_old_hc = 0;
$total_periode_hier_hp = 0;
$total_periode_hier_hc = 0;

/*HEURE PLEINE hier*/
$kwhhp_hier = array();
$total_hp_hier_prix= array();
$type_graphHP_hier= array();

/*HEURE CREUSE hier*/
$kwhhc_hier= array();
$total_hc_hier_prix= array();
$type_graphHC_hier= array();
$abo_hier = array();

if($yesterday && $yesterday!='false'){
		/************************************/
		/*Afficher semaine précedente*/
		/************************************/
		$result_hier = Eco_legrand_teleinfo::get_calcul_prix($pdate_debut,$pdate_fin,$type_graph,false,$num_rows,true,false,$id_ecq);/*semaine derniere*/
		$num_rows_hier = is_array($result_hier) && count($result_hier) ;
		if($num_rows_hier>0){
		        $data_year_hier = true;
		}

		for ($i=0; $i < $num_rows-$num_rows_hier; $i++) {
					$abo_hier[$i]= null;
                    $kwhhp_hier[$i]= null;
                    $kwhhc_hier[$i]=null;
					$timestp_hier[$i] = null;
                    $total_hp_hier_prix[$i] = null;
					$total_hc_hier_prix[$i] = null;
			$no_hier++;
		}

		if($data_year_hier){
			foreach ($result_hier as $row_hier )  {
					$abo_hier[$no_hier] = checkPrice($row_hier["abonnement"]);
					$timestp_hier[$no_hier] = $row_hier["categorie"];
					$kwhhp_hier[$no_hier] = checkPrice($row_hier["hp"]) * $pulse;
					$kwhhc_hier[$no_hier] = checkPrice($row_hier["hc"]) * $pulse;
					$total_hp_hier_prix[$no_hier] = checkPrice($row_hier["total_hp"]) * $pulse;
					$total_hc_hier_prix[$no_hier] = checkPrice($row_hier["total_hc"]) * $pulse;
					$total_periode_hier_hp += (($row_hier["total_hp"]*$row_hier["tva"])/100 * $pulse) +$row_hier["total_hp"] * $pulse ;
					$total_periode_hier_hc += (($row_hier["total_hc"]*$row_hier["tva"])/100 * $pulse) +$row_hier["total_hc"] * $pulse ;

					$no_hier++ ;
			 }
		}
}else{
	$data_hier= false;
}


$no = 0 ;
$date_deb=0; // date du 1er enregistrement
$date_fin=time();
$total_periode_hp = 0;
$total_periode_hc = 0;
$hptot = 0;
$abo = array();
$fixe = 0;
$total_fixe = array();
$total_inte = array();



$data_year_old = false;
if($year_old && $year_old!='false'){
		/************************************/
		/*Afficher année précedente*/
		/************************************/

		$kwhhp_old = array();
		$kwhhc_old = array();
		//log::add('conso', 'debug', 'year_old date deb:'.$pdate_debut.' date fin:'.$pdate_fin);
		$result_old = Eco_legrand_teleinfo::get_calcul_prix($pdate_debut,$pdate_fin,$type_graph,true,false,false,false,$id_ecq);/*Année derniere*/
		$num_rows_old = is_array($result_old) && count($result_old) ;
		if($num_rows_old>0 && $result_old[0]['rec_date'] != 0){
		        $data_year_old = true;
		}
		$i=0;
}



if($result)
foreach  ($result as  $row)
  {

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

							/*Si graph 7 derniers jours alors il faut afficher en litre*/
							if($type_graph=='jours' && stripos($type_ecq, 'elect') === false) {
								$row_old["hp"] = $row_old["hp"] * 1000;/*Conversion des m3 en litre*/
								$row_old["hc"] = $row_old["hc"] * 1000;/*Conversion des m3 en litre*/
							}

							$val_kwhhp_old = checkPrice($row_old["hp"]) * $pulse;
							$val_kwhhc_old = checkPrice($row_old["hc"]) * $pulse;
							$val_kw = $val_kwhhp_old + $val_kwhhc_old;
							//log::add('conso', 'debug', 'kw_old:'.$val_kw);
							$val_total_hp_old_prix =  checkPrice($row_old["total_hp"]) * $pulse;
							$val_total_hc_old_prix = checkPrice($row_old["total_hc"]) * $pulse;
							$val_total_periode_old_hp =  (($row_old["total_hp"]*$row_old["tva"])/100 * $pulse) +$row_old["total_hp"] * $pulse ;
							$val_total_periode_old_hc = (($row_old["total_hc"]*$row_old["tva"])/100 * $pulse) +$row_old["total_hc"] * $pulse ;

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
				if(!$day_old){
						$abo_old[$i]=null;
		                $kwhhp_old[$i]=null;
		                $kwhhc_old[$i]=null;
						$timestp_old[$i] = null;
						$mois_old[$i] = null;
		                $total_hp_old_prix[$i] = null;
						$total_hc_old_prix[$i] = null;

				}
				$i++;
		}

	/*conversion semaine en date*/
	if (substr($row["categorie"], 0, 3) == 'sem'){

	    $year = substr($row["categorie"],-2);
	    $week = substr($row["categorie"], 4,2);
	    $row["categorie"] = get_lundi_dimanche_from_week($week, (int)$year+2000);
	   // $row["categorie"] = $row["rec_date"];
	}

    if ($date_deb==0) {
		$date_deb = strtotime($row["date"]);
    }

     $date[$no] = $row["date"] ;
     $timestp[$no] = $row["categorie"];
     $mois[$no] = $row["mois"];
	 $annee[$no] = $row["annee"];


	  /*Si graph 7 derniers jours alors il faut afficher en litre*/
	  if($type_graph=='jours' && stripos($type_ecq, 'elect') === false) {
		  $row["hp"] = $row["hp"] * 1000;/*Conversion des m3 en litre*/
		  $row["hc"] = $row["hc"] * 1000;/*Conversion des m3 en litre*/
	  }

	$hp = checkPrice($row["hp"]) * $pulse;
	$hc = checkPrice($row["hc"]) * $pulse;
	$val_total_hp =  checkPrice($row["total_hp"]) * $pulse;
	$val_total_hc = checkPrice($row["total_hc"]) * $pulse;

	

	/*Temperature*/
	$temp_moy[$no] =   ($row["temp_moy"] != 0 ? (float)number_format(str_replace(",", ".", $row["temp_moy"]),2,'.','') : null);
	$temp_min[$no] =  ($row["temp_min"] != 0 ?   (float)number_format(str_replace(",", ".", $row["temp_min"]),2,'.','') : null);
	$temp_max[$no] =  ($row["temp_max"] != 0 ? (float)number_format(str_replace(",", ".", $row["temp_max"]),2,'.','') : null);

	

	$ttc_hp =  (($val_total_hp * $row["tva"]) / 100) + $val_total_hp;
	$ttc_hc =  (($val_total_hc * $row["tva"]) / 100) + $val_total_hc;

    $kwhhp[$no] = ($hp > 0 ? $hp : null);
    $kwhhc[$no] = ($hc > 0 ? $hc : null);

	$total_hp[$no] =  ($val_total_hp > 0 ? $val_total_hp : null);
	$total_hc[$no] =  ($val_total_hc > 0 ? $val_total_hc : null);

	$total_hp_ttc[$no] = (checkPrice($ttc_hp) > 0 ?  checkPrice($ttc_hp) : null);
	$total_hc_ttc[$no] = (checkPrice($ttc_hc) > 0 ?  checkPrice($ttc_hc)  : null);

	//$total_fixe[$no] = ($fixe> 0 ? checkPrice(round($fixe/round(((strtotime($pdate_fin)-strtotime($pdate_debut))/86400)+1,0)*date('j',strtotime($date[$no])),2)) + $abon : null );
	//log::add('conso', 'debug', 'datedeb:'.$date[$no].' mois:'. $mois[$no].' Taxe fixe:'.$total_fixe[$no].' '.$pdate_fin.' '.$pdate_debut.' '.date('j',strtotime($date[$no])).' '.round(((strtotime($pdate_fin)-strtotime($pdate_debut))/86400)+1,0));
	$total_periode_hp += (($row["total_hp"]*$row["tva"])/100 * $pulse) +$row["total_hp"] * $pulse ;
	$total_periode_hc += (($row["total_hc"]*$row["tva"])/100 * $pulse) +$row["total_hc"] * $pulse ;
    $no++ ;

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

  $mnt_kwhbase = 0;
  $mnt_kwhhp = 0;
  $mnt_kwhhc = 0;
  $mnt_abonnement = 0;
  $i = 0;

$mnt_abonnement = 0;
  $mnt_total = $mnt_abonnement + $mnt_kwhbase + $total_periode_hp + $total_periode_hc;
  if($year_old && $year_old!='false'){
        $mnt_total_old = $mnt_abonnement + $mnt_kwhbase + $total_periode_old_hp + $total_periode_old_hc;
  }
$subtitle = '';

 $display = ($tarif_type == "HCHP" ? ' ' : 'displaynone') ;
$title = ($tarif_type == "HCHP" ? 'HP' : 'TOTAL') ;
//  if ($tarif_type == "HCHP") {
		$subtitle = '<table class="table paper-tbl-theme table-bordered responsive  table-paper"><thead>	<tr><th class="center">Libelle</th><th class="center">'.$title.'</th><th class="center '.$display.'">HC</th><th class="'.$display.' center">Total</th></tr></thead><tbody>';
		$subtitle .= '<tr '.($year_old ? ' class="success" ' : ' ' ).'><td>Coût sur la période</td><td>'.round($total_periode_hp,2). config::byKey('Devise', 'conso').'</td><td class="'.$display.'">'.round($total_periode_hc,2). config::byKey('Devise', 'conso') .'</td><td class="'.$display.'">'.round($mnt_total,2). ' ' .config::byKey('Devise', 'conso').'</td></tr>';
		// $subtitle = "Total : ".round($mnt_total,2)."  ".($abo_view ? '<br> Abonnement : '.round($mnt_abonnement,2).' + ' : 'hors abonnement' )." (HP : ".round($total_periode_hp,2)." + HC : ".round($total_periode_hc,2)." )";
	if($year_old && $year_old!='false'){
		//   $subtitle .= "Total année précédente :".round($mnt_total_old,2)."  ".($abo_view ? '<br> Abonnement : '.round($mnt_abonnement,2).' + ' : 'hors abonnement' )." (HP : ".round($total_periode_old_hp,2)." + HC : ".round($total_periode_old_hc,2)." )";
		$subtitle .= '<tr class="warning"><td>Coût sur la période de l\'année précédente</td><td>'.round($total_periode_old_hp,2). ' ' .config::byKey('Devise', 'conso').'</td><td class="'.$display.'">'.round($total_periode_old_hc,2). config::byKey('Devise', 'conso').'</td><td class="'.$display.'">'.round($mnt_total_old,2). ' ' .config::byKey('Devise', 'conso').'</td></tr>';
		$subtitle .= '<tr class="info"><td>Différence</td><td>'.round($total_periode_hp-$total_periode_old_hp,2). config::byKey('Devise', 'conso') .'</td><td class="'.$display.'" >'.round($total_periode_hc-$total_periode_old_hc,2).config::byKey('Devise', 'conso') .'</td><td class="'.$display.'">'.round($mnt_total-$mnt_total_old,2).  ' ' .config::byKey('Devise', 'conso').'</td></tr>';
	}

		$subtitle .= '</tbody></table>';
// } else {
//    $subtitle = "Coût sur la période ".round($mnt_total,2)." Euro<br />( Abonnement : ".round($mnt_abonnement,2)." + BASE : ".round($mnt_kwhbase,2)." + HP : ".round($mnt_kwhhp,2)." + HC : ".round($mnt_kwhhc,2)." )";
//  }

/*
 * TEMPERATURES
 * test si le tableau contient que des null*/
$arrayTEMP_moy = (isset($temp_moy) ? array_filter($temp_moy, function($var){ return (!($var == '' || is_null($var)));}) : false);
$arrayTEMP_max =  (isset($temp_max) ? array_filter($temp_max, function($var){ return (!($var == '' || is_null($var)));}): false);
$arrayTEMP_min = (isset($temp_min) ?  array_filter($temp_min, function($var){ return (!($var == '' || is_null($var)));}): false);

$subtitle = '';

  $data =  array(
    'trouv' => true,
    'title' => "Prix $xlabel",
    'libelle' => $libelle,
    'subtitle' => $subtitle,
    'debut' =>  $date_deb*1000,
    'BASE_name' => (stripos($type_ecq, 'elect') !== false ?  'Heures de Base' : ($type_ecq == 'water' ? 'Consommation Eau' : ($type_ecq == 'oil' ? 'Consommation Fioul' : 'Consommation Gaz')) ),
   // 'BASE_data'=> $kwhbase,

/*---- TAXE FIXE : ABO + CTA -----*/

    'fixe_name' =>   'Fixe',
    'inte_name' =>   'Variable',
    'total_fixe' => $total_fixe,
	'total_inte' => $total_inte,

/*HEURE PLEINE*/
    'HP_name' =>    (stripos($type_ecq, 'elect') !== false ? ($tarif_type == "HCHP" ? 'Heures Pleines' : 'Heures de Base' ) : ($type_ecq == 'water' ? 'Consommation Eau' : ($type_ecq == 'oil' ? 'Consommation Fioul' : 'Consommation Gaz')) ),
    'HP_data_prix' => (!isset($total_hp) ? null : $total_hp),
    'HP_data_prix_ttc' => (!isset($total_hp_ttc) ? null : $total_hp_ttc),
	'HP_data' => (!isset($kwhhp) ? null : $kwhhp),
	'HP_max' => (!isset($kwhhp) ? null : max($kwhhp)),
	'HP_max_key' =>  (!isset($kwhhp) ? null :  array_search(max($kwhhp),$kwhhp)),
	'HP_type_graph' => $type_graphHP ,

/*HEURE CREUSE*/
    'HC_name' => (stripos($type_ecq, 'elect') !== false ?  'Heures Creuses' : ($type_ecq == 'water' ? 'Consommation Eau' : ($type_ecq == 'oil' ? 'Consommation Fioul' : 'Consommation Gaz')) ),
    'HC_data_prix' => (!isset($total_hc) ? null :  $total_hc),
    'HC_data_prix_ttc' =>  (!isset($total_hc_ttc) ? null :  $total_hc_ttc),
	'HC_data' => (!isset($kwhhc) ? null :  $kwhhc),
	'HC_type_graph' => (!isset($type_graphHC) ? null :  $type_graphHC),


/*HEURE PLEINE hier*/
	'HP_name_hier' =>   (stripos($type_ecq, 'elect') !== false ?  ($tarif_type == "HCHP" ? 'HP Hier' : 'Hier' ) : ($type_ecq == 'water' ? 'Conso. Eau Hier' : ($type_ecq == 'oil' ? 'Conso. Fioul Hier' : 'Conso. Gaz Hier')) ),
	'HP_data_hier' => $kwhhp_hier,
	'HP_data_hier_prix' => $total_hp_hier_prix,
	'HP_type_graph_hier' => $type_graphHP_hier,

/*HEURE CREUSE hier*/
	'HC_name_hier' => 'HC Hier',
	'HC_data_hier' => $kwhhc_hier,
	'HC_data_hier_prix' => $total_hc_hier_prix,
	'HC_type_graph_hier' => $type_graphHC_hier,

/*HEURE PLEINE ANNEE -1*/
	//'HP_name_old' =>  ($type_ecq =='electricity' ?   ($tarif_type == "HCHP" ? 'HP ' : 'Heures de Base ' ) : 'Consommation Eau ' ).$graph_year_old,
	'HP_name_old' =>  (stripos($type_ecq, 'elect') !== false ?   ($tarif_type == "HCHP" ? 'HP ' : 'Heures de Base ' ) : ($type_ecq == 'water' ? 'Consommation Eau ' : ($type_ecq == 'oil' ? 'Consommation Fioul ' : 'Consommation Gaz ')) ).'An - 1',
	'HP_data_old' => $kwhhp_old,
	'HP_data_old_prix' => $total_hp_old_prix,
	'HP_type_graph_old' => $type_graphHP_OLD,

/*HEURE CREUSE ANNEE -1*/
	//'HC_name_old' => 'HC '.$graph_year_old,
	'HC_name_old' => 'HC An - 1',
	'HC_data_old' => $kwhhc_old,
	'HC_data_old_prix' => $total_hc_old_prix,
	'HC_type_graph_old' => $type_graphHC_OLD,

/*TEMPERATURES*/
	'TEMP_moy' => (is_array($arrayTEMP_moy) && count($arrayTEMP_moy) > 0 && $arrayTEMP_moy!==false ? $temp_moy : false),
	'TEMP_max' => (is_array($arrayTEMP_max) && count($arrayTEMP_max) > 0 && $arrayTEMP_max!==false ? $temp_max : false),
	'TEMP_min' => (is_array($arrayTEMP_min) && count($arrayTEMP_min) > 0 && $arrayTEMP_min!==false ? $temp_min : false),


/*AUTRES*/
	'num_annee' => (!isset($annee) ? null :  $annee),
	'num_mois' => (!isset($mois) ? null :  $mois),
    'categories' => (!isset($timestp) ? null :  $timestp),
    'categories_old' => $timestp_old,
    'mois_old' => $mois_old,
    'type_graph' =>  $type_graph,
    'type_ecq' =>  $type_ecq,


  //  'prix' => $prix,
	'point_start_day' => date("d", strtotime($pdate_debut)),
	'point_start_month' => date("m", strtotime($pdate_debut)),
	'point_start_year' => date("Y", strtotime($pdate_debut)),
    'affichage' => $graph_mode,/*0=Watt,1=Prix*/
    'tarif_type' => $tarif_type,
	'enabled_old' => ($graph_year_old =='' ? false : true ),
	'libelle_year_old' =>$graph_year_old,

	'MonthOld' => ($prevision ? $monthOld : false ) // prévision du mois de l 'année derniere
    );
	ajax::success($data);
	//ajax::success(jeedom::toHumanReadable($data));
 //return  json_encode($data);

 // mysql_close() ;


?>
