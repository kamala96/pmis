<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-wpforms" style="color:#1976d2"> </i> Posta Shop </h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#" >Home</a></li>
				<li class="breadcrumb-item active"> Posta Shop </li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<div class="row m-b-10">
			<div class="col-12">
			
           <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>PostaShop/postashop_dashboard" class="text-white"><i class="" aria-hidden="true"></i> Dashboard </a></button>

           <button type="button" class="btn btn-primary"><i class="fa fa-bell"></i><a href="<?php echo base_url(); ?>PostaShop/get_issued_approved_stock_request" class="text-white"><i class="" aria-hidden="true"></i> Pending Stock (<?php echo number_format(@$pendingstock); ?>) </a></button>
			
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>   Products List (Stock) | <button type="button" class="btn btn-sm btn-info"> <i class="fa fa-bell"></i></a> </button> Low Stock (Quantity Below 5) </h4>
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
                                            <th>Product</th>
                                            <th>Category</th>
                                            <th>Quantity</th>
                                            <th> Price </th>
                                            <th> Total </th>
                                        </tr>
                                    </thead>

                                    <tbody class="results">
                                     <?php $sn=1; foreach($list as $data){ 
                                     $stock = $data->qty;
                                     if($stock<=5){
                                     ?>
                                        <tr style="background: #d22c19;">
                                            <td> <?php echo $sn; ?> </td> 
                                            <td> <?php echo $data->product_name; ?> </td>                                          
                                            <td> <?php echo $data->category_name; ?> </td>
                                            <td> <?php echo $data->qty; ?> </td>
                                            <td> <?php echo number_format(@$data->price,2); ?> </td>
                                            <td> <?php echo number_format(@$data->qty*@$data->price,2); ?> </td>
                                        </tr>
                                  
                                     <?php } else { ?>

                                       <tr>
                                            <td> <?php echo $sn; ?> </td> 
                                            <td> <?php echo $data->product_name; ?> </td>                                          
                                            <td> <?php echo $data->category_name; ?> </td>
                                            <td> <?php echo $data->qty; ?> </td>
                                            <td> <?php echo number_format(@$data->price,2); ?> </td>
                                            <td> <?php echo number_format(@$data->qty*@$data->price,2); ?> </td>
                                        </tr>



                                     <?php } $sn++; } ?>
                   
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
<?php $this->load->view('backend/footer'); ?>
