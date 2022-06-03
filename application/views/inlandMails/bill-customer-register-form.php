<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Bill Customer Registration</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Bill Customer Registration</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                     
                    <?php if($this->session->userdata('user_type') == "EMPLOYEE"){ ?>
                         <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list?AskFor=<?php echo @$askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Bill Transactions Lists List</a></button>
                          <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Box_Application/Ems_Application_bill_List?AskFor=<?php echo @$askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Bill Item Transactions List</a></button>
                    <?php }if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "ACCOUNTANT"){ ?>

                       <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_form?AskFor=<?php echo @$askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Add Bill Customer</a></button>
                       <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list?AskFor=<?php echo @$askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Bill Customer List</a></button>
                       <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_transactions_list?AskFor=<?php echo @$askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Bill Transactions List</a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Box_Application/Ems_Application_bill_List?AskFor=<?php echo @$askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Bill Item Transactions List</a></button>

                   <?php } ?>
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">  
                        Bill Customer Registration Form                 
                        </h4>
                    </div>
                              
                         <div class="card-body">
                            <?php if(!empty($this ->session->flashdata('message'))){ ?>
                          <div class="alert alert-success alert-dismissible">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <strong> <?php echo $this ->session->userdata('message'); ?></strong> 
                        </div>
                <?php }else{?>
                  
                <?php }?>
            <form method="post" action="Customer_Register?AskFor=<?php echo @$askfor;?>">
                            
                                <div class="row">
                                 <div class="form-group col-md-4">
                                    <input type="hidden" class="acc" name="accno" value="<?php echo @$edit->acc_no; ?>">
                                <label>Services Type:</label>
                                   <select class="form-control custom-select" name="service_type" required="">
                                    <option><?php echo @$edit->services_type; ?></option>
                                    <option value="">--Select Service Type--</option>
                                       <option>EMS Postage</option>
                                       <option>MAILS</option>
                                       <!-- <option>BULK POSTING</option> -->
                                   </select>
                                </div>
                                <div class="form-group col-md-4">
                                <label>Payment Type:</label>
                                   <select class="form-control custom-select" name="payment_type" required="">
                                   <?php if(@$edit->customer_type =="PrePaid"){  ?>
                                    <option><?php echo @$edit->customer_type; ?></option>
                                    
                                    <?php }else{ ?>
                                        <option><?php echo @$edit->customer_type; ?></option>
                                    <option value="">--Select Payment Type--</option>
                                       <option>PrePaid</option>
                                       <option>PostPaid</option>
                                        <?php } ?>
                                   
                                   
                                   </select>
                                </div>
                                <div class="form-group col-md-4">
                                <label>Customer Name:</label>
                                    <input type="text" name="cust_name" class="form-control" required="required" value="<?php echo @$edit->customer_name; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                <label>Customer Address:</label>
                            <input type="text" name="cust_address" class="form-control" required="required" value="<?php echo @$edit->customer_address; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                <label>Phone Number[ Mobile Number ]:</label>
                                    <input type="text" name="cust_mobile" class="form-control" required="required" value="<?php echo @$edit->cust_mobile; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                <label>[ Tin Number ]:</label>
                                    <input type="text" name="tin_number" class="form-control" required="required" value="<?php echo @$edit->tin_number; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                <label>[ Vrn ]:</label>
                                    <input type="text" name="vrn" class="form-control" required="required" value="<?php echo @$edit->vrn; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                <?php if(@$edit->customer_type =="PrePaid"){  ?>
                                    <label>Price:</label>
                                    <input type="text" name="price" class="form-control"  value="<?php echo @$edit->price; ?>" readonly>
                                    <input type="hidden" name="crdtid" value="<?php echo @$edit->credit_id; ?>">
                                    <?php }else{ ?>
                                        <label>Price:</label>

                                        <input type="text" name="price" class="form-control" required="required" value="<?php echo @$edit->price; ?>">
                                        <input type="hidden" name="crdtid" value="<?php echo @$edit->credit_id; ?>">
                                        <?php } ?>
                                </div>
                                <div class="form-group col-md-4">
                                <label>Region:</label>
                                    <select class="form-control custom-select" onChange="GetBranch();" id="regiono" name="">
                                        <option>--Select Region--</option>
                                        <?php foreach ($regionlist as $value) { ?>
                                        <option><?php echo $value->region_name; ?></option>
                                        <?php } ?>
                                    </select>
                                 </div>
                               <div class="col-md-12 card-header">
                                   <h3>Regions And Branch To Provide Srvices</h3>
                               </div>

                                 <div class="form-group col-md-12 branchdropo" style="display: none; text-transform: uppercase;">
                                
                                </div>
                                <div class="form-group col-md-12 dar" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 mtw" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 tan" style="display: none;">
                                
                                </div>
                                <br><br>
                                <div class="form-group col-md-12 tab" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 mwa" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 dod" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 sin" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 ruk" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 kil" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 mzi" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 moro" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 lin" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 mbe" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 pwa" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 sim" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 man" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 gei" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 kat" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 zan" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 ruv" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 song" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 kig" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 iri" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 son" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 mar" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 shi" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 kag" style="display: none;">
                                
                                </div>
                                
                                </div>
                                <br><br>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-info"> Save Information</button>
                                    </div>
                                </div>
                               
                        </form>
                        </div>
                        
                   </div>
                    </div>

                </div>
            </div>
            </div>

 <script type="text/javascript">
    function GetBranch() {
    var region_id = $('#regiono').val();
    var accno = $('.acc').val();

    //console.log(region_id)
    //console.log(accno)
    
    
      $.ajax({
     
      url: "<?php echo base_url();?>Employee/GetBranch1",
      method:"POST",
      data:{region_id:region_id,accno:accno},//'region_id='+ val,
      success: function(data){

        // console.log(data)

        if (region_id == "Arusha") {
            $(".branchdropo").show();
            $(".branchdropo").html(data);
        }else if(region_id == "Dar es Salaam"){
            $(".dar").show();
            $(".dar").html(data);
        }else if(region_id == "Mtwara"){
            $(".mtw").show();
            $(".mtw").html(data);
        }else if(region_id == "Tanga"){
            $(".tan").show();
            $(".tan").html(data);
        }else if(region_id == "Tabora"){
            $(".tab").show();
            $(".tab").html(data);
        }else if(region_id == "Mwanza"){
            $(".mwa").show();
            $(".mwa").html(data);
        }else if(region_id == "Dodoma"){
            $(".dod").show();
            $(".dod").html(data);
        }else if(region_id == "Singida"){
            $(".sin").show();
            $(".sin").html(data);
        }else if(region_id == "Rukwa"){
            $(".ruk").show();
            $(".ruk").html(data);
        }else if(region_id == "Kilimanjaro"){
            $(".kil").show();
            $(".kil").html(data);
        }else if(region_id == "Mzizima"){
            $(".mzi").show();
            $(".mzi").html(data);
        }else if(region_id == "Lindi"){
            $(".lin").show();
            $(".lin").html(data);
        }else if(region_id == "Mbeya"){
            $(".mbe").show();
            $(".mbe").html(data);
        }else if(region_id == "Morogoro"){
            $(".moro").show();
            $(".moro").html(data);
        }else if(region_id == "Shinyanga"){
            $(".shi").show();
            $(".shi").html(data);
        }else if(region_id == "Kagera"){
            $(".kag").show();
            $(".kag").html(data);
            $('.reg').val(region_id);
        }else if(region_id == "Mara"){
            $(".mar").show();
            $(".mar").html(data);
        }else if(region_id == "Songea"){
            $(".son").show();
            $(".son").html(data);
        }else if(region_id == "Iringa"){
            $(".iri").show();
            $(".iri").html(data);
        }else if(region_id == "Kigoma"){
            $(".kig").show();
            $(".kig").html(data);
        }else if(region_id == "Zanzibar"){
            $(".zan").show();
            $(".zan").html(data);
        }else if(region_id == "Ruvuma"){
            $(".ruv").show();
            $(".ruv").html(data);
        }else if(region_id == "Songwe"){
            $(".song").show();
            $(".song").html(data);
        }else if(region_id == "Katavi"){
            $(".kat").show();
            $(".kat").html(data);
        }else if(region_id == "Geita"){
            $(".gei").show();
            $(".gei").html(data);
        }else if(region_id == "Manyara"){
            $(".man").show();
            $(".man").html(data);
        }else if(region_id == "Pwani"){
            $(".dar").show();
            $(".dar").html(data);
        }else if(region_id == "Simiyu"){
            $(".sim").show();
            $(".sim").html(data);
        }else if(region_id == "Pwani"){
            $(".pwa").show();
            $(".pwa").html(data);
        }
        

      }
  });
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
<script>
$(document).ready(function() {

    $('.cnumber').on('click', function(event) {
        $('.cnumber').attr("disabled", true);
    event.preventDefault();
    

    var acc_no    = $(this).attr('data-accno');
    var total     = $(this).attr('data-total');

      $.ajax({
                 type: 'POST',
                 url: 'Generate_Control_Number2',
                 data:'acc_no='+ acc_no + '&total='+ total,
                 success: function(response) {
                        // $('.resultr').html(response);
                        //alert(response);
                        $('.cn').html(response);
                        $("#myModal").modal();

            }
        });
   });
});
</script>
<!-- <script type="text/javascript">
$('form').each(function() {
    $(this).validate({
    submitHandler: function(form) {
        var formval = form;
        var url = $(form).attr('action');

        // Create an FormData object
        var data = new FormData(formval);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            // url: "crud/Add_userInfo",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                console.log(response);            
                $(".message").fadeIn('fast').delay(1800).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},1800);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});

    </script> -->
<?php $this->load->view('backend/footer'); ?>

