<?php

	class Estatemodel extends CI_Model{


			function __consturct(){
			parent::__construct();

			}
			
			public function Addattachment($data){
				$this->db->insert('propertyuploads',$data);
			}

			public function Addproperty($data){
				
				$this->db->insert('property',$data);
			}



			  public function propertylist(){
			  $sql = "SELECT * FROM `property` ORDER BY `property_created_at` DESC " ;
				$query=$this->db->query($sql);
				$result = $query->result();
				return $result;
			}

			public function delete_real_estate_property($id){
			 $sql = "DELETE FROM `property` WHERE id='$id'" ;
			 $query=$this->db->query($sql);
			  return $query;
			}

	public function find_real_estate_property_list($fromdate,$todate,$region,$district,$propertytype){
	$otheruser = $this->session->userdata('user_region');
	$empid = $this->session->userdata('user_emid');
	$qry = "SELECT * from property WHERE ";

    if($fromdate != '' && $todate != '') {
    $qry .= "DATE(property_created_at) BETWEEN '$fromdate' AND '$todate' AND ";
    }

    if($this->session->userdata('user_type') == 'SUPER ADMIN' || $this->session->userdata('user_type') == 'ADMIN'){
    if($region != '') {
    $qry .= "Region='".$region."' AND ";
    }
    } else {
    if($otheruser != ''){
    $qry .= "Region='".$otheruser."' AND ";
    }
    }

    if($district != '') {
    $qry .= "District='".$district."' AND ";
    }

    if($propertytype != '') {
    $qry .= "property_type='".$propertytype."' AND ";
    }

    $qry .= '1 ORDER BY property_created_at DESC';
    $query = $this->db->query($qry);
    $result = $query->result();
    return $result;
	}

			public function propertyprofile($id){
				// $sql = "SELECT * FROM property
			    // 		INNER JOIN propertyuploads
				// 		ON propertyuploads.property_id = property.id
				// 		WHERE propertyuploads.deleted = 0 AND property.id = '$id' AND property.deleted = 0" ;

                 $sql = "SELECT * FROM property WHERE  property.id = '$id' AND property.deleted = 0" ;
						
				  $query=$this->db->query($sql);
				  $result = $query->result();
				  return $result;
			  }

			  public function propertyimages($id){
                 $sql = "SELECT * FROM propertyuploads WHERE  propertyuploads.property_id = '$id' AND propertyuploads.deleted = 0" ;
						
				  $query=$this->db->query($sql);
				  $result = $query->result();
				  return $result;
			  }

           public function requestlist($serialno){
           	 $id = $this->session->userdata('user_login_id');
             $basicinfo = $this->employee_model->GetBasic($id);
             $em_id = $basicinfo->em_id;
				
			  $sql = "SELECT * FROM `requisitionform` WHERE ( `serialno` = '$serialno' )";
		 
			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;

			}
		


      public function Update_stock($data2,$StockId)
		{
			$this->db->where('StockId', $StockId);
			$this->db->update('stock',$data2);
		}

		public function Update_property($data,$Id)
		{
			$this->db->where('id', $Id);
			$this->db->update('property',$data);
		}

		public function Update_tenantinf($tenant,$tenantid)
		{
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('tenant_id', $tenantid);
			$db2->update('estate_tenant_information',$tenant);
		}

		public function Update_estateinf($data,$Id)
		{
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('estate_id', $Id);
			$db2->update('estate_information',$data);
		}

		 public function getregionvalue($regid){
		  $sql    = "SELECT * FROM `em_region` WHERE `region_id`='$regid'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
		          return $result;
		  }
		  public function getdistrictvalue($id){
		  $sql    = "SELECT * FROM `em_district` WHERE `district_id`='$id'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
		          return $result;
		  }
	
public function get_tenant_informations($id){
        
        $db2 = $this->load->database('otherdb', TRUE);

        $sql = "SELECT `estate_tenant_information`.*,`estate_information`.* FROM `estate_tenant_information`
            INNER JOIN `estate_contract_information` 
            ON `estate_contract_information`.`tenant_id` = `estate_tenant_information`.`tenant_id`
            INNER JOIN `estate_information` 
            ON `estate_information`.`estate_id` = `estate_contract_information`.`estate_id`
             
            WHERE `estate_tenant_information`.`tenant_id` = '$id'  ORDER BY `estate_tenant_information`.`tenant_id` DESC LIMIT 1";

        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

    public function get_tenant_informations_details($id){
        
        $db2 = $this->load->database('otherdb', TRUE);

        $sql = "SELECT `estate_tenant_information`.*,`estate_information`.* FROM `estate_tenant_information`
            INNER JOIN `estate_contract_information` 
            ON `estate_contract_information`.`tenant_id` = `estate_tenant_information`.`tenant_id`
            INNER JOIN `estate_information` 
            ON `estate_information`.`estate_id` = `estate_contract_information`.`estate_id`
             
            WHERE `estate_tenant_information`.`tenant_id` = '$id'  ORDER BY `estate_tenant_information`.`tenant_id` DESC LIMIT 1";

        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

    public function check_customer($custname){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `estate_tenant_information` WHERE `customer_name`='$custname'";
		$query  = $db2->query($sql);
		$result = $query->row_array();
		return $result;
	}

     public function get_tenant_informations_payment($type,$regid,$tenant_id,$tin_number,$districtid,$customer_name){
        
        $db2 = $this->load->database('otherdb', TRUE);

        if(empty($regid)){

           $sql = "SELECT t1.*,t2.*,t3.*,t4.*
 FROM `estate_tenant_information` AS t1
INNER JOIN (SELECT *
      FROM `estate_contract_information`
      JOIN (
       Select  max(estate_co_id) mlike
       from estate_contract_information
       GROUP BY `tenant_id`)  T
    on  estate_contract_information.estate_co_id = T.mlike ) AS t2 ON t1.`tenant_id` = t2.`tenant_id` 
  INNER JOIN `estate_information` AS t3 
            ON t3.`estate_id` = t2.`estate_id`   INNER JOIN (SELECT *
      FROM `real_estate_transactions` as k
      JOIN (SELECT  MAX(`t_id`) mlikes
       FROM real_estate_transactions
      GROUP BY `tenant_id`)  Tz
     on k.t_id = Tz.mlikes  
) AS t4 ON t1.`tenant_id` = t4.`tenant_id`  
           
 

            WHERE t3.`estate_type` = '$type'  
            AND ( t1.`tenant_id` = '$tenant_id'   OR t1.`customer_name` LIKE '%$customer_name%' )

               ORDER BY t2.`estate_co_id` DESC";
               // OR  t1.`tin_number` = '$tin_number'

        }else{


         $sql = "SELECT t1.*,t2.*,t3.*,t4.*
 FROM `estate_tenant_information` AS t1
INNER JOIN (SELECT *
      FROM `estate_contract_information`
      JOIN (
       Select  max(estate_co_id) mlike
       from estate_contract_information
       GROUP BY `tenant_id`)  T
    on  estate_contract_information.estate_co_id = T.mlike ) AS t2 ON t1.`tenant_id` = t2.`tenant_id` 
  INNER JOIN `estate_information` AS t3 
            ON t3.`estate_id` = t2.`estate_id`   INNER JOIN (SELECT *
      FROM `real_estate_transactions` as k
      JOIN (SELECT  MAX(`t_id`) mlikes
       FROM real_estate_transactions
      GROUP BY `tenant_id`)  Tz
     on k.t_id = Tz.mlikes  
) AS t4 ON t1.`tenant_id` = t4.`tenant_id`  
           
 

            WHERE t3.`estate_type` = '$type' AND t3.`region` = '$regid' AND t3.`district` = '$districtid'  
            AND ( t1.`tenant_id` = '$tenant_id'  OR t1.`customer_name` LIKE '%$customer_name%' )

               ORDER BY t2.`estate_co_id` DESC";
                // OR  t1.`tin_number` = '$tin_number'
             }

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

	
			 public function getrequestlist($serialno){
           	 $id = $this->session->userdata('user_login_id');
             $basicinfo = $this->employee_model->GetBasic($id);
             $em_id = $basicinfo->em_id;
				
			 $sql = "SELECT * FROM `requisitionform` WHERE ( `ApprovedBy` = '$em_id' && `IsApproved` = '0') || 
			  ( `issuedby` = '$em_id' && `IsIssued` = '0' && `IsApproved` = '1')";
		 
			$query=$this->db->query($sql);
				$result = $query->row();
				return $result;

			
			}



			public function Getprice($data1){

				$sql    = "SELECT * FROM `stock` WHERE `StockId`='$data1'";
					  $query  = $this->db->query($sql);
					  $result = $query->row();
					  $price = $result->pricepermint;
	

					  $output =  '<td style="text-align:center;"><input type="number" readonly style="border: none;" class="form-control" name="price" placeholder="'.$price.'" ></td>' ;
					//$output =  '<td style="text-align:center;border: none;" ><text style="border: none;" class="form-control">'.$price.'</text></td>' ;


				 return $output;
			  }


			  public function lastserialnumber(){

				$sql  = "SELECT * FROM `requisitionform` ORDER BY `serialno` DESC LIMIT 1";
				$query  = $this->db->query($sql);
				$result = $query->row();
				$serialno2 = $result->serialno;
				return $serialno2 + 1;
			  }

			  public function getisapproved($serialno){

				$sql  = "SELECT * FROM `requisitionform`WHERE `serialno`='$serialno'  LIMIT 1";
				$query  = $this->db->query($sql);
				$result = $query->row();
				$IsApproved = $result->IsApproved;
				return $IsApproved;

			  }


			  public function getlastStockId(){

				$sql  = "SELECT * FROM `stock`  ORDER BY `StockId` DESC   LIMIT 1";
				$query  = $this->db->query($sql);
				$result = $query->row();
				$StockId = $result->StockId;
				return $StockId;

			  }

			 

		
		


           public function requestedrequisation($data1,$empid){

		  
			  $sql = "SELECT DISTINCT  * FROM `requisitionform` WHERE `IsIssued`='$data1' AND `RequestedBy`='$empid'
			        GROUP BY `serialno`    " ;
		  

			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
			}
			public function requisationbranch($data1,$em_branch,$takefromrole){

			  $sql = "SELECT   * FROM `requisitionform` 
			  INNER JOIN `employee`  
			   ON `requisitionform`.`RequestedBy` = `employee`.`em_id`
			   WHERE `employee`.`em_sub_role`='$takefromrole' AND `requisitionform`.`IsIssued`='$data1'
			   AND `employee`.`em_branch`='$em_branch'
			   GROUP BY `requisitionform`.`serialno` " ;
			   $query=$this->db->query($sql);
			   $result = $query->result();




			return $result;
			}
			 public function requisationstrong($data1,$em_region,$takefromrole){

		  
			  $sql = "SELECT   * FROM `requisitionform` 
			  INNER JOIN `employee`  
			   ON `requisitionform`.`RequestedBy` = `employee`.`em_id`
			   WHERE `employee`.`em_sub_role`='$takefromrole' AND `requisitionform`.`IsIssued`='$data1'
			   AND `employee`.`em_region`='$em_region'
			   GROUP BY `requisitionform`.`serialno`   " ;
		  

			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
			}
			public function requisationlistStore($data1,$takefromrole){

		  
			  $sql = "SELECT   * FROM `requisitionform` 
			  INNER JOIN `employee`  
			   ON `requisitionform`.`RequestedBy` = `employee`.`em_id`
			   WHERE `employee`.`em_sub_role`='$takefromrole' AND `requisitionform`.`IsIssued`='$data1'
			   
			   GROUP BY `requisitionform`.`serialno` " ;
		  

			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
			}

			 public function receive($data1,$empid){

		  
			  $sql = "SELECT DISTINCT  * FROM `requisitionform` WHERE `IsReceved`='$data1'
			          AND  `RequestedBy`='$empid' AND `IsIssued`='1' 
			        GROUP BY `serialno`    " ;
		  

			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
			}
		
	
 
         

			

			public function getstock(){
			$query = $this->db->get('stock_category');
			$result = $query->result();
			return $result;
			}
		 

		 //jaribio

			 public function edit($formno){
          $sql    = "SELECT * FROM `requisitionform` WHERE `formno`='$formno'";
          $query  = $this->db->query($sql);
          $result = $query->row();
          return $result;
	}
}
?>
