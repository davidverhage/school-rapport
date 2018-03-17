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
    <link href="<?= base_url(); ?>assets/css/mpdfcss.css" rel="stylesheet">

<?php } ?>


<?php
$enabled1 = '';
$enabled = '';


$uri_table = 'tbl_g' . $this->uri->segment(4);

$uri_table_id = $this->uri->segment(5);
$uri_report_student_id = $this->uri->segment(3);
/* Keep this in to seperate the two versions of reports in the report view page*/
$this->db->from($uri_table);
$this->db->where('tbl_student_id', $uri_report_student_id);
$this->db->where('verslag_versie', 1);
$query = $this->db->get();
if ($query->num_rows() > 0) {

    $enabled1 = true;
    /* end - setting of enablement; */

    $this->db->join('tbl_students_xml ts', "$uri_table.tbl_student_id = ts.id");

    $report_items_1 = $this->db->get_where($uri_table, array("$uri_table.id" => $uri_table_id, 'verslag_versie' => 1))->result();
    $report_item = new stdClass();
    foreach ($report_items_1 as $r1):
        $report_item = $r1;
    endforeach;
}


$this->db->from($uri_table);
$this->db->where('tbl_student_id', $uri_report_student_id);
$this->db->where('verslag_versie', 2);
$this->db->where('schooljaar', $this->uri->segment(6));
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
if ($this->uri->segment(2) === 'voorbeeld' || $this->uri->segment(1) === 'preview'): ?>


    <style>body {
            background: #FFF !important;
        }

        table {
            max-width: 800px !important;
            margin: 10px auto;
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
            <?php

            $reportlhg = '';
            if ($enabled != true) {
                $reportlhg = $r1->lhg;
            } else {
                $reportlhg = $r2->lhg;
            }


            $switch = '';
            if ($enabled != true) {
                //klasnaam onttrekken

                $this->db->select('*');
                $this->db->from('tbl_classes_xml');
                $this->db->where('tbl_classes_xml.id', $r1->groepkey);
                $this->db->limit('1');
                $naamklas = $this->db->get();

                foreach ($naamklas->result() as $student_klas) {

                    $switch = $student_klas->name;
                }
            } else {
                $this->db->select('*');
                $this->db->from('tbl_classes_xml');
                $this->db->where('tbl_classes_xml.id', $r2->groepkey);
                $this->db->limit('1');
                $naamklas1 = $this->db->get();

                foreach ($naamklas1->result() as $student_klas1) {

                    $switch = $student_klas1->name;
                }
            }
            switch ($switch) {
                case 'OB-1':
                case 'OB-2':
                case 'OB-3':
                case 'OB-4':
                    echo "Onderbouw";
                    break;

                case 'MB-1':
                case 'MB-2':
                case 'MB-3':
                case 'MB-4':
                    echo "Middenbouw";
                    break;

                case 'TB-1':
                case 'TB-4':
                    echo "Tussenbouw";
                    break;

                case 'BB-1':
                case 'BB-2':
                case 'BB-3':
                case 'BB-4':
                    echo "Bovenbouw";
                    break;
            }

            ?> - groep <?php echo $reportlhg; ?>
        </th>
    </tr>
    <tr>
        <td width="176">

            <strong>Naam</strong>

        </td>

        <td width="464">
            <?php
            if (isset($fml)) {
                echo $fml;
            } else {
                $middlename = '';

                if ($enabled1 === true) {
                    ($report_item->Tussenvoegsel) ? $middlename = $report_item->Tussenvoegsel . ' ' : $middlename = ' ';
                } else {
                    ($report_item_2->Tussenvoegsel) ? $middlename = $report_item_2->Tussenvoegsel . ' ' : $middlename = ' ';
                }
                if ($enabled1 === true) {
                    echo $report_item->Roepnaam . ' ' . $middlename . $report_item->Achternaam;
                } else {
                    echo $report_item_2->Roepnaam . ' ' . $middlename . $report_item_2->Achternaam;
                }
            }
            ?>
        </td>
    </tr>
    <tr>
        <td width="176">

            <strong>Leid(st)er</strong>

        </td>

        <td width="464">
            <?php if ($enabled === true) {
                echo $report_item_2->leidsters;
            } else {
                echo $report_item->leidsters;
            } ?>
        </td>
    </tr>
    <tr>
        <td width="176">

            <strong>Datum / Periode</strong>

        </td>

        <td width="464">
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
        <th colspan="2">

            Periode van groei

        </th>
    </tr>
    <tr>
        <td width="176">

            <strong>Verslag 1</strong>

        </td>

        <td width="464">
            <?php if ($enabled1 === true) {
                echo $report_item->pvg;
            } ?>

        </td>
    </tr>
    <tr>
        <td width="176">

            <strong>Verslag 2</strong>

        </td>

        <td width="464">
            <?php if ($enabled === true) {
                echo($report_item_2->pvg);
            } ?>

            <!-- ?php echo $report_item->pvg;? -->
        </td>
    </tr>
    </tbody>
</table>
<pagebreak/>
<table border="1" cellpadding="0" cellspacing="0" class="table orange-table">
    <thead>
    <tr>
        <th colspan="12" valign="top">

            Taal

        </th>
    </tr>
    <tr>
        <td width="190" class="tussen">


        </td>

        <td colspan="5" width="190">

            Verslag 1

        </td>

        <td width="63" class="tussen">
        </td>
        <td colspan="5" width="190">

            Verslag 2

        </td>

    </tr>
    <tr>
        <td width="190">

        </td>

        <td width="38" class="text-center">

            O

        </td>

        <td width="38" class="text-center">

            Z

        </td>

        <td width="38" class="text-center">

            V

        </td>

        <td width="38" class="text-center">

            RV

        </td>

        <td width="38" class="text-center">

            G

        </td>

        <td width="63" class="tussen">
        </td>
        <td width="38" class="text-center">

            O

        </td>

        <td width="38" class="text-center">

            Z

        </td>

        <td width="38" class="text-center">

            V

        </td>

        <td width="38" class="text-center">

            RV

        </td>

        <td width="38" class="text-center">

            G

        </td>

    </tr>
    </thead>
    <tbody>
    <?php if ($reportlhg <= 2) { ?>
        <tr>
            <td colspan="12" class="table dblue-table" style="background:#fff;">

                <strong>Mondelinge taalvaardigheid:</strong>

            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg <= 2) { ?>
        <tr>
            <td width="190">
                Luistert naar anderen

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_la == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_la == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_la == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_la == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_la == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_la == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_la == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_la == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_la == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_la == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg <= 2) { ?>
        <tr>
            <td width="190">
                Durft te vertellen

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_dv == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_dv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_dv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_dv == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_dv == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_dv == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_dv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_dv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_dv == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_dv == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg <= 2) { ?>
        <tr>
            <td width="190">
                Zinsbouw

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_zb == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_zb == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_zb == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_zb == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_zb == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_zb == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_zb == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_zb == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_zb == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_zb == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg <= 2) { ?>
        <tr>
            <td width="190">
                Woordenschat

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_ws == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_ws == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_ws == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_ws == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_ws == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_ws == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_ws == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_ws == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_ws == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_ws == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg <= 2) { ?>
        <tr>
            <td width="190">
                Auditief geheugen

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_ag == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_ag == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_ag == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_ag == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_ag == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_ag == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_ag == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_ag == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_ag == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_ag == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg <= 2) { ?>
        <tr>
            <td colspan="12" class="table dblue-table" style="background:#fff;">

                <strong>Leesvoorwaarden:</strong>

            </td>

        </tr>
    <?php } ?>
    <?php if ($reportlhg == 1) { ?>
        <tr>
            <td width="190">
                Kan verschillen in op elkaar lijkende vormen zien

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_vv == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_vv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_vv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_vv == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_vv == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_vv == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_vv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_vv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_vv == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_vv == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 2) { ?>
        <tr>
            <td width="190">
                Kan verschillen in klanken horen

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_kh == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_kh == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_kh == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_kh == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_kh == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_kh == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_kh == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_kh == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_kh == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_kh == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 2) { ?>
        <tr>
            <td width="190">
                Kan verschillen in lettervormen zien

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_lv == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_lv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_lv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_lv == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_lv == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_lv == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_lv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_lv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_lv == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_lv == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg <= 2) { ?>
        <tr>
            <td width="190">
                Rijmen

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_rij == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_rij == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_rij == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_rij == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_rij == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_rij == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_rij == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_rij == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_rij == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_rij == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 2) { ?>
        <tr>
            <td width="190">
                Kent verschil letter/woord/zin

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_lwz == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_lwz == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_lwz == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_lwz == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_lwz == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_lwz == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_lwz == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_lwz == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_lwz == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_lwz == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 2) { ?>
        <tr>
            <td width="190">
                Korte woorden na stempelen/leggen

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_kw == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_kw == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_kw == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_kw == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_kw == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_kw == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_kw == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">

                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_kw == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_kw == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_kw == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 2) { ?>
        <tr>
            <td width="190">
                Kan synthetiseren

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_ks == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_ks == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_ks == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_ks == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_ks == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_ks == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_ks == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_ks == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_ks == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_ks == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 2) { ?>
        <tr>
            <td width="190">
                Kan analyseren

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_ka == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_ka == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_ka == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_ka == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_ka == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_ka == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_ka == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_ka == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_ka == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_ka == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 2) { ?>
        <tr>
            <td width="190">
                Herkent minimaal 10 letters

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_l10 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_l10 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_l10 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_l10 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_lv_l10 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_l10 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_l10 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_l10 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_l10 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_lv_l10 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg > 2) { ?>
        <tr>
            <td width="190">
                Technisch lezen
            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_tl == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_tl == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_tl == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_tl == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_tl == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_tl == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_tl == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_tl == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_tl == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_tl == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg > 2) { ?>
        <tr>
        <td width="190"> Begrijpend lezen
        </td>

        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->taal_bl == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->taal_bl == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->taal_bl == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->taal_bl == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->taal_bl == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="63" class="tussen">
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->taal_bl == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->taal_bl == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->taal_bl == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->taal_bl == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->taal_bl == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        </tr><?php } ?>
    <?php if ($reportlhg == 3) { ?>
        <tr>
            <td width="190">
                Uitdrukkingsvaardigheid
            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_uv == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_uv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_uv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_uv == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_uv == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_uv == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_uv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_uv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_uv == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_uv == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg > 3) { ?>
        <tr>
            <td width="190"> Boekbespreking
            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_bb == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_bb == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_bb == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_bb == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_bb == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_bb == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_bb == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_bb == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_bb == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_bb == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg > 3) { ?>
        <tr>
            <td width="190">Stellen (inzet)
            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_st == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_st == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_st == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_st == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_st == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_st == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_st == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_st == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_st == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_st == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg > 2) { ?>
        <tr>
            <td width="190"> Spelling
            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_sp == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_sp == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_sp == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_sp == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_sp == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_sp == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_sp == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_sp == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_sp == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_sp == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>

    <?php if ($reportlhg > 2) { ?>
        <tr>
            <td width="190">
                (Montessori) materiaalgebruik

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_mm == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_mm == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_mm == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_mm == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_mm == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_mm == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_mm == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_mm == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_mm == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_mm == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>

    <tr>
        <td width="190">
            Engels (inzet)

        </td>

        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->taal_lv_en == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->taal_lv_en == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->taal_lv_en == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->taal_lv_en == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->taal_lv_en == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="63" class="tussen">
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->taal_lv_en == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->taal_lv_en == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->taal_lv_en == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->taal_lv_en == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->taal_lv_en == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
    </tr>

    <?php if ($reportlhg == 8) { ?>
        <tr>
            <td width="190">
                8 Engels niveau ( groep 8)

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_en8 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_en8 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_en8 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_en8 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->taal_en8 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_en8 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_en8 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_en8 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_en8 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->taal_en8 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<table border="1" cellpadding="0" cellspacing="0" class="table yellow-table">

    <thead>
    <tr>
        <th colspan="12">

            Rekenen/wiskunde

        </th>
    </tr>
    <tr>
        <td width="190" class="tussen">

        </td>

        <td colspan="5" width="190">
            Verslag 1

        </td>

        <td width="63" class="tussen">
        </td>
        <td colspan="5" width="190">

            Verslag 2

        </td>

    </tr>
    <tr>
        <td width="190">

        </td>

        <td width="38" class="text-center">

            O

        </td>

        <td width="38" class="text-center">

            Z

        </td>

        <td width="38" class="text-center">

            V

        </td>

        <td width="38" class="text-center">

            RV

        </td>

        <td width="38" class="text-center">

            G

        </td>

        <td width="63" class="tussen">
        </td>
        <td width="38" class="text-center">

            O

        </td>

        <td width="38" class="text-center">

            Z

        </td>

        <td width="38" class="text-center">

            V

        </td>

        <td width="38" class="text-center">

            RV

        </td>

        <td width="38" class="text-center">

            G

        </td>

    </tr>
    </thead>
    <tbody>
    <?php if ($reportlhg <= 2) { ?>
        <tr>
            <td width="190">
                Kent de rekenbegrippen zoals minder/meer/vooraan...

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_rb == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_rb == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_rb == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_rb == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_rb == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_rb == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_rb == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_rb == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_rb == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_rb == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 1) { ?>
        <tr>
            <td width="190">
                Getalbegrip t/m 6

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb6 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb6 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb6 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb6 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb6 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb6 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb6 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb6 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb6 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb6 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 2) { ?>
        <tr>
            <td width="190">
                Getalbegrip t/m 12

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb12 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb12 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb12 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb12 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb12 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb12 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb12 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb12 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb12 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb12 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 1) { ?>
        <tr>
            <td width="190">
                Getalbegrip t/m 10

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb10 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb10 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb10 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb10 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb10 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb10 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb10 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb10 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb10 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb10 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 2) { ?>
        <tr>
            <td width="190">
                Getalbegrip t/m 20

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb20 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb20 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb20 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb20 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gb20 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb20 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb20 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb20 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb20 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gb20 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 3) { ?>
        <tr>
            <td width="190">
                Rekenen tot 10

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r10 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r10 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r10 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r10 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r10 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r10 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r10 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r10 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r10 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r10 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 3) { ?>
        <tr>
            <td width="190">
                Rekenen tot 20

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r20 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r20 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r20 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r20 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r20 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r20 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r20 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r20 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r20 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r20 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 4) { ?>
        <tr>
            <td width="190">
                Rekenen tot 50

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r50 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r50 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r50 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r50 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r50 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r50 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r50 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r50 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r50 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r50 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 4 || $reportlhg == 5) { ?>
        <tr>
            <td width="190">
                Rekenen tot 100

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r100 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r100 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r100 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r100 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r100 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r100 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r100 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r100 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r100 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r100 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 5) { ?>
        <tr>
            <td width="190">
                Rekenen tot 1000

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r1000 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r1000 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r1000 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r1000 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_r1000 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r1000 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r1000 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r1000 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r1000 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_r1000 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 4) { ?>
        <tr>
            <td width="190">
                Keertafels 1 t/m 5 + 10

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_k5 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_k5 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_k5 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_k5 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_k5 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_k5 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_k5 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_k5 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_k5 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_k5 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 5) { ?>
        <tr>
            <td width="190">
                Keertafels 1 t/m 10

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_k10 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_k10 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_k10 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_k10 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_k10 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_k10 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_k10 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_k10 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_k10 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_k10 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 1) { ?>
        <tr>
            <td width="190">
                Kent de dagen van de week

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_wk == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_wk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_wk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_wk == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_wk == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_wk == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_wk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_wk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_wk == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_wk == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg > 4) { ?>
        <tr>
            <td width="190">
                Beheersing hoofdbewerkingen

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_bh == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_bh == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_bh == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_bh == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_bh == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_bh == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_bh == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_bh == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_bh == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_bh == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 3) { ?>
        <tr>
            <td width="190">

                Automatiseren t/m 10

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_a10 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_a10 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_a10 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_a10 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_a10 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_a10 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_a10 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_a10 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_a10 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_a10 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>    <?php } ?>
    <?php if ($reportlhg == 4) { ?>
        <tr>
            <td width="190">
                Automatiseren t/m 20

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_a20 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_a20 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_a20 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_a20 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_a20 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_a20 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_a20 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_a20 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_a20 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_a20 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 2) { ?>
        <tr>
            <td width="190">
                Kent het begrip erbij/eraf

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_ee == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_ee == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_ee == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_ee == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_ee == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_ee == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_ee == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_ee == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_ee == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_ee == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg <= 2) { ?>
        <tr>
            <td width="190">
                Kan plaatjes ordenen/sorteren

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_pos == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_pos == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_pos == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_pos == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_pos == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_pos == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_pos == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_pos == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_pos == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_pos == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 2) { ?>
        <tr>
            <td width="190">
                Kan schattend een hoeveelheid bepalen t/m 4

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_h4 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_h4 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_h4 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_h4 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_h4 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_h4 == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_h4 == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_h4 == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_h4 == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_h4 == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>

    <tr>
        <td width="190">
            (Montessori) materiaalgebruik

        </td>

        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->reken_mm == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->reken_mm == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->reken_mm == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->reken_mm == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->reken_mm == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="63" class="tussen">
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->reken_mm == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->reken_mm == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->reken_mm == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->reken_mm == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->reken_mm == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
    </tr>

    <?php if ($reportlhg > 1) { ?>
        <tr>
            <td width="190">
                Tijd

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_td == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_td == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_td == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_td == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_td == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_td == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_td == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_td == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_td == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_td == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg == 2) { ?>
        <tr>
            <td width="190">
                Kan grote getallen benoemen

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gg == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gg == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gg == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gg == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gg == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gg == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gg == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gg == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gg == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gg == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg > 2) { ?>
        <tr>
            <td width="190">
                Geld

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gld == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gld == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gld == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gld == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_gld == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gld == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gld == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gld == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gld == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_gld == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg > 2) { ?>
        <tr>
            <td width="190">
                Meten en meetkunde

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_mem == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_mem == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_mem == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_mem == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->reken_mem == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_mem == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_mem == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_mem == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_mem == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->reken_mem == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>

    </tbody>
</table>

<?php if ($reportlhg <= 2) { ?>
    <table border="1" cellpadding="0" cellspacing="0" class="table green-table">
        <thead>
        <tr>
            <th colspan="12" valign="top">

                Fijne motoriek
            </th>
        </tr>
        <tr>
            <td width="190" class="tussen">


            </td>

            <td colspan="5" width="190">

                Verslag 1

            </td>

            <td width="63" class="tussen">
            </td>
            <td colspan="5" width="190">

                Verslag 2

            </td>

        </tr>
        <tr>
            <td width="190">

            </td>

            <td width="38" class="text-center">

                O

            </td>

            <td width="38" class="text-center">

                Z

            </td>

            <td width="38" class="text-center">

                V

            </td>

            <td width="38" class="text-center">

                RV

            </td>

            <td width="38" class="text-center">

                G

            </td>

            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">

                O

            </td>

            <td width="38" class="text-center">

                Z

            </td>

            <td width="38" class="text-center">

                V

            </td>

            <td width="38" class="text-center">

                RV

            </td>

            <td width="38" class="text-center">

                G

            </td>

        </tr>
        </thead>
        <tbody>
        <tr>
            <td width="190">
                Is vaardig in het hanteren van knutselgereedschappen

            </td>

            <td width="38" class="text-center">&nbsp;</td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->motor_kg == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->motor_kg == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->motor_kg == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->motor_kg == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->motor_kg == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->motor_kg == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->motor_kg == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->motor_kg == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->motor_kg == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
        <tr>
            <td width="190">
                Oog-hand co&ouml;rdinatie

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->motor_ohc == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->motor_ohc == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->motor_ohc == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->motor_ohc == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->motor_ohc == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->motor_ohc == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->motor_ohc == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->motor_ohc == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">

                <?php if ($enabled === true) {
                    echo ($report_item_2->motor_ohc == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->motor_ohc == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
        </tbody>
    </table>
    <span class="text-center">
	<?php if ($enabled1 === true) {
        echo ($report_item->motor_kg == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
    } ?>
	</span>
<?php } ?>
<?php if ($reportlhg > 2) { ?>
    <table border="1" cellpadding="0" cellspacing="0" class="table green-table">
        <thead>
        <tr>
            <th colspan="12">

                Schrijven
            </th>
        </tr>
        <tr>
            <td width="190">


            </td>

            <td colspan="5" width="190">

                Verslag 1

            </td>

            <td width="63" class="tussen">
            </td>
            <td colspan="5" width="190">

                Verslag 2

            </td>

        </tr>
        <tr>
            <td width="190">

            </td>

            <td width="38" class="text-center">

                O

            </td>

            <td width="38" class="text-center">

                Z

            </td>

            <td width="38" class="text-center">

                V

            </td>

            <td width="38" class="text-center">

                RV

            </td>

            <td width="38" class="text-center">

                G

            </td>

            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">

                O

            </td>

            <td width="38" class="text-center">

                Z

            </td>

            <td width="38" class="text-center">

                V

            </td>

            <td width="38" class="text-center">

                RV

            </td>

            <td width="38" class="text-center">

                G

            </td>

        </tr>
        </thead>
        <tbody>
        <?php if ($reportlhg == 3 || $reportlhg == 4 || $reportlhg == 5) { ?>
            <tr>
                <td width="190">
                    Fijne motoriek

                </td>

                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_fm == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_fm == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_fm == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_fm == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_fm == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="63" class="tussen">
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_fm == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_fm == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_fm == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_fm == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_fm == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ($reportlhg == 3 || $reportlhg == 4 || $reportlhg == 5) { ?>
            <tr>
                <td width="190">
                    Vorm van de letters

                </td>

                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_vl == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_vl == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_vl == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_vl == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_vl == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="63" class="tussen">
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_vl == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_vl == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_vl == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_vl == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_vl == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ($reportlhg == 3 || $reportlhg == 4 || $reportlhg == 5) { ?>
            <tr>
                <td width="190">
                    Schrijfhouding

                </td>

                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_sh == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_sh == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_sh == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_sh == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_sh == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="63" class="tussen">
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_sh == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_sh == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_sh == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_sh == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_sh == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ($reportlhg == 3 || $reportlhg == 4 || $reportlhg == 5) { ?>
            <tr>
                <td width="190">
                    Pengreep

                </td>

                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_pg == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_pg == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_pg == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_pg == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_pg == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="63" class="tussen">
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_pg == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_pg == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_pg == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_pg == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_pg == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ($reportlhg > 5) { ?>
            <tr>
                <td width="190">
                    Verzorging

                </td>

                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_vz == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_vz == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_vz == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_vz == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_vz == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="63" class="tussen">
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_vz == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_vz == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_vz == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_vz == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_vz == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ($reportlhg > 5) { ?>
            <tr>
                <td width="190">
                    Leesbaarheid

                </td>

                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_lh == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_lh == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_lh == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_lh == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_lh == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="63" class="tussen">
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_lh == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_lh == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_lh == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_lh == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_lh == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ($reportlhg > 5) { ?>
            <tr>
                <td width="190">
                    Bladindeling

                </td>

                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_bi == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_bi == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_bi == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_bi == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled1 === true) {
                        echo ($report_item->schrijf_bi == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="63" class="tussen">
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_bi == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_bi == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_bi == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_bi == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
                <td width="38" class="text-center">
                    <?php if ($enabled === true) {
                        echo ($report_item_2->schrijf_bi == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                    } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>

<table border="1" cellpadding="0" cellspacing="0" class="table purple-table">
    <thead>
    <tr>
        <th colspan="12" valign="top">
            Kosmisch onderwijs
        </th>
    </tr>
    <tr>
        <td width="190" class="tussen">


        </td>

        <td colspan="5" width="190">
            Verslag 1

        </td>

        <td width="63" class="tussen">
        </td>
        <td colspan="5" width="190">

            Verslag 2

        </td>

    </tr>
    <tr>
        <td width="190">

        </td>

        <td width="38" class="text-center">

            O

        </td>

        <td width="38" class="text-center">

            Z

        </td>

        <td width="38" class="text-center">

            V

        </td>

        <td width="38" class="text-center">

            RV

        </td>

        <td width="38" class="text-center">

            G

        </td>

        <td width="63" class="tussen">
        </td>
        <td width="38" class="text-center">

            O

        </td>

        <td width="38" class="text-center">

            Z

        </td>

        <td width="38" class="text-center">

            V

        </td>

        <td width="38" class="text-center">

            RV

        </td>

        <td width="38" class="text-center">

            G

        </td>

    </tr>
    </thead>
    <tbody>
    <tr>
        <td width="190">

            Toont interesse

        </td>

        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->kosmi_in == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->kosmi_in == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->kosmi_in == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->kosmi_in == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->kosmi_in == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="63" class="tussen">
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->kosmi_in == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->kosmi_in == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->kosmi_in == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->kosmi_in == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->kosmi_in == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
    </tr>

    <?php if ($reportlhg <= 2) { ?>
        <tr>
            <td width="190">

                Kiest werkjes uit de kosmische kast en van de aandachtstafel

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_kk == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_kk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_kk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_kk == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_kk == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_kk == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_kk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_kk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_kk == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_kk == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg > 2) { ?>
        <tr>
            <td width="190">

                Projecten

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_pr == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_pr == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_pr == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_pr == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_pr == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_pr == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_pr == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_pr == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_pr == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_pr == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg > 4) { ?>
        <tr>
            <td width="190">

                Werkstuk

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_ws == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_ws == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_ws == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_ws == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_ws == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_ws == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_ws == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_ws == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_ws == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_ws == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg > 2) { ?>
        <tr>
            <td width="190">

                Techniek (inzet)

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_tn == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_tn == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_tn == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_tn == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center"><?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_tn == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?></td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_tn == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_tn == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_tn == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_tn == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_tn == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg > 4) { ?>
        <tr>
            <td width="190">

                Spreekbeurt

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_sb == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_sb == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_sb == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_sb == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_sb == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63" class="tussen">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_sb == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_sb == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_sb == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_sb == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_sb == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($reportlhg > 4) { ?>
        <tr>
            <td width="190">

                Verkeer (inzet)

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_vk == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_vk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_vk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_vk == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?></td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_vk == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_vk == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_vk == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_vk == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_vk == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_vk == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>

    <?php if ($reportlhg == 3 || $reportlhg == 4 || $reportlhg == 5) { ?>
        <tr>
            <td width="190">

                (Montessori) materiaalgebruik

            </td>

            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_mm == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_mm == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_mm == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_mm == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?></td>
            <td width="38" class="text-center">
                <?php if ($enabled1 === true) {
                    echo ($report_item->kosmi_mm == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="63">
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_mm == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_mm == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_mm == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_mm == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
            <td width="38" class="text-center">
                <?php if ($enabled === true) {
                    echo ($report_item_2->kosmi_mm == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
                } ?>
            </td>
        </tr>
    <?php } ?>


    <tr>
        <td>

            <strong>Verslag 1</strong>

        </td>
        <td colspan="11">
            <?php if ($enabled1 === true) {
                echo $report_item->kosmi_verslag;
            } ?>
        </td>
    </tr>
    <tr>
        <td>

            <strong>Verslag 2</strong>

        </td>
        <td colspan="11">
            <?php if ($enabled === true) {
                echo($report_item_2->kosmi_verslag);
            } ?>
        </td>
    </tr>
    </tbody>
</table>
<table border="1" cellpadding="0" cellspacing="0" class="table pink-table">
    <tbody>
    <tr>
        <th colspan="2">
            Creatieve ontwikkeling
        </th>
    </tr>

    <tr>
        <td width="190">

            <strong>Verslag 1</strong>

        </td>

        <td width="450">
            <?php if ($enabled1 === true) {
                echo $report_item->crea_verslag;
            } ?>
            <?php if ($enabled1 === true) { ?>
                <?php if ($report_item->uploaded_art != '' || $report_item->uploaded_art != NULL): ?>
                    <img align="right" src="<?= base_url($report_item->uploaded_art); ?>" width="200"
                         style="text-align:right !important;margin-top:15px;height:auto; width:200px;float:right;"/>
                <?php endif; ?>
            <?php } ?>


        </td>
    </tr>
    <tr>
        <td>

            <strong>Verslag 2</strong>

        </td>

        <td>
            <?php if ($enabled === true) { ?>
                <?php if ($report_item_2->uploaded_art != '' || $report_item_2->uploaded_art != NULL): ?>
                    <img src="<?= base_url($report_item_2->uploaded_art); ?>" width="200"
                         style="margin-left:15px;height:auto; width:200px;float:right;"/>
                <?php endif; ?>
            <?php } ?>
            <?php if ($enabled === true) {
                echo($report_item_2->crea_verslag);
            } ?>


        </td>
    </tr>
    </tbody>
</table>
<table border="1" cellpadding="0" cellspacing="0" class="table brown-table">
    <thead>
    <tr>
        <th colspan="12">
            Gymnastiek
        </th>
    </tr>
    <tr>
        <td width="190" class="tussen"></td>
        <td colspan="5" width="190">

            Verslag 1

        </td>

        <td width="63" class="tussen">
        </td>
        <td colspan="5" width="190">

            Verslag 2

        </td>

    </tr>
    <tr>
        <td width="190">

        </td>

        <td width="38" class="text-center">

            O

        </td>

        <td width="38" class="text-center">

            Z

        </td>

        <td width="38" class="text-center">

            V

        </td>

        <td width="38" class="text-center">

            RV

        </td>

        <td width="38" class="text-center">

            G

        </td>

        <td width="63" class="tussen">
        </td>
        <td width="38" class="text-center">

            O

        </td>

        <td width="38" class="text-center">

            Z

        </td>

        <td width="38" class="text-center">

            V

        </td>

        <td width="38" class="text-center">

            RV

        </td>

        <td width="38" class="text-center">

            G

        </td>

    </tr>
    </thead>

    <tbody>
    <tr>
        <td width="190">

            Inzet

        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->gym_in == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->gym_in == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->gym_in == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->gym_in == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->gym_in == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="63" class="tussen">
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->gym_in == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->gym_in == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->gym_in == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->gym_in == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->gym_in == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
    </tr>
    <tr>
        <td width="190">

            Sociale vaardigheden <em>(samenwerken, luisteren)</em>

        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->gym_sv == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->gym_sv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->gym_sv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->gym_sv == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->gym_sv == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="63" class="tussen">
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->gym_sv == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->gym_sv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->gym_sv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->gym_sv == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->gym_sv == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
    </tr>
    <tr>
        <td width="190">

            Motorische vaardigheden

        </td>

        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->gym_mv == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->gym_mv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->gym_mv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->gym_mv == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled1 === true) {
                echo ($report_item->gym_mv == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="63">
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->gym_mv == 1) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->gym_mv == 3) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->gym_mv == 6) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->gym_mv == 8) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
        <td width="38" class="text-center">
            <?php if ($enabled === true) {
                echo ($report_item_2->gym_mv == 10) ? '<img src="' . base_url() . 'assets/img/check.png" alt="&#x2713;"/>' : '';
            } ?>
        </td>
    </tr>


    <tr>
        <td>

            <strong>Verslag 1</strong>

        </td>
        <td colspan="11">            <?php if ($enabled1 === true) {
                echo $report_item->gym_verslag;
            } ?>
        </td>
    </tr>
    <tr>
        <td>

            <strong>Verslag 2</strong>

        </td>
        <td colspan="11">           <?php if ($enabled === true) {
                echo($report_item_2->gym_verslag);
            } ?>
        </td>
    </tr>
    </tbody>
</table>
<table border="1" cellpadding="0" cellspacing="0" class="table dgreen-table">
    <tbody>
    <tr>
        <th colspan="2">
            (Extra) Ondersteuning
        </th>
    </tr>
    <tr>
        <td width="190">

            <strong>Verslag 1</strong>

        </td>
        <td width="477">
            <?php if ($enabled1 === true) {
                echo $report_item->eo_verslag;
            } ?>
        </td>
    </tr>
    <tr>
        <td width="190">

            <strong>Verslag 2</strong>

        </td>
        <td width="477">
            <?php if ($enabled === true) {
                echo($report_item_2->eo_verslag);
            } ?>
        </td>
    </tr>
    </tbody>
</table>
<table border="1" cellpadding="0" cellspacing="0" class="table lblue-table">
    <tbody>
    <tr>
        <th colspan="2" valign="top">
            Overige opmerkingen
        </th>
    </tr>
    <tr>
        <td width="190">

            <strong>Verslag 1</strong>

        </td>

        <td width="477">
            <?php if ($enabled1 === true) {
                echo $report_item->oo_verslag;
            } ?>
        </td>
    </tr>
    <tr>
        <td width="190">

            <strong>Verslag 2</strong>

        </td>
        <td width="477">
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
        <th colspan="3">
            Handtekening
        </th>
    </tr>
    <tr>
        <td width="176">

        </td>

        <td width="238">

            Verslag 1

        </td>

        <td width="237">

            Verslag 2

        </td>

    </tr>
    <tr>
        <td width="190">

            <strong>Leid(st)er</strong>

        </td>

        <td>
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <td width="190">

            <strong>Directie</strong>
        </td>

        <td>
        </td>
        <td>
        </td>
    </tr>
    </tbody>
</table>