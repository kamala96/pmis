<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>



<style>
.overlay{
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 999;
    background: rgba(255,255,255,0.8) url("loader-img.gif") center no-repeat;
}
/* Turn off scrollbar when body element has the loading class */
body.loading{
    overflow: hidden;   
}
/* Make spinner image visible when body element has the loading class */
body.loading .overlay{
    display: block;
}

#btn_save:focus{
  outline:none;
  outline-offset: none;
}

.button {
    display: inline-block;
    padding: 6px 12px;
    margin: 20px 8px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    background-image: none;
    border: 2px solid transparent;
    border-radius: 5px;
    color: #000;
    background-color: #b2b2b2;
    border-color: #969696;
}

.button_loader {
  background-color: transparent;
  border: 4px solid #f3f3f3;
  border-radius: 50%;
  border-top: 4px solid #969696;
  border-bottom: 4px solid #969696;
  width: 35px;
  height: 35px;
  -webkit-animation: spin 0.8s linear infinite;
  animation: spin 0.8s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  99% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  99% { transform: rotate(360deg); }
}



    /*Hidden class for adding and removing*/
    .lds-dual-ring.hidden {
        display: none;
    }

    /*Add an overlay to the entire page blocking any further presses to buttons or other elements.*/
    .overlay2 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(0,0,0,.8);
        z-index: 999;
        opacity: 1;
        transition: all 0.5s;
    }

    /*Spinner Styles*/
    .lds-dual-ring {
        display: inline-block;
        width: 80px;
        height: 80px;
    }
    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 5% auto;
        border-radius: 50%;
        border: 6px solid #fff;
        border-color: #fff transparent #fff transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }
    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

</style>




         <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Payroll</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-university" aria-hidden="true"></i> Payroll</li>
                    </ol>
                </div>
            </div>
            
            <div class="container-fluid"> 
                <div class="row m-b-10"> 
                    <div class="col-12">
<!--                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#TypeModal" data-whatever="@getbootstrap" class="text-white TypeModal"><i class="" aria-hidden="true"></i> Add Payroll </a></button>-->
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="" class="text-white"><i class="" aria-hidden="true"></i>  Generate Payroll</a></button>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-12">

                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Payroll List                     
                                </h4>
                                
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                    <form method="post" action="<?php echo base_url() ?>payroll/Payslip_Create1">
                                    <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="hide">SL </th>
                                                <th>PF Number</th>
                                                <th>Full names</th>
                                                <th>Titles</th>
                                                <th>Salary Scale</th>
                                                <th>Salary Amount</th>
                                                <th>Joining Date</th>
                                                <th>Department</th>
                                               
                                                <!-- <th>Status</th> -->
                                               <!--  <th>
                                                    <div class="form-check">
                                                     <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                                     <label class="form-check-label" for="remember-me">Select All</label>
                                                 </div> 
                                             </th>-->
                                             <?php if($this->session->userdata('user_type') == "SUPER ADMIN" || $this->session->userdata('user_type') == 'HR-PAY'){ ?>
                                             <th colspan="2">Action</th>
                                         <?php }else{?>

                                         <?php }?>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="hide">SL </th>
                                                <th>PF Number</th>
                                                <th>Full names</th>
                                                <th>Titles</th>
                                                <th>Salary Scale</th>
                                                <th>Salary Amount</th>
                                                <th>Joining Date</th>
                                                <th>Department</th>
                                <?php if($this->session->userdata('user_type') == "SUPER ADMIN" || $this->session->userdata('user_type') == 'HR-PAY'){ ?>
                                                     <th colspan="2"><button id="btn_save" type="submit" class="btn btn-info">Generate Salary</button></th>

                                                    <?php }else{?>
                                                         <th colspan="2"></th>

                                         <?php }?>
                                                
                                           
                                            </tr>
                                        </tfoot>
                                        <tbody>

                                        <?php $i =0; foreach($salary_info as $individual_info): ?>
                                            <tr>
                                                <td class="hide"><?php $i++; echo $i;?></td>
                                                <td><?php echo $individual_info->em_code; ?></td>
                                                <td><?php echo strtoupper( $individual_info->first_name.' '.$individual_info->middle_name.' '.$individual_info->last_name ); ?></td>
                                                <td><?php  
                                                    @$des_id = $individual_info->des_id; 
                                                    @$desvalue = $this->employee_model->getdesignation1($des_id);
                                                    echo strtoupper( @$desvalue->des_name );
                                                ?></td>
                                                <td><?php 
                                                        @$des_id = $individual_info->type_id; 

                                                        echo @$des_id; 
                                                ?></td>
                                                <td><?php echo number_format($individual_info->total,2); ?></td>
                                                <td><?php echo $individual_info->em_joining_date; ?></td>
                                                 <td>
                                                    <?php 
                                                    $dep_id = $individual_info->dep_id;
                                                     $depvalue1 = $this->employee_model->getdepartment1($dep_id);echo strtoupper( @$depvalue1->dep_name );
                                                ?></td>
                                                 
                                                <!--  <td class="jsgrid-align-center ">
                                               <div class="form-check">
                                                 <input type="checkbox" name="I[]" class="form-check-input checkSingle" id="remember-me" value="<?php echo $individual_info->emp_id?>">
                                                 <label class="form-check-label" for="remember-me"></label>
                                             </div> 
                                                
                                                </td> -->
                                               <?php if($this->session->userdata('user_type') == "SUPER ADMIN" || $this->session->userdata('user_type') == 'HR-PAY'){ ?>
                                            <td colspan="2">
                                                   
                                                        <input type="hidden" name="salary_id" value="<?php echo $individual_info->em_id; ?>" class="sid">
                                                         <?php if($this->session->userdata('user_type') == "ADMIN" ){ ?>
                                                        <button class="btn btn-info btn-sm BtnDay" type="submit">Delete</button> |
                                                         <?php }?>
                                                         <a href="edit_bank_info?I=<?php echo base64_encode($individual_info->emp_id) ?>" class="btn btn-info btn-sm" type="submit">Edit</button>
                                                   
                                                </td>
                                         <?php }else{?>

                                         <?php }?>
                                                
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        

<script type="text/javascript">

$('#btn_save').on('click',function(){

//$('#btn_save').prop('disabled', true);
 $("#btn_save").addClass('button_loader').attr("value",""); 


});
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

    var table = $('#example4').DataTable( {
         ordering: false,
        orderCellsTop: false,
        fixedHeader: true,
        "aaSorting": [[0,'asc']],
         lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
        dom: 'lBfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
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
                $(".message").fadeIn('fast').delay(1800).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},1800);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});

    </script>
<?php $this->load->view('backend/footer'); ?>