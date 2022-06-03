<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
         <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Imprest Subsistence Request</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-university" aria-hidden="true"></i> Imprest Subsistence Request</li>
                    </ol>
                </div>
            </div>
            
            <div class="container-fluid">
				<div class="row m-b-10">
					<div class="col-12">
						<a href="<?php echo base_url() ?>imprest/expenditure_Application" class="btn btn-primary"><i class="fa fa-plus"></i> Add Imprest Request</a>

                    <a href="<?php echo base_url() ?>imprest/expenditure_List" class="btn btn-primary"><i class="fa fa-list"></i> Imprest Request List</a>

                    <a href="<?php echo base_url() ?>imprest/imprest_subsistence_List" class="btn btn-primary"><i class="fa fa-list"></i> Imprest Subsistence Request List</a>
					</div>
				</div>
				<div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Imprest Susistence Request Verify Form
                                </h4>
                            </div>
                    <div class="card-body">
							<div class="tab-pane" id="ims" role="tabpanel" enctype='multipart/form-data'>
									<div class="card">
										<div class="card-body">
			<form class="" action="verify_imprest_subsistence_status" method="post" enctype="multipart/form-data">
												<div class="row">
													<div class="form-group col-md-4 m-t-5">
														<label>Subsistence Allowance Rate per day</label>
														<input type="hidden" name="imps_id" value="<?php echo $value->imps_id;?>" class="form-control form-control-line" placeholder="Rate Per Day">

														<input type="number" name="subsistence_allowance" class="form-control form-control-line" placeholder="Rate Per Day" value="<?php echo $value->rate_per_day;?>">
													</div>
												</div>
												<label><b>Details Of Safaris</b></label>
												<div class="row">
													<div class="form-group col-md-4 m-t-5">
														<label>Date Of Leaving Station</label>
														<input type="text" name="leaving_date"  class="form-control form-control-line mydatetimepickerFull" placeholder="Date Of Leaving" required="required" value="<?php echo $value->date_leaving;?>">
													</div>
													<div class="form-group col-md-4 m-t-5">
														<label>Date Of Returning</label>
														<input type="text" name="date_returning" value="<?php echo $value->date_returning;?>" class="form-control form-control-line mydatetimepickerFull" placeholder="Date Of Returning" required="required">
													</div>
													<div class="form-group col-md-4 m-t-5">
														<label>Visited Place</label>
														<input type="text" name="place_visited" value="<?php echo $value->visited_place;?>" class="form-control form-control-line" minlength="" placeholder="Place Visited">
													</div>
												</div>
												<div class="row">
													<div class="form-group col-md-12 m-t-5">
														<label>Reason</label>
														<textarea class="form-control" placeholder="Purpose of safari" name="safari_purpose" required="required"><?php echo $value->reason;?></textarea>
													</div>
												</div>
												<label><b>Details Of Imprest Required</b></label>
												<div class="row">
													<div class="form-group col-md-4 m-t-5">
														<label>Subsistence Allowance Days.</label>
														<input type="number" name="days" class="form-control" style="" placeholder="Number of days" required="required" value="<?php echo $value->days;?>">
													</div>
													<div class="form-group col-md-4 m-t-5">
														<label>Subsistence Allowance Amount in Tsh.</label>
														<input type="number" name="sub_amount" class="form-control" style="" placeholder="Amount Tshs." required="required" value="<?php echo $value->sub_amount;?>">
													</div>
													<div class="form-group col-md-4 m-t-5">
														<label>Incidental Expenses Foreign 20%.</label>
														<input type="number" name="inc_amount" class="form-control" style="" placeholder="Amount Tshs." required="required" value="<?php echo $value->inc_amount;?>">
													</div>
												</div>
												<div class="row">
													<div class="form-group col-md-4 m-t-5">
														<label>Fare Type.</label>
														<select name="fare_type" class="form-control" required="">
                                <option><?php echo $value->fare_type;?></option>
                                <option>Bus Ticket</option>
                                <option>Train Ticket</option>
                                <option>Air Ticket</option>              
                            </select>
													</div>
													<div class="form-group col-md-4 m-t-5">
														<label>Amount According To Fare Type Selection</label>
														<input type="number" name="fare_amount" class="form-control" style="" placeholder="Amount Tshs." required="required" value="<?php echo $value->fare_amount;?>">
													</div>
													<div class="form-group col-md-4 m-t-5">
														<label>AC/Code/Vote to be charged</label>
														<input type="number" name="vote_code" class="form-control" style="" placeholder="ACC/Code/Vote." required="required" value="<?php echo $value->vote_code;?>">
													</div>
													<div class="form-group col-md-4 m-t-5">
														<label>AC/Code/Vote to be charged Amount</label>
														<input type="number" name="vote_amount" class="form-control" style="" placeholder="Amount in Tsh." required="required" value="<?php echo $value->vote_amount;?>">
													</div>
												</div>
												<label><b>Details Of Safari Outside Tanzania</b></label>
												<div class="row">
													<div class="form-group col-md-4 m-t-5">
														<label>State House Authority No.</label>
														<input type="number" name="number7" class="form-control" style="height: 45px;" value="">
													</div>
													<div class="form-group col-md-4 m-t-5">
														<label>State House Authority Letter</label>
														<input type="file" name="state_letter" class="form-control">
													</div>
													<div class="form-group col-md-4 m-t-5">
												<label>Is this safari assisted by TPC/Donor</label>
                            <select name="status" class="form-control custome-select" id="yes" onChange="getValue()" style="height: 45px;">
                              <option>No</option>
                              <option>Yes</option>
                            </select>
													</div>
												</div>
												<div class="row" style="display: none;" id="comments">
													<div class="form-group col-md-12 m-t-5">
														<label>Short Details and number of safari days in this current year</label>
														<textarea class="form-control" placeholder="" name="comments"></textarea>
													</div>
												</div>
												<div class="row">
                        <div class="col-md-6">
                          <label>Select Status To Verify Imprest Subsistence</label>
                          <select name="status"  class="form-control custom-select reason" onchange="getReason();">
                            <option value="Approve">Approve</option>
                            <option value="Rejected">Reject</option>
                          </select>
                        </div>
                      </div>
                      <div class="row m-t-20" style="display: none;" id="show">
                        <div class="col-md-6">
                          <label>Reason</label>
                          <textarea name="reason" class="form-control"></textarea>
                        </div>
                      </div>
                      <br>
												<div class="row">
													<div class="form-actions col-md-12">
														<button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save Information</button>
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
    function getReason() {
       if ($('.reason').val() =='Rejected'){
           $('#show').show();
     }else{
           $('#show').hide();
     }

    };
