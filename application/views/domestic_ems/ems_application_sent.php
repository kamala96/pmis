
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<style type="text/css">body {margin:2em;}</style>
<div class="page-wrapper">
<div class="message"></div>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Ems Application List</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Ems Application List </li>
        </ol>
    </div>
</div>
<!-- Container fluid  -->
<!-- ============================================================== -->
<?php $regionlist = $this->employee_model->regselect(); ?>
<?php $ems_cat = $this->Box_Application_model->ems_cat(); ?>
<?php $tz = 'Africa/Nairobi';
    $tz_obj = new DateTimeZone($tz);
    $today = new DateTime("now", $tz_obj);
    $date = $today->format('Y-m-d');  

    $id=$this->session->userdata('user_login_id'); $getInfo = $this->employee_model->GetBasic($id) ;
    ?>
<div class="container-fluid">
    <div class="row m-b-10">
        <div class="col-12">
          <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Ems_Domestic/document_parcel" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Transaction</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_Application_List" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Transactions List</a></button>
                      <?php if($this->session->userdata('user_type') == "EMPLOYEE"  ){ ?>
                      <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_application_sent" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Sent to Backoffice</a></button>
                    <?php }?>
                          <?php if($this->session->userdata('user_type') == "ADMIN" ){ ?>
                      <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_application_admin" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Sent to Backoffice</a></button>
                    <?php }?>
     </div>
 </div>

 <div class="row">
    <div class="col-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"> Ems Application Sent</h4>
            </div>
            <div class="card-body">
                <div class="card">
                   <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                           <table class="table table-bordered" style="width: 100%;">
                              
                              <input type="hidden" name="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>"/>
            <?php  if($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {?>
<form action="Ems_application_sent" method="POST">
                                <tr>
                                    <th style="">
                                     <div class="input-group">
                                        
                                        <input type="text" name="date" class="form-control  mydatetimepickerFull" placeholder="Select Date">
                                        <input type="text" name="month" class="form-control  mydatetimepicker" placeholder="Select Month">
                                        <input type="submit" class="btn btn-success" style="" value="Search Date">

                                    </div>
                                </th>

                            </th>
                        </tr>
                        </form>
                      <?php }else { ?>
                        <?php if($this->session->userdata('user_type') == "SUPERVISOR" ){ ?>
                           <tr>
                                    <th style="">
                                     <label>Select Date:</label>
                                     <div class="input-group">

                                        <input type="text" name="" class="form-control  mydatetimepickerFull">
                                        <input type="hidden" name="" class="form-control date" value="Date">
                                        <!-- <input type="button" name="" class="btn btn-success BtnSubmit" style="" id="" value="Search Date" required="required"> -->
                                    </div>
                                </th>
                                <th>
                                 <label>Employee Name:</label>
                                 <div class="input-group">
                                    <select class="form-control custom-select emname">
                                      <option value="">--Select Employee--</option>
                                      <?php foreach($emselect as $value){?>
                                      <option value="<?php echo $value->em_id ?>"><?php echo $value->first_name.'    '.$value->middle_name.'    '.$value->last_name ?></option>
                                    <?php }?>
                                    </select>
                                </div>
                            </th>
                            <th>
                                 <label>Agent Name:</label>
                                 <div class="input-group">
                                    <select class="form-control custom-select agname">
                                      <option value="">--Select Agent--</option>
                                      <?php foreach($agselect as $value){?>
                                      <option value="<?php echo $value->em_id ?>"><?php echo $value->first_name.'    '.$value->middle_name.'    '.$value->last_name ?></option>
                                    <?php }?>
                                    </select>
                                </div>
                            </th>
                            <th>
                                 <label>&nbsp;</label>
                                 <div class="input-group">
                                    <input type="button" name="" class="btn btn-success BtnSuper" style="width: 100px;" id="" value="Search">
                                </div>
                            </th>
                        </tr>
                                  <?php }else{?>
                                     <tr>
                                <?php if($this->session->userdata('user_type') == "ACCOUNTANT-HQ" || $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "BOP"){ ?>
                                    <form action="Ems_application_sent" method="POST">
                                    <th style="">
                                     <div class="input-group">

                                         <input type="text" name="date" class="form-control  mydatetimepickerFull" placeholder="Select Date">
                                        <input type="text" name="date2" class="form-control  mydatetimepickerFull" placeholder="Select Date  To">
                                        <input type="text" name="month" class="form-control  mydatetimepicker" placeholder="Select Month">
                                        <input type="text" name="month2" class="form-control  mydatetimepicker" placeholder="Select Month To">
                                        <select class="form-control custom-select" name="ems_type">
                                        <option>--Select Type--</option>
                                        <option value="EMS">EMS</option>
                                        <option value="LOAN BOARD">Loan Board</option>
                                    </select>
                                    <select id="years" class="form-control custom-select" name="year">
                                        <option>--Select Year--</option>
                                    </select>
                                    <select name="region" value="" class="form-control custom-select" required id="regiono" onChange="getDistrict();">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    
                                        <button type="submit" class="btn btn-info">Search</button>
                                    </div>
                                </th>
                                </form>
                                <?php }else{?>
                        <?php }?>
                        </tr>
                                  <?php } ?>

                       
                      <?php } ?>

                    </table>
                </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <?php if(!empty($this ->session->flashdata('message'))){ ?>
                  <div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong> <?php echo $this ->session->userdata('message'); ?></strong> 
</div>
                <?php }else{?>
                  
                <?php }?>
                
               
              </div>
            </div>

            <form method="POST" action="<?php echo base_url();?>Box_Application/send_to_back_office">

                <div class="">

                    <span class="">

                        <!-- <table id="example4" class="  table  table-bordered" cellspacing="0" width="100%"> -->
                          <table id="example4" class="table  table-bordered" cellspacing="0" width="100%">
                            <thead>

                              <tr>
                                <th style="border-left:0px;right:0px   "></th>
                                <th style="border-left:0px;right:0px   "></th>
                                <th style="border-left:0px;right:0px   "></th>
                                <th style="border-left:0px;right:0px   "></th>
                                <th style="border-left:0px;right:0px ;float:right;   ">
                                   <span ><b>Transfered Items on: </b></span>
                                  
                                </th>
                                
                                  <th style="border-left:0px;right:0px   " >
                                 
                                 
                                     
                                  <?php
                                  $year=date('Y', strtotime(@$emslist[0]->date_registered)) ;
                                  $month=date('m', strtotime(@$emslist[0]->date_registered));
                                  $day=date('d', strtotime(@$emslist[0]->date_registered));

                                  $date = $day.'/'.$month.'/'.$year;
                                  if($year == '1970')
                                  {
                                    echo '';

                                  }else{
                                     echo @$date; 
                                  }?> 

                                                            
                                 
                                 
                               </th>
                               <!-- <th style="border-left:0px;right:0px   "></th> -->

                             </tr>

                              
                              								
                                 <tr style="border:1px ">
                                    <th>S/N No</th>
                                    <th>Item Number </th>
                                    <th>Item Type</th>
                                    <th>Amount (Tsh.)</th>
                                    <th>Transfered By</th>
                                    <th>Received By</th>
                                    <!-- <th>Transfer Status</th> -->
                                
                                </tr>
                            </thead>


                            <tbody class="" >
                               <?php  foreach ($emslist as $key =>  $value) {?>
                                   <tr style="border:1px ">
                                      <td><?php echo $key;?></td>
                                      <td><?php  echo $value->track_number; ?></td>
                                      <td><?php echo $value->ems_type;?></td>
                                      <td><?php echo $value->paidamount; ?></td>
                                     <td><?php  $info = $this->employee_model->GetBasic($value->operator);
                                      echo 'PF.'.$info->em_code.' '.$info->first_name.' '.$info->last_name;?>
                                                                       
                                     </td>
                                     <?php if ($value->office_name == 'Received') {?>
                                      <td>
                                        <?php $info = $this->employee_model->GetBasic($value->created_by);
                                      echo 'PF.'.$info->em_code.' '.$info->first_name.' '.$info->last_name;?>
                                         </td>

                                    <!-- <td> <button type="button" class="btn  btn-success btn-sm" disabled="disabled">Successfully Transfer</button> -->
                                    </td>
                                    <?php }else{ ?>
                                      <!-- <td><?php echo '';?></td> -->
                                      <td><button type="button" class="btn btn-danger btn-sm" disabled="disabled"> Pending To Back Office</button></td>
                               <?php }?>

                    
</tr>

<?php } ?>
<tr>
  <td style="border:0px;  "></td>
  <td style="border:0px;  "></td>
  <td style="border:0px;  "></td>
   <td style="border:0px; ;float:right;">
        <span ><b>Total Number of Items: </b></span>
 </td>
  <td style="border:0px;  "> <?php echo COUNT($emslist);?></td>
  
  <td style="border:0px;  "></td>
  <!-- <td style="border:0px;  "></td> -->





   

</tr>

</tbody>

</table>


</span>

<span class="table2" style="display: none;">
<span class="results"></span>
</span>
</div>

<!-- <input type="hidden" name="emid" id="emid" value="<?php echo $emid; ?>"> -->
<input type="hidden" name="type" value="EMS">
</form>
</div>
</div>

</div>
</div>

</div>

</div>
</div>
<div class="modal fade" id="myModal" role="dialog" style="padding-top: 100px;">
<div class="modal-dialog modal-lg">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <form role="form" action="ems_action_receiver" method="post" onsubmit='disableButton()'>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <h3>Step 3 of 4  - Reciever Personal Details</h3>
            </div>

            <div class="col-md-6">
                <label>Full Name:</label>
                <input type="text" name="r_fname" id="r_fname" class="form-control" onkeyup="myFunction()" required="required">
            </div>
            <div class="col-md-6">
                <label>Address:</label>
                <input type="text" name="r_address" id="r_address" class="form-control" onkeyup="myFunction()" required="required">
            </div>
            <div class="col-md-6">
                <label>Email:</label>
                <input type="email" name="r_email" id="r_email" class="form-control" onkeyup="myFunction()">
            </div>
            <div class="col-md-6">
                <label>Mobile Number</label>
                <input type="mobile" name="r_mobile" id="r_mobile" class="form-control" onkeyup="myFunction()" required="required">
            </div>
            <div class="col-md-6">
                <label class="control-label">Region</label>
                <select name="region_to" value="" class="form-control custom-select" required id="rec_region" onChange="getRecDistrict();" required="required">
                    <option value="">--Select Region--</option>
                    <?Php foreach($regionlist as $value): ?>
                    <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label>Reciever Branch</label>
            <select name="district" value="" class="form-control custom-select"  id="rec_dropp" required="required">
                <option>--Select Branch--</option>
            </select>

        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <label>Selection Type</label>
            <select class="form-control custom-select wgt" name="weight_sel" onChange="getSelect();">
                <option value="same">Same Weight</option>
                <option value="diff">Different Weight</option>
            </select>
        </div>
    </div>
    <div class="row select" style="display: none;">
        <div class="col-md-6">
            <label>Ems Type</label>
                                    <select name="emsname" value="" class="form-control custom-select" required id="boxtype">
                                            <option value="Document">Document</option>
                                            <option value="Parcel">Parcel</option>
                                        </select>
        </div>
        <div class="col-md-6">
            <label>Ems Tariff Category:</label>
                                    <select name="emscattype" value="" class="form-control custom-select catid"  id="tariffCat" required="required" onChange = "getEMSType();">
                                        <option value="0">--Select Category--</option>
                                        <?Php foreach($ems_cat as $value): ?>
                                             <option value="<?php echo $value->cat_id ?>"><?php echo $value->cat_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
        </div>
        <div class="col-md-6">
           <label>Weight Step in KG:</label>
                            <input type="number" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()">
        </div>
    </div>
    <br>
                                <div class="row">
                                    <div class="col-md-12">
                                    <span class ="price" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div>
   
</div>
<div class="row" style="float: right;padding-right: 30px;padding-bottom: 10px;">

    <input type="hidden" name="id" id="comid">
    <button type="submit" class="btn btn-info pull-left"><span class="glyphicon glyphicon-remove"></span>Save Information</button>
    <button type="submit" class="btn btn-warning pull-left" data-dismiss="modal">Cancel</button>
</div>
</form>
</div>
<div class="modal-footer">

</div>

</div>
</div>
    <div id="myModal1" class="modal fade" role="dialog" style="padding-top:200px; font-size:24px;">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">EMS Information</h2>
                </div>
                <div class="modal-body">
                <table class="table table-bordered table-striped" width="100%">
                        <tr>
                          <th colspan="2">SENDER INFORMATION</th>
                        </tr>
                        <tr><td>Fullname::</td><td><span class="sfname"></span></td></tr>
                        <tr><td>Address::</td><td><span class="saddress"></span></td></tr>
                        <tr><td>Email::</td><td><span class="semail"></span></td></tr>
                        <tr><td>Mobile::</td><td><span class="smobile"></span></td></tr>
                        <tr><td>Region::</td><td><span class="sregion"></span></td></tr>
                        <tr><td>Branch::</td><td><span class="sbranch"></span></td></tr>
                        <tr><th colspan="2"></th></tr>
                        <tr>
                          <th colspan="2">RECEIVER INFORMATION</th>
                        </tr>
                        <tr><td>Fullname::</td><td><span class="rfname"></span></td></tr>
                        <tr><td>Address::</td><td><span class="raddress"></span></td></tr>
                        <tr><td>Email::</td><td><span class="remail"></span></td></tr>
                        <tr><td>Mobile::</td><td><span class="rmobile"></span></td></tr>
                        <tr><td>Region::</td><td><span class="rregion"></span></td></tr>
                        <tr><td>Branch::</td><td><span class="rbranch"></span></td></tr>
                        <tr><th colspan="2"></th></tr>
                        <tr>
                          <th colspan="2">PAYMENT INFORMATION</th>
                        </tr>
                        <tr><td>Bill Number::</td><td><span class="billid"></span></td></tr>
                        <tr><td>Channel::</td><td><span class="channel"></span></td></tr>
                        <tr><th colspan="2"></th></tr>
                        <tr>
                          <th colspan="2">OPERATOR INFORMATION</th>
                        </tr>
                        <tr><td>Fullname::</td><td><span class="operator"></span></td></tr>
                      </table>
                </div>
                </div>
                </div>
                </div>




<div id="myModalEndDay" class="modal fade" role="dialog" style="padding-top:200px; font-size:24px;">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Ending Job Process</h2>
                </div>
                <div class="modal-body">
                  <h3 style="color:red;">You Cant End This Day Until She/He Complete Task</h3>
                </div>
                </div>
                </div>
                </div>
<div id="myModalEndDay2" class="modal fade" role="dialog" style="padding-top:200px;">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Ending Job Process</h2>
                </div>
                <div class="modal-body">
                  <form name="" action="<?php echo base_url();?>Employee/Assign_job" method="post">
                  <h3 style="color:red;">Successfully Transaction.</h3>
                  <?php $sup_service = $this->organization_model->get_services_super(); ?>
                  <label>Select Job To Assign[Day Task]</label>
                  <select class="custom-select form-control" name="job" required="required">
                    <option value="">--Select Job--</option>

                  <?php foreach($sup_service as $value){?>
                     <option><?php echo $value->serv_name; ?></option>
                  <?php } ?>
                  </select>
                <br><br>
                  <div class="" style="float: right;padding-bottom: 10px;">

    <input type="hidden" name="empid" id="empid">
    <button type="submit" class="btn btn-info pull-left"><span class="glyphicon glyphicon-remove"></span>Save Information</button>
    <button type="submit" class="btn btn-warning pull-left" data-dismiss="modal">Cancel</button>
</div>
</form>
                </div>

                </div>
                </div>
                </div>
                <script>
                $(document).ready(function(){
                    $(".getDetails").click(function(){
                        $(".sfname").html($(this).attr("data-s_fullname"));
                        $(".saddress").html($(this).attr("data-s_address"));
                        $(".semail").html($(this).attr("data-s_email"));
                        $(".smobile").html($(this).attr("data-s_mobile"));
                        $(".sregion").html($(this).attr("data-s_region"));
                        $(".rfname").html($(this).attr("data-r_fullname"));
                        $(".raddress").html($(this).attr("data-r_address"));
                        $(".remail").html($(this).attr("data-r_email"));
                        $(".rmobile").html($(this).attr("data-r_mobile"));
                        $(".rregion").html($(this).attr("data-r_region"));
                        $(".sbranch").html($(this).attr("data-sbranch"));
                        $(".rbranch").html($(this).attr("data-rbranch"));
                        $(".operator").html($(this).attr("data-operator"));
                        $(".channel").html($(this).attr("data-channel"));
                        $(".billid").html($(this).attr("data-billid"));

                        $("#myModal1").modal();
                        });
                        });
                        </script>
<!-- <script>
$('form').submit(function(){
    $(this).find('button[type=submit]').prop('disabled', true);
});
</script> -->
<script>
        var nowY = new Date().getFullYear(),
            options = "";

        for (var Y = nowY; Y >= 2019; Y--) {
            options += "<option>" + Y + "</option>";
        }

        $("#years").append(options);
</script>
<script>
function getPriceFrom() {

 var weight = $('#weight').val();
  var tariffCat  = $('#tariffCat').val();
if (weight == '') {

}else{
    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Ems_price_vat')?>",
                 //dataType : "JSON",
                 data : {weight:weight,tariffCat:tariffCat},
                 success: function(data){
                    $('.price').html(data);
                 }
             });
}

    }
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
        {
          text: 'Print Form',
          extend: 'pdfHtml5',
          filename: 'Ems_application',
          orientation: 'portrait', // landscape
          pageSize: 'A4', //A3 , A5 , A6 , legal , letter
          exportOptions: {
            columns: ':visible',
            search: 'applied',
            //order: 'applied'
          },
          customize: function (doc) {
            //Remove the title created by datatTables
            doc.content.splice(0,1);
            //Create a date string that we use in the footer. Format is dd-mm-yyyy
            var now = new Date();
            var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
            // Logo converted to base64
            // var logo = getBase64FromImageUrl('https://datatables.net/media/images/logo.png');
            // The above call should work, but not when called from codepen.io
            // So we use a online converter and paste the string in.
            // Done on http://codebeautify.org/image-to-base64-converter
            // It's a LONG string scroll down to see the rest of the code !!!
            var logo = 'data:image/jpeg;base64,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';
            // A documentation reference can be found at
            // https://github.com/bpampuch/pdfmake#getting-started
            // Set page margins [left,top,right,bottom] or [horizontal,vertical]
            // or one number for equal spread
            // It's important to create enough space at the top for a header !!!
             doc.pageMargins = [20,60,20,30];
            // Set the font size fot the entire document
            doc.defaultStyle.fontSize = 10;
            // Set the fontsize for the table header
            doc.styles.tableHeader.fontSize = 10;
            // Create a header object with 3 columns
            // Left side: Logo
            // Middle: brandname
            // Right side: A document title
            doc['header']=(function() {
              return {
                columns: [
                  {
                    image: logo,
                    width: 24
                  },
                  // {
                  //   alignment: 'left',
                  //   italics: true,
                  //   text: '',
                  //   fontSize: 18,
                  //   margin: [10,0] //margin: [10,0]
                  // },
                  {
                    alignment: 'center',
                    fontSize: 14,
                    text: 'TANZANIA POSTS CORPORATION'
                  },
                  {
                    alignment: 'right',
                    fontSize: 14,
                    text: ''
                  }
                ],
                margin: 20
              }
            });
            // Create a footer object with 2 columns
            // Left side: report creation date
            // Right side: current page and total pages
            doc['footer']=(function(page, pages) {
              return {
                columns: [
                  {
                    alignment: 'left',
                    text: ['Created on: ', { text: jsDate.toString() }]
                  },
                  {
                    alignment: 'right',
                    text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                  }
                ],
                margin: 20
              }
            });
            // Change dataTable layout (Table styling)
            // To use predefined layouts uncomment the line below and comment the custom lines below
            // doc.content[0].layout = 'lightHorizontalLines'; // noBorders , headerLineOnly
            var objLayout = {};
            objLayout['hLineWidth'] = function(i) { return .5; };
            objLayout['vLineWidth'] = function(i) { return .5; };
            objLayout['hLineColor'] = function(i) { return '#aaa'; };
            objLayout['vLineColor'] = function(i) { return '#aaa'; };
            objLayout['paddingLeft'] = function(i) { return 4; };
            objLayout['paddingRight'] = function(i) { return 4; };
            doc.content[0].layout = objLayout;
        }
        }]
} );
} );
</script>
<script type="">
  
  $(document).ready(function() {
  // Function to convert an img URL to data URL
  function getBase64FromImageUrl(url) {
    var img = new Image();
    img.crossOrigin = "anonymous";
    img.onload = function () {
        var canvas = document.createElement("canvas");
        canvas.width =this.width;
        canvas.height =this.height;
        var ctx = canvas.getContext("2d");
        ctx.drawImage(this, 0, 0);
        var dataURL = canvas.toDataURL("image/png");
        return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
    };
    img.src = url;
  }
  // DataTable initialisation
  $('#example').DataTable(
    {
     // "dom": '<"dt-buttons"Bf><"clear">lirtp',
     "dom": 'lBfrtip',
      "paging": true,
      "autoWidth": true,
      "buttons": [
        {
          text: 'Custom PDF',
          extend: 'pdfHtml5',
          filename: 'Ems_application',
          orientation: 'portrait', // landscape
          pageSize: 'A4', //A3 , A5 , A6 , legal , letter
          exportOptions: {
            columns: ':visible',
            search: 'applied',
            //order: 'applied'
          },
          customize: function (doc) {
            //Remove the title created by datatTables
            doc.content.splice(0,1);
            //Create a date string that we use in the footer. Format is dd-mm-yyyy
            var now = new Date();
            var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
            // Logo converted to base64
            // var logo = getBase64FromImageUrl('https://datatables.net/media/images/logo.png');
            // The above call should work, but not when called from codepen.io
            // So we use a online converter and paste the string in.
            // Done on http://codebeautify.org/image-to-base64-converter
            // It's a LONG string scroll down to see the rest of the code !!!
            var logo = 'data:image/jpeg;base64,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ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA=';
            // A documentation reference can be found at
            // https://github.com/bpampuch/pdfmake#getting-started
            // Set page margins [left,top,right,bottom] or [horizontal,vertical]
            // or one number for equal spread
            // It's important to create enough space at the top for a header !!!
            doc.pageMargins = [20,60,20,30];
            // Set the font size fot the entire document
            doc.defaultStyle.fontSize = 7;
            // Set the fontsize for the table header
            doc.styles.tableHeader.fontSize = 7;
            // Create a header object with 3 columns
            // Left side: Logo
            // Middle: brandname
            // Right side: A document title
            doc['header']=(function() {
              return {
                columns: [
                  {
                    image: logo,
                    width: 24
                  },
                  {
                    alignment: 'left',
                    italics: true,
                    text: '',
                    fontSize: 18,
                    margin: [0,0] //margin: [10,0]
                  },
                  {
                    alignment: 'center',
                    fontSize: 14,
                    text: 'TANZANIA POSTS CORPORATION'
                  },
                  {
                    alignment: 'right',
                    fontSize: 14,
                    text: ''
                  }
                ],
                margin: 20
              }
            });
            // Create a footer object with 2 columns
            // Left side: report creation date
            // Right side: current page and total pages
            doc['footer']=(function(page, pages) {
              return {
                columns: [
                  {
                    alignment: 'left',
                    text: ['Created on: ', { text: jsDate.toString() }]
                  },
                  {
                    alignment: 'right',
                    text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                  }
                ],
                margin: 20
              }
            });
            // Change dataTable layout (Table styling)
            // To use predefined layouts uncomment the line below and comment the custom lines below
            // doc.content[0].layout = 'lightHorizontalLines'; // noBorders , headerLineOnly
            var objLayout = {};
            objLayout['hLineWidth'] = function(i) { return .5; };
            objLayout['vLineWidth'] = function(i) { return .5; };
            objLayout['hLineColor'] = function(i) { return '#aaa'; };
            objLayout['vLineColor'] = function(i) { return '#aaa'; };
            objLayout['paddingLeft'] = function(i) { return 4; };
            objLayout['paddingRight'] = function(i) { return 4; };
            doc.content[0].layout = objLayout;
        }
        }]
    });
});



