<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
 <div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Master Receipt</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"><i class="fa fa-university" aria-hidden="true"></i> Receipt</li>
            </ol>
        </div>
    </div>
            
<div class="container-fluid">
    <div class="col-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Master Receipt search                  
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered" width="100%">
                    
                    <tr>
                        <td>
                                    <select name="type" value="" class="form-control custom-select" required id="type">
                                            <option value="Realestate">Realestate</option>
                                           
                                        </select>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-line" placeholder="Controll number" name="cnumber" id="cnumber">
                        </td>
                            
                       
                        <td>
                            <button onclick="searchTransaction('#type','#cnumber')" type="submit" class="btn btn-info col-md-12" id="BtnSubmit">Search Receipt</button>
                        </td>
                    </tr>
                    
                </table>
            </div>

            <div class="card-body">
                <div style="display: none;background-color: #d22c19;color: white;" id="forMessage" class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong id="notifyMessage"></strong>
                </div>
                <div >
                    <textarea id="reasonBox" style="display:none;" class="form-control" cols="20" rows="" placeholder="Please write the reasons"></textarea>
                </div>
                <div class="table-responsive">
                    <table id="example4" class="display nowrap table table-bordered fromServer2 receiveTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Control Number</th>
                                <th>Customer Name </th>
                                <th>Mobile Number for</th>
                                <th>Amount Payed</th>
                                <th>Pay Channel</th>
                                <th>Receipt Number</th>
                                <th>Date Payed</th>
                                <th>Action</th>
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
    function searchTransaction(type,cnumber){
        var type = $(type).val();
        var cnumber = $(cnumber).val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Services/Search_Receipt",
            data:{type:type,cnumber:cnumber},
            dataType:'json',
            success:function(response){
                
                if (response['status'] == 'Success') {
                    $('#emsListData').html(response['msg'])
                }else{
                    $('#emsListData').html(response['msg'])
                }
                //console.log(response)

            },error:function(){

            }
        })
       
    }

    function allowEdit(){
        // var transId = transId;
        // var editbarcode  = 
        $('.editbarcode').removeAttr('disabled').removeAttr('readonly');
        $('#reasonBox').show();
        // console.log(transId);
        // console.log(editbarcode);
    }

    function editingProcess(obj){
        var barcode = $(obj).val();
        var transId = $(obj).attr('data-transId');
        var reasonText = $('#reasonBox').val();

        //console.log(transId)

        if (barcode.length != 13) {
            $('#optionBox').hide();
            $('#forMessage').show();
            $('#notifyMessage').html('Tafadhali barcode haijakamilika = 13');
        }else{
            if (reasonText == '') {
                $('#optionBox').hide();
                $('#forMessage').show();
                $('#notifyMessage').html('Tafadhali andika sababu');
            }else{
                $.ajax({
                    type : "POST",
                    url  : "<?php echo base_url();?>Box_Application/editBarcodeprocess",
                    data:{barcode:barcode,transid:transId,reasonMessage:reasonText},
                    dataType:'json',
                    success: function(data){
                         
                        if(data['status'] == 'error'){
                            
                            $('#forMessage').show();
                            $('#notifyMessage').html(data['message']);
                        }else{
                            
                            $('#forMessage').show();
                            //$('#notifyMessage').html('');
                            $('#notifyMessage').html(data['message']);
                        }
                    }
                });
            }
            
        }
    }


</script>
<?php $this->load->view('backend/footer'); ?>