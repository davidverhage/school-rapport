<div class="row">
    <div class="col-xs-12 col-sm-12 block-box" style="min-height:480px;">
        <div id="profile_page" class="well">
            <h3>Verslagen Downloaden</h3>
            <p>De volgende verslagen staan in de documenten map. U kunt een individuele selectie maken of alles in een
                keer selecteren.</p>
            <label class="label label-danger">LET OP!</label>
            <p>Het is mogelijk dat u hier geen bestanden ziet. Dit kan komen omdat er dan nog geen verslagen zijn
                gemaakt of zijn opgeslagen.</p>
            <form action="/dashboard/download_zip" method="post" id="zipbuilder" class="form-horizontal" role="form">
                <div class="form-group">
                    <fieldset>
                        <legend>\\Documenten</legend>
                        <p>
                            <label class="btn btn-danger btn-sm text-center clearfix">
                                <input type="checkbox" id="checkAll" style="opacity:1; visibility:hidden;"/>
                                <i class="glyphicon glyphicon-ok"></i>
                            </label>
                        </p>
                        <?php foreach ($files as $key => $file_name) { ?>

                            <label class="btn btn-success col-xs-12 col-sm-2 active">
                                <input type="checkbox" name='files[]' id="file_name" type="radio"
                                       value='<?= $file_name; ?>' autocomplete="off" checked="checked"/>
                                <?= $file_name; ?>
                            </label>

                        <?php } ?>
                    </fieldset>
                </div>
                <label class="control-label" for="pwd">Archiefnaam:</label>
                <div class="input-group">
                    <input name="file_name" class="form-control" id="file_name" type="text" required/>
                    <span class="input-group-btn">
                    <button class="btn btn-primary btn-md" id="download" type="submit"><i
                                class="glyphicon glyphicon-download-alt"></i></button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>