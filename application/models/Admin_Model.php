<?php
class Admin_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

    }

    //** insert item model */
    public function insert_item($data)
    {
        $this->db->insert('material_master', $data);
        return 1;
    }
    //** get all item */
    public function get_all_item()
    {
        $query = $this->db->query("Select * from material_master ");
        return $query->result_array();
    }

    //** Get perticular material */
    public function get_material($material_icode)
    {
        $query = $this->db->query("Select * from material_master WHERE Material_Icode = '$material_icode' ");
        return $query->result_array();

    }

    //** get all charges */
    public function get_all_charges()
    {
        $query = $this->db->query("Select * from processing_charges_master ");
        return $query->result_array();
    }

    //** Insert Material History */
    public function insert_material_history($data)
    {
        $this->db->insert('material_price_history', $data);
        return 1;
    }
    //** insert charges */
    public function insert_charges($data)
    {
        $this->db->insert('processing_charges_master', $data);
        return 1;

    }
    //** get perticular Cvharges */
    public function get_charges($id)
    {
        $query = $this->db->query("Select * from processing_charges_master WHERE charge_icode = '$id' ");
        return $query->result_array();
    }
    //** nsert charges history */
    public function insert_charges_history($data)
    {
        $this->db->insert('processing_charges_history', $data);
        return 1;
    }
    //** Get material Quantity */
    public function get_material_quantity($material_id)
    {
        $query = $this->db->query("Select * from material_inventory WHERE Material_Icode = '$material_id' ");
        return $query->result_array();
    }

    public function get_material_inventry($material_id)
    {
        $query = $this->db->query("Select * from material_inventory WHERE Material_Icode = '$material_id' ");
        return $query->num_rows();
    }

    /*insert Inventary*/
    public function insert_inventary($data){
        $this->db->insert('material_inventory', $data);
        return 1;
    }
    //* Insert inventry history*/
    public function insert_inventary_history($data)
    {
        $this->db->insert('material_inventory_inward_history', $data);
        return 1;
    }
    //** Get all inventaty */
    public function get_all_inventary()
    {
        $query = $this->db->query("Select * from material_inventory A INNER  JOIN  material_master B on A.Material_Icode = B.Material_Icode ");
        return $query->result_array();

    }

    /*Save Customer*/
    public function save_customer($data){
        $this->db->insert('customer_master', $data);
        return 1;
    }
    /** Gte all Customers */
    public function get_all_customers()
    {
        $query = $this->db->query("Select * from customer_master ");
        return $query->result_array();
    }
    /** Save customers */
    public function save_address($data)
    {
        $this->db->insert('customer_add_address', $data);
        return 1;
    }
    /** Save stronglass details */
    public function save_stronglass($data)
    {
        $this->db->insert('stronglasstough_details', $data);
        return 1;
    }

    /** Update stronglass details */
    public function update_stronglass($data,$id)
    {
        $this->db->where('ST_Icode',$id);
        $this->db->update('stronglasstough_details', $data);
        return 1;
    }
    /** save tat details */
    public function save_tax($data)
    {
        $this->db->insert('tax_details', $data);
        return 1;
    }

    /*Get Last inserted Tax*/
    public function get_last_Tax(){
        $query = $this->db->query("Select * from tax_details ORDER BY Tax_Icode DESC LIMIT 1");
        return $query->result_array();
    }
    //** Get Stronglass Details */
    public function get_ST()
    {
        $query = $this->db->query("Select * from stronglasstough_details ");
        return $query->result_array();
    }

    /*Get Tax */
    public function get_Tax(){
        $query = $this->db->query("Select * from tax_details ");
        return $query->result_array();
    }
    /** get customer details */
    public function get_customer_details($id)
    {
        $query = $this->db->query("Select * from customer_master WHERE Customer_Icode ='$id'");
        return $query->result_array();

    }
    public function get_Customer_Address_Details($id)
    {
        $query = $this->db->query("Select * from customer_add_address WHERE Customer_Icode ='$id'");
        return $query->result_array();

    }
    /** Get All Revised Items */
    public function get_all_Revised_item()
    {
        $query = $this->db->query("SELECT A.* FROM material_master A INNER JOIN material_price_history B ON A.Material_Icode=B.Material_Icode GROUP by A.Material_Icode ");
        return $query->result_array();
    }
    //** Get perticular revised material */
    public function get_revised_material($material_icode)
    {
        $query = $this->db->query("Select * from material_price_history WHERE Material_Icode = '$material_icode' ORDER BY Material_Price_Revised_Date DESC ");
        return $query->result_array();
    }
    //** Get Revice Charges History */
    public function get_all_Revised_Charges()
    {
        $query = $this->db->query("SELECT A.* FROM processing_charges_master A INNER JOIN processing_charges_history B on A.charge_icode=B.charge_icode GROUP by A.charge_icode");
        return $query->result_array();
    }
    /** get revised charges */
    public function get_revised_charges($id)
    {
        $query = $this->db->query("SELECT * FROM processing_charges_history WHERE charge_icode='$id' ORDER BY charge_revised_on DESC");
        return $query->result_array();
    }
    //** get date wise inventry */
    public function get_Date_inventary($from_date,$to_date)
    {
        $query = $this->db->query("SELECT SUM(A.Material_Quantity_Added) as Counts, B.Material_Name FROM material_inventory_inward_history A INNER JOIN material_master B on A.Material_ICode=B.Material_Icode
                                    WHERE  date(A.Material_Qty_Last_Added_Date) >= '$from_date' and date(A.Material_Qty_Last_Added_Date) <= '$to_date' GROUP by A.Material_ICode");
        return $query->result_array();
    }
    /** get material baed inventry histrory */
    public function get_material_inventary($from_date,$to_date,$material)
    {

        if(!empty($from_date))
        {
            $data1 = "date(A.Material_Qty_Last_Added_Date) >= '$from_date' AND";
        }else{
            $data1 = "";
        }
        if(!empty($to_date))
        {
            $data2 = "date(A.Material_Qty_Last_Added_Date) <= '$to_date' AND";
        }else{
            $data2 = "";
        }
        if(!empty($material))
        {
            $data3 = "A.Material_ICode = '$material' ";
        }else{
            $data3 = "";
        }
        $main_string = " $data1 $data2 $data3 "; //All details
        $stringAnd = "AND"; //And
        $main_string = trim($main_string); //Remove whitespaces from the beginning and end of the main string
        $endAnd = substr($main_string, -3); //Gets the AND at the end

        if($stringAnd == $endAnd)
        {
            $main_string = substr($main_string, 0, -3);
        }else if($main_string == "AND"){
            $main_string = "";
        }
        else{
            $main_string = " $data1 $data2 $data3 ";
        }

        if($main_string == ""){ //Doesn't show all the products

        }else
        {
            $query=$this->db->query("SELECT A.Material_Quantity_Added, A.Material_Qty_Last_Added_Date FROM material_inventory_inward_history A INNER JOIN material_master B on A.Material_ICode=B.Material_Icode 
                                   WHERE $main_string ");
            if ($res = $query->num_rows())
            {
                // echo $res;
                /* Check the number of rows that match the SELECT statement */
                if ($res > 0)
                {
                    // $query=$this->db->query("SELECT * FROM ibt_prospect_data WHERE Prospect_Status ='Cold' and Current_BDE_User_Code = '$id' and Prospect_DND = 'No' and Prospect_CNE='No' $main_string LIMIT 0,1");

                    $query=$this->db->query("SELECT A.Material_Quantity_Added, A.Material_Qty_Last_Added_Date FROM material_inventory_inward_history A INNER JOIN material_master B on A.Material_ICode=B.Material_Icode 
                                   WHERE $main_string");
                    // echo $this->db->last_query();
                    return $query->result_array();
                }    /* No rows matched -- do something else */
                else
                {
                    return 0;

                }
            }
        }
        $res = null;
    }

    /** get all Customers Details */
    public function get_all_Customer_details()
    {
        $query = $this->db->query("SELECT A.*, COUNT(B.Customer_Icode) as locations FROM customer_master A LEFT JOIN customer_add_address B on A.Customer_Icode=B.Customer_Icode GROUP By A.Customer_Icode");
        return $query->result_array();
    }
    /** Get Single Customers */
    public function get_single_Customer_details($id)
    {
        $query = $this->db->query("Select * from customer_master WHERE Customer_Icode = '$id' ");
        return $query->result_array();
    }
    /** Get customer Locations */
    public function get_location_details($id)
    {
        $query = $this->db->query("Select * from customer_add_address A INNER  JOIN customer_master B on A.Customer_Icode=B.Customer_Icode  WHERE A.Customer_Icode = '$id' ");
        return $query->result_array();
    }
    /** get single customer locations */
    public function get_single_Customer_Locations($id)
    {
        $query = $this->db->query("Select * from customer_add_address A INNER  JOIN customer_master B on A.Customer_Icode=B.Customer_Icode  WHERE A.Customer_Address_Icode = '$id' ");
        return $query->result_array();
    }

    /** Insert profoma invoice */
    public function Insert_Profoma_Invoice($data)
    {
        $this->db->insert('proforma_invoice', $data);
        return $this->db->insert_id();
    }
    /** Inseret profoma item */
    public function Insert_Profoma_Item($data)
    {
        $this->db->insert('proforma_invoice_items', $data);
        return 1;
    }
    /** Insert profoma charges */
    public function Insert_Profoma_Charges($data)
    {
        $this->db->insert('proforma_material_processing_charges', $data);
        return 1;
    }
    /** Get profoma number */
    public function get_profoma_number($month)
    {
        $query= $this->db->query("SELECT Proforma_Number FROM `proforma_invoice` WHERE `Proforma_Number` LIKE '%$month%' ORDER by Proforma_Icode DESC LIMIT 1  ");
        if($query->num_rows() == 1)
        {
            return $query->result_array();
        }
        else{
            return 0;
        }
    }
    /** Get customer Address */
    public function get_Customer_Address($id)
    {
        $query = $this->db->query("Select * from customer_add_address WHERE Customer_Icode = '$id' ");
        return $query->result_array();
    }
    /** Get All Invoice */
    public function get_All_Invoice()
    {
        $user_icode =$this->session->userdata['userid'];
        $query = $this->db->query("Select * from proforma_invoice A INNER JOIN  customer_master B on A.Proforma_Customer_Icode=B.Customer_Icode
                                   WHERE  A.PI_Confirm='0' and A.Proforma_Generated_By ='$user_icode'  ");
        return $query->result_array();
    }

    public function Get_All_Material($keyword) {
        $this->db->order_by('Material_Icode', 'Asc');
        $this->db->like("Material_Name", $keyword);
        return $this->db->get('material_master')->result_array();
    }
    /*Get Company Name*/
    public function GetRow($keyword) {
        $this->db->order_by('Customer_Icode', 'DESC');
        $this->db->like("Customer_Company_Name", $keyword);
        return $this->db->get('customer_master')->result_array();
    }
    /** Get Single Invoice */
    public function Get_Single_Invoice($pi_id)
    {
        $query = $this->db->query("SELECT C.*,A.*,B.*,B.Customer_Icode as consignee FROM proforma_invoice A INNER JOIN customer_master B on A.Proforma_Customer_Icode=B.Customer_Icode 
                                   LEFT JOIN customer_add_address C ON A.Proforma_Delivery_Address_Icode=C.Customer_Icode WHERE A.Proforma_Icode='$pi_id'");
        return $query->result_array();
    }
    /** Get single Perfoma invoice single item */
    public function Get_Single_Invoice_Item($pi_id)
    {
        $query = $this->db->query("SELECT * FROM proforma_invoice_items A INNER JOIN material_master B on A.Proforma_Material_Icode=B.Material_Icode WHERE A.Proforma_Icode='$pi_id'");
        return $query->result_array();
    }
    public function Get_Single_Sheet_Invoice_Item($pi_id)
    {
        $query = $this->db->query("SELECT * FROM proforma_invoice_item_sheet A INNER JOIN material_master B on A.Proforma_Material_Icode=B.Material_Icode WHERE A.Proforma_Icode='$pi_id'");
        return $query->result_array();
    }

    /** Get Sheet Details */
    public function Get_Sheet_Details($pi_id)
    {
        $query = $this->db->query("SELECT * FROM proforma_invoice_sheet A INNER JOIN material_master B on A.Proforma_Material_Icode=B.Material_Icode WHERE A.Proforma_Icode='$pi_id'");
        return $query->result_array();
    }
    /** Get single invoice charges */
    public function Get_Single_Invoice_Charges($pi_id)
    {
        $query = $this->db->query("SELECT * FROM proforma_material_processing_charges A INNER JOIN processing_charges_master B on A.Proforma_Charge_Icode=B.charge_icode WHERE A.Proforma_Icode='$pi_id'");
        return $query->result_array();
    }
    /** Get Invoice Item Total */
    public function Get_Single_Invoice_Item_Total($pi_id)
    {
        $query = $this->db->query("SELECT SUM(A.Proforma_Qty) as qty, SUM(A.Proforma_Area_SQMTR) as area, SUM(A.Proforma_Material_Cost) as rate,SUM(A.Proforma_Holes) as holes,SUM(A.Proforma_Cutout) as cutout FROM proforma_invoice_items A INNER JOIN material_master B on A.Proforma_Material_Icode=B.Material_Icode
                                  WHERE A.Proforma_Icode='$pi_id'");
        return $query->result_array();
    }
    /** Get Work Order number */
    public function get_WO_number($month)
    {
        $query= $this->db->query("SELECT WO_Number FROM work_order WHERE `WO_Number` LIKE '%$month%' ORDER by WO_Icode DESC LIMIT 1  ");
        if($query->num_rows() == 1)
        {
            return $query->result_array();
        }
        else{
            return 0;
        }
    }
    /** Insert Work Order */
    public function Insert_WO($data)
    {
        $this->db->insert('work_order', $data);
        return $this->db->insert_id();
    }
    public function Insert_WO_Process($data)
    {
        $this->db->insert('WO_Processing', $data);
        return 1;
    }
    /** Get all work order */
    public function get_all_work_order()
    {
        $query = $this->db->query("SELECT * FROM work_order");
        return $query->result_array();
    }
    public  function  Get_Work_Order($id)
    {
        $query = $this->db->query("SELECT * FROM work_order WHERE  Proforma_Icode='$id'");
        return $query->result_array();
    }
    public function get_Work_Order_Details($id)
    {
        $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_items B ON A.Proforma_Invoice_Item_Icode=B.Proforma_Invoice_Items_Icode 
                                        INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.WO_Icode='$id'");
        return $query->result_array();
    }
    /** Get single work ordetr */
    public function get_Single_Work_Order($wo_id)
    {
        $query = $this->db->query("SELECT * FROM `work_order` WHERE WO_Icode='$wo_id'");
        return $query->result_array();
    }
    /** Get Invoice item */
    public function get_invoice_item($pi)
    {
        $query = $this->db->query("SELECT * FROM `proforma_invoice_items` WHERE Proforma_Icode='$pi'");
        return $query->result_array();
    }
    /** Get all work order with in 8Hr */
    public function get_all_work_order_within8()
    {
//        $query = $this->db->query("SELECT  A.*,C.Customer_Company_Name FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode
//                                   WHERE now() <= DATE_ADD(A.WO_Created_On, INTERVAL 48 HOUR) and now() >= DATE_ADD(A.WO_Created_On, INTERVAL 24 HOUR) ");
        $query = $this->db->query("SELECT  A.*,C.Customer_Company_Name, SUM(CASE WHEN D.Dispatch_Status ='3' THEN D.Total_Qty END ) AS total,(sum(D.Dispatch_Remaining_Qty) + sum(D.Cutting_Remaining_Qty)+sum(D.Furnace_Remaining_Qty)) as remaining
                                   FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                   INNER JOIN wo_processing D on A.WO_Icode=D.WO_Icode WHERE now() <= DATE_ADD(A.WO_Created_On, INTERVAL 48 HOUR) and now() >= DATE_ADD(A.WO_Created_On, INTERVAL 24 HOUR) and A.WO_Completed ='0' GROUP BY A.WO_Icode ");

        return $query->result_array();
    }
    /** Get all work order with in 16Hr */
    public function get_all_work_order_within16()
    {
//        $query = $this->db->query("SELECT  A.*,C.Customer_Company_Name, sum(D.Total_Qty)as total, sum(D.Dispatch_Remaining_Qty) as remaining FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode INNER JOIN wo_processing D on A.WO_Icode=D.WO_Icode
//                                   WHERE now() >= DATE_ADD(A.WO_Created_On, INTERVAL 16 HOUR) and now() <= DATE_ADD(A.WO_Created_On, INTERVAL 24 HOUR) and D.Dispatch_Status='3'");

        $query = $this->db->query("SELECT  A.*,C.Customer_Company_Name, SUM(CASE WHEN D.Dispatch_Status ='3' THEN D.Total_Qty END ) AS total,(sum(D.Dispatch_Remaining_Qty) + sum(D.Cutting_Remaining_Qty)+sum(D.Furnace_Remaining_Qty)) as remaining
                                   FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                   INNER JOIN wo_processing D on A.WO_Icode=D.WO_Icode WHERE now() >= DATE_ADD(A.WO_Created_On, INTERVAL 16 HOUR) and now() <= DATE_ADD(A.WO_Created_On, INTERVAL 24 HOUR) and A.WO_Completed ='0' GROUP BY A.WO_Icode ");
        return $query->result_array();
    }
    /** Get all work order with in 16Hr to 24 hr */
    public function get_all_work_order_within24()
    {
//        $query = $this->db->query("SELECT  A.*,C.Customer_Company_Name FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode
//                                   WHERE now() >= DATE_ADD(A.WO_Created_On, INTERVAL 8 HOUR) and now() <= DATE_ADD(A.WO_Created_On, INTERVAL 16 HOUR)");

        $query = $this->db->query("SELECT  A.*,C.Customer_Company_Name, SUM(CASE WHEN D.Dispatch_Status ='3' THEN D.Total_Qty END ) AS total,(sum(D.Dispatch_Remaining_Qty) + sum(D.Cutting_Remaining_Qty)+sum(D.Furnace_Remaining_Qty)) as remaining
                                   FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                   INNER JOIN wo_processing D on A.WO_Icode=D.WO_Icode WHERE now() >= DATE_ADD(A.WO_Created_On, INTERVAL 8 HOUR) and now() <= DATE_ADD(A.WO_Created_On, INTERVAL 16 HOUR) and A.WO_Completed ='0' GROUP BY A.WO_Icode ");
        return $query->result_array();
    }
    /** Get all work order with in 24Hr to 48 hr */
    public function get_all_work_order_within48()
    {
//        $query = $this->db->query("SELECT  A.*,C.Customer_Company_Name FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode
//                                   WHERE now() <= DATE_ADD(A.WO_Created_On, INTERVAL 8 HOUR) ");

        $query = $this->db->query("SELECT  A.*,C.Customer_Company_Name, SUM(CASE WHEN D.Dispatch_Status ='3' THEN D.Total_Qty END ) AS total,(sum(D.Dispatch_Remaining_Qty) + sum(D.Cutting_Remaining_Qty)+sum(D.Furnace_Remaining_Qty)) as remaining
                                   FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                   INNER JOIN wo_processing D on A.WO_Icode=D.WO_Icode WHERE now() <= DATE_ADD(A.WO_Created_On, INTERVAL 8 HOUR) and A.WO_Completed ='0' GROUP BY A.WO_Icode ");
        return $query->result_array();
    }
    /** Get all work order Delay */
    public function get_all_work_order_delay()
    {
//        $query = $this->db->query("SELECT  A.*,C.Customer_Company_Name FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode
//                                   WHERE now() >= DATE_ADD(A.WO_Created_On, INTERVAL 48 HOUR) ");
        $query = $this->db->query("SELECT  A.*,C.Customer_Company_Name, SUM(CASE WHEN D.Dispatch_Status ='3' THEN D.Total_Qty END ) AS total,SUM(CASE WHEN D.Dispatch_Status ='3' THEN D.Dispatch_Remaining_Qty END ) AS remaining
                                   FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                   INNER JOIN wo_processing D on A.WO_Icode=D.WO_Icode WHERE now() >= DATE_ADD(A.WO_Created_On, INTERVAL 48 HOUR) and A.WO_Completed ='0' GROUP BY A.WO_Icode ");

        return $query->result_array();
    }
    /** get cutting Status */
    public function get_cutting_status($id)
    {
        $query = $this->db->query("SELECT sum(Total_Qty)as total, sum(Cutting_Remaining_Qty) as remaining FROM wo_processing  WHERE WO_Icode ='$id' and Cutting_Status !='3'");
        return $query->result_array();
    }
    /** work order completed status */
    public function get_completed_status($id)
    {
        //$query = $this->db->query("SELECT sum(Total_Qty)as total, sum(Dispatch_Remaining_Qty) as remaining FROM wo_processing  WHERE WO_Icode ='$id' and Dispatch_Status ='3'");
        $query = $this->db->query("SELECT sum(Total_Qty)as total, sum(Dispatch_Remaining_Qty) as remaining1,sum(Cutting_Remaining_Qty) as remaining2,sum(Furnace_Remaining_Qty) as remaining3 FROM wo_processing  WHERE WO_Icode ='$id' ");
        return $query->result_array();
    }
    /** get furnace status */
    public function get_furnace_status($id)
    {
        $query = $this->db->query("SELECT sum(Furnace_Incoming)as total, sum(Furnace_Remaining_Qty) as remaining FROM wo_processing  WHERE WO_Icode ='$id' and Furnace_Status !='3'");
        return $query->result_array();
    }
    /** dispatch status */
    public function get_dispatch_status($id)
    {
        $query = $this->db->query("SELECT sum(Dispatch_Incoming)as total, sum(Dispatch_Remaining_Qty) as remaining FROM wo_processing  WHERE WO_Icode ='$id' and Dispatch_Status !='3'");
        return $query->result_array();
    }
    /** Get Completed Status with result */
    public function get_completed_result($id)
    {
        $query = $this->db->query("SELECT ifnull(sum(Total_Qty), '0') as total, ifnull(sum(Dispatch_Remaining_Qty), '0') as remaining FROM wo_processing  WHERE WO_Icode ='$id' and Dispatch_Status ='3'");
        return $query->row_array(0);
    }
    /** Get completed work order */
    public function get_complete_work_order()
    {
        $query = $this->db->query("SELECT A.*,C.Customer_Company_Name FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode  WHERE A.WO_Completed='1'");
        return $query->result_array();
    }
    public function Insert_Customer($data)
    {
        $this->db->insert('customer_master', $data);
        return 1;
    }
    public function Profoma_Charges($picode)
    {
        $charg = $this->db->query("SELECT Proforma_Material_PC_Icode FROM proforma_material_processing_charges WHERE Proforma_Icode='$picode'");
        return $charg->num_rows();
    }
    public function get_Profoma_Charges($charge_id,$picode)
    {
        $charg = $this->db->query("SELECT Proforma_Material_PC_Icode FROM proforma_material_processing_charges WHERE Proforma_Icode='$picode' and Proforma_Charge_Icode='$charge_id'");
        return $charg->row_array(0);
    }
    public function Profoma_Charges_list($picode)
    {
        $query = $this->db->query("SELECT Proforma_Charge_Icode FROM proforma_material_processing_charges WHERE Proforma_Icode='$picode'");
        return $query->result();
    }
    public function delete_charges($charge_id,$picode)
    {
        $delete = $this->db->query("DELETE FROM proforma_material_processing_charges WHERE Proforma_Icode='$picode' and Proforma_Charge_Icode='$charge_id' ");

    }

    public function delete_Item($item_id)
    {
        $delete = $this->db->query("DELETE FROM proforma_invoice_items WHERE Proforma_Invoice_Items_Icode='$item_id' ");
    }

    //** Get All Work Order Status */
    public function get_all_WO_Status()
    {
        $query = $this->db->query("SELECT COUNT(CASE WHEN now() >= DATE_ADD(WO_Created_On, INTERVAL 48 HOUR) THEN 1 END) as delay,
                                COUNT(CASE WHEN now() <= DATE_ADD(A.WO_Created_On, INTERVAL 48 HOUR) and now() >= DATE_ADD(A.WO_Created_On, INTERVAL 24 HOUR) THEN 1 END) as within8,
                                COUNT(CASE WHEN  now() >= DATE_ADD(A.WO_Created_On, INTERVAL 16 HOUR) and now() <= DATE_ADD(A.WO_Created_On, INTERVAL 24 HOUR) THEN 1 END) as within16,
                                COUNT(CASE WHEN now() >= DATE_ADD(A.WO_Created_On, INTERVAL 8 HOUR) and now() <= DATE_ADD(A.WO_Created_On, INTERVAL 16 HOUR) THEN 1 END) as within24,
                                COUNT(CASE WHEN now() <= DATE_ADD(A.WO_Created_On, INTERVAL 8 HOUR) THEN 1 END) as within48
                                FROM work_order A  WHERE WO_Completed ='0' ");
        return $query->result_array();
    }
    /** Get Wotrk order result */
    public function Get_Workorder_Result()
    {
        $query = $this->db->query("SELECT Proforma_Charge_Icode FROM proforma_material_processing_charges WHERE Proforma_Icode=''");
        return $query->result();
    }
    /** Get Todays Count Details */
    public function get_today_pi()
    {
        $today = date('Y-m-d');
        $query = $this->db->query(" SELECT COUNT(CASE WHEN PI_Confirm ='0' and date(Proforma_Generated_On) = '$today' THEN 1 END) as pi,
                                    COUNT(CASE WHEN PI_Confirm ='1' and WO_Confirm='0' and date(PI_Confirm_Date) = '$today' THEN 1 END) as pi_confirm,
                                    COUNT(CASE WHEN WO_Confirm ='1'  and date(WO_Confirm_On) = '$today' THEN 1 END) as wo_confirm
                                    FROM `proforma_invoice`  ");
        return $query->result_array();
    }
    /** Get Monthly wo Completed */
    public function Monthly_WO_Complete()
    {
        $query = $this->db->query("SELECT DATE_FORMAT(WO_Completed_On, '%b') as months, COUNT(WO_Icode) as wo FROM `work_order` WHERE WO_Completed='1' 
                                  GROUP BY  DATE_FORMAT(WO_Completed_On, '%b') order by WO_Completed_On ASC  ");
        return $query->result_array();
    }
    //** Get All Stock Details */
    public function get_all_stock()
    {
        $query = $this->db->query("SELECT * FROM Stock_Master");
        return $query->result();
    }
    //** Insert Stock Details */
    public function Insert_Stock($data)
    {
        $this->db->insert('Stock_Master', $data);
        $insert_id = $this->db->insert_id();
        if($insert_id != '0')
        {
            return 1;
        }
        else{
            return 0;
        }
    }
}