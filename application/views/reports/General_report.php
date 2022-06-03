<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>  General Report </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">General Report</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
      <!--  <div class="row m-b-10">
              <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Internet/Internet_form" class="text-white"><i class="" aria-hidden="true"></i>Add Internet </a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Internet/Internet_List" class="text-white"><i class="" aria-hidden="true"></i> Internet Transaction List</a></button>
                </div>
        </div> -->

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
                        <h4 class="m-b-0 text-white"> General Report
                        </h4>
                    </div>
                    <div class="card-body" >
                      <div class="col-md-12">
                        <form action="Get_General_Reports" method="POST">
                        <div class="input-group">
                          
                          <input type="text" name="date" class="form-control mydatetimepickerFull" placeholder="Select Date">
                          <input type="text" name="month" class="form-control mydatetimepicker" placeholder="Select Month">
                          <?php if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "BOP" || $this->session->userdata('user_type') == "CRM" ){ ?>
                          <select class="form-control custom-select" name="region">
                            <option value="">--Select Year-</option>
                            <option value="">2020</option>
                            <option value="">2019</option>
                            <option value="">2018</option>
                            <option value="">2017</option>
                           <!--  <?php foreach ($region as $value) { ?>
                              <option><?php echo $value->region_name ?></option>
                            <?php } ?> -->
                          </select>
                        <?php }?>
                          <button type="submit" class="btn btn-info">Search</button>
                        </div>
                        </form>
                      </div>
                       <br />
                      <form action="Miscereneous" method="POST">
                        <div class="table table-responsive">
                           <table class="table table-bordered International text-nowrap" width="100%" style="text-transform: capitalize;">
                               <thead>
                                 <th>SN</th>
                                 <th>COST CENTER NAME</th>
                                   <th>LOCATION CODE</th>
                                   <th>COST CENTER CODE</th>
                                   <th>GFS CODE`</th>
                                   <th>GFS CODE DESCRITION</th>

                                   <th>PAID AMOUNT TSHS</th>
                                   <th>UNPAID AMOUNT TSHS</th>
                                 
                               </thead>
                               <tbody>
                                <tr>
                                  <td colspan="">1</td>
                                   <td colspan="">PROCUREMENT MENENGEMENT UNIT</td>
                                   <td colspan="">000</td>
                                   <td colspan="">201E</td>
                                   <td colspan=""></td>
                                   <td colspan="">Sale of Stores - Obsolete Stock</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                  
                                 </tr>
                                 <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">Tender Board Deposits</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                  
                                 </tr>
                                  <tr>
                                  <td colspan="">2</td>
                                   <td colspan="">REAL ESTATE MANAGEMENT UNIT</td>
                                   <td colspan="">000</td>
                                   <td colspan="">201G</td>
                                   <td colspan=""></td>
                                   <td colspan="">Rent Income</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                  
                                 </tr>
                                 </tr>
                                 <tr>
                                  <td colspan="">3</td>
                                   <td colspan="">MAILS AND LOGISTIC</td>
                                   <td colspan=""></td>
                                   <td colspan="">202B</td>
                                   <td colspan=""></td>
                                   <td colspan="">International Mails Income</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                  
                                 </tr>

                                  <tr>
                                  <td colspan="">4</td>
                                   <td colspan="">FINANCIAL AND AGENCY SERVICES</td>
                                   <td colspan=""></td>
                                   <td colspan="">202D</td>
                                   <td colspan=""></td>
                                   <td colspan="">Post GIRO Revenue</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                  
                                 </tr>

                                 <tr>
                                  <td colspan="">5</td>
                                   <td colspan="">E-BUSINESS</td>
                                   <td colspan=""></td>
                                   <td colspan="">202E</td>
                                   <td colspan=""></td>
                                   <td colspan="">e-Shopping</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                  
                                 </tr>

                                  <tr>
                                  <td colspan="">6</td>
                                   <td colspan="">UPU–RTC</td>
                                   <td colspan=""></td>
                                   <td colspan="">203C</td>
                                   <td colspan=""></td>
                                   <td colspan="">UPU RTC Income</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                  
                                 </tr>

                                   <tr>
                                  <td colspan="">7</td>
                                   <td colspan="">CORPORATE FINANCE ACCOUNTS</td>
                                   <td colspan=""></td>
                                   <td colspan="">205C</td>
                                   <td colspan=""></td>
                                   <td colspan="">Dividend Income</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 </tr>

                                  <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">Revaluation Gain</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 </tr>
                                  <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">Deferred Income</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 </tr>

                                  <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">Impairment Loss Reversal</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 </tr>

                                  <tr>
                                  <td colspan="">8</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">Revaluation Gain</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 </tr>
                                   
                                   
                               </tbody>
                               <tfoot>
                                 <tr>
                                 
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   
                                   </tr>
                               </tfoot>
                           </table>
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
