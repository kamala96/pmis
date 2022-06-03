
<?php


class Supervisor_ViewModel extends CI_Model
{
    public $date_registered;
    public $track_number;
    public $s_region;
    public $s_district;
    public $s_fullname;
    public $s_address;
    public $s_email;
    public $s_mobile;
    public $operator;
    public $s_status;
      public $sender_id;

    public $r_region;
    public $branch;
    public $receiver_id;
    public $fullname;
    public $address;
    public $email;
    public $mobile;

    public $billid;
    public $office_name;
    public $status;
    public $id;
    public $paidamount;

    public $receivertype;
    public $s_pay_type;
  public $service_name;
   public $Barcode;

    

     function __consturct(){parent::__construct();}

         public function view_data($sender_id,$date_registered, $track_number, $s_region, $s_district,
            $s_fullname, $s_address,$s_email, $s_mobile,$operator, $s_status,
             $r_region, $branch,$receiver_id, $fullname, $address,$email,$mobile, 
             $billid, $office_name, $status,$id, $paidamount, $receivertype,$s_pay_type,$service_name)
         {
              //parent::__construct();

            $data = array();
             $data = array(
            'date_registered'=> $date_registered,
            'track_number'=>$track_number,
           's_region'=>$s_region,
           's_district'=>$s_district,
           's_fullname'=>$s_fullname,
           's_address'=>$s_address,
           's_email'=>$s_email,
           's_mobile'=>$s_mobile,
           'operator'=>$operator,
          's_status'=>$s_status,
           'sender_id'=>$sender_id,

           'r_region'=>$r_region,
           'branch'=>$branch,
           'receiver_id'=>$receiver_id,
           'fullname'=>$fullname,
           'address'=>$address,
           'email'=>$email,
           'mobile'=>$mobile,

           'billid'=>$billid,
           'office_name'=>$office_name,
           'status'=>$status,
           'id'=>$id,
            'paidamount'=>$paidamount,

           'receivertype'=>$receivertype,
            's_pay_type'=>$s_pay_type,
            // 'Barcode'=>$Barcode,
            'service_name'=>$service_name
        );
             return $data;

            // $this->date_registered= $date_registered;
            // $this->track_number=$track_number;
            // $this->s_region=$s_region;
            // $this->s_district=$s_district;
            // $this->s_fullname=$s_fullname;
            // $this->s_address=$s_address;
            // $this->s_email=$s_email;
            // $this->s_mobile=$s_mobile;
            // $this->operator=$operator;
            // $this->s_status=$s_status;
            // $this->sender_id=$sender_id;

            // $this->r_region=$r_region;
            // $this->branch=$branch;
            // $this->receiver_id=$receiver_id;
            // $this->fullname=$fullname;
            // $this->address=$address;
            // $this->email=$email;
            // $this->mobile=$mobile;

            // $this->billid=$billid;
            // $this->office_name=$office_name;
            // $this->status=$status;
            // $this->id=$id;
            // $this->paidamount=$paidamount;

            // $this->receivertype=$receivertype;
            // $this->s_pay_type=$s_pay_type;
            // $this->service_name=$service_name;




            

        }

         public function view_data1($sender_id,$date_registered, $track_number, $s_region, $s_district,
            $s_fullname, $s_address,$s_email, $s_mobile,$operator, $s_status,
             $r_region, $branch,$receiver_id, $fullname, $address,$email,$mobile, 
             $billid, $office_name, $status,$id, $paidamount, $receivertype,$s_pay_type,$service_name,$Barcode)
         {
              //parent::__construct();

            $data = array();
             $data = array(
            'date_registered'=> $date_registered,
            'track_number'=>$track_number,
           's_region'=>$s_region,
           's_district'=>$s_district,
           's_fullname'=>$s_fullname,
           's_address'=>$s_address,
           's_email'=>$s_email,
           's_mobile'=>$s_mobile,
           'operator'=>$operator,
          's_status'=>$s_status,
           'sender_id'=>$sender_id,

           'r_region'=>$r_region,
           'branch'=>$branch,
           'receiver_id'=>$receiver_id,
           'fullname'=>$fullname,
           'address'=>$address,
           'email'=>$email,
           'mobile'=>$mobile,

           'billid'=>$billid,
           'office_name'=>$office_name,
           'status'=>$status,
           'id'=>$id,
            'paidamount'=>$paidamount,

           'receivertype'=>$receivertype,
            's_pay_type'=>$s_pay_type,
            'Barcode'=>$Barcode,
            'service_name'=>$service_name
        );
             return $data;



            

        }

        public  function create($sender_id,$date_registered, $track_number, $s_region, $s_district,
            $s_fullname, $s_address,$s_email, $s_mobile,$operator, $s_status,
             $r_region, $branch,$receiver_id, $fullname, $address,$email,$mobile, 
             $billid, $office_name, $status,$id, $paidamount, $receivertype,$s_pay_type,$service_name,$Barcode){
    
        return  $this->view_data($sender_id,$date_registered, $track_number, $s_region, $s_district,
            $s_fullname, $s_address,$s_email, $s_mobile,$operator, $s_status,
             $r_region, $branch,$receiver_id, $fullname, $address,$email,$mobile, 
             $billid, $office_name, $status,$id, $paidamount, $receivertype,$s_pay_type,$service_name,$Barcode);
    
}
}  

?>