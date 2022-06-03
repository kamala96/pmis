<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 

         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Consolidated Report  </h3>
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



                            
                       
                            
                            } ?>
                        <!-- <form method="POST" action="ems_Consolidated_Search_Reports"> -->

                           <div class="row">
                              <div class="col-md-12">
                                 <h4 class="statusText"></h4>
                              </div>
                           </div>
               
                                <div class="row">

                                    <div class="form-group col-md-3 m-t-10">
                                    <input type="text" autocomplete="off" name="fromdate" class="form-control mydatetimepickerFull fromdate" placeholder="From Date" required="required">
                                    </div>
                                    
                                    <div class="form-group col-md-3 m-t-10">
                                         <input type="text" autocomplete="off" name="todate" class="form-control mydatetimepickerFull todate" placeholder="To Date" required="required">
                                    </div>

                                     <!--  <div class="form-group col-md-3 m-t-10">
                                         <input type="text" name="test" class="form-control  test">
                                    </div>-->


                                    <?php  if($this->session->userdata('user_type') == "RM"){ ?>

                                       <input id="region_name" class="region" type="hidden" name="region" value="<?php echo $region;?>">
                                       
                                    <?php } ?>

                                     <?php 
                                        $id = $this->session->userdata('user_login_id');
                                            $basicinfos = $this->employee_model->GetBasic($id);
                                            $dep_id = $basicinfos->dep_id;
                                             $dep = $this->employee_model->getdepartment1($dep_id);
                                             $dep_name='';
                                            if (!empty($dep)) {
                                                $dep_name = $dep->dep_name;
                                            }


                                     if($this->session->userdata('user_type') == "SUPER ADMIN" || $this->session->userdata('user_type') == "BOP" || $this->session->userdata('user_type') == "PMG" || $this->session->userdata('user_type') == "CRM" || $this->session->userdata('user_type') == "ACCOUNTANT-HQ" || $dep_name == 'EMS HQ' ){ ?>
                                         <div class="form-group col-md-3 m-t-10">
                                          <select id="region_name" class="form-control custom-select region" name="region">
                                            <option value="">--Select Region-</option>
                                            <?php foreach ($region as $value) { ?>
                                                 
                                              <option><?php echo $value->region_name ?></option>
                                            <?php } ?>
                                          </select>
                                      </div>

                                 <?php }?>


                                <!-- <input type="text" name="todate" class="form-control " value="<?php echo $dep_name; ?>" > -->

                                    <div class="form-group col-md-3 m-t-10">
                                         <button type="submit" class="btn btn-info Search" id="Search"> <i class="fa fa-search"></i> Search </button>
                                          <h3 id="loadingtext" style="color: red;"></h3>
                                    </div>
                                <!-- </form> -->
                            </div>
                            <button class="btn btn-info" onclick="download_table_as_csv('exceldownload')"><i class="fa fa-print"></i> Excel</button>
                         <button class="btn btn-info" onclick="printContent('div1')"><i class="fa fa-print"></i> Print</button>
 <div class="table-responsive" id="div1">

<div class="panel-footer text-center">
<img src="<?php echo base_url(); ?>assets/images/tcp.png" height="100px" width="200px"/>
<br />
</div>


