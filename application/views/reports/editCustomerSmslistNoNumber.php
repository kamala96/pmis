<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>  Customers  List Without Mobile</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Customers List Without Mobile</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
              <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>reports/oldboxnotfy" class="text-white"><i class="" aria-hidden="true"></i>Sms Dashboard </a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>reports/SmsCustomers" class="text-white"><i class="" aria-hidden="true"></i> Customers List With Mobile</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>reports/SmsCustomersWithoutNUmber" class="text-white"><i class="" aria-hidden="true"></i> Customers List  Without Mobile</a></button>
                </div>
        </div>

            <div class="row">
              <div class="col-md-12">
                <?php if(!empty($this ->session->flashdata('message'))){ ?>
                  <div class="alert alert-success alert-dismissible">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong> <?php echo $this ->session->userdata('message'); ?></strong> 
                </div>
                <?php }else{?>
                  
                <?php }?>
                
               
              </div>
            </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Customers List Without Mobile (<?php echo $customerlistcount[0]->idadi; ?>)
                        </h4>
                    </div>
                    <div class="card-body" >
                     
                      <br />
                    
                           <form method="POST" action="<?php echo base_url()?>Reports/Save_Edit_SmsCustomersWithoutNUmber">
                               <div id="div1">
                                <div class="row">

                                <div class="col-md-12">
                                   <!--  <h3> Internet Form</h3> -->
                                </div>

                                 
                                   <div class="col-md-6">
                                <label>PostBoxNumber :</label>
                            <input type="text" name="PostBoxNumber" class="form-control" value="<?php echo $customer->PostBoxNumber ; ?>" id="PostBoxNumber" >
                               
                                </div> 


                                 <div class="col-md-6">
                                    <label>Mobile Number</label>
                                    <input type="mobile" name="MobileNumber" value="<?php echo $customer->MobileNumber ; ?>" id="MobileNumber" class="form-control" required="required">
                                   
                                </div>

                                <div class="form-group col-md-6">
                                    <input type="hidden" name="id" class="form-control" value="<?php echo $customer->id; ?>">
                                  </div>

                                </div>
                                <br>
                              
                              
                                
                                </div>


                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-info disable">Save Information</button>
                                    </div>
                                </div>
                                </div>
                           </form>
                       
                        </div>
                    </div>

                </div>

            </div>
        </div>

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

<?php $this->load->view('backend/footer'); ?>
