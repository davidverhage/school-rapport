<?php

class Validate extends App\MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        // Receives the login data
        $login = $this->input->post('login');
        $password = $this->input->post('password');

        /*
         * Validates the user input
         * The user->login returns true on success or false on fail.
         * It also creates the user session.
        */
        if ($this->user->login($login, $password)) {
            // Success
            redirect('/dashboard');
        } else {
            // Oh, holdon sir.
            redirect('/');
        }
    }

    // Simple logout function
    function logout()
    {
        // Removes user session and redirects to login
        $this->user->destroy_user('login');
    }


}