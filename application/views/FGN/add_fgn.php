<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 


<style>
.overlay{
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 999;
    background: rgba(255,255,255,0.8) url("loader-img.gif") center no-repeat;
}
/* Turn off scrollbar when body element has the loading class */
body.loading{
    overflow: hidden;   
}
/* Make spinner image visible when body element has the loading class */
body.loading .overlay{
    display: block;
}

#btn_save:focus{
  outline:none;
  outline-offset: none;
}

.button {
    display: inline-block;
    padding: 6px 12px;
    margin: 20px 8px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    background-image: none;
    border: 2px solid transparent;
    border-radius: 5px;
    color: #000;
    background-color: #b2b2b2;
    border-color: #969696;
}

.button_loader {
  background-color: transparent;
  border: 4px solid #f3f3f3;
  border-radius: 50%;
  border-top: 4px solid #969696;
  border-bottom: 4px solid #969696;
  width: 35px;
  height: 35px;
  -webkit-animation: spin 0.8s linear infinite;
  animation: spin 0.8s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  99% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  99% { transform: rotate(360deg); }
}



    /*Hidden class for adding and removing*/
    .lds-dual-ring.hidden {
        display: none;
    }

    /*Add an overlay to the entire page blocking any further presses to buttons or other elements.*/
    .overlay2 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(0,0,0,.8);
        z-index: 999;
        opacity: 1;
        transition: all 0.5s;
    }

    /*Spinner Styles*/
    .lds-dual-ring {
        display: inline-block;
        width: 80px;
        height: 80px;
    }
    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 5% auto;
        border-radius: 50%;
        border: 6px solid #fff;
        border-color: #fff transparent #fff transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }
    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

