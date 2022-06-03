<?php

	class Stampbureau extends CI_Model{


			function __consturct(){
			parent::__construct();

			}

			  public function stocklist($data1){

		  
			  $sql = "SELECT * FROM `stock` WHERE `Stock_Categoryid`='$data1' 
			   GROUP BY `StockId`  " ;
		  

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
			public function requestlist1($serialno){
           	
				
			  $sql = "SELECT * FROM `requisitionform` WHERE ( `serialno` = '$serialno' ) LIMIT 1";
		 
			$query=$this->db->query($sql);
			$result = $query->row();
				return $result;

			}

			public function requestlist12($serialno,$StockId){
           	
				
			  $sql = "SELECT * FROM `requisitionform` WHERE ( `serialno` = '$serialno' && `StockId` = '$StockId' ) LIMIT 1";
		 
			$query=$this->db->query($sql);
			$result = $query->row();
				return $result;

			}

      public function Update_stock($data2,$StockId)
		{
			$this->db->where('StockId', $StockId);
			$this->db->update('stock',$data2);
		}
		public function Update_stock_Request_form($data,$serialno,$StockId)
		{
			$this->db->where('StockId', $StockId);
			$this->db->where('serialno', $serialno);
			$this->db->update('requisitionform',$data);
		}

		public function Update_stock_Request($data,$serialno)
		{
			$this->db->where('serialno', $serialno);
			$this->db->update('requisitionform',$data);
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

			  public function getpreviousQuantity($db,$StockId){

				$sql  = "SELECT * FROM `$db` WHERE `StockId`='$StockId' ORDER BY `createddate` DESC   LIMIT 1";
				$query  = $this->db->query($sql);
				$result = $query->row();
				//$quantity = $result->quantity;
				return $result;

			  }
			   public function getstockinfo($StockId){

				$sql  = "SELECT * FROM `stock` WHERE `StockId`='$StockId' ORDER BY `createddate` DESC   LIMIT 1";
				$query  = $this->db->query($sql);
				$result = $query->row();
				//$quantity = $result->quantity;
				return $result;

			  }

			    public function getlastQuantity($StockId,$db){

				$sql  = "SELECT * FROM `$db` WHERE `StockId`='$StockId' ORDER BY `createddate` DESC   LIMIT 1";
				$query  = $this->db->query($sql);
				$result = $query->row();
				$quantity = $result->quantity;
				return $result;

			  }

			  public function getlastStockId(){

				$sql  = "SELECT * FROM `stock`  ORDER BY `StockId` DESC   LIMIT 1";
				$query  = $this->db->query($sql);
				$result = $query->row();
				$StockId = $result->StockId;
				return $StockId;

			  }



			  public function geStockname($StockId){

				$sql  = "SELECT * FROM `stock` WHERE `StockId`='$StockId' ORDER BY `createddate` DESC   LIMIT 1";
				$query  = $this->db->query($sql);
				$result = $query->row();
				$name = $result->stampname;
				return $name;

			  }

			  public function geStockprice($StockId){

				$sql  = "SELECT * FROM `stock` WHERE `StockId`='$StockId' ORDER BY `createddate` DESC   LIMIT 1";
				$query  = $this->db->query($sql);
				$result = $query->row();
				$pricepermint = $result->pricepermint;
				return $pricepermint;

			  }
		     public function getCounterstock($empid){
		  
				$sql = "SELECT * FROM `counterstock` 
				WHERE `Emp_id`='$empid' ORDER BY `createddate` DESC " ;
			
  
			  $query=$this->db->query($sql);
			  $result = $query->result();
			  return $result;
			  }

			  public function getBranchstock($em_branch){
		  
				$sql = "SELECT * FROM `branchstock`
				WHERE `Regionbranch`='$em_branch' ORDER BY `createddate` DESC  " ;
			
  
			  $query=$this->db->query($sql);
			  $result = $query->result();
			  return $result;
			  }
			    public function getStrongstock($em_region){
		  
				$sql = "SELECT * FROM `strongroomstock`
				WHERE `Region`='$em_region' ORDER BY `createddate` DESC  " ;
			
  
			  $query=$this->db->query($sql);
			  $result = $query->result();
			  return $result;
			  }
			    public function getMainstock(){
		  
				$sql = "SELECT * FROM `stock` ORDER BY `createddate` DESC  " ;
			
  
			  $query=$this->db->query($sql);
			  $result = $query->result();
			  return $result;
			  }

			
			public function getstocklist(){

		  
				$sql = "SELECT * FROM `stock` " ;
			
  
			  $query=$this->db->query($sql);
			  $result = $query->result();
			  return $result;
			  }

		  public function philatelist(){

		  
			  $sql = "SELECT * FROM `stock` WHERE `Stock_Categoryid`='1'" ;
		  

			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
			}

         public function requisationlist1($data1){

		  
			  $sql = "SELECT DISTINCT  * FROM `requisitionform` WHERE `IsIssued`='$data1'
			        GROUP BY `serialno`    " ;
		  

			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
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
		
		 public function received($data1,$empid){

		      $Isreceived = "1";
			  $sql = "SELECT DISTINCT  * FROM `requisitionform` WHERE `IsIssued`='$data1'
			          AND  `ReceivedBy`='$empid' AND  `IsReceved`='$Isreceived'
			        GROUP BY `serialno`    " ;
		  

			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
			}
 
         public function Addstockrequest($data){
				$this->db->insert('requisitionform',$data);
			}

			public function Addstamp($data){
				$this->db->insert('stock',$data);
			}

				public function Addstocks($data,$db){
				$this->db->insert($db,$data);
			}

				public function Addstocks2($data2,$db){
				$this->db->insert($db,$data2);
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
