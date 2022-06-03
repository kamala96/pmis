
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
<div class="message"></div>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> PCUM Office</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">PCUM</li>
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
            <!-- <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url() ?>Services/Pickup" class="text-white"><i class="" aria-hidden="true"></i> Pickup list</a></button>   -->

            <!-- <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url() ?>Box_Application/item_transfer_pcum" class="text-white"><i class="" aria-hidden="true"></i> Item Transfer</a></button>   -->
        </div>
    </div>
 </div>

 <div id="dataDisplay" class="rodw">
    <div class="col-lg-12">
        <div class="card card-outline-info">

            <div class="container-fluid">
            <div class="card-header">
                <h4 class="m-b-0 text-white"> Item list</h4>
            </div>
            <div class="col-md-6">
                
                <table class="table table-bordered" style="width: 100%;">
                    <tbody>
                        <tr>
                            <th style="text-transform: uppercase;">
                            <div class="input-group"> 
                                <span id="" class=" ">Zone type</span><br>
                              </div>
                              <div class="input-group">
                                  <select onchange="getOperatorByZone(this)" class="form-control custom-select js-example-basic-multiple zonetype bulk" id="zonetype" name="operator_zone">
                                    <option selected="selected" disabled="disabled">--Select zone --</option>
                                    <?php foreach ($sectiondata as $key => $value){ ?>
                                        <?php if ($value['id'] == 24){ ?>
                                            <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                                        <?php } ?>
                                    <?php } ?>

                                </select>
                                <input id="searched_name" type="hidden" name="searched_name">
                            </div>
                        </th>
                          <th style="text-transform: uppercase;">
                                <div class="input-group"> 
                                    <span id="" class=" ">Operator</span><br>
                                </div>
                                <div class="input-group">
                                      <select onchange="getPassedItemsByOperator(this)" class="form-control custom-select js-example-basic-multiple assignedoperator bulk" id="assignedoperator" name="operator">
                                        <option selected disabled="disabled">--Select operator --</option>            
                                    </select>
                              </div>
                        </th>
                    </tr>
            </tbody>
        </table>
    </div>

            <div class="card-body">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 id="resMessage"></h3>
                        </div>
                    </div>
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
                                      <input autocomplete="off" id="edValue" type="text" class="form-control edValue" onchange="passToOperatorByzone(this);">
                                      <br><br></div>
                                      <div class="input-group">
                                       <span id="lblValue" class="lblValue">Barcode scan: </span><br></div>
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
                                <th>Action</th>
                            </tr>

                            </thead>
                        <tbody class="" id='emsListData'>
                        </tbody>
                        <tbody class="">
                            <tr><td colspan="11"></td><td style="float: right;">
                <a class="btn btn-success" href="<?php echo base_url();?>Services/pcum_pass" class="text-white"><i class="" aria-hidden="true"></i> Submit </a>
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

    function getPassedItemsByOperator(obj){
        var operatorid = $(obj).val();
        var selectedZone = $('#zonetype option:selected').text();
        $('#loadingtext').html('Please wait............');
        $('#searched_name').val(selectedZone);
        var currentCounter = parseInt($('#countingNumber').html());

        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Box_Application/getPassedItemsByOperator",
            data:{
                operator:operatorid,
                zonetype:selectedZone,
                removefunction:'removePCUMPassedItem'},
            dataType:'json',
            success:function(response){
                //console.log(response)
                //$(obj).val('')

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

    function getOperatorByZone(obj){
        var sectionid = $(obj).val();

        $.ajax({
            type:"POST",
            url:"<?php echo base_url();?>Employee/getEmployeeBySection",
            data:'sectionid='+sectionid,
            dataType:'json',
            success:function(res){

                if (res['status'] == 'Success') {
                    $('#assignedoperator').empty();

                    $('#assignedoperator').append("<option selected disabled='disabled'>--Select operator --</option>");
                    $.each(res['msg'], function(index,data){

                        $('#assignedoperator').append("<option value="+data['em_id']+"  >"+data['first_name']+" "+data['last_name']+"</option>");

                    })
                }else{
                    $('#assignedoperator').empty();
                    $('#assignedoperator').append("<option selected disabled='disabled'>--Select operator --</option>");
                }

            },error:function(err){

            }
        })
    }

    function passToOperatorByzone(obj){
        var barcode = $(obj).val();
        var operator = $('#assignedoperator').val();
        var zone = $('#zonetype option:selected').text();

        var sno = nextSerialNo();

        var currentCounter = parseInt($('#countingNumber').html());
        //console.log(barcode.length)
      
        if (operator) {

            if (barcode.length == 14) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Box_Application/PCUMPassToOperatorByzone",
                    data:{barcode:barcode,operator:operator,zonetype:zone,sn:sno},
                    dataType:'json',
                    success:function(response){
                        $(obj).val('')
                        // console.log(response)
                        if (response['status'] == 'Success') {
                            $('#emsListData').append(response['msg'])
                            $('#countingNumber').html(currentCounter + parseInt(response['total']));
                        }else{
                            $('#resMessage').html(response['msg']);
                        }
                    },error:function(){

                    }
                })
            }

        }else{
            $('#resMessage').html('Please choose operator first')
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

    function removePCUMPassedItem(obj){
        var transid = $(obj).attr('data-transid');
        var barcode = $(obj).attr('data-barcode');
        var operator = $('#assignedoperator').val();
        //removing the row for that transaction
        $(obj).closest('.receiveRow').remove();

        $.ajax({
            type: "POST",
             url: "<?php echo base_url();?>Box_Application/removePCUMPassedItem",
             data:'barcode='+barcode+'&transid='+transid+'&operator='+operator,
             //dataType:'json',
             success: function(response) {
                //console.log(response)
             }
        });
    }

</script>


<?php $this->load->view('backend/footer'); ?>

<!-- Modal content-->
