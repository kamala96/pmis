<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Send Money </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Posta Cash </li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                    
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Posta_Cash/send_money" class="text-white"><i class="" aria-hidden="true"></i> Send Money  </a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Posta_Cash/postacash_list" class="text-white"><i class="" aria-hidden="true"></i> Posta Cash Transaction </a></button>
                      <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Posta_Cash/postacash_dashboard" class="text-white"><i class="" aria-hidden="true"></i> Posta Cash Menu  </a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Send Money Form
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">


                           <?php if($this->session->flashdata('success')){ ?> 
                           <div class='alert alert-success alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong> <?php echo $this->session->flashdata('success'); ?>  </strong> 
                           </div>                         
                          <?php } ?>
                          
                          <?php if($this->session->flashdata('feedback')){ ?> 
                           <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong>  <?php echo $this->session->flashdata('feedback'); ?>  </strong> 
                           </div>                         
                          <?php } ?>

                           <form method="POST" action="<?php echo base_url('Posta_Cash/save_sendmoney');?>">
                             
                            <input type="hidden" name="currency" class="form-control" value="TZS">

                                <div class="row">

                                <div class="col-md-4">
                                <label> Sender Name: </label>
                                <input type="text" name="sender_name" class="form-control" required>
                                <span id="" style="color: red;"></span>
                                </div> 

                                <div class="col-md-4">
                                <label> Sender Phone Number: </label>
                                <input type="text" name="sender_phone" class="form-control" required>
                                <span id="" style="color: red;"></span>
                                </div>

                                <div class="col-md-4">
                                <label> Receiver Name: </label>
                                <input type="text" name="receiver_name" class="form-control" required>
                                <span id="" style="color: red;"></span>
                                </div>

                                <div class="col-md-4">
                                <label> Receiver Region: </label>
                                <select name="region" value="" class="form-control" required id="regiono" onChange="getDistrict();">
                                            <option value=""> Region </option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                </select>
                                </div>

                                <div class="col-md-4">
                                <label> Receiver Branch: </label>
                                <select name="branch" value="" class="form-control"  id="branchdropo">  
                                 <option> Branch </option>
                                </select>
                                </div>

                                <div class="col-md-4">
                                <label>Amount:</label>
                                 <input type="Number" name="amount" class="form-control amount" id="amount" required>
                                </div>

                                 <div class="col-md-4">
                                <label><b style="color:red;"> Posta Cash Tariff (rate):</b></label>
                                 <input type="Number" name="commission" style="color: #000;font-weight: bold;" class="form-control" placeholder="Auto Generated" readonly>
                                </div>

                                 <div class="col-md-4">
                                <label><b style="color:red;">Receiver Amount:</b></label>
                                 <input type="Number" name="r_amount" style="color: #000;font-weight: bold;" class="form-control" placeholder="Auto Generated" readonly>
                                </div>


                                </div>
                                <br>
                               

                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-info disable">Save Information</button>
                                    </div>
                                </div>
                                </div>
                           </form>
                            </div>
                           </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>


<script type="text/javascript">
    function getDistrict() {
    var region_id = $('#regiono').val();
     $.ajax({
     
     url: "<?php echo base_url();?>Employee/GetBranch",
     method:"POST",
     data:{region_id:region_id},//'region_id='+ val,
     success: function(data){
         $("#branchdropo").html(data);

     }
 });
};
</script>

<script>
        $(document).ready(function(){
            
            $(document).on('change','#amount',function(){
                var basicamount = $('#amount').val();

                if($('#amount').val() <= 50000){
                 var fee = 2000;
                 var ramount = basicamount-fee;
                 $('[name="commission"]').val(fee);
                 $('[name="r_amount"]').val(ramount);
                }
                else if($('#amount').val() <= 100000){
                 var fee = 3000;
                 var ramount = basicamount-fee;
                 $('[name="commission"]').val(fee);
                 $('[name="r_amount"]').val(ramount);
                }
                else if($('#amount').val() <= 200000){
                 var fee = 4000;
                 var ramount = basicamount-fee;
                 $('[name="commission"]').val(fee);
                 $('[name="r_amount"]').val(ramount);
                }
                else if($('#amount').val() <= 500000){
                 var fee = 5000;
                 var ramount = basicamount-fee;
                 $('[name="commission"]').val(fee);
                 $('[name="r_amount"]').val(ramount);
                }
                else
                {
                var fee = basicamount*2/100;
                var ramount = basicamount-fee;
                $('[name="commission"]').val(fee);
                $('[name="r_amount"]').val(ramount);
                } 
            });
            
        });
        
        </script>





<?php $this->load->view('backend/footer'); ?>
