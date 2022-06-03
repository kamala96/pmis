<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
   <div class="message"></div>
   <div class="row page-titles">
      <div class="col-md-5 align-self-center">
         <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i>&nbsp 
            <?php 
               $id = $this->session->userdata('user_login_id');
               $basicinfo = $this->employee_model->GetBasic($id); 
                               //     if (!empty($id)) {
                               //         echo $basicinfo->em_role;
                               //        } ?>
            Delivery Performance reports
         </h3>
      </div>
      <div class="col-md-7 align-self-center">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">
               Deliver report
            </li>
         </ol>
      </div>
   </div>
   <!-- Container fluid  -->
   <!-- ============================================================== -->
   <div class="container-fluid">
      <br>
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-body">
                  <div class="col-md-12">
                     <h5>
                     </h5>
                  </div>
                  <div class="row">
                     <div class="row">
                        <div class="col-md-12">
                           <h4 class="statusText"></h4>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <table class="table table-bordered" style="width: 100%;">
                           <tr>
                              <th style="">
                                 <label>Select Date:</label>
                                 <div class="input-group">
                                    <input type="text" placeholder="From date" name="" class="form-control  mydatetimepickerFull" id="fromdate">

                                    <input type="text" name="" placeholder="To date" class="form-control  mydatetimepickerFull" id="todate">

                                    <input type="button" name="" class="btn btn-success BtnSubmit" style="" id="" value="Get report" required="required">
                                 </div>
                              </th>
                           </tr>
                        </table>
                     </div>
                  </div>
                  <div class="table-responsive despatch1" style="">
                     <div class="">
                        <form style="" method="POST" action="despatch_action">
                           <table id="despatchIn" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                              <thead>
                                 <tr>
                                    <th>SN</th>
                                    <th>Operator</th>
                                    <th>Region</th>
                                    <th>Branch</th>
                                    <th>Completed</th>
                                    <th>Pending</th>
                                    <th>Total Assinged</th>
                                    <th>Percent(%)</th>
                                    <th>Comment</th>
                                 </tr>
                              </thead>
                              <tbody id="tableData">
                                 
                              </tbody>
                              
                           </table>
                        </form>
                     </div>
                  </div>
                  <div class="table-responsive despatch2" style="display: none;">
                     <div class="result">          
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- ============================================================== -->
</div>
<script>
   $(document).ready(function() {
   
       $(".BtnSubmit").on("click", function(event) {
            event.preventDefault();
           var fromdate = $('#fromdate').val();
           var todate = $('#todate').val();
       $('.statusText').html('<h3><strong>Please wait (Tafadhali subiri).......</strong></h3>');

             $.ajax({
              type: "POST",
              url: "<?php echo base_url();?>Box_Application/getAssignedDeliveryItems",
              data:{fromdate:fromdate,todate:todate},
              dataType:'json',
              success: function(response) {
               //console.log(response);
               var htmldata='';

               if (response['status'] = 'Success') {
                  var count  = 1;
                  var comment = '';
                  var total = '';
                  var parcent = '';
                  $.each(response['msg'], function(index,data){
                     comment = (data['pending'] == 0 )? 'Excellent':'Bad';
                     total= parseInt(data['completed']) + parseInt(data['pending']);
                     parcent = parseInt(parseInt(data['completed']) * 100 / total);

                     htmldata+="<tr> <td>"+(count++)+"</td>"+
                     "<td>"+data['fullname']+"</td>"+
                     "<td>"+data['em_region']+"</td>"+
                     "<td>"+data['em_branch']+"</td>"+
                     "<td><a href='<?php echo base_url();?>Services/printDeliveryItems?fromdate="+data['fromdate']+"&todate="+data['todate']+"&status=0&empid="+data['empid']+"'>"+data['completed']+"</a></td>"+
                     "<td><a href='<?php echo base_url();?>Services/printDeliveryItems?fromdate="+data['fromdate']+"&todate="+data['todate']+"&status=1&empid="+data['empid']+"'>"+data['pending']+"</a></td>"+
                     "<td>"+total+"</td>"+
                     "<td>"+parcent+"%</td>"+
                     "<td>"+comment+"</td></tr>";
                     
                  })
                  $('#tableData').append(htmldata);
                  $('.statusText').html(response['status']);
               }
                 }
             });
       });

   });
   
   
   
   function formSubmit(obj){
       $('.statusText').html('<h3><strong>Please wait (Tafadhali subiri).......</strong></h3>');
   
       var selectedData = [];
       var despatchno = $(obj).attr('data-despno');
   
       //creating the array for posting in the controller
       $.each($("input[name='I']:checked"), function(){
           selectedData.push($(this).val());
       });
   
       //Send to the server
       $.ajax({
              type: "POST",
              url: "<?php echo base_url();?>Box_Application/receive_action",
              data: 'selected='+selectedData+'&despatchno='+despatchno, 
              success: function(response){
               
                   $('.despatch1').hide();
                   $('.despatch2').show();
                   $('.result').html(response);
   
              },error:function(){
                   console.log('An error occurred.');
                   //console.log(data);
              }
         });
   }
   
   
   function receiveBagItems(obj){
   
     $('.statusText').html('<h3><strong>Please wait (Tafadhali subiri) .......</strong></h3>');
    
       var bagno = $(obj).attr('data-bagno');
       var despatch = $(obj).attr('data-despno');
   
       $.ajax({
          type: "POST",
          url: "<?php echo base_url();?>Box_Application/receiveBagItems",
          data:'despatchno='+despatch+'&bagno='+bagno,
          success: function(response) {
              $('.despatch1').hide();
              $('.despatch2').show();
              $('.result').html(response);
             }
         });
   
   }
   
   function enquaryItem(obj){
     var itemid = $(obj).attr('data-itemid');
     //sending the data to the server
     $.ajax({
       type: "POST",
       url: "<?php echo base_url();?>Box_Application/enquaryItem",
       data:'itemid='+ itemid,
       success: function(response) {
         //if(response == 'Success'){
           $(obj).closest('.receiveRow').remove();
           //console.log(itemid);
         //}
          //console.log(response);
         
       }
     });
   
   }
   
   
   function edValueKeyPress() {
   
       var date = $('#date').val();
       var month = $('#month').val();   
       var region = $('#region').val();
   
       var edValue = $('#edValue').val();
       var s = edValue;
       
       var txt = "The barcode number is: " + s;
       var lblValue = $('#lblValue').val();
       $('.lblValue').html(txt);
   
       var barcodeClass = '.'+s;
   
       console.log(barcodeClass);
   
       //find parent
       var tr = $(barcodeClass).closest('.receiveRow').css({
         "background":"white",
         "color":"black"
       })
   
       $(barcodeClass).each(function() {
           this.checked = true;
           $('#edValue').val('');
       });
      
   }
   
   
