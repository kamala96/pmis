<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-shopping-bag" style="color:#1976d2"> </i> Official Use Stock </h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Officialuse/dashboard" >Home</a></li>
				<li class="breadcrumb-item active"> Official Use </li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<div class="row m-b-10">
			<div class="col-12">
			
            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Officialuse/dashboard" class="text-white"><i class="" aria-hidden="true"></i> Dashboard </a></button>

             <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Officialuse/stock" class="text-white"><i class="" aria-hidden="true"></i> List Stock </a></button>

            <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>Officialuse/addstock" class="text-white"><i class="" aria-hidden="true"></i> Add Stock </a></button>
			
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>   Stock  </h4>
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
                                            <th> Date Registered </th>
                                            <th> Item </th>
                                            <th> Unit  </th>
                                            <th> Unit Price </th>
                                            <th> Total Qty  </th>
                                            <th> Total </th>
                                            <th> Supplier </th>
                                            <th> Qty Supplied  </th>
                                            <th> Available Stock  </th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="results">
                                     <?php $sn=1; foreach($list as $data){ ?>
                                        <tr>
                                            <td> <?php echo $sn; ?> </td>    
                                            <td> <?php echo $data->date_registered; ?> </td>
                                              <td> <?php echo $data->item_name; ?> </td>
                                               <td> <?php echo $data->unit_name; ?> </td>
                                               <td> <?php echo number_format($data->price,2); ?> </td>
                                              <td> <?php echo number_format($data->qty); ?> </td>
                                               <td> <?php echo number_format($data->price*$data->qty,2); ?> </td>
                                               <td> <?php echo $data->supplier; ?> </td>
                                               <td> <?php  if(!empty($data->balance_qty)){ echo number_format($data->qty-$data->balance_qty); } ?> </td>
                            <td> <?php if(!empty($data->balance_qty)){ echo number_format($data->balance_qty); } else { echo number_format($data->qty); } ?> </td>
                                            <td>

                                             <button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#update_modal<?php echo $data->stock_id; ?>">  <i class="fa fa-pencil-square-o"></i> </button>
                                                 
                                              <a href="<?php echo base_url('Officialuse/delete_stock');?>?I=<?php echo base64_encode($data->stock_id); ?>" onclick='return del();' title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>

                                            </td>
                                        </tr>
                                    <?php $sn++; ?>
                                      
                                    <!-- Edit -->
                        <div class="modal fade" id="update_modal<?php echo $data->stock_id; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Edit Item information  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>             
                    <div class="modal-body"> 
                    <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Officialuse/update_stock');?>">
                    <input type="hidden" class="form-control"  name="stockid" value="<?php echo $data->stock_id; ?>">
                    <div class="form-group row">
                    <div class="col-6">
                    <label> Item </label>
                    <select name="itemid" class="form-control" required="">
                    <option value="<?php echo $data->itemid; ?>"> <?php echo $data->item_name; ?> </option>
                    <?php foreach ($listitems as $value){ ?>
                   <option value="<?php echo $value->item_id; ?>"> <?php echo $value->item_name; ?></option>
                   <?php } ?>
                   </select>
                    </div>
                    <div class="col-6">
                    <label> Unit </label>
                    <select name="unitid" class="form-control" required="">
                    <option value="<?php echo $data->unitid;?>"> <?php echo $data->unit_name; ?> </option>
                    <?php foreach ($listunits as $value){ ?>
                   <option value="<?php echo $value->unit_id; ?>"> <?php echo $value->unit_name; ?></option>
                   <?php } ?>
                   </select>
                    </div>
                     <div class="col-12">
                    <label> Supplier </label>
                    <input class="form-control" type="text" name="supplier" value="<?php echo $data->supplier; ?>">
                    </div>
                    <div class="col-6">
                    <label> Price </label>
                    <input class="form-control" type="number" name="price" step="any" value="<?php echo $data->price; ?>">
                    </div>
                    <div class="col-6">
                    <label> Quantity </label>
                    <input class="form-control" type="number" name="qty" step="any" value="<?php echo $data->qty; ?>">
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
