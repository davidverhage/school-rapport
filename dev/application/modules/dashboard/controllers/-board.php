<?php

class Dashboard extends App\MY_Controller
{
    protected $storage_drive;

    function __construct()
    {
        parent::__construct();
        $this->user->on_invalid_session('/');
        $this->load->library('email'); // load email library
        $this->load->model('student_model');
        $this->load->model('user_model');
        $this->load->library('pagination');
        $this->load->model('pagination_model');
        $this->load->model('Excel_model');
        $this->load->library('m_pdf');

        if (!is_dir(FCPATH . 'uploads/docs/' . $this->user->get_name() . '/')) {
            mkdir(FCPATH . 'uploads/docs/' . $this->user->get_name(), 0777, TRUE);
            $this->storage_drive = FCPATH . 'uploads/docs/' . $this->user->get_name() . '/';
            $user_name = "www-data";
            chown($this->storage_drive, $user_name);
            chmod("$this->storage_drive", 0755);
        } else {
            $this->storage_drive = FCPATH . 'uploads/docs/' . $this->user->get_name() . '/';
        }
    }

    //	$content = $this->load->view('dashboard/overview', null, true);
    //	$this->render($content);
    public function index()
    {
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        // get books list
        $userinfo = $this->user->user_data;
        if ($this->user->has_permission('leidsters')) {
            $data['students'] = $this->student_model->get_all_students_by_class($userinfo->klas);
            $data['documentdrive'] = $this->storage_drive;
            $content = $this->load->view('dashboard/dashboard_view', $data, true);
        }

        if ($this->user->has_permission('admin') || $this->user->has_permission('administratie')) {
            $data['klastype'] = $this->user_model->get_all_classes();
            $data['gebruikers'] = $this->user_model->show_all();
            $data['students'] = $this->student_model->get_all_students();
            $data['documentdrive'] = $this->storage_drive;
            $content = $this->load->view('dashboard/dashboard_view', $data, true);
        }

        if ($this->user->has_permission('special_g')) {
            $data['students'] = $this->student_model->get_all_students();
            $data['documentdrive'] = $this->storage_drive;
            $content = $this->load->view('dashboard/dashboard_view', $data, true);

        }
        if ($this->user->has_permission('special_c')) {
            $data['students'] = $this->student_model->get_all_students();
            $data['documentdrive'] = $this->storage_drive;
            $content = $this->load->view('dashboard/dashboard_view', $data, true);

        }

        $this->render($content);

    }

    function edit($id = null, $version = '1', $group = '1')
    {
        $result = $this->student_model->get_student_report($id, $group, $version, $group);
        if ($result->num_rows() > 0) {
            $data['students'] = $result;
            if ($group === 0 || $group === '0') {
                $content = $this->load->view('dashboard/verslagps', $data, true);
            } else {
                $content = $this->load->view('dashboard/verslag', $data, true);
            }
            $this->render($content);
        } else {
            $data = ['user_id' => $this->user->get_id(), 'tbl_student_id' => $id, 'verslag_versie' => $version];
            $db_group = 'tbl_g' . $group;
            if ($this->student_model->insert_student_report($db_group, $data)) {
                $page = base_url("dashboard/edit/{$id}/{$version}/{$group}");

                redirect($page, 'refresh');
            } else {
                die('Database disconnected');
            }
        }
    }

    function fatal_error_handler($buffer)
    {
        $error = error_get_last();
        if ($error['type'] == 1) {
            // type, message, file, line
            $newBuffer = '<html><header><title>Fatal Error </title></header>
                    <style>
                    .error_content{
                        background: ghostwhite;
                        vertical-align: middle;
                        margin:0 auto;
                        padding:10px;
                        width:50%;
                     }
                     .error_content label{color: red;font-family: Georgia;font-size: 16pt;font-style: italic;}
                     .error_content ul li{ background: none repeat scroll 0 0 FloralWhite;
                                border: 1px solid AliceBlue;
                                display: block;
                                font-family: monospace;
                                padding: 2%;
                                text-align: left;
                      }
                    </style>
                    <body style="text-align: center;">
                      <div class="error_content">
                          <label >Fatal Error </label>
                          <ul>
                            <li><b>Line</b> ' . $error['line'] . '</li>
                            <li><b>Message</b> ' . $error['message'] . '</li>
                            <li><b>File</b> ' . $error['file'] . '</li>
                          </ul>

                          <a href="javascript:history.back()"> Back </a>
                      </div>
                    </body></html>';

            return $newBuffer;

        }

        return $buffer;

    }

