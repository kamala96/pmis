<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>  Sales Transaction </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Sales</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
              <div class="col-12">


                    <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo site_url('PostaStamp/dashboard');?>" class="text-white"><i class="" aria-hidden="true"></i> Dashboard  </a></button>

                    <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo site_url('PostaStamp//salestamp');?>" class="text-white"><i class="" aria-hidden="true"></i> Sales (POS)  </a></button>

                    <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo site_url('PostaStamp/generate_sales_transaction_control_number');?>" class="text-white"><i class="" aria-hidden="true"></i> Generate Control Number  </a></button>

                    <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo site_url('PostaStamp/payment_transaction');?>" class="text-white"><i class="" aria-hidden="true"></i> Payment Transactions </a></button>

                </div>
        </div>

            <div class="row">
              <div class="col-md-12">

              </div>
            </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Sales Transaction List
                        </h4>
                    </div>
                    <div class="card-body" >
                      <div class="col-md-12">
                        
                      </div>

                          <?php 
                            if(!empty($this->session->flashdata('feedback'))){
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
                                      <?php echo $this->session->flashdata('feedback'); ?>
                                      <?php
                            echo "</div>";
                            
                            }
                            ?>

                            <?php if($this->session->flashdata('success')){ ?> 
                           <div class='alert alert-success alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong> <?php echo $this->session->flashdata('success'); ?>  </strong> 
                           </div>                         
                          <?php } ?>

                        <form class="row" method="post" action="<?php echo site_url('PostaStamp/find_sale_transaction'); ?>">
                                
                                    <div class="form-group col-md-4 m-t-10">
                                    <input type="text" name="fromdate" class="form-control mydatetimepickerFull"  required="required" placeholder="From Date">
                                    </div>
                                    
                                    <div class="form-group col-md-4 m-t-10">
                                         <input type="text" name="todate" class="form-control mydatetimepickerFull" required="required" placeholder="To Date">
                                    </div>
                                    
                                    <div class="form-group col-md-4 m-t-10">
                                         <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> Search </button>
                                    </div>
                        </form>



                        <?php if(isset($list)){ ?>
                        <div class="table table-responsive">
                           <table class="table table-bordered International text-nowrap" width="100%" style="text-transform: capitalize;">
                               <thead>
                                    <th>S/N </th>
                                   <th> Customer </th>
                                   <th> Phone  </th>
                                   <th> Address </th>
                                   <th> Receipt </th>
                                   <th> Total Items </th>
                                   <th> Total Amount </th>
                                   <th> Transaction Date </th>
                               </thead>
                               <tbody>
                                   <?php $sn=1; foreach ($list as $value) { 
                                   $listitems = $this->PostaStampModel->get_selling_transaction_items($value->receipt);
                                    ?>
                                       <tr>
                                           <td><?php echo $sn; ?></td>
                                           <td><?php echo $value->customer; ?></td>
                                           <td><?php echo $value->phone; ?></td>
                                           <td><?php echo $value->address; ?></td>
                                           <td>
                                            <a data-toggle="modal" data-target="#update_modal<?php echo $value->receipt; ?>">
                                            <?php echo $value->receipt; ?></td>
                                            </a>
                                           <td>
                                             <a data-toggle="modal" data-target="#update_modal<?php echo $value->receipt; ?>">
                                            <?php echo number_format($value->totalitems); ?> 
                                             <i class="fa fa-eye"></i>
                                             </a>
                                            </td>
                                           <td><?php echo number_format($value->total,2); ?></td>
                                           <td><?php echo $value->transaction_created_at; ?></td>
                                           
                                       </tr>
                                   <?php $sn++;  ?>


                                    <!-- Edit -->
                        <div class="modal fade" id="update_modal<?php echo $value->receipt; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Sales Items   </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>             
                    <div class="modal-body"> 

                    <div class="row">
                    <div class="col-md-2"> <strong> S/N </strong> </div> 
                    <div class="col-md-3"> <strong> Item </strong> </div>  
                    <div class="col-md-2"> <strong> Quantity </strong> </div> 
                    <div class="col-md-2"> <strong> Price </strong> </div>
                    <div class="col-md-3"> <strong> Total </strong> </div> 
                    </div>
                     <hr>
                    <?php $serial=1; foreach($listitems as $row){ ?>
                     <div class="row">
                     <div class="col-md-2">
                    <?php echo $serial; ?>
                    </div>
                    <div class="col-md-3">
                    <?php echo @$row->product_name; ?>
                    </div>
                     <div class="col-md-2">
                    <?php echo number_format($row->sale_qty); ?>
                    </div>
                    <div class="col-md-2">
                    <?php echo number_format($row->sale_price); ?>
                    </div>
                    <div class="col-md-3">
                    <?php echo number_format($row->sale_price*$row->sale_qty); ?>
                    </div>
                    </div>
                     <hr>
                <?php $serial++; } ?>
                
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
