    <p><?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<style>
        .line {
            border-bottom: 3px solid #D93030;
            width: 100%;
        }

        .line-light {
            width: 100%;
            border-bottom: 1px solid #949597;
        }

        .line-end {
            width: 100%;
            border-bottom: 3px solid #f0c29e;
        }

       

        .data .data-box {
            margin-top: 60px;
        }

        .data .data-box .data-separator {
            border-top: 1px solid #949597;
            width: 10%;
        }

        

        .without-margin {
            margin: 0 !important;
        }

        
        .page
        {
            page-break-after: always;
            page-break-inside: avoid;
        }
    </style>

<style type="text/css">
    body {
        color: #404E67;
        background: #F5F7FA;
		font-family: 'Open Sans', sans-serif;
	}
	.table-wrapper {
		width: 700px;
		margin: 30px auto;
        background: #fff;
        padding: 20px;	
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .table-title {
        padding-bottom: 10px;
        margin: 0 0 10px;
    }
    .table-title h2 {
        margin: 6px 0 0;
        font-size: 22px;
    }
    .table-title .add-new {
        float: right;
		height: 30px;
		font-weight: bold;
		font-size: 12px;
		text-shadow: none;
		min-width: 100px;
		border-radius: 50px;
		line-height: 13px;
    }
	.table-title .add-new i {
		margin-right: 4px;
	}
    table.table {
        table-layout: fixed;
    }
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
    }
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }
    table.table th:last-child {
        width: 100px;
    }
    table.table td a {
		cursor: pointer;
        display: inline-block;
        margin: 0 5px;
		min-width: 24px;
    }    
	table.table td a.add {
        color: #27C46B;
    }
    table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #E34724;
    }
    table.table td i {
        font-size: 19px;
    }
	table.table td a.add i {
        font-size: 24px;
    	margin-right: -1px;
        position: relative;
        top: 3px;
    }    
    table.table .form-control {
        height: 32px;
        line-height: 32px;
        box-shadow: none;
        border-radius: 2px;
    }
	table.table .form-control.error {
		border-color: #f50000;
	}
	table.table td .add {
		display: none;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	var actions = $("table td:last-child").html();
	// Append table with add row form on add new button click
    $(".add-new").click(function(){
		$(this).attr("disabled", "disabled");
		var index = $("table tbody tr:last-child").index();


       

        var row = '<tr>' +
            '<td><select name="format" class="form-control">'+
      '<option selected disabled>Select Stock </option>'+
      '<option value="pdf">Posta stamp</option>'+
      '<option value="txt">Cash</option>'+
     
      '</select></td>' +
            '<td style="text-align:center;"><text  >5</text></td>' +
            '<td><input type="number" class="form-control" name="phone" id="phone"></td>' +
            '<td style="text-align:center;"><text class="">500</text></td>' +
            '<td style="text-align:center;"><text class="">00</text></td>' +
			'<td>' + actions + '</td>' +
        '</tr>';
    	$("table").append(row);		
		$("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
        $('[data-toggle="tooltip"]').tooltip();
    });
	// Add row on add button click
	$(document).on("click", ".add", function(){
		var empty = false;
		var input = $(this).parents("tr").find('input[type="text"]');
        input.each(function(){
			if(!$(this).val()){
				$(this).addClass("error");
				empty = true;
			} else{
                $(this).removeClass("error");
            }
		});
		$(this).parents("tr").find(".error").first().focus();
		if(!empty){
			input.each(function(){
				$(this).parent("td").html($(this).val());
			});			
			$(this).parents("tr").find(".add, .edit").toggle();
			$(".add-new").removeAttr("disabled");
		}		
    });
	// Edit row on edit button click
	$(document).on("click", ".edit", function(){		
        $(this).parents("tr").find("td:not(:last-child)").each(function(){
			$(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
		});		
		$(this).parents("tr").find(".add, .edit").toggle();
		$(".add-new").attr("disabled", "disabled");
    });
	// Delete row on delete button click
	$(document).on("click", ".delete", function(){
        $(this).parents("tr").remove();
		$(".add-new").removeAttr("disabled");
    });
});
</script>
   

    <div class="page-wrapper">
      
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Branch</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Branch</li>
                </ol>
            </div>
        </div>
        <div class="message">
            
        </div>
        <?php $degvalue = $this->employee_model->getdesignation(); ?>
        <?php $depvalue = $this->employee_model->getdepartment(); ?>
        <?php $usertype = $this->employee_model->getusertype(); ?>
        <?php  ?>
        <?php $regvalue1 = $this->employee_model->branchselect(); ?>
        <div class="container-fluid">
            <div class="row m-b-10"> 
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Stock/StockRequest" class="text-white"><i class="" aria-hidden="true"></i>  Back Request List</a></button>

                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i> Branch Request<span class="pull-right " ></span></h4>
                        </div>
                        <?php echo validation_errors(); ?>
                        <?php echo $this->upload->display_errors(); ?>

                        <?php echo $this->session->flashdata('formdata'); ?>
                        <?php echo $this->session->flashdata('feedback'); ?>
                        <div class="card-body">
                  
    
    <div id="app" class="container invoice">
        <div class="row">
           
            <!-- content -->
            <div class="col-12 content py-4">
                <div class="line mt-4 mb-4"></div>
                <!-- header -->
                <div class="header">
                 
                <div align="left" style="font-size:0px;word-break:break-word;float:left;">
                                                       <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:;line-height:22px;text-align:left;color:#525252; ">SN.000</div>
                                                   </div>
                                            <div align="center" style="font-size:0px;word-break:break-word;">

                                                 <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:bold;line-height:22px;text-align:center;">
                                                        TANZANIA POSTS CORPORATION
                                                </div>
                                                    <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:bold;line-height:22px;text-align:center;">
                                                       REQUISITION FOR STAMP, ETC.
                                                   </div>
                                                   <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:bold;line-height:22px;text-align:center;">
                                                    INDENTING OFFICE
                                                </div>

                                            </div>

                                                <div align="right" style="font-size:0px;word-break:break-word;float:right;">
                                                       <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:;line-height:22px;text-align:left;color:#525252; "> P93</div>
                                                   </div>

                     <br/>
                      <br/>
                    <div class="row">
                    <div class="col-md-3" style="float:left;">
                                <div class="field">
                                    <input type="text" class="input-label form-control" name="S" value="To" />
                                </div>
                                <div class="value">
                                    <textarea class="form-control" placeholder="Who is this invoice from?" name="from"></textarea>
                                </div>
                     </div>

                     <div class="col-md-6">
                     </div>
                       
                   <div class="col-md-3" style="float:right;">
                                <div class="field">
                                    <input type="text" class="input-label form-control" name="from_title" value="From" />
                                </div>
                                <div class="value">
                                    <textarea class="form-control" placeholder="Who is this invoice from?" name="from"></textarea>
                                </div>
                    </div>
                      
                    </div>
                </div>
                <!-- end header -->

                <!-- note -->
                <!-- <div class="row my-4">
                    <div class="col-md-12">
                                    <text>Signature of identity Officer &nbsp;
                                        <input type="text" name="exp_sum" class="col-md-5" style="border-top: 0px;border-left: 0px;border-right: 0px;" required>
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Date &nbsp;<input type="Date" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  " required><br><br>
                                        
                                    </text>
                                </div>
                     <div class="col-md-12">
                                    <text>Signature of Approving Officer &nbsp;
                                        <input type="text" name="exp_sum" class="col-md-5" style="border-top: 0px;border-left: 0px;border-right: 0px;" required>
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Date &nbsp;<input type="Date" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px; " required><br><br>
                                        
                                    </text>
                                </div>
                </div> -->
                <!-- end note -->

<br />
                <div class="content">
        <div class="">
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="text-align:center;">Description of Stock</th>
                        <th style="text-align:center;">Rate</th>
                        <th style="text-align:center;">Quantity</th>
                        <th style="text-align:center;">Shs</th>
                        <th style="text-align:center;">Cts</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <tr class="hidden">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
							<a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                            <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                            <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                        </td>
                    </tr>
                   
                  
                </tbody>
            </table>
        </div>
        <div class="">
                <div class="row">
                 
                    <div class="col-md-2" style="float:left;">
                        <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</button>
                    </div>
                </div>
            </div>


    </div> 
               

                      
                      

<div class="row my-4">
                    <div class="col-md-12">
                                    <text>Issued by &nbsp;
                                        <input type="text" name="exp_sum" class="col-md-4" style="border-top: 0px;border-left: 0px;border-right: 0px;" required>
                                       
                                         Checked by &nbsp;<input type="text" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px; " required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Date &nbsp;<input type="Date" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px; " required><br><br>
                                        
                                    </text>
                                </div>
                                
                     <div class="col-md-12">
                                    <text>Received and taken on charge items detailied above to the value of Shs &nbsp;
                                        <input type="number" name="exp_sum" class="" style="border-top: 0px;border-left: 0px;border-right: 0px;" required>
                                        
                                        Cts &nbsp;<input type="number" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  " required><br><br>
                                        
                                    </text>
                    </div>


                    <div class="col-md-12">
                                    <text>as per attached "Details of Temittance" Active AC 184 No&nbsp;
                                        <input type="text" name="exp_sum" class="col-md-4" style="border-top: 0px;border-left: 0px;border-right: 0px;" required>
                                        
                                       
                                        <br><br>
                                    </text>
                    </div>

                    <!-- <div class="col-md-12">
                                    <text>Signature of Receiving Officer &nbsp;
                                        <input type="text" name="exp_sum" class="col-md-4" style="border-top: 0px;border-left: 0px;border-right: 0px;" required>
                                        
                                        Date &nbsp;<input type="Date" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px; " required><br><br>
                                        
                                    </text>
                    </div> -->
                </div>




                <div class="">
                <div class="row">
                <div class="col-sm-10"></div>
                    <div class="col-md-2" style="float:right;">
                        <button type="button" class="btn btn-info add-new"><i class="fa fa-menu"></i> Send For Approval </button>
                    </div>
                </div>
            </div>




             
            </div>
            <!-- end content -->
        </div>
    </div>

   
                        <!-- mwisho wa -->


                        </div>
                     </div>

                </div>
            </div> 
         </div>
                          
    </div>




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

    <script>
        $( "#target" ).keyup(function() {
      //alert( "Handler for .keyup() called." );
    });
    </script>

    <?php $this->load->view('backend/footer'); ?>

    </p>