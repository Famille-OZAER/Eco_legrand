<?php

echo '<div  class="col-lg-12" id="conso_outil" style="padding-right:25px;border-left: solid 1px #EEE; padding-left: 25px;display:none;">

	<div id="div_outilAlert" style="display: none;"></div>

	<form class="form-horizontal">
        <fieldset>
		<div class="col-lg-6" class="span6">
          <div class="widget">
            <div class="widget-header"> <i class="icon-bookmark"></i>
              <h3>Synchronisations</h3>
            </div>
            <div class="widget-content">
              <div class="shortcuts" >
				<a onclick="javascript:void(0)" id="synch_day" class="shortcut"><i class="shortcut-icon icon-cog"></i><span class="shortcut-label">Tout Synchroniser</span> </a>
				<a onclick="javascript:void(0)" id="synch_this" class="shortcut"><i class="shortcut-icon icon-cog"></i><span class="shortcut-label">Aujourd\'hui</span> </a>
				<a onclick="javascript:void(0)" id="deamon_relaod" class="shortcut"><i class="shortcut-icon icon-wrench"></i><span class="shortcut-label">Relancer le Deamon</span> </a>
				</div>
            </div>
          </div>
		</div>


<div class="col-lg-6 span6" >
          <div class="widget">
            <div class="widget-header"> <i class="icon-bookmark"></i>
              <h3>Informations</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts" >
				<div id="big_stats">
					<a onclick="javascript:;"  class="shortcut"><div class="stat"><span class="value" id="date_trame"></span> <span class="shortcut-label">Date dernière Trame Téléinfo</span></div></a>
					<a onclick="javascript:;"  class="shortcut"><div class="stat"><span class="value" id="date_day"></span> <span class="shortcut-label">Date Table Jour</span></div></a>
					<a onclick="javascript:;"  class="shortcut"><div class="stat"><span class="value" id="date_mysql"></span> <span class="shortcut-label">Date mysql</span></div></a>
				</div>
            </div>
          </div>
		</div>
</div>
<div class="col-lg-12" class="span6">
          <div class="widget">
            <div class="widget-header"> <i class="icon-bookmark"></i>
              <h3>Outils</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts" >
				<a onclick="javascript:;"  id="id_equip" class="shortcut"><i class="shortcut-icon icon-cog"></i> <span class="shortcut-label">Changement ID Equipement</span></a>
				<a onclick="javascript:;"  id="del_id_equip" class="shortcut"><i class="shortcut-icon icon-cog"></i> <span class="shortcut-label">Supprimer un Equipement</span></a>
                <a onclick="javascript:;"  id="search_error" class="shortcut"><i class="shortcut-icon icon-search"></i> <span class="shortcut-label">Identifier les erreurs</span></a>
                <a onclick="javascript:;" id="purger" class="shortcut"><i class="shortcut-icon icon-trash"></i><span class="shortcut-label">Purger</span> </a>
            </div>
          </div>
          </div>
  </div>

<div class="col-lg-12 span6">
          <div class="widget">
            <div class="widget-header"> <i class="icon-bookmark"></i>
              <h3>Accessoires</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts" >
                <div class="form-group">
				    <label for="returnbtn" class="col-sm-2 control-label">Lien du bouton retour ( menu ) </label>
				    <div class="col-sm-8">
				      <input type="text" class="configKey form-control" data-l1key="btn_return" value="" id="btn_return" placeholder="">
				         </div>
				 </div>
				 <div class="form-group">
                       <label class="col-sm-2 control-label">Calculer la facture à partir du mois :</label>
                        <div class="col-lg-2">
                        <div class="input-group">
                            <input style="width: 60px;" type="text" class="configKey form-control dtimepickerMonth" data-l1key="date_abo" value="" id="date_abo" placeholder="">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                             <select  style="width: 190px;" class="configKey form-control dtimepickerMonth" data-l1key="date_abo_year" value="" id="date_abo_year">
                                    <option value="1">Année en cours</option>
                                    <option value="-1">Année -1</option>
                             </select>
                        </div>
                        </div>
                             <div class="col-lg-2" id="result_date"></div>
                    </div>
				  <div class="form-group">
				        <div class="col-sm-12">
				      <button id="savebtnreturn" type="button" class="btn btn-success">Sauvegarder</button>
				    </div>
				 </div>
            </div>
          </div>
          </div>
  </div>

	</fieldset>
	</form>
	</div>
	';

?>