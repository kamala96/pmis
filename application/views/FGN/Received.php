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
                             <a href="<?php echo base_url(); ?>FGN_Application/Receive" class="btn btn-primary waves-effect waves-light">Receive</a>

                              <a href="<?php echo base_url(); ?>FGN_Application/Received?>" class="btn btn-primary waves-effect waves-light">Received</a>

                               <a href="<?php echo base_url(); ?>FGN_Application/Itemized" class="btn btn-primary waves-effect waves-light">Itemized Item</a>

						
								
							 </h4>
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
							
                            

                            


							   <div class="table-responsive ">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
												<th> Small Packet Number </th>
												<th> Region </th>
												<th> Branch </th>
												 <th> Created at  </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										$sn=1;
										foreach($outsidesmallpacket as $data){
										?>
                                            <tr>
                                                <td> <?php echo $sn; ?> </td>
												<td> <?php echo $data->FGN_number; ?> </td>
												<td> <?php echo $data->region; ?> </td>
												<td> <?php echo $data->branch; ?> </td>
												<td> <?php echo $data->FGN_created_at; ?> </td>
												
                                                <td class="jsgrid-align-center ">
													
                                                    <a href="#" onclick='return del();' title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
													
                                                </td>
                                            </tr>
										<?php 
										$sn++;
										?>
								
										<?php }?>  
											
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
<script>
    $(document).ready(function() {
    var max_fields_limit      = 1; //set limit for maximum input fields
    var x = 1; //initialize counter for text box
    $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
        if(x <= max_fields_limit){ //check conditions
            x++; //counter increment
            $('.input_fields_container').append('<div> <div class="form-group row"> <div class="col-4"> <input type="text" placeholder="Enter FGN Number" class="form-control" name="fgn_no[]"/> </div> <div class="col-3"> <select name="region[]" value="" class="form-control custom-select" required id="regiono2" onChange="getBranch();"> <option value=""> Region </option> <?php foreach($region as $value): ?> <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option> <?php endforeach; ?> </select> </div> <div class="col-3"> <select name="branch[]" value="" class="form-control custom-select"  id="branchdropo2"><option> Branch </option> </select> </div> <button href="#" class="remove_field btn btn-primary" style="margin-left:10px;">  X  </button>   </div> </div>'); //add input field
        }
    });  
    $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>


<script type="text/javascript">
    function getDistrict() {
    var region_id = $('#regiono').val();
     $.ajax({
     
     url: "<?php echo base_url();?>Employee/GetBranch",
     method:"POST",
     data:{region_id:region_id},//'region_id='+ val,
     success: function(data){
         $("#branchdropo").html(data);

     }
 });
};
</script>

<script type="text/javascript">
    function getBranch() {
    var region_id = $('#regiono2').val();
     $.ajax({
     
     url: "<?php echo base_url();?>Employee/GetBranch",
     method:"POST",
     data:{region_id:region_id},//'region_id='+ val,
     success: function(data){
         $("#branchdropo2").html(data);

     }
 });
};
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