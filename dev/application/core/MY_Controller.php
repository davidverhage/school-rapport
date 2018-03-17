<?php

namespace App;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends \MX_Controller
{
    protected $layout = 'default';
    protected $stylesheets = array(
        'bootstrap.min.css', 'jquery.spellchecker.css', 'jquery.fullPage.css', 'app.css'
    );
    protected $javascripts = array(
        'bootstrap.min.js', 'fabric.js', 'jquery.spellchecker.js', 'app.js'
    );
    protected $local_stylesheets = array();
    protected $local_javascripts = array();

    public function __construct()
    {
        parent::__construct();
        // Load the Library
        $this->load->library(array('user', 'user_manager'));
        $this->load->helper('url');
    }

    protected function render($content)
    {
        $view_data = array('content' => $content,
            'stylesheets' => $this->get_stylesheets(),
            'javascripts' => $this->get_javascripts()
        );
        $this->load->view($this->layout, $view_data);
    }

    protected function get_stylesheets()
    {
        return array_merge($this->stylesheets, $this->local_stylesheets);
    }

    protected function get_javascripts()
    {
        return array_merge($this->javascripts, $this->local_javascripts);
    }

}