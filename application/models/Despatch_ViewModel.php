
<?php


class Despatch_ViewModel extends CI_Model
{
    public $datetime;
    public $desp_no;
    public $region_from;
    public $branch_from;
    public $region_to;
    public $branch_to;
    public $despatch_status;
    public $item_number ;
    public $desp_id;
      public $type;
      public $service_category;

   
    

     function __consturct(){parent::__construct();}

         public function view_data($datetime,$desp_no, $region_from, $branch_from, $region_to,
            $branch_to, $despatch_status,$item_number, $desp_id,$service_category, $type)
         {
              //parent::__construct();

            $data = array();
             $data = array(
            'datetime'=> $datetime,
            'desp_no'=>$desp_no,
           'region_from'=>$region_from,
           'branch_from'=>$branch_from,
           'region_to'=>$region_to,
           'branch_to'=>$branch_to,
           'despatch_status'=>$despatch_status,
           'item_number'=>$item_number,
           'desp_id'=>$desp_id,
           'service_category'=>$service_category,
           'type'=>$type
           
        );
             return $data;

          

        }

        public  function create($datetime,$desp_no, $region_from, $branch_from, $region_to,
            $branch_to, $despatch_status,$item_number, $desp_id,$service_category, $type){
    
        return  $this->view_data($datetime,$desp_no, $region_from, $branch_from, $region_to,
            $branch_to, $despatch_status,$item_number, $desp_id,$service_category, $type);
    
}
}  

?>