<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Legal Section</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Legal Section</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    <a href="<?php echo base_url() ?>Box_Application/Legal" class="btn btn-primary"><i class="fa fa-plus"></i> Add Contract</a>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>organization/Contract" class="text-white"><i class="" aria-hidden="true"></i> Contract Type</a></button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>organization/Agreement" class="text-white"><i class="" aria-hidden="true"></i> Agreement Type</a></button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Contract_list" class="text-white"><i class="" aria-hidden="true"></i> Contract List</a></button>

                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Contract List                       
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                            <div id="div1" class="table-responsive"> 
                            <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Registered Date</th>
                                                <th>Contract Type</th>
                                                <th>Agreement Type</th>
                                                <th>Parties Name</th>
                                                <th>Mobile Number</th>
                                                <th>Region</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Mode Of Payment</th>
                                                <th>Price (Tsh.)</th>
                                                <th>Scanned Document</th>
                                                <th>Status</th>
                                                <th style="text-align: right;">Action</th>
                                               
                                            </tr>
                                        </thead>
                                        
                                 <tbody class="results">
                                   <?php foreach ($contract as  $value) {?>
                                    <tr>
                                        <td><?php echo $value->registered_date ?></td>
                                        <td><?php echo $value->cont_name ?></td>
                                        <td><?php echo $value->agreement_type ?></td>
                                         <td><?php echo $value->parties_name;?></td>
                                         <td><?php echo $value->mobile ?></td>
                                         <td><?php echo $value->region ?></td>
                                        <td><?php 
                                        if ($value->start_date == '') {
                                               
                                            } else {
                                                 echo date('jS \of F Y',strtotime($value->start_date));
                                            }
                                            
                                        ?>
                                        </td>
                                        <td><?php 

                                            if ($value->start_date == '') {
                                               
                                            } else {
                                                 echo date('jS \of F Y',strtotime($value->end_date));
                                            }
                                        
                                        ?></td>
                                       
                                        
                                        <td><?php echo $value->mode_payment ?></td>
                                        <td><?php echo number_format($value->cont_price) ?></td>
                                        <td><a href="http://hrmis.posta.co.tz/assets/images/users/<?php echo $value->scann_docu; ?>"><?php echo $value->scann_docu ?></a></td>
                                        
                                        <td>
                                            <?php 

                                              $startYear= $value->start_date;
                                              $year1=date('Y', strtotime($startYear));
                                              $year =date('Y', strtotime($startYear));
                                              $yearDays = 366;
                                              $todayDays =  date('z', strtotime($year1)) + 1;
                                              $dayDiff = $yearDays - $todayDays;
                                              
                                             if ($dayDiff == 100) {
                                                 
                                                 echo "<button class='btn btn-warning btn-sm'>Renew Contract</button>";
                                             }else{
                                                if ($value->status == 'ACTIVE') {
                                                echo "<button class='btn btn-success btn-sm'>Active Contract</button>";
                                                }elseif($value->status == 'CANCEL'){
                                                     echo "<button class='btn btn-danger btn-sm'>Canceled Contract</button>";
                                                }elseif($value->status == 'IsPMG'){
                                                     echo "<button class='btn btn-success btn-sm'>GMBOP /GMCRM Signed</button>";
                                                }elseif($value->status == 'IsComplete'){
                                                     echo "<button class='btn btn-success btn-sm'>Completed Contract</button>";
                                                }else{

                                                    echo "<button class='btn btn-info btn-sm'>Signed By Legal</button>";
                                                }
                                             }
                                            ?>
                                            
                                        </td>
                                        <td style="text-align: right;">

                                            <!-- <input type="hidden" name="" class="contId" value="<?php echo $value->contid ?>"> -->
                                            <?php
                                                if ($value->status == 'CANCEL') {
                                                  
                                                }else{
                                                    echo "
                                            <a href='#' class='btn btn-info btn-sm myBtn' data-contid='$value->contid'>Status</a> | <a href ='Legal?I=".base64_encode($value->contid)."' class='btn btn-warning btn-sm'>Edit</a>";
                                                }
                                            ?>
                                            
                                        </td>
                                    </tr>
                                   <?php } ?>
                                 </tbody>
                                    </table>
                            </div>

                            </div>
                           </div>
                        
                        

                        </div>
                    </div>

                </div>
           
            </div>
        </div>
        <div class="modal fade" id="myModal" role="dialog" style="padding-top: 100px;">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h3>Update Contract Status</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
          <form role="form" action="cancel_contract" method="post">
        <div class="modal-body">
            
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="conid" class="form-control comid" required="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Contract Status</label>
                    <select class="custom-select form-control status" name="status" onChange="getDiv();">
                        <option value="CANCEL">Cancel</option>
                        <option value="isLegal">Signed By Legal Section</option>
                        <option value="isPMG">Signed By GMBOP/GMCRM</option>
                        <option value="isComplete">Complete</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row" id="compl" style="display: none;">
                <div class="form-group col-md-12">
                                        <label>Start Date </label>
                                        <input type="text" name="start_date" id=""  class="form-control mydatetimepickerFull" placeholder="" required=""> 
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Contract Year </label>
                                        <select name="contract_year" class="form-control custom-select">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Payment Mode </label>
                                        <select name="mode_payment" class="form-control custom-select" required="">
                                            <option value="">--Select Payment Mode--</option>
                                            <option>Monthly</option>
                                            <option>Quarterly</option>
                                            <option>Semiannual</option>
                                            <option>Annual</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Contract Price</label>
                                        <input type="number" name="cont_price" id=""  class="form-control" placeholder="" required=""> 
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Scaned Contract ( Maximum Size 2MB )</label>
                                        <input type="file" name="image_url" id=""  class="form-control" placeholder="" > 
                                    </div>
            </div>
        </div>
        <div style="float: right;padding-right: 30px;padding-bottom: 10px;">
           
            <!-- <input type="hidden" name="id" id="comid"> -->
            <button type="submit" class="btn btn-info pull-left"><span class="glyphicon glyphicon-remove"></span>Save Status</button>
         <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel Status</button>
        </div>
        </form>
        </div>
        <div class="modal-footer">
            
        </div>
    
      </div>
    </div>
 <script type="text/javascript">
    function getDiv() {
        var check = $('.status').val();
        if (check == 'isComplete') {
             $('#compl').show();
         }else{
             $('#compl').hide();
         }
   
};
</script>
<script>
$(document).ready(function(){
  $(".myBtn").click(function(){
    
    var text = $(this).attr("data-contid");
    $('.comid').val(text);
    $("#myModal").modal();
});
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
    $('#day13').on('keyup', function() {
  var textinsert = ($(this).val());
    var regex=/^[0-9]+$/;
    if (textinsert.match(regex))
    {
        $('.errorPhone').hide();
     return false;
    }else{
        $('.errorPhone').show();
    }
});
});
</script>
<script type="text/javascript">
    $(document).ready(function() {
  
    var table = $('#example4').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
<?php $this->load->view('backend/footer'); ?>

