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
                      Despatch Office</h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Despatch Office</li>
                      </ol>
                    </div>
                  </div>

                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">

                    <div class="row ">
                    <!-- Column -->
                     <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/in.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                            
                                    <?php
                                     echo $despatchInCount;   
                                    ?>
                                     </h3>
                                        <a href="<?php echo base_url(); ?>Box_Application/despatch_in" class="text-muted m-b-0">Total Despatch In</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                     <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/sent.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    <?php
                                      echo $despatchCount;
                                    ?>
                                    
                                     </h3>
                                     
                                        <a href="<?php echo base_url(); ?>Box_Application/despatch_out" class="text-muted m-b-0">Total Despatch Out</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/receiving.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    <?php 
                                     echo $ems;
                                     ?>
                                     </h3>
                                     
                                        <a href="<?php echo base_url(); ?>Box_Application/BackOffice" class="text-muted m-b-0">Total Item from Counter</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   <!-- Column -->
                   <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/bag.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                   <?php 
                                    echo $bags;
                                    ?>
                                     </h3>
                                     
                                        <a href="<?php echo base_url(); ?>Box_Application/ems_bags_list" class="text-muted m-b-0">Total Bags</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    
                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">
                        <hr/>
                        <div class="row">
                            <div class="col-md-10">
                                <h2 id="loadingtext"></h2>
                            </div>
                            <div class="col-md-2">
                                <h2>Counter: <span id="countingNumber">0</span></h2>
                            </div>
                        </div>
                         <div class="row">
                                <div class="col-md-12">
                              <table class="table table-bordered" style="width: 100%;">
                                <tr>
                                    
                  
                            <th style="text-transform: uppercase;" >
                                <div class="input-group">
                                     <?php $bagss = $this->Box_Application_model->bagundespatchedselect11();?>
                            <select onchange="getbagItems(this)" class="form-control custom-select bagss" name="bagss" style="height: 40px;background-color: white;"  id="bagss"  onChange="getbags();">
                                          <!-- <option value="">--Select Bag--</option> -->
                                          <option selected="selected" value="New Bag">New Bag</option>
                                          <?php foreach ($bagss as $value) {?>
                                            <option value="<?php echo $value->bag_id; ?>"><?php echo $value->bag_number; ?></option>
                                          <?php } ?>
                                        </select>
                              </div> 

                              <div>
                                  <a onclick="return confirm('Una uhakika unataka kufuta begi hilo?')" style="display: none;" href="<?php echo base_url(); ?>Box_Application/delete_selected_bag" id='btnDeletebag'><i class="fa fa-trash-o"></i> Delete Bag</a>
                              </div>


                          </th>

                            <th style="text-transform: uppercase;"  >
                                       
                                <div class="input-group">

                                     <?php $region = $this->employee_model->regselect();?>
                                <select class="form-control custom-select rec_region" name="region" style="height: 40px;background-color: white;" onChange="getRecDistrict(this,'null');" id="rec_region">
                                  <option value="">--Select Region--</option>
                                  <?php foreach ($region as $value) {?>
                                    <option value="<?php echo $value->region_name; ?>"><?php echo $value->region_name; ?></option>
                                  <?php } ?>
                              </select>
                              </div>
                              <div class="input-group">
                                     <span id="rec_regionerror" class="rec_regionerror" style="color: red;"></span>
                                </div>
                               
                                </th>

                                  <th style="text-transform: uppercase;"  >
                            <div class="input-group">
                                 <select name="district" value="" class="form-control custom-select rec_dropp1" style="background-color: white;"  id="rec_dropp1" required="required">
                                        <option value="">--Select Branch--</option>
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
                             
                        </tr>
                        
                        </table>
                    </div>
                   
                </div>

               <div class="row">
                    <div class="col-md-12">
                        <h3 id="resMessage"></h3>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Sender Name</th>
                                    <th>Receiver Name</th>
                                    <th>Registered Date</th>
                                    <th>Branch Origin</th>
                                    <th>Destination</th>
                                    <th>Barcode Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="" id='emsListData'>
                            </tbody>
                            <tbody class="">
                                <tr>
                                    <td colspan="7"></td><td style="float: right;">
                                        <a class="btn btn-success" href="<?php echo base_url();?>Box_Application/close_bag_items" class="text-white"><i class="" aria-hidden="true"></i> Close Bag </a>
                                      </td>
                                  </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-12">
               <br>
                <div id="div6" style="display: none;">
                    <div class="row">
                        <div class="col-md-12 ">
                        <span class ="list" style="font-weight: 60px;font-size: 18px;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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


