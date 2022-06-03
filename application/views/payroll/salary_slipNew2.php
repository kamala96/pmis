<!DOCTYPE html>
<html>
<head>
    <title>Tanzania Posts Coparetion</title>
    
</head>
<body style="text-align: center;font-family: monospace; background-size: 100%;text-transform: uppercase;font-size: 10px;background-image:url('assets/images/background.png');">
<div class="table-responsive" style="text-align: center; ">
    <div class="row">
        <div class="col-md-2"></div>
       
             <table class="table" style="width: 100%;text-align: center;">
     <tr>
        <th style=""><img src="assets/images/tcp.png" width="80" height="80"></th></tr>
        <tr><th><h1>Tanzania Posts Corporation</h1></th></tr>
  
    <tr>
    <th>STAFF SALARY PAYSLIP</th>
    </tr>
  </table>
  <br>
  <div class="col-md-6" style="padding-left: 100px;">
   <table class="table" style="width: 80%;">
    <tr><td>For The Month of:</td><td colspan="2" style="text-align: right;"><?php echo $salary_info->month.'/'.$salary_info->year  ?></td></tr>
  </table>
   <table class="table" style="width: 80%;">
    
    <tr>
        <th>--------------------------------------------------------------------------------</th>
    </tr>
    
  </table>
 <table style="width: 80%;">
        <tr style="">
            <td>
                Employee Name:
            </td>
            <td style="text-align: right;"><?php echo $salary_info->first_name.'  '.$salary_info->middle_name.'  '.$salary_info->last_name?>
            </td>
        </tr>       
        <tr style="">
            <td>
                Employee No:
            </td>
            <td style="text-align: right;">
                <?php echo $salary_info->em_code  ?><br>
            </td>
        </tr>                               
        <tr style="">
            <td>
                Department:
            </td>
            <td style="text-align: right;">
                <?php
                 $dep_id = $salary_info->dep_id;
                 $depvalue1 = $this->employee_model->getdepartment1($dep_id);echo $depvalue1->dep_name . '  ' .$salary_info->em_region;
                ?>
            </td>
        </tr>      
</table>
 <table class="table" style="width: 80%;">
    <th>--------------------------------------------------------------------------------</th>
  </table>
 
  <table style="width: 80%;">
    <tr style="">
            <td><strong>PAYMENTS:</strong></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>  
        <tr>
            <td>Basic Salary</td>
            <td></td>
            <td style="text-align: right;"> <?php echo  number_format($salary_info->basic_payment,2);?></td>
        </tr>

        <?php //echo json_encode($TaxAddition);?>
        <?php foreach($TaxAddition as $value): ?>

            <tr>
            <td><?php echo $value->add_name; ?></td>
            <td></td>
            <td style="text-align: right;"><?php echo number_format($value->add_amount,2);?></td>
            </tr>
        <?php endforeach; ?>
       
        
</table>
<table style="width: 80%;">
    <tr style="">
            <td>Total <br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                ----------------<br>
                <?php
                $bsicSundry = (($salary_info->basic_payment)+($salary_info->addition_total));
                 echo  number_format($bsicSundry,2);

                ?><br>
               ----------------
            </td>
        </tr> 
</table>
<table style="width: 80%;">
    <tr style="">
            <td><strong>NON TAXABLE ALLOWANCE:</strong></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>  
        
        <?php //echo json_encode($Additional);?>
        <?php foreach($NonTaxAddition as $value): ?>

            <tr>
            <td><?php echo $value->add_name; ?></td>
            <td></td>
            <td style="text-align: right;"><?php echo number_format($value->add_amount,2);?></td>
            </tr>
        <?php endforeach; ?>
       
        
</table>
<table style="width: 80%;">
    <tr style="">
            <td>Gross Pay<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                ----------------<br>
                <?php
                $bsicSundry = (($salary_info->basic_payment)+($salary_info->addition_total)+ ($salary_info->nonTaxAddition_total));
                 echo  number_format($bsicSundry,2);

                ?><br>
               ----------------
            </td>
        </tr> 
