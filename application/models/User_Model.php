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
        $query=$this->db->query("SELECT  DATE_FORMAT(PI_Confirm_Date, '%d') as Date ,COUNT(*) as Complete_pi FROM `proforma_invoice`  WHERE PI_Confirm_By ='$user_id' and PI_Confirm='1'  and  MONTH(PI_Confirm_Date) = MONTH(CURRENT_DATE())
          AND YEAR(PI_Confirm_Date) = YEAR(CURRENT_DATE())  GROUP BY Date(PI_Confirm_Date)  ");
        return $query->result_array();
    }
    //** Invoice Received,Pending,Confirm Status Confirm */
    public function Monthly_PI_Received()
    { $user_id=$this->session->userdata['userid'];
        $query=$this->db->query("SELECT  DATE_FORMAT(Proforma_Generated_On, '%d') as Date ,COUNT(*) as Received_pi FROM `proforma_invoice`  WHERE  PI_Confirm='0'  and  MONTH(Proforma_Generated_On) = MONTH(CURRENT_DATE())
          AND YEAR(Proforma_Generated_On) = YEAR(CURRENT_DATE())  GROUP BY Date(Proforma_Generated_On)  ");
        return $query->result_array();
    }
    // generated Wo
    public function Monthly_Wo_Generated()
    {
        $user_id=$this->session->userdata['userid'];
        $query=$this->db->query("SELECT  DATE_FORMAT(WO_Confirm_On, '%d') as Date ,COUNT(*) as Work_Order FROM `proforma_invoice`  WHERE WO_Confirm_By ='$user_id' and WO_Confirm='1'  and  MONTH(WO_Confirm_On) = MONTH(CURRENT_DATE())
          AND YEAR(WO_Confirm_On) = YEAR(CURRENT_DATE())  GROUP BY Date(WO_Confirm_On)  ");
        return $query->result_array();
    }

    // get today pi count
    public function get_today_pi_count()
    {
        $user_id=$this->session->userdata['userid'];
        $today=date('Y-m-d');
        $query=$this->db->query("SELECT COUNT(Proforma_Icode) as pi_count FROM proforma_invoice WHERE Proforma_Generated_By='$user_id' and date(Proforma_Generated_On)='$today'  ");
        return $query->result_array();

    }

    //** Get PI Check Todays */
    public function get_today_pi_check()
    {

        $query=$this->db->query("   SELECT 
                                COUNT(CASE WHEN Email_Send_Status = '1'  THEN 1 END) AS SendEmail,
                                COUNT(CASE WHEN Modified_Status = '1' AND Email_Send_Status = '0'   THEN 1 END) AS In_Review,
                                COUNT(CASE WHEN Modified_Status = '0' AND Email_Send_Status = '0'  THEN 1 END) AS Yet_to_review
                                FROM proforma_invoice WHERE WO_Confirm ='0' and PI_Confirm ='0'  ");
        return $query->result_array();
    }
    //** Today Generated WO  */
    public function get_today_WO_Generate()
    {
        $today=date('Y-m-d');
        $query=$this->db->query("  SELECT 
                                    COUNT(CASE WHEN PI_Confirm='1' and WO_Confirm='0'  THEN 1 END) AS Yet_to_generate,
                                    COUNT(CASE WHEN WO_Confirm='1' and date(WO_Confirm_On) ='$today' THEN 1 END) AS Generated
                                    FROM proforma_invoice   ");
        return $query->result_array();
    }
    //** Get Workorder Furnance */
    public function get_furnance_details($process_icode)
    {
        $query=$this->db->query("  SELECT  * from wo_processing WHERE WO_Process_Icode ='$process_icode' ");
        return $query->result_array();
    }

    //** Monthly Cutting */
    public function Cutting_Chart()
    {
        $user_id=$this->session->userdata['userid'];
        $query=$this->db->query("SELECT DATE_FORMAT(Created_On, '%d') as Date,SUM(Cutting_Qty) as cutting FROM `cutting_history` WHERE  Created_By='$user_id' and MONTH(Created_On) = MONTH(CURRENT_DATE())
          AND YEAR(Created_On) = YEAR(CURRENT_DATE())  GROUP BY Date(Created_On) ");
        return $query->result_array();
    }
    //** Monthly Furnace */
    public function Furnace_Chart()
    {
        $user_id=$this->session->userdata['userid'];
        $query=$this->db->query("SELECT DATE_FORMAT(Created_On, '%d') as Date,SUM(Furnace_qty) as furnace FROM `furnace_history` WHERE  Created_By='$user_id' and MONTH(Created_On) = MONTH(CURRENT_DATE())
          AND YEAR(Created_On) = YEAR(CURRENT_DATE())  GROUP BY Date(Created_On) ");
        return $query->result_array();
    }
    //** Monthly Dispatch */
    public function Dispatch_chart()
    {
        $user_id=$this->session->userdata['userid'];
        $query=$this->db->query("SELECT DATE_FORMAT(Created_On, '%d') as Date,SUM(Dispatch_Qty) as dispatch FROM `dispatch_history` WHERE  Created_By='$user_id' and MONTH(Created_On) = MONTH(CURRENT_DATE())
          AND YEAR(Created_On) = YEAR(CURRENT_DATE())  GROUP BY Date(Created_On)  ");
        return $query->result_array();
    }
    //** get material */
    public function get_material($id)
    {
        $query=$this->db->query("  SELECT  * from material_master WHERE Material_Icode ='$id' ");
        return $query->row_array(0);
    }
    //** Insert profoma sheet */
    public  function Insert_Profoma_Sheet($data)
    {
        $this->db->insert('proforma_invoice_sheet', $data);
        return 1;
    }
    //** item sheet */
    public function  Insert_Profoma_Item_sheet($data)
    {
        $this->db->insert('proforma_invoice_item_sheet', $data);
        return 1;
    }
    /** Get single Perfoma invoice single item sheet */
    public function Get_Single_Invoice_Item_Sheet($pi_id)
    {
        $query = $this->db->query("SELECT * FROM proforma_invoice_item_sheet A INNER JOIN material_master B on A.Proforma_Material_Icode=B.Material_Icode WHERE A.Proforma_Icode='$pi_id'");
        return $query->result_array();
    }
    /** Get Invoice Item Total */
    public function Get_Single_Invoice_Item_Sheet_Total($pi_id)
    {
        $query = $this->db->query("SELECT SUM(A.Proforma_Qty) as qty, SUM(A.Proforma_Area_SQMTR) as area,SUM(A.Proforma_Cutout) as cutout FROM proforma_invoice_item_sheet A INNER JOIN material_master B on A.Proforma_Material_Icode=B.Material_Icode
                                  WHERE A.Proforma_Icode='$pi_id'");
        return $query->result_array();
    }
    //** Get Sheet Details */
    public function Get_Single_Sheet($pi_id)
    {

        $query = $this->db->query("SELECT * FROM proforma_invoice_sheet A INNER JOIN material_master B on A.Proforma_Material_Icode=B.Material_Icode WHERE A.Proforma_Icode='$pi_id'");
        return $query->result_array();
    }



}