<div class="col-xs-12 col-sm-3 fixed hidden-xs">
    <div class="row-fluid">
        <ul class="nav nav-pills nav-stacked">
            <?php foreach ($students->result() as $student): ?>
            <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
            <li class="hidden">
                <a class="page-scroll" href="#page-top"></a>
            </li>
            <li>
                <a class="page-scroll" href="#" data-id="taal">Taal</a>
            </li>
            <li>
                <a class="page-scroll" href="#" data-id="rekenen">Rekenen</a>
            </li>
            <li>
                <a class="page-scroll" href="#" data-id="creatief">Creatieve ontwikkeling</a>
            </li>
            <li>
                <a class="page-scroll" href="#" data-id="fijne">Fijne motoriek</a>
            </li>
            <li>
                <a class="page-scroll" href="#" data-id="grove">Grove motoriek</a>
            </li>
            <li>
                <a class="page-scroll" href="#" data-id="opmerkingen">Opmerkingen</a>
            </li>
            <li>
                <a class="page-scroll" href="#" data-id="finish">Opslaan</a>
            </li>
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
                    <span style="color:#666;">Peutergroep</h2>

                </h2>
                <div class="form-group">
                    <label class="col-sm-3" for="datum_periode">datum_periode</label>
                    <input name="datum_periode" class="form-control date-picker" value="<?= $student->datum_periode; ?>"
                           placeholder="maand jaar voorbeeld: maart 2016"/>
                </div>
                <!-- ?php if ($this->user->has_permission('leidsters')||$this->user->has_permission('admin')) { ? -->
                <!-- ?php } ? -->
                <div class="ui-widget form-group">
                    <label class="col-sm-3" for="tags" style="font-family:'Roboto', Arial, sans; font-size:12px;">Leid(st)er(s) </label>
                    <input id="tags" name="leidsters" value="<?= $student->leidsters; ?>" class="form-control"
                           size="50">
                </div>
            </div>
            <section id="kosmisch" class="kosmisch-section form-block">
                <div class="row ">
                    <div class="well kosmi">
                        <h1>Periode van groei</h1>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgik">Benoemt zichzelf als
                            'ik'</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgik == 3) ? 'active' : '' ?>">
                                <input name="pvgik" type="radio"
                                       value="3" <?php echo ($student->pvgik == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgik == 6) ? 'active' : '' ?>"><input
                                        name="pvgik" type="radio"
                                        value="6" <?php echo ($student->pvgik == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgik == 9) ? 'active' : '' ?>"><input
                                        name="pvgik" type="radio"
                                        value="9" <?php echo ($student->pvgik == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>

                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgcl">Heeft contact met de
                            leidster</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgcl == 3) ? 'active' : '' ?>">
                                <input name="pvgcl" type="radio"
                                       value="3" <?php echo ($student->pvgcl == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgcl == 6) ? 'active' : '' ?>"><input
                                        name="pvgcl" type="radio"
                                        value="6" <?php echo ($student->pvgcl == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgcl == 9) ? 'active' : '' ?>"><input
                                        name="pvgcl" type="radio"
                                        value="9" <?php echo ($student->pvgcl == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgck">Heeft contact met
                            andere kinderen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgck == 3) ? 'active' : '' ?>">
                                <input name="pvgck" type="radio"
                                       value="3" <?php echo ($student->pvgck == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgck == 6) ? 'active' : '' ?>"><input
                                        name="pvgck" type="radio"
                                        value="6" <?php echo ($student->pvgck == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgck == 9) ? 'active' : '' ?>"><input
                                        name="pvgck" type="radio"
                                        value="9" <?php echo ($student->pvgck == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>

                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgss">Kan samen
                            spelen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgss == 3) ? 'active' : '' ?>">
                                <input name="pvgss" type="radio"
                                       value="3" <?php echo ($student->pvgss == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgss == 6) ? 'active' : '' ?>"><input
                                        name="pvgss" type="radio"
                                        value="6" <?php echo ($student->pvgss == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgss == 9) ? 'active' : '' ?>"><input
                                        name="pvgss" type="radio"
                                        value="9" <?php echo ($student->pvgss == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>

                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgzo">Kan voor zichzelf
                            opkomen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgzo == 3) ? 'active' : '' ?>">
                                <input name="pvgzo" type="radio"
                                       value="3" <?php echo ($student->pvgzo == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgzo == 6) ? 'active' : '' ?>"><input
                                        name="pvgzo" type="radio"
                                        value="6" <?php echo ($student->pvgzo == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgzo == 9) ? 'active' : '' ?>"><input
                                        name="pvgzo" type="radio"
                                        value="9" <?php echo ($student->pvgcl == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>

                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgra">Houdt rekening met
                            anderen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgra == 3) ? 'active' : '' ?>">
                                <input name="pvgra" type="radio"
                                       value="3" <?php echo ($student->pvgra == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgra == 6) ? 'active' : '' ?>"><input
                                        name="pvgra" type="radio"
                                        value="6" <?php echo ($student->pvgra == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgra == 9) ? 'active' : '' ?>"><input
                                        name="pvgra" type="radio"
                                        value="9" <?php echo ($student->pvgra == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>

                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgi">Neemt
                            initiatieven</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgcl == 3) ? 'active' : '' ?>">
                                <input name="pvgi" type="radio"
                                       value="3" <?php echo ($student->pvgi == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgi == 6) ? 'active' : '' ?>"><input
                                        name="pvgi" type="radio"
                                        value="6" <?php echo ($student->pvgi == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgi == 9) ? 'active' : '' ?>"><input
                                        name="pvgi" type="radio"
                                        value="9" <?php echo ($student->pvgi == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>

                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgws">Kan zich aanpassen aan
                            wisselende situaties</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgws == 3) ? 'active' : '' ?>">
                                <input name="pvgws" type="radio"
                                       value="3" <?php echo ($student->pvgws == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgws == 6) ? 'active' : '' ?>"><input
                                        name="pvgws" type="radio"
                                        value="6" <?php echo ($student->pvgws == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgws == 9) ? 'active' : '' ?>"><input
                                        name="pvgws" type="radio"
                                        value="9" <?php echo ($student->pvgws == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgaa">Houdt zich aan
                            afspraken</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgaa == 3) ? 'active' : '' ?>">
                                <input name="pvgaa" type="radio"
                                       value="3" <?php echo ($student->pvgaa == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgaa == 6) ? 'active' : '' ?>"><input
                                        name="pvgaa" type="radio"
                                        value="6" <?php echo ($student->pvgaa == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgaa == 9) ? 'active' : '' ?>"><input
                                        name="pvgaa" type="radio"
                                        value="9" <?php echo ($student->pvgaa == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgtv">Kan teleurstellingen
                            verwerken</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgtv == 3) ? 'active' : '' ?>">
                                <input name="pvgtv" type="radio"
                                       value="3" <?php echo ($student->pvgtv == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgtv == 6) ? 'active' : '' ?>"><input
                                        name="pvgtv" type="radio"
                                        value="6" <?php echo ($student->pvgtv == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgtv == 9) ? 'active' : '' ?>"><input
                                        name="pvgtv" type="radio"
                                        value="9" <?php echo ($student->pvgtv == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgrz">Ruimt zelfstandig
                            op</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgrz == 3) ? 'active' : '' ?>">
                                <input name="pvgrz" type="radio"
                                       value="3" <?php echo ($student->pvgrz == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgrz == 6) ? 'active' : '' ?>"><input
                                        name="pvgrz" type="radio"
                                        value="6" <?php echo ($student->pvgrz == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgrz == 9) ? 'active' : '' ?>"><input
                                        name="pvgrz" type="radio"
                                        value="9" <?php echo ($student->pvgrz == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>


                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgkc">Kan zich
                            concentreren</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgkc == 3) ? 'active' : '' ?>">
                                <input name="pvgkc" type="radio"
                                       value="3" <?php echo ($student->pvgkc == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgkc == 6) ? 'active' : '' ?>"><input
                                        name="pvgkc" type="radio"
                                        value="6" <?php echo ($student->pvgkc == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgkc == 9) ? 'active' : '' ?>"><input
                                        name="pvgkc" type="radio"
                                        value="9" <?php echo ($student->pvgkc == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgzw">Heeft zorg voor
                            werk</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgzw == 3) ? 'active' : '' ?>">
                                <input name="pvgzw" type="radio"
                                       value="3" <?php echo ($student->pvgzw == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgzw == 6) ? 'active' : '' ?>"><input
                                        name="pvgzw" type="radio"
                                        value="6" <?php echo ($student->pvgzw == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgzw == 9) ? 'active' : '' ?>"><input
                                        name="pvgzw" type="radio"
                                        value="9" <?php echo ($student->pvgzw == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgd">Heeft
                            doorzettingsvermogen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgd == 3) ? 'active' : '' ?>">
                                <input name="pvgd" type="radio"
                                       value="3" <?php echo ($student->pvgd == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgd == 6) ? 'active' : '' ?>"><input
                                        name="pvgd" type="radio"
                                        value="6" <?php echo ($student->pvgd == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgd == 9) ? 'active' : '' ?>"><input
                                        name="pvgd" type="radio"
                                        value="9" <?php echo ($student->pvgd == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgk">Doet mee met
                            kringactiviteiten</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgk == 3) ? 'active' : '' ?>">
                                <input name="pvgk" type="radio"
                                       value="3" <?php echo ($student->pvgk == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgk == 6) ? 'active' : '' ?>"><input
                                        name="pvgk" type="radio"
                                        value="6" <?php echo ($student->pvgk == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgk == 9) ? 'active' : '' ?>"><input
                                        name="pvgk" type="radio"
                                        value="9" <?php echo ($student->pvgk == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgjs">Kan jas en schoenen
                            aandoen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgjs == 3) ? 'active' : '' ?>">
                                <input name="pvgjs" type="radio"
                                       value="3" <?php echo ($student->pvgjs == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgjs == 6) ? 'active' : '' ?>"><input
                                        name="pvgjs" type="radio"
                                        value="6" <?php echo ($student->pvgjs == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgjs == 9) ? 'active' : '' ?>"><input
                                        name="pvgjs" type="radio"
                                        value="9" <?php echo ($student->pvgjs == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgma">Neemt makkelijk
                            afscheid</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgma == 3) ? 'active' : '' ?>">
                                <input name="pvgma" type="radio"
                                       value="3" <?php echo ($student->pvgma == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgma == 6) ? 'active' : '' ?>"><input
                                        name="pvgma" type="radio"
                                        value="6" <?php echo ($student->pvgma == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgma == 9) ? 'active' : '' ?>"><input
                                        name="pvgma" type="radio"
                                        value="9" <?php echo ($student->pvgma == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgzh">Geeft uit zichzelf een
                            hand</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgzh == 3) ? 'active' : '' ?>">
                                <input name="pvgzh" type="radio"
                                       value="3" <?php echo ($student->pvgzh == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgzh == 6) ? 'active' : '' ?>"><input
                                        name="pvgzh" type="radio"
                                        value="6" <?php echo ($student->pvgzh == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgzh == 9) ? 'active' : '' ?>"><input
                                        name="pvgzh" type="radio"
                                        value="9" <?php echo ($student->pvgzh == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgiz">Is zindelijk</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgiz == 3) ? 'active' : '' ?>">
                                <input name="pvgiz" type="radio"
                                       value="3" <?php echo ($student->pvgiz == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgiz == 6) ? 'active' : '' ?>"><input
                                        name="pvgiz" type="radio"
                                        value="6" <?php echo ($student->pvgiz == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgiz == 9) ? 'active' : '' ?>"><input
                                        name="pvgiz" type="radio"
                                        value="9" <?php echo ($student->pvgiz == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>

                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvgbo">Kan basisemoties
                            onderscheiden</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvgbo == 3) ? 'active' : '' ?>">
                                <input name="pvgbo" type="radio"
                                       value="3" <?php echo ($student->pvgbo == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgbo == 6) ? 'active' : '' ?>"><input
                                        name="pvgbo" type="radio"
                                        value="6" <?php echo ($student->pvgbo == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvgbo == 9) ? 'active' : '' ?>"><input
                                        name="pvgbo" type="radio"
                                        value="9" <?php echo ($student->pvgbo == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>

                        <label style="padding-top:10px !important;" class="col-sm-3" for="pvghp">Vraagt om hulp</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->pvghp == 3) ? 'active' : '' ?>">
                                <input name="pvghp" type="radio"
                                       value="3" <?php echo ($student->pvghp == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvghp == 6) ? 'active' : '' ?>"><input
                                        name="pvghp" type="radio"
                                        value="6" <?php echo ($student->pvghp == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->pvghp == 9) ? 'active' : '' ?>"><input
                                        name="pvghp" type="radio"
                                        value="9" <?php echo ($student->pvghp == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>


                        <div class="form-group">
                            <label class="col-sm-3" for="pvg">Toelichting</label><br/>
                            <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="pvg" name="pvg"
                                      spellcheck="true">
							<?= $student->pvg; ?>
						</textarea>

                        </div>
                    </div>
                </div>
            </section>


            <!-- Intro Section -->
            <section id="taal" class="taal-section form-block">
                <div class="row ">
                    <div class="well taal">
                        <h1>Taal</h1>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="tldv">Vertelt in de
                            kring</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->tldv == 3) ? 'active' : '' ?>">
                                <input name="tldv" type="radio"
                                       value="3" <?php echo ($student->tldv == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->tldv == 6) ? 'active' : '' ?>"><input
                                        name="tldv" type="radio"
                                        value="6" <?php echo ($student->tldv == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->tldv == 9) ? 'active' : '' ?>"><input
                                        name="tldv" type="radio"
                                        value="9" <?php echo ($student->tldv == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="tlna">Luistert naar
                            anderen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->tlna == 3) ? 'active' : '' ?>">
                                <input name="tlna" type="radio"
                                       value="3" <?php echo ($student->tlna == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->tlna == 6) ? 'active' : '' ?>"><input
                                        name="tlna" type="radio"
                                        value="6" <?php echo ($student->tlna == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->tlna == 9) ? 'active' : '' ?>"><input
                                        name="tlna" type="radio"
                                        value="9" <?php echo ($student->tlna == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="tlsv">Spreekt
                            verstaanbaar</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->tlsv == 3) ? 'active' : '' ?>">
                                <input name="tlsv" type="radio"
                                       value="3" <?php echo ($student->tlsv == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->tlsv == 6) ? 'active' : '' ?>"><input
                                        name="tlsv" type="radio"
                                        value="6" <?php echo ($student->tlsv == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->tlsv == 9) ? 'active' : '' ?>"><input
                                        name="tlsv" type="radio"
                                        value="9" <?php echo ($student->tlsv == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="tlz">Maakt zinnen </label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->tlz == 3) ? 'active' : '' ?>">
                                <input name="tlz" type="radio"
                                       value="3" <?php echo ($student->tlz == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->tlz == 6) ? 'active' : '' ?>"><input
                                        name="tlz" type="radio"
                                        value="6" <?php echo ($student->tlz == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->tlz == 9) ? 'active' : '' ?>"><input
                                        name="tlz" type="radio"
                                        value="9" <?php echo ($student->tlz == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="tllz">Kan kritisch
                            luisteren</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->tllz == 3) ? 'active' : '' ?>">
                                <input name="tllz" type="radio"
                                       value="3" <?php echo ($student->tllz == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->tllz == 6) ? 'active' : '' ?>"><input
                                        name="tllz" type="radio"
                                        value="6" <?php echo ($student->tllz == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->tllz == 9) ? 'active' : '' ?>"><input
                                        name="tllz" type="radio"
                                        value="9" <?php echo ($student->tllz == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>

                        <div class="form-group">
                            <label class="col-sm-3" for="tl">Toelichting</label><br/>
                            <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="tl" name="tl"
                                      spellcheck="true">
							<?= $student->tl; ?>
						</textarea>

                        </div>
                    </div>
                </div>
            </section>

            <!-- About Section -->
            <section id="rekenen" class="rekenen-section form-block">
                <div class="row ">
                    <div class="well rekenen">
                        <h1>Rekenen</h1>

                        <label style="padding-top:10px !important;" class="col-sm-3" for="rkrb">Kan akoestisch
                            tellen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->rkrb == 3) ? 'active' : '' ?>">
                                <input name="rkrb" type="radio"
                                       value="3" <?php echo ($student->rkrb == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->rkrb == 6) ? 'active' : '' ?>"><input
                                        name="rkrb" type="radio"
                                        value="6" <?php echo ($student->rkrb == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->rkrb == 9) ? 'active' : '' ?>"><input
                                        name="rkrb" type="radio"
                                        value="9" <?php echo ($student->rkrb == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="rkst">Kan synchroon tellen tot
                            10</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->rkst == 3) ? 'active' : '' ?>">
                                <input name="rkst" type="radio"
                                       value="3" <?php echo ($student->rkst == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->rkst == 6) ? 'active' : '' ?>"><input
                                        name="rkst" type="radio"
                                        value="6" <?php echo ($student->rkst == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->rkst == 9) ? 'active' : '' ?>"><input
                                        name="rkst" type="radio"
                                        value="9" <?php echo ($student->rkst == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="rkhh">Kan hoeveelheden
                            herkennen/benoemen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->rkhh == 3) ? 'active' : '' ?>">
                                <input name="rkhh" type="radio"
                                       value="3" <?php echo ($student->rkhh == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->rkhh == 6) ? 'active' : '' ?>"><input
                                        name="rkhh" type="radio"
                                        value="6" <?php echo ($student->rkhh == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->rkhh == 9) ? 'active' : '' ?>"><input
                                        name="rkhh" type="radio"
                                        value="9" <?php echo ($student->rkhh == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="rks">Kan sorteren naar
                            vorm/grootte</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->rks == 3) ? 'active' : '' ?>">
                                <input name="rks" type="radio"
                                       value="3" <?php echo ($student->rks == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->rks == 6) ? 'active' : '' ?>"><input
                                        name="rks" type="radio"
                                        value="6" <?php echo ($student->rks == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->rks == 9) ? 'active' : '' ?>"><input
                                        name="rks" type="radio"
                                        value="9" <?php echo ($student->rks == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="rkgb"><b>Getalbegrip</b><br/>Kan
                            meetkundige vormen onderscheiden en benoemen (cirkel, vierkant, etc.)</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->rkgb == 3) ? 'active' : '' ?>">
                                <input name="rkgb" type="radio"
                                       value="3" <?php echo ($student->rkgb == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->rkgb == 6) ? 'active' : '' ?>"><input
                                        name="rkgb" type="radio"
                                        value="6" <?php echo ($student->rkgb == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->rkgb == 9) ? 'active' : '' ?>"><input
                                        name="rkgb" type="radio"
                                        value="9" <?php echo ($student->rkgb == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <br/>
                        <hr/>
                        <div class="form-group">
                            <label class="col-sm-3" for="rk">Toelichting</label><br/>
                            <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="rk" name="rk"
                                      spellcheck="true">
							<?= $student->rk; ?>
						</textarea>

                        </div>

                    </div>
                </div>
            </section>


            <!-- About Section -->
            <section id="creatief" class="creatieve-ontwikkeling-section form-block">
                <div class="row ">
                    <div class="well crea">
                        <h1>Creatieve ontwikkeling</h1>

                        <label style="padding-top:10px !important;" class="col-sm-3" for="cra">Kiest voor een creatieve
                            activiteit</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->cra == 3) ? 'active' : '' ?>">
                                <input name="cra" type="radio"
                                       value="3" <?php echo ($student->cra == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->cra == 6) ? 'active' : '' ?>"><input
                                        name="cra" type="radio"
                                        value="6" <?php echo ($student->cra == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->cra == 9) ? 'active' : '' ?>"><input
                                        name="cra" type="radio"
                                        value="9" <?php echo ($student->cra == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="crf">Gaat vanuit zijn/haar
                            fantasie aan het werk</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->crf == 3) ? 'active' : '' ?>">
                                <input name="crf" type="radio"
                                       value="3" <?php echo ($student->crf == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->crf == 6) ? 'active' : '' ?>"><input
                                        name="crf" type="radio"
                                        value="6" <?php echo ($student->crf == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->crf == 9) ? 'active' : '' ?>"><input
                                        name="crf" type="radio"
                                        value="9" <?php echo ($student->crf == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="crt">Tekent</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->crt == 3) ? 'active' : '' ?>">
                                <input name="crt" type="radio"
                                       value="3" <?php echo ($student->crt == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->crt == 6) ? 'active' : '' ?>"><input
                                        name="crt" type="radio"
                                        value="6" <?php echo ($student->crt == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->crt == 9) ? 'active' : '' ?>"><input
                                        name="crt" type="radio"
                                        value="9" <?php echo ($student->crt == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="crk">Kent kleuren</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->crk == 3) ? 'active' : '' ?>">
                                <input name="crk" type="radio"
                                       value="3" <?php echo ($student->crk == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->crk == 6) ? 'active' : '' ?>"><input
                                        name="crk" type="radio"
                                        value="6" <?php echo ($student->crk == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->crk == 9) ? 'active' : '' ?>"><input
                                        name="crk" type="radio"
                                        value="9" <?php echo ($student->crk == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="crsf">Speelt in de
                            fantasiehoek</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->crsf == 3) ? 'active' : '' ?>">
                                <input name="crsf" type="radio"
                                       value="3" <?php echo ($student->crsf == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->crsf == 6) ? 'active' : '' ?>"><input
                                        name="crsf" type="radio"
                                        value="6" <?php echo ($student->crsf == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->crsf == 9) ? 'active' : '' ?>"><input
                                        name="crsf" type="radio"
                                        value="9" <?php echo ($student->crsf == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label class="col-sm-3" for="cr">Toelichting</label><br/>
                            <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="cr" name="cr"
                                      spellcheck="true">
							<?= $student->cr; ?>
						</textarea>

                        </div>
                    </div>

                </div>
            </section>
            <!-- About Section -->
            <section id="fijne" class="fijne-motoriek-section form-block">
                <div class="row ">
                    <div class="well schrijven">
                        <h1>Fijne motoriek</h1>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="fmsk">Kan smalle stroken
                            knippen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->fmsk == 3) ? 'active' : '' ?>">
                                <input name="fmsk" type="radio"
                                       value="3" <?php echo ($student->fmsk == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->fmsk == 6) ? 'active' : '' ?>"><input
                                        name="fmsk" type="radio"
                                        value="6" <?php echo ($student->fmsk == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->fmsk == 9) ? 'active' : '' ?>"><input
                                        name="fmsk" type="radio"
                                        value="9" <?php echo ($student->fmsk == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="fmbk">Kan brede stroken
                            knippen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->fmbk == 3) ? 'active' : '' ?>">
                                <input name="fmbk" type="radio"
                                       value="3" <?php echo ($student->fmbk == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->fmbk == 6) ? 'active' : '' ?>"><input
                                        name="fmbk" type="radio"
                                        value="6" <?php echo ($student->fmbk == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->fmbk == 9) ? 'active' : '' ?>"><input
                                        name="fmbk" type="radio"
                                        value="9" <?php echo ($student->fmbk == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="fmvk">Kan een vierkant
                            knippen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->fmvk == 3) ? 'active' : '' ?>">
                                <input name="fmvk" type="radio"
                                       value="3" <?php echo ($student->fmvk == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->fmvk == 6) ? 'active' : '' ?>"><input
                                        name="fmvk" type="radio"
                                        value="6" <?php echo ($student->fmvk == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->fmvk == 9) ? 'active' : '' ?>"><input
                                        name="fmvk" type="radio"
                                        value="9" <?php echo ($student->fmvk == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="fmck">Kan een cirkel
                            knippen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->fmck == 3) ? 'active' : '' ?>">
                                <input name="fmck" type="radio"
                                       value="3" <?php echo ($student->fmck == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->fmck == 6) ? 'active' : '' ?>"><input
                                        name="fmck" type="radio"
                                        value="6" <?php echo ($student->fmck == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->fmck == 9) ? 'active' : '' ?>"><input
                                        name="fmck" type="radio"
                                        value="9" <?php echo ($student->fmck == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="fmsl">Kan een spiraal
                            knippen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->fmsl == 3) ? 'active' : '' ?>">
                                <input name="fmsl" type="radio"
                                       value="3" <?php echo ($student->fmsl == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->fmsl == 6) ? 'active' : '' ?>"><input
                                        name="fmsl" type="radio"
                                        value="6" <?php echo ($student->fmsl == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->fmsl == 9) ? 'active' : '' ?>"><input
                                        name="fmsl" type="radio"
                                        value="9" <?php echo ($student->fmsl == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="fmgp">Heeft een goede
                            pengreep</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->fmgp == 3) ? 'active' : '' ?>">
                                <input name="fmgp" type="radio"
                                       value="3" <?php echo ($student->fmgp == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->fmgp == 6) ? 'active' : '' ?>"><input
                                        name="fmgp" type="radio"
                                        value="6" <?php echo ($student->fmgp == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->fmgp == 9) ? 'active' : '' ?>"><input
                                        name="fmgp" type="radio"
                                        value="9" <?php echo ($student->fmgp == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3"
                               for="fmrl">Rechts-/linkshandig</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->fmrl == 3) ? 'active' : '' ?>">
                                <input name="fmrl" type="radio"
                                       value="3" <?php echo ($student->fmrl == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->fmrl == 6) ? 'active' : '' ?>"><input
                                        name="fmrl" type="radio"
                                        value="6" <?php echo ($student->fmrl == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->fmrl == 9) ? 'active' : '' ?>"><input
                                        name="fmrl" type="radio"
                                        value="9" <?php echo ($student->fmrl == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label class="col-sm-3" for="fm">Toelichting</label><br/>
                            <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="fm" name="fm"
                                      spellcheck="true">
							<?= $student->fm; ?>
						</textarea>

                        </div>
                    </div>
                </div>
            </section>

            <!-- About Section -->
            <section id="grove" class="grove-motoriek-section form-block">
                <div class="row ">
                    <div class="well schrijven">
                        <h1>Grove motoriek</h1>

                        <label style="padding-top:10px !important;" class="col-sm-3" for="gmf">Kan fietsen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->gmf == 3) ? 'active' : '' ?>">
                                <input name="gmf" type="radio"
                                       value="3" <?php echo ($student->gmf == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gmf == 6) ? 'active' : '' ?>"><input
                                        name="gmf" type="radio"
                                        value="6" <?php echo ($student->gmf == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gmf == 9) ? 'active' : '' ?>"><input
                                        name="gmf" type="radio"
                                        value="9" <?php echo ($student->gmf == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>

                        <label style="padding-top:10px !important;" class="col-sm-3" for="gmas">Durft ergens af te
                            springen</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->gmas == 3) ? 'active' : '' ?>">
                                <input name="gmas" type="radio"
                                       value="3" <?php echo ($student->gmas == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gmas == 6) ? 'active' : '' ?>"><input
                                        name="gmas" type="radio"
                                        value="6" <?php echo ($student->gmas == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gmas == 9) ? 'active' : '' ?>"><input
                                        name="gmas" type="radio"
                                        value="9" <?php echo ($student->gmas == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="gmsb">Speelt en beweegt met
                            plezier</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->gmsb == 3) ? 'active' : '' ?>">
                                <input name="gmsb" type="radio"
                                       value="3" <?php echo ($student->gmsb == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gmsb == 6) ? 'active' : '' ?>"><input
                                        name="gmsb" type="radio"
                                        value="6" <?php echo ($student->gmsb == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gmsb == 9) ? 'active' : '' ?>"><input
                                        name="gmsb" type="radio"
                                        value="9" <?php echo ($student->gmsb == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="gmbm">Beweegt graag op
                            muziek</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->gmbm == 3) ? 'active' : '' ?>">
                                <input name="gmbm" type="radio"
                                       value="3" <?php echo ($student->gmbm == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gmbm == 6) ? 'active' : '' ?>"><input
                                        name="gmbm" type="radio"
                                        value="6" <?php echo ($student->gmbm == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gmbm == 9) ? 'active' : '' ?>"><input
                                        name="gmbm" type="radio"
                                        value="9" <?php echo ($student->gmbm == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <label style="padding-top:10px !important;" class="col-sm-3" for="gmbs">Beweegt zich
                            soepel</label>
                        <div class="btn-group" data-toggle="buttons"><label
                                    class="btn btn-default <?php echo ($student->gmbs == 3) ? 'active' : '' ?>">
                                <input name="gmbs" type="radio"
                                       value="3" <?php echo ($student->gmbs == 3) ? 'checked="checked"' : '' ?>>nee</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gmbs == 6) ? 'active' : '' ?>"><input
                                        name="gmbs" type="radio"
                                        value="6" <?php echo ($student->gmbs == 6) ? 'checked="checked"' : '' ?>>soms</label>
                            <label
                                    class="btn btn-default <?php echo ($student->gmbs == 9) ? 'active' : '' ?>"><input
                                        name="gmbs" type="radio"
                                        value="9" <?php echo ($student->gmbs == 9) ? 'checked="checked"' : '' ?>>ja</label>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label class="col-sm-3" for="tl">Toelichting</label><br/>
                            <textarea class="form-control dbs-tc-wysiwyg wysiwyg-editor" rows="4" id="gm" name="gm"
                                      spellcheck="true">
							<?= $student->gm; ?>
						</textarea>

                        </div>
                    </div>
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