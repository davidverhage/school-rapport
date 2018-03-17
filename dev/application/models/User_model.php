<?php

class User_model extends CI_Model
{

    private $permission_change = false;

    function __construct()
    {
        parent::__construct();
    }

    public function show_all()
    {
        $query = "SELECT users_permissions.*, permissions.name AS rolnaam, permissions.id, users.*
        FROM users
        LEFT JOIN users_permissions ON users_permissions.user_id = users.id
        LEFT JOIN permissions ON  permissions.id = users_permissions.permission_id
		WHERE `active` = 1
        ";
        $results = $this->db->query($query);
        return $results->result();

    }

    public function show_by_id($id)
    {
        $query = "SELECT users_permissions.*, permissions.name AS rolnaam, permissions.id, users.*
        FROM users
        LEFT JOIN users_permissions ON users_permissions.user_id = users.id
        LEFT JOIN permissions ON  permissions.id = users_permissions.permission_id 
		WHERE users.id=$id
		AND `active` = 1";
        $results = $this->db->query($query);
        return $results->result();
    }

    public function get_all_classes()
    {
        return $this->db->get_where('tbl_classes', array('active' => '1'))->result();
    }

    public function add_user()
    {
        $data = $this->input->post();
        $fullname = $data['fullname'];
        $login = $data['email'];
        $email = $data['email'];
        $password = $data['password'];
        $active = true;
        $permissions = $data['rights'];
        $new_user_id = $this->user_manager->save_user($fullname, $login, $password, $email, $active, $permissions);
        return $new_user_id;

    }


    public function get_current_user()
    {
        return $this->db->get_where('users', array('id' => $this->user->get_id()))->result();
    }


    public function edit_user()
    {


        // Receives new user login information trough post
        $user_id = $this->input->post('user_id');
        $data = $this->input->post();
        $fullname = $data['fullname'];
        $login = $data['email'];
        $email = $data['email'];
        $password = $data['password'];
        $active = 1;
        $permissions = $data['rights'];
        // Updates the user access information
        $this->user_manager->update_user($fullname, $login, $email, $password, $active, $this->user->get_id());
        if (!$password) { // do nothing
        } else {
            $this->user_manager->update_pw($password, $this->user->get_id());
        }
        $this->user_manager->update_login($login, $this->user->get_id());
        $this->user_manager->update_permission($permissions, $this->user->get_id());

    }

    public function delete_user()
    {
    }

    public function update_profile_pic($user_id)
    {
        //show($user_id);
        if ($_FILES['avatar']['error'] == 0) {
            $relative_url = 'uploads/profiles/' . $this->upload->file_name;
            $profile_data['avatar'] = $relative_url;
        }
        $this->db->where('id', intval($user_id));
        $this->db->update('users', $profile_data);
    }

}