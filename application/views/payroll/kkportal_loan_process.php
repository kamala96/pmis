<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 

         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Loan Process  </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Payroll </li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">

                    <div class="col-12">

                    <div class="card card-outline-info">
                  
                            <div class="card-body">

                            <?php 
                            if(!empty($this->session->flashdata('message'))){
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
                                      <?php echo $this->session->flashdata('message'); ?>
                                      <?php
                            echo "</div>";
                            
                            }
                            ?>
                            
                            <form class="row" method="get" action="<?php echo site_url('Payroll/kkportal_loanprocess_results');?>">
                                    <div class="form-group col-md-3 m-t-10">
                                    <input type="date" name="fromdate" class="form-control"  required="required">
                                    </div>
                                    
                                    <div class="form-group col-md-3 m-t-10">
                                         <input type="date" name="todate" class="form-control"  required="required">
                                    </div>

                                    <div class="form-group col-md-3 m-t-10">
                                    <select class="form-control" required="required" name="status">
                                    <option value="Accepted"> Pending </option>
                                    <option value="Approved"> Approved </option>
                                    </select>
                                    </div>
                                    
                                    <div class="form-group col-md-3 m-t-10">
                                         <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> Search </button>
                                    </div>
                            </form>

                              <?php if(isset($list)){ ?>

                                   <div class="table table-responsive">
                                   <table class="table table-bordered International text-nowrap" width="100%" style="text-transform: capitalize;">
                                        <thead>
                                            <tr>
                                                   <th> S/N </th>
                                                    <th> PF No. </th>
                                                    <th> Employee Name </th>
                                                    <th> Loan </th>
                                                    <th> Principal </th>
                                                    <th> Interest </th>
                                                    <th> Insurance </th>
                                                    <th> Loan Period </th>
                                                    <th> Date Taken </th>
                                                    <th> Total Taken </th>
                                                    <th> Monthly Deduction </th>
                                                    <th> Requested date  </th>
                                                    <th> Status </th>
                                                    <th> Action  </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       <?php  
                                       $sn=1;
                                       foreach ($list as $row) {  ?>
                                        <tr>
                                                    <td> <?php echo $sn; ?></td>
                                                    <td> <?php echo @$row->em_code; ?> </td>
                                                    <td><?php echo @$row->first_name.' '.@$row->middle_name.' '.@$row->last_name; ?> </td>
                                                    <td>  <?php echo $row->loan_product; ?></td>
                                                    <td> <?php  echo number_format(@$row->principal,2); ?> </td>
                                                    <td> <?php  echo number_format(@$row->interest,2); ?> </td>
                                                    <td> <?php  echo number_format(@$row->insurance,2); ?> </td>
                                                    <td> <?php $loanperiod =  @$row->loan_period; echo @$loanperiod; ?> </td>

                                                    <td> <?php if($row->type=="new"){ echo $row->date_taken; } else { } ?> </td>


                                            <td> <?php $totaltaken = $row->principal+$row->interest+$row->insurance; echo number_format($totaltaken,2); ?> </td>


                                            <td> <?php  if($loanperiod==0){ } else { echo number_format($totaltaken/$loanperiod,2); }  ?> </td>
                                                    


                                                    <td> <?php echo $row->request_created_at; ?> </td>


                                                    <td>  
                                                    <?php if($row->request_status=="Accepted"){?>
                                                    <button class="btn btn-danger btn-sm"> Pending </button> 
                                                    <?php } else { ?>
                                                    <button class="btn btn-danger btn-sm"> <?php echo $row->request_status; ?> </button> 
                                                    <?php } ?>
                                                    </td>
                                                    <td>
                                    <?php if($row->type=="new" && $row->request_status=="Accepted"){?>

                                    <button class="btn btn-primary btn-sm" data-toggle="modal" type="button" data-target="#update_modal<?php echo $row->loan_process_id; ?>"> <i class="fa fa-check"></i> Approve </button>
                                    <?php } ?>
                                                    </td>

                                       </tr>
                                       <?php $sn++; ?>

                                       <!-- Edit -->
                        <div class="modal fade" id="update_modal<?php echo $row->loan_process_id; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel"> Approve/Decline Loan Process of  <?php echo $row->first_name.' '.$row->middle_name.' '.$row->last_name;  ?>  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                                        
                        <div class="modal-body"> 
            
                    <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Payroll/update_kkportal_loan_process');?>">
                    
                    <input type="hidden" class="form-control" name="processid" value="<?php echo $row->loan_process_id; ?>" required>
                    <input type="hidden" class="form-control" name="em_code" value="<?php echo $row->em_code; ?>" required>
                     <input type="hidden" class="form-control" name="others_names" value="<?php echo $row->loan_product; ?>" required>
                      <input type="hidden" class="form-control" name="loan_amount" value="<?php echo $totaltaken; ?>" required>
                       <input type="hidden" class="form-control" name="loan_deduction_amount" value="<?php if($row->loan_period==0){} else { echo $totaltaken/$loanperiod; }?>" required>
                    
                   <div class="form-group row">
                   <div class="col-12">
                                    <select class="form-control" required="required" name="status">
                                    <option value="Canceled"> Cancel </option>
                                    <option value="Approved"> Approve </option>
                                    </select>
                    </div>
                    </div>
                     
                     
                    <div class="form-group row">
                    <div class="col-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="update"> Update </button>
                    </div>
                    </div>
                            
                     </form>
                      
                        </div>
                       </div>
                       </div>
                    </div>
                 <!-- End -->

                                       <?php } ?> 
   
                                        </tbody>
                                    </table>
                                    </div>
                               <?php } ?>


               
                               
                               
                            </div>
                        </div>
                    </div>
                </div>
<script type="text/javascript">
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>

<script type="text/javascript">
$(document).ready(function() {

var table = $('#example4').DataTable( {
    order: [[1,"desc" ]],
    //orderCellsTop: true,
    fixedHeader: true,
    ordering:false,
    lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    dom: 'lBfrtip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ]
} );
} );
</script>

<script type="text/javascript">
$(document).ready(function() {

var table = $('.International').DataTable( {
    order: [[1,"desc" ]],
    //orderCellsTop: true,
    fixedHeader: true,
    ordering:false,
    lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    dom: 'lBfrtip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ]
} );
} );
</script>


<script type="text/javascript">
function printContent(el)
{
  var restorepage = document.body.innerHTML;
  var printcontent = document.getElementById(el).innerHTML;
  document.body.innerHTML = printcontent;
  window.print();
  document.body.innerHTML = restorepage;
}
</script>
    <?php $this->load->view('backend/footer'); ?>