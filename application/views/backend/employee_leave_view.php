<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
   <div class="message"></div>
   <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-user-secret" style="color:#1976d2"></i> <?php echo @$basic->first_name .' '.@$basic->last_name; ?></h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Leave View</li>
        </ol>
    </div>
</div>


<?php 
$dep_id = @$basic->dep_id;
$depvalue1 = $this->employee_model->getdepartment1($dep_id); ?>
<?php $regvalue = $this->employee_model->regselect(); ?>
<?php $branchvalue = $this->employee_model->branchselect(); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-xlg-12 col-md-12">
            <div class="card">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab" style="font-size: 14px;">  Personal Information </a> </li>

                   
                    <li class="nav-item"> <a class="nav-link" 
                       data-toggle="tab" href="#family23" role="tab" style="font-size: 14px;">Family members</a> </li>

                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#address" role="tab" style="font-size: 14px;"> Address </a> </li>                                
                   

                </ul>
                <!-- Tab panes -->

                <div class="tab-content">
             
  

<div class="tab-pane" id="address" role="tabpanel">
    <div class="card">
        <div class="card-body">
            <table id="" class="display nowrap table table-hover table-striped table-bordered family" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Address</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Address Type</th>
                       
                    </tr>
                </thead>
                <tbody>
                 <?php foreach($present as $value){ ?>
                    <tr>
                        <td><?php echo $value->address ?></td>
                        <td><?php echo $value->city ?></td>
                        <td><?php echo $value->country ?></td>
                        <td><?php echo $value->type ?></td>

                     
                   </tr>
               <?php }?>
           </tbody>
       </table>
       <br>
       <br>
       <hr>
       

</div>
</div>
</div>

