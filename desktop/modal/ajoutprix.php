<?php


    if (!isConnect()) {
        throw new Exception(__('401 - Accès non autorisé', __FILE__));
    }
    //include_file('desktop', 'panel', 'css', 'conso');


    $eq= eqLogic::byType('Eco_legrand');
    $type_abo = '';
    foreach ($eq as $eqLogic) {
        if ($eqLogic->getConfiguration('type') != 'eau' && $eqLogic->getConfiguration('type') != 'gaz' &&  $eqLogic->getIsEnable() == 1)  {
            $type_abo = ($type_abo == 'HCHP' ? 'HCHP' :Eco_legrand::getAbo($eqLogic->getId()));
            //break;
        }
    }

    //$type_abo = (count($eq)==0 ? 'HCHP' : Eco_legrand::getAbo($eq[0]->getId()) );

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
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-5 control-label">{{Date de début:}}</label>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" id="date_debut"  value="<?php echo $prix->date_debut ?>" data-l1key="date_debut" class="dtimepicker prixAttr form-control pull-right" autocomplete="off">
                        </div><!-- /.input group -->
                    </div>
                </div><!-- /.form group -->

                <div class="form-group">
                    <label class="col-sm-5 control-label">{{Date de fin:}}</label>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" id="date_fin"  value="<?php echo $prix->date_fin ?>" data-l1key="date_fin" class="dtimepicker prixAttr form-control pull-right" autocomplete="off">
                        </div><!-- /.input group -->
                    </div>
                </div><!-- /.form group -->
                <div class="form-group">
                    <label class="col-sm-5 control-label">{{Type:}}</label>
                    <div class="col-lg-6">
                        <div class="btn-group" data-toggle="buttons" >
                            <?php
                                echo '<button type="button" class="btn btn-sm '.($prix->gettype()  == 'electricité' ? "btn-success" : "btn-danger").' "   '.($prix->gettype() == 'electricité' ? 'aria-pressed="true" ' : "").' id="type_elec" autocomplete="off">{{Elect}}</button>';
                                echo '<button type="button" class="btn btn-sm '.($prix->gettype()  == 'gaz' ? "btn-success" : "btn-danger").' "  '.($prix->gettype() == 'gaz' ? 'aria-pressed="true" ' : "").' id="type_gaz" autocomplete="off">{{Gaz}}</button>';
                                echo '<button type="button" class="btn btn-sm '.($prix->gettype()  == 'eau' ? "btn-success" : "btn-danger").' "  '.($prix->gettype() == 'eau' ? 'aria-pressed="true" ' : "").' id="type_eau" autocomplete="off">{{Eau}}</button>';
                            ?>
                        </div>
    <input id="bt_type_ecq"  type="hidden"  class="prixAttr"   data-l1key="type" value="<?php echo $prix->gettype() ?>"/>
    </div>
    </div>

    <div class="form-group">
    <label id="labelhp" class="col-sm-5 control-label"><?php echo ($prix->gettype()  == 'electricité'  ? '{{Prix unitaire HT }}'.$title : 'Prix au M3'); ?></label>
    <div class="col-lg-6">
    <div class="input-group">
    <input type="text" id="hp"  value="<?php echo $prix->hp ?>" data-l1key="hp" class="prixAttr form-control pull-right" autocomplete="off">
    </div><!-- /.input group -->
    </div>
    </div><!-- /.form group -->
    <?php $display =  $prix->gettype()  == 'eau' ? 'displaynone' : '';?>

    <div id="saisiehc" class="<?php echo $display ?> form-group">
    <label id="labelhc" class="col-sm-5 control-label"><?php echo ($prix->gettype()  == 'electricité'  ? '{{Prix unitaire HT HC:}}' : ($prix->gettype()  == 'gaz' ? 'Coefficient m3/kWh' : 'Confirmer le prix au M3')); ?> </label>
    <div class="col-lg-6">
    <div class="input-group">
    <input type="text" id="hc"  value="<?php echo $prix->hc ?>" data-l1key="hc" class="prixAttr form-control pull-right" autocomplete="off">
    </div><!-- /.input group -->
    </div>
    </div><!-- /.form group -->


    <div class="form-actions">
    <div class="col-lg-9 control-label">
    <input id="id_prix" hidden value="<?php echo $prix->getId() ?>"  class="prixAttr"  data-l1key="id" />
    <a style="display:block;"  class="btn btn-success PrixAction" data-action="ajoutprix"><i class="fa fa-plus-circle"></i> {{Enregistrer}}</a>
    </div>
    </div>
    </fieldset>
    </form>
</div>

<?php include_file('desktop', 'Eco_legrand_ajout_prix', 'js', 'Eco_legrand'); ?>

