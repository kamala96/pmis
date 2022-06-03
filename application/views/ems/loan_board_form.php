<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Ems Loans Board Form</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Ems Loans Board Form</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Loan_Board/Loan_info" class="text-white"><i class="" aria-hidden="true"></i> Heslb Transactions</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Loan_Board/loan_board_transactions_list" class="text-white"><i class="" aria-hidden="true"></i> Heslb Transanctions List</a></button>
                    
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Ems Loans Board Form
                        </h4>
                    </div>
                    <div class="card-body">
                            <form method="POST" action="<?php echo base_url()?>Loan_Board/Save_Heslb_Info">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="r_name" value="HESLB">
                                        <input type="hidden" name="r_region" value="Dar es Salaam">
                                        <input type="hidden" name="r_address" value="P.O.BOX 7608">
                                        <input type="hidden" name="r_zipcode" value="15471">
                                        <input type="hidden" name="r_phone" value="0225507910">
                                        <input type="hidden" name="r_email" value="info@heslb.go.tz">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Sender Full Name</label>
                                        <input type="text" name="s_fullname" class="form-control" required="required">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Sender Address</label>
                                        <input type="text" name="s_address" class="form-control" required="required">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Sender Mobile</label>
                                        <input type="text" name="s_mobile" class="form-control" required="required">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Weight Step</label>
                                        <input type="text" name="Weight" class="form-control price" onkeyup="myFunction()" required="required">
                                        <span style="color: red" class="priceerror"></span>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-info submit">Save Information</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>

<script>
function myFunction() {

 var price = $('.price').val().replace(/[^\d.-]/g, '');
 //var s = price.replace(/[^\d.-]/g, '');

   if(price > 0.5){

     $('.priceerror').html('Weight Maximum Limit is 0.5kg');
     $('.submit').attr("disabled", true);

   }else{
      $('.priceerror').html('');
      $('.price').val(price);
      $('.submit').attr("disabled", false);
   }

 
}
 
</script>
<script type="text/javascript">
    $('.submit').on('click',function(){
            $('.submit').attr("disabled", true);
        })
</script>
<?php $this->load->view('backend/footer'); ?>
