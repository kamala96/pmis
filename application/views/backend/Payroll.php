 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends CI_Controller {

        function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('leave_model');
        $this->load->model('payroll_model');
        $this->load->model('settings_model');
        $this->load->model('organization_model');
        $this->load->model('loan_model');
    }
    public function index()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            redirect('dashboard/Dashboard');
            $data=array();
            #$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
            $this->load->view('login');
    }
    public function Salary_Scale(){
        if($this->session->userdata('user_login_access') != False) {
        $data['scalevalue'] = $this->payroll_model->GetSalaryScale();
        $this->load->view('backend/salary_scale',$data);
        }
        else{
            redirect(base_url() , 'refresh');
        }
    }
    public function Add_Salary_Scale(){
        if($this->session->userdata('user_login_access') != False) {

        $id = $this->input->post('scaleId');
        $scalename = $this->input->post('salary_scale');
        $amount = $this->input->post('amount');
        $increment = $this->input->post('increment');

        //$this->form_validation->set_error_delimiters();
        //$this->form_validation->set_rules('icrement', 'Increment', 'trim|required|min_length[3]|max_length[7]|xss_clean');

            $data = array();
            $data = array(
                    'scale_name' => $scalename,
                    'amount' => $amount,
                    'increment' => $increment
                );

                if (empty($id)) {
                     $success = $this->payroll_model->Insert_Salary_Scale($data);
                echo "Successfully Added";
                } else {
                   $success = $this->payroll_model->Salary_Scale_Update($id,$data);
                    echo "Successfully Updated";
                }
            }
        else{
                redirect(base_url() , 'refresh');
            }
    }


    public function Salary_Scale_Edit($ScaleId){
        if($this->session->userdata('user_login_access') != False) {
        $data['scalevalue'] = $this->payroll_model->GetSalaryScale();
        $data['EditSalaryScale']=$this->payroll_model->Edit_Salary_Scale($ScaleId);
        $this->load->view('backend/salary_scale', $data);
        }
    else{
        redirect(base_url() , 'refresh');
    }
    }

public function Salary_Scale_Delete($ScaleId){
        if($this->session->userdata('user_login_access') != False) {

        $this->payroll_model->Delete_Salary_Scale($ScaleId);
        $this->session->set_flashdata('delsuccess', 'Successfully Deleted');
        redirect('payroll/Salary_Scale');
        }
    else{
        redirect(base_url() , 'refresh');
    }
    }

    public function GetScale(){

      $scale_name = $this->input->post('scale_name',TRUE);
      //run the query for the cities we specified earlier
      echo $this->payroll_model->Get_Scale_Salary($scale_name);

    }

    public function Salary_Type(){
        if($this->session->userdata('user_login_access') != False) {
        $data['typevalue'] = $this->payroll_model->GetsalaryType();
        $this->load->view('backend/salary_type',$data);
        }
        else{
            redirect(base_url() , 'refresh');
        }
    }
    public function Add_Sallary_Type(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->post('id');
        $type = $this->input->post('typename');
        $createdate = $this->input->post('createdate');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('typename', 'Type name', 'trim|required|min_length[3]|max_length[120]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
            } else {
            $data = array();
            $data = array(
                    'salary_type' => $type,
                    'create_date' => $createdate
                );
            if(empty($id)){
                $success = $this->payroll_model->Add_typeInfo($data);
                #redirect("leave/Holidays");
                #$this->session->set_flashdata('feedback','Successfully Added');
                echo "Successfully Added";
            } else {
                $success = $this->payroll_model->Update_typeInfo($id,$data);
                #$this->session->set_flashdata('feedback','Successfully Updated');
                #redirect("leave/Holidays");
                echo "Successfully Updated";
            }

        }
        }
    else{
        redirect(base_url() , 'refresh');
    }
    }

    public function GetSallaryTypeById(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->get('id');
        $data['typevalueid'] = $this->payroll_model->Get_typeValue($id);
        echo json_encode($data);
        }
    else{
        redirect(base_url() , 'refresh');
    }
    }
    public function GetSallaryById(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->get('id');
        $data=array();
        // $data['salaryvaluebyid'] = $this->payroll_model->Get_Salary_Value($id);
        // $data['salarypayvaluebyid'] = $this->payroll_model->Get_Salarypay_Value($id);
        $data['salaryvalue'] = $this->payroll_model->GetsalaryValueByID($id);
        $data['loanvaluebyid'] = $this->payroll_model->GetLoanValueByID($id);
        echo json_encode($data);
        }
    else{
        redirect(base_url() , 'refresh');
    }
    }
    public function Generate_salary(){
    if($this->session->userdata('user_login_access') != False) {
    $data['typevalue'] = $this->payroll_model->GetsalaryType();
    $data['employee'] = $this->employee_model->emselect();
    $data['salaryvalue'] = $this->payroll_model->GetAllSalary();
    $data['salaryvalue1'] = $this->payroll_model->GetsalaryValueEm();
    $data['department'] = $this->organization_model->depselect();
    $this->load->view('backend/salary_view',$data);
        }
    else{
        redirect(base_url() , 'refresh');
    }

    }

    // Generates the salary
    public function Add_Sallary_Pay(){
        if($this->session->userdata('user_login_access') != False) {
            $id = $this->input->post('id');
            $emid = $this->input->post('emid');
            $month = $this->input->post('month');
            $basic = $this->input->post('basic');
            $totalday = $this->input->post('month_work_hours');
            $totalday = $this->input->post('hours_worked');
            $loan = $this->input->post('loan');
            $loanid = $this->input->post('loan_id');
            $total = $this->input->post('total_paid');
            $paydate = $this->input->post('paydate');
            $status = $this->input->post('status');
            $paid_type = $this->input->post('paid_type');

            $this->form_validation->set_error_delimiters();
            $this->form_validation->set_rules('emid', 'Employee Id', 'trim|required');
            $this->form_validation->set_rules('basic', 'Employee Basic', 'trim|required|min_length[2]|max_length[7]|xss_clean');

            if ($this->form_validation->run() == FALSE) {

                    echo validation_errors();

                } else {

                $data = array();
                $data = array(
                        'emp_id' => $emid,
                        'month' => $month,
                        'paid_date' => $paydate,
                        'total_days' => $totalday,
                        'basic' => $basic,
                        'loan' => $loan,
                        'total_pay' => $total,
                        'status' => $status,
                        'paid_type' => $paid_type
                    );
                if(empty($id)){
                    $success = $this->payroll_model->insert_Salary_Pay($data);
                   if(empty($loanid)){
                        #$loaninfo = $this->payroll_model->GetloanInfo($emid);
                        echo "Successfully Added";
                    } else {
                        $loanvalue = $this->loan_model->GetLoanValuebyLId($loanid);
                        #$loaninfo = $this->payroll_model->GetloanInfo($emid);
                        if(!empty($loanvalue)){
                    $period = $loanvalue->install_period - 1;
                    $number = $loanvalue->loan_number;
                    $data = array();
                    $data = array(
                        'emp_id' => $emid,
                        'loan_id' => $loanid,
                        'loan_number' => $number,
                        'install_amount' => $loan,
                        /*'pay_amount' => $payment,*/
                        'app_date' => $paydate,
                        /*'receiver' => $receiver,*/
                        'install_no' => $period
                        /*'notes' => $notes*/
                    );
                $success = $this->loan_model->Add_installData($data);
                $totalpay = $loanvalue->total_pay + $loan;
                $totaldue = $loanvalue->amount - $totalpay;
                 /*$period = $loanvalue->install_period - 1;*/
                    if($period == '1'){
                        $status = 'Done';
                    }
                $data = array();
                $data = array(
                'total_pay'=>$totalpay,
                'total_due'=>$totaldue,
                'install_period'=>$period,
                'status'=>'Done'
                );
                $success = $this->loan_model->update_LoanData($loanid,$data);
                    } else {
                     echo "Successfully added But your Loan number is not available";
                    }
                }
                echo "Successfully Added";
                } else {
                    $success = $this->payroll_model->Update_SalaryPayInfo($id,$data);
                    echo "Successfully Updated";
                }

            }
        }
        else{
            redirect(base_url() , 'refresh');
        }
    }

   public function Save_Salary()
   {
            if($this->session->userdata('user_login_access') != False) {
                $em_id = $this->input->post('emid');
                $salary_scale = $this->input->post('salary_scale');
                $basic_amount = $this->input->post('basic_amount');
                $sid = $this->input->post('sid');

                //data for basic salary
                if (!empty($basic_amount) && !empty($salary_scale)) {
            $data['salaryvalue'] = $this->employee_model->GetsalaryValue($em_id);
                    // if (!empty($sid)) {
                //         $data = array();
                //         $data = array(
                //             'emp_id' => $em_id,
                //             'type_id' => $salary_scale,
                //             'total' => $basic_amount
                //         );
                // $success = $this->employee_model->Update_Salary($sid,$data);
                //         $message = 'Successfully Updated';
                //     } else {
                           $data = array();
                        $data = array(
                            'emp_id' => $em_id,
                            'type_id' => $salary_scale,
                            'total' => $basic_amount
                        );
                        $success = $this->employee_model->Add_Salary($data);
                        $salary_id = $this->db->insert_id();
                        $message = 'Successfully Added';
                //     }
                // }
                   //$message = 'Please Select Salary Scale';
                // }
                echo  $message;
            //}
            
   }
}else
            {
                redirect(base_url() , 'refresh');
            }
}

   public function Save_Addition()
   {
        if($this->session->userdata('user_login_access') != False) {
             $em_id = $this->input->post('emid');
             $sid = $this->input->post('sid');
             $addition_name = $this->input->post('addition_name');
             $addition_amount = $this->input->post('addition_amount');
             $date = '-31';
             $startmonth = $this->input->post('startdate');
             $endmonth =   $this->input->post('enddate');

             $remove  = $this->input->post('remove');
             $addid   = $this->input->post('addid');

             if (empty($addid)) {
               
             if (!empty($sid)) {
                 
                    for ($i=0; $i <sizeof($addition_name) ; $i++)
                    {
                        $data = array();
                        $data = array(
                            'salary_id' => $sid,
                            'add_name' => $addition_name[$i],
                            'add_amount' => $addition_amount,
                            'start_month'=>$startmonth,
                            'end_month'=>$endmonth,
                            'em_id' => $em_id
                        );
                $success = $this->employee_model->Add_Emp_Addition($data);
                    }
                    echo 'Successfully Added';
             }

              } else {

                 $this->employee_model->Delete_Emp_Addition($addid);
                 echo "Successfully Deleted";
              }

             //redirect(base_url());

        }
   }
   public function Save_Fund()
   {
        if($this->session->userdata('user_login_access') != False) {
             $basic_amount = $this->input->post('basic_amount');
             $sid = $this->input->post('sid');
             $fund_name = $this->input->post('fund_name');
             $fund_percent = $this->input->post('fund_percent');
             $emid = $this->input->post('emid');

             if (!empty($sid)) {
                 //Employee Addition from input

                        $data = array();
                        $data = array(
                            'salary_id' => $sid,
                            'fund_name' => $fund_name,
                            'fund_percent' => $fund_percent,
                            'em_id' => $emid
                        );
                $success = $this->employee_model->Add_Emp_Fund($data);
                echo 'Successfully Added';
             }
             else
             {
                echo 'Unsuccessfully Added';
             }
        }
   }
   public function Save_Assuarance()
   {
        if($this->session->userdata('user_login_access') != False) {
             $basic_amount = $this->input->post('basic_amount');
             $sid = $this->input->post('sid');
             $fund_name = $this->input->post('fund_name');
             $fund_percent = $this->input->post('fund_percent');
             $remove = $this->input->post('remove');
             $assId = $this->input->post('assId');
             $emid = $this->input->post('emid');

             $data = array();
                        $data = array(
                            'salary_id' => $sid,
                            'ded_name' => $fund_name,
                            'ded_amount' => $fund_percent,
                            'em_id' => $emid
                        );

             if (empty($remove)) {

              
                $success = $this->employee_model->Add_Emp_Assuarance($data);
                echo 'Successfully Added';
             // }
             // else
             // {
             //     $success = $this->employee_model->Update_Emp_Assuarance($data,$assId);
             //    echo 'Successfully Updated';
             // }
                
             } else {
                 $success = $this->employee_model->Delete_Emp_Assuarance($assId);
                echo 'Successfully Deleted';
             }
             
             
        }
   }
