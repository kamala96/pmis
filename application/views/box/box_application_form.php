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
    <?php //$regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12 row">
                    <!-- <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Application </a></button> -->
                    <a href="<?php echo base_url() ?>Box_Application/BoxRental" class="btn btn-primary"><i class="fa fa-plus"></i> Box Application</a>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Box_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Box Application List</a></button>
                       <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Box_accessories_dashboard" class="text-white"><i class="" aria-hidden="true"></i> Box Accessories</a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Bulkboxes" class="text-white"><i class="" aria-hidden="true"></i> Bulk Boxes</a></button>

                         <div class="" >
                      <form method="post" action="<?php echo base_url();?>Box_Application/Gotobox">
                        <div class="input-group" >
                                        <input type="number" placeholder="Box Number" name="box_numbersearch" class="form-control">
                                         <?php if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "BOP" || $this->session->userdata('user_type') == "CRM" || $this->session->userdata('user_type') == "SUPPORTER" ){ ?>
                                          <select class="form-control custom-select" name="region">
                                            <option value="">--Select Region-</option>
                                            <?php foreach ($regionlist as $value) { ?>
                                              <option><?php echo $value->region_name ?></option>
                                            <?php } ?>
                                          </select>
                                        <?php }?>
                                      
                                        <input type="submit" class="btn btn-success" style="" id="" value="Goto Box" required="required"> 

                                        <?php if(!empty($this ->session->flashdata('infor'))){ ?>
                                            <h3 id="info" style="padding-left:10px; color: red;">
                                                 <?php echo $this ->session->userdata('infor'); ?>
                                            </h3>
                  
                                      
                                        
                                                        <?php }?>

                                         

                                    </div>

                  </form>
              </div>

                 <?php if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "BOP" || $this->session->userdata('user_type') == "CRM" || $this->session->userdata('user_type') == "SUPPORTER" ){ ?>
                         <div class="" >
                      <form method="post" action="<?php echo base_url();?>Box_Application/Updateboxtransactionlocation">
                        <div class="input-group" >
                                        <input type="number" placeholder="ControlNumber" name="billid" class="form-control">
                                      
                                        <input type="submit" class="btn btn-success" style="" id="" value="Update Box" required="required"> 

                                        <?php if(!empty($this ->session->flashdata('infor2'))){ ?>
                                            <h3 id="info2" style="padding-left:10px; color: green;">
                                                 <?php echo $this ->session->userdata('infor2'); ?>
                                            </h3>
                  
                                      
                                        
                                                        <?php }?>

                                         

                                    </div>

                  </form>
              </div>

               <?php }?>
                                      

                
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Get_Box_Invoice" class="text-white"><i class="" aria-hidden="true"></i>Print Box Invoice</a></button>
                 <?php //if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "RM" ){ ?>
  
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Box_Application_Invoice" class="text-white"><i class="" aria-hidden="true"></i> Box List</a></button>

                       <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Virtual_Box_Application_List" class="text-white"><i class="" aria-hidden="true"></i>Virtue Application List</a></button>

                     <?php //} ?>

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
                                <div class=" col-md-4">
                                    <label>Box Type</label>
                                    <select name="renters" value="" class="form-control custom-select" required id="boxtype" onChange="getTariffCategory()">
                                            <option value="0">--Select Box Type--</option>
                                            <?Php foreach($box_renters as $value): ?>
                                             <option value="<?php echo $value->bt_id ?>"><?php echo $value->renter_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                <span id="error1" style="color: red;"></span>
                                </div>
                                <div class="col-md-4" style="display: none;" id="indv">
                                <label>PostBox Category:</label>
                                    <select name="box_category" value="" class="form-control custom-select tariffCat"  id="tariffCat" required="required" onChange="GetPriceFrom()"> 
                                        </select>
                                <span id="error2" style="color: red;"></span>
                                </div>

                                <div class="col-md-4">
                                <label><span id="results" style=""> </span> Customer Name:</label>
                                <input type="text" name="custname" id="name" class="form-control" onkeyup="myFunction()">
                                <span id="errname" style="color: red;"></span>
                                </div>
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                <label><span id="results" style=""> </span> Identity Number:</label>
                                <input type="text" name="idnumber" id="idnumber" class="form-control">
                                <span id="erridnumber" style="color: red;"></span>
                                </div>
                                <div class="col-md-4">
                                    <label>Box Status</label>
                                    <select name="region_to" value="" class="form-control custom-select" required id="box" onChange="getRenewal()" required="required">
                                            <option value="0">--Select Box Status--</option>
                                            <option>New Box</option>
                                            <option>Renewal Box</option>
                                        </select>
                                    <span id="errbox" style="color: red;"></span>
                                </div>
                                <div class="col-md-4">
                                <label><span id="results" style=""> </span> Authority Card Number:</label>
                                <input type="text" name="authcard" id="authcard" class="form-control">
                                <input type="hidden" name="validateyear" value="" class="validateyear" id="validateyear"> 
                                 <input type="hidden" name="validateoutstanding" value="" class="validateoutstanding" id="validateoutstanding"> 
                                <div id="test_form5" style="display: block;">
                                <span id="errauth" style="color: red;"></span>
                                
                                </div>
                                <br />

                                  <div class="col-sm-12 col-md-12 col-lg-12">
       
                                <span id="errvalidateyear" style="color: red;"></span>
                                <span id="errvalidateoutstanding" style="color: red;"></span>
                            </div>

  <form id="test_form4" >
      <div class="col-sm-12 col-md-12 col-lg-12">
        <br />
        <div id="input_wrapper3"></div>
        <!-- <button id="save_btn" class="btn btn-success">Save</button> -->
        <button id="add_btn3" class="btn btn-danger">Add Next Year Payments</button>
      </div>
  </form>
   </div>

