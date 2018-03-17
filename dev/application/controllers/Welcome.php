<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends App\MY_Controller
{

    function __constuct()
    {
        parent::__construct();

    }

    public function index()
    {
        $this->user->on_valid_session('/dashboard');
        $content = $this->load->view('welcome_message', null, true);
        $this->render($content);
    }


}
