<div class="col-xs-12 col-sm-3 fixed hidden-xs">
    <div class="row-fluid">
        <ul class="nav nav-pills nav-stacked">
            <?php foreach ($students->result() as $student): ?>
            <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
            <li class="hidden">
                <a class="page-scroll" href="#page-top"></a>
            </li>
            <?php if ($this->user->has_permission('special_g') || $this->user->has_permission('special_c')) {
                echo '<li>
				<a class="page-scroll" href="/dashboard">Terug naar overzicht zonder opslaan</a>
			</li>';
            } else { ?>
                <li>
                    <a class="page-scroll" href="#" data-id="taal">Taal</a>
                </li>
                <li>
                    <a class="page-scroll" href="#" data-id="rekenen">Rekenen</a>
                </li>
                <li>
                    <a class="page-scroll" href="#" data-id="schrijven">
                        <?php echo ($student->lhg > 3) ? 'Schrijven' : 'Fijne motoriek'; ?>
                    </a>
                </li>
                <li>
                    <a class="page-scroll" href="#" data-id="kosmisch">Kosmisch</a>
                </li>
                <li>
                    <a class="page-scroll" href="#" data-id="creatief">Creatief</a>
                </li>
                <li>
                    <a class="page-scroll" href="#" data-id="gymnastiek">Gymnastiek</a>
                </li>
                <li>
                    <a class="page-scroll" href="#" data-id="ondersteuning">Ondersteuning</a>
                </li>
                <li>
                    <a class="page-scroll" href="#" data-id="opmerkingen">Opmerkingen</a>
                </li>
                <li>
                    <a class="page-scroll" href="#" data-id="notes">Interne Notities</a>
                </li>
                <li>
                    <a class="page-scroll" href="#" data-id="finish">Opslaan</a>
                </li><?php } ?>
        </ul>
    </div>
    <div id="status"></div>
    <div id="lastupdate"></div>
</div>


