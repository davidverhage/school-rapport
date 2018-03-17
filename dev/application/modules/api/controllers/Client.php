<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 14-6-2016
 * Time: 23:51
 */

class Client extends \App\MY_Controller
{
// User's Login Credentials
    function __construct()
    {
        parent::__construct();
        $this->load->library('REST_Controller', array('server' => base_url(),
            'api_key' => 'REST API',
            'api_name' => 'X-API-KEY',
            'http_user' => 'admin',
            'http_pass' => '1234',
            'http_auth' => 'basic',
        ));
    }

// Client's Put Method
    function put($id = 0)
    {
        if ($id == 0) {
            $this->load->view('default_api');
        }
        $id = $this->uri->segment(3);
        $this->REST_Controller->format('application/json');
        $params = array(
            'id' => $id,
            'book_name' => $this->input->post('dname'),
            'book_price' => $this->input->post('dprice'),
            'book_author' => $this->input->post('dauthor')
        );
        $user = $this->REST_Controller->put('/api/data/' . $id, $params, '');
        $this->REST_Controller->debug();
    }

// Client's Post Method
    function post($id = 0)
    {
        if ($id == 0) {
            $this->load->view('default_api');
        }
        $this->REST_Controller->format('application/json');
        $params = $this->input->post(NULL, TRUE);
        $user = $this->REST_Controller->post('/api/data', $params, '');
        $this->REST_Controller->debug();
    }

// Client's Get Method
    function get($id = 0)
    {
        if ($id == 0) {
            $this->load->view('default_api');
        }
        $id = $this->uri->segment(3);
        $this->REST_Controller->format('application/json');
        $params = $this->input->get('id');
        $user = $this->REST_Controller->get('/api/data/' . $id, $params, '');
        $this->REST_Controller->debug();
    }

// Client's Delete Method
    function delete($id = 0)
    {
        if ($id == 0) {
            $this->load->view('default_api');
        }
        $id = $this->uri->segment(3);
        $this->REST_Controller->format('application/json');
        $user = $this->REST_Controller->delete('/api/data/' . $id, '', '');
        $this->REST_Controller->debug();
    }
}
