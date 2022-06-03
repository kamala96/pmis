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
    

    public function Create_Salary()
    {
        if($this->session->userdata('user_login_access') != False) { 

            $id = base64_decode($this->input->get('I'));
            $data['basic'] = $this->employee_model->GetBasic($id);
            $data['salaryvalue'] = $this->payroll_model->GetsalaryValue($id);

            $update = array();
            $update = array('em_id'=>$data['salaryvalue']->emp_id);
            $salary_id = $data['salaryvalue']->id;
            $this->payroll_model->Update_Africa_Assurance($update,$salary_id);

            $data['TaxAddition']= $this->payroll_model->getTaxAddition($id,$salary_id);
            $data['NonTaxAddition'] = $this->payroll_model->getNonTaxAddition($id,$salary_id);
            $data['PensionFund'] = $this->payroll_model->getPensionFund($id);
            $data['TaxRelif'] = $this->payroll_model->getTaxRelief($salary_id);
            $data['TradeUnion'] = $this->payroll_model->getTradeUnion($id);
            $data['AfricaAssurance'] = $this->payroll_model->getAfricaAssurance($id);
            $data['NonTaxDeduction'] = $this->payroll_model->getNonTaxDeduction($id);
            $data['TaxDeduction'] = $this->payroll_model->getTaxDeduction($id);
            $data['LoanDeduction'] = $this->payroll_model->getLoanDeduction($id);
            $data['BankInfomation'] = $this->payroll_model->getBankInfo($id);
            $data['commPension'] = $this->payroll_model->GetCommulativePension($id);
            $data['commPendingSec'] = $this->payroll_model->GetCommulative($id);
            $data['getValue'] = $this->payroll_model->commulative_value($id);
            
            $this->load->view('payroll/create_salary',$data);

        }else{
            redirect(base_url());
        }

    }


 public function edit_bank_info()
    {
        if($this->session->userdata('user_login_access') != False) { 

            $id = base64_decode($this->input->get('I'));
            $data['basic'] = $this->employee_model->GetBasic($id);
            $data['salaryvalue'] = $this->payroll_model->GetsalaryValue($id);

            $update = array();
            $update = array('em_id'=>$data['salaryvalue']->emp_id);
            $salary_id = $data['salaryvalue']->id;
            $this->payroll_model->Update_Africa_Assurance($update,$salary_id);

       
            $data['bankinfo'] = $this->payroll_model->getBankInfo($id);
           
            $this->load->view('backend/edit_bank_info',$data);

        }else{
            redirect(base_url());
        }

    }


 
    public function Add_bank_info(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->post('id');
        $em_id = $this->input->post('emid');
        $holder = $this->input->post('holder_name');
        $bank = $this->input->post('bank_name');
        $branch = $this->input->post('branch_name');
        $number = $this->input->post('account_number');
        $bank_code = $this->input->post('bank_code');
        $account = $this->input->post('account_type');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('holder_name', 'holder name', 'trim|required|min_length[5]|max_length[120]|xss_clean');
        $this->form_validation->set_rules('account_number', 'account name', 'trim|required|min_length[5]|max_length[120]|xss_clean');
        // $this->form_validation->set_rules('branch_name', 'branch name', 'trim|required|min_length[5]|max_length[120]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
            redirect("employee/view?I=" .base64_encode($em_id));
            } else {
            $data = array();
                $data = array(
                    'em_id' => $em_id,
                    'holder_name' => $holder,
                    'bank_name' => $bank,
                    'branch_name' => $branch,
                    'account_number' => $number,
                    'account_type' => $account,
                    'bank_code'=>$bank_code
                );
            if(empty($id)){
                $success = $this->employee_model->Add_BankInfo($data);
                $this->session->set_flashdata('feedback','Successfully Added');
                redirect("employee/view?I=" .base64_encode($em_id));
                echo "Successfully Added";
            } else {
                $success = $this->employee_model->Update_BankInfo($id,$data);
                $this->session->set_flashdata('feedback','Successfully Updated');
                redirect("employee/view?I=" .base64_encode($em_id));
                echo "Successfully Updated";
            }
                       
        }
        }
    else{
        redirect(base_url() , 'refresh');
    }            
    }





    public function GetScale(){

      $scale_name = $this->input->post('scale_name',TRUE);
      echo $this->payroll_model->Get_Scale_Salary($scale_name);

    }

    public function Save_Salary()
   {
            
       if($this->session->userdata('user_login_access') != False) {

                $em_id = $this->input->post('emid');
                $salary_scale = $this->input->post('salary_scale');
                $basic_amount = $this->input->post('basic_amount');

                $data = array();
                $data = array(
                     'emp_id' => $em_id,
                     'type_id' => $salary_scale,
                     'total' => $basic_amount
                    );
                        
                    $success = $this->payroll_model->Add_Salary($data);
                        
                    $message = 'Successfully Added';
                
                echo  $message;
   }else{
         redirect(base_url() , 'refresh');
    }
}

