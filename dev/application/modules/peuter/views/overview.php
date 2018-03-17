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

<div class="col-sm-12 block-box" style="padding-top:25px;">
    <h1>Overzicht</h1>

    <div class="panel-group" id="accordion">
        <?php if ($this->user->has_permission('admin') || $this->user->has_permission('administratie')) { ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#create">
                            <i class="fa fa-user-plus fa-fw"></i> Gebruiker aanmaken</a>
                    </h4></div>
                <div id="create" class="panel-collapse collapse">
                    <div class="panel-body">    <?php $this->load->view('user_crud/create_user'); ?></div>
                </div>
            </div>
            <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#gebruikers">
                        <i class="fa fa-user fa-fw"></i> Overzicht gebruikers</a>
                </h4>
            </div>
            <div id="gebruikers" class="panel-collapse collapse">
                <div class="panel-body">    <?php $this->load->view('user_crud/show_users'); ?></div>
            </div>
            </div><?php } ?>
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
        <?php if ($this->user->has_permission('admin') || $this->user->has_permission('administratie')) { ?>
            <div class="row">

                <div class="col-xs-12 col-sm-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Update alle gegevens met XML import</h4>
                        </div>
                        <div id="leerling">
                            <div class="panel-body">
                                <?php if (isset($errorxml)): ?>
                                    <div class="alert alert-error"><?php echo $errorxml; ?></div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('successxml') == TRUE): ?>
                                    <div
                                            class="alert alert-success"><?php echo $this->session->flashdata('successxml'); ?></div>
                                <?php endif; ?>
                                <form method="post" action="/dashboard/xmlimport/" enctype="multipart/form-data">
                                    <input type="file" name="userfile"><br><br>
                                    <input type="submit" name="submit" value="IMPORTEER" class="btn btn-primary">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div
                class="col-xs-12 <?php if ($this->user->has_permission('admin') || $this->user->has_permission('administratie')) { ?> col-sm-4 <?php } else { ?> col-sm-6 col-sm-offset-3 <?php } ?>">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Storing melden</h4>
                </div>
                <div id="leerling">
                    <div class="panel-body">
                        <p>Indien een module niet correct functioneert, kunt u contact opnemen met de
                            beheerder:<br/>
                            Telefoonnummer: 0703608091<br/>
                            of via email: beheer@zobijzonder.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>