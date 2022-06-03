<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
         <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Payroll</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-university" aria-hidden="true"></i> Payroll</li>
                    </ol>
                </div>
            </div>
            
            <div class="container-fluid"> 
                <div class="row m-b-10"> 
                    <div class="col-12">
<!--                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#TypeModal" data-whatever="@getbootstrap" class="text-white TypeModal"><i class="" aria-hidden="true"></i> Add Payroll </a></button>-->
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Payroll/Generate_salary" class="text-white"><i class="" aria-hidden="true"></i>  Generate Payroll</a></button>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-12">

                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Payslip Form                     
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="">
                   
                                    <div class="row" style="">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
            <form action="<?php echo base_url() ?>payroll/pay_salary" method="post" class="" name="form1">
                                                
                                            <table style="width: 80%;">
                                        <thead>
                                            <tr><th><b>PF Number</b></th><th><b>Full Names</b></th><th><b>Salary Scale</b></th></tr>
                                        </thead>
                                    <tbody>
                                        <tr><td><?php echo $salary_info->em_code  ?></td><td><?php echo $salary_info->first_name.'  '.$salary_info->middle_name.'  '.$salary_info->last_name?></td><td><?php echo $salary_info->type_id; ?></td></tr>
                                    </tbody>
                                    </table>
                                        </div>
                                        <div class="col-md-2"></div>
                                        
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row" style="">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                   
                            <table style="width: 80%;">
                                        <thead>
                                            <tr><th><b>Description</b></th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th><b>Amount</b></th></tr>
                                        </thead>
                                    <tbody>
                                        <tr><td colspan="3"></td></tr>

                                        <?php if(!empty($salary_info->total))
                                        {
                                        ?>
                                        <tr><td>Basic Salary</td><td></td><td><input type="text" name="basic_total" value="<?php echo $salary_info->total?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <tr><td colspan="3"></td></tr>
                                        <tr><td colspan="3"></td></tr>
                                        <tr><td colspan="3"></td></tr>
                                        <tr><th colspan="3"><b>Addition to salary</b></th></tr>
                                        <?php if(!empty($salary_info->house_allowance))
                                        {
                                        ?>
                                        <tr><td>House Allowance</td><td></td><td><input type="text" name="house_total" value="<?php echo $salary_info->house_allowance?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->fuel_allowance))
                                        {
                                        ?>
                                        <tr><td>Fuel Allowance</td><td></td><td><input type="text" name="fuel_total" value="<?php echo $salary_info->fuel_allowance?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->transport_allowance))
                                        {
                                        ?>
                                        <tr><td>Transport Allowance</td><td></td><td><input type="text" name="transport_total" value="<?php echo $salary_info->transport_allowance?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->overtime))
                                        {
                                        ?>
                                        <tr><td>Overtime Allowance</td><td></td><td><input type="text" name="overtime_total" value="<?php echo $salary_info->overtime?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->acting_allowance))
                                        {
                                        ?>
                                        <tr><td>Acting Allowance</td><td></td><td><input type="text" name="acting_total" value="<?php echo $salary_info->acting_allowance?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->telephone_allowance))
                                        {
                                        ?>
                                        <tr><td>Telphone Allowance</td><td></td><td><input type="text" name="telephone_total" value="<?php echo $salary_info->telephone_allowance?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <tr><td colspan="3"></td></tr>
                                        <tr><td colspan="3"></td></tr>
                                        <tr><td colspan="3"></td></tr>
                                        <tr><th colspan="3"><b>Deduction to salary</b></th></tr>
                                        <?php if(!empty($salary_info->wadu))
                                        {
                                        ?>
                                        <tr><td>W.A.D.U</td><td></td><td><input type="text" name="wadu_total" value="<?php echo ($salary_info->wadu* $salary_info->total)?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->nssf))
                                        {
                                        ?>
                                        <tr><td>NSSF</td><td></td><td><input type="text" name="nssf_total" value="<?php echo ($salary_info->nssf* $salary_info->total)?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->psssf))
                                        {
                                        ?>
                                        <tr><td>PSSSF</td><td></td><td><input type="text" name="psssf_total" value="<?php echo ($salary_info->psssf* $salary_info->total)?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->nhif))
                                        {
                                        ?>
                                        <tr><td>NHIF</td><td></td><td><input type="text" name="nhif_total" value="<?php echo ($salary_info->nhif* $salary_info->total)?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->workers_union))
                                        {
                                        ?>
                                        <tr><td>Workers Union</td><td></td><td><input type="text" name="workers_total" value="<?php echo ($salary_info->workers_union* $salary_info->total)?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->thb))
                                        {
                                        ?>
                                        <tr><td>T.H.B</td><td></td><td><input type="text" name="thb_total" value="<?php echo ($salary_info->thb* $salary_info->total)?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->postasaccoss))
                                        {
                                        ?>
                                        <tr><td>Posta Saccoss</td><td></td><td><input type="text" name="postasaccos_total" value="<?php echo ($salary_info->postasaccoss* $salary_info->total)?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->court))
                                        {
                                        ?>
                                        <tr><td>Court Attatchment</td><td></td><td><input type="text" name="court_total" value="<?php echo ($salary_info->court* $salary_info->total)?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->paye))
                                        {
                                        ?>
                                        <tr><td>P.A.Y.E</td><td></td><td><input type="text" name="paye_total" value="<?php echo ($salary_info->paye * $salary_info->total) ?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->imprest_recovery))
                                        {
                                        ?>
                                        <tr><td>Imprest Recover</td><td></td><td><input type="text" name="imprest_total" value="<?php echo ($salary_info->imprest_recovery* $salary_info->total)?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->insuarance_premium))
                                        {
                                        ?>
                                        <tr><td>Insuarance Premium</td><td></td><td><input type="text" name="insuarance_total" value="<?php echo ($salary_info->insuarance_premium * $salary_info->total)?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <?php if(!empty($salary_info->salary_control))
                                        {
                                        ?>
                                        <tr><td>Salary Control</td><td></td><td><input type="text" name="salary_control" value="<?php echo ($salary_info->salary_control * $salary_info->total)?>" class="" readonly></td></tr>
                                        <?php
                                        }
                                        ?>
                                        <tr><td colspan="3"></td></tr>
                                        <tr><td colspan="3"></td></tr>
                                        <tr><td colspan="3"></td></tr>
                                        <tr><th colspan="3"><b>Others Deduction</b></th></tr>
                                         <?php foreach($othersDeductions as $value): ?>

                                            <tr>
                                                <td><?php echo $value->other_names; ?></td>
                                               <td><input type="text" name="installamount" value="<?php echo $value->installment_Amount?>" class="" readonly></td>
                                               <td><input type="text" name="others_amount" value="<?php echo $value->others_amount?>" class="" readonly></td>
                                            </tr>
                                             <?php endforeach; ?>
                                        
                                       <!-- <?php foreach($othersDeductions as $value): ?>
                                          <tr><td>
                                              <?
                                          echo $value->name;  ?>
                                          </td><td></td></tr>
                                        <?php endforeach; ?> -->
                                         <?php
                                         // foreach ($othersDeductions as $key => $value) {
                                         //     # code...
                                         //    echo $value->amou;
                                         // }
                                         
                                        ?>
                                         
                                    </tbody>
                                    </table>

                                    <input type="hidden" name="emp_code" value="<?php echo $salary_info->em_code?>">
                                    <input type="hidden" name="others_id" value="<?php echo $salary_info->others_id?>">
                                    <input type="hidden" name="em_id" value="<?php echo $salary_info->em_id?>">
                                    <input type="hidden" name="salary_scale" value="<?php echo $salary_info->type_id?>">
                                    <input type="hidden" name="salary_id" value="<?php echo $salary_info->salary_id?>">
                                   <button type="submit"> Create Salary</button>
    </form>
                                    
                                        </div>
                                        <div class="col-md-2"></div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        <div class="modal fade" id="Salarymodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel1">Salary Form</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form method="post" action="Add_Salary" id="salaryform" enctype="multipart/form-data">
                                    <div class="modal-body">
<!--			                                    <div class="form-group">
			                                     <label>Salary Type</label>
                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="typeid" required>
                                                    <?php #foreach($typevalue as $value): ?>
                                                    <option value="<?php #echo $value->id ?>"><?php #echo $value->salary_type; ?></option>
                                                    <?php #endforeach; ?>
                                                </select>
			                                    </div> -->                                        
                                            <div class="form-group">
                                                <label class="control-label">Employee Id</label>
                                                <input type="text" name="emid" class="form-control" id="recipient-name1" value="" readonly>
                                            </div>                                         
                                            <div class="form-group">
                                                <label class="control-label">Basic</label>
                                                <input type="text" name="basic" class="form-control" id="recipient-name1" value="">
                                            </div>
                                            <h4>Addition</h4>                                         
                                            <div class="form-group">
                                                <label class="control-label">Medical</label>
                                                <input type="text" name="medical" class="form-control" id="recipient-name1"  value="">
                                            </div>                                         
                                            <div class="form-group">
                                                <label class="control-label">House Rent</label>
                                                <input type="text" name="houserent" class="form-control" id="recipient-name1" value="">
                                            </div>                                         
                                            <div class="form-group">
                                                <label class="control-label">Bonus</label>
                                                <input type="text" name="bonus" class="form-control" id="recipient-name1" value="">
                                            </div>
                                            <h4>Deduction</h4>                                         
                                            <div class="form-group">
                                                <label class="control-label">Provident Fund</label>
                                                <input type="text" name="provident" class="form-control" id="recipient-name1" value="">
                                            </div>                                         
                                            <div class="form-group">
                                                <label class="control-label">Bima</label>
                                                <input type="text" name="bima" class="form-control" id="recipient-name1" value="" >
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Tax</label>
                                                <input type="text" name="tax" class="form-control" id="recipient-name1"  value="">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Others</label>
                                                <input type="text" name="others" class="form-control" id="recipient-name1"  value="">
                                            </div>                                          
                                         <input type="checkbox" name="checkedAll" id="checkedAll" />

<input type="checkbox" name="checkAll" class="checkSingle" />
<input type="checkbox" name="checkAll" class="checkSingle" />
<input type="checkbox" name="checkAll" class="checkSingle" />
                                    </div>
                                    <div class="modal-footer">                                       
                                    <input type="hidden" name="sid" value="" class="form-control" id="recipient-name1">                                       
                                    <input type="hidden" name="aid" value="" class="form-control" id="recipient-name1">                                       
                                    <input type="hidden" name="did" value="" class="form-control" id="recipient-name1">                                       
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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