</script>
<script>
   $(document).ready(function() {
   
       $(".BtnMonth").on("click", function(event) {
   
        event.preventDefault();
        
        var month1 = $('.month1').val();
        var month2 = $('.month2').val();
          $.ajax({
           type: "POST",
           url: "<?php echo base_url();?>Box_Application/Get_Despatch_In_ByMonth",
           data:'month1='+ month1 +'&month2='+ month2,
           success: function(response) {
            
                   $('.despatch1').hide();
                   $('.despatch2').show();
                   $('.result').html(response);
              }
          });
      });
   });
</script>
<script type="text/javascript">
   $(document).ready(function(){
     $("#show1").click(function(){
       alert('mussa');
     });
   });
</script>    
<script>
   function transportType() {
     var ty = $('.type').val();
   
     if (ty == '') {
       alert('1');
     }else if(ty == 'Public Truck' || ty == 'Public Buses'){
       $('.cost').show();
     }else{
      $('.cost').hide();
    }
   }
</script>
<script>
   $(document).ready(function(){
   
     $(".ems1").click(function(){
       $(".ems").show();
       $(".ems2").hide();
       $(".mails").hide();
       $(".emsbags").hide();
       $(".itemlist").hide();
       $(".despatch1").hide();
       $(".bags_item_list").hide();
       $(".bagsList").hide();
       $(".despatchIn1").hide();
     });
     $(".ems12").click(function(){
       $(".ems2").show();
       $(".ems").hide();
       $(".mails").hide();
       $(".emsbags").hide();
       $(".itemlist").hide();
       $(".despatch1").hide();
       $(".bags_item_list").hide();
       $(".bagsList").hide();
       $(".despatchIn1").hide();
     });
     $(".item").click(function(){
       $(".ems").show();
       $(".ems2").hide();
       $(".mails").hide();
       $(".emsbags").hide();
       $(".itemlist").hide();
       $(".despatch1").hide();
       $(".bags_item_list").hide();
       $(".bagsList").hide();
       $(".despatchIn1").hide();
     });
     $("#mails").click(function(){
       $(".ems").hide();
       $(".ems2").hide();
       $(".mails").show();
       $(".emsbags").hide();
       $(".itemlist").hide();
       $(".despatch1").hide();
       $(".bags_item_list").hide();
       $(".bagsList").hide();
       $(".despatchIn1").hide();
     });
     $(".emsbags1").click(function(){
       $(".emsbags").show();
       $(".ems").hide();
       $(".ems2").hide();
       $(".mails").hide();
       $(".itemlist").hide();
       $(".despatch1").hide();
       $(".bags_item_list").hide();
       $(".bagsList").hide();
       $(".despatchIn1").hide();
     });
   
     $(".despatch").click(function(){
       $(".despatch1").show();
       $(".emsbags").hide();
       $(".ems").hide();
       $(".ems2").hide();
       $(".mails").hide();
       $(".itemlist").hide();
       $(".bags_item_list").hide();
       $(".bagsList").hide();
       $(".despatchIn1").hide();
     });
   
     $(".despatchIn").click(function(){
       $(".despatch1").hide();
       $(".despatchIn1").show();
       $(".emsbags").hide();
       $(".ems").hide();
       $(".ems2").hide();
       $(".mails").hide();
       $(".itemlist").hide();
       $(".bags_item_list").hide();
       $(".bagsList").hide();
     });
   
     $(".listitem").click(function(){
   
       var type = 'EMS';
       var bagno = $(this).attr('data-bagno');
       var reg   = $('.reg').val();
       $.ajax({
   
        url: "<?php echo base_url();?>Box_Application/bags_item_list",
        method:"POST",
   data:{bagno:bagno,type:type},//'region_id='+ val,
   success: function(data){
   
   $('.listresults').html(data);
   
   //$(".itemlist").show();
   $(".bags_item_list").show();
   $(".emsbags").hide();
   $(".ems").hide();
   $(".ems2").hide();
   $(".mails").hide();
   $(".despatch1").hide();
   $(".bagsList").hide();
   $(".despatchIn1").hide();
   
   //$('#fromServer').dataTable().clear();
   $('#fromServer').DataTable( {
   orderCellsTop: true,
   destroy:true,
   order: [[3,"desc" ]],
   fixedHeader: true,
   dom: 'Bfrtip',
   buttons: [
   'copy', 'csv', 'excel', 'pdf', 'print'
   ]
   } );
   
   
   }
   });
   
     });
     $(".bagsList12").click(function(){
   
       var type = 'EMS';
       var despno = $(this).attr('data-despno');
   
       $.ajax({
   
        url: "<?php echo base_url();?>Box_Application/bags_list_despatch",
        method:"POST",
   data:{despno:despno,type:type},//'region_id='+ val,
   success: function(data){
   
   $('.bagresults').html(data);
   
   //$(".itemlist").show();
   $(".bags_item_list").hide();
   $(".bagsList").show();
   $(".emsbags").hide();
   $(".ems").hide();
   $(".ems2").hide();
   $(".mails").hide();
   $(".despatch1").hide();
   $(".despatchIn1").hide();
   //$('#example47').dataTable().destroy();
   $('#example47').DataTable( {
   //orderCellsTop: true,
   destroy:true,
   fixedHeader: true,
   dom: 'Bfrtip',
   buttons: [
   'copy', 'csv', 'excel', 'pdf', 'print'
   ]
   } );
   
   
   }
   });
   
     });
   
   });
