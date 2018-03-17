<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Api extends App\MY_Controller
{

    function __constuct()
    {
        parent::__construct();

        $this->user->on_invalid_session('/');
        $this->load->model('Harp_model');
        if (is_array($this->response->lang)) {
            $this->load->language('application', $this->response->lang[0]);
        } else {
            $this->load->language('application', $this->response->lang);
        }

    }

    public function index()
    {
        $this->user->on_invalid_session('/');
        redirect('/api/index_get');
    }

    public function index_get()
    {
        $this->user->on_invalid_session('/');
        echo json_encode($this->db->get('tbl_students')->result_array());
    }

    /**
     * linkUrl: /api/index_post/Firstname/Middle or Maidenname/Lastname/DateOfBirth/group/level
     * @param $Roepnaam
     * @param $Tussenvoegsel
     * @param $Achternaam
     * @param $Geboortedatum
     * @param $ghg
     * @param $lhg
     * @param bool|false $store
     */
    public function index_post($Roepnaam, $Tussenvoegsel, $Achternaam, $Geboortedatum, $ghg, $lhg, $store = false)
    {
        $this->user->on_invalid_session('/');
        $data = array(
            'Roepnaam' => $Roepnaam,
            'Tussenvoegsel' => $Tussenvoegsel,
            'Achternaam' => $Achternaam,
            'Geboortedatum' => $Geboortedatum,
            'ghg' => $ghg,
            'lhg' => $lhg
        );

        if ($store) {
            if (!$this->db->insert('tbl_students', $data)) {
                echo json_encode(array('ERROR' => '900', 'message' => 'Failed to store user data'));
            }
        }
        echo json_encode($data);
        $this->response($data, '201');// Send an HTTP 201 Created
    }

    /**
     * linkUrl: /api/index_update/id/firstname/middlename or maidenname/lastname/DateOfBirth/group/level/
     * @param $Roepnaam
     * @param $Tussenvoegsel
     * @param $Achternaam
     * @param $Geboortedatum
     * @param $ghg
     * @param $lhg
     * @param bool|false $store
     */
    public function index_update($id, $Roepnaam, $Tussenvoegsel, $Achternaam, $Geboortedatum, $ghg, $lhg)
    {
        $this->user->on_invalid_session('/');
        $data = array(
            'Roepnaam' => $Roepnaam,
            'Tussenvoegsel' => $Tussenvoegsel,
            'Achternaam' => $Achternaam,
            'Geboortedatum' => $Geboortedatum,
            'ghg' => $ghg,
            'lhg' => $lhg
        );

        $this->db->where('id', $id);
        if (!$this->db->update('tbl_students', $data)) {
            echo json_encode(array('ERROR' => '906', 'message' => 'Failed to update user data'));
        }
        echo json_encode($data);
        $this->response($data, '201');// Send an HTTP 201 Created
    }

    public function index_delete($id)
    {
        $this->user->on_invalid_session('/');
        $this->response([
            'returned from delete:' => $id,
        ]);
    }


}
