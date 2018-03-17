<?php

class Profile extends App\MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->user->on_invalid_session('/');
        $this->load->model('student_model');
        $this->load->model('user_model');
        $this->load->library('pagination');
        $this->load->model('pagination_model');

    }

    //	$content = $this->load->view('dashboard/overview', null, true);
    //	$this->render($content);
    public function index()
    {
        $data['details'] = $this->user_model->get_current_user();
        $content = $this->load->view('users/profile', $data, true);
        $this->render($content);
    }

    public function change_profile_admin()
    {
        $postdata = $this->input->post();
        $current_user_id = $postdata['user_id'];
        $dataset = array();

        if ($postdata['name'] != '') {
            $dataset["name"] = $postdata['name'];
        }
        if ($postdata['email'] != '') {
            $dataset["email"] = $postdata['email'];
        }
        if ($postdata['login'] != '') {
            $dataset["login"] = $postdata['login'];
        }
        if ($postdata['password'] != '') {
            $dataset["password"] = $this->bcrypt->hash($postdata['password']);
        }

        $this->db->where('id', $current_user_id);
        $return = $this->db->update('users', $dataset);

        //$this->db->query($query);
        if ($return) {
            $this->session->set_flashdata('admin_feedback', 'Gebruiker gewijzigd. Er is een email verzonden.');
            redirect('/');
        }
    }

    public function change_profile()
    {
        $postdata = $this->input->post();
        $current_user_id = $this->user->get_id();
        $dataset = array();

        if ($postdata['name'] != '') {
            $dataset["name"] = $postdata['name'];
        }
        if ($postdata['email'] != '') {
            $dataset["email"] = $postdata['email'];
        }
        if ($postdata['login'] != '') {
            $dataset["login"] = $postdata['login'];
        }
        if ($postdata['password'] != '') {
            $dataset["password"] = $this->bcrypt->hash($postdata['password']);
        }

        $this->db->where('id', $current_user_id);
        $return = $this->db->update('users', $dataset);

        //$this->db->query($query);
        if ($return) {
            $this->session->set_flashdata('success_message', 'Uw gegevens zijn gewijzigd. Log opnieuw in.');
            redirect('/');
        }
    }

    public function edit_profilepic()
    {
//show($_FILES);
        if ($_FILES['avatar']['error'] == 0) {
//upload and update the file
            $config['upload_path'] = './uploads/profiles/'; // Location to save the image
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = false;
            $config['remove_spaces'] = true;
//$config['max_size'] = '100';// in KB // if required, remove the comment and give the size

            $this->load->library('upload', $config); //codeigniter default function

            if (!$this->upload->do_upload('avatar')) {
                redirect("/dashboard/profile/"); // redirect page if the load fails.
            } else {
//Image Resizing
                $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 200; // image re-size properties
                $config['height'] = 300; // image re-size properties

                $this->load->library('image_lib', $config); //codeigniter default function

                if (!$this->image_lib->resize()) {
                    redirect("/dashboard/profile/"); // redirect page if the resize fails.
                }

                $this->user_model->update_profile_pic($this->user->get_id());
                redirect("/dashboard/profile/");
            }
        } else {
//show an error to select a picture before clicking the update pic button
            redirect("/dashboard/profile/");
        }
    }

}