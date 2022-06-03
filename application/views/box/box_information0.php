<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Box Information Perperson</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Box Information Perperson</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    <a href="<?php echo base_url() ?>Box_Application/BoxRental" class="btn btn-primary"><i class="fa fa-plus"></i> Box Application</a>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Box_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Box Application List</a></button>
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="">
                      <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active boxinfo" data-toggle="tab" href="#" role="tab" style=""> Box Information </a> </li>
                                <li class="nav-item"> <a class="nav-link addboxnumber" data-toggle="tab" href="#" role="tab" style=""> Allocate Box</a> </li>
                                <li class="nav-item"> <a class="nav-link renewbox1" data-toggle="tab" href="#" role="tab" style=""> Renew Box </a> </li>
                                <li class="nav-item"> <a class="nav-link lockreplacement1" data-toggle="tab" href="#profile" role="tab" style=""> Lock Replacement </a> </li>
                                <li class="nav-item"> <a class="nav-link keydeposite1" data-toggle="tab" href="#education" role="tab" style=""> Key Deposite</a> </li>
                                <li class="nav-item"> <a class="nav-link authority_card1" data-toggle="tab" href="#referee" role="tab" style=""> Box Rental Authority Card</a> </li>
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="infor">
                        <div class="card">
                           <div class="card-body">
                            <h4>Box Information Perperson</h4>

                            <table class="table table-bordered table-striped" style="width:100%;">
                              <tr><th style="width: 25%;">Description</th><th style="width: 25%;">Values Item</th><th style="width: 25%;">Description</th><th style="width: 25%;">Values Item</th></tr>
                              <tr><td style="width: 25%;"><b>Post Box Type</b></td><td style="width: 25%;"><?php echo $inforperson->renter_name; ?></td><td style="width: 25%;"><b>Post Box Category</b></td><td style="width: 25%;"><?php echo $inforperson->box_tariff_category; ?></td></tr>
                              <tr><td style="width: 25%;"><b>Customer Name</b></td><td style="width: 25%;"><?php echo $inforperson->cust_name; ?></td><td style="width: 25%;"><b>Representative Name</b></td><td style="width: 25%;"><?php echo $inforperson->first_name.'  '. $inforperson->middle_name.' '.$inforperson->last_name; ?>;</td></tr>
                              <tr><td style="width: 25%;"><b>Identity Type</b></td><td style="width: 25%;"><?php echo $inforperson->iddescription; ?></td><td style="width: 25%;"><b>Identity Number</b></td><td style="width: 25%;"><?php echo $inforperson->idnumber; ?></td></tr>
                              <tr><td style="width: 25%;"><b>Authority Card Number</b></td><td style="width: 25%;"><?php echo $inforperson->authority_card; ?></td><td style="width: 25%;"><b>Box Number</b></td><td style="width: 25%;"><?php echo $inforperson->box_number; ?></td></tr>
                              <tr><td style="width: 25%;"><b>Region</b></td><td style="width: 25%;"><?php echo $inforperson->region; ?></td><td style="width: 25%;"><b>Branch</b></td><td style="width: 25%;"><?php echo $inforperson->branch; ?></td></tr>
                              <tr><td style="width: 25%;"><b>Phone</b></td><td style="width: 25%;"><?php echo $inforperson->phone; ?></td><td style="width: 25%;"><b>Mobile</b></td><td style="width: 25%;"><?php echo $inforperson->mobile; ?></td></tr>
                            </table>
                            </div>

                            <div class="card-body">
                            <h4>Box Payment Information</h4>
                            <table class="table table-bordered table-striped" style="width:100%;">
                              <tr><th style="width: 25%;">Control Number</th>
                                <th style="width: 25%;">Receipt Number</th>
                                <th style="width: 25%;">Payment Date</th>
                                <th style="width: 25%;">Renew Date</th><th style="width: 25%;"></th><th style="width: 25%;">Amount(Tsh.)</th></tr>
                              <?php foreach ($paymentlist as $value) { ?>
                                 <tr><td style="width: 25%;"><?php echo $value->billid; ?>
                                   <td style="width: 25%;"><?php echo $value->receipt; ?>
                                 </td><td style="width: 25%;"><?php echo $value->paymentdate; ?></td>
                                 <td style="width: 25%;"><?php 
                                           
                                           if (!empty($value->paymentdate)) {
                                            $maxyear=1;
                                            foreach ($Outstanding as $value) {
                                              if(date('Y', strtotime($value->paymentdate)) < $Outstanding->year){
                                                $maxyear=$maxyear+1;

                                              }
                                              
                                            }
                                            
                                             $yearOnly=date('Y', strtotime($value->paymentdate)) + $maxyear;
                                              echo  $year = '01-01-'.$yearOnly; 
                                           }
                                    
                                 ?></td>
                                 <td style="width: 25%;" >TOTAL</td><td style="width: 25%;"><?php echo number_format($value->paidamount); ?></td></tr>
                                 <?php } ?>
                              
                              <?php foreach ($Outstanding as $value) { ?>
                                <tr>
                            <td style="width: 25%;" colspan="4"></td>
                            <td style="width: 25%;"><?php echo $value->year; ?></td>
                            <td style="width: 25%;"><?php echo $value->amount; ?></td>
                          </tr>


                               <?php } ?>
                              
                            </table>
                            </div>
                           </div>
                        
                        

                        </div>
                        <div class="tab-pane renewbox" id="" style="display: none;">
                        <input type="hidden" name="" id="cust_id" value="<?php echo base64_encode($inforperson->details_cust_id);?>">
                        <button type="button" class="btn btn-primary generate">Generate Control Number Renewal Payment</button>
                        <br><br>
                        <span class="showvalue"></span>
                       </div>
                       <div class="tab-pane allocatebox" id="" style="display: none;">
                        Box Allocation
                       </div>
                       <div class="tab-pane lockreplacement" id="" style="display: none;">
                        lock Replacement
                       </div>
                       <div class="tab-pane keydeposite" id="" style="display: none;">
                        Key Deposite
                       </div>
                       <div class="tab-pane authority_card" id="" style="display: none;">
                        Box Rental Authority Card
                       </div>
                    </div>
                  </div>
                </div>
            
            </div>
        </div>

