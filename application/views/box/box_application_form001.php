<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
<h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"></i> Box Application</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Box Application</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    <a href="<?php echo base_url() ?>Box_Application/BoxRental" class="btn btn-primary"><i class="fa fa-plus"></i> Box Application</a>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Box_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Box Application List</a></button>
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Box Application Form                       
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                            <div id="div1"> 
                                <div class="row">
                                
                                <div class="col-md-12">
                                    <h3>Step 1 of 3  - Customer Type</h3>
                                </div>
                                <div class=" col-md-6">
                                    <label>Customer Type</label>
                                    <select name="renters" value="" class="form-control custom-select" required id="boxtype" onChange="getTariffCategory()">
                                            <option value="0">--Select Customer Type--</option>
                                            <?Php foreach($box_renters as $value): ?>
                                             <option value="<?php echo $value->bt_id ?>"><?php echo $value->renter_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                <span id="error1" style="color: red;"></span>
                                </div>
                                <div class="col-md-6" style="display: none;" id="indv">
                                <label>Customer Category:</label>
                                    <select name="box_category" value="" class="form-control custom-select"  id="tariffCat" required="required"> 
                                        </select>
                                <span id="error2" style="color: red;"></span>
                                </div>

                                <div class="col-md-6">
                                <label><span id="results" style=""> </span> Customer Name:</label>
                                <input type="text" name="custname" id="cust" class="form-control" onkeyup="myFunction()">
                                <span id="custerror" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                <label><span id="results" style=""> </span> Id Description:</label>
                                 <select name="iddescription" value="" class="form-control custom-select"  id="iddescription"> 
                                    <option value="">--Select Id Description--</option>
                                    <option>National Id</option>
                                    <option>Voters Id</option>
                                    <option>Pasport Document</option>
                                    <option>Driver Licences</option>
                                    <option>Employee Id</option>
                                    <option>Authority Card</option>
                                 </select>
                                 <span id="iderror" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                <label><span id="results" style=""> </span> Identification Number:</label>
                                <input type="text" name="idnumber" id="idnumber" class="form-control" onkeyup="myFunction()">
                                <span id="idnerror" style="color: red;"></span>
                                </div>
                                </div>
                                <br>
                                <div class="row"><!-- 
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button class="btn btn-info btn-sm" id="1step">Next Step</button>
                                    </div>
                                </div>
                                </div>


                                <div id="div2" style="display: none;"> 
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 2 of 3  - Customer Personal Details</h3>
                                </div>
                              <div class="col-md-6">
                                    <label>Region Name:</label>
                                    <select name="region_to" value="" class="form-control custom-select" required id="regionp" onChange="getDistrict();" required="required">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($regionlist as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span id="regnerror" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>District Name:</label>
                                    <select name="district_to" value="" class="form-control custom-select"  id="branchdropp" required="required">  
                                            <option value="">--Select District--</option>
                                        </select>
                                        <span id="errdistrict"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Residence:</label>
                                    <input type="text" name="residence" id="residence" class="form-control" onkeyup="myFunction()">
                                    <span id="errresidence"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Email</label>
                                    <input type="email" name="email" id="email" class="form-control" >
                                    <span id="erremail"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Phone Number</label>
                                    <input type="text" name="phone" id="phone" class="form-control" onkeyup="myFunction()">
                                    <span id="errphone"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Mobile</label>
                                   <input type="text" name="mobile" id="mobile" class="form-control" onkeyup="myFunction()">
                                   <span id="errmobile"></span>
                                </div>
                                </div>
                                <br>
                                <div class="row"><!-- 
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button class="btn btn-warning btn-sm" id="1stepBack">Back Step</button>
                                       <button class="btn btn-info btn-sm" id="btn_save">Save Information</button>
                                    </div>
                                </div>
                                </div>

                                <div id="div4" style="display: none;"> 
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 3 of 3  - Payment Information</h3>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12">
                                    <span id="majibu"></span>
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


<!-- <script type="text/javascript">
    $('#boxtype').on('change', function() {
        if ($('#boxtype').val() == 'Individual') {
            $('#indv').show();
            $('#sectors').hide();
            $('#error1').html('');
        }if ($('#boxtype').val() == 1) {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            //$('#results').html($('#boxtype').val());
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
</script> -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#1step').on('click',function(){
        if ($('#boxtype').val() == 0) {
                $('#error1').html('Please Select PostBox Type');
        }else{

            if ($('#tariffCat').val() == 0) {
                $('#error2').html('Please Select PostBox Category');
            }else if($('#custname').val() == ''){
                 $('#custerror').html('This field is required');
            }else if($('#custname').val() == ''){
                 $('#custerror').html('This field is required');
            }else if($('#idnumber').val() == ''){
                $('#idnerror').html('This field is required');
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
    
            var boxtype       = $('#boxtype').val();
            var tariffCat     = $('#tariffCat').val();
            var custname      = $('#cust').val();
            var iddescription = $('#iddescription').val();
            var idnumber      = $('#idnumber').val();
            var region        = $('#regionp').val();
            var district      = $('#branchdropp').val();
            var email         = $('#email').val();
            var phone         = $('#phone').val();
            var mobile        = $('#mobile').val();
            var residence     = $('#residence').val();

            if (district == ''){
            $('#errdistrict').html('This field is required');
            }else if(residence == ''){
            $('#errresidence').html('This field is required');
            }else if(region == ''){
            $('#regnerror').html('This field is required');
            }else if(mobile == ''){
            $('#errmobile').html('This field is required');
            }else{
                
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Box_Application/Register_Box_Action')?>",
                dataType : "JSON",
                data : {boxtype:boxtype,custname:custname,iddescription:iddescription,idnumber:idnumber,region:region,district:district,email:email,phone:phone,mobile:mobile,residence:residence,tariffCat:tariffCat},
                success: function(data){

                    $('#div4').show();
                    $('#div2').hide();
                    $('#majibu').html(data);

                    show_product();
                }
            });
            return false;
        }
        });


</script>
<script type="text/javascript">
        function getCustomer() {

    var val = $('#box').val();
    if (val == 'Renewal Box') {

        $('#box1').show();
    }else{
         $('#box1').hide()
    }
     
};
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
     if ( val == 5) {
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
     }else{
        $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Box_Application/GetTariffCategory",
     data:'bt_id='+ val,
     success: function(data){
        $('#tariffCat').html(data);
        $('#indv').hide();
        $('#error1').html('');
     }
 });
     }
     
};
</script>
<script type="text/javascript">
    $(document).ready(function(){
        show_product(); //call function show all product


        //function show all product
        function show_product(){
            $.ajax({
                type  : 'ajax',
                url   : '<?php echo site_url('products/recep_info')?>',
                async : true,
                dataType : 'json',
                success : function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<tr>'+
                            '<td>'+data[i].name+'</td>'+
                            '<td>'+data[i].mobile+'</td>'+
                            '<td>'+data[i].email+'</td>'+
                            '<td>'+data[i].country+'</td>'+
                            //'<td>'+data[i].centigrade+'</td>'+
                            //'<td>'+data[i].qrcode_image+'</td>'+
                            //'<td>'+data[i].status+'</td>'+
                            //'<td><a href="">'+data[i].DriverId+'</a></td>'+
                            //'<td><a href="">'+data[i].destinationId+'</a></td>'+
                            '</tr>';
                    }
                    $('#show_data').html(html);
                    $('#roles1').dataTable().clear();
                    $('#roles1').dataTable().draw();
                }

            });
        }

        
    });

</script>
<?php $this->load->view('backend/footer'); ?>