function Deletevalue(obj) {
    var transId = $(obj).attr('data-transid');
    $('#tr'+transId).remove();
    var bagnoSelectedText = $('#bagss option:selected').text();
    var currentRow = $('#emsListData tr').length;
    $('#countingNumber').html(currentRow);
    
    $.ajax({
        type : 'POST',
        url  : '<?php echo base_url('Box_Application/delete_bag_item_scanned')?>',
        data : {transactionid:transId},
        dataType:'json',
        success:function(response){
            
            if (response['status'] == 'Success') {
                $('#loadingtext').html(response['msg']+' number '+bagnoSelectedText);
            }else{
                $('#loadingtext').html(response['msg']);
            }

            setTimeout(function(){
                $('#loadingtext').html('');
            },3000)
        }
       });
}

function getbagItems(obj){
    var bagno = $(obj).val();
    var bagnoSelectedText = $('#bagss option:selected').text();
    $('#loadingtext').html('Please wait............');
    var href = $('#btnDeletebag').attr('href');

    $('#btnDeletebag').attr('href',href+'?bagno='+bagno+'&returnto=close_bag_items');


    if (bagnoSelectedText) {
        $('#btnDeletebag').css({'display':'block'})


        $.ajax({
            type:'POST',
            url:"<?php echo base_url();?>Box_Application/get_bag_itemlist",
            data:{bagnoText:bagnoSelectedText},
            dataType:'json',
            success:function(response){
                $('#emsListData').html('')
                
                if (response['status'] == 'Success') {
                    //auto selecting the region
                    $('#rec_region option[value="'+response['from']+'"]').prop('selected', true)
                    //load district automatic
                    getRecDistrict('#rec_region',response['to']);
                    
                    $('#emsListData').append(response['msg'])
                    $('#bagss').html(response['select']);
                    $('#loadingtext').html(response['status']);
                    $('#countingNumber').html(response['total']);
                }else{
                    $('#loadingtext').html(response['msg']);
                }

                setTimeout(function(){
                    $('#loadingtext').html('');
                },3000)

            },error:function(){

            }
        })
    }else{
        $('#btnDeletebag').css({'display':'none'})
    }
}


function assignBagProcess(obj){
        var barcode = $(obj).val();
        var rec_region = $('#rec_region').val();
        var rec_branch = $('#rec_dropp1').val();
        var bagssno = $('#bagss').val();//value
        var bagnoText = $('#bagss option:selected').text();

        $('#loadingtext').html('Please wait............');
        var sno = nextSerialNo();

        //current number
        var currentCounter = parseInt($('#countingNumber').html());

        if (rec_region && rec_branch && barcode) {

            if (barcode.length == 13) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Box_Application/assign_item_bag_general_process",
                    data:{
                        barcode:barcode,rec_region:rec_region,
                        rec_branch:rec_branch,
                        bagno:bagssno,bagnoText:bagnoText,sn:sno},
                    dataType:'json',
                    success:function(response){
                        $(obj).val('')
                        //console.log(response)
                       
                        if (response['status'] == 'Success') {
                                $('#emsListData').append(response['msg'])
                                $('#loadingtext').html(response['status']);
                                $('#bagss').html(response['select']);
                                $('#countingNumber').html(currentCounter + parseInt(response['total']));
                        }else{
                           $('#loadingtext').html(response['msg']);
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
