<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-wpforms" style="color:#1976d2"> </i>  <?php echo @$productcode; ?>  </h3> 
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#" >Home</a></li>
				<li class="breadcrumb-item active">  <?php echo @$productcode;  ?>   </li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<div class="row m-b-10">
			<div class="col-12">
			
         <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>PostaStamp/products_dashboard" class="text-white"><i class="" aria-hidden="true"></i> Dashboard </a></button>

        <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo site_url('PostaStamp/main_stock'); ?>?I=<?php echo base64_encode($categoryid);?>" class="text-white"><i class="" aria-hidden="true"></i>  Add <?php echo @$productcode; ?>  </a></button>



			
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>    <?php echo @$productcode; ?> List (Stock) </h4>
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
                                            <th> <?php echo @$productcode; ?> </th>
                                            <th>Quantity</th>
                                            <th>Price </th>
                                            <th> Total </th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="results">
                                     <?php $sn=1; foreach($list as $data){ ?>
                                        <tr>
                                            <td> <?php echo $sn; ?> </td> 
                                            <td> <?php echo $data->product_name; ?> </td>
                                            <td> <?php echo $data->qty; ?> </td>
                                            <td> <?php echo number_format(@$data->price,2); ?> </td>
                                            <td> <?php echo number_format(@$data->qty*@$data->price,2); ?> </td>
                                            <td>

                                             <button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#update_modal<?php echo $data->stampstock_id; ?>">  <i class="fa fa-pencil-square-o"></i> </button>
                                                 
                                              <a href="<?php echo base_url('PostaStamp/delete_stock');?>?I=<?php echo base64_encode($data->stampstock_id); ?>" onclick='return del();' title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>

                                            </td>
                                        </tr>
                                    <?php $sn++; ?>
                                      
                                    <!-- Edit -->
                        <div class="modal fade" id="update_modal<?php echo $data->stampstock_id; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Edit <?php echo @$productcode; ?> Details </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>             
                    <div class="modal-body"> 
                    <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('PostaStamp/update_stock');?>">
                    <input type="hidden" class="form-control"  name="productstockid" value="<?php echo $data->stampstock_id; ?>">
                    

                    <div class="form-group row">
                    <div class="col-6">
                    <label> <?php echo @$productcode; ?> </label>
                    <input class="form-control" type="text" name="product" value="<?php echo @$data->product_name; ?>" required>
                    </div>
                    <div class="col-6">
                    <label> price </label>
                    <input class="form-control" type="number" name="price" value="<?php echo @$data->price; ?>" required>
                    </div>
                    </div>

                    <div class="form-group row">
                    <div class="col-6">
                    <label> Quantity </label>
                    <input class="form-control" type="number" name="qty" value="<?php echo @$data->qty; ?>" required>
                    </div>
                     <div class="col-6">
                    <label> Total </label>
                    <input class="form-control" type="text" value="<?php echo number_format(@$data->price*@$data->qty,2); ?>" readonly>
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

<script>
    $(document).ready(function() {
    var max_fields_limit      = 10; //set limit for maximum input fields
    var x = 1; //initialize counter for text box
    $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
        if(x < max_fields_limit){ //check conditions
            x++; //counter increment
            $('.input_fields_container').append('<div> <div class="form-group row"> <div class="col-8"> <input type="text" placeholder="Enter Category Name" class="form-control" name="name[]"/> </div>  <button href="#" class="remove_field btn btn-primary" style="margin-left:10px;">  X  </button>   </div> </div>'); //add input field
        }
    });  
    $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
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