public function Non_Tax_Addition()
   {
        if($this->session->userdata('user_login_access') != False) {
             $em_id = $this->input->post('emid');
             $sid = $this->input->post('sid');
             $addition_name = $this->input->post('addition_name');
             $addition_amount = $this->input->post('addition_amount');
             $addid = $this->input->post('addid');
             $button = $this->input->post('delete');
                if (empty($button)) {
                    for ($i=0; $i <sizeof($addition_name) ; $i++)
                    {
                        $data = array();
                        $data = array(
                            'salary_id' => $sid,
                            'add_name' => $addition_name[$i],
                            'add_amount' => $addition_amount[$i],
                            'em_id' => $em_id
                        );
                $success = $this->employee_model->Add_Non_Tax_Addition($data);
                    }
                    echo 'Successfully Added';
                } else {
                    $success = $this->employee_model->Delete_Non_Tax_Addition($addid);
                    echo 'Successfully Deleted';
                }
                
                    
             }
             
   }

public function Save_NonPdecuction()
   {
        if($this->session->userdata('user_login_access') != False) {
             $em_id = $this->input->post('emid');
             $sid = $this->input->post('sid');
             $deduction_name = $this->input->post('deduction_name');
             $deduction_amount = $this->input->post('deduction_amount');
             $info = $this->payroll_model->getSalary($em_id);
             $dedid = $this->input->post('dedid');
             $button = $this->input->post('delete');

             if (empty($button)) {
                
                 if (!empty($sid)) {
                 //Employee Addition from input

                    for ($i=0; $i <sizeof($deduction_name) ; $i++)
                    {
                    if ($deduction_name[$i] == "COTWU(T)" || $deduction_name[$i] == "TEWUTA") {

                         $data = array();
                         $data = array(
                             'salary_id' => $sid,
                             'ded_name' => $deduction_name[$i],
                             'ded_amount' => $deduction_amount[$i] * $info->total,
                             'em_id' => $em_id
                       );

                        }else{

                        $data = array();
                        $data = array(
                            'salary_id' => $sid,
                            'ded_name' => $deduction_name[$i],
                            'ded_amount' => $deduction_amount[$i],
                            'em_id' => $em_id
                        );
                    }
                    $success = $this->employee_model->Add_Emp_Non_Percent($data);
                    }
                echo 'Successfully Added';
             }

             } else {
                 
                $success = $this->employee_model->Delete_Emp_Non_Percent($dedid);
                echo "Successfully Deleted";

             }
             
            
        }
   }

   public function Save_Pdecuction()
   {
        if($this->session->userdata('user_login_access') != False) {
             $em_id = $this->input->post('emid');
             $salary_id = $this->input->post('sid');
             $basic_amount = $this->input->post('basic_amount');
             $percent_name = $this->input->post('percent_name');
             $percent_amount = $this->input->post('percent_amount');
            $dedid = $this->input->post('dedid');
             //$getTotal['totalAddition']= $this->payroll_model->getTotalAdditionAmount($salary_id);
             //$total = $getTotal['totalAddition']->add_amount;

                if (empty($dedid)) {
                    
                    if (!empty($salary_id)) {
                 //Employee Addition from input

                   for ($i=0; $i <sizeof($percent_name) ; $i++)
                    {

                        //@$total = ($percent_amount[$i] * $basic_amount);
                        $data = array();
                        $data = array(
                            'salary_id' => $salary_id,
                            'ded_name' => $percent_name[$i],
                            'ded_percent' => $percent_amount[$i],
                            'ded_amount'  => $percent_amount[$i] * $basic_amount,
                            'em_id'  => $em_id
                        );
                        $success = $this->employee_model->Add_Emp_Percent($data);

                    }
                echo 'Successfully Added';
             } else{
                echo 'UnSuccessfully Added';
             }

                } else {

                      

                }
                
             
        }
   }
   public function Save_Othersdecuction()
   {
        if($this->session->userdata('user_login_access') != False) {
             $em_id = $this->input->post('emid');
             $sid = $this->input->post('sid');
             $others_names = $this->input->post('others_name');
             $loan_amount = $this->input->post('loan_amount');
             $loan_deduction_amount = $this->input->post('loan_deduction_amount');

             if (!empty($sid)) {
                 //Employee Addition from input

                   for ($i=0; $i <sizeof($others_names) ; $i++)
                    {
                    $data = array();
                        $data = array(
                                 'salary_id' =>$sid,
                                 'other_names'=>$others_names[$i],
                                 'loan_amount'=>$loan_amount[$i],
                                 'installment_Amount' => $loan_deduction_amount[$i],
                                 'status'=>'ACTIVE',
                                 'em_id' => $em_id,
                                 'month'=>date('M'),
                                 'year'=>date('Y')
                             );
                 $success = $this->employee_model->Add_Others_Deduction($data);
                    }
                echo 'Successfully Added';
             }
        }
   }
   public function Delete_Othersdecuction()
   {
        if($this->session->userdata('user_login_access') != False) {

             $id = $this->input->post('id');
             $success = $this->employee_model->Delete_Othersdecuction($id);
             $success = $this->employee_model->Delete_others_deduction_permonth($id);
             echo 'Successfully Deleted';

        }
   }
   public function Delete_NonPdecuction()
   {
        if($this->session->userdata('user_login_access') != False) {

             $dedid = $this->input->post('dedid');
                 $success = $this->employee_model->Delete_Emp_Non_Percent($dedid);
            
             echo 'Successfully Deleted';

        }
   }
    // From Salary List - Not Sure
    public function Add_Salary(){
        if($this->session->userdata('user_login_access') != False) {
        $salary_id = $this->input->post('sid');
        $add_id = $this->input->post('aid');
        $ded_id = $this->input->post('did');
        $emid = $this->input->post('emid');
        $salary_scale= $this->input->post('salary_scale');
        $amount = $this->input->post('amount');
        $house = $this->input->post('house');
        $transport = $this->input->post('transport');
        $acting = $this->input->post('acting');
        $telphone = $this->input->post('telphone');
        $overtime = $this->input->post('overtime');
        $fuel = $this->input->post('fuel');
        $paye = $this->input->post('paye');
        $premium = $this->input->post('premium');
        $nssf = $this->input->post('nssf');
        $psssf = $this->input->post('psssf');
        $nhif = $this->input->post('nhif');
        $workers = $this->input->post('workers');
        $thb = $this->input->post('thb');
        $wadu = $this->input->post('wadu');
        $pss = $this->input->post('pss');
        $court = $this->input->post('court');
        $control = $this->input->post('control');
        $others = $this->input->post('others');
        $imprest = $this->input->post('imprest');
        $name = $this->input->post('name');
        $deductionAmount =$this->input->post('deductionAmount');
        $loanAmount =$this->input->post('loanamount');
        $salarycontrol = $this->input->post('salary_control');


        if (!empty($salary_id)) {

            //data for basic salary
                $data = array();
                        $data = array(
                            'emp_id' => $emid,
                            'type_id' => $salary_scale,
                            'total' => $amount
                        );
                $success = $this->employee_model->Update_Salary($salary_id,$data);
                $insertIdSalary = $this->db->insert_id();
                //Data for employee addition
                 $data1 = array();
                 $data1 = array(
                     'salary_id' => $salary_id,
                     'basic' => $amount,
                     'transport_allowance' => $transport,
                     'overtime' => $overtime,
                     'acting_allowance' => $acting,
                     'telephone_allowance' => $telphone,
                     'house_allowance' => $house,
                     'fuel_allowance' => $fuel
                );

                $success = $this->employee_model->Update_Addition($add_id,$data1);

                //data for employee deduction
                $data2 = array();
                 $data2 = array(
                     'salary_id' => $salary_id,
                     'others' => $others,
                     'imprest_recovery' => $imprest,
                     'salary_control' => $control,
                     'insuarance_premium' => $premium,
                     'nssf' => $nssf,
                     'psssf' => $psssf,
                     'nhif' => $nhif,
                     'workers_union' => $workers,
                     'thb' => $thb,
                     'wadu' => $wadu,
                     'court' => $court,
                     'postasaccoss' => $pss,
                     'paye' => $paye
                );
                $success = $this->employee_model->Update_Deduction($ded_id,$data2);

                if (!empty($name)) {
                   $data3 = array();
                    $data3 = array('salary_id' =>$salary_id,
                                 'other_names'=>$name,
                                 'others_amount'=>$deductionAmount,
                                 'loan_amount'=>$loanAmount,
                                 'installment_Amount' => $loanAmount
                             );
                 $success = $this->employee_model->Add_Others_Deduction($data3);
                }
                echo "Successfully Updated";

            } else {
                //data for basic salary
                $data = array();
                        $data = array(
                            'emp_id' => $emid,
                            'type_id' => $salary_scale,
                            'total' => $amount
                        );
                $success = $this->employee_model->Add_Salary($data);
                $insertIdSalary = $this->db->insert_id(); //last id of salary

                //Data for employee addition
                 $data1 = array();
                 $data1 = array(
                     'salary_id' => $insertIdSalary,
                     'basic' => $amount,
                     'transport_allowance' => $transport,
                     'overtime' => $overtime,
                     'acting_allowance' => $acting,
                     'telephone_allowance' => $telphone,
                     'house_allowance' => $house,
                     'fuel_allowance' => $fuel
                );
            $success = $this->employee_model->Add_Addition($data1);

                //data for employee deduction
                $data2 = array();
                 $data2 = array(
                     'salary_id' => $insertIdSalary,
                     'others' => $others,
                     'imprest_recovery' => $imprest,
                     'salary_control' => $control,
                     'insuarance_premium' => $premium,
                     'nssf' => $nssf,
                     'psssf' => $psssf,
                     'nhif' => $nhif,
                     'workers_union' => $workers,
                     'thb' => $thb,
                     'wadu' => $wadu,
                     'court' => $court,
                     'postasaccoss' => $pss,
                     'paye' => $paye
                );
          $success = $this->employee_model->Add_Deduction($data2);

                   if (!empty($name) and !empty($loanAmount)) {
                   $data3 = array();
                    $data3 = array('salary_id' =>$salary_id,
                                 'other_names'=>$name,
                                 'others_amount'=>$deductionAmount,
                                 'loan_amount'=>$loanAmount,
                                 'installment_Amount' => $loanAmount
                             );
                 $success = $this->employee_model->Add_Others_Deduction($data3);
                }
            echo "Successfully Added";
            }

        }
    else{
        redirect(base_url() , 'refresh');
    }
    }
    public function Get_PayrollDetails(){
        $depid = $this->input->get('dep_id');
        $dateval = $this->input->get('date_time');

       $orderdate = explode('-', $dateval);
        $month = $orderdate[0];
        $year = $orderdate[1];

        $day = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $holiday = $this->payroll_model->GetHolidayByYear($dateval);
        $totalday = 0;
       foreach($holiday as $value){
            #$start = date_create($value->from_date);
            #$end = date_create($value->to_date);

            $days = $value->number_of_days;
           #$inday = $days->format("%a");
           #$total = array_sum($inday);

            $totalday = $totalday + $days;
        }
        $totalholiday = $totalday;
        $m = date('m');
        $y = date('Y');
        function getDays($y,$m){
            $allday = cal_days_in_month(CAL_GREGORIAN,$m,$y);
            $wed = array();
            for($i = 1; $i<= $allday; $i++){
                $daye  = date('Y-m-'.$i);
                $result = date("D", strtotime($daye));
                if($result == "Fri"){
                    $fri[] = date("Y-m-d", strtotime($daye)). " ".$result."<br>";
                }
            }
            return  count($fri);
        }
        $fri = getDays($y, $m);
        $totalweekend = $fri;
        $holidays = $totalholiday + $totalweekend;
        $monthday = $day - $holidays;


        $totalmonthhour = $monthday * 8;
        $totalmonthhour;
        $employee = $this->payroll_model->GetDepEmployee($depid);

        foreach($employee as $value){
            $hourrate = $value->total/$totalmonthhour;
            echo "<tr>
                    <td>$value->em_code</td>
                    <td>$value->first_name</td>
                    <td>$value->total</td>
                    <td>$hourrate</td>
                    <td>$totalmonthhour</td>
                    <td><a href='' data-id='$value->em_id' class='btn btn-sm btn-info waves-effect waves-light salaryGenerateModal' data-toggle='modal' data-target='#SalaryTypemodel' data-hour='$totalmonthhour'>Generate Salary</a></td>
                </tr>";
        }

    }

    // Original one commented out above
    public function Salary_List(){

        if($this->session->userdata('user_login_access') != False) {

        $data['salary_info'] = $this->payroll_model->getAllSalaryData();

        $this->load->view('backend/salary_list', $data);

        }

        else {

            redirect(base_url() , 'refresh');
        }
    }

    // Start Invoice
    public function Invoice(){
        if($this->session->userdata('user_login_access') != False) {
        /*$data['typevalue'] = $this->payroll_model->GetsalaryType();*/
        $id                         = $this->input->get('Id');
        $eid                         = $this->input->get('em');
        $data2                      = array();

        $data['salary_info'] = $this->payroll_model->getAllSalaryDataById($id);

        // $data['salary_info']        = $this->payroll_model->getAllSalaryID($id);
        $data['employee_info']      = $this->payroll_model->getEmployeeID($eid);
        $data['salaryvaluebyid']    = $this->payroll_model->Get_Salary_Value($eid); // 24
        $data['salarypaybyid']      = $this->payroll_model->Get_SalaryID($eid);
        $data['salaryvalue']        = $this->payroll_model->GetsalaryValueByID($eid); // 25000
        $data['loanvaluebyid']      = $this->payroll_model->GetLoanValueByID($eid);
        $data['settingsvalue']      = $this->settings_model->GetSettingsValue();

        $data['addition'] = $this->payroll_model->getAdditionDataBySalaryID($data['salaryvalue']->id);
        $data['diduction'] = $this->payroll_model->getDiductionDataBySalaryID($data['salaryvalue']->id);
        //$data['diduction'] = $this->payroll_model->getDiductionDataBySalaryID($data['salaryvalue']->id);

        //$month = date('m');
        //$data['loanInfo']      = $this->payroll_model->getLoanInfoInvoice($id, $month);
        $data['otherInfo']      = $this->payroll_model->getOtherInfo($eid);
        $data['bankinfo']      = $this->payroll_model->GetBankInfo($eid);

        //Count Add/Did
        $month_init = $data['salary_info']->month;

        $month = date("n",strtotime($month_init));
        $year = $data['salary_info']->year;
        $id_em = $data['employee_info']->em_id;

        $data['id_em']=$id_em;
        $data['month']=$month;

        if ($month<10){
            $month = '0' . $month;
        }

        //$data['hourlyAdditionDiduction']      = $month;


        $employeePIN = $this->getPinFromID($id_em);

        // Count Friday
        $fridays = $this->count_friday($month, $year);



       $month_holiday_count = $this->payroll_model->getNumberOfHolidays($month, $year);

        // Total holidays and friday count
        $total_days_off = $fridays + $month_holiday_count->total_days;

        // Total days in the month
        $total_days_in_the_month = $this->total_days_in_a_month($month, $year);

        $total_work_days = $total_days_in_the_month - $total_days_off;

        $total_work_hours = $total_work_days * 8;

        //Format date for hours count in the hours_worked_by_employee() function
        $start_date = $year . '-' . $month . '-' . 1;
        $end_date = $year . '-' . $month . '-' . $total_days_in_the_month;

        // Employee actually worked
        $employee_actually_worked = $this->hours_worked_by_employee($employeePIN->em_code, $start_date, $end_date);  // in hours

        //Get his monthly salary
        $employee_salary = $this->payroll_model->GetsalaryValueByID($id_em);
        if($employee_salary) {
            $employee_salary = $employee_salary->total;
        }

        // Hourly rate for the month
        $hourly_rate = $employee_salary / $total_work_hours; //15.62

        $work_hour_diff = abs($total_work_hours) - abs($employee_actually_worked[0]->Hours);



        $data['work_h_diff'] = $work_hour_diff;
        $addition = 0;
        $diduction = 0;
        if($work_hour_diff < 0) {
            $addition = abs($work_hour_diff) * $hourly_rate;
        } else if($work_hour_diff > 0) {
            $diduction = abs($work_hour_diff) * $hourly_rate;
        }
        // Loan
        $loan_amount = $this->payroll_model->GetLoanValueByID($id_em);
        if($loan_amount) {
            $loan_amount = $loan_amount->installment;
        }
         // Sending

        $data['a'] = $addition;
        $data['d'] = $data['salary_info']->diduction;

        $this->load->view('backend/invoice',$data);
        }
        else {
            redirect(base_url() , 'refresh');
        }
    }

    // Start Invoice
    public function load_employee_Invoice_by_EmId_for_pay(){
        if($this->session->userdata('user_login_access') != False) {
            $emid = $this->input->post('emid');
            $dateTime = $this->input->post('datetime');

            $orderdate = explode('-', $dateTime);
            $month = $orderdate[0];
            $year = $orderdate[1];
            $month = $this->month_number_to_name($month);


           $data['salaryInfor'] = $this->payroll_model->getSalaryByMonthYearEmid($emid,$month,$year);



        }
        else {
            redirect(base_url() , 'refresh');
        }
    }
    // End Invoice

    private function count_friday($month, $year) {
        $fridays=0;
        $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        for($i=1;$i<=$total_days;$i++) {
            if(date('N',strtotime($year.'-'.$month.'-'.$i))==5) {
                $fridays++;
            }
        }
        return $fridays;
    }

    private function total_days_in_a_month($month, $year) {
        return cal_days_in_month(CAL_GREGORIAN, $month, $year);
    }

    // Totals hours worked by an emplyee in a month
    private function hours_worked_by_employee($employeeID, $start_date, $end_date) {
        return $this->payroll_model->totalHoursWorkedByEmployeeInAMonth($employeeID, $start_date, $end_date);
    }


    private function getPinFromID($employeeID) {
        return $this->payroll_model->getPinFromID($employeeID);
    }

    /*GET WORKHOURS OF ANY MONTH - */
    /*||||| Method has not been used anywhere |||||*/
    public function GetSalaryByWorkdays(){

        if($this->session->userdata('user_login_access') != False) {

        // Get the month and year
        $monthName = $this->input->get('monthName');
        $employeeID = $this->input->get('employeeID');
        $year = date("Y");

        // Count Friday
        $fridays = $this->count_friday($monthName, $year);


        $month_holiday_count = $this->payroll_model->getNumberOfHolidays($monthName, $year);

        // Total holidays and friday count
        $total_days_off = $fridays + $month_holiday_count->total_days;

        // Total days in the month
        $total_days_in_the_month = $this->total_days_in_a_month($monthName, $year);

        $total_work_days = $total_days_in_the_month - $total_days_off;

        $total_work_hours = $total_work_days * 8;

        //Format date for hours count in the hours_worked_by_employee() function
        $start_date = $year . '-' . $monthName . '-' . 1;
        $end_date = $total_days_in_the_month . '-' . $monthName . '-' . $total_days_in_the_month;

        // Employee actually worked
        $employee_actually_worked = $this->hours_worked_by_employee($employeeID, $start_date, $end_date);  // in hours

        //Get his monthly salary
        $employee_salary = $this->payroll_model->GetsalaryValueByID($employeeID);
        if($employee_salary) {
            $employee_salary = $employee_salary->total;
        }

        // Hourly rate for the month
        $hourly_rate = $employee_salary / $total_work_hours;

        $work_hour_diff = abs($total_work_hours) - abs($employee_actually_worked[0]->Hours); // 96 - 16 = 80

        $addition = 0;
        $diduction = 0;
        if($work_hour_diff < 0) {
            $addition = abs($work_hour_diff) * $hourly_rate;
        } else if($work_hour_diff > 0) {
            // 80 is > 0 which means he worked less, so diduction = 80 hrs
            // so 80 * hourly rate 208 taka = 17500
            $diduction = abs($work_hour_diff) * $hourly_rate;
        }

        // Loan
        $loan_amount = $this->payroll_model->GetLoanValueByID($employeeID);
        if($loan_amount) {
            $loan_amount = $loan_amount->installment;
        }

        // Sending
        $data = array();
        $data['basic_salary'] = $employee_salary;
        $data['total_work_hours'] = $total_work_hours;
        $data['employee_actually_worked'] = $employee_actually_worked[0]->Hours;
        $data['addition'] = $addition;
        $data['diduction'] = $diduction;
        $data['loan'] = $loan_amount;
        echo json_encode($data);
        }
        else{
            redirect(base_url() , 'refresh');
        }
    }

    public function month_number_to_name($month) {
        $dateObj   = DateTime::createFromFormat('!m', $month);
        return $dateObj->format('F'); // March
    }

    public function get_full_name($first_name, $last_name) {
        return $first_name . ' ' . $last_name;
    }

    public function pay_salary()
    {
        $em_id = $this->input->post('em_id');
        $emp_code = $this->input->post('emp_code');
        $salary_id = $this->input->post('salary_id');
        $basic_total = $this->input->post('basic_total');
        $salary_scale = $this->input->post('salary_scale');
        $house_total = $this->input->post('house_total');
        $fuel_total = $this->input->post('fuel_total');
        $transport_total = $this->input->post('transport_total');
        $overtime_total = $this->input->post('overtime_total');
        $acting_total = $this->input->post('acting_total');
        $telephone_total = $this->input->post('telephone_total');
        $wadu_total = $this->input->post('wadu_total');
        $nssf_total = $this->input->post('nssf_total');
        $psssf_total = $this->input->post('psssf_total');
        $nhif_total = $this->input->post('nhif_total');
        $workers_total = $this->input->post('workers_total');
        $thb_total = $this->input->post('thb_total');
        $postasaccos_total = $this->input->post('postasaccos_total');
        $court_total = $this->input->post('court_total');
        $paye_total = $this->input->post('paye_total');
        $imprest_total = $this->input->post('imprest_total');
        $insuarance_total = $this->input->post('insuarance_total');
        $salarycontrol = $this->input->post('salary_control');
        $othersId = $this->input->post('others_id');
        $install_amount = $this->input->post('install_amount');
        $others_amount = $this->input->post('others_amount');


        $month = date('m');
        $dateObj   = DateTime::createFromFormat('!m', $month);
        $monthName = $dateObj->format('F');
        $year = date('Y');

        $dateToTest =date('d/m/Y');
        $lastday = date('t',strtotime($dateToTest));

        $getTotal['totalDeduction']= $this->payroll_model->getTotalDeductionAmount($salary_id);
        $TotalDeduction = $getTotal['totalDeduction']->others_amount;

        $addition = (($house_total)+($fuel_total) + ($transport_total)+($overtime_total)+($acting_total)+($telephone_total));

        $deduction = (($wadu_total)+($nssf_total)+($psssf_total)+($nhif_total)+($workers_total)+($thb_total)+($postasaccos_total)+($court_total)+($paye_total)+($imprest_total)+($insuarance_total)+($TotalDeduction)+($salarycontrol));

        $netSalary = (($basic_total - $deduction) +($addition));

        $data=array();
        $data = array(
                        'emp_code' =>$emp_code ,
                        'em_id' =>$em_id ,
                        'salary_scale'=>$salary_scale,
                        'month' =>$monthName,
                        'year'=>date('Y'),
                        'paid_date' =>$lastday.'/'.date('m').'/'.date('Y'),
                        'paid_status'=>'PAID',
                        'house_allowance' =>$house_total ,
                        'acting_allowance'=>$acting_total,
                        'telephone_allowance' =>$telephone_total ,
                        'overtime_allowance'=>$overtime_total,
                        'transport_allowance' =>$transport_total ,
                        'fuel_allowance'=>$fuel_total,
                        'imprest_recovery' =>$imprest_total ,
                        'court'=>$court_total,
                        'salary_control' =>$salarycontrol,
                        'pss'=>$postasaccos_total,
                        'wadu' =>$wadu_total ,
                        'thb'=>$thb_total,
                        'workers_union' =>$workers_total ,
                        'nhif'=>$nhif_total,
                        'psssf' =>$psssf_total ,
                        'nssf'=>$nssf_total,
                        'insuarance_premium' =>$insuarance_total ,
                        'paye'=>$paye_total,
                        'others_deduction_total'=>$TotalDeduction,
                        'net_payment'=>$netSalary,
                        'basic_payment'=>$basic_total
                         );

        // See if record exists
            $get_salary_record = $this->payroll_model->getSalaryRecord($em_id,$year,$monthName);

            if($get_salary_record) {
                $payID = $get_salary_record[0]->pay_id;
                $payment_status = $get_salary_record[0]->paid_status;
            }

             // If exists, add/edit
            if( isset($payID) && $payID > 0 ) {

                if($payment_status == "Paid") {

                    echo "Has already been paid";

                }
                } else {
                    $this->payroll_model->insertPaidSalaryData($data);
                    $lastId = $this->db->insert_id();
            $data['othersDeductions'] = $this->payroll_model->Others_Employee_Deduction($salary_id);
             foreach ($data['othersDeductions'] as $value) {

                $data1 = array();
                $data1 = array(
                'pay_id' =>$lastId ,
                'emp_id' =>$emp_code ,
                'other_names' =>$value->other_names ,
                'others_amount' =>$value->others_amount ,
                'deduction_month' =>$monthName ,
                'deduction_year' =>date('Y')
         );
        $this->payroll_model->insertOthersDeductionData($data1);

            $total = ($value->installment_Amount - $value->others_amount);
            $id = $value->others_id;
            $data2 = array();
            $data2 = array(
                        'installment_Amount'=>$total
            );

            $this->payroll_model->updateOthersDeduction($id, $data2);
        }

        echo 'Successfully Added';
    }
}
    // Add or update the salary record
    public function pay_salary_add_record() {
        if($this->session->userdata('user_login_access') != False) {
        $emid = $this->input->post('emid');
        $month = $this->month_number_to_name($this->input->post('month'));
        $basic = $this->input->post('basic');
        $year = $this->input->post('year');
        $hours_worked = $this->input->post('hours_worked');
        $addition = $this->input->post('addition');
        $diduction = $this->input->post('diduction');
        $loan_id = $this->input->post('loan_id');
        $loan = $this->input->post('loan');
        $total_paid = $this->input->post('total_paid');
        $paydate = $this->input->post('paydate');
        $status = $this->input->post('status');
        $paid_type = $this->input->post('paid_type');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('basic', 'basic', 'trim|required|min_length[3]|max_length[10]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
                // redirect("Payroll/Generate_salary");
            } else {

            $data = array();
            $data = array(
                'emp_id' => $emid,
                'month' => $month,
                'year' => $year,
                'paid_date' => $paydate,
                'total_days' => $hours_worked,
                'basic' => $basic,
                'loan' => $loan,
                'total_pay' => $total_paid,
                'addition' => $addition,
                'diduction' => $diduction,
                'status' => $status,
                'paid_type' => $paid_type,
            );

            // See if record exists
            $get_salary_record = $this->payroll_model->getSalaryRecord($emid, $month,$year);

            if($get_salary_record) {
                $payID = $get_salary_record[0]->pay_id;
                $payment_status = $get_salary_record[0]->status;
            }

            // If exists, add/edit
            if( isset($payID) && $payID > 0 ) {

                if($payment_status == "Paid") {

                    echo "Has already been paid";

                } else {

                    $success = $this->payroll_model->updatePaidSalaryData($payID, $data);

                    // Do the loan update
                    if($success && $status == "Paid") {
                        $loan_info = $this->loan_model->GetLoanValuebyLId($loan_id);

                        // loan_id and loan fields already grabbed
                        if (!empty($loan_info)) {

                            $period = $loan_info->install_period - 1;
                            $number = $loan_info->loan_number;
                            $data = array();
                            $data = array(
                                'emp_id' => $emid,
                                'loan_id' => $loan_id,
                                'loan_number' => $number,
                                'install_amount' => $loan,
                                /*'pay_amount' => $payment,*/
                                'app_date' => $paydate,
                                /*'receiver' => $receiver,*/
                                'install_no' => $period
                                /*'notes' => $notes*/
                            );

                            $success_installment = $this->loan_model->Add_installData($data);

                            $totalpay = $loan_info->total_pay + $loan;
                            $totaldue = $loan_info->amount - $totalpay;
                            $period = $loan_info->install_period - 1;
                            $loan_status = $loan_info->status;

                            if ($period == '1') {
                                $loan_status = 'Done';
                            }

                            $data = array();
                            $data = array(
                                'total_pay'         => $totalpay,
                                'total_due'         => $totaldue,
                                'install_period'    => $period,
                                'status'            => $loan_status
                            );

                            $success_loan = $this->loan_model->update_LoanData($loan_id, $data);
                        }
                    }

                    echo "Successfully added";

                }

            } else {
                $success = $this->payroll_model->insertPaidSalaryData($data);

                // Do the loan update
                if($success && $status == "Paid") {

                    // Input Status
                        $loan_info = $this->loan_model->GetLoanValuebyLId($loan_id);

                        // loan_id and loan fields already grabbed
                        if (!empty($loan_info)) {

                            $period = $loan_info->install_period - 1;
                            $number = $loan_info->loan_number;
                            $data = array();
                            $data = array(
                                'emp_id' => $emid,
                                'loan_id' => $loan_id,
                                'loan_number' => $number,
                                'install_amount' => $loan,
                                /*'pay_amount' => $payment,*/
                                'app_date' => $paydate,
                                /*'receiver' => $receiver,*/
                                'install_no' => $period
                                /*'notes' => $notes*/
                            );

                            $success_installment = $this->loan_model->Add_installData($data);

                            $totalpay = $loan_info->total_pay + $loan;
                            $totaldue = $loan_info->amount - $totalpay;
                            $period = $loan_info->install_period - 1;
                            $loan_status = $loan_info->status;

                            if ($period == '0') {
                                $loan_status = 'Done';
                            }

                            $data = array();
                            $data = array(
                                'total_pay'         => $totalpay,
                                'total_due'         => $totaldue,
                                'install_period'    => $period,
                                'status'            => $loan_status
                            );

                            $success_loan = $this->loan_model->update_LoanData($loan_id, $data);
                        }

                    echo "Successfully added";
                }
            }
        }
    }
    else {
            redirect(base_url() , 'refresh');
        }
    }
