<?php

/**
 * Created by PhpStorm.
 * User: Four
 * Date: 4-2-2016
 * Time: 19:17
 */
class Student_model extends CI_Model
{

    public $title;
    public $content;
    public $date;

    private $tbl = 'tbl_students_xml';

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function get_last_ten_entries()
    {
        $query = $this->db->get($this->tbl, 10);
        return $query->result();
    }

    public function get_all_entries()
    {
        $query = $this->db->get($this->tbl, 10);
        return $query->result();
    }

    public function get_by_id($id)
    {
        $query = $this->db->get_where($this->tbl, array('id' => $id));
        return $query->result_array();
    }

    function get_students($limit, $start, $st = NULL)
    {
        if ($st == "NIL") $st = "";
        $sql = "select * from $this->tbl where ghg like '%$st%' limit " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_all_students()
    {
        $this->db->select('*, id as `StudentID`');
        $this->db->from($this->tbl);

        /*$sql = "select * from $this->tbl";*/
        $query = $this->db->get();
        return $query->result();
    }


    function get_all_students_by_class($class = null)
    {

        $this->db->select('*, tsx.id as `StudentID`');
        $this->db->from('tbl_students_xml tsx');
        $this->db->join('tbl_classes_xml tcx', 'tcx.id = tsx.groepkey');
        $this->db->where_in('tcx.name', $class);
        $query = $this->db->get();
        return $query->result();
        /*
        $mainQuery = "SELECT *, tsx.id as StudentID
                FROM tbl_students_xml tsx
                INNER JOIN tbl_classes_xml tcx
                ON tcx.id = tsx.groepkey
                WHERE tcx.name
                  IN($class);";
        $result = $this->db->query($mainQuery);
        return $result;
        */
    }

    /*
    function get_all_students_by_class($class = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_students_xml');
        $this->db->join('tbl_classes_xml tcx', 'tcx.id = tbl_students_xml.groepkey');
        $this->db->where_in('tcx.name', $class);
        $query = $this->db->get();
        return $query->result();
    }
    */

    /*	function get_all_students_by_class($class = '')
        {
            $sql = "select * from $this->tbl where ghg = '".$class."'";
            $query = $this->db->query($sql);
            return $query->result();
        }*/

    function get_student_count($st = NULL)
    {
        if ($st == "NIL") $st = "";
        $sql = "select * from $this->tbl where ghg like '%$st%'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function insert_student_report($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    function get_student_report($id, $find_table, $version, $group)
    {
        /*
         if($group === 0 || $group < 1 || $group ) {

        }
        */
        $find_table = 'tbl_g' . $find_table;
        $report_version = $version;
        $query = "SELECT *
		FROM tbl_students_xml
		LEFT JOIN $find_table ON $find_table.tbl_student_id = tbl_students_xml.id
		WHERE lhg = $group
			AND $find_table.tbl_student_id = $id
			AND $find_table.verslag_versie = $report_version
		LIMIT 0 , 30";
        $results = $this->db->query($query);
        return $results;
    }


    public function insert_entry()
    {
        $this->title = $_POST['title']; // please read the below note
        $this->content = $_POST['content'];
        $this->date = time();

        $this->db->insert('entries', $this);
    }

    public function update_entry()
    {
        $this->title = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

}