</script>
<script type="text/javascript">
        function getValue() {
    var val = $('#yes').val();
    if (val == 'Yes') {
    $('#comments').show();
     }
     else {
    $('#comments').hide();
    }
};
</script>
				<script type="text/javascript">
                    $(document).ready(function() {
                        // Setup - add a text input to each footer cell
                        $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
                        $('#example4 thead tr:eq(1) th').not(":eq(2)").each( function (i) {
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

                        var table = $('#example4').DataTable( {
                            orderCellsTop: true,
                            fixedHeader: true,
                            dom: 'Bfrtip',
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ]
                        } );
                    } );
				</script>

<script>
 $(document).ready(function(){  
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="addition_name[]" placeholder="Enter Addition Name" class="form-control name_list" required="required"/></td><td><input type="text" name="addition_amount[]" placeholder="Enter Addition Amount" class="form-control name_list" required="required"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove1">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove1', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>
 <script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add7').click(function(){  
           i++;  
           $('#dynamic_field7').append('<tr id="row'+i+'"><td><input type="text" name="addition_name[]" placeholder="Enter Addition Name" class="form-control name_list" required="required"/></td><td><input type="text" name="addition_amount[]" placeholder="Enter Addition Amount" class="form-control name_list" required="required"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove7">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove7', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>
 <script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add2').click(function(){  
           i++;  
           $('#dynamic_field2').append('<tr  id="row'+i+'"><td><input type="text" name="deduction_name[]" placeholder="Enter Deduction Name" class="form-control name_list" required="required" /></td><td><input type="text" name="deduction_amount[]" placeholder="Enter Deduction Percent" class="form-control name_list" required="required" /></td>  <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>
 <script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add4').click(function(){  
           i++;  
           $('#dynamic_field4').append('<tr id="row'+i+'"><td><input type="text" name="percent_name[]" placeholder="Enter Deduction Name" class="form-control name_list" /></td><td><input type="text" name="percent_amount[]" placeholder="Enter Deduction Amount/Percent" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>
 <script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add3').click(function(){  
           i++;  
           $('#dynamic_field3').append('<tr id="row'+i+'"><td><input type="text" name="others_name[]" placeholder="Enter Name" class="form-control name_list" /></td><td><input type="text" name="loan_amount[]" placeholder="Enter Loan Amount" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr><tr id="row'+i+'"><td><input type="text" name="loan_deduction_amount[]" placeholder="Enter Deduction Amount" class="form-control name_list" required="required" /></td><td colspan="2"></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>


<script type="text/javascript">
        function getScale() {
    var val = $('#regiono').val();
     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Payroll/GetScale",
     data:'scale_name='+ val,
     success: function(data){
         $("#branchdropo").val(data.trim());
     }
 });
};
</script>



























































<script type="text/javascript">
    $(document).ready(function() {
    $("#checkedAll").change(function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkedAll").prop("checked", true);
            }     
        }
        else {
            $("#checkedAll").prop("checked", false);
        }
    });
});
</script>



                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $(".SalarylistModal").click(function (e) {
                                                e.preventDefault(e);
                                                // Get the record's ID via attribute  
                                                var iid = $(this).attr('data-id');
                                                $('#salaryform').trigger("reset");
                                                $('#Salarymodel').modal('show');
                                                $.ajax({
                                                    url: 'GetSallaryById?id=' + iid,
                                                    method: 'GET',
                                                    data: '',
                                                    dataType: 'json',
                                                }).done(function (response) {
                                                    console.log(response);
                                                    // Populate the form fields with the data returned from server
													$('#salaryform').find('[name="sid"]').val(response.salaryvalue.id).end();
													$('#salaryform').find('[name="aid"]').val(response.salaryvalue.addi_id).end();
													$('#salaryform').find('[name="did"]').val(response.salaryvalue.de_id).end();
                                                   /* $('#salaryform').find('[name="typeid"]').val(response.salaryvalue.type_id).end();*/
                                                    $('#salaryform').find('[name="emid"]').val(response.salaryvalue.emp_id).end();
                                                    $('#salaryform').find('[name="basic"]').val(response.salaryvalue.basic).end();
                                                    $('#salaryform').find('[name="medical"]').val(response.salaryvalue.medical).end();
                                                    $('#salaryform').find('[name="houserent"]').val(response.salaryvalue.house_rent).end();
                                                    $('#salaryform').find('[name="bonus"]').val(response.salaryvalue.bonus).end();
                                                    $('#salaryform').find('[name="provident"]').val(response.salaryvalue.provident_fund).end();
                                                    $('#salaryform').find('[name="bima"]').val(response.salaryvalue.bima).end();
                                                    $('#salaryform').find('[name="tax"]').val(response.salaryvalue.tax).end();
                                                    $('#salaryform').find('[name="others"]').val(response.salaryvalue.others).end();
												});
                                            });
                                        });
                                    </script>                             
