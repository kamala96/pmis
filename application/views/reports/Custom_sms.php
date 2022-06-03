<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Service Sms  Application Form</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Service Sms  Application Form</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                   <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>reports/oldboxnotfy" class="text-white"><i class="" aria-hidden="true"></i>Sms Dashboard </a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Custom Sms Application Form
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                           <form method="POST" action="<?php echo base_url()?>Reports/Save_Custom_sms">
                               <div id="div1">
                                <div class="row">

                                <div class="col-md-12">
                                   <!--  <h3> Internet Form</h3> -->
                                </div>

                                

                                <div class="form-group col-md-6">
                                    <label>Add Phone Numbers:</label>
                                    <input type="tel" name="phonenumber" id="phonenumber" style="width:300px">
                                    <!-- <input type="text" name="phonenumber"  class="form-control" required="required" id="phonenumber"> -->
                                           
                                </div>

                               
                                 <div class="col-md-6">
                                <label>Custom Sms:</label>
                           <textarea name="text" id="text" class="form-control " rows="5" cols="10" required="required"></textarea>
                                
                                </div>

                               

                                </div>
                                <br>
                               
                              
                                
                                </div>


                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-info disable">Send Sms</button>
                                    </div>
                                </div>
                                </div>
                           </form>
                            </div>
                           </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>






<?php $this->load->view('backend/footer'); ?>
