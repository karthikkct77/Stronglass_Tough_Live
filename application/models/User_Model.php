<?php
class User_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

    }
    /** Get All Work Order */
    public function get_all_Work_Order()
    {
       $role =  $this->session->userdata['role'];
       if($role == 2 )
       {
           $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode WHERE B.Cutting_Status !='4' and A.WO_Status ='0' GROUP by A.WO_Icode");
           return $query->result_array();
       }
       elseif ($role == 3)
       {
           $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode WHERE B.Furnace_Status !='4' and A.WO_Status ='0' GROUP by A.WO_Icode");
           return $query->result_array();
       }
       elseif ($role == 4)
       {
           $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode WHERE B.Dispatch_Status !='4' and A.WO_Status ='0' GROUP by A.WO_Icode");
           return $query->result_array();
       }

    }
    /** Get Perticular work order details */
    public function get_Work_Order_Details($wo_id)
    {
        $role =  $this->session->userdata['role'];
        if($role == 2 )
        {
            $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode WHERE B.Cutting_Status !='4' and A.WO_Status ='0' GROUP by A.WO_Icode");
            return $query->result_array();
        }
        elseif ($role == 3)
        {
            $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode WHERE B.Furnace_Status !='4' and A.WO_Status ='0' GROUP by A.WO_Icode");
            return $query->result_array();
        }
        elseif ($role == 4)
        {
            $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode WHERE B.Dispatch_Status !='4' and A.WO_Status ='0' GROUP by A.WO_Icode");
            return $query->result_array();
        }
    }
}