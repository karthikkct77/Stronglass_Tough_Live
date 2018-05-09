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
       if($role == 2 ) // Cutting
       {
           $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode WHERE B.Cutting_Status !='3' and A.WO_Status ='0' GROUP by A.WO_Icode");
           return $query->result_array();
       }
       elseif ($role == 3) // Furnace
       {
           $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode WHERE B.Cutting_Status in('2' ,'3') and  B.Furnace_Status !='3' and A.WO_Status ='0' GROUP by A.WO_Icode");
           return $query->result_array();
       }
       elseif ($role == 4) // Dispatch
       {
           $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode WHERE B.Furnace_Status in('2','3') and  B.Dispatch_Status !='3' and A.WO_Status ='0' GROUP by A.WO_Icode");
           return $query->result_array();
       }

    }
    /** Get Perticular work order details */
    public function get_Work_Order_Details($wo_id)
    {
        $role =  $this->session->userdata['role'];
        if($role == 2 ) //Cutting
        {
            $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_items B ON A.Proforma_Invoice_Item_Icode=B.Proforma_Invoice_Items_Icode 
                                        INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.Cutting_Status !='3' AND A.WO_Icode='$wo_id'");
            return $query->result_array();
        }
        elseif ($role == 3) //Furnace
        {
            $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_items B ON A.Proforma_Invoice_Item_Icode=B.Proforma_Invoice_Items_Icode 
                                       INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.Cutting_Status in('2' ,'3') and A.Furnace_Status !='3' AND A.WO_Icode='$wo_id'");
            return $query->result_array();
        }
        elseif ($role == 4) //Dispatch
        {
            $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_items B ON A.Proforma_Invoice_Item_Icode=B.Proforma_Invoice_Items_Icode 
                                        INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.Furnace_Status in('2','3') and  A.Dispatch_Status !='3' AND A.WO_Icode='$wo_id'");
            return $query->result_array();
        }
    }
    /** Get single work ordetr */
    public function get_Single_Work_Order($wo_id)
    {
        $query = $this->db->query("SELECT * FROM `work_order` WHERE WO_Icode='$wo_id'");
        return $query->result_array();
    }
    /** Insert cutting history */
    public function Insert_Cutting($data)
    {
        $this->db->insert('Cutting_History', $data);
        return 1;
    }
   /** Insert furnace */
    public function Insert_Furnace($data)
    {
        $this->db->insert('furnace_history', $data);
        return 1;
    }
    /** insert dispatch */
    public function Insert_Dispatch($data)
    {
        $this->db->insert('Dispatch_History', $data);
        return 1;
    }
    /** Word order all item success completed or not */
//    public function find_WO_Finished($wo_id)
//    {
//
//    }
}