<div class="update">



    <div class="panel-footer text-center">
        <h3> <strong> SHIRIKA LA POSTA TANZANIA </strong> </h3>
        <h3 style="text-transform: uppercase;"> <strong> <span id="reportRegion"></span> EMS BUSINESS PERFORMANCE </strong> </h3>
        <h3> <strong> From:<span id="fromdateText"></span>  &nbsp; &nbsp; &nbsp;  <b>To:</b> </b> <span id="todateText"></span>  </strong> </h3>
    </div>


    <table id="dropedarea" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%" style="width: 100%;font-size: 25px; " id="exceldownload">
        <tr style="font-size: 18px;"><th colspan="16" > </th>
        </tr>
        <tr style="text-align: center;font-size: 18px;">
            <th></th>
            <th colspan="2" > Document/Parcel </th>
             <th colspan="2" >  Ems Cargo </th>
             <th colspan="2" > Parcel Charge </th>
             <th colspan="2" > Loan Board (HELSB) </th>
             <th colspan="2" > PCUM </th>
             <th colspan="2" > Domestic Bill </th>
             <th colspan="2" > International cash </th>
             <th colspan="2" > International Bill </th>
        </tr>
        <tr style="text-align: right;font-size: 16px;">
            <th> OFFICE </th>
            <th>NO </th>
             <th> AMOUNT </th>
             <th>NO  </th>
             <th> AMOUNT </th>
             <th>NO  </th>
             <th> AMOUNT </th>
             <th>NO  </th>
             <th> AMOUNT </th>
             <th>NO  </th>
             <th> AMOUNT </th>
             <th>NO  </th>
             <th> AMOUNT </th>
             <th>NO  </th>
             <th> AMOUNT </th>
             <th>NO  </th>
             <th> AMOUNT </th>
        </tr>
        <tr style="font-size: 17px;">
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td></td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
        </tr>

        <!-- <div id="dropedarea"></div> -->

    </table>




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

                    $('#fromdateText').html(fromdate)
                    $('#todateText').html(todate)
                    $('#reportRegion').html(region)
                    
                      $.ajax({
                     
                      url: "<?php echo base_url();?>Reports/ems_Consolidated_Search_Reports",
                      type:"POST",
                      dataType:'json',
                      data:{fromdate:fromdate,todate:todate,region:region},
                      success: function(res){
                        $("#dropedarea").find("tr:gt(2)").html('')

                        // console.log(res)
                       
                        var html = '';
                        var totalRow = '';

                        //EMS
                         var EMSCashNoTotal = 0;
                         var EMSCashAmountTotal = 0;

                         var ParcelCashNoTotal = 0;
                         var ParcelCashAmountTotal = 0;

                         var EMSBillhNoTotal = 0;
                         var EMSBillAmountTotal = 0;

                          var CashIntNoTotal = 0;
                          var CashIntAmountTotal = 0;

                          var billIntNoTotal = 0;
                          var billIntAmountTotal = 0;

                          var PCUMCashNoTotal = 0;
                          var PCUMCashAmountTotal = 0;

                          var LoanBoardCashNoTotal = 0;
                          var LoanBoardCashAmountTotal = 0;

                          //Trying to avoid errors for the branch which has no data
                          if(res.status == 'found'){
                              $('.statusText').html('<strong>Successfully</strong>');

                               $.each(res.data,function(index,data){

                               let billIntNo = (data.EMSintBillhNo === undefined )? 0:data.EMSintBillhNo; 
                               let billIntAmount = (data.EMSintBillAmount === undefined )? 0:data.EMSintBillAmount; 
                               //------------
                               let CashIntNo = (data.EMSintCashNo === undefined )? 0:data.EMSintCashNo; 
                               let CashIntAmount = (data.EMSintCashAmount === undefined )? 0:data.EMSintCashAmount; 
                               //------------
                               let EMSBillhNo = (data.EMSBillhNo === undefined )? 0:data.EMSBillhNo;
                               let EMSBillAmount = (data.EMSBillAmount === undefined )? 0:data.EMSBillAmount;
                               //---------
                               let ParcelCashNo = (data.ParcelCashNo === undefined )? 0:data.ParcelCashNo;
                               let ParcelCashAmount = (data.ParcelCashAmount === undefined )? 0:data.ParcelCashAmount;
                               //-----------
                               let EMSCashNo = (data.EMSCashNo === undefined )? 0:data.EMSCashNo;
                               let EMSCashAmount = (data.EMSCashAmount === undefined )? 0:data.EMSCashAmount;
                               //---------------
                               let PCUMCashNo = (data.PCUMCashNo === undefined )? 0:data.PCUMCashNo;
                               let PCUMCashAmount = (data.PCUMCashAmount === undefined )? 0:data.PCUMCashAmount;
                               //-----------------
                               let LoanBoardCashNo = (data.LoanBoardCashNo === undefined )? 0:data.LoanBoardCashNo;
                               let LoanBoardCashAmount = (data.LoanBoardCashAmount === undefined )? 0:data.LoanBoardCashAmount;


                               EMSCashNoTotal += parseInt(EMSCashNo);
                               EMSCashAmountTotal += parseInt(EMSCashAmount);

                               ParcelCashNoTotal += parseInt(ParcelCashNo);
                               ParcelCashAmountTotal += parseInt(ParcelCashAmount);

                               EMSBillhNoTotal += parseInt(EMSBillhNo);
                               EMSBillAmountTotal += parseInt(EMSBillAmount);

                               CashIntNoTotal += parseInt(CashIntNo);
                               CashIntAmountTotal += parseInt(CashIntAmount);

                               billIntNoTotal += parseInt(billIntNo);
                               billIntAmountTotal += parseInt(billIntAmount);

                               PCUMCashNoTotal += parseInt(PCUMCashNo);
                               PCUMCashAmountTotal += parseInt(PCUMCashAmount);

                               LoanBoardCashNoTotal += parseInt(LoanBoardCashNo);
                               LoanBoardCashAmountTotal += parseInt(LoanBoardCashAmount);

                               html = "<tr style='font-size: 17px;'>"
                                       +"<td>"+data.office+"</td>"
                                       +"<td>"+number_format(EMSCashNo)+"</td>"
                                       +"<td>"+number_format(EMSCashAmount)+"</td>"
                                       +"<td>0</td>"
                                       +"<td>0</td>"
                                       +"<td>"+number_format(ParcelCashNo)+"</td>"
                                       +"<td>"+number_format(ParcelCashAmount)+"</td>"
                                       +"<td>"+number_format(LoanBoardCashNo)+"</td>"
                                       +"<td>"+number_format(LoanBoardCashAmount)+"</td>"
                                       +"<td>"+number_format(PCUMCashNo)+"</td>"
                                       +"<td>"+number_format(PCUMCashAmount)+"</td>"
                                       +"<td>"+number_format(EMSBillhNo)+"</td>"
                                       +"<td>"+number_format(EMSBillAmount)+"</td>"
                                       +"<td>"+number_format(CashIntNo)+"</td>"
                                       +"<td>"+number_format(CashIntAmount)+"</td>"
                                       +"<td>"+number_format(billIntNo)+"</td>"
                                       +"<td>"+number_format(billIntAmount)+"</td></tr>";


                                       //TOTAL row
                               totalRow = "<tr style='font-size: 17px;font-weight: bold;text-align: left;'>"
                                       +"<td>TOTAL</td>"
                                       +"<td>"+number_format(EMSCashNoTotal)+"</td>"
                                       +"<td>"+number_format(EMSCashAmountTotal)+"</td>"
                                       +"<td>0</td>"
                                       +"<td>0</td>"
                                       +"<td>"+number_format(ParcelCashNoTotal)+"</td>"
                                       +"<td>"+number_format(ParcelCashAmountTotal)+"</td>"
                                       +"<td>"+number_format(LoanBoardCashNoTotal)+"</td>"
                                       +"<td>"+number_format(LoanBoardCashAmountTotal)+"</td>"
                                       +"<td>"+number_format(PCUMCashNoTotal)+"</td>"
                                       +"<td>"+number_format(PCUMCashAmountTotal)+"</td>"
                                       +"<td>"+number_format(EMSBillhNoTotal)+"</td>"
                                       +"<td>"+number_format(EMSBillAmountTotal)+"</td>"
                                       +"<td>"+number_format(CashIntNoTotal)+"</td>"
                                       +"<td>"+number_format(CashIntAmountTotal)+"</td>"
                                       +"<td>"+number_format(billIntNoTotal)+"</td>"
                                       +"<td>"+number_format(billIntAmountTotal)+"</td></tr>";


                                   //total row
                                $('#dropedarea').append(html)

                              })
                              
                              //General Total Row
                              $('#dropedarea').append(totalRow)
                          }else{
                           $('.statusText').html('<strong>'+res.data+'</strong>');
                          }


                           //Removing the message line after a second
                           setTimeout(function(){
                               $('.statusText').html('');
                           },3000)


                        $('#loadingtext').hide();
                        //$(".update").html(data);
                      }
                  });


                });


                function number_format(number) {
                  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                }



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

// Quick and simple export target #table_id into a csv
function download_table_as_csv(table_id, separator = ',') {
    // Select rows from table_id
    var rows = document.querySelectorAll('table#' + table_id + ' tr');
    // Construct csv
    var csv = [];
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll('td, th');
        for (var j = 0; j < cols.length; j++) {
            // Clean innertext to remove multiple spaces and jumpline (break csv)
            var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
            // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
            data = data.replace(/"/g, '""');
            // Push escaped string
            row.push('"' + data + '"');
        }
        csv.push(row.join(separator));
    }
    var csv_string = csv.join('\n');
    // Download it
    var filename = 'export_' + table_id + '_' + new Date().toLocaleDateString() + '.csv';
    var link = document.createElement('a');
    link.style.display = 'none';
    link.setAttribute('target', '_blank');
    link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
    <?php $this->load->view('backend/footer'); ?>