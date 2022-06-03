<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 

         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Collection Report  </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Reports </li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">

                    <div class="col-12">

                    <div class="card card-outline-info">
                   
                            
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
                       
               
                                <div class="row">
                                    <div class="form-group col-md-3 m-t-10">
                                    <input type="text" name="fromdate" class="form-control mydatetimepickerFull fromdate" placeholder="From Date" required="required">
                                    </div>
                                    
                                    <div class="form-group col-md-3 m-t-10">
                                         <input type="text" name="todate" class="form-control mydatetimepickerFull todate" placeholder="To Date" required="required">
                                    </div>

                                     <!--  <div class="form-group col-md-3 m-t-10">
                                         <input type="text" name="test" class="form-control  test">
                                    </div>
 -->

                                     <?php if($this->session->userdata('user_type') == "SUPER ADMIN" || $this->session->userdata('user_type') == "BOP" || $this->session->userdata('user_type') == "CRM" || $this->session->userdata('user_type') == "ACCOUNTANT-HQ" ){ ?>
                                         <div class="form-group col-md-3 m-t-10">
                                          <select class="form-control custom-select region" name="region">
                                            <option value="">--Select Region-</option>
                                            <option>ALL</option>
                                            <?php foreach ($region as $value) { ?>
                                                 
                                              <option><?php echo $value->region_name ?></option>
                                            <?php } ?>
                                          </select>
                                      </div>
                                        <?php }?>




                                    <div class="form-group col-md-3 m-t-10">
                                         <button type="submit" class="btn btn-info Search" id="Search"> <i class="fa fa-search"></i> Search </button>
                                          <h3 id="loadingtext" style="color: red;"></h3>
                                    </div>
                            </div>

                         <button class="btn btn-info" onclick="printContent('div1')"><i class="fa fa-print"></i> Print</button>
 <div class="table-responsive" id="div1">

<div class="panel-footer text-center">
<img src="<?php echo base_url(); ?>assets/images/tcp.png" height="100px" width="200px"/>
<br>
<h3> <strong> COLLECTION TRANSACTION SUMMARY </strong> </h3>
</div>


<div class="update">

</div>
</div>



                                       
                                           
                                        
                                            
                            
                               
                            </div>
                        </div>
                    </div>
                </div>

                <script type="text/javascript">
                   $('#Search').on('click',function(){

                      $('#loadingtext').html('Please wait............');

                    var fromdate = $('.fromdate').val();
                    var todate = $('.todate').val();
                    var region = $('.region').val();

                    // $('.test').val('yes');
                    
                      $.ajax({
                     
                      url: "<?php echo base_url();?>Reports/Collection_Search_Reports",
                      method:"POST",
                      data:{fromdate:fromdate,todate:todate,region:region},
                      success: function(data){
                        $('#loadingtext').hide();
                          $(".update").html(data);


                      }
                  });


                });

                </script>
<script type="text/javascript">
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
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