<div id="test_form1" style="display: none;">
  <form id="test_form" >
      <div class="col-sm-12 col-md-12 col-lg-12">
        <br />
        <div id="input_wrapper"></div>
        <!-- <button id="save_btn" class="btn btn-success">Save</button> -->
        <button id="add_btn" class="btn btn-danger">Add Outstanding</button>
      </div>
  </form>
   </div>

  

   <div id="test_form2" style="display: none;">
  <form id="test_form3" >
      <div class="col-sm-12 col-md-12 col-lg-12">
        <br />
        <div id="input_wrapper2"></div>
        <!-- <button id="save_btn" class="btn btn-success">Save</button> -->
        <button id="add_btn2" class="btn btn-danger">Add Box accesories</button>
      </div>
  </form>
   </div>


                                </div>
                                <br />

                                  <div class="row">
                                    <div class="col-md-12">
                                    <span class ="price" style="font-weight: 60px;font-size: 18px;"></span>
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
                                    <h3>Step 2 of 4  - Customer Personal Details</h3>
                                </div>
                                <div class="col-md-4">
                                    <label>First Name:</label>
                                    <input type="text" name="fname" id="fname" class="form-control" onkeyup="myFunction()">
                                    <span id="errfname"  style="color: red;"></span>
                                </div>
                                <div class="col-md-4">
                                    <label>Middle Name:</label>
                                    <input type="text" name="mname" id="mname" class="form-control" onkeyup="myFunction()">
                                    <span id="errmname"  style="color: red;"></span>
                                </div>
                                <div class="col-md-4">
                                    <label>Last Name:</label>
                                    <input type="text" name="lname" id="lname" class="form-control" onkeyup="myFunction()">
                                    <span id="errlname"  style="color: red;"></span>
                                </div>
                                <div class="col-md-4">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control custom-select" id="gender">
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Occupation</label>
                                    <input type="text" name="occupation" id="occu" class="form-control" onkeyup="myFunction()">
                                    <span id="erroccu"  style="color: red;"></span>
                                </div>
                                 
                                <div class="col-md-4" style="" id="box1">
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
                                <div class="col-md-4">
                                    <label>Region Name:</label>
                                    <select name="region_to" value="" class="form-control custom-select" required id="regionp" onChange="getDistrict();" required="required">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($regionlist as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Branch Name:</label>
                                    <select name="district_to" value="" class="form-control custom-select"  id="branchdropp" required="required">  
                                            <option value="">--Select Branch--</option>
                                        </select>
                                        <span id="errdistrict"  style="color: red;"></span>
                                </div>
                                <div class="col-md-4">
                                    <label>Residence:</label>
                                    <input type="text" name="residence" id="residence" class="form-control" onkeyup="myFunction()">
                                    <span id="errresidence"  style="color: red;"></span>
                                </div>
                                <div class="col-md-4">
                                    <label>Email</label>
                                    <input type="email" name="email" id="email" class="form-control" onkeyup="myFunction()">
                                    <span id="erremail"  style="color: red;"></span>
                                </div>
                                <div class="col-md-4">
                                    <label>Phone Number</label>
                                    <input type="text" name="phone" id="phone" class="form-control" onkeyup="myFunction()">
                                    <span id="errphone"  style="color: red;"></span>
                                </div>
                                <div class="col-md-4">
                                    <label>Mobile</label>
                                   <input type="text" name="mobile" id="mobile" class="form-control" onkeyup="myFunction()">
                                   <span id="errmobile"  style="color: red;"></span>
                                </div>
                                </div>
                                <br>
                                <div class="row"><!-- 
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button class="btn btn-warning btn-sm" id="2stepBack">Back Step</button>
                                        <button class="btn btn-info btn-sm disable" id="btn_save">Save Information</button>
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

                                <div id="loaderDiv" style="display:none;">
                                    <?php $image='ajax-loader.gif';
                                    echo '<img src="'.base_url().'images/'.$image.'" style="width: 150px; height: 140px;" id="ajaxSpinnerImage" title="working..." >';
                                    ?>
                                 </div>
                                 <div class="overlay"></div>
                                  <div id="loader" class="lds-dual-ring hidden overlay2"></div>

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
   $(document).ready(function() {
    var x = 0;
    $('#save_btn').hide();
  
    $('#add_btn3').click(function(e) {
    e.preventDefault();
     $('#validateyear').val('validated');
      $('#errvalidateyear').val('');
    appendRow(); // appen dnew element to form 
    x++; // increment counter for form
    $('#save_btn').show(); // show save button for form
  });

    $('#input_wrapper3').on('click', '.deleteBtn3', function(e) {
    e.preventDefault();
    var id = e.currentTarget.id; // set the id based on the event 'e'
    $('div[id='+id+']').remove(); //find div based on id and remove
    x--; // decrement the counter for form.
    
    if (x === 0) { 
        $('#save_btn').hide(); // hides the save button if counter is equal to zero
    }
  });
    
  $('#save_btn').click(function(e) {
    e.preventDefault();
   var formData = $('#test_form4').serializeObject(); // serialize the form
    //var arr[]; //obj can be use to send to ajax call
    var obj;
    
      var years   ='';
     var TotalOutstandingamount = 0;
    if(Array.isArray(formData.fn)) {
        for(var i = 0; i < formData.fn.length; i++) {
        obj = {};
        // set the obj for submittion
        obj.Year = formData.fn[i];
        obj.Amount = formData.ln[i];

        years=' '+ formData.fn[i]+' Balance'.formData.ln[i]+'';
        TotalOutstandingamount =TotalOutstandingamount + +formData.ln[i]  ; 
         //arr.insert(obj)
        // This object could be push into an array
        //console.log('object from form array ', TotalOutstandingamount);
        



      };
    } else {
        obj = {};
      obj.Year = formData.fn;
      obj.Amount = formData.ln;
       //arr.insert(obj)
      //years=' '.formData.fn.' Balance'.formData.ln.'';
       // TotalOutstandingamount =TotalOutstandingamount +  parseInt(formData.ln); 
      console.log('single obj from form ', obj);
       //console.log('object from form array ', TotalOutstandingamount);
    }

       //console.log('object from form array ', arr);s
  });
  
  function appendRow() {

    $('#input_wrapper3').append(
        // '<label><span id="results" style=""> </span> Outstanding Balance</label>'+
        // '<br />'+
        '<div id="'+x+'" class="form-group" style="display:flex;">' +
          '<div>' +
         '<select name="fn" id="'+x+'" class="form-control col-md-6" >'+
                                        '<option value="">--Select Year --</option>'+ 
                                         '<option value="2022">2022</option>'+ 
                                         '<option value="2023">2023</option>'+ 
                                      '<option value="2024">2024</option>'+
                                    '<option value="2025">2025</option>'+
                                     '<option value="2026">2026</option>'+
                                    '<option value="2027">2027</option>'+
                                      '<option value="2028">2028</option>'+ 
                                      '<option value="2029">2029</option>'+
                                    '<option value="2030">2030</option>'+
                                     '<option value="2031">2031</option>'+
                                    '<option value="2032">2032</option>'+


            // '<input type="text" id="'+x+'" class="form-control" name="fn"                                   placeholder="Select Year"/>' +
          '</div>' +
          '<div>'+
          '<input type="text" id="'+x+'" class="form-control col-md-6" name="ln"                                         placeholder="Amount"/>'+
          '</div>' +
          '<div>'+
            '<button id="'+x+'" class="btn btn-danger deleteBtn3"><i class="glyphicon glyphicon-trash"></i> Remove</button>' +
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
<script>
function GetPriceFrom() {

 
  var tariffCat  = $('.tariffCat').val();
    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Getprices1')?>",
                 //dataType : "JSON",
                 data : {tariffCat:tariffCat},
                 success: function(data){
                    $('.price').html(data);
                 }
             });
};
</script>
<script type="text/javascript">
        function getRenewal() {

    var val = $('#box').val();
    if (val == 'Renewal Box') {
        $('#box1').show();
        $('#test_form1').show();
    }else{
         $('#test_form1').hide()
         $('#box1').hide();
    }
     
 if (val == 'New Box') {
        $('#box1').hide();
        $('#test_form2').show();
    }else{
         $('#test_form2').hide()
         $('#box1').show();
    }


};
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var idnumber = $('#idnumber').val();
        var iddescription         = $('#iddescription').val();
        var box         = $('#box').val();
        $('#1step').on('click',function(){
        if ($('#boxtype').val() == 0) {
                $('#error1').html('Please Select PostBox Type');//
        }else if(($('#validateyear').val() == "") && $('#box').val() ==  'Renewal Box' && $('#validateoutstanding').val() == ""){
            $('#errvalidateyear').html('Please Choose Year/Outstanding');
            $('#error1').hide();
        }else if($('#name').val() == ""){
            $('#errname').html('Please Input Customer Name');
            $('#error1').hide();
        }else if($('#iddescription').val() == 0){
            $('#erriddescription').html('Please select Id Type');
            $('#errname').hide();
        }else if( $('#idnumber').val() == ""){
            $('#erridnumber').html('Please input Id Number');
            $('#erriddescription').hide();
        }else if( $('#box').val() == 0){
            $('#errbox').html('Please select Box Status');
             $('#erridnumber').hide();
        }else if( $('#authcard').val() == ""){
            $('#errauth').html('Please input Authority Card Number');
            $('#errbox').hide();
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
            $('#errfname').html('Please Input Firstname');
        }else if($('#mname').val() == ''){
            $('#errmname').html('Please Input MiddleName');
            $('#errfname').hide();
        }else if($('#lname').val() == ''){
            $('#errlname').html('Please Input Lastname');
            $('#errmname').hide();
        }else if($('#occu').val() == ''){
            $('#erroccu').html('Please Input Occupation');
            $('#errlname').hide();
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

$('.disable').attr("disabled", true);
 
    
       var formData1 = $('#test_form4').serializeObject(); // serialize the form
    //var arr[]; //obj can be use to send to ajax call
    var obj1;
    var payments = new Array();
      var years1   ="";
     var Totalpaymentsamount = 0;
     var Totalpaymentsvalue = 0;
    if(Array.isArray(formData1.fn)) {
        for(var i = 0; i < formData1.fn.length; i++) {
        obj1 = {};

         //var $someArray = [["year" => formData.fn[i],"amount" => formData.ln[i]];
        // set the obj for submittion
        obj1.year = formData1.fn[i];
        obj1.amount = formData1.ln[i];

        years1=years1 + ","+ formData1.fn[i]+" Balance "  + formData1.ln[i];
        Totalpaymentsamount =Totalpaymentsamount + +formData1.ln[i]  ; 
        Totalpaymentsvalue=10;
         payments.push(obj1)

      //console.log('single obj from  ', myArray);
      };
    }  else if(formData1.fn == null || formData1.fn == '')
    {

        //obj = {};
      //obj.Year = formData.fn;
      //obj.Amount = formData.ln;
         //myArray.push(obj)
      years1='';
        Totalpaymentsamount =0;
        Totalpaymentsvalue =10;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
    else {

        obj1 = {};
      obj1.Year = formData1.fn;
      obj1.Amount = formData1.ln;
         payments.push(obj1)
      years1=""+ formData1.fn+" Balance "  + formData1.ln;
        Totalpaymentsamount =Totalpaymentsamount +  +formData1.ln; 
        Totalpaymentsvalue=0;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
        //console.log('years ', years);
       //  console.log('TotalOutstandingamount ', TotalOutstandingamount);
       // console.log('object from form array ', myArray);
    


      var val = $('#box').val();
    if (val == 'Renewal Box') {
       var formData = $('#test_form').serializeObject(); // serialize the form
    //var arr[]; //obj can be use to send to ajax call
    var obj;
    var myArray = new Array();
      var years   ="";
     var TotalOutstandingamount = 0;
     var TotalOutstandingvalue = 0;
    if(Array.isArray(formData.fn)) {
        for(var i = 0; i < formData.fn.length; i++) {
        obj = {};

         //var $someArray = [["year" => formData.fn[i],"amount" => formData.ln[i]];
        // set the obj for submittion
        obj.year = formData.fn[i];
        obj.amount = formData.ln[i];

        years=years + ","+ formData.fn[i]+" Balance "  + formData.ln[i];
        TotalOutstandingamount =TotalOutstandingamount + +formData.ln[i]  ; 
        TotalOutstandingvalue=10;
         myArray.push(obj)

      //console.log('single obj from  ', myArray);
      };
    }  else if(formData.fn == null || formData.fn == '')
    {

        //obj = {};
      //obj.Year = formData.fn;
      //obj.Amount = formData.ln;
         //myArray.push(obj)
      years='';
        TotalOutstandingamount =0;
        TotalOutstandingvalue =10;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
    else {

        obj = {};
      obj.Year = formData.fn;
      obj.Amount = formData.ln;
         myArray.push(obj)
      years=""+ formData.fn+" Balance "  + formData.ln;
        TotalOutstandingamount =TotalOutstandingamount +  +formData.ln; 
        TotalOutstandingvalue=0;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
        //console.log('years ', years);
       //  console.log('TotalOutstandingamount ', TotalOutstandingamount);
       // console.log('object from form array ', myArray);
    }

    else
    {
        var formData = $('#test_form3').serializeObject(); // serialize the form
    //var arr[]; //obj can be use to send to ajax call
    var obj;
    var myArray2 = new Array();
      var accesory   ="";
     var TotalAccesoryamount = 0;
     var TotalAccesoryvalue = 0;
    if(Array.isArray(formData.fn)) {
        for(var i = 0; i < formData.fn.length; i++) {
        obj = {};

         //var $someArray = [["year" => formData.fn[i],"amount" => formData.ln[i]];
        // set the obj for submittion
        obj.accesory = formData.fn[i];
        obj.amount = formData.ln[i];

        accesory=accesory + ","+ formData.fn[i]+" Amount "  + formData.ln[i];
        TotalAccesoryamount =TotalAccesoryamount + +formData.ln[i]  ; 
        TotalAccesoryvalue=10;
         myArray2.push(obj)

      //console.log('single obj from  ', myArray);
      };
    }  else if(formData.fn == null || formData.fn == '')
    {

        //obj = {};
      //obj.Year = formData.fn;
      //obj.Amount = formData.ln;
         //myArray.push(obj)
      accesory='';
        TotalAccesoryamount =0;
        TotalAccesoryvalue =10;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
    else {

        obj = {};
      obj.accesory = formData.fn;
      obj.Amount = formData.ln;
         myArray2.push(obj)
      accesory=""+ formData.fn+" Amount "  + formData.ln;
        TotalAccesoryamount =TotalAccesoryamount +  +formData.ln; 
        TotalAccesoryvalue=0;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
        //console.log('years ', years);
       //  console.log('TotalAccesoryamount ', TotalAccesoryamount);
       // console.log('object from form array ', myArray2);
     
    }



            var AccesoryArray   = myArray2;
            var TotalAccesoryamounts   = TotalAccesoryamount;
             var TotalAccesoryvalues   = TotalAccesoryvalue;
            var accesoryDesc = accesory;


            var OutstandingArray   = myArray;
            var TotalOutstandingamounts   = TotalOutstandingamount;
             var TotalOutstandingvalues   = TotalOutstandingvalue;
            var OutstandingDesc = years;

            var paymentsArray   = payments;
            var Totalpaymentsamounts   = Totalpaymentsamount;
             var Totalpaymentsvalues   = Totalpaymentsvalue;
            var paymentsDesc = years1;

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
            $('#errdistrict').html('Please Select District');
            
            $('.disable').attr("disabled", false);
           }else if(residence == ''){
            $('#errresidence').html('Please Input Residence');
            $('#errdistrict').hide();
            $('.disable').attr("disabled", false);
             }
            //  else if(email == ''){
            // $('#erremail').html('Please Input Email');
            // }
            else if(phone == ''){
            $('#errphone').html('Please Input Phone Number');
             $('#errresidence').hide();
            $('.disable').attr("disabled", false);
            }else if(mobile == ''){
            $('#errmobile').html('Please Input Mobile Number');
             $('#errphone').hide();
            $('.disable').attr("disabled", false);
            }else{

                //$('#majibu').html("<img src='assets/images/users/'>");

            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Box_Application/Register_Box_Action')?>",
                dataType : "JSON",
                data : {boxtype:boxtype,fname:fname,mname:mname,lname:lname,gender:gender,occu:occu,region:region,district:district,email:email,phone:phone,mobile:mobile,residence:residence,tariffCat:tariffCat,boxn:boxn,name:name,idnumber:idnumber,box:box,iddescription:iddescription,authcard:authcard,boxn1:boxn,TotalOutstandingamounts:TotalOutstandingamounts,OutstandingDesc:OutstandingDesc,TotalOutstandingvalues:TotalOutstandingvalues,OutstandingArray:JSON.stringify(OutstandingArray),
                  TotalAccesoryamounts:TotalAccesoryamounts,accesoryDesc:accesoryDesc,TotalAccesoryvalues:TotalAccesoryvalues,AccesoryArray:JSON.stringify(AccesoryArray),Totalpaymentsamounts:Totalpaymentsamounts,paymentsDesc:paymentsDesc,Totalpaymentsvalues:Totalpaymentsvalues,paymentsArray:JSON.stringify(paymentsArray) },
                beforeSend: function() {
                    //$("#loaderDiv").show();
                   //$("body").addClass("loading");
                      $("#btn_save").addClass('button_loader').attr("value",""); 
                      //$('#loader').removeClass('hidden');
                    
                 },
                  // complete: function() {
                    
                  // },
                success: function(data){
                     
                    //$("#loaderDiv").hide();
                     //$("body").removeClass("loading"); 
                      $('#btn_save').removeClass('button_loader').attr("value","\u2713");
                      $('#btn_save').prop('disabled', true);
                       //$('#loader').addClass('hidden');

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
     $('#validateoutstanding').val('validated');//
      $('#errvalidateoutstanding').val('');
    appendRow(); // appen dnew element to form 
    x++; // increment counter for form
    $('#save_btn').show(); // show save button for form
  });

    $('#input_wrapper').on('click', '.deleteBtn', function(e) {
    e.preventDefault();
    var id = e.currentTarget.id; // set the id based on the event 'e'
    $('div[id='+id+']').remove(); //find div based on id and remove
    x--; // decrement the counter for form.
    
    if (x === 0) { 
        $('#save_btn').hide(); // hides the save button if counter is equal to zero
    }
  });
    
  $('#save_btn').click(function(e) {
    e.preventDefault();
   var formData = $('#test_form').serializeObject(); // serialize the form
    //var arr[]; //obj can be use to send to ajax call
    var obj;
    
      var years   ='';
     var TotalOutstandingamount = 0;
    if(Array.isArray(formData.fn)) {
        for(var i = 0; i < formData.fn.length; i++) {
        obj = {};
        // set the obj for submittion
        obj.Year = formData.fn[i];
        obj.Amount = formData.ln[i];

        years=' '+ formData.fn[i]+' Balance'.formData.ln[i]+'';
        TotalOutstandingamount =TotalOutstandingamount + +formData.ln[i]  ; 
         //arr.insert(obj)
        // This object could be push into an array
        //console.log('object from form array ', TotalOutstandingamount);
        



      };
    } else {
        obj = {};
      obj.Year = formData.fn;
      obj.Amount = formData.ln;
       //arr.insert(obj)
      //years=' '.formData.fn.' Balance'.formData.ln.'';
       // TotalOutstandingamount =TotalOutstandingamount +  parseInt(formData.ln); 
      console.log('single obj from form ', obj);
       //console.log('object from form array ', TotalOutstandingamount);
    }

       //console.log('object from form array ', arr);s
  });
  
  function appendRow() {
    $('#input_wrapper').append(
        // '<label><span id="results" style=""> </span> Outstanding Balance</label>'+
        // '<br />'+
        '<div id="'+x+'" class="form-group" style="display:flex;">' +
          '<div>' +
         '<select name="fn" id="'+x+'" class="form-control col-md-6" >'+
                                        '<option value="">--Select Year --</option>'+ 
                                         '<option value="2010">2010</option>'+ 
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
                                    '<option value="2021">2021</option>'+


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
   $(document).ready(function() {
    var x = 0;
    $('#save_btn').hide();
  
    $('#add_btn2').click(function(e) {
    e.preventDefault();
    appendRow(); // appen dnew element to form 
    x++; // increment counter for form
    $('#save_btn').show(); // show save button for form
  });

    $('#input_wrapper2').on('click', '.deleteBtn', function(e) {
    e.preventDefault();
    var id = e.currentTarget.id; // set the id based on the event 'e'
    $('div[id='+id+']').remove(); //find div based on id and remove
    x--; // decrement the counter for form.
    
    if (x === 0) { 
        $('#save_btn').hide(); // hides the save button if counter is equal to zero
    }
  });
    
  $('#save_btn').click(function(e) {
    e.preventDefault();
   var formData = $('#test_form2').serializeObject(); // serialize the form
    //var arr[]; //obj can be use to send to ajax call
    var obj;
    
      var years   ='';
     var TotalOutstandingamount = 0;
    if(Array.isArray(formData.fn)) {
        for(var i = 0; i < formData.fn.length; i++) {
        obj = {};
        // set the obj for submittion
        obj.Year = formData.fn[i];
        obj.Amount = formData.ln[i];

        years=' '+ formData.fn[i]+' Balance'.formData.ln[i]+'';
        TotalOutstandingamount =TotalOutstandingamount + +formData.ln[i]  ; 
         //arr.insert(obj)
        // This object could be push into an array
        //console.log('object from form array ', TotalOutstandingamount);
        



      };
    } else {
        obj = {};
      obj.Year = formData.fn;
      obj.Amount = formData.ln;
       //arr.insert(obj)
      //years=' '.formData.fn.' Balance'.formData.ln.'';
       // TotalOutstandingamount =TotalOutstandingamount +  parseInt(formData.ln); 
      console.log('single obj from form ', obj);
       //console.log('object from form array ', TotalOutstandingamount);
    }

       //console.log('object from form array ', arr);s
  });
  
  function appendRow() {
    $('#input_wrapper2').append(
        // '<label><span id="results" style=""> </span> Outstanding Balance</label>'+
        // '<br />'+
        '<div id="'+x+'" class="form-group" style="display:flex;">' +
          '<div>' +
         '<select name="fn" id="'+x+'" class="form-control col-md-6" >'+
                                        '<option value="">--Select accesory --</option>'+ 
                                         '<option value="Key Deposity">Key Deposity</option>'+ 
                                         '<option value="Authority Card">Authority Card</option>'+ 
                                    


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
        function getDistrict() {
    var val = $('#regionp').val();
     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Employee/GetBoxBranch",
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

