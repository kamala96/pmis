<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Foreign parcel </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Foreign parcel </li>
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
								
							
                          <a href="<?php echo base_url(); ?>Services/Foreign_parcel" class="btn btn-primary waves-effect waves-light">New Foreign parcel</a>
                             <a href="<?php echo base_url(); ?>FP_Application/Receive" class="btn btn-primary waves-effect waves-light">Receive/Itemazation</a>

                            <a href="<?php echo base_url(); ?>FP_Application/foreign_parcel_zone_pass?fromzone=Foreign_parcel" class="btn btn-primary waves-effect waves-light">Pass to small packet cage</a>

                              <!--  <a href="<?php echo base_url(); ?>FP_Application/Pass" class="btn btn-primary waves-effect waves-light">Print Itemization</a> -->
						
								
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
							
                            
 <!-- <div class="row">
                                <div class="col-md-12">
                              <table class="table table-bordered" style="width: 100%;">
                                <tr>
                                    
                  

                            <th style="text-transform: uppercase;"  >
                                       
                                
                           


                            <th style="">
                                 <div class="input-group">
                                    <input id="edValue" type="text" class="form-control col-md-8 edValue" onInput="assignBagProcess(this)">
                                    <br /><br /></div>

                                     <div class="input-group">
                                     <span id="lblValue" class="lblValue ">Barcode scan: </span><br /></div>
                                   
                                     <div class="input-group">
                                     <span id="results" class="  results" style="color: red;"></span>
                                </div>
                            </th>

                            
                             
                        </tr>
                        
                        </table>
                    </div>
                   
                </div> -->

                <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Posta_delivery/search_single_mail_bulk');?>">
                             <div class="input-group">
                                    <input id="edValue" type="text" class="form-control col-md-8 edValue" onInput="assignBagProcess(this)">
                                    <br /><br /></div>

                                     <div class="input-group">
                                     <span id="lblValue" class="lblValue ">Barcode scan: </span><br /></div>
                                   
                                     <div class="input-group">
                                     <span id="results" class="  results" style="color: red;"></span>
                                </div>
                        </form> 

                            


							   <div class="table-responsive " id='emsListData'>
                                   
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
				
<script type="text/javascript">

function getRecDistrict(obj,branch) {
      var val = $(obj).val();
       $.ajax({
       type: "POST",
       url: "<?php echo base_url();?>Employee/GetBranch",
       data:'region_id='+ val,
       success: function(data){
           $("#rec_dropp1").html(data);
            if (branch != 'null') {
            $('#rec_dropp1 option[value="'+branch+'"]').prop('selected', true)
           }
       }
   });
  };

function getbags() {
  var val = $('#bagss').val();
  if(val != 'New Bag'){
      $('#rec_region').attr('disabled', 'disabled');
     $('#rec_dropp1').attr('disabled', 'disabled');
  }
  else{
      $('#rec_region').removeAttr('disabled');
     $('#rec_dropp1').removeAttr('disabled');

  }
};


function Submitvalue(obj) {
    var transId = $(obj).attr('data-transid');
    $('#tr'+transId).remove();
    //var bagnoSelectedText = $('#bagss option:selected').text();
    //var currentRow = $('#emsListData tr').length;
    //$('#countingNumber').html(currentRow);

    var itemnumber = $('#itemnumber').val();
    var postedat = $('#postedat').val();
    var pocharges = $('#pocharges').val();
    var hndlcharges = $('#hndlcharges').val();
    var customsfee = $('#customsfee').val();
    var demurragefee = $('#demurragefee').val();
    var othercharges = $('#othercharges').val();
    var addressedto = $('#addressedto').val();
    var serial = $('#serial').val();
    var cardno = $('#cardno').val();
    var boxnumber = $('#boxnumber').val();
    var phone = $('#phone').val();
    var identity = $('#identity').val();
   
    
    $.ajax({
        type : 'POST',
        url  : '<?php echo base_url('FP_Application/submit_Packet_itemized_scanned')?>',
        data : {transactionid:transId,
                itemnumber:itemnumber,
                postedat:postedat,
                pocharges:pocharges,
                hndlcharges:hndlcharges,
                customsfee:customsfee,
                demurragefee:demurragefee,
                othercharges:othercharges,
                addressedto:addressedto,
                serial:serial,
                cardno:cardno,
                boxnumber:boxnumber,
                phone:phone,
                identity:identity},
                dataType:'json',
                success:function(response){
                    //console.log(response)
            
            if (response['status'] == 'Success') {
                $('#loadingtext').html(response['msg']);
                $('#emsListData').html('');
                  $('#forMessage').show();
                  $('#notifyMessage').html(response['msg']);
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

function Cancelvalue(obj) {
    var transId = $(obj).attr('data-transid');
    $('#tr'+transId).remove();
    //var bagnoSelectedText = $('#bagss option:selected').text();
    //var currentRow = $('#emsListData tr').length;
    //$('#countingNumber').html(currentRow);
      $('#emsListData').html('')
    
    // $.ajax({
    //     type : 'POST',
    //     url  : '<?php echo base_url('Packet_Application/cancel_Packet_itemized_scanned')?>',
    //     data : {transactionid:transId},
    //     dataType:'json',
    //     success:function(response){
            
    //         if (response['status'] == 'Success') {
    //             $('#loadingtext').html(response['msg']);
    //              $('#emsListData').html('')
    //         }else{
    //             $('#loadingtext').html(response['msg']);
    //         }

    //         setTimeout(function(){
    //             $('#loadingtext').html('');
    //         },3000)
    //     }
    //    });
}



function assignBagProcess(obj){
        var barcode = $(obj).val();
        //var rec_region = $('#rec_region').val();
        //var rec_branch = $('#rec_branch').val();

        $('#loadingtext').html('Please wait............');
          //var sno = nextSerialNo();
          //if(sno == null)sno = 1;
        

        if (barcode) {

            if (barcode.length == 13) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>FP_Application/itemize_item_general_process",
                    data:{
                        barcode:barcode},
                    dataType:'json',
                    success:function(response){
                        $(obj).val('')
                        //console.log(response)
                       
                        if (response['status'] == 'Success') {
                               // $('#emsListData').append(response['msg'])
                                 $('#emsListData').html(response['msg'])
                                $('#loadingtext').html(response['status']);
                                  $('#forMessage').show();
        $                       ('#notifyMessage').html(response['status']);
                                //$('#bagss').html(response['select']);
                        }else{
                           $('#loadingtext').html(response['msg']);
                            $('#forMessage').show();
        $                       ('#notifyMessage').html(response['msg']);
                        }

                         setTimeout(function(){
                            $('#loadingtext').html('');

                        },3000)

                    },error:function(jqXHR, textStatus, errorThrown){
                        //console.log(textStatus)
                    }
                })
            }

       }else{
        $(obj).val('')
        $('#loadingtext').html('<strong>Please Input correct barcode</strong>')
        }

    }

    function nextSerialNo(){
        var num = $('#emsListData tr:last-child td:first-child').html();
       
        if (num == 'No pending assigned') {
            return parseInt(1); 
        }else if(num == 'No data found'){
            return parseInt(1); 
        }else if(num == 'NaN'){
            return parseInt(1); 
        }else if(typeof(num) == 'undefined'){
            return parseInt(1);
        }else{
            return parseInt(num) + 1;
        }
        
    }


$(document).ready(function() {

var table = $('#example5').DataTable( {
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

    <?php $this->load->view('backend/footer'); ?>