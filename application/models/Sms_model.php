<?php

class Sms_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}

          public function save_sms($data){
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('smsresend',$data);
        }

         public function get_sms_byservice($servicename){
        //HR DATABASE
        $db2 = $this->load->database('otherdb', TRUE);
      $sql= "SELECT * FROM `smsresend` WHERE `servicename`='$servicename' AND `status`='isNotsent'";
        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 

    public function get_sms_unsent(){
        //HR DATABASE
        $db2 = $this->load->database('otherdb', TRUE);
      $sql= "SELECT * FROM `smsresend` WHERE  `status`='isNotsent'";
        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 

    public function Update_sms2($id){
            $db2 = $this->load->database('otherdb', TRUE);
             $db2->set('status','issent');
       
        $db2->where('id', '$id');
        $db2->update('smsresend');  

        //UPDATE `smsresend` SET `status`='issent' WHERE `status`='isNotsent'     
    }

    public function Update_sms($id){
          $db2 = $this->load->database('otherdb', TRUE);
            $sql= "UPDATE `smsresend` SET `status`='issent' WHERE `id` = $id ";
            $query=$db2->query($sql);
            }



    public function send_sms_trick($s_mobile,$sms)
    {
         $mobile = trim($s_mobile);
         $mobile = str_replace(array(' ','-'), '',  $mobile);
        $mobile = '255'.substr($mobile, -9);
        $url = 'http://192.168.33.2/modules/otsms/process.php?msisdn='.$mobile.'&message='.urlencode($sms);
      
                //$urloutput=file_get_contents($url,);

            // $ctx = stream_context_create(['http'=> ['timeout' => 2]]); // 5 seconds
            // $urloutput = file_get_contents($url,null,$ctx);
        // $options = stream_context_create(array('http'=>
        //     array(
        //         //'method' => 'GET',
        //     'timeout' =>10.0,
        //     'ignore_errors' => true,
        //     )
        // ));
        //     $urloutput = file_get_contents($url , false, $options);

                //$urloutput=file_get_contents($url);
              //return $urloutput;


// @$urloutput=file_get_contents($url);
// if($urloutput === FALSE) {
    
//     echo 'error';
// } else {
    
// }

//@$data = file_get_contents($url);  //SMS WORKING UNCOMMENT
@$data = FALSE;
if($data === FALSE) {
     // $error = error_get_last();
      //echo "HTTP request failed. Error was: " . $error['message'];
      //save sms to send latel

              $custom = array();
        $custom = array(
          'MobileNumber' => $mobile,
          'status' => 'isNotsent',
          'message' => $sms
        );
           $this->save_sms($custom);
} else {
      //echo "Everything went better than expected";

      $custom = array();
        $custom = array(
          'MobileNumber' => $mobile,
          'status' => 'issent',
          'message' => $sms
        );
           $this->save_sms($custom);
}
              
    }


     public function send_sms_trick2($s_mobile,$sms,$servicename)
    {
         $mobile = trim($s_mobile);
         $mobile = str_replace(array(' ','-'), '',  $mobile);
        $mobile = '255'.substr($mobile, -9);
        $url = 'http://192.168.33.2/modules/otsms/process.php?msisdn='.$mobile.'&message='.urlencode($sms);
      
                //$urloutput=file_get_contents($url,);

            // $ctx = stream_context_create(['http'=> ['timeout' => 2]]); // 5 seconds
            // $urloutput = file_get_contents($url,null,$ctx);
        // $options = stream_context_create(array('http'=>
        //     array(
        //         //'method' => 'GET',
        //     'timeout' =>10.0,
        //     'ignore_errors' => true,
        //     )
        // ));
        //     $urloutput = file_get_contents($url , false, $options);

                //$urloutput=file_get_contents($url);
              //return $urloutput;


// @$urloutput=file_get_contents($url);
// if($urloutput === FALSE) {
    
//     echo 'error';
// } else {
    
// }


//@$data = file_get_contents($url);  //SMS WORKING UNCOMMENT
@$data = FALSE;
if($data === FALSE) {
     // $error = error_get_last();
      //echo "HTTP request failed. Error was: " . $error['message'];
      //save sms to send latel

              $custom = array();
        $custom = array(
          'MobileNumber' => $mobile,
          'servicename' => $servicename,
          'status' => 'isNotsent',
          'message' => $sms
        );
           $this->save_sms($custom);
} else {
      //echo "Everything went better than expected";

      $custom = array();
        $custom = array(
          'MobileNumber' => $mobile,
          'servicename' => $servicename,
          'status' => 'issent',
          'message' => $sms
        );
           $this->save_sms($custom);


}
              
    }



    public function send_sms_success($s_mobile,$sms,$id)
    {
         $mobile = trim($s_mobile);
         $mobile = str_replace(array(' ','-'), '',  $mobile);
        $mobile = '255'.substr($mobile, -9);
        $url = 'http://192.168.33.2/modules/otsms/process.php?msisdn='.$mobile.'&message='.urlencode($sms);
      

            $data = file_get_contents($url);  //SMS WORKING UNCOMMENT
          
            if($data === FALSE) {
                
                       
            } else{$this->Update_sms($id);}
              
    }



    public function send_sms_trick3($s_mobile,$sms,$servicename)
    {
         $mobile = trim($s_mobile);
         $mobile = str_replace(array(' ','-'), '',  $mobile);
        $mobile = '255'.substr($mobile, -9);
        $url = 'http://192.168.33.2/modules/otsms/process.php?msisdn='.$mobile.'&message='.urlencode($sms);
      
            
            @$data = FALSE;
            if($data === FALSE) {
               

                          $custom = array();
                    $custom = array(
                      'MobileNumber' => $mobile,
                      'servicename' => $servicename,
                      'status' => 'isNotsent',
                      'message' => $sms
                    );
                       $this->save_sms($custom);
            } else {

                  $custom = array();
                    $custom = array(
                      'MobileNumber' => $mobile,
                      'servicename' => $servicename,
                      'status' => 'issent',
                      'message' => $sms
                    );
                       $this->save_sms($custom);
            }
              
    }

     public function send_sms_trickdoble($s_mobile,$sms ,$r_mobile,$rsms)
    {
         $mobile = trim($s_mobile);
         $mobile = str_replace(array(' ','-'), '',  $mobile);
        $mobile = '255'.substr($mobile, -9);
        $url = 'http://192.168.33.2/modules/otsms/process.php?msisdn='.$mobile.'&message='.urlencode($sms);
      
                //$urloutput=file_get_contents($url,);

            // $ctx = stream_context_create(['http'=> ['timeout' => 2]]); // 5 seconds
            // $urloutput = file_get_contents($url,null,$ctx);
        // $options = stream_context_create(array('http'=>
        //     array(
        //         //'method' => 'GET',
        //     'timeout' =>10.0,
        //     'ignore_errors' => true,
        //     )
        // ));
        //     $urloutput = file_get_contents($url , false, $options);

                //$urloutput=file_get_contents($url);
            
        
//@$data = file_get_contents($url);  //SMS WORKING UNCOMMENT
@$data = FALSE;
if($data === FALSE) {
     // $error = error_get_last();
      //echo "HTTP request failed. Error was: " . $error['message'];
      //save sms to send latel

              $custom = array();
        $custom = array(
          'MobileNumber' => $mobile,
          'status' => 'isNotsent',
          'message' => $sms
        );
           $this->save_sms($custom);
} else {
      //echo "Everything went better than expected";

      $custom = array();
        $custom = array(
          'MobileNumber' => $mobile,
          'status' => 'issent',
          'message' => $sms
        );
           $this->save_sms($custom);
           
}
              
    }
}
?>