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
                <div class="col-12 row">
                     <div class="">
                    <a href="<?php echo base_url() ?>Box_Application/BoxRental" class="btn btn-primary"><i class="fa fa-plus"></i> Box Application</a>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Box_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Box Application List</a></button>
                </div>

                    <div class="" >
                      <form method="post" action="<?php echo base_url();?>Box_Application/Gotobox">
                        <div class="input-group" >
                                        <input type="number" name="box_numbersearch" class="form-control">
                                      
                                        <input type="submit" class="btn btn-success" style="" id="" value="Goto Box" required="required"> 

                                        <!-- <button type="button" class="btn btn-primary " id="getboxdetails">Goto Box</button> -->

                                        <?php if(!empty($this ->session->flashdata('infor'))){ ?>
                                            <h3 id="info" style="padding-left:10px; color: red;">
                                                 <?php echo $this ->session->userdata('infor'); ?>
                                            </h3>
                  
                                          <!-- <strong> <?php echo $this ->session->userdata('message'); ?></strong>  -->
                                        
                                                        <?php }?>

                                         

                                    </div>

                  </form>
              </div>

                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="">
                      <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active boxinfo" data-toggle="tab" href="#" role="tab" style=""> Virtual Box Information </a> </li>
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="infor">
                        <div class="card">
                           <div class="card-body">
                            <h4> Box Customer Information </h4>

                  <?php if($this->session->flashdata('success')){ ?> 
                           <div class='alert alert-success alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong>  <?php echo $this->session->flashdata('success'); ?>  </strong> 
                           </div>                         
                    <?php } ?>
                            
                            <!-- <form method="post" action="<?php echo site_url('Box_Application/update_customer_virtual_box_information');?>"> -->

                            <input type="hidden" value="<?php echo $inforperson->virtuebox_id; ?>" name="virtuebox_id" class="form-control">
                          
                            <table class="table table-bordered table-striped" style="width:100%;">
                              <tr><th style="width: 25%;">Description</th><th style="width: 25%;">Values Item</th><th style="width: 25%;">Description</th><th style="width: 25%;">Values Item</th></tr>
                              <tr><td style="width: 25%;"><b>Post Box Type</b></td><td style="width: 25%;"><?php echo $inforperson->virtueboxtype; ?></td><td style="width: 25%;"><b>Post Box Category</b></td><td style="width: 25%;"><?php echo $inforperson->virtueboxtype; ?></td></tr>
                              
                           
 

                            <tr>
                            <td><b>Customer Name</b></td><td style="width: 25%;" colspan="3">
                            <div class="row">
                            <div class="col-md-4">
                            <input type="text" value="<?php echo $inforperson->fname; ?>" name="fname" class="form-control" placeholder="First Name" required>
                            </div>
                            <div class="col-md-4">
                            <input type="text" value="<?php echo $inforperson->mname; ?>" name="mname" class="form-control" placeholder="Middle Name" required>
                            </div>
                            <div class="col-md-4">
                            <input type="text" value="<?php echo $inforperson->lname; ?>" name="lname" class="form-control" placeholder="Last Name" required>
                            </div>
                            </div>
                            </td>
                            </tr>

                            <tr>
                            <td style="width: 25%;"><b>Identity Type</b></td>
                            <td style="width: 25%;">
                            <div class="row">
                            <div class="col-md-12">
                            <select class="custom-select form-control" name="idtype" required="">
                                        <option value="<?php echo $inforperson->idtype; ?>"> <?php echo $inforperson->idtype; ?> </option>
                                        <!-- <option>Work ID</option>
                                        <option>National ID</option>
                                        <option>Passport Document</option>
                                        <option>Voters ID</option>
                                        <option>School ID</option> -->
                            </select>
                            <div>
                            <div>
                            </td>

                            <td style="width: 25%;"><b>Identity Number</b></td>
                            <td style="width: 25%;">
                            <input type="text" value="<?php echo $inforperson->idno; ?>" name="idnumber" class="form-control" required>
                            </td>
                            </tr>


                            <tr><td style="width: 25%;"><b>Gender</b></td>
                            <td style="width: 25%;">
                    <input type="text" value="<?php echo $inforperson->gender; ?>" name="gender" class="form-control" required>
                            </td>


                            <td style="width: 25%;"><b>Box Number</b></td>
                            <td style="width: 25%;">
                   <input type="text" value="<?php echo $inforperson->phone; ?>" name="boxnumber" class="form-control" required>
                            </td>
                            </tr>




                              <tr><td style="width: 25%;"><b>Region</b></td><td style="width: 25%;"><?php echo $inforperson->region; ?></td><td style="width: 25%;"><b>Branch</b></td><td style="width: 25%;"><?php echo $inforperson->district; ?></td></tr>
                              

                             <!--  <tr><td style="width: 25%;"><b>Phone</b></td>
                               <td style="width: 25%;">
                    <input type="text" value="<?php echo $inforperson->phone; ?>" name="phone" class="form-control" required>
                               </td>
                               <td style="width: 25%;"><b>Mobile</b></td>
                               <td style="width: 25%;">
                    <input type="text" value="<?php echo $inforperson->phone; ?>" name="phone" class="form-control"  required>
                                </td>
                               </tr> -->
                            </table>

                   <!--  <button type="submit" class="btn btn-info"> Update Information </button>

                            </form> -->
                            </div>

                            <div class="card-body">
                            <h4>Box Payment Information</h4>
                            <table class="table table-bordered table-striped" style="width:100%;">
                              <tr><th style="width: 25%;">Control Number</th>
                                <th style="width: 25%;">Receipt Number</th>
                                <th style="width: 25%;">Payment Date</th>
                                  <th>Payment Channel</th>
                                <th style="width: 25%;">Expire Date</th>
                                <th style="width: 25%;" colspan="2">Amount(Tsh.) </th>
                                
                            </tr>
                              <?php foreach ($paymentlist as $value) { ?>
                                 <tr><td style="width: 25%;"><?php echo $value->billid; ?>
                                   <td style="width: 25%;"><?php echo $value->receipt; ?>
                                 </td><td style="width: 25%;"><?php echo $value->paymentdate; ?></td>
                                 <td><?php echo $value->paychannel; ?></td>

                                                    <td><?php if (!empty($value->paymentdate )) {
                                                        $todaydate=date('Y-m-d');
                                                        $expiredate= date('Y-m-d',strtotime($value->paymentdate. ' + '.$value->duration.' year'));
                                                        echo $expiredate;
                                                        if($expiredate <= $todaydate){
                                                            if($virtuebox_status == 'ACTIVE'){
                                                                 $updatevirtual = array('virtuebox_status'=>'EXPIRED');
                                                            $virtuebox_id=@$value->CustomerID;
                                                            $this->Box_Application_model->update_virtual($virtuebox_id,$updatevirtual);

                                                            }
                                                           


                                                        }
                                                    
                                                }else{
                                                     echo '';
                                                }
                                                ?>
                                               </td>

                          

                                 <td style="width: 30%;" ><?php echo number_format($value->paidamount); ?></td>

                             </tr>
                                 <?php } ?>
                              
                             

                              
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
     $('.generate').hide();
     $('#loadingtext').html('Please wait............');
     
    $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Box_Application/RenewalBox')?>",
                //dataType : "JSON",
                data : {cust_id:cust_id},
                success: function(data){
                  $('.showvalue').html(data);
                   $('.generate').hide();
                   $('#loadingtext').hide();
                  // $('.renewbox').hide();
                  // $('.infor').show();
                  // $('.lockreplacement').hide();
                  // $('.keydeposite').hide();
                  // $('.authority_card').hide();

                  // $('.renewbox').hide();
                  // $('.infor').show();
                  // $('.lockreplacement').hide();
                  // $('.keydeposite').hide();
                  // $('.authority_card').hide();
                  // $('.allocatebox').hide();                  // $('.allocatebox').hide();
                }
            });

    //alert(cust_id);
});


   $(".getboxdetails").click(function(){
    var box_numbersearch = $('#box_numbersearch').val();
     // $('.getboxdetails').hide();
     $('#info').html('Please wait............');
     
    $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Box_Application/Gotobox')?>",
                //dataType : "JSON",
                data : {box_numbersearch:box_numbersearch},
                success: function(data){
                  // $('.info').html(data);
                  //  $('.getboxdetails').hide();
                  //  $('#loadingtext').hide();
                  $('#info').html('Imekubalii');
                },error:function(){
                     $('#info').html('');
                      $('#info').html('Imegomaaaaaaa');

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
     },error:function(){

            }
 });

 }
};
</script>
<?php $this->load->view('backend/footer'); ?>

