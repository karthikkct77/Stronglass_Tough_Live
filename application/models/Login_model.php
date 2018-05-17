<?php
class Login_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    //** check login */
    public function check_login($data)
    {
        $user_name = $data['user_name'];
        $password = $data['password'];
        $query= $this->db->query("SELECT * FROM st_admin  WHERE admin_name = '".$user_name."'  AND admin_password = '".$password."' "); // Admin side
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            $data = array(
                'userid' => $row->admin_icode,
                'user_name' => $row->admin_name,
                'role' => $row->Admin_Role,
                'validated' => true
            );
            $this->session->set_userdata($data);
            return 1;
        }
        else
        {
            $query= $this->db->query("SELECT * FROM st_user_details  WHERE User_Name = '".$user_name."'  AND Password = '".$password."' ");
            if($query->num_rows() == 1)
            {
                $row = $query->row();
                $data = array(
                    'userid' => $row->User_Icode,
                    'user_name' => $row->User_Name,
                    'role' => $row->Role_Icode,
                    'active' =>$row->User_Leave_Approval_Rights,
                    'gender' =>$row->User_Gender,
                    'validated' => true
                );
                $this->session->set_userdata($data);
                return 2;
            }
            else
            {
                return 0;
            }

        }

    }
}