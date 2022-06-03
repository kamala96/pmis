/for loop for generating salary for each employee.......
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
        $getTotal['PensionDeduction']= $this->payroll_model->getPensionDeduction($salary_id);

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

        foreach ($getTotal['PensionDeduction'] as $value) {
           $percent1 = $value->fund_percent;
           $fund_id = $value->fund_id;

           $data2 = array();
            $data2 = array(
                        'fund_amount'=>$percent1 * $basic_total
            );
        $this->payroll_model->updatePensionDeduction($fund_id, $data2);
        }
        

        
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
            $basic_totalAdd = $before - $checkAss->ded_amount + $TotalAddition;

        }
        

        if ($basic_totalAdd <= 170000) {

            $paye = 0;
            $gross_payment = (($basic_totalAdd) + ($totalNonTaxAddition));

        }
        if ($basic_totalAdd >= 170000 && $basic_totalAdd <= 360000) {

           $paye = ($basic_totalAdd - 170000) * 0.09;
           $gross_payment = (($basic_totalAdd) + ($totalNonTaxAddition));
        }
        if ($basic_totalAdd >= 360000 && $basic_totalAdd <= 540000) {

           $paye = 17100 + ($basic_totalAdd - 360000) * 0.2;
           $gross_payment = (($basic_totalAdd) + ($totalNonTaxAddition));
        }
        if ($basic_totalAdd >= 360000 && $basic_totalAdd <= 540000) {

           $paye = 17100 + ($basic_totalAdd - 360000) * 0.2;
           $gross_payment = (($basic_totalAdd) + ($totalNonTaxAddition));
        }
        if ($basic_totalAdd >= 540000 && $basic_totalAdd <= 720000) {

           $paye = 53000 + ($basic_totalAdd - 540000) * 0.25;
           $gross_payment = (($basic_totalAdd) + ($totalNonTaxAddition));
        }
        if ($basic_totalAdd >= 720000 ) {

           $paye = 98100 + ($basic_totalAdd - 720000) * 0.3;
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
                        'bank_name'=>$bankIfo->bank_name
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

                    $message = "Has already been paid";

                }
                } else {
                    $this->payroll_model->insertPaidSalaryData($data);
                    $lastId = $this->db->insert_id();
            $data['othersDeductions'] = $this->payroll_model->Others_Employee_Deduction($salary_id);
             foreach ($data['othersDeductions'] as $value) {

                $installmentName = $value->other_names;
                $lastInstallement = $this->payroll_model->Others_Employee_Deduction_Permonth($installmentName);

                if (!empty($lastInstallement)) {

                        $data1 = array();
                        $data1 = array(
                        'pay_id' =>$lastId ,
                        'emp_id' =>$em_code , 
                        'other_names' =>$value->other_names ,
                        'others_amount' =>$value->others_amount + $lastInstallement->others_amount ,
                        'deduction_month' =>$monthName ,
                        'deduction_year' =>date('Y'),
                        'installment_permonth' => $value->installment_Amount - $value->others_amount 
                            );
                } else {

                        $data1 = array();
                        $data1 = array(
                        'pay_id' =>$lastId ,
                        'emp_id' =>$em_code , 
                        'other_names' =>$value->other_names ,
                        'others_amount' =>$value->others_amount ,
                        'deduction_month' =>$monthName ,
                        'deduction_year' =>date('Y'),
                        'installment_permonth' => $value->installment_Amount - $value->others_amount
                              );
                }
        $this->payroll_model->insertOthersDeductionData($data1);

            $total = ($value->installment_Amount - $value->others_amount);
            if ($total == 0) {
               $id = $value->others_id;
            $data2 = array();
            $data2 = array(
                'installment_Amount'=>$total,
                        'status'=>'COMPLETE'
            );
            $this->payroll_model->updateOthersDeduction($id, $data2);

            } else {

            $id = $value->others_id;
            $data2 = array();
            $data2 = array(
                        'installment_Amount'=>$total
            );
            $this->payroll_model->updateOthersDeduction($id, $data2);
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

        $message = "Successfully Added";   
    }