    function edit_user($id = null)
    {
        $data['klastype'] = $this->user_model->get_all_classes();
        $data['gebruikers'] = $this->user_model->show_by_id($id);
        $content = $this->load->view('user_crud/edit_user', $data, true);
        $this->render($content);

    }

    function buildusers()
    {
        $data['klastype'] = $this->user_model->get_all_classes();
        $content = $this->load->view('user_crud/create_user', $data, true);
        $this->render($content);
    }

    function create($id = null)
    {
        $data['students'] = $this->student_model->get_by_id($id);
        $content = $this->load->view('dashboard/index', $data, true);
        $this->render($content);
    }

    function create_students()
    {

        $content = $this->load->view('student_crud/create_student', true);
        $this->render($content);
    }

    function edit_students($id = null)
    {
        $data['students'] = $this->student_model->get_by_id($id);
        $content = $this->load->view('student_crud/edit_student', $data, true);
        $this->render($content);
    }


    function delete($id = null)
    {
        if ($id == null) {
            redirect('/');
        } else {
            $content = $this->load->view('dashboard/index', null, true);
            $this->render($content);
        }

    }

    function store($id, $group, $student_id)
    {
        $storage_table = 'tbl_g' . $group;
        if ($id == null) {
            redirect('/');
        } else {

            $data = $this->input->post();
            $this->db->where('tbl_student_id', $student_id);
            $this->db->where('id', $id);

            $this->db->set($data);
            $m = $this->db->update($storage_table, $data);

            if ($m) {
                $this->session->set_flashdata('storage_message',
                    'Opgeslagen. U kunt nu verder of terug naar uw <a href="/dashboard">overzicht</a>.');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('storage_message',
                    'Er is een fout opgetreden tijdens het opslaan. Controleer het document en probeer het opnieuw.');
                redirect($_SERVER['HTTP_REFERER']);
            }
            //echo $this->db->last_query();
        }

    }

    function preview($student_id, $group, $id)
    {
        $storage_table = 'tbl_g' . $group;
        if ($id == null || !intval($id) || $id = '') {
            redirect($_SERVER['HTTP_REFERER']);
        } else {

            $data = $this->input->post();
            $this->db->where('tbl_student_id', $student_id);
            $this->db->where('id', $id);

            $this->db->set($data);
            $m = $this->db->update($storage_table, $data);
            if ($m) {
                echo true;
            } else {
                echo false;
            }
            //echo $this->db->last_query();
        }

    }

    function voorbeeld()
    {
        /* get model data based on uri id */
        $content = $this->load->view('sjabloon', null, true);
        $this->render($content);
    }

    function newuser()
    {
        $msg = '';
        $keyID = $this->user_model->add_user();
        if ($keyID) {
            $data = $this->input->post();

            $updateStatus = null;
            if ($data['rights'] == 2) {
                $updateArray = array('klas' => $data['klas']);
                $this->db->where('id', $keyID);
                $updateStatus = $this->db->update('users', $updateArray);
            }

            if ($this->sendmail('Registratie gebruiker ' . $data['fullname'], $data)) {
                $msg = 'Gebruiker is aangemaakt en er is een mail verzonden.';
            } else {
                $msg = 'Gebruiker is aangemaakt maar het verzenden van een mail is mislukt.';
            }

        } else {
            $msg = 'Gebruiker kon niet aangemaakt worden. Probeer het opnieuw. Indien het probleem zich blijft voor doen, neem dan contact op met de systeembeheerder.';
        }

        $this->session->set_flashdata('created_user_message', $msg);
        redirect('/dashboard/buildusers');
    }

