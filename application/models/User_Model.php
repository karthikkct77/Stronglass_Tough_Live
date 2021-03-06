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
            $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode INNER JOIN proforma_invoice C on A.Proforma_Icode=C.Proforma_Icode WHERE B.Cutting_Status !='3'  GROUP by A.WO_Icode");
            return $query->result_array();
        } elseif ($role == 3) // Furnace
        {
            $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode INNER JOIN proforma_invoice C on A.Proforma_Icode=C.Proforma_Icode WHERE B.Cutting_Status in('2' ,'3') and  B.Furnace_Status !='3'  GROUP by A.WO_Icode");
            return $query->result_array();
        } elseif ($role == 4) // Dispatch
        {
            $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode INNER JOIN proforma_invoice C on A.Proforma_Icode=C.Proforma_Icode WHERE B.Furnace_Status in('2','3') and  B.Dispatch_Status !='3' GROUP by A.WO_Icode");
            return $query->result_array();
        }
        elseif ($role == '9')
        {
            $query = $this->db->query("SELECT * FROM work_order A INNER JOIN wo_processing B on A.WO_Icode=B.WO_Icode INNER JOIN proforma_invoice C on A.Proforma_Icode=C.Proforma_Icode WHERE B.Cutting_Status in('2' ,'3')  GROUP by A.WO_Icode");
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
        elseif ($role == 9) //Fabrication
        {
            $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_items B ON A.Proforma_Invoice_Item_Icode=B.Proforma_Invoice_Items_Icode 
                                        INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.Cutting_Status in('2' ,'3') AND A.WO_Icode='$wo_id' and B.Proforma_Special !='B'");
            return $query->result_array();
        }
    }

    /** Get Perticular sheet work order details */
    public function get_Sheet_Work_Order_Details($wo_id)
    {
        $role = $this->session->userdata['role'];
        if ($role == 2) //Cutting
        {
            $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_item_sheet B ON A.PI_Sheet_Item_Icode=B.pi_item_sheet_icode 
                                        INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.Cutting_Status !='3' AND A.WO_Icode='$wo_id'");
            return $query->result_array();
        } elseif ($role == 3) //Furnace
        {
            $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_item_sheet B ON A.PI_Sheet_Item_Icode=B.pi_item_sheet_icode 
                                       INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.Cutting_Status in('2' ,'3') and A.Furnace_Status !='3' AND A.WO_Icode='$wo_id'");
            return $query->result_array();
        } elseif ($role == 4) //Dispatch
        {
            $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_item_sheet B ON A.PI_Sheet_Item_Icode=B.pi_item_sheet_icode 
                                        INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.Furnace_Status in('2','3') and  A.Dispatch_Status !='3' AND A.WO_Icode='$wo_id'");
            return $query->result_array();
        }
        elseif ($role == 9) //Fabrication
        {
            $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_item_sheet B ON A.PI_Sheet_Item_Icode=B.pi_item_sheet_icode 
                                        INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.Cutting_Status in('2' ,'3') AND A.WO_Icode='$wo_id' and B.Proforma_Special !='B'");
            return $query->result_array();
        }
    }

    /** Get single work ordetr */
    public function get_Single_Work_Order($wo_id)
    {
        $query = $this->db->query("SELECT * FROM work_order A INNER JOIN proforma_invoice B ON A.Proforma_Icode=B.Proforma_Icode WHERE A.WO_Icode='$wo_id'");
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
        $query = $this->db->query("Select * from proforma_invoice A INNER JOIN  customer_master B on A.Proforma_Customer_Icode=B.Customer_Icode INNER  JOIN  st_user_details C on A.Proforma_Generated_By = C. User_Icode WHERE  PI_Confirm='0' ORDER by A.Proforma_Icode DESC");
        return $query->result_array();
    }
    public function get_All_Confirm_Invoice()
    {
        $query = $this->db->query("Select * from proforma_invoice A INNER JOIN  customer_master B on A.Proforma_Customer_Icode=B.Customer_Icode INNER  JOIN  st_user_details C on A.Proforma_Generated_By = C. User_Icode WHERE  PI_Confirm='1' ORDER by A.Proforma_Icode DESC");
        return $query->result_array();
    }
    // get pi create user details
    public function Get_User_Details($pi_icode)
    {
        $query = $this->db->query("Select * from proforma_invoice A INNER JOIN  customer_master B on A.Proforma_Customer_Icode=B.Customer_Icode INNER  JOIN  st_user_details C on A.Proforma_Generated_By =C. User_Icode WHERE  A.Proforma_Icode= '$pi_icode'");
        return $query->result_array();
    }

    //Get PI Check user details
    public function Get_Check_User_Details()
    {
        $user_icode =$this->session->userdata['userid'];
        $query = $this->db->query("Select * from st_user_details WHERE  User_Icode= '$user_icode'");
        return $query->result_array();
    }
    /** GEt WORK ORDER LIST */
    public function get_All_WO()
    {
//        $user_icode =$this->session->userdata['userid'];
        $query = $this->db->query("SELECT * FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                  INNER JOIN st_user_details C on A.WO_Created_By = C.User_Icode INNER JOIN  customer_master D on B.Proforma_Customer_Icode=D.Customer_Icode  WHERE  B.WO_Confirm= '1' and A.Bill_Status='0' ORDER by A.WO_Icode DESC ");
        return $query->result_array();
    }
    public function get_All_WO_Details()
    {

        $query = $this->db->query("Select * from proforma_invoice A INNER JOIN  customer_master B on A.Proforma_Customer_Icode=B.Customer_Icode 
                                   INNER  JOIN  st_user_details C on A.PI_Confirm_By =C. User_Icode WHERE  PI_Confirm='1' and WO_Confirm='0' ORDER by A.Proforma_Icode DESC");
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
        $query = $this->db->query("SELECT SUM(A.Proforma_Qty) as qty, SUM(A.Proforma_Area_SQMTR) as area,SUM(A.Proforma_Cutout) as cutout, SUM(A.Proforma_Holes) as holes, SUM(A.Proforma_Material_Cost) as rate FROM proforma_invoice_item_sheet A INNER JOIN material_master B on A.Proforma_Material_Icode=B.Material_Icode
                                  WHERE A.Proforma_Icode='$pi_id'");
        return $query->result_array();
    }
    //** Get Sheet Details */
    public function Get_Single_Sheet($pi_id)
    {

        $query = $this->db->query("SELECT * FROM proforma_invoice_sheet A INNER JOIN material_master B on A.Proforma_Material_Icode=B.Material_Icode WHERE A.Proforma_Icode='$pi_id'");
        return $query->result_array();
    }

    //** Update sheet Invoice history */
    public function Invoice_sheet_Update($pi_id)
    {
        $user_icode =$this->session->userdata['userid'];
        $query = $this->db->query("INSERT INTO pi_master_history (Proforma_Icode,Proforma_Number,Proforma_Date,Proforma_Customer_Icode,Proforma_Delivery_Address_Icode,Sub_Total,Insurance_Value,Transport,SGST_Value,CGST_Value,IGST_Value,GrossTotal_Value,Updated_By)
                                   SELECT Proforma_Icode,Proforma_Number,Proforma_Date,Proforma_Customer_Icode,Proforma_Delivery_Address_Icode,Sub_Total,Insurance_Value,Transport,SGST_Value,CGST_Value,IGST_Value,GrossTotal_Value,'$user_icode'
                                   FROM proforma_invoice WHERE Proforma_Icode='$pi_id' ");
        if($query)
        {
            $query_sheet = $this->db->query("INSERT INTO pi_sheet_history (pi_sheet_icode,Proforma_Icode ,Proforma_Material_Icode,No_Of_Sheet,Actual_Height,Actual_Width,Chargable_Height,Chargable_Width,Area,Rate,Total_Amount,updated_by)
                                   SELECT pi_sheet_icode,Proforma_Icode ,Proforma_Material_Icode,No_Of_Sheet,Actual_Height,Actual_Width,Chargable_Height,Chargable_Width,Area,Rate,Total_Amount,'$user_icode'
                                   FROM proforma_invoice_sheet WHERE Proforma_Icode='$pi_id' ");

            if($query_sheet)
            {
                $query_item = $this->db->query("INSERT INTO pi_item_sheet_history (pi_item_sheet_icode,pi_sheet_icode,Proforma_Icode,Proforma_Special,Proforma_Qty,Proforma_Cutout,Proforma_Holes,Proforma_Actual_Size_Width,Proforma_Actual_Size_Height,Proforma_Chargeable_Size_Width,Proforma_Chargeable_Size_Height,Proforma_Area_SQMTR,updated_by)
                                   SELECT pi_item_sheet_icode,pi_sheet_icode,Proforma_Icode,Proforma_Special,Proforma_Qty,Proforma_Cutout,Proforma_Holes,Proforma_Actual_Size_Width,Proforma_Actual_Size_Height,Proforma_Chargeable_Size_Width,Proforma_Chargeable_Size_Height,Proforma_Area_SQMTR,'$user_icode'
                                   FROM proforma_invoice_item_sheet WHERE Proforma_Icode='$pi_id' ");

                if($query_item)
                {
                    $query_charges = $this->db->query("INSERT INTO pi_charges_history (Proforma_Material_PC_Icode,Proforma_Icode,Proforma_Charge_Icode,Proforma_Charge_Count,Proforma_Charge_Value,Proforma_Charge_Cost,Updated_By)
                                   SELECT Proforma_Material_PC_Icode,Proforma_Icode,Proforma_Charge_Icode,Proforma_Charge_Count,Proforma_Charge_Value,Proforma_Charge_Cost,'$user_icode'
                                   FROM proforma_material_processing_charges WHERE Proforma_Icode='$pi_id' ");
                }
                if($query_charges)
                {
                    return 1;
                }
            }
        }
    }

    //** Getall print type */
    public function Get_Print_Type()
    {
        $query = $this->db->query("SELECT * FROM st_print_type");
        return $query->result_array();
    }
    //** Get Fabrication Details in Sheeted PI */
    public function Get_fabrication_Sheet($pi_icode)
    {
        $query = $this->db->query("SELECT * FROM proforma_invoice_item_sheet A INNER JOIN material_master B on A.Proforma_Material_Icode=B.Material_Icode WHERE A.Proforma_Special !='B' and A.Proforma_Icode='$pi_icode'");
        return $query->result_array();
    }
    //** Get Fabrication Details in PI */
    public function Get_fabrication($pi_icode)
    {
        $query = $this->db->query("SELECT * FROM proforma_invoice_items A INNER JOIN material_master B on A.Proforma_Material_Icode=B.Material_Icode WHERE A.Proforma_Special !='B' and A.Proforma_Icode='$pi_icode'");
        return $query->result_array();
    }

    //** Get un completed Work Order */
    public function Get_Not_Completed_WO()
    {
        $query = $this->db->query("SELECT * FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                      WHERE  A.WO_Completed = '0' ");
        return $query->result_array();
    }
    //** Get All Sheet */
    public function get_Sheet_Re_Cut_WO($wo_id)
    {
        $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_item_sheet B ON A.PI_Sheet_Item_Icode=B.pi_item_sheet_icode 
                                        INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.WO_Icode='$wo_id'");
        return $query->result_array();
    }
    //** Get All re cut */
    public function get_Re_Cut_WO($wo_id)
    {
        $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_items B ON A.Proforma_Invoice_Item_Icode=B.Proforma_Invoice_Items_Icode 
                                        INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE   A.WO_Icode='$wo_id'");
        return $query->result_array();
    }
    //** Insert Recut */
    public function Insert_Recut($data)
    {
        $this->db->insert('recut_item_details', $data);
        $insert_id = $this->db->insert_id();
        if($insert_id != '0')
        {
            return 1;
        }
        else{
            return 0;
        }
    }

    //** Get All Production Recut */
    public function get_Production_Recut()
    {
        $role = $this->session->userdata['role'];
        if ($role == 2) //Cutting
        {
            $query = $this->db->query("SELECT * FROM recut_item_details A INNER JOIN work_order B on A.Work_Order_Icode=B.WO_Icode INNER JOIN proforma_invoice_item_sheet C on A.Sheet_Item_Icode=C.pi_item_sheet_icode INNER JOIN material_master D on C.Proforma_Material_Icode=D.Material_Icode WHERE A.Cutting_Status='0'");
             $array1 = $query->result_array();
            $query1 = $this->db->query("SELECT * FROM recut_item_details A INNER JOIN work_order B on A.Work_Order_Icode=B.WO_Icode INNER JOIN proforma_invoice_items C on A.Item_Icode=C.Proforma_Invoice_Items_Icode INNER JOIN material_master D on C.Proforma_Material_Icode=D.Material_Icode WHERE A.Cutting_Status='0'");
            $array2 =  $query1->result_array();
            return array_merge($array1, $array2);
        } elseif ($role == 3) //Furnace
        {
            $query = $this->db->query("SELECT * FROM recut_item_details A INNER JOIN work_order B on A.Work_Order_Icode=B.WO_Icode INNER JOIN proforma_invoice_item_sheet C on A.Sheet_Item_Icode=C.pi_item_sheet_icode INNER JOIN material_master D on C.Proforma_Material_Icode=D.Material_Icode WHERE A.Cutting_Status='1' and A.Furnace_Status='0'");
            $array1 = $query->result_array();
            $query1 = $this->db->query("SELECT * FROM recut_item_details A INNER JOIN work_order B on A.Work_Order_Icode=B.WO_Icode INNER JOIN proforma_invoice_items C on A.Item_Icode=C.Proforma_Invoice_Items_Icode INNER JOIN material_master D on C.Proforma_Material_Icode=D.Material_Icode WHERE A.Cutting_Status='1' and A.Furnace_Status='0'");
            $array2 =  $query1->result_array();
            return array_merge($array1, $array2);
        } elseif ($role == 4) //Dispatch
        {
            $query = $this->db->query("SELECT * FROM recut_item_details A INNER JOIN work_order B on A.Work_Order_Icode=B.WO_Icode INNER JOIN proforma_invoice_item_sheet C on A.Sheet_Item_Icode=C.pi_item_sheet_icode INNER JOIN material_master D on C.Proforma_Material_Icode=D.Material_Icode WHERE A.Dispatch_Status='0' and A.Furnace_Status='1'");
            $array1 = $query->result_array();
            $query1 = $this->db->query("SELECT * FROM recut_item_details A INNER JOIN work_order B on A.Work_Order_Icode=B.WO_Icode INNER JOIN proforma_invoice_items C on A.Item_Icode=C.Proforma_Invoice_Items_Icode INNER JOIN material_master D on C.Proforma_Material_Icode=D.Material_Icode WHERE A.Dispatch_Status='0' and A.Furnace_Status='1'");
            $array2 =  $query1->result_array();
            return array_merge($array1, $array2);
        }
        elseif ($role == 9) //Fabrication
        {
            $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_item_sheet B ON A.PI_Sheet_Item_Icode=B.pi_item_sheet_icode 
                                        INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.Cutting_Status in('2' ,'3') AND A.WO_Icode='$wo_id' and B.Proforma_Special !='B'");
            return $query->result_array();
        }
    }

    //** Insert Recut History */
    public function Insert_Recut_History($data)
    {
        $this->db->insert('Recut_History', $data);
        $insert_id = $this->db->insert_id();
        if($insert_id != '0')
        {
            return 1;
        }
        else{
            return 0;
        }
    }

    //** Chennai Workorder  */
    public function get_all_chennai_wo()
    {

        $query = $this->db->query("SELECT  A.*,C.Customer_Company_Name, SUM(CASE WHEN D.Dispatch_Status ='3' THEN D.Total_Qty END ) AS total,(sum(D.Dispatch_Remaining_Qty) + sum(D.Cutting_Remaining_Qty)+sum(D.Furnace_Remaining_Qty)) as remaining
                                   FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                   INNER JOIN wo_processing D on A.WO_Icode=D.WO_Icode WHERE A.WO_Completed ='0' and C.Customer_City  LIKE '%chennai%'  GROUP BY A.WO_Icode  ");
        return $query->result_array();
    }

    //** Get All Kerala Workorder */
    public function get_all_kerala_wo()
    {

        $query = $this->db->query("SELECT  A.*,C.Customer_Company_Name, SUM(CASE WHEN D.Dispatch_Status ='3' THEN D.Total_Qty END ) AS total,(sum(D.Dispatch_Remaining_Qty) + sum(D.Cutting_Remaining_Qty)+sum(D.Furnace_Remaining_Qty)) as remaining
                                   FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                   INNER JOIN wo_processing D on A.WO_Icode=D.WO_Icode WHERE A.WO_Completed ='0' and C.Customer_State LIKE '%kerala%'  GROUP BY A.WO_Icode  ");
        return $query->result_array();
    }
    public function insert_msg($data)
    {
        $this->db->insert('st_message_details', $data);
        $insert_id = $this->db->insert_id();
        if($insert_id != '0')
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    //** get all message */
    public function get_all_chennai_message()
    {

        $query=$this->db->query("SELECT A.* FROM st_message_details A LEFT OUTER JOIN st_user_details B on A.User_Icode=B.User_Icode and A.Client_Icode=B.User_Icode WHERE A.client_type LIKE '%chennai%'  ORDER BY A.send_date Asc");
        return $query->result_array();
    }

    public function get_all_kerala_message()
    {

        $query=$this->db->query("SELECT A.* FROM st_message_details A LEFT OUTER JOIN st_user_details B on A.User_Icode=B.User_Icode and A.Client_Icode=B.User_Icode WHERE A.client_type LIKE '%kerala%' ORDER BY A.send_date Asc");
        return $query->result_array();
    }
    public function get_unread_count_chennai()
    {
        $query=$this->db->query("SELECT COUNT(Message_Icode) as msg FROM `st_message_details` WHERE Msg_Read = '0' and Client_Icode !='12' and client_type LIKE '%kerala'");
        return $query->result_array();
    }
    public function get_unread_count_kerala()
    {
        $query=$this->db->query("SELECT COUNT(Message_Icode) as msg FROM `st_message_details` WHERE Msg_Read = '0' and Client_Icode !='13' and client_type LIKE '%kerala'");
        return $query->result_array();
    }

    public function get_unread_count()
    {
        $query=$this->db->query("SELECT COUNT(Message_Icode) as msg FROM `st_message_details` WHERE Msg_Read = '0' and Client_Icode !='0' ");
        return $query->result_array();
    }

    //** get customer counts */
    public function get_customer_count($type)
    {
        $query=$this->db->query("SELECT COUNT(A.WO_Icode) as counts
                                   FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode WHERE A.WO_Completed ='0' and C.Customer_State LIKE '%$type%' ");
        return $query->result_array();
    }

    //** Get Workorder Processing */
    public function get_wo_process($process_id)
    {
        $query=$this->db->query("SELECT * FROM `wo_processing` WHERE WO_Process_Icode='$process_id' ");
        return $query->result_array();
    }

public function get_bill_wo()
    {
       
        $query = $this->db->query("SELECT * FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode WHERE B.WO_Confirm= '1' and A.Bill_Status='0' ORDER by A.WO_Icode DESC ");
        return $query->result_array();
    }
    public function Get_all_bill()
    {
       $query=$this->db->query("SELECT * FROM `Billing_Details` ORDER by Bill_Icode DESC LIMIT 1 ");
        if($query->num_rows() == 1)
        {
            return $query->result_array();
        }
        else{
            return 0;
        } 
    }
    public function get_work_order($pid)
    {
        $query = $this->db->query("SELECT * FROM work_order A INNER JOIN proforma_invoice B ON A.Proforma_Icode=B.Proforma_Icode WHERE B.Proforma_Icode='$pid'");
        return $query->result_array();
    }

     public function Insert_Billing($data)
    {
        $this->db->insert('billing_details', $data);
        return $this->db->insert_id();

    }

    public function get_all_bill_details()
    {
        $query = $this->db->query("SELECT A.*,B.*,D.Customer_Company_Name,C.Amt_Words,C.PI_Type FROM billing_details A INNER JOIN work_order B  on A.Wo_Icode=B.Wo_Icode INNER JOIN proforma_invoice C on B.Proforma_Icode=C.Proforma_Icode INNER JOIN customer_master D on C.Proforma_Customer_Icode=D.Customer_Icode order by Created_On DESC");

        return $query->result_array();
    }
    public function Insert_Billing_charges($data)
    {
        $this->db->insert('billing_charges_entry', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function Get_Bill_details($wo_id)
    {
        $query = $this->db->query("SELECT * FROM billing_details WHERE Wo_Icode='$wo_id'");
        return $query->result_array();
    }

    public function Get_Single_Bill_Charges($pi_id)
    {
        $query = $this->db->query("SELECT * FROM billing_charges_entry A INNER JOIN processing_charges_master B on A.Proforma_Charge_Icode=B.charge_icode WHERE A.bill_icode='$pi_id'");
        return $query->result_array();
    }

    public function Get_search_material($keyword) {
        $this->db->order_by('Material_Icode', 'ASC');
        $this->db->like("Material_Name", $keyword);
        return $this->db->get('material_master')->result_array();
    }
    public function get_single_material($id)
    {
        $query = $this->db->query("Select * from material_master WHERE Material_Icode ='$id'");
        return $query->result_array();
    }
    public function Get_Bill_Customer($bill_icode)
    {
        $query = $this->db->query("Select * from billing_details A INNER JOIN customer_master B on A.Customer_Address=B.Customer_Icode  WHERE bill_icode ='$bill_icode'");
        return $query->result_array();
    }

    public function Get_Bill_Reports($from,$to)
    {
        $query = $this->db->query(" SELECT A.*,B.*,D.Customer_Company_Name,C.Amt_Words,C.PI_Type FROM billing_details A INNER JOIN work_order B  on A.Wo_Icode=B.Wo_Icode
                                    INNER JOIN proforma_invoice C on B.Proforma_Icode=C.Proforma_Icode INNER JOIN customer_master D on C.Proforma_Customer_Icode=D.Customer_Icode 
                                    WHERE date(A.Created_On) >= '$from' and date(A.Created_On) <= '$to' ORDER  BY  A.Created_On ASC");

        return $query->result_array();
    }

    public function delete_bill_charges($charge_id)
    {
        $delete = $this->db->query("DELETE FROM billing_charges_entry WHERE bill_charge_icode='$charge_id' ");

    }

    //** get word order counts */
    public function Get_WO_Counts($from,$to)
    {
        $query = $this->db->query("SELECT COUNT(A.WO_Icode) as wo_count, SUM(B.GrossTotal_Value) as wo_amount FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode
                                    WHERE date(A.WO_Created_On) >= '$from' and date(A.WO_Created_On) <= '$to'"); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    public function Get_Today_normal_WO_details($from,$to)
    {

        $query = $this->db->query("SELECT A.WO_Number,A.Proforma_Number,A.Total_Qty,C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, B.GrossTotal_Value, GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness FROM work_order A 
                                   INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_items D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode  WHERE date(A.WO_Created_On) >= '$from' and date(A.WO_Created_On) <= '$to' GROUP by D.Proforma_Icode ORDER  by A.WO_Number Asc"); //GROUP by A.Stock_Icode
        return $query->result_array();

    }
    public function Get_Today_sheet_WO_details($from,$to)
    {

        $query = $this->db->query("SELECT A.WO_Number,A.Proforma_Number,A.Total_Qty,C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, B.GrossTotal_Value,GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness FROM work_order A 
                                   INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_item_sheet D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode  WHERE date(A.WO_Created_On) >= '$from' and date(A.WO_Created_On) <= '$to' GROUP by D.Proforma_Icode ORDER  by A.WO_Number Asc "); //GROUP by A.Stock_Icode
        return $query->result_array();

    }

    public function Get_Today_PI_Counts($from,$to)
    {
        $query = $this->db->query("SELECT count(Proforma_Icode) as pi_count, SUM(GrossTotal_Value) as pi_amount FROM proforma_invoice WHERE date(Proforma_Generated_On)>='$from' and date(Proforma_Generated_On) <= '$to' "); //GROUP by A.Stock_Icode
        return $query->result_array();

    }

    public function Get_Today_normal_PI_details($from,$to)
    {

        $query = $this->db->query("SELECT A.Proforma_Number,C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, A.GrossTotal_Value, sum(D.Proforma_Qty) as Total_Qty, GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness FROM  proforma_invoice A 
                                    INNER JOIN customer_master C on A.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_items D on A.Proforma_Icode=D.Proforma_Icode 
                                    INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode 
                                     WHERE date(A.Proforma_Generated_On) >= '$from' and date(A.Proforma_Generated_On) <= '$to' 
                                     GROUP by D.Proforma_Icode ORDER  by A.Proforma_Number Asc"); //GROUP by A.Stock_Icode
        return $query->result_array();

    }
    public function Get_Today_sheet_PI_details($from,$to)
    {

        $query = $this->db->query("SELECT A.Proforma_Number,C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, A.GrossTotal_Value, sum(D.Proforma_Qty) as Total_Qty, GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness FROM  proforma_invoice A 
                                    INNER JOIN customer_master C on A.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_item_sheet D on A.Proforma_Icode=D.Proforma_Icode 
                                    INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode 
                                     WHERE date(A.Proforma_Generated_On) >= '$from' and date(A.Proforma_Generated_On) <= '$to' 
                                     GROUP by D.Proforma_Icode ORDER  by A.Proforma_Number Asc "); //GROUP by A.Stock_Icode
        return $query->result_array();

    }

    //** Normal Material Details
    public function Get_Today_normal_WO_material($from,$to)
    {
         $query = $this->db->query("SELECT   DISTINCT(E.Material_Name),GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, SUM(D.Proforma_Qty) as Total_Qty, SUM(D.Proforma_Area_SQMTR) as area FROM work_order A  INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                    INNER JOIN proforma_invoice_items D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode  WHERE date(A.WO_Created_On) >= '$from' and date(A.WO_Created_On) <= '$to'  GROUP BY E.Material_Icode"); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    public function Get_Today_sheet_WO_material($from,$to)
    {
         $query = $this->db->query("SELECT   DISTINCT(E.Material_Name),GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, SUM(D.Proforma_Qty) as Total_Qty, SUM(D.Proforma_Area_SQMTR) as area FROM work_order A  INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                    INNER JOIN proforma_invoice_item_sheet D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode  WHERE date(A.WO_Created_On) >= '$from' and date(A.WO_Created_On) <= '$to'  GROUP BY E.Material_Icode"); //GROUP by A.Stock_Icode
        return $query->result_array();
    }








}