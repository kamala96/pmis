<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
 <div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Transaction Tracing</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"><i class="fa fa-university" aria-hidden="true"></i> Tracing</li>
            </ol>
        </div>
    </div>
            
<div class="container-fluid">
    <div class="col-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Tracing                 
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered" width="100%">
                    
                    <tr>
                        <td>
                            <input type="text" class="form-control form-control-line" placeholder="Barcode number" name="barcode" id="barcode">
                        </td>
                        <td>
                            <button onclick="searchTransaction(this)" type="submit" class="btn btn-info col-md-12" id="BtnSubmit">Check</button>
                        </td>
                    </tr>
                    
                </table>
            </div>

            <div class="card-body">
                <div style="display: none;background-color: #d22c19;color: white;" id="forMessage" class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong id="notifyMessage"></strong>
                </div>
                <div class="row">
                      <div class="col-md-12">
                          <h2 id="loadingtext"></h2>
                      </div>
                  </div>
                <div >
                    <textarea id="reasonBox" style="display:none;" class="form-control" cols="20" rows="" placeholder="Please write the reasons"></textarea>
                </div>
                <div class="table-responsive">
                    <span id="infotab"></span>
                    <table id="example4" class="display nowrap table table-bordered fromServer2 receiveTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Barcode</th>
                                <th>From</th>
                                <th>Pass To</th>
                                <th>Office name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Branch</th>
                                <th>TimeStamp</th>
                            </tr>
                        </thead>
                        <tbody class="" id='emsListData'>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function searchTransaction(obj){
        var barcode = $('#barcode').val();

        $('#infotab').html("<h3 style='font-weight:bold'>Please wait............</h3>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Services/tracing_master",
            data:{barcode:barcode},
            dataType:'json',
            success:function(response){
                
                if (response['status'] == 'Success') {
                    //$('#loadingtext').html('SuccessFully');
                    $('#infotab').html(response['infotab'])
                    $('#emsListData').html(response['msg'])
                }else{
                    // $('#loadingtext').html('No Data found');
                    $('#infotab').html("<h3 style='font-weight:bold'>No Data found</h3>");
                    $('#emsListData').html(response['msg'])
                }

            },error:function(){

            }
        })
       
    }


</script>
<?php $this->load->view('backend/footer'); ?>