<script type="text/javascript">
  $(".boxinfo").click(function(){
  $('.renewbox').hide();
  $('.infor').show();
  $('.lockreplacement').hide();
  $('.keydeposite').hide();
  $('.authority_card').hide();
  $('.allocatebox').hide();
});
  $(".addboxnumber").click(function(){
  $('.renewbox').hide();
  $('.allocatebox').show();
  $('.infor').hide();
  $('.lockreplacement').hide();
  $('.keydeposite').hide();
  $('.authority_card').hide();
});
  $(".renewbox1").click(function(){
  $('.renewbox').show();
  $('.infor').hide();
  $('.lockreplacement').hide();
  $('.keydeposite').hide();
  $('.authority_card').hide();
  $('.allocatebox').hide();
});
  $(".lockreplacement1").click(function(){
  $('.renewbox').hide();
  $('.infor').hide();
  $('.lockreplacement').show();
  $('.keydeposite').hide();
  $('.authority_card').hide();
  $('.allocatebox').hide();
});
  $(".keydeposite1").click(function(){
  $('.renewbox').hide();
  $('.infor').hide();
  $('.lockreplacement').hide();
  $('.keydeposite').show();
  $('.authority_card').hide();
  $('.allocatebox').hide();
});
  $(".authority_card1").click(function(){
  $('.renewbox').hide();
  $('.infor').hide();
  $('.lockreplacement').hide();
  $('.keydeposite').hide();
  $('.authority_card').show();
  $('.allocatebox').hide();
});
  $(".generate").click(function(){
    var cust_id = $('#cust_id').val();

    $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Box_Application/RenewalBox')?>",
                //dataType : "JSON",
                data : {cust_id:cust_id},
                success: function(data){
                  $('.showvalue').html(data);
                }
            });

    //alert(cust_id);
});
</script>
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

