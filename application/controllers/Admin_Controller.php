<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if($this->session->user_name == "")
        {
            redirect('Login');
        }

        //bjj$this->load->model('LoginModel','LoginModel');
        $this->load->helper('url');   /***** LOADING HELPER TO AVOID PHP ERROR ****/
        $this->load->model('Admin_Model','admin_model'); /* LOADING MODEL * Technical_Admin_Model as technical_admin_model */
        $this->load->model('User_Model', 'user_model'); /* LOADING MODEL * User_Model as user_model */
        $this->load->library('session');
        $this->load->library('excel');
        $this->session->set_flashdata('message');
    }

    //** Admin Dashboard**//
    public function dashboard()
    {
        $data['status']= $this->admin_model->get_all_WO_Status();
        $data['todays_pi'] =$this->admin_model->get_today_pi();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/dashboard',$data, FALSE);
        $this->load->view('Admin/footer');
    }

    //** Enter stack with size */
    public function Stock_Entry()
    {
        $data['stock']= $this->admin_model->get_all_item();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Stock_Entry',$data, FALSE);
        $this->load->view('Admin/footer');
    }
    //** Save stock */
    public function Save_Stock()
    {
        $data = array( 'Material_Name' => $this->input->post('stock_name'),
                       'Material_Current_Price' => $this->input->post('stock_price'),
                       'HSN_Code' => $this->input->post('HSN'),
                       'Material_Created_By' => $this->session->userdata['userid']);
        $insert = $this->admin_model->insert_item($data);
        if($insert == 1)
        {
            $this->session->set_flashdata('feedback', 'Insert Successfully ..');
            redirect('Admin_Controller/Stock_Entry');
        }
        else{
            $this->session->set_flashdata('feedback', 'Insert Failed..');
        }
    }

    //** Edit Material */
    public function Edit_Material()
    {
        $material_id = $this->input->post('id',true);
        $data = $this->admin_model->get_material($material_id);
        echo  json_encode($data);
    }
    //** Update Material */
    public function Update_Material()
    {
        $material_icode = $this->input->post('material_icode');
        $get = $this->admin_model->get_material($material_icode);
        $update = array('Material_Icode' => $this->input->post('material_icode'),
            'Material_Old_Price' =>$get[0]['Material_Current_Price'],
            'Material_Current_Price   ' =>$this->input->post('material_price'),
            'Material_Price_Revised_Date' => date('Y-m-d H:i:s'),
            'Material_Price_Updated_By' => $this->session->userdata['userid']);
        $insert = $this->admin_model->insert_material_history($update);
        if($insert == 1)
        {
            $data = array(  'Material_Name' => $this->input->post('material_name'),
                'Material_Current_Price' =>$this->input->post('material_price'),
                'HSN_Code' => $this->input->post('HSN'));
            $this->db->where('material_icode',$material_icode);
            $this->db->update('material_master', $data);
            $this->session->set_flashdata('feedback', 'Successfully Updated..');
            redirect('Admin_Controller/Stock_Entry');

        }
        else{
            $this->session->set_flashdata('feedback', 'Insert Failed..');
        }
    }
    //** Item Charges */

    public function Charges_Entry()
    {
        $data['charges']= $this->admin_model->get_all_charges();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Charges',$data, FALSE);
        $this->load->view('Admin/footer');
    }
    //** Insert Charges */
    public function  Save_Charges()
    {
        $data = array( 'charge_name' => $this->input->post('charges_name'),
            'charge_current_price' =>$this->input->post('charges_price'),
            'created_by' => $this->session->userdata['userid']);
        $insert = $this->admin_model->insert_charges($data);
        if($insert == 1)
        {
            $this->session->set_flashdata('feedback', 'Successfully Saved..');
            redirect('Admin_Controller/Charges_Entry');
        }
        else{
            $this->session->set_flashdata('feedback', 'Insert Failed..');
        }
    }
   //** Edit Charges */
    public function Edit_Charges()
    {
        $charges_id = $this->input->post('id',true);
        $data = $this->admin_model->get_charges($charges_id);
        echo  json_encode($data);
    }
    //**Update Charges **//
    public function Update_Charges()
    {
        $charges_id = $this->input->post('charges_icode');
        $get = $this->admin_model->get_charges($charges_id);
        $update = array('charge_icode' => $this->input->post('charges_icode'),
                        'charge_old_price' =>$get[0]['charge_current_price'],
                        'charge_current_price  ' =>$this->input->post('charges_price'),
                        'charge_revised_by' => $this->session->userdata['userid']);
        $insert = $this->admin_model->insert_charges_history($update);
        if($insert == 1)
        {
            $data = array(  'charge_name' => $this->input->post('charges_name'),
                'charge_current_price' =>$this->input->post('charges_price'),
                'modified_by' => $this->session->userdata['userid'],
                'modified_on' => date('Y-m-d H:i:s'));
            $this->db->where('charge_icode',$charges_id);
            $this->db->update('processing_charges_master', $data);
            $this->session->set_flashdata('feedback', 'Data Updated..');
            redirect('Admin_Controller/Charges_Entry');
        }
        else{
            $this->session->set_flashdata('feedback', 'Insert Failed..');
        }
    }

    //** IINVENTRY */
    public function Inventry()
    {
        $data['inventary']= $this->admin_model->get_all_inventary();
        $data['stock']= $this->admin_model->get_all_item();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Inventry',$data, FALSE);
        $this->load->view('Admin/footer');
    }
    //** Get Material quantity */
    public function get_quantity()
    {
        $material_id = $this->input->post('id',true);
        $data = $this->admin_model->get_material_quantity($material_id);
        echo  json_encode($data);

    }

    /*save Inventary*/
    public function Save_Inventary(){
        $Materials =  $this->input->post('material_id',true);
        $new_quantity = $this->input->post('new_quantity',true);
        $total_quantity = $this->input->post('total_quantity',true);
        $count = sizeof($Materials);
        for($i=0; $i<$count; $i++)
        {
            if ($Materials[$i] == "") {

            }
            else{
                $data = $this->admin_model->get_material_inventry($Materials[$i]);

                if ($data == 0)
                {
                    $insert = array('Material_Icode' => $Materials[$i],
                        'Material_Current_Quantity' =>$total_quantity[$i],
                        'Material_Stock_Qty_Last_Added  ' =>$new_quantity[$i],
                        'Material_Qty_Last_Added_By' => $this->session->userdata['userid']);
                    $insert_inventary = $this->admin_model->insert_inventary($insert);
                }
                else
                {
                    $insert = array('Material_Icode' => $Materials[$i],
                        'Material_Quantity_Added' =>$new_quantity[$i],
                        'Material_Qty_Last_Added_By' => $this->session->userdata['userid']);
                    $insert_history = $this->admin_model->insert_inventary_history($insert);
                    if($insert_history == 1)
                    {
                        $data = array(  'Material_Current_Quantity' => $total_quantity[$i],
                            'Material_Stock_Qty_Last_Added' =>$new_quantity[$i],
                            'Material_Qty_Last_Added_Date' =>date('Y-m-d H:i:s'));
                        $this->db->where('Material_Icode',$Materials[$i]);
                        $this->db->update('material_inventory', $data);
                    }
                    else{
                       echo 0;
                    }
                }
            }
        }
        echo 1;
    }

    //** Add Customers */
    public function Add_Customers()
    {
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Customers');
        $this->load->view('Admin/footer');

    }

    /*save customer*/
    public function Save_Customer(){
        $data = array( 'Customer_Company_Name' => $this->input->post('company_name'),
            'Customer_GSTIN' =>$this->input->post('gstin_number'),
            'Customer_Address_1' =>$this->input->post('address'),
            'Customer_Address_2' =>$this->input->post('address1'),
            'Customer_Area' =>$this->input->post('area'),
            'Customer_City' =>$this->input->post('city'),
            'Customer_State' =>$this->input->post('state'),
            'Customer_Phone' =>$this->input->post('phone'),
            'Customer_Alternate_Phone' =>$this->input->post('alternate_phone'),
            'Customer_Email_Id_1' =>$this->input->post('email_1'),
            'Customer_Email_Id_2' =>$this->input->post('email_2'),
            'Customer_Reference' =>$this->input->post('Reference'),
            'Customer_Created_By' => $this->session->userdata['userid']);
        $insert = $this->admin_model->save_customer($data);
        if($insert == 1)
        {
            redirect('Admin_Controller/View_Customers');
            $this->session->set_flashdata('feedback', 'Insert Success..');
        }
        else{
            $this->session->set_flashdata('feedback', 'Insert Failed..');
        }
    }

    /** Add MOre Addresss */
    public function Add_Address()
    {
        $data['customer']= $this->admin_model->get_all_customers();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Add_Address',$data, false);
        $this->load->view('Admin/footer');
    }

    /** Save Address */
    public function Save_Address()
    {
        $data = array( 'Customer_Icode' => $this->input->post('company_name'),
            'Customer_Add_GSTIN' =>$this->input->post('gstin_number'),
            'Customer_Add_Address_1' =>$this->input->post('address'),
            'Customer_Add_Address_2' =>$this->input->post('address1'),
            'Customer_Add_Area' =>$this->input->post('area'),
            'Customer_Add_City' =>$this->input->post('city'),
            'Customer_Add_State' =>$this->input->post('state'),
            'Customer_Add_Phone' =>$this->input->post('phone'),
            'Customer_Add_Alternate_Phone' =>$this->input->post('alternate_phone'),
            'Customer_Add_Email_Id_1' =>$this->input->post('email_1'),
            'Customer_Add_Email_Id_2' =>$this->input->post('email_2'),
            'Customer_Add_Created_By' => $this->session->userdata['userid']);
        $insert = $this->admin_model->save_address($data);
        if($insert == 1)
        {
            redirect('Admin_Controller/View_Customers');
            $this->session->set_flashdata('feedback', 'Insert Success..');
        }
        else{
            $this->session->set_flashdata('feedback', 'Insert Failed..');
        }
    }

    /** Our Company details  */
    public function Add_Stornglass()
    {
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Add_Stornglass');
        $this->load->view('Admin/footer');
    }

    /** Save Stronglass Details */
    public function Save_ST()
    {
        $data = array( 'ST_Name' => $this->input->post('company_name'),
            'ST_GSTIN' =>$this->input->post('gstin_number'),
            'ST_Address_1' =>$this->input->post('address'),
            'ST_Address_2' =>$this->input->post('address1'),
            'ST_Area' =>$this->input->post('area'),
            'ST_City' =>$this->input->post('city'),
            'ST_State' =>$this->input->post('state'),
            'ST_Phone' =>$this->input->post('phone'),
            'ST_Alternate_Phone' =>$this->input->post('alternate_phone'),
            'ST_Email_ID1' =>$this->input->post('email_1'),
            'ST_Email_ID2' =>$this->input->post('email_2'),
            'ST_Bank' =>$this->input->post('bank'),
            'ST_Bank_Account_Number' =>$this->input->post('account'),
            'ST_Bank_Account_Type' =>$this->input->post('account_type'),
            'ST_Bank_Account_IFSC_Code' =>$this->input->post('ifsc'),
            'ST_created_by' => $this->session->userdata['userid']);
        $insert = $this->admin_model->save_stronglass($data);
        if($insert == 1)
        {
            $datas = array('SGST%' =>$this->input->post('sgst'),
                'CGST%' =>$this->input->post('cgst'),
                'Tax_UpdatedBy' => $this->session->userdata['userid']);
            $insert = $this->admin_model->save_tax($datas);
            if($insert == 1)
            {
                redirect('Admin_Controller/Add_Address');
                $this->session->set_flashdata('feedback', 'Insert Success..');
            }
            else{
                $this->session->set_flashdata('feedback', 'Insert Failed..');
            }
        }
        else{
            $this->session->set_flashdata('feedback', 'Insert Failed..');
        }
    }
    /** View Stronglass */
    public function View_Stronglass()
    {
        $data['st']= $this->admin_model->get_ST();
        $data['tax']= $this->admin_model->get_Tax();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/View_Stronglass',$data,false);
        $this->load->view('Admin/footer');
    }
    /**Edit Our Company details  */
    public function Edit_Stornglass()
    {
        $data['tax']= $this->admin_model->get_last_Tax();
        $data['st']= $this->admin_model->get_ST();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Edit_Stronglass',$data,false);
        $this->load->view('Admin/footer');
    }

    /** Update Stronglass Details */
    public function Update_ST()
    {
        $id = $this->input->post('st_id');
        $tax_id =$this->input->post('tax_id');
        $data = array(
            'ST_Name' => $this->input->post('company_name'),
            'ST_GSTIN' =>$this->input->post('gstin_number'),
            'ST_Address_1' =>$this->input->post('address'),
            'ST_Address_2' =>$this->input->post('address1'),
            'ST_Area' =>$this->input->post('area'),
            'ST_City' =>$this->input->post('city'),
            'ST_State' =>$this->input->post('state'),
            'ST_Phone' =>$this->input->post('phone'),
            'ST_Alternate_Phone' =>$this->input->post('alternate_phone'),
            'ST_Email_ID1' =>$this->input->post('email_1'),
            'ST_Email_ID2' =>$this->input->post('email_2'),
            'ST_Bank' =>$this->input->post('bank'),
            'ST_Bank_Account_Number' =>$this->input->post('account'),
            'ST_Bank_Account_Type' =>$this->input->post('account_type'),
            'ST_Bank_Account_IFSC_Code' =>$this->input->post('ifsc'),
            'ST_created_by' => $this->session->userdata['userid']);
        $insert = $this->admin_model->update_stronglass($data, $id);
        if($insert == 1)
        {
            $datas = array('SGST%' =>$this->input->post('sgst'),
                'CGST%' =>$this->input->post('cgst'),
                'Tax_UpdatedBy' => $this->session->userdata['userid']);
            $this->db->where('Tax_Icode',$tax_id);
            $this->db->update('tax_details', $datas);
            if($insert == 1)
            {
                $this->session->set_flashdata('feedback', 'Successfully Updated...');
                redirect('Admin_Controller/View_Stronglass');

            }
            else{
                $this->session->set_flashdata('feedback', 'Update Failed..');
            }
        }
        else
            {
            $this->session->set_flashdata('feedback', 'Update Failed..');
        }
    }

    /** Get PErticular customer details */
    public function get_Customer_Details()
    {
        $customer_id = $this->input->post('id',true);
        $data= $this->admin_model->get_customer_details($customer_id);
        echo  json_encode($data);
    }
    public function get_Customer_Address_Details()
    {
        $customer_id = $this->input->post('id',true);
        $data= $this->admin_model->get_single_Customer_Locations($customer_id);
        echo  json_encode($data);
    }
    /** Get customer more address */
    public function get_Customer_Address()
    {
        $customer_id = $this->input->post('id',true);
        $data= $this->admin_model->get_Customer_Address($customer_id);
        $output =null;
        foreach ($data as $row)
        {
            $output .= "<option value='".$row['Customer_Address_Icode']."'>".$row['Customer_Add_City']."</option>";
        }
        echo  $output;

    }
    /** Proforma_Invoice */
    public function Proforma_Invoice()
    {
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Invoice');
        $this->load->view('Admin/footer');
    }
    /** Upload excel data to list */
    public function Upload_Invoice()
    {
        $configUpload['upload_path'] = FCPATH.'uploads/excel/';
        $configUpload['allowed_types'] = 'xls|xlsx|csv';
        $configUpload['max_size'] = '5000';
        $this->load->library('upload', $configUpload);
        $this->upload->do_upload('userfile');
        $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
        $file_name = $upload_data['file_name']; //uploded file name
        $extension=$upload_data['file_ext'];    // uploded file extension

        //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003
        $objReader= PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007
        //Set to read only
        $objReader->setReadDataOnly(true);
        //Load excel file
        $objPHPExcel=$objReader->load(FCPATH.'uploads/excel/'.$file_name);
        $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel
        $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);
        //loop from first data untill last data
        for($i=2;$i<=$totalrows;$i++)
        {
            $thickness=$objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
            $height=$objWorksheet->getCellByColumnAndRow(1,$i)->getValue();
            $width=$objWorksheet->getCellByColumnAndRow(2,$i)->getValue();
            $pics=$objWorksheet->getCellByColumnAndRow(3,$i)->getValue();
            $holes=$objWorksheet->getCellByColumnAndRow(4,$i)->getValue();
            $types=$objWorksheet->getCellByColumnAndRow(5,$i)->getValue();
            $charge_height = $height + 30;
            $charge_weigth = $width + 30;
            $area = $charge_height/1000 * $charge_weigth/1000;
            $data_user[]=array(
                'Thickness'=>$thickness,
                'height'=>$height,
                'width'=>$width,
                'pics'=>$pics,
                'holes'=>$holes,
                'type'=>$types,
                'ch_height'=>$charge_height,
                'ch_weight'=>$charge_weigth,
                'area'=>$area );
        }
        $month =date('m');
        $data['invoice'] =  $data_user;
        $data['st']= $this->admin_model->get_ST();
        $data['customer']= $this->admin_model->get_all_customers();
        $data['stock']= $this->admin_model->get_all_item();
        $data['charges']= $this->admin_model->get_all_charges();
        $data['tax']= $this->admin_model->get_Tax();
        $perfoma = $this->admin_model->get_profoma_number($month);
        if($perfoma == 0)
        {
            $data['profoma_number'] = $month .'-101';
        }
        else
        {
            $myString = $perfoma[0]['Proforma_Number'];
            $myArray = explode('-', $myString);
            $increment = $myArray[1] + 1;
            $data['profoma_number'] = $month .'-'. $increment;

        }
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/View_Invoice',$data,false);
        $this->load->view('Admin/footer');
    }
    /*Material Revise History*/
    public function Revice_History(){
        $data['inventary']= $this->admin_model->get_all_inventary();
        $data['stock']= $this->admin_model->get_all_Revised_item();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Revice_History',$data,false);
        $this->load->view('Admin/footer');
    }
    /*View Material Revice History*/
    public function View_Material_Revice_History(){
        $material_id = $this->input->post('id',true);
        $data = $this->admin_model->get_revised_material($material_id);
        $i=1;
        $output =null;
        foreach ($data as $key)
        {
            $output .="<tr>";
            $output .="<td>".$i ."</td>";
            $output .="<td>".$key['Material_Old_Price']."</td>";
            $output .="<td>".$key['Material_Price_Revised_Date']."</td>";
            $output .="</tr>";
            $i++;
        }
        echo $output;
    }
    /** Revise Charge History */
    public function Revice_Charge_History()
    {
        $data['charges']= $this->admin_model->get_all_Revised_Charges();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Revice_Charges_History',$data,false);
        $this->load->view('Admin/footer');
    }
    /** View Charges History */
    public function View_Charges_Revice_History()
    {
        $charges_id = $this->input->post('id',true);
        $data = $this->admin_model->get_revised_charges($charges_id);
        $i=1;
        $output =null;
        foreach ($data as $key)
        {
            $output .="<tr>";
            $output .="<td>".$i ."</td>";
            $output .="<td>".$key['charge_old_price']."</td>";
            $output .="<td>".$key['charge_revised_on']."</td>";
            $output .="</tr>";
            $i++;
        }
        echo $output;
    }
    /** Inward History */
    public function Inward_History()
    {
        $data['inventary']= $this->admin_model->get_all_inventary();
        $data['stock']= $this->admin_model->get_all_item();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Inventry_History',$data,false);
        $this->load->view('Admin/footer');
    }
    //** get date rage inventry history details */
    public function Get_Date_inventry_history()
    {
        $from_date = $this->input->post('from_date',true);
        $to_date = $this->input->post('to_date',true);
        $data = $this->admin_model->get_Date_inventary($from_date,$to_date);
        $i=1;
        $output =null;
        foreach ($data as $key)
        {
            $output .="<tr>";
            $output .="<td>".$i ."</td>";
            $output .="<td>".$key['Material_Name']."</td>";
            $output .="<td>".$key['Counts']."</td>";
            $output .="</tr>";
            $i++;
        }
        echo $output;
    }
    /** Get material Based History */
    public function Get_Material_inventry_history()
    {
        $from_date = $this->input->post('from_date',true);
        $to_date = $this->input->post('to_date',true);
        $material = $this->input->post('Material',true);
        $data = $this->admin_model->get_material_inventary($from_date,$to_date,$material);
        print_r($data);
        $i=1;
        $output =null;
        foreach ($data as $key)
        {
            $output .="<tr>";
            $output .="<td>".$i ."</td>";
            $output .="<td>".date('Y-m-d',strtotime($key['Material_Qty_Last_Added_Date']))."</td>";
            $output .="<td>".$key['Material_Quantity_Added']."</td>";
            $output .="</tr>";
            $i++;
        }
        echo $output;
    }
    /** View Customer Details */
    public function View_Customers()
    {
        $data['customers']= $this->admin_model->get_all_Customer_details();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/View_Customers',$data,false);
        $this->load->view('Admin/footer');
    }
    /** get Single Customer Details */
    public function single_customer($id)
    {
        $customer_id = $this->uri->segment(3);
        $data['customers'] = $this->admin_model->get_single_Customer_details($customer_id);
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/View_Single_Customers',$data,false);
        $this->load->view('Admin/footer');
    }
    /** Edit Customers */
    public function Edit_Customers ($id)
    {
        $customer_id = $this->uri->segment(3);
        $data['customers'] = $this->admin_model->get_single_Customer_details($customer_id);
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Edit_Customers',$data,false);
        $this->load->view('Admin/footer');
    }
    /** Update Customers */
    public function Update_Customer()
    {
        $id = $this->input->post('customer_id');
        $data = array(
            'Customer_Company_Name' => $this->input->post('company_name'),
            'Customer_GSTIN' =>$this->input->post('gstin_number'),
            'Customer_Address_1' =>$this->input->post('address'),
            'Customer_Address_2' =>$this->input->post('address1'),
            'Customer_Area' =>$this->input->post('area'),
            'Customer_City' =>$this->input->post('city'),
            'Customer_State' =>$this->input->post('state'),
            'Customer_Phone' =>$this->input->post('phone'),
            'Customer_Reference' =>$this->input->post('Reference'),
            'Customer_Alternate_Phone' =>$this->input->post('alternate_phone'),
            'Customer_Email_Id_1' =>$this->input->post('email_1'),
            'Customer_Email_Id_2' =>$this->input->post('email_2'),
            'Customer_Created_By' => $this->session->userdata['userid']);
            $this->db->where('Customer_Icode',$id);
           $this->db->update('customer_master', $data);
        $this->session->set_flashdata('feedback', 'Data Updated..');
        redirect('Admin_Controller/View_Customers');
    }
    /** locations */
    public function Locations($id)
    {
        $customer_id = $this->uri->segment(3);
        $data['customers'] = $this->admin_model->get_location_details($customer_id);
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Customer_Locations',$data,false);
        $this->load->view('Admin/footer');
    }
    /** Single locations Details */
    public function single_Locations($id)
    {
        $customer_id = $this->uri->segment(3);
        $data['customers'] = $this->admin_model->get_single_Customer_Locations($customer_id);
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/View_Single_Locations',$data,false);
        $this->load->view('Admin/footer');
    }
    /** Edit Customer locations */
    public function Edit_Locations($id)
    {
        $customer_id = $this->uri->segment(3);
        $data['customers'] = $this->admin_model->get_single_Customer_Locations($customer_id);
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Edit_Locations',$data,false);
        $this->load->view('Admin/footer');
    }
    /** Update Locations */
    public function Update_Locations()
    {
        $id = $this->input->post('customer_Address_id');
        $data = array(
            'Customer_Icode' => $this->input->post('customer_icode'),
            'Customer_Add_GSTIN' =>$this->input->post('gstin_number'),
            'Customer_Add_Address_1' =>$this->input->post('address'),
            'Customer_Add_Address_2' =>$this->input->post('address1'),
            'Customer_Add_Area' =>$this->input->post('area'),
            'Customer_Add_City' =>$this->input->post('city'),
            'Customer_Add_State' =>$this->input->post('state'),
            'Customer_Add_Phone' =>$this->input->post('phone'),
            'Customer_Add_Alternate_Phone' =>$this->input->post('alternate_phone'),
            'Customer_Add_Email_Id_1' =>$this->input->post('email_1'),
            'Customer_Add_Email_Id_2' =>$this->input->post('email_2'),
            'Customer_Add_Created_By' => $this->session->userdata['userid']);
        $this->db->where('Customer_Address_Icode',$id);
        $this->db->update('customer_add_address', $data);
        $this->session->set_flashdata('feedback', 'Data Updated..');
        redirect('Admin_Controller/View_Customers');
    }

    /** Save Invoice */
    public function Save_Invoice()
    {
        $address =$this->input->post('company_address');
        if($address == 0)
        {
            $profoma_address= '0';
        }
        else{
            $profoma_address= $this->input->post('company_address');
        }
        $data = array(
            'Proforma_Number' => $this->input->post('invoice_no'),
            'Proforma_Date' => $this->input->post('invoice_date'),
            'Proforma_Customer_Icode' => $this->input->post('company_name'),
            'Proforma_Delivery_Address_Icode' =>$profoma_address ,
            'Sub_Total' => $this->input->post('sub_tot'),
            'Insurance_Value' => $this->input->post('insurance'),
            'SGST_Value' => $this->input->post('sgst'),
            'CGST_Value' => $this->input->post('cgst'),
            'GrossTotal_Value' => $this->input->post('gross_tot'),
            'Proforma_Generated_By' => $this->session->userdata['userid']);
        $insert = $this->admin_model->Insert_Profoma_Invoice($data);
        if($insert != 0)
        {
            $material_id = $this->input->post('material');
            $hsn = $this->input->post('hsn');
            $qty = $this->input->post('pics');
            $special = $this->input->post('type');
            $holes = $this->input->post('holes');
            $actual_W = $this->input->post('width');
            $actual_H = $this->input->post('height');
            $Charge_W = $this->input->post('ch_weight');
            $Charge_H = $this->input->post('ch_height');
            $Area = $this->input->post('area');
            $Rate = $this->input->post('rate');
            $cost = $this->input->post('total');
            $count = sizeof($material_id);
            for($i=0; $i<$count; $i++)
            {
                $full_data =array( 'Proforma_Icode' => $insert,
                    'Proforma_Date' => $this->input->post('invoice_date'),
                    'Proforma_Material_Icode' => $material_id[$i],
                    'Proforma_HSNCode' => $hsn[$i],
                    'Proforma_Special' => $special[$i],
                    'Proforma_Holes' => $holes[$i],
                    'Proforma_Qty' => $qty[$i],
                    'Proforma_Actual_Size_Width' => $actual_W[$i],
                    'Proforma_Actual_Size_Height' => $actual_H[$i],
                    'Proforma_Chargeable_Size_Width' =>$Charge_W[$i],
                    'Proforma_Chargeable_Size_Height' => $Charge_H[$i],
                    'Proforma_Area_SQMTR' => $Area[$i],
                    'Proforma_Material_Rate' => $Rate[$i],
                    'Proforma_Material_Cost' => $cost[$i],
                    'created_by' => $this->session->userdata['userid']);
                $insert_item = $this->admin_model->Insert_Profoma_Item($full_data);
            }
            $charges_id = $this->input->post('charges');
            $charges_count = $this->input->post('no_holes');
            $charges_value = $this->input->post('charge_amt');
            $charges_cost = $this->input->post('tot_charge_amt');
            $count1 = sizeof($charges_id);
            for($i=0; $i<$count1; $i++)
            {
                $full_data1 =array( 'Proforma_Icode' => $insert,
                    'Proforma_Charge_Icode' => $charges_id[$i],
                    'Proforma_Charge_Count' => $charges_count[$i],
                    'Proforma_Charge_Value' => $charges_value[$i],
                    'Proforma_Charge_Cost' => $charges_cost[$i],
                    'created_by' => $this->session->userdata['userid']);
                $insert_charges = $this->admin_model->Insert_Profoma_Charges($full_data1);
            }
            $this->session->set_flashdata('feedback', 'Profoma Generated ..');
            redirect('Admin_Controller/Proforma_Invoice');
        }
    }
    /** Invoice List */
    public function Invoice_List()
    {
        $data['invoice'] = $this->admin_model->get_All_Invoice();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Invoice_List',$data,false);
        $this->load->view('Admin/footer');

    }
    /*Get Company Name*/
    public function GetCountryName(){
        $search_data = $this->input->post('search_data');
        $result = $this->admin_model->GetRow($search_data);
        if (!empty($result))
        {
            foreach ($result as $row):
                echo "<li><a href='javascript:;'  onclick='get_row(". $row['Customer_Icode'] .")' >" . $row['Customer_Company_Name'] . "</a></li>";
            endforeach;
        }
        else
        {
            echo "<li> <em> Not found ... </em> </li>";
        }
    }
    /*Get Company Name*/
    /** Get Single Invoice Details */
    public function single_Invoice($id)
    {
        $pi_icode = $this->uri->segment(3);
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->admin_model->Get_Single_Invoice_Item($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->admin_model->Get_Single_Invoice_Item_Total($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['User']=$this->user_model->Get_User_Details($pi_icode);
        $data['check_user']=$this->user_model->Get_Check_User_Details();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/View_Single_Invoice',$data,false);
        $this->load->view('Admin/footer');
    }
    /** Get Single Invoice Details */
    /** Save Work Order */
    public function Save_Work_Order()
    {
        $month =date('m');
        $perfoma = $this->admin_model->get_WO_number($month);
        if($perfoma == 0)
        {
            $WO_Number = $month .'-101';
        }
        else
        {
            $myString = $perfoma[0]['WO_Number'];
            $myArray = explode('-', $myString);
            $increment = $myArray[1] + 1;
            $WO_Number = $month .'-'. $increment;

        }

        $data = array(
            'WO_Number' => $WO_Number,
            'Proforma_Icode' => $this->input->post('PI_Icode'),
            'Proforma_Number' => $this->input->post('invoice_no'),
            'WO_Confirm_Date' =>date('Y-m-d') ,
            'WO_Created_By' => $this->session->userdata['userid']);
        $insert = $this->admin_model->Insert_WO($data);
        if($insert != 0)
        {
            $item_icode =  $this->input->post('material');
            $Qty =  $this->input->post('pics');
            $count = sizeof($item_icode);
            for($i=0; $i<$count; $i++)
            {
                $data1 = array(
                    'WO_Icode' =>  $insert,
                    'Proforma_Icode' => $this->input->post('PI_Icode'),
                    'Proforma_Invoice_Item_Icode' => $item_icode[$i],
                    'Total_Qty' =>$Qty[$i] ,
                    'Cutting_Remaining_Qty' =>'0',
                    'Furnace_Remaining_Qty' =>'0',
                    'Dispatch_Remaining_Qty' =>'0');
                $insert_process = $this->admin_model->Insert_WO_Process($data1);
            }
            $id=$this->input->post('PI_Icode');
            $update = array('WO_Confirm' => '1');
            $this->db->where('Proforma_Icode',$id);
            $this->db->update('proforma_invoice', $update);

            $this->session->set_flashdata('feedback', 'Work Order Generated ..');
            redirect('Admin_Controller/Invoice_List');
        }
    }
    /** Edit Profroma Invoice */
    public function Edit_Invoice($id)
    {
        $pi_icode = $this->uri->segment(3);
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->admin_model->Get_Single_Invoice_Item($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->admin_model->Get_Single_Invoice_Item_Total($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['charges']= $this->admin_model->get_all_charges();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Edit_Invoice',$data,false);
        $this->load->view('Admin/footer');
    }
    public function Update_Invoice()
    {
        $picode = $this->input->post('PI_Icode');
        $address =$this->input->post('company_address');
        if($address == 0)
        {
            $profoma_address= '0';
        }
        else{
            $profoma_address= $this->input->post('company_address');
        }
        $data = array(
            'Proforma_Number' => $this->input->post('invoice_no'),
            'Proforma_Date' => $this->input->post('invoice_date'),
            'Proforma_Customer_Icode' => $this->input->post('company_name'),
            'Proforma_Delivery_Address_Icode' =>$profoma_address ,
            'Sub_Total' => $this->input->post('sub_tot'),
            'Insurance_Value' => $this->input->post('insurance'),
            'SGST_Value' => $this->input->post('sgst'),
            'CGST_Value' => $this->input->post('cgst'),
            'GrossTotal_Value' => $this->input->post('gross_tot'),
            'Proforma_Generated_By' => $this->session->userdata['userid']);
            $this->db->where('Proforma_Icode',$picode);
            $this->db->update('proforma_invoice', $data);

            $material_id = $this->input->post('material');
            $qty = $this->input->post('pics');
            $holes = $this->input->post('holes');
            $Rate = $this->input->post('rate');
            $cost = $this->input->post('total');
            $count = sizeof($material_id);
            for($i=0; $i<$count; $i++)
            {
                $full_data =array( 'Proforma_Icode' => $picode,
                    'Proforma_Holes' => $holes[$i],
                    'Proforma_Qty' => $qty[$i],
                    'Proforma_Material_Rate' => $Rate[$i],
                    'Proforma_Material_Cost' => $cost[$i],
                    'created_by' => $this->session->userdata['userid']);
                $this->db->where('Proforma_Invoice_Items_Icode',$material_id[$i]);
                $this->db->update('proforma_invoice_items', $full_data);
            }
            $charges_id = $this->input->post('charges');
            if (empty($charges_id)) {
            }
            else{

                $charges_count = $this->input->post('no_holes');
                $charges_value = $this->input->post('charge_amt');
                $charges_cost = $this->input->post('tot_charge_amt');
                $count1 = sizeof($charges_id);
                for($i=0; $i<$count1; $i++)
                {
                    $full_data1 =array( 'Proforma_Icode' => $picode,
                        'Proforma_Charge_Icode' => $charges_id[$i],
                        'Proforma_Charge_Count' => $charges_count[$i],
                        'Proforma_Charge_Value' => $charges_value[$i],
                        'Proforma_Charge_Cost' => $charges_cost[$i],
                        'created_by' => $this->session->userdata['userid']);
                    $insert_charges = $this->admin_model->Insert_Profoma_Charges($full_data1);
                }
            }
            $this->session->set_flashdata('feedback', 'Updated Invoice..');
            redirect('Admin_Controller/Invoice_List');
        }

        /** Work Order */
        public function Work_Order()
        {
            $data['work_order']= $this->admin_model->get_all_work_order();
            $this->load->view('Admin/header');
            $this->load->view('Admin/top');
            $this->load->view('Admin/left');
            $this->load->view('Admin/Work_Order',$data,false);
            $this->load->view('Admin/footer');
        }
        /** View Work Order */
        public function View_Work_Order($id)
        {
            $wo_icode = $this->uri->segment(3);
            $data['work_order_desc']= $this->admin_model->get_Work_Order_Details($wo_icode);
            $data['work_order']= $this->admin_model->get_Single_Work_Order($wo_icode);
            $this->load->view('Admin/header');
            $this->load->view('Admin/top');
            $this->load->view('Admin/left');
            $this->load->view('Admin/View_Work_Order',$data, FALSE);
            $this->load->view('Admin/footer');
        }

        /** Current Status */
        public function Current_Status()
        {
            $data['hours']= $this->admin_model->get_all_work_order_within8();
            $data['hours16']= $this->admin_model->get_all_work_order_within16();
            $data['hours24']= $this->admin_model->get_all_work_order_within24();
            $data['hours48']= $this->admin_model->get_all_work_order_within48();
            $data['delays']= $this->admin_model->get_all_work_order_delay();
//            foreach ($data['delay'] as $val)
//            {
//                $wo_icode = $val['WO_Icode'];
//
//                $new[]= $this->admin_model->get_completed_result($wo_icode);
//            }
//            $data['delays']= $data['delay'] + $new;
//            print_r( $data['delays']);
            $this->load->view('Admin/header');
            $this->load->view('Admin/top');
            $this->load->view('Admin/left');
            $this->load->view('Admin/Current_Status',$data, FALSE);
            $this->load->view('Admin/footer');
        }
        /** View Work Order Status */
        public function View_WO_Status($id)
        {
            $wo_icode = $this->uri->segment(3);
            $data['work_order']= $this->admin_model->get_Single_Work_Order($wo_icode);
            $data['cutting']= $this->admin_model->get_cutting_status($wo_icode);
            $data['complete']= $this->admin_model->get_completed_status($wo_icode);
            $data['furnace']= $this->admin_model->get_furnace_status($wo_icode);
            $data['dispatch']= $this->admin_model->get_dispatch_status($wo_icode);
            $this->load->view('Admin/header');
            $this->load->view('Admin/top');
            $this->load->view('Admin/left');
            $this->load->view('Admin/WO_Status',$data, FALSE);
            $this->load->view('Admin/footer');
        }
        /** Complete Work Order */
        public function Complete_Work_Order()
        {
            $data['work_order']= $this->admin_model->get_complete_work_order();
            $this->load->view('Admin/header');
            $this->load->view('Admin/top');
            $this->load->view('Admin/left');
            $this->load->view('Admin/Completed_Work_Order',$data,false);
            $this->load->view('Admin/footer');
        }



        /** Manual Create Work Order */
        public function  Create_Work_Order()
        {
            $data['st']= $this->admin_model->get_ST();
            $data['customer']= $this->admin_model->get_all_customers();
            $data['stock']= $this->admin_model->get_all_item();
            $data['charges']= $this->admin_model->get_all_charges();
            $data['tax']= $this->admin_model->get_Tax();
            $this->load->view('Admin/header');
            $this->load->view('Admin/top');
            $this->load->view('Admin/left');
            $this->load->view('Admin/Create_Work_Order',$data, FALSE);
            $this->load->view('Admin/footer');
        }

        /** insert work order */
        public function Insert_WO()
        {
            $address =$this->input->post('company_address');
            if($address == 0)
            {
                $profoma_address= '0';
            }
            else{
                $profoma_address= $this->input->post('company_address');
            }
            $data = array(
                'Proforma_Number' => $this->input->post('invoice_no'),
                'Proforma_Date' => $this->input->post('invoice_date'),
                'Proforma_Customer_Icode' => $this->input->post('company_name'),
                'Proforma_Delivery_Address_Icode' =>$profoma_address ,
                'Sub_Total' => $this->input->post('sub_tot'),
                'Insurance_Value' => $this->input->post('insurance'),
                'SGST_Value' => $this->input->post('sgst'),
                'CGST_Value' => $this->input->post('cgst'),
                'IGST_Value' => $this->input->post('igst'),
                'GrossTotal_Value' => $this->input->post('gross_tot'),
                'WO_Confirm' => '1',
                'Proforma_Generated_By' => $this->session->userdata['userid']);
            $insert = $this->admin_model->Insert_Profoma_Invoice($data);
            if($insert != 0)
            {
                $material_id = $this->input->post('material');
                $hsn = $this->input->post('hsn');
                $qty = $this->input->post('pics');
                $special = $this->input->post('type');
                $holes = $this->input->post('holes');
                $actual_W = $this->input->post('width');
                $actual_H = $this->input->post('height');
                $Charge_W = $this->input->post('ch_weight');
                $Charge_H = $this->input->post('ch_height');
                $Area = $this->input->post('area');
                $Rate = $this->input->post('rate');
                $cost = $this->input->post('total');
                $count = sizeof($material_id);
                for($i=0; $i<$count; $i++)
                {
                    $full_data =array( 'Proforma_Icode' => $insert,
                        'Proforma_Date' => $this->input->post('invoice_date'),
                        'Proforma_Material_Icode' => $material_id[$i],
                        'Proforma_HSNCode' => $hsn[$i],
                        'Proforma_Special' => $special[$i],
                        'Proforma_Holes' => $holes[$i],
                        'Proforma_Qty' => $qty[$i],
                        'Proforma_Actual_Size_Width' => $actual_W[$i],
                        'Proforma_Actual_Size_Height' => $actual_H[$i],
                        'Proforma_Chargeable_Size_Width' =>$Charge_W[$i],
                        'Proforma_Chargeable_Size_Height' => $Charge_H[$i],
                        'Proforma_Area_SQMTR' => $Area[$i],
                        'Proforma_Material_Rate' => $Rate[$i],
                        'Proforma_Material_Cost' => $cost[$i],
                        'created_by' => $this->session->userdata['userid']);
                    $insert_item = $this->admin_model->Insert_Profoma_Item($full_data);
                }
                $charges_id = $this->input->post('charges');
                $charges_count = $this->input->post('no_holes');
                $charges_value = $this->input->post('charge_amt');
                $charges_cost = $this->input->post('tot_charge_amt');
                $count1 = sizeof($charges_id);
                for($i=0; $i<$count1; $i++)
                {
                    $full_data1 =array( 'Proforma_Icode' => $insert,
                        'Proforma_Charge_Icode' => $charges_id[$i],
                        'Proforma_Charge_Count' => $charges_count[$i],
                        'Proforma_Charge_Value' => $charges_value[$i],
                        'Proforma_Charge_Cost' => $charges_cost[$i],
                        'created_by' => $this->session->userdata['userid']);
                    $insert_charges = $this->admin_model->Insert_Profoma_Charges($full_data1);
                }


                $data = array(
                    'WO_Number' => $this->input->post('wo_number'),
                    'Proforma_Icode' => $insert,
                    'Proforma_Number' => $this->input->post('invoice_no'),
                    'Total_Qty'=> $this->input->post('total_qty'),
                    'WO_Date' =>date('Y-m-d') ,
                    'WO_Confirm_Status' =>'1',
                    'WO_Created_By' => $this->session->userdata['userid']);
                $insert_wo = $this->admin_model->Insert_WO($data);
                if($insert_wo != 0)
                {
                    $item =  $this->admin_model->get_invoice_item($insert);
                    foreach ($item as $item_icode )
                    {
                        $data1 = array(
                            'WO_Icode' =>  $insert_wo,
                            'Proforma_Icode' => $insert,
                            'Proforma_Invoice_Item_Icode' => $item_icode['Proforma_Invoice_Items_Icode'],
                            'Total_Qty' =>$item_icode['Proforma_Qty'] ,
                            'Cutting_Remaining_Qty' =>'0',
                            'Furnace_Remaining_Qty' =>'0',
                            'Dispatch_Remaining_Qty' =>'0');
                        $insert_process = $this->admin_model->Insert_WO_Process($data1);
                    }

                    $update = array('WO_Confirm' => '1');
                    $this->db->where('Proforma_Icode',$insert);
                    $this->db->update('proforma_invoice', $update);

                    $this->session->set_flashdata('feedback', 'Work Order Generated ..');
                    redirect('Admin_Controller/Invoice_List');
                }
            }
        }

        /** Manual Create Work Order */

        //** Uploads */
    public function  Upload_Customer()
    {
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Data_Import');
    }

    public  function ExcelDataAdd_new() {
        $configUpload['upload_path'] = FCPATH.'uploads/excel/';
        $configUpload['allowed_types'] = 'xls|xlsx|csv';
        $configUpload['max_size'] = '5000';
        $this->load->library('upload', $configUpload);
        $this->upload->do_upload('userfile');
        $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
        $file_name = $upload_data['file_name']; //uploded file name
        $extension=$upload_data['file_ext'];    // uploded file extension

        //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003
        $objReader= PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007
        //Set to read only
        $objReader->setReadDataOnly(true);
        //Load excel file
        $objPHPExcel=$objReader->load(FCPATH.'uploads/excel/'.$file_name);
        $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel
        print_r($totalrows);
        $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);
        //loop from first data untill last data
        for($i=2;$i<=$totalrows;$i++)
        {
            $company_name=$objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
            $email=$objWorksheet->getCellByColumnAndRow(1,$i)->getValue();
            $phone=$objWorksheet->getCellByColumnAndRow(3,$i)->getValue();
            $phone1=$objWorksheet->getCellByColumnAndRow(4,$i)->getValue();
            $gstn=$objWorksheet->getCellByColumnAndRow(5,$i)->getValue();
            $add1=$objWorksheet->getCellByColumnAndRow(6,$i)->getValue();
            $add2=$objWorksheet->getCellByColumnAndRow(7,$i)->getValue();
            $add3=$objWorksheet->getCellByColumnAndRow(8,$i)->getValue();
            $add4=$objWorksheet->getCellByColumnAndRow(9,$i)->getValue();
            $add5=$objWorksheet->getCellByColumnAndRow(10,$i)->getValue();
            $data_user=array(
                'Customer_Company_Name'=>$company_name,
                'Customer_GSTIN'=>$gstn,
                'Customer_Address_1'=>$add1,
                'Customer_Address_2'=>$add2,
                'Customer_Area'=>$add3,
                'Customer_City'=>$add4,
                'Customer_State'=>$add5,
                'Customer_Phone'=>$phone,
                'Customer_Alternate_Phone'=>$phone1,
                'Customer_Email_Id_1'=>$email,
                'Customer_Created_By'=>$this->session->userdata['userid']);
            $insert= $this->admin_model->Insert_Customer($data_user);
         }

    }

    //** Work order Completed */
    public function WO_Monthly_Chart()
    {
        $data_count= $this->admin_model->Monthly_WO_Complete();
        print_r(json_encode($data_count, true));
    }
    //** Add New Stock */
    public function New_Stock()
    {
        $data['stock']= $this->admin_model->get_all_stock();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Stock_Master',$data, FALSE);
        $this->load->view('Admin/footer');
    }
    //** Insert Stock */
    public function Insert_Stock()
    {

        $data=array(
            'Stock_Name'=>$this->input->post('stock_name'),
            'Stock_Height'=>$this->input->post('stock_height'),
            'Stock_Width'=>$this->input->post('stock_width'),
            'Created_By'=>$this->session->userdata['userid']);
        $insert= $this->admin_model->Insert_Stock($data);
        if($insert == '1')
        {
            $this->session->set_flashdata('feedback', 'Stock Added Successfully ..');
            redirect('Admin_Controller/New_Stock');
        }
        else if($insert == '2')
        {
            $this->session->set_flashdata('feedback1', 'Already Insert This Stock ..');
            redirect('Admin_Controller/New_Stock');
        }
        else{
            $this->session->set_flashdata('feedback1', 'Insert Failed ..');
            redirect('Admin_Controller/New_Stock');
        }
    }
    //** Edit Stock */
    public function Edit_Stock()
    {
        $material_id = $this->input->post('id',true);
        $data = $this->admin_model->get_Stock($material_id);
        echo  json_encode($data);
    }
    //** Update Stock */
    public function Update_Stock()
    {
            $stock_icode = $this->input->post('Stock_icode');
            $data = array(  'Stock_Name' => $this->input->post('material_name'),
                'Stock_Height' =>$this->input->post('material_height'),
                'Stock_Width' => $this->input->post('material_width'));
            $this->db->where('Stock_Icode',$stock_icode);
            $this->db->update('stock_master', $data);
            $this->session->set_flashdata('feedback', 'Successfully Updated..');
            redirect('Admin_Controller/New_Stock');
    }
    //** Godown Entry */
    public function Godown_Entry()
    {
        $data['godown']= $this->admin_model->get_all_godown_stock();
        $data['stock']= $this->admin_model->get_all_stock();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Godown_Stock',$data, FALSE);
        $this->load->view('Admin/footer');
    }
    //** Get Godown Stock Qty */
    public function get_stock_quantity()
    {
        $material_id = $this->input->post('id',true);
        $data = $this->admin_model->get_stock_quantity($material_id);
        echo  json_encode($data);
    }
    public function get_factory_stock_quantity()
    {
        $material_id = $this->input->post('id',true);
        $data = $this->admin_model->get_factory_stock_quantity($material_id);
        echo  json_encode($data);
    }
    //** Save Godown Inventry */
    public function Save_Godown_Inward()
    {
        $Materials =  $this->input->post('material',true);
        $new_quantity = $this->input->post('new_qty',true);
        $total_quantity = $this->input->post('total_qty',true);
        $company = $this->input->post('company_name',true);
        $vehicle = $this->input->post('vehicle_no',true);
        $count = sizeof($Materials);
        for($i=0; $i<$count; $i++)
        {
            if ($Materials[$i] == "") {

            }
            else{
                $data = $this->admin_model->get_godown_inventry($Materials[$i]);

                if ($data == 0)
                {
                    $insert = array('Stock_Icode' => $Materials[$i],
                        'Current_Qty' =>$total_quantity[$i],
                        'Last_Added_Qty' =>$new_quantity[$i],
                        'Company_Name' =>$company[$i],
                        'Vehicle_No' =>$vehicle[$i],
                        'Created_By' => $this->session->userdata['userid']);
                    $insert_inventary = $this->admin_model->insert_Godown_inventary($insert);
                }
                else
                {
                    $insert = array('Stock_Icode' => $Materials[$i],
                        'Last_Added_Qty' =>$new_quantity[$i],
                        'Company_Name' =>$company[$i],
                        'Vehicle_No' =>$vehicle[$i],
                        'Last_Added_By' => $this->session->userdata['userid']);
                    $insert_history = $this->admin_model->insert_Godown_inventary_history($insert);
                    if($insert_history == 1)
                    {
                        $data = array(  'Current_Qty' => $total_quantity[$i],
                            'Last_Added_Qty' =>$new_quantity[$i],
                            'Company_Name' =>$company[$i],
                            'Vehicle_No' =>$vehicle[$i],
                            'Created_On' =>date('Y-m-d H:i:s'));
                        $this->db->where('Stock_Icode',$Materials[$i]);
                        $this->db->update('godown_stock_inventry', $data);
                    }
                    else{
                        echo 0;
                    }
                }
            }
        }
        $this->session->set_flashdata('feedback', 'Successfully Updated..');
        redirect('Admin_Controller/Godown_Entry');
    }
    /** Godown Inward History */
    public function Godown_Inward_History()
    {
        $data['inventary']= $this->admin_model->get_all_godown_stock();
        $data['stock']= $this->admin_model->get_all_stock();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Godown_Inventry_History',$data, FALSE);
        $this->load->view('Admin/footer');
    }
    //** get date rage Godown inventry history details */
    public function Get_Date_Godown_inventry_history()
    {
        $from_date = $this->input->post('from_date',true);
        $to_date = $this->input->post('to_date',true);
        $data = $this->admin_model->get_Date_Godown_inventary($from_date,$to_date);
        $i=1;
        $output =null;
        foreach ($data as $key)
        {
            $output .="<tr>";
            $output .="<td>".$i ."</td>";
            $output .="<td>".$key['Material_Name']."</td>";
            $output .="<td>".$key['Counts']."</td>";
            $output .="</tr>";
            $i++;
        }
        echo $output;
    }

    //** GET GODOWN to FACTORY */
    public function Godown_To_Factory()
    {
        $data['godown']= $this->admin_model->get_all_godown_stock();
        $data['stock']= $this->admin_model->get_all_godown_Current_stock();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Godown_To_Factory',$data, FALSE);
        $this->load->view('Admin/footer');
    }
    //** Save OUTWARD  */
    public function Save_Godown_Outward()
    {
        $Materials =  $this->input->post('material',true);
        $new_quantity = $this->input->post('new_qty',true);
        $total_quantity = $this->input->post('total_qty',true);
        $count = sizeof($Materials);

        for($i=0; $i<$count; $i++)
        {

            if ($Materials[$i] == "") {

            }
            else{
                $data = $this->admin_model->get_godown_inventry($Materials[$i]);

                if ($data == 0)
                {
//                    $insert = array('Stock_Icode' => $Materials[$i],
//                        'Current_Qty' =>$total_quantity[$i],
//                        'Stock_Out_Qty' =>$new_quantity[$i],
//                        'Updated_By' => $this->session->userdata['userid'],
//                        'Updated_On' =>date('Y-m-d H:i:s'));
//                    $insert_inventary = $this->admin_model->insert_Godown_inventary($insert);
                }
                else
                {
                    $insert = array('Stock_Icode' => $Materials[$i],
                        'Stock_Out_Qty' =>$new_quantity[$i],
                        'Stock_Getting_By' => $this->session->userdata['userid']);
                    $insert_history = $this->admin_model->insert_godown_outward_history($insert);
                    if($insert_history == 1)
                    {
                        $data = array('Current_Qty' => $total_quantity[$i],
                            'Stock_Out_Qty' =>$new_quantity[$i],
                            'Updated_By' => $this->session->userdata['userid'],
                            'Updated_On' =>date('Y-m-d H:i:s'));
                        $this->db->where('Stock_Icode',$Materials[$i]);
                        $this->db->update('godown_stock_inventry', $data);
                    }
                    else{
                        echo 0;
                    }
                }
                $factory = $this->admin_model->get_factory_stock($Materials[$i]);
                $material = $Materials[$i];
                if (!empty($factory))
                {

                    $qty = $factory[0]['Current_Qty'] + $new_quantity[$i];
                    $data = array('Current_Qty' => $qty,
                        'Updated_By' => $this->session->userdata['userid'],
                        'Updated_On' =>date('Y-m-d H:i:s'));
                    $this->db->where('Stock_Icode',$material);
                    $this->db->update('Factory_Stock_details', $data);
                }
                else
                {
                    $insert = array('Stock_Icode' => $Materials[$i],
                        'Current_Qty' =>$new_quantity[$i],
                        'Created_By' => $this->session->userdata['userid'],
                        'Created_On' =>date('Y-m-d H:i:s'));
                    $insert_inventary = $this->admin_model->insert_factory_stock($insert);

                }
            }
        }
        $this->session->set_flashdata('feedback', 'Successfully Updated..');
        redirect('Admin_Controller/Godown_To_Factory');
    }
    //** Factory Stock */
    public function Factory_Stock()
    {
        $data['factory']= $this->admin_model->get_all_factory_stock();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Factory_Stock',$data, FALSE);
        $this->load->view('Admin/footer');
    }
    //** View Reviced Stock */
    public function View_Revice_Stock()
    {
        $stock_id = $this->input->post('id',true);
        $data = $this->admin_model->get_revised_godown_stock($stock_id);
        $i=1;
        $output =null;
        foreach ($data as $key)
        {
            $output .="<tr>";
            $output .="<td>".$i ."</td>";
            $output .="<td>".$key['Stock_Name']."<br>" .$key['Stock_Height']. "*" .$key['Stock_Width']. "</td>";
            $output .="<td>".$key['Last_Added_Qty']."</td>";
            $output .="<td>".$key['Company_Name']."</td>";
            $output .="<td>".$key['Vehicle_No']."</td>";
            $output .="<td>".$key['Last_Added_Date']."</td>";
            $output .="</tr>";
            $i++;
        }
        echo $output;
    }
    /** View Sheet Work Order */
    public function View_Sheet_Work_Order($id)
    {
        $wo_icode = $this->uri->segment(3);
        $data['work_order_desc']= $this->admin_model->get_sheet_Work_Order_Details($wo_icode);
        $data['work_order']= $this->admin_model->get_Single_Work_Order($wo_icode);
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/View_Work_Order',$data, FALSE);
        $this->load->view('Admin/footer');
    }

    //** Print Godown Inward Stock */
    public function Print_Godown_Inward_Stock()
    {
        $data['godown']= $this->admin_model->get_all_godown_stock();
        $data['stock']= $this->admin_model->get_all_stock();
        $data['st']= $this->admin_model->get_ST();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Print_Godown_Inward_Stock',$data, FALSE);
        $this->load->view('Admin/footer');
    }

    //** Print Factory Stock */
    public function Print_Factory_Stock()
    {
        $data['factory']= $this->admin_model->get_all_factory_stock();
        $data['stock']= $this->admin_model->get_all_stock();
        $data['st']= $this->admin_model->get_ST();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Print_Factory_Stock',$data, FALSE);
        $this->load->view('Admin/footer');
    }

    //** View Profoma Invoice */
    public function profoma_invoice()
    {
        $data['invoice'] = $this->user_model->get_All_Invoice();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/View_PI',$data, FALSE);
        $this->load->view('Admin/footer');
    }
    /** Get Single sheet */
    public function single_sheet_Invoice()
    {
        $pi_icode = $this->uri->segment(3);
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->user_model->Get_Single_Invoice_Item_Sheet($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->user_model->Get_Single_Invoice_Item_Sheet_Total($pi_icode);
        $data['sheet'] = $this->user_model->Get_Single_Sheet($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['wo'] = $this->user_model->Get_Single_wo($pi_icode);
        $data['User']=$this->user_model->Get_User_Details($pi_icode);
        $data['check_user']=$this->user_model->Get_Check_User_Details();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/View_Sheet_PI',$data,false);
        $this->load->view('Admin/footer');
    }
    //** Factory Outwords */
    public function Factory_Outwords()
    {
        $data['factory_outword']= $this->admin_model->get_all_Factory_current_stock();
        $data['factory_outword_details']= $this->admin_model->get_all_Factory_Outword();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Factory_Outwords',$data, FALSE);
        $this->load->view('Admin/footer');
    }
    //** Save Factory utwords */
    public function Save_Factory_Outward()
    {
        $Materials =  $this->input->post('material',true);
        $new_quantity = $this->input->post('new_qty',true);
        $total_quantity = $this->input->post('total_qty',true);
        $count = sizeof($Materials);

        for($i=0; $i<$count; $i++)
        {

            if ($Materials[$i] == "") {

            }
            else{

                    $insert = array('Stock_Icode' => $Materials[$i],
                        'Stock_Out_Qty' =>$new_quantity[$i],
                        'Stock_Getting_By' => $this->session->userdata['userid']);
                    $insert_history = $this->admin_model->insert_factory_outward_history($insert);
                    if($insert_history == 1)
                    {
                        $data = array('Current_Qty' => $total_quantity[$i],
                            'Updated_By' => $this->session->userdata['userid'],
                            'Updated_On' =>date('Y-m-d H:i:s'));
                        $this->db->where('Stock_Icode',$Materials[$i]);
                        $this->db->update('Factory_Stock_details', $data);
                    }
                    else{
                        echo 0;
                    }

            }
        }
        $this->session->set_flashdata('feedback', 'Successfully Updated..');
        redirect('Admin_Controller/Factory_Stock');
    }

    //** Today Work Order */
    public function Today_Wo_Report()
    {
        $data['pi_count']= $this->admin_model->Get_Today_PI_Counts();
        $data['wo_count']= $this->admin_model->Get_Today_WO_Counts();

        $normal_wo = $this->admin_model->Get_Today_normal_WO_details();
        $sheet_wo = $this->admin_model->Get_Today_sheet_WO_details();

        $data['wo_details'] = array_merge($normal_wo, $sheet_wo);

        $data['wo_count']= $this->admin_model->Get_Today_WO_Counts();



        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Wo_Report',$data, FALSE);
        $this->load->view('Admin/footer');
    }

    public function Report_pdf()
    {
        $this->load->library('pdf');
        $data['st']= $this->admin_model->get_ST();
        $data['pi_count']= $this->admin_model->Get_Today_PI_Counts();
        $data['wo_count']= $this->admin_model->Get_Today_WO_Counts();

        $normal_wo = $this->admin_model->Get_Today_normal_WO_details();
        $sheet_wo = $this->admin_model->Get_Today_sheet_WO_details();

        $data['wo_details'] = array_merge($normal_wo, $sheet_wo);

        $data['wo_count']= $this->admin_model->Get_Today_WO_Counts();

        $body = $this->load->view('Admin/Pdf_Report',$data,TRUE);
        $this->pdf->loadHtml($body);
        $this->pdf->render();
        $this->pdf->stream("welcome.pdf", array("Attachment"=>0));
    }

    //** Today Delivery Report */
    public function Today_Delivery_Report()
    {
        $data['work_order']= $this->admin_model->Get_Not_Completed_WO();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/WO_Details',$data, FALSE);
        $this->load->view('Admin/footer');
    }

    public function Delivery_All_WO()
    {
        $data= $this->input->post('Wo_Icode', true);
        $string = trim($data,",");
        $process = explode(",", $string);
        foreach ($process as $key )
        {

            $update = array('WO_Completed' => '1',
                'WO_Completed_On' =>date('Y-m-d H:i:s'));
            $this->db->where('WO_Icode',$key);
            $this->db->update('work_order', $update);

            $insert_data = array('WO_Icode' => $key,
                'Delivery_Location' => $this->input->post('Delivery_Location', true),
                'Delivery_Date' => $this->input->post('Delivery_Date', true),
                'Vehicle_Number' => $this->input->post('Vehicle_No', true),
                'Driver_Name' => $this->input->post('Driver_Name', true) );
            $insert_delivery = $this->admin_model->insert_delivery_data($insert_data);

        }
        echo 1;
    }
    public function Today_Despatch_Report()
    {
        $normal_wo = $this->admin_model->Get_Today_normal_WO_details_kerala();
        $sheet_wo = $this->admin_model->Get_Today_sheet_WO_details_kerala();
        $data['wo_details'] = array_merge($normal_wo, $sheet_wo);
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Despatch_kerala_Report',$data, FALSE);
        $this->load->view('Admin/footer');
    }

    //** Chennai Despatch Report **/
   public function Chennai_Despatch_Report()
   {
        $normal_wo = $this->admin_model->Get_Today_normal_WO_details_chennai();
        $sheet_wo = $this->admin_model->Get_Today_sheet_WO_details_chennai();
        $data['wo_details'] = array_merge($normal_wo, $sheet_wo);
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Despatch_Chennai_Report',$data, FALSE);
        $this->load->view('Admin/footer');
   }

   //** Local Dispatch
   public function Local_Despatch_Report()
   {
        $normal_wo = $this->admin_model->Get_Today_normal_WO_details_local();
        $sheet_wo = $this->admin_model->Get_Today_sheet_WO_details_local();
        $data['wo_details'] = array_merge($normal_wo, $sheet_wo);
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Despatch_Local_Report',$data, FALSE);
        $this->load->view('Admin/footer');
   }
   //** Kerala PDF
   public function Kerala_pdf()
   {
        $this->load->library('pdf');
        $data['st']= $this->admin_model->get_ST();
        $normal_wo = $this->admin_model->Get_Today_normal_WO_details_kerala();
        $sheet_wo = $this->admin_model->Get_Today_sheet_WO_details_kerala();
        $data['wo_details'] = array_merge($normal_wo, $sheet_wo);
        $data['name'] = 'Kerala Despatch Report';
        $body = $this->load->view('Admin/Despatch_pdf',$data,TRUE);
        $this->pdf->loadHtml($body);
        $this->pdf->render();
        $this->pdf->stream("welcome.pdf", array("Attachment"=>0));
   }

      public function Chennai_pdf()
   {
      $this->load->library('pdf');
        $data['st']= $this->admin_model->get_ST();
       $normal_wo = $this->admin_model->Get_Today_normal_WO_details_chennai();
        $sheet_wo = $this->admin_model->Get_Today_sheet_WO_details_chennai();
        $data['wo_details'] = array_merge($normal_wo, $sheet_wo);
        $data['name'] = 'Chennai Despatch Report';
        $body = $this->load->view('Admin/Despatch_pdf',$data,TRUE);
        $this->pdf->loadHtml($body);
        $this->pdf->render();
        $this->pdf->stream("welcome.pdf", array("Attachment"=>0));
   }

    public function Local_pdf()
   {
       $this->load->library('pdf');
        $data['st']= $this->admin_model->get_ST();
       $normal_wo = $this->admin_model->Get_Today_normal_WO_details_local();
        $sheet_wo = $this->admin_model->Get_Today_sheet_WO_details_local();
        $data['wo_details'] = array_merge($normal_wo, $sheet_wo);
        $data['name'] = 'Local Despatch Report';
        $body = $this->load->view('Admin/Despatch_pdf',$data,TRUE);
        $this->pdf->loadHtml($body);
        $this->pdf->render();
        $this->pdf->stream("welcome.pdf", array("Attachment"=>0));
   }

   public function Pending_PI()
   {
        $data['pi_count']= $this->admin_model->Get_Today_PI_Counts();
        $data['pi_pending']= $this->admin_model->Get_Today_Pending_PI_counts();

        $normal_wo = $this->admin_model->Get_Today_normal_pending_details();
        $sheet_wo = $this->admin_model->Get_Today_sheet_pending_details();

        $data['pi_details'] = array_merge($normal_wo, $sheet_wo);
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Pending_PI',$data, FALSE);
        $this->load->view('Admin/footer');
   }
   public function Pending_pi_pdf()
   {
       $this->load->library('pdf');
        $data['st']= $this->admin_model->get_ST();
        $data['pi_count']= $this->admin_model->Get_Today_PI_Counts();
        $data['pi_pending']= $this->admin_model->Get_Today_Pending_PI_counts();

         $normal_wo = $this->admin_model->Get_Today_normal_pending_details();
        $sheet_wo = $this->admin_model->Get_Today_sheet_pending_details();

        $data['pi_details'] = array_merge($normal_wo, $sheet_wo);

        $body = $this->load->view('Admin/Pending_PI_Pdf',$data,TRUE);
        $this->pdf->loadHtml($body);
        $this->pdf->render();
        $this->pdf->stream("welcome.pdf", array("Attachment"=>0));
   }

   public function PI_Summary()
   {
       $this->load->view('Admin/header');
       $this->load->view('Admin/top');
       $this->load->view('Admin/left');
       $this->load->view('Admin/PI_Summary');
       $this->load->view('Admin/footer');
   }

   public function Print_PI_Summary()
   {
       $from_date = $this->input->post('from_date');
       $to_date = $this->input->post('to_date');
       $data['pi_count']= $this->user_model->Get_Today_PI_Counts($from_date,$to_date);
       $normal_wo = $this->user_model->Get_Today_normal_PI_details($from_date,$to_date);
       $sheet_wo = $this->user_model->Get_Today_sheet_PI_details($from_date,$to_date);
       $data['wo_details'] = array_merge($normal_wo, $sheet_wo);

       $data['st']= $this->admin_model->get_ST();
       $data['from_date']  =$from_date;
       $data['to_date']  =$to_date;
       $this->load->view('Admin/header');
       $this->load->view('Admin/top');
       $this->load->view('Admin/left');
       $this->load->view('Admin/Print_PI_Report',$data,false);
       $this->load->view('Admin/footer');
   }

    public function Print_PDF_PI($from,$to)
    {
        $this->load->library('pdf');
        $from_date = $from;
        $to_date = $to;
        $data['pi_count']= $this->user_model->Get_Today_PI_Counts($from_date,$to_date);
        $normal_wo = $this->user_model->Get_Today_normal_PI_details($from_date,$to_date);
        $sheet_wo = $this->user_model->Get_Today_sheet_PI_details($from_date,$to_date);
        $data['wo_details'] = array_merge($normal_wo, $sheet_wo);

        $data['st']= $this->admin_model->get_ST();
        $data['from_date']  =$from_date;
        $data['to_date']  =$to_date;

        $body = $this->load->view('User/Print_PI_Pdf',$data,TRUE);
        $this->pdf->loadHtml($body);
        $this->pdf->render();
        $this->pdf->stream("welcome.pdf", array("Attachment"=>0));
    }

    public function WO_Summary()
    {
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/WO_Summary');
        $this->load->view('Admin/footer');
    }

    //** Print work order report */
    public function  Print_WO_Report()
    {
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $data['wo_count']= $this->user_model->Get_WO_Counts($from_date,$to_date);
        $normal_wo = $this->user_model->Get_Today_normal_WO_details($from_date,$to_date);
        $sheet_wo = $this->user_model->Get_Today_sheet_WO_details($from_date,$to_date);
        $data['wo_details'] = array_merge($normal_wo, $sheet_wo);

        $normal_material = $this->user_model->Get_Today_normal_WO_material($from_date,$to_date);
        $sheet_material = $this->user_model->Get_Today_sheet_WO_material($from_date,$to_date);
        $data['material_details'] = array_merge($normal_material, $sheet_material);

        $data['st']= $this->admin_model->get_ST();
        $data['from_date']  =$from_date;
        $data['to_date']  =$to_date;
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Print_WO_Report',$data,false);
        $this->load->view('Admin/footer');
    }
    public function Print_PDF_WO($from,$to)
    {
        $this->load->library('pdf');
        $from_date = $from;
        $to_date = $to;
        $data['wo_count']= $this->user_model->Get_WO_Counts($from_date,$to_date);
        $normal_wo = $this->user_model->Get_Today_normal_WO_details($from_date,$to_date);
        $sheet_wo = $this->user_model->Get_Today_sheet_WO_details($from_date,$to_date);
        $data['wo_details'] = array_merge($normal_wo, $sheet_wo);

        $normal_material = $this->user_model->Get_Today_normal_WO_material($from_date,$to_date);
        $sheet_material = $this->user_model->Get_Today_sheet_WO_material($from_date,$to_date);
        $data['material_details'] = array_merge($normal_material, $sheet_material);

        $data['st']= $this->admin_model->get_ST();
        $data['from_date']  =$from_date;
        $data['to_date']  =$to_date;
        $body = $this->load->view('User/Print_WO_Pdf',$data,TRUE);
        $this->pdf->loadHtml($body);
        $this->pdf->render();
        $this->pdf->stream("welcome.pdf", array("Attachment"=>0));

    }

    public function Monthly_Report()
    {
        $data['pi_count']= $this->admin_model->Get_Monthly_PI_Counts();
        $data['wo_count']= $this->admin_model->Get_Monthly_WO_Counts();
        $data['wo_count_locations']= $this->admin_model->Get_Monthly_WO_Counts_locations();
        $data['total_bill']= $this->admin_model->Get_Monthly_Total_Bill();
//        $normal_material = $this->admin_model->Get_monthly_normal_WO_material();
        $data['sheet_material'] = $this->admin_model->Get_monthly_sheet_WO_material();
        $data['normal_material'] = $this->admin_model->Get_monthly_normal_pi_WO_material();
        $data['dg_material'] = $this->admin_model->Get_monthly_dg_pi_WO_material();
        $data['lamination_material'] = $this->admin_model->Get_monthly_lamination_pi_WO_material();

        $data['expenses']= $this->admin_model->Get_Monthly_Expenses();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Print_Monthly_Report',$data,false);
        $this->load->view('Admin/footer');
    }

    //** Despatch Report */
    public function Despatch_Report()
    {
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Despatch_Report',false);
        $this->load->view('Admin/footer');
    }
    //** Today Despatch Print */
    public  function  Today_Despatch_Print()
    {
        $delivery = $this->input->post('Delivery');
        $normal_wo = $this->admin_model->Get_Today_normal_Delivery_WO_details($delivery);
        $sheet_wo = $this->admin_model->Get_Today_sheet_Delivery_WO_details($delivery);
        $data['wo_details'] = array_merge($normal_wo, $sheet_wo);

        if (empty($data['wo_details'])) {
            $this->session->set_flashdata('feedback', 'No Record Found..');
            redirect('Admin_Controller/Despatch_Report');
        }
        else{
            $this->load->view('Admin/header');
            $this->load->view('Admin/top');
            $this->load->view('Admin/left');
            $this->load->view('Admin/Today_Despatch_Report',$data, FALSE);
            $this->load->view('Admin/footer');
        }
    }

    //** PDF Despatch */
    public function despatch_pdf($location)
    {
        $this->load->library('pdf');
        $normal_wo = $this->admin_model->Get_Today_normal_Delivery_WO_details($location);
        $sheet_wo = $this->admin_model->Get_Today_sheet_Delivery_WO_details($location);
        $data['wo_details'] = array_merge($normal_wo, $sheet_wo);
        $body = $this->load->view('Admin/Despatch_pdf',$data,TRUE);
        $this->pdf->loadHtml($body);
        $this->pdf->render();
        $this->pdf->stream("welcome.pdf", array("Attachment"=>0));
    }

    //** Expenses Master */
    public function Expenses_Master()
    {
        $data['expenses']= $this->admin_model->Get_All_Expenses();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Expenses_Master',$data, FALSE);
        $this->load->view('Admin/footer');
    }
    //** Insert Expenses */
    public function Insert_Expenses()
    {
        $insert_data = array(
            'Expenses_Name' => $this->input->post('expenses_name') );
        $this->db->insert('Expenses_Master', $insert_data);
        $this->session->set_flashdata('feedback', 'Expenses Added Successfully..');
        redirect('Admin_Controller/Expenses_Master');
    }
    //** Add Expenses */
    public function Add_Expenses()
    {
        $data['petty_cash']= $this->admin_model->Get_Petty_Cash();
        $data['expenses']= $this->admin_model->Get_All_Expenses();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Add_Expenses',$data, FALSE);
        $this->load->view('Admin/footer');
    }
    //** Insert Expenses Details */
    public function Insert_Expenses_Details()
    {
        $expense_Amount =  $this->input->post('amount');
        $petty =  $this->input->post('petty_amt');
        $new_petty = $petty - $expense_Amount;
        $inward = array('Petty_Cash' => $new_petty);
        $this->db->where('Petty_Cash_Icode', $this->input->post('petty_icode'));
        $this->db->update('petty_cash', $inward);
        $insert_data = array( 'Expenses_Icode' => $this->input->post('expenses'),
            'Expenses_Date' => $this->input->post('expenses_date'),
            'Amount' => $this->input->post('amount'),
            'Comments' => $this->input->post('comments'),
            'Created_By' => $this->session->userdata['userid']);
        $this->db->insert('Expenses_Details', $insert_data);
        $this->session->set_flashdata('feedback', 'Expenses Added Successfully..');
        redirect('Admin_Controller/View_Expenses');
    }

    //** View Expenses */
    public function View_Expenses()
    {
        $data['petty_cash']= $this->admin_model->Get_Petty_Cash();
        $data['st']= $this->admin_model->get_ST();
        $data['expenses']= $this->admin_model->Get_All_Expenses_details();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/View_Expenses',$data, FALSE);
        $this->load->view('Admin/footer');
    }

    //** Export PI */
    public function Export_PI()
    {
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Export_PI');
        $this->load->view('Admin/footer');
    }
    //** Export PI upload */
    /** Upload excel data to list */
    public function Upload_Export_Invoice()
    {
        $configUpload['upload_path'] = FCPATH.'uploads/excel/';
        $configUpload['allowed_types'] = 'xls|xlsx|csv';
        $configUpload['max_size'] = '5000';
        $this->load->library('upload', $configUpload);
        $this->upload->do_upload('userfile');
        $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
        $file_name = $upload_data['file_name']; //uploded file name
        $extension=$upload_data['file_ext'];    // uploded file extension

        //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003
        $objReader= PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007
        //Set to read only
        $objReader->setReadDataOnly(true);
        //Load excel file
        $objPHPExcel=$objReader->load(FCPATH.'uploads/excel/'.$file_name);
        $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel
        $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);
        //loop from first data untill last data
        for($i=2;$i<=$totalrows;$i++)
        {
            $thickness=$objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
            $height=$objWorksheet->getCellByColumnAndRow(1,$i)->getValue();
            $width=$objWorksheet->getCellByColumnAndRow(2,$i)->getValue();
            $types=$objWorksheet->getCellByColumnAndRow(5,$i)->getValue();

            if($types == 'T')
            {

                $heigh_val =  explode("/",$height);
                $length_H =  sizeof($heigh_val);
                if($length_H == '1')
                {
                    $charge_height = $heigh_val[0] + 50;
                    $height_check[] ="";
                }
                else
                {
                    if($heigh_val[0] > $heigh_val[1])
                    {

                        $charge_height = $heigh_val[0] + 50;
                        $height_check[] ="";
                    }
                    else
                    {
                        $charge_height = $heigh_val[1] + 50;
                        $height_check[] ="";
                    }
                }



                $width_val = explode("/",$width);
                $length_W =  sizeof($width_val);

                if($length_W == '1')
                {
                    $charge_weigth = $width_val[0] + 50;
                    $width_check[]="";
                }
                else{
                    if($width_val[0] > $width_val[1])
                    {

                        $charge_weigth = $width_val[0] + 50;
                        $width_check[]="";
                    }
                    else
                    {
                        $charge_weigth = $width_val[1] + 50;
                        $width_check[]="";
                    }
                }


            }
            else
            {
                if(is_numeric($height))
                {
                    $charge_height = $height + 30;
                    $height_check[] ="";
                }
                else{
                    $height_check[] ='1';
                }

                if(is_numeric($width))
                {
                    $charge_weigth = $width + 30;
                    $width_check[]="";
                }
                else{
                    $width_check[] ='1';
                }
            }

            $pics=$objWorksheet->getCellByColumnAndRow(3,$i)->getValue();
            if(is_numeric($pics))
            {
                $pics_check[]="";
            }
            else{

                $pics_check[] ='1';
            }
            $holes=$objWorksheet->getCellByColumnAndRow(4,$i)->getValue();
            if(is_numeric($holes))
            {
                $holes_check[]="";
            }
            else{
                $holes_check[] ='1';
            }
            $types=$objWorksheet->getCellByColumnAndRow(5,$i)->getValue();
            if($types == 'D' || $types == 'S' || $types == 'DS' || $types == 'B' || $types == 'D' )
            {
                $types_check[]="";
            }
            else{
                $types_check[] ='1';
            }
            $cutout=$objWorksheet->getCellByColumnAndRow(6,$i)->getValue();
//            if(is_numeric($cutout))
//            {
//                $cutout_check[]="";
//            }
//            else{
//                $cutout_check[] ='1';
//            }

            $areass = $charge_height/1000 * $charge_weigth/1000;
            $area1 = $areass * $pics;
            $area = number_format((float)$area1, 3, '.', '');
            $data_user[]=array(
                'Thickness'=>$thickness,
                'height'=>$height,
                'width'=>$width,
                'pics'=>$pics,
                'holes'=>$holes,
                'type'=>$types,
                'cutout'=>$cutout,
                'ch_height'=>$charge_height,
                'ch_weight'=>$charge_weigth,
                'area'=>$area );
        }
        $month =date('m');
        $data['invoice'] =  $data_user;
        $data['st']= $this->admin_model->get_ST();
        $data['customer']= $this->admin_model->get_all_customers();
        $data['stock']= $this->admin_model->get_all_item();
        $data['charges']= $this->admin_model->get_all_charges();
        $data['tax']= $this->admin_model->get_Tax();
        $perfoma = $this->admin_model->get_Export_profoma_number($month);
        if($perfoma == 0)
        {
            $data['profoma_number'] = $month .'-101';
        }
        else
        {
            $myString = $perfoma[0]['Export_Invoice_Number'];
            $myArray = explode('-', $myString);
            $increment = $myArray[1] + 1;
            $data['profoma_number'] = $month .'-'. $increment;

        }

        $check_H = count(array_keys($height_check, "1"));
        $check_W = count(array_keys($width_check, "1"));
        $check_P = count(array_keys($pics_check, "1"));
        $check_Holes = count(array_keys($holes_check, "1"));
        $check_Type = count(array_keys($types_check, "1"));
//        $check_cutout = count(array_keys($cutout_check, "1"));


        if($check_H =='0' and $check_W =='0' and $check_P =='0' and $check_Holes =='0'  )
        {
            unlink('uploads/excel/'.$file_name);
            $this->load->view('Admin/header');
            $this->load->view('Admin/top');
            $this->load->view('Admin/left');
            $this->load->view('Admin/View_Export_Invoice',$data,false);
            $this->load->view('Admin/footer');
        }
        else
        {
            $this->session->set_flashdata('feedback', 'Please Cross Check the values in the Excel Sheet.The Columns Height,Width,No.of.pieces,Holes Must have only Numeric values. Type must have only Alphabetic. Make corrections and load Again ..');
            redirect('Admin_Controller/Export_PI');
        }

    }

    //** Save Export Invoice */
    public function Save_Export_Invoice()
    {
        $address =$this->input->post('company_address');
        if($address == 0)
        {
            $profoma_address= '0';
        }
        else{
            $profoma_address= $this->input->post('company_address');
        }
        $month =date('m');
        $perfoma = $this->admin_model->get_Export_profoma_number($month);
        if($perfoma == 0)
        {
            $Invoice_Number = $month .'-101';
        }
        else
        {
            $myString = $perfoma[0]['Export_Invoice_Number'];
            $myArray = explode('-', $myString);
            $increment = $myArray[1] + 1;
            $Invoice_Number = $month .'-'. $increment;

        }
        $data = array(
            'Export_Invoice_Number' => $Invoice_Number,
            'Export_Date' => $this->input->post('invoice_date'),
            'Proforma_Customer_Icode' => $this->input->post('company_name'),
            'Proforma_Delivery_Address_Icode' =>$profoma_address ,
            'Container_Type' => $this->input->post('container_type'),
            'Delivery_Period' => $this->input->post('delivery'),
            'Payment_Terms' => $this->input->post('payment_Terms'),
            'Price_Term' => $this->input->post('price_Terms'),
            'Delivery_Route' => $this->input->post('Delivery_Route'),
            'Gross_Total'=>$this->input->post('grand_total'),
            'Created_By' => $this->session->userdata['userid']);
        $insert = $this->admin_model->Insert_Export_Profoma_Invoice($data);
        if($insert != 0)
        {
            $material_id = $this->input->post('material');
            $hsn = $this->input->post('hsn');
            $qty = $this->input->post('pics');
            $special = $this->input->post('type');
            $holes = $this->input->post('holes');
            $cutout = $this->input->post('cutout');
            $actual_W = $this->input->post('width');
            $actual_H = $this->input->post('height');
            $Charge_W = $this->input->post('ch_weight');
            $Charge_H = $this->input->post('ch_height');
            $Area = $this->input->post('area');
            $Rate = $this->input->post('rate');
            $cost = $this->input->post('total');
            $count = sizeof($material_id);
            for($i=0; $i<$count; $i++)
            {
                $full_data =array( 'Export_PI_Icode' => $insert,
                    'Export_Date' => $this->input->post('invoice_date'),
                    'Proforma_Material_Icode' => $material_id[$i],
                    'Proforma_HSNCode' => $hsn[$i],
                    'Proforma_Special' => $special[$i],
                    'Proforma_Holes' => $holes[$i],
                    'Proforma_Qty' => $qty[$i],
                    'Proforma_Cutout'=>$cutout[$i],
                    'Proforma_Actual_Size_Width' => $actual_W[$i],
                    'Proforma_Actual_Size_Height' => $actual_H[$i],
                    'Proforma_Chargeable_Size_Width' =>$Charge_W[$i],
                    'Proforma_Chargeable_Size_Height' => $Charge_H[$i],
                    'Proforma_Area_SQMTR' => $Area[$i],
                    'Proforma_Material_Rate' => $Rate[$i],
                    'Proforma_Material_Cost' => $cost[$i],
                    'created_by' => $this->session->userdata['userid']);
                $this->db->insert('export_items', $full_data);
            }

            $this->session->set_flashdata('feedback', 'PI Created Successfully ..');
            redirect('Admin_Controller/Export_Invoice_List');
        }
    }
    /** Export Invoice List */
    public function Export_Invoice_List()
    {
        $data['invoice'] = $this->admin_model->get_All_Export_Invoice();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Export_Invoice_List',$data,false);
        $this->load->view('Admin/footer');
    }
    //** Get Single Incoice */
    public function Get_Single_Export($export_id)
    {
        $data['invoice'] = $this->admin_model->Get_Single_Export_Invoice($export_id);
        $data['invoice_item'] = $this->admin_model->Get_Single_Export_Invoice_Item($export_id);
        $data['invoice_total'] = $this->admin_model->Get_Single_Export_Invoice_Item_Total($export_id);
        $data['st']= $this->admin_model->get_ST();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/View_Single_Export_Invoice',$data,false);
        $this->load->view('Admin/footer');
    }

    //** Export PDF */
    public function Export_Invoice_PDF()
    {
        $this->load->library('pdf');
        $export_id = $this->input->post('invoice_no');
        $data['invoice'] = $this->admin_model->Get_Single_Export_Invoice($export_id);
        $data['invoice_item'] = $this->admin_model->Get_Single_Export_Invoice_Item($export_id);
        $data['invoice_total'] = $this->admin_model->Get_Single_Export_Invoice_Item_Total($export_id);
        $data['st']= $this->admin_model->get_ST();
        $body = $this->load->view('Admin/Print_Export_PI_Pdf',$data,TRUE);
        $this->pdf->loadHtml($body);
        $this->pdf->render();
        $this->pdf->stream("welcome.pdf", array("Attachment"=>0));

    }

    // Local Sales Summary
    public function Local_Summary()
    {
        $data['wo_count_locations']= $this->admin_model->Get_Monthly_WO_Counts_locations();
        $data['charges_location']=$this->admin_model->Get_Monthly_Charges_Local();
        $data['transport']=$this->admin_model->Get_Monthly_Transport_Local();
        $normal_material = $this->admin_model->Get_monthly_normal_WO_material_local();
        $sheet_material = $this->admin_model->Get_monthly_sheet_WO_material_local();
        $data['material_details'] = array_merge($normal_material, $sheet_material);
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Sales_Summary_Local',$data,false);
        $this->load->view('Admin/footer');
    }

    public function Chennai_Summary()
    {
        $data['wo_count_locations']= $this->admin_model->Get_Monthly_WO_Counts_locations();
        $data['charges_location']=$this->admin_model->Get_Monthly_Charges_chennai();
        $data['transport']=$this->admin_model->Get_Monthly_Transport_chennai();
        $normal_material = $this->admin_model->Get_monthly_normal_WO_material_chennai();
        $sheet_material = $this->admin_model->Get_monthly_sheet_WO_material_chennai();
        $data['material_details'] = array_merge($normal_material, $sheet_material);
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Sales_Summary_Chennai',$data,false);
        $this->load->view('Admin/footer');
    }
    public function Kerala_Summary()
    {
        $data['wo_count_locations']= $this->admin_model->Get_Monthly_WO_Counts_locations();
        $data['charges_location']=$this->admin_model->Get_Monthly_Charges_kerala();
        $data['transport']=$this->admin_model->Get_Monthly_Transport_kerala();
        $normal_material = $this->admin_model->Get_monthly_normal_WO_material_kerala();
        $sheet_material = $this->admin_model->Get_monthly_sheet_WO_material_kerala();
        $data['material_details'] = array_merge($normal_material, $sheet_material);
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Sales_Summary_Kerala',$data,false);
        $this->load->view('Admin/footer');
    }

    public function Accounts()
    {
        $data['wo_count']= $this->admin_model->Get_Monthly_WO_Counts();
        $data['bill_count']= $this->admin_model->Get_Monthly_Bill_Counts();
        $data['bill_account']= $this->admin_model->Get_Monthly_Bill_Accounts();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Account_Report',$data,false);
        $this->load->view('Admin/footer');
    }

    public function Inward_Cash()
    {
        $data['petty_cash']= $this->admin_model->Get_Petty_Cash();
        $data['inward']= $this->admin_model->Get_Inward_Cash();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Inward_Cash',$data,false);
        $this->load->view('Admin/footer');
    }
    public function Insert_Inward_Details()
    {
       $inward_Amount =  $this->input->post('amount');
       $petty =  $this->input->post('petty_amt');
       $new_petty = $petty + $inward_Amount;
        $inward = array('Petty_Cash' => $new_petty);
        $this->db->where('Petty_Cash_Icode', $this->input->post('petty_icode'));
        $this->db->update('petty_cash', $inward);

        $insert_data = array( 'Petty_Cash_Icode' => $this->input->post('petty_icode'),
            'Inward_Amount' => $this->input->post('amount'),
            'Inward_Details' => $this->input->post('comments'),
            'Created_By' => $this->session->userdata['userid']);
        $this->db->insert('Inward_Cash', $insert_data);
        $this->session->set_flashdata('feedback', 'Inward Cash Added Successfully..');
        redirect('Admin_Controller/Inward_Cash');
    }

}