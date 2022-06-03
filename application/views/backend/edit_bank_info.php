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
                        <li class="breadcrumb-item active"><i class="fa fa-university" aria-hidden="true"></i> Bank Info Edit</li>
                    </ol>
                </div>
            </div>
            
            <div class="container-fluid"> 
                <div class="row m-b-10"> 
                    <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="" class="text-white"><i class="" aria-hidden="true"></i>  Bank Info Edit</a></button>
                </div>
                </div> 
                <div class="row">
                    <div class="col-12">

                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Bank Info Edit                     
                                </h4>
                                
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                   
                                <div class="tab-pane" id="bank" role="tabpanel">
                                 <div class="card">
                                    <div class="card-body">
                                        <form class="row" action="Add_bank_info" method="post" enctype="multipart/form-data">
                                            <div class="form-group col-md-6 m-t-5">
                                                <label> Bank Holder Name</label>
                                                <input type="text" name="holder_name" value="<?php if(!empty($bankinfo->holder_name)) echo $bankinfo->holder_name  ?>" class="form-control form-control-line" placeholder="Bank Holder Name" minlength="" required> 
                                            </div>
                                            <div class="form-group col-md-6 m-t-5">
                                                <label>Bank Name</label>
                                                <select class="custom-select form-control" name="bank_name" required="required" id="bank_name">
                                                
                                                    <!-- <option><?php echo $bankinfo->bank_name; ?></option> -->
                                                  <option value="">--Select Bank Name--</option>
                                                
                                                <option>CRDB</option>
                                                <option>NBC</option>
                                                <option>DCB</option>
                                                <option>BARCLAYS</option>
                                                <option>NMB</option>
                                                <option>TPB</option>
                                                <option>AKIBA</option>
                                                <option>PBZ</option>
                                                <option>EXIM</option>
                                                <option>BOA</option>
                                                <option>UCHUMI BANK</option>
                                                <option>AMANA BANK</option>
                                                <option>STANBIC BANK</option>
                                                <option>EQUITY BANK</option>
                                                <option>STANDARD CHARTER</option>

                                    </select>
                                            </div>
                                            
                                            <div class="form-group col-md-6 m-t-5">
                                                <label>Bank Account Number</label>
                                                <input type="text" name="account_number" value="<?php if(!empty($bankinfo->account_number)) echo $bankinfo->account_number ?>" class="form-control form-control-line" minlength="5" required> 
                                            </div>
                                            <div class="form-group col-md-6 m-t-5">
                                                <label>Bank Code</label>
                                                <input type="text" name="bank_code" value="<?php if(!empty($bankinfo->bank_code)) echo $bankinfo->bank_code ?>" class="form-control form-control-line" placeholder="Bank Code"> 
                                            </div>
                                            <div class="form-actions col-md-12">
                                                <input type="hidden" name="emid" value="<?php echo @$basic->em_id; ?>">
                                                <input type="hidden" name="id" value="<?php if(!empty($bankinfo->id)) echo $bankinfo->id  ?>">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save Info</button>
                                            </div>
                                        </form>

 





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
<script>
$(document).ready(function() {

    $(".BtnDay").on("click", function(event) {
        
     event.preventDefault();

     var em_id = $('.sid').val();

    
     console.log(em_id);

                $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>employee/delete_salary",
                 data:'em_id='+ em_id ,
                 success: function(response) {
                    alert(response);
                    //$('.results').html(response);
                    }
                });
   });
});
</script>                                    
<script type="text/javascript">   
$(document).ready(function() {    
   
   var table = $('#example123').DataTable( {
         "ordering": false,
        "aaSorting": [[9,'desc']],
        dom: 'Bfrtip',
         buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );

} );
</script>

<script type="text/javascript">
    $(document).ready(function() {

    var table = $('#example4').DataTable( {
         ordering: false,
        orderCellsTop: false,
        fixedHeader: true,
        "aaSorting": [[0,'asc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
<?php $this->load->view('backend/footer'); ?>