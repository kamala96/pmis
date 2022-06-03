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
                        <a class="text-muted m-b-0" href="<?php echo site_url('MasterCancelation/dashboard'); ?>">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                      Cancel Transaction
                                     </h3>
                                      Find Transaction
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
                                <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i>  Find Cancelation Transaction Report <span class="pull-right " ></span></h4>
                            </div>

                           <div class="card-body">

                            <form method="post" class="row" action="<?php echo site_url('MasterCancelation/find_transaction_report'); ?>">

                                <div class="form-group col-md-3 m-t-10">
                                <input type="text" name="fromdate" class="form-control  mydatetimepickerFull" placeholder="From Date" required>
                                </div> 

                                <div class="form-group col-md-3 m-t-10">
                                <input type="text" name="todate" class="form-control  mydatetimepickerFull" placeholder="To Date" required>
                                </div> 

                                <select class="form-group col-md-3 m-t-10" name="status" required>
                                <option value="EMS">EMS</option>
                                 <option value="MAILS">MAILS</option>
                                </select>
                           

                                <div class="form-group col-md-3 m-t-10">
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
                                           <th> Canceled Date </th>
                                           <th> Transaction Date </th>
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
                                           <th> Canceled By  </th>
                                            <th> Reason  </th>
                                        </tr>
                                     </thead>

                                             <tbody class="results">
                                           <?php $sn=1; foreach($emstranslist as $data){ 
                                     $createdinfo  = $this->ExedenceModel->user_info(@$data->canceledby);
                                     $sendname = @$createdinfo->first_name.' '.@$createdinfo->middle_name.' '.@$createdinfo->last_name.' - PFNo: '.@$createdinfo->em_code;
                                            ?>
                                             <tr>
                                            <td> <?php echo $sn; ?> </td>  
                                            <td> <?php echo @$data->transaction_canceleddate; ?> </td>                                          
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
                                            <td> <?php if(!empty($data->canceledby)) { echo @$sendname; } else { } ?> </td>
                                            <td> <?php echo @$data->cancel_reason; ?> </td>
                                        </tr>
                                    <?php $sn++; ?>

                                     <?php } ?>
                   
                                    </tbody>
                                </table>
                                </div>
                              
                              <br>

                         <?php } ?>
                         <!-- END OF EMS RESULTS -->


                         <!-- MAILS RESULTS -->
                           
                         <?php if(!empty($mailtranslist)){ ?>

                                    <div class="table-responsive">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>

                                        <tr>
                                            <th width="5%">S/N</th>
                                           <th> Canceled Date </th>
                                           <th> Transaction Date </th>
                                           <th> Serial </th>
                                           <th> Barcode </th>
                                           <th> Amount </th>
                                           <th> Control # </th>
                                           <th> PaymentDate </th>
                                           <th> PayChannel </th>
                                           <th> Receipt </th>
                                           <th> Status  </th>
                                           <th> Canceled By  </th>
                                           <th> Reason  </th>
                                        </tr>
                                     </thead>

                                             <tbody class="results">
                                           <?php $sn=1; foreach($mailtranslist as $data){ 
                                     $createdinfo  = $this->ExedenceModel->user_info(@$data->canceledby);
                                     $sendname = @$createdinfo->first_name.' '.@$createdinfo->middle_name.' '.@$createdinfo->last_name.' - PFNo: '.@$createdinfo->em_code;
                                            ?>
                                             <tr>
                                            <td> <?php echo $sn; ?> </td>  
                                            <td> <?php echo @$data->transaction_canceleddate; ?> </td>                                         
                                            <td> <?php echo @$data->transactiondate; ?> </td>
                                            <td> <?php echo @$data->serial; ?> </td>
                                            <td> <?php echo @$data->Barcode; ?> </td>
                                            <td> <?php echo number_format(@$data->paidamount,2); ?> </td>
                                            <td> <?php echo @$data->billid; ?> </td>
                                            <td> <?php echo @$data->paymentdate; ?> </td>
                                            <td> <?php echo @$data->paychannel; ?> </td>
                                            <td> <?php echo @$data->receipt; ?> </td>
                                            <td> <button type="button" class="btn btn-primary btn-xm"> <?php echo @$data->status; ?> </button>  </td>
                                             <td> <?php if(!empty($data->canceledby)) { echo @$sendname; } else { } ?> </td>
                                            <td> <?php echo @$data->cancel_reason; ?> </td>
                                        </tr>
                                    <?php $sn++; ?>

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