<div class="tab-pane active" id="home" role="tabpanel">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <center class="m-t-30">
                             <?php if(!empty($basic->em_image)){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/users/<?php echo $basic->em_image; ?>" class="img-circle" width="150" />
                            <?php } else { ?>
                                <img src="<?php echo base_url(); ?>assets/images/users/user.png" class="img-circle" width="150" alt="<?php echo $basic->first_name ?>" title="<?php echo $basic->first_name ?>"/>                                   
                            <?php } ?>
                            <h4 class="card-title m-t-10"><?php echo $basic->first_name .' '.$basic->last_name; ?></h4>
                            <h6 class="card-subtitle"><?php echo $basic->des_name; ?></h6>
                            <!--                                    <input type="file" id="filecount" multiple="multiple">-->
                        </center>
                    </div>
                    <div>
                        <hr> </div>
                        <div class="card-body"> <small class="text-muted">Email address </small>
                            <h6><?php echo $basic->em_email; ?></h6> <small class="text-muted p-t-30 db">Phone</small>
                            <h6><?php echo $basic->em_phone; ?></h6> 
                            
                        </div>
                    </div>                                                    
                </div>
                <div class="row col-md-8">
                        
                        <div class="form-group col-md-4 m-t-10">
                            <label>Employee PF Number </label>
                            <input type="text" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> class="form-control form-control-line"  name="eid" value="<?php echo $basic->em_code; ?>" required > 
                        </div>
                        <div class="form-group col-md-4 m-t-10">
                            <label>First Name</label>
                            <input type="text" class="form-control form-control-line" placeholder="Your first name" name="fname" value="<?php echo $basic->first_name; ?>" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> minlength="3" required> 
                        </div>
                        <div class="form-group col-md-4 m-t-10">
                            <label>Middle Name </label>
                            <input type="text" id="" name="mname" class="form-control form-control-line" value="<?php echo $basic->middle_name; ?>" placeholder="Your last name" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> minlength="3"> 
                        </div>
                        <div class="form-group col-md-4 m-t-10">
                            <label>Last Name </label>
                            <input type="text" id="" name="lname" class="form-control form-control-line" value="<?php echo $basic->last_name; ?>" placeholder="Your last name" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> minlength="3" required> 
                        </div>
                      
                        <div class="form-group col-md-4 m-t-10">
                            <label>Gender </label>
                            <select name="gender" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> class="form-control custom-select">

                                <option value="<?php echo $basic->em_gender; ?>"><?php echo $basic->em_gender; ?></option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 m-t-10">
                            <label>Region</label>
                            <select name="region" value="" class="form-control custom-select" required id="region" onChange="getDistrict();">
                                <option value="<?php echo $basic->em_region; ?>"><?php echo $basic->em_region; ?></option>
                                <?Php foreach($regvalue as $value): ?>
                                <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4 m-t-10">
                        <label>Region Branch</label>
                        <select name="branch" value="" class="form-control custom-select"  id="branchdrop">  
                            <option value="<?php echo $basic->em_branch; ?>"><?php echo $basic->em_branch; ?></option>
                        </select>

                    </div>

                      <div class="form-group col-md-12 m-t-10">
                <label><h2>Leave Details</h2></label>
               
                <br>
                <div class="row col-md-12 m-t-10">

                <div class="form-group col-md-4 m-t-10">
                            <label>Leave Type </label>
                            <input type="text"  readonly  class="form-control form-control-line"  name="eid" value="<?php echo $report->name; ?>" required > 
                        </div>

                        <div class="form-group col-md-4 m-t-10">
                            <label>Apply Date </label>
                            <input type="text"  readonly  class="form-control form-control-line"  name="eid" value="<?php echo date('jS \of F Y',strtotime($report->apply_date)); ?>" required > 
                        </div>

                         <div class="form-group col-md-4 m-t-10">
                            <label>Start Date </label>
                            <input type="text"  readonly  class="form-control form-control-line"  name="eid" value="<?php echo $report->start_date; ?>" required > 
                        </div>

                         <div class="form-group col-md-4 m-t-10">
                            <label>End Date </label>
                            <input type="text"  readonly  class="form-control form-control-line"  name="eid" value="<?php echo $report->end_date; ?>" required > 
                        </div>

                          <div class="form-group col-md-4 m-t-10">
                            <label>Duration </label>
                            <input type="text"  readonly  class="form-control form-control-line"  name="eid" value="<?php echo $report->leave_duration . ' ' .'Days'; ?>" required > 
                        </div>

                         <div class="form-group col-md-4 m-t-10">
                            <label>Fare Amount </label>
                            <input type="text"  readonly  class="form-control form-control-line"  name="eid" value="<?php echo number_format($report->fare_amount + $report->faredistrictvillage); ?>" required > 
                        </div>


                        <div class="form-group col-md-4 m-t-10">
                            <label>From Region</label>
                            <?php
                            $from='';
                             if(empty($report->region_from)){
                                $from=$report->em_region;

                             } else{ $from=$report->region_from;

                             } ?>
                            <input type="text"  readonly  class="form-control form-control-line"  name="eid" value="<?php echo $from; ?>" required > 
                        </div>

                         <div class="form-group col-md-4 m-t-10">
                            <label>To Region</label>
                            <input type="text"  readonly  class="form-control form-control-line"  name="eid" value="<?php echo $report->region_to; ?>" required > 
                        </div>

                         <div class="form-group col-md-4 m-t-10">
                            <label>Amount </label>
                            <input type="text"  readonly  class="form-control form-control-line"  name="eid" value="<?php echo number_format($report->fare_amount); ?>" required > 
                        </div>

                        <div class="form-group col-md-4 m-t-10">
                            <label>From District</label>
                            <input type="text"  readonly  class="form-control form-control-line"  name="eid" value="<?php echo $report->district_to; ?>" required > 
                        </div>

                         <div class="form-group col-md-4 m-t-10">
                            <label>To village</label>
                            <input type="text"  readonly  class="form-control form-control-line"  name="eid" value="<?php echo $report->village_to; ?>" required > 
                        </div>

                         <div class="form-group col-md-4 m-t-10">
                            <label>Amount </label>
                            <input type="text"  readonly  class="form-control form-control-line"  name="eid" value="<?php echo number_format($report->faredistrictvillage); ?>" required > 
                        </div>

                         <div class="form-group col-md-4 m-t-10">
                            <label>Reason</label>
                            <input type="text"  readonly  class="form-control form-control-line"  name="eid" value="<?php echo $report->reason; ?>" required > 
                        </div>
                       
            </div>
        </div>
                    
                
            
                                                        
      
