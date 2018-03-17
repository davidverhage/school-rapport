<style>
    html, body {
        background: url(/assets/img/elapsus-bg.jpg) no-repeat center center fixed !important;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        /* Preserve aspet ratio */
        min-width: 100%;
        min-height: 100%;
    }
</style>
<div class="col-md-4 col-md-offset-4">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="text-center">
                <img src="<?= base_url('assets/img/SR.png'); ?>" width="120" class="avatar img-circle img-thumbnail"
                     alt="Elapsus Report Card Module"
                     style=" -moz-border-radius: 50%!important; -webkit-border-radius: 50%!important; border-radius: 50%!important; border:0!important;">
                <h3><strong>Aanmelden</strong></h3>
            </div>
        </div>
        <div class="panel-body">
            <form action="<?php echo site_url('validate') ?>" method="post" action="#" method="post"
                  class="form-horizontal" role="form">

                <div class="error_message"><?php echo $this->session->flashdata('error_message'); ?></div>
                <div class="success_message"><?php echo $this->session->flashdata('success_message'); ?></div>
                <div class="form-group">
                    <label for="login" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="login" id="login" placeholder="Email" required="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="password" id="password" placeholder="Password" required=""
                               type="password">
                    </div>
                </div>
                <div class="form-group last">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-success btn-sm">Aanmelden</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="panel-footer">

            <p class="text-muted text-center hidden-xs">
                Snelkoppeling op bureaublad?<br/>Sleep de afbeelding naar uw bureaublad. Hierdoor maakt u een
                snelkoppeling direct naar uw inlog venster
            <center><a href="<?= base_url(); ?>" style="border:1px dotted red; padding:15px; display:inline-block;">
                    <div id="icon"
                         style="background: url(<?= base_url('/assets/img/elapsus2.0.png'); ?>) no-repeat center center;  -webkit-background-size: cover;
                                 -moz-background-size: cover;
                                 -o-background-size: cover;
                                 background-size: cover; width:80px; height:80px;" title="Elapsus Snelkoppeling"></div>
                    <div id="title">Elapsus Snelkoppeling</div>
                </a></center>
            </p>
        </div>
    </div>

</div>







