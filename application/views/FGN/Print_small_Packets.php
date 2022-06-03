<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
  <div class="message"></div>
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i>&nbsp 
       
      
                      Small Packet</h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">

                        Small Packet</li>
                      </ol>
                    </div>
                  </div>

                  <!-- Container fluid  -->
                  <!-- ============================================================== -->
                  <div class="container-fluid">
                   <br>
                    

                <div class="row" style="font-size:22px ;">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-header">
                                <h4 class="m-b-0 text-white"> 
                                
                            
                         <a href="<?php echo base_url(); ?>Services/Small_Packets" class="btn btn-primary waves-effect waves-light">New Small Packet</a>
                             <a href="<?php echo base_url(); ?>Packet_Application/Receive" class="btn btn-primary waves-effect waves-light">Receive/Itemazation</a>

                              <!-- <a href="<?php echo base_url(); ?>Packet_Application/Received?>" class="btn btn-primary waves-effect waves-light">Received</a> -->

                                <a href="<?php echo base_url(); ?>Packet_Application/Pass" class="btn btn-primary waves-effect waves-light">Pass Item</a>

                        
                                
                             </h4>
                            </div>
                      <div class="card-body">


                                  <form method="post" action="<?php echo base_url(); ?>Packet_Application/print_Packet_report">
                        
                         
                             <div class="row">
                                <div class="col-md-12">
                              <table class="table table-bordered" style="width: 100%;border: none;">
                                <tr>
                                    

                                  <th style="text-transform: uppercase;"  >
                                <div class="input-group">

                                <input type="text" name="rec_region" value="<?php echo @$report->region; ?>" hidden>
                                 <input type="text" name="rec_branch" value="<?php echo @$report->branch; ?>" hidden>
                              </div> 
                           
                                </th>
                           



                              <th style="">
                                 <div class="input-group">
                                      <button type="submit" class="btn btn-info waves-effect waves-light" name="submitinfo"> <i class="fa fa-print"></i> Print </button>
                                </div>
                            </th>
                             
                        </tr>
                        
                        </table>
                    </div>
                   
                </div>

                            
                            
                        </form>


                      <!-- <button class="btn btn-info div1" id="div1" onclick="printContent('div1')"><i class="fa fa-print"></i> Print</button> -->

                     <!--  <a href="
                               <?php echo base_url()?>Box_Application/download3?trn=<?php echo @$getbags->bag_number; ?>"data-bagno = "<?php echo @$getbags->bag_number; ?>" class="btn btn-primary">Wordocument
                                </a> -->

                          <br>

                        <div class="">
                          <div class="div2" id="div2">
                           

                           <table  class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%" style="border:2px;color:#000;font-size: 20px;font-weight: bold;">
                            <thead>
    
                          <tr>
                          <th colspan="6">
                         

                         <img src="<?php echo base_url(); ?>assets/images/tcp.png" height="100px" width="200px" style="display: block; margin-left: auto; margin-right: auto;"/>
                           <center>TANZANIA POSTS CORPORATION <br>
                          Small Packet List
                          </center>
                            

                          </th>
                          </tr>

                          


                          <tr>
                          <th colspan="2">
                          From: <?php echo @$report->region_from; ?>
                          </th>
                          <th colspan="3">
                          To: <?php echo @$report->region; ?>
                          </th>
                          </tr>
                            
                         
                      </thead>
                      </table>
                         

                        <table  class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%" style="border:2px;color:#000;font-size: 20px;font-weight: bold;">
                         <thead>         

                            <tr>
                                    <th> S/N </th>
                                     <th>Barcode Number</th>
                                     <th>Origin Branch</th>
                                    <th>Destination Branch</th>
                                </tr>
                            </thead>

                            <tbody>
                              <?php $sn=1; ?>
                               <?php foreach (@$reports as  $value) {?>
                                   <tr>
                                 
                                     <td> <?php echo $sn; ?> </td>
                                      <td> <?php  echo @$value->FGN_number; ?>  </td>
                                      <td><?php echo @$value->branch_from;?></td>
                                       <td><?php echo @$value->branch;?></td>
                                    </tr>
                              <?php $sn++; } ?>
                            </tbody>
                        </table>

 <table  class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%" style="border:2px;color:#000;font-size: 20px;font-weight: bold;">
    <tr>

    <td></td>
<td colspan="3">Remarks: 
<br><br><br><br>
</td>
<td colspan="3">Receiving Office Date Stamp:
<br><br><br><br>
</td>
</tr>

<tr style="font-size:22px ;">
<td>Prepared by <b><?php echo @$staff; ?></b></td>
<td>Carried by ........................................... </td>
<td colspan="6">Received by ...............................</td>
   
</tr>


</table>

 </div>
                      
                      </div>
                      </div>
                      </div>

                      </div>
                            <!-- ============================================================== -->

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

                
<script type="text/javascript">
    $(document).ready(function() {
    
    $('.div1').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
    var restorepage = document.body.innerHTML;
  var printcontent = document.getElementById('div2').innerHTML;
  document.body.innerHTML = printcontent;
  window.print();
  document.body.innerHTML = restorepage;
    });  
 
});
</script>



                           

                          </div> </div> </div> 







<?php $this->load->view('backend/footer'); ?>
