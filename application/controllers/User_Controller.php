<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->user_name == "") {
            redirect('Login');
        }
        $this->load->helper('url');
        /***** LOADING HELPER TO AVOID PHP ERROR ****/
        $this->load->model('User_Model', 'user_model'); /* LOADING MODEL * User_Model as user_model */
        $this->load->model('Admin_Model','admin_model');
        $this->load->library('session');
        $this->load->library('excel');
        $this->session->set_flashdata('message');
    }
    /** User Dashboard */
    public function dashboard()
    {
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/dashboard');
        $this->load->view('User/footer');
    }

    /** Get Work Order */
    public function Work_Order()
    {
        $data['work_order']= $this->user_model->get_all_Work_Order();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Work_Order',$data, FALSE);
        $this->load->view('User/footer');
    }
    /** Start Work Order */
    public function Start_Work_Order($id)
    {
        $wo_id = $this->uri->segment(3);
        $data['work_order_desc']= $this->user_model->get_Work_Order_Details($wo_id);
        $data['work_order']= $this->user_model->get_Single_Work_Order($wo_id);
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/View_Work_Order',$data, FALSE);
        $this->load->view('User/footer');
    }
    /** Save WO  */
    public function Save_WO_Item()
    {
        $role =  $this->session->userdata['role'];
        if($role == 2) //  Cutting
        {
            $total_qty = $this->input->post('Total_Qty',true);
            $remain = $this->input->post('Qty',true);
            $Income = $total_qty - $remain;
            $wo_icode = $this->input->post('Process_Icode',true);
            $data =array('WO_Icode' => $this->input->post('Wo_Icode',true),
                'WO_Process_Icode' => $this->input->post('Process_Icode',true),
                'Proforma_Invoice_Items_Icode' => $this->input->post('Item_Icode',true),
                'Cutting_Remaining_Qty  ' => $this->input->post('Qty',true),
                'Remaining_Comments' => $this->input->post('Comments',true),
                'Cutting_Status' => $this->input->post('Status',true),
                'Created_By' => $this->session->userdata['userid']);
            $insert = $this->user_model->Insert_Cutting($data);
            if($insert == 1)
            {
                $update = array('Cutting_Remaining_Qty' => $this->input->post('Qty',true),
                    'Furnace_Incoming' => $Income,
                    'Furnace_Status' => '1',
                    'Cutting_Status' => $this->input->post('Status',true) );
                $this->db->where('WO_Process_Icode',$wo_icode);
                $this->db->update('wo_processing', $update);
                echo 1;
            }
            else{
                echo 0;
            }

        }
        elseif ($role == 3) // Fornace
        {
            $Furnace_income = $this->input->post('Furnace_Income',true);
            $remain = $this->input->post('Qty',true);
            $Disptach_Income = $Furnace_income - $remain;
            $wo_icode = $this->input->post('Process_Icode',true);
            $data =array('WO_Icode' => $this->input->post('Wo_Icode',true),
                'WO_Process_Icode' => $this->input->post('Process_Icode',true),
                'Proforma_Invoice_Items_Icode' => $this->input->post('Item_Icode',true),
                'Cutting_Income' => $this->input->post('Furnace_Income',true),
                'Furnace_Remaining_Qty  ' => $this->input->post('Qty',true),
                'Remaining_Comments' => $this->input->post('Comments',true),
                'Furnace_Status' => $this->input->post('Status',true),
                'Created_By' => $this->session->userdata['userid']);
            $insert = $this->user_model->Insert_Furnace($data);
            if($insert == 1)
            {
                $update = array('Furnace_Remaining_Qty' => $this->input->post('Qty',true),
                    'Dispatch_Incoming' => $Disptach_Income,
                    'Furnace_Incoming' => '0',
                    'Dispatch_Status' => '1',
                    'Furnace_Status' => $this->input->post('Status',true) );
                $this->db->where('WO_Process_Icode',$wo_icode);
                $this->db->update('wo_processing', $update);
                echo 1;
            }
            else{
                echo 0;
            }

        }
        elseif ($role == 4) // Dispatch
        {
            $wo_icode = $this->input->post('Process_Icode',true);
            $data =array('WO_Icode' => $this->input->post('Wo_Icode',true),
                'WO_Process_Icode' => $this->input->post('Process_Icode',true),
                'Proforma_Invoice_Items_Icode' => $this->input->post('Item_Icode',true),
                'Dispatch_Remaining_Qty  ' => $this->input->post('Qty',true),
                'Furnace_Income' => $this->input->post('Dispatch_Income',true),
                'Remaining_Comments' => $this->input->post('Comments',true),
                'Dispatch_Status' => $this->input->post('Status',true),
                'Created_By' => $this->session->userdata['userid']);
            $insert = $this->user_model->Insert_Dispatch($data);
            if($insert == 1)
            {
                $update = array('Dispatch_Remaining_Qty' => $this->input->post('Qty',true),
                                'Dispatch_Incoming' => '0',
                                'Dispatch_Status' => $this->input->post('Status',true) );
                $this->db->where('WO_Process_Icode',$wo_icode);
                $this->db->update('wo_processing', $update);

                $work_order =$this->input->post('Wo_Icode',true);
                $data['complete']= $this->admin_model->get_completed_status($work_order);
                $data['work_order']= $this->admin_model->get_Single_Work_Order($work_order);
                if($data['complete'][0]['total'] = $data['work_order'][0]['Total_Qty'] )
                {
                    $complete = '1';
                }
                else{
                    $complete = '0';
                }
                $update1 = array('WO_Completed' => $complete,
                           'WO_Completed_On' => date('Y-m-d  H:i:s'));
                $this->db->where('WO_Icode',$work_order);
                $this->db->update('work_order', $update1);
                echo 1;
                //$work_order = $this->input->post('Wo_Icode',true);
              //  $success = $this->user_model->find_WO_Finished($work_order);
            }
            else{
                echo 0;
            }
        }
    }

    //** PROFOMA INVOICE */
    /** Proforma_Invoice */
    public function Proforma_Invoice()
    {
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Invoice');
        $this->load->view('User/footer');
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
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/View_Invoice',$data,false);
        $this->load->view('User/footer');
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
            'IGST_Value' => $this->input->post('igst'),
            'Transport' => $this->input->post('transport'),
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
            redirect('User_Controller/Invoice_List');
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
    //** Edit Charges */
    public function Edit_Charges()
    {
        $charges_id = $this->input->post('id',true);
        $data = $this->admin_model->get_charges($charges_id);
        echo  json_encode($data);
    }
    //** Edit Material */
    public function Edit_Material()
    {
        $material_id = $this->input->post('id',true);
        $data = $this->admin_model->get_material($material_id);
        echo  json_encode($data);
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
    /** Invoice List */
    public function Invoice_List()
    {
        $data['invoice'] = $this->admin_model->get_All_Invoice();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Invoice_List',$data,false);
        $this->load->view('User/footer');
    }
    /*Get Company Name*/
    public function Generate_WO()
    {
        $data['invoice'] = $this->user_model->get_All_Invoice();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Create_WO',$data,false);
        $this->load->view('User/footer');
    }
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
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/View_Single_Invoice',$data,false);
        $this->load->view('User/footer');
    }
    /** Get Single Invoice Details */
    /** Save Work Order */
    public function Save_Work_Order()
    {
        $role =  $this->session->userdata['role'];
        if($role == 6)
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
                'WO_Date' =>date('Y-m-d') ,
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
                redirect('User_Controller/Generate_WO');
            }
        }
        elseif ($role == 7)
        {
            $wo_icode = $this->input->post('wo_icode');
            $data = array(
                'WO_Icode' => $wo_icode ,
                'WO_Number' => $this->input->post('wo_number'),
                'Approved_by' =>$this->session->userdata['userid']);
            $approve = $this->user_model->Approve_Work_Order($data);
            if($approve == 1)
            {
                $update = array('WO_Confirm_Status' => '1');
                $this->db->where('WO_Icode',$wo_icode);
                $this->db->update('work_order', $update);
                $this->session->set_flashdata('feedback', 'Work Order Approved ..');
                redirect('User_Controller/Check_PI');
            }
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
        $data['stock']= $this->admin_model->get_all_item();
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['charges']= $this->admin_model->get_all_charges();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Edit_Invoice',$data,false);
        $this->load->view('User/footer');
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
            'IGST_Value' => $this->input->post('igst'),
            'GrossTotal_Value' => $this->input->post('gross_tot'),
            'Modified_By' => $this->session->userdata['userid'],
            'Modified_On' => date('Y-m-d H:i:s'));
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
                'Modified_By' => $this->session->userdata['userid'],'Modified_On' => date('Y-m-d H:i:s'));
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
                    'Modified_By' => $this->session->userdata['userid'],
                    'Modified_On' => date('Y-m-d H:i:s'));
                $insert_charges = $this->admin_model->Insert_Profoma_Charges($full_data1);
            }
        }
        $this->session->set_flashdata('feedback', 'Updated Invoice..');
        redirect('User_Controller/Generate_WO');
    }

    /** Get WO LIST */
    public function View_WO()
    {
        $data['wo'] = $this->user_model->get_All_WO();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/WO_List',$data,false);
        $this->load->view('User/footer');
    }
    /** CHECK WORK ORDERS */
    public function Check_PI()
    {
        //$data['wo'] = $this->user_model->get_All_WO_Details();get_All_Invoice
        $data['invoice'] = $this->user_model->get_All_Invoice();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Check_PI',$data,false);
        $this->load->view('User/footer');
    }
    /** Get Single work order */
    public function single_Work_Order()
    {
        $pi_icode = $this->uri->segment(3);
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->admin_model->Get_Single_Invoice_Item($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->admin_model->Get_Single_Invoice_Item_Total($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['wo'] = $this->user_model->Get_Single_wo($pi_icode);
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/View_Single_WO',$data,false);
        $this->load->view('User/footer');
    }

}