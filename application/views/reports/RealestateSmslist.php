<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>  Realestate Sms  List </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Realestate Sms List</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
              <div class="col-12">
                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>reports/oldboxnotfy" class="text-white"><i class="" aria-hidden="true"></i>Sms Dashboard </a></button>
                   <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>reports/RealestateSmslist" class="text-white"><i class="" aria-hidden="true"></i>Realestate Sms list </a></button>
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
                        <h4 class="m-b-0 text-white"> Realestate Sms List  (<?php echo $customerlistcount[0]->idadi; ?>)
                        </h4>
                    </div>
                    <div class="card-body" >
                     
                      <br />
                    
                      
                        <div class="table table-responsive">
                           <table class="table table-bordered International text-nowrap" width="100%" style="text-transform: capitalize;">
                               <thead>
                                
                                 <th>Customer Mobile</th>
                                 <th>Service Type</th>
                                   <th>Sms Status</th>
                                  <!--  <th>Action</th> -->
                                   
                                  
                               </thead>
                               <tbody>
                                   <?php foreach ($customerlist as $value) { ?>
                                       <tr>
                                           
                                           <td><?php echo $value->MobileNumber; ?></td>
                                           
                                           <td><?php echo $value->servicename; ?></td>
                                          
                                           <td><?php if($value->status == 'issent'){?>
                                                <button class="btn btn-success btn-sm" disabled="disabled">SENT</button>
                                               <?php }else{?>
                                                <button class="btn btn-danger btn-sm" disabled="disabled">NOT SENT</button>
                                               <?php } ?>
                                           </td>
                                            <!--  <td>
                                             <a href="Edit_SmsCustomersWithoutNUmber?id=<?php echo $value->id; ?>" class="btn btn-warning">Edit</a>
                                           </td> -->
                                          
                                          
                                           
                                       </tr>
                                   <?php } ?>
                                   
                               </tbody>
                               <tfoot>
                                 <tr>
                                 
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                  <!--  <td colspan=""></td>
                                   <td colspan=""></td>
                                    <td colspan=""></td> -->
                                  
                                   
                                   </tr>
                               </tfoot>
                           </table>
                           </div>
                          
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
