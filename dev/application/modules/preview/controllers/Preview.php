<?php

class Preview extends App\MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->user->on_invalid_session('/');
    }

    function index()
    {
        redirect('/');
    }

    function build()
    {
        if ($this->uri->segment(4) != 0) {
            $content = $this->load->view('sjabloon', null, true);
        } else { /* get model data based on uri id */
            $content = $this->load->view('sjabloonps', null, true);
        }
        $this->render($content);
    }

    // Simple logout function
    function logout()
    {
        // Removes user session and redirects to login
        $this->user->destroy_user('/');
    }
}