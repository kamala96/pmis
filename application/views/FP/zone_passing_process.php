
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
<div class="message"></div>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Foreign parcel passing Process</h3>
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
   <!--  <div class="col-lg-12 col-md-12">
        <div class="row">
            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="text-white"><i class="" aria-hidden="true"></i> Back to list</a></button>  

           <!--  <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url() ?>Box_Application/item_transfer_inward" class="text-white"><i class="" aria-hidden="true"></i> Item Transfer</a></button>   
        </div>
    </div> -->
 </div>

 <div id="dataDisplay" class="rodw">
    <div class="col-lg-12">
        <div class="card card-outline-info">

            <div class="container-fluid">
            <div class="card-header">

                <div class="row">
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary btn-block"><i class="fa fa-list"></i><a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="text-white"><i class="" aria-hidden="true"></i> Back to list</a></button>
                    </div>
                   <div class="col-md-2">
                        <button type="button" class="btn btn-primary btn-block"><i class="fa fa-list"></i><a href="<?php echo base_url() ?>FP_Application/item_foreign_parcel_transfer?fromzone=Small_Packets" class="text-white"><i class="" aria-hidden="true"></i> Item transfer</a></button>
                    </div>
                </div>
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

                                        <?php if ($fromzone == 'InLand_reg'){ ?>

                                            <?php if (
                                                $value['id'] == 7 || 
                                                $value['id'] == 20 || 
                                                $value['id'] == 21 || 
                                                $value['id'] == 13 || 
                                                $value['id'] == 9){ ?>

                                            <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>

                                            <?php } ?>

                                        <?php } else if ($fromzone == 'mails_counters'){ ?>

                                            <?php if ($value['id'] == 14){ ?>

                                            <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>

                                            <?php }else if($value['id'] == 15 && $current_section == 'Counter parcel'){ ?>
                                                <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                                            <?php } ?>

                                        <?php } else if($fromzone == 'InLand_parcel'){ ?>


                                            <?php if ($value['id'] == 22 || $value['id'] == 13){ ?>

                                            <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>

                                            <?php }?>


                                        <?php } else if($fromzone == 'OutBound') { ?>

                                             <?php if ($value['id'] == 22){ ?>

                                            <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>

                                            <?php }?>

                                        <?php } else if($fromzone == 'Small_Packets') {?>

                                             <?php if ($value['id'] == 22){ ?>

                                            <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>

                                            <?php }?>

                                        <?php } else if($fromzone == 'Foreign_parcel') {?>

                                             <?php if ($value['id'] == 22){ ?>

                                            <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>

                                            <?php }?>

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
                                    <select data-zone='InWard' onchange="getPassedItemsByOperator(this)" class="form-control custom-select js-example-basic-multiple assignedoperator bulk" id="assignedoperator" name="operator">
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
                                <th>Addresse</th>
                                <th>Item number</th>
                                <th>Delivery Serial</th>
                                <th>Handling charge</th>
                                <th>Address</th>
                                <th>Mobile No.</th>
                                <th>Identity</th>
                                <th>Action</th>
                            </tr>

                            </thead>
                        <tbody class="" id='emsListData'>
                        </tbody>
                        <tbody class="">
                            <tr><td colspan="9"></td><td style="float: right;">
                <a class="btn btn-success" href="<?php echo base_url();?>Services/<?php echo $fromzone; ?>" class="text-white"><i class="" aria-hidden="true"></i> Submit </a>
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
            url: "<?php echo base_url();?>FP_Application/getForeignParcelPassedItemsByOperator",
            data:{operator:operatorid,zonetype:selectedZone,removefunction:'removeInWardPassedItem'},
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
        var barcode = cleanBarcode($(obj).val());
        //update in the text input
        $(obj).val(cleanBarcode(barcode))
        var operator = $('#assignedoperator').val();
        var zone = $('#zonetype option:selected').text();

        $('#loadingtext').html('Please wait............');
        var sno = nextSerialNo();
        
        var currentCounter = parseInt($('#countingNumber').html());
        

        if (operator) {

            if (barcode.length == 13) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>FP_Application/ForeignParcelPassToCage",
                    data:{
                        Barcode:barcode,
                        operator:operator,
                        zonetype:zone,
                        sn:sno,
                        office_name:'<?php echo $current_section.' receive' ?>'},
                    dataType:'json',
                    success:function(response){
                        //console.log(response)
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
            }else{
                $('#loadingtext').html('Barcode character 13 zinazoitajika');

                setTimeout(function(){
                    $('#loadingtext').html('');
                },3000)
            }

        }else{
            $('#loadingtext').html('Please choose operator first')
        }

    }

    function removeMailsPassedItem(obj){
        var transid = $(obj).attr('data-transid');
        var barcode = $(obj).attr('data-barcode');
        var operator = $('#assignedoperator').val();
        //removing the row for that transaction
        $(obj).closest('.receiveRow').remove();

        $.ajax({
            type: "POST",
             url: "<?php echo base_url();?>Box_Application/removeMailsPassedItem",
             data:'barcode='+barcode+'&transid='+transid+'&operator='+operator+'&return_office=InWard Mails',
             //dataType:'json',
             success: function(response) {
                //console.log(response)
             }
        });
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


    function cleanBarcode(barcode){
        //remove any space from the string
        return  $.trim(barcode.replace(/ /g,''));
    }

</script>


<?php $this->load->view('backend/footer'); ?>

<!-- Modal content-->
