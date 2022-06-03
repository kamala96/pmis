<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Box Application</h3>
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
                    <!-- <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Application </a></button> -->
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
                                    <h3>Step 1 of 4  - Customer Type</h3>
                                </div>
                                <div class=" col-md-6">
                                    <label>Box Type</label>
                                    <select name="renters" value="" class="form-control custom-select" required id="boxtype" onChange="getTariffCategory()">
                                            <option value="0">--Select Box Type--</option>
                                            <?Php foreach($box_renters as $value): ?>
                                             <option value="<?php echo $value->bt_id ?>"><?php echo $value->renter_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                <span id="error1" style="color: red;"></span>
                                </div>
                                <div class="col-md-6" style="display: none;" id="indv">
                                <label>PostBox Category:</label>
                                    <select name="box_category" value="" class="form-control custom-select"  id="tariffCat" required="required"> 
                                        </select>
                                <span id="error2" style="color: red;"></span>
                                </div>

                                <div class="col-md-6">
                                <label><span id="results" style=""> </span> Customer Name:</label>
                                <input type="text" name="custname" id="name" class="form-control" onkeyup="myFunction()">
                                <span id="errname" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                <label><span id="results" style=""> </span> ID Description:</label>
                                    <select name="" class="custom-select form-control" id="iddescription">
                                        <option value="0">--Select Id Type--</option>
                                        <option>Work ID</option>
                                        <option>National ID</option>
                                        <option>Passport Document</option>
                                        <option>Voters ID</option>
                                        <option>School ID</option>
                                    </select>
                                    <span id="erriddescription" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                <label><span id="results" style=""> </span> Identity Number:</label>
                                <input type="text" name="idnumber" id="idnumber" class="form-control">
                                <span id="" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Box Status</label>
                                    <select name="region_to" value="" class="form-control custom-select" required id="box" onChange="getCustomer()" required="required">
                                            <option value="0">--Select Box Status--</option>
                                            <option>New Box</option>
                                            <option>Renewal Box</option>
                                        </select>
                                    <span id="errbox" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                <label><span id="results" style=""> </span> Authority Card Number:</label>
                                <input type="text" name="authcard" id="authcard" class="form-control">
                                <span id="errauth" style="color: red;"></span>
                                </div>
                                <br />



  <!-- <form id="test_form">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <br />
        <div id="input_wrapper"></div>
        <button id="save_btn" class="btn btn-success">Save</button>
        <button id="add_btn" class="btn btn-danger">Add Outstanding</button>
      </div>
  </form> -->
   


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
                                    <h3>Step 2 of 4  - Customer Personal Details</h3>
                                </div>
                                <div class="col-md-6">
                                    <label>First Name:</label>
                                    <input type="text" name="fname" id="fname" class="form-control" onkeyup="myFunction()">
                                    <span id="errfname"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Middle Name:</label>
                                    <input type="text" name="mname" id="mname" class="form-control" onkeyup="myFunction()">
                                    <span id="errmname"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Last Name:</label>
                                    <input type="text" name="lname" id="lname" class="form-control" onkeyup="myFunction()">
                                    <span id="errlname"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control custom-select" id="gender">
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Occupation</label>
                                    <input type="text" name="occupation" id="occu" class="form-control" onkeyup="myFunction()">
                                    <span id="erroccu"></span>
                                </div>
                                 
                                <div class="col-md-6" style="" id="box1">
                                    <label>Box Number</label>
                                    <input type="number" name="box" id="boxn" class="form-control">
                                </div>

                                </div>
                                <br>
                                <div class="row"><!-- 
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button class="btn btn-warning btn-sm" id="1stepBack">Back Step</button>
                                        <button class="btn btn-info btn-sm" id="2step">Next Step</button>
                                    </div>
                                </div>
                                </div>


                                <div id="div3" style="display: none;"> 
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 3 of 4  - Customer Address Details</h3>
                                </div>
                                <div class="col-md-6">
                                    <label>Region Name:</label>
                                    <select name="region_to" value="" class="form-control custom-select" required id="regionp" onChange="getDistrict();" required="required">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($regionlist as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Branch Name:</label>
                                    <select name="district_to" value="" class="form-control custom-select"  id="branchdropp" required="required">  
                                            <option value="">--Select Branch--</option>
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
                                    <input type="email" name="email" id="email" class="form-control" onkeyup="myFunction()">
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
                                        <button class="btn btn-warning btn-sm" id="2stepBack">Back Step</button>
                                        <button class="btn btn-info btn-sm" id="btn_save">Save Information</button>
                                    </div>
                                </div>
                                </div>

                                <div id="div4" style="display: none;"> 
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 4 of 4  - Payment Information</h3>
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
        var idnumber = $('#idnumber').val();
        var iddescription         = $('#iddescription').val();
        var box         = $('#box').val();
        $('#1step').on('click',function(){
        if ($('#boxtype').val() == 0) {
                $('#error1').html('Please Select PostBox Type');
        }else if($('#name').val() == ""){
            $('#errname').html('This field is required');
        }else if($('#iddescription').val() == 0){
            $('#erriddescription').html('This field is required');
        }else if( $('#idnumber').val() == ""){
            $('#erridnumber').html('This field is required');
        }else if( $('#box').val() == 0){
            $('#errbox').html('This field is required');
        }else if( $('#authcard').val() == ""){
            $('#errauth').html('This field is required');
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


 var formData = $('#test_form').serializeObject(); // serialize the form
    var obj; //obj can be use to send to ajax call
      var years   ='';
     var TotalOutstandingamount = 0;
    if(Array.isArray(formData.fn)) {
        for(var i = 0; i < formData.fn.length; i++) {
        obj = {};
        // set the obj for submittion
        obj.Year = formData.fn[i];
        obj.Amount = formData.ln[i];

        years=' '.formData.fn[i].' Balance'.formData.ln[i].'';
        TotalOutstandingamount =TotalOutstandingamount +  formData.ln[i]; 
        // This object could be push into an array
        console.log('object from form array ', TotalOutstandingamount);
        console.log('object from form array ', obj);
      };
    } else {
        obj = {};
      obj.Year = formData.fn;
      obj.Amount = formData.ln;
      years=' '.formData.fn.' Balance'.formData.ln.'';
        TotalOutstandingamount =TotalOutstandingamount +  formData.ln; 
      console.log('single obj from form ', obj);
       console.log('object from form array ', TotalOutstandingamount);
    }






    
            var boxtype   = $('#boxtype').val();
            var tariffCat = $('#tariffCat').val();
            var fname     = $('#fname').val();
            var name     = $('#name').val();
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
            var boxn         = $('#boxn').val();
            var idnumber = $('#idnumber').val();
            var iddescription         = $('#iddescription').val();
            var box         = $('#box').val();
            var authcard         = $('#authcard').val();
            var boxn         = $('#boxn').val();

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
                data : {boxtype:boxtype,fname:fname,mname:mname,lname:lname,gender:gender,occu:occu,region:region,district:district,email:email,phone:phone,mobile:mobile,residence:residence,tariffCat:tariffCat,boxn:boxn,name:name,idnumber:idnumber,box:box,iddescription:iddescription,authcard:authcard,boxn1:boxn },
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
   $(document).ready(function() {
    var x = 0;
    $('#save_btn').hide();
  
    $('#add_btn').click(function(e) {
    e.preventDefault();
    appendRow(); // appen dnew element to form 
    x++; // increment counter for form
    $('#save_3btn').show(); // show save button for form
  });

    $('#input_wrapper').on('click', '.deleteBtn', function(e) {
    e.preventDefault();
    var id = e.currentTarget.id; // set the id based on the event 'e'
    $('div[id='+id+']').remove(); //find div based on id and remove
    x--; // decrement the counter for form.
    
    if (x === 0) { 
        $('#save_3btn').hide(); // hides the save button if counter is equal to zero
    }
  });
    
  $('#save_3btn').click(function(e) {
    e.preventDefault();
    var formData = $('#test_form').serializeObject(); // serialize the form
    var obj; //obj can be use to send to ajax call
    if(Array.isArray(formData.fn)) {
        for(var i = 0; i < formData.fn.length; i++) {
        obj = {};
        // set the obj for submittion
        obj.Year = formData.fn[i];
        obj.Amount = formData.ln[i];
        // This object could be push into an array
        console.log('object from form array ', obj);
      };
    } else {
        obj = {};
      obj.Year = formData.fn;
      obj.Amount = formData.ln;
      console.log('single obj from form ', obj);
    }
  });
  
  function appendRow() {
    $('#input_wrapper').append(
        // '<label><span id="results" style=""> </span> Outstanding Balance</label>'+
        // '<br />'+
        '<div id="'+x+'" class="form-group" style="display:flex;">' +
          '<div>' +
         '<select name="fn" id="'+x+'" class="form-control col-md-6" >'+
                                        '<option value="">--Select Year --</option>'+ 
                                         '<option value="2011">2010</option>'+ 
                                         '<option value="2011">2011</option>'+ 
                                      '<option value="2012">2012</option>'+
                                    '<option value="2013">2013</option>'+
                                     '<option value="2014">2014</option>'+
                                    '<option value="2015">2015</option>'+
                                      '<option value="2016">2016</option>'+ 
                                      '<option value="2017">2017</option>'+
                                    '<option value="2018">2018</option>'+
                                     '<option value="2019">2019</option>'+
                                    '<option value="2020">2020</option>'+


            // '<input type="text" id="'+x+'" class="form-control" name="fn"                                   placeholder="Select Year"/>' +
          '</div>' +
          '<div>'+
          '<input type="text" id="'+x+'" class="form-control col-md-6" name="ln"                                         placeholder="Amount"/>'+
          '</div>' +
          '<div>'+
            '<button id="'+x+'" class="btn btn-danger deleteBtn"><i class="glyphicon glyphicon-trash"></i> Remove</button>' +
          '</div>' +
        '</div>');
  }
  
});

$.fn.serializeObject = function(asString) {
   var o = {};
   var a = this.serializeArray();
   $.each(a, function() {

       if($('#' + this.name).hasClass('date')) {
           this.value = new Date(this.value).setHours(12);
       }

       if (o[this.name] !== undefined) {
           if (!o[this.name].push) {
               o[this.name] = [o[this.name]];
           }
           o[this.name].push(this.value || '');
       } else {
           o[this.name] = this.value || '';
       }
   });
   if (asString) {
       return JSON.stringify(o);
   }
   return o;
};
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
     url: "<?php echo base_url();?>Employee/GetBranch",
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