<script type="text/javascript">   
$(document).ready(function() {    
/*var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) {
    dd = '0'+dd
} 

if(mm<10) {
    mm = '0'+mm
} 

today = mm + '/' + dd + '/' + yyyy;*/
var d = new Date();
var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
var m = months[d.getMonth()];    
var y = d.getFullYear();    
//document.write(today);    
   var table = $('#example123').DataTable( {
        "aaSorting": [[9,'desc']],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                title: 'Salary List'+'<br>'+ m +' '+ y,
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '50pt' )
                        .prepend(
                            '<img src="<?php echo base_url()?>assets/images/dRi_watermark.png" style="position:absolute;background-size:300px 300px; top:35%; left:27%;" />'
                        );
                    $(win.document.body)
                        //.css( 'border', 'inherit' )
                        .prepend(
                            '<footer class="footer" style="border:inherit"><img src="<?php echo base_url();?>assets/images/signature_vice.png" style="position:absolute; top:0; left:0;" /><img src="<?php echo base_url();?>assets/images/signature_ceo.png" style="position:absolute; top:0; right:0;height:30px;" /></footer>'
                        );
                    $(win.document.body).find( 'h1' )
                        .addClass( 'header' )
                        .css( 'display', 'inharit' )
                        .css( 'position', 'relative' )
                        .css( 'float', 'right' )
                        .css( 'font-size', '24px' )
                        .css( 'font-weight', '700' )
                        .css( 'margin-right', '15px' );
                    $(win.document.body).find( 'div' )
                        .addClass( 'header-top' )
                        .css( 'background-position', 'left top' )
                        .css( 'height', '100px' )
                        .prepend(
                            '<img src="<?php echo base_url()?>assets/images/dri_Logo.png" style="position:absolute;background-size:30%; top:0; left:0;" />'
                        );
                    $(win.document.body).find( 'div img' )
                        .addClass( 'header-img' )
                        .css( 'width', '300px' );
                    $(win.document.body).find( 'h1' )
                        .addClass( 'header' )
                        .css( 'font-size', '25px' );

                    $(win.document.body).find( 'table thead' )
                        .addClass( 'compact' )
                        .css( {
                            color: '#000',
                            margin: '20px',
                            background: '#e8e8e8',

                        });
 
                    $(win.document.body).find( 'table thead th' )
                        .addClass( 'compact' )
                        .css( {
                            color: '#000',
                            border: '1px solid #000',
                            padding: '15px 12px',
                            width: '8%'
                        });
 
                    $(win.document.body).find( 'table tr td' )
                        .addClass( 'compact' )
                        .css( {
                            color: '#000',
                            margin: '20px',
                            border: '1px solid #000'

                        });
 
                    $(win.document.body).find( 'table thead th:nth-child(3)' )
                        .addClass( 'compact' )
                        .css( {
                            width: '15%',
                        });
 
                    $(win.document.body).find( 'table thead th:nth-child(1)' )
                        .addClass( 'compact' )
                        .css( {
                            width: '1%',
                        });
 
                    $(win.document.body).find( 'table thead th:nth-child(2)' )
                        .addClass( 'compact' )
                        .css( {
                            width: '5%',
                        });
 
                    $(win.document.body).find( 'table thead th:last-child' )
                        .addClass( 'compact' )
                        .css( {
                            display: 'none',

                        });
 
                    $(win.document.body).find( 'table tr td:last-child' )
                        .addClass( 'compact' )
                        .css( {
                            display: 'none',

                        });
                }
            }
        ]
    } );
