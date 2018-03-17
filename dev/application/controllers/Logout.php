<?php

class Logout extends App\MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->user->destroy_user('/');
    }
}