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

        public function View_WO()
        {

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
        $data['stock']= $this->admin_model->get_all_stock();
        $this->load->view('Admin/header');
        $this->load->view('Admin/top');
        $this->load->view('Admin/left');
        $this->load->view('Admin/Godown_To_Factory',$data, FALSE);
        $this->load->view('Admin/footer');
    }




}