</script>
<script type="text/javascript">
   $(document).ready(function() {
     
       var table = $('#example4').DataTable( {
           //orderCellsTop: true,
           fixedHeader: true,
           order: [[4,"desc" ]],
           dom: 'Bfrtip',
           buttons: [
           'copy', 'csv', 'excel', 'pdf', 'print'
           ]
         } );
     } );
</script>
<script type="text/javascript">
   $(document).ready(function() {
    
     var table = $('#example42').DataTable( {
         //orderCellsTop: true,
         fixedHeader: true,
         order: [[4,"desc" ]],
         dom: 'Bfrtip',
         buttons: [
         'copy', 'csv', 'excel', 'pdf', 'print'
         ]
       } );
   } );
</script>
<script type="text/javascript">
   $(document).ready(function() {
     // //$('#example5 thead tr').clone(true).appendTo( '#example5 thead' );
     // $('#example5 thead tr:eq(1) th').not(":eq(7),:eq(8)").each( function (i) {
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
   
     var table = $('#example5').DataTable( {
         //orderCellsTop: true,
         fixedHeader: true,
         order: [[4,"desc" ]],
         dom: 'Bfrtip',
         buttons: [
         'copy', 'csv', 'excel', 'pdf', 'print'
         ]
       } );
   } );
</script>
<script type="text/javascript">
   $(document).ready(function() {
     var table = $('#despatch').DataTable( {
         //orderCellsTop: true,
         fixedHeader: true,
         order: [[4,"desc" ]],
         dom: 'Bfrtip',
         buttons: [
         'copy', 'csv', 'excel', 'pdf', 'print'
         ]
       } );
   } );
