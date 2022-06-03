<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-shopping-bag" style="color:#1976d2"> </i> Private Box/Locks </h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#" >Home</a></li>
				<li class="breadcrumb-item active"> Private Box/Locks </li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<div class="row m-b-10">
			<div class="col-12">

              <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Commercialuse/list_locks" class="text-white"><i class="" aria-hidden="true"></i> List Private Box/Locks </a></button>

            <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>Commercialuse/add_locks" class="text-white"><i class="" aria-hidden="true"></i> Add Private Box/Locks </a></button>
			
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>   Private Box/Locks List  </h4>
                </div>

                <div class="card-body">

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


                                    <div class="table-responsive" id="defaulttable">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">S/N</th>
                                            <th> Issue Date </th>
                                            <th>Locks Name </th>
                                            <th>Quantity </th>
                                            <th>Price</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="results">
                                     <?php $sn=1; foreach($list as $data){ ?>
                                        <tr>
                                            <td> <?php echo $sn; ?> </td>    
                                            <td> <?php echo  date('Y', strtotime($data->issuedate)) .' - '.date('Y', strtotime($data->enddate)); ?>  </td>
                                              <td> <?php echo $data->product; ?> </td>
                                               <td> <?php echo $data->quantity; ?> </td>
                                              <td> <?php echo number_format($data->pricepermint,2); ?> </td>
                           
                                            <td>

                                             <button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#update_modal<?php echo $data->commercial_stock_id; ?>">  <i class="fa fa-pencil-square-o"></i> </button>
                                                 
                                              <a href="<?php echo base_url('Commercialuse/delete_stock');?>?I=<?php echo base64_encode($data->commercial_stock_id); ?>" onclick='return del();' title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>

                                            </td>
                                        </tr>
                                    <?php $sn++; ?>
                                      
                                    <!-- Edit -->
                        <div class="modal fade" id="update_modal<?php echo $data->commercial_stock_id; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Edit <?php echo $data->product; ?>  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>             
                    <div class="modal-body"> 
                    <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Commercialuse/update_stock');?>">
                    <input type="hidden" class="form-control"  name="stockid" value="<?php echo $data->commercial_stock_id; ?>">

                    <div class="form-group row">
                     <div class="col-6">
                    <label> Issue Date </label>
                    <input class="form-control mydatetimepickerFull" type="text" name="issuedate" value="<?php echo $data->issuedate; ?>" required>
                    </div>
                    <div class="col-6">
                    <label> End Date </label>
                    <input class="form-control mydatetimepickerFull" type="text" name="enddate" value="<?php echo $data->enddate; ?>" required>
                    </div>
                    <div class="col-6">
                    <label> Locks Name </label>
                    <input class="form-control" type="text" name="product" value="<?php echo $data->product; ?>" required>
                    </div>
                    <div class="col-6">
                    <label> Quantity </label>
                    <input class="form-control" type="number" name="quantity" value="<?php echo $data->quantity; ?>" required>
                    </div>
                    <div class="col-6">
                    <label> Price </label>
                    <input class="form-control" type="number" name="pricepermint" value="<?php echo $data->pricepermint; ?>" required>
                    </div>
                    </div>

                    <div class="form-group row">
                    <div class="col-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Update </button>
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

                 </div>





						
	    	</div>
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

<script type="text/javascript">
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>

<?php $this->load->view('backend/footer'); ?>
