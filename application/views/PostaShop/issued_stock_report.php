<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-list" style="color:#1976d2"> </i> Posta Shop | Stock Issed Report </h3>
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
			   

             <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>PostaShop/report_dashbaord" class="text-white"><i class="" aria-hidden="true"></i> Report Dashboard   </a></button>

			
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>  Branch Issued Stock Report </h4>
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

                    <form method="POST" action="<?php echo base_url('PostaShop/print_issued_stock_report');?>">

                                <div class="form-group row">
                                <div class="col-3">
                                <input type="text" name="fromdate" class="form-control mydatetimepickerFull" placeholder="From Date" required>
                                </div>
                                <div class="col-3">
                                 <input type="text" name="todate" class="form-control mydatetimepickerFull" placeholder="To Date" required>
                                </div>
                                <div class="col-3">
                                <select name="region" value="" class="form-control" required id="regiono" onChange="getDistrict();" required>
                                <option value=""> Region </option>
                                <?php foreach($regions as $value): ?>
                                <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                <?php endforeach; ?>
                                </select>
                                </div>
                                <div class="col-3">
                                <select name="branch" value="" class="form-control" id="branchdropo" required>  
                                 <option> Branch </option>
                                </select>
                                </div>
                                </div>

                                 <div class="form-group row">
                                <div class="col-4">
                                <button type="submit" class="btn btn-primary waves-effect waves-light"> <i class="fa fa-search"></i> Search</button>
                                </div>
                                  </div>
                          
                               </form>


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
    function getDistrict() {
    var region_id = $('#regiono').val();
     $.ajax({
     
     url: "<?php echo base_url();?>PostaShop/GetBranch",
     method:"POST",
     data:{region_id:region_id},//'region_id='+ val,
     success: function(data){
         $("#branchdropo").html(data);

     }
 });
};
</script>

<?php $this->load->view('backend/footer'); ?>
