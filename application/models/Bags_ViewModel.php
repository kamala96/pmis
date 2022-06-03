
<?php


class Bags_ViewModel extends CI_Model
{
    public $date_created;
    public $bag_number;
    public $bag_origin_region;
    public $bag_branch_origin;
    public $bag_region_to;
    public $bag_branch_to;
    public $bag_weight;
    public $item_number ;
    public $bags_status;
    public $bag_id;
      public $type;
      public $service_category;

   
    

     function __consturct(){parent::__construct();}

         public function view_data($date_created,$bag_number, $bag_origin_region, $bag_branch_origin, $bag_region_to,
            $bag_branch_to, $bag_weight,$item_number, $bags_status,$bag_id,$service_category, $type)
         {
              //parent::__construct();

            $data = array();
             $data = array(
            'date_created'=> $date_created,
            'bag_number'=>$bag_number,
           'bag_origin_region'=>$bag_origin_region,
           'bag_branch_origin'=>$bag_branch_origin,
           'bag_region_to'=>$bag_region_to,
           'bag_branch_to'=>$bag_branch_to,
           'bag_weight'=>$bag_weight,
           'item_number'=>$item_number,
           'bags_status'=>$bags_status,
          'bag_id'=>$bag_id,
           'service_category'=>$service_category,
           'type'=>$type
           
        );
             return $data;

          

        }

        public  function create($date_created,$bag_number, $bag_origin_region, $bag_branch_origin, $bag_region_to,
            $bag_branch_to, $bag_weight,$item_number, $bags_status,$bag_id,$service_category, $type){
    
        return  $this->view_data($date_created,$bag_number, $bag_origin_region, $bag_branch_origin, $bag_region_to,
            $bag_branch_to, $bag_weight,$item_number, $bags_status,$bag_id,$service_category, $type);
    
}
}  

?>