</table>
<table style="width: 80%;">
    <tr style="">
            <td><strong>DEDUCTIONS:</strong></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr> 
      
            <tr>
            <td>P.A.Y.E</td>
            <td></td>
            <td style="text-align: right;"><?php 
            echo number_format($salary_info->paye,2);
            ?></td>
            </tr>
            
            <tr>
            <td><?php echo $salary_info->pension_name; ?></td>
            <td></td>
            <td style="text-align: right;"><?php 
                if ($salary_info->pension_fund == 0) {
                    
                } else {
                   echo number_format($salary_info->pension_fund,2);
                }
                
            ?></td>
            </tr>
             <tr>
            <td><?php echo @$assAfrica->ded_name; ?></td>
            <td></td>
            <td style="text-align: right;"><?php 
                if (@$assAfrica->ded_amount == 0) {
                    
                } else {
                   echo number_format($assAfrica->ded_amount,2);
                }
                
            ?></td>
            </tr>
            
       <!--  <?php foreach($NonTaxDeduction1 as $value): ?>

            <tr>
            <td><?php echo $value->ded_name; ?></td>
            <td></td>
            <td style="text-align: right;"><?php echo number_format($value->ded_amount,2);?></td>
            </tr>
        <?php endforeach; ?> -->

        <?php foreach($TaxDeduction as $value): ?>

            <tr>
            <td><?php echo $value->ded_name; ?></td>
            <td></td>
            <td style="text-align: right;"><?php echo number_format($value->ded_amount,2);?></td>
            </tr>
        <?php endforeach; ?>

         <?php foreach($NonPercentageDeduction as $value): ?>

            <tr>
            <td><?php echo $value->ded_name; ?></td>
            <td></td>
            <td style="text-align: right;"><?php echo number_format($value->ded_amount,2);?></td>
            </tr>
        <?php endforeach; ?>
        <?php  foreach($LoanDeduction as $value): ?>
          
            <?php if($value->others_amount == 0 && $value->status == "COMPLETE" ){ ?>
            <?php }else{ ?>
            <tr>
            <td><?php echo $value->other_names; ?></td>
            <td style="text-align: right;"><?php if ($value->others_amount < 0) {
               echo number_format(0,2);
            } else {
                echo number_format($value->others_amount,2);
            }
            ?>
            </td>
        <td style="text-align: right;"><?php echo number_format($value->installment_Amount,2);?></td>
            </tr>
        <?php }?>
            
        <?php endforeach; ?>
        
        <tr style="">
            <td><b>Total Deduction</b><br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                ----------------<br>
                <?php
                $TotaDeduction = ($salary_info->others_deduction_total + $salary_info->percentage_deduction_total + $salary_info->nonpercentage_deduction_total + $salary_info->paye + $salary_info->pension_fund + @$assAfrica->ded_amount);
                 echo  number_format($TotaDeduction,2);

                ?><br>
                ----------------
            </td>
        </tr> 
        <tr style="">
            <td><b>Net Salary <?PHP //echo json_encode($LoanDeduction);?></b><br>
            </td>
            <td style="text-align: right;" colspan="2"> 
                <?php
                if (!empty($taxtRelief)) {
                     $gross_pay = (($salary_info->basic_payment)+($salary_info->addition_total)+ ($salary_info->nonTaxAddition_total));
                $TotaDeduction = ($salary_info->others_deduction_total + $salary_info->percentage_deduction_total + $salary_info->nonpercentage_deduction_total + $salary_info->paye + $salary_info->pension_fund + @$assAfrica->ded_amount);
                 echo  number_format(($gross_pay-$TotaDeduction + $taxtRelief->amount),2);
                } else {
                     $gross_pay = (($salary_info->basic_payment)+($salary_info->addition_total)+ ($salary_info->nonTaxAddition_total));
                $TotaDeduction = ($salary_info->others_deduction_total + $salary_info->percentage_deduction_total + $salary_info->nonpercentage_deduction_total + $salary_info->paye + $salary_info->pension_fund + @$assAfrica->ded_amount);
                 echo  number_format(($gross_pay-$TotaDeduction),2);
                }
                
               
                ?><br>
                <b>----------------</b>
            </td>
        </tr> 
        <tr style="">
            <td><br>
            </td>
            <td style="text-align: right;" colspan="2"> 
            </td>
        </tr> 
        <tr style="">
            <td><b>SUMMARY</b><br>
            </td>
            <td style="text-align: right;" colspan="2"> 
                
            </td>
        </tr> 
        <tr><td colspan="3">-------</td></tr>
        <tr>
            <td>TAXABLE PAYE</td>
            <td></td>
            <td style="text-align: right;"><?php 
             $basicSundry = (($salary_info->basic_payment - @$assAfrica->ded_amount)+($salary_info->addition_total));
             echo number_format($basicSundry-$salary_info->pension_fund,2);?></td>
            </tr>
        <!-- <?php foreach($NonTaxAddition as $value): ?>

            <tr>
            <td><?php echo $value->add_name; ?></td>
            <td></td>
            <td style="text-align: right;"><?php echo number_format($value->add_amount,2);?></td>
            </tr>
        <?php endforeach; ?> -->
        
            <tr>
            <td>LIABLE P.A.Y.E</td>
            <td></td>
            <td style="text-align: right;"><?php 
            if (empty($taxtRelief)) {
                 echo number_format(($salary_info->paye),2);
        
            } else {
               echo number_format(($salary_info->paye - $taxtRelief->amount),2);
            }
            ?>
            </td>
            </tr>
            <?php if(empty($taxtRelief)){ ?>


            <?php }else{?>
                <tr>
            <td>TAX RELIEF</td>
            <td></td>
            <td style="text-align: right;"><?php echo number_format(($taxtRelief->amount),2);?></td>
            </tr>
            <?php }?>
            
         <tr style="">
            <td><br>
            </td>
            <td style="text-align: right;" colspan="2"> 
            </td>
        </tr> 
        <tr style="">
            <td><b>COMMULATIVE SAVINGS AS AT:</b><br>
            </td>
            <td><b><?php echo $salary_info->month.'/'.$salary_info->year  ?></b></td>
            <td style="text-align: right;" colspan=""> 
            </td>
        </tr> 

        <tr><td colspan="3">------------------------------------------</td></tr>





           <!--  <tr>
            <td><?php echo $assAfrica->ded_name; ?></td>
            <td></td>
            <td style="text-align: right;"><?php 
                if ($assAfrica->ded_amount == 0) {
                    
                } else {
                   echo number_format($assAfrica->ded_amount,2);
                }
                
            ?></td>
            </tr> 
 -->
            




        <?php foreach($NonTaxDeduction1 as $value): ?>

            <tr>
            <td><?php if ($value->ded_name == "TEWUTA" || $value->ded_name == "COTWU(T)") {
               
            } else {
                echo $value->ded_name; 
            }
             ?></td>
            <td></td>
            <td style="text-align: right;"><?php 
            if ($value->ded_name == "TEWUTA" || $value->ded_name == "COTWU(T)") {
               
            } else {

                $ded_name = $value->ded_name;
                $month = $salary_info->month;
                $year = $salary_info->year;
                $salary_id = $value->salary_id;
                $total = $this->payroll_model->getSumNonTaxDeduction($ded_name,$month,$year,$salary_id);
                if (empty($total)) {
                    
                } else {
                    echo number_format($total->ded_amount,2);
                }
                
            }
                
            ?></td>
            </tr>
        <?php endforeach; ?>
        <?php foreach($TaxDeduction as $value): ?>
                <tr>
            <td><?php 
            if ($value->ded_name == "NHIF") {
                
            } else {

              echo $value->ded_name;
            }
            ?></td>
            <td></td>
            <td style="text-align: right;"><?php 
            if($value->ded_name == "NHIF"){

            }else{
                
                $ded_name = $value->ded_name;
                $month = $salary_info->month;
                $year = $salary_info->year;
                $salary_id = $value->salary_id;
                $total = $this->payroll_model->getSumTaxDeduction($ded_name,$month,$year,$salary_id);
                 echo number_format(@$total->ded_amount,2);
            }
           ?></td>
            </tr>
        <?php endforeach; ?>
            
            <?php if(!empty($pensionFund)){ ?>

            <tr>
            <td>PSSSF</td>
            <td></td>
            <td style="text-align: right;"><?php echo number_format(@$pensionFund->amount,2);?></td>
            </tr>
        <?php }else{?>
            
        <?php }?>








        
</table>
        </div>
        <div class="col-md-2"></div>
    </div>
 

</div> 
</body>
</html>