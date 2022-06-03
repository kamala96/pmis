<?php

class Control_Number_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}

    public function get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno){

            $AppID = 'POSTAPORTAL';

            $data = array(
            'AppID'=>$AppID,
            'BillAmt'=>$paidamount,
            'serial'=>$serial,
            'District'=>$sender_branch,
            'Region'=>$sender_region,
            'service'=>$serviceId,
            'item'=>$renter,
            'mobile'=>$s_mobile,
            'trackno'=>$trackno
            );

            //create logs
            $value = array();
            $value = array('trackno'=>$trackno,'serviceid'=>$serviceId,'item'=>$renter,'serial'=>$serial);
            $log=json_encode($value);
            $lg = array(
            'response'=>$log
            );
               $this->save_logs($lg);



            $url = "http://192.168.33.2/payments/paymentAPI.php";
            $ch = curl_init($url);
            $json = json_encode($data);
            curl_setopt($ch, CURLOPT_URL, $url);
            // For xml, change the content-type.
            curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
            curl_setopt($ch, CURLOPT_POST, 1);curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

            // Send to remote and return data to caller.
            $response = curl_exec ($ch);
            $error    = curl_error($ch);
            $errno    = curl_errno($ch);
            // print_r($result->controlno);
            //print_r($response.$error);
            curl_close ($ch);
            $result = json_decode($response);
            //print_r($result->controlno);
            return $result;

            //echo $result;
            }

            public function save_logs($data){
            $db2 = $this->load->database('otherdb', TRUE);
             //$db2->query("SET sql_mode = '' ");
            $db2->insert('logs',$data);
            }


            public function get_control_number_partial_payment($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno){

            $AppID = 'POSTAPORTAL';

            $data = array(

            'AppID'=>$AppID,
            'BillAmt'=>$paidamount,
            'serial'=>$serial,
            'District'=>$sender_branch,
            'Region'=>$sender_region,
            'service'=>$serviceId,
            'item'=>$renter,
            'mobile'=>$s_mobile,
            'trackno'=>$trackno,
            'payOpt'=>'YES'
            
            );

            //create logs
            $value = array();
            $value = array('trackno'=>$trackno,'serviceid'=>$serviceId,'item'=>$renter,'serial'=>$serial);
            $log=json_encode($value);
            $lg = array(
            'response'=>$log
            );
               $this->save_logs($lg);

            $url = "http://192.168.33.2/payments/paymentAPI.php";
            $ch = curl_init($url);
            $json = json_encode($data);
            curl_setopt($ch, CURLOPT_URL, $url);
            // For xml, change the content-type.
            curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
            curl_setopt($ch, CURLOPT_POST, 1);curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

            // Send to remote and return data to caller.
            $response = curl_exec ($ch);
            $error    = curl_error($ch);
            $errno    = curl_errno($ch);
            // print_r($result->controlno);
            //print_r($response.$error);
            curl_close ($ch);
            $result = json_decode($response);
            //print_r($result->controlno);
            return $result;

            //echo $result;
            }




    public function getVirtualBoxInfo(){

      $phone = $this->input->post('phone');
      $target_url = "http://smartposta.posta.co.tz/api/virtual_box/";

      $post = array(
                  'box'=>$phone
                  );


      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL,$target_url);
      curl_setopt($curl, CURLOPT_POST,1);
      //curl_setopt($curl, CURLOPT_POST, count($post));
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2'
      ));
      curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($curl, CURLOPT_VERBOSE,true);
      $result = curl_exec($curl);
      echo $answer = json_decode($result);
      curl_close($curl);

      }

}
?>