<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<link href="<?php echo base_url(); ?>assets/css/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />   

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Real Estate Properties </h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
				<li class="breadcrumb-item active">Property 
                list </li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<?php $regvalue = $this->employee_model->regselect(); ?>
	<div class="container-fluid">
		<div class="row m-b-10">
			<div class="col-12">
				<!-- <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Application </a></button> -->

            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Services/Estate" class="text-white"><i class="" aria-hidden="true"></i> Dashboard </a></button>
			   
			<button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>Realestate/AddProperty" class="text-white"><i class="" aria-hidden="true"></i> Add  Property</a></button>

			
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>  Property List</h4>
                </div>

                <div class="card-body">


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

                            <?php 
                            if(!empty($this->session->flashdata('success'))){
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
                                      <?php echo $this->session->flashdata('success'); ?>
                                      <?php
                            echo "</div>";
                            
                            }
                            ?>


                     <form class="row" method="get" action="<?php echo site_url('Realestate/find_real_estate_property_list'); ?>">
                                
                                <div class="form-group col-md-3 m-t-10">
                                <input type="text" name="fromdate" class="form-control mydatetimepickerFull"  placeholder="From Date">
                                </div>
                                    
                                <div class="form-group col-md-3 m-t-10">
                                <input type="text" name="todate" class="form-control mydatetimepickerFull" placeholder="To Date">
                                </div>

                                <div class="form-group col-md-3 m-t-10">
                                <select name="region" class="form-control region" id="regiono" onChange="getDistrict();">
                                            <option value=""> Region </option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                </select>
                                </div>

                                <div class="form-group col-md-3 m-t-10">
                                <select name="district" class="form-control branch" id="branchdropo">  
                                 <option value=""> District </option>
                                </select>
                                </div>

                                <div class="form-group col-md-3 m-t-10">
                                <select name="propertytype" class="form-control">
                                <option value=""> Property Type </option>
                                <option value="Residential"> Residential </option>
                                <option value="Land"> Land </option>
                                <option value="Offices"> Offices </option>
                                <option value="Conference"> Conference </option>
                                </select>
                                </div>
                                    
                                <div class="form-group col-md-4 m-t-10">
                                <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> Search </button>
                                </div>
                    </form>

                    <?php if(!empty($list)){?>


                     <div class="table table-responsive">
                           <table class="table table-bordered International text-nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Property Name</th>
                                <th>Property #</th>
                                <th>Region</th>
                                <th>District</th>
                                <th>Property Size</th>
                                <th>Property Value</th>
                                <th>Land Value</th>
                                <th>Property Type</th>
                                <th >Action</th>
                            </tr>
                        </thead>
                         <tbody>
                        <?php $sn=1; foreach ($list as $value) { ?>
                        <tr>
                        <td><?php echo @$sn; ?></td>
                        <td><?php echo @$value->property_name; ?></td>
                        <td><?php echo @$value->RegistrationNo; ?></td>
                        <td><?php echo @$value->Region; ?></td>
                        <td><?php echo @$value->District; ?></td>
                        <td><?php echo number_format(@$value->property_size); ?> <?php echo @$value->size_unit; ?></td>
                        <td><?php echo number_format(@$value->PropertyValue,2); ?> </td>
                        <td><?php echo number_format(@$value->LandValue,2); ?> </td>
                        <td><?php echo @$value->property_type; ?> </td>
                        <td>

                <a href="<?php echo site_url('Realestate/editproperty/');?><?php echo $value->id; ?>" class="toolproperty btn btn-success view" title="Edit Details" style="color:#fff;"> <i class="fa fa-pencil-square-o"></i> </a>
                        
                <a href="<?php echo site_url('Realestate/delete_real_estate_property');?>?I=<?php echo base64_encode($value->id); ?>" class="toolproperty btn btn-primary view" style="color:#fff;" onclick="return confirm('Are you sure you want to delete this Property?');"> <i class="fa fa-trash"></i> </a>


                        </td>
                        </tr>
                        <?php $sn++; } ?>
                        </tbody>
                        </table>
                       </div>
                 <?php } ?>


                 </div>





						
	    	</div>
		</div>
	</div>
  </div>

	</div>
</div>




<script type="text/javascript">
    $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#kiwi thead tr').clone(true).appendTo( '#kiwi thead' );
    $('#kiwi thead tr:eq(1) th').not(":eq(8)").each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );

        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                .column(i)
                .search( this.value )
                .draw();
            }
        } );
    } );

    var table = $('#kiwi').DataTable( {
        orderCellsTop: true,
        order: [[0,"asc" ]],
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );

   


} );

function showPropertyModal(id){    
      var id = id;            
      $('.property-body').load('<?php echo base_url(); ?>Realestate/Propertyprofile/' + id,function(){           
          $('#updateProperty').modal({show:true}); 
         
      });                    
  }
</script>



<script type="text/javascript">
$(document).ready(function() {

var table = $('.International').DataTable( {
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
    function getDistrict() {
    var region_id = $('#regiono').val();
     $.ajax({
     
     url: "<?php echo base_url();?>Realestate/RealEsategetDistrict",
     method:"POST",
     data:{region_id:region_id},//'region_id='+ val,
     success: function(data){
         $("#branchdropo").html(data);

     }
 });
};
</script>


	<?php $this->load->view('backend/footer'); ?>

	