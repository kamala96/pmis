<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
<style type="text/css">  
table {
    border:solid #000 !important;
    border-width:1px 0 0 1px !important;
}
th, td {
    border:solid #000 !important;
    border-width:0 1px 1px 0 !important;
    padding: 3px !important;
    color: #000 !important;
}

</style>
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> MAILS Invoice Report  </h3>
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
                       
                            <form class="row" method="post" action="<?php echo site_url('E_reports/mails_print_pending_invoice');?>">
                                    <div class="form-group col-md-2 m-t-10">
                                    <input type="date" name="fromdate" class="form-control" required="required">
                                    </div>
                                    
                                    <div class="form-group col-md-2 m-t-10">
                                         <input type="date" name="todate" class="form-control" required="required">
                                    </div>

                                    <div class="form-group col-md-3 m-t-10">
                                    <select class="form-control region" name="region" required>
                                       <?php if ($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPER ADMIN'){ ?>
                                        <option value="all"> --  Select All Regions-- </option>
                                        <?php } ?>
                                        <?php foreach($listregion as $data){ ?>
                                        <option value="<?php echo $data->region_name; ?>"> <?php echo $data->region_name; ?> </option>
                                    <?php } ?>
                                    </select>
                                    </div>

                                    <div class="form-group col-md-3 m-t-10">
                                    <select class="form-control region" name="status" required>
                                        <option value="Notpaid"> NotPaid </option>
                                         <option value="Paid"> Paid </option>
                                    </select>
                                    </div>

                                    <div class="form-group col-md-2 m-t-10">
                                         <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> Search </button>
                                    </div>
                            </form>
                            
                               
                            </div>
                        </div>
                    </div>
                </div>
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