/*$("#example123 tfoot th").each( function ( i ) {
		
		if ($(this).text() !== '') {
	        var isStatusColumn = (($(this).text() == 'Status') ? true : false);
			var select = $('<select><option value=""></option></select>')
	            .appendTo( $(this).empty() )
	            .on( 'change', function () {
	                var val = $(this).val();
					
	                table.column( i )
	                    .search( val ? '^'+$(this).val()+'$' : val, true, false )
	                    .draw();
	            } );
	 		
			// Get the Status values a specific way since the status is a anchor/image
			if (isStatusColumn) {
				var statusItems = [];
				
                /* ### IS THERE A BETTER/SIMPLER WAY TO GET A UNIQUE ARRAY OF <TD> data-filter ATTRIBUTES? ### 
				table.column( i ).nodes().to$().each( function(d, j){
					var thisStatus = $(j).attr("data-filter");
					if($.inArray(thisStatus, statusItems) === -1) statusItems.push(thisStatus);
				} );
				
				statusItems.sort();
								
				$.each( statusItems, function(i, item){
				    select.append( '<option value="'+item+'">'+item+'</option>' );
				});

			}
            // All other non-Status columns (like the example)
			else {
				table.column( i ).data().unique().sort().each( function ( d, j ) {  
					select.append( '<option value="'+d+'">'+d+'</option>' );
		        } );	
			}
	        
		}
    } );*/
  
} );
</script>
<?php $this->load->view('backend/footer'); ?>
<script>
    $('#salary123').DataTable({
        "aaSorting": [[10,'desc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
