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
        $role = $this->session->userdata['role'];
        if ($role == 2) // Cutting
        {
            $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode WHERE B.Cutting_Status !='3'  GROUP by A.WO_Icode");
            return $query->result_array();
        } elseif ($role == 3) // Furnace
        {
            $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode WHERE B.Cutting_Status in('2' ,'3') and  B.Furnace_Status !='3'  GROUP by A.WO_Icode");
            return $query->result_array();
        } elseif ($role == 4) // Dispatch
        {
            $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode WHERE B.Furnace_Status in('2','3') and  B.Dispatch_Status !='3' GROUP by A.WO_Icode");
            return $query->result_array();
        }

    }

    /** Get Perticular work order details */
    public function get_Work_Order_Details($wo_id)
    {
        $role = $this->session->userdata['role'];
        if ($role == 2) //Cutting
        {
            $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_items B ON A.Proforma_Invoice_Item_Icode=B.Proforma_Invoice_Items_Icode 
                                        INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.Cutting_Status !='3' AND A.WO_Icode='$wo_id'");
            return $query->result_array();
        } elseif ($role == 3) //Furnace
        {
            $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_items B ON A.Proforma_Invoice_Item_Icode=B.Proforma_Invoice_Items_Icode 
                                       INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.Cutting_Status in('2' ,'3') and A.Furnace_Status !='3' AND A.WO_Icode='$wo_id'");
            return $query->result_array();
        } elseif ($role == 4) //Dispatch
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

    /** Get All Invoice */
    public function get_All_Invoice()
    {
        $query = $this->db->query("Select * from proforma_invoice A INNER JOIN  customer_master B on A.Proforma_Customer_Icode=B.Customer_Icode INNER  JOIN  st_user_details C on A.Proforma_Generated_By =C. User_Icode WHERE  PI_Confirm='0'");
        return $query->result_array();
    }
    /** GEt WORK ORDER LIST */
    public function get_All_WO()
    {
        $user_icode =$this->session->userdata['userid'];
        $query = $this->db->query("SELECT * FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                  INNER JOIN st_user_details C on A.WO_Created_By = C.User_Icode  WHERE A.WO_Created_By='$user_icode' and B.WO_Confirm= '1'");
        return $query->result_array();
    }
    public function get_All_WO_Details()
    {

        $query = $this->db->query("Select * from proforma_invoice A INNER JOIN  customer_master B on A.Proforma_Customer_Icode=B.Customer_Icode 
                                   INNER  JOIN  st_user_details C on A.PI_Confirm_By =C. User_Icode WHERE  PI_Confirm='1' and WO_Confirm='0'");
        return $query->result_array();
    }
    public function Get_Single_wo($pi_icode)
    {
        $query = $this->db->query("SELECT * FROM work_order  WHERE Proforma_Icode= '$pi_icode'");
        return $query->result_array();
    }
    public function Approve_Work_Order($data)
    {
        $this->db->insert('wo_approve', $data);
        return 1;
    }

    //** Update Invoice history */
    public function Invoice_Update($pi_id)
    {
        $user_icode =$this->session->userdata['userid'];
        $query = $this->db->query("INSERT INTO pi_master_history (Proforma_Icode,Proforma_Number,Proforma_Date,Proforma_Customer_Icode,Proforma_Delivery_Address_Icode,Sub_Total,Insurance_Value,Transport,SGST_Value,CGST_Value,IGST_Value,GrossTotal_Value,Updated_By)
                                   SELECT Proforma_Icode,Proforma_Number,Proforma_Date,Proforma_Customer_Icode,Proforma_Delivery_Address_Icode,Sub_Total,Insurance_Value,Transport,SGST_Value,CGST_Value,IGST_Value,GrossTotal_Value,'$user_icode'
                                   FROM proforma_invoice WHERE Proforma_Icode='$pi_id' ");
        if($query)
        {
            $query_item = $this->db->query("INSERT INTO pi_item_history (Proforma_Invoice_Items_Icode,Proforma_Icode,Proforma_Date,Proforma_Material_Icode,Proforma_HSNCode,Proforma_Special,Proforma_Holes,Proforma_Qty,Proforma_Actual_Size_Width,Proforma_Actual_Size_Height,Proforma_Chargeable_Size_Width,Proforma_Chargeable_Size_Height,Proforma_Area_SQMTR,Proforma_Material_Rate,Proforma_Material_Cost,Updated_By)
                                   SELECT Proforma_Invoice_Items_Icode,Proforma_Icode,Proforma_Date,Proforma_Material_Icode,Proforma_HSNCode,Proforma_Special,Proforma_Holes,Proforma_Qty,Proforma_Actual_Size_Width,Proforma_Actual_Size_Height,Proforma_Chargeable_Size_Width,Proforma_Chargeable_Size_Height,Proforma_Area_SQMTR,Proforma_Material_Rate,Proforma_Material_Cost,'$user_icode'
                                   FROM proforma_invoice_items WHERE Proforma_Icode='$pi_id' ");
            if($query_item)
            {
                $query_charges = $this->db->query("INSERT INTO pi_charges_history (Proforma_Material_PC_Icode,Proforma_Icode,Proforma_Charge_Icode,Proforma_Charge_Count,Proforma_Charge_Value,Proforma_Charge_Cost,Updated_By)
                                   SELECT Proforma_Material_PC_Icode,Proforma_Icode,Proforma_Charge_Icode,Proforma_Charge_Count,Proforma_Charge_Value,Proforma_Charge_Cost,'$user_icode'
                                   FROM proforma_material_processing_charges WHERE Proforma_Icode='$pi_id' ");
                if($query_charges)
                {
                    return 1;
                }
            }
        }
    }

    //** Monthly PI */
    public function Monthly_PI($user_id)
    {
        $query=$this->db->query("SELECT  DATE_FORMAT(Proforma_Generated_On, '%d') as Date ,COUNT(*) as pi FROM `proforma_invoice`  WHERE Proforma_Generated_By ='$user_id'  and  MONTH(Proforma_Generated_On) = MONTH(CURRENT_DATE())
          AND YEAR(Proforma_Generated_On) = YEAR(CURRENT_DATE())  GROUP BY Date(Proforma_Generated_On)  ");
        return $query->result_array();
    }

    //** Invoice Received,Pending,Confirm Status */
    public function get_pi_confirm_status()
    { $user_id=$this->session->userdata['userid'];
        $query=$this->db->query("SELECT  DATE_FORMAT(Proforma_Generated_On, '%d') as Date ,COUNT(*) as pi FROM `proforma_invoice`  WHERE Proforma_Generated_By ='$user_id'  and  MONTH(Proforma_Generated_On) = MONTH(CURRENT_DATE())
          AND YEAR(Proforma_Generated_On) = YEAR(CURRENT_DATE())  GROUP BY Date(Proforma_Generated_On)  ");
        return $query->result_array();
    }

    //** Invoice Received,Pending,Confirm Status Confirm */
    public function Monthly_PI_Confirm()
    { $user_id=$this->session->userdata['userid'];
        $query=$this->db->query("SELECT  DATE_FORMAT(PI_Confirm_Date, '%d') as Date ,COUNT(*) as pi FROM `proforma_invoice`  WHERE PI_Confirm_By ='$user_id' and PI_Confirm='1'  and  MONTH(PI_Confirm_Date) = MONTH(CURRENT_DATE())
          AND YEAR(PI_Confirm_Date) = YEAR(CURRENT_DATE())  GROUP BY Date(PI_Confirm_Date)  ");
        return $query->result_array();
    }


}