public function Payed_Salary()
    {
        if($this->session->userdata('user_login_access') != False) {
        $data['salary_info'] = $this->payroll_model->getAllSalaryPayedData();
        $data['employee'] = $this->employee_model->emselect();
        $this->load->view('backend/payed_salary', $data);

        }

        else {

            redirect(base_url() , 'refresh');
        }
    }
    public function Salary_Slips()
    {
        if($this->session->userdata('user_login_access') != False) {

        $month = $this->input->post('month');
        $year = $this->input->post('year'); 
       
        $data['salary_info'] = $this->payroll_model->getAllSalaryPayedData_Slips($month,$year);
        $data['employee'] = $this->employee_model->emselect();
        $this->load->view('backend/salary_slips', $data);

        }

        else {

            redirect(base_url() , 'refresh');
        }
    }
    public function Payroll_Salary_list()
    {
        if($this->session->userdata('user_login_access') != False) {
        $data['salary_info'] = $this->payroll_model->getAllSalaryPayedData();
        $data['employee'] = $this->employee_model->emselect();
        $this->load->view('backend/payed_salary_list', $data);

        }

        else {

            redirect(base_url() , 'refresh');
        }
    }
    // Generate the list of employees by dept. to generate their payments
    public function load_employee_by_deptID_for_pay(){

        if($this->session->userdata('user_login_access') != False) {

        // Get the month and year
        $date_time = $this->input->get('date_time');
        $dep_id = $this->input->get('dep_id');
        if (empty($date_time) and !empty($dep_id)) {
            echo "No data available in table";
        } else {

            $year = explode('-', $date_time);
        $month = $year[0];
        $year = $year[1];

        $employees = $this->payroll_model->GetDepEmployee($dep_id);

        foreach($employees as $employee){

            $full_name = $this->get_full_name($employee->first_name, $employee->last_name);
            // Loan
            $has_loan = $this->payroll_model->hasLoanOrNot($employee->em_id);

            echo "<tr>
                    <td>$employee->em_code</td>
                    <td>$full_name</td>
                    <td>$employee->total</td>
                    <td><a href=''
                                data-id='$employee->em_id'
                                data-month='$month'
                                data-year='$year'
                                data-has_loan='$has_loan'
                                class='btn btn-sm btn-info waves-effect waves-light salaryGenerateModal'
                                data-toggle='modal'
                                data-target='#salaryGenerateModal'>
                        Generate Salary</a></td>
                </tr>";
        }

        // Sending
        $data = array();
        $data['basic_salary'] = $employee_salary;
        $data['total_work_hours'] = $total_work_hours;
        $data['employee_actually_worked'] = $employee_actually_worked[0]->Hours;
        $data['addition'] = $addition;
        $data['diduction'] = $diduction;
        $data['loan'] = $loan_amount;
        echo json_encode($data);

        }



        }
        else{
            redirect(base_url() , 'refresh');
        }
    }

    public function generate_payroll_for_each_employee(){

        if($this->session->userdata('user_login_access') != False) {
        // Get the month and year
        $month = $this->input->get('month');
        $year = $this->input->get('year');
        $employeeID = $this->input->get('employeeID');

        // Get employee PIN
        $employeePIN = $this->getPinFromID($employeeID);

        // Count Friday
        $fridays = $this->count_friday($month, $year);

        $month_holiday_count = $this->payroll_model->getNumberOfHolidays($month, $year);

        // Total holidays and friday count
        $total_days_off = $fridays + $month_holiday_count->total_days;

        // Total days in the month
        $total_days_in_the_month = $this->total_days_in_a_month($month, $year);

        $total_work_days = $total_days_in_the_month - $total_days_off;

        $total_work_hours = $total_work_days * 8;
            $sdate = 01;
        //Format date for hours count in the hours_worked_by_employee() function
        //$start_date = $year . '-' . $month . '-' . date('d');
        $result = strtotime("{$year}-{$month}-01");
        $start_date = date('Y-m-d', $result);
        $end_date = $year . '-' . $month . '-' . $total_days_in_the_month;

        // Employee actually worked
        $employee_actually_worked = $this->hours_worked_by_employee($employeePIN->em_code, $start_date, $end_date);  // in hours
            //echo json_encode($start_date);
        //Get his monthly salary
        $employee_salary = $this->payroll_model->GetsalaryValueByID($employeeID);


        if($employee_salary) {
            $employee_salary = $employee_salary->total;
        }

        // Hourly rate for the month
        $hourly_rate = $employee_salary / $total_work_hours;

        $work_hour_diff = abs($total_work_hours) - abs($employee_actually_worked[0]->Hours); // 96 - 16 = 80

        $addition = 0;
        $diduction = 0;
        if($work_hour_diff < 0) {
            $addition = abs($work_hour_diff) * $hourly_rate;
        } else if($work_hour_diff > 0) {
            // 80 is > 0 which means he worked less, so diduction = 80 hrs
            // so 80 * hourly rate 208 taka = 17500
            $diduction = abs($work_hour_diff) * $hourly_rate;
        }

        // Loan
        $loan_amount = 0;
        $loan_id = 0;
        $loan_info = $this->payroll_model->GetLoanValueByID($employeeID);
        if($loan_info) {
            $loan_amount = $loan_info->installment;
            $loan_id = $loan_info->id;
        }

        // Final Salary
        $final_salary = $employee_salary + $addition - $diduction - $loan_amount;

        // Sending
        $data = array();
        $data['basic_salary'] = $employee_salary;
        $data['total_work_hours'] = $total_work_hours;
        $data['employee_actually_worked'] = $employee_actually_worked[0]->Hours;
        $data['wpay'] =$total_work_hours - $employee_actually_worked[0]->Hours;
        $data['addition'] = round($addition, 2);
        $data['diduction'] = round($diduction, 2);
        $data['loan_amount'] = $loan_amount;
        $data['loan_id'] = $loan_id;
        $data['final_salary'] = round($final_salary, 2);
        $data['rate'] = round($hourly_rate, 2);
        echo json_encode($data);
        }
        else{
            redirect(base_url() , 'refresh');
        }
    }
    public function Payslip_Report(){
        if($this->session->userdata('user_login_access') != False) {
        $data=array();
        $data['employee'] = $this->employee_model->emselect();
        $this->load->view('backend/salary_report',$data);
        }
    else{
        redirect(base_url() , 'refresh');
    }
    }

    public function Payslip_Create(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->get('I');
        $emid = $id;
        $data['salary_info'] = $this->payroll_model->Get_SalaryID($id);
        $salary_id = $data['salary_info']->salary_id;
        $data['othersDeductions'] = $this->payroll_model->Others_Employee_Deduction($salary_id);
        $this->load->view('backend/payslip_create',$data);
        }
    else{
        redirect(base_url() , 'refresh');
    }
    }
    public function mussa()
    {
        if($this->session->userdata('user_login_access') != False) {

            $id = $this->input->post('I');

            for ($i=0; $i <sizeof($id) ; $i++) {
                $data['salary_id'] = $this->payroll_model->Get_SalaryIDById($id[$i]);
                //$data['salary_info'] = $this->payroll_model->Get_SalaryID($id[$i]);
                $salary_id = $data['salary_id']->id;
                echo $salary_id;
            }

            }
            else{
                redirect(base_url() , 'refresh');
            }

    }