</script>
<script type="text/javascript">
function getEMSType() {

var tariffCat = $('.catid').val();
var weight = $('.catweight').val();

if (weight == '') {

}else{
    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Ems_price_vat')?>",
                 //dataType : "JSON",
                 data : {weight:weight,tariffCat:tariffCat},
                 success: function(data){
                    $('.price').html(data);
                 }
             });
}

};
</script>
<script>
$(document).ready(function() {

    $(".BtnSubmit").on("click", function(event) {

     event.preventDefault();


     var datetime = $('.mydatetimepickerFull').val();
     var emid = $('#emid').val();
     var month2 = $('.month2').val();
     var date = $('.date').val();
     var month = $('.month').val();
     console.log(datetime);
                // alert(datetime);
                $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/Get_EMSDate1",
                 data:'date_time='+ datetime +'&emid='+ emid,
                 success: function(response) {

                    $('.table2').show();
                    $('.table1').hide();
                    $('.results').html(response);

                    $('#fromServer').DataTable( {
                      destroy: true,
                      ordering:false,
                      order: [[3,"desc" ]],
                      fixedHeader: false,
                       lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
                       dom: 'lBfrtip',
                      buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                      ]
                  } );
                        //$('#fromServer').dataTable().clear();
                    }
                });
            });
});
</script>
<script>
$(document).ready(function() {

    $(".BtnSuper").on("click", function(event) {

     event.preventDefault();


     var datetime = $('.mydatetimepickerFull').val();
     var emid = $('.emname').val();
     var emidag = $('.agname').val();
    
     console.log(datetime);
                // alert(datetime);
                $.ajax({

                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/Get_EMSDate1",
                 data:'date_time='+ datetime +'&emid='+ emid+'&emidag='+ emidag,
                 success: function(response) {

                    $('.table2').show();
                    $('.table1').hide();
                    $('.results').html(response);

                    $('#fromServer').DataTable( {
                      destroy: true,
                      ordering:false,
                      order: [[3,"desc" ]],
                      fixedHeader: false,
                       lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
                       dom: 'lBfrtip',
                      buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                      ]
                  } );
                        //$('#fromServer').dataTable().clear();
                }
            });
        });
});
</script>
<script>
$(document).ready(function() {

    $(".BtnSubmit1").on("click", function(event) {

     event.preventDefault();


     var datetime = $('.mydatetimepickerFull').val();
     var emid = $('#emid').val();
     var month2 = $('.month2').val();
     var date = $('.date').val();
     var month = $('.month').val();
     console.log(datetime);
                // alert(datetime);
                $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/Get_EMSDate2",
                 data:'date_time='+ datetime +'&emid='+ emid,
                 success: function(response) {

                    $('.table2').show();
                    $('.table1').hide();
                    $('.results').html(response);

                    $('#fromServer').DataTable( {
                      destroy: true,
                      order: [[3,"desc" ]],
                      fixedHeader: false,
                      dom: 'Bfrtip',
                      buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                      ]
                  } );
                        //$('#fromServer').dataTable().clear();
                    }
                });
            });
});
</script>
<script>
$(document).ready(function() {

    $(".BtnRegBra").on("click", function(event) {

     event.preventDefault();

     var region = $('#regiono').val();
     var branch = $('#branchdropo').val();
     //var date   = $('.date').val();
	 var emid = $('#emid').val();
     console.log(region);
                // alert(region);
                $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/Get_EMSRegionBranch",
                 data:'region='+ region +'&branch='+ branch +'&emid='+ emid,
                 success: function(response) {

                    $('.table2').show();
                    $('.table1').hide();
                    $('.results').html(response);

                    $('#fromServer').DataTable( {
                      destroy: true,
                      ordering:false,
                      order: [[3,"desc" ]],
                      fixedHeader: false,
                      lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
                      dom: 'lBfrtip',
                      buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                      ]
                  } );
                        //$('#fromServer').dataTable().clear();
                    }
                });
            });
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
function getRecDistrict() {
    var val = $('#rec_region').val();
    $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Employee/GetBranch",
     data:'region_id='+ val,
     success: function(data){
         $("#rec_dropp").html(data);
     }
 });
};
</script>
<script type="text/javascript">
function getSelect() {
    var val = $('.wgt').val();
    if(val == 'same'){
        $('.select').hide();
    }else{
        $('.select').show();
    }
};
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
<script type="text/javascript">
$(document).ready(function() {
    $("#checkAll").change(function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkAll").prop("checked", true);
            }
        }
        else {
            $("#checkAll").prop("checked", false);
        }
    });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
    $("#checkAll3").change(function() {
        if (this.checked) {
            $(".checkSingle3").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle3").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingle3").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle3").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkAll3").prop("checked", true);
            }
        }
        else {
            $("#checkAll3").prop("checked", false);
        }
    });
});
</script>