    private function sendmail($subject = 'Berichtgeving', $data)
    {
        $message = $this->load->view('templates/email', $data, true);
        $email = $data['email'];
        $password = $data['password'];
        $name = $data['fullname'];
        $config = array(
            'charset' => 'utf-8',
            'wordwrap' => true,
            'mailtype' => 'html'
        );
        $this->email->initialize($config);
        $this->email->from('elapsus.enms@gmail.com', 'Elapsus Mailer');
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }

    function multipdf()
    {
        //var_dump($this->input->post());
        $pdf_id_list = implode(", ", $this->input->post('id'));
        $selected_count = count($this->input->post('id'));
        //echo $selected_count;
        foreach ($this->input->post('id') as $student_id => $id_value) {
            $result = $this->db->get_where('tbl_students_xml', array('id' => $id_value));
            foreach ($result->result() as $student_data) {
                $report_id_table = 'tbl_g' . $student_data->lhg;
                $current_id = $student_data->id;
                $this->db->select('*');
                $this->db->from('tbl_students_xml AS ts');
                $this->db->join("$report_id_table", "$report_id_table.tbl_student_id = ts.id");
                $this->db->where('ts.id', $current_id);
                $results = $this->db->get();

                if ($results->num_rows()) {
                    $matchFouund = '';
                    $result = $this->db->query("SELECT * FROM $report_id_table WHERE verslag_versie = '1' AND tbl_student_id = $current_id");
                    $result2 = $this->db->query("SELECT * FROM $report_id_table WHERE verslag_versie = '2' AND tbl_student_id = $current_id");
                    if (!$result2->num_rows()) {
                        $matchFound = $result->id;
                    } else {
                        $matchFound = $result2->id;
                    }
                    $this->store_pdf($current_id, $student_data->lhg, $matchFound);
                }
            }
        }

        $file_path = $this->storage_drive;
        $files = scandir($file_path);

        $files_array = array();

        foreach ($files as $key => $file_name) {

            $file_name = trim($file_name);

            if ($file_name != '.' || $file_name != '..') {
                if ((is_file($file_path . $file_name))) {
                    array_push($files_array, $file_name);
                }
            }
        }

        $data['files'] = $files_array;

        $content = $this->load->view('dashboard/view_files', $data, true);
        $this->render($content);

    }

    function store_pdf($student_id, $lhg, $report_id, $download = false)
    {
        $filename = '';
        $directory = 'doc/';
        $report_table = 'tbl_g' . $lhg;
        $pdf_report_id = $report_id;
        $report_student_id = $student_id;
        $data['enabled'] = true;

        /*
        $this->db->select('*');
        $this->db->from($report_table);
        $this->db->where('tbl_student_id', $report_student_id);
        $this->db->join('tbl_students ts', "$report_student_id = ts.id");
        $this->db->where('verslag_versie', 1);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $data['report_item'] = new stdClass();
            foreach ($result->result() as $r1):
                $data['report_item'] = $r1;
                $tussen = '';
                if ($r1->Tussenvoegsel != '' || $r1->Tussenvoegsel != null) {
                    $tussen = ' ' . $r1->Tussenvoegsel;
                } else {
                    $tussen = '';
                }
                $filename = $r1->Roepnaam . $tussen . ' ' . $r1->Achternaam;
            endforeach;
        }

        $this->db->from($report_table);
        $this->db->where('tbl_student_id', $report_student_id);
        $this->db->where('verslag_versie', 2);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data['enabled'] = true;
            $this->db->select('*');
            $this->db->join('tbl_students ts', "$report_student_id = ts.id");
            $this->db->where('tbl_student_id', $report_student_id);
            $this->db->where('id', $pdf_report_id);
            $this->db->where('verslag_versie', 2);
            $result2 = $this->db->get($report_table);

            $data['report_item_2'] = new stdClass();
            foreach ($result2->result() as $r2):
                $data['report_item_2'] = $r2;
            endforeach;
        }
        */
        /* Keep this in to seperate the two versions of reports in the report view page*/
        $enabled = false;
        /* end - setting of enablement; */
        $uri_table = $report_table;
        $uri_table_id = $pdf_report_id;
        $uri_report_student_id = $report_student_id;
        $this->db->join('tbl_students_xml ts', "$uri_table.tbl_student_id = ts.id");
        $report_items_1 = $this->db->get_where($uri_table, array("$uri_table.id" => $uri_table_id, 'verslag_versie' => 1))->result();
        $data['report_item'] = new stdClass();
        foreach ($report_items_1 as $r1):
            $data['report_item'] = $r1;
        endforeach;

        $this->db->from($uri_table);
        $this->db->where('tbl_student_id', $uri_report_student_id);
        $this->db->where('verslag_versie', 2);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data['enabled'] = true;
            $uri_table = $report_table;
            $uri_table_id = $pdf_report_id;
            $uri_report_student_id = $report_student_id;
            $this->db->join('tbl_students_xml ts', "$uri_table.tbl_student_id = ts.id");
            $report_items_2 = $this->db->get_where($uri_table, array("$uri_table.tbl_student_id" => $uri_report_student_id, 'verslag_versie' => 2))->result();
            $data['report_item_2'] = new stdClass();
            foreach ($report_items_2 as $r2):
                $data['report_item_2'] = $r2;
            endforeach;

        }

