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

  require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';


function Eco_legrand_install() {
  //exec('sudo chmod 777 '.dirname(__FILE__) . '/sql/install.sql');
 // $sql = file_get_contents(dirname(__FILE__) . '/sql/install.sql');
  //log::add('conso', 'debug', 'sql : '.$sql);

  //DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
  Eco_legrand::install_sql();
  Eco_legrand::deamon_start();
}

function legrandeco_update() {
  //exec('sudo chmod 777 '.dirname(__FILE__) . '/sql/install.sql');
  //$sql = file_get_contents(dirname(__FILE__) . '/sql/install.sql');
  //log::add('conso', 'debug', 'sql : '.$sql);

  //DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL);
  Eco_legrand::install_sql();
  $cron = cron::byClassAndFunction('Eco_legrand', 'getConsoall_heure');
  if (is_object($cron)) {
    $cron->remove();
  }
  $cron = cron::byClassAndFunction('Eco_legrand', 'getConsoAll_jour');
  if (is_object($cron)) {
    $cron->remove();
  }
  $cron = cron::byClassAndFunction('Eco_legrand', 'cron_getinfos');
  if (is_object($cron)) {
    $cron->remove();
  }
}

function Eco_legrand_remove() {
 
}
?>