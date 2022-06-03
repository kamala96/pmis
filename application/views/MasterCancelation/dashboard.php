<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar');
 ?>

      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i> Master Cancelation  </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">
                            Dashboard
                        </li>
                    </ol>
                </div>
            </div>
             
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">



                 <div class="row">

                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                        <a class="text-muted m-b-0" href="<?php echo site_url('Exedence/nontechnical_dashboard');?>">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                     Incidents
                                     </h3>
                                      Dashboard 
                                    </div>
                                </div>
                            </div>
                       </a>
                        </div>
                    </div>
                    <!-- Column -->

                     <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                        <a class="text-muted m-b-0" href="<?php echo site_url('MasterCancelation/find_transactiond'); ?>">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                      Search Transaction
                                     </h3>
                                      View Cancelation
                                    </div>
                                </div>
                            </div>
                       </a>
                        </div>
                    </div>
                    <!-- Column -->

                </div>


                <div class="row">
                    <div class="col-12">

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


                            <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i>  Find Transaction <span class="pull-right " ></span></h4>
                            </div>

                           <div class="card-body">

                            <form method="get" class="row" action="<?php echo site_url('MasterCancelation/find_transaction'); ?>">

                                <div class="form-group col-md-6 m-t-10">
                                <input type="text" name="code" class="form-control" placeholder="Enter Barcode / Control Number" required>
                                </div> 
                           

                                <div class="form-group col-md-4 m-t-10">
                                <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> Search </button>
                                </div>
                                      
                            </form>


   <!-- EMS RESULTS -->
                           
                         <?php if(!empty($emstranslist)){ ?>

                                    <div class="table-responsive">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">S/N</th>
                                           <th> Date </th>
                                           <th> Serial </th>
                                           <th> Mobile </th>
                                           <th> Region </th>
                                           <th> Branch </th>
                                           <th> Barcode </th>
                                           <th> Amount </th>
                                           <th> Control # </th>
                                           <th> PaymentDate </th>
                                           <th> PayChannel </th>
                                           <th> PaymentFor </th>
                                           <th> Receipt </th>
                                           <th> Status  </th>
                                           <th> Action  </th>
                                        </tr>
                                     </thead>

                                             <tbody class="results">
                                           <?php $sn=1; foreach($emstranslist as $data){ ?>
                                             <tr>
                                            <td> <?php echo $sn; ?> </td>                                           
                                            <td> <?php echo @$data->transactiondate; ?> </td>
                                            <td> <?php echo @$data->serial; ?> </td>
                                            <td> <?php echo @$data->Customer_mobile; ?> </td>
                                            <td> <?php echo @$data->region; ?> </td>
                                            <td> <?php echo @$data->district; ?> </td>
                                            <td> <?php echo @$data->Barcode; ?> </td>
                                            <td> <?php echo number_format(@$data->paidamount,2); ?> </td>
                                            <td> <?php echo @$data->billid; ?> </td>
                                            <td> <?php echo @$data->paymentdate; ?> </td>
                                            <td> <?php echo @$data->paychannel; ?> </td>
                                            <td> <?php echo @$data->PaymentFor; ?> </td>
                                            <td> <?php echo @$data->receipt; ?> </td>
                                            <td> <button type="button" class="btn btn-primary btn-xm"> <?php echo @$data->status; ?> </button>  </td>
                                            <td>

                                             <button title="Edit" class="btn btn-xm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#update_modal<?php echo $data->id; ?>">  <i class="fa fa-pencil-square-o"></i> Cancel </button>

                                            </td>
                                        </tr>
                                    <?php $sn++; ?>
                                      
                                    <!-- Edit -->
                <div class="modal fade" id="update_modal<?php echo $data->id; ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                                               
                  <div class="modal-header">
                  <h5 class="modal-title mt-0" id="myLargeModalLabel"> Cancelation Reason  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                   </div>             
                    <div class="modal-body"> 
                    <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('MasterCancelation/cancel_transaction');?>">
                    <input type="hidden" class="form-control"  name="transid" value="<?php echo $data->id; ?>">
                    <div class="form-group row">
                    <div class="col-12">
                    <label> Reason </label>
                    <textarea name="reason" class="form-control" rows="5" required></textarea>
                    </div>
                    </div>
                    <div class="form-group row">
                    <div class="col-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Confirm Cancelation  </button>
                    </div>
                    </div>   
                     </form>
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
                         <!-- END OF EMS RESULTS -->


                         <!-- MAILS RESULTS -->
                           
                         <?php if(!empty($mailtranslist)){ ?>

                                    <div class="table-responsive">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">S/N</th>
                                           <th> Date </th>
                                           <th> Serial </th>
                                           <th> Barcode </th>
                                           <th> Amount </th>
                                           <th> Control # </th>
                                           <th> PaymentDate </th>
                                           <th> PayChannel </th>
                                           <th> Receipt </th>
                                           <th> Status  </th>
                                           <th> Action  </th>
                                        </tr>
                                     </thead>

                                             <tbody class="results">
                                           <?php $sn=1; foreach($mailtranslist as $data){ ?>
                                             <tr>
                                            <td> <?php echo $sn; ?> </td>                                           
                                            <td> <?php echo @$data->transactiondate; ?> </td>
                                            <td> <?php echo @$data->serial; ?> </td>
                                            <td> <?php echo @$data->Barcode; ?> </td>
                                            <td> <?php echo number_format(@$data->paidamount,2); ?> </td>
                                            <td> <?php echo @$data->billid; ?> </td>
                                            <td> <?php echo @$data->paymentdate; ?> </td>
                                            <td> <?php echo @$data->paychannel; ?> </td>
                                            <td> <?php echo @$data->receipt; ?> </td>
                                            <td> <button type="button" class="btn btn-primary btn-xm"> <?php echo @$data->status; ?> </button>  </td>
                                            <td>

                                             <button title="Edit" class="btn btn-xm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#update_modal<?php echo $data->t_id; ?>">  <i class="fa fa-pencil-square-o"></i> Cancel </button>

                                            </td>
                                        </tr>
                                    <?php $sn++; ?>
                                      
                                    <!-- Edit -->
                <div class="modal fade" id="update_modal<?php echo $data->t_id; ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                                               
                  <div class="modal-header">
                  <h5 class="modal-title mt-0" id="myLargeModalLabel"> Cancelation Reason  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                   </div>             
                    <div class="modal-body"> 
                    <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('MasterCancelation/cancel_register_transaction');?>">
                    <input type="hidden" class="form-control"  name="transid" value="<?php echo $data->t_id; ?>">
                    <div class="form-group row">
                    <div class="col-12">
                    <label> Reason </label>
                    <textarea name="reason" class="form-control" rows="5" required></textarea>
                    </div>
                    </div>
                    <div class="form-group row">
                    <div class="col-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Confirm Cancelation </button>
                    </div>
                    </div>   
                     </form>
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
                         <!-- END OF MAILS RESULTS -->


                       


                        </div>
                    </div>
                   </div>
               </div>









                        



            </div>

<script type="text/javascript">
$(document).ready(function() {

var table = $('#example4').DataTable( {
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