</div>
</div>
</div>
</div>
</div>
<div class="tab-pane" id="family23" role="tabpanel">
    <div class="card-body">
        <div class="card card-outline-info">
            <div class="card-body">
                <div class="table-responsive ">
                    <table id="employeesFamily" class="display nowrap table table-hover table-striped table-bordered " cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Date Of Birth</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                         <?php foreach($family as $value): ?>
                            <tr>
                                <td><?php echo $value->first_name . '  '.$value->middle_name.' '.$value->last_name; ?></td>
                                <td><?php echo $value->dateofbirth; ?></td>
                                <td><?php echo $value->gender; ?></td>
                                <td><?php
                                $dateProvided=$value->dateofbirth;
                                $yearOnly=date('Y', strtotime($dateProvided));
                                $monthOnly=date('m', strtotime($dateProvided));
                                $age = date('Y') - $yearOnly;
                                if ($age == 0)
                                {
                                    echo $age = date('m') - $monthOnly.' '.'Months';
                                }
                                else{
                                    echo $age.'  '.'Years';
                                }
                                ?></td>
                                <td><?php echo $value->title; ?></td>
                                <td class="jsgrid-align-center ">
                                    <div class="input-group">
                                      
                                            <?php if($value->certificate == ''){?>

                                            <?php }else{?>
                                               &nbsp; | &nbsp;
                                               <a href="<?php echo base_url()?>assets/images/users/<?php echo $value->certificate; ?>" class="btn btn-info btn-sm" target="_blank"> View Certificate</a>
                                           <?php  } ?>

                                    </div>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
           
                    </div>
                </div>
            </div>
        </div>

  







    </div>
</div>
</div>
<!-- Column -->
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#yes').change(function () {
            if (this.checked) {
                $('#comments').show();
                $('#sio').hide();
            }
            else {
                $('#comments').hide();
                $('#sio').show();
            }
        });
        $('#no').change(function () {
            if (this.checked) {
                $('#comments').hide();
                $('#ndio').hide();
            }
            else
            {
                $('#ndio').show();
            }
        });
    });
</script>


<script type="text/javascript">
    function getScale() {
        var val = $('#regiono').val();
        $.ajax({
           type: "POST",
           url: "<?php echo base_url();?>Payroll/GetScale",
           data:'scale_name='+ val,
           success: function(data){
               $("#branchdropo").val(data.trim());
           }
       });
    };
</script>


<?php $this->load->view('backend/em_modal'); ?>                


<script type="text/javascript">
    function getType() {
        var type = $('#title').val();
        if (type == 'Child') {
            $('#attatch').show();
            $('#child').html('Attatch Birthcertificate');
            $('#spouse').html('');
        }else if(type == 'Spouse'){
            $('#attatch').show();
            $('#spouse').html('Attatch Marriage Certificate');
            $('#child').html('');
        }else{
            $('#attatch').hide();
        }
    };
</script>
<script type="text/javascript">
    function getSuper() {
        
        var user = $('.usertype1').val();
        if (user == 'SUPERVISOR') {
            $('.super').show();
        }else{
            $('.super').hide();
            $('.Subsuper').hide();
        }


    };

    function getSubSuper() {
        $('.Subsuper').show();

    };
</script>         
<script type="text/javascript">
    function getDistrict() {
        var val = $('#region').val();
        $.ajax({
           type: "POST",
           url: "<?php echo base_url();?>Employee/GetBranch",
           data:'region_id='+ val,
           success: function(data){
               $("#branchdrop").html(data);
           }
       });
    };
