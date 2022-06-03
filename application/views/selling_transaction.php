<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>  Bureau De Change | Selling Transaction </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Bureau De Change</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
              <div class="col-12">


                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo site_url('Bureau/selling');?>" class="text-white"><i class="" aria-hidden="true"></i> Selling  </a></button>
                    
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Bureau/selling_transaction" class="text-white"><i class="" aria-hidden="true"></i> Selling Transaction </a></button>

                      <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Services/Bureau" class="text-white"><i class="" aria-hidden="true"></i>  Bureau De Change Menu  </a></button>

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
                        <h4 class="m-b-0 text-white"> Selling Transaction List
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

                      <form class="row" method="post" action="<?php echo site_url('Bureau/list_transaction_results'); ?>">

                                    <input type="hidden" name="status" class="form-control"  value="01">
                                
                                    <div class="form-group col-md-4 m-t-10">
                                    <input type="date" name="fromdate" class="form-control"  required="required">
                                    </div>
                                    
                                    <div class="form-group col-md-4 m-t-10">
                                         <input type="date" name="todate" class="form-control" required="required">
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
                                   <th> Customer Name </th>
                                   <th> Phone Number  </th>
                                   <th> Identity Type </th>
                                   <th> Identity Number </th>
                                   <th> Receipt </th>
                                   <th> Transaction Date </th>
                                   <th> Action </th>
                               </thead>
                               <tbody>
                                   <?php $sn=1; foreach ($list as $value) { 
                                    ?>
                                       <tr>
                                           <td><?php echo $sn; ?></td>
                                           <td><?php echo $value->customer_name; ?></td>
                                           <td><?php echo $value->customer_mobile; ?></td>
                                           <td><?php echo $value->identity_desc; ?></td>
                                           <td><?php echo $value->customer_identity_no; ?></td>
                                           <td><?php echo $value->receipt; ?></td>
                                           <td><?php echo $value->transaction_created_at; ?></td>
                                           <td>
                                            <button type="button" class="btn btn-primary"><i class="fa fa-print"></i><a href="<?php echo base_url('Bureau/printReceipt');?>?I=<?php echo base64_encode($value->serial); ?>" class="text-white"><i class="" aria-hidden="true"></i>  Print Receipt  </a></button>
                                           </td>
                                       </tr>
                                   <?php $sn++; } ?>
                                   
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
