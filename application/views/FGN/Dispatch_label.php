<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Small Packet </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Small Packet </li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">

                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> 
								
                                <a href="<?php echo base_url(); ?>Services/Small_Packets" class="btn btn-primary waves-effect waves-light">New Small Packet</a>
                             <a href="<?php echo base_url(); ?>Packet_Application/Receive" class="btn btn-primary waves-effect waves-light">Receive/Itemazation</a>

                              <!-- <a href="<?php echo base_url(); ?>Packet_Application/Itemize" class="btn btn-primary waves-effect waves-light">Itemized Item</a> -->

                              <a href="<?php echo base_url(); ?>Packet_Application/Pass" class="btn btn-primary waves-effect waves-light">Print Itemization</a>
                              <a href="<?php echo base_url(); ?>Packet_Application/Dispatch_Packet_list" class="btn btn-primary waves-effect waves-light">Print Regional Dispatched </a>
                              <a href="<?php echo base_url(); ?>Packet_Application/Dispatch_label" class="btn btn-primary waves-effect waves-light">Print Label </a>
								
								
							 </h4>
                            </div>
							
                            <div class="card-body">


                                    <div style="display: none; font-size: 25px;background-color: #d22c19;color: white;" id="forMessage" class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong id="notifyMessage"></strong>
                        </div>
                            
							
							<?php 
							if(!empty($this->session->flashdata('message'))){
							echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
									  <?php echo $this->session->flashdata('message'); ?>
									  <?php
                            echo "</div>";
							
							}
							?>

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


                              <div class="col-md-12">
                                            
                                                 <form class="row" method="post" action="<?php echo site_url('Packet_Application/print_Dispatch_label_report');?>">
                        <table class="table table-bordered" style="width: 100%;">
                           <tr>
                              <th style="">
                                 <label>Select Date:</label>
                                 <div class="input-group">
                                    <input type="text" placeholder="From date" name="fromdate" class="form-control  mydatetimepickerFull col-md-4" id="fromdate">

                                    <input type="text" name="todate" placeholder="To date" class="form-control  mydatetimepickerFull col-md-4" id="todate">

                                    <select name="type"  class="form-control custom-select"  id="type">  
                                 <option value="Single">Print Single</option>
                                 <option value="All">Print All</option>
                                </select>

                                    <input type="submit" name="check"  class="btn btn-success  col-md-2" style="" id="BtnSubmit012" value="Submit/Print" required="required">
                                 </div>
                              </th>
                           </tr>
                        </table>
                         </form>
                     </div>
<div>
<form class="row" method="post" action="<?php echo site_url('Packet_Application/print_Dispatch_label_report');?>">
                     <table  class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%" style="border:2px;color:#000;font-size: 20px;font-weight: bold;">
                         <thead>         

                            <tr>
                                    <th> S/N </th>
                                    <th>Date</th>
                                     <th>Despatch Number</th>
                                     <th>Origin Branch</th>
                                    <th>Destination Branch</th>
                                    <th>Weight </th>
                                    <th>Action </th>
                                </tr>
                            </thead>

                            <tbody>
                              <?php $sn=1; ?>
                               <?php foreach (@$reports as  $value) {?>
                                   <tr>
                                 
                                     <td> <?php echo $sn; ?> </td>
                                      <td> <?php  echo @$value->datetime; ?>  </td>
                                      <td> <?php  echo @$value->desp_no; ?>  </td>
                                      <td><?php echo @$value->branch_from;?></td>
                                       <td><?php echo @$value->branch_to;?></td>
                                       <td><?php echo @$value->weight;?></td>
                                       <td>  <a href=" <?php echo base_url().'Packet_Application/print_Dispatch_label_single_report?desp_no='.@$value->desp_no; ?>" class="btn btn-sm btn-danger waves-effect waves-light"> <i class="fa fa-print"></i>Print</a></td>
                                    </tr>
                              <?php $sn++; } ?>
                            </tbody>
                        </table>
</form>

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