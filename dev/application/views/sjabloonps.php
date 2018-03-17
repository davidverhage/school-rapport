<?php
/**
 * @id
 * @tbl_student_id
 * @user_id
 * @leidsters
 * @verslag_versie
 * @datum_periode
 * @pvg
 * @taal_la
 * @taal_dv
 * @taal_zb
 * @taal_ws
 * @taal_ag
 * @taal_lv_kh
 * @taal_lv_lv
 * @taal_lv_rij
 * @taal_lv_lwz
 * @taal_lv_kw
 * @taal_lv_ks
 * @taal_lv_ka
 * @taal_lv_l10
 * @taal_lv_en
 * @reken_rb
 * @reken_gb12
 * @reken_gb20
 * @reken_ee
 * @reken_pos
 * @reken_h4
 * @reken_mm
 * @reken_td
 * @reken_gg
 * @motor_kg
 * @motor_ohc
 * @kosmi_verslag
 * @kosmi_in
 * @kosmi_kk
 * @crea_verslag
 * @gym_verslag
 * @gym_in
 * @gym_sv
 * @gym_mv
 * @eo_verslag
 * @oo_verslag
 * @notes
 *
 */

if ($this->uri->segment('1') == 'printer' || $this->uri->segment(2) == 'storepdf') { ?>
    <link href="<?= base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="<?= base_url(); ?>assets/css/theme-set.css" rel="stylesheet">

    <link href="<?= base_url(); ?>assets/css/app.css" rel="stylesheet">

<?php } ?>


<?php if ($this->uri->segment(1) === 'preview'):

    /* Keep this in to seperate the two versions of reports in the report view page*/
    $enabled = false;
    /* end - setting of enablement; */
    $uri_table = 'tbl_g' . $this->uri->segment(4);
    $uri_table_id = $this->uri->segment(5);
    $uri_report_student_id = $this->uri->segment(3);
    $this->db->join('tbl_students_xml ts', "$uri_table.tbl_student_id = ts.id");
    $report_items_1 = $this->db->get_where($uri_table, array("$uri_table.id" => $uri_table_id, 'verslag_versie' => 1))->result();
    $report_item = new stdClass();
    foreach ($report_items_1 as $r1):
        $report_item = $r1;
    endforeach;

    $this->db->from($uri_table);
    $this->db->where('tbl_student_id', $uri_report_student_id);
    $this->db->where('verslag_versie', 2);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        $enabled = true;
        $uri_table = 'tbl_g' . $this->uri->segment(4);
        $uri_table_id = $this->uri->segment(5);
        $uri_report_student_id = $this->uri->segment(3);
        $this->db->join('tbl_students_xml ts', "$uri_table.tbl_student_id = ts.id");
        $report_items_2 = $this->db->get_where($uri_table, array("$uri_table.tbl_student_id" => $uri_report_student_id, 'verslag_versie' => 2))->result();
        $report_item_2 = new stdClass();
        foreach ($report_items_2 as $r2):
            $report_item_2 = $r2;
        endforeach;
        //echo $this->db->last_query();
    }
    //echo '<pre>'.var_dump($report_item_2).'</pre>';
    ?>

    <style>body {
            background: #FFF !important;
        }</style>
    <h1>Preview</h1>
    <a href="javascript:javascript:history.go(-1)">Terug naar formulier</a>
<?php endif; ?>
<table class="table" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td class="logoenms" style="border:none !important;width:100%;float:right;text-align:right;"><img
                    src="<?= base_url('assets/img/enms_pdf.png'); ?>"
                    style="max-width:201px;width:150px;padding-bottom:10px;float:right;text-align:right"
                    class="img-responsive pull-right"/></td>
    </tr>
    <tr>
        <td class="text-center"
            style="border:none !important;width: 100% !important; color:#5B9BD5 !important; text-align: center;padding-bottom:20px!important;">
            <h3 class="text-center">
                <strong>Verslagformulier Eerste Nederlandse Montessorischool</strong>
            </h3></td>

    </tr>
    </tbody>
</table>


<table border="1" cellpadding="0" cellspacing="0" class="table dblue-table">
    <tbody>
    <tr>
        <th colspan="2">


            Peutergroep

        </th>
    </tr>
    <tr>
        <td width="127">

            <strong>Naam</strong>

        </td>

        <td width="487">
            <?php
            $middlename = ($report_item->Tussenvoegsel) ? $report_item->Tussenvoegsel . ' ' : ' ';
            echo $report_item->Roepnaam . ' ' . $middlename . $report_item->Achternaam;
            ?>
        </td>
    </tr>
    <tr>
        <td width="127">

            <strong>Leid(st)er</strong>

        </td>

        <td width="487">
            <?php if ($enabled === true && $report_item_2->leidsters != NULL) {
                echo $report_item_2->leidsters;
            } else {
                echo $report_item->leidsters;
            } ?>
        </td>
    </tr>
    <tr>
        <td width="127">

            <strong>Datum / Periode</strong>

        </td>

        <td width="487">
            <?php if ($enabled === true && $report_item_2->datum_periode != NULL) {
                echo $report_item_2->datum_periode;
            } else {
                echo $report_item->datum_periode;
            } ?>
        </td>
    </tr>
    </tbody>