public function Save_Addition()
   {
        if($this->session->userdata('user_login_access') != False) {
             $em_id = $this->input->post('emid');
             $sid = $this->input->post('sid');
             $addid = $this->input->post('addid');
             $addition_name = $this->input->post('addition_name');
             $addition_amount = $this->input->post('addition_amount');
             $date = '-31';
             $startmonth = $this->input->post('startdate');
             $endmonth =   $this->input->post('enddate');
             $addition_name1 = $this->input->post('addition_name1');
             $addition_amount1 = $this->input->post('addition_amount1');
             $startmonth1 = $this->input->post('startdate1');
             $endmonth1 =   $this->input->post('enddate1');
             $edit =   $this->input->post('edit');
             $remove =   $this->input->post('remove');
             
            if ($edit =="edit") {
                $data = array();
                $data = array(

                            'salary_id' => $sid,
                            'add_name' => $addition_name1,
                            'add_amount' => $addition_amount1,
                            'start_month'=>$startmonth1,
                            'end_month'=>$endmonth1,
                            'em_id' => $em_id

                        );
                $success = $this->payroll_model->update_emp_Addition($data,$addid);
                echo 'Successfully Updated';
            }elseif ($remove == "remove") {
                $this->payroll_model->Delete_Emp_Addition($addid);
                 echo "Successfully Deleted";
            } else {
                 $data = array();
                 $data = array(
                            'salary_id' => $sid,
                            'add_name' => $addition_name,
                            'add_amount' => $addition_amount,
                            'start_month'=>$startmonth,
                            'end_month'=>$endmonth,
                            'em_id' => $em_id
                        );
                $success = $this->payroll_model->Add_Emp_Addition($data);
                echo 'Successfully Added';
            }
            
        }else{
            redirect(base_url());
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
             $start_month = $this->input->post('start_month');
             $end_month = $this->input->post('end_month');
             $delete = $this->input->post('delete');
             $edit = $this->input->post('edit');

             $addition_name1 = $this->input->post('addition_name1');
             $addition_amount1 = $this->input->post('addition_amount1');
             $start_month1 = $this->input->post('start_month1');
             $end_month1 = $this->input->post('end_month1');

             if ($delete =="delete") {
                 $success = $this->payroll_model->Delete_Non_Tax_Addition($addid);
                     echo 'Successfully Deleted';
             } elseif ($edit =="edit") {
                 $data = array();
                         $data = array(
                             'salary_id' => $sid,
                             'add_name' => $addition_name1,
                             'add_amount' => $addition_amount1,
                             'start_month'=>$start_month1,
                             'end_month'=>$end_month1,
                             'em_id' => $em_id
                         );
                 $success = $this->payroll_model->Update_Non_Tax_Addition($data,$addid);
                 echo 'Successfully Updated';
                 
             }else{

                $data = array();
                $data = array(
                             'salary_id' => $sid,
                             'add_name' => $addition_name,
                             'add_amount' => $addition_amount,
                             'start_month'=>$start_month,
                             'end_month'=>$end_month1,
                             'em_id' => $em_id
                         );
                 $success = $this->payroll_model->Add_Non_Tax_Addition($data);
                 echo 'Successfully Added';
             }
             
             }else{
                redirect(base_url());
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
             $delete = $this->input->post('delete');

             if ($delete == "delete") {
                 $success = $this->payroll_model->Delete_Pension_Fund($emid);
                     echo 'Successfully Deleted';
             } else {

                 $data = array();
                 $data = array(
                            'salary_id' => $sid,
                            'fund_name' => $fund_name,
                            'fund_percent' => $fund_percent,
                            'fund_amount'=>$fund_percent*$basic_amount,
                            'em_id' => $emid
                        );
                $success = $this->payroll_model->Add_Emp_Fund($data);
                echo 'Successfully Added';
             }
        }else{
            redirect(base_url());
        }
   }

   public function Tax_relief()
  {
    if($this->session->userdata('user_login_access') != False) {

        echo $tax = $this->input->post('tax_relief');
        echo $emid = $this->input->post('emid');
        echo $sid = $this->input->post('sid');
        $trid = $this->input->post('trid');
        $remove = $this->input->post('remove');

        if (empty($remove)) {
           
           $data = array();
           $data = array('amount'=>$tax,'em_id'=>$emid,'salaryId'=>$sid);

               $this->payroll_model->save_tax_relief($data);
               echo "Successfully Added";

        } else {
             $this->payroll_model->delete_tax_relief($trid);
            echo "Successfully Deleted";
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
             $dedid = $this->input->post('dedid');
             $total = $this->input->post('basic_amount');
             $button = $this->input->post('delete');

             if ($button != "delete") {
                
                    if ($deduction_name == "COTWU(T)" || $deduction_name == "TEWUTA") {

                         $data = array();
                         $data = array(
                             'salary_id' => $sid,
                             'ded_name' => $deduction_name,
                             'ded_amount' => $deduction_amount*$total,
                             'em_id' => $em_id
                       );

                        }else{

                        $data = array();
                        $data = array(
                            'salary_id' => $sid,
                            'ded_name' => $deduction_name,
                            'ded_amount' => $deduction_amount,
                            'em_id' => $em_id
                        );
                    }
                    $success = $this->payroll_model->Add_Emp_Non_Percent($data);
                echo 'Successfully Added';
             }else {
                 
                $success = $this->payroll_model->Delete_Emp_Non_Percent($dedid);
                echo "Successfully Deleted";

             }

        }else{
            redirect(base_url());
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

              
                $success = $this->payroll_model->Add_Emp_Assuarance($data);
                echo 'Successfully Added';
                
             } else {
                 $success = $this->employee_model->Delete_Emp_Assuarance($assId);
                echo 'Successfully Deleted';
             }
             
             
        }
   }

   public function Save_percent_comm()
  {
    if($this->session->userdata('user_login_access') != False) {

        $name = "PSSSF";
        $amount = $this->input->post('amount');
        $sid = $this->input->post('sid');
        $em_id = $this->input->post('emid');
        $id = $this->input->post('fundid');
        $button = $this->input->post('remove');

        if ($button == "remove") {
            $this->payroll_model->remove_commulative_psssf($id);
           echo "Successfull Removed";
        } else {

        $PensionF = array();
        $PensionF = array('salary_id'=>$sid,
            'fund_name'=>$name,
            'fund_amount'=>$amount,
            'month'=>'April',
            'year'=>2020,
            'em_id'=>$em_id);
        $this->payroll_model->InsertPensionPermonth($PensionF);

        echo "Successfull Updated";
        }
    }

  }

  public function Save_non_percent_comm()
  {
    if($this->session->userdata('user_login_access') != False) {

        $name = $this->input->post('name');
        $amount = $this->input->post('amount');
        $sid = $this->input->post('sid');
        $em_id = $this->input->post('emid');
        $id = $this->input->post('commid');

        $button = $this->input->post('remove');
        if ($button == "remove") {
           
           $this->payroll_model->remove_commulative($id);
           echo "Successfull Removed";
        } else {
            
            $dataNonP = array();
        $dataNonP = array('salary_id'=>$sid,
            'ded_name'=>$name,
            'ded_amount'=>$amount,
            'month'=>'April',
            'year'=>2020,
            'em_id'=>$em_id
        );
        $this->payroll_model->insertNonPDeductioCommulative($dataNonP);

        echo "Successfull Updated";
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
             $id = $this->input->post('others_id');
             $button = $this->input->post('delete');
             if (empty($button)) {
                 //Employee Addition from input

                   
                    $data = array();
                        $data = array(
                                 'salary_id' =>$sid,
                                 'other_names'=>$others_names,
                                 'loan_amount'=>$loan_amount,
                                 'installment_Amount' => $loan_deduction_amount,
                                 'status'=>'ACTIVE',
                                 'em_id' => $em_id,
                                 'month'=>date('M'),
                                 'year'=>date('Y')
                             );
                 $success = $this->payroll_model->Add_Others_Deduction($data);
                 echo 'Successfully Added';
             }else{
                $success = $this->payroll_model->Delete_others_deduction_permonth($id);
             echo 'Successfully Deleted';
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
             $button = $this->input->post('remove');
             
                if (empty($button)) {
                   
                        $data = array();
                        $data = array(
                            'salary_id' => $salary_id,
                            'ded_name' => $percent_name,
                            'ded_percent' => $percent_amount,
                            'ded_amount'  => $percent_amount * $basic_amount,
                            'em_id'  => $em_id
                        );
                        $success = $this->payroll_model->Add_Emp_Percent($data);
                        echo 'Successfully Added';
                }else{

                    $success = $this->payroll_model->Delete_emp_percent_deduction($dedid);
                    echo 'Successfully Deleted';
                }
                
             
        }else{
            redirect(base_url());
        }
   }


   public function Salary_List(){

        if($this->session->userdata('user_login_access') != False) {

        $data['salary_info'] = $this->payroll_model->getAllSalaryData();

        $this->load->view('payroll/salary_list', $data);

        }

        else {

            redirect(base_url() , 'refresh');
        }
    }


    public function Payslip_Create1(){

        if($this->session->userdata('user_login_access') != False) {

            $em_id = $this->payroll_model->getAllSalaryDataID();
             $month = date('m');
            $dateObj   = DateTime::createFromFormat('!m', $month);
            $monthName = $dateObj->format('F');
            $year = date('Y');
          // $em_id = $this->input->post('I');



            //  $totalAddition= 0;
            // $totalNonTaxAddition= 0;
            // $totalNonPDeduction= 0;
            // $totalDeduction= 0;
            // $totalPDeduction= 0;

        if (!empty($em_id)) {

            $id2=$em_id[0]->em_id;

             $get_salary_record = $this->payroll_model->getSalaryRecord($id2,$year,$monthName);

            if( !empty($get_salary_record )) {

                    echo " Already Generated";

                } else {
               
            //for ($i=0; $i <@sizeof($em_id) ; $i++) {
           foreach ($em_id as $value) {

            //$id = $em_id[$i];
            $id = $value->em_id;
            $salary_info = $this->payroll_model->Get_SalaryID($id);
            $scale = $salary_info->type_id;
            $bankIfo = $this->payroll_model->Get_BankInfo($id);
             $banks= $this->payroll_model->swiftcode($bankIfo->bank_name);
            $salary_id = $salary_info->id;

           
        //Get Deductions
        $data['othersDeductions'] = $this->payroll_model->Others_Employee_Deduction($salary_id,$id);

         foreach ($data['othersDeductions'] as $value) {

                 if ($value->other_names == "HESLB") {

                    $ded_amountheslb = $salary_info->total * 0.15;
                    $data = array();
                    $data = array('others_amount'=>$ded_amountheslb);
                    $this->payroll_model->update_heslb($data,$salary_id);//others_id
                }

                $installmentName = $value->other_names;
                $lastInstallement = $this->payroll_model->Others_Employee_Deduction_Permonth($installmentName,$salary_id);


                    if ( !empty($lastInstallement->others_amount) &&  $lastInstallement->others_amount == 0) {
                        
                    $dedu = array();
                    $dedu = array(

                    'other_names'=>$value->other_names,
                    'others_amount'=>0,
                    'salary_id'=>$salary_id,
                    'loan_amount'=>$value->loan_amount,
                    'installment_Amount'=>0,
                    'status'=>'COMPLETE',
                    'em_id'=>$id,
                    'month'=>$monthName,
                    'year'=>date('Y')

                    );

                    } else {

                        if(empty($lastInstallement->others_amount)){
                             $dedu = array();
                    $dedu = array(
                        
                    'other_names'=>$value->other_names,
                    'others_amount'=>$value->loan_amount - $value->installment_Amount,
                    'salary_id'=>$salary_id,
                    'loan_amount'=>$value->loan_amount,
                    'installment_Amount'=>$value->installment_Amount,
                    'status'=>'ACTIVE',
                    'em_id'=>$id,
                    'month'=>$monthName,
                    'year'=>date('Y')

                    );


                        }
                        else
                        {
                             $dedu = array();
                    $dedu = array(
                        
                    'other_names'=>$value->other_names,
                    'others_amount'=>$lastInstallement->others_amount - $lastInstallement->installment_Amount,
                    'salary_id'=>$salary_id,
                    'loan_amount'=>$value->loan_amount,
                    'installment_Amount'=>$value->installment_Amount,
                    'status'=>'ACTIVE',
                    'em_id'=>$id,
                    'month'=>$monthName,
                    'year'=>date('Y')

                    );


                        }

                   
            } 
                $this->payroll_model->insertOthersDeductionData($dedu);

        }

            $getTaxRelief = $this->payroll_model->getTaxReliefs($salary_id,$id);

            if (!empty($getTaxRelief)) {
               $taxRelief = $getTaxRelief->amount;
            } else {
                $taxRelief = 0;
            }

            $PercentDeduction= $this->payroll_model->getPercentDeduction($salary_id,$id);
            foreach ($PercentDeduction as $value) {
                $dataP = array();
                $dataP = array(
                    'salary_id'=>$salary_id,
                    'ded_name'=>$value->ded_name,
                    'ded_percent'=>$value->ded_percent,
                    'ded_amount'=>$value->ded_amount,
                    'month'=>$monthName,
                    'year'=>$year,
                    'em_id'=>$id);

                $this->payroll_model->insertPDeductioCommulative($dataP);
            }

            
             $PensionDeduction = $this->payroll_model->getPensionDeduction($salary_id,$id);

            if(!empty($PensionDeduction)){
                $PensionF = array();
                $PensionF = array(
                    'salary_id'=>$salary_id,
                    'fund_name'=>$PensionDeduction->fund_name,
                    'fund_amount'=>$PensionDeduction->fund_amount,
                    'month'=>$monthName,
                    'year'=>$year ,
                    'em_id'=>$id
                );

                $this->payroll_model->InsertPensionPermonth($PensionF);

            }
            
            

                $NonPercentDeduction= $this->payroll_model->getNonPDeductions($id,$salary_id);

               foreach ($NonPercentDeduction as $value) {
                $NonP = array();
                $NonP = array(
                    'salary_id'=>$salary_id,
                    'ded_name'=>$value->ded_name,
                    'ded_amount'=>$value->ded_amount,
                    'month'=>$monthName,
                    'year'=>$year,
                    'em_id'=>$id
                );

                $this->payroll_model->insertNonPDeductioCommulative($NonP);
            }

            $TaxAddition= $this->payroll_model->getTaxAddition($id,$salary_id);
            

            foreach ($TaxAddition as $value) {
                // One month from a specific date
                //$datemn = date('Y-m-d', strtotime('+1 month', strtotime($value->end_month)));
                // if(strtotime($value->end_month) > strtotime('now') || empty($value->end_month))
                // {
                //      $totalAddition= $totalAddition + $value->add_amount;
          
                    $dataTaxA = array();
                $dataTaxA = array(
                            'salary_id' => $salary_id,
                            'add_name' => $value->add_name,
                            'add_amount' => $value->add_amount,
                            'month'=>$monthName,
                            'year'=>$year,
                            'em_id' => $id
                        );
                $success = $this->payroll_model->addTaxAdditionPErMonth($dataTaxA);

               // }
                
            }


            $NonTaxAddition= $this->payroll_model->getNonTaxAddition($id,$salary_id);

            foreach ($NonTaxAddition as $value) {
                // if(strtotime($value->end_month) > strtotime('now')|| empty($value->end_month))
                // {
                     //$totalNonTaxAddition= $totalNonTaxAddition + $value->add_amount;

                     $dataNonTaxA = array();
                $dataNonTaxA = array(
                            'salary_id' => $salary_id,
                            'add_name' => $value->add_name,
                            'add_amount' => $value->add_amount,
                            'month'=>$monthName,
                            'year'=>$year,
                            'em_id' => $id
                        );
                $success = $this->payroll_model->addNonTaxAdditionPErMonth($dataNonTaxA);

               // }
               
            }


             //$totalAddition=  $totalAddition;
           //$totalNonTaxAddition=  $totalNonTaxAddition;



        $totalAddition= $this->payroll_model->getTotalAdditionAmount($id,$salary_id);
        $totalNonTaxAddition= $this->payroll_model->getTotalNonTaxAdditionAmount($id,$salary_id);

        //    $totalAddition= $this->payroll_model->getTotalAdditionAmounts($monthName,$salary_id);
        // $totalNonTaxAddition= $this->payroll_model->getTotalNonTaxAdditionAmounts($monthName,$salary_id);

        $totalNonPDeduction= $this->payroll_model->getTotalNonPDeductionAmount($id,$salary_id);
        $totalDeduction= $this->payroll_model->getTotalDeductionAmount($id,$salary_id);
        $totalPDeduction= $this->payroll_model->getTotalPDeductionAmount($id,$salary_id);



        $checkAss = $this->payroll_model->getAssuarances($salary_id,$id);

               if (!empty($checkAss)) {
                $Ass = array();
                $Ass = array(
                    'salary_id'=>$salary_id,
                    'ded_name'=>$checkAss->ded_name,
                    'ded_amount'=>$checkAss->ded_amount,
                    'month'=>$monthName,
                    'year'=>$year,
                    'em_id'=>$id
                );

                $this->payroll_model->insertAssurance($Ass);
            }

          if (empty($checkAss)) {
             if(!empty($PensionDeduction))
             {
                 $before = $salary_info->total-$PensionDeduction->fund_amount;
               $basic_totalAdd = $before + $totalAddition->add_amount;
             }else
             {
                 $before = $salary_info->total;
               $basic_totalAdd = $before + $totalAddition->add_amount;

             }

               

          } else {

             if(!empty($PensionDeduction))
             {
               $before = $salary_info->total-$PensionDeduction->fund_amount;
               $basic_totalAdd = $before - @$checkAss->ded_amount + ($totalAddition->add_amount);

             }else
             {
                $before = $salary_info->total;
                $basic_totalAdd = $before - @$checkAss->ded_amount + ($totalAddition->add_amount);


             }

            
          }


          if ($basic_totalAdd <= 270000) {

            $paye = 0;
            $gross_payment = (($basic_totalAdd) + ($totalNonTaxAddition->add_amount));

        }
        if ($basic_totalAdd >= 270000 && $basic_totalAdd <= 520000) {

           $paye = ($basic_totalAdd - 270000) * 0.09;
           $gross_payment = (($basic_totalAdd) + ($totalNonTaxAddition->add_amount));
        }
        if ($basic_totalAdd >= 520000 && $basic_totalAdd <= 760000) {

           $paye = 22500 + ($basic_totalAdd - 520000) * 0.2;
           $gross_payment = (($basic_totalAdd) + ($totalNonTaxAddition->add_amount));
        }
        if ($basic_totalAdd >= 760000 && $basic_totalAdd <= 1000000) {

           $diff = $basic_totalAdd -(760000);
           $mult = $diff * 0.25;
           $paye = (70500 + $mult);
           $gross_payment = (($basic_totalAdd) + ($totalNonTaxAddition->add_amount));
        }
        
        if ($basic_totalAdd >= 1000000 ) {

           $paye = 130500 + ($basic_totalAdd - 1000000) * 0.3;
           $gross_payment = (($basic_totalAdd) + ($totalNonTaxAddition->add_amount));
        }

           $sumDeduction = $totalPDeduction->ded_amount + $totalNonPDeduction->ded_amount + $totalDeduction->others_amount  + $paye;

             $net_payment = $gross_payment  - $sumDeduction + $taxRelief;

             $dateToTest =date('d/m/Y');
             $lastday = date('t',strtotime($dateToTest));
             $info = $this->employee_model->GetBasic($id);

            /* if(!empty($PensionDeduction)){
                $pensiondeduc =   $PensionDeduction->fund_amount;

             }else{
                $pensiondeduc =   0;

             }*/

             $payment_desc ='SALARY';

             

             $data=array();
             $data = array(
                        'emp_code'=>$info->em_code,
                        'em_id' =>$id ,
                        'salary_scale'=>$salary_info->type_id,
                        'month' =>$monthName,
                        'year'=>date('Y'),
                        'paid_date' =>$lastday.'/'.date('m').'/'.date('Y'),
                        'paid_status'=>'PAID',
                        'others_deduction_total'=>$totalDeduction->others_amount,
                        'net_payment'=>$net_payment,
                        'basic_payment' =>$salary_info->total,
                        'percentage_deduction_total'=>$totalPDeduction->ded_amount,
                        'nonpercentage_deduction_total'=>$totalNonPDeduction->ded_amount,
                        'addition_total' => $totalAddition->add_amount,
                        'nonTaxAddition_total'=>$totalNonTaxAddition->add_amount,
                        'paye'=>$paye,
                        'pension_fund'=>@$PensionDeduction->fund_amount,
                        'pension_name'=>@$PensionDeduction->fund_name,
                        'bank_name'=>@$bankIfo->bank_name,
                        'gross_salary'=>$gross_payment,
                        'gross_taxable'=>$salary_info->total-@$checkAss->ded_amount+$totalAddition->add_amount-@$PensionDeduction->fund_amount,
                        'id_salary'=>$salary_id,

                        'swift_code'=>$banks->swift_code,
                        'payment_desc'=>$payment_desc,
                        'title'=>$info->des_name,
                    );

              // See if record exists
            $get_salary_record = $this->payroll_model->getSalaryRecord($id,$year,$monthName);

            if( !empty($get_salary_record )) {

                    echo "Has Already Paid";

                } else {
                    //else start
                    $this->payroll_model->insertPaidSalaryData($data);
                    //$lastId = $this->db->insert_id();
                }
                //else end;

         }

         echo "Salary Successfully Payed";
       }
        }else{

        }

    }else{
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
    public function Deductions_Report()
    {
        if($this->session->userdata('user_login_access') != False) {

        $data['salary_info'] = $this->payroll_model->getAllSalaryPayedData();
        $data['employee'] = $this->employee_model->emselect();
        $this->load->view('payroll/Deduction_report', $data);

        }

        else {

            redirect(base_url() , 'refresh');
        }
    }


    public function Salary_Slip_Create(){

        if($this->session->userdata('user_login_access') != False) {

        $id = base64_decode($this->input->get('I'));
        $month = base64_decode($this->input->get('M'));
        $year = base64_decode($this->input->get('Y'));
        $salary_id = $this->input->get('S');
        $data = array();
        $data['title']  = 'Tanzania Posts Corporation';
        $data['title1'] = 'Monthly Salary Slip';

        // $data['TaxAddition'] = $this->payroll_model->getTaxAddition1($id,$month,$year);
        // $data['NonTaxAddition'] = $this->payroll_model->getNonTaxAddition($id,$salary_id);

         $data['TaxAddition'] = $this->payroll_model->getTaxAdditions($id,$salary_id);
        

        $data['NonTaxAddition'] = $this->payroll_model->getNonTaxAddition($id,$salary_id);





        $data['salary_info'] = $this->payroll_model->Get_Paid_Salary($id,$month,$year);

        $data['Additional'] = $this->payroll_model->getAdditional($id,$month,$year);
        $data['NonTaxDeduction1'] = $this->payroll_model->getNonTaxDeduction1($salary_id,$month,$year,$id);
        //$data['NonTaxDeduction'] = $this->payroll_model->getNonTaxDeduction($salary_id);
        $data['TaxDeduction']= $this->payroll_model->getTaxDeduction1($salary_id,$id,$month,$year);
        
        $data['LoanDeduction']= $this->payroll_model->getLoanDeduction2($salary_id,$month,$year);


        $data['pensionFund'] = $this->payroll_model->getLastContribution($id);
         $data['assAfrica']  = $this->payroll_model->getAssuarance2($id);
        $data['taxtRelief']  = $this->payroll_model->getTaxRelief($id);


         $data['NonPercentageDeduction']= $this->payroll_model->getNonPercentageDeduction2($salary_id,$month,$year);


        //$html = $this->output->get_output();
        $html= $this->load->view('payroll/salary_slipNew',$data,TRUE);
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

    public function Salary_Slips()
    {
        if($this->session->userdata('user_login_access') != False) {

        $month = $this->input->post('month');
        $year = $this->input->post('year'); 
       
        $data['salary_info'] = $this->payroll_model->getAllSalaryPayedData_Slips($month,$year);
        $data['employee'] = $this->employee_model->emselect();
        $this->load->view('payroll/salary_slips', $data);

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

        $paye = $this->input->post('paye');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $region = $this->input->post('region');

        $data['list'] = $this->payroll_model->get_pay_list_data($month,$year,$region);
        $data['paye'] = $this->payroll_model->get_pay_data($month,$year,$region);

        if (empty($data['paye'])) {
            
        foreach ($data['list'] as $value) {
        $salary_id = $value->id; 
        $assAfrica = $this->payroll_model->getAssuarance($salary_id); 
        $basicSundry = (($value->basic_payment - @$assAfrica->ded_amount)+($value->addition_total));
          $taxablepaye  = $basicSundry-$value->pension_fund; 

        $save = array();
        $save = array(

            'PFno'=>$value->em_code,
            'full_name'=>$value->first_name.'  '.$value->middle_name.'  '.$value->last_name,
            'gross_taxable'=>$taxablepaye,
            'paye_employee_amount'=>$value->paye,
            'paye_employer_amount'=>$value->basic_payment*0.045,
            'total'=>$value->paye+$value->basic_payment*0.045,
            'region'=>$value->em_region,
            'month'=>$value->month,
            'year'=>$value->year
        );

         $this->payroll_model->save_paye_value($save);
        }
        $data['paye'] = $this->payroll_model->get_pay_data($month,$year,$region);
        }
        $data['paye'] = $this->payroll_model->get_pay_data($month,$year,$region);
        $this->load->view('payroll/payed_salary_list', $data);

        }

        else {

            redirect(base_url() , 'refresh');
        }
    }

    public function Payroll_report(){

        if ($this->session->userdata('user_login_access') != False) {
            
            $month = $this->input->post('month');
            $year  = $this->input->post('year');


            $data['paymonth'] = $this->payroll_model->Check_Roster_Pay($month,$year);
             $getEmid = $this->payroll_model->get_Em_Id($month,$year);

            if (empty($data['paymonth'])) {
                
                if (empty($getEmid)) {
                   $data['salary'] = $this->payroll_model->Check_Roster_Pay($month,$year);
                } else {


                foreach ($getEmid as $value) {
                 $salaryId = $value->id_salary;



                 // Start Deduction Procedure

                 $refund ="kk refund" ; 
                 $ref = $this->payroll_model->getKkRefundAreas($salaryId,$refund,$month,$year);
                 if (empty($ref)) {
                     $ref = 0.00;
                 } else {
                     $ref = $ref->add_amount;
                 }

                 $africanlife ="AFRICAN LIFE ASSURANCE" ; //SANLAM Insurance
                 $afric = $this->payroll_model->getAfricanLifeAmount($africanlife,$month,$year);
                 if (empty($afric)) {
                     $afric = 0.00;
                 } else {
                     $afric = $afric->ded_amount;
                 }

                 $tewuta ="TEWUTA" ; 
                 $tew = $this->payroll_model->getDedAmount($salaryId,$tewuta,$month,$year);
                 if (empty($tew)) {
                     $tewt = 0.00;
                 } else {
                     $tewt = $tew->ded_amount;
                 }
                 
                 $cotwu ="COTWU(T)" ; 
                 $cot = $this->payroll_model->getDedAmountCotwu($salaryId,$cotwu,$month,$year);
                  if (empty($cot)) {
                     $cott = 0.00;
                 } else {
                     $cott = $cot->ded_amount;
                 }

                 $kks ="KK SAVINGS" ; 
                 $kk = $this->payroll_model->getDedAmountKKSaving($salaryId,$kks,$month,$year);
                  if (empty($kk)) {
                     $kka = 0.00;
                 } else {
                     $kka = $kk->ded_amount;
                 }

                 $wadu ="W.A.D.U" ; 
                 $wad = $this->payroll_model->getDedAmountWadu($salaryId,$wadu,$month,$year);
                  if (empty($wad)) {
                     $wada = 0.00;
                 } else {
                     $wada = $wad->ded_amount;
                 }

                 $house ="HOUSE RENT" ; 
                 $hous = $this->payroll_model->getDedAmountHouse($salaryId,$house,$month,$year);
                  if (empty($hous)) {
                     $housa = 0.00;
                 } else {
                     $housa = $hous->ded_amount;
                 }

                 $insu ="INSURANCE" ; 
                 $insur = $this->payroll_model->getDedAmountInsurance($salaryId,$insu,$month,$year);
                  if (empty($insur)) {
                     $insa = 0.00;
                 } else {
                     $insa = $insur->ded_amount;
                 }  
                 //End of Deduction Procedure

                 //Start of addition Procedure 
                 $salarr ="SALARY ARREARS" ; 
                 $add = $this->payroll_model->getAdditionSalAreas($salaryId,$salarr,$month,$year);

                 if (empty($add)) {
                     $sal = 0;
                 } else{
                     $sal = $add->add_amount;
                 }
                 
                 $act ="ACTING ALLOWANCE" ; 
                 $acting = $this->payroll_model->getAdditionActing($salaryId,$act,$month,$year);

                 if (empty($acting)) {
                     $acta = 0;
                 } else{
                     $acta = $acting->add_amount;
                 }

                 $fuel ="FUEL ALLOWANCE" ; 
                 $fuels = $this->payroll_model->getAdditionFuel($salaryId,$fuel,$month,$year);

                 if (empty($fuels)) {
                     $fela = 0;
                 } else{
                     $fela = $fuels->add_amount;
                 }

                 $pssf ="PSSSF" ; 
                 $pssfv = $this->payroll_model->getPsssfReport($salaryId,$pssf,$month,$year);
                 if (empty($pssfv)) {
                     $pssfa = 0;
                 } else {
                     $pssfa = $pssfv->fund_amount;                                 
                 }

                 $nhif ="NHIF" ; 
                 $nhifv = $this->payroll_model->getNhifReport($salaryId,$nhif,$month,$year);
                 if (empty($nhifv)) {
                     $nhifa = 0;
                 } else {
                     $nhifa = $nhifv->ded_amount;                                 
                 }

                 $hslb ="HESLB" ; 
                 $hslbv = $this->payroll_model->getHeslbReport($salaryId,$hslb,$month,$year);
                 if (empty($hslbv)) {
                     $hslba = 0;
                 } else {
                     $hslba = $hslbv->installment_Amount;                                 
                 }

                 $zhslb ="ZHESLB" ; 
                 $zhslbv = $this->payroll_model->getZHeslbReport($salaryId,$zhslb,$month,$year);
                 if (empty($zhslbv)) {
                     $zhslba = 0;
                 } else {
                     $zhslba = $zhslbv->installment_Amount;                                 
                 }

                 $sundry ="Sundry Allowance" ; 
                 $sundryv = $this->payroll_model->getSundryReport($salaryId,$sundry,$month,$year);
                 if (empty($sundryv)) {
                     $sundrya = 0;
                 } else {
                     $sundrya = $sundryv->add_amount;                                 
                 }

                 $sha ="SHORT & ACCESS" ; 
                 $shav = $this->payroll_model->getShortAccess($salaryId,$sha,$month,$year);
                 if (empty($shav)) {
                     $shaa = 0;
                 } else {
                     $shaa = $shav->others_amount;                                 
                 }

                 $hou ="HOUSE RECOVERY" ; 
                 $houv = $this->payroll_model->getHouseRecovery($salaryId,$hou,$month,$year);
                 if (empty($houv)) {
                     $houa = 0;
                 } else {
                     $houa = $houv->others_amount;                                 
                 }

                 $salr ="SALARY RECOVERY" ; 
                 $salrv = $this->payroll_model->getSalaryRecovery($salaryId,$salr,$month,$year);
                 if (empty($salrv)) {
                     $salra = 0;
                 } else {
                     $salra = $salrv->others_amount;                                 
                 }

                 $court ="COURT ORDER" ; 
                 $courtv = $this->payroll_model->getCourtOrder($salaryId,$court,$month,$year);
                 if (empty($courtv)) {
                     $courta = 0;
                 } else {
                     $courta = $courtv->others_amount;                                 
                 }

                 $parc ="PURCHASE LOAN" ; 
                 $parcv = $this->payroll_model->getParcheLoan($salaryId,$parc,$month,$year);
                 if (empty($parcv)) {
                     $parca = 0;
                 } else {
                     $parca = $parcv->others_amount;                                 
                 }

                 $sunr ="SUNDRY ALLOWANCE RECOVERY" ; 
                 $sunrv = $this->payroll_model->getSundryRecovery($salaryId,$sunr,$month,$year);
                 if (empty($sunrv)) {
                     $sunra = 0;
                 } else {
                     $sunra = $sunrv->others_amount;                                 
                 }

                 $kkl ="KK LOAN" ; 
                 $kklv = $this->payroll_model->getKKloan($salaryId,$kkl,$month,$year);
                 if (empty($kklv)) {
                     $kkla = 0;
                 } else {
                     $kkla = $kklv->installment_Amount;                                 
                 }

                 $kkel ="KK EMERGENCY LOAN" ; 
                 $kkelv = $this->payroll_model->getKKeloan($salaryId,$kkel,$month,$year);
                 if (empty($kkelv)) {
                     $kkela = 0;
                 } else {
                     $kkela = $kkelv->installment_Amount;                                 
                 }

                 $over ="OVERTIME" ; 
                 $overtime = $this->payroll_model->getAdditionOvertime($salaryId,$over,$month,$year);

                 if (empty($overtime)) {
                     $overa = 0;
                 } else{
                     $overa = $overtime->add_amount;
                 }

                 $fuealareas ="FUEL ALLOWANCE ARREAS" ; 
                 $fuelArea = $this->payroll_model->getFuelArears($salaryId,$fuealareas,$month,$year);

                 if (empty($fuelArea)) {
                     $fuelAreaa = 0;
                 } else{
                     $fuelAreaa = $fuelArea->add_amount;
                 }

                 $tele ="TELEPHONE ALLOWANCE" ; 
                 $telev = $this->payroll_model->getTelephoneAllowance($salaryId,$tele,$month,$year);

                 if (empty($telev)) {
                     $telea = 0;
                 } else{
                     $telea = $telev->add_amount;
                 }

                 $teleareas ="TELEPHONE ALLOWANCE ARREAS" ; 
                 $teleav = $this->payroll_model->getTelephoneAllowanceAreas($salaryId,$teleareas,$month,$year);

                 if (empty($teleav)) {
                     @$televa = 0;
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
                            'sundryallowance'=>$sundrya,
                            'kkrefund'=>$ref,
                            'sanslam'=>$afric

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

              /* $sanslam = $this->payroll_model->getSanslamSum($month,$year);
               $data['sanslam'] = $sanslam->sanslam;
               $kkrefund = $this->payroll_model->getKkrefundSum($month,$year);
               $data['kkrefund'] = $kkrefund->kkrefund;


*/
                //$salaryId = $getEmid[0]->id_salary;
               $refund ="kk refund" ; 
                 $ref = $this->payroll_model->getKkRefundAreaamount($refund,$month,$year);
                 $kktotal = $this->payroll_model->getKkRefundTotalAreas($refund,$month,$year);
                 

                 $africanlife ="AFRICAN LIFE ASSURANCE" ; //SANLAM Insurance
                 $afric = $this->payroll_model->getAfricanLifeAmounts1($africanlife,$month,$year);
                 $africtotal = $this->payroll_model->getAfricanLifeTotalAmount($africanlife,$month,$year);

               $data['sanslam'] = @$afric;
               $data['sanslamtotal'] = $africtotal->africantotal;
               $data['kkrefund'] = @$ref;
               $data['kktotal'] = $kktotal->kktotal;

               $data['salary'] = $this->payroll_model->Check_Roster_Pay($month,$year);
           }
            
            $this->load->view('payroll/payroll_report',$data);
         
        } else {
            redirect(base_url(),'refresh');
        }
        
    }

    public function Paye_Chart()
  {
       if($this->session->userdata('user_login_access') != False) {

        $data['payeChart'] = $this->payroll_model->getPayeChart();
        $this->load->view('payroll/paye_chart',$data);
       }
  }

  public function Pension_Chart()
  {
       if($this->session->userdata('user_login_access') != False) {

        $data['pensionChart'] = $this->payroll_model->getPensionChart();
        $this->load->view('payroll/pension_chart',$data);
       }
  }

  public function Percent_Deduction()
  {
       if($this->session->userdata('user_login_access') != False) {

        $data['NonPercentageDeduction'] = $this->payroll_model->getPercentageDeduction();
        $this->load->view('payroll/percentage_deduction',$data);
       }
  }

  public function Non_PercentD()
  {
       if($this->session->userdata('user_login_access') != False) {

        $data['NonPercentageDeduction'] = $this->payroll_model->getNonPercentageDeduction();
        $this->load->view('backend/non_percentage_deduction',$data);
       }
  }

  public function Loan_Deduction()
  {
       if($this->session->userdata('user_login_access') != False) {

        $data['NonPercentageDeduction'] = $this->payroll_model->getLoanPermonthDeduction();
        $this->load->view('backend/loan_deduction',$data);
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

                 echo "<table id='example5' class='table table-bordered' >
                <thead>
                <tr><th>S/N.</th><th>Beneficiary Code</th><th>Beneficiary Name</th><th>Swift Code</th><th>Bank Name</th><th>Account Number</th><th>Amount</th><th>Payment Description</th><th>Title</th><th>Rate</th><th>Number Of Days</th></tr>
                </thead><tbody>";
                        $i=0;
                  foreach ($getSalaryMonth as $value) {
                     $designation = $this->payroll_model->getdesignation1($value->des_id);
                        $i++;

                        echo "<tr><td>".$i."</td><td>".$value->emp_code."</td><td>$value->holder_name</td><td>$value->swift_code</td><td>$value->bank_name</td><td>$value->account_number</td><td>".number_format($value->net_payment,2)."</td><td>Salary</td><td>$designation->des_name</td><td>".number_format($value->net_payment,2)."</td><td>1</td></tr>";


                  }
                 echo "<tr><td></td><td></td><td>Total ::</td><td>".number_format($data['sum']->total,2)."</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td>Signature</td><td>-----------------------------</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td>Signature</td><td>-----------------------------</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                   echo "</tbody>
                   </table>

                   <script type='text/javascript'>
                    $(document).ready(function() {

                var table = $('#example5').DataTable( {
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

 public function Salary_Deduction_Report()
  {
       if($this->session->userdata('user_login_access') != False) {

        $month = $this->input->get('month');
        $year = $this->input->get('year');
        $ded_type = $this->input->get('ded_type');


            if (!empty($ded_type)) {
                 // Start Deduction Procedure

              $africanlife ="AFRICAN LIFE ASSURANCE" ; //SANLAM Insurance
                 if($ded_type ==$africanlife){
                 $afric = $this->payroll_model->getAfricanLifesheet($africanlife,$month,$year);
                 if (!empty($afric)) {
                     $data['salary_info']=$salary_info  = $afric;
                 } 
               }

                  $tewuta ="TEWUTA" ;
                 if($ded_type ==$tewuta){
                 $tew = $this->payroll_model->getnonPercentagesheet($tewuta,$month,$year);
                 if (!empty($tew)) {
                     $data['salary_info']=$salary_info  = $tew;
                 } 
               }


               $cotwu ="COTWU(T)" ; 
                 if($ded_type ==$cotwu){
                 $cot = $this->payroll_model->getnonPercentagesheet($cotwu,$month,$year);
                 if (!empty($cot)) {
                     $data['salary_info']=$salary_info  = $cot;
                 } 
               }


               $kks ="KK SAVINGS" ; 
                 if($ded_type ==$kks){
                 $kk = $this->payroll_model->getnonPercentagesheet($kks,$month,$year);
                 if (!empty($kk)) {
                     $data['salary_info']=$salary_info  = $kk;
                 } 
               }

                 $wadu ="W.A.D.U" ;  
                 if($ded_type ==$wadu){
                 $wad = $this->payroll_model->getnonPercentagesheet($wadu,$month,$year);
                 if (!empty($wad)) {
                     $data['salary_info']=$salary_info  = $wad;
                 } 
               }

              $house ="HOUSE RENT" ;  
                 if($ded_type ==$house){
                 $hous = $this->payroll_model->getnonPercentagesheet($house,$month,$year);
                 if (!empty($hous)) {
                     $data['salary_info']=$salary_info  = $hous;
                 } 
               }

                $insu ="INSURANCE" ;
                 if($ded_type ==$insu){
                 $insa = $this->payroll_model->getnonPercentagesheet($insu,$month,$year);
                 if (!empty($insa)) {
                     $data['salary_info']=$salary_info  = $insa;
                 } 
               }



                 //Start of addition Procedure 
                $refund ="KK REFUND" ;
                 if($ded_type ==$refund){
                 $ref = $this->payroll_model->getKkRefundsheet($refund,$month,$year);
                 if (!empty($ref)) {
                     $data['salary_info']=$salary_info  = $ref;
                 } 
               }

                $salarr ="SALARY ARREARS" ;
                 if($ded_type ==$salarr){
                 $add = $this->payroll_model->getKkRefundsheet($salarr,$month,$year);
                 if (!empty($add)) {
                     $data['salary_info']=$salary_info  = $add;
                 } 
               }

               $act ="ACTING ALLOWANCE" ; 
                 if($ded_type ==$act){
                 $acting = $this->payroll_model->getKkRefundsheet($act,$month,$year);
                 if (!empty($acting)) {
                     $data['salary_info']=$salary_info  = $acting;
                 } 
               }

               $fuel ="FUEL ALLOWANCE" ; 
                 if($ded_type ==$fuel){
                 $fuels = $this->payroll_model->getKkRefundsheet($fuel,$month,$year);
                 if (!empty($fuels)) {
                     $data['salary_info']=$salary_info  = $fuels;
                 } 
               }


                  $pssf ="PSSSF" ; 
                 if($ded_type ==$pssf){
                 $pssfv = $this->payroll_model->getPsssfSheet($pssf,$month,$year);
                 if (!empty($pssfv)) {
                     $data['salary_info']=$salary_info  = $pssfv;
                 } 
               }

               
                 $nhif ="NHIF" ; 
                 if($ded_type ==$nhif){
                 $nhifv = $this->payroll_model->get_emp_percsheet($nhif,$month,$year);
                 if (!empty($nhifv)) {
                     $data['salary_info']=$salary_info  = $nhifv;
                 } 
               }

                 $hslb ="HESLB" ;  
                 if($ded_type == $hslb){
                 $hslbv = $this->payroll_model->get_loan_ded_sheet($hslb,$month,$year);
                 if (!empty($hslbv)) {
                     $data['salary_info']=$salary_info  = $hslbv;
                 } 
               }


               $zhslb ="ZHESLB" ;  
                 if($ded_type ==$zhslb){
                 $zhslbv = $this->payroll_model->get_loan_ded_sheet($zhslb,$month,$year);
                 if (!empty($zhslbv)) {
                     $data['salary_info']=$salary_info  = $zhslbv;
                 } 
               }





                /* $sundry ="Sundry Allowance" ; 
                 $sundryv = $this->payroll_model->getSundryReport($salaryId,$sundry,$month,$year);
                 if (empty($sundryv)) {
                     $sundrya = 0;
                 } else {
                     $sundrya = $sundryv->add_amount;                                 
                 }*/


                  $sha ="SHORT & ACCESS" ;  
                 if($ded_type ==$sha){
                 $shav = $this->payroll_model->get_loan_ded_sheet($sha,$month,$year);
                 if (!empty($shav)) {
                     $data['salary_info']=$salary_info  = $shav;
                 } 
               }


               $hou ="HOUSE RECOVERY" ;   
                 if($ded_type ==$hou){
                 $houv = $this->payroll_model->get_loan_ded_sheet($hou,$month,$year);
                 if (!empty($houv)) {
                     $data['salary_info']=$salary_info  = $houv;
                 } 
               }


                $salr ="SALARY RECOVERY" ;  
                 if($ded_type ==$salr){
                 $salrv = $this->payroll_model->get_loan_ded_sheet($salr,$month,$year);
                 if (!empty($salrv)) {
                     $data['salary_info']=$salary_info  = $salrv;
                 } 
               }



                $court ="COURT ORDER" ; 
                 if($ded_type ==$court){
                 $courtv = $this->payroll_model->get_loan_ded_sheet($court,$month,$year);
                 if (!empty($courtv)) {
                     $data['salary_info']=$salary_info  = $courtv;
                 } 
               }


                $parc ="PURCHASE LOAN" ;  
                 if($ded_type ==$parc){
                 $parcv = $this->payroll_model->get_loan_ded_sheet($parc,$month,$year);
                 if (!empty($parcv)) {
                     $data['salary_info']=$salary_info  = $parcv;
                 } 
               }



                $sunr ="SUNDRY ALLOWANCE RECOVERY" ;  
                 if($ded_type ==$sunr){
                 $sunrv = $this->payroll_model->get_loan_ded_sheet($sunr,$month,$year);
                 if (!empty($sunrv)) {
                     $data['salary_info']=$salary_info  = $sunrv;
                 } 
               }


               $kkl ="KK LOAN"; 
                 if($ded_type ==$kkl){
                 $kklv = $this->payroll_model->get_loan_ded_sheet($kkl,$month,$year);
                 if (!empty($kklv)) {
                     $data['salary_info']=$salary_info  = $kklv;
                 } 
               }

               $kkel ="KK EMERGENCY LOAN" ;  
                 if($ded_type ==$kkel){
                 $kkelv = $this->payroll_model->get_loan_ded_sheet($kkel,$month,$year);
                 if (!empty($kkelv)) {
                     $data['salary_info']=$salary_info  = $kkelv;
                 } 
               }


               $over ="OVERTIME" ;  
                 if($ded_type ==$over){
                 $overtime = $this->payroll_model->getKkRefundsheet($over,$month,$year);
                 if (!empty($overtime)) {
                     $data['salary_info']=$salary_info  = $overtime;
                 } 
               }


               $fuealareas ="FUEL ALLOWANCE ARREAS" ; 
                 if($ded_type ==$fuealareas){
                 $fuelArea = $this->payroll_model->getKkRefundsheet($fuealareas,$month,$year);
                 if (!empty($fuelArea)) {
                     $data['salary_info']=$salary_info  = $fuelArea;
                 } 
               }

               $fueal ="FUEL ALLOWANCE" ; 
                 if($ded_type ==$fueal){
                 $fuelAreas = $this->payroll_model->getKkRefundsheet($fueal,$month,$year);
                 if (!empty($fuelAreas)) {
                     $data['salary_info']=$salary_info  = $fuelAreas;
                 } 
               }


               $tele ="TELEPHONE ALLOWANCE" ; 
                 if($ded_type ==$tele){
                 $telev = $this->payroll_model->getKkRefundsheet($tele,$month,$year);
                 if (!empty($telev)) {
                     $data['salary_info']=$salary_info  = $telev;
                 } 
               }


                 $teleareas ="TELEPHONE ALLOWANCE ARREAS" ;
                 if($ded_type ==$teleareas){
                 $teleav = $this->payroll_model->getKkRefundsheet($teleareas,$month,$year);
                 if (!empty($teleav)) {
                     $data['salary_info']=$salary_info = $teleav;
                 } 
               }

             

             if (!empty($salary_info)) {

                $ded_type = strtoupper($ded_type);

                 echo "<table id='example5' class='table table-bordered' >
                <thead>
                <tr><th></th><th></th><th  colspan=2> $ded_type REPORT</th><th></th><th> </th></tr>
                <tr><th >S/N.</th><th>PF NO.</th><th>FULLNAME</th><th>Month</th><th>Year</th><th> AMOUNT</th></tr>
                </thead><tbody>";
                        $i=0;
                        $total = 0;
                  foreach ($salary_info as $value) {
                     //$designation = $this->payroll_model->getdesignation1($value->des_id);
                        $i++;
                        $total = $total + $value->add_amount;

                        echo "<tr><td>".$i."</td><td>"."PF.".$value->em_code."</td><td>$value->first_name"." "."$value->middle_name"." "."$value->last_name"."</td><td>$month</td><td>$year</td><td>".number_format($value->add_amount,2)."</td></tr>";


                  }
                  echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                 echo "<tr><td></td><td><b>Total ::</b></td><td><b>".number_format($total,2)."</b></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td>Signature</td><td>-----------------------------</td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                  echo "<tr><td></td><td>Signature</td><td>-----------------------------</td><td></td><td></td><td></td></tr>";
                   echo "</tbody>
                   </table>

                   <script type='text/javascript'>
                    $(document).ready(function() {

                var table = $('#example5').DataTable( {
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

            echo "<table id='example5' class='table table-bordered' >
                <thead>
                <tr><th>S/N.</th><th>PF NO.</th><th>FULLNAME</th><th>Month</th><th>Year</th><th> AMOUNT</th><th>TITLE</th></tr>
                </thead>";
               echo" <tbody><td colspan='6' style='color:red;text-align:center;'>No  Data yet</td></tbody>
              </table>";

              }
          }

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

// public function updateLoans()
//   {
//     $get = $this->payroll_model->get_salary_record();

//      foreach ($get as $value) {
//         //echo $value->add_name.'<br>';
//           $data = array();
//           $data = array(

//                'salary_id'=>$value->id,
//                'add_name'=>$value->add_name,
//                'add_amount'=>$value->add_amount,
//                'em_id'=>$value->emp_id
//            );

//            $this->payroll_model->Add_Emp_Fund1($data);
//      }
//   }

}
