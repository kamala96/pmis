
<?php


class Received_ViewModel extends CI_Model
{
    public $sender_fullname;
    public $sender_date_created;
    public $register_type;
    public $register_weght;
    public $date_registered;
    public $register_price;
    public $payment_type;
    public $sender_region;
    public $sender_branch;
    public $receiver_region;
    public $reciver_branch;
    public $billid;

    public $track_number;
     public $Barcode;
    public $sender_status;
    public $senderp_id;
    public $type;
    

     function __consturct(){parent::__construct();}

         public function view_data($sender_fullname,$sender_date_created, $register_type, $register_weght, $date_registered,
            $register_price, $payment_type,$sender_region, $sender_branch,$receiver_region, $reciver_branch,$billid,$track_number,$sender_status, $senderp_id,$type,$Barcode)
         {
              //parent::__construct();
    $data = array();
    $data = array(
    'sender_fullname'=>$sender_fullname,
    'sender_date_created'=>$sender_date_created,
    'register_type'=>$register_type,
    'register_weght'=>$register_weght,
    'date_registered'=>$date_registered,
    'register_price'=>$register_price,
    'payment_type'=>$payment_type,
    'sender_region'=>$sender_region,
    'sender_branch'=>$sender_branch,
   'receiver_region'=>$receiver_region,
    'reciver_branch'=>$reciver_branch,
    'billid'=>$billid,

    'track_number'=>$track_number,
    'sender_status'=>$sender_status,
    'senderp_id'=>$senderp_id,
    'type'=>$type,
    'Barcode'=>$Barcode
     );
             return $data;

          

          

        }

        public  function create($sender_fullname,$sender_date_created, $register_type, $register_weght, $date_registered,
            $register_price, $payment_type,$sender_region, $sender_branch,$receiver_region, $reciver_branch,$billid,$track_number,$sender_status, $senderp_id,$type,$Barcode){
    
        return  $this->view_data($sender_fullname,$sender_date_created, $register_type, $register_weght, $date_registered,
            $register_price, $payment_type,$sender_region, $sender_branch,$receiver_region, $reciver_branch,$billid,$track_number,$sender_status, $senderp_id,$type,$Barcode);
    
}
}  

?>