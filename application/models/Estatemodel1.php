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



			  public function propertylist($data1){
			  $sql = "SELECT * FROM `property` WHERE `deleted`='$data1' 
			   ORDER BY `date` ASC " ;
				$query=$this->db->query($sql);
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
