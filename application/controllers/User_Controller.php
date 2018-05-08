<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->user_name == "") {
            redirect('Login');
        }
        $this->load->helper('url');
        /***** LOADING HELPER TO AVOID PHP ERROR ****/
        $this->load->model('User_Model', 'user_model'); /* LOADING MODEL * User_Model as user_model */
        $this->load->library('session');
        $this->load->library('excel');
        $this->session->set_flashdata('message');
    }
}