public function Payslip_Create1(){

        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->post('I');
        if (!empty($id)) {

         //for loop for generating salary for each employee.......
        for ($i=0; $i <@sizeof($id) ; $i++) {

            $emid = $id[$i];
            $data['salary_id'] = $this->payroll_model->Get_SalaryIDById($id[$i]);
            $salary_id = $data['salary_id']->id;
            $data['salary_info'] = $this->payroll_model->Get_SalaryID($id[$i]);
            $salary_scale = $data['salary_info']->type_id;
            $data['scalesalary'] = $this->payroll_model->getIncrementByScale($salary_scale);
            $data['othersDeductions'] = $this->payroll_model->Others_Employee_Deduction($salary_id);
            $bankIfo = $this->payroll_model->Get_BankInfo($emid);

            $month = date('m');
            $dateObj   = DateTime::createFromFormat('!m', $month);
            $monthName = $dateObj->format('F');
            $year = date('Y');

            $dateToTest =date('d/m/Y');
            $lastday = date('t',strtotime($dateToTest));
            $em_code = $data['salary_info']->em_code;
            $em_id = $data['salary_info']->em_id;
            $basic_total = $data['salary_info']->total;// + $data['scalesalary']->increment;

            $getTotal['PercentDeduction']= $this->payroll_model->getPercentDeduction($salary_id);
            $PensionDeduction = $this->payroll_model->getPensionDeduction($salary_id);

            $data['Heslb'] = $this->payroll_model->getOthersDeduction($salary_id);

            foreach ($data['Heslb'] as  $value) {

                if ($value->other_names == "HESLB") {

                    $ded_amountheslb = $basic_total * 0.15;
                    $data = array();
                    $data = array('others_amount'=>$ded_amountheslb);
                    $this->payroll_model->update_heslb($data,$salary_id);
                }
            }

            $getTaxRelief = $this->payroll_model->getTaxRelief($salary_id);

            if (!empty($getTaxRelief)) {
               $taxRelief = $getTaxRelief->amount;
            } else {
                $taxRelief = 0;
            }


            foreach ($getTotal['PercentDeduction'] as $value) {
           $percent = $value->ded_amount;
           $ded_id = $value->ded_id;

           $data2 = array();
            $data2 = array(
                        'ded_amount'=>$percent
            );
            $this->payroll_model->updatePercentDeduction($ded_id, $data2);
            }

            //foreach ($getTotal['PensionDeduction'] as $value) {
           $percent1 = $PensionDeduction->fund_percent;
           $fund_id = $PensionDeduction->fund_id;

           $data2 = array();
            $data2 = array(
                        'fund_amount'=>$percent1 * $basic_total
            );
        $this->payroll_model->updatePensionDeduction($fund_id, $data2);
        //}



        $getTotal['totalDeduction']= $this->payroll_model->getTotalDeductionAmount($salary_id);
        $getTotal['totalPDeduction']= $this->payroll_model->getTotalPDeductionAmount($salary_id);
        $getTotal['totalNonPDeduction']= $this->payroll_model->getTotalNonPDeductionAmount($salary_id);

        $getTotal['totalAddition']= $this->payroll_model->getTotalAdditionAmount($salary_id);
        $getTotal['totalNonTaxAddition']= $this->payroll_model->getTotalNonTaxAdditionAmount($salary_id);
        $getTotal['totalFund']= $this->payroll_model->getFundAmount($salary_id);
         


        $TotalDeduction = $getTotal['totalDeduction']->others_amount;
        $TotalPDeduction = $getTotal['totalPDeduction']->ded_amount;
        $TotalNonPDeduction = $getTotal['totalNonPDeduction']->ded_amount;
        $TotalAddition = $getTotal['totalAddition']->add_amount;
        $totalNonTaxAddition = $getTotal['totalNonTaxAddition']->add_amount;
        $totalFund = @$getTotal['totalFund']->fund_amount;
        $pensionName = @$getTotal['totalFund']->fund_name;

        //$gross_payment = (($basic_total) + ($totalNonTaxAddition) + ($TotalAddition));
        $checkAss = $this->payroll_model->getAssuarance($salary_id);
        if (empty($checkAss)) {

            $basic_totalAdd = (($basic_total) + ($TotalAddition)-($totalFund));

        } else {

            $before = $basic_total-$totalFund;
            $basic_totalAdd = $before - @$checkAss->ded_amount + $TotalAddition;

        }


        if ($basic_totalAdd <= 270000) {

            $paye = 0;
            $gross_payment = (($basic_totalAdd) + ($totalNonTaxAddition));

        }
        if ($basic_totalAdd >= 270000 && $basic_totalAdd <= 520000) {

           $paye = ($basic_totalAdd - 270000) * 0.09;
           $gross_payment = (($basic_totalAdd) + ($totalNonTaxAddition));
        }
        if ($basic_totalAdd >= 520000 && $basic_totalAdd <= 760000) {

           $paye = 22500 + ($basic_totalAdd - 520000) * 0.2;
           $gross_payment = (($basic_totalAdd) + ($totalNonTaxAddition));
        }
        if ($basic_totalAdd >= 760000 && $basic_totalAdd <= 1000000) {

           $diff = $basic_totalAdd -(760000);
           $mult = $diff * 0.25;
           $paye = (70500 + $mult);
           $gross_payment = (($basic_totalAdd) + ($totalNonTaxAddition));
        }
        
        if ($basic_totalAdd >= 1000000 ) {

           $paye = 130500 + ($basic_totalAdd - 1000000) * 0.3;
           $gross_payment = (($basic_totalAdd) + ($totalNonTaxAddition));
        }

        //$data['NonTaxDeduction']= $this->payroll_model->getNonTaxDeduction($salary_id);

        $sumDeduction = $TotalPDeduction + $TotalNonPDeduction + $TotalDeduction  + $paye;

        $net_payment = $gross_payment  - $sumDeduction + $taxRelief;

        $data=array();
        $data = array(
                        'emp_code' =>$em_code ,
                        'em_id' =>$em_id ,
                        'salary_scale'=>$salary_scale,
                        'month' =>$monthName,
                        'year'=>date('Y'),
                        'paid_date' =>$lastday.'/'.date('m').'/'.date('Y'),
                        'paid_status'=>'PAID',
                        'others_deduction_total'=>$TotalDeduction,
                        'net_payment'=>$net_payment,
                        'basic_payment' =>$basic_total,
                        'percentage_deduction_total'=>$TotalPDeduction,
                        'nonpercentage_deduction_total'=>$TotalNonPDeduction,
                        'addition_total' => $TotalAddition,
                        'nonTaxAddition_total'=>$totalNonTaxAddition,
                        'paye'=>$paye,
                        'pension_fund'=>$totalFund,
                        'pension_name'=>$pensionName,
                        'bank_name'=>@$bankIfo->bank_name,
                        'gross_salary'=>$gross_payment,
                        'gross_taxable'=>$basic_total-@$checkAss->ded_amount+$TotalAddition-$totalFund,
                        'id_salary'=>$salary_id
                    );

            // See if record exists
            $get_salary_record = $this->payroll_model->getSalaryRecord($em_id,$year,$monthName);

            if( !empty($get_salary_record )) {

                    echo "Has Already Paid";

                } else {
                    //else start
                    $this->payroll_model->insertPaidSalaryData($data);
                    $lastId = $this->db->insert_id();
                }
                //else end;
        }
        //end of forloop

        $data['othersDeductions'] = $this->payroll_model->Others_Employee_Deduction($salary_id);

        if (!empty($data['othersDeductions'])) {

            $year = date('Y');
            $month= date('M');

            foreach ($data['othersDeductions'] as $value) {

                $installmentName = $value->other_names;
                $lastInstallement = $this->payroll_model->Others_Employee_Deduction_Permonth($installmentName,$salary_id);

                if (!empty($lastInstallement)) {

                    if ($lastInstallement->others_amount == 0) {
                        
                     $data = array();
                     $data = array(

                     'other_names'=>$value->other_names,
                     'loan_amount'=>$value->loan_amount,
                     'others_amount'=>'0',
                     'salary_id'=>$value->salary_id,
                     'installment_Amount'=>'0',
                     'status'=>'COMPLETE',
                     'em_id'=>$value->em_id,
                     'month'=>$monthName,
                     'year'=>$year

                     );


                    } else {
                        
                     $data = array();
                     $data = array(

                     'other_names'=>$value->other_names,
                     'loan_amount'=>$value->loan_amount,
                     'others_amount'=>$lastInstallement->others_amount-$value->installment_Amount,
                     'salary_id'=>$value->salary_id,
                     'installment_Amount'=>$value->installment_Amount,
                     'status'=>$value->status,
                     'em_id'=>$value->em_id,
                     'month'=>$monthName,
                     'year'=>$year

                     );


                    }
                    
                    
                } else {

                     $data = array();
                     $data = array(

                     'other_names'=>$value->other_names,
                     'loan_amount'=>$value->loan_amount,
                     'others_amount'=>$value->loan_amount-$value->installment_Amount,
                     'salary_id'=>$value->salary_id,
                     'installment_Amount'=>$value->installment_Amount,
                     'status'=>$value->status,
                     'em_id'=>$value->em_id,
                     'month'=>$monthName,
                     'year'=>$year

                     );

                 }
                     $this->payroll_model->InsertLoansDeduction($data);
                    }

                   } 

                     $data = array();
                        $data = array('total'=> $basic_total);
                        $sid = $salary_id;
                        $this->employee_model->Update_Salary($sid,$data);


                        $data['NonTaxDeductionInsert'] = $this->payroll_model->getNonPDeduction($salary_id);
                         $data['TaxDeductionInsert'] = $this->payroll_model->getPDeduction($salary_id);

                        foreach ($data['NonTaxDeductionInsert'] as $value) {

                            $ded_name = $value->ded_name;

                            $total = $this->payroll_model->getLastNonTaxDeduction($ded_name,$salary_id);
                            @$amount1 = @$total->total_amount;

                            if (!empty($total)) {

                             $dataNonP = array();
                             $dataNonP = array(
                                     'salary_id'=>$salary_id,'name'=>$value->ded_name,'amount'=>$value->ded_amount,'month'=>$monthName,'year'=>$year,'total_amount'=>$value->ded_amount + $amount1);
                            } else {

                             $dataNonP = array();
                             $dataNonP = array(
                                     'salary_id'=>$salary_id,'name'=>$value->ded_name,'amount'=>$value->ded_amount,'month'=>$monthName,'year'=>$year,'total_amount'=>$value->ded_amount);
                            }

                            $this->payroll_model->insertNonPDeductioCommulative($dataNonP);
                        }


                        foreach ($data['TaxDeductionInsert'] as $value) {

                        $ded_name = $value->ded_name;
                        $total2 = $this->payroll_model->getLastTaxDeduction($ded_name,$salary_id);
                        $amount2 = @$total2->total_amount;

                        if (!empty($total2)) {
                             $dataP = array();
                             $dataP = array(
                                 'salary_id'=>$salary_id,'name'=>$value->ded_name,'amount'=>$value->ded_amount,'month'=>$monthName,'year'=>$year,'total_amount'=>$amount2 + $value->ded_amount);

                        } else {
                             $dataP = array();
                             $dataP = array(
                                 'salary_id'=>$salary_id,'name'=>$value->ded_name,'amount'=>$value->ded_amount,'month'=>$monthName,'year'=>$year,'total_amount'=>$value->ded_amount);
                        }
                          $this->payroll_model->insertPDeductioCommulative($dataP);
                    }

                    //Getting last month pension contribution
                    $lastPension = $this->payroll_model->getLastContribution($salary_id);
                    $lastPension1 = @$lastPension->fund_sum_permonth;
                    //Inserting Pension fund contribution permonth
                    $PensionF = array();
                    $PensionF = array(
                                        'salary_id'=>$salary_id,
                                        'fund_name'=>$pensionName,
                                        'fund_amount'=>$totalFund,
                                        'fund_sum_permonth'=>$totalFund + $lastPension1,
                                        'month'=>$monthName,
                                        'year'=>$year );

                  $this->payroll_model->InsertPensionPermonth($PensionF);

        echo "Successfully Saved";

    }else{
        redirect(base_url() , 'refresh');
    }
}
}


    public function Salary_Slip_Create(){

        if($this->session->userdata('user_login_access') != False) {
        $id = base64_decode($this->input->get('I'));
        $month = base64_decode($this->input->get('M'));
        $year = base64_decode($this->input->get('Y'));
        $salary_id = $this->input->get('S');
        $data = array();
        $data['title'] = 'Tanzania Posts Corporation';
        $data['title1'] = 'Monthly Salary Slip';
        $data['salary_info'] = $this->payroll_model->Get_Paid_Salary($id,$month,$year);
        $data['TaxAddition']= $this->payroll_model->getTaxAddition($salary_id);
        $data['NonTaxAddition'] = $this->payroll_model->getNonTaxAddition($salary_id);
        $data['NonTaxDeduction']= $this->payroll_model->getNonTaxDeduction($salary_id);
        $data['TaxDeduction']= $this->payroll_model->getTaxDeduction($salary_id);
        
        $data['LoanDeduction']= $this->payroll_model->getLoanDeduction($salary_id,$month,$year);
        $data['pensionFund'] = $this->payroll_model->getLastContribution($salary_id);
         $data['assAfrica'] = $this->payroll_model->getAssuarance($salary_id);
        $data['taxtRelief'] = $this->payroll_model->getTaxRelief($salary_id);


        //$html = $this->output->get_output();
        $html= $this->load->view('backend/salary_slipNew',$data,TRUE);
        $this->load->library('Pdf');
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4','potrait');
        $this->dompdf->render();
        $this->dompdf->stream($data['salary_info']->emp_code.'.pdf', array("Attachment"=>0));
        }
    else{
        redirect(base_url() , 'refresh');
    }
    }

