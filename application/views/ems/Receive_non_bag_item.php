
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
<div class="message"></div>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Receive Non-bag Items</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">InWard</li>
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
    <div class="col-lg-12 col-md-12">
        <div class="row">
            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url() ?>Box_Application/despatch_in" class="text-white"><i class="" aria-hidden="true"></i> Despatch</a></button>  

            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url() ?>Box_Application/item_received_non_bag" class="text-white"><i class="" aria-hidden="true"></i> Item received</a></button>  
        </div>
    </div>
 </div>

 <div id="dataDisplay" class="rodw">
    <div class="col-lg-12">
        <div class="card card-outline-info">

            <div class="container-fluid">
            <div class="card-header">
                <!-- <h4 class="m-b-0 text-white"> Scanning</h4> -->
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-md-10">
                            <h2 id="loadingtext"></h2>
                        </div>
                        <div class="col-md-2">
                            <h2>Counter: <span id="countingNumber">0</span></h2>
                        </div>
                    </div>
                    <table id="example4" class="display nowrap table table-bordered fromServer2 receiveTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th colspan="9"></th>
                                <th colspan="3">
                                   <div class="input-group">
                                    <!-- oninput="passToOperatorByzone(this);" -->
                                      <input autocomplete="off" id="edValue" type="text" class="form-control edValue" onchange="receiveScanNonBagItem(this);">
                                      <br><br></div>
                                      <!-- <div class="input-group">
                                       <span id="lblValue" class="lblValue">Barcode scan: </span><br></div> -->
                                </th>
                            </tr>

                             <tr>
                                <th>SN</th>
                                <th>Sender Name</th>
                                <th>Receiver Name</th>
                                <th>Registered Date</th>
                                <th>Amount (Tsh.)</th>
                                <th>Weight</th>
                                <th>Branch Origin</th>
                                <th>Destination</th>
                                <th>Bill Number</th>
                                <th>Barcode Number</th>
                                <th style="text-align: right;">Payment Status</th>
                            </tr>

                            </thead>
                        <tbody class="" id='emsListData'>
                        </tbody>
                        <tbody class="">
                            <tr><td colspan="9"></td><td style="float: right;">
                <a class="btn btn-success" href="<?php echo base_url();?>Box_Application/Receive_non_bag_item" class="text-white"><i class="" aria-hidden="true"></i> Submit </a>
                  </td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">

    function receiveScanNonBagItem(obj){
        var barcode = $(obj).val();
        var operator = $('#assignedoperator').val();
        var zone = $('#zonetype option:selected').text();

        $('#loadingtext').html('Please wait............');
        var sno = nextSerialNo();
        
        var currentCounter = parseInt($('#countingNumber').html());

        if (barcode.length == 13) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Box_Application/receiveScanNonBagItem",
                data:{barcode:barcode,operator:operator,zonetype:zone,sn:sno},
                dataType:'json',
                success:function(response){
                    //console.log(response);
                    $(obj).val('')

                    if (response['status'] == 'Success') {
                        $('#emsListData').append(response['msg'])
                        $('#countingNumber').html(currentCounter + parseInt(response['total']));

                    }else{
                        $('#loadingtext').html(response['msg']);
                    }

                    setTimeout(function(){
                        $('#loadingtext').html('');
                    },3000)

                },error:function(){

                }
            })
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

</script>


<?php $this->load->view('backend/footer'); ?>

<!-- Modal content-->
