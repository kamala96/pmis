<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<style>
select#assignedoperator {
    height: 51px;
}
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
                      Pass to Delivery</h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard Back Office</li>
                      </ol>
                    </div>
                  </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">

                        <div style="display: none; font-size: 25px;" id="forMessage" class="alert alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong id="notifyMessage"></strong>
                        </div>


                        <!-- <div class="row col-md-12">
                           <div class="">
                            <?php $regionlist = $this->employee_model->regselect(); ?>
                    
                            <a href="<?php echo base_url('Box_Application/despatch_in');?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Dispatch</a>

                            </div> 

                            <div style="margin-left:10px">
                                <?php $regionlist = $this->employee_model->regselect(); ?>
                        
                                <a href="<?php echo base_url('Box_Application/delivering');?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Delivering</a>
                            </div> 
                        </div> -->

                        <hr/>
                         <div class="row">
                            <div class="col-md-12">
                                 <div class="input-group">
                                   <!--  <h5 style="text-align: center;width: 100%;" id="lblValue" class="lblValue">Barcode scan: </h5><br /> -->
                                    <h5  id="results" class="results" 
                                    style="color: red;
                                    text-align: 'center';
                                    width: 100%;"></h5>
                                </div>
                            </div>
                                <!--<div class="col-md-12">
                              <table class="table table-bordered" style="width: 100%;">
                                <tr>
                                      <th style="text-transform: uppercase;"  >
                                        <div class="input-group"> <span id="" class=" ">Bulk single scan: </span><br /></div>
                                       
                                <div class="input-group">
                                      <input id="typeScanSingle" type="hidden" name="" value="single">

                                      <select data-block-select="bulk" data-block-input="bulkInpt" onchange="checkPendingDelivering(this)" class="form-control custom-select js-example-basic-multiple assignedoperator1 single" id="assignedoperator1"  name="operator1">
                                        <option value="">--Select Deliverer --</option>
                                      <?php foreach ($emselect as  $value) {?>
                                      <option value="<?php echo $value->em_id; ?>"><?php echo $value->first_name.'  '.$value->middle_name.'  '.$value->last_name;  ?></option>
                                    <?php } ?>
                                  </select>
                              </div>
                                 
                            </th>
                                <th style="">
                                  <label>Scan Barcode :</label>
                                  <div class="input-group"> <span id="" class=" "> </span><br /></div>
                                  
                                 <div class="input-group">
                                    <input id="edValue1" type="text" class="form-control col-md-8 edValue1 singleInpt" 
                                    onchange="edValueKeyPress('edValue1','assignedoperator1','typeScanSingle')"
                                    >
                                    <br /><br />
                                </div>
                            </th>
                        </tr>
                        </table>
                            </div>-->
                              <div class="col-md-6">
                            <table class="table table-bordered" style="width: 100%;">
                                <tr>
                                      <th style="text-transform: uppercase;"  >
                                    <div class="input-group"> <span id="" class=" ">Bulk Single scan: </span><br /></div>
                                <div class="input-group">
                                     <input id="typeScanBulk" type="hidden" name="" value="single">
                                      <select data-block-select="single" data-block-input="singleInpt" onchange="checkPendingDelivering(this)" class="form-control custom-select js-example-basic-multiple assignedoperator bulk" id="assignedoperator"  name="operator">
                                        <option value="">--Select Deliver --</option>
                                      <?php foreach ($emselect as  $value) {?>
                                      <option value="<?php echo $value->em_id; ?>"><?php echo $value->first_name.'  '.$value->middle_name.'  '.$value->last_name;  ?></option>
                                    <?php } ?>
                                  </select>
                              </div>
                                </th>
                                    <th style="text-transform: uppercase;">
                                      <div class="input-group"> <span id="" class=" "> 
                                      Scan Barcode</span><br /></div>
                                     <div class="input-group">
                                        <!-- oninput="edValueKeyPress('edValue','assignedoperator','typeScanBulk');" -->

                                        <!-- onkeyup="edValueKeyPress('edValue','assignedoperator','typeScanBulk');" -->

                                        <input id="edValue" type="text" class="form-control edValue"
                                        onchange="edValueKeyPress('edValue','assignedoperator','typeScanBulk');">
                                        <br /><br /></div>
                                </th>
                             
                            </tr>
                        </table>
                            </div>
                   
                </div>

                <hr />
            <div class="row">
                <div class="col-md-12">
                <br>
                <div id="div6" style="display: nonef;">
                    <h2 id="messageResponse"></h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table  class="table table-bordered" style="width: 100%;">
                                <tr>
                                    <th>S/No</th>
                                    <th>Sender</th>
                                    <th>Receiver</th>
                                    <th>Branch Origin</th>
                                    <th>Destination Branch</th>
                                    <th>Barcode</th>
                                    <th>Action</th>
                                    <tbody id="listTable"></tbody>
                                </tr>
                            </table>
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

    function checkPendingDelivering(obj){
        $("#messageResponse").html('Tafadhali subiri...');
        var operator = $(obj).val();

        var blockSelet = $(obj).attr('data-block-select');
        var blockInput = $(obj).attr('data-block-input');

        $('.'+blockSelet).attr('disabled','disabled').attr('readonly','readonly')
        $('.'+blockInput).attr('disabled','disabled').attr('readonly','readonly')

        $('#listTable').empty();
         //$("#mainTable > tbody").empty();

        $.ajax({
            type:'POST',
            url:"<?php echo base_url();?>Box_Application/getOperatorPendingDeliveringMails",
            data:'operator='+operator,
            success:function(response){
                //onsole.log(response)
                $('.'+blockSelet).removeAttr('disabled','disabled').removeAttr('readonly','readonly')
                $('.'+blockInput).removeAttr('disabled','disabled').removeAttr('readonly','readonly')

                $("#messageResponse").html('');
                $('#listTable').append(response);

            },error:function(error){

            }
        })
    }

    function removeAssignedItem(obj){
        var transid = $(obj).attr('data-transid');
        var barcode = $(obj).attr('data-barcode');
        var operator = $('#assignedoperator').val();
        //removing the row for that transaction
        $(obj).closest('.receiveRow').remove();

        $.ajax({
            type: "POST",
             url: "<?php echo base_url();?>Box_Application/removeAssignedItemDeliveringMails",
             data:'barcode='+barcode+'&transid='+transid+'&operator='+operator,
             //dataType:'json',
             success: function(response) {
                //console.log(response)
             }
        });
    }

    function nextSerialNo(){
        var num = $('#listTable tr:last-child td:first-child').html();
       
        if (num == 'No pending assigned') {
            return parseInt(1); 
        }else if(num == 'No data found'){
            return parseInt(1); 
        }else{
            return parseInt(num) + 1; 
        }
        
    }

  function edValueKeyPress(barcodeBox,operatorname,type) {
    var date = $('#date').val();
    var month = $('#month').val();   
    var region = $('#region').val();
    //operatore name
    var assignedoperator = $('#'+operatorname).val();
    //type -> Bulk or Single
    var type = $('#'+type).val();
   
    var barcode = $('#'+barcodeBox).val();

    if(assignedoperator === ''){
       
        $('#forMessage').show().addClass('alert alert-danger').css({
            'background-color': '#d22c19',
            'color': 'white'
        })
        $('#notifyMessage').html("Please Assign Operator First");

        $('.results').html(txt2);
    }else{
        $('#forMessage').hide().removeClass();
        $('#notifyMessage').html('');


        $('.results').html('');
        var txt = "The barcode number is: " + barcode;
        var lblValue = $('#lblValue').val();
        $('.lblValue').html(txt);

        var sn = nextSerialNo();
    
        if (barcode.length == 13) {
            $('#forMessage').hide().removeClass();
            $('#notifyMessage').html('');

            $.ajax({
                type: "POST",
                 url: "<?php echo base_url();?>Box_Application/passToDeliveringProcessMails",
                 data:'barcode='+barcode+'&operator='+assignedoperator+'&type='+type+'&sn='+sn,
                 dataType:'json',
                 success: function(response) {
                    //console.log(response)
                    $('#'+barcodeBox).val('');

                    if (response['status'] == 'Success') {
                        $('#forMessage').show().addClass('alert alert-success').css({
                            'background-color': '#198754',
                            'color': 'white'
                        })

                        $('#notifyMessage').html('SuccessFully assigned for delivery');

                        $('#listTable').append(response['msg']);
                    }else{
                        $('#forMessage').show().addClass('alert alert-danger').css({
                            'background-color': '#d22c19',
                            'color': 'white'
                        })

                        $('#notifyMessage').html(response['msg']);
                    }

                    //remove the message box
                    /*setTimeout(function(){
                      $('#forMessage').hide().removeClass();
                      $('#notifyMessage').html('');
                    }, 3000);* /             
                    
                 },error: function (e) {
                    /*$('.results').html(e.responseText);
                    
                    $('.lblValue').html('Barcode scan:');
                   
                    var edValue = document.getElementById("edValue");
                    edValue.value = '';
                     $('#div6').show();
                     $('.list').html(e);*/
                 }
            });
        }else{

            $('#forMessage').show().addClass('alert alert-success').css({
                'background-color': '#d22c19',
                'color': 'white'
            })

            $('#notifyMessage').html('Tafadhali barcode haijakamilika = 13');
        }
    }
    
}
</script>        

        

                                                     

<script>
  $(document).ready(function() {

    $("#BtnSubmit").on("click", function(event) {

     event.preventDefault();

     var datetime = $('.mydatetimepickerFull').val();

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
<?php $this->load->view('backend/footer'); ?>
