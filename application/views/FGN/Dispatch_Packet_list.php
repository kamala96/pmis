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
                                            
                                                
                        <table class="table table-bordered" style="width: 100%;">
                           <tr>
                              <th style="">
                                 <label>Select Date:</label>
                                 <div class="input-group">
                                    <input type="text" placeholder="From date" name="fromdate" class="form-control  mydatetimepickerFull col-md-4" id="fromdate">

                                    <input type="text" name="todate" placeholder="To date" class="form-control  mydatetimepickerFull col-md-4" id="todate">

                                     <input type="text" name="check" onclick='Submitvalue(this)' class="btn btn-success col-md-2" style="" id="BtnSubmit" value="Submit" required="required">
                                      </div>
                              </th>
                           </tr>
                        </table>
                         
                     </div>

                       <div class="table-responsive " >


                         <div class="table-responsive ">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
                                                <th> Region From </th>
                                                <th> Branch From </th>
                                                <th> Dispatched By </th>
                                                <th> Dispatch Number </th>
                                                <th> Dispatched Date </th>
                                                 <th> Weight  </th>
                                                 <th> Region To </th>
                                                <th> Branch To </th>
                                                 <th> Transport Type  </th>
                                                 <th> Transport Name  </th>
                                                  <th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody class="" id='emsListData'>   

                                        <?php 
										$sn=1;
										foreach($outsidesmallpacket as $data){
										?>
                                            <tr>
                                                <td> <?php echo $sn; ?> </td>
                                                <td> <?php echo $data->region_from; ?> </td>
                                                <td> <?php echo $data->branch_from; ?> </td>
                                                <td> <?php echo $data->despatch_by; ?> </td>
                                                <td> <?php echo $data->desp_no; ?> </td>
                                                <td> <?php echo $data->despatch_date; ?> </td>
                                                <td> <?php echo $data->weight; ?> </td>
                                                <td> <?php echo $data->region_to; ?> </td>
                                                <td> <?php echo $data->branch_to; ?> </td>
                                                <td> <?php echo $data->transport_type; ?> </td>
                                                <td> <?php echo $data->transport_name; ?> </td>
                                                <td class="jsgrid-align-center ">
                                                <a href="<?php echo base_url(); ?>Packet_Application/print_Dispatch_Packet_report?desp_no=<?php echo $data->desp_no; ?>" class="btn btn-sm btn-danger waves-effect waves-light"> <i class="fa fa-print"></i>Print</a>
									
                                                </td>
                                            </tr>
										<?php 
										$sn++;
										?>
								
										<?php }?>  
										
                                        
                                            
                                        </tbody>
                                    </table>
                                </div>
                                   
                                </div>
										
                                </div>
                           

                            </div>
                        </div>
                    </div>
                </div>
				
<script>
   
function Submitvalue(obj) {

    var todate = $('#todate').val();
    var fromdate = $('#fromdate').val();
    
    $.ajax({
        type : 'POST',
        url  : '<?php echo base_url('Packet_Application/Packets_Dispatched')?>',
        data : {fromdate:fromdate,
                todate:todate
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