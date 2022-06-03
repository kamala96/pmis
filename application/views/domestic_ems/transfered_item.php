<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
  <div class="message"></div>
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i>&nbsp
        <?php
        $id = $this->session->userdata('user_login_id');
        $basicinfo = $this->employee_model->GetBasic($id);
                        //     if (!empty($id)) {
                        //         echo $basicinfo->em_role;
                        //        } ?>
                      Transfered Item List </h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">

                        Transfered Item List </li>
                      </ol>
                    </div>
                  </div>
                  <!-- Container fluid  -->
                  <!-- ============================================================== -->
                  <div class="container-fluid">
                   
				 <div class="row m-b-10">
                <div class="col-12">   
                      <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Ems_Domestic/document_parcel" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Transaction</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_Application_List" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Transactions List</a></button>
                      <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list?AskFor=Ems" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Bill Transactions</a></button>
                    <!--  <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Box_Application/Credit_Customer" class="text-white"><i class="" aria-hidden="true"></i> Create Bill Customer</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_BackOffice" class="text-white"><i class="" aria-hidden="true"></i> Ems Back Office List</a></button> -->
                     <!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Ems_Domestic/Incoming_Item" class="text-white"><i class="" aria-hidden="true"></i> Incoming Item</a></button> -->
                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Ems_Domestic/bulk_document_parcel" class="text-white"><i class="" aria-hidden="true"></i> Bulk <?php echo $this->session->userdata('heading') ?> Transaction </a></button>
					  <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Ems_Domestic/transfered_item_list" class="text-white"><i class="" aria-hidden="true"></i> Transfered Item List </a></button>
                </div>
               </div>  
                
				

                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">
                          <?php $regionlist = $this->employee_model->regselect(); ?>
                     
                        <hr/>
                        <div class="row">
                        <div class="col-md-12">
                                <table class="table table-bordered" style="width: 100%;">
                                    <tr>
                                        <th style="">
                                         <form action="" method="get">
                                         <div class="input-group">
                                            <input type="date" name="fromdate" class="form-control">
											                      <input type="date" name="todate" class="form-control">
                                            <input type="submit" name="search" class="btn btn-success" value="Search Date" required="required">
                                        </div>
                                        </form>
                                    </th>
                                   </tr>
                        </table>
                       </div>
                </div>

          <?php if(isset($_GET['search'])){
		    $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
			$todate = date("Y-m-d",strtotime($_GET['todate']));
		    $list = $this->Box_Application_model->transfered_item_list($fromdate,$todate);	
            if($list)
            {				
		  ?>
		               <button class="btn btn-info" onclick="printContent('div1')"><i class="fa fa-print"></i> Print </button> 
                      <br>
					       <div id="div1">
                            <div class="table-responsive">
                            <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
							  <tr>
                          <th colspan="5">
                         <img src="<?php echo base_url(); ?>assets/images/tcp.png" height="100px" width="200px" style="display: block; margin-left: auto; margin-right: auto;"/>
                           <center>TANZANIA POSTS CORPORATION <br>
                          Transfered Item List
                          </center>
                          </th>
                          </tr>
						  <tr>
                          <th colspan="5">
                          Transfered Item On: <?php echo date("d-m-Y",strtotime($fromdate)).' - '.date("d-m-Y",strtotime($todate)); ?>
						  <hr>
                          </th>
                          </tr>
                             <tr>
                              <th> S/No </th>
							                <th> Track Number </th>
                              <th> Barcode Number </th>
                              <th> Item Type </th>
                              <th> Transfered  By </th>
                              <th> Received By </th>
                             </tr>
                             </thead>

                          <tbody class="results">
                           <?php  
						   $sn =1;
						   foreach($list as $value){?>
                             <tr>
                               <td> <?php echo $sn; ?>   </td>
                               <td>  <?php echo $value->track_number; ?>  </td>
                               <td>  <?php echo $value->Barcode; ?>  </td>
                               <td>  <?php echo $value->ems_type; ?>   </td>
                               <td> 
							   <?php 
							   $senderid = $value->operator; 
							   //Check sender info
							   $senderinfo = $this->Box_Application_model->check_sender($senderid);
                               $sendername = $senderinfo['em_code'].': '.$senderinfo['first_name'].' '.$senderinfo['last_name'];
                               echo $sendername;						   
							   ?> 
							   </td>   
                <td> 
							   <?php 
							    $receiverid = $value->item_received_by;
							   //Check Receiver info
                  $receiverinfo = $this->Box_Application_model->check_sender($receiverid);
                  $receivername = $receiverinfo['em_code'].': '.$receiverinfo['first_name'].' '.$receiverinfo['last_name'];
								  echo $receivername;
							   ?>
							   </td>							   
                            </tr>
						   <?php $sn++; } ?>
                       </tbody>
                        </table>
        </div>
		</div>
      <?php 
	  }
	  else
	  {
	  echo "Results Not found";  
	  }
	  } 
	  ?>
                      </div>
                      </div>
                      </div>

                            </div>
                            <!-- ============================================================== -->
                          </div>

                          <script type="text/javascript">
                                  function getRecDistrict() {
                              var val = $('#rec_region').val();
                               $.ajax({
                               type: "POST",
                               url: "<?php echo base_url();?>Employee/GetBranch",
                               data:'region_id='+ val,
                               success: function(data){
                                   $("#rec_dropp1").html(data);
                               }
                           });
                          };
                          </script>
<script type="text/javascript">
$(document).ready(function() {
 // $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
    $('#example4 thead tr:eq(1) th').not(":eq(8),:eq(7)").each( function (i) {
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
        //orderCellsTop: true,
        fixedHeader: true,
        ordering:false,
        order: [[1,"desc" ]],
        lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
        dom: 'lBfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      } );
  } );
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#checkAll").change(function() {
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
          $("#checkAll").prop("checked", true);
        }
      }
      else {
        $("#checkAll").prop("checked", false);
      }
    });
  });
</script>

<script type="text/javascript">
function printContent(el)
{
  var restorepage = document.body.innerHTML;
  var printcontent = document.getElementById(el).innerHTML;
  document.body.innerHTML = printcontent;
  window.print();
  document.body.innerHTML = restorepage;
}
</script>

<?php $this->load->view('backend/footer'); ?>
