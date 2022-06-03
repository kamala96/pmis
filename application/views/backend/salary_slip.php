<!-- 
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<body style="font-family: monospace;">
	<div class="row payslip_print" id="payslip_print">
	<div class="col-md-3"></div>
	<div class="col-md-6">
<table class="table" style="width: 100%;">
     <tr>
        <td><img src="<?php echo base_url(); ?>assets/images/tcp.jpg" width="" height=""></td>
    </tr>
    <tr style="text-align: center;">
    <td>STAFF SALARY PAYSLIP</td>
    </tr>
  </table>
  <table class="table" style="width: 100%;">
    <tr><td>For The Month of:</td><td style="text-align: right;"><?php echo $salary_info->month.'/'.$salary_info->year  ?></td></tr>
  </table>
 <table style="width: 100%;">
 	 <tr><td colspan="2">----------------------------------------------------------------------------------</td></tr>
        <tr style="">
            <td>Employee Name:
            </td>
            <td style="text-align: right;"><?php echo $salary_info->first_name.'  '.$salary_info->middle_name.'  '.$salary_info->last_name?><br>
            </td>
        </tr> 
         <tr style="">
            <td>
                Employee No:
            </td>
            <td style="text-align: right;">
                <?php echo $salary_info->em_code  ?>
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
        <tr><td colspan="2">----------------------------------------------------------------------------------</td></tr>     
</table>
<br>
 <table style="width: 100%;">
    <tr style="">
            <td><strong>PAYMENTS:</strong></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>  
        <tr><td>Basic Salary</td>
            <td></td>
            <td style="text-align: right;"> <?php echo  number_format($salary_info->total,2);?></td>
        </tr>
        <tr style="">
            <?php if(!empty($salary_info->house_allowance))
            {
            ?>
            <td>House Allowance<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->house_allowance,2);
                ?>
            </td>
            <?php
            } 
            ?>
        <tr style="">
            <?php if(!empty($salary_info->acting_allowance))
            {
            ?>
            <td>Acting Allowance<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->acting_allowance,2);
                ?>
            </td>
            <?php
            } 
            ?>
        </tr>
        <tr style="">
            <?php if(!empty($salary_info->telephone_allowance))
            {
            ?>
            <td>Telephone Allowance<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->telephone_allowance,2);
                ?>
            </td>
            <?php
            } 
            ?>
        </tr>
         <tr style="">
            <?php if(!empty($salary_info->overtime_allowance))
            {
            ?>
            <td>Overtime Allowance<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->overtime_allowance,2);
                ?>
            </td>
            <?php
            } 
            ?>
        </tr>
        <tr style="">
            <?php if(!empty($salary_info->transport_allowance))
            {
            ?>
            <td>Transport Allowance<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->transport_allowance,2);
                ?>
            </td>
            <?php
            } 
            ?>
        </tr>
        <tr style="">
            <?php if(!empty($salary_info->fuel_allowance))
            {
            ?>
            <td>Fuel Allowance<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->transport_allowance,2);
                ?>
            </td>
            <?php
            } 
            ?>
        </tr>
        <tr style="">
            <?php if(!empty($salary_info->sundry_allowance))
            {
            ?>
            <td>Sundry Allowance<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->sundry_allowance,2);
                ?>
            </td>
            <?php
            } 
            ?>
        </tr>
</table>
<table style="width: 100%;">
    <tr style="">
            <td>Gross Pay<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                ----------------<br>
                <?php
                $bsicSundry = (($salary_info->total)+($salary_info->sundry_allawance)+($salary_info->house_allowance)+($salary_info->acting_allowance)+($salary_info->telephone_allowance)+($salary_info->overtime_allowance)+($salary_info->transport_allowance)+($salary_info->fuel_allowance));
                 echo  number_format($bsicSundry,2);

                ?><br>
               ----------------
            </td>
        </tr> 
</table>
<br>
<table style="width: 100%;">
        <tr style="">
            <td><b>DEDUCTIONS:</b></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="">
            <?php if(!empty($salary_info->paye))
            {
            ?>
            <td>P.a.y.e<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->paye,2);
                ?>
            </td>
            <?php
            } 
            ?>

        </tr>
        <tr style="">
            <?php if(!empty($salary_info->nhif))
            {
            ?>
            <td>Nhif<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->nhif,2);
                ?>
            </td>
            <?php
            } 
            ?>
            
        </tr>
        <tr style="">
            <?php if(!empty($salary_info->psssf))
            {
            ?>
            <td>Psssf<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->psssf,2);
                ?>
            </td>
            <?php
            } 
            ?>
            
        </tr>
        <tr style="">
            <?php if(!empty($salary_info->insuarance_premium))
            {
            ?>
            <td>Insuarance Premium<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->insuarance_premium,2);
                ?>
            </td>
            <?php
            } 
            ?>
            
        </tr>
        <tr style="">
            <?php if(!empty($salary_info->wadu))
            {
            ?>
            <td>W.a.d.u<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->wadu,2);
                ?>
            </td>
            <?php
            } 
            ?>
            
        </tr>
    

