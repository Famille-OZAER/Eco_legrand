<?php


    if (!isConnect()) {
        throw new Exception(__('401 - Accès non autorisé', __FILE__));
    }
    //include_file('desktop', 'panel', 'css', 'conso');


    $eq= eqLogic::byType('Eco_legrand');
    $type_abo = '';
    foreach ($eq as $eqLogic) {
        if ($eqLogic->getConfiguration('type') != 'eau' && $eqLogic->getConfiguration('type') != 'gaz' &&  $eqLogic->getIsEnable() == 1)  {
            $type_abo = ($type_abo == 'HCHP' ? 'HCHP' :Eco_legrand::get_type_abo($eqLogic->getId()));
            //break;
        }
    }

    //$type_abo = (count($eq)==0 ? 'HCHP' : Eco_legrand::get_type_abo($eq[0]->getId()) );

    $display = ($type_abo=='HC' ? '' : 'displaynone');
    $title = ($type_abo=='HC' ? 'HP:' : '');


    if(init('id_prix',false)){
        $id_prix = init('id_prix');
        $prix = Eco_legrand_prix::byId($id_prix);
        $prix->setDate_debut(Eco_legrand_prix::dateFr($prix->getDate_debut()));
        $prix->setDate_fin(Eco_legrand_prix::dateFr($prix->getDate_fin()));
       
    }else{
        $prix = new Eco_legrand_prix();
    }
?>

    <div class="row row-overflow">
        <form class="prixformulaire form-horizontal">
            <div class="form-group hide" >
                <label class="col-sm-5 control-label">{{Eqlogic ID:}}</label>
                <div class="col-lg-6">
                    <input class="eqlogic_id"   value="<?php echo init('eqlogic_id') ?>" readonly/> 
                </div>
            </div>
            <div class="form-group hide" >
                <label class="col-sm-5 control-label">{{Id Prix:}}</label>
                <div class="col-lg-6">
                <input id="id_prix"  value="<?php echo $prix->getId() ?>"  class="prixAttr"  data-l1key="id" readonly/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label">{{Date de début:}}</label>
                <div class="col-lg-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" id="date_debut"  value="<?php echo $prix->date_debut ?>" data-l1key="date_debut" class="dtimepicker prixAttr form-control pull-right" autocomplete="off" readonly style="cursor: pointer;">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label">{{Date de fin:}}</label>
                <div class="col-lg-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" id="date_fin"  value="<?php echo $prix->date_fin ?>" data-l1key="date_fin" class="dtimepicker prixAttr form-control pull-right" autocomplete="off" readonly style="cursor: pointer;">
                    </div>
                </div>
            </div>
            <div class="form-group hide">
                <label class="col-sm-5 control-label">{{Type:}}</label>
                <div class="col-lg-6">
                    <div class="btn-group" data-toggle="buttons" >
                        <?php
                            echo '<button type="button" class="btn btn-sm '.($prix->gettype()  == 'électricité' ? "btn-success" : "btn-danger").' "   '.($prix->gettype() == 'électricité' ? 'aria-pressed="true" ' : "").' id="type_elec" autocomplete="off">{{Elect}}</button>';
                            echo '<button type="button" class="btn btn-sm '.($prix->gettype()  == 'gaz' ? "btn-success" : "btn-danger").' "  '.($prix->gettype() == 'gaz' ? 'aria-pressed="true" ' : "").' id="type_gaz" autocomplete="off">{{Gaz}}</button>';
                            echo '<button type="button" class="btn btn-sm '.($prix->gettype()  == 'eau' ? "btn-success" : "btn-danger").' "  '.($prix->gettype() == 'eau' ? 'aria-pressed="true" ' : "").' id="type_eau" autocomplete="off">{{Eau}}</button>';
                        ?>
                    </div>
                    <input id="bt_type_ecq"  class="prixAttr"   data-l1key="type" value="<?php echo init('type') ?>"/>
                        

                </div>
            </div>
            <div class="form-group">
                <label id="labelhp" class="col-sm-5 control-label"><?php echo ($prix->gettype()  == 'électricité'  ? '{{Prix unitaire HT }}'.$title : 'Prix au M3'); ?></label>
                <div class="col-lg-6">
                    <div class="input-group">
                        <input type="text" id="hp"  value="<?php echo $prix->hp ?>" data-l1key="hp" class="prixAttr form-control pull-right" autocomplete="off"/> 
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?php $display =  $prix->gettype()  == 'eau' ? 'displaynone' : '';?>

                <div id="saisiehc" class="<?php echo $display ?> form-group">
                <label id="labelhc" class="col-sm-5 control-label">
                    <?php
                        if($prix->gettype() =='électricité'){
                            echo ('{{Prix unitaire HT HC:}}');
                        }else if($prix->gettype() =='gaz'){
                            echo ( 'Coefficient m3/kWh');
                        }else{
                            echo('Confirmer le prix au M3');
                        }
                    ?> 
                </label>
                <div class="col-lg-6">
                    <div class="input-group">
                        <input type="text" id="hc"  value="<?php echo $prix->hc ?>" data-l1key="hc" class="prixAttr form-control pull-right" autocomplete="off"/> 
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="col-lg-9 control-label">
                    <a style="display:block;"  class="btn btn-success PrixAction" data-action="ajoutprix"><i class="fa fa-plus-circle"></i> {{Enregistrer}}</a>
                </div>
            </div>
            
        </form>
    </div>