        #get name and surname
        $this->db->where('tbl_students_xml.id', $report_student_id);
        $query = $this->db->get('tbl_students_xml');
        $row = $query->row();
        if (!empty($row->Tussenvoegsel)) {
            $t = ' ' . $row->Tussenvoegsel;
        }
        $data['fml'] = $row->Roepnaam . $t . ' ' . $row->Achternaam;

        $filename = $data['fml'];

        if ($lhg == '0') {
            $html = $this->load->view('sjabloonps', $data, true);
        } else {
            $html = $this->load->view('sjabloon', $data, true);
        }
        $pdfFilePath = $this->storage_drive . $filename . ".pdf";
        $stylesheet = file_get_contents('./assets/css/mpdfcss.css');
        $this->m_pdf->pdf->use_kwt = true;
        $this->m_pdf->pdf->WriteHTML($stylesheet, 1);

        $this->m_pdf->pdf->SetHTMLFooter('
            <table width="100%" class="table" style="vertical-align: bottom; font-size: 8pt; color: rgba(204, 204, 204, 0.49); font-weight: bold;"><tr>
            <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
            <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
            <td width="33%" style="text-align: right; ">Verslag:
             <span class="text-primary" style="color:#31a3dd;">' . $filename . '</span></td>
            </tr></table>
        ');
        $this->m_pdf->pdf->WriteHTML($html, 2);
        $outsourcePath = $this->m_pdf->pdf->Output($this->storage_drive . $filename . ".pdf", 'F');
        $this->m_pdf->pdf->Output($pdfFilePath, "F");
        if ($download == true) {
            if (file_exists($this->storage_drive . $filename . ".pdf")) {

                if (force_download($this->storage_drive . $filename . ".pdf", NULL)) {
                    redirect('/');
                }

            }
        }
        $this->session->set_flashdata('file_stored', 'Bestanden zijn opgeslagen in' . $this->storage_drive);
        redirect('/dashboard');
    }

    function download_zip()
    {

        $this->load->library('zip');
        $file_path = $this->storage_drive;
        $zip_file_name = $_POST['file_name'];
        $selected_files = $_POST['files'];
        foreach ($selected_files as $key => $file) {
            $this->zip->read_file($file_path . $file);
        }
        $this->zip->download($zip_file_name);
    }