</table>
<table border="1" cellpadding="0" cellspacing="0" class="table blue-table">
    <tbody>
    <tr>
        <th colspan="12">

            Periode van groei

        </th>
    </tr>
    <tr>
        <td width="173" class="tussen">


        </td>

        <td colspan="3" width="191">
            <p align="center">
                3 jaar</p>

        </td>

        <td width="63" class="tussen">
        </td>
        <td colspan="3" width="191">
            <p align="center">4 jaar</p>
        </td>

    </tr>
    <tr>
        <td width="235">
            <p align="center">
                <em> </em>
            </p>
        </td>


        <td width="38" class="text-center">
            <p align="center">nee</p>
        </td>

        <td width="38" class="text-center">
            <p align="center">soms</p>
        </td>


        <td width="38" class="text-center">
            <p align="center">ja</p>
        </td>

        <td width="63" class="tussen">
        </td>


        <td width="38" class="text-center">
            <p align="center">nee</p>
        </td>

        <td width="38" class="text-center">
            <p align="center">soms</p>
        </td>


        <td width="38" class="text-center">
            <p align="center">ja</p>
        </td>

    </tr>
    </thead>
    <tbody>

    <tr>
        <td width="235"> Benoemt zichzelf als 'ik'</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgik == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgik == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgik == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgik == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgik == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgik == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>

        <td width="235"> Heeft contact met de leidster</td>
        <td width="38"
            ikass="text-center"><?php echo ($report_item->pvgcl == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgcl == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgcl == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgcl == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgcl == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgcl == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Heeft contact met andere kinderen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgck == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgck == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgck == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgck == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgck == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgck == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Kan samen spelen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgss == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgss == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgss == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgss == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgss == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgss == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Kan voor zichzelf opkomen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgzo == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgzo == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgzo == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgzo == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgzo == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgzo == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Houdt rekening met anderen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgra == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgra == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgra == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgra == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgra == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgra == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Neemt initiatieven</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgi == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgi == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgi == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgi == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgi == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgi == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Kan zich aanpassen aan wisselende situaties</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgws == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgws == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgws == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgws == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgws == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgws == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Houdt zich aan afspraken</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgaa == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgaa == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgaa == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgaa == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgaa == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgaa == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Kan teleurstellingen verwerken</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgtv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgtv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgtv == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgtv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgtv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgtv == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Ruimt zelfstandig op</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgrz == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgrz == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgrz == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgrz == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgrz == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgrz == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Kan zich concentreren</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgkc == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgkc == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgkc == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgkc == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgkc == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgkc == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Heeft zorg voor werk</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgzw == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgzw == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgzw == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgzw == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgzw == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgzw == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Heeft doorzettingsvermogen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgd == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgd == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgd == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgd == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgd == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgd == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Doet mee met kringactiviteiten</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgk == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgk == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Kan jas en schoenen aandoen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgjs == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgjs == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgjs == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgjs == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgjs == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgjs == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Neemt makkelijk afscheid</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgma == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgma == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgma == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgma == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgma == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgma == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Geeft uit zichzelf een hand</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgzh == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgzh == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgzh == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgzh == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgzh == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgzh == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Is zindelijk</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgiz == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgiz == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgiz == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgiz == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgiz == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgiz == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>

    <tr>
        <td width="235"> Kan basisemoties onderscheiden</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgbo == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgbo == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvgbo == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgbo == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgbo == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvgbo == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Vraagt om hulp</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvghp == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvghp == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->pvghp == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvghp == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvghp == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->pvghp == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>


    <tr>
        <td width="235">

            <strong>Toelichting 3 jaar</strong>

        </td>

        <td colspan="7">
            <?php echo $report_item->pvg; ?>

        </td>
    </tr>
    <tr>
        <td width="235">

            <strong>Toelichting 4 jaar</strong>

        </td>

        <td colspan="7">
            <?php if ($enabled === true) {
                echo($report_item_2->pvg);
            } ?>
        </td>
    </tr>
    </tbody>
</table>

<table border="1" cellpadding="0" cellspacing="0" class="table orange-table">
    <thead>
    <tr>
        <th colspan="12" valign="top">

            Taal

        </th>
    </tr>
    <tr>
        <td width="173" class="tussen">


        </td>

        <td colspan="3" width="191">
            <p align="center">
                3 jaar</p>

        </td>

        <td width="63" class="tussen">
        </td>
        <td colspan="3" width="191">
            <p align="center">4 jaar</p>
        </td>

    </tr>
    <tr>
        <td width="235">
            <p align="center">
                <em> </em>
            </p>
        </td>


        <td width="38" class="text-center">
            <p align="center">nee</p>
        </td>

        <td width="38" class="text-center">
            <p align="center">soms</p>
        </td>


        <td width="38" class="text-center">
            <p align="center">ja</p>
        </td>

        <td width="63" class="tussen">
        </td>


        <td width="38" class="text-center">
            <p align="center">nee</p>
        </td>

        <td width="38" class="text-center">
            <p align="center">soms</p>
        </td>


        <td width="38" class="text-center">
            <p align="center">ja</p>
        </td>

    </tr>
    </thead>
    <tbody>


    <tr>
        <td width="235"> Vertelt in de kring</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->tldv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->tldv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->tldv == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->tldv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->tldv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->tldv == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Luistert naar anderen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->tlna == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->tlna == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->tlna == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->tlna == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->tlna == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->tlna == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Spreekt verstaanbaar</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->tlsv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->tlsv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->tlsv == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->tlsv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->tlsv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->tlsv == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Maakt zinnen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->tlz == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->tlz == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->tlz == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->tlz == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->tlz == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->tlz == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Kan kritisch luisteren</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->tllz == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->tllz == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->tllz == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->tllz == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->tllz == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->tllz == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>


    <tr>
        <td width="235">

            <strong>Toelichting 3 jaar</strong>

        </td>

        <td colspan="7">
            <?php echo $report_item->tl; ?>

        </td>
    </tr>
    <tr>
        <td width="235">

            <strong>Toelichting 4 jaar</strong>

        </td>

        <td colspan="7">
            <?php if ($enabled === true) {
                echo($report_item_2->tl);
            } ?>
        </td>
    </tr>
    </tbody>
</table>

<table border="1" cellpadding="0" cellspacing="0" class="table yellow-table">

    <thead>
    <tr>
        <th colspan="12">

            Rekenen

        </th>
    </tr>
    <tr>
        <td width="173" class="tussen">


        </td>

        <td colspan="3" width="191">
            <p align="center">
                3 jaar</p>

        </td>

        <td width="63" class="tussen">
        </td>
        <td colspan="3" width="191">
            <p align="center">4 jaar</p>
        </td>

    </tr>
    <tr>
        <td width="235">
            <p align="center">
                <em> </em>
            </p>
        </td>


        <td width="38" class="text-center">
            <p align="center">nee</p>
        </td>

        <td width="38" class="text-center">
            <p align="center">soms</p>
        </td>


        <td width="38" class="text-center">
            <p align="center">ja</p>
        </td>

        <td width="63" class="tussen">
        </td>


        <td width="38" class="text-center">
            <p align="center">nee</p>
        </td>

        <td width="38" class="text-center">
            <p align="center">soms</p>
        </td>


        <td width="38" class="text-center">
            <p align="center">ja</p>
        </td>

    </tr>
    </thead>
    <tbody>


    <tr>
        <td width="235"> Kan akoestisch tellen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->rkrb == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->rkrb == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->rkrb == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->rkrb == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->rkrb == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->rkrb == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Kan synchroon tellen tot 10</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->rkst == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->rkst == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->rkst == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->rkst == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->rkst == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->rkst == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Kan hoeveelheden herkennen/benoemen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->rkhh == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->rkhh == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->rkhh == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->rkhh == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->rkhh == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->rkhh == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Kan sorteren naar vorm/grootte</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->rks == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->rks == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->rks == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->rks == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->rks == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->rks == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"><b>Getalbegrip</b><br/>Kan meetkundige vormen onderscheiden en benoemen (cirkel,vierkant, etc.)
        </td>
        <td width="38"
            class="text-center"><?php echo ($report_item->rkgb == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->rkgb == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->rkgb == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->rkgb == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->rkgb == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->rkgb == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>


    <tr>
        <td width="235">

            <strong>Toelichting 3 jaar</strong>

        </td>

        <td colspan="7">
            <?php echo $report_item->rk; ?>

        </td>
    </tr>
    <tr>
        <td width="235">

            <strong>Toelichting 4 jaar</strong>

        </td>

        <td colspan="7">
            <?php if ($enabled === true) {
                echo($report_item_2->rk);
            } ?>
        </td>
    </tr>
    </tbody>
</table>
<table border="1" cellpadding="0" cellspacing="0" class="table pink-table">
    <tbody>
    <tr>
        <th colspan="12">
            Creatieve ontwikkeling
        </th>
    </tr>
    <tr>
        <td width="173" class="tussen">


        </td>

        <td colspan="3" width="191">
            <p align="center">
                3 jaar</p>

        </td>

        <td width="63" class="tussen">
        </td>
        <td colspan="3" width="191">
            <p align="center">4 jaar</p>
        </td>

    </tr>
    <tr>
        <td width="235">
            <p align="center">
                <em> </em>
            </p>
        </td>


        <td width="38" class="text-center">
            <p align="center">nee</p>
        </td>

        <td width="38" class="text-center">
            <p align="center">soms</p>
        </td>


        <td width="38" class="text-center">
            <p align="center">ja</p>
        </td>

        <td width="63" class="tussen">
        </td>


        <td width="38" class="text-center">
            <p align="center">nee</p>
        </td>

        <td width="38" class="text-center">
            <p align="center">soms</p>
        </td>


        <td width="38" class="text-center">
            <p align="center">ja</p>
        </td>

    </tr>
    </thead>
    <tbody>


    <tr>
        <td width="235"> Kiest voor een creatieve activiteit</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->cra == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->cra == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->cra == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->cra == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->cra == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->cra == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Gaat vanuit zijn/haar fantasie aan het werk</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->crf == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->crf == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->crf == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->crf == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->crf == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->crf == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Tekent</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->crt == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->crt == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->crt == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->crt == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->crt == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->crt == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Kent kleuren</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->crk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->crk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->crk == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->crk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->crk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->crk == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Speelt in de fantasiehoek</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->crsf == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->crsf == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->crsf == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->crsf == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->crsf == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->crsf == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>


    <tr>
        <td width="235">

            <strong>Toelichting 3 jaar</strong>

        </td>

        <td colspan="7">
            <?php echo $report_item->cr; ?>

        </td>
    </tr>
    <tr>
        <td width="235">

            <strong>Toelichting 4 jaar</strong>

        </td>
        <td colspan="7">
            <?php if ($enabled === true) {
                echo($report_item_2->cr);
            } ?>
        </td>
    </tr>
    </tbody>
</table>

<table border="1" cellpadding="0" cellspacing="0" class="table green-table">
    <thead>
    <tr>
        <th colspan="12" valign="top">

            Fijne motoriek
        </th>
    </tr>
    <tr>
        <td width="173" class="tussen">


        </td>

        <td colspan="3" width="191">
            <p align="center">
                3 jaar</p>

        </td>

        <td width="63" class="tussen">
        </td>
        <td colspan="3" width="191">
            <p align="center">4 jaar</p>
        </td>

    </tr>
    <tr>
        <td width="235">
            <p align="center">
                <em> </em>
            </p>
        </td>


        <td width="38" class="text-center">
            <p align="center">nee</p>
        </td>

        <td width="38" class="text-center">
            <p align="center">soms</p>
        </td>


        <td width="38" class="text-center">
            <p align="center">ja</p>
        </td>

        <td width="63" class="tussen">
        </td>


        <td width="38" class="text-center">
            <p align="center">nee</p>
        </td>

        <td width="38" class="text-center">
            <p align="center">soms</p>
        </td>


        <td width="38" class="text-center">
            <p align="center">ja</p>
        </td>

    </tr>
    </thead>
    <tbody>

    <tr>
        <td width="235"> Kan smalle stroken knippen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmsk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmsk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmsk == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmsk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmsk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmsk == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Kan brede stroken knippen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmbk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmbk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmbk == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmbk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmbk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmbk == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Kan een vierkant knippen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmvk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmvk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmvk == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmvk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmvk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmvk == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Kan een cirkel knippen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmck == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmck == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmck == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmck == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmck == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmck == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Kan een spiraal knippen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmsl == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmsl == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmsl == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmsl == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmsl == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmsl == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Heeft een goede pengreep</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmgp == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmgp == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmgp == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmgp == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmgp == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmgp == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Rechts-/linkshandig</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmrl == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmrl == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->fmrl == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmrl == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmrl == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->fmrl == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>


    <tr>
        <td width="235">

            <strong>Toelichting 3 jaar</strong>

        </td>

        <td colspan="7">
            <?php echo $report_item->fm; ?>

        </td>
    </tr>
    <tr>
        <td width="235">

            <strong>Toelichting 4 jaar</strong>

        </td>

        <td colspan="7">
            <?php if ($enabled === true) {
                echo($report_item_2->fm);
            } ?>
        </td>
    </tr>
    </tbody>
</table>

<table border="1" cellpadding="0" cellspacing="0" class="table purple-table">
    <thead>
    <tr>
        <th colspan="12">

            Grove motoriek
        </th>
    </tr>
    <tr>
        <td width="235">


        </td>

        <td colspan="3" width="191">
            <p align="center">
                3 jaar</p>

        </td>

        <td width="63" class="tussen">
        </td>
        <td colspan="3" width="191">
            <p align="center">4 jaar</p>
        </td>

    </tr>
    <tr>
        <td width="235">
            <p align="center">
                <em> </em>
            </p>
        </td>


        <td width="38" class="text-center">
            <p align="center">nee</p>
        </td>

        <td width="38" class="text-center">
            <p align="center">soms</p>
        </td>


        <td width="38" class="text-center">
            <p align="center">ja</p>
        </td>

        <td width="63" class="tussen">
        </td>


        <td width="38" class="text-center">
            <p align="center">nee</p>
        </td>

        <td width="38" class="text-center">
            <p align="center">soms</p>
        </td>


        <td width="38" class="text-center">
            <p align="center">ja</p>
        </td>

    </tr>
    </thead>
    <tbody>

    <tr>
        <td width="235"> Kan fietsen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->gmf == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->gmf == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->gmf == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->gmf == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->gmf == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->gmf == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>

    <tr>
        <td width="235"> Durft ergens af te springen</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->gmas == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->gmas == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->gmas == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->gmas == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->gmas == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->gmas == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Speelt en beweegt met plezier</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->gmsb == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->gmsb == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->gmsb == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->gmsb == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->gmsb == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->gmsb == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Beweegt graag op muziek</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->gmbm == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->gmbm == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->gmbm == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->gmbm == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->gmbm == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->gmbm == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>
    <tr>
        <td width="235"> Beweegt zich soepel</td>
        <td width="38"
            class="text-center"><?php echo ($report_item->gmbs == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->gmbs == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="38"
            class="text-center"><?php echo ($report_item->gmbs == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : ''; ?></td>
        <td width="63" class="tussen"></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->gmbs == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->gmbs == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
        <td width="38" class="text-center"><?php if ($enabled === true) {
                echo ($report_item_2->gmbs == 9) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?></td>
    </tr>
    <tr>


    <tr>
        <td width="173">

            <strong>Toelichting 3 jaar</strong>

        </td>
        <td colspan="7">
            <?php echo $report_item->gm; ?>
        </td>
    </tr>
    <tr>
        <td width="235">

            <strong>Toelichting 4 jaar</strong>

        </td>
        <td colspan="7">
            <?php if ($enabled === true) {
                echo($report_item_2->gm);
            } ?>
        </td>
    </tr>
    </tbody>
</table>


<table border="1" cellpadding="0" cellspacing="0" class="table lblue-table">
    <tbody>
    <tr>
        <th colspan="2" valign="top">
            Opmerkingen
        </th>
    </tr>
    <tr>
        <td width="235">

            <strong>Toelichting 3 jaar</strong>

        </td>

        <td width="441">
            <?php echo $report_item->oo_verslag; ?>
        </td>
    </tr>
    <tr>
        <td width="235">

            <strong>Toelichting 4 jaar</strong>

        </td>
        <td width="441">
            <?php if ($enabled === true) {
                echo($report_item_2->oo_verslag);
            } ?>
        </td>
    </tr>
    </tbody>
</table>
<table border="1" cellpadding="0" cellspacing="0" class="table dblue-table">
    <tbody>
    <tr>
        <th colspan="5">
            Handtekening
        </th>
    </tr>
    <tr>
        <td width="235">


        </td>

        <td width="191">
            <p align="center">
                3 jaar</p>

        </td>

        <td width="63" class="tussen">
        </td>
        <td width="191">
            <p align="center">4 jaar</p>
        </td>

    </tr>
    <tr>
        <td width="235">
            <p>
                <strong>Leid(st)er</strong>

        </td>

        <td></td>
        <td width="63" class="tussen">
        </td>
        <td></td>
    </tr>
    <tr>
        <td width="235">
            <p>
                <strong>Directie</strong>

        </td>

        <td></td>
        <td width="63" class="tussen">
        </td>
        <td></td>
    </tr>
    </tbody>
</table>