<script>
$(document).ready(function(){
  $(".myBtn").click(function(){

    var text1 = $(this).attr('data-sender_id');
    $('#comid').val(text1);
    $("#myModal").modal();
});
});
</script>
<script>
$(document).ready(function(){
  $(".myBtnEndDay").click(function(){

    //var text1 = $(this).attr('data-sender_id');
    var emid = $('.id').val();
     $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/send_to_back_office",
                 data:'emid='+ emid,
                 success: function(response) {
                    //$('.results').html(response);
                    if ($.trim(response) == "No") {
                       $("#myModalEndDay").modal();
                    }else{
                      $("#myModalEndDay2").modal();
                      $("#empid").val(emid);
                    }
                  }
                });

});
});
</script>
<script type="text/javascript">
    function getDistrict() {
    var region_id = $('#regiono').val();
     $.ajax({

     url: "<?php echo base_url();?>Employee/GetBranch",
     method:"POST",
     data:{region_id:region_id},//'region_id='+ val,
     success: function(data){
         $("#branchdropo").html(data);

     }
 });
};
</script>
<!-- <script type="text/javascript">
$('form').each(function() {
    $(this).validate({
    submitHandler: function(form) {
        var formval = form;
        var url = $(form).attr('action');

        // Create an FormData object
        var data = new FormData(formval);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            // url: "crud/Add_userInfo",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                console.log(response);            
                $(".message").fadeIn('fast').delay(1800).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},1800);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});

    </script> -->
<?php $this->load->view('backend/footer'); ?>

<!-- Modal content-->
