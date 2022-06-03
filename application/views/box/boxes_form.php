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
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Bulk Boxes Application</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Add Boxes Application</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php //$regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Bulkboxes" class="text-white"><i class="" aria-hidden="true"></i>Add Bulk Boxes</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Bulk_List" class="text-white"><i class="" aria-hidden="true"></i> Bulk Transaction List</a></button>
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Add Boxes Application                       
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                            <div id="div1" style="display: block;"> 
                                <div class="row">
                                
                                <div class="col-md-12"><?php //echo json_encode($customer); ?>

                                    <h3>CUSTOMER: <?php echo $customer->Cust_Name; ?>   MOBILE:<?php echo $customer->Customer_mobile; ?> </h3>
                                </div>
                               
                                <br />

<div id="test_form5" style="display: block;">
  <form id="test_form4" >
      <div class="col-sm-12 col-md-12 col-lg-12">
        <br />
        <div id="input_wrapper3"></div>
        <!-- <button id="save_btn" class="btn btn-success">Save</button> -->

        <!-- <a href="#" class="btn btn-danger" id="add_btn3" >Add Boxes</a> -->
        <button id="add_btn3" class="btn btn-danger">Add Boxes</button>
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
                                <div class="row">
                                    <input type="hidden" name="Customerserial" id="Customerserial" class="form-control" value="<?php echo $customer->serial; ?>">
                                    <div class="col-md-6">
                                        
                                        <button class="btn btn-info btn-sm"  id="btn_save">Save Information</button>
                                    </div>
                                </div>
                                </div>


                              

                                <div id="div4" style="display: none;"> 
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Saved Successfully</h3>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12" id="majibu">
                                    <span id="majibu"> Successfully</span>
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
    //$('#save_btn').hide();
  
    $('#add_btn3').click(function(e) {
    e.preventDefault();
    appendRow(); // appen dnew element to form 
    x++; // increment counter for form
    //$('#save_btn').show(); // show save button for form
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
   // var arr[]; //obj can be use to send to ajax call
    var obj;
    
      var Boxnumbers   ='';
     var TotalOutstandingamount = 0;
    if(Array.isArray(formData.fn)) {
        for(var i = 0; i < formData.fn.length; i++) {
        obj = {};
        // set the obj for submittion
        obj.Boxnumber = formData.fn[i];
        obj.Boxname = formData.bn[i];
        obj.Amount = formData.ln[i];

        Boxnumbers=' '+ formData.fn[i]+' Balance'.formData.ln[i]+'';
        TotalOutstandingamount =TotalOutstandingamount + +formData.ln[i]  ; 
         //arr.insert(obj)
        // This object could be push into an array
        //console.log('object from form array ', TotalOutstandingamount);
      };
    } else {
        obj = {};
      obj.Boxnumber = formData.fn;
      obj.Amount = formData.ln;
      obj.Boxname = formData.bn;
       //arr.insert(obj)
      //years=' '.formData.fn.' Balance'.formData.ln.'';
       // TotalOutstandingamount =TotalOutstandingamount +  parseInt(formData.ln); 
      console.log('single obj from form ', obj);
       //console.log('object from form array ', TotalOutstandingamount);
    }

       console.log('object from form array ', arr);s
  });

  function appendRow() {
    $('#input_wrapper3').append(
        // '<label><span id="results" style=""> </span> Outstanding Balance</label>'+
        // '<br />'+
        '<div id="'+x+'" class="form-group" style="display:flex;">' +
        '<div class="col-md-4">' +
          '<input type="text" id="'+x+'" class="form-control " name="bn"  placeholder="Add Branch Name"/>'+
         


            // '<input type="text" id="'+x+'" class="form-control" name="fn"                                   placeholder="Select Year"/>' +
          '</div>' +
          '<div class="col-md-4">' +
          '<input type="text" id="'+x+'" class="form-control " name="fn"                                         placeholder="Box Number"/>'+
         


            // '<input type="text" id="'+x+'" class="form-control" name="fn"                                   placeholder="Select Year"/>' +
          '</div>' +
          '<div class="col-md-4">'+
          '<input type="text" id="'+x+'" class="form-control" name="ln"                                         placeholder="Amount"/>'+
          '</div>' +
          '<div class="col-md-4">'+
            '<button id="'+x+'" class="btn btn-danger deleteBtn3"><i class="glyphicon glyphicon-trash"></i> Remove</button>' +
          '</div>' +
        '</div>');
  };
  


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

});

</script>

<script type="text/javascript">

  $(document).ready(function() {

//save data to databse
$('#btn_save').on('click',function(){

 
    
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
        obj1.Boxnumber = formData1.fn[i];
        obj1.Boxname = formData1.bn[i];
        obj1.amount = formData1.ln[i];

        years1=years1 + ","+ formData1.fn[i]+" Balance "  + formData1.ln[i];
        Totalpaymentsamount =Totalpaymentsamount + +formData1.ln[i]  ; 
        Totalpaymentsvalue=10;
         payments.push(obj1);

      //console.log('single obj from  ', myArray);
      };
    }  else if(formData1.fn == null || formData1.fn == '')
    {
      years1='';
        Totalpaymentsamount =0;
        Totalpaymentsvalue =10;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
    else {

        obj = {};
      obj.Boxnumber = formData1.fn;
        obj.Boxname = formData1.bn;
      obj.Amount = formData1.ln;
         payments.push(obj);
      years1=""+ formData1.fn+" Balance "  + formData1.ln;
        Totalpaymentsamount =Totalpaymentsamount +  +formData1.ln; 
        Totalpaymentsvalue=0;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
        //console.log('years ', years);
       //  console.log('TotalOutstandingamount ', TotalOutstandingamount);
       // console.log('object from form array ', myArray);
    
            

            var paymentsArray   = payments;
            var Totalpaymentsamounts   = Totalpaymentsamount;
             var Totalpaymentsvalues   = Totalpaymentsvalue;
            var paymentsDesc = years1;

            var Customerserial   = $('#Customerserial').val();
           
                //$('#majibu').html("<img src='assets/images/users/'>");

            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Box_Application/Register_Bulk_Action')?>",
                dataType : "JSON",
                data : {Customerserial:Customerserial,Totalpaymentsamounts:Totalpaymentsamounts,paymentsDesc:paymentsDesc,Totalpaymentsvalues:Totalpaymentsvalues,paymentsArray:JSON.stringify(paymentsArray) },
                beforeSend: function() {
                      $("#btn_save").addClass('button_loader').attr("value",""); 
                    
                 },
                  complete: function(data) {

                     //var obj = jQuery.parseJSON(data);
                     alert(data.responseText); 
                     //alert(data.statuss);
                      $('#btn_save').removeClass('button_loader').attr("value","\u2713");
                      $('#btn_save').prop('disabled', true);

                    //$('#div4').show();
                    $('#div1').hide();
                    //$('#majibu').html(data);
                    //window.location.href="<?php echo base_url();?>Box_Application/Bulk_List";

                    
                  }
                // success: function(data){
                //      alert("Success?");
                //       $('#btn_save').removeClass('button_loader').attr("value","\u2713");
                //       $('#btn_save').prop('disabled', true);

                //     $('#div4').show();
                //     $('#div1').hide();
                //     $('#majibu').html(data);
                // }
            });
            return false;
        });
});


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

<?php $this->load->view('backend/footer'); ?>