</script>
<script type="text/javascript">
   $(document).ready(function() {
     var table = $('#despatchIn').DataTable( {
         //orderCellsTop: true,
         fixedHeader: true,
         ordering:false,
         order: [[5,"desc" ]],
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
</script><script type="text/javascript">
   $(document).ready(function() {
     $("#checkAlls").change(function() {
       if (this.checked) {
         $(".checkSingles").each(function() {
           this.checked=true;
         });
       } else {
         $(".checkSingles").each(function() {
           this.checked=false;
         });
       }
     });
   
     $(".checkSingles").click(function () {
       if ($(this).is(":checked")) {
         var isAllChecked = 0;
   
         $(".checkSingles").each(function() {
           if (!this.checked)
             isAllChecked = 1;
         });
   
         if (isAllChecked == 0) {
           $("#checkAlls").prop("checked", true);
         }     
       }
       else {
         $("#checkAlls").prop("checked", false);
       }
     });
   });
</script>
<script type="text/javascript">
   $(document).ready(function() {
     $("#checkAll1").change(function() {
       if (this.checked) {
         $(".checkSingle1").each(function() {
           this.checked=true;
         });
       } else {
         $(".checkSingle1").each(function() {
           this.checked=false;
         });
       }
     });
   
     $(".checkSingle1").click(function () {
       if ($(this).is(":checked")) {
         var isAllChecked = 0;
   
         $(".checkSingle1").each(function() {
           if (!this.checked)
             isAllChecked = 1;
         });
   
         if (isAllChecked == 0) {
           $("#checkAll1").prop("checked", true);
         }     
       }
       else {
         $("#checkAll1").prop("checked", false);
       }
     });
   });
</script>
<script type="text/javascript">
   $(document).ready(function() {
     $("#checkAll4").change(function() {
       if (this.checked) {
         $(".checkSingle4").each(function() {
           this.checked=true;
         });
       } else {
         $(".checkSingle4").each(function() {
           this.checked=false;
         });
       }
     });
   
     $(".checkSingle4").click(function () {
       if ($(this).is(":checked")) {
         var isAllChecked = 0;
   
         $(".checkSingle4").each(function() {
           if (!this.checked)
             isAllChecked = 1;
         });
   
         if (isAllChecked == 0) {
           $("#checkAll4").prop("checked", true);
         }     
       }
       else {
         $("#checkAll4").prop("checked", false);
       }
     });
   });
</script>
<script>
   $(document).ready(function() {
   
     $("#BtnSubmit").on("click", function(event) {
   
      event.preventDefault();
   
      var datetime = $('.mydatetimepickerFull').val();
      console.log(datetime);
                 // alert(datetime);
                 $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>Box_Application/Get_Despatch_List_Date",
                  data:'date_time='+ datetime,
                  success: function(response) {
                   $('.fromServer1').show();
                   $('.despatchdiv').hide();
                   $('.fromServer1').html(response);
                 }
               });
               });
   });
</script>
<script type="text/javascript">
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
   
       
</script>
<?php $this->load->view('backend/footer'); ?>