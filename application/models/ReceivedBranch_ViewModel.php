
<?php


class ReceivedBranch_ViewModel extends CI_Model
{
    public $s_fullname;
    public $s_region;
    public $s_district;
    public $date_registered;
    public $track_number;
    public $r_region;
    public $branch;
    public $id;
    public $office_name;
    public $bag_status;
      public $status;
       public $Barcode;
       public $fullname;

   
    

     function __consturct(){parent::__construct();}

         public function view_data($s_fullname,$s_region, $s_district, $date_registered, $track_number,
            $r_region, $branch,$id, $office_name,$bag_status, $status,$Barcode,$fullname)
         {
              //parent::__construct();

            $data = array();
             $data = array(
            's_fullname'=> $s_fullname,
            's_region'=>$s_region,
           's_district'=>$s_district,
           'date_registered'=>$date_registered,
           'track_number'=>$track_number,
           'r_region'=>$r_region,
           'branch'=>$branch,
           'id'=>$id,
           'office_name'=>$office_name,
          'bag_status'=>$bag_status,
           'status'=>$status,
           'Barcode'=>$Barcode,
           'fullname'=>$fullname
        );
             return $data;

          

        }

        public  function create($s_fullname,$s_region, $s_district, $date_registered, $track_number,
            $r_region, $branch,$id, $office_name,$bag_status, $status,$Barcode,$fullname){
    
        return  $this->view_data($s_fullname,$s_region, $s_district, $date_registered, $track_number,
            $r_region, $branch,$id, $office_name,$bag_status, $status,$Barcode,$fullname);
    
}
}  

?>