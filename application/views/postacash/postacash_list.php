<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>  Posta Cash Transaction List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Posta Cash</li>
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
              <div class="col-md-12">
                <?php if(!empty($this ->session->flashdata('message'))){ ?>
                  <div class="alert alert-success alert-dismissible">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong> <?php echo $this ->session->userdata('message'); ?></strong> 
                </div>
                <?php }else{?>
                  
                <?php }?>
                
               
              </div>
            </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Posta Cash  Transaction List
                        </h4>
                    </div>
                    <div class="card-body" >
                      <div class="col-md-12">
                        
                      </div>

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
                                             <?php } else { ?>
                                            <button class="btn btn-info btn-sm"> <?php  echo $value->sendmoney_status; ?> </button>  
                                           <?php } ?>
                                           </td> 
                                       </tr>
                                   <?php } ?>
                                   
                               </tbody>
                           </table>
                           </div>
                        
                        </div>
                    </div>

                </div>

            </div>
        </div>

<script type="text/javascript">
$(document).ready(function() {

var table = $('.International').DataTable( {
    order: [[1,"desc" ]],
    //orderCellsTop: true,
    fixedHeader: true,
    ordering:false,
    lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    dom: 'lBfrtip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ]
} );
} );
</script>


<?php $this->load->view('backend/footer'); ?>
