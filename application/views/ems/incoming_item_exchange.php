
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
<div class="message"></div>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h2 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> EXCHANGE OFFICE </h2>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Exchange Office</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="row m-b-10">
        <div class="col-12">
         <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url()?>Ems_Domestic/Incoming_Exchange?AskFor=EMS" class="text-white"><i class="" aria-hidden="true"></i> Incoming To Exchange Office</a></button>

                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url()?>Ems_Domestic/Sent_ToIps?AskFor=EMS" class="text-white"><i class="" aria-hidden="true"></i> Sent To Ips Item</a></button>



     </div>
 </div>
 <hr/>
                        <div class="row">
                            <div class="col-md-12">
                              
                          <form   method="POST" action="<?php echo base_url()?>Ems_Domestic/Incoming_Exchange?AskFor=EMS">
                                <table class="table table-bordered" style="width: 100%;"> 
                                    <input type="hidden" name="askfor" value="EMS" >
                                    <!-- ?AskFor=EMS -->
                                  <!-- <input type="hidden" name="" id="emid" value="<?php echo @$emid; ?>"> -->
                                  
                                    <tr>
                                        <th style="">
                                          <div class="input-group">
                                        <input type="text" name="date" class="form-control  mydatetimepickerFull">
                                        <button type="submit" class="btn btn-success">Search Date</button>
                                    </div>

                                        
                                    </th>
                                    <th>
                                 <div class="input-group">
                                    <input type="text" name="month" class="form-control  mydatetimepicker month2">
                                    <button type="submit" class="btn btn-success">Search Month</button>

                                </div>
                            </th>
                                  </tr>
                                 
                                
                         
                        </table>
                         </form>
                       
                          
                    </div>
                </div>


 <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Incomming To Exchange Office
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                          <form action="Send_Ips" method="POST">
                            <div style="overflow-x: auto;">
                             <table id="example4" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                
                                 <tr>
                                    <th>Sender Name</th>
                                    <th>Registered Date</th>
                                    <th>Amount (Tsh.)</th>
                                    <th>Service Name</th>
                                    <th>Region Origin</th>
                                    <th>Branch Origin</th>
                                    <th>Destination Region</th>
                                    <th>Destination Branch</th>
                                    <th>Bill Number</th>
                                    <th>Tracking Number</th>
                                     <th>Barcode Number</th>
                                    <th style="padding-right: 40px;">
                                     <div class="form-check" style="padding-left:50px;" id="showCheck">
                                <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                <label class="form-check-label" for="remember-me">All</label>
                                </div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="">
                              <?php foreach ($emslist as $value) {?>
                                   <tr>
                                      <td><a href="#" class="myBtn" data-sender_id="<?php echo $value->sender_id; ?>"><?php echo @$value->s_fullname;echo @$value->sender_fullname;?></a></td>
                                      <td><?php
                                      echo @$value->date_registered;echo @$value->sender_date_created;
                                      ?></td>
                                      <td><?php echo number_format($value->paidamount,2);?></td>
                                      <td><?php echo @$value->PaymentFor;echo @$value->sender_type;?></td>
                                      <td><?php echo @$value->s_region;echo @$value->sender_region;?></td>
                                      <td><?php echo @$value->s_district; ?></td>
                                      <td><?php echo @$value->r_region; echo @$value->receiver_region;?></td>
                                      <td><?php echo @$value->branch;  ?></td>
                                      <td>
                                          <?php echo @$value->billid;?>
                                      </td>
                                      <td>
                                    <?php
                                    echo @$value->track_number;
                                    ?>
                               </td>
                                 <td>
                                    <?php
                                    echo @$value->Barcode;
                                    ?>
                               </td>
                            
                        <td style = "text-align:center;"><div class='form-check'>
                             <input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value="<?php echo @$value->sender_id;?>">
                            <label class='form-check-label' for='remember-me'></label></div>
                             </td>
</tr>
<?php }?>
</tbody>
<tfoot>
  <tr>
    <td colspan="11"></td>
  <!--   <td style="text-transform: uppercase;"  colspan="2">
        
      <select class="form-control custom-select js-example-basic-multiple"  name="operator">
        <option value="">--Select Operator--</option>
      <?php foreach ($emselect as  $value) {?>
      <option value="<?php echo $value->em_id; ?>"><?php echo $value->first_name.'  '.$value->middle_name.'  '.$value->last_name;  ?></option>
    <?php } ?>
  </select>
 
</td> -->
   <!--  <td>
        <input type="hidden" name="askfor" value="<?php echo $askfor; ?>">
        <button class="btn btn-info" type="submit" value="" >Assign To</button>
   </td> -->
 <!--   <td style="" colspan="2">


                      <select name="action"  class="form-control custom-select" style="background-color: white;"   required="required">
                                            <option value="">--Select Action--</option>
                                            <option value="Assign">Assign To</option>
                                            <option value="Return">Return</option>
                                         </select>
                    </td> -->
    <td>
        <input type="hidden" name="askfor" value="<?php echo $askfor; ?>">
        <button class="btn btn-info" type="submit" value="" >Sent To Ips</button>
   </td>

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
$(document).ready(function() {
    $("#checkAll3").change(function() {
        if (this.checked) {
            $(".checkSingle3").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle3").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingle3").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle3").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkAll3").prop("checked", true);
            }
        }
        else {
            $("#checkAll3").prop("checked", false);
        }
    });
});
</script>
<!--  <script type="text/javascript">
$('form').each(function() {
    $(this).validate({
    submitHandler: function(form) {
        var formval = form;
        var url = $(form).attr('action');

        // Create an FormData object
        var data = new FormData(formval);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            // url: "crud/Add_userInfo",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                console.log(response);            
                $(".message").fadeIn('fast').delay(600).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},600);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});

    </script> -->
<?php $this->load->view('backend/footer'); ?>


