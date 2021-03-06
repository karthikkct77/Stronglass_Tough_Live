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
    /*insert godown  Inventary*/
    public function insert_Godown_inventary($data){
        $this->db->insert('godown_stock_inventry', $data);
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
    public function Insert_Export_Profoma_Invoice($data)
    {
        $this->db->insert('export_invoice', $data);
        return $this->db->insert_id();
    }
    /** Get profoma number */
    public function get_profoma_number($month)
    {
        $query= $this->db->query("SELECT Proforma_Number FROM `proforma_invoice` WHERE substring(Proforma_Number, 1,2) LIKE '%$month%' and  YEAR(Proforma_Generated_On) = YEAR(CURRENT_DATE()) ORDER by Proforma_Icode DESC LIMIT 1  ");
        if($query->num_rows() == 1)
        {
            return $query->result_array();
        }
        else{
            return 0;
        }
    }
    public function get_Export_profoma_number($month)
    {
        $query= $this->db->query("SELECT Export_Invoice_Number FROM `export_invoice` WHERE substring(Export_Invoice_Number, 1,2) LIKE '%$month%' and  YEAR(Created_On) = YEAR(CURRENT_DATE()) ORDER by Export_PI_Icode DESC LIMIT 1  ");
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
        $cdate = date('Y-m-d');
        $user_icode =$this->session->userdata['userid'];
        $query = $this->db->query("Select * from proforma_invoice A INNER JOIN  customer_master B on A.Proforma_Customer_Icode=B.Customer_Icode
                                   WHERE  date(A.Proforma_Generated_On) = '$cdate' and A.Proforma_Generated_By ='$user_icode'  ");
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
        $query= $this->db->query("SELECT WO_Number FROM work_order WHERE   SUBSTR(WO_Number, 1, 2) LIKE '%$month%' and  YEAR(WO_Created_On) = YEAR(CURRENT_DATE())  ORDER by WO_Icode DESC LIMIT 1  ");
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
        $query = $this->db->query("SELECT * FROM work_order A INNER  JOIN  proforma_invoice B on A.Proforma_Icode =B.Proforma_Icode");
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
        $query = $this->db->query("SELECT  A.*,C.Customer_Company_Name, SUM(CASE WHEN D.Dispatch_Status ='3' THEN D.Total_Qty END ) AS total,(sum(D.Dispatch_Remaining_Qty) + sum(D.Cutting_Remaining_Qty)+sum(D.Furnace_Remaining_Qty)) as remaining
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
    public function delete_charges($charge_id)
    {
        $delete = $this->db->query("DELETE FROM proforma_material_processing_charges WHERE Proforma_Material_PC_Icode='$charge_id' ");

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
        return $query->result_array();
    }
    //** Insert Stock Details */
    public function Insert_Stock($data)
    {
        $sname = $data['Stock_Name'];
        $height = $data['Stock_Height'];
        $width = $data['Stock_Width'];
        $query= $this->db->query("SELECT * FROM stock_master  WHERE Stock_Name = '".$sname."'  AND Stock_Height = '".$height."' AND Stock_Width = '".$width."' "); // Admin side
        if($query->num_rows() == 0) {
            $this->db->insert('Stock_Master', $data);
            $insert_id = $this->db->insert_id();
            if ($insert_id != '0') {
                return 1;
            } else {
                return 0;
            }
        }
        else{
            return 2;
        }
    }
    //** Get Perticular Task */
    public function get_Stock($stock_icode)
    {
        $query = $this->db->query("SELECT * FROM Stock_Master WHERE Stock_Icode ='$stock_icode'");
        return $query->result_array();
    }
    //** Get All Godown Stock Details */
    public function get_all_godown_stock()
    {
        $query = $this->db->query("SELECT A.*,B.*,A.Created_On as added_Date FROM godown_stock_inventry A INNER JOIN stock_master B on A.Stock_Icode=B.Stock_Icode");
        return $query->result_array();
    }
    //** Get Material QTY */
    public function get_stock_quantity($stock_id)
    {
        $query = $this->db->query("SELECT * FROM godown_stock_inventry WHERE Stock_Icode='$stock_id'");
        return $query->result_array();
    }
    public function get_factory_stock_quantity($stock_id)
    {
        $query = $this->db->query("SELECT * FROM factory_stock_details WHERE Stock_Icode='$stock_id'");
        return $query->result_array();
    }
    //** Get Godown Inventry */
    public function get_godown_inventry($material_id)
    {
        $query = $this->db->query("Select * from godown_stock_inventry WHERE Stock_Icode = '$material_id' ");
        return $query->num_rows();
    }
    //** get date wise inventry */
    public function get_Date_Godown_inventary($from_date,$to_date)
    {
        $query = $this->db->query("SELECT SUM(A.Last_Added_Date) as Counts, B.Material_Name FROM godown_inventory_inward_history A INNER JOIN stock_master B on A.Stock_Icode=B.Stock_Icode
                                    WHERE  date(A.Last_Added_Date) >= '$from_date' and date(A.Last_Added_Date) <= '$to_date' GROUP by A.Stock_Icode");
        return $query->result_array();
    }
    //**Insert Godown History
    public function insert_Godown_inventary_history($data)
    {
        $this->db->insert('godown_inventory_inward_history', $data);
        $insert_id = $this->db->insert_id();
        if($insert_id != '0')
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    //**Insert Godown outward History
    public function insert_godown_outward_history($data)
    {
        $this->db->insert('godown_stock_outward_history', $data);
        $insert_id = $this->db->insert_id();
        if($insert_id != '0')
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    //**Insert factory stock
    public function insert_factory_stock($data)
    {
        $this->db->insert('Factory_Stock_details', $data);
        $insert_id = $this->db->insert_id();
        if($insert_id != '0')
        {
            return 1;
        }
        else{
            return 0;
        }
    }


    //** Get Factory Stock */
    public function get_factory_stock($material_id)
    {
        $query = $this->db->query("Select * from Factory_Stock_details WHERE Stock_Icode = '$material_id' ");
        return $query->result_array();
    }
    //** Get All Factory Stock Details */
    public function get_all_factory_stock()
    {
        $query = $this->db->query("SELECT A.*,B.*, A.Created_On as dates, C.Company_Name FROM Factory_Stock_details A INNER JOIN stock_master B on A.Stock_Icode=B.Stock_Icode 
                                   INNER JOIN godown_stock_inventry C ON A.Stock_Icode=C.Stock_Icode WHERE  A.Current_Qty !='0' ORDER BY B.Stock_Name DESC");
        return $query->result_array();
    }
    //** Get perticular revised material */
    public function get_revised_godown_stock($stock_icode)
    {
        $query = $this->db->query("Select * from godown_inventory_inward_history A INNER  JOIN stock_master B on A.Stock_Icode=B.Stock_Icode  WHERE A.Stock_Icode = '$stock_icode' ORDER BY Last_Added_Date DESC ");
        return $query->result_array();
    }

    //** get sheet work order */  */
    public function get_sheet_Work_Order_Details($id)
    {
        $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_item_sheet B ON A.PI_Sheet_Item_Icode=B.pi_item_sheet_icode 
                                        INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.WO_Icode='$id'");
        return $query->result_array();
    }

    //** Get All Invoice List */
    public function get_all_invoice_list()
    {
        $query = $this->db->query("Select * from proforma_invoice A INNER JOIN  customer_master B on A.Proforma_Customer_Icode=B.Customer_Icode
                                   WHERE  A.PI_Confirm='0'  ");
        return $query->result_array();
    }

    //** Get Recut invoice recut */
    public function  get_recut_normal_item($process_id)
    {
        $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_items B on A.Proforma_Invoice_Item_Icode=B.Proforma_Invoice_Items_Icode INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.WO_Process_Icode='$process_id'");
        return $query->result_array();
    }
    public function  get_recut_sheet_item($process_id)
    {
        $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_item_sheet B on A.PI_Sheet_Item_Icode=B.pi_item_sheet_icode INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.WO_Process_Icode='$process_id'");
        return $query->result_array();
    }

    public function get_all_Factory_stock_details()
    {
        $query = $this->db->query("SELECT * FROM wo_processing A INNER JOIN proforma_invoice_item_sheet B on A.PI_Sheet_Item_Icode=B.pi_item_sheet_icode INNER JOIN material_master C on B.Proforma_Material_Icode=C.Material_Icode WHERE A.WO_Process_Icode='$process_id'");
        return $query->result_array();
    }
    public function get_all_godown_Current_stock()
    {
        $query = $this->db->query("SELECT * FROM godown_stock_inventry A INNER JOIN stock_master B on A.Stock_Icode=B.Stock_Icode WHERE A.Current_Qty !='0'");
        return $query->result_array();
    }
    public function get_all_Factory_current_stock()
    {
        $query = $this->db->query("SELECT * FROM factory_stock_details A INNER JOIN stock_master B on A.Stock_Icode=B.Stock_Icode WHERE A.Current_Qty !='0'");
        return $query->result_array();
    }

    //**Insert Godown outward History
    public function insert_factory_outward_history($data)
    {
        $this->db->insert('factory_stock_outword_history', $data);
        $insert_id = $this->db->insert_id();
        if($insert_id != '0')
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    //** get all factory word history */
    public function get_all_Factory_Outword()
    {
        $query = $this->db->query("SELECT * FROM factory_stock_outword_history A INNER JOIN stock_master B on A.Stock_Icode=B.Stock_Icode  ORDER BY A.Stock_Getting_On DESC"); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    //** Get Today Workorder PI counts */
    public function Get_Today_PI_Counts()
    {
        $today = date('Y-m-d');
//        $today ='2018-10-01';
        $query = $this->db->query("SELECT count(Proforma_Icode) as pi_count, SUM(GrossTotal_Value) as pi_amount FROM proforma_invoice WHERE date(Proforma_Generated_On)='$today'"); //GROUP by A.Stock_Icode
        return $query->result_array();

    }
    public function Get_Today_WO_Counts()
    {
        $today = date('Y-m-d');

        $query = $this->db->query("SELECT COUNT(A.WO_Icode) as wo_count, SUM(B.GrossTotal_Value) as wo_amount FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode WHERE date(A.WO_Created_On) = '$today'"); //GROUP by A.Stock_Icode
        return $query->result_array();

    }
    public function Get_Today_normal_WO_details()
    {
        $today = date('Y-m-d');

        $query = $this->db->query("SELECT A.WO_Number,A.Proforma_Number,A.Total_Qty,C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, B.Total_Outstanding,C.Customer_Reference, B.Transport,
                                    B.GrossTotal_Value, GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness 
                                    FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_items D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode WHERE date(A.WO_Created_On)='$today' GROUP by D.Proforma_Icode ORDER  by A.WO_Number Asc"); //GROUP by A.Stock_Icode
        return $query->result_array();

    }
    public function Get_Today_sheet_WO_details()
    {
        //date('Y-m-d')
        $today = date('Y-m-d');
        $query = $this->db->query("SELECT A.WO_Number,A.Proforma_Number,A.Total_Qty,C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, B.GrossTotal_Value,B.Total_Outstanding, GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness,C.Customer_Reference, B.Transport FROM work_order A 
                                   INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_item_sheet D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode WHERE date(A.WO_Created_On)='$today' GROUP by D.Proforma_Icode ORDER  by A.WO_Number Asc "); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    //get delivery work order//
    public function Get_Not_Completed_WO()
    {

        $query = $this->db->query("SELECT * FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN  customer_master C ON B.Proforma_Customer_Icode=C.Customer_Icode 
                                      WHERE  A.WO_Completed = '0' ");
        return $query->result_array();
    }

    //** kerala normal workordfer details
    public function Get_Today_normal_WO_details_kerala()
    {
        $today = date('Y-m-d');
        $query = $this->db->query("SELECT A.WO_Number,A.Proforma_Number,A.Total_Qty,C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, B.Total_Outstanding,C.Customer_Reference, B.Transport,
                                    B.GrossTotal_Value, GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness 
                                    FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_items D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode WHERE A.WO_Completed = '1' and  
                                    date(A.WO_Completed_On)='$today'  and  C.Customer_State LIKE '%kerala%' GROUP by D.Proforma_Icode ORDER  by A.WO_Number Asc"); //GROUP by A.Stock_Icode
        return $query->result_array();

    }

    public function Get_Today_sheet_WO_details_kerala()
    {
        //date('Y-m-d')
        $today = date('Y-m-d');
        $query = $this->db->query("SELECT A.WO_Number,A.Proforma_Number,A.Total_Qty,C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, B.GrossTotal_Value,B.Total_Outstanding, GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness,C.Customer_Reference, B.Transport FROM work_order A 
                                   INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_item_sheet D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode WHERE A.WO_Completed = '1' and  
                                    date(A.WO_Completed_On)='$today'  and  C.Customer_State LIKE '%kerala%' GROUP by D.Proforma_Icode ORDER  by A.WO_Number Asc "); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    //** Chennai Report
    public function Get_Today_normal_WO_details_chennai()
    {
        $today = date('Y-m-d');
        $query = $this->db->query("SELECT A.WO_Number,A.Proforma_Number,A.Total_Qty,C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, B.Total_Outstanding,C.Customer_Reference, B.Transport,
                                    B.GrossTotal_Value, GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness 
                                    FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_items D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode WHERE A.WO_Completed = '1' and  
                                    date(A.WO_Completed_On)='$today'  and  C.Customer_City LIKE '%chennai%' GROUP by D.Proforma_Icode ORDER  by A.WO_Number Asc"); //GROUP by A.Stock_Icode
        return $query->result_array();

    }

    public function Get_Today_sheet_WO_details_chennai()
    {
        //date('Y-m-d')
        $today = date('Y-m-d');
        $query = $this->db->query("SELECT A.WO_Number,A.Proforma_Number,A.Total_Qty,C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, B.GrossTotal_Value,B.Total_Outstanding, GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness,C.Customer_Reference, B.Transport FROM work_order A 
                                   INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_item_sheet D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode WHERE A.WO_Completed = '1' and  
                                    date(A.WO_Completed_On)='$today'  and  C.Customer_City LIKE '%chennai%' GROUP by D.Proforma_Icode ORDER  by A.WO_Number Asc "); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    //** Local Despatch Report
    public function Get_Today_normal_WO_details_local()
    {
        $today = date('Y-m-d');
        $query = $this->db->query("SELECT A.WO_Number,A.Proforma_Number,A.Total_Qty,C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, B.Total_Outstanding,C.Customer_Reference, B.Transport,
                                    B.GrossTotal_Value, GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness 
                                    FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_items D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode WHERE A.WO_Completed = '1' and  
                                    date(A.WO_Completed_On)='$today'  and  C.Customer_State NOT LIKE 'kerala' and  C.Customer_City NOT LIKE '%chennai%' GROUP by D.Proforma_Icode ORDER  by A.WO_Number Asc"); //GROUP by A.Stock_Icode
        return $query->result_array();

    }
    public function Get_Today_sheet_WO_details_local()
    {
        //date('Y-m-d')
        $today = date('Y-m-d');
        $query = $this->db->query("SELECT A.WO_Number,A.Proforma_Number,A.Total_Qty,C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, B.GrossTotal_Value,B.Total_Outstanding, GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness,C.Customer_Reference, B.Transport FROM work_order A 
                                   INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_item_sheet D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode WHERE A.WO_Completed = '1' and  
                                    date(A.WO_Completed_On)='$today'  and  C.Customer_State NOT LIKE 'kerala' and  C.Customer_City NOT LIKE '%chennai%' GROUP by D.Proforma_Icode ORDER  by A.WO_Number Asc "); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    public function Get_Today_Pending_PI_counts()
    {
        $today = date('Y-m-d');
//        $today ='2018-10-01';
        $query = $this->db->query("SELECT count(Proforma_Icode) as pi_count, SUM(GrossTotal_Value) as pi_amount FROM proforma_invoice 
            WHERE PI_Confirm !='1' and
         date(Proforma_Generated_On)='$today'"); //GROUP by A.Stock_Icode
        return $query->result_array();

    }
    public function Get_Today_normal_pending_details()
    {
        $today = date('Y-m-d');

        $query = $this->db->query("SELECT B.Proforma_Number, sum(D.Proforma_Qty) as Total_Qty, C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, B.Total_Outstanding,C.Customer_Reference, B.Transport,
                                    B.GrossTotal_Value, GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness 
                                    FROM  proforma_invoice B  INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_items D on B.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode WHERE date(B.Proforma_Generated_On)='$today' and B.PI_Confirm !='1' GROUP by D.Proforma_Icode ORDER  by B.Proforma_Number Asc"); //GROUP by A.Stock_Icode
        return $query->result_array();

    }
    public function Get_Today_sheet_pending_details()
    {
        //date('Y-m-d')
        $today = date('Y-m-d');
        $query = $this->db->query("SELECT B.Proforma_Number, sum(D.Proforma_Qty) as Total_Qty,  C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, B.GrossTotal_Value,B.Total_Outstanding, GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness,C.Customer_Reference, B.Transport FROM proforma_invoice B INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_item_sheet D on B.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode WHERE date(B.Proforma_Generated_On)='$today' and B.PI_Confirm !='1' GROUP by D.Proforma_Icode ORDER  by B.Proforma_Number Asc" ); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    public function Get_Monthly_PI_Counts()
    {
        $query = $this->db->query("SELECT count(Proforma_Icode) as pi_count, SUM(GrossTotal_Value) as pi_amount FROM proforma_invoice WHERE  
                                  MONTH(Proforma_Generated_On) = MONTH(CURRENT_DATE()) AND YEAR(Proforma_Generated_On) = YEAR(CURRENT_DATE()) ");
        return $query->result_array();
    }
    public function Get_Monthly_WO_Counts()
    {
        $query = $this->db->query("SELECT COUNT(A.WO_Icode) as wo_count, SUM(B.GrossTotal_Value) as wo_amount FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode
                                    WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE())");
        return $query->result_array();
    }

    public function Get_Monthly_Total_Bill()
    {
        $query = $this->db->query("SELECT SUM(GrossTotal_Value) as total_amt FROM `billing_details` WHERE MONTH(Created_On) = MONTH(CURRENT_DATE()) AND YEAR(Created_On) = YEAR(CURRENT_DATE())");
        return $query->result_array();
    }

    //** Normal Material Details
//    public function Get_monthly_normal_WO_material()
//    {
//        $query = $this->db->query("SELECT   DISTINCT(E.Material_Name), SUM(D.Proforma_Qty) as Total_Qty, SUM(D.Proforma_Area_SQMTR) as area FROM work_order A  INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode
//                                    INNER JOIN proforma_invoice_items D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode  WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE())  GROUP BY E.Material_Icode"); //GROUP by A.Stock_Icode
//        return $query->result_array();
//    }

    public function Get_monthly_sheet_WO_material()
    {
        $query = $this->db->query("SELECT   DISTINCT(E.Material_Name),SUM(D.Proforma_Qty) as Total_Qty, SUM(D.Proforma_Area_SQMTR) as area FROM work_order A  INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                    INNER JOIN proforma_invoice_item_sheet D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode  WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE())  GROUP BY E.Material_Icode"); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    public function Get_monthly_normal_pi_WO_material()
    {
        $query = $this->db->query("SELECT   DISTINCT(E.Material_Name), SUM(D.Proforma_Qty) as Total_Qty, SUM(D.Proforma_Area_SQMTR) as area FROM work_order A  INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                    INNER JOIN proforma_invoice_items D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode
                                      WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE())  and B.PI_Type='0'  GROUP BY E.Material_Icode"); //GROUP by A.Stock_Icode
        return $query->result_array();
    }
    public function Get_monthly_dg_pi_WO_material()
    {
        $query = $this->db->query("SELECT   DISTINCT(E.Material_Name), SUM(D.Proforma_Qty) as Total_Qty, SUM(D.Proforma_Area_SQMTR) as area FROM work_order A  INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                    INNER JOIN proforma_invoice_items D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode
                                      WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE())  and B.PI_Type='2'  GROUP BY E.Material_Icode"); //GROUP by A.Stock_Icode
        return $query->result_array();
    }
    public function Get_monthly_lamination_pi_WO_material()
    {
        $query = $this->db->query("SELECT   DISTINCT(E.Material_Name), SUM(D.Proforma_Qty) as Total_Qty, SUM(D.Proforma_Area_SQMTR) as area FROM work_order A  INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                    INNER JOIN proforma_invoice_items D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode
                                      WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE())  and B.PI_Type='3'  GROUP BY E.Material_Icode"); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    /** Inseret Delivery Data */
    public function insert_delivery_data($data)
    {
        $this->db->insert('delivery_details', $data);
        return 1;
    }

    public function Get_Today_normal_Delivery_WO_details($location)
    {
        $today = date('Y-m-d');
        $query = $this->db->query("SELECT A.WO_Number,A.Proforma_Number,A.Total_Qty,C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, B.Total_Outstanding,C.Customer_Reference, B.Transport,
                                    B.GrossTotal_Value, GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness , F.*
                                    FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_items D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode INNER JOIN delivery_details F on A.WO_Icode=F.WO_Icode WHERE A.WO_Completed = '1' and  
                                    date(A.WO_Completed_On)='$today'  and  F.Delivery_Location LIKE '%$location%' GROUP by D.Proforma_Icode ORDER  by A.WO_Number Asc"); //GROUP by A.Stock_Icode
        return $query->result_array();

    }

    public function Get_Today_sheet_Delivery_WO_details($location)
    {
        //date('Y-m-d')
        $today = date('Y-m-d');
        $query = $this->db->query("SELECT A.WO_Number,A.Proforma_Number,A.Total_Qty,C.Customer_Company_Name,SUM(D.Proforma_Area_SQMTR) as area, B.GrossTotal_Value,B.Total_Outstanding, GROUP_CONCAT(DISTINCT(D.Proforma_Special)) as special, GROUP_CONCAT(DISTINCT LEFT(E.Material_Name, 4)) as thickness,C.Customer_Reference, B.Transport, F.* FROM work_order A 
                                   INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    INNER JOIN proforma_invoice_item_sheet D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN material_master E on D.Proforma_Material_Icode=E.Material_Icode INNER JOIN delivery_details F on A.WO_Icode=F.WO_Icode WHERE A.WO_Completed = '1' and  
                                    date(A.WO_Completed_On)='$today'  and F.Delivery_Location LIKE '%$location%' GROUP by D.Proforma_Icode ORDER  by A.WO_Number Asc "); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    //** Location wise total work order amount */
    public function Get_Monthly_WO_Counts_locations()
    {
        $query = $this->db->query("SELECT 
                                   SUM(CASE WHEN C.Customer_State LIKE '%kerala%' THEN B.GrossTotal_Value END) AS Kerala,
                                   SUM(CASE WHEN C.Customer_City LIKE '%chennai%' THEN B.GrossTotal_Value END) AS Chennai, 
                                   SUM(CASE WHEN C.Customer_State NOT LIKE 'kerala' and  C.Customer_City NOT LIKE '%chennai%' THEN B.GrossTotal_Value END) AS Locals
                                   FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                   WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE())");
        return $query->result_array();
    }
    //** Get All Expenses */
    public function Get_All_Expenses()
    {
        $query = $this->db->query("Select * from Expenses_Master  ");
        return $query->result_array();
    }

    //** Get All Expense  */
    public function Get_All_Expenses_details()
    {
        $query = $this->db->query("Select A.*,B.* from Expenses_Details A INNER JOIN Expenses_Master B on A.Expenses_Icode=B.Expenses_Icode  WHERE MONTH(A.Expenses_Date) = MONTH(CURRENT_DATE()) AND YEAR(A.Expenses_Date) = YEAR(CURRENT_DATE()) ORDER  by A.Expenses_Date ASC ");
        return $query->result_array();
    }
    //** Get Monthly Expenses */
    public function Get_Monthly_Expenses()
    {
        $query = $this->db->query("Select B.Expenses_Name,SUM(A.Amount) as amounts from Expenses_Details A INNER JOIN Expenses_Master B on A.Expenses_Icode=B.Expenses_Icode  
                                   WHERE MONTH(A.Expenses_Date) = MONTH(CURRENT_DATE()) AND YEAR(A.Expenses_Date) = YEAR(CURRENT_DATE()) GROUP BY A.Expenses_Icode ");
        return $query->result_array();
    }
    //** Export Invoice  */
    public function get_All_Export_Invoice()
    {
        $query = $this->db->query("Select * from export_invoice A INNER JOIN  customer_master B on A.Proforma_Customer_Icode=B.Customer_Icode ");
        return $query->result_array();
    }
    //** Get Single Export Invoice */
    public function Get_Single_Export_Invoice($export_icode)
    {

        $query = $this->db->query("SELECT C.*,A.*,B.*,B.Customer_Icode as consignee FROM export_invoice A INNER JOIN customer_master B on A.Proforma_Customer_Icode=B.Customer_Icode 
                                   LEFT JOIN customer_add_address C ON A.Proforma_Delivery_Address_Icode=C.Customer_Icode WHERE A.Export_PI_Icode='$export_icode'");
        return $query->result_array();
    }
    public function Get_Single_Export_Invoice_Item($export_icode)
    {
        $query = $this->db->query("SELECT * FROM Export_Items A INNER JOIN material_master B on A.Proforma_Material_Icode=B.Material_Icode WHERE A.Export_PI_Icode='$export_icode'");
        return $query->result_array();
    }
    public function Get_Single_Export_Invoice_Item_Total($export_icode)
    {
        $query = $this->db->query("SELECT SUM(A.Proforma_Qty) as qty, SUM(A.Proforma_Area_SQMTR) as area, SUM(A.Proforma_Material_Cost) as rate,SUM(A.Proforma_Holes) as holes,SUM(A.Proforma_Cutout) as cutout FROM Export_Items A INNER JOIN material_master B on A.Proforma_Material_Icode=B.Material_Icode
                                  WHERE A.Export_PI_Icode='$export_icode'");
        return $query->result_array();
    }
    public function Get_Monthly_Charges_Local()
    {
        $query = $this->db->query(" SELECT C.charge_name, SUM(B.Proforma_Charge_Cost) as amount FROM work_order A 
                                    INNER JOIN proforma_material_processing_charges B on A.Proforma_Icode=B.Proforma_Icode
                                    INNER JOIN processing_charges_master C on B.Proforma_Charge_Icode=C.charge_icode
                                    INNER JOIN proforma_invoice D ON D.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master E on E.Customer_Icode=D.Proforma_Customer_Icode
                                    WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE()) and  E.Customer_State NOT LIKE 'kerala' and  E.Customer_City NOT LIKE '%chennai%' 
                                    GROUP by B.Proforma_Charge_Icode");
        return $query->result_array();
    }

    public function Get_Monthly_Transport_Local()
    {
        $query = $this->db->query("SELECT SUM(B.Transport) as Transport FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                   INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                   WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE()) and 
                                    C.Customer_State NOT LIKE 'kerala' and  C.Customer_City NOT LIKE '%chennai%' ");
        return $query->result_array();
    }

    public function Get_monthly_normal_WO_material_local()
    {
        $query = $this->db->query("SELECT   SUM(D.Proforma_Area_SQMTR) as area FROM work_order A  INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                    INNER JOIN proforma_invoice_items D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE())   and  C.Customer_State NOT LIKE 'kerala' and  C.Customer_City NOT LIKE '%chennai%'"); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    public function Get_monthly_sheet_WO_material_local()
    {
        $query = $this->db->query("SELECT   SUM(D.Proforma_Area_SQMTR) as area FROM work_order A  INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                    INNER JOIN proforma_invoice_item_sheet D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE())   and  C.Customer_State NOT LIKE 'kerala' and  C.Customer_City NOT LIKE '%chennai%'"); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    public function Get_Monthly_Charges_chennai()
    {
        $query = $this->db->query(" SELECT C.charge_name, SUM(B.Proforma_Charge_Cost) as amount FROM work_order A 
                                    INNER JOIN proforma_material_processing_charges B on A.Proforma_Icode=B.Proforma_Icode
                                    INNER JOIN processing_charges_master C on B.Proforma_Charge_Icode=C.charge_icode
                                    INNER JOIN proforma_invoice D ON D.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master E on E.Customer_Icode=D.Proforma_Customer_Icode
                                    WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE()) and  E.Customer_City LIKE '%chennai%'
                                    GROUP by B.Proforma_Charge_Icode");
        return $query->result_array();
    }
    public function Get_Monthly_Transport_chennai()
    {
        $query = $this->db->query("SELECT SUM(B.Transport) as Transport FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                   INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                   WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE()) and 
                                     C.Customer_City LIKE '%chennai%' ");
        return $query->result_array();
    }

    public function Get_monthly_normal_WO_material_chennai()
    {
        $query = $this->db->query("SELECT   SUM(D.Proforma_Area_SQMTR) as area FROM work_order A  INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                    INNER JOIN proforma_invoice_items D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE())  
                                     and  C.Customer_City  LIKE '%chennai%'"); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    public function Get_monthly_sheet_WO_material_chennai()
    {
        $query = $this->db->query("SELECT   SUM(D.Proforma_Area_SQMTR) as area FROM work_order A  INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                    INNER JOIN proforma_invoice_item_sheet D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE())  
                                     and  C.Customer_City LIKE '%chennai%'"); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    public function Get_Monthly_Charges_kerala()
    {
        $query = $this->db->query(" SELECT C.charge_name, SUM(B.Proforma_Charge_Cost) as amount FROM work_order A 
                                    INNER JOIN proforma_material_processing_charges B on A.Proforma_Icode=B.Proforma_Icode
                                    INNER JOIN processing_charges_master C on B.Proforma_Charge_Icode=C.charge_icode
                                    INNER JOIN proforma_invoice D ON D.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master E on E.Customer_Icode=D.Proforma_Customer_Icode
                                    WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE()) and  E.Customer_State LIKE '%kerala%'
                                    GROUP by B.Proforma_Charge_Icode");
        return $query->result_array();
    }
    public function Get_Monthly_Transport_kerala()
    {
        $query = $this->db->query("SELECT SUM(B.Transport) as Transport FROM work_order A INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                   INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                   WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE()) and 
                                     C.Customer_State  LIKE 'kerala' ");
        return $query->result_array();
    }

    public function Get_monthly_normal_WO_material_kerala()
    {
        $query = $this->db->query("SELECT   SUM(D.Proforma_Area_SQMTR) as area FROM work_order A  INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                    INNER JOIN proforma_invoice_items D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE())  
                                     and C.Customer_State  LIKE 'kerala'"); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    public function Get_monthly_sheet_WO_material_kerala()
    {
        $query = $this->db->query("SELECT   SUM(D.Proforma_Area_SQMTR) as area FROM work_order A  INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode 
                                    INNER JOIN proforma_invoice_item_sheet D on A.Proforma_Icode=D.Proforma_Icode INNER JOIN customer_master C on B.Proforma_Customer_Icode=C.Customer_Icode 
                                    WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE())  
                                     and  C.Customer_State  LIKE 'kerala'"); //GROUP by A.Stock_Icode
        return $query->result_array();
    }

    public function Get_Monthly_Bill_Counts()
    {
        $query = $this->db->query("SELECT COUNT(Bill_Icode) as Bill_Count FROM billing_details WHERE MONTH(Created_On) = MONTH(CURRENT_DATE()) AND YEAR(Created_On) = YEAR(CURRENT_DATE()) ");
        return $query->result_array();

    }
    public function Get_Monthly_Bill_Accounts()
    {
        $query = $this->db->query("SELECT A.WO_Number,B.GrossTotal_Value as wo_total,A.WO_Date,D.Customer_Company_Name, C.Bill_Number,C.GrossTotal_Value FROM work_order A 
                                   INNER JOIN proforma_invoice B on A.Proforma_Icode=B.Proforma_Icode INNER JOIN customer_master D on B.Proforma_Customer_Icode=D.Customer_Icode LEFT JOIN billing_details C on A.WO_Icode=C.Wo_Icode 
                                   WHERE MONTH(A.WO_Created_On) = MONTH(CURRENT_DATE()) AND YEAR(A.WO_Created_On) = YEAR(CURRENT_DATE()) ORDER by A.WO_Icode ASC    ");
        return $query->result_array();

    }
    public function Get_Petty_Cash()
    {
        $query = $this->db->query("SELECT * FROM petty_cash ");
        return $query->result_array();
    }
    public function Get_Inward_Cash()
    {
        $query = $this->db->query("SELECT * FROM Inward_Cash WHERE MONTH(Created_On) = MONTH(CURRENT_DATE()) AND YEAR(Created_On) = YEAR(CURRENT_DATE()) ");
        return $query->result_array();
    }





}