<?php

class Sms_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
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

                $urloutput=file_get_contents($url);
              //return $urloutput;
              
    }
}
?>