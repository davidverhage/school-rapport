<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once FCPATH . 'php/elFinderConnector.class.php';
include_once FCPATH . 'php/elFinder.class.php';
include_once FCPATH . 'php/elFinderVolumeDriver.class.php';
include_once FCPATH . 'php/elFinderVolumeLocalFileSystem.class.php';

class Elfinder_lib
{
    public function __construct($opts)
    {
        $connector = new elFinderConnector(new elFinder($opts));
        $connector->run();
    }
}