</style>


         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Small Packet </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Small Packets </li>
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
                             <a href="<?php echo base_url(); ?>Packet_Application/Receive" class="btn btn-primary waves-effect waves-light">Receive/Itemization</a>

                            <!--   <a href="<?php echo base_url(); ?>Packet_Application/Itemize" class="btn btn-primary waves-effect waves-light">Itemize Item</a> -->

                                <a href="<?php echo base_url(); ?>Packet_Application/Pass" class="btn btn-primary waves-effect waves-light">Print Itemization</a>

                                <a href="<?php echo base_url(); ?>Packet_Application/fgn_zone_pass?fromzone=Small_Packets" class="btn btn-primary waves-effect waves-light">Pass to small packet cage</a>
                                <a href="<?php echo base_url(); ?>Packet_Application/Dispatch_Packet_list" class="btn btn-primary waves-effect waves-light">Print Regional Dispatched </a>
                              <a href="<?php echo base_url(); ?>Packet_Application/Dispatch_label" class="btn btn-primary waves-effect waves-light">Print Label </a>
								
                              <a href="<?php echo base_url(); ?>Packet_Application/TrackItem" class="btn btn-primary waves-effect waves-light">Track Item </a>

                              <!-- <a href="<?php echo base_url(); ?>Services/Foreign_letter?fromzone=Foreign_letter" class="btn btn-primary waves-effect waves-light">Passing Zone</a> -->

                              <?php if ($depsection == 'Foreign letter'){ ?>
                                  
                                  <a href="<?php echo base_url(); ?>Services/Foreign_letter?fromzone=Foreign_letter" class="btn btn-primary waves-effect waves-light">Foreign letter section</a>

                              <?php } ?>
								
                              <!-- <a href="<?php echo base_url(); ?>Unregistered/unregistered_rtx_bulk_form" class="btn btn-primary waves-effect waves-light"> Official / RTS </a> -->
								
								
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
							
                           <!--  <form class="form-horizontal m-t-20" method="post" action="<?php //echo site_url('FGN_Application/print_Packet_report');?>"> -->

                                  <form method="post" action="<?php echo base_url(); ?>Packet_Application/print_Packet_report">
						
						 
                             <div class="row">
                                <div class="col-md-12">
                              <table class="table table-bordered" style="width: 100%;">
                                <tr>
                                    
                  

                            <th style="text-transform: uppercase;"  >
                                       
                                <div class="input-group">

                               <select name="rec_region" value="" class="form-control custom-select rec_region" required id="rec_region" onChange="getDistrict();">
                                          <option value="">--Select Dispatch Region--</option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                </select>
                              </div>
                              <div class="input-group">
                                     <span id="rec_regionerror" class="rec_regionerror" style="color: red;"></span>
                                </div>
                               
                                </th>

                                  <th style="text-transform: uppercase;"  >
                            <div class="input-group">
                                  <select name="rec_branch" value="" class="form-control custom-select rec_branch"  id="rec_branch">  
                                 <option value="">--Select Dispatch Branch </option>
                                </select>
                              </div> 
                           <div class="input-group">
                                <span id="rec_dropp1error" class="  rec_dropp1error" style="color: red;"></span>
                            </div></th>

                           


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

                           <!--    <th style="">
                                 <div class="input-group">
                                      <button type="submit" class="btn btn-primary waves-effect waves-light" name="submitinfo"> <i class="flaticon-checked-1"></i> Print </button>
                                </div>
                            </th> -->
                             
                        </tr>
                        
                        </table>
                    </div>
                   
                </div>

							<!-- </form> -->
							
                      

                            


							   <div class="table-responsive ">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
												<th> Small Packet Number </th>
												<th> Region </th>
												<th> Branch </th>
												 <th> Created at  </th>
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
                            <!-- </div> -->


                            <br />
                             

                <div class="row despatched" style="padding-left: 10px;padding-right: 35px; text-align: left;" style="display:block">
              
           
                  <div class="col-md-3">
                    <label>Transport Type</label>
                    <select name="transport_type" class="form-control custom-select type" onChange="transportType()">
                      <option>Office Truck</option>
                      <option>Public Truck</option>
                      <option>Public Buses</option>
                      <option>Sea Transport</option>
                      <option>Railway Transport</option>
                      <option>Air Transport</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label>Transport Name</label>
                    <input type="text" name="transport_name" class="form-control" >
                  </div>
                  <div class="col-md-3">
                    <label>Rigistration Number</label>
                    <input type="text" name="reg_no" class="form-control">
                  </div>
                  <div class="col-md-3 cost" style="display: none;">
                    <label>Transport Cost</label>
                    <input type="text" name="transport_cost" class="form-control" >
                  </div>
                  <div class="col-md-3 " style="display: block;">
                    <label>Seal</label>
                    <input type="text" name="Seal" class="form-control" >
                  </div>
                  <div class="col-md-3 " style="display: block;">
                    <label>Weight</label>
                    <input  placeholder="Weight" type="text" name="weight" class="form-control" required="required">
                  </div>


                   <div class="row col-md-3">
                    <div id="test_form5" style="display: block;">
                      <div id="test_form4" >
                          <div class="col-sm-12 col-md-12 col-lg-12">
                            <br />
                            <div class="col-sm-12 col-md-12 col-lg-12" id="input_wrapper3"></div>
                            <!-- <button id="save_btn" class="btn btn-success">Save</button> -->
                            <button id="add_btn3" class="btn btn-danger">Add Remarks</button>
                          </div>
                      </div>
                       </div>
                  
                  </div>
                 
                </div>
                
                 <br>
                <div class="row" style="padding-left: 30px;padding-right: 35px;">

                  <div class="col-md-12">  
                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="submitinfo"> <i class="flaticon-checked-1"></i> Print Dispatch </button>
                    <!-- <button type="submit" class="btn btn-info" name="despatch" value="despatch">Submit</button> -->
                  </div>
                </div>
                <br />
                           
  </form>   

                        </div>
                    </div>
                </div>
                </div>
                </div> </div>
				
