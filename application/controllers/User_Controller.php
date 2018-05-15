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