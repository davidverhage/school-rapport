<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-2-2016
 * Time: 10:26
 */
?>

<?php
if ($this->session->flashdata('created_user_message')) { ?>
    <div id="message">
        <div style="padding: 5px;">
            <div id="inner-message" class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $this->session->flashdata('created_user_message'); ?>
            </div>
        </div>
    </div>
<?php } ?>


<?php if ($this->uri->segment(2) == 'buildusers') { ?>
    <div class="container">
    <div class="well clearfix">
<?php } ?>
    <form class="form-horizontal">
        <fieldset>

            <!-- Form Name -->
            <legend>Maak gebruiker aan</legend>
            <div id="broadcast"></div>
            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="fullname">Volledige naam</label>

                <div class="col-md-8">
                    <input id="fullname" name="fullname" placeholder="voornaam achternaam" class="form-control input-md"
                           required type="text">
                    <span class="help-block">voer de voor en achternaam van de medewerk(st)er in</span>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="email">E-mailadres</label>

                <div class="col-md-8">
                    <input id="email" name="email" placeholder="voer het e-mailadres op" class="form-control input-md"
                           required type="text">
                    <span class="help-block">voer het juiste e-mailadres in</span>
                </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="password">Wachtwoord</label>

                <div class="col-md-8">
                    <?php
                    function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
                    {
                        $sets = array();
                        if (strpos($available_sets, 'l') !== false)
                            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
                        if (strpos($available_sets, 'u') !== false)
                            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
                        if (strpos($available_sets, 'd') !== false)
                            $sets[] = '23456789';
                        if (strpos($available_sets, 's') !== false)
                            $sets[] = '!@#$%&*?';
                        $all = '';
                        $password = '';
                        foreach ($sets as $set) {
                            $password .= $set[array_rand(str_split($set))];
                            $all .= $set;
                        }
                        $all = str_split($all);
                        for ($i = 0; $i < $length - count($sets); $i++)
                            $password .= $all[array_rand($all)];
                        $password = str_shuffle($password);
                        if (!$add_dashes)
                            return $password;
                        $dash_len = floor(sqrt($length));
                        $dash_str = '';
                        while (strlen($password) > $dash_len) {
                            $dash_str .= substr($password, 0, $dash_len) . '-';
                            $password = substr($password, $dash_len);
                        }
                        $dash_str .= $password;
                        return $dash_str;
                    }

                    $genPassKey = generateStrongPassword(8, false, 'luds');
                    ?>
                    <input id="password" name="password" placeholder="voer het gewenste wachtwoord in"
                           value="<?= $genPassKey; ?>"
                           class="form-control input-md" required type="text">
                    <span class="help-block">Een wachtwoord dient minimaal een hoofdletter en een cijfer te bevatten</span>
                </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="rights">Rechten</label>

                <div class="col-md-8">
                    <select id="rights" name="rights" class="form-control input-md">
                        <option value="2">Leidster</option>
                        <option value="3">Speciaal Gym</option>
                        <option value="4">Speciaal Crea/TeHaTex</option>
                        <option value="5">Administratie</option>
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
                    foreach ($klastype as $klas) {
                        echo '<div class="col-xs-12 col-sm-3"><label class="radio-inline" for="checkboxes-' . $count . '">
                        <input name="klas" id="checkboxes-' . $count . '" value="' . $klas->name . '" type="radio">
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
                <button id="publish" name="publish" class="btn btn-primary">Opslaan</button>
                <button id="clear" name="clear" class="btn btn-danger">Wissen</button>
            </div>
        </div>

    </form>
<?php if ($this->uri->segment(2) == 'buildusers') { ?>
    </div>
    </div>
<?php } ?>