    public function importexcel()
    {

        $this->load->model('excel_model');
        $this->load->library('csvimport');

        $data['addressbook'] = $this->excel_model->get_addressbook();
        $data['error'] = '';    //initialize image upload error array to empty

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';

        $this->load->library('upload', $config);


        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();

            $content = $this->load->view('dashboard/dashboard_view', $data, true);
            $this->render($content);
        } else {
            $file_data = $this->upload->data();
            $file_path = './uploads/' . $file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path, false, false, false, ';');
                foreach ($csv_array as $row) {
                    $insert_data = array(
                        'Roepnaam' => $row['Roepnaam'],
                        'Tussenvoegsel' => $row['Tussenvoegsel'],
                        'Achternaam' => $row['Achternaam'],
                        'Geboortedatum' => $row['Geboortedatum'],
                        'ghg' => $row['Groepsnaam huidige groepsindeling'],
                        'lhg' => $row['Leerjaar huidige groepsindeling'],
                    );
                    $this->excel_model->insert_csv($insert_data);
                }
                $this->session->set_flashdata('success', 'Csv Data Imported Succesfully');
                redirect(base_url() . '/dashboard');
                //echo "<pre>"; print_r($insert_data);
            } else
                $data['error'] = "Error occured";
            $content = $this->load->view('dashboard/dashboard_view', $data, true);
            $this->render($content);
        }
    }

    function edexImporter()
    {
        $mimes = ['application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/xml'];
        $uploaddir = FCPATH . 'uploads/';
        $uploadfile = $uploaddir . basename($_FILES['file']['name']);
        $reportStatus = "";
        if (!in_array($_FILES['file']['type'], $mimes)) {
            $data['errorxml'] = '
<h3>Fout: Het bestandstype komt niet overeen met een waardige XML bestand.</h3>
<p>Probeer het opnieuw of neem contact op met de beheerder.</p>
<a href="/">Vernieuw scherm</a>';
        } else {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                $xmlstring = file_get_contents($uploadfile);
                $actiefdata = ['actief ' => '0'];
                $this->db->update('tbl_students_xml', $actiefdata);
                $xmlObject = new SimpleXMLElement($xmlstring);
                $count = 1;
                $data = [];
                $reportStatus .= '<ol>';
                $schooljaar = $xmlObject->school->schooljaar;
                foreach ($xmlObject->leerlingen->leerling as $node) {
                    $data['id'] = null;
                    $studentKey = $node->attributes();   // returns an array
                    $groepKey = $node->groep->attributes();
                    if ($node->geslacht == 1) {
                        $geslacht = 'm';
                    } else {
                        $geslacht = 'v';
                    }
                    $vn = implode('', array_map(function ($v) {
                        return $v[0];
                    }, explode(' ', $node->voornamen)));
                    $reportStatus .= '<li>';
                    //echo $count++.']';
                    $reportStatus .= '<br/>Geslacht:' . $geslacht;
                    $reportStatus .= "<br/>roepnaam:" . $node->roepnaam;
                    $reportStatus .= "<br/>voorletters:" . $vn;
                    $reportStatus .= "<br/>voorvoegsel:" . $node->voornamen;
                    if ($node->voorvoegsel != null || $node->voorvoegsel != '') {
                        $reportStatus .= "<br/>tussenvoegsel:" . $node->voorvoegsel;
                    }
                    $reportStatus .= "<br/>achternaam:" . $node->achternaam;
                    $reportStatus .= '<br/>Geboortedatum:' . $node->geboortedatum;
                    $reportStatus .= '<br/>jaargroep:' . $node->jaargroep;
                    $reportStatus .= '<br/>studentKey:' . $studentKey;
                    $reportStatus .= '<br/>groepKey:' . $groepKey;
                    $reportStatus .= '</li>';
                    $tussenvoegsels = null;
                    if ($node->voorvoegsel != null || $node->voorvoegsel != '') {
                        $tussenvoegsels = $node->voorvoegsel;
                    } else {
                        $tussenvoegsels = null;
                    }
                    $data = [
                        "id" => $studentKey,
                        "Geslacht" => $geslacht,
                        "Voorletters" => $vn,
                        "Roepnaam" => $node->roepnaam,
                        "Tussenvoegsel" => $tussenvoegsels,
                        "Achternaam" => $node->achternaam,
                        "Geboortedatum" => $node->geboortedatum,
                        "lhg" => $node->jaargroep,
                        "groepkey" => $groepKey,
                        "actief" => 1,
                        "schooljaar" => $schooljaar];
                    if ($this->checkStudentID($data)) {
                        $reportStatus .= '<span style="background-color:green;">Inserted {' . $data['id'] . '}</span>';
                    } else {
                        $reportStatus .= '<span style="background-color:red;">Failed Inserting {' . $data['id'] . '}</span>';
                    }
                }

                foreach ($xmlObject->groepen->groep as $node) {
                    $groepkey = $node->attributes();   // returns an array
                    $groepData = [
                        'id' => $groepkey["key"],
                        'name' => $node->naam,
                        'active ' => '1'
                    ];
                    $count = $this->db->get_where('tbl_classes_xml', ['id' => $groepkey["key"]])->num_rows();
                    if ($count > 0) {
                        $this->db->where('id', $groepkey["key"]);
                        unset($groepData['id']);
                        if ($this->db->update('tbl_classes_xml', $groepData)) {
                            $reportStatus .= '<span style="background-color:green;">Inserted {' . $groepData['id'] . '}</span>';
                        } else {
                            $reportStatus .= '<span style="background-color:red;">Failed Inserting {' . $groepData['id'] . '}</span>';
                        }
                    } else {
                        if ($this->db->insert('tbl_classes_xml', $groepData)) {
                            $reportStatus .= '<span style="background-color:green;">Updated {' . $groepData['id'] . '}</span>';
                        } else {
                            $reportStatus .= '<span style="background-color:red;">Failed Updating {' . $groepData['id'] . '}</span>';
                        }
                    }
                }

                foreach ($xmlObject->leerkrachten->leerkracht as $node) {
                    $leerkrachtKey = $node->attributes();   // returns an array
                    $groepKey = $node->groepen->groep->attributes();
                    $Roepnaam = $node->roepnaam;
                    $Tussenvoegsel = $node->voorvoegsel;
                    $Achternaam = $node->achternaam;
                    $leerkrachtData = [
                        'id' => $leerkrachtKey["key"],
                        'Roepnaam' => $Roepnaam,
                        'Tussenvoegsel' => $Tussenvoegsel,
                        'Achternaam' => $Achternaam,
                        'groepkey' => $groepKey["key"]
                    ];
                    $count = $this->db->get_where('tbl_teachers', ['id' => $leerkrachtKey["key"]])->num_rows();
                    if ($count > 0) {
                        $this->db->where('id', $leerkrachtKey["key"]);
                        unset($leerkrachtData['id']);
                        if ($this->db->update('tbl_teachers', $leerkrachtData)) {
                            $reportStatus .= '<span style="background-color:green;">Updated {' . $leerkrachtData['id'] . '}</span>';
                        } else {
                            $reportStatus .= '<span style="background-color:red;">Failed Updating {' . $leerkrachtData['id'] . '}</span>';
                        }
                    } else {
                        if ($this->db->insert('tbl_teachers', $leerkrachtData)) {
                            $reportStatus .= '<span style="background-color:green;">Inserted {' . $leerkrachtData['id'] . '}</span>';
                        } else {
                            $reportStatus .= '<span style="background-color:red;">Failed Inserting {' . $leerkrachtData['id'] . '}</span>';
                        }
                    }
                }

                $reportStatus .= '</ol>';
                $reportStatus .= '<a href="/">Terug naar de dashboard</a>';
                $data['reportStatus'] = $reportStatus;
                $content = $this->load->view('dashboard/dashboard_xml_report', $data, true);
                $this->render($content);
            }
        }
    }

    function checkStudentID($data = [])
    {
        $collector = null; //emptying in case
        $query = null; //emptying in case
        $id = $data['id']; //getting from post value


        $query = $this->db->get_where('tbl_students_xml', ['id' => $id]);
        $count = $query->num_rows(); //counting result from query
        if ($count === 0) {
            $insert = $this->db->insert('tbl_students_xml', $data);
            if ($insert) {
                $collector = true;
            } else {
                $collector = false;
            }
        } else {
            $this->db->where('id', $id);
            unset($data['id']);
            $update = $this->db->update('tbl_students_xml', $data);
            if ($update) {
                $collector = true;
            } else {
                $collector = false;
            }
        }

        if ($collector == true) {
            return true;
        } else {
            return false;
        }
    }

    function storeImage()
    {
        $this->storage_drive = '';
        if (!is_dir(FCPATH . 'uploads/docs/' . $this->user->get_name() . '/images/')) {
            mkdir(FCPATH . 'uploads/docs/' . $this->user->get_name() . '/images/', 0777, TRUE);
            $this->storage_drive = FCPATH . 'uploads/docs/' . $this->user->get_name() . '/images/';
            $user_name = "www-data";
            chown($this->storage_drive, $user_name);
            chmod("$this->storage_drive", 0777);
        } else {
            $this->storage_drive = FCPATH . 'uploads/docs/' . $this->user->get_name() . '/images/';
        }

        $img = $_POST['file'];
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
        //$img = str_replace('data:image/png;base64,', '', $img);
        //$img = str_replace(' ', '+', $data);
        //$data = base64_decode($data);
        $file = uniqid() . '.png';
        $success = file_put_contents($this->storage_drive . $file, $data);
        print $success ? 'uploads/docs/' . $this->user->get_name() . '/images/' . $file : 'Unable to save the file.';
    }

    function removeImage($userID = null, $groupID = 99)
    {
        if ($userID !== null || $userID !== 0 || $userID !== '') {
            if ($groupID <= 9) {
                $data = ['uploaded_art' => NULL];
                $tbl = 'tbl_g' . $groupID;
                $this->db->where('tbl_student_id', $userID);
                if ($this->db->update($tbl, $data)) {
                    echo json_encode(['status' => 'success', 'message' => 'Image has been cleared.'], JSON_PRETTY_PRINT);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error removing image has failed.' . $this->db->last_query()], JSON_PRETTY_PRINT);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error removing image has failed. unknown:' . $groupID], JSON_PRETTY_PRINT);
            }
        }
    }

    function deferred()
    {

        $db = [
            "hostname" => "localhost",
            "username" => "admin",
            "password" => "admin",
            "database" => "cmfive",
            "driver" => "mysql"
        ];

        if ($_GET['action'] == "poll") {
            if (intval($_GET['id']) > 0 && intval($_GET['dt_modified']) > 0) {
                $dbh = new PDO($db['driver'] . ':host=' . $db['hostname'] . ';dbname=' . $db['database'], $db['username'], $db['password']);
                $sql = 'SELECT id,body,unix_timestamp(dt_modified) dt_modified from wiki_page where id=' . intval($_GET['id']) . ' AND unix_timestamp(dt_modified) > ' . intval($_GET['dt_modified']);
                $rows = [];
                foreach ($dbh->query($sql) as $row) {
                    $rows[] = $row;
                }
                $wrap = array('success' => $rows);
                print_r(json_encode($wrap));
            }
        } else if ($_GET['action'] == "save") {
            if (intval($_POST['id']) > 0 && !empty($_POST['body'])) {

                $dbh = new PDO($db['driver'] . ':host=' . $db['hostname'] . ';dbname=' . $db['database'], $db['username'], $db['password']);
                $sql = "update wiki_page set body='" . $_POST['body'] . "', dt_modified=now() where id=" . intval($_POST['id']);
                $dbh->query($sql);
                $sql = 'SELECT id,body,unix_timestamp(dt_modified) dt_modified from wiki_page where id=' . intval($_POST['id']);
                //$sql="select unix_timestamp() from wiki_page";
                $rows = [];
                foreach ($dbh->query($sql) as $row) {
                    $rows[] = $row;
                }
                if (count($rows) > 0) {
                    $wrap = array('success' => $rows[0]);
                    print_r(json_encode($wrap));
                }
            }

        } else if ($_GET['action'] == "test") {
            echo "Sample save form
                    <form method=\"POST\" action='?action=save'>
                    <input type='hidden' name='id' value='1' >
                    <textarea name='body' >this is it</textarea>
                    <input type='submit' id=\"savebutton\">
                    </form>
                    <a href='?action=poll&id=1&dt_modified=11' >Poll</a>";
        }

    }

    function logout()
    {
        $this->user->destroy_user('/');
    }
}