<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Register Zones Country </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Register Zones Country</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <!-- <div class="row m-b-10">
                <div class="col-12">
                    <a href="<?php echo base_url() ?>Organization/Services" class="btn btn-primary"><i class="fa fa-plus"></i> Create Services</a>
                    
                </div>    
        </div>  -->

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Zone Form                       
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                           <div class="row">
                               <div class="col-md-12">
                                   <?php if(!empty($this->session->flashdata('success'))){ ?>
                                    <div class="alert alert-success alert-dismissible">
                                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                      <strong><?php echo $this->session->flashdata('success'); ?>!</strong>
                                    </div>
                                   <?php }else{?>

                                   <?php }?>
                               </div>
                           </div>
                            <?php if (!empty($zoneEdit->zone_id)) {?>
                                 <form action="<?php echo base_url('Organization/zone_country')?>" method="POST">
                                <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                <label>Country Name<label>
                                <input type="text" name="country_name" class="form-control" required="" value="<?php echo $countryEdit->country_name ?>">
                                </div>
                               </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label>Zone Name</label>
                                    <select class="form-control custom-select" name="zone_name">
                                        <option><?php echo $countryEdit->zone_name ?></option>
                                        <option>ZONE1</option>
                                        <option>ZONE2</option>
                                        <option>ZONE3</option>
                                        <option>ZONE4</option>
                                        <option>ZONE5</option>
                                        <option>ZONE6</option>
                                        <option>ZONE7</option>
                                    </select>
                                </div>
                               </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="country_id" value="<?php echo $countryEdit->country_id ?>">
                                   <button class="btn btn-info btn-sm" type="submit">Save Country</button>
                                </div>
                                </div>
                                </div>
                        </form>
                            <?php }else{ ?>

                            <form action="<?php echo base_url('Organization/zone_country')?>" method="POST">
                                <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country Name</label>
                                <input type="text" name="country_name" class="form-control" required="">
                                </div>
                               </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label>Zone Name</label>
                                <select class="form-control custom-select" name="zone_name" required="">
                                        <option value="">--Select Zone Type--</option>
                                        <option>ZONE1</option>
                                        <option>ZONE2</option>
                                        <option>ZONE3</option>
                                        <option>ZONE4</option>
                                        <option>ZONE5</option>
                                        <option>ZONE6</option>
                                        <option>ZONE7</option>
                               </select>
                                </div>
                               </div>
                           </div>
                              
                                <div class="row">
                                    <div class="col-md-6">
                                <div class="form-group">
                                   <button class="btn btn-info btn-sm" type="submit">Save Country</button>
                                </div>
                                </div>
                                </div>
                        </form>

                        <?php } ?>
                             

                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Zone Name</th>
                                                <th>Country</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody class="results">
                                           <?php foreach($country as $value): ?>
                                            <tr>
                                                <td><?php echo $value->zone_name;?></td>
                                                <td><?php echo $value->country_name;?></td>
                                                <td style="text-align: center;"><a href="zone_country?I=<?php echo base64_encode($value->country_id)?>" class="btn btn-warning btn-sm">Edit</a> | <a href="delete_country?I=<?php echo base64_encode($value->country_id)?>" class="btn btn-warning btn-sm">Delete</a> </td>
                                            </tr>
                                            <?php endforeach; ?>
                                       
                                        </tbody>
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


<script type="text/javascript">
    $('#boxtype').on('change', function() {
        if ($('#boxtype').val() == 'Individual') {
            $('#indv').show();
            $('#sectors').hide();
            $('#error1').html('');
        }if ($('#boxtype').val() == 'Government Ministries and Large Business/Inst.') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }if ($('#boxtype').val() == 'Government Department') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }if ($('#boxtype').val() == 'Religious/Education Inst,Small Business and NGOs') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }if ($('#boxtype').val() == 'Primary Schools') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }
    
    //$('#showdiv' + this.value).show();
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#1step').on('click',function(){
        if ($('#boxtype').val() == 0) {
                $('#error1').html('Please Select PostBox Type');
        }else{

            if ($('#tariffCat').val() == 0) {
                $('#error2').html('Please Select PostBox Category');
            }else{
                $('#div2').show();
                $('#div1').hide();
            }
        }
  });
        $('#1stepBack').on('click',function(){
        $('#div2').hide();
        $('#div1').show();
  });
        $('#2step').on('click',function(){
        if ($('#fname').val() == '') {
            $('#errfname').html('This field is required');
        }else if($('#mname').val() == ''){
            $('#errmname').html('This field is required');
        }else if($('#lname').val() == ''){
            $('#errlname').html('This field is required');
        }else if($('#occu').val() == ''){
            $('#erroccu').html('This field is required');
        }else{
        $('#div2').hide();
        $('#div3').show();
        }
  });
        $('#2stepBack').on('click',function(){
        $('#div3').hide();
        $('#div2').show();
  });
});

//save data to databse
$('#btn_save').on('click',function(){
    
            var boxtype   = $('#boxtype').val();
            var tariffCat = $('#tariffCat').val();
            var fname     = $('#fname').val();
            var mname     = $('#mname').val();
            var lname     = $('#lname').val();
            var gender    = $('#gender').val();
            var occu      = $('#occu').val();
            var region    = $('#regionp').val();
            var district   = $('#branchdropp').val();
            var email     = $('#email').val();
            var phone     = $('#phone').val();
            var mobile    = $('#mobile').val();
            var residence   = $('#residence').val();

            if (district == '') {
            $('#errdistrict').html('This field is required');
            }else if(residence == ''){
            $('#errresidence').html('This field is required');
             }else if(email == ''){
            $('#erremail').html('This field is required');
            }else if(phone == ''){
            $('#errphone').html('This field is required');
            }else if(mobile == ''){
            $('#errmobile').html('This field is required');
            }else{

            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Box_Application/Register_Box_Action')?>",
                dataType : "JSON",
                data : {boxtype:boxtype,fname:fname,mname:mname,lname:lname,gender:gender,occu:occu,region:region,district:district,email:email,phone:phone,mobile:mobile,residence:residence,tariffCat:tariffCat},
                success: function(data){

                    $('[name="vehicle_no"]').val("");
                    $('[name="vehicle_id"]').val("");

                    $('#div4').show();
                    $('#div3').hide();
                    $('#majibu').html(data);
                   /// $('#Modal_Edit').modal('hide');
                    show_product();
                }
            });
            return false;
        }
        });


</script>

<script type="text/javascript">
        function getDistrict() {
    var val = $('#regionp').val();
     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Employee/GetDistrict",
     data:'region_id='+ val,
     success: function(data){
         $("#branchdropp").html(data);
     }
 });
};
</script>
<script type="text/javascript">
     function getTariffCategory() {

     var val = $('#boxtype').val();
     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Box_Application/GetTariffCategory",
     data:'bt_id='+ val,
     success: function(data){
        $('#tariffCat').html(data);
        $('#indv').show();
        $('#error1').html('');
     }
 });
};
</script>
<script type="text/javascript">
    $(document).ready(function() {
   
    var table = $('#example4').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>

<script type="text/javascript">
        function getBoxnumber() {

    var val = $('#box_number').val();
     if (val == 0) {

     }else{

     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Box_Application/UpdateBoxFull",
     data:'box_id='+ val,
     success: function(data){
         //$("#branchdropp").html(data);
     }
 });

 }
};
</script>
<?php $this->load->view('backend/footer'); ?>

