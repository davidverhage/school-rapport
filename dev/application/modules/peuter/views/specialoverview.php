<?php
/**
 * @id,
 * @Roepnaam,
 * @Tussenvoegsel,
 * @Achternaam,
 * @Geboortedatum ,
 * @ghg,
 * @lhg
 */
?>

<?php if ($this->session->flashdata('admin_feedback')) { ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> <?php echo $this->session->flashdata('admin_feedback'); ?>
    </div>
<?php } ?>

<div class="col-sm-12" style="padding-top:25px;">
    <h1>Overzicht</h1>
    <?php if ($this->user->has_permission('special_g')) { ?>
        <!-- About Section -->
        <section class="gymnastiek-section form-block">
            <div class="row ">
                <div class="well gym">
                    <h1>Gymnastiek</h1>
                    <label class="col-sm-3" for="gym_in"> Inzet </label>

                    <div class="btn-group" data-toggle="buttons">
                        <label
                                class="btn btn-default "><input
                                    name="gym_in" type="radio"
                                    value="1">O</label>
                        <label
                                class="btn btn-default "><input
                                    name="gym_in" type="radio"
                                    value="3">Z</label>
                        <label
                                class="btn btn-default "><input
                                    name="gym_in" type="radio"
                                    value="6">V</label>
                        <label
                                class="btn btn-default "><input
                                    name="gym_in" type="radio"
                                    value="8">RV</label>
                        <label
                                class="btn btn-default"><input
                                    name="gym_in" type="radio"
                                    value="10">G</label>
                    </div>
                    <hr/>

                    <label class="col-sm-3" for="gym_sv"> Sociale vaardigheden (samenwerken,luisteren) </label>

                    <div class="btn-group" data-toggle="buttons">
                        <label
                                class="btn btn-default "><input
                                    name="gym_sv" type="radio"
                                    value="1">O</label>
                        <label
                                class="btn btn-default "><input
                                    name="gym_sv" type="radio"
                                    value="3">Z</label>
                        <label
                                class="btn btn-default"><input
                                    name="gym_sv" type="radio"
                                    value="6">V</label>
                        <label
                                class="btn btn-default"><input
                                    name="gym_sv" type="radio"
                                    value="8">RV</label>
                        <label
                                class="btn btn-default "><input
                                    name="gym_sv" type="radio"
                                    value="10">G</label>
                    </div>
                    <hr/>

                    <label class="col-sm-3" for="gym_mv"> Motorische vaardigheden </label>

                    <div class="btn-group" data-toggle="buttons">
                        <label
                                class="btn btn-default"><input
                                    name="gym_mv" type="radio"
                                    value="1">O</label>
                        <label
                                class="btn btn-default "><input
                                    name="gym_mv" type="radio"
                                    value="3">Z</label>
                        <label
                                class="btn btn-default "><input
                                    name="gym_mv" type="radio"
                                    value="6">V</label>
                        <label
                                class="btn btn-default "><input
                                    name="gym_mv" type="radio"
                                    value="8">RV</label>
                        <label
                                class="btn btn-default "><input
                                    name="gym_mv" type="radio"
                                    value="10">G</label>
                    </div>
                    <hr/>

                    <div class="form-group"><label class="col-sm-3" for="gym_verslag"> Verslag </label><br/>
                        <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="gym_verslag"
                                  name="gym_verslag" spellcheck="true"></textarea>
                        <button type="button" id="gym_button" class="btn btn-info btn-sm scrollable-spelling">
                            <i class="fa fa-file-text fa-2x"></i>
                        </button>
                    </div>
                    <hr/>

                </div>
            </div>
        </section>
    <?php } elseif ($this->user->has_permission('special_c') == true) { ?>
        <!-- About Section -->
        <section class="creatieve-ontwikkeling-section form-block">
            <div class="row ">
                <div class="well crea">
                    <h1>Creatieve ontwikkeling</h1>

                    <div class="form-group"><label class="col-sm-3" for="crea_verslag"> Verslag </label><br/>
                        <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="crea_verslag"
                                  name="crea_verslag" spellcheck="true">
								</textarea>
                        <button type="button" id="crea_button" class="btn btn-info btn-sm scrollable-spelling">
                            <i class="fa fa-file-text fa-2x"></i>
                        </button>
                    </div>
                </div>
                <hr/>
            </div>
        </section>
    <?php } ?>
    <div class="panel-group" id="accordion">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#leerling">
                        <i class="fa fa-users fa-fw"></i> Overzicht Leerlingen</a></h4>
            </div>
            <div id="leerling" class="panel-collapse collapse in">
                <div class="panel-body">

                    <div class="table-responsive ">
                        <table class="table table-hover table-bordered display select" id="example">
                            <thead>
                            <tr>
                                <th><input name="select_all" value="1" id="example-select-all" type="checkbox"></th>
                                <th class="hidden-xs">#</th>
                                <th>Naam</th>
                                <th>Klas</th>
                                <th class="hidden-xs">Groep</th>
                                <th>Verslag deel 1</th>
                                <th>Verslag deel 2</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php for ($i = 0; $i < count($students); ++$i) { ?>
                                <tr>
                                    <td><input type="checkbox" name="id[]" value="<?= $students[$i]->id; ?>"></td>
                                    <td class="hidden-xs"><?php echo($page + $i + 1); ?></td>
                                    <td><?php echo $students[$i]->Roepnaam . ' ' . $students[$i]->Tussenvoegsel . ' ' . $students[$i]->Achternaam; ?></td>
                                    <td><?php echo $students[$i]->ghg; ?></td>
                                    <td class="hidden-xs"><?php echo $students[$i]->lhg; ?></td>

                                    <!-- if date beyond march - second reportcard should be accessible. -->

                                    <td>

                                        <a class="btn btn-success btn-fw"
                                           href="<?php echo site_url() . 'dashboard/edit/' . $students[$i]->id . '/1/' . $students[$i]->lhg; ?>"
                                           title="verslag een">
                                            verslag 1
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-fw"
                                           href="<?php echo site_url() . 'dashboard/edit/' . $students[$i]->id . '/2/' . $students[$i]->lhg; ?>"
                                           title="verslag twee">
                                            verslag 2
                                        </a>
                                    </td>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- /.panel-body -->
    </div>

    <div class="row">

        <div class="col-xs-12 <?php if ($this->user->has_permission('admin') || $this->user->has_permission
            ('administratie')) { ?>col-sm-4 <?php } else { ?> col-sm-6 col-sm-offset-3 <?php } ?>">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Storing melden</h4>
                </div>
                <div id="leerling">
                    <div class="panel-body">
                        <p>Indien een module niet correct functioneert, kunt u contact opnemen met de beheerder:<br/>
                            Telefoonnummer: 0703608091<br/>
                            of via email: beheer@zobijzonder.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
