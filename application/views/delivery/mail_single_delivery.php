<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> <i class="fa fa-braille" style="color:#1976d2"></i> Register Delivery  </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Delivery </li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">

                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">

					 <a href="<?php echo site_url('Posta_delivery/mails_dashboard');?>">	 <button type="button" class="btn btn-primary waves-effect waves-light"> <i class="fa fa-bars"></i> Dashboard </button> </a>
							
                            </div>
                            <div class="card-body">
							
							<p> Please, Fill valid Barcode to continue  </p>
							
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

						<form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Posta_delivery/search_single_mail_bulk');?>">
						    <div class="form-group row">
                                <div class="col-9">
                                <input class="form-control" type="text" required="" placeholder="Enter valid Barcode" name="code">
                                </div>
							 <div class="col-3">
                             <button type="submit" class="btn btn-primary waves-effect waves-light" name="search"> <i class="mdi mdi-file-find"></i> Search </button>
                              </div>
                            </div>
                        </form> 


                       <!-- Single Delivery EMS Display Results -->
				    <?php  if(!empty($senderid)){ ?>
      
                    <hr>
                    <h3> Barcode Number: <?php echo $barcode; ?> | Origin: <?php echo $origin; ?> | Destination: <?php echo $destination; ?> </h3>
                    <hr>

                    <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Posta_delivery/submit_mail_single_delivery');?>">
					
		            <input type="hidden" class="form-control"  name="senderid" value="<?php echo $senderid; ?>">

                     <div class="form-group row">
				    <div class="col-sm-4">
					<label> Deliverer Name </label>
				     <input type="text" class="form-control" placeholder="Enter Name" name="name" required>
				    </div>
					<div class="col-sm-4">
					<label> Phone </label>
				     <input type="text" class="form-control" placeholder="Enter Phone # eg 255xxxxxxxxx" name="phone" required>
				    </div>
				    <div class="col-sm-4">
					<label> Identity </label>
				     <input type="text" class="form-control" placeholder="Enter Identity" name="identity">
				    </div>
	                 </div>   
					 
					<div class="form-group row">
					<div class="col-sm-4">
					<label> Identity No </label>
				     <input type="text" class="form-control" placeholder="Enter Identit No" name="identityno">
				    </div>
				    <div class="col-sm-4">
					<label> Delivery Date </label>
				     <input type="date" class="form-control" placeholder="Select Delivery Date" name="deliverydate" required>
				    </div>
	                 </div> 
					
			        <div class="form-group row">
                    <div class="col-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Submit </button>
                    </div>
                    </div>
							
                     </form>



					   
											  								
					   <?php } ?>				
					    <!-- END MAILS Display Results -->


					     <!-- Single Delivery EMS Display Results -->
				    <?php  if(!empty($groupid)){ ?>

				    <hr>
				  
      
                    <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Posta_delivery/submit_group_mail_single_delivery');?>">
					
		            <input type="hidden" class="form-control"  name="groupid" value="<?php echo $groupid; ?>">

                     <div class="form-group row">
				    <div class="col-sm-4">
					<label> Deliverer Name </label>
				     <input type="text" class="form-control" placeholder="Enter Name" name="name" required>
				    </div>
					<div class="col-sm-4">
					<label> Phone </label>
				     <input type="text" class="form-control" placeholder="Enter Phone # eg 255xxxxxxxxx" name="phone" required>
				    </div>
				    <div class="col-sm-4">
					<label> Identity </label>
				     <input type="text" class="form-control" placeholder="Enter Identity" name="identity">
				    </div>
	                 </div>   
					 
					<div class="form-group row">
					<div class="col-sm-4">
					<label> Identity No </label>
				     <input type="text" class="form-control" placeholder="Enter Identit No" name="identityno">
				    </div>
				    <div class="col-sm-4">
					<label> Delivery Date </label>
				     <input type="date" class="form-control" placeholder="Select Delivery Date" name="deliverydate" required>
				    </div>
	                 </div> 
					
			        <div class="form-group row">
                    <div class="col-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Submit </button>
                    </div>
                    </div>
							
                     </form>

                      <hr>
                   


                                   <div class="table-responsive" id="defaulttable">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">S/N</th>
                                            <th>Addressee</th>
                                            <th>Barcode</th>
                                            <th>Origin</th>
                                            <th>Destination</th>
                                            <th>Registered</th>
                                            <th>Weight</th>
                                            <th>Postage</th>
                                            <th>Vat</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>

                                    <tbody class="results">
                                     <?php $sn=1; foreach($list as $data){  
                                     $value = $this->Delivery_Model->get_mail_info($data->barcode);
                                     ?>
            <tr>
            <td>  <?php echo $sn; ?> </td>
		   <td>  <?php echo $value->receiver_fullname; ?> </td>
           <td> <?php echo $value->Barcode; ?> </td>
           <td> <?php echo $value->sender_region; ?> </td>
		   <td> <?php echo $value->reciver_branch; ?> </td>
		   <td> <?php echo date("d/m/y", strtotime($value->sender_date_created))?> </td>
		   <td> <?php echo $value->register_weght; ?> </td>
		   <td> 
       <?php @$emsprice = (100*$value->paidamount)/118; echo number_format($emsprice,2); 
       $sumprice[] = @$emsprice;
        ?> 
       </td>
       <td> 
      <?php @$amount = $value->paidamount; 
       @$emsvat = @$amount - @$emsprice;
       $sumvat[] = @$emsvat;
       echo number_format(@$emsvat,2);
       ?> 
       </td>
       <td>
        <?php 
        @$finalamount = $value->paidamount; echo number_format($finalamount,2);
        @$sumamount[] = @$finalamount;
         ?>
        </td>
         </tr>
                                    <?php  $sn++;  }  ?>
                   
                                    </tbody>

     <tr>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td>  <strong> <?php echo number_format(array_sum(@$sumprice),2);?>  </strong> </td>
     <td> <strong> <?php echo number_format(array_sum(@$sumvat),2);?>  </strong> </td>
       <td> <strong> 
        <?php 
       if(!empty(@$finalamount)){
       echo number_format(array_sum(@$sumamount)); 
       }
       ?> <strong></td>
       </tr>

                                </table>
                                </div>



					   
											  								
					   <?php } ?>				
					    <!-- END MAILS Display Results -->

                               
							   
							   
                            </div>
                        </div>
                    </div>
                </div>
<script type="text/javascript">
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>

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

     <script type="text/javascript">
	  function del()
	  {
		if(confirm("Are you sure you want to delete?"))
		{
			return true;
		}
		
		else{
			return false;
		}
	  }
     </script>
    <?php $this->load->view('backend/footer'); ?>