<div class="col-xs-12 col-sm-9 scrollit" style="padding-top:55px;">

    <form action="/dashboard/store/<?= $student->id; ?>/<?= $student->lhg; ?>/<?= $student->tbl_student_id; ?>"
          method="post" enctype="multipart/form-data" id="reportcard_builder">
        <button type="submit" id="store-done" class="btn btn-danger btn-sm scrollable">
            <i class="fa fa-save fa-3x"></i></button>

        <div class="row ">
            <?php if ($this->session->flashdata()) { ?><span class="alert alert-info"><?php
                echo
                $this->session->flashdata('storage_message');
                ?></span><?php } ?>
            <div id="5mstored"></div>
            <div class="well persoon">

                <h2><span
                            style="color:#666;">Leerling: </span> <?= $student->Roepnaam . ' '; ?><?php if ($student->Tussenvoegsel) {
                        echo $student->Tussenvoegsel . ' ';
                    } ?><?= $student->Achternaam; ?>
                    <br/>
                    <span style="color:#666;">Groep:&nbsp; &nbsp;&nbsp; </span> <?php echo $student->lhg; ?></h2>
                <?php $value = $student->lhg; ?>
                <input <?php echo (ENVIRONMENT === 'development') ? 'type="text"' : 'type="hidden"'; ?>
                        class="form-control" value="<?= $student->tbl_student_id; ?>" name="tbl_student_id"/>
                <input <?php echo (ENVIRONMENT === 'development') ? 'type="text"' : 'type="hidden"'; ?>
                        class="form-control" value="<?= $this->user->get_id(); ?>" name="user_id"/>

                </h2>
                <div class="form-group">
                    <label class="col-sm-3" for="datum_periode">datum_periode</label>
                    <input name="datum_periode" class="form-control date-picker" value="<?= $student->datum_periode; ?>"
                           placeholder="maand jaar voorbeeld: maart 2016"/>
                </div>
                <!-- ?php if ($this->user->has_permission('leidsters')||$this->user->has_permission('admin')) { ? -->
                <div class="form-group">
                    <label class="col-sm-3" for="pvg">Periode van groei</label><br/>
                    <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="pvg" name="pvg"
                              spellcheck="true">
							<?= $student->pvg; ?>
						</textarea>

                </div>
                <!-- ?php } ? -->
                <div class="ui-widget form-group">
                    <label class="col-sm-3" for="tags" style="font-family:'Roboto', Arial, sans; font-size:12px;">Leid(st)er(s)
                        <address>meer toevoegen gebruik ,</address>
                    </label>
                    <input id="tags" name="leidsters" value="<?= $student->leidsters; ?>" class="form-control"
                           size="50">
                </div>
            </div>
            <?php if ($this->user->has_permission('special_g')) { ?>
                <!-- About Section -->
                <section class="gymnastiek-section form-block">
                    <div class="row ">
                        <div class="well gym">
                            <h1>Gymnastiek</h1>
                            <label class="col-sm-3" for="gym_in"> Inzet </label>
                            <!-- start new element addition -->
                            <div class="btn-group" data-target="group_gym_in" data-toggle="buttons">
                                <!-- end new element addition -->
                                <label
                                        class="btn btn-default <?php echo ($student->gym_in == 1) ? 'active' : '' ?>"><input
                                            name="gym_in" type="radio"
                                            value="1" <?php echo ($student->gym_in == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->gym_in == 3) ? 'active' : '' ?>"><input
                                            name="gym_in" type="radio"
                                            value="3" <?php echo ($student->gym_in == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->gym_in == 6) ? 'active' : '' ?>"><input
                                            name="gym_in" type="radio"
                                            value="6" <?php echo ($student->gym_in == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->gym_in == 8) ? 'active' : '' ?>"><input
                                            name="gym_in" type="radio"
                                            value="8" <?php echo ($student->gym_in == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->gym_in == 10) ? 'active' : '' ?>"><input
                                            name="gym_in" type="radio"
                                            value="10" <?php echo ($student->gym_in == 10) ? 'checked="checked"' : '' ?>>G</label>
                                <!-- reset this button group -->
                                <!-- button id="undoButtons" type="button" class="btn btn-sm btn-default" data-target="gym_in">R</button -->
                                <!-- end reset button -->


                            </div>
                            <hr/>

                            <label class="col-sm-3" for="gym_sv"> Sociale vaardigheden (samenwerken,luisteren) </label>

                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->gym_sv == 1) ? 'active' : '' ?>"><input
                                            name="gym_sv" type="radio"
                                            value="1" <?php echo ($student->gym_sv == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->gym_sv == 3) ? 'active' : '' ?>"><input
                                            name="gym_sv" type="radio"
                                            value="3" <?php echo ($student->gym_sv == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->gym_sv == 6) ? 'active' : '' ?>"><input
                                            name="gym_sv" type="radio"
                                            value="6" <?php echo ($student->gym_sv == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->gym_sv == 8) ? 'active' : '' ?>"><input
                                            name="gym_sv" type="radio"
                                            value="8" <?php echo ($student->gym_sv == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->gym_sv == 10) ? 'active' : '' ?>"><input
                                            name="gym_sv" type="radio"
                                            value="10" <?php echo ($student->gym_sv == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>

                            <label class="col-sm-3" for="gym_mv"> Motorische vaardigheden </label>

                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->gym_mv == 1) ? 'active' : '' ?>"><input
                                            name="gym_mv" type="radio"
                                            value="1" <?php echo ($student->gym_mv == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->gym_mv == 3) ? 'active' : '' ?>"><input
                                            name="gym_mv" type="radio"
                                            value="3" <?php echo ($student->gym_mv == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->gym_mv == 6) ? 'active' : '' ?>"><input
                                            name="gym_mv" type="radio"
                                            value="6" <?php echo ($student->gym_mv == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->gym_mv == 8) ? 'active' : '' ?>"><input
                                            name="gym_mv" type="radio"
                                            value="8" <?php echo ($student->gym_mv == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->gym_mv == 10) ? 'active' : '' ?>"><input
                                            name="gym_mv" type="radio"
                                            value="10" <?php echo ($student->gym_mv == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>

                            <div class="form-group"><label class="col-sm-3" for="gym_verslag"> Verslag </label><br/>
                                <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="gym_verslag"
                                          name="gym_verslag" spellcheck="true"><?= $student->gym_verslag; ?></textarea>

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
                                          name="crea_verslag" spellcheck="true"><?= $student->crea_verslag; ?>
								</textarea>

                            </div>
                        </div>
                        <hr/>
                    </div>
                </section>
            <?php }
            else { ?>

            <!-- Intro Section -->
            <section id="taal" class="taal-section form-block">
                <div class="row ">
                    <div class="well taal">
                        <h1>Taal</h1>
                        <?php if ($value > 2) { ?>
                            <label style="padding-top:10px !important;" class="col-sm-3" for="taal_tl"> Technisch
                                lezen </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_tl == 1) ? 'active' : '' ?>">
                                    <input name="taal_tl" type="radio"
                                           value="1" <?php echo ($student->taal_tl == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_tl == 3) ? 'active' : '' ?>"><input
                                            name="taal_tl" type="radio"
                                            value="3" <?php echo ($student->taal_tl == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_tl == 6) ? 'active' : '' ?>"><input
                                            name="taal_tl" type="radio"
                                            value="6" <?php echo ($student->taal_tl == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_tl == 8) ? 'active' : '' ?>"><input
                                            name="taal_tl" type="radio"
                                            value="8" <?php echo ($student->taal_tl == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_tl == 10) ? 'active' : '' ?>"><input
                                            name="taal_tl" type="radio"
                                            value="10" <?php echo ($student->taal_tl == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value > 2) { ?>
                            <label class="col-sm-3" for="taal_bl"> Begrijpend lezen </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_bl == 1) ? 'active' : '' ?>">
                                    <input name="taal_bl" type="radio"
                                           value="1" <?php echo ($student->taal_bl == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_bl == 3) ? 'active' : '' ?>"><input
                                            name="taal_bl" type="radio"
                                            value="3" <?php echo ($student->taal_bl == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_bl == 6) ? 'active' : '' ?>"><input
                                            name="taal_bl" type="radio"
                                            value="6" <?php echo ($student->taal_bl == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_bl == 8) ? 'active' : '' ?>"><input
                                            name="taal_bl" type="radio"
                                            value="8" <?php echo ($student->taal_bl == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_bl == 10) ? 'active' : '' ?>"><input
                                            name="taal_bl" type="radio"
                                            value="10" <?php echo ($student->taal_bl == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 3) { ?>
                            <label class="col-sm-3" for="taal_uv"> Uitdrukkingsvaardigheid </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_uv == 1) ? 'active' : '' ?>">
                                    <input name="taal_uv" type="radio"
                                           value="1" <?php echo ($student->taal_uv == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_uv == 3) ? 'active' : '' ?>"><input
                                            name="taal_uv" type="radio"
                                            value="3" <?php echo ($student->taal_uv == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_uv == 6) ? 'active' : '' ?>"><input
                                            name="taal_uv" type="radio"
                                            value="6" <?php echo ($student->taal_uv == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_uv == 8) ? 'active' : '' ?>"><input
                                            name="taal_uv" type="radio"
                                            value="8" <?php echo ($student->taal_uv == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_uv == 10) ? 'active' : '' ?>"><input
                                            name="taal_uv" type="radio"
                                            value="10" <?php echo ($student->taal_uv == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value > 3) { ?>
                            <label class="col-sm-3" for="taal_bb"> Boekbespreking </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_bb == 1) ? 'active' : '' ?>">
                                    <input name="taal_bb" type="radio"
                                           value="1" <?php echo ($student->taal_bb == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_bb == 3) ? 'active' : '' ?>"><input
                                            name="taal_bb" type="radio"
                                            value="3" <?php echo ($student->taal_bb == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_bb == 6) ? 'active' : '' ?>"><input
                                            name="taal_bb" type="radio"
                                            value="6" <?php echo ($student->taal_bb == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_bb == 8) ? 'active' : '' ?>"><input
                                            name="taal_bb" type="radio"
                                            value="8" <?php echo ($student->taal_bb == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_bb == 10) ? 'active' : '' ?>"><input
                                            name="taal_bb" type="radio"
                                            value="10" <?php echo ($student->taal_bb == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value > 3) { ?>
                            <label class="col-sm-3" for="taal_st"> Stellen ( inzet) </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_st == 1) ? 'active' : '' ?>">
                                    <input name="taal_st" type="radio"
                                           value="1" <?php echo ($student->taal_st == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_st == 3) ? 'active' : '' ?>"><input
                                            name="taal_st" type="radio"
                                            value="3" <?php echo ($student->taal_st == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_st == 6) ? 'active' : '' ?>"><input
                                            name="taal_st" type="radio"
                                            value="6" <?php echo ($student->taal_st == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_st == 8) ? 'active' : '' ?>"><input
                                            name="taal_st" type="radio"
                                            value="8" <?php echo ($student->taal_st == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_st == 10) ? 'active' : '' ?>"><input
                                            name="taal_st" type="radio"
                                            value="10" <?php echo ($student->taal_st == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value > 2) { ?>
                            <label class="col-sm-3" for="taal_sp"> Spelling </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_sp == 1) ? 'active' : '' ?>">
                                    <input name="taal_sp" type="radio"
                                           value="1" <?php echo ($student->taal_sp == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_sp == 3) ? 'active' : '' ?>"><input
                                            name="taal_sp" type="radio"
                                            value="3" <?php echo ($student->taal_sp == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_sp == 6) ? 'active' : '' ?>"><input
                                            name="taal_sp" type="radio"
                                            value="6" <?php echo ($student->taal_sp == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_sp == 8) ? 'active' : '' ?>"><input
                                            name="taal_sp" type="radio"
                                            value="8" <?php echo ($student->taal_sp == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_sp == 10) ? 'active' : '' ?>"><input
                                            name="taal_sp" type="radio"
                                            value="10" <?php echo ($student->taal_sp == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value <= 2) { ?>
                            <label class="col-sm-3" for="taal_la"> Luistert naar anderen </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->taal_la == 1) ? 'active' : '' ?>">
                                    <input name="taal_la" type="radio"
                                           value="1" <?php echo ($student->taal_la == 1) ? 'checked="checked"' : '' ?>>O
                                </label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_la == 3) ? 'active' : '' ?>">
                                    <input name="taal_la" type="radio"
                                           value="3" <?php echo ($student->taal_la == 3) ? 'checked="checked"' : '' ?>>Z
                                </label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_la == 6) ? 'active' : '' ?>">
                                    <input name="taal_la" type="radio"
                                           value="6" <?php echo ($student->taal_la == 6) ? 'checked="checked"' : '' ?>>V
                                </label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_la == 8) ? 'active' : '' ?>">
                                    <input name="taal_la" type="radio"
                                           value="8" <?php echo ($student->taal_la == 8) ? 'checked="checked"' : '' ?>>RV
                                </label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_la == 10) ? 'active' : '' ?>">
                                    <input name="taal_la" type="radio"
                                           value="10" <?php echo ($student->taal_la == 10) ? 'checked="checked"' : '' ?>>G
                                </label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value <= 2) { ?>
                            <label class="col-sm-3" for="taal_dv"> Durft te vertellen </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_dv == 1) ? 'active' : '' ?>">
                                    <input name="taal_dv" type="radio"
                                           value="1" <?php echo ($student->taal_dv == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_dv == 3) ? 'active' : '' ?>"><input
                                            name="taal_dv" type="radio"
                                            value="3" <?php echo ($student->taal_dv == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_dv == 6) ? 'active' : '' ?>"><input
                                            name="taal_dv" type="radio"
                                            value="6" <?php echo ($student->taal_dv == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_dv == 8) ? 'active' : '' ?>"><input
                                            name="taal_dv" type="radio"
                                            value="8" <?php echo ($student->taal_dv == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_dv == 10) ? 'active' : '' ?>"><input
                                            name="taal_dv" type="radio"
                                            value="10" <?php echo ($student->taal_dv == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value <= 2) { ?>
                            <label class="col-sm-3" for="taal_zb"> Zinsbouw </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_zb == 1) ? 'active' : '' ?>">
                                    <input name="taal_zb" type="radio"
                                           value="1" <?php echo ($student->taal_zb == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_zb == 3) ? 'active' : '' ?>"><input
                                            name="taal_zb" type="radio"
                                            value="3" <?php echo ($student->taal_zb == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_zb == 6) ? 'active' : '' ?>"><input
                                            name="taal_zb" type="radio"
                                            value="6" <?php echo ($student->taal_zb == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_zb == 8) ? 'active' : '' ?>"><input
                                            name="taal_zb" type="radio"
                                            value="8" <?php echo ($student->taal_zb == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_zb == 10) ? 'active' : '' ?>"><input
                                            name="taal_zb" type="radio"
                                            value="10" <?php echo ($student->taal_zb == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value <= 2) { ?>
                            <label class="col-sm-3" for="taal_ws"> Woordenschat </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_ws == 1) ? 'active' : '' ?>">
                                    <input name="taal_ws" type="radio"
                                           value="1" <?php echo ($student->taal_ws == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_ws == 3) ? 'active' : '' ?>"><input
                                            name="taal_ws" type="radio"
                                            value="3" <?php echo ($student->taal_ws == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_ws == 6) ? 'active' : '' ?>"><input
                                            name="taal_ws" type="radio"
                                            value="6" <?php echo ($student->taal_ws == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_ws == 8) ? 'active' : '' ?>"><input
                                            name="taal_ws" type="radio"
                                            value="8" <?php echo ($student->taal_ws == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_ws == 10) ? 'active' : '' ?>"><input
                                            name="taal_ws" type="radio"
                                            value="10" <?php echo ($student->taal_ws == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value <= 2) { ?>
                            <label class="col-sm-3" for="taal_ag"> Auditief geheugen </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_ag == 1) ? 'active' : '' ?>">
                                    <input name="taal_ag" type="radio"
                                           value="1" <?php echo ($student->taal_ag == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_ag == 3) ? 'active' : '' ?>"><input
                                            name="taal_ag" type="radio"
                                            value="3" <?php echo ($student->taal_ag == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_ag == 6) ? 'active' : '' ?>"><input
                                            name="taal_ag" type="radio"
                                            value="6" <?php echo ($student->taal_ag == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_ag == 8) ? 'active' : '' ?>"><input
                                            name="taal_ag" type="radio"
                                            value="8" <?php echo ($student->taal_ag == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_ag == 10) ? 'active' : '' ?>"><input
                                            name="taal_ag" type="radio"
                                            value="10" <?php echo ($student->taal_ag == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 1) { ?>
                            <label class="col-sm-3" for="taal_lv_vv"> Kan verschillen in op elkaar lijkende vormen
                                zien </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_lv_vv == 1) ? 'active' : '' ?>">
                                    <input name="taal_lv_vv" type="radio"
                                           value="1" <?php echo ($student->taal_lv_vv == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_vv == 3) ? 'active' : '' ?>"><input
                                            name="taal_lv_vv" type="radio"
                                            value="3" <?php echo ($student->taal_lv_vv == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_vv == 6) ? 'active' : '' ?>"><input
                                            name="taal_lv_vv" type="radio"
                                            value="6" <?php echo ($student->taal_lv_vv == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_vv == 8) ? 'active' : '' ?>"><input
                                            name="taal_lv_vv" type="radio"
                                            value="8" <?php echo ($student->taal_lv_vv == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_vv == 10) ? 'active' : '' ?>"><input
                                            name="taal_lv_vv" type="radio"
                                            value="10" <?php echo ($student->taal_lv_vv == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 2) { ?>
                            <label class="col-sm-3" for="taal_lv_kh"> Kan verschillen in klanken horen </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_lv_kh == 1) ? 'active' : '' ?>">
                                    <input name="taal_lv_kh" type="radio"
                                           value="1" <?php echo ($student->taal_lv_kh == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_kh == 3) ? 'active' : '' ?>"><input
                                            name="taal_lv_kh" type="radio"
                                            value="3" <?php echo ($student->taal_lv_kh == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_kh == 6) ? 'active' : '' ?>"><input
                                            name="taal_lv_kh" type="radio"
                                            value="6" <?php echo ($student->taal_lv_kh == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_kh == 8) ? 'active' : '' ?>"><input
                                            name="taal_lv_kh" type="radio"
                                            value="8" <?php echo ($student->taal_lv_kh == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_kh == 10) ? 'active' : '' ?>"><input
                                            name="taal_lv_kh" type="radio"
                                            value="10" <?php echo ($student->taal_lv_kh == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 2) { ?>
                            <label class="col-sm-3" for="taal_lv_lv"> Kan verschillen in lettervormen zien </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_lv_lv == 1) ? 'active' : '' ?>">
                                    <input name="taal_lv_lv" type="radio"
                                           value="1" <?php echo ($student->taal_lv_lv == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_lv == 3) ? 'active' : '' ?>"><input
                                            name="taal_lv_lv" type="radio"
                                            value="3" <?php echo ($student->taal_lv_lv == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_lv == 6) ? 'active' : '' ?>"><input
                                            name="taal_lv_lv" type="radio"
                                            value="6" <?php echo ($student->taal_lv_lv == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_lv == 8) ? 'active' : '' ?>"><input
                                            name="taal_lv_lv" type="radio"
                                            value="8" <?php echo ($student->taal_lv_lv == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_lv == 10) ? 'active' : '' ?>"><input
                                            name="taal_lv_lv" type="radio"
                                            value="10" <?php echo ($student->taal_lv_lv == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value <= 2) { ?>
                            <label class="col-sm-3" for="taal_lv_rij"> Rijmen </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_lv_rij == 1) ? 'active' : '' ?>">
                                    <input name="taal_lv_rij" type="radio"
                                           value="1" <?php echo ($student->taal_lv_rij == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_rij == 3) ? 'active' : '' ?>"><input
                                            name="taal_lv_rij" type="radio"
                                            value="3" <?php echo ($student->taal_lv_rij == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_rij == 6) ? 'active' : '' ?>"><input
                                            name="taal_lv_rij" type="radio"
                                            value="6" <?php echo ($student->taal_lv_rij == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_rij == 8) ? 'active' : '' ?>"><input
                                            name="taal_lv_rij" type="radio"
                                            value="8" <?php echo ($student->taal_lv_rij == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_rij == 10) ? 'active' : '' ?>"><input
                                            name="taal_lv_rij" type="radio"
                                            value="10" <?php echo ($student->taal_lv_rij == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 2) { ?>
                            <label class="col-sm-3" for="taal_lv_lwz"> Kent verschil letter/woord/zin </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_lv_lwz == 1) ? 'active' : '' ?>">
                                    <input name="taal_lv_lwz" type="radio"
                                           value="1" <?php echo ($student->taal_lv_lwz == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_lwz == 3) ? 'active' : '' ?>"><input
                                            name="taal_lv_lwz" type="radio"
                                            value="3" <?php echo ($student->taal_lv_lwz == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_lwz == 6) ? 'active' : '' ?>"><input
                                            name="taal_lv_lwz" type="radio"
                                            value="6" <?php echo ($student->taal_lv_lwz == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_lwz == 8) ? 'active' : '' ?>"><input
                                            name="taal_lv_lwz" type="radio"
                                            value="8" <?php echo ($student->taal_lv_lwz == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_lwz == 10) ? 'active' : '' ?>"><input
                                            name="taal_lv_lwz" type="radio"
                                            value="10" <?php echo ($student->taal_lv_lwz == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 2) { ?>
                            <label class="col-sm-3" for="taal_lv_kw"> Korte woorden na stempelen/leggen </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_lv_kw == 1) ? 'active' : '' ?>">
                                    <input name="taal_lv_kw" type="radio"
                                           value="1" <?php echo ($student->taal_lv_kw == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_kw == 3) ? 'active' : '' ?>"><input
                                            name="taal_lv_kw" type="radio"
                                            value="3" <?php echo ($student->taal_lv_kw == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_kw == 6) ? 'active' : '' ?>"><input
                                            name="taal_lv_kw" type="radio"
                                            value="6" <?php echo ($student->taal_lv_kw == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_kw == 8) ? 'active' : '' ?>"><input
                                            name="taal_lv_kw" type="radio"
                                            value="8" <?php echo ($student->taal_lv_kw == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_kw == 10) ? 'active' : '' ?>"><input
                                            name="taal_lv_kw" type="radio"
                                            value="10" <?php echo ($student->taal_lv_kw == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 2) { ?>
                            <label class="col-sm-3" for="taal_lv_ks"> Kan synthetiseren </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_lv_ks == 1) ? 'active' : '' ?>">
                                    <input name="taal_lv_ks" type="radio"
                                           value="1" <?php echo ($student->taal_lv_ks == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_ks == 3) ? 'active' : '' ?>"><input
                                            name="taal_lv_ks" type="radio"
                                            value="3" <?php echo ($student->taal_lv_ks == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_ks == 6) ? 'active' : '' ?>"><input
                                            name="taal_lv_ks" type="radio"
                                            value="6" <?php echo ($student->taal_lv_ks == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_ks == 8) ? 'active' : '' ?>"><input
                                            name="taal_lv_ks" type="radio"
                                            value="8" <?php echo ($student->taal_lv_ks == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_ks == 10) ? 'active' : '' ?>"><input
                                            name="taal_lv_ks" type="radio"
                                            value="10" <?php echo ($student->taal_lv_ks == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 2) { ?>
                            <label class="col-sm-3" for="taal_lv_ka"> Kan analyseren </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_lv_ka == 1) ? 'active' : '' ?>">
                                    <input name="taal_lv_ka" type="radio"
                                           value="1" <?php echo ($student->taal_lv_ka == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_ka == 3) ? 'active' : '' ?>"><input
                                            name="taal_lv_ka" type="radio"
                                            value="3" <?php echo ($student->taal_lv_ka == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_ka == 6) ? 'active' : '' ?>"><input
                                            name="taal_lv_ka" type="radio"
                                            value="6" <?php echo ($student->taal_lv_ka == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_ka == 8) ? 'active' : '' ?>"><input
                                            name="taal_lv_ka" type="radio"
                                            value="8" <?php echo ($student->taal_lv_ka == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_ka == 10) ? 'active' : '' ?>"><input
                                            name="taal_lv_ka" type="radio"
                                            value="10" <?php echo ($student->taal_lv_ka == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 2) { ?>
                            <label class="col-sm-3" for="taal_lv_l10"> Herkent minimaal 10 letters </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_lv_l10 == 1) ? 'active' : '' ?>">
                                    <input name="taal_lv_l10" type="radio"
                                           value="1" <?php echo ($student->taal_lv_l10 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_l10 == 3) ? 'active' : '' ?>"><input
                                            name="taal_lv_l10" type="radio"
                                            value="3" <?php echo ($student->taal_lv_l10 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_l10 == 6) ? 'active' : '' ?>"><input
                                            name="taal_lv_l10" type="radio"
                                            value="6" <?php echo ($student->taal_lv_l10 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_l10 == 8) ? 'active' : '' ?>"><input
                                            name="taal_lv_l10" type="radio"
                                            value="8" <?php echo ($student->taal_lv_l10 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_lv_l10 == 10) ? 'active' : '' ?>"><input
                                            name="taal_lv_l10" type="radio"
                                            value="10" <?php echo ($student->taal_lv_l10 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value > 2) { ?>    <label class="col-sm-3" for="taal_mm"> (Montessori)
                            materiaalgebruik </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->taal_mm == 1) ? 'active' : '' ?>">
                                    <input name="taal_mm" type="radio"
                                           value="1" <?php echo ($student->taal_mm == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_mm == 3) ? 'active' : '' ?>"><input
                                            name="taal_mm" type="radio"
                                            value="3" <?php echo ($student->taal_mm == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_mm == 6) ? 'active' : '' ?>"><input
                                            name="taal_mm" type="radio"
                                            value="6" <?php echo ($student->taal_mm == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_mm == 8) ? 'active' : '' ?>"><input
                                            name="taal_mm" type="radio"
                                            value="8" <?php echo ($student->taal_mm == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_mm == 10) ? 'active' : '' ?>"><input
                                            name="taal_mm" type="radio"
                                            value="10" <?php echo ($student->taal_mm == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>

                        <label class="col-sm-3" for="taal_lv_en"> Engels (inzet) </label>

                        <div class="btn-group" data-toggle="buttons">
                            <label
                                    class="btn btn-default <?php echo ($student->taal_lv_en == 1) ? 'active' : '' ?>"><input
                                        name="taal_lv_en" type="radio"
                                        value="1" <?php echo ($student->taal_lv_en == 1) ? 'checked="checked"' : '' ?>>O</label>
                            <label
                                    class="btn btn-default <?php echo ($student->taal_lv_en == 3) ? 'active' : '' ?>"><input
                                        name="taal_lv_en" type="radio"
                                        value="3" <?php echo ($student->taal_lv_en == 3) ? 'checked="checked"' : '' ?>>Z</label>
                            <label
                                    class="btn btn-default <?php echo ($student->taal_lv_en == 6) ? 'active' : '' ?>"><input
                                        name="taal_lv_en" type="radio"
                                        value="6" <?php echo ($student->taal_lv_en == 6) ? 'checked="checked"' : '' ?>>V</label>
                            <label
                                    class="btn btn-default <?php echo ($student->taal_lv_en == 8) ? 'active' : '' ?>"><input
                                        name="taal_lv_en" type="radio"
                                        value="8" <?php echo ($student->taal_lv_en == 8) ? 'checked="checked"' : '' ?>>RV</label>
                            <label
                                    class="btn btn-default <?php echo ($student->taal_lv_en == 10) ? 'active' : '' ?>"><input
                                        name="taal_lv_en" type="radio"
                                        value="10" <?php echo ($student->taal_lv_en == 10) ? 'checked="checked"' : '' ?>>G</label>
                        </div>
                        <hr/>

                        <?php if ($value == 8) { ?><label class="col-sm-3" for="taal_en8"> Engels niveau (groep
                            8) </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->taal_en8 == 1) ? 'active' : '' ?>"><input
                                            name="taal_en8" type="radio"
                                            value="1" <?php echo ($student->taal_en8 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_en8 == 3) ? 'active' : '' ?>"><input
                                            name="taal_en8" type="radio"
                                            value="3" <?php echo ($student->taal_en8 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_en8 == 6) ? 'active' : '' ?>"><input
                                            name="taal_en8" type="radio"
                                            value="6" <?php echo ($student->taal_en8 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_en8 == 8) ? 'active' : '' ?>"><input
                                            name="taal_en8" type="radio"
                                            value="8" <?php echo ($student->taal_en8 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->taal_en8 == 10) ? 'active' : '' ?>"><input
                                            name="taal_en8" type="radio"
                                            value="10" <?php echo ($student->taal_en8 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>


                    </div>
                </div>
            </section>

            <!-- About Section -->
            <section id="rekenen" class="rekenen-section form-block">
                <div class="row ">
                    <div class="well rekenen">
                        <h1>Rekenen</h1>
                        <?php if ($value <= 2) { ?>
                            <label class="col-sm-3" for="reken_rb"> Kent de rekenbegrippen zoals
                                minder/meer/vooraan...</label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_rb == 1) ? 'active' : '' ?>"><input
                                            name="reken_rb" type="radio"
                                            value="1" <?php echo ($student->reken_rb == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_rb == 3) ? 'active' : '' ?>"><input
                                            name="reken_rb" type="radio"
                                            value="3" <?php echo ($student->reken_rb == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_rb == 6) ? 'active' : '' ?>"><input
                                            name="reken_rb" type="radio"
                                            value="6" <?php echo ($student->reken_rb == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_rb == 8) ? 'active' : '' ?>"><input
                                            name="reken_rb" type="radio"
                                            value="8" <?php echo ($student->reken_rb == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_rb == 10) ? 'active' : '' ?>"><input
                                            name="reken_rb" type="radio"
                                            value="10" <?php echo ($student->reken_rb == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value == 1) { ?>
                            <label class="col-sm-3" for="reken_gb6"> Getalbegrip t/m 6 </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb6 == 1) ? 'active' : '' ?>"><input
                                            name="reken_gb6" type="radio"
                                            value="1" <?php echo ($student->reken_gb6 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb6 == 3) ? 'active' : '' ?>"><input
                                            name="reken_gb6" type="radio"
                                            value="3" <?php echo ($student->reken_gb6 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb6 == 6) ? 'active' : '' ?>"><input
                                            name="reken_gb6" type="radio"
                                            value="6" <?php echo ($student->reken_gb6 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb6 == 8) ? 'active' : '' ?>"><input
                                            name="reken_gb6" type="radio"
                                            value="8" <?php echo ($student->reken_gb6 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb6 == 10) ? 'active' : '' ?>"><input
                                            name="reken_gb6" type="radio"
                                            value="10" <?php echo ($student->reken_gb6 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value == 2) { ?>
                            <label class="col-sm-3" for="reken_gb12"> Getalbegrip t/m 12 </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->reken_gb12 == 1) ? 'active' : '' ?>">
                                    <input name="reken_gb12" type="radio"
                                           value="1" <?php echo ($student->reken_gb12 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb12 == 3) ? 'active' : '' ?>"><input
                                            name="reken_gb12" type="radio"
                                            value="3" <?php echo ($student->reken_gb12 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb12 == 6) ? 'active' : '' ?>"><input
                                            name="reken_gb12" type="radio"
                                            value="6" <?php echo ($student->reken_gb12 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb12 == 8) ? 'active' : '' ?>"><input
                                            name="reken_gb12" type="radio"
                                            value="8" <?php echo ($student->reken_gb12 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb12 == 10) ? 'active' : '' ?>"><input
                                            name="reken_gb12" type="radio"
                                            value="10" <?php echo ($student->reken_gb12 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value == 1) { ?>
                            <label class="col-sm-3" for="reken_gb10"> Getalbegrip t/m 10 </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb10 == 1) ? 'active' : '' ?>"><input
                                            name="reken_gb10" type="radio"
                                            value="1" <?php echo ($student->reken_gb10 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb10 == 3) ? 'active' : '' ?>"><input
                                            name="reken_gb10" type="radio"
                                            value="3" <?php echo ($student->reken_gb10 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb10 == 6) ? 'active' : '' ?>"><input
                                            name="reken_gb10" type="radio"
                                            value="6" <?php echo ($student->reken_gb10 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb10 == 8) ? 'active' : '' ?>"><input
                                            name="reken_gb10" type="radio"
                                            value="8" <?php echo ($student->reken_gb10 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb10 == 10) ? 'active' : '' ?>"><input
                                            name="reken_gb10" type="radio"
                                            value="10" <?php echo ($student->reken_gb10 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value == 2) { ?>
                            <label class="col-sm-3" for="reken_gb20"> Getalbegrip t/m 20 </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb20 == 1) ? 'active' : '' ?>"><input
                                            name="reken_gb20" type="radio"
                                            value="1" <?php echo ($student->reken_gb20 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb20 == 3) ? 'active' : '' ?>"><input
                                            name="reken_gb20" type="radio"
                                            value="3" <?php echo ($student->reken_gb20 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb20 == 6) ? 'active' : '' ?>"><input
                                            name="reken_gb20" type="radio"
                                            value="6" <?php echo ($student->reken_gb20 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb20 == 8) ? 'active' : '' ?>"><input
                                            name="reken_gb20" type="radio"
                                            value="8" <?php echo ($student->reken_gb20 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gb20 == 10) ? 'active' : '' ?>"><input
                                            name="reken_gb20" type="radio"
                                            value="10" <?php echo ($student->reken_gb20 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value == 3) { ?>
                            <label class="col-sm-3" for="reken_r10"> Rekenen tot 10 </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r10 == 1) ? 'active' : '' ?>"><input
                                            name="reken_r10" type="radio"
                                            value="1" <?php echo ($student->reken_r10 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r10 == 3) ? 'active' : '' ?>"><input
                                            name="reken_r10" type="radio"
                                            value="3" <?php echo ($student->reken_r10 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r10 == 6) ? 'active' : '' ?>"><input
                                            name="reken_r10" type="radio"
                                            value="6" <?php echo ($student->reken_r10 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r10 == 8) ? 'active' : '' ?>"><input
                                            name="reken_r10" type="radio"
                                            value="8" <?php echo ($student->reken_r10 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r10 == 10) ? 'active' : '' ?>"><input
                                            name="reken_r10" type="radio"
                                            value="10" <?php echo ($student->reken_r10 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value == 3) { ?>
                            <label class="col-sm-3" for="reken_r20"> Rekenen tot 20 </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r20 == 1) ? 'active' : '' ?>"><input
                                            name="reken_r20" type="radio"
                                            value="1" <?php echo ($student->reken_r20 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r20 == 3) ? 'active' : '' ?>"><input
                                            name="reken_r20" type="radio"
                                            value="3" <?php echo ($student->reken_r20 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r20 == 6) ? 'active' : '' ?>"><input
                                            name="reken_r20" type="radio"
                                            value="6" <?php echo ($student->reken_r20 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r20 == 8) ? 'active' : '' ?>"><input
                                            name="reken_r20" type="radio"
                                            value="8" <?php echo ($student->reken_r20 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r20 == 10) ? 'active' : '' ?>"><input
                                            name="reken_r20" type="radio"
                                            value="10" <?php echo ($student->reken_r20 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value == 4) { ?>
                            <label class="col-sm-3" for="reken_r50"> Rekent tot 50 </label>
                            <div class="btn-group" data-toggle="buttons"><label
                                        class="btn btn-default <?php echo ($student->reken_r50 == 1) ? 'active' : '' ?>">
                                    <input name="reken_r50" type="radio"
                                           value="1" <?php echo ($student->reken_r50 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r50 == 3) ? 'active' : '' ?>"><input
                                            name="reken_r50" type="radio"
                                            value="3" <?php echo ($student->reken_r50 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r50 == 6) ? 'active' : '' ?>"><input
                                            name="reken_r50" type="radio"
                                            value="6" <?php echo ($student->reken_r50 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r50 == 8) ? 'active' : '' ?>"><input
                                            name="reken_r50" type="radio"
                                            value="8" <?php echo ($student->reken_r50 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r50 == 10) ? 'active' : '' ?>"><input
                                            name="reken_r50" type="radio"
                                            value="10" <?php echo ($student->reken_r50 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 4 || $value == 5) { ?>
                            <label class="col-sm-3" for="reken_r100"> Rekenen tot 100 </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r100 == 1) ? 'active' : '' ?>"><input
                                            name="reken_r100" type="radio"
                                            value="1" <?php echo ($student->reken_r100 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r100 == 3) ? 'active' : '' ?>"><input
                                            name="reken_r100" type="radio"
                                            value="3" <?php echo ($student->reken_r100 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r100 == 6) ? 'active' : '' ?>"><input
                                            name="reken_r100" type="radio"
                                            value="6" <?php echo ($student->reken_r100 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r100 == 8) ? 'active' : '' ?>"><input
                                            name="reken_r100" type="radio"
                                            value="8" <?php echo ($student->reken_r100 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r100 == 10) ? 'active' : '' ?>"><input
                                            name="reken_r100" type="radio"
                                            value="10" <?php echo ($student->reken_r100 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value == 5) { ?>
                            <label class="col-sm-3" for="reken_r1000"> Rekenen tot 1000 </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r1000 == 1) ? 'active' : '' ?>"><input
                                            name="reken_r1000" type="radio"
                                            value="1" <?php echo ($student->reken_r1000 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r1000 == 3) ? 'active' : '' ?>"><input
                                            name="reken_r1000" type="radio"
                                            value="3" <?php echo ($student->reken_r1000 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r1000 == 6) ? 'active' : '' ?>"><input
                                            name="reken_r1000" type="radio"
                                            value="6" <?php echo ($student->reken_r1000 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r1000 == 8) ? 'active' : '' ?>"><input
                                            name="reken_r1000" type="radio"
                                            value="8" <?php echo ($student->reken_r1000 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_r1000 == 10) ? 'active' : '' ?>"><input
                                            name="reken_r1000" type="radio"
                                            value="10" <?php echo ($student->reken_r1000 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 4) { ?>
                            <label class="col-sm-3" for="reken_k5"> Keertafels 1 t/m 5 + 10 </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_k5 == 1) ? 'active' : '' ?>"><input
                                            name="reken_k5" type="radio"
                                            value="1" <?php echo ($student->reken_k5 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_k5 == 3) ? 'active' : '' ?>"><input
                                            name="reken_k5" type="radio"
                                            value="3" <?php echo ($student->reken_k5 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_k5 == 6) ? 'active' : '' ?>"><input
                                            name="reken_k5" type="radio"
                                            value="6" <?php echo ($student->reken_k5 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_k5 == 8) ? 'active' : '' ?>"><input
                                            name="reken_k5" type="radio"
                                            value="8" <?php echo ($student->reken_k5 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_k5 == 10) ? 'active' : '' ?>"><input
                                            name="reken_k5" type="radio"
                                            value="10" <?php echo ($student->reken_k5 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 5) { ?>
                            <label class="col-sm-3" for="reken_k10"> Keertafels 1 t/m 10 </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_k10 == 1) ? 'active' : '' ?>"><input
                                            name="reken_k10" type="radio"
                                            value="1" <?php echo ($student->reken_k10 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_k10 == 3) ? 'active' : '' ?>"><input
                                            name="reken_k10" type="radio"
                                            value="3" <?php echo ($student->reken_k10 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_k10 == 6) ? 'active' : '' ?>"><input
                                            name="reken_k10" type="radio"
                                            value="6" <?php echo ($student->reken_k10 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_k10 == 8) ? 'active' : '' ?>"><input
                                            name="reken_k10" type="radio"
                                            value="8" <?php echo ($student->reken_k10 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_k10 == 10) ? 'active' : '' ?>"><input
                                            name="reken_k10" type="radio"
                                            value="10" <?php echo ($student->reken_k10 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 1) { ?>
                            <label class="col-sm-3" for="reken_wk"> Kent de dagen van de week </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_wk == 1) ? 'active' : '' ?>"><input
                                            name="reken_wk" type="radio"
                                            value="1" <?php echo ($student->reken_wk == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_wk == 3) ? 'active' : '' ?>"><input
                                            name="reken_wk" type="radio"
                                            value="3" <?php echo ($student->reken_wk == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_wk == 6) ? 'active' : '' ?>"><input
                                            name="reken_wk" type="radio"
                                            value="6" <?php echo ($student->reken_wk == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_wk == 8) ? 'active' : '' ?>"><input
                                            name="reken_wk" type="radio"
                                            value="8" <?php echo ($student->reken_wk == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_wk == 10) ? 'active' : '' ?>"><input
                                            name="reken_wk" type="radio"
                                            value="10" <?php echo ($student->reken_wk == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value > 4) { ?>
                            <label class="col-sm-3" for="reken_bh"> Beheersing hoofdbewerkingen </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_bh == 1) ? 'active' : '' ?>"><input
                                            name="reken_bh" type="radio"
                                            value="1" <?php echo ($student->reken_bh == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_bh == 3) ? 'active' : '' ?>"><input
                                            name="reken_bh" type="radio"
                                            value="3" <?php echo ($student->reken_bh == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_bh == 6) ? 'active' : '' ?>"><input
                                            name="reken_bh" type="radio"
                                            value="6" <?php echo ($student->reken_bh == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_bh == 8) ? 'active' : '' ?>"><input
                                            name="reken_bh" type="radio"
                                            value="8" <?php echo ($student->reken_bh == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_bh == 10) ? 'active' : '' ?>"><input
                                            name="reken_bh" type="radio"
                                            value="10" <?php echo ($student->reken_bh == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 3) { ?>
                            <label class="col-sm-3" for="reken_a10"> Automatiseren tot en met 10 </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_a10 == 1) ? 'active' : '' ?>"><input
                                            name="reken_a10" type="radio"
                                            value="1" <?php echo ($student->reken_a10 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_a10 == 3) ? 'active' : '' ?>"><input
                                            name="reken_a10" type="radio"
                                            value="3" <?php echo ($student->reken_a10 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_a10 == 6) ? 'active' : '' ?>"><input
                                            name="reken_a10" type="radio"
                                            value="6" <?php echo ($student->reken_a10 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_a10 == 8) ? 'active' : '' ?>"><input
                                            name="reken_a10" type="radio"
                                            value="8" <?php echo ($student->reken_a10 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_a10 == 10) ? 'active' : '' ?>"><input
                                            name="reken_a10" type="radio"
                                            value="10" <?php echo ($student->reken_a10 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 4) { ?>
                            <label class="col-sm-3" for="reken_a20"> Automatiseren tot en met 20 </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_a20 == 1) ? 'active' : '' ?>"><input
                                            name="reken_a20" type="radio"
                                            value="1" <?php echo ($student->reken_a20 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_a20 == 3) ? 'active' : '' ?>"><input
                                            name="reken_a20" type="radio"
                                            value="3" <?php echo ($student->reken_a20 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_a20 == 6) ? 'active' : '' ?>"><input
                                            name="reken_a20" type="radio"
                                            value="6" <?php echo ($student->reken_a20 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_a20 == 8) ? 'active' : '' ?>"><input
                                            name="reken_a20" type="radio"
                                            value="8" <?php echo ($student->reken_a20 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_a20 == 10) ? 'active' : '' ?>"><input
                                            name="reken_a20" type="radio"
                                            value="10" <?php echo ($student->reken_a20 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 2) { ?>
                            <label class="col-sm-3" for="reken_ee"> Kent het begrip erbij/eraf </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_ee == 1) ? 'active' : '' ?>"><input
                                            name="reken_ee" type="radio"
                                            value="1" <?php echo ($student->reken_ee == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_ee == 3) ? 'active' : '' ?>"><input
                                            name="reken_ee" type="radio"
                                            value="3" <?php echo ($student->reken_ee == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_ee == 6) ? 'active' : '' ?>"><input
                                            name="reken_ee" type="radio"
                                            value="6" <?php echo ($student->reken_ee == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_ee == 8) ? 'active' : '' ?>"><input
                                            name="reken_ee" type="radio"
                                            value="8" <?php echo ($student->reken_ee == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_ee == 10) ? 'active' : '' ?>"><input
                                            name="reken_ee" type="radio"
                                            value="10" <?php echo ($student->reken_ee == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value <= 2) { ?>
                            <label class="col-sm-3" for="reken_pos"> Kan plaatjes ordenen/sorteren </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_pos == 1) ? 'active' : '' ?>"><input
                                            name="reken_pos" type="radio"
                                            value="1" <?php echo ($student->reken_pos == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_pos == 3) ? 'active' : '' ?>"><input
                                            name="reken_pos" type="radio"
                                            value="3" <?php echo ($student->reken_pos == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_pos == 6) ? 'active' : '' ?>"><input
                                            name="reken_pos" type="radio"
                                            value="6" <?php echo ($student->reken_pos == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_pos == 8) ? 'active' : '' ?>"><input
                                            name="reken_pos" type="radio"
                                            value="8" <?php echo ($student->reken_pos == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_pos == 10) ? 'active' : '' ?>"><input
                                            name="reken_pos" type="radio"
                                            value="10" <?php echo ($student->reken_pos == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 2) { ?>
                            <label class="col-sm-3" for="reken_h4"> Kan schattend een hoeveelheid bepalen t/m
                                4 </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_h4 == 1) ? 'active' : '' ?>"><input
                                            name="reken_h4" type="radio"
                                            value="1" <?php echo ($student->reken_h4 == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_h4 == 3) ? 'active' : '' ?>"><input
                                            name="reken_h4" type="radio"
                                            value="3" <?php echo ($student->reken_h4 == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_h4 == 6) ? 'active' : '' ?>"><input
                                            name="reken_h4" type="radio"
                                            value="6" <?php echo ($student->reken_h4 == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_h4 == 8) ? 'active' : '' ?>"><input
                                            name="reken_h4" type="radio"
                                            value="8" <?php echo ($student->reken_h4 == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_h4 == 10) ? 'active' : '' ?>"><input
                                            name="reken_h4" type="radio"
                                            value="10" <?php echo ($student->reken_h4 == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>

                        <label class="col-sm-3" for="reken_mm"> (Montessori) materiaalgebruik </label>

                        <div class="btn-group" data-toggle="buttons">
                            <label
                                    class="btn btn-default <?php echo ($student->reken_mm == 1) ? 'active' : '' ?>"><input
                                        name="reken_mm" type="radio"
                                        value="1" <?php echo ($student->reken_mm == 1) ? 'checked="checked"' : '' ?>>O</label>
                            <label
                                    class="btn btn-default <?php echo ($student->reken_mm == 3) ? 'active' : '' ?>"><input
                                        name="reken_mm" type="radio"
                                        value="3" <?php echo ($student->reken_mm == 3) ? 'checked="checked"' : '' ?>>Z</label>
                            <label
                                    class="btn btn-default <?php echo ($student->reken_mm == 6) ? 'active' : '' ?>"><input
                                        name="reken_mm" type="radio"
                                        value="6" <?php echo ($student->reken_mm == 6) ? 'checked="checked"' : '' ?>>V</label>
                            <label
                                    class="btn btn-default <?php echo ($student->reken_mm == 8) ? 'active' : '' ?>"><input
                                        name="reken_mm" type="radio"
                                        value="8" <?php echo ($student->reken_mm == 8) ? 'checked="checked"' : '' ?>>RV</label>
                            <label
                                    class="btn btn-default <?php echo ($student->reken_mm == 10) ? 'active' : '' ?>"><input
                                        name="reken_mm" type="radio"
                                        value="10" <?php echo ($student->reken_mm == 10) ? 'checked="checked"' : '' ?>>G</label>
                        </div>
                        <hr/>
                        <?php if ($value > 1) { ?>
                            <label class="col-sm-3" for="reken_td"> Tijdsbegrippen </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_td == 1) ? 'active' : '' ?>"><input
                                            name="reken_td" type="radio"
                                            value="1" <?php echo ($student->reken_td == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_td == 3) ? 'active' : '' ?>"><input
                                            name="reken_td" type="radio"
                                            value="3" <?php echo ($student->reken_td == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_td == 6) ? 'active' : '' ?>"><input
                                            name="reken_td" type="radio"
                                            value="6" <?php echo ($student->reken_td == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_td == 8) ? 'active' : '' ?>"><input
                                            name="reken_td" type="radio"
                                            value="8" <?php echo ($student->reken_td == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_td == 10) ? 'active' : '' ?>"><input
                                            name="reken_td" type="radio"
                                            value="10" <?php echo ($student->reken_td == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 2) { ?>
                            <label class="col-sm-3" for="reken_gg"> Kan grote getallen benoemen </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gg == 1) ? 'active' : '' ?>"><input
                                            name="reken_gg" type="radio"
                                            value="1" <?php echo ($student->reken_gg == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gg == 3) ? 'active' : '' ?>"><input
                                            name="reken_gg" type="radio"
                                            value="3" <?php echo ($student->reken_gg == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gg == 6) ? 'active' : '' ?>"><input
                                            name="reken_gg" type="radio"
                                            value="6" <?php echo ($student->reken_gg == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gg == 8) ? 'active' : '' ?>"><input
                                            name="reken_gg" type="radio"
                                            value="8" <?php echo ($student->reken_gg == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gg == 10) ? 'active' : '' ?>"><input
                                            name="reken_gg" type="radio"
                                            value="10" <?php echo ($student->reken_gg == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value > 2) { ?>
                            <label class="col-sm-3" for="reken_gld"> Geld </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gld == 1) ? 'active' : '' ?>"><input
                                            name="reken_gld" type="radio"
                                            value="1" <?php echo ($student->reken_gld == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gld == 3) ? 'active' : '' ?>"><input
                                            name="reken_gld" type="radio"
                                            value="3" <?php echo ($student->reken_gld == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gld == 6) ? 'active' : '' ?>"><input
                                            name="reken_gld" type="radio"
                                            value="6" <?php echo ($student->reken_gld == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gld == 8) ? 'active' : '' ?>"><input
                                            name="reken_gld" type="radio"
                                            value="8" <?php echo ($student->reken_gld == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_gld == 10) ? 'active' : '' ?>"><input
                                            name="reken_gld" type="radio"
                                            value="10" <?php echo ($student->reken_gld == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value > 2) { ?>
                            <label class="col-sm-3" for="reken_mem"> Meten en meetkunde </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->reken_mem == 1) ? 'active' : '' ?>"><input
                                            name="reken_mem" type="radio"
                                            value="1" <?php echo ($student->reken_mem == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_mem == 3) ? 'active' : '' ?>"><input
                                            name="reken_mem" type="radio"
                                            value="3" <?php echo ($student->reken_mem == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_mem == 6) ? 'active' : '' ?>"><input
                                            name="reken_mem" type="radio"
                                            value="6" <?php echo ($student->reken_mem == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_mem == 8) ? 'active' : '' ?>"><input
                                            name="reken_mem" type="radio"
                                            value="8" <?php echo ($student->reken_mem == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->reken_mem == 10) ? 'active' : '' ?>"><input
                                            name="reken_mem" type="radio"
                                            value="10" <?php echo ($student->reken_mem == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>

            <!-- About Section -->
            <section id="schrijven" class="schrijven-fijne-motoriek-section form-block">
                <div class="row ">
                    <div class="well schrijven">
                        <?php if ($value > 3) { ?><h1>Schrijven</h1><?php } else { ?><h1>Fijne
                            motoriek</h1><?php } ?>

                        <?php if ($value <= 2) { ?>
                            <label class="col-sm-3" for="motor_kg"> Is vaardig in het hanteren van
                                knutselgereedschappen </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->motor_kg == 1) ? 'active' : '' ?>"><input
                                            name="motor_kg" type="radio"
                                            value="1" <?php echo ($student->motor_kg == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->motor_kg == 3) ? 'active' : '' ?>"><input
                                            name="motor_kg" type="radio"
                                            value="3" <?php echo ($student->motor_kg == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->motor_kg == 6) ? 'active' : '' ?>"><input
                                            name="motor_kg" type="radio"
                                            value="6" <?php echo ($student->motor_kg == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->motor_kg == 8) ? 'active' : '' ?>"><input
                                            name="motor_kg" type="radio"
                                            value="8" <?php echo ($student->motor_kg == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->motor_kg == 10) ? 'active' : '' ?>"><input
                                            name="motor_kg" type="radio"
                                            value="10" <?php echo ($student->motor_kg == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value <= 2) { ?>
                            <label class="col-sm-3" for="motor_ohc"> Oog-hand co&ouml;rdinatie </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->motor_ohc == 1) ? 'active' : '' ?>"><input
                                            name="motor_ohc" type="radio"
                                            value="1" <?php echo ($student->motor_ohc == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->motor_ohc == 3) ? 'active' : '' ?>"><input
                                            name="motor_ohc" type="radio"
                                            value="3" <?php echo ($student->motor_ohc == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->motor_ohc == 6) ? 'active' : '' ?>"><input
                                            name="motor_ohc" type="radio"
                                            value="6" <?php echo ($student->motor_ohc == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->motor_ohc == 8) ? 'active' : '' ?>"><input
                                            name="motor_ohc" type="radio"
                                            value="8" <?php echo ($student->motor_ohc == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->motor_ohc == 10) ? 'active' : '' ?>"><input
                                            name="motor_ohc" type="radio"
                                            value="10" <?php echo ($student->motor_ohc == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value == 3 || $value == 4 || $value == 5) { ?>
                            <label class="col-sm-3" for="schrijf_fm"> Fijne motoriek</label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_fm == 1) ? 'active' : '' ?>"><input
                                            name="schrijf_fm" type="radio"
                                            value="1" <?php echo ($student->schrijf_fm == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_fm == 3) ? 'active' : '' ?>"><input
                                            name="schrijf_fm" type="radio"
                                            value="3" <?php echo ($student->schrijf_fm == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_fm == 6) ? 'active' : '' ?>"><input
                                            name="schrijf_fm" type="radio"
                                            value="6" <?php echo ($student->schrijf_fm == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_fm == 8) ? 'active' : '' ?>"><input
                                            name="schrijf_fm" type="radio"
                                            value="8" <?php echo ($student->schrijf_fm == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_fm == 10) ? 'active' : '' ?>"><input
                                            name="schrijf_fm" type="radio"
                                            value="10" <?php echo ($student->schrijf_fm == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value == 3 || $value == 4 || $value == 5) { ?>
                            <label class="col-sm-3" for="schrijf_vl">Vorm van de letters</label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_vl == 1) ? 'active' : '' ?>"><input
                                            name="schrijf_vl" type="radio"
                                            value="1" <?php echo ($student->schrijf_vl == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_vl == 3) ? 'active' : '' ?>"><input
                                            name="schrijf_vl" type="radio"
                                            value="3" <?php echo ($student->schrijf_vl == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_vl == 6) ? 'active' : '' ?>"><input
                                            name="schrijf_vl" type="radio"
                                            value="6" <?php echo ($student->schrijf_vl == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_vl == 8) ? 'active' : '' ?>"><input
                                            name="schrijf_vl" type="radio"
                                            value="8" <?php echo ($student->schrijf_vl == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_vl == 10) ? 'active' : '' ?>"><input
                                            name="schrijf_vl" type="radio"
                                            value="10" <?php echo ($student->schrijf_vl == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 3 || $value == 4 || $value == 5) { ?>
                            <label class="col-sm-3" for="schrijf_sh"> Schrijfhouding </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_sh == 1) ? 'active' : '' ?>"><input
                                            name="schrijf_sh" type="radio"
                                            value="1" <?php echo ($student->schrijf_sh == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_sh == 3) ? 'active' : '' ?>"><input
                                            name="schrijf_sh" type="radio"
                                            value="3" <?php echo ($student->schrijf_sh == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_sh == 6) ? 'active' : '' ?>"><input
                                            name="schrijf_sh" type="radio"
                                            value="6" <?php echo ($student->schrijf_sh == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_sh == 8) ? 'active' : '' ?>"><input
                                            name="schrijf_sh" type="radio"
                                            value="8" <?php echo ($student->schrijf_sh == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_sh == 10) ? 'active' : '' ?>"><input
                                            name="schrijf_sh" type="radio"
                                            value="10" <?php echo ($student->schrijf_sh == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value == 3 || $value == 4 || $value == 5) { ?>
                            <label class="col-sm-3" for="schrijf_pg"> Pengreep </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_pg == 1) ? 'active' : '' ?>"><input
                                            name="schrijf_pg" type="radio"
                                            value="1" <?php echo ($student->schrijf_pg == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_pg == 3) ? 'active' : '' ?>"><input
                                            name="schrijf_pg" type="radio"
                                            value="3" <?php echo ($student->schrijf_pg == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_pg == 6) ? 'active' : '' ?>"><input
                                            name="schrijf_pg" type="radio"
                                            value="6" <?php echo ($student->schrijf_pg == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_pg == 8) ? 'active' : '' ?>"><input
                                            name="schrijf_pg" type="radio"
                                            value="8" <?php echo ($student->schrijf_pg == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_pg == 10) ? 'active' : '' ?>"><input
                                            name="schrijf_pg" type="radio"
                                            value="10" <?php echo ($student->schrijf_pg == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value > 5) { ?>
                            <label class="col-sm-3" for="schrijf_vz"> Verzorging </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_vz == 1) ? 'active' : '' ?>"><input
                                            name="schrijf_vz" type="radio"
                                            value="1" <?php echo ($student->schrijf_vz == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_vz == 3) ? 'active' : '' ?>"><input
                                            name="schrijf_vz" type="radio"
                                            value="3" <?php echo ($student->schrijf_vz == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_vz == 6) ? 'active' : '' ?>"><input
                                            name="schrijf_vz" type="radio"
                                            value="6" <?php echo ($student->schrijf_vz == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_vz == 8) ? 'active' : '' ?>"><input
                                            name="schrijf_vz" type="radio"
                                            value="8" <?php echo ($student->schrijf_vz == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_vz == 10) ? 'active' : '' ?>"><input
                                            name="schrijf_vz" type="radio"
                                            value="10" <?php echo ($student->schrijf_vz == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value > 5) { ?>
                            <label class="col-sm-3" for="schrijf_lh"> Leesbaarheid </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_lh == 1) ? 'active' : '' ?>"><input
                                            name="schrijf_lh" type="radio"
                                            value="1" <?php echo ($student->schrijf_lh == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_lh == 3) ? 'active' : '' ?>"><input
                                            name="schrijf_lh" type="radio"
                                            value="3" <?php echo ($student->schrijf_lh == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_lh == 6) ? 'active' : '' ?>"><input
                                            name="schrijf_lh" type="radio"
                                            value="6" <?php echo ($student->schrijf_lh == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_lh == 8) ? 'active' : '' ?>"><input
                                            name="schrijf_lh" type="radio"
                                            value="8" <?php echo ($student->schrijf_lh == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_lh == 10) ? 'active' : '' ?>"><input
                                            name="schrijf_lh" type="radio"
                                            value="10" <?php echo ($student->schrijf_lh == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/><?php } ?>
                        <?php if ($value > 5) { ?>
                            <label class="col-sm-3" for="schrijf_bi"> Bladindeling </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_bi == 1) ? 'active' : '' ?>"><input
                                            name="schrijf_bi" type="radio"
                                            value="1" <?php echo ($student->schrijf_bi == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_bi == 3) ? 'active' : '' ?>"><input
                                            name="schrijf_bi" type="radio"
                                            value="3" <?php echo ($student->schrijf_bi == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_bi == 6) ? 'active' : '' ?>"><input
                                            name="schrijf_bi" type="radio"
                                            value="6" <?php echo ($student->schrijf_bi == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_bi == 8) ? 'active' : '' ?>"><input
                                            name="schrijf_bi" type="radio"
                                            value="8" <?php echo ($student->schrijf_bi == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->schrijf_bi == 10) ? 'active' : '' ?>"><input
                                            name="schrijf_bi" type="radio"
                                            value="10" <?php echo ($student->schrijf_bi == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>

            <!-- About Section -->
            <section id="kosmisch" class="kosmisch-section form-block">
                <div class="row ">
                    <div class="well kosmi">
                        <h1>Kosmisch</h1>
                        <label class="col-sm-3" for="kosmi_in"> Toont interesse voor kosmische lessen </label>

                        <div class="btn-group" data-toggle="buttons">
                            <label
                                    class="btn btn-default <?php echo ($student->kosmi_in == 1) ? 'active' : '' ?>"><input
                                        name="kosmi_in" type="radio"
                                        value="1" <?php echo ($student->kosmi_in == 1) ? 'checked="checked"' : '' ?>>O</label>
                            <label
                                    class="btn btn-default <?php echo ($student->kosmi_in == 3) ? 'active' : '' ?>"><input
                                        name="kosmi_in" type="radio"
                                        value="3" <?php echo ($student->kosmi_in == 3) ? 'checked="checked"' : '' ?>>Z</label>
                            <label
                                    class="btn btn-default <?php echo ($student->kosmi_in == 6) ? 'active' : '' ?>"><input
                                        name="kosmi_in" type="radio"
                                        value="6" <?php echo ($student->kosmi_in == 6) ? 'checked="checked"' : '' ?>>V</label>
                            <label
                                    class="btn btn-default <?php echo ($student->kosmi_in == 8) ? 'active' : '' ?>"><input
                                        name="kosmi_in" type="radio"
                                        value="8" <?php echo ($student->kosmi_in == 8) ? 'checked="checked"' : '' ?>>RV</label>
                            <label
                                    class="btn btn-default <?php echo ($student->kosmi_in == 10) ? 'active' : '' ?>"><input
                                        name="kosmi_in" type="radio"
                                        value="10" <?php echo ($student->kosmi_in == 10) ? 'checked="checked"' : '' ?>>G</label>
                        </div>
                        <hr/>
                        <?php if ($value <= 2) { ?>
                            <label class="col-sm-3" for="kosmi_kk">Kiest werkjes uit de kosmische kast en van de
                                aandachtstafel </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_kk == 1) ? 'active' : '' ?>"><input
                                            name="kosmi_kk" type="radio"
                                            value="1" <?php echo ($student->kosmi_kk == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_kk == 3) ? 'active' : '' ?>"><input
                                            name="kosmi_kk" type="radio"
                                            value="3" <?php echo ($student->kosmi_kk == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_kk == 6) ? 'active' : '' ?>"><input
                                            name="kosmi_kk" type="radio"
                                            value="6" <?php echo ($student->kosmi_kk == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_kk == 8) ? 'active' : '' ?>"><input
                                            name="kosmi_kk" type="radio"
                                            value="8" <?php echo ($student->kosmi_kk == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_kk == 10) ? 'active' : '' ?>"><input
                                            name="kosmi_kk" type="radio"
                                            value="10" <?php echo ($student->kosmi_kk == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value > 2) { ?>
                            <label class="col-sm-3" for="kosmi_pr"> Projecten </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_pr == 1) ? 'active' : '' ?>"><input
                                            name="kosmi_pr" type="radio"
                                            value="1" <?php echo ($student->kosmi_pr == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_pr == 3) ? 'active' : '' ?>"><input
                                            name="kosmi_pr" type="radio"
                                            value="3" <?php echo ($student->kosmi_pr == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_pr == 6) ? 'active' : '' ?>"><input
                                            name="kosmi_pr" type="radio"
                                            value="6" <?php echo ($student->kosmi_pr == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_pr == 8) ? 'active' : '' ?>"><input
                                            name="kosmi_pr" type="radio"
                                            value="8" <?php echo ($student->kosmi_pr == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_pr == 10) ? 'active' : '' ?>"><input
                                            name="kosmi_pr" type="radio"
                                            value="10" <?php echo ($student->kosmi_pr == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value > 4) { ?>
                            <label class="col-sm-3" for="kosmi_ws"> Werkstuk </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_ws == 1) ? 'active' : '' ?>"><input
                                            name="kosmi_ws" type="radio"
                                            value="1" <?php echo ($student->kosmi_ws == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_ws == 3) ? 'active' : '' ?>"><input
                                            name="kosmi_ws" type="radio"
                                            value="3" <?php echo ($student->kosmi_ws == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_ws == 6) ? 'active' : '' ?>"><input
                                            name="kosmi_ws" type="radio"
                                            value="6" <?php echo ($student->kosmi_ws == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_ws == 8) ? 'active' : '' ?>"><input
                                            name="kosmi_ws" type="radio"
                                            value="8" <?php echo ($student->kosmi_ws == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_ws == 10) ? 'active' : '' ?>"><input
                                            name="kosmi_ws" type="radio"
                                            value="10" <?php echo ($student->kosmi_ws == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value > 2) { ?>
                            <label class="col-sm-3" for="kosmi_tn"> Techniek </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_tn == 1) ? 'active' : '' ?>"><input
                                            name="kosmi_tn" type="radio"
                                            value="1" <?php echo ($student->kosmi_tn == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_tn == 3) ? 'active' : '' ?>"><input
                                            name="kosmi_tn" type="radio"
                                            value="3" <?php echo ($student->kosmi_tn == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_tn == 6) ? 'active' : '' ?>"><input
                                            name="kosmi_tn" type="radio"
                                            value="6" <?php echo ($student->kosmi_tn == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_tn == 8) ? 'active' : '' ?>"><input
                                            name="kosmi_tn" type="radio"
                                            value="8" <?php echo ($student->kosmi_tn == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_tn == 10) ? 'active' : '' ?>"><input
                                            name="kosmi_tn" type="radio"
                                            value="10" <?php echo ($student->kosmi_tn == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value > 4) { ?>
                            <label class="col-sm-3" for="kosmi_sb"> Spreekbeurt </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_sb == 1) ? 'active' : '' ?>"><input
                                            name="kosmi_sb" type="radio"
                                            value="1" <?php echo ($student->kosmi_sb == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_sb == 3) ? 'active' : '' ?>"><input
                                            name="kosmi_sb" type="radio"
                                            value="3" <?php echo ($student->kosmi_sb == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_sb == 6) ? 'active' : '' ?>"><input
                                            name="kosmi_sb" type="radio"
                                            value="6" <?php echo ($student->kosmi_sb == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_sb == 8) ? 'active' : '' ?>"><input
                                            name="kosmi_sb" type="radio"
                                            value="8" <?php echo ($student->kosmi_sb == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_sb == 10) ? 'active' : '' ?>"><input
                                            name="kosmi_sb" type="radio"
                                            value="10" <?php echo ($student->kosmi_sb == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value == 3 || $value == 4 || $value == 5) { ?>
                            <label class="col-sm-3" for="kosmi_mm"> (Montessori) materiaalgebruik </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_mm == 1) ? 'active' : '' ?>"><input
                                            name="kosmi_mm" type="radio"
                                            value="1" <?php echo ($student->kosmi_mm == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_mm == 3) ? 'active' : '' ?>"><input
                                            name="kosmi_mm" type="radio"
                                            value="3" <?php echo ($student->kosmi_mm == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_mm == 6) ? 'active' : '' ?>"><input
                                            name="kosmi_mm" type="radio"
                                            value="6" <?php echo ($student->kosmi_mm == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_mm == 8) ? 'active' : '' ?>"><input
                                            name="kosmi_mm" type="radio"
                                            value="8" <?php echo ($student->kosmi_mm == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_mm == 10) ? 'active' : '' ?>"><input
                                            name="kosmi_mm" type="radio"
                                            value="10" <?php echo ($student->kosmi_mm == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>
                        <?php if ($value > 4) { ?>
                            <label class="col-sm-3" for="kosmi_vk"> Verkeer (inzet) </label>
                            <div class="btn-group" data-toggle="buttons">
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_vk == 1) ? 'active' : '' ?>"><input
                                            name="kosmi_vk" type="radio"
                                            value="1" <?php echo ($student->kosmi_vk == 1) ? 'checked="checked"' : '' ?>>O</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_vk == 3) ? 'active' : '' ?>"><input
                                            name="kosmi_vk" type="radio"
                                            value="3" <?php echo ($student->kosmi_vk == 3) ? 'checked="checked"' : '' ?>>Z</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_vk == 6) ? 'active' : '' ?>"><input
                                            name="kosmi_vk" type="radio"
                                            value="6" <?php echo ($student->kosmi_vk == 6) ? 'checked="checked"' : '' ?>>V</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_vk == 8) ? 'active' : '' ?>"><input
                                            name="kosmi_vk" type="radio"
                                            value="8" <?php echo ($student->kosmi_vk == 8) ? 'checked="checked"' : '' ?>>RV</label>
                                <label
                                        class="btn btn-default <?php echo ($student->kosmi_vk == 10) ? 'active' : '' ?>"><input
                                            name="kosmi_vk" type="radio"
                                            value="10" <?php echo ($student->kosmi_vk == 10) ? 'checked="checked"' : '' ?>>G</label>
                            </div>
                            <hr/>
                        <?php } ?>

                        <div class="form-group">
                            <label class="col-sm-3" for="kosmi_verslag">Verslag</label><br/>
                            <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="kosmi_verslag"
                                      name="kosmi_verslag" spellcheck="true"><?= $student->kosmi_verslag; ?></textarea>

                        </div>
                        <hr/>
                    </div>
                </div>
            </section>

            <!-- About Section -->
            <section id="creatief" class="creatieve-ontwikkeling-section form-block">
                <div class="row ">
                    <div class="well crea">
                        <h1>Creatieve ontwikkeling</h1>

                        <div class="form-group"><label class="col-sm-3" for="crea_verslag"> Verslag </label><br/>
                            <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="crea_verslag"
                                      name="crea_verslag" spellcheck="true"><?= $student->crea_verslag; ?></textarea>

                        </div>
                    </div>
                    <hr/>
                </div>
            </section>

            <!-- About Section -->
            <section id="gymnastiek" class="gymnastiek-section form-block">
                <div class="row ">
                    <div class="well gym">
                        <h1>Gymnastiek</h1>
                        <label class="col-sm-3" for="gym_in"> Inzet </label>

                        <div class="btn-group" data-toggle="buttons">
                            <label
                                    class="btn btn-default <?php echo ($student->gym_in == 1) ? 'active' : '' ?>"><input
                                        name="gym_in" type="radio"
                                        value="1" <?php echo ($student->gym_in == 1) ? 'checked="checked"' : '' ?>>O</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gym_in == 3) ? 'active' : '' ?>"><input
                                        name="gym_in" type="radio"
                                        value="3" <?php echo ($student->gym_in == 3) ? 'checked="checked"' : '' ?>>Z</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gym_in == 6) ? 'active' : '' ?>"><input
                                        name="gym_in" type="radio"
                                        value="6" <?php echo ($student->gym_in == 6) ? 'checked="checked"' : '' ?>>V</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gym_in == 8) ? 'active' : '' ?>"><input
                                        name="gym_in" type="radio"
                                        value="8" <?php echo ($student->gym_in == 8) ? 'checked="checked"' : '' ?>>RV</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gym_in == 10) ? 'active' : '' ?>"><input
                                        name="gym_in" type="radio"
                                        value="10" <?php echo ($student->gym_in == 10) ? 'checked="checked"' : '' ?>>G</label>
                        </div>
                        <hr/>

                        <label class="col-sm-3" for="gym_sv"> Sociale vaardigheden (samenwerken,luisteren) </label>

                        <div class="btn-group" data-toggle="buttons">
                            <label
                                    class="btn btn-default <?php echo ($student->gym_sv == 1) ? 'active' : '' ?>"><input
                                        name="gym_sv" type="radio"
                                        value="1" <?php echo ($student->gym_sv == 1) ? 'checked="checked"' : '' ?>>O</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gym_sv == 3) ? 'active' : '' ?>"><input
                                        name="gym_sv" type="radio"
                                        value="3" <?php echo ($student->gym_sv == 3) ? 'checked="checked"' : '' ?>>Z</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gym_sv == 6) ? 'active' : '' ?>"><input
                                        name="gym_sv" type="radio"
                                        value="6" <?php echo ($student->gym_sv == 6) ? 'checked="checked"' : '' ?>>V</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gym_sv == 8) ? 'active' : '' ?>"><input
                                        name="gym_sv" type="radio"
                                        value="8" <?php echo ($student->gym_sv == 8) ? 'checked="checked"' : '' ?>>RV</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gym_sv == 10) ? 'active' : '' ?>"><input
                                        name="gym_sv" type="radio"
                                        value="10" <?php echo ($student->gym_sv == 10) ? 'checked="checked"' : '' ?>>G</label>
                        </div>
                        <hr/>

                        <label class="col-sm-3" for="gym_mv"> Motorische vaardigheden </label>

                        <div class="btn-group" data-toggle="buttons">
                            <label
                                    class="btn btn-default <?php echo ($student->gym_mv == 1) ? 'active' : '' ?>"><input
                                        name="gym_mv" type="radio"
                                        value="1" <?php echo ($student->gym_mv == 1) ? 'checked="checked"' : '' ?>>O</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gym_mv == 3) ? 'active' : '' ?>"><input
                                        name="gym_mv" type="radio"
                                        value="3" <?php echo ($student->gym_mv == 3) ? 'checked="checked"' : '' ?>>Z</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gym_mv == 6) ? 'active' : '' ?>"><input
                                        name="gym_mv" type="radio"
                                        value="6" <?php echo ($student->gym_mv == 6) ? 'checked="checked"' : '' ?>>V</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gym_mv == 8) ? 'active' : '' ?>"><input
                                        name="gym_mv" type="radio"
                                        value="8" <?php echo ($student->gym_mv == 8) ? 'checked="checked"' : '' ?>>RV</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gym_mv == 10) ? 'active' : '' ?>"><input
                                        name="gym_mv" type="radio"
                                        value="10" <?php echo ($student->gym_mv == 10) ? 'checked="checked"' : '' ?>>G</label>
                        </div>
                        <hr/>

                        <div class="form-group"><label class="col-sm-3" for="gym_verslag"> Verslag </label><br/>
                            <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="gym_verslag"
                                      name="gym_verslag" spellcheck="true"><?= $student->gym_verslag; ?></textarea>

                        </div>
                        <hr/>

                    </div>
                </div>
            </section>

            <!-- About Section -->
            <section id="ondersteuning" class="extra-ondersteuning-section form-block">
                <div class="row ">
                    <div class="well eo">
                        <h1>(Extra) Ondersteuning</h1>

                        <div class="form-group"><label class="col-sm-3" for="eo_verslag"> Verslag </label><br/>
                            <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="eo_verslag"
                                      name="eo_verslag" spellcheck="true"><?= $student->eo_verslag; ?></textarea>

                        </div>
                    </div>
                    <hr/>
                </div>
            </section>

            <!-- About Section -->
            <section id="opmerkingen" class="overige-opmerkingen-section  form-block">
                <div class="row ">
                    <div class="well oo">
                        <h1>Opmerkingen</h1>

                        <div class="form-group"><label class="col-sm-3" for="oo_verslag"> Verslag </label><br/>
                            <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="oo_verslag"
                                      name="oo_verslag" spellcheck="true"><?= $student->oo_verslag; ?></textarea>

                        </div>
                    </div>
                    <hr/>
                </div>
            </section>

            <!--
            <section id="notes" class="notities-section  form-block">
                <div class="row">
                    <div class="well">
                        <h1>Interne Notities</h1>

                        <div class="form-group"><label class="col-sm-3" for="notes"> Eigen notities </label><br/>
                                <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="inotes"
                                          name="notes" spellcheck="true">< ?= $student->notes; ?></textarea>

                        </div>
                    </div>
                    <hr/>
                </div>
            </section>
            notes Section -->

            <!-- About Section -->
            <section id="finish" class="overzicht-section  form-block">
                <div class="row">
                    <div class="well">
                        <h1>Opslaan</h1>

                        <p>

                            Indien u (geheel) gereed bent kunt u gebruik maken van de knop: Opslaan.
                            <br/>U kunt in het overzicht van uw leerlingen een voorbeeld bekijken of dit verslag
                            downloaden.
                        </p>

                        <div class="btn-group">
                            <?php } ?>
                            <button type="submit" id="store-done" class="btn btn-danger btn-sm">Opslaan</button>
                        </div>
                    </div>
                    <hr/>
                </div>
            </section>
        </div>

    </form>
</div>
<?php endforeach; ?>