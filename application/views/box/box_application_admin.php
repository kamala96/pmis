<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Box Application</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Box Application</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php //$regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    <a href="<?php echo base_url() ?>Box_Application/BoxRental" class="btn btn-primary"><i class="fa fa-plus"></i> Box Application</a>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Box_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Box Application List</a></button>

                    <?php if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "RM" ){ ?>

                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Box_Application_Invoice" class="text-white"><i class="" aria-hidden="true"></i> Box List</a></button>



                     <?php } ?>

                       <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Virtual_Box_Application_List" class="text-white"><i class="" aria-hidden="true"></i>Virtue Application List</a></button>
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Box Application List                       
                        </h4>
                    </div>
                    <div class="card-body">

                  <div class="col-md-12">
                        <form action="Box_Application_Search" method="POST">
                        <div class="input-group">
                          
                          <input type="text" name="date" class="form-control mydatetimepickerFull" placeholder="Select Date">
                          <input type="text" name="month" class="form-control mydatetimepicker" placeholder="Select Month">
                          <?php if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "BOP" || $this->session->userdata('user_type') == "CRM" ){ ?>
                          <select class="form-control custom-select" name="region">
                            <option value="">--Select Region-</option>
                            <?php foreach ($region as $value) { ?>
                              <option><?php echo $value->region_name ?></option>
                            <?php } ?>
                          </select>
                        <?php }?>
                          <button type="submit" class="btn btn-info">Search</button>
                        </div>
                        </form>
                      </div> 
                      
                        <div class="card">
                           <div class="card-body">
                            <div class="table-responsive">
                            <table id="example41" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Customer Name</th>
                                                 <th>Registered date</th>
                                                <!-- <th>Customer Type</th> -->
                                                <th>Mobile No.</th>
                                                <th>Amount(Tsh.)</th>
                                                <th>Bill Number</th>
                                                <th>Region </th>
                                                 <th>Branch </th>
                                                <th>P.o.Box Number</th>
                                                <th>Payment Date</th>
                                                 <th>Payment Channel</th>
                                                <th style="text-align: right;">Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody class="results">
                                           <?php foreach($box_renters as $value): ?>
                                            <tr>
                                                <td><a href="Box_Information?I=<?php echo base64_encode($value->details_cust_id)?>"><?php echo $value->cust_name; ?></a></td>
                                                <td><?php echo $value->transactiondate; ?></td>
                                                <!-- <td><?php echo $value->box_tariff_category; ?></td> -->
                                                <td><?php echo $value->Customer_mobile; ?></td>
                                                <td><?php echo number_format($value->paidamount,2); ?></td>
                                                <td><?php 
                                                    if ($value->billid == '' && $value->bill_status == 'PENDING') {
                                                     $serial=$value->serial;
                                                     $paidamount=$value->paidamount;
                                                     $region=$value->region;
                                                     $district=$value->district;
                                                     $mobile = $value->Customer_mobile;
                                                     $renter = $value->box_tariff_category;
                                                     $serviceId = $value->PaymentFor;

                                                     // $this->Box_Application_model->getBillGepgBillId($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId);
                                                     
                                                    }else{

                                                      echo $value->billid;
                                                    }
                                                   
                                                   ?></td>
                                                    <?php //$box_status = null; ?>
                                                   <?php $box_status =$this->Box_Application_model->box_status($value->details_cust_id);

                                                  //echo $box_status->box_status;

                                                   ?>

                                                   <td><?php echo $value->region; ?></td>
                                                   <td><?php echo $value->district; ?></td>

                                                   <td>

                                                  <?php if (!is_null($box_status)){?>
                                                    <?php echo $box_status->box_number; ?>

                                                  <?php   }else{?>
                                                 <?php   }?>


                                                    <!--  <?php if (!is_null($boxlist)){?>

                                                    <?php foreach($boxlist as $value2): ?>
                                                      <?php if ($value2->reff_cust_id ==$value->details_cust_id ){?>
                                                        <?php echo $box_status->box_number; ?>
                                                        <?php   }else{?>
                                                        <?php   }?>
                                                          <?php endforeach; ?>
                                                        <?php   }?> -->



                                                 </td>

                                                   
                                                   

                                                <td><?php if ($value->paymentdate == '') {
                                                    
                                                }else{
                                                     echo date('d/m/Y', strtotime($value->paymentdate));
                                                }
                                                ?>
                                               </td>
                                                <td><?php echo $value->paychannel; ?></td>

                                                <td>
                                                <?php if ($value->status == 'Paid') {?>
                                             <?php if (!is_null($box_status) ){?>
                                                <?php if ($box_status->box_status == 'Occupied' ) {?>
                                                  <?php if (date('Y', strtotime($value->paymentdate)) > date('Y')) {?>
                                                            <a href="<?php echo base_url('Box_Application/RenewalBox')?>?I=<?php echo base64_encode($value->details_cust_id) ?>" class="btn btn-info btn-sm">
                                                                 Box Renewal
                                                            </a>
                                                        </button>
                                                      <?php  }else{ ?>
                                                         <button class="btn btn-success btn-sm" >
                                                            Active Box
                                                        </button> | 
                                                        <a href="#"></a>
                                                      <?php }} ?>
                                                <?php }else{?>
                                                <a href="Add_Box_Number?I=<?php echo base64_encode( $value->details_cust_id); ?>" class="btn btn-info btn-sm">Add Box Number</a>
                                                <?php } ?>
                                                <?php }else{?>
                                                  <button class="btn btn-warning btn-sm" >
                                                            Box Not Paid
                                                  </button>
                                                <?php } ?>
                                                </td>

                                            </tr>
                                            <?php endforeach; ?>
                                       
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


