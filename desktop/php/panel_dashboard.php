<?php


echo '<div  class="col-lg-12" id="conso_dashboard" style="height:100%;">
		<div id="div_DashboardAlert" style="display: none;"></div>

		<div class="span6">
			<div class="row">
				<div class="col-lg-4" id="widget_tableau_prix">
					<div class="widget flip" id="tableau_prix">
					<div class="card">
						<div class="face front">
						<img class="icon_flip" src="plugins/conso/desktop/css/theme/img/elec.png" title="Voir la consommation">
						<div class="widget-header">
							<i class="icon-money"></i>
							<h3>Prix</h3>
							<span class="datesynchro"></span>
						</div>
						<div style="height:240px;" class="widget-content">
						<div class="col-xs-1 changeType" style="display:none;"><button type="button" class="icon-eye-open btn btn-default"></button></div>
						<table data-role="table" id="table-column-toggle" class="tableaueuros movie-list table table-striped table-bordered ui-responsive">
								<thead>
									<tr><th>Périodes</th><th class="tts" data-placement="top" data-toggle="tooltip" title="Prix HT + TVA!" ></th><th class=" dds " data-placement="top" data-toggle="tooltip" title="Prix HT + TVA">HC TTC</th><th data-placement="top" data-toggle="tooltip" title="Prix TTC + Abonnement (Si équipement Total) + TVA + Taxes">Total TTC</th></tr>
								</thead>
								<tbody>
								    <tr><td>Jour </td><td id="day_hp" ></td><td id="day_hc" class="dds "></td><td id="day_total"></td></tr>
								    <tr><td>Hier </td><td id="yesterday_hp" ></td><td id="yesterday_hc" class="dds "></td><td id="yesterday_total"></td></tr>
								    <tr><td>Semaine </td><td id="week_hp"></td><td id="week_hc" class="dds "></td><td id="week_total" ></td></tr>
								    <tr><td>Mois </td><td id="month_hp"></td><td id="month_hc" class="dds "></td><td id="month_total" ></td></tr>
								    <tr><td>Année <i data-toggle="tooltip"  data-placement="right" title="" class="fas fa-info-circle datefact"></i>
				                        </td><td id="year_hp"></td><td id="year_hc" class="dds "></td><td id="year_total"></td></tr>
								</tbody>
								</table>
						</div>
					</div>
					<div class="face back">
						<img class="icon_flip" src="plugins/conso/desktop/css/theme/img/euro.png" title="Voir le coût">
						<div class="widget-header">
							<i class="icon-money"></i>
							<h3>Consommation</h3>
							<span class="datesynchro"></span>
						</div>
						<div style="height:240px;" class="widget-content">
							<table data-role="table" id="table-column-toggle2 "  class="tableauwatt movie-list table table-striped table-bordered ui-responsive">
								<thead>
									<tr><th>Périodes</th><th class="tts2" ></th><th class="dds ">HC</th><th class="dds ">Total</th></tr>
								</thead>
								<tbody>
								  <tr><td>Jour </td><td id="day_hpw" ></td><td  id="day_hcw" class="dds "></td><td id="day_totalw" class="dds "></td></tr>
								  <tr><td>Hier </td><td id="yesterday_hpw" ></td><td id="yesterday_hcw" class="dds "></td><td id="yesterday_totalw" class="dds"></td></tr>
								  <tr><td>Semaine </td><td id="week_hpw" ></td><td  id="week_hcw" class="dds "></td><td id="week_totalw" class="dds "></td></tr>
								  <tr><td>Mois </td><td id="month_hpw" ></td><td  id="month_hcw" class=" dds "></td><td id="month_totalw" class="dds "></td></tr>
								  <tr><td>
								        Année <i data-toggle="tooltip"  data-placement="right" title="" class="fas fa-info-circle datefact"></i>
				                        </td><td id="year_hpw"></td><td  id="year_hcw" class=" dds "></td><td id="year_totalw" class="dds "></td></tr>
								</tbody>
							</table>
						</div>
					</div>
					</div>
					</div>
				</div>

				<div class="col-lg-4" id="widget_Consobox">
					<div class="row">
						<div style="display:none" id="Consobox" class="TableauBox widget flip"></div>
						<div style="display:none" id="previsionbox" class="TableauBox widget flip">
							<div class="card">
								<div class="face front">
									<div  id="prevision">
										<div class="widget-header">
											<i class="icon-eye-open"></i>
											<h3>Prévisions</h3>
											<span class="icon_return redcolor">Voir les relevés</span>
										</div>
										<div id="content_prevision" style="height:240px;" class="widget-content">
											<div class=" prevision col-lg-12">
												<div class="previsionbox nopadding col-lg-2">
													<img id="imgcharge" class="img_charge" src="plugins/conso/desktop/css/theme/img/charge/charge.png" title="">
												</div>
												<div class="col-lg-4 statcharge">
														<div id="consomme_contener">Consommé : <span id="consomme" class="pre_value"></span></div>
														<div id="budget_contener">Budget : <span id="budget" class="pre_value"></span></div>
														<div id="reste_contener">Reste : <span id="reste" class="pre_value"></span></div>
												</div>
												<div class="col-lg-6 statcharge">
													<span class="title">Prévision du mois en cours</span> : <span id="Eurosprevi"></span>' .config::byKey('Devise', 'conso').'<br>
													<span class="title">Coût du mois en cours</span> : <span id="Eurosmontant"></span>' .config::byKey('Devise', 'conso').' HT <span id="percent_Montant"></span><br>
													<span class="title">	Economies réalisées</span> : <span id="economie"></span>' .config::byKey('Devise', 'conso').'
												</div>
											</div>
											<div class="row">
												<div class=" previsionyear col-lg-12">
													<div class="nopadding col-lg-2">
														<img id="imgcharge_year" class="img_charge" src="plugins/conso/desktop/css/theme/img/charge/charge.png" title="">
													</div>
													<div class="col-lg-4 statcharge ">
															<div id="consomme_contener_year">Consommé : <span id="consomme_year" class="pre_value"></span></div>
															<div id="budget_contener_year">Budget : <span id="budget_year" class="pre_value"></span></div>
															<div id="reste_contener_year">Reste : <span id="reste_year" class="pre_value"></span></div>
													</div>
													<div class="col-lg-6 statcharge">
														<span class="title">Prévision sur 1 an
														<!--<i data-toggle="tooltip"  data-placement="right" title="" class="fas fa-info-circle datefactyearold"></i>-->
														</span> : <span id="Eurosprevi_year"></span>' .config::byKey('Devise', 'conso').' HT<br>
														<span class="title">Coût sur 1 an </span> : <span id="Eurosmontant_year"></span>' .config::byKey('Devise', 'conso').' HT<span id="percent_Montant_year"></span><br>
														<span class="title">	Economies réalisées sur 1 an</span> : <span id="economie_year"></span>' .config::byKey('Devise', 'conso').'<br>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="face back">

									<div id="config_prevision">
										<div class="widget-header">
											<i class="icon-wrench"></i>
											<h3 id="title_tb2">Année-1 (Kwh)</h3>
											<span class="icon_return redcolor">Retour</span>
										</div>
										<div id="param_prevision" style="height:240px;" class="widget-content">
											<div  class="prevision nopadding nomargin  col-lg-12">
												<div class="col-lg-6 nopadding nomargin">
													<table  data-role="table" id="table-column-toggle2"  class="movie-list table table-striped table-bordered ui-responsive">
													<thead>
														<tr><th nowrap>Mois</th><th nowrap>Relevé<span class="dds"> (HP/HC)</span></th></tr>
													</thead>
														<tbody>
																<tr class="previcase previcase_0"><th id="month_0" class="previcasevalue"></th><td  nowrap><span id="previ_annee_0" class="previcasevalue"></span><span  id="previ_annee_0_hp" class="dds previcasevalue"></span><span id="previ_annee_0_hc" class="dds previcasevalue"></span></td></tr>
																<tr class="previcase previcase_1"><th id="month_1" class="previcasevalue"></th><td  nowrap><span id="previ_annee_1" class="previcasevalue"></span><span id="previ_annee_1_hp" class="dds previcasevalue"></span><span id="previ_annee_1_hc" class="dds previcasevalue"></span></td></tr>
																<tr class="previcase previcase_2"><th id="month_2" class="previcasevalue"></th><td  nowrap><span id="previ_annee_2" class="previcasevalue"></span><span id="previ_annee_2_hp" class="dds previcasevalue"></span><span id="previ_annee_2_hc" class="dds previcasevalue"></span></td></tr>
																<tr class="previcase previcase_3"><th id="month_3" class="previcasevalue"></th><td  nowrap><span id="previ_annee_3" class="previcasevalue"></span><span id="previ_annee_3_hp" class="dds previcasevalue"></span><span id="previ_annee_3_hc" class="dds previcasevalue"></span></td></tr>
																<tr class="previcase previcase_4"><th id="month_4" class="previcasevalue"></th><td  nowrap><span id="previ_annee_4" class="previcasevalue"></span><span id="previ_annee_4_hp" class="dds previcasevalue"></span><span id="previ_annee_4_hc" class="dds previcasevalue"></span></td></tr>
																<tr class="previcase previcase_5"><th id="month_5" class="previcasevalue"></th><td  nowrap><span id="previ_annee_5" class="previcasevalue"></span><span id="previ_annee_5_hp" class="dds previcasevalue"></span><span id="previ_annee_5_hc" class="dds previcasevalue"></span></td></tr>
														</tbody>
													</table>
												</div>
												<div class="col-lg-6 nopadding nomargin ">
													<table  data-role="table" id="table-column-toggle2"  class="movie-list table table-striped table-bordered ui-responsive">
													<thead>
															<tr><th nowrap>Mois</th><th nowrap>Relevé<span class="dds"> (HP/HC)</span></th></tr>
													</thead>
														<tbody>
																<tr class="previcase previcase_6"><th id="month_6" class="previcasevalue"></th><td  nowrap><span id="previ_annee_6" class="previcasevalue"></span><span id="previ_annee_6_hp" class="dds previcasevalue"></span><span id="previ_annee_6_hc" class="previcasevalue dds"></span></td></tr>
																<tr class="previcase previcase_7"><th id="month_7" class="previcasevalue"></th><td  nowrap><span id="previ_annee_7" class="previcasevalue"></span><span id="previ_annee_7_hp" class="dds previcasevalue"></span><span id="previ_annee_7_hc" class="previcasevalue dds"></span></td></tr>
																<tr class="previcase previcase_8"><th id="month_8" class="previcasevalue"></th><td  nowrap><span id="previ_annee_8" class="previcasevalue" ></span><span id="previ_annee_8_hp" class="dds previcasevalue"></span><span id="previ_annee_8_hc" class="previcasevalue dds"></span></td></tr>
																<tr class="previcase previcase_9"><th id="month_9" class="previcasevalue"></th><td  nowrap><span id="previ_annee_9" class="previcasevalue"></span><span id="previ_annee_9_hp" class="dds previcasevalue"></span><span id="previ_annee_9_hc" class="previcasevalue dds"></span></td></tr>
																<tr class="previcase previcase_10"><th id="month_10" class="previcasevalue"></th><td  nowrap><span id="previ_annee_10" class="previcasevalue"></span><span id="previ_annee_10_hp" class="dds previcasevalue"></span><span id="previ_annee_10_hc" class="previcasevalue dds"></span></td></tr>
																<tr class="previcase previcase_11"><th id="month_11" class="previcasevalue"></th><td  nowrap><span id="previ_annee_11" class="previcasevalue" ></span><span id="previ_annee_11_hp" class="dds previcasevalue"></span><span id="previ_annee_11_hc" class="previcasevalue dds"></span></td></tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="widget_gauge">
					<div id="widgetgauge" class="col-lg-2">
						<div class="widget">
							<div class="widget-header">
								<i class="icon-bolt"></i>
								<h3>Puissance</h3>
								<span class="date_isrefresh"></span>
							</div>
							<div style="height:240px;" class="widget-content">
								<div class="shortcuts" >
									<div id="contentegauge" class="box-body no-padding">
									<!--<div class="circle" id="circles-1"></div>	-->
									<div  id="gauge" class="inner"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			    <div class="col-lg-2" id="widget_variation">
					<div class="widget">
						<div class="widget-header">
							<i class="icon-list-alt"></i>
							<h3>Variation</h3>
							<span class="date_isrefresh"></span>
						</div>
						<div id="widgetvariation" style="height:240px;" class="widget-content">
							<div id="tab_list" class="shortcuts" >
								<div class="box-body no-padding">
									<table data-role="table" id="tab_info" class="movie-list table table-striped ui-responsive"></table>
								</div>
							</div>
						</div>
					</div>
			    </div>
			</div>

			<div class="row">
				<div id ="widget_currentBox">
					<div id="currentBox" class="col-lg-8">
						<div class="widget">
							<div class="widget-header">
								<div class="col-lg-7" style="display:block">
									<i class="icon-bar-chart"></i>
									<h3>Consommation du jour</h3>
									<span class="date_isrefresh"></span>
								</div>
								<div class="col-xs-1 changeType" style="display:none;"><button type="button" class="icon-eye-open btn btn-default"></button></div>
								<div class="col-lg-4">
									<div class="input-group input-daterange">
										<span class="input-group-addon">Du</span>
										<input id="current_debut" type="text" class="datecurrent datetimepicker form-control" value="">
										<span class="input-group-addon">au</span>
										<input id="current_fin" type="text" class=" datecurrent datetimepicker form-control" value="">
										<span id="validedatecurrent" class="input-group-addon">OK</span>
									</div>
								</div>
							</div>
							<div  class="widget-content">
								<div class="shortcuts" >
									<div id="contentebar" class="box-body no-padding">
										<div class="chart" id="Currentbar"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="widget_statBox">
					<div id="statBox" class="col-lg-4" style="height:320px">
						<div class="widget">
							<div class="widget-header">
								<div class="col-lg-8" style="display:block">
									<i class="icon-bar-chart"></i>
									<h3>Statistique</h3>
									<span class="datesynchro"></span>
								</div>
							</div>
							<div  class="widget-content">
								<div class="shortcuts" >';
									include('panel_carousel.php');
											echo '</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<!-- ligne 2 -->
			<div class="row">
			    <div class="col-lg-4" id="widget_Temp7jBox">
					<div class="flip widget">
						<div class="card">
							<div class="face front">
								<img id="Temp7jBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/temp.png" title="Voir les températures de cette période">
								<div class="widget-header">
									<i class="icon-bar-chart"></i>
									<h3>7 derniers jours</h3>
									<span class="datesynchro"></span>
								</div>
								<div style="height:340px;" class="  widget-content">
									<div class=" shortcuts" >
										<div class=" box-body no-padding">
											<div class="chart" id="Day" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="face back">
								<img class="icon_flip" src="plugins/conso/desktop/css/theme/img/elec.png" title="Voir la consommation de cette période">
								<div class="widget-header">
									<i class="icon-bar-chart"></i>
									<h3>Température 7 derniers jours</h3>
									<span class="datesynchro"></span>
								</div>
								<div style="height:340px;" class="  widget-content">
									<div class=" shortcuts" >
										<div class=" box-body no-padding">
											<div class="chart" id="TempDay" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			    <div class="col-lg-4" id="widget_Temp4sBox">
					<div class="flip widget">
						<div class="card">
							<div class="face front">
								<img id="Temp4sBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/temp.png" title="Voir les températures de cette période">
								<div class="widget-header">
									<i class="icon-bar-chart"></i>
									<h3>4 dernières semaines</h3>
									<span class="datesynchro"></span>
								</div>
								<div style="height:340px;" class="  widget-content">
									<div class=" shortcuts" >
										<div class=" box-body no-padding">
											<div class="chart" id="Month" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="face back">
								<img class="icon_flip" src="plugins/conso/desktop/css/theme/img/elec.png" title="Voir la consommation de cette période">
								<div class="widget-header">
									<i class="icon-bar-chart"></i>
									<h3>Température 4 dernières semaines</h3>
									<span class="datesynchro"></span>
								</div>
								<div style="height:340px;" class="  widget-content">
									<div class=" shortcuts" >
										<div class=" box-body no-padding">
											<div class="chart" id="TempMonth" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			    <div class="col-lg-4" id="widget_Temp12mBox">
					<div class="flip widget">
						<div class="card">
							<div class="face front">
								<img id="Temp12mBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/temp.png" title="Voir les températures de cette période">
								<div class="widget-header">
									<i class="icon-bar-chart"></i>
									<h3>12 derniers mois</h3>
									<span class="datesynchro"></span>
								</div>
								<div style="height:340px;" class="  widget-content">
									<div class=" shortcuts" >
										<div class=" box-body no-padding">
											<div class="chart" id="Year" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="face back">
								<img class="icon_flip" src="plugins/conso/desktop/css/theme/img/elec.png" title="Voir la consommation de cette période">
								<div class="widget-header">
									<i class="icon-bar-chart"></i>
									<h3>Température 12 derniers mois</h3>
									<span class="datesynchro"></span>
								</div>
								<div style="height:340px;" class="  widget-content">
									<div class=" shortcuts" >
										<div class=" box-body no-padding">
											<div class="chart" id="TempYear" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ligne 3 -->
			<div class="row">
				<div class=" col-lg-4" id="widget_DJU7jBox">
					<div class="flip widget">
						<div class="card">
							<div class="face front">
								<img id="DJU7jBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/dju.png" title="Voir les DJU  de cette période">
								<div class="widget-header">
									<i class="icon-bar-chart"></i>
									<h3>7 derniers jours en '.config::byKey('Devise', 'conso').' (HT)</h3>
									<span class="datesynchro"></span>
								</div>
								<div style="height:340px;" class="widget-content">
									<div class="shortcuts" >
										<div class="box-body no-padding">
											<div class="chart" id="DayEuro" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="face back">
								<img class="icon_flip" src="plugins/conso/desktop/css/theme/img/euro.png" title="Voir  la consommation de cette période">
								<div class="widget-header">
									<i class="icon-bar-chart"></i>
									<h3>DJU des 7 derniers jours</h3>
									<span class="datesynchro"></span>
								</div>
								<div style="height:340px;" class="  widget-content">
									<div class=" shortcuts" >
										<div class=" box-body no-padding">
											<div class="chart" id="DayDJU" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			    </div>
				<div class=" col-lg-4" id="widget_DJU4sBox">
					<div class="flip widget">
						<div class="card">
							<div class="face front">
									<img id="DJU4sBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/dju.png" title="Voir les DJU de cette période ">
									<div class="widget-header">
										<i class="icon-bar-chart"></i>
										<h3>4 dernières semaines en '.config::byKey('Devise', 'conso').' (HT)</h3>
										<span class="datesynchro"></span>
									</div>
									<div style="height:340px;" class="widget-content">
										<div class="shortcuts" >
											<div class="box-body no-padding">
													<div class="chart" id="MonthEuro" style="height:300px;"></div>
											</div>
									</div>
								</div>
							</div>
							<div class="face back">
								<img class="icon_flip" src="plugins/conso/desktop/css/theme/img/euro.png" title="Voir la consommation de cette période">
								<div class="widget-header">
									<i class="icon-bar-chart"></i>
									<h3>DJU des 4 dernières semaines</h3>
									<span class="datesynchro"></span>
								</div>
								<div style="height:340px;" class="  widget-content">
									<div class=" shortcuts" >
										<div class=" box-body no-padding">
											<div class="chart" id="MonthDJU" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			    </div>
				<div class=" col-lg-4" id="widget_DJU12mBox">
					<div class="flip widget">
						<div class="card">
							<div class="face front">
								<img id="DJU12mBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/dju.png" title="Voir les DJU de cette période">
								<div class="widget-header">
									<i class="icon-bar-chart"></i>
									<h3>12 derniers mois en '.config::byKey('Devise', 'conso').' (HT)</h3>
									<span class="datesynchro"></span>
								</div>
								<div style="height:340px;" class="widget-content">
									<div class="shortcuts" >
										<div class="box-body no-padding">
											<div class="chart" id="YearEuro" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="face back">
								<img class="icon_flip" src="plugins/conso/desktop/css/theme/img/euro.png" title="Voir la consommation de cette période">
								<div class="widget-header">
									<i class="icon-bar-chart"></i>
									<h3>DJU des 12 derniers mois</h3>
									<span class="datesynchro"></span>
								</div>
								<div style="height:340px;" class="  widget-content">
									<div class=" shortcuts" >
										<div class=" box-body no-padding">
											<div class="chart" id="YearDJU" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			    </div>
			</div>
			<!-- ligne 4 -->
			<div class="row">
			    <div class="col-lg-6" id="widget_YearTaxe">
			    	<div class="widget">
						<div class="widget-header">
							<i class="icon-bar-chart"></i>
							<h3>12 derniers mois TTC</h3>
							<span class="datesynchro"></span>
						</div>
						<div style="height:340px;" class="widget-content">
							<div class="shortcuts" >
								<div class="box-body no-padding">
									<div class="chart" id="YearTaxe" style="height:300px;"></div>
								</div>
							</div>
						</div>
					</div>
			    </div>
				<div id="widget_DJUBox">
					<div id="DJUBox" class="col-lg-6">
						<div class="widget">
							<div class="widget-header">
								<i class="icon-bar-chart"></i>
								<h3>Degré jour unifié par an</h3>
								<span class="datesynchro"></span>
							</div>
							<div style="height:340px;" class="widget-content">
								<div class="shortcuts" >
									<div class="box-body no-padding">
										<div class="chart" id="DJUYear" style="height:300px;"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ligne 5 -->
			<div class="row">
			    <div class="col-lg-6" id="widget_PluriYear">
			    	<div class="flip widget">
						<div class="card">
							<div class="face front">
								<img id="Temp12mBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/temp.png" title="Voir les températures de cette période">
								<div class="widget-header">
									<i class="icon-bar-chart"></i>
									<h3>Pluriannuel</h3>
									<span class="datesynchro"></span>
								</div>
								<div style="height:340px;" class="widget-content">
									<div class="shortcuts" >
										<div class="box-body no-padding">
											<div class="chart" id="pluri" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="face back">
								<img class="icon_flip" src="plugins/conso/desktop/css/theme/img/elec.png" title="Voir la consommation de cette période">
								<div class="widget-header">
									<i class="icon-bar-chart"></i>
									<h3>Température pluriannuelles</h3>
									<span class="datesynchro"></span>
								</div>
								<div style="height:340px;" class="  widget-content">
									<div class=" shortcuts" >
										<div class=" box-body no-padding">
											<div class="chart" id="pluriTemp" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			    </div>
				<div class="col-lg-6" id="widget_PluriYearEuro">
					<div class="flip widget">
						<div class="card">
							<div class="face front">
								<img id="DJUaBox" class="icon_flip" src="plugins/conso/desktop/css/theme/img/dju.png" title="Voir les DJU de cette période">
								<div class="widget-header">
									<i class="icon-bar-chart"></i>
									<h3>Pluriannuel en '.config::byKey('Devise', 'conso').' (HT)</h3>
									<span class="datesynchro"></span>
								</div>
								<div style="height:340px;" class="widget-content">
									<div class="shortcuts" >
										<div class="box-body no-padding">
											<div class="chart" id="pluriEuro" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="face back">
								<img class="icon_flip" src="plugins/conso/desktop/css/theme/img/euro.png" title="Voir la consommation de cette période">
								<div class="widget-header">
									<i class="icon-bar-chart"></i>
									<h3>DJU pluriannuels</h3>
									<span class="datesynchro"></span>
								</div>
								<div style="height:340px;" class="  widget-content">
									<div class=" shortcuts" >
										<div class=" box-body no-padding">
											<div class="chart" id="pluriDJU" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>';
?>
