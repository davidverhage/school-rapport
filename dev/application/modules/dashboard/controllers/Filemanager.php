<?php

class Filemanager extends App\MY_Controller
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
            $content = $this->load->view('dashboard/fileviewer', $data, true);

        }

        if ($this->user->has_permission('admin') || $this->user->has_permission('administratie')) {
            $data['klastype'] = $this->user_model->get_all_classes();
            $data['gebruikers'] = $this->user_model->show_all();
            $data['students'] = $this->student_model->get_all_students();
            $data['documentdrive'] = $this->storage_drive;
            $content = $this->load->view('dashboard/fileviewer', $data, true);

        }

        if ($this->user->has_permission('special_g')) {
            $data['students'] = $this->student_model->get_all_students();
            $data['documentdrive'] = $this->storage_drive;
            $content = $this->load->view('dashboard/fileviewer', $data, true);

        }
        if ($this->user->has_permission('special_c')) {
            $data['students'] = $this->student_model->get_all_students();
            $data['documentdrive'] = $this->storage_drive;
            $content = $this->load->view('dashboard/fileviewer', $data, true);

        }

        $this->render($content);

    }

    function edit($id = null, $version = '1', $group = '1')
    {
        $find_table = 'tbl_g' . $group;
        $result = $this->student_model->get_student_report($id, $find_table, $version, $group);
        if ($result->num_rows() != 0) {
            $data['students'] = $result;
            $content = $this->load->view('dashboard/index', $data, true);
            $this->render($content);
        } else {
            $content = $this->load->view('loadingpage', null, true);
            $this->render($content);
            $data = array(
                'user_id' => $this->user->get_id(),
                'tbl_student_id' => $id,
                'verslag_versie' => $version
            );

            if ($this->student_model->insert_student_report($find_table, $data)) {
                $page = $_SERVER['PHP_SELF'];
                $sec = "3";
                header("Refresh: $sec; url=$page");
            }
        }
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
        echo true;
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
            $result = $this->db->get_where('tbl_students', array('id' => $id_value));
            foreach ($result->result() as $student_data) {
                $report_id_table = 'tbl_g' . $student_data->lhg;
                $current_id = $student_data->id;
                $this->db->select('*');
                $this->db->from('tbl_students AS ts');
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
        $data['enabled'] = false;

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

        $html = $this->load->view('sjabloon', $data, true);
        $pdfFilePath = $this->storage_drive . $filename . ".pdf";
        $stylesheet = file_get_contents('./assets/css/mpdfcss.css');
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

    function verslagbeheer()
    {
        $this->load->helper('path');
        $opts = array(
            'debug' => true,
            'roots' => array(
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => FCPATH . 'uploads/docs/' . $this->user->get_name(),
                    'URL' => site_url('uploads/docs/' . $this->user->get_name()) . '/'
                    // more elFinder options here
                )
            )
        );
        $this->load->library('elfinder_lib', $opts);
    }

    function logout()
    {
        $this->user->destroy_user('/');
    }
}