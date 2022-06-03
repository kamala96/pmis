<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
  <div class="message"></div>
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Ems Application List</h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Ems Application List</li>
      </ol>
    </div>
  </div>
  <!-- Container fluid  -->
  <!-- ============================================================== -->
  <?php $regionlist = $this->employee_model->regselect(); ?>
  <div class="container-fluid">
    <div class="row m-b-10">
      <div class="col-12">
        <a href="<?php echo base_url() ?>Box_Application/Ems" class="btn btn-primary"><i class="fa fa-plus"></i> Ems Application</a>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Ems Application List</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Box_Application/Credit_Customer" class="text-white"><i class="" aria-hidden="true"></i> Create Bill Customer</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_BackOffice" class="text-white"><i class="" aria-hidden="true"></i> Ems Back Office List</a></button>
      </div>    
    </div> 

    <div class="row">
      <div class="col-12">
        <div class="card card-outline-info">
          <div class="card-header">
            <h4 class="m-b-0 text-white"> Ems Application List                       
            </h4>
          </div>
          <div class="card-body">

            <div class="card">
             <div class="card-body">

              <form method="POST" action="send_to_back_office">
                <div class="table-responsive">
                            <!-- <table style="width: 100%;"><tr><th>
                                 <label>Select Date:</label>
                                <div class="input-group">

                                    <input type="text" name="" class="form-control col-md-3 mydatetimepickerFull">
                                <input type="button" name="" class="btn btn-info" style="" id="BtnSubmit" value="Search Date">
                                </div>
                                
                              </th></tr></table> -->
                              <span class="table1">
                                <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                  <thead>
                                    <tr>
                                      <th>Sender Name</th>
                                      <th>Registered Date</th>
                                      <th>Amount (Tsh.)</th>
                                      <th>Region Origin</th>
                                      <th>Branch Origin</th>
                                      <th>Destination</th>
									  <th>Destination Branch</th>
                                      <th>Bill Number</th>
                                      <th>Tracking Number</th>
                                      <th>Transfer Status</th>
                                      <th style="text-align: right;">Received By</th>

                                    </tr>
                                  </thead>

                                  <tbody class="">
                                   <?php foreach ($emslist as  $value) {?>
                                     <tr>
                                       <td><?php echo $value->s_fullname;?></td>
                                       <td><?php 
                                       echo $value->date_registered;
                                                   //echo $value->date_registered;
                                       ?></td>
                                       <td><?php echo number_format($value->paidamount,2);?></td>
                                       <td><?php echo $value->s_region;?></td>
                                       <td><?php echo $value->s_district;?></td>
                                       
                                       
                                       <td><?php echo $value->r_region;?></td>
									   <td><?php echo $value->branch;?></td>
                                       <td>
                                        <?php 
                                        if ($value->status == "Bill") {
                                         echo strtoupper($value->s_pay_type);
                                        } else {
                                          echo $value->billid;
                                        }
                                        
                                        ?>
                                        
                                       
                                       
                                     </td>
                                     <td>
                                      <a href="<?php echo base_url();?>Box_Application/item_qrcode?code=<?php echo base64_encode($value->track_number) ?>" target="_blank"><?php echo $value->track_number;?></a>

                                    </td>
                                    <td>
                                      <?php if ($value->office_name == 'Received') {?>
                                        <button type="button" class="btn  btn-success btn-sm" disabled="disabled">Successfully Transfer</button>
                                      <?php }else{ ?>
                                       <button type="button" class="btn  btn-danger btn-sm" disabled="disabled"> Pending To Back Office</button>
                                     <?php }?>

                                   </td>
                                   <td style="color: red;">
                                    <?php 
                                    $id = $value->created_by;
                                    @$info = $this->employee_model->GetBasic($id);
                                    echo 'PF:'." ".@$info->em_code.'  '.@$info->first_name.'  '.@$info->last_name;
                                    ?>
                                  </td>

                                </tr>
                              <?php } ?>

                            </tbody>

                          </table>
                        </span>

                        <span class="table2" style="display: none;">

                          <table id="fromServer" class="display nowrap table table-hover table-striped table-bordered searchResult" cellspacing="0" width="100%" >
                            <thead>
                              <tr>
                                <th>Sender Name</th>
                                <th>Receiver Name</th>
                                <th>Item Name</th>
                                <th>Registered Date</th>
                                <th>Item Type</th>
                                <th>Amount (Tsh.)</th>
                                <th>Destination</th>
                                <th>Bill Number</th>
                                <th>Tracking Number</th>
                                <th>Transfer Status</th>
                                <th style="text-align: right;">Payment Status</th>
                                <th>
                                  <div class="form-check" style="text-align: right;" id="showCheck">
                                   <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                   <label class="form-check-label" for="remember-me">Select All</label>
                                 </div>
                               </th>
                             </tr>
                           </thead>

                           <tbody class="results">


                           </tbody>
                           <footer>
                            <tr><td colspan="11"></td><td style="text-align: center;"><button type="submit" class="btn btn-info btn-sm">Send To BackOffice </button></td></tr>
                          </footer>
                        </table>
                      </span>
                    </div>
                    <input type="hidden" name="type" value="EMS">
                  </form>
                </div>
              </div>



            </div>
          </div>

        </div>

      </div>
    </div>

    <script>
      $(document).ready(function() {

        $("#BtnSubmit").on("click", function(event) {

         event.preventDefault();


         var datetime = $('.mydatetimepickerFull').val();
         console.log(datetime);
                    // alert(datetime);
                    $.ajax({
                     type: "POST",
                     url: "<?php echo base_url();?>Box_Application/Get_EMSDate",
                     data:'date_time='+ datetime,
                     success: function(response) {

                      $('.table2').show();
                      $('.table1').hide();
                      $('.results').html(response);
                            //alert(response);
                            $('#fromServer').dataTable().destroy();
                            $('#fromServer').DataTable( {
                            //destroy: true,
                            orderCellsTop: false,
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
<!-- <script type="text/javascript">
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
</script> -->
<script type="text/javascript">
  $(document).ready(function() {


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
    // Setup - add a text input to each footer cell
    // $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
    // $('#example4 thead tr:eq(1) th').not(":eq(9),:eq(10),:eq(11)").each( function (i) {
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );

    //     $( 'input', this ).on( 'keyup change', function () {
    //         if ( table.column(i).search() !== this.value ) {
    //             table
    //                 .column(i)
    //                 .search( this.value )
    //                 .draw();
    //         }
    //     } );
    // } );

    var table = $('#example4').DataTable( {
      orderCellsTop: true,
      ordering: false,
      order: [[1,"desc" ]],
      fixedHeader: true,
      dom: 'B1frtip',
      buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    } );
  } );
</script>
<?php $this->load->view('backend/footer'); ?>

