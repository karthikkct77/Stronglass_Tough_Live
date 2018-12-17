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
        $this->load->model('Login_model','login_model');
        $this->load->library('session');
        $this->load->library('excel');
        $this->session->set_flashdata('message');
    }

    //** CHANGE Password**/
    public function change_password()
    {
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/change_password');
        $this->load->view('User/footer');
    }


    /** Save Password */
    public function save_password()
    {
        $current_pwd = $this->input->post('currentPassword');
        $id = $this->session->userdata['userid'];
        $data =  array('Password'=> $this->input->post('newPassword') );
        $insert = $this->login_model->insert_user_password($data);
        foreach ($insert as $key => $val)
        {
            $check = $val['Password'];
        }
        if($current_pwd == $check)
        {
            $this->db->where('User_Icode',$id);
            $this->db->update('st_user_details', $data);
            $this->session->set_flashdata('message', 'Update Password Successfully..');
            redirect('User_Controller/dashboard');
        }
        else
        {
            $this->session->set_flashdata('message', 'Current Password is not correct');
            redirect('User/change_password');
        }
    }
    /** User Dashboard */
    public function dashboard()
    {
        $role = $this->session->userdata['role'];
        if($role == 5)
        {
            $data['msg_count']=$this->user_model->get_unread_count();

        }
        elseif ($role == 10)
        {
            $type = 'chennai';
            $data['msg_count']=$this->user_model->get_unread_count_chennai();
            $data['customer']=$this->user_model->get_customer_count($type);

        }
        elseif ($role == 11)
        {
            $type = 'kerala';
            $data['msg_count']=$this->user_model->get_unread_count_kerala();
            $data['customer']=$this->user_model->get_customer_count($type);

        }

        $data['pi_confirm']= $this->user_model->get_pi_confirm_status();
        $data['today_pi_count']= $this->user_model->get_today_pi_count();
        $data['today_pi_check']= $this->user_model->get_today_pi_check();
        $data['wo_generate']= $this->user_model->get_today_WO_Generate();
        $data['status']= $this->admin_model->get_all_WO_Status();

        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/dashboard',$data, FALSE);
        $this->load->view('User/footer');
    }

    /** Get Work Order */
    public function Work_Order()   // Production side
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
            $balance =  $this->input->post('Balance',true);
            $remain = $this->input->post('Qty',true);
            $Income = $balance - $remain;
            $wo_icode = $this->input->post('Process_Icode',true);
            $data =array('WO_Icode' => $this->input->post('Wo_Icode',true),
                'WO_Process_Icode' => $this->input->post('Process_Icode',true),
                'Proforma_Invoice_Items_Icode' => $this->input->post('Item_Icode',true),
                'PI_Type' =>$this->input->post('PI_type',true),
                'Cutting_Qty'=>$Income,
                'Cutting_Remaining_Qty  ' => $this->input->post('Qty',true),
                'Remaining_Comments' => $this->input->post('Comments',true),
                'Cutting_Status' => $this->input->post('Status',true),
                'Created_By' => $this->session->userdata['userid']);
            $insert = $this->user_model->Insert_Cutting($data);
            if($insert == 1)
            {
                $wo_process = $this->user_model->get_furnance_details($wo_icode);
                $furnance_icome = $wo_process[0]['Furnace_Remaining_Qty'];

                if($furnance_icome == '0')
                {

                    $update = array('Cutting_Remaining_Qty' => $this->input->post('Qty',true),
                        'Furnace_Incoming' => $Income,
                        'Furnace_Remaining_Qty'=>$Income,
                        'Furnace_Status' => '1',
                        'Cutting_Status' => $this->input->post('Status',true) );
                    $this->db->where('WO_Process_Icode',$wo_icode);
                    $this->db->update('wo_processing', $update);
                    echo 1;
                }
                else
                {

                    $new_income = $Income + $furnance_icome;
                    $update = array('Cutting_Remaining_Qty' => $this->input->post('Qty',true),
                        'Furnace_Incoming' => $new_income,
                        'Furnace_Remaining_Qty'=>$new_income,
                        'Furnace_Status' => '1',
                        'Cutting_Status' => $this->input->post('Status',true) );
                    $this->db->where('WO_Process_Icode',$wo_icode);
                    $this->db->update('wo_processing', $update);
                    echo 1;

                }


            }
            else{
                echo 0;
            }

        }
        elseif ($role == 3) // Fornace
        {
            $Furnace_income = $this->input->post('Furnace_Income',true);
            $balance =  $this->input->post('Balance',true);
            $remain = $this->input->post('Qty',true);
            $Income = $balance - $remain;
            $Disptach_Income = $Furnace_income - $remain;
            $wo_icode = $this->input->post('Process_Icode',true);
            $data =array('WO_Icode' => $this->input->post('Wo_Icode',true),
                'WO_Process_Icode' => $this->input->post('Process_Icode',true),
                'Proforma_Invoice_Items_Icode' => $this->input->post('Item_Icode',true),
                'Cutting_Income' => $this->input->post('Furnace_Income',true),
                'PI_Type' =>$this->input->post('PI_type',true),
                'Furnace_qty'=>$Income,
                'Furnace_Remaining_Qty  ' => $this->input->post('Qty',true),
                'Remaining_Comments' => $this->input->post('Comments',true),
                'Furnace_Status' => $this->input->post('Status',true),
                'Created_By' => $this->session->userdata['userid']);
            $insert = $this->user_model->Insert_Furnace($data);
            if($insert == 1)
            {
                $wo_process = $this->user_model->get_furnance_details($wo_icode);
                $dispatch_icome = $wo_process[0]['Dispatch_Remaining_Qty'];
                if($dispatch_icome == '0')
                {

                    $update = array('Furnace_Remaining_Qty' => $this->input->post('Qty',true),
                        'Dispatch_Incoming' => $Income,
                        'Dispatch_Remaining_Qty'=>$Income,
                        'Furnace_Incoming' => '0',
                        'Dispatch_Status' => '1',
                        'Furnace_Status' => $this->input->post('Status',true) );
                    $this->db->where('WO_Process_Icode',$wo_icode);
                    $this->db->update('wo_processing', $update);
                    echo 1;
                }
                else
                {
                    $new_income = $Income + $dispatch_icome;

                    $update = array('Furnace_Remaining_Qty' => $this->input->post('Qty',true),
                        'Dispatch_Incoming' => $new_income,
                        'Dispatch_Remaining_Qty'=>$new_income,
                        'Furnace_Incoming' => '0',
                        'Dispatch_Status' => '1',
                        'Furnace_Status' => $this->input->post('Status',true) );
                    $this->db->where('WO_Process_Icode',$wo_icode);
                    $this->db->update('wo_processing', $update);
                    echo 1;

                }



            }
            else{
                echo 0;
            }

        }
        elseif ($role == 4) // Dispatch
        {
            $balance =  $this->input->post('Balance',true);
            $remain = $this->input->post('Qty',true);
            $Income = $balance - $remain;
            $wo_icode = $this->input->post('Process_Icode',true);
            $data =array('WO_Icode' => $this->input->post('Wo_Icode',true),
                'WO_Process_Icode' => $this->input->post('Process_Icode',true),
                'Proforma_Invoice_Items_Icode' => $this->input->post('Item_Icode',true),
                'Dispatch_Qty' =>$Income,
                'PI_Type' =>$this->input->post('PI_type',true),
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

                $total_qty = $data['complete'][0]['total'];
                $disptach_remain = $data['complete'][0]['remaining1'];
                $cutting_remain = $data['complete'][0]['remaining2'];
                $funan_remain = $data['complete'][0]['remaining3'];
                $remain = $disptach_remain + $cutting_remain + $funan_remain;
                $completed = $total_qty - $remain;
                if($completed == $data['work_order'][0]['Total_Qty'] )
                {
                    $complete = '1';
                }
                else{
                    $complete = '0';
                }
                $update1 = array('WO_Completed' => $complete,
                    'WO_Completed_On' => date('Y-m-d'));
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

    //** Save All Production Depatment  */
    public function Save_All_Production()
    {
        $role =  $this->session->userdata['role'];
        if($role == 2) //  Cutting
        {
            $data= $this->input->post('Process_Icode', true);
            $string = trim($data,",");
            $process = explode(",", $string);
            foreach ($process as $key )
            {
                $process_details = $this->user_model->get_wo_process($key);

                $type = $this->input->post('PI_type',true);

                if($type == '1' )
                {
                    $item = $process_details[0]['PI_Sheet_Item_Icode'];
                }
                else
                {
                    $item = $process_details[0]['Proforma_Invoice_Item_Icode'];
                }

                $data =array('WO_Icode' => $process_details[0]['WO_Icode'],
                    'WO_Process_Icode' => $key,
                    'Proforma_Invoice_Items_Icode' => $item,
                    'PI_Type' =>$this->input->post('PI_type',true),
                    'Cutting_Qty'=>$process_details[0]['Cutting_Remaining_Qty'],
                    'Cutting_Remaining_Qty  ' => '0',
                    'Remaining_Comments' => '',
                    'Cutting_Status' => '3',
                    'Created_By' => $this->session->userdata['userid']);
                $insert = $this->user_model->Insert_Cutting($data);
                if($insert == 1)
                {
                    $wo_process = $this->user_model->get_furnance_details($key);
                    $furnance_icome = $wo_process[0]['Furnace_Remaining_Qty'];

                    if($furnance_icome == '0')
                    {

                        $update = array('Cutting_Remaining_Qty' => '0',
                            'Furnace_Incoming' => $wo_process[0]['Cutting_Remaining_Qty'],
                            'Furnace_Remaining_Qty'=>$wo_process[0]['Cutting_Remaining_Qty'],
                            'Furnace_Status' => '1',
                            'Cutting_Status' => '3' );
                        $this->db->where('WO_Process_Icode',$key);
                        $this->db->update('wo_processing', $update);
                        echo 1;
                    }
                    else
                    {

                        $new_income = $wo_process[0]['Cutting_Remaining_Qty'] + $furnance_icome;
                        $update = array('Cutting_Remaining_Qty' => '0',
                            'Furnace_Incoming' => $new_income,
                            'Furnace_Remaining_Qty'=>$new_income,
                            'Furnace_Status' => '1',
                            'Cutting_Status' => '3' );
                        $this->db->where('WO_Process_Icode',$key);
                        $this->db->update('wo_processing', $update);
                        echo 1;

                    }
                }
                else{
                    echo 0;
                }

            }
        }
        elseif ($role == 3) // Fornace
        {
            $data= $this->input->post('Process_Icode', true);
            $string = trim($data,",");
            $process = explode(",", $string);
            foreach ($process as $key )
            {
                $process_details = $this->user_model->get_wo_process($key);

                $type = $this->input->post('PI_type',true);

                if($type == '1' )
                {
                    $item = $process_details[0]['PI_Sheet_Item_Icode'];
                }
                else
                {
                    $item = $process_details[0]['Proforma_Invoice_Item_Icode'];
                }

                $data =array('WO_Icode' => $process_details[0]['WO_Icode'],
                    'WO_Process_Icode' => $key,
                    'Proforma_Invoice_Items_Icode' => $item,
                    'PI_Type' =>$this->input->post('PI_type',true),
                    'Cutting_Income' => $process_details[0]['Furnace_Incoming'],
                    'Furnace_qty'=>$process_details[0]['Furnace_Remaining_Qty'],
                    'Furnace_Remaining_Qty  ' => '0',
                    'Remaining_Comments' => '',
                    'Furnace_Status' => '3',
                    'Created_By' => $this->session->userdata['userid']);
                $insert = $this->user_model->Insert_Furnace($data);
                if($insert == 1)
                {
                    $wo_process = $this->user_model->get_furnance_details($key);
                    $dispatch_icome = $wo_process[0]['Dispatch_Remaining_Qty'];
                    if($dispatch_icome == '0')
                    {

                        $update = array('Furnace_Remaining_Qty' => '0',
                            'Dispatch_Incoming' => $wo_process[0]['Furnace_Remaining_Qty'],
                            'Dispatch_Remaining_Qty'=>$wo_process[0]['Furnace_Remaining_Qty'],
                            'Furnace_Incoming' => '0',
                            'Dispatch_Status' => '1',
                            'Furnace_Status' => '3' );
                        $this->db->where('WO_Process_Icode',$key);
                        $this->db->update('wo_processing', $update);
                        echo 1;
                    }
                    else
                    {
                        $new_income = $wo_process[0]['Furnace_Remaining_Qty'] + $dispatch_icome;

                        $update = array('Furnace_Remaining_Qty' => '0',
                            'Dispatch_Incoming' => $new_income,
                            'Dispatch_Remaining_Qty'=>$new_income,
                            'Furnace_Incoming' => '0',
                            'Dispatch_Status' => '1',
                            'Furnace_Status' => '3' );
                        $this->db->where('WO_Process_Icode',$key);
                        $this->db->update('wo_processing', $update);
                        echo 1;

                    }
                }
                else{
                    echo 0;
                }

            }

        }
        elseif ($role == 4) // Dispatch
        {
            $data= $this->input->post('Process_Icode', true);
            $string = trim($data,",");
            $process = explode(",", $string);
            foreach ($process as $key )
            {
                $process_details = $this->user_model->get_wo_process($key);

                $type = $this->input->post('PI_type',true);

                if($type == '1' )
                {
                    $item = $process_details[0]['PI_Sheet_Item_Icode'];
                }
                else
                {
                    $item = $process_details[0]['Proforma_Invoice_Item_Icode'];
                }
                $data =array('WO_Icode' => $process_details[0]['WO_Icode'],
                    'WO_Process_Icode' => $key,
                    'Proforma_Invoice_Items_Icode' => $item,
                    'Dispatch_Qty' =>$process_details[0]['Dispatch_Remaining_Qty'],
                    'PI_Type' =>$this->input->post('PI_type',true),
                    'Dispatch_Remaining_Qty  ' => '0',
                    'Furnace_Income' => $process_details[0]['Dispatch_Incoming'],
                    'Remaining_Comments' => '',
                    'Dispatch_Status' => '3',
                    'Created_By' => $this->session->userdata['userid']);
                $insert = $this->user_model->Insert_Dispatch($data);
                if($insert == 1)
                {
                    $update = array('Dispatch_Remaining_Qty' => '0',
                        'Dispatch_Incoming' => '0',
                        'Dispatch_Status' => '3' );
                    $this->db->where('WO_Process_Icode',$key);
                    $this->db->update('wo_processing', $update);

                    $work_order =$process_details[0]['WO_Icode'];
                    $data['complete']= $this->admin_model->get_completed_status($work_order);
                    $data['work_order']= $this->admin_model->get_Single_Work_Order($work_order);
                    $total_qty = $data['complete'][0]['total'];
                    $disptach_remain = $data['complete'][0]['remaining1'];
                    $cutting_remain = $data['complete'][0]['remaining2'];
                    $funan_remain = $data['complete'][0]['remaining3'];
                    $remain = $disptach_remain + $cutting_remain + $funan_remain;
                    $completed = $total_qty - $remain;
                    if($completed == $data['work_order'][0]['Total_Qty'] )
                    {
                        $complete = '1';
                    }
                    else{
                        $complete = '0';
                    }
                    $update1 = array('WO_Completed' => $complete,
                        'WO_Completed_On' => date('Y-m-d'));
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

        $check_H = count(array_keys($height_check, "1"));
        $check_W = count(array_keys($width_check, "1"));
        $check_P = count(array_keys($pics_check, "1"));
        $check_Holes = count(array_keys($holes_check, "1"));
        $check_Type = count(array_keys($types_check, "1"));
//        $check_cutout = count(array_keys($cutout_check, "1"));


        if($check_H =='0' and $check_W =='0' and $check_P =='0' and $check_Holes =='0'  )
        {
            unlink('uploads/excel/'.$file_name);
            $this->load->view('User/header');
            $this->load->view('User/top');
            $this->load->view('User/left');
            $this->load->view('User/View_Invoice',$data,false);
            $this->load->view('User/footer');
        }
        else
        {
            $this->session->set_flashdata('feedback', 'Please Cross Check the values in the Excel Sheet.The Columns Height,Width,No.of.pieces,Holes Must have only Numeric values. Type must have only Alphabetic. Make corrections and load Again ..');
            redirect('User_Controller/Proforma_Invoice');
        }



    }
    /** Save Invoice */
    public function Save_Invoice()
    {
        $address =$this->input->post('company_address');

        if($address == '')
        {
            $profoma_address= '0';
        }
        else{
            $profoma_address= $this->input->post('company_address');
        }
        $month =date('m');
        $perfoma = $this->admin_model->get_profoma_number($month);
        if($perfoma == 0)
        {
            $Invoice_Number = $month .'-101';
        }
        else
        {
            $myString = $perfoma[0]['Proforma_Number'];
            $myArray = explode('-', $myString);
            $increment = $myArray[1] + 1;
            $Invoice_Number = $month .'-'. $increment;

        }
        $data = array(
            'Proforma_Number' => $Invoice_Number,
            'Proforma_Date' => $this->input->post('invoice_date'),
            'Proforma_Customer_Icode' => $this->input->post('company_name'),
            'Proforma_Delivery_Address_Icode' =>$profoma_address ,
            'Sub_Total' => $this->input->post('sub_tot'),
            'Insurance_Value' => $this->input->post('insurance'),
            'SGST_Value' => $this->input->post('sgst'),
            'CGST_Value' => $this->input->post('cgst'),
            'IGST_Value' => $this->input->post('igst'),
            'Total_Outstanding'=>$this->input->post('outstanding'),
            'Credit_Limit'=>$this->input->post('credit_limit'),
            'Material_Area'=>$this->input->post('material_area'),
            'PI_Type' =>$this->input->post('pi_type'),
            'Transport' => $this->input->post('transport'),
            'Delivery_Days'=>$this->input->post('delivery'),
            'GrossTotal_Value' => $this->input->post('gross_tot'),
            'Amt_Words' =>$this->input->post('amt_words'),
            'Proforma_Generated_By' => $this->session->userdata['userid']);
        $insert = $this->admin_model->Insert_Profoma_Invoice($data);
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
                $full_data =array( 'Proforma_Icode' => $insert,
                    'Proforma_Date' => $this->input->post('invoice_date'),
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
            $this->session->set_flashdata('feedback', 'PI Created Successfully ..');
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

    public function get_material_name()
    {
        $search_data = $this->input->post('search_data');
        $item_id = $this->input->post('item_icode');
        $result = $this->user_model->Get_search_material($search_data);
        if (!empty($result))
        {
            foreach ($result as $row):
                echo "<li><a href='javascript:;'  onclick='Get_search_material(". $row['Material_Icode'] .", " .$item_id.")' >" . $row['Material_Name'] . "</a></li>";
            endforeach;
        }
//        else
//        {
//            echo "<li> <em> Not found ... </em> </li>";
//        }
    }

    public function get_material_details()
    {
        $material_id = $this->input->post('id',true);
        $data= $this->user_model->get_single_material($material_id);
        echo  json_encode($data);

    }

    /*Get Company Name*/
    public function GetAllMaterial(){
        $search_data = $this->input->post('search_data');
        $result = $this->admin_model->Get_All_Material($search_data);
        if (!empty($result))
        {
            foreach ($result as $row):
                echo "<li><a href='javascript:;'  onclick='get_row(". $row['Material_Icode'] .")' >" . $row['Material_Name'] . "</a></li>";
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
        $data['invoice'] = $this->user_model->get_All_WO_Details();
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
        $data['User']=$this->user_model->Get_User_Details($pi_icode);
        $data['check_user']=$this->user_model->Get_Check_User_Details();
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
        if($role == 6) // Wo Creater
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
            $Qty =  $this->input->post('pics');
            $tot_qty = array_sum($Qty);

            $data = array(
                'WO_Number' => $WO_Number,
                'Proforma_Icode' => $this->input->post('PI_Icode'),
                'Proforma_Number' => $this->input->post('invoice_no'),
                'WO_Date' =>date('Y-m-d') ,
                'Total_Qty' =>$tot_qty,
                'WO_Created_By' => $this->session->userdata['userid']);
            $insert = $this->admin_model->Insert_WO($data);
            if($insert != 0)
            {
                $item_icode =  $this->input->post('material');
                $count = sizeof($item_icode);

                $pi_type = $this->input->post('invoice_type');
                if($pi_type == '1')
                {
                    for($i=0; $i<$count; $i++)
                    {
                        $data1 = array(
                            'WO_Icode' =>  $insert,
                            'Proforma_Icode' => $this->input->post('PI_Icode'),
                            'Proforma_Invoice_Item_Icode' => '0',
                            'PI_Sheet_Item_Icode' =>$item_icode[$i],
                            'Total_Qty' =>$Qty[$i] ,
                            'Cutting_Remaining_Qty' =>$Qty[$i],
                            'Furnace_Remaining_Qty' =>'0',
                            'Dispatch_Remaining_Qty' =>'0');
                        $insert_process = $this->admin_model->Insert_WO_Process($data1);
                    }
                    $id=$this->input->post('PI_Icode');
                    $update = array('WO_Confirm' => '1',
                        'WO_Confirm_By'=>$this->session->userdata['userid'],
                        'WO_Confirm_On'=>date('Y-m-d H:i:s'));
                    $this->db->where('Proforma_Icode',$id);
                    $this->db->update('proforma_invoice', $update);
                    $this->session->set_flashdata('feedback', 'Work Order Generated Successfully ..');
                    redirect('User_Controller/single_sheet_WO/'.$id);
                }
                else{
                    for($i=0; $i<$count; $i++)
                    {
                        $data1 = array(
                            'WO_Icode' =>  $insert,
                            'Proforma_Icode' => $this->input->post('PI_Icode'),
                            'Proforma_Invoice_Item_Icode' => $item_icode[$i],
                            'PI_Sheet_Item_Icode' =>'0',
                            'Total_Qty' =>$Qty[$i] ,
                            'Cutting_Remaining_Qty' =>$Qty[$i],
                            'Furnace_Remaining_Qty' =>'0',
                            'Dispatch_Remaining_Qty' =>'0');
                        $insert_process = $this->admin_model->Insert_WO_Process($data1);
                    }
                    $id=$this->input->post('PI_Icode');
                    $update = array('WO_Confirm' => '1',
                        'WO_Confirm_By'=>$this->session->userdata['userid'],
                        'WO_Confirm_On'=>date('Y-m-d H:i:s'));
                    $this->db->where('Proforma_Icode',$id);
                    $this->db->update('proforma_invoice', $update);
                    $this->session->set_flashdata('feedback', 'Work Order Generated Successfully ..');
                    redirect('User_Controller/single_WO/'.$id);
                }
            }
        }
        elseif ($role == 7) // Pi Confirm
        {
            $email =$this->input->post('email');
            $picode=$this->input->post('PI_Icode');
            $type = $this->input->post('PI_Type');

            $this->load->library('pdf');
            if($type == '1')
            {
                $data['invoice_item'] = $this->admin_model->Get_Single_Sheet_Invoice_Item($picode);
                $data['invoice_total'] = $this->user_model->Get_Single_Invoice_Item_Sheet_Total($picode);
                $data['sheet'] = $this->admin_model->Get_Sheet_Details($picode);
            }
            else
            {
                $data['invoice_item'] = $this->admin_model->Get_Single_Invoice_Item($picode);
                $data['invoice_total'] = $this->admin_model->Get_Single_Invoice_Item_Total($picode);
            }
            $data['invoice'] = $this->admin_model->Get_Single_Invoice($picode);
            $data['tax']= $this->admin_model->get_Tax();
            $data['st']= $this->admin_model->get_ST();
            $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($picode);
            $data['User']=$this->user_model->Get_User_Details($picode);
            $data['check_user']=$this->user_model->Get_Check_User_Details();
            $body = $this->load->view('User/email',$data,TRUE);
//            print_r($body);

            $this->pdf->loadHtml($body);
            $this->pdf->render();
//            $this->pdf->stream("welcome.pdf", array("Attachment"=>0));
            $pdf = $this->pdf->output();
            $pdf_name = 'Stronglass_Tough';
            $file_location =FCPATH."uploads/pdf/".$pdf_name.".pdf";
            file_put_contents($file_location,$pdf);
//            if($email == "")
//            {
//                $this->session->set_flashdata('feedback1', 'Sorry, No Email Address in this Customer...');
                $this->pdf->stream($pdf_name .".pdf", array("Attachment"=>0));
                redirect('User_Controller/single_Invoice/'.$picode);
//            }
//            else{
//                $id=$this->input->post('PI_Icode');
//                $update = array('Email_Send_Status' => '1',
//                    'Email_Send_Date'=>date('Y-m-d H:i:s'));
//                $this->db->where('Proforma_Icode',$id);
//                $this->db->update('proforma_invoice', $update);
//
////            $userEmail='vignesh@ibtemail.com';
//                $subject='Stronglass Tough Quote PI.NO:'.$data['invoice'][0]['Proforma_Number'];
//                $config = Array(
//                    'mailtype' => 'html',
//                    'charset' => 'utf-8',
//                    'priority' => '1'
//                );
//                $this->load->library('email', $config);
//                $this->email->set_newline("\r\n");
//                $pi_icode= $this->input->post('PI_Icode');
//                $this->email->from('karthik@ibtemail.com', 'Stronglass Tough');
//                $this->email->to('karthikkct77@gmail.com');  // replace it with receiver mail id
//                $this->email->subject($subject); // replace it with relevant subject
//                $file_location =FCPATH."uploads/pdf/".$pdf_name.".pdf";
//                $body = $this->load->view('User/email_body',$data,TRUE);
//                $this->email->message($body);
//                $this->email->attach($file_location);
//                $this->email->send();
//                $this->session->set_flashdata('feedback', 'Email Send Successfully ..');
//                redirect('User_Controller/Check_PI');
//            }
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
        $history = $this->user_model->Invoice_Update($picode);
        if($history == '1') {


            $address =$this->input->post('company_address');
            if($address == '')
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
                'Amt_Words' =>$this->input->post('amt_words'),
                'Transport'=>$this->input->post('transport'),
                'Total_Outstanding'=>$this->input->post('outstanding'),
                'Credit_Limit'=>$this->input->post('credit_limit'),
                'Material_Area'=>$this->input->post('material_area'),
                'Amt_Words'=>$this->input->post('amt_words'),
                'Delivery_Days'=>$this->input->post('delivery'),
                'Modified_By' => $this->session->userdata['userid'],
                'Modified_Status' => '1',
                'Modified_On' => date('Y-m-d H:i:s'));
            $this->db->where('Proforma_Icode',$picode);
            $this->db->update('proforma_invoice', $data);

            $item_icode = $this->input->post('item_icode');
            $material_id = $this->input->post('material');
            $qty = $this->input->post('pics');
            $holes = $this->input->post('holes');
            $cutout = $this->input->post('cutout');
            $cost = $this->input->post('total');
            $actual_W = $this->input->post('Actual_width');
            $actual_H = $this->input->post('Actual_height');
            $Charge_W = $this->input->post('Charge_width');
            $Area = $this->input->post('area');
            $Charge_H = $this->input->post('Charge_height');
            $Rate = $this->input->post('rate');
            $special = $this->input->post('special');
            $count = sizeof($material_id);
            for($i=0; $i<$count; $i++)
            {
                $full_data =array( 'Proforma_Icode' => $picode,
                    'Proforma_Holes' => $holes[$i],
                    'Proforma_Qty' => $qty[$i],
                    'Proforma_Special'=>$special[$i],
                    'Proforma_Cutout' => $cutout[$i],
                    'Proforma_Material_Rate' => $Rate[$i],
                    'Proforma_Material_Cost' => $cost[$i],
                    'Proforma_Material_Icode'=>$material_id[$i],
                    'Proforma_Actual_Size_Width' => $actual_W[$i],
                    'Proforma_Actual_Size_Height' => $actual_H[$i],
                    'Proforma_Chargeable_Size_Width' =>$Charge_W[$i],
                    'Proforma_Chargeable_Size_Height' => $Charge_H[$i],
                    'Proforma_Area_SQMTR' => $Area[$i],
                    'Modified_By' => $this->session->userdata['userid'],'Modified_On' => date('Y-m-d H:i:s'));
                $this->db->where('Proforma_Invoice_Items_Icode',$item_icode[$i]);
                $this->db->update('proforma_invoice_items', $full_data);
            }

            $new_material_id = $this->input->post('new_material');
            $new_qty = $this->input->post('new_pics');
            $new_holes = $this->input->post('new_holes');
            $new_cutout = $this->input->post('new_cutout');
            $new_cost = $this->input->post('new_total');
            $new_actual_W = $this->input->post('new_Actual_width');
            $new_actual_H = $this->input->post('new_Actual_height');
            $new_Charge_W = $this->input->post('new_Charge_width');
            $new_Area = $this->input->post('new_area');
            $new_Charge_H = $this->input->post('new_Charge_height');
            $new_Rate = $this->input->post('new_rate');
            $new_special = $this->input->post('new_special');
            $new_count = sizeof($new_material_id);
            for($i=0; $i<$new_count; $i++)
            {
                $full_data =array( 'Proforma_Icode' => $picode,
                    'Proforma_Holes' => $new_holes[$i],
                    'Proforma_Qty' => $new_qty[$i],
                    'Proforma_Special'=>$new_special[$i],
                    'Proforma_Cutout' => $new_cutout[$i],
                    'Proforma_Material_Rate' => $new_Rate[$i],
                    'Proforma_Material_Cost' => $new_cost[$i],
                    'Proforma_Material_Icode'=>$new_material_id[$i],
                    'Proforma_Actual_Size_Width' => $new_actual_W[$i],
                    'Proforma_Actual_Size_Height' => $new_actual_H[$i],
                    'Proforma_Chargeable_Size_Width' =>$new_Charge_W[$i],
                    'Proforma_Chargeable_Size_Height' => $new_Charge_H[$i],
                    'Proforma_Area_SQMTR' => $new_Area[$i],
                    'created_by' => $this->session->userdata['userid']);
                $insert_item = $this->admin_model->Insert_Profoma_Item($full_data);
            }

            $delete_item_id = $this->input->post('Delete_Item_Icode');
            $count_item = sizeof($delete_item_id);
            for($i=0; $i<$count_item; $i++)
            {

                $delete_item_list=$this->admin_model->delete_Item($delete_item_id[$i]);

            }

            $delete_charges_id = $this->input->post('Delete_Charge_Icode');
            $count1 = sizeof($delete_charges_id);
            for($i=0; $i<$count1; $i++)
            {

                $delete_chrg_list=$this->admin_model->delete_charges($delete_charges_id[$i],$picode);

            }
            $charges_count = $this->input->post('Delete_charges_count');
            $charges_value = $this->input->post('Delete_charges_value');
            $charges_cost = $this->input->post('tot_charge_amt');
            $update_charges_id = $this->input->post('Delete_charges');
            $charge_icode = $this->input->post('charge_icode');




            $count_update = sizeof($charges_count);

            for($i=0; $i<$count_update; $i++)
            {
                if (empty($update_charges_id[$i])) {

                }
                else{
                    $full_data1 =array( 'Proforma_Icode' => $picode,
                        'Proforma_Charge_Icode' => $update_charges_id[$i],
                        'Proforma_Charge_Count' => $charges_count[$i],
                        'Proforma_Charge_Value' => $charges_value[$i],
                        'Proforma_Charge_Cost' => $charges_cost[$i],
                        'Modified_By' => $this->session->userdata['userid'],
                        'Modified_On' => date('Y-m-d H:i:s'));
                    $charge_id=$charge_icode[$i];
                    $this->db->where('Proforma_Material_PC_Icode',$charge_id);
                    $this->db->update('proforma_material_processing_charges', $full_data1);
                }

            }
            $charges_id = $this->input->post('charges');
            $check = array_filter($charges_id);
            if (!empty($check)) {
                $charges_count = $this->input->post('no_holes');
                $charges_value = $this->input->post('charge_amt');
                $charges_cost = $this->input->post('tot_charge_amounts');
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
            redirect('User_Controller/single_Invoice/'.$picode);
        }
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
    public function View_Invoice_List()
    {
        //$data['wo'] = $this->user_model->get_All_WO_Details();get_All_Invoice
        $data['invoice'] = $this->user_model->get_All_Confirm_Invoice();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/view_confirm_pi',$data,false);
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
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/View_Sheet_PI',$data,false);
        $this->load->view('User/footer');
    }

    /** Request to Approve */
    public function Request_To_Approve()
    {
        $pi_code=$this->input->post('id', true);
        $update = array('PI_Confirm' => '1',
            'PI_Confirm_By' => $this->session->userdata['userid'],
            'PI_Confirm_Date' => date('Y-m-d H:i:s'));
        $this->db->where('Proforma_Icode',$pi_code);
        $this->db->update('proforma_invoice', $update);
        echo 1;
    }
    /** PI Monthly Chart */
    public function PI_Monthly_Chart()
    {
        $User_Icode =  $this->session->userdata['userid'];
        $data_count= $this->user_model->Monthly_PI($User_Icode);
        print_r(json_encode($data_count, true));
    }

    /** PI Confirm Monthly Chart */
    public function PI_Confirm_Monthly_Chart()
    {
        $User_Icode =  $this->session->userdata['userid'];
        $data_count= $this->user_model->Monthly_PI_Confirm($User_Icode);
        print_r(json_encode($data_count, true));
    }
    /** Complete work order */
    public function Completed_WO()
    {
        $User_Icode =  $this->session->userdata['userid'];
        $data_count= $this->user_model->Monthly_Wo_Generated($User_Icode);
        print_r(json_encode($data_count, true));
    }
    /** Get Single Workorder Details */
    public function single_WO($id)
    {
        $pi_icode = $this->uri->segment(3);
        $data['wo'] = $this->admin_model->Get_Work_Order($pi_icode);
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->admin_model->Get_Single_Invoice_Item($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->admin_model->Get_Single_Invoice_Item_Total($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/WO_Barcode',$data,false);
        $this->load->view('User/footer');
    }

    /** Cutting Monthly Chart */
    public function Cutting_chart()
    {
        $data_count= $this->user_model->Cutting_Chart();
        print_r(json_encode($data_count, true));
    }

    /** Furnace Monthly Chart */
    public function Furnace_chart()
    {
        $data_count= $this->user_model->Furnace_Chart();
        print_r(json_encode($data_count, true));
    }
    /** Dispatch Monthly Chart */
    public function Dispatch_chart()
    {
        $data_count= $this->user_model->Dispatch_chart();
        print_r(json_encode($data_count, true));
    }

    //** Production Dashboard */
    public function Production_Dashboard()
    {
        $data['hours']= $this->admin_model->get_all_work_order_within8();
        $data['hours16']= $this->admin_model->get_all_work_order_within16();
        $data['hours24']= $this->admin_model->get_all_work_order_within24();
        $data['hours48']= $this->admin_model->get_all_work_order_within48();
        $data['delays']= $this->admin_model->get_all_work_order_delay();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/production_dashboard',$data,false);
        $this->load->view('User/footer');

    }
    //** Production Work Order Status */
    public function Production_WO_Status($id)
    {
        $wo_icode = $this->uri->segment(3);
        $data['work_order']= $this->admin_model->get_Single_Work_Order($wo_icode);
        $data['cutting']= $this->admin_model->get_cutting_status($wo_icode);
        $data['complete']= $this->admin_model->get_completed_status($wo_icode);
        $data['furnace']= $this->admin_model->get_furnace_status($wo_icode);
        $data['dispatch']= $this->admin_model->get_dispatch_status($wo_icode);
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Production_WO_Status',$data, FALSE);
        $this->load->view('User/footer');
    }

    //** Sheet PI */
    public function Sheet_PI()
    {
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Sheet_Invoice');
        $this->load->view('User/footer');

    }
    public function Upload_Sheet_Invoice()
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
//            $types=$objWorksheet->getCellByColumnAndRow(5,$i)->getValue();
//            if($types == 'D' || $types == 'S' || $types == 'DS' || $types == 'B')
//            {
//                $types_check[]="";
//            }
//            else{
//                $types_check[] ='1';
//            }
            $cutout=$objWorksheet->getCellByColumnAndRow(6,$i)->getValue();
//            if(is_numeric($cutout))
//            {
//                $cutout_check[]="";
//            }
//            else{
//                $cutout_check[] ='1';
//            }

            $area1 = ($height/1000 * $width/1000) * $pics;
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

        $check_H = count(array_keys($height_check, "1"));
        $check_W = count(array_keys($width_check, "1"));
        $check_P = count(array_keys($pics_check, "1"));
        $check_Holes = count(array_keys($holes_check, "1"));
//        $check_Type = count(array_keys($types_check, "1"));
//        $check_cutout = count(array_keys($cutout_check, "1"));


        if($check_H =='0' and $check_W =='0' and $check_P =='0' and $check_Holes =='0'  )
        {
            unlink('uploads/excel/'.$file_name);
            $this->load->view('User/header');
            $this->load->view('User/top');
            $this->load->view('User/left');
            $this->load->view('User/View_sheet_Invoice',$data,false);
            $this->load->view('User/footer');
        }
        else
        {
            $this->session->set_flashdata('feedback', 'Please Cross Check the values in the Excel Sheet.The Columns Height,Width,No.of.pieces,Holes Must have only Numeric values. Type must have only Alphabetic. Make corrections and load Again ..');
            redirect('User_Controller/Sheet_PI');
        }

    }

    //** Save Sheet PI */
    /** Save Invoice */
    public function Save_Sheet_Invoice()
    {
        $address =$this->input->post('company_address');
        if($address == '')
        {
            $profoma_address= '0';
        }
        else{
            $profoma_address= $this->input->post('company_address');
        }

        $month =date('m');
        $perfoma = $this->admin_model->get_profoma_number($month);
        if($perfoma == 0)
        {
            $Invoice_Number = $month .'-101';
        }
        else
        {
            $myString = $perfoma[0]['Proforma_Number'];
            $myArray = explode('-', $myString);
            $increment = $myArray[1] + 1;
            $Invoice_Number = $month .'-'. $increment;

        }
        $data = array(
            'Proforma_Number' => $Invoice_Number,
            'Proforma_Date' => $this->input->post('invoice_date'),
            'Proforma_Customer_Icode' => $this->input->post('company_name'),
            'Proforma_Delivery_Address_Icode' =>$profoma_address ,
            'Sub_Total' => $this->input->post('sub_tot'),
            'Insurance_Value' => $this->input->post('insurance'),
            'SGST_Value' => $this->input->post('sgst'),
            'CGST_Value' => $this->input->post('cgst'),
            'IGST_Value' => $this->input->post('igst'),
            'Total_Outstanding'=>$this->input->post('outstanding'),
            'Credit_Limit'=>$this->input->post('credit_limit'),
            'Material_Area'=>$this->input->post('material_area'),
            'Delivery_Days'=>$this->input->post('delivery'),
            'Transport' => $this->input->post('transport'),
            'PI_Type' =>'1',
            'GrossTotal_Value' => $this->input->post('gross_tot'),
            'Proforma_Generated_By' => $this->session->userdata['userid']);
        $insert = $this->admin_model->Insert_Profoma_Invoice($data);
        if($insert != 0)
        {
            $sheet_material_id = $this->input->post('sheet_material');
            $no_sheet = $this->input->post('sheet_pieces');
            $act_h = $this->input->post('sheet_Act_Size_H');
            $act_w = $this->input->post('sheet_Act_Size_W');
            $cha_h = $this->input->post('sheet_Act_Size_H');
            $cha_w = $this->input->post('sheet_Act_Size_W');
            $area = $this->input->post('sheet_Area');
            $rate = $this->input->post('sheet_Rate');
            $amount = $this->input->post('sheet_Rate_Amt');
            $count = sizeof($sheet_material_id);
            for($i=0; $i<$count; $i++)
            {
                $full_data =array( 'Proforma_Icode' => $insert,
                    'Proforma_Material_Icode' => $sheet_material_id[$i],
                    'No_Of_Sheet' => $no_sheet[$i],
                    'Actual_Height' => $act_h[$i],
                    'Actual_Width' => $act_w[$i],
                    'Chargable_Height' => $cha_h[$i],
                    'Chargable_Width'=>$cha_w[$i],
                    'Area' => $area[$i],
                    'Rate' => $rate[$i],
                    'Total_Amount' =>$amount[$i],
                    'created_by' => $this->session->userdata['userid']);
                $insert_sheet = $this->user_model->Insert_Profoma_Sheet($full_data);
            }
            if($insert_sheet != 0)
            {
                $material_id = $this->input->post('material');
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
                    $full_data =array( 'Proforma_Icode' => $insert,
                        'pi_sheet_icode' =>$insert_sheet,
                        'Proforma_Material_Icode' => $material_id[$i],
                        'Proforma_Special' => $special[$i],
                        'Proforma_Holes' => $holes[$i],
                        'Proforma_Qty' => $qty[$i],
                        'Proforma_Cutout'=>$cutout[$i],
                        'Proforma_Actual_Size_Width' => $actual_W[$i],
                        'Proforma_Actual_Size_Height' => $actual_H[$i],
                        'Proforma_Chargeable_Size_Width' =>$actual_W[$i],
                        'Proforma_Chargeable_Size_Height' => $actual_H[$i],
                        'Proforma_Area_SQMTR' => $Area[$i],
                        'Proforma_Material_Rate' => $Rate[$i],
                        'Proforma_Material_Cost' => $cost[$i],
                        'created_by' => $this->session->userdata['userid']);
                    $insert_item = $this->user_model->Insert_Profoma_Item_sheet($full_data);
                }

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
            $this->session->set_flashdata('feedback', 'PI Created Successfully ..');
            redirect('User_Controller/Invoice_List');
        }
    }

    //** Get Material Details */
    public function get_material()
    {
        $material = $this->input->post('Material',TRUE);
        foreach ($material as $key )
        {
            $data[] = $this->user_model->get_material($key);
        }
        $output = null;
        foreach ( $data as $row)
        {
            $output .= "<option value='".$row['Material_Icode']."'>".$row['Material_Name']."</option>";
        }
        echo $output;

    }

    //** Edit Sheet Invoice */
    public function Edit_Sheet_Invoice ()
    {
        $pi_icode = $this->uri->segment(3);
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->user_model->Get_Single_Invoice_Item_Sheet($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->user_model->Get_Single_Invoice_Item_Sheet_Total($pi_icode);
        $data['sheet'] = $this->user_model->Get_Single_Sheet($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['stock']= $this->admin_model->get_all_item();
        $data['wo'] = $this->user_model->Get_Single_wo($pi_icode);
        $data['charges']= $this->admin_model->get_all_charges();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Edit_Sheet_Invoice',$data,false);
        $this->load->view('User/footer');
    }

    //** Update Sheet Invoice */
    public function Update_Sheet_Invoice()
    {
        $picode = $this->input->post('PI_Icode');
        $history = $this->user_model->Invoice_sheet_Update($picode);
        if($history == '1')
        {
            $address =$this->input->post('company_address');
            if($address == '')
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
                'Transport'=>$this->input->post('transport'),
                'GrossTotal_Value' => $this->input->post('gross_tot'),
                'Total_Outstanding'=>$this->input->post('outstanding'),
                'Credit_Limit'=>$this->input->post('credit_limit'),
                'Material_Area'=>$this->input->post('material_area'),
                'Delivery_Days'=>$this->input->post('delivery'),
                'Amt_Words'=>$this->input->post('amt_words'),
                'Modified_By' => $this->session->userdata['userid'],
                'Modified_Status' => '1',
                'Modified_On' => date('Y-m-d H:i:s'));
            $this->db->where('Proforma_Icode',$picode);
            $this->db->update('proforma_invoice', $data);

            $sheet_icode = $this->input->post('sheet_icode');
            $sheet_material = $this->input->post('sheet_material');
            $sheet_piece = $this->input->post('sheet_pieces');
            $sheet_act_h = $this->input->post('sheet_Act_Size_H');
            $sheet_act_w = $this->input->post('sheet_Act_Size_W');
            $sheet_cha_h = $this->input->post('sheet_Cha_Size_H');
            $sheet_cha_w = $this->input->post('sheet_Cha_Size_W');
            $sheet_area = $this->input->post('sheet_Area');
            $sheet_rate = $this->input->post('sheet_Rate');
            $sheet_amt = $this->input->post('sheet_Rate_Amt');
            $count_sheet = sizeof($sheet_icode);
            for($i=0; $i<$count_sheet; $i++)
            {
                $full_data =array(
                    'Proforma_Icode' => $picode,
                    'Proforma_Material_Icode' =>$sheet_material[$i],
                    'No_Of_Sheet' => $sheet_piece[$i],
                    'Actual_Height' => $sheet_act_h[$i],
                    'Actual_Width' => $sheet_act_w[$i],
                    'Chargable_Height' => $sheet_cha_h[$i],
                    'Chargable_Width' => $sheet_cha_w[$i],
                    'Area' => $sheet_area[$i],
                    'Rate' => $sheet_rate[$i],
                    'Total_Amount' =>$sheet_amt[$i],
                    'Modified_By' => $this->session->userdata['userid'],
                    'Modified_On' => date('Y-m-d H:i:s'));
                $this->db->where('pi_sheet_icode',$sheet_icode[$i]);
                $this->db->update('proforma_invoice_sheet', $full_data);
            }

            $new_sheet_material = $this->input->post('new_sheet_material');
            $new_sheet_piece = $this->input->post('new_sheet_pieces');
            $new_sheet_act_h = $this->input->post('new_sheet_Act_Size_H');
            $new_sheet_act_w = $this->input->post('new_sheet_Act_Size_W');
            $new_sheet_cha_h = $this->input->post('new_sheet_Cha_Size_H');
            $new_sheet_cha_w = $this->input->post('new_sheet_Cha_Size_W');
            $new_sheet_area = $this->input->post('new_sheet_Area');
            $new_sheet_rate = $this->input->post('new_sheet_Rate');
            $new_sheet_amt = $this->input->post('new_sheet_Rate_Amt');
            $count_sheet = sizeof($new_sheet_material);
            for($i=0; $i<$count_sheet; $i++)
            {
                $full_data =array(
                    'Proforma_Icode' => $picode,
                    'Proforma_Material_Icode' =>$new_sheet_material[$i],
                    'No_Of_Sheet' => $new_sheet_piece[$i],
                    'Actual_Height' => $new_sheet_act_h[$i],
                    'Actual_Width' => $new_sheet_act_w[$i],
                    'Chargable_Height' => $new_sheet_cha_h[$i],
                    'Chargable_Width' => $new_sheet_cha_w[$i],
                    'Area' => $new_sheet_area[$i],
                    'Rate' => $new_sheet_rate[$i],
                    'Total_Amount' =>$new_sheet_amt[$i],
                    'created_by' => $this->session->userdata['userid']);
                $insert_sheet = $this->user_model->Insert_Profoma_Sheet($full_data);
            }

            $item_sheet_id = $this->input->post('item_icode');
            $material_id = $this->input->post('material');
            $qty = $this->input->post('pics');
            $holes = $this->input->post('holes');
            $cutout = $this->input->post('cutout');
            $actual_W = $this->input->post('width');
            $actual_H = $this->input->post('height');
            $special = $this->input->post('type');
            $Area = $this->input->post('area');
            $Rate = $this->input->post('rate');
            $cost = $this->input->post('total');
            $count = sizeof($material_id);
            for($i=0; $i<$count; $i++)
            {
                $full_data =array( 'Proforma_Icode' => $picode,
                    'Proforma_Holes' => $holes[$i],
                    'Proforma_Qty' => $qty[$i],
                    'Proforma_Cutout' => $cutout[$i],
                    'Proforma_Material_Icode' => $material_id[$i],
                    'Proforma_Special'=>$special[$i],
                    'Proforma_Actual_Size_Width' => $actual_W[$i],
                    'Proforma_Actual_Size_Height' => $actual_H[$i],
                    'Proforma_Chargeable_Size_Width' =>$actual_W[$i],
                    'Proforma_Chargeable_Size_Height' => $actual_H[$i],
                    'Proforma_Area_SQMTR' => $Area[$i],
                    'Proforma_Material_Rate' => $Rate[$i],
                    'Proforma_Material_Cost' => $cost[$i],
                    'Modified_By' => $this->session->userdata['userid'],
                    'Modified_On' => date('Y-m-d H:i:s'));
                $this->db->where('pi_item_sheet_icode',$item_sheet_id[$i]);
                $this->db->update('proforma_invoice_item_sheet', $full_data);
            }



            $new_material_id = $this->input->post('new_material');
            $new_qty = $this->input->post('new_pics');
            $new_holes = $this->input->post('new_holes');
            $new_cutout = $this->input->post('new_cutout');
            $new_actual_W = $this->input->post('new_width');
            $new_actual_H = $this->input->post('new_height');
            $new_special = $this->input->post('new_type');
            $new_Area = $this->input->post('new_area');
            $new_Rate = $this->input->post('new_rate');
            $new_cost = $this->input->post('new_total');
            $count = sizeof($new_qty);
            for($i=0; $i<$count; $i++)
            {
                $full_data1 =array( 'Proforma_Icode' => $picode,
                    'Proforma_Holes' => $new_holes[$i],
                    'Proforma_Qty' => $new_qty[$i],
                    'Proforma_Cutout' => $new_cutout[$i],
                    'Proforma_Material_Icode' => $new_material_id[$i],
                    'Proforma_Special'=>$new_special[$i],
                    'Proforma_Actual_Size_Width' => $new_actual_W[$i],
                    'Proforma_Actual_Size_Height' => $new_actual_H[$i],
                    'Proforma_Chargeable_Size_Width' =>$new_actual_W[$i],
                    'Proforma_Chargeable_Size_Height' => $new_actual_H[$i],
                    'Proforma_Area_SQMTR' => $new_Area[$i],
                    'Proforma_Material_Rate' => $new_Rate[$i],
                    'Proforma_Material_Cost' => $new_cost[$i],
                    'created_by' => $this->session->userdata['userid']);
                $insert_item = $this->user_model->Insert_Profoma_Item_sheet($full_data1);
            }

            $delete_item_id = $this->input->post('Delete_Item_Icode');
            $count_item = sizeof($delete_item_id);
            for($i=0; $i<$count_item; $i++)
            {

                $delete_item_list=$this->admin_model->delete_Item($delete_item_id[$i]);

            }

            $delete_charges_id = $this->input->post('Delete_Charge_Icode');
            $count1 = sizeof($delete_charges_id);
            for($i=0; $i<$count1; $i++)
            {

                $delete_chrg_list=$this->admin_model->delete_charges($delete_charges_id[$i]);

            }
            $charges_count = $this->input->post('Delete_charges_count');
            $charges_value = $this->input->post('Delete_charges_value');
            $charges_cost = $this->input->post('tot_charge_amt');
            $update_charges_id = $this->input->post('Delete_charges');
            $charge_icode = $this->input->post('charge_icode');
            $count_update = sizeof($charges_count);
            for($i=0; $i<$count_update; $i++)
            {
                if (empty($update_charges_id[$i])) {

                }
                else{
                    $full_data1 =array( 'Proforma_Icode' => $picode,
                        'Proforma_Charge_Icode' => $update_charges_id[$i],
                        'Proforma_Charge_Count' => $charges_count[$i],
                        'Proforma_Charge_Value' => $charges_value[$i],
                        'Proforma_Charge_Cost' => $charges_cost[$i],
                        'Modified_By' => $this->session->userdata['userid'],
                        'Modified_On' => date('Y-m-d H:i:s'));
                    $charge_id=$charge_icode[$i];
                    $this->db->where('Proforma_Material_PC_Icode',$charge_id);
                    $this->db->update('proforma_material_processing_charges', $full_data1);
                }

            }
            $charges_id = $this->input->post('charges');
            $check = array_filter($charges_id);
            if (!empty($check)) {
                $charges_count = $this->input->post('no_holes');
                $charges_value = $this->input->post('charge_amt');
                $charges_cost = $this->input->post('tot_charge_amounts');
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
            redirect('User_Controller/single_sheet_Invoice/'.$picode);
        }
    }

    /** Get Single sheet work order */
    public function single_sheet_WO()
    {
        $pi_icode = $this->uri->segment(3);
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->user_model->Get_Single_Invoice_Item_Sheet($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->user_model->Get_Single_Invoice_Item_Sheet_Total($pi_icode);
        $data['sheet'] = $this->user_model->Get_Single_Sheet($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['stock']= $this->admin_model->get_all_item();
        $data['wo'] = $this->user_model->Get_Single_wo($pi_icode);
        $data['charges']= $this->admin_model->get_all_charges();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/View_Single_Sheet_WO',$data,false);
        $this->load->view('User/footer');
    }
    //** Print Work Order */
    public function Print_WO()
    {
        $data['wo'] = $this->user_model->get_All_WO();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/WO_Print',$data,false);
        $this->load->view('User/footer');
    }
    //** Print Work Orders */
    public function Print_Sheet()
    {
        $pi_icode = $this->uri->segment(3);
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->user_model->Get_Single_Invoice_Item_Sheet($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->user_model->Get_Single_Invoice_Item_Sheet_Total($pi_icode);
        $data['sheet'] = $this->user_model->Get_Single_Sheet($pi_icode);
        $data['fab'] = $this->user_model->Get_fabrication_Sheet($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['stock']= $this->admin_model->get_all_item();
        $data['wo'] = $this->user_model->Get_Single_wo($pi_icode);
        $data['charges']= $this->admin_model->get_all_charges();
        $data['print'] = $this->user_model->Get_Print_Type();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Print_Sheet',$data,false);
        $this->load->view('User/footer');
    }
    //** Print Normal Work Order */
    public function Print_Normal()
    {
        $pi_icode = $this->uri->segment(3);
        $data['wo'] = $this->admin_model->Get_Work_Order($pi_icode);
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->admin_model->Get_Single_Invoice_Item($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->admin_model->Get_Single_Invoice_Item_Total($pi_icode);
        $data['fab'] = $this->user_model->Get_fabrication($pi_icode);
        $data['print'] = $this->user_model->Get_Print_Type();
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Print_Normal',$data,false);
        $this->load->view('User/footer');
    }

    //** Recut */
    public function Re_Cut()
    {
        $data['wo'] = $this->user_model->Get_Not_Completed_WO();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Re_Cut',$data,false);
        $this->load->view('User/footer');
    }

    /** Start Work Order */
    public function Start_Sheet_Work_Order($id)
    {
        $wo_id = $this->uri->segment(3);
        $data['work_order_desc']= $this->user_model->get_Sheet_Work_Order_Details($wo_id);
        $data['work_order']= $this->user_model->get_Single_Work_Order($wo_id);
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/View_Work_Order',$data, FALSE);
        $this->load->view('User/footer');
    }
    /** Start Re Cut */
    public function Start_Sheet_Re_Cut($id)
    {
        $wo_id = $id;
        $data['work_order_desc']= $this->user_model->get_Sheet_Re_Cut_WO($wo_id);
        $data['work_order']= $this->user_model->get_Single_Work_Order($wo_id);
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/View_Sheet_Re_Cut',$data, FALSE);
        $this->load->view('User/footer');
    }
    /** Start Re Cut */
    public function Start_Re_Cut($id)
    {
        $wo_id = $id;
        $data['work_order_desc']= $this->user_model->get_Re_Cut_WO($wo_id);
        $data['work_order']= $this->user_model->get_Single_Work_Order($wo_id);
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/View_Re_Cut',$data, FALSE);
        $this->load->view('User/footer');
    }
    // Save Recut NOrmal
    public  function Save_Normal_Recut()
    {
        $full_data =array( 'Work_Order_Icode' => $this->input->post('Wo_Icode',true),
            'Proforma_Icode' =>$this->input->post('Proforma_icode',true),
            'Item_Icode' => $this->input->post('Item_Icode',true),
            'Recut_Qty' => $this->input->post('Qty',true),
            'Recut_Reason' => $this->input->post('Comments',true),
            'Sheet_Item_Icode'=>$this->input->post('Sheet_Icode',true),
            'PI_Type'=>$this->input->post('PI_type',true),
            'Created_By' => $this->session->userdata['userid']);
        $insert_item = $this->user_model->Insert_Recut($full_data);
        if($insert_item == '1')
        {
            echo "1";
        }
        else
        {
            echo "0";
        }
    }

    // Production Re Cut
    public function Production_Re_Cut()
    {
        $data['Recut']= $this->user_model->get_Production_Recut();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Production_Re_Cut',$data, FALSE);
        $this->load->view('User/footer');
    }

    // Save Recut ITEm
    public function Save_Recut_Item()
    {
        $recut_icode =  $this->input->post('Recut_Icode',true);
        $full_data =array( 'Cutting_Status' => '1');
        $this->db->where('Recut_Icode',$recut_icode);
        $this->db->update('recut_item_details', $full_data);
        $data =array( 'WO_Icode' => $this->input->post('Work_Oder',true),
            'Recut_Icode' =>$this->input->post('Recut_Icode',true),
            'Production_Type' => $this->input->post('Type',true),
            'Created_By' => $this->session->userdata['userid']);
        $insert_item = $this->user_model->Insert_Recut_History($data);
        if($insert_item == '1')
        {
            echo '1';
        }
        else
        {
            echo '0';
        }

    }
    public function Barcode($id,$type)
    {
        $pi_icode = $this->uri->segment(3);
        $type = $this->uri->segment(4);

        if($type == '0')
        {
            $data['wo'] = $this->admin_model->Get_Work_Order($pi_icode);
            $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
            $data['invoice_item'] = $this->admin_model->Get_Single_Invoice_Item($pi_icode);
            $this->load->view('User/Print_Barcode',$data, FALSE);
        }
        else
        {
            $data['wo'] = $this->admin_model->Get_Work_Order($pi_icode);
            $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
            $data['invoice_item'] = $this->admin_model->Get_Single_Sheet_Invoice_Item($pi_icode);
            $this->load->view('User/Print_Barcode',$data, FALSE);
        }

    }

    //** Recut Barcode */
    public function Recut_Barcode($process_id,$pi_ic)
    {
        $process_icode = $this->uri->segment(3);
        $pi_icode = $this->uri->segment(4);  $data['wo'] = $this->admin_model->Get_Work_Order($pi_icode);
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->admin_model->get_recut_normal_item($process_icode);
        $this->load->view('User/Print_Recut_Barcode',$data, FALSE);
    }
    public function Recut_Sheet_Barcode($process_id,$pi_ic)
    {
        $process_icode = $this->uri->segment(3);
        $pi_icode = $this->uri->segment(4);  $data['wo'] = $this->admin_model->Get_Work_Order($pi_icode);
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->admin_model->get_recut_sheet_item($process_icode);
        $this->load->view('User/Print_Recut_Barcode',$data, FALSE);
    }

    /** Double_Glazing_PI */
    public function Double_Glazing_PI()
    {
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Double_Glaz_Invoice');
        $this->load->view('User/footer');
    }

    /** Upload excel data to list */
    public function Upload_DG_Invoice()
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
//            $types=$objWorksheet->getCellByColumnAndRow(5,$i)->getValue();
//            if($types == 'D' || $types == 'S' || $types == 'DS' || $types == 'B' || $types == 'D' )
//            {
//                $types_check[]="";
//            }
//            else{
//                $types_check[] ='1';
//            }
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

        $check_H = count(array_keys($height_check, "1"));
        $check_W = count(array_keys($width_check, "1"));
        $check_P = count(array_keys($pics_check, "1"));
        $check_Holes = count(array_keys($holes_check, "1"));
//        $check_Type = count(array_keys($types_check, "1"));
//        $check_cutout = count(array_keys($cutout_check, "1"));


        if($check_H =='0' and $check_W =='0' and $check_P =='0' and $check_Holes =='0'  )
        {
            unlink('uploads/excel/'.$file_name);
            $this->load->view('User/header');
            $this->load->view('User/top');
            $this->load->view('User/left');
            $this->load->view('User/View_DG_Invoice',$data,false);
            $this->load->view('User/footer');
        }
        else
        {
            $this->session->set_flashdata('feedback', 'Please Cross Check the values in the Excel Sheet.The Columns Height,Width,No.of.pieces,Holes Must have only Numeric values. Type must have only Alphabetic. Make corrections and load Again ..');
            redirect('User_Controller/Double_Glazing_PI');
        }

    }

    /** Double_Glazing_PI */
    public function Lamination_PI()
    {
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Lamination_PI');
        $this->load->view('User/footer');
    }

    /** Upload excel data to list */
    public function Upload_Lamination()
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
//            $types=$objWorksheet->getCellByColumnAndRow(5,$i)->getValue();
//            if($types == 'D' || $types == 'S' || $types == 'DS' || $types == 'B' || $types == 'D' )
//            {
//                $types_check[]="";
//            }
//            else{
//                $types_check[] ='1';
//            }
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

        $check_H = count(array_keys($height_check, "1"));
        $check_W = count(array_keys($width_check, "1"));
        $check_P = count(array_keys($pics_check, "1"));
        $check_Holes = count(array_keys($holes_check, "1"));
//        $check_Type = count(array_keys($types_check, "1"));
//        $check_cutout = count(array_keys($cutout_check, "1"));


        if($check_H =='0' and $check_W =='0' and $check_P =='0' and $check_Holes =='0'  )
        {
            unlink('uploads/excel/'.$file_name);
            $this->load->view('User/header');
            $this->load->view('User/top');
            $this->load->view('User/left');
            $this->load->view('User/View_Lamination',$data,false);
            $this->load->view('User/footer');
        }
        else
        {
            $this->session->set_flashdata('feedback', 'Please Cross Check the values in the Excel Sheet.The Columns Height,Width,No.of.pieces,Holes Must have only Numeric values. Type must have only Alphabetic. Make corrections and load Again ..');
            redirect('User_Controller/Lamination_PI');
        }

    }

    //** Get Chennai Work Order */
    public function Chennai_Work_Order()
    {
        $data['chennai_wo']= $this->user_model->get_all_chennai_wo();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Chennai_Status',$data, FALSE);
        $this->load->view('User/footer');

    }

    //** save message */
    public function save_message ()
    {
        $data = array('Client_Message' => $this->input->post('message',true),
            'client_type' =>$this->input->post('ctype',true),
            'Client_Icode' => $this->session->userdata['userid'] );
        $insert = $this->user_model->insert_msg($data);
        if($insert == 1)
        {
            echo 1;
        }
        else{
            echo 0;
        }

    }
    //** save message */
    public function save_admin_message ()
    {
        $data = array('Message' => $this->input->post('message',true),
            'client_type' =>$this->input->post('ctype',true),
            'User_Icode' => $this->session->userdata['userid'] );
        $insert = $this->user_model->insert_msg($data);
        if($insert == 1)
        {
            echo 1;
        }
        else{
            echo 0;
        }

    }

    //** Get All Messages */
    public function Get_All_Message()
    {

        $role = $this->session->userdata['role'];

        if($role == 5)
        {
            $data = array('Msg_Read' => '1' );
            $array = array('Client_Icode !=' => '0');
            $this->db->where($array);
            $this->db->update('st_message_details', $data);
            $data['chennai_msg']=$this->user_model->get_all_chennai_message();
            $data['kerala_msg']=$this->user_model->get_all_kerala_message();
            $data['msg_count']=$this->user_model->get_unread_count();
            $this->load->view('User/header');
            $this->load->view('User/top',$data, FALSE);
            $this->load->view('User/left');
            $this->load->view('User/view_chat',$data, FALSE);
            $this->load->view('User/footer');
        }
        elseif ($role == 10)
        {
            $data = array('Msg_Read' => '1' );
            $array = array('client_type =' => 'chennai', 'User_Icode !=' => '0');
            $this->db->where($array);
            $this->db->update('st_message_details', $data);
            $data['msg_count']=$this->user_model->get_unread_count_chennai();
            $data['chennai_msg']=$this->user_model->get_all_chennai_message();
            $this->load->view('User/header');
            $this->load->view('User/top',$data, FALSE);
            $this->load->view('User/left');
            $this->load->view('User/view_chat',$data, FALSE);
            $this->load->view('User/footer');
        }
        elseif ($role == 11)
        {
            $data = array('Msg_Read' => '1' );
            $array = array('client_type =' => 'kerala', 'User_Icode !=' => '0');
            $this->db->where($array);
            $this->db->update('st_message_details', $data);
            $data['msg_count']=$this->user_model->get_unread_count_kerala();
            $data['kerala_msg']=$this->user_model->get_all_kerala_message();
            $this->load->view('User/header');
            $this->load->view('User/top',$data, FALSE);
            $this->load->view('User/left');
            $this->load->view('User/view_chat',$data, FALSE);
            $this->load->view('User/footer');
        }

    }

    //** kerala work orders */
    public function Kerala_Work_Order()
    {
        $data['kerala_wo']= $this->user_model->get_all_kerala_wo();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Kerala_Status',$data, FALSE);
        $this->load->view('User/footer');
    }

    //** Billing Work Order **/
    public function Bill_WO()
    {
         $data['bill']= $this->user_model->get_bill_wo();

        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Bill_Wo',$data, FALSE);
        $this->load->view('User/footer');
    }

    //** view workorder bill
    public function View_Bill_Wo()
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
         $data['work_order']=$this->user_model->get_work_order($pi_icode);
        $bill_data = $this->user_model->Get_all_bill();
        if($bill_data == 0)
        {
            $data['bill_no'] = '3128';
        }
        else
        {
            $myString = $bill_data[0]['Bill_Number'];        
            $increment = $myString + 1;
             $data['bill_no'] = $increment;

        }
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/View_Bill_Wo',$data,false);
        $this->load->view('User/footer');
    }

    public function View_Sheet_Bill()
    {
        $pi_icode = $this->uri->segment(3);
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->user_model->Get_Single_Invoice_Item_Sheet($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->user_model->Get_Single_Invoice_Item_Sheet_Total($pi_icode);
        $data['sheet'] = $this->user_model->Get_Single_Sheet($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['work_order'] = $this->user_model->Get_Single_wo($pi_icode);
        $data['User']=$this->user_model->Get_User_Details($pi_icode);
        $data['check_user']=$this->user_model->Get_Check_User_Details();
        $bill_data = $this->user_model->Get_all_bill();
        if($bill_data == 0)
        {
            $data['bill_no'] = '3128';
        }
        else
        {
            $myString = $bill_data[0]['Bill_Number'];
            $increment = $myString + 1;
            $data['bill_no'] = $increment;

        }
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/View_Sheet_Bill_Wo',$data,false);
        $this->load->view('User/footer');
    }

//** save bill
    public function save_bill()
    {
        $data = array(
            
            'Bill_Number' => $this->input->post('bill_no'),
            'Wo_Icode' => $this->input->post('work_order_no'),
            'Vehicle_No' =>$this->input->post('vehicle_no'),
            'Destination' => $this->input->post('destination'), 
            'Delivery_Address'=> $this->input->post('new_address'),
            'Sub_Total' => $this->input->post('sub_tot'),
            'Transport' => $this->input->post('transport'),
            'Insurance_Value' => $this->input->post('insurance'),
            'SGST_Value' => $this->input->post('sgst'),
            'CGST_Value' => $this->input->post('cgst'),
            'IGST_Value' => $this->input->post('igst'),
            'GrossTotal_Value' => $this->input->post('gross_tot'),
            'Amt_Words' =>$this->input->post('amt_words'),
            'Created_By' => $this->session->userdata['userid']);
        $insert = $this->user_model->Insert_Billing($data);
        if($insert != '0')
        {
            $bill_id = $insert;
            $charges_count = $this->input->post('Delete_charges_count');
            $charges_value = $this->input->post('Delete_charges_value');
            $charges_cost = $this->input->post('tot_charge_amt');

            $update_charges_id = $this->input->post('Delete_charges');

            $count_update = sizeof($update_charges_id);
            for($i=0; $i<$count_update; $i++)
            {

                    $full_data1 =array( 'bill_icode' => $bill_id,
                        'Proforma_Charge_Icode' => $update_charges_id[$i],
                        'Proforma_Charge_Count' => $charges_count[$i],
                        'Proforma_Charge_Value' => $charges_value[$i],
                        'Proforma_Charge_Cost' => $charges_cost[$i],
                        'created_by' => $this->session->userdata['userid']
                       );
                    $inserts = $this->user_model->Insert_Billing_charges ($full_data1);
            }
            $id=$this->input->post('work_order_no');
            $update  = array('Bill_Status' => '1' );
            $this->db->where('WO_Icode',$id);
            $this->db->update('work_order', $update);


            $this->session->set_flashdata('feedback', 'Bill Generated Successfully..');
             redirect('User_Controller/Bill_WO');

        }
        else
        {
     
        }
    }

    public function View_Bill_List()
    {
        $data['bill']= $this->user_model->get_all_bill_details();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Complete_Bill',$data, FALSE);
        $this->load->view('User/footer');
    }

    public function View_Single_Bill($pid)
    {
        $pi_icode = $pid;
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->admin_model->Get_Single_Invoice_Item($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->admin_model->Get_Single_Invoice_Item_Total($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['User']=$this->user_model->Get_User_Details($pi_icode);
        $data['check_user']=$this->user_model->Get_Check_User_Details();
         $data['work_order']=$this->user_model->get_work_order($pi_icode);
         $wo_icode = $data['work_order'][0]['WO_Icode'];
         $data['bill'] = $this->user_model->Get_Bill_details($wo_icode);
        $bill_icode = $data['bill'][0]['Bill_Icode'];
        $data['bill_Charges'] = $this->user_model->Get_Single_Bill_Charges($bill_icode);
        $data['bill_customer']= $this->user_model->Get_Bill_Customer($bill_icode);

        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/View_Single_Bill',$data,false);
        $this->load->view('User/footer');
    }



    public function View_Single_Sheet_Bill($pid)
    {
        $pi_icode = $pid;
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->user_model->Get_Single_Invoice_Item_Sheet($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->user_model->Get_Single_Invoice_Item_Sheet_Total($pi_icode);
        $data['sheet'] = $this->user_model->Get_Single_Sheet($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['work_order'] = $this->user_model->Get_Single_wo($pi_icode);
        $data['User']=$this->user_model->Get_User_Details($pi_icode);
        $data['check_user']=$this->user_model->Get_Check_User_Details();
        $wo_icode = $data['work_order'][0]['WO_Icode'];
        $data['bill'] = $this->user_model->Get_Bill_details($wo_icode);
        $bill_icode = $data['bill'][0]['Bill_Icode'];
        $data['bill_Charges'] = $this->user_model->Get_Single_Bill_Charges($bill_icode);
        $data['bill_customer']= $this->user_model->Get_Bill_Customer($bill_icode);

        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/View_Single_Sheet_Bill',$data,false);
        $this->load->view('User/footer');
    }





    public function Print_Bill($pid)
    {
        $pi_icode = $pid;
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->admin_model->Get_Single_Invoice_Item($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->admin_model->Get_Single_Invoice_Item_Total($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['User']=$this->user_model->Get_User_Details($pi_icode);
        $data['check_user']=$this->user_model->Get_Check_User_Details();
        $data['work_order']=$this->user_model->get_work_order($pi_icode);
        $wo_icode = $data['work_order'][0]['WO_Icode'];
        $data['bill'] = $this->user_model->Get_Bill_details($wo_icode);
        $bill_icode = $data['bill'][0]['Bill_Icode'];
        $data['bill_Charges'] = $this->user_model->Get_Single_Bill_Charges($bill_icode);
        $data['bill_customer']= $this->user_model->Get_Bill_Customer($bill_icode);

        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Print_Bill',$data,false);
        $this->load->view('User/footer');
    }


    public function Print_Sheet_Bill($pid)
    {
        $pi_icode = $pid;
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->user_model->Get_Single_Invoice_Item_Sheet($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->user_model->Get_Single_Invoice_Item_Sheet_Total($pi_icode);
        $data['sheet'] = $this->user_model->Get_Single_Sheet($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['work_order'] = $this->user_model->Get_Single_wo($pi_icode);
        $data['User']=$this->user_model->Get_User_Details($pi_icode);
        $data['check_user']=$this->user_model->Get_Check_User_Details();
        $wo_icode = $data['work_order'][0]['WO_Icode'];
        $data['bill'] = $this->user_model->Get_Bill_details($wo_icode);
        $bill_icode = $data['bill'][0]['Bill_Icode'];
        $data['bill_Charges'] = $this->user_model->Get_Single_Bill_Charges($bill_icode);
        $data['bill_customer']= $this->user_model->Get_Bill_Customer($bill_icode);

        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Print_Sheet_Bill',$data,false);
        $this->load->view('User/footer');
    }

    public function Edit_Bill($pid)
    {
        $pi_icode = $pid;
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->admin_model->Get_Single_Invoice_Item($pi_icode);

        $data['invoice_total'] = $this->admin_model->Get_Single_Invoice_Item_Total($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['User']=$this->user_model->Get_User_Details($pi_icode);
        $data['check_user']=$this->user_model->Get_Check_User_Details();
        $data['work_order']=$this->user_model->get_work_order($pi_icode);
        $wo_icode = $data['work_order'][0]['WO_Icode'];
        $data['bill'] = $this->user_model->Get_Bill_details($wo_icode);
        $bill_icode = $data['bill'][0]['Bill_Icode'];
        $data['bill_Charges'] = $this->user_model->Get_Single_Bill_Charges($bill_icode);
        $data['bill_customer']= $this->user_model->Get_Bill_Customer($bill_icode);

        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Edit_Bill',$data,false);
        $this->load->view('User/footer');
    }
    public function Edit_Sheet_Bill($pid)
    {
        $pi_icode = $pid;
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->user_model->Get_Single_Invoice_Item_Sheet($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->user_model->Get_Single_Invoice_Item_Sheet_Total($pi_icode);
        $data['sheet'] = $this->user_model->Get_Single_Sheet($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['work_order'] = $this->user_model->Get_Single_wo($pi_icode);
        $data['User']=$this->user_model->Get_User_Details($pi_icode);
        $data['check_user']=$this->user_model->Get_Check_User_Details();
        $wo_icode = $data['work_order'][0]['WO_Icode'];
        $data['bill'] = $this->user_model->Get_Bill_details($wo_icode);
        $bill_icode = $data['bill'][0]['Bill_Icode'];
        $data['bill_Charges'] = $this->user_model->Get_Single_Bill_Charges($bill_icode);
        $data['bill_customer']= $this->user_model->Get_Bill_Customer($bill_icode);

        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Edit_Sheet_Bill',$data,false);
        $this->load->view('User/footer');
    }

    public  function  Update_Bill()
    {
        $pi_icode = $this->input->post('PI_Icode');
        $bill_icode = $this->input->post('bill_icode');
        $data = array(
            'Vehicle_No' =>$this->input->post('vehicle_no'),
            'Destination' => $this->input->post('destination'),
            'Customer_Address'=> $this->input->post('new_cus_address'),
            'Delivery_Address'=> $this->input->post('new_delivery_address'),
            'Transport' => $this->input->post('transport'),
            'Sub_Total' => $this->input->post('sub_tot'),
            'Insurance_Value'=> $this->input->post('insurance'),
            'SGST_Value' => $this->input->post('sgst'),
            'CGST_Value' => $this->input->post('cgst'),
            'IGST_Value' => $this->input->post('igst'),
            'GrossTotal_Value' => $this->input->post('gross_tot'),
            'Amt_Words' =>$this->input->post('amt_words'),
            'Created_By' => $this->session->userdata['userid']);
        $this->db->where('Bill_Icode',$bill_icode);
        $this->db->update('billing_details', $data);

        $delete_charges_id = $this->input->post('Delete_Charge_Icode');
        $count1 = sizeof($delete_charges_id);
        for($i=0; $i<$count1; $i++)
        {

            $delete_chrg_list=$this->user_model->delete_bill_charges($delete_charges_id[$i]);

        }



        $charges_count = $this->input->post('Delete_charges_count');
        $charges_value = $this->input->post('Delete_charges_value');
        $charges_cost = $this->input->post('tot_charge_amt');

        $update_charges_id = $this->input->post('Delete_charges');

        $bill_charges_id = $this->input->post('bill_charge_icode');



        $count_update = sizeof($bill_charges_id);
        for($i=0; $i<$count_update; $i++)
        {
            $bill_charge = $bill_charges_id[$i];

            $full_data1 =array( 'bill_icode' => $bill_icode,
                'Proforma_Charge_Icode' => $update_charges_id[$i],
                'Proforma_Charge_Count' => $charges_count[$i],
                'Proforma_Charge_Value' => $charges_value[$i],
                'Proforma_Charge_Cost' => $charges_cost[$i],
                'created_by' => $this->session->userdata['userid']
            );
            $this->db->where('bill_charge_icode',$bill_charge);
            $this->db->update('billing_charges_entry', $full_data1);
        }


        $item_icode = $this->input->post('item_icode');
        $material_id = $this->input->post('material');
        $qty = $this->input->post('pics');
        $holes = $this->input->post('holes');
        $cutout = $this->input->post('cutout');
        $cost = $this->input->post('total');
        $actual_W = $this->input->post('Actual_width');
        $actual_H = $this->input->post('Actual_height');
        $Charge_W = $this->input->post('Charge_width');
        $Area = $this->input->post('area');
        $Charge_H = $this->input->post('Charge_height');
        $Rate = $this->input->post('rate');
        $special = $this->input->post('special');
        $count = sizeof($material_id);
        for($i=0; $i<$count; $i++)
        {
            $full_data =array( 'Proforma_Icode' => $pi_icode,
                'Proforma_Holes' => $holes[$i],
                'Proforma_Qty' => $qty[$i],
                'Proforma_Special'=>$special[$i],
                'Proforma_Cutout' => $cutout[$i],
                'Proforma_Material_Rate' => $Rate[$i],
                'Proforma_Material_Cost' => $cost[$i],
                'Proforma_Material_Icode'=>$material_id[$i],
                'Proforma_Actual_Size_Width' => $actual_W[$i],
                'Proforma_Actual_Size_Height' => $actual_H[$i],
                'Proforma_Chargeable_Size_Width' =>$Charge_W[$i],
                'Proforma_Chargeable_Size_Height' => $Charge_H[$i],
                'Proforma_Area_SQMTR' => $Area[$i],
                'Modified_By' => $this->session->userdata['userid'],'Modified_On' => date('Y-m-d H:i:s'));
            $this->db->where('Proforma_Invoice_Items_Icode',$item_icode[$i]);
            $this->db->update('proforma_invoice_items', $full_data);
        }

        $this->session->set_flashdata('feedback', 'Bill Updated Successfully..');

        $pi_type = $this->input->post('bill_type');

        if($pi_type == '0')
        {
            redirect('User_Controller/View_Single_Bill/'.$pi_icode);
        }
        else
        {
            redirect('User_Controller/View_Single_Sheet_Bill/'.$pi_icode);
        }

    }

    //** Update Sheet Bill */
    public function Update_Sheet_Bill()
    {
        $pi_icode = $this->input->post('PI_Icode');
        $bill_icode = $this->input->post('bill_icode');
        $data = array(
            'Vehicle_No' =>$this->input->post('vehicle_no'),
            'Destination' => $this->input->post('destination'),
            'Customer_Address'=> $this->input->post('new_cus_address'),
            'Delivery_Address'=> $this->input->post('new_delivery_address'),
            'Transport' => $this->input->post('transport'),
            'Sub_Total' => $this->input->post('sub_tot'),
            'Insurance_Value'=> $this->input->post('insurance'),
            'SGST_Value' => $this->input->post('sgst'),
            'CGST_Value' => $this->input->post('cgst'),
            'IGST_Value' => $this->input->post('igst'),
            'GrossTotal_Value' => $this->input->post('gross_tot'),
            'Amt_Words' =>$this->input->post('amt_words'),
            'Created_By' => $this->session->userdata['userid']);
        $this->db->where('Bill_Icode',$bill_icode);
        $this->db->update('billing_details', $data);

        $delete_charges_id = $this->input->post('Delete_Charge_Icode');
        $count1 = sizeof($delete_charges_id);
        for($i=0; $i<$count1; $i++)
        {

            $delete_chrg_list=$this->user_model->delete_bill_charges($delete_charges_id[$i]);

        }



        $charges_count = $this->input->post('Delete_charges_count');
        $charges_value = $this->input->post('Delete_charges_value');
        $charges_cost = $this->input->post('tot_charge_amt');

        $update_charges_id = $this->input->post('Delete_charges');

        $bill_charges_id = $this->input->post('bill_charge_icode');



        $count_update = sizeof($bill_charges_id);
        for($i=0; $i<$count_update; $i++)
        {
            $bill_charge = $bill_charges_id[$i];

            $full_data1 =array( 'bill_icode' => $bill_icode,
                'Proforma_Charge_Icode' => $update_charges_id[$i],
                'Proforma_Charge_Count' => $charges_count[$i],
                'Proforma_Charge_Value' => $charges_value[$i],
                'Proforma_Charge_Cost' => $charges_cost[$i],
                'created_by' => $this->session->userdata['userid']
            );
            $this->db->where('bill_charge_icode',$bill_charge);
            $this->db->update('billing_charges_entry', $full_data1);
        }

        $sheet_icode = $this->input->post('sheet_icode');
        $sheet_material = $this->input->post('sheet_material');
        $sheet_piece = $this->input->post('sheet_pieces');
        $sheet_act_h = $this->input->post('sheet_Act_Size_H');
        $sheet_act_w = $this->input->post('sheet_Act_Size_W');
        $sheet_cha_h = $this->input->post('sheet_Cha_Size_H');
        $sheet_cha_w = $this->input->post('sheet_Cha_Size_W');
        $sheet_area = $this->input->post('sheet_Area');
        $sheet_rate = $this->input->post('sheet_Rate');
        $sheet_amt = $this->input->post('sheet_Rate_Amt');
        $count_sheet = sizeof($sheet_icode);
        for($i=0; $i<$count_sheet; $i++)
        {
            $full_data =array( 'Proforma_Icode' => $pi_icode,
                'Proforma_Material_Icode' =>$sheet_material[$i],
                'No_Of_Sheet' => $sheet_piece[$i],
                'Actual_Height' => $sheet_act_h[$i],
                'Actual_Width' => $sheet_act_w[$i],
                'Chargable_Height' => $sheet_cha_h[$i],
                'Chargable_Width' => $sheet_cha_w[$i],
                'Area' => $sheet_area[$i],
                'Rate' => $sheet_rate[$i],
                'Total_Amount' =>$sheet_amt[$i],
                'Modified_By' => $this->session->userdata['userid'],
                'Modified_On' => date('Y-m-d H:i:s'));
            $this->db->where('pi_sheet_icode',$sheet_icode[$i]);
            $this->db->update('proforma_invoice_sheet', $full_data);
        }

        $item_sheet_id = $this->input->post('item_icode');
        $material_id = $this->input->post('material');
        $qty = $this->input->post('pics');
        $holes = $this->input->post('holes');
        $cutout = $this->input->post('cutout');
        $actual_W = $this->input->post('width');
        $actual_H = $this->input->post('height');
        $special = $this->input->post('type');
        $Area = $this->input->post('area');
        $Rate = $this->input->post('rate');
        $cost = $this->input->post('total');
        $count = sizeof($material_id);
        for($i=0; $i<$count; $i++)
        {
            $full_data =array( 'Proforma_Icode' => $pi_icode,
                'Proforma_Holes' => $holes[$i],
                'Proforma_Qty' => $qty[$i],
                'Proforma_Cutout' => $cutout[$i],
                'Proforma_Material_Icode' => $material_id[$i],
                'Proforma_Special'=>$special[$i],
                'Proforma_Actual_Size_Width' => $actual_W[$i],
                'Proforma_Actual_Size_Height' => $actual_H[$i],
                'Proforma_Chargeable_Size_Width' =>$actual_W[$i],
                'Proforma_Chargeable_Size_Height' => $actual_H[$i],
                'Proforma_Area_SQMTR' => $Area[$i],
                'Proforma_Material_Rate' => $Rate[$i],
                'Proforma_Material_Cost' => $cost[$i],
                'Modified_By' => $this->session->userdata['userid'],
                'Modified_On' => date('Y-m-d H:i:s'));
            $this->db->where('pi_item_sheet_icode',$item_sheet_id[$i]);
            $this->db->update('proforma_invoice_item_sheet', $full_data);
        }





        $this->session->set_flashdata('feedback', 'Bill Updated Successfully..');

        $pi_type = $this->input->post('bill_type');

        if($pi_type == '0')
        {
            redirect('User_Controller/View_Single_Bill/'.$pi_icode);
        }
        else
        {
            redirect('User_Controller/View_Single_Sheet_Bill/'.$pi_icode);
        }

    }

    public function PDF_Bill()
    {
        $picode=$this->input->post('PI_Icode');
        $type = $this->input->post('PI_Type');

        $this->load->library('pdf');
        if($type == '1')
        {
            $data['invoice_item'] = $this->admin_model->Get_Single_Sheet_Invoice_Item($picode);
            $data['invoice_total'] = $this->user_model->Get_Single_Invoice_Item_Sheet_Total($picode);
            $data['sheet'] = $this->admin_model->Get_Sheet_Details($picode);
        }
        else
        {
            $data['invoice_item'] = $this->admin_model->Get_Single_Invoice_Item($picode);
            $data['invoice_total'] = $this->admin_model->Get_Single_Invoice_Item_Total($picode);
        }
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($picode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($picode);
        $data['User']=$this->user_model->Get_User_Details($picode);
        $data['check_user']=$this->user_model->Get_Check_User_Details();
        $data['work_order'] = $this->user_model->Get_Single_wo($picode);
        $wo_icode = $data['work_order'][0]['WO_Icode'];
        $data['bill'] = $this->user_model->Get_Bill_details($wo_icode);
        $bill_icode = $data['bill'][0]['Bill_Icode'];
        $data['bill_Charges'] = $this->user_model->Get_Single_Bill_Charges($bill_icode);
        $data['bill_customer']= $this->user_model->Get_Bill_Customer($bill_icode);
        $body = $this->load->view('User/Pdf_bill',$data,TRUE);
        $this->pdf->loadHtml($body);
        $this->pdf->render();
        $this->pdf->stream("welcome.pdf", array("Attachment"=>0));
    }

    //bill report
    public function Bill_Report()
    {
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Bill_Report');
        $this->load->view('User/footer');
    }

    //** print_bill_datre */
    public function Print_Bill_Report()
    {
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $data['bill_report'] = $this->user_model->Get_Bill_Reports($from_date,$to_date);
        $data['st']= $this->admin_model->get_ST();
        $data['from_date']  =$from_date;
        $data['to_date']  =$to_date;
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Print_Bill_Report',$data,false);
        $this->load->view('User/footer');

    }

    // Work order report
    public function wo_Report()
    {
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/WO_Report');
        $this->load->view('User/footer');

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
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Print_WO_Report',$data,false);
        $this->load->view('User/footer');
    }

    public function Print_PDF_WO()
    {
        $this->load->library('pdf');
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
        $body = $this->load->view('User/Print_WO_Pdf',$data,TRUE);
        $this->pdf->loadHtml($body);
        $this->pdf->render();
        $this->pdf->stream("welcome.pdf", array("Attachment"=>0));

    }

    public function Today_Wo_Report()
    {
        $data['pi_count']= $this->admin_model->Get_Today_PI_Counts();
        $data['wo_count']= $this->admin_model->Get_Today_WO_Counts();
        $normal_wo = $this->admin_model->Get_Today_normal_WO_details();
        $sheet_wo = $this->admin_model->Get_Today_sheet_WO_details();
        $data['wo_details'] = array_merge($normal_wo, $sheet_wo);
        $data['wo_count']= $this->admin_model->Get_Today_WO_Counts();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Today_Wo_Report',$data, FALSE);
        $this->load->view('User/footer');
    }

    public function PI_Report()
    {
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/PI_Report');
        $this->load->view('User/footer');
    }
    public function Print_PI_Report()
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
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Print_PI_Report',$data,false);
        $this->load->view('User/footer');
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
    //** Work Order Report with invoice number */
    public function Work_Order_Report()
    {
        $data['wo'] = $this->user_model->get_All_WO();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/All_Work_Orders',$data,false);
        $this->load->view('User/footer');
    }
    public function Normal_WO($id)
    {
        $pi_icode = $this->uri->segment(3);
        $data['wo'] = $this->admin_model->Get_Work_Order($pi_icode);
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->admin_model->Get_Single_Invoice_Item($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->admin_model->Get_Single_Invoice_Item_Total($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Print_Normal_WO',$data,false);
        $this->load->view('User/footer');
    }

    /** Get Single sheet work order */
    public function Sheet_WO()
    {
        $pi_icode = $this->uri->segment(3);
        $data['invoice'] = $this->admin_model->Get_Single_Invoice($pi_icode);
        $data['invoice_item'] = $this->user_model->Get_Single_Invoice_Item_Sheet($pi_icode);
        $data['invoice_Charges'] = $this->admin_model->Get_Single_Invoice_Charges($pi_icode);
        $data['invoice_total'] = $this->user_model->Get_Single_Invoice_Item_Sheet_Total($pi_icode);
        $data['sheet'] = $this->user_model->Get_Single_Sheet($pi_icode);
        $data['tax']= $this->admin_model->get_Tax();
        $data['st']= $this->admin_model->get_ST();
        $data['stock']= $this->admin_model->get_all_item();
        $data['wo'] = $this->user_model->Get_Single_wo($pi_icode);
        $data['charges']= $this->admin_model->get_all_charges();
        $this->load->view('User/header');
        $this->load->view('User/top');
        $this->load->view('User/left');
        $this->load->view('User/Print_Sheet_WO',$data,false);
        $this->load->view('User/footer');
    }

}