<script type="text/javascript">
    $('#boxtype').on('change', function() {
        if ($('#boxtype').val() == 'Individual') {
            $('#indv').show();
            $('#sectors').hide();
            $('#error1').html('');
        }if ($('#boxtype').val() == 'Government Ministries and Large Business/Inst.') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }if ($('#boxtype').val() == 'Government Department') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }if ($('#boxtype').val() == 'Religious/Education Inst,Small Business and NGOs') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }if ($('#boxtype').val() == 'Primary Schools') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }
    
    //$('#showdiv' + this.value).show();
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#1step').on('click',function(){
        if ($('#boxtype').val() == 0) {
                $('#error1').html('Please Select PostBox Type');
        }else{

            if ($('#tariffCat').val() == 0) {
                $('#error2').html('Please Select PostBox Category');
            }else{
                $('#div2').show();
                $('#div1').hide();
            }
        }
  });
        $('#1stepBack').on('click',function(){
        $('#div2').hide();
        $('#div1').show();
  });
        $('#2step').on('click',function(){
        if ($('#fname').val() == '') {
            $('#errfname').html('This field is required');
        }else if($('#mname').val() == ''){
            $('#errmname').html('This field is required');
        }else if($('#lname').val() == ''){
            $('#errlname').html('This field is required');
        }else if($('#occu').val() == ''){
            $('#erroccu').html('This field is required');
        }else{
        $('#div2').hide();
        $('#div3').show();
        }
  });
        $('#2stepBack').on('click',function(){
        $('#div3').hide();
        $('#div2').show();
  });
});

//save data to databse
$('#btn_save').on('click',function(){
    
            var boxtype   = $('#boxtype').val();
            var tariffCat = $('#tariffCat').val();
            var fname     = $('#fname').val();
            var mname     = $('#mname').val();
            var lname     = $('#lname').val();
            var gender    = $('#gender').val();
            var occu      = $('#occu').val();
            var region    = $('#regionp').val();
            var district   = $('#branchdropp').val();
            var email     = $('#email').val();
            var phone     = $('#phone').val();
            var mobile    = $('#mobile').val();
            var residence   = $('#residence').val();

            if (district == '') {
            $('#errdistrict').html('This field is required');
            }else if(residence == ''){
            $('#errresidence').html('This field is required');
             }else if(email == ''){
            $('#erremail').html('This field is required');
            }else if(phone == ''){
            $('#errphone').html('This field is required');
            }else if(mobile == ''){
            $('#errmobile').html('This field is required');
            }else{

            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Box_Application/Register_Box_Action')?>",
                dataType : "JSON",
                data : {boxtype:boxtype,fname:fname,mname:mname,lname:lname,gender:gender,occu:occu,region:region,district:district,email:email,phone:phone,mobile:mobile,residence:residence,tariffCat:tariffCat},
                success: function(data){

                    $('[name="vehicle_no"]').val("");
                    $('[name="vehicle_id"]').val("");

                    $('#div4').show();
                    $('#div3').hide();
                    $('#majibu').html(data);
                   /// $('#Modal_Edit').modal('hide');
                    show_product();
                }
            });
            return false;
        }
        });


</script>

<script type="text/javascript">
        function getDistrict() {
    var val = $('#regionp').val();
     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Employee/GetDistrict",
     data:'region_id='+ val,
     success: function(data){
         $("#branchdropp").html(data);
     }
 });
};
</script>
<script type="text/javascript">
     function getTariffCategory() {

     var val = $('#boxtype').val();
     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Box_Application/GetTariffCategory",
     data:'bt_id='+ val,
     success: function(data){
        $('#tariffCat').html(data);
        $('#indv').show();
        $('#error1').html('');
     }
 });
};
</script>
<script type="text/javascript">
    $(document).ready(function() {
   
    var table = $('#example41').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        dom: 'Bfrtip',
        order: [[ 1, 'dec' ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>

<script type="text/javascript">
        function getBoxnumber() {

    var val = $('#box_number').val();
     if (val == 0) {

     }else{

     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Box_Application/UpdateBoxFull",
     data:'box_id='+ val,
     success: function(data){
         //$("#branchdropp").html(data);
     }
 });

 }
};
</script>
<?php $this->load->view('backend/footer'); ?>

