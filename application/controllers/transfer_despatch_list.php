<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 

<style type="text/css">
    .nofooter{
        display: none;
    }
</style>

         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Transfer  </h3>
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
                   <div class="card-header">
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Services/Despatch" class="text-white"><i class="" aria-hidden="true"></i> Despatch list </a></button>
                    </div>
                            
                            <div class="card-body">


                            <?php 
                            if(!empty($this->session->flashdata('message'))){
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
                                      <?php echo $this->session->flashdata('message'); ?>
                                      <?php
                            echo "</div>";
                            
                            }
                            ?>
                       
                            <form class="row" method="post" action="<?php echo site_url('Box_Application/item_transfer_despatch');?>">

                                

                                    <div class="form-group col-md-3 m-t-10">
                                        <select onchange="getOperatorByZone(this)" class="form-control custom-select js-example-basic-multiple zonetype bulk" id="zonetype" name="operator_zone">
                                        <option selected="selected" disabled="disabled">--Select zone --</option>
                                        <?php foreach ($sectiondata as $key => $value){ ?>
                                            <?php if ($value['id'] == 5 || $value['id'] == 3 || $value['id'] == 2){ ?>
                                                <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                                            <?php } ?>
                                        <?php } ?>

                                        </select>
                                        <input id="searched_name" type="hidden" name="searched_name">
                                    </div>

                                    <div class="form-group col-md-3 m-t-10">
                                        <select class="form-control custom-select js-example-basic-multiple assignedoperator bulk" id="assignedoperator" name="operator">
                                        <option selected disabled="disabled">--Select operator --</option>            
                                    </select>
                                    </div>

                                    <div class="form-group col-md-2 m-t-10">
                                    <input type="date" name="fromdate" class="form-control" required="required">
                                    </div>
                                    
                                    <div class="form-group col-md-2 m-t-10">
                                         <input type="date" name="todate" class="form-control" required="required">
                                    </div>
                                    
                                    <div class="form-group col-md-2 m-t-10">
                                         <button type="submit" class="btn btn-block btn-info"> <i class="fa fa-search"></i> Search </button>
                                    </div>
                            </form>
                            

 <?php if(isset($listdata)){ ?>

 <button class="btn btn-info" onclick="printContent('div1')"><i class="fa fa-print"></i> Print</button>
 <div class="table-responsive" id="div1">

    <div class="panel-footer text-center">
        <img src="<?php echo base_url(); ?>assets/images/tcp.png" height="50px" width="100px"/>
        <br>
        <h3> <strong> TRANSFERRED ITEMS </strong> </h3>
    </div>
                                
    <table  class="table table-hover table-bordered" cellspacing="0" width="100%">
        <tr style="font-size:12px ;">; 
            <th><b>Transfer from <? echo $selected_section; ?>: </b><?php echo $info->em_code; ?>  - <?php echo $info->first_name.' '.$info->middle_name.' '.$info->last_name; ?> </th>
             <th><b>Office : </b><?php echo $info->em_branch;?> </th>
        </tr> 

        <tr style="font-size:12px ;">
            <th><b>Received By Despatch: </b><?php echo $info_assignedby->em_code; ?>  - <?php echo $info_assignedby->first_name.' '.$info_assignedby->middle_name.' '.$info_assignedby->last_name; ?> </th>
             <th><b>Office : </b><?php echo $info_assignedby->em_branch;?> </th>
        </tr>

        <tr style="font-size:12px ;" >
             <th colspan="2"><b>From : </b><?php echo $fromdate;?>  &nbsp; &nbsp; &nbsp;  <b>To:</b> </b><?php echo $todate;?> </th>
        </tr>
        <br>

    </table>
                               
            <table style="font-size: 11px;" class="" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>S/No</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Barcode</th>
                        <th>Status</th>
                        <tbody id="listTable"></tbody>
                    </tr>
                </thead>
                <tbody>
                </tbody>

                <?php 

                $count = 1;

                foreach ($listdata as $key => $value){ ?>
                    <tr>
                        <td><?php echo $count++?></td>
                        <td><?php echo $value['s_fullname'];?></td>
                        <td><?php echo $value['fullname'];?></td>
                        <td style="font-weight: 900"><strong><?php echo $value['Barcode'];?></strong> </td>
                        <td><?php echo $value['trans_status'];?></td>
                    </tr>
                    
                <?php } ?>

            </table>
                                     
                               
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }?>

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

function printContent(el){
  var restorepage = document.body.innerHTML;
  var printcontent = document.getElementById(el).innerHTML;
  document.body.innerHTML = printcontent;
  window.print();
  document.body.innerHTML = restorepage;
}

function getOperatorByZone(obj){
        var sectionid = $(obj).val();
        var selectedName = $('#'+$(obj).attr('id')+' option:selected').text();
        $('#searched_name').val(selectedName);

        $.ajax({
            type:"POST",
            url:"<?php echo base_url();?>Employee/getEmployeeBySection",
            data:'sectionid='+sectionid,
            dataType:'json',
            success:function(res){

                if (res['status'] == 'Success') {
                    $('#assignedoperator').empty();

                    $('#assignedoperator').append("<option selected disabled='disabled'>--Select operator --</option>");
                    $.each(res['msg'], function(index,data){

                        $('#assignedoperator').append("<option value="+data['em_id']+"  >"+data['first_name']+" "+data['last_name']+"</option>");

                    })
                }else{
                    $('#assignedoperator').empty();
                    $('#assignedoperator').append("<option selected disabled='disabled'>--Select operator --</option>");
                }

            },error:function(err){

            }
        })
    }
</script>
<?php $this->load->view('backend/footer'); ?>