</table>
<table style="width: 100%;">
        <tr style="">
            <?php if(!empty($salary_info->court))
            {
            ?>
            <td>Court Attatchment<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->court,2);
                ?>
            </td>
            <?php
            } 
            ?>

        </tr>
        <tr style="">
            <?php if(!empty($salary_info->thb))
            {
            ?>
            <td>T.h.b<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->thb,2);
                ?>
            </td>
            <?php
            } 
            ?>
            
        </tr>
        <tr style="">
            <?php if(!empty($salary_info->workers_union))
            {
            ?>
            <td>Workers Union<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->workers_union,2);
                ?>
            </td>
            <?php
            } 
            ?>
            
        </tr>
        <tr style="">
            <?php if(!empty($salary_info->imprest_recovery))
            {
            ?>
            <td>Imprest Recovery<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->insuarance_premium,2);
                ?>
            </td>
            <?php
            } 
            ?>
            
        </tr>
        <tr style="">
            <?php if(!empty($salary_info->pss))
            {
            ?>
            <td>Posta Saccoss<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->pss,2);
                ?>
            </td>
            <?php
            } 
            ?>
        </tr>
        <tr style="">
            <?php if(!empty($salary_info->salary_control))
            {
            ?>
            <td>&nbsp;&nbsp;Salary Control<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->salary_control,2);
                ?>
            </td>
            <?php
            } 
            ?>
        </tr>
</table>

<table style="width: 100%;">
    <tr style="">
            <?php if(!empty($salary_info->nssf))
            {
            ?>
            <td>Nssf<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                <?php
                    echo  number_format($salary_info->nssf,2);
                ?>
            </td>
            <?php
            } 
            ?>
        </tr>
        <?php foreach($othersDeductions as $value): ?>

            <tr>
            <td><?php echo $value->other_names; ?></td>
            <td style="text-align: right;"><?php echo number_format($value->installment_Amount,2);?></td>
            <td style="text-align: right;"><?php echo number_format($value->others_amount,2);?></td>
            </tr>
            <?php endforeach; ?>
    <tr style="">
            <td>Total Deduction<br>
            </td>
            <td></td>
            <td style="text-align: right;"> 
                ----------------<br>
                <?php
                $bsicSundry = (($salary_info->total)+($salary_info->sundry_allawance)+($salary_info->house_allowance)+($salary_info->acting_allowance)+($salary_info->telephone_allowance)+($salary_info->overtime_allowance)+($salary_info->transport_allowance)+($salary_info->fuel_allowance));

                $TotaDeduction = (($salary_info->imprest_recovery)+($salary_info->court)+($salary_info->salary_control)+($salary_info->pss)+($salary_info->wadu)+($salary_info->thb)+($salary_info->workers_union)+($salary_info->nhif)+($salary_info->psssf)+($salary_info->nssf)+($salary_info->insuarance_premium)+($salary_info->paye) +($salary_info->others_deduction_total)+($salary_info->salary_control));
                 echo  number_format($TotaDeduction,2);

                ?><br>
                ----------------
            </td>
        </tr> 
        <tr style="">
            <td>Net Salary<br>
            </td>
            <td style="text-align: right;" colspan="2"> 
                <?php
                $bsicSundry = (($salary_info->total)+($salary_info->sundry_allawance)+($salary_info->house_allowance)+($salary_info->acting_allowance)+($salary_info->telephone_allowance)+($salary_info->overtime_allowance)+($salary_info->transport_allowance)+($salary_info->fuel_allowance));

                $TotaDeduction = (($salary_info->imprest_recovery)+($salary_info->court)+($salary_info->salary_control)+($salary_info->pss)+($salary_info->wadu)+($salary_info->thb)+($salary_info->workers_union)+($salary_info->nhif)+($salary_info->psssf)+($salary_info->nssf)+($salary_info->insuarance_premium)+($salary_info->paye)+($salary_info->others_deduction_total));
                $netPay = ($bsicSundry - $TotaDeduction);
                 echo  number_format($netPay,2);

                ?><br>
                <b>----------------</b>
            </td>
        </tr> 
</table>

	</div>
	<div class="col-md-3"></div>
</div>
</body>

 -->

 <html>
<head>
  

<script language="javascript" type="text/javascript">
$(function() {
  $("#PrintButton").click( function() {
      $('#divToPrint').jqprint();
      return false;
  });
});
</script>
</head>
<body>
<input id="PrintButton" type="button" name="Print" value="Print" />

<div id="divToPrint" class="test">
Print Me, I'm in DIV
</div>
</body>
</html>

<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.1.min.js" > </script>