</script>      

<?php $this->load->view('backend/footer'); ?>
<script>
    $('#employeesFamily').DataTable({
        "aaSorting": [[1,'asc']],
        dom: 'Bfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
<?php $this->load->view('backend/footer'); ?>
<script>
    $('.family').DataTable({
        "aaSorting": [[1,'asc']],
        dom: 'Bfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var i = 1;
        $('#add_input').click(function() {
            i++;
            $('#dynamic').append('<tr id="row' + i + '"><td><input type="text" name="name[]" placeholder="Enter Name" class="form-control"/></td><td>&nbsp;</td><td><input type="text" name="amountLoan[]" placeholder="Enter Amount" class="form-control"/></td><td><button type="button" name="remove" id="' + i + '" class="btn_remove">Remove</button></td></tr>');
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
        $('#submit').click(function() {
            $.ajax({
                url: "insert.php",
                method: "POST",
                data: $('#add_me').serialize(),
                success: function(data) {
                    alert(data);
                    $('#add_me')[0].reset();
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
                    // Setup - add a text input to each footer cell
                    $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
                    $('#example4 thead tr:eq(1) th').not(":eq(3)").each( function (i) {
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
                        orderCellsTop: true,
                        fixedHeader: true,
                        dom: 'Bfrtip',
                        buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    } );
                } );
            </script>

            <script type="text/javascript">
                $(document).ready(function() {
                    // Setup - add a text input to each footer cell
                    $('#example5 thead tr').clone(true).appendTo( '#example5 thead' );
                    $('#example5 thead tr:eq(1) th').not(":eq(3)").each( function (i) {
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

                    var table = $('#example5').DataTable( {
                        orderCellsTop: true,
                        fixedHeader: true,
                        dom: 'Bfrtip',
                        buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    } );
                } );
            </script>




            <script>

                $('#filecount').filestyle({

                    input : false,

                    buttonName : 'btn-danger',

                    iconName : 'glyphicon glyphicon-folder-close'

                });

            </script>

            <script type="text/javascript">
                $(document).ready(function() {

                    var table = $('#referees').DataTable( {
                        orderCellsTop: true,
                        fixedHeader: true,
                        dom: 'Bfrtip',
                        buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    } );
                } );
            </script>
            <script type="text/javascript">
                $(document).ready(function() {

                    var table = $('#documents').DataTable( {
                        orderCellsTop: true,
                        fixedHeader: true,
                        dom: 'Bfrtip',
                        buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    } );
                } );
            </script>
            <script type="text/javascript">
                $(document).ready(function() {

                    var table = $('#experiences').DataTable( {
                        orderCellsTop: true,
                        fixedHeader: true,
                        dom: 'Bfrtip',
                        buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    } );
                } );
            </script>
            <script>
                var nowY = new Date().getFullYear(),
                options = "";

                for (var Y = nowY; Y >= 1900; Y--) {
                    options += "<option>" + Y + "</option>";
                }

                $("#years").append(options);
            </script>
            <script>
                var nowY = new Date().getFullYear(),
                options = "";

                for (var Y = nowY; Y >= 1900; Y--) {
                    options += "<option>" + Y + "</option>";
                }

                $("#yearsTo").append(options);
            </script>
<script type="text/javascript">
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


function getSections(obj){
    var departId = $(obj).val();

    $.ajax({
        type:"POST",
        url:"<?php echo base_url();?>Employee/getDepartmentSections",
        data:'departId='+departId,
        dataType:'json',
        success:function(res){
            if (res['status'] == 'Success') {
                $('#usersection').empty();
                $.each(res['msg'], function(index,data){

                    $('#usersection').append("<option value="+data['id']+"  >"+data['name']+"</option>");

                })
            }else{
                $('#usersection').empty();
            }

        },error:function(err){

        }
    })

}

    </script>
            <?php $this->load->view('backend/footer'); ?>