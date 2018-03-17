<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-2-2016
 * Time: 10:26
 */
?>
<?php foreach ($gebruikers as $gebruiker): ?>
    <form class="form-horizontal" action="<?= site_url('/dashboard/profile/change_profile'); ?>" method="post">
        <fieldset>

            <!-- Form Name -->
            <legend>Bewerk gebruiker</legend>
            <input id="user_id" name="user_id" value="<?= $this->uri->segment(3); ?>" type="hidden">

            <div class="form-group">
                <label class="col-md-4 control-label" for="fullname">Volledige naam</label>

                <div class="col-md-8">
                    <input id="fullname" name="name" placeholder="voornaam achternaam" class="form-control input-md"
                           required type="text" value="<?= $gebruiker->name; ?>">
                    <span class="help-block">voer de voor en achternaam van de medewerk(st)er in</span>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="email">E-mailadres</label>

                <div class="col-md-8">
                    <input id="email" name="email" placeholder="voer het e-mailadres op" class="form-control input-md"
                           required type="text" value="<?= $gebruiker->email; ?>">
                    <span class="help-block">voer het juiste e-mailadres in</span>
                </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="password">Wachtwoord</label>

                <div class="col-md-8">
                    <input id="password" name="password" placeholder="voer het gewenste wachtwoord in"
                           class="form-control input-md" type="text">
                    <span class="help-block">Een wachtwoord dient minimaal een hoofdletter en een cijfer te bevatten</span>
                </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="rights">Rechten</label>

                <div class="col-md-8">
                    <select id="rights" name="rights" class="form-control input-md">
                        <option <?php if ($this->uri->segment(4) == 'leidsters') {
                            echo 'selected="selected"';
                        } ?> value="2">Leidster
                        </option>
                        <option <?php if ($this->uri->segment(4) == 'special_g') {
                            echo 'selected="selected"';
                        } ?> value="3">Speciaal Gym
                        </option>
                        <option <?php if ($this->uri->segment(4) == 'special_c') {
                            echo 'selected="selected"';
                        } ?> value="4">Speciaal Crea/TeHaTex
                        </option>
                        <option <?php if ($this->uri->segment(4) == 'administratie') {
                            echo 'selected="selected"';
                        } ?> value="5">Administratie
                        </option>
                    </select>
                    <span class="help-block">Welke rol krijgt deze gebruiker?</span>
                </div>
            </div>

            <!-- Multiple Checkboxes (inline) -->
            <div class="form-group klas-selector" id="class-selection">
                <label class="col-md-4 control-label" for="checkboxes">Klas gebonden</label>

                <div class="col-md-8">
                    <?php
                    $count = 0;
                    $checked = '';
                    foreach ($klastype as $klas) {
                        if ($klas->name == $gebruiker->klas) {
                            $checked = 'checked="checked"';
                        }

                        echo '<div class="col-xs-12 col-sm-3"><label class="radio-inline" for="checkboxes-' . $count . '">
                <input name="radio" id="checkboxes-' . $count . '" value="' . $klas->name . '" type="radio" ' . $checked . '>
                ' . $klas->name . '<br/> <span class="help-block small">' . $klas->type . '</span>
                </label></div>';
                        $count++;
                    } ?>
                </div>
            </div>


        </fieldset>

        <!-- Button (Double) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="publish">Opslaan / Wissen</label>

            <div class="col-md-8">
                <button type="submit" id="opslaan" name="publish" class="btn btn-primary">Opslaan</button>
                <button id="clear" name="clear" class="btn btn-danger">Wissen</button>
            </div>
        </div>

    </form>
<?php endforeach; ?>