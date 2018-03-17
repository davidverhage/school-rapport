<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-2-2016
 * Time: 10:26
 */
?>
<div class="col-sm-12" style="padding-top:25px;">
    <div class="panel-group">
        <?php foreach ($students->result() as $student): ?>
            <form class="form-horizontal" action="/dashboard/edit_student/" method="post">
                <fieldset>

                    <!-- Form Name -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <legend>Leerling wijzigen</legend>
                            </h4>
                        </div>
                        <div class="panel-body">
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="Roepnaam">Roepnaam</label>
                                <div class="col-md-4">
                                    <input id="Roepnaam" name="Roepnaam" placeholder=""
                                           value="<?= $student->Roepnaam; ?>" class="form-control input-md" required=""
                                           type="text">

                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="Tussenvoegsel">Tussenvoegsel</label>
                                <div class="col-md-4">
                                    <input id="Tussenvoegsel" name="Tussenvoegsel"
                                           value="<?= $student->Tussenvoegsel; ?>" placeholder="van der"
                                           class="form-control input-md" type="text">

                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="Achternaam">Achternaam</label>
                                <div class="col-md-4">
                                    <input id="Achternaam" name="Achternaam" placeholder=""
                                           value="<?= $student->Achternaam; ?>" class="form-control input-md"
                                           required="" type="text">

                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="Geboortedatum">Geboortedatum</label>
                                <div class="col-md-4">
                                    <input id="Geboortedatum" name="Geboortedatum"
                                           value="<?= $student->Geboortedatum; ?>" placeholder="20-12-2006"
                                           class="form-control input-md" required="" type="text">
                                    <span class="help-block">bijvoorbeeld:  	20-12-2006</span>
                                </div>
                            </div>

                            <!-- Select Basic -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="ghg">Klas</label>
                                <div class="col-md-4">
                                    <select id="ghg" name="ghg" class="form-control">
                                        <option selected="selected"
                                                value="<?= $student->ghg; ?>"><?= $student->ghg; ?></option>
                                        <option value="OB-1">OB-1</option>
                                        <option value="OB-2">OB-2</option>
                                        <option value="OB-3">OB-3</option>
                                        <option value="OB-4">OB-4</option>
                                        <option value="MB-1">MB-1</option>
                                        <option value="MB-2">MB-2</option>
                                        <option value="MB-3">MB-3</option>
                                        <option value="MB-4">MB-4</option>
                                        <option value="TB-1">TB-1</option>
                                        <option value="TB-4">TB-4</option>
                                        <option value="BB-1">BB-1</option>
                                        <option value="BB-2">BB-2</option>
                                        <option value="BB-3">BB-3</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Select Basic -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="lhg">groep</label>
                                <div class="col-md-4">
                                    <select id="lhg" name="lhg" class="form-control">
                                        <option selected="selected"
                                                value="<?= $student->lhg; ?>"><?= $student->lhg; ?></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-4">
                                    <button id="submit" name="submit" class="btn btn-success">Toevoegen</button>
                                </div>
                            </div>

                </fieldset>
            </form>


        <?php endforeach; ?>
    </div>
</div></div></div>