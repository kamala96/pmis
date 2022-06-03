<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>  Payment Transaction </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Payment</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
              <div class="col-12">


                    <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo site_url('PostaStamp/dashboard');?>" class="text-white"><i class="" aria-hidden="true"></i> Dashboard  </a></button>

                    <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo site_url('PostaStamp//salestamp');?>" class="text-white"><i class="" aria-hidden="true"></i> Sales (POS)  </a></button>

                    <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo site_url('PostaStamp/sales_transaction');?>" class="text-white"><i class="" aria-hidden="true"></i> Sales transaction  </a></button>

                    <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo site_url('PostaStamp/generate_sales_transaction_control_number');?>" class="text-white"><i class="" aria-hidden="true"></i> Generate Control Number  </a></button>

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
                        <h4 class="m-b-0 text-white"> Payment Transaction List
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

                        <form class="row" method="post" action="<?php echo site_url('PostaStamp/find_payment_transaction'); ?>">
                                
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
                                   <th>Operator</th>
                                   <th>Stamp Details</th>
                                   <th>Region</th>
                                   <th>Branch</th>
                                   <th>Amount</th>
                                   <th>Control Number</th>
                                   <th>Channel</th>
                                   <th>Pay Date</th>
                                   <th>Payment Status</th>
                                   
                                  
                               </thead>
                               <tbody>
                                   <?php foreach ($list as $value) { ?>
                                       <tr>
                                           <td><?php echo $value->Operator; ?></td>
                                           <td><?php echo $value->StampDetails; ?></td>
                                           <td><?php echo $value->region; ?></td>
                                           <td><?php echo $value->branch; ?></td>
                                           <td><?php echo number_format($value->paidamount,2); ?></td>
                                           <td> <?php  echo $value->billid;  ?> 
                                           </td>
                                           <td><?php echo $value->paychannel; ?></td>
                                           <td><?php echo $value->paymentdate; ?></td>
                                           <td><?php if($value->status == 'NotPaid'){?>
                                                <button class="btn btn-danger btn-sm" disabled="disabled">NOT PAID</button>
                                               <?php }else{?>
                                                <button class="btn btn-success btn-sm" disabled="disabled">PAID</button>
                                               <?php } ?>
                                           </td> 
                                       </tr>
                                   <?php } ?>
                                   
                               </tbody>
                           </table>

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
