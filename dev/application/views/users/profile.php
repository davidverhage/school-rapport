<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16-2-2016
 * Time: 10:46
 */
?>
<div class="container">
    <div class="row-fluid block-box clearfix">
        <h3>Profiel aanpassen</h3>
        <p>Deze module wordt nog geimplementeerd.</p>
        <hr/>

        <div class="col-xs-12 col-sm-4">
            <div id="profile_page" class="well" style="min-height:540px;">
                <h3>Profielfoto</h3>
                <p>Upload uw profiel foto.</p>
                <?php
                //var_dump($this->user->user_data);
                $avatar = $this->user->user_data->avatar;
                ?>
                <ul>
                    <?php if ($avatar != '' || $avatar != null) {// if the avatar has been uploaded then display it?>
                        <img src="<?php echo base_url() . $avatar; ?>"/>
                    <?php } else {
                    } ?>
                    <?php
                    // underneath display the form to update the picture
                    echo form_open_multipart('dashboard/profile/edit_profilepic');
                    $Fdata = array('name' => 'avatar', 'class' => 'file'); // set your file and class for the image
                    echo form_upload($Fdata); // upload the datas here the image that user has selected.
                    echo form_submit('mysubmit', 'Instellen', array('class' => 'btn btn-primary btn-fw')); // your submit button fucntion
                    echo form_close();
                    ?>

                </ul>
            </div>
        </div>

        <div class="col-xs-12 col-sm-8">
            <div id="profile_page" class="well clearfix" style="min-height:540px;">
                <h3>Profielgegevens aanpassen</h3>
                <p>Bij het wijzigen van uw profiel wordt u uitgelogd. Bewaar uw gewijzigde wachtwoord alvorens u de
                    profielgegevens opslaat.</p>
                <?php if (isset($change_error)) {
                    echo $change_error;
                } else {
                    //do nothing;
                }
                ?>
                <form class="form-horizontal" action="/dashboard/profile/change_profile" method="post">
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="email">emailadres</label>

                        <div class="col-md-5">
                            <input id="email" name="email" placeholder="uw zakelijke emailadres"
                                   value="<?php echo $this->user->get_email(); ?>" class="form-control
						input-md" type="text">
                            <span class="help-block">waarop mogen emails ontvangen worden</span>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="name">weergave naam</label>

                        <div class="col-md-5">
                            <input id="name" name="name" placeholder="weergave naam"
                                   value="<?php echo $this->user->get_name(); ?>" class="form-control input-md"
                                   type="text">
                            <span class="help-block">uw voornaam en achternaam</span>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="login">aanmeldnaam / loginnaam</label>

                        <div class="col-md-5">
                            <input id="login" name="login" placeholder="loginnaam" value="<?php echo
                            $this->user->user_data->login; ?>" class="form-control input-md"
                                   type="text">
                            <span class="help-block">uw login/aanmeld naam</span>
                        </div>
                    </div>

                    <!-- Password input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="password">wachtwoord</label>

                        <div class="col-md-5">
                            <input id="password" name="password" placeholder="voer het gewenste wachtwoord in"
                                   class="form-control input-md" type="password">
                            <span class="help-block">voer het gewenste wachtwoord in</span>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="change">Wijzigingen Opslaan</label>

                        <div class="col-md-4">
                            <button id="change" name="change" class="btn btn-warning" type="submit">wijzigen</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>