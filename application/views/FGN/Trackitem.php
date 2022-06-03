<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Small Packet </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Small Packet </li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">

                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> 
								
							
                          <a href="<?php echo base_url(); ?>Services/Small_Packets" class="btn btn-primary waves-effect waves-light">New Small Packet</a>
                             <a href="<?php echo base_url(); ?>Packet_Application/Receive" class="btn btn-primary waves-effect waves-light">Receive/Itemazation</a>

                              <!-- <a href="<?php echo base_url(); ?>Packet_Application/Itemize" class="btn btn-primary waves-effect waves-light">Itemized Item</a> -->

                              <a href="<?php echo base_url(); ?>Packet_Application/Pass" class="btn btn-primary waves-effect waves-light">Print Itemization</a>
                              <a href="<?php echo base_url(); ?>Packet_Application/Dispatch_Packet_list" class="btn btn-primary waves-effect waves-light">Print Regional Dispatched </a>
                              <a href="<?php echo base_url(); ?>Packet_Application/Dispatch_label" class="btn btn-primary waves-effect waves-light">Print Label </a>
								
								
							 </h4>
                            </div>
							
                            <div class="card-body">


                                    <div style="display: none; font-size: 25px;background-color: #d22c19;color: white;" id="forMessage" class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong id="notifyMessage"></strong>
                        </div>
                            
							
							<?php 
							if(!empty($this->session->flashdata('message'))){
							echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
									  <?php echo $this->session->flashdata('message'); ?>
									  <?php
                            echo "</div>";
							
							}
							?>

							<?php 
							if(!empty($this->session->flashdata('feedback'))){
							echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
									  <?php echo $this->session->flashdata('feedback'); ?>
									  <?php
                            echo "</div>";
							
							}
							?>


                              <div class="col-md-12">
                                            
                                                 <!-- <form class="row" method="post" action="<?php echo site_url('Packet_Application/TrackItem');?>"> -->
                        <table class="table table-bordered" style="width: 100%;">
                           <tr>
                              <th style="">
                                 <label>Scan / Input Barcode Number:</label>
                                 <div class="input-group">
                                    <input type="text" placeholder="Scan/Input Barcode Number" name="fgn_no" class="form-control col-md-4  fgn_no" id="fgn_no">

                                    <!-- <input type="text" name="todate" placeholder="To date" class="form-control  mydatetimepickerFull col-md-4" id="todate"> -->

                                   <!--  <input type="button" name="" class="btn btn-success BtnSubmit col-md-2" style="" id="BtnSubmit" value="Submit" required="required"> -->
                                     <input type="text" name="check" onclick='Submitvalue(this)' class="btn btn-success col-md-2" style="" id="BtnSubmit" value="Search" required="required">
                                    <!-- <input type="submit" name="check"  class="btn btn-success  col-md-2" style="" id="BtnSubmit012" value="Print" required="required"> -->
                                 </div>
                              </th>
                           </tr>
                        </table>
                         <!-- </form> -->
                     </div>

                       <div class="table-responsive " >

                         <div class="table-responsive ">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
                                                <th> Small Packet Number </th>
                                                <th> Region From </th>
                                                <th> Branch From</th>
                                                <th> Region To</th>
                                                <th> Branch To</th>
                                                  <th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody class="" id='emsListData'>   
                                         <tr>
                                    <td colspan="6"></td>
                                  </tr>                             
                                            
                                        </tbody>
                                    </table>
                                </div>
                                   
                                </div>
							
                          
                            


                            </div>
                        </div>
                    </div>
                </div>
				
<script>
   
function Submitvalue(obj) {

    var fgn_no = $('#fgn_no').val();
    
    $.ajax({
        type : 'POST',
        url  : '<?php echo base_url('Packet_Application/TrackItem')?>',
        data : {fgn_no:fgn_no
               },
                dataType:'json',
                success:function(response){
            
            if (response['status'] == 'Success') {
                $('#emsListData').html(response['msg']);
                //$('#emsListData').html('');
                  $('#forMessage').show();
                  $('#notifyMessage').html(response['status']);
                 //$('#emsListData').append(response['msg2'])
            }else{
                $('#loadingtext').html(response['msg']);
                 $('#forMessage').show();
                  $('#notifyMessage').html(response['msg']);
            }

            setTimeout(function(){
                $('#loadingtext').html('');
            },3000)
        }
       });
}

function Printvalue(obj) {
  var transId = $(obj).attr('data-transid');
    $('#tr'+transId).remove();
    
    $.ajax({
        type : 'POST',
        url  : '<?php echo base_url('Packet_Application/print_Packet_Passto_report')?>',
        data : {FGN_number:transId},
                dataType:'json',
                success:function(response){
            
            if (response['status'] == 'Success') {
                $('#loadingtext').html(response['msg']);
                $('#emsListData').html('');
                  $('#forMessage').show();
                  $('#notifyMessage').html(response['status']);
                 //$('#emsListData').append(response['msg2'])
            }else{
                $('#loadingtext').html(response['msg']);
                 $('#forMessage').show();
                  $('#notifyMessage').html(response['msg']);
            }

            setTimeout(function(){
                $('#loadingtext').html('');
            },3000)
        }
       });
}


function Printvalues(obj) {   //many
   var todate = $('#todate').val();
    var fromdate = $('#fromdate').val();
    
    $.ajax({
        type : 'POST',
        url  : '<?php echo base_url('Packet_Application/print_Packets_Passto_reports')?>',
        data : {fromdate:fromdate,
                todate:todate
               },
                dataType:'json',
                success:function(response){
            
            if (response['status'] == 'Success') {
                $('#loadingtext').html(response['msg']);
                $('#emsListData').html('');
                  $('#forMessage').show();
                  $('#notifyMessage').html(response['status']);
                 //$('#emsListData').append(response['msg2'])
            }else{
                $('#loadingtext').html(response['msg']);
                 $('#forMessage').show();
                  $('#notifyMessage').html(response['msg']);
            }

            setTimeout(function(){
                $('#loadingtext').html('');
            },3000)
        }
       });
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
    'copy', 'csv', 'excel', 'pdf', 'print'
    ]
} );
} );
</script>


    <?php $this->load->view('backend/footer'); ?>