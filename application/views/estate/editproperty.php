<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<style type="text/css">
.editable-select {
    width: 90%;
}

.jumbotron {
    padding: 2rem 2rem;
}
</style>


<div class="page-wrapper">
    <!-- == -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- == -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Edit Property</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Realestate/Propertylist">Property List</a>
                </li>
                <li class="breadcrumb-item active">Edit Property</li>
            </ol>
        </div>
    </div>
    <div class="message"></div>
    <?php $degvalue = $this->employee_model->getdesignation(); ?>
    <?php $depvalue = $this->employee_model->getdepartment(); ?>
    <?php $usertype = $this->employee_model->getusertype(); ?>
    <?php  ?>
    <?php $regvalue1 = $this->employee_model->branchselect(); ?>
    <div class="container-fluid">

        <div class="row m-b-10">
            <!-- <div class="col-12">
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php //echo base_url(); ?>Realestate/Propertylist" class="text-white"><i class="" aria-hidden="true"></i>  Back Property List</a></button>
                        
                    </div> -->
        </div>


        <div id="content-wrapper">

            <div class="container-fluid">


                <div class="row">
                    <div class="col-lg-6">
                        <?php echo validation_errors(); ?>
                        <?php echo $this->upload->display_errors(); ?>

                        <?php echo $this->session->flashdata('formdata'); ?>
                        <?php echo $this->session->flashdata('feedback'); ?>


                        <?php foreach($property as $value):
                              $image_path = $value->image_path;?>

                        <form action="SaveEditproperty" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="attachproperty">
                            <input type="hidden" name="id" value="<?php echo $value->id ?>">
                            <button class="btn btn-primary" type="submit" style="margin-bottom: 1em;">Save
                                Property</button>
                           
                            <div class="card mb-3 ">
                                <div class="card-header">
                                    Property Information<?php echo $value->additional_info ?>
                                </div>
                                <div class="card-body">
                                  
                                    <div class="form-group">
                                        <label>Property Type: </label><br>
                                        <?php 
                  if($value->property_type == "Vacant  Land")
                  {?>

                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="property_type" value="Vacant  Land" id="1"
                                                checked> Vacant Land
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="property_type" id=""
                                                value="Residential  Property"> Residential Property
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="property_type" id="3"
                                                value="Commercial Property"> Commercial
                                        </label>


                                        <?php   }
                  elseif ($value->property_type == "Residential  Property") 
                  {?>

                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="property_type" value="Vacant  Land" id="1">
                                            Vacant Land
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="property_type" id=""
                                                value="Residential  Property" checked> Residential Property
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="property_type" id="3"
                                                value="Commercial Property"> Commercial
                                        </label>
                                        <?php }
                  elseif ($value->property_type == "Commercial Property") 
                  {?>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="property_type" value="Vacant  Land" id="1">
                                            Vacant Land
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="property_type" id=""
                                                value="Residential  Property"> Residential Property
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="property_type" id="3"
                                                value="Commercial Property" checked> Commercial
                                        </label>
                                        <?php  }
                elseif ($value->property_type == "") 
                {?>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="property_type" value="Vacant  Land" id="1">
                                            Vacant Land
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="property_type" id=""
                                                value="Residential  Property"> Residential Property
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="property_type" id="3"
                                                value="Commercial Property" checked> Commercial
                                        </label>
                                        <?php  }
              ?>


                                    </div>
                                    <div class="form-group ">
                                        <!-- <label>Issue Date </label><br> -->
                                        <input type="text" name="property_name" placeholder="Property name"
                                            value="<?php echo $value->property_name ?>" class="form-control "
                                            style="width: 40%;display: inline;">
                                        <input type="text" name="RegistrationNo"
                                            value="<?php echo $value->RegistrationNo ?>"
                                            placeholder="Registration number" class="form-control "
                                            style="width: 40%;display: inline;">

                                    </div>
                                    <div class="form-group ">
                                        <!-- <label>Issue Date </label><br> -->
                                        <input type="date" name="DateofReg" value="<?php echo $value->DateofReg ?>"
                                            placeholder="Date of registration" class="form-control "
                                            style="width: 40%;display: inline;">
                                        <input type="text" name="Plot" value="<?php echo $value->Plot ?>"
                                            placeholder="Plot number" class="form-control "
                                            style="width: 40%;display: inline;">

                                    </div>

                                    <div class="form-group ">
                                        <!-- <label>Issue Date </label><br> -->
                                        <input type="Number" name="property_size"
                                            value="<?php echo $value->property_size ?>" placeholder="Property size"
                                            class="form-control " style="width: 40%;display: inline;">
                                        <select id="sizeUnit" class="custom-select radio-inline" name="size_unit"
                                            style="width: 40%;display: inline;">
                                            <?php 
                  if($value->size_unit == "0")
                  {?>

                                            <option value="0">Square meter</option>
                                            <option value="1">Hectare</option>


                                            <?php   }
                  elseif ($value->size_unit == "1") 
                  {?>
                                            <option value="1">Hectare</option>
                                            <option value="0">Square meter</option>

                                            <?php  }
              ?>


                                        </select>
                                    </div>

                                    <div class="form-group ">
                                        <!-- <label>Issue Date </label><br> -->
                                        <select name="Region" value="" class="form-control custom-select"
                                            style="width: 40%;display: inline;" id="regiono" onChange="getDistrict();">
                                            <option value="<?php echo $value->Region ?>"><?php echo $value->Region ?>
                                            </option>
                                            <?Php foreach($region as $value1): ?>
                                            <option value="<?php echo $value1->region_name ?>">
                                                <?php echo $value1->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <select name="District" value="" class="form-control custom-select"
                                            style="width: 40%;display: inline;" id="branchdropo">
                                            <option value="<?php echo $value->District ?>">
                                                <?php echo $value->District ?></option>
                                        </select>

                                    </div>
                                    <div class="form-group ">
                                        <!-- <label>Issue Date </label><br> -->
                                        <input type="text" name="address" value="<?php echo $value->address ?>"
                                            placeholder="address" class="form-control "
                                            style="width: 40%;display: inline;">
                                        <input type="text" name="postal_code" value="<?php echo $value->postal_code ?>"
                                            placeholder="Postal Code" class="form-control "
                                            style="width: 40%;display: inline;">

                                    </div>
                                    <div class="form-group">
                                        <label>Property Usage: </label><br>

                                        <?php 
                  if($value->PropertyUsage == "Office")
                  {?>

                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="PropertyUsage" value="Office" id="1" checked>
                                            Office
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="PropertyUsage" id="2"
                                                value="Office & Residential"> Office & Residential
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="PropertyUsage" id="3" value="Residential">
                                            Residential
                                        </label>


                                        <?php   }
                  elseif ($value->PropertyUsage == "Office & Residential") 
                  {?>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="PropertyUsage" value="Office" id="1"> Office
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="PropertyUsage" id="2"
                                                value="Office & Residential" checked> Office & Residential
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="PropertyUsage" id="3" value="Residential">
                                            Residential
                                        </label>


                                        <?php  }
               elseif ($value->PropertyUsage == "Residential") 
               {?>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="PropertyUsage" value="Office" id="1"> Office
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="PropertyUsage" id="2"
                                                value="Office & Residential"> Office & Residential
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="PropertyUsage" id="3" value="Residential"
                                                checked> Residential
                                        </label>

                                        <?php  }
           elseif ($value->PropertyUsage == "Office (TPC HQ)") 
           {?>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="PropertyUsage" value="Office (TPC HQ)" id="1"
                                                checked> Office (TPC HQ)
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="PropertyUsage" id="2"
                                                value="Office & Residential"> Office & Residential
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="PropertyUsage" id="3" value="Residential">
                                            Residential
                                        </label>

                                        <?php  }
        elseif ($value->PropertyUsage == "") 
        {?>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="PropertyUsage" value="Office" id="1" checked>
                                            Office
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="PropertyUsage" id="2"
                                                value="Office & Residential"> Office & Residential
                                        </label>
                                        <label class="form-control" style="border: none;">
                                            <input type="checkbox" name="PropertyUsage" id="3" value="Residential">
                                            Residential
                                        </label>

                                        <?php  }
              ?>





                                    </div>


                                    <!--upload property image -->

                                    <div class="input-group addborder" style="margin-bottom: 1em;">
                                        <?php if($image_path == 'no-image-land.png'){
                    echo '<img src="'.base_url().'images/'.$image_path.'" style="width: 200px; height: 200px;"><br>';
                   }
                  else{
                    echo '<img src="'.base_url().'images/no-image-land.png" style="width: 150px; height: 140px;"><br>';
                  }
               ?>

                                    </div>
                                    <div class="input-group addborder" style="margin-bottom: 1em;">

                                        <span class="input-group-btn">
                                            <span class="btn btn-default btn-file">
                                                Browse… picture <input type="file" id="imgInp" name="image">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <!--upload property image -->
                                    <!-- if subdevided lot-->
                                    <i class="text-muted small">Fill up if subdevided </i>
                                    <div class="form-group jumbotron" style="text-align: center;">

                                        <label>Block:
                                            <input type="text" name="block" class="form-control"
                                                value="<?php echo $value->block ?>" placeholder="value numeric">
                                        </label>
                                        <!-- <label>Lot: 
              <input type="text" name="lot" class="form-control" placeholder="value numeric">
            </label> -->
                                    </div>







                                </div>
                            </div>
                    </div>
                    <div class="col-lg-6" style="margin-top: 3.2em;">
                        <div class="card mb-3">
                            <div class="card-header">
                                Additional information
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="property_condition" value="0">
                             
                                <div class="form-group">
                                    <label>Property Status: </label><br>

                                    <?php 
                  if($value->Status == "Developed")
                  {?>

                                    <label class="form-control" style="border: none;">
                                        <input type="checkbox" name="Status" value="Developed" id="1" checked> Developed
                                    </label>
                                    <label class="form-control" style="border: none;">
                                        <input type="checkbox" name="Status" id="2" value="Developed(tpc/ttcl)">
                                        Developed(tpc/ttcl)
                                    </label>
                                    <label class="form-control" style="border: none;">
                                        <input type="checkbox" name="Status" id="3" value="Undeveloped"> Undeveloped
                                    </label>


                                    <?php   }
                  elseif ($value->Status == "Developed(tpc/ttcl)") 
                  {?>
                                    <label class="form-control" style="border: none;">
                                        <input type="checkbox" name="Status" value="Developed" id="1"> Developed
                                    </label>
                                    <label class="form-control" style="border: none;">
                                        <input type="checkbox" name="Status" id="2" value="Developed(tpc/ttcl)" checked>
                                        Developed(tpc/ttcl)
                                    </label>
                                    <label class="form-control" style="border: none;">
                                        <input type="checkbox" name="Status" id="3" value="Undeveloped"> Undeveloped
                                    </label>


                                    <?php  }
               elseif ($value->Status == "Undeveloped") 
               {?>
                                    <label class="form-control" style="border: none;">
                                        <input type="checkbox" name="Status" value="Developed" id="1"> Developed
                                    </label>
                                    <label class="form-control" style="border: none;">
                                        <input type="checkbox" name="Status" id="2" value="Developed(tpc/ttcl)">
                                        Developed(tpc/ttcl)
                                    </label>
                                    <label class="form-control" style="border: none;">
                                        <input type="checkbox" name="Status" id="3" value="Undeveloped" checked>
                                        Undeveloped
                                    </label>

                                    <?php  }
           
        elseif ($value->Status == "") 
        {?>
                                    <label class="form-control" style="border: none;">
                                        <input type="checkbox" name="Status" value="Developed" id="1" checked> Developed
                                    </label>
                                    <label class="form-control" style="border: none;">
                                        <input type="checkbox" name="Status" id="2" value="Developed(tpc/ttcl)">
                                        Developed(tpc/ttcl)
                                    </label>
                                    <label class="form-control" style="border: none;">
                                        <input type="checkbox" name="Status" id="3" value="Undeveloped"> Undeveloped
                                    </label>

                                    <?php  }
              ?>






                                </div>
                                <div class="form-group" id="sale">
                                    <!-- <label>Price per Sq.m. </label> -->
                                    <input id="pricePerSqm" class="form-control radio-inline" type="Number"
                                        name="price_per_sqm" value="<?php echo $value->price_per_sqm ?>"
                                        style="display: inline;width:40%;" placeholder=" Price per Sq.m."
                                        onkeyup="javascript:calculateBoughtPrice()">
                                    <!-- <label>Bought Price </label> -->
                                    <input id="inputPriceBought" class="form-control radio-inline" type="Number"
                                        name="PropertyValue" value="<?php echo $value->PropertyValue ?>"
                                        style="display: inline;width:40%;" placeholder="Property Value"><br>

                                </div>
                                <div class="form-group" id="sale">
                                    <!-- <label>Price per Sq.m. </label> -->
                                    <input id="landvalue" class="form-control radio-inline" type="Number"
                                        name="LandValue" value="<?php echo $value->LandValue ?>"
                                        style="display: inline;width:40%;" placeholder=" Land Value"
                                        onkeyup="javascript:calculateBoughtPrice()">
                                    <!-- <label>Bought Price </label> -->
                                    <input id="totalprice" class="form-control radio-inline" type="Number"
                                        name="Totalprice" value="<?php echo $value->Totalprice ?>"
                                        style="display: inline;width:40%;" placeholder=" Total price"><br>

                                </div>
                                <div class="form-group" id="rent">
                                    <label>Monthly Payment </label>
                                    <input id="input_monthly_payment" class="form-control radio-inline" type="Number"
                                        value="<?php echo $value->monthly_paymentRent ?>" name="monthly_paymentRent"
                                        style="display: inline;width:50%;" placeholder=" 0.00">
                                </div>

                            
                                <div class="form-group">
                                    <label>Additional information/comments: </label><br>
                                    <textarea class="form-control" name="additional_info" value=""
                                        placeholder="<?php echo $value->additional_info ?>" rows="10"></textarea>
                                </div>
                                </form>

                                <?php endforeach; ?>
                                <!--upload image -->
                                <div class="form-group">
                                    <label>Attachments [e.g. Pictures]</label>
                                    <div class="file_upload">
                                        <form action="<?php echo base_url(); ?>Realestate/UploadAttachment"
                                            class="dropzone">
                                            <div class="dz-message needsclick">
                                                <strong>Drop files here or click to upload.</strong><br />
                                                <span class="note needsclick">(Select or upload multiple
                                                    attachment)</span>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!--row -->

            </div>

        </div>
    </div>

    <!-- <script type="text/javascript">
    function getDistrict() {
    var region_id = $('#regiono').val();
     $.ajax({
     
     url: "<?php //echo base_url();?>Employee/GetBranch",
     method:"POST",
     data:{region_id:region_id},//'region_id='+ val, -->

    <script type="text/javascript">
    $(document).ready(function() {
        $('#1').change(function() {
            if (this.checked) {

            } else {

            }
        });
        $('#2').change(function() {
            if (this.checked) {

            } else {

            }
        });
    });
    </script>


    <script type="text/javascript">
    function getDistrict() {
        var region_id = $('#regiono').val();
        $.ajax({

            url: "<?php echo base_url();?>Employee/GetBranch",
            method: "POST",
            data: {
                region_id: region_id
            }, //'region_id='+ val,
            success: function(data) {
                $("#branchdropo").html(data);

            }
        });
    };
    </script>

    
    <script type="text/javascript">
    function calculate(val) {
        var total = parseInt(document.getElementById("inputPriceBought").value);
        var terms = 12 * (parseInt(val));
        var result = total / terms;

        $('#input_monthly_payment').val(result);
    }


    $(function() {
        $(".sidebar .nav-item").removeClass("active");
        $(".menu-attach-property").addClass("active");

    });

    function calculateBoughtPrice() {

        var size = Number($('#propertySize').val());
        var unit = Number($('#sizeUnit').val());
        var pricePerSqm = Number($('#pricePerSqm').val());
        var result = 0;

        if (unit == 1) {
            size *= 1000;
        }

        result = size * pricePerSqm;
        $("#inputPriceBought").val(result);

    }

    //upload image js
    $(document).ready(function() {
        $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = label;

            if (input.length) {
                input.val(log);
            } else {
                if (log) alert(log);
            }

        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });
    });
    </script>
    <?php $this->load->view('backend/footer'); ?>