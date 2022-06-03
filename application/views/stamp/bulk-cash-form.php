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
        <div class="col-12">
                   <?php if($this->session->userdata('user_type') =='ACCOUNTANT' 
                  || $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ ?>
               
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Stamp/Stamp_List" class="text-white"><i class="" aria-hidden="true"></i> Stamp Transaction List</a></button>

<?php }else{?>

                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Stamp/bulk_Stamp_cash_form" class="text-white"><i class="" aria-hidden="true"></i>Add Cash Stamp </a></button>
                     
                      <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Stamp/Stamp_cash_List" class="text-white"><i class="" aria-hidden="true"></i>Stamp Cash List </a></button>

                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Stamp/Stamp_form" class="text-white"><i class="" aria-hidden="true"></i>Add Stamp Transaction </a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Stamp/Stamp_List" class="text-white"><i class="" aria-hidden="true"></i> Stamp Transaction List</a></button>

                       <?php }?>
                </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Cash Bulk Form   </h4>
                         <span id="result" style="color: green;"></span>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                            <div id="div1"> 
                                <div class="row">
                                
                                <div class="col-md-12">
                                    <h3> Cash Bulk </h3>
                                </div>
                             
                             

                                <div class="col-md-3">
                                <label><span id="results" style=""> </span> Customer Name:</label>
                                <input type="text" name="custname" id="name" class="form-control">
                                <span id="errname" style="color: red;"></span>
                                </div>

                              <!--   <div class="col-md-3">
                                <label><span id="results" style=""> </span> Customer Mobile:</label>
                                <input type="text" name="custname" id="name" class="form-control" onkeyup="myFunction()">
                                <span id="errname" style="color: red;"></span>
                                </div> -->

                                 <div class="col-md-3">
                                <label><span id="results" style=""> </span> Invoice Number:</label>
                                <input type="text" name="invoice" id="invoice" class="form-control">
                                <span id="errinvoice" style="color: red;"></span>

                                </div>
                               
                              
                              <!--   <div class="col-md-6">
                                    <label>Box Status</label>
                                    <select name="region_to" value="" class="form-control custom-select" required id="box" onChange="getRenewal()" required="required">
                                            <option value="0">--Select Box Status--</option>
                                            <option>New Box</option>
                                            <option>Renewal Box</option>
                                        </select>
                                    <span id="errbox" style="color: red;"></span>
                                </div> -->

                            </div>
                              
                                <br />
<div id="test_form5" style="display: block;">
  <form id="test_form4" >
      <div class="col-sm-12 col-md-12 col-lg-12">
        <br />
        <div id="input_wrapper3"></div>
        <!-- <button id="save_btn" class="btn btn-success">Save</button> -->
        <button id="add_btn3" class="btn btn-danger">Add Cash Stamp</button>
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
                                        <button class="btn btn-info btn-sm disable" id="btn_save">Save Information</button>
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
   $(document).ready(function() {
    var x = 0;
    $('#save_btn').hide();
  
    $('#add_btn3').click(function(e) {
    e.preventDefault();
     $('#btn_save').prop('disabled', false); 
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
    

  
  function appendRow() {
    $('#input_wrapper3').append(
        // '<label><span id="results" style=""> </span> Outstanding Balance</label>'+
        // '<br />'+
        '<div id="'+x+'" class="form-group" style="display:flex;">' +
          '<div>' +

            '<input type="text" id="'+x+'" class="form-control col-md-11"" name="fn" placeholder="Stamp Type"/>' +
          '</div>' +
          '<div>'+
          '<input type="Number" id="'+x+'" class="form-control col-md-11" name="ln"                                         placeholder="Unit Price"/>'+
          '</div>' +
          // '<div>'+
          '<div>'+
          '<input type="Number" id="'+x+'" class="form-control col-md-11" name="lq"                                         placeholder="Quantity"/>'+
          '</div>' +
          '<div>'+
          '<input type="Number" id="'+x+'" class="form-control col-md-11 Total" name="lt"  placeholder="Total"/>'+
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



<script type="text/javascript">
   

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

        obj1.type = formData1.fn[i];
        obj1.unit = formData1.ln[i];
        obj1.quantity = formData1.lq[i];
        obj1.total = formData1.lt[i];

        years1=years1 + ","+ formData1.fn[i]+" unit price "  + formData1.ln[i]+" Quantity "  + formData1.lq[i];
        Totalpaymentsamount =Totalpaymentsamount + +(formData1.ln[i] * formData1.lq[i] ); 
        Totalpaymentsvalue=10;
         payments.push(obj1);

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
     obj1.type = formData1.fn;
        obj1.unit = formData1.ln;
        obj1.quantity = formData1.lq;
        obj1.total = formData1.lt;
         payments.push(obj1);
     
        years1=years1 + ","+ formData1.fn+" unit price "  + formData1.ln+" Quantity "  + formData1.lq;
        Totalpaymentsamount =Totalpaymentsamount +  +(formData1.ln * formData1.lq ); 
        Totalpaymentsvalue=0;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
        //console.log('years ', years);
       //  console.log('TotalOutstandingamount ', TotalOutstandingamount);
       console.log(obj1); 

            var paymentsArray   = payments;
            var Totalpaymentsamounts   = Totalpaymentsamount;
             var Totalpaymentsvalues   = Totalpaymentsvalue;
            var paymentsDesc = years1;

            
            var name     = $('#name').val();
            var invoice     = $('#invoice').val();
            if(invoice == ''){
            $('#errinvoice').html('Please Input Invoice Number');
             $('#errname').hide();
            $('.disable').attr("disabled", false);
            }else if(name == ''){
            $('#errname').html('Please Input Customer Name');
             $('#errinvoice').hide();
            $('.disable').attr("disabled", false);
            }else{

                //$('#majibu').html("<img src='assets/images/users/'>");

            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Stamp/Register_Bulk_cash_stamp_Action')?>",
                dataType : "JSON",
                data : {name:name,invoice:invoice,Totalpaymentsamounts:Totalpaymentsamounts,paymentsDesc:paymentsDesc,Totalpaymentsvalues:Totalpaymentsvalues,paymentsArray:JSON.stringify(paymentsArray) },
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
                      $('#input_wrapper3').html('');
                       $('#result').html(data.responseText);
                         window.location.href = "<?php echo base_url() ?>Stamp/bulk_Stamp_cash_form";
                      
                       //$('#loader').addClass('hidden');

                },
                 error: function (e) {
                 $('.result').html(e.responseText);
                   $('#btn_save').removeClass('button_loader').attr("value","\u2713");
                      $('#btn_save').prop('disabled', true);
                      //console.log(e);
                       window.location.href = "<?php echo base_url() ?>Stamp/bulk_Stamp_cash_form";
                 }
            });
            return false;
        }
        });


</script>

<?php $this->load->view('backend/footer'); ?>

