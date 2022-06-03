<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Receive Money </h3>
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
                    
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Posta_Cash/receive_money" class="text-white"><i class="" aria-hidden="true"></i> Receive Money  </a></button>

                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Posta_Cash/postacash_list" class="text-white"><i class="" aria-hidden="true"></i> Posta Cash Transaction </a></button>
                      <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Posta_Cash/postacash_dashboard" class="text-white"><i class="" aria-hidden="true"></i> Posta Cash Menu  </a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Receive Money with Posta Cash 
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

                           <form method="POST" action="<?php echo base_url('Posta_Cash/search_pin');?>">
                             
                                <div class="row">

                                <div class="col-md-8">
                                <input type="text" name="pin" class="form-control" placeholder="Enter PIN" required>
                                </div> 

                                <div class="col-md-4">
                                <button type="submit" class="btn btn-info disable"> Search </button>
                                </div>

                                </div>
                        
                           </form>
                        
                        <br><br>
                         
                         <?php if(isset($listtrans)){?>
                           
                          <div class="table table-responsive">
                           <table class="table table-bordered International text-nowrap" width="100%" style="text-transform: capitalize;">
                               <thead>
                                 <th>Transaction Code</th>
                                 <th>PIN </th>
                                   <th>Sender name</th>
                                   <th>Sender phone </th>
                                   <th>Receiver name</th>
                                   <th>Receiver region</th>
                                   <th>Receiver branch</th>
                                   <th>Amount</th>
                                   <th>Fee</th>
                                   <th>Taken Amount </th>
                                   <th>Transaction Date </th>
                                   <th>Status</th>
                                   <th> Action </th>
                                   
                                  
                               </thead>
                               <tbody>
                                   <?php foreach ($listtrans as $value) { 
                                    $status = $value->sendmoney_status;
                                    ?>
                                       <tr>
                                           <td><?php echo strtoupper($value->transactioncode); ?></td>
                                           <td><?php echo strtoupper($value->pin); ?></td>
                                           <td><?php echo $value->sender_name; ?></td>
                                           <td><?php echo $value->sender_phone; ?></td>
                                           <td><?php echo $value->receiver_name; ?></td>
                                           <td><?php echo $value->receiver_region; ?></td>
                                           <td><?php echo $value->receiver_branch; ?></td>
                                           <td><?php echo number_format($value->amount,2).' '.$value->currency; ?></td>
                                           <td><?php echo number_format($value->posta_commission,2).' '.$value->currency; ?> </td>
                                           <td><?php echo number_format($value->r_amount,2).' '.$value->currency; ?> </td>
                                           <td><?php echo $value->sendmoney_created_at; ?></td>
                                           <td>  
                                           <?php if($status=='Received'){?>  
                                            <button class="btn btn-info btn-sm"> Received </button>  
                                            <button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#receiver_modal<?php echo $value->sendmoney_id; ?>">  <i class="fa fa-eye"> </i> </button>
                                             <?php } else { ?>
                                            <button class="btn btn-info btn-sm"> <?php  echo $value->sendmoney_status; ?> </button>  
                                           <?php } ?>
                                           </td> 
                                           <td>

                                            <?php if($status=='Not Received'){?> 
                                           <button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#update_modal<?php echo $value->sendmoney_id; ?>">  <i class="fa fa-pencil-square-o"> </i> </button>
                                           <?php } ?>
                                           </td>
                                       </tr>


                                       <!-- Receiver Information -->
                        <div class="modal fade" id="update_modal<?php echo $value->sendmoney_id; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Receiver Information  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                                        
                    <div class="modal-body"> 
            
                    <form class="form-horizontal m-t-20" method="post" action="<?php echo base_url('Posta_Cash/save_receivemoney');?>">
                    
                    <input type="hidden" class="form-control"  name="sendmoneyid" value="<?php echo $value->sendmoney_id; ?>">

                   <div class="form-group row">
                    <div class="col-12">
                    <label>Identity Card</label>
                     <select name="identitycard" value="" class="form-control" required>
                      <option value="National ID">National ID</option>
                      <option value="Vote ID">Vote ID</option>
                      <option value="Employee ID">Employee ID</option>
                      <option value="Licence ID">Licence ID</option>
                       <option value="Other">Other</option>
                    </select>
                   </div>
                  </div>
 
                    <div class="form-group row">
                    <div class="col-12">
                    <label>Identity Number</label>
                     <input type="text" class="form-control"  name="identitynumber" required>
                   </div>
                   </div>
                     
                    <div class="form-group row">
                    <div class="col-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Submit </button>
                    </div>
                    </div>
                            
                     </form>
                      
                        </div>
                       </div>
                       </div>
                    </div>
                 <!-- End -->

                  <!-- Receiver Information -->
                        <div class="modal fade" id="receiver_modal<?php echo $value->sendmoney_id; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Receiver Information  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                                        
                    <div class="modal-body"> 
            
                    Name: <?php echo $value->receiver_name; ?>

                    <hr>

                    Identity Card: <?php echo $value->identitycard; ?>

                    <hr>

                    Identity Number: <?php echo $value->identitynumber; ?>

                    <hr>

                    Received Date: <?php echo $value->received_created_at; ?>
                      
                        </div>
                       </div>
                       </div>
                    </div>
                 <!-- End -->


                                   <?php } ?>
                                   
                               </tbody>
                           </table>
                           </div>
                   <?php } ?>

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
                //fee
                var fee = basicamount*10/100;
                //remaining amount
                var ramount = basicamount-fee;
                $('[name="commission"]').val(fee);
                $('[name="r_amount"]').val(ramount);
            });
            
        });
        
        </script>





<?php $this->load->view('backend/footer'); ?>