<script>
    if ($('#bt_type_ecq')[0].value == 'électricité') {
        $('#type_eau').removeClass("btn-success").addClass("btn-danger");
        $('#type_gaz').removeClass("btn-success").addClass("btn-danger");
        $('#type_elec').addClass("btn-success").removeClass("btn-danger");
        $('#labelhc').text('Prix unitaire HT HC:');
        $('#labelhp').text('Prix unitaire HT HP:');
        $('#saisiehc').show();
    } else if ($('#bt_type_ecq')[0].value == 'gaz') {
        $('#type_elec').removeClass("btn-success").addClass("btn-danger");
        $('#type_eau').removeClass("btn-success").addClass("btn-danger");
        $('#type_gaz').addClass("btn-success").removeClass("btn-danger");
        $('#labelhc').text('Coefficent m3/kWh:');
        $('#labelhp').text('Prix au M3:');
        $('#saisiehc').show();
    } else if ($('#bt_type_ecq')[0].value == 'eau') {
        $('#type_elec').removeClass("btn-success").addClass("btn-danger");
        $('#type_gaz').removeClass("btn-success").addClass("btn-danger");
        $('#type_eau').addClass("btn-success").removeClass("btn-danger");
        $('#labelhc').text('Prix au M3:');
        $('#labelhp').text('Prix au M3:');
        $('#saisiehc').hide();
    }

$('.PrixAction[data-action=ajoutprix]').on('click', function() {
    var erreur=false
    if($("#date_debut")[0].value==''){
        $('#div_alert').showAlert({ message: 'La date de début ne peut pas être vide.', level: 'danger' ,ttl:5000});
        erreur=true
    }
    if($("#date_fin")[0].value==''){
        $('#div_alert').showAlert({ message: 'La date de fin ne peut pas être vide.', level: 'danger' ,ttl:5000});
        erreur=true
    }
    if ($('#bt_type_ecq')[0].value == 'électricité') {
        console.log($("#date_debut")[0].value)
        
        if( $('#saisiehc')[0].value==''){
        $('#div_alert').showAlert({ message: 'Le montant HC ne peut pas être vide.', level: 'danger' ,ttl:5000});
        erreur=true
    }
    } else if ($('#bt_type_ecq')[0].value == 'gaz') { 

    } else if ($('#bt_type_ecq')[0].value == 'eau') {

    }
    if(erreur){
        return
    }
    $.ajax({
        type: 'POST',
        url: 'plugins/Eco_legrand/core/ajax/Eco_legrand.ajax.php',
        data: {
            action: 'Ajout_MAJPrix',
            event: json_encode($(this).closest('.prixformulaire').getValues('.prixAttr')[0]),
            eqlogic_id: $('.eqlogic_id').value(),
            id_prix: $('#id_prix').value()
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, error, $('#div_alert'));
        },
        success: function(data) {
            if (data.state != 'ok') {
                $('#div_alert').showAlert({ message: data.result, level: 'danger' });
                return;
            }
            refreshPrix();
            if ($('#id_prix').value() == "") {
                $('#div_alert').showAlert({ message: "Ajout executé avec succès.", level: 'success' });
            } else {
                $('#div_alert').showAlert({ message: "Moficiation executée avec succès.", level: 'success' });
            }

            $('#md_GestionPrix').dialog('close');
        }
    });

});

$('.dtimepicker').datepicker({
    lang: 'fr',
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true
});
</script>