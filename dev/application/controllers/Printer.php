<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Printer extends MY_Controller
{

    function __constuct()
    {
        parent::__construct();
        $this->user->on_invalid_session('/');
    }

    public function index()
    {
        //$this->user->on_valid_session('/dashboard');
        //$this->user->on_valid_session('/dashboard');
        $data = [];
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

        /* Keep this in to seperate the two versions of reports in the report view page*/
        $enabled = false;
        /* end - setting of enablement; */
        $uri_table = 'tbl_g' . $this->uri->segment(4);
        $uri_table_id = $this->uri->segment(5);
        $uri_report_student_id = $this->uri->segment(3);
        $this->db->join('tbl_students ts', "$uri_table.tbl_student_id = ts.id");
        $report_items_1 = $this->db->get_where($uri_table, array("$uri_table.id" => $uri_table_id, 'verslag_versie' => 1))->result();
        $report_item = new stdClass();
        foreach ($report_items_1 as $r1):
            $data['report_item'] = $r1;
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
            $this->db->join('tbl_students ts', "$uri_table.tbl_student_id = ts.id");
            $report_items_2 = $this->db->get_where($uri_table, array("$uri_table.tbl_student_id" => $uri_report_student_id, 'verslag_versie' => 2))->result();
            $report_item_2 = new stdClass();
            foreach ($report_items_2 as $r2):
                $data['report_item_2'] = $r2;
            endforeach;
            //echo $this->db->last_query();
        }
//echo '<pre>'.var_dump($report_item_2).'</pre>';
        //load the view and saved it into $html variable
        $html = $this->load->view('sjabloon', $data, true);

        //this the the PDF filename that user will get to download
        $pdfFilePath = FCPATH . "doc/sjabloon.pdf";

        //load mPDF library
        $this->load->library('m_pdf');

        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        if ($this->m_pdf->pdf->Output($pdfFilePath, "F")) {

            $content = $this->load->view('sjabloon', null, true);
            $this->render($content);
        }

    }

    public function bulk($start = 1, $end = 1, $zip = false)
    {
        // Desired folder structure
        $structure = 'doc/' . date('dmyhis') . '/';

// To create the nested structure, the $recursive parameter
// to mkdir() must be specified.

        if (!mkdir($structure, 0777, true)) {
            die('Failed to create folders...');
        }

        $ids = array(1, 3, 16, 20, 34, 45);
        $this->db->where_in('id', $ids);
        $Qresult = $this->db->get('tbl_students')->result();
        $file_list = array();
        foreach ($Qresult as $r) {
            $file_list[] = $this->createPDF($structure, $r->Roepnaam) . ' ';
        }

        $this->zip->read_dir($structure, false);
        if ($this->zip->download('verslagen-' . date('M-Y') . '.zip')) {

            echo '<pre><code>' . print_r($nflist) . '</code></pre>';
            exit();
        }
    }


    function createPDF($s, $p, $i)
    {
        $directory = 'doc/';
        $filename = 'sjabloon';
        //$this->user->on_valid_session('/dashboard');
        $data = [];
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

        /* Keep this in to seperate the two versions of reports in the report view page*/
        $enabled = false;
        /* end - setting of enablement; */
        $uri_table = 'tbl_g' . $this->uri->segment(4);
        $uri_table_id = $this->uri->segment(5);
        $uri_report_student_id = $this->uri->segment(3);
        $this->db->join('tbl_students ts', "$uri_table.tbl_student_id = ts.id");
        $report_items_1 = $this->db->get_where($uri_table, array("$uri_table.id" => $uri_table_id, 'verslag_versie' => 1))->result();
        $report_item = new stdClass();
        foreach ($report_items_1 as $r1):
            $data['report_item'] = $r1;
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
            $this->db->join('tbl_students ts', "$uri_table.tbl_student_id = ts.id");
            $report_items_2 = $this->db->get_where($uri_table, array("$uri_table.tbl_student_id" => $uri_report_student_id, 'verslag_versie' => 2))->result();
            $report_item_2 = new stdClass();
            foreach ($report_items_2 as $r2):
                $data['report_item_2'] = $r2;
            endforeach;
            //echo $this->db->last_query();
        }
//echo '<pre>'.var_dump($report_item_2).'</pre>';

        //load the view and saved it into $html variable
        $html = $this->load->view('sjabloon', $data, true);

        //this the the PDF filename that user will get to download
        $pdfFilePath = $directory . $filename . ".pdf";

        //load mPDF library
        $this->load->library('m_pdf');

        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");

        //return $pdfFilePath;
    }


}
