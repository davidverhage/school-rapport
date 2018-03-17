<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 15-6-2016
 * Time: 0:55
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Harp_model extends CI_Model
{

    function add($data)
    {
        $data = [
            'Roepnaam' => $data['voornaam'],
            'Tussenvoegsel' => $data['tussenvoegsel'],
            'Achternaam' => $data['Achternaam'],
            'Geboortedatum' => $data['Geboortedatum'],
            'ghg' => $data['ghg'],
            'lhg' => $data['lhg'],
        ];
        $this->db->insert('tbl_students', $data);
    }

    function view()
    {
        $tbl = $this->db->get('tbl_students');
        return $tbl;
    }

    function edit($a)
    {
        $d = $this->db->get_where('tbl_students', array('id' => $a))->row();
        return $d;
    }

    function delete($a)
    {
        //$this->db->delete('tbl_students', array('id' => $a));
        return;
    }

    function update($data, $id)
    {
        $data = array(
            'Roepnaam' => $data['voornaam'],
            'Tussenvoegsel' => $data['tussenvoegsel'],
            'Achternaam' => $data['Achternaam'],
            'Geboortedatum' => $data['Geboortedatum'],
            'ghg' => $data['ghg'],
            'lhg' => $data['lhg'],
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_students', $data);
    }
}