<script>
    $(document).ready(function() {
    var max_fields_limit      = 1; //set limit for maximum input fields
    var x = 1; //initialize counter for text box
    $('.add_more_button3').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
        if(x <= max_fields_limit){ //check conditions
            x++; //counter increment
            $('.input_fields_container').append('<div> <div class="form-group row"> <div class="col-4"> <input type="text" placeholder="Enter FGN Number" class="form-control" name="fgn_no[]"/> </div> <div class="col-3"> <select name="region[]" value="" class="form-control custom-select" required id="regiono2" onChange="getBranch();"> <option value=""> Region </option> <?php foreach($region as $value): ?> <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option> <?php endforeach; ?> </select> </div> <div class="col-3"> <select name="branch[]" value="" class="form-control custom-select"  id="branchdropo2"><option> Branch </option> </select> </div> <button href="#" class="remove_field btn btn-primary" style="margin-left:10px;">  X  </button>   </div> </div>'); //add input field
        }
    });  
    $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>

     <script type="text/javascript">
                            $(document).ready(function(){
                                var x = 0;
                                   $('#add_btn3').click(function(e) {
                                    e.preventDefault();
                                    appendRow(); // appen dnew element to form 
                                    x++; // increment counter for form
                                    //$('#save_btn').show(); // show save button for form
                                  });

                                   function appendRow() {
                                $('#input_wrapper3').append(
                                    // '<label><span id="results" style=""> </span> Outstanding Balance</label>'+
                                    // '<br />'+
                                    '<div id="'+x+'" class="form-group col-md-12" style="display:flex;">' +
                                     //  '<div>' +
                                     // '<select name="fn[]" id="'+x+'" class="form-control col-md-6" >'+
                                     //                               ' <option value="">--Select Remarks--</option>'+
                                     //              '<option>NMB - Bulk</option>'+
                                     //              '<option>PML - Posta Mlangoni</option>'+
                                     //            ' <option>FGN - </option>'+
                                     //             ' <option>DP -</option>'+
                                     //              ' <option>INT-PCL - Foreign Parcel</option>'+
                                     //               ' <option>INL-PCL - Bulk</option>'+


                                        
                                     //  '</div>' +
                                      '<div>'+
                                      '<input type="text" id="'+x+'" class="form-control " name="ln[]"   placeholder=""/>'+
                                      '</div>' +
                                      '<div>'+
                                        '<button id="'+x+'" class="btn btn-danger deleteBtn3"><i class="glyphicon glyphicon-trash"></i> Remove</button>' +
                                      '</div>' +
                                    '</div>');
                              }

                              $('#input_wrapper3').on('click', '.deleteBtn3', function(e) {
                                e.preventDefault();
                                var id = e.currentTarget.id; // set the id based on the event 'e'
                                $('div[id='+id+']').remove(); //find div based on id and remove
                                x--; // decrement the counter for form.
                                
                                if (x === 0) { 
                                    //$('#save_btn').hide(); // hides the save button if counter is equal to zero
                                }
                              });

                            });
                          </script>    


<script type="text/javascript">
    function getDistrict() {
    var region_id = $('#rec_region').val();
     $.ajax({
     
     url: "<?php echo base_url();?>Employee/GetBranch",
     method:"POST",
     data:{region_id:region_id},//'region_id='+ val,
     success: function(data){
         $("#rec_branch").html(data);

     }
 });
};
</script>

<script type="text/javascript">
    function getBranch() {
    var region_id = $('#regiono2').val();
     $.ajax({
     
     url: "<?php echo base_url();?>Employee/GetBranch",
     method:"POST",
     data:{region_id:region_id},//'region_id='+ val,
     success: function(data){
         $("#branchdropo2").html(data);

     }
 });
};
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
 <script type="text/javascript">
	  function del()
	  {
		if(confirm("Are you sure you want to delete?"))
		{
			return true;
		}
		
		else{
			return false;
		}
	  }
</script>


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


function Deletevalue(obj) {
    var transId = $(obj).attr('data-transid');
    $('#tr'+transId).remove();
    //var bagnoSelectedText = $('#bagss option:selected').text();
    //var currentRow = $('#emsListData tr').length;
    //$('#countingNumber').html(currentRow);
    
    $.ajax({
        type : 'POST',
        url  : '<?php echo base_url('Packet_Application/delete_Packet_item_scanned')?>',
        data : {transactionid:transId},
        dataType:'json',
        success:function(response){
            
            if (response['status'] == 'Success') {
                $('#loadingtext').html(response['msg']);
            }else{
                $('#loadingtext').html(response['msg']);
            }

            setTimeout(function(){
                $('#loadingtext').html('');
            },3000)
        }
       });
}



function assignBagProcess(obj){
        var barcode = $(obj).val();
        var rec_region = $('#rec_region').val();
        var rec_branch = $('#rec_branch').val();

        $('#loadingtext').html('Please wait............');
          var sno = nextSerialNo();
          //if(sno == null)sno = 1;
        

        if (rec_region && rec_branch && barcode) {

            if (barcode.length == 13) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Packet_Application/assign_item_general_process",
                    data:{
                        barcode:barcode,rec_region:rec_region,
                        rec_branch:rec_branch,sn:sno},
                    dataType:'json',
                    success:function(response){
                        $(obj).val('')
                        //console.log(response)
                       
                        if (response['status'] == 'Success') {
                                //$('#emsListData').append(response['msg'])
                                 $('#emsListData').html(response['msg'])
                                $('#loadingtext').html(response['status']);
                                     $('#forMessage').hide();
                                //$('#bagss').html(response['select']);
                        }else{
                           $('#loadingtext').html(response['msg']);
                             $('#forMessage').show();
                             $('#notifyMessage').html(response['msg']);
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
        $('#loadingtext').html('<strong>Please select region and branch</strong>')
        }

    }

    function nextSerialNo(){
        //var num = $('#emsListData tr:last-child td:first-child').html();
        var num = $('#emsListData tr:first-child td:first-child').html();
       
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