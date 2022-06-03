<?php ini_set('memory_limit', '-1'); ?>
<!DOCTYPE html>
<html>
<head>
    <title> LEAVE REPORT SUMMARY  </title> 
<style>
#t01 th, 
#t01 td {
  border: 1px solid black;
  padding: 5px;
}
#t01 {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
</head>
<body style="text-align: center;font-family: monospace; background-size: 100%;">
   <table class="table" style="width: 100%;">
        <th style="text-align: center;">
    <!-- <img src="assets/images/tcp.png" width="130" height="80"> -->
      <img src="assets/images/tcp.png" height="100px" width="200px"/>
    </th>
  </table>
             <table class="table" style="width: 100%;text-align: center;">
       <th><b style="font-size: 20px;">TANZANIA POSTS CORPORATION</b></th>
    </tr>
  </table>
  <table class="table" style="width: 100%; text-align: center;">
    <tr><th>  <?php echo strtoupper(@$status); ?> LEAVE REPORT </th>
    </tr>
  </table>
  </table>
      <table class="table" style="width: 100%; text-align: center;">
    <tr><th>   From: <?php echo date("d/m/Y",strtotime($fromdate)); ?> To: <?php echo date("d/m/Y",strtotime($todate)); ?> </th>
    </tr>
  </table>
  <br>
  
  <table style="border-bottom: solid; 1px;border-top: solid;1px;width: 100%;font-size: 14px;">
      <tr>
          <td>Telegraphic Address: POSTGEN</td>
          <td style="text-align: right;">POSTMASTER GENERAL</td>
      </tr>
      <tr>
          <td>Telex  : 41008 POSTGEN</td>
          <td style="text-align: right;">P.O.BOX  9551</td>
      </tr>
      <tr>
          <td>Telephone: (022)2118280 Fax (022)2113081</td>
          <td style="text-align: right;">DAR ES SALAAM</td>
      </tr>
      <tr>
          <td>Email: pmg@posta.co.tz</td>
          <td></td>
      </tr>
      <tr>
          <td>Website : www.posta.co.tz</td>
          <td></td>
      </tr>
  </table>

  <br>
  
   <table style="width: 100%;font-size: 14px;">
      <tr>
          <td style="text-align: right;"> Status: <?php echo strtoupper(@$status);?> Printed date: <?php echo date('d/m/Y');?>  </td>
      </tr>
  </table>
                            <table style="width: 100%;font-size: 14px;" id="t01">

                           
                          <thead>
                                    <tr>
                                        <th>Employee PF Number</th>
                                        <th>Employee Names</th>
                                       <!--  <th>Department</th>
                                        <th>Designation</th> -->
                                        <th>Leave Type</th>
                                        <th>Leave Duration</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                         <th>Approver </th>
                                        <th>Designation</th>
                                     
                                    </tr>
                                </thead>
                            <tbody style="color:green" class="leave2">

                              <?php 
                               foreach ($reports as $key => $value) {
                                    //$des_id = $value->des_id;
                                    // $desvalue = $this->employee_model->getdesignation1($des_id);

                                    // $dep_id = $value->dep_id;
                                    // $dep_value = $this->employee_model->getdepartment1($dep_id);

                                                                    $approver = "";
                                            $approverDes = "";
                                            $approvers = null;
                                            if(empty($approvers)){
                                              if($value->isPMG){
                                                //get pmg
                                                $RoleName="PMG";
                                                if(!empty($value->PMG_emid)){
                                                   $emid = $value->PMG_emid;
                                                                 $basic = $this->employee_model->GetStaffByRoleEmid($emid,$RoleName);
                                                   $approver = 'PF '.$basic->em_code.' '.$basic->first_name.'  '.$basic->middle_name.'  '.$basic->last_name;
                                                   $approverDes = $basic->des_name;

                                                }else{
                                                   //$emid = "Mze1468";
                                                    //$basic = $this->employee_model->GetStaffByRoleEmid($emid,$RoleName);
                                                   $basic = $this->employee_model->GetStaffByRole($RoleName);
                                                   $approver = 'PF '.$basic->em_code.' '.$basic->first_name.'  '.$basic->middle_name.'  '.$basic->last_name;
                                                    $approverDes = $basic->des_name;
                                                }


                                              }elseif ($value->isGMCRM) {
                                                //get CRM
                                                $RoleName="CRM";
                                                if(!empty($value->GMCRM_emid)){
                                                   $emid = $value->GMCRM_emid;
                                                                 $basic = $this->employee_model->GetStaffByRoleEmid($emid,$RoleName);
                                                   $approver = 'PF '.$basic->em_code.' '.$basic->first_name.'  '.$basic->middle_name.'  '.$basic->last_name;
                                                    $approverDes = $basic->des_name;

                                                }else{
                                                 // $emid = "Mze1468";
                                                    //$basic = $this->employee_model->GetStaffByRoleEmid($emid,$RoleName);
                                                   $basic = $this->employee_model->GetStaffByRole($RoleName);
                                                   $approver = 'PF '.$basic->em_code.' '.$basic->first_name.'  '.$basic->middle_name.'  '.$basic->last_name;
                                                    $approverDes = $basic->des_name;
                                                }
                                              }
                                              elseif ($value->isGMBOP) {
                                                //get BOP
                                                $RoleName="BOP";
                                                if(!empty($value->GMBOP_emid)){
                                                   $emid = $value->GMBOP_emid;
                                                                 $basic = $this->employee_model->GetStaffByRoleEmid($emid,$RoleName);
                                                   $approver = 'PF '.$basic->em_code.' '.$basic->first_name.'  '.$basic->middle_name.'  '.$basic->last_name;
                                                    $approverDes = $basic->des_name;

                                                }else{
                                                   //$emid = "Mze1468";
                                                   // $basic = $this->employee_model->GetStaffByRoleEmid($emid,$RoleName);
                                                   $basic = $this->employee_model->GetStaffByRole($RoleName);
                                                   $approver = 'PF '.$basic->em_code.' '.$basic->first_name.'  '.$basic->middle_name.'  '.$basic->last_name;
                                                    $approverDes = $basic->des_name;
                                                }
                                              }
                                              elseif ($value->isHR) {
                                                //get HR
                                                $RoleName="HR";
                                                if(!empty($value->HR_emid)){
                                                   $emid = $value->HR_emid;
                                                                 $basic = $this->employee_model->GetStaffByRoleEmid($emid,$RoleName);
                                                   $approver = 'PF '.$basic->em_code.' '.$basic->first_name.'  '.$basic->middle_name.'  '.$basic->last_name;
                                                    $approverDes = $basic->des_name;

                                                }else{
                                                   $emid = 'Mze1468';

                                                   $RoleName="HR-PAY";
                                                    $basic = $this->employee_model->GetStaffByRoleEmid($emid,$RoleName);
                                                   //$basic = $this->employee_model->GetStaffByRole($RoleName);
                                                     $approver = 'PF '.$basic->em_code.' '.$basic->first_name.'  '.$basic->middle_name.'  '.$basic->last_name;
                                                    $approverDes = $basic->des_name;
                                                }
                                              }
                                              // elseif ($value->isHOD) {
                                              //  //get HOD
                                              //  $RoleName="HOD";
                                              //  if(!empty($value->HOD_emid)){
                                              //     $emid = $value->HOD_emid;
                                         //                         $basic = $this->employee_model->GetStaffByRoleEmid($emid,$RoleName);
                                              //     $approver = 'PF '.$basic->em_code.' '.$basic->first_name.'  '.$basic->middle_name.'  '.$basic->last_name;
                                              //      $approverDes = $basic->des_name;

                                              //  }else{
                                              //     $basic = $this->employee_model->GetStaffByRole($RoleName);
                                              //     $approver = 'PF '.$basic->em_code.' '.$basic->first_name.'  '.$basic->middle_name.'  '.$basic->last_name;
                                              //      $approverDes = $basic->des_name;
                                              //  }
                                              // }


                                            }



                                    ?>

                                  <!--   echo "<tr>
                                                    <td>$value->em_code</td>
                                                    <td>$value->first_name $value->middle_name $value->last_name </td>
                                                    <td>$dep_value->dep_name</td>
                                                    <td>$desvalue->des_name</td>
                                                    <td>$value->name</td>
                                                    <td>$value->leave_duration Days</td>
                                                    <td>$value->start_date</td>
                                                    <td>$value->end_date</td>
                                                </tr>";
                                  } }?> -->


                                 
                                  <tr>
                                                    <td><?php echo $value->em_code; ?> </td>
                                                    <td><?php echo $value->first_name.' '.$value->middle_name.' '.$value->last_name ; ?> </td>
                                                   <!--  <td><?php echo $dep_value->dep_name; ?> </td>
                                                    <td><?php echo $desvalue->des_name; ?> </td> -->
                                                    <td><?php echo $value->name; ?> </td>
                                                    <td><?php echo $value->leave_duration.' '.'Days'; ?> </td>
                                                    <td><?php echo $value->start_date; ?> </td>
                                                    <td><?php echo $value->end_date; ?> </td>
                                                      <td> <?php echo $approver; ?></td>
                                                       <td> <?php echo $approverDes; ?></td>
                                                </tr>
                                  <?php  } //}?>

                                </tbody>

</table>
</body>
</html>