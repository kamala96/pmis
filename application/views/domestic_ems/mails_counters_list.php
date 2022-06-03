<style type="text/css">
    .strong {
        font-size: 19px;
        font-weight: 600;
        width: 100px;
        display: block;
    }
</style>

<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
<div class="message"></div>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Counter Office</h3>
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
        <!--<div class="row">
            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url() ?>Box_Application/Distributer_pass_view" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Pass process</a></button>  
        </div>-->
    </div>
    <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
                                     
                                        <a href="<?php echo base_url('Unregistered/Dashboard')?>" class="text-muted m-b-0">Registered</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>

                                        <a href="<?php echo base_url('Stamp/Stamp_form')?>" class="text-muted m-b-0">Sales Of Stamp</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6" style="">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                        <a href="<?php echo base_url('Unregistered/parcel_dashboard')?>" class="text-muted m-b-0">Parcel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" style="">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                        <a href="<?php echo base_url('Unregistered/small_packet')?>" class="text-muted m-b-0">Small Packets</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" style="">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                        <a href="<?php echo base_url('Unregistered/posts_cargo')?>" class="text-muted m-b-0">Posts Cargo</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" style="">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                        <a href="#" class="text-muted m-b-0">Posta Mlangoni</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" style="">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                        <a href="<?php echo base_url('Box_Application/BoxRental')?>" class="text-muted m-b-0">Box Rental</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="col-lg-3 col-md-6" style="">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                        <a href="<?php echo base_url()?>parcel/air_mails_dashboard" class="text-muted m-b-0">Air Mails</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->

                     <div class="col-lg-3 col-md-6" style="">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                        <a href="<?php echo base_url('Bill_Customer/Bill_Dashboard')?>" class="text-muted m-b-0">Bill</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="col-lg-3 col-md-6" style="">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                        <a href="<?php echo base_url('Mail_box/callnote');?>" class="text-muted m-b-0"> Call Note </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="col-lg-3 col-md-6" style="">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                        <a href="<?php echo base_url()?>Mail_box/bulk_callnote" class="text-muted m-b-0"> Bulk Call Note </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 

                     <div class="col-lg-3 col-md-6" style="">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                        <a href="<?php echo base_url('Posta_delivery/mails_dashboard');?>" class="text-muted m-b-0"> Register Delivery </a>
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
                                    <div class="round align-self-center round-info"><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        </h3>
                                    <a href="<?php echo base_url()?>Necta/necta_info" class="text-muted m-b-0">Necta</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" style="">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                        <a href="<?php echo base_url()?>Unregistered/unregistered_rtx_bulk_form" class="text-muted m-b-0">  Official / RTS   </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 

                </div>
 </div>

 <div class="row">
    <div class="col-md-7">
        <!-- <div class="col-md-2">
          <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url() ?>Services/mails_zone_pass?fromzone=mails_counters" class="text-white"><i class="" aria-hidden="true"></i> Pass to zone</a></button>
     </div> -->
     

    </div>
 </div>

 <div class="rosdw">
    <div class="col-md-11">
        <div class="row">
            <div class="col-md-2">
              <button type="button" class="btn btn-primary btn-block"><i class="fa fa-list"></i><a href="<?php echo base_url() ?>Services/mails_zone_pass?fromzone=mails_counters" class="text-white"><i class="" aria-hidden="true"></i> Pass to zone</a></button>
            </div>

            <div class="col-md-2">
              <button type="button" class="btn btn-primary btn-block"><i class="fa fa-list"></i><a href="<?php echo base_url() ?>Box_Application/item_mails_transfer?fromzone=mails_counters&print_status=IN" class="text-white"><i class="" aria-hidden="true"></i> Item transfer</a></button>
            </div>


            <?php if ($current_section == 'Counter parcel'){ ?>

                <div class="col-md-2">
                  <button type="button" class="btn btn-primary btn-block"><i class="fa fa-list"></i><a href="<?php echo base_url() ?>Packet_Application/packet_cage?fromzone=Small_Packets" class="text-white"><i class="" aria-hidden="true"></i> Small packet Cage</a></button>
                </div>

                <div class="col-md-2">
                  <button type="button" class="btn btn-primary btn-block"><i class="fa fa-list"></i><a href="<?php echo base_url() ?>FP_Application/packet_cage?fromzone=foreign_parcel" class="text-white"><i class="" aria-hidden="true"></i> Foreign Parcel Cage</a></button>
                </div>
                
            <?php } ?>

            
        </div>
    </div>
 </div>

 <div class="container-fluid">
     <div><h2 id="loadingtext"></h2></div>
     <div class="row">

        <?php if (!empty($counter_list)){ ?>

            <?php foreach ($counter_list as $key => $list) { ?>

                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div onclick="getListFromZone('<?php echo $key; ?>')" style="cursor: pointer;" class="card-body card-body-list card-body<?php echo $key; ?>">
                            <div class="d-flex flex-row">
                                <div class="round align-self-center round-warning">
                                    <?php if ($list['em_image']){ ?>

                                        <img src="<?php echo base_url()?>assets/images/users/<?php echo $list['em_image']; ?>" width="40">
                                        
                                    <?php }else{ ?>

                                        <img src="<?php echo base_url()?>assets/images/in.png" width="40">

                                    <?php } ?>
                                    
                                </div>
                                <div class="col-md-12 m-l-10 align-self-center">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <!-- <h3 class="m-b-0">0</h3> -->
                                 
                                            <a href="#" class="text-muted m-b-0">
                                                <h4><?php echo $list['fullname']; ?></h4>
                                            </a>
                                            <a href="#" class="text-muted m-b-0">
                                                <?php echo $list['last_name']; ?> 's Box
                                                <!-- <strong>(<?php echo $list['em_sub_role']; ?>)</strong> -->
                                            </a>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="#" class="text-muted m-b-0">
                                                <strong class="strong"><?php echo $list['pass_from']; ?>
                                                </strong>
                                            </a>
                                        </div>
                                    </div>
                             
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

            <?php } ?>
            
        <?php }else { ?>
           
           <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">
                                    <i class="fa fa-box-open"></i>
                                    No item(s) ...
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

     </div>
</div>

 <div id="dataDisplay" style="display:none;" class="row">
    <div class="col-12">
        <div class="card card-outline-info">

            <div class="container-fluid">
            <div class="card-header">
                <h4 class="m-b-0 text-white"> Item list</h4>
            </div>
            <div class="card-body">
                <div class="card">
                   <div class="card-body">
                        <div class="table-responsive">
                            <span class="table1">
                                <table id="example4" class="display nowrap table table-bordered fromServer2 receiveTable" cellspacing="0" width="100%">
                                    <thead>
                                         <tr>
                                        <th colspan="7"></th>
                                        <th colspan="3">
                                           <div class="input-group">
                                              <input autocomplete="off" id="edValue" type="text" class="form-control edValue" oninput="scanforReceive(this);" onchange="scanforReceive(this);">
                                              <br><br></div>
                                              <div class="input-group">
                                               <span id="lblValue" class="lblValue">Barcode scan: </span><br></div>
                                               <div class="input-group">
                                               <span id="results" class="results" style="color: red;"></span>
                                          </div>
                                        </th>
                                    </tr>
                                         <tr>
                                            <th>SN</th>
                                            <th>Sender Name</th>
                                            <th>Receiver Name</th>
                                            <th>Registered Date</th>
                                            <th>Branch Origin</th>
                                            <th>Destination</th>
                                            <th>Barcode Number</th>
                                        </tr>

                                    </thead>
                                    <tbody class="" id='emsListData'>
                                    </tbody>
                                </table>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



<script type="text/javascript">
    function getListFromZone(operatorId){
        var pfnumber = operatorId;
        //hide all cardcontent
        $('.card-body-list').hide();
        $('.card-body'+pfnumber).show();
        $('#loadingtext').html('Please wait............');

        $.ajax({
            type:'post',
            url:"<?php echo base_url();?>Box_Application/get_zone_sentList",
            data: 'emid='+pfnumber+'&office_name=<?php echo $current_section;?>&controller=<?php echo $current_controller;?>',
            dataType:'json',
            success:function(response){

                if (response['status'] == 'Success') {
                    $('#dataDisplay').show();
                    $('#emsListData').html(response['msg']);
                    $('#loadingtext').html(response['status']);
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

    function scanforReceive(obj) {
        var barcode = $(obj).val();
        
        //make the difference scanned and not scanned - just for user experience
         var tr = $('.'+barcode).closest('.receiveRow').css({
          "background":"white",
          "color":"black"
        })

         //transactionid
         var transactionid = $('.'+barcode).closest('.receiveRow').attr('data-transid');
         var emid = $('.'+barcode).closest('.receiveRow').attr('data-emid');

        //make the checkBoc to be checked
        $('.'+barcode).each(function() {
        this.checked = true;
            $(obj).val('');
        });

        //prepare request to the server for 'receive' and 'tracing'
        if (barcode.length == 13) {

            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Box_Application/zone_receive",
                data:{
                    barcode:barcode,
                    transid:transactionid,
                    passfrom:emid,
                    office_name:'<?php echo $current_section;?> receive'},
                dataType:'json',
                success:function(response){
                    
                    if (response['status'] == 'Success') {
                        console.log(response['transid'])
                    }else{

                    }

                },error:function(){

                }
            })
        }
   
}
</script>


                

<?php $this->load->view('backend/footer'); ?>

<!-- Modal content-->