public function dedactionlist()
  {
    $data['othersDeductions'] = $this->payroll_model->Others_Employee_Deduction();
    $this->load->view('backend/dedactionlist',$data);
  }

  public function updateLoans()
  {

    $lastInstallement = $this->payroll_model->Others_Employee_Deduction_Permonth($installmentName,$salary_id);
    echo $lastInstallement->others_Amount;
//     $data['othersDeductions'] = $this->payroll_model->Others_Employee_Deduction2();
    
// //     $data['othersDeductions'] = $this->payroll_model->loanDeduction();
// //     foreach ($data['othersDeductions'] as $value) {
        
// //         $id = $value->em_id;
// //         $data = array();
// //         $data = array(
// //         'others_amount'=>$value->installment_Amount,
// //         'installment_Amount'=>$value->installment_Amount
        
// //     );
// //         $this->payroll_model->update_loans_deduction($id,$data);
// // }
        
//     foreach ($data['othersDeductions'] as $value) {

//          $data = array();
//          $data = array(

//          'other_names'=>$value->other_names,
//          'loan_amount'=>$value->loan_amount+$value->others_amount*6,
//          'others_amount'=>($value->loan_amount+$value->others_amount*6)-($value->others_amount*6),
//          'salary_id'=>$value->salary_id,
//          'installment_Amount'=>$value->others_amount,
//          'status'=>$value->status,
//          'em_id'=>$value->emp_id,
//          'month'=>$value->month,
//          'year'=>$value->year

//      );
        
//          $this->payroll_model->InsertLoansDeduction($data);
//      }
  }

  public function Non_PercentD()
  {
       if($this->session->userdata('user_login_access') != False) {

        $data['NonPercentageDeduction'] = $this->payroll_model->getNonPercentageDeduction();
        $this->load->view('backend/non_percentage_deduction',$data);
       }
  }
  public function Percent_Deduction()
  {
       if($this->session->userdata('user_login_access') != False) {

        $data['NonPercentageDeduction'] = $this->payroll_model->getPercentageDeduction();
        $this->load->view('backend/percentage_deduction',$data);
       }
  }
  public function Loan_Deduction()
  {
       if($this->session->userdata('user_login_access') != False) {

        $data['NonPercentageDeduction'] = $this->payroll_model->getLoanPermonthDeduction();
        $this->load->view('backend/loan_deduction',$data);
       }
  }

  public function Paye_Chart()
  {
       if($this->session->userdata('user_login_access') != False) {

        $data['payeChart'] = $this->payroll_model->getPayeChart();
        $this->load->view('backend/paye_chart',$data);
       }
  }

  public function Pension_Chart()
  {
       if($this->session->userdata('user_login_access') != False) {

        $data['pensionChart'] = $this->payroll_model->getPensionChart();
        $this->load->view('backend/pension_chart',$data);
       }
  }
  public function Salary_Payslip()
  {
       if($this->session->userdata('user_login_access') != False) {
         $id = $this->session->userdata('user_login_id');
         $data['basic'] = $this->employee_model->GetBasic($id);
        //$data['pensionChart'] = $this->payroll_model->getPensionChart();
        $this->load->view('backend/salary_payslip',$data);
       }
  }

  public function Search()
  {
       if($this->session->userdata('user_login_access') != False) {

        $em_code = $this->input->get('em_code');
        $month = $this->input->get('month');
        $year = $this->input->get('year');
        $sid = $this->input->get('salaryID');
        

        $getSalary = $this->payroll_model->getPayedSalary($em_code,$month,$year);

        if (!empty($getSalary)) {
           echo "<table style='width:100%; text-align:center;' class='table'><tr><td>
         <a href='Salary_Slip_Create?I=".base64_encode($em_code)."&& M=".base64_encode($month)."&& Y=".base64_encode($year)."&& S=".$sid."' class='btn btn-info' style='color:white;'>Download Salary Payslip</a></td></tr></table";
        } else {
           echo "<table style='width:100%; text-align:center;' class='table'><tr><td><text style='color:red;'>No Salary Payslip yet</text></td></tr></table";
        }




       }
  }

  public function Salary_Report()
  {
       if($this->session->userdata('user_login_access') != False) {

        $month = $this->input->get('month');
        $year = $this->input->get('year');
        $bank_name = $this->input->get('bank_name');


             $getSalaryMonth = $this->payroll_model->getSheetToBankEmpty($month,$year,$bank_name);
             $data['sum'] =$this->payroll_model->getSheetToBankSumEmpty($month,$year,$bank_name);

             if (!empty($getSalaryMonth)) {

                 echo "<table id='example4' class='table table-bordered' style='text-transform: uppercase;'>
                <thead>

                <tr><td>S/N.</td><td>PF No.</td><td>FULL NAME</td><td>NET SALARY</td><td>BANK NAME</td><td>ACC NO.</td><td>BANK CODE</td></tr>
                </thead><tbody>";
                        $i=0;
                  foreach ($getSalaryMonth as $value) {
                        $i++;
                    echo "<tr><td>".$i."</td><td>".$value->emp_code."</td><td>$value->holder_name</td><td>".number_format($value->net_payment,2)."</td><td>$value->bank_name</td><td>$value->account_number</td><td>$value->bank_code</td></tr>";

                  }
                 echo "<tr><td></td><td></td><td>Total ::</td><td>".number_format($data['sum']->total,2)."</td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td>Signature</td><td>-----------------------------</td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td>Signature</td><td>-----------------------------</td><td></td><td></td><td></td></tr>";
                   echo "</tbody>
                   </table>

                   <script type='text/javascript'>
                    $(document).ready(function() {

                var table = $('#example4').DataTable( {
                     ordering: false,
                     bPaginate: false,
                    orderCellsTop: false,
                    fixedHeader: true,
                    'aaSorting': [[0,'asc']],
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                    } );
                } );
                </script>";

              } else {

                echo "<table class='table table-bordered table-striped' style='text-transform: uppercase;'>
                <thead>
                <tr><td colspan='5'><a href='#' class='btn btn-info' style='color:white;'>Generate Pdf Report</a></td></tr>
                <tr><td>Employee Id</td><td>Full Name</td><td>Net Salary</td><td>Bank Name</td><td>Acc Number</td></tr>
                </thead>
                <tbody><td colspan='5' style='color:red;text-align:center;'>No Salary Data yet</td></tbody>
              </table>";

              }

}
}

  public function Salary_Payroll_List()
  {
       if($this->session->userdata('user_login_access') != False) {

        $month = $this->input->get('month');
        $year = $this->input->get('year');
        $bank_name = $this->input->get('bank_name');
        $dedtype = $this->input->get('dedtype');
        $getSalaryMonth1 = $this->payroll_model->getSheetToBankEmpty($month,$year,$bank_name);

        foreach ($getSalaryMonth1 as $value) {
            
           $id = $value->em_id;
           $data['getSalaId'] = $this->payroll_model->Get_SalaryIDById($id);
           $salary_id = $data['getSalaId']->id;
           $getTotal['totalFund']= $this->payroll_model->getFundAmount($salary_id);
           $totalFund = @$getTotal['totalFund']->fund_amount;
           $getTotal['totalAddition']= $this->payroll_model->getTotalAdditionAmount($salary_id);
           $TotalAddition = $getTotal['totalAddition']->add_amount;
           $checkAss = $this->payroll_model->getAssuarance($salary_id);
           $pid = $value->pay_id;

           $data = array();
           $data = array('gross_taxable'=>$value->basic_payment-@$checkAss->ded_amount+$TotalAddition-$totalFund);
           $this->payroll_model->Update_Paye($pid,$data);
        }


        $getSalaryMonth = $this->payroll_model->getSheetToBankEmpty($month,$year,$bank_name);
         $i=0;
         echo "<div class='table-responsive'>
                 <table id='example4' class='table table-bordered text-nowrap table-striped' style='text-transform: uppercase;'>
                <thead>

                <tr style='text-transform:capitalize;'><td>S/N.</td><td>Employee No.</td><td>FULL NAME</td><td>GROSS TAXABLE</td><td>EMPLOYEE AMOUNT</td><td>EMPLOYER AMOUNT</td><td>TOTAL</td></tr>
                </thead><tbody>";
        foreach ($getSalaryMonth as $value) {

           $id = $value->em_id;
           $data['getSalaId'] = $this->payroll_model->Get_SalaryIDById($id);
           

           if ($dedtype == 'P.A.Y.E') {
               $amount = $value->paye;
               $data['sumPaye'] =$this->payroll_model->getSheetToBankSumPaye($month,$year,$bank_name);
           } elseif ($dedtype == 'W.A.D.U') {
               
               $dedname = 'W.A.D.U';
               $salId = $data['getSalaId']->id;

               $wadu = $this->payroll_model->getwadu($salId,$dedname);
               $amount = @$wadu->ded_amount;
               $data['sumPaye'] =$this->payroll_model->getSum($dedname);

           } elseif ($dedtype == 'TEWUTA') {
               
               $dedname = 'TEWUTA';
               $salId = $data['getSalaId']->id;

               $tewuta = $this->payroll_model->getwadu($salId,$dedname);
               $amount = @$tewuta->ded_amount;
            $data['sumPaye'] =$this->payroll_model->getSum($dedname);

           } elseif ($dedtype == 'COTWU(T)') {
               
               $dedname = 'COTWU(T)';
               $salId = $data['getSalaId']->id;

               $cotwu = $this->payroll_model->getwadu($salId,$dedname);
               $amount = @$cotwu->ded_amount;
               $data['sumPaye'] =$this->payroll_model->getSum($dedname);

           } elseif ($dedtype == 'HESLB') {
               
               $dedname = 'HESLB';
               $salId = $data['getSalaId']->id;

               $heslb = $this->payroll_model->getwadu($salId,$dedname);
               $amount = @$heslb->ded_amount;
               $data['sumPaye'] =$this->payroll_model->getSum($dedname);

           } elseif ($dedtype == 'PSSSF') {
               
               $dedname = 'PSSSF';
               $salId = $data['getSalaId']->id;

               $psssf = $this->payroll_model->getpsssf($salId,$dedname);
               $amount = @$psssf->fund_amount;
               $data['sumPaye'] =$this->payroll_model->getSumPsssf($dedname);
           } elseif ($dedtype == 'AFRICAN LIFE ASSUARANCE') {
               
               $dedname = 'AFRICAN LIFE ASSUARANCE';
               $salId = $data['getSalaId']->id;

               $assuarance = $this->payroll_model->getAssuarance2($salId);
               $amount = @$assuarance->ded_amount;
               $data['sumPaye'] =$this->payroll_model->getSumAssuarance($dedname);

           } 
           
                        $i++;
                    echo "<tr><td>".$i."</td><td>".$value->emp_code."</td><td>$value->holder_name</td></td><td  style='text-align:right;'>".number_format($value->gross_taxable,2)."</td><td  style='text-align:right;'>".number_format(@$amount,2)."</td><td  style='text-align:right;'>0.00</td><td  style='text-align:right;'>".number_format(@$amount,2)."</td></tr>";

           }
                  $data['sumTaxable'] =$this->payroll_model->getSheetToBankSumGrossTaxable($month,$year,$bank_name);
                 echo "<tr><td></td><td></td><td>Total ::</td><td  style='text-align:right;'></td><td  style='text-align:right;'>".number_format($data['sumTaxable']->totalTaxable,2)."</td><td  style='text-align:right;'>".number_format($data['sumPaye']->totalpaye,2)."</td><td  style='text-align:right;'>".number_format(0,2)."</td><td  style='text-align:right;'>".number_format($data['sumPaye']->totalpaye,2)."</td></tr>";
                  echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td>Signature</td><td>-----------------------------</td><td></td><td></td><td></td><td></td></tr>";
                    echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                     echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td>Signature</td><td>-----------------------------</td><td></td><td></td><td></td><td></td></td>";
                   echo "</tbody>
                   </table></div>
                   <script type='text/javascript'>
                    $(document).ready(function() {

                var table = $('#example4').DataTable( {
                     ordering: false,
                     bPaginate: false,
                    orderCellsTop: false,
                    fixedHeader: true,
                    'aaSorting': [[0,'asc']],
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                    } );
                } );
                </script>";
            
    }
  }
  public function Sheet_to_bank()
  {
    if($this->session->userdata('user_login_access') != False) {


        $month = $this->input->get('M');
        $year = $this->input->get('Y');
        $bank_name = $this->input->get('bank_name');

        if (empty($bank_name)) {
            $data['sheet_to_bank'] = $this->payroll_model->getSheetToBankEmpty($month,$year);
            $data['sum'] =$this->payroll_model->getSheetToBankSumEmpty($month,$year);

            $this->load->library('Pdf');
            $html= $this->load->view('backend/bank_sheet',$data,TRUE);
            $this->load->library('Pdf');
            $this->dompdf->loadHtml($html);
            $this->dompdf->setPaper('A4','potrait');
            $this->dompdf->render();
            $this->dompdf->stream($month.'.pdf', array("Attachment"=>0));

        } else {

            $data['sheet_to_bank'] = $this->payroll_model->getSheetToBank($month,$year,$bank_name);
            $data['sum'] =$this->payroll_model->getSheetToBankSum($month,$year,$bank_name);

            $this->load->library('Pdf');
            $html= $this->load->view('backend/bank_sheet',$data,TRUE);
            $this->load->library('Pdf');
            $this->dompdf->loadHtml($html);
            $this->dompdf->setPaper('A4','potrait');
            $this->dompdf->render();
            $this->dompdf->stream($month.'.pdf', array("Attachment"=>0));

        }


        //$data['sum'] =$this->payroll_model->getSheetToBankSum($month,$year,$bank_name);
        //$this->load->view('backend/sheet_to_bank',$data,TRUE);


    }
  }

  public function Tax_relief()
  {
    if($this->session->userdata('user_login_access') != False) {

        $tax = $this->input->post('tax_relief');
        $emid = $this->input->post('emid');
        $sid = $this->input->post('sid');
        $trid = $this->input->post('trid');
        $remove = $this->input->post('remove');

        if (empty($remove)) {
           
            $data = array();
           $data = array('amount'=>$tax,'em_id'=>$emid,'salaryId'=>$sid);

               $this->payroll_model->save_tax_relief($data);
               echo "Successfully Save";

            // } else {
            //    $this->payroll_model->update_tax_relief($data,$trid);
            // echo "Successfully Updated";
            // }

        } else {
             $this->payroll_model->delete_tax_relief($trid);
            echo "Successfully Deleted";
        }
    }
  }

  public function Save_BankInfo()
  {
    if($this->session->userdata('user_login_access') != False) {

        $bank_name = $this->input->post('bank_name');
        $acc_number = $this->input->post('acc_number');
        $acc_name = $this->input->post('acc_name');
        $id = $this->input->post('emid');
        $sid = $this->input->post('sid');



        $data = array();
            $data = array('em_id'=>$id,'holder_name '=>$acc_name,'bank_name '=>$bank_name,'account_number'=>$acc_number);

        $check = $this->employee_model->Check_Exist($id);


        $data = array();
            $data = array('em_id'=>$id,'holder_name '=>$acc_name,'bank_name '=>$bank_name,'account_number'=>$acc_number);

        if (!empty($check)) {

            $this->employee_model->DeleteInfoBank($id);

            $data = array();
            $data = array('em_id'=>$id,'holder_name '=>$acc_name,'bank_name '=>$bank_name,'account_number'=>$acc_number);

            $this->employee_model->Add_BankInfo($data);
            $success = $this->employee_model->Update_BankInfo($id,$data);
           echo "Successfully Updated";
        } else {
            $this->employee_model->Add_BankInfo($data);
            echo "Successfully Save";

        }


    }
  }

  public function last_month_comm()
  {
    if($this->session->userdata('user_login_access') != False) {

        $name = $this->input->post('deduction_name');
        $amount = $this->input->post('deduction_amount');
        $amountTotal = $this->input->post('amount_total');
        $emid = $this->input->post('emid');
        $sid = $this->input->post('sid');
        $month = date('m');
        $dateObj   = DateTime::createFromFormat('!m', $month);
        $monthName = $dateObj->format('F');
        $year = date('Y');

         $dataNonP = array();
        $dataNonP = array(
                     'salary_id'=>$sid,'name'=>$name,'amount'=>$amount,'month'=>$monthName,'year'=>$year,'total_amount'=>$amountTotal);
        $this->payroll_model->insertNonPDeductioCommulative($dataNonP);
        echo "Successfully Save";
    }
  }

  public function last_month_pcomm()
  {
    if($this->session->userdata('user_login_access') != False) {

        $name = $this->input->post('deduction_name');
        $amount = $this->input->post('deduction_amount');
        $amountTotal = $this->input->post('amount_total');
        $emid = $this->input->post('emid');
        $sid = $this->input->post('sid');
        $month = date('m');
        $dateObj   = DateTime::createFromFormat('!m', $month);
        $monthName = $dateObj->format('F');
        $year = date('Y');

         $PensionF = array();
         $PensionF = array(
                     'salary_id'=>$sid,'fund_name'=>$name,'fund_amount'=>$amount,'month'=>$monthName,'year'=>$year,'fund_sum_permonth'=>$amountTotal);
        $this->payroll_model->InsertPensionPermonth($PensionF);
        echo "Successfully Save";
    }
  }


  public function edit_bank_info()
  {
    if($this->session->userdata('user_login_access') != False) {

        $id = base64_decode($this->input->get('I'));
        $data['bankinfo'] = $this->employee_model->GetBankInfo($id);
        $this->load->view('backend/edit_bank_info',$data);
        //echo "Successfully Save";

    }
  }


  public function Add_bank_info(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->post('id');
        $em_id = $this->input->post('emid');
        $holder = $this->input->post('holder_name');
        $bank = $this->input->post('bank_name');
        $number = $this->input->post('account_number');
        $bank_code = $this->input->post('bank_code');
            $data = array();
                $data = array(
                    //'em_id' => $em_id,
                    'holder_name' => $holder,
                    'bank_name' => $bank,
                    'account_number' => $number,
                    'bank_code'=>$bank_code
                );

                $success = $this->employee_model->Update_BankInfo($id,$data);
                echo "Successfully Updated";

        }else{
        redirect(base_url() , 'refresh');
    }
    }

    public function Payroll_report(){

        if ($this->session->userdata('user_login_access') != False) {
            
            $month = $this->input->post('month');
            $year  = $this->input->post('year');


            $data['paymonth'] = $this->payroll_model->Check_Roster_Pay($month,$year);

            if (empty($data['paymonth'])) {
                 $getEmid = $this->payroll_model->get_Em_Id($month,$year);
                if (empty($getEmid)) {
                   $data['salary'] = $this->payroll_model->Check_Roster_Pay($month,$year);
                } else {


                foreach ($getEmid as $value) {
                 $salaryId = $value->id_salary;

                 // Start Deduction Procedure
                 $tewuta ="TEWUTA" ; 
                 $tew = $this->payroll_model->getDedAmount($salaryId,$tewuta);
                 if (empty($tew)) {
                     $tewt = 0.00;
                 } else {
                     $tewt = $tew->ded_amount;
                 }
                 
                 $cotwu ="COTWU(T)" ; 
                 $cot = $this->payroll_model->getDedAmountCotwu($salaryId,$cotwu);
                  if (empty($cot)) {
                     $cott = 0.00;
                 } else {
                     $cott = $cot->ded_amount;
                 }

                 $kks ="KK SAVINGS" ; 
                 $kk = $this->payroll_model->getDedAmountKKSaving($salaryId,$kks);
                  if (empty($kk)) {
                     $kka = 0.00;
                 } else {
                     $kka = $kk->ded_amount;
                 }

                 $wadu ="W.A.D.U" ; 
                 $wad = $this->payroll_model->getDedAmountWadu($salaryId,$wadu);
                  if (empty($wad)) {
                     $wada = 0.00;
                 } else {
                     $wada = $wad->ded_amount;
                 }

                 $house ="HOUSE RENT" ; 
                 $hous = $this->payroll_model->getDedAmountHouse($salaryId,$house);
                  if (empty($hous)) {
                     $housa = 0.00;
                 } else {
                     $housa = $hous->ded_amount;
                 }

                 $insu ="INSURANCE" ; 
                 $insur = $this->payroll_model->getDedAmountInsurance($salaryId,$insu);
                  if (empty($insur)) {
                     $insa = 0.00;
                 } else {
                     $insa = $insur->ded_amount;
                 }  
                 //End of Deduction Procedure

                 //Start of addition Procedure 
                 $salarr ="SALARY ARREARS" ; 
                 $add = $this->payroll_model->getAdditionSalAreas($salaryId,$salarr);

                 if (empty($add)) {
                     $sal = 0;
                 } else{
                     $sal = $add->add_amount;
                 }
                 
                 $act ="ACTING ALLOWANCE" ; 
                 $acting = $this->payroll_model->getAdditionActing($salaryId,$act);

                 if (empty($acting)) {
                     $acta = 0;
                 } else{
                     $acta = $acting->add_amount;
                 }

                 $fuel ="FUEL ALLOWANCE" ; 
                 $fuels = $this->payroll_model->getAdditionFuel($salaryId,$fuel);

                 if (empty($fuels)) {
                     $fela = 0;
                 } else{
                     $fela = $fuels->add_amount;
                 }

                 $pssf ="PSSSF" ; 
                 $pssfv = $this->payroll_model->getPsssfReport($salaryId,$pssf);
                 if (empty($pssfv)) {
                     $pssfa = 0;
                 } else {
                     $pssfa = $pssfv->fund_amount;                                 
                 }

                 $nhif ="NHIF" ; 
                 $nhifv = $this->payroll_model->getNhifReport($salaryId,$nhif);
                 if (empty($nhifv)) {
                     $nhifa = 0;
                 } else {
                     $nhifa = $nhifv->ded_amount;                                 
                 }

                 $hslb ="HESLB" ; 
                 $hslbv = $this->payroll_model->getHeslbReport($salaryId,$hslb);
                 if (empty($hslbv)) {
                     $hslba = 0;
                 } else {
                     $hslba = $hslbv->others_amount;                                 
                 }

                 $zhslb ="ZHESLB" ; 
                 $zhslbv = $this->payroll_model->getZHeslbReport($salaryId,$zhslb);
                 if (empty($zhslbv)) {
                     $zhslba = 0;
                 } else {
                     $zhslba = $zhslbv->others_amount;                                 
                 }

                 $sundry ="Sundry Allowance" ; 
                 $sundryv = $this->payroll_model->getSundryReport($salaryId,$sundry);
                 if (empty($sundryv)) {
                     $sundrya = 0;
                 } else {
                     $sundrya = $sundryv->add_amount;                                 
                 }

                 $sha ="SHORT & ACCESS" ; 
                 $shav = $this->payroll_model->getShortAccess($salaryId,$sha);
                 if (empty($shav)) {
                     $shaa = 0;
                 } else {
                     $shaa = $shav->others_amount;                                 
                 }

                 $hou ="HOUSE RECOVERY" ; 
                 $houv = $this->payroll_model->getHouseRecovery($salaryId,$hou);
                 if (empty($houv)) {
                     $houa = 0;
                 } else {
                     $houa = $houv->others_amount;                                 
                 }

                 $salr ="SALARY RECOVERY" ; 
                 $salrv = $this->payroll_model->getSalaryRecovery($salaryId,$salr);
                 if (empty($salrv)) {
                     $salra = 0;
                 } else {
                     $salra = $salrv->others_amount;                                 
                 }

                 $court ="COURT ORDER" ; 
                 $courtv = $this->payroll_model->getCourtOrder($salaryId,$court);
                 if (empty($courtv)) {
                     $courta = 0;
                 } else {
                     $courta = $courtv->others_amount;                                 
                 }

                 $parc ="PURCHASE LOAN" ; 
                 $parcv = $this->payroll_model->getParcheLoan($salaryId,$parc);
                 if (empty($parcv)) {
                     $parca = 0;
                 } else {
                     $parca = $parcv->others_amount;                                 
                 }

                 $sunr ="SUNDRY ALLOWANCE RECOVERY" ; 
                 $sunrv = $this->payroll_model->getSundryRecovery($salaryId,$sunr);
                 if (empty($sunrv)) {
                     $sunra = 0;
                 } else {
                     $sunra = $sunrv->others_amount;                                 
                 }

                 $kkl ="KK LOAN" ; 
                 $kklv = $this->payroll_model->getKKloan($salaryId,$kkl);
                 if (empty($kklv)) {
                     $kkla = 0;
                 } else {
                     $kkla = $kklv->others_amount;                                 
                 }

                 $kkel ="KK EMERGENCY LOAN" ; 
                 $kkelv = $this->payroll_model->getKKeloan($salaryId,$kkel);
                 if (empty($kkelv)) {
                     $kkela = 0;
                 } else {
                     $kkela = $kkelv->others_amount;                                 
                 }

                 $over ="OVERTIME" ; 
                 $overtime = $this->payroll_model->getAdditionOvertime($salaryId,$over);

                 if (empty($overtime)) {
                     $overa = 0;
                 } else{
                     $overa = $overtime->add_amount;
                 }

                 $fuealareas ="FUEL ALLOWANCE ARREAS" ; 
                 $fuelArea = $this->payroll_model->getFuelArears($salaryId,$fuealareas);

                 if (empty($fuelArea)) {
                     $fuelAreaa = 0;
                 } else{
                     $fuelAreaa = $fuelArea->add_amount;
                 }

                 $tele ="TELEPHONE ALLOWANCE" ; 
                 $telev = $this->payroll_model->getTelephoneAllowance($salaryId,$tele);

                 if (empty($telev)) {
                     $telea = 0;
                 } else{
                     $telea = $telev->add_amount;
                 }

                 $teleareas ="TELEPHONE ALLOWANCE ARREAS" ; 
                 $teleav = $this->payroll_model->getTelephoneAllowanceAreas($salaryId,$teleareas);

                 if (empty($teleav)) {
                     $televa = 0;
                 } else{
                     $televa = $teleav->add_amount;
                 }

               $pay = array();
               $pay = array(
                            'month'=>$month,
                            'year'=>$year,
                            'em_id'=>$value->em_id,
                            'paye'=>$value->paye,
                            'basic_salary'=>$value->basic_payment,
                            'gross_salary'=>$value->gross_salary,
                            'net_salary'=>$value->net_payment,
                            'tewuta'=>$tewt,
                            'cotwu'=>$cott,
                            'kksaving'=>$kka,
                            'wadu'=>$wada,
                            'houserent'=>$housa,
                            'insurance'=>$insa,
                            'salaryarrers'=>$sal,
                            'actingallowance'=>$acta,
                            'fuelallowance'=>$fela,
                            'psssf'=>$pssfa,
                            'nhif'=>$nhifa,
                            'heslb'=>$hslba,
                            'zheslb'=>$zhslba,
                            'telephoneallowancearrears'=>$televa,
                            'telephoneallowance'=>$telea,
                            'sundryallowancerecovery'=>$sunra,
                            'fuelallowancearreas'=>$fuelAreaa,
                            'overtime'=>$overa,
                            'emergencyloan'=>$kkela,
                            'kkloan'=>$kkla,
                            'purchaseloan'=>$parca,
                            'courtorder'=>$courta,
                            'salaryrecovery'=>$salra,
                            'houserecovery'=>$houa,
                            'shortaccess'=>$shaa,
                            'sundryallowance'=>$sundrya

                            );

               $this->payroll_model->Save_Payroll_Model($pay);
               
            }
            $data['salary'] = $this->payroll_model->Check_Roster_Pay($month,$year);
            }
            } else {
               $bsalary = $this->payroll_model->getSumBasicSalary($month,$year);
               $data['basicSalary'] = $bsalary->basic_salary;
               $gsalary = $this->payroll_model->getSumGrossSalary($month,$year);
               $data['grossSalary'] = $gsalary->gross_salary;
               $nsalary = $this->payroll_model->getSumNetSalary($month,$year);
               $data['nsalary'] = $nsalary->net_salary;
               $purchaseloan = $this->payroll_model->getSumpurchaseloan($month,$year);
               $data['purchaseloan'] = $purchaseloan->purchaseloan;
               $kkloan = $this->payroll_model->getSumkkloan($month,$year);
               $data['kkloan'] = $kkloan->kkloan;
               
               $emergencyloan = $this->payroll_model->getSumemergencyloan($month,$year);
               $data['emergencyloan'] = $emergencyloan->emergencyloan;
               $overtime = $this->payroll_model->getSumovertime($month,$year);
               $data['overtime'] = $overtime->overtime;
               $sundryallowancerecovery = $this->payroll_model->getSumsundryallowancerecovery($month,$year);
               $data['sundryallowancerecovery'] = $sundryallowancerecovery->sundryallowancerecovery;
               $telephoneallowance = $this->payroll_model->getSumtelephoneallowance($month,$year);
               $data['telephoneallowance'] = $telephoneallowance->telephoneallowance;
               $telephoneallowancearrears = $this->payroll_model->getSumtelephoneallowancearrears($month,$year);
               $data['tala1'] = $telephoneallowancearrears->telephoneallowancearrears;

               $fuelallowance = $this->payroll_model->getSumfuelallowance($month,$year);
               $data['fuelallowance'] = $fuelallowance->fuelallowance;
               $actingallowance = $this->payroll_model->getSumactingallowance($month,$year);
               $data['actingallowance'] = $actingallowance->actingallowance;
               $wadu = $this->payroll_model->getSumwadu($month,$year);
               $data['wadu'] = $wadu->wadu;
               $houserent = $this->payroll_model->getSumhouserent($month,$year);
               $data['houserent'] = $houserent->houserent;
               $insurance = $this->payroll_model->getSuminsurance($month,$year);
               $data['insurance'] = $insurance->insurance;
               $salaryarrers = $this->payroll_model->getSumsalaryarrers($month,$year);
               $data['salaryarrers'] = $salaryarrers->salaryarrers;
               $kksaving = $this->payroll_model->getSumkksaving($month,$year);
               $data['kksaving'] = $kksaving->kksaving;
               $cotwu = $this->payroll_model->getSumcotwu1($month,$year);
               $data['cotwu'] = $cotwu->cotwu;
               $tewuta = $this->payroll_model->getSumtewuta1($month,$year);
               $data['tewuta'] = $tewuta->tewuta;
               $zheslb = $this->payroll_model->getzheslbSum($month,$year);
               $data['zheslb'] = $zheslb->zheslb;
               $heslb = $this->payroll_model->getheslbSum($month,$year);
               $data['heslb'] = $heslb->heslb;
               $courtorder = $this->payroll_model->getcourtorderSum($month,$year);
               $data['courtorder'] = $courtorder->courtorder;
               $salaryrecovery = $this->payroll_model->getsalaryrecoverySum($month,$year);
               $data['salaryrecovery'] = $salaryrecovery->salaryrecovery;
               $houserecovery = $this->payroll_model->gethouserecoverySum($month,$year);
               $data['houserecovery'] = $houserecovery->houserecovery;
               $shortaccess = $this->payroll_model->getshortaccessSum($month,$year);
               $data['shortaccess'] = $shortaccess->shortaccess;
               $sundAll = $this->payroll_model->getSumSunAll($month,$year);
               $data['sundryallowance'] = $sundAll->sundryallowance;
               $snhif = $this->payroll_model->getNhifSum($month,$year);
               $data['nhif'] = $snhif->nhif;
               $spsssf = $this->payroll_model->getPsssfSum($month,$year);
               $data['psssf'] = $spsssf->psssf;
               $paye = $this->payroll_model->getpayeSum($month,$year);
               $data['paye'] = $paye->paye;
               $data['salary'] = $this->payroll_model->Check_Roster_Pay($month,$year);
           }
            
            $this->load->view('backend/payroll_report',$data);
            

            // if ($month == "May" || $month == "June") {
            //    $data['salary'] = $this->payroll_model->Get_Paid_SalaryReport($month,$year);
            // } else {
            //    $data['salary'] = $this->payroll_model->Get_Paid_SalaryReport($month,$year);
            // }
            //$data['netReport'] = $this->payroll_model->getNetPayReport($month,$year);
            //$data['grossReport'] = $this->payroll_model->getGrossReport($month,$year);
            //$data['basicReport'] = $this->payroll_model->getBasicReport($month,$year);
            
           
        } else {
            redirect(base_url(),'refresh');
        }
        
    }

}
