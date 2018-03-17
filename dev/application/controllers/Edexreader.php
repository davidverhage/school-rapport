<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set("display_errors", 1);

class Edexreader extends \App\MY_Controller
{

    function __constuct()
    {
        parent::__construct();

    }

    public function index()
    {

        //$xml = file_get_contents(FCPATH.'uploads/edexll.xml');
        $data['xmlTree'] = $this->synchDB('edexll.xml');
        $content = $this->load->view('edexlist', $data, true);

        $this->render($content);
        //exit('dave was hier');
    }

    private function synchDB($filename = null)
    {
        $array = $this->xml2array(@file_get_contents(FCPATH . 'uploads/' . $filename));
        return $array;
    }

    private function xml2array($xml)
    {
        $opened = [];
        $xml_parser = xml_parser_create();
        xml_parse_into_struct($xml_parser, $xml, $xmlarray);
        $array = [];
        $arrsize = sizeof($xmlarray);
        for ($j = 0; $j < $arrsize; $j++) {
            $val = $xmlarray[$j];
            switch ($val["type"]) {
                case "open":
                    $opened[$val["tag"]] = $array;
                    if (!empty($array)) unset($array);
                    break;
                case "complete":
                    $array[$val["tag"]][] = $val["value"];
                    break;
                case "close":
                    $opened[$val["tag"]] = $array;
                    $array = $opened;
                    break;
            }
        }
        return $array;
    }

    function getJSONEDEX()
    {
        echo $this->synchDB('edexll.xml');
    }
}