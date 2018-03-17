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
<?php
if ($this->session->flashdata('file_stored')) { ?>
    <div id="message">
        <div style="padding: 5px;">
            <div id="inner-message" class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Verslag staat in uw documenten map.
            </div>
        </div>
    </div>
<?php } ?>
<div class="col-sm-12 block-box" style="padding-top:25px;">
    <h1>Overzicht</h1>

    <div class="panel-group" id="accordion">
        <?php if ($this->user->has_permission('admin') || $this->user->has_permission('administratie')) { ?>

            <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion"
                       href="#gebruikers" class="accordion-toggle">
                        <i class="fa fa-user fa-fw"></i> Overzicht gebruikers</a>
                    <i class="indicator glyphicon glyphicon-chevron-down  pull-right"></i>
                </h4>
            </div>
            <div id="gebruikers" class="panel-collapse collapse">
                <div class="panel-body">    <?php $this->load->view('user_crud/show_users'); ?></div>
            </div>
            </div><?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#leerling" class="accordion-toggle">
                        <i class="fa fa-users fa-fw"></i> Overzicht Leerlingen</a>
                    <i class="indicator glyphicon glyphicon-chevron-down  pull-right"></i>
                </h4>
            </div>
            <div id="leerling" class="panel-collapse collapse in">
                <div class="panel-body">
                    <form action="/dashboard/multipdf" id="frm-example" method="post">
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
                                    <th>Voorbeeld</th>
                                    <th>Download</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php for ($i = 0; $i < count($students); ++$i) { ?>
                                    <tr>
                                        <td><input type="checkbox" name="id[]" value="<?= $students[$i]->StudentID; ?>">
                                        </td>
                                        <td class="hidden-xs"><?php echo($page + $i + 1); ?></td>
                                        <td><?php echo $students[$i]->Roepnaam . ' ' . $students[$i]->Tussenvoegsel . ' ' . $students[$i]->Achternaam; ?></td>
                                        <td><?php
                                            $this->db->select('*');
                                            $this->db->from('tbl_classes_xml');
                                            $this->db->where('tbl_classes_xml.id', $students[$i]->groepkey);
                                            $this->db->limit('1');
                                            $naamklas = $this->db->get();

                                            foreach ($naamklas->result() as $student_klas) {

                                                echo $student_klas->name;

                                            } ?></td>
                                        <td class="hidden-xs"><?php echo $students[$i]->lhg; ?></td>
                                        <!-- if date beyond march - second reportcard should be accessible. -->
                                        <td>
                                            <a class="btn btn-success btn-fw"
                                               href="<?php echo site_url() . 'dashboard/edit/' . $students[$i]->StudentID . '/1/' . $students[$i]->schooljaar . '/' . $students[$i]->lhg; ?>"
                                               title="verslag een">
                                                verslag 1
                                            </a>
                                            <?php $group_table = 'tbl_g' . $students[$i]->lhg;
                                            $this->db->where('tbl_student_id', $students[$i]->StudentID);
                                            $this->db->where('verslag_versie', '1');
                                            $this->db->where('schooljaar', $students[$i]->schooljaar);
                                            $query = $this->db->get($group_table);
                                            if ($query->num_rows() > 0) {
                                                echo '<img src="' . base_url() . 'assets/img/checkweb.png" alt="&#x2713;" width="24" style="margin-left:15px;"/>';
                                            } else {
                                                echo '';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-fw"
                                               href="<?php echo site_url() . 'dashboard/edit/' . $students[$i]->StudentID . '/2/' . $students[$i]->schooljaar . '/' . $students[$i]->lhg; ?>"
                                               title="verslag twee">
                                                verslag 2
                                            </a>
                                            <?php $group_table = 'tbl_g' . $students[$i]->lhg;
                                            $this->db->where('tbl_student_id', $students[$i]->StudentID);
                                            $this->db->where('verslag_versie', '2');
                                            $this->db->where('schooljaar', $students[$i]->schooljaar);
                                            $query = $this->db->get($group_table);
                                            if ($query->num_rows() > 0) {
                                                echo '<img src="' . base_url() . 'assets/img/checkweb.png" alt="&#x2713;" width="24" style="margin-left:15px;"/>';
                                            } else {
                                                echo '';
                                            }
                                            ?>
                                        </td>
                                        <td><?php
                                            $group_table = 'tbl_g' . $students[$i]->lhg;
                                            $this->db->where('tbl_student_id', $students[$i]->StudentID);
                                            $this->db->where('verslag_versie', '1');
                                            $this->db->where('schooljaar', $students[$i]->schooljaar);
                                            $query = $this->db->get($group_table);
                                            if ($query->num_rows() > 0) {
                                                foreach ($query->result() as $row) {
                                                    $verslagid = $row->id;
                                                    echo '<center><a href="/preview/build/' . $students[$i]->StudentID . '/' . $students[$i]->lhg . '/' . $verslagid . '/' . $students[$i]->schooljaar . ' "><img src="' . base_url() . 'assets/img/eye-icon.png" style="height:30px;" alt="&#x2713;"/></a></center>';
                                                }
                                            } elseif ($query->num_rows() < 1) {
                                                $group_table = 'tbl_g' . $students[$i]->lhg;
                                                $this->db->where('tbl_student_id', $students[$i]->StudentID);
                                                $this->db->where('verslag_versie', '2');
                                                $this->db->where('schooljaar', $students[$i]->schooljaar);
                                                $query1 = $this->db->get($group_table);
                                                if ($query1->num_rows() > 0) {
                                                    foreach ($query1->result() as $row1) {
                                                        $verslagid2 = $row1->id;
                                                        echo '<center><a href="/preview/build/' . $students[$i]->StudentID . '/' . $students[$i]->lhg . '/' . $verslagid2 . '/' . $students[$i]->schooljaar . '"><img src="' . base_url() . 'assets/img/eye-icon.png" style="height:30px;" alt="&#x2713;"/></a></center>';
                                                    }
                                                }
                                            } else {
                                                echo '';
                                            }
                                            ?></td>
                                        <td><?php
                                            $group_table = 'tbl_g' . $students[$i]->lhg;
                                            $this->db->where('tbl_student_id', $students[$i]->StudentID);
                                            $this->db->where('verslag_versie', '1');
                                            $this->db->where('schooljaar', $students[$i]->schooljaar);
                                            $query = $this->db->get($group_table);
                                            if ($query->num_rows() > 0) {
                                                foreach ($query->result() as $row) {
                                                    $verslagid = $row->id;
                                                    echo '<center><a href="/dashboard/store_pdf/' . $students[$i]->StudentID . '/' . $students[$i]->lhg . '/' . $verslagid . '/' . $students[$i]->schooljaar . '/true/"><img src="' . base_url() . 'assets/img/Download-pdf-icon.png" style="height:30px;" alt="&#x2713;"/></a></center>';
                                                }
                                            } elseif ($query->num_rows() < 1) {
                                                $group_table = 'tbl_g' . $students[$i]->lhg;
                                                $this->db->where('tbl_student_id', $students[$i]->id);
                                                $this->db->where('verslag_versie', '2');
                                                $this->db->where('schooljaar', $students[$i]->schooljaar);
                                                $query1 = $this->db->get($group_table);
                                                if ($query1->num_rows() > 0) {
                                                    foreach ($query1->result() as $row1) {
                                                        $verslagid2 = $row1->id;
                                                        echo '<center><a href="/dashboard/store_pdf/' . $students[$i]->StudentID . '/' . $students[$i]->lhg . '/' . $verslagid . '/' . $students[$i]->schooljaar . '/true/"><img src="' . base_url() . 'assets/img/Download-pdf-icon.png" style="height:30px;" alt="&#x2713;"/></a></center>';
                                                    }
                                                }
                                            } else {
                                                echo '';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <button type="button" data-toggle="collapse" data-parent="#accordion" href="#files"
                                    class="btn btn-danger btn-fw"><i class="glyphicon glyphicon-print"></i></button>
                            <p>Selecteer de verslagen die u wenst af te drukken en klik daarna op het afdruk icon.<br/>
                                U wordt dan doorverwezen naar de document map waar alle gegenereerde pdf staan.<br/>
                                U kunt ook daar nog een laatste selectie maken alvorens u de download van verslagen
                                start.</p>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.panel-body -->

        <?php if (!$this->user->has_permission('admin') || !$this->user->has_permission('administratie')) { ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#files" class="accordion-toggle">Verslagbeheer</a>&nbsp;<span
                                class="label label-danger label-xs">NIEUW!</span>
                        <i class="indicator glyphicon glyphicon-chevron-down  pull-right"></i>
                    </h4>
                </div>
                <div id="files" class="panel-collapse collapse in">
                    <!-- Element where elFinder will be created (REQUIRED) -->
                    <div id="elfinder"></div>
                </div>
            </div>

        <?php } ?>
        <?php if ($this->user->has_permission('admin') || $this->user->has_permission('administratie')) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion"
                       href="#dirfiles" class="accordion-toggle">Administratie Beheer & Overzicht</a>
                    <i class="indicator glyphicon glyphicon-chevron-down  pull-right"></i>
                </h4>

                <p class="helper-block"><a href="<?= base_url(); ?>elfinder.php">Bekijk alle verslagen</a></p>
            </div>
            <!--<div id="dirfiles" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <p class="text-info">
                            <!-- Uw werkmaplocatie: <?php echo $documentdrive; ?> -->
            <!-- button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Alle Documenten Ophalen</button -->
            <!-- <iframe src="<   ?= base_url(); ?>elfinder.php" width="100%" height="410px" frameborder="0"
                    allowtransparency="true"></iframe>
        </p>
    </div>
</div>
</div>-->

            <!--xmlimport-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" class="accordion-toggle" href="#xmlimport">Update
                            alle gegevens met XML import</a>
                        <i class="indicator glyphicon glyphicon-chevron-down  pull-right"></i>
                    </h4>
                </div>
                <div id="xmlimport" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <?php if (isset($errorxml)): ?>
                            <div class="alert alert-error"><?php echo $errorxml; ?></div>
                        <?php endif; ?>
                        <?php if ($this->session->flashdata('successxml') == TRUE): ?>
                            <div
                                    class="alert alert-success"><?php echo $this->session->flashdata('successxml'); ?></div>
                        <?php endif; ?>
                        <?php echo form_open_multipart('/dashboard/edexImporter'); ?>
                        <!-- form method="post" action="" enctype="multipart/form-data" -->
                        <input type="file" name="file"><br><br>
                        <input type="submit" name="submit" value="IMPORTEER" class="btn btn-primary">
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if ($this->session->userdata('login') == 'k.leeuwen@enms.nl' || $this->session->userdata('login') == 'p.vandervelde@enms.nl' || $this->user->has_permission('administratie')) { ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><strong><span
                                        style="color:darkred">Uitsluitend voor de Peutergroep</span></strong><br/>
                            Toevoegen peuters via csv import, komma gescheiden</h4>
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

                            <?php echo form_open_multipart('/dashboard/importexcel'); ?>
                            <!-- form method="post" action="" enctype="multipart/form-data" -->
                            <input type="file" name="userfile"><br><br>
                            <input type="submit" name="submit" value="IMPORTEER" class="btn btn-primary">
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
