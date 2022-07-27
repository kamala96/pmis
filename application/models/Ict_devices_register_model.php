<?php
class Ict_devices_register_model extends CI_Model
{
	public  function list_items()
	{
		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "select * from officialuse_items";
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	private function ordinal($number)
	{
		$ends = array('th','st','nd','rd','th','th','th','th','th','th');
		if ((($number % 100) >= 11) && (($number%100) <= 13))
			return $number. 'th';
		else
			return $number. $ends[$number % 10];
	}

	private function get_region($region_code)
	{
		$region_code = (Int)$region_code;
		$this->db->where('reg_code', $region_code);
		$query = $this->db->get('em_region');
		return $query->row_array();
	}

	public function get_all_ict_devices() 
	{
		$this->db->join('ict_register_category cat', 'cat.category_id    = r.dev_title', 'left');
		$query = $this->db->get('ict_device_register r');

		$data = [];
		$i = 0;
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row) 
			{
				if($this->check_not_available_in_pool($row['dev_id']))
				{
					$i++;

					$dates = explode("-", $row['dev_date_tracker']);
					$date_created =  gmdate("d F Y", $dates[0]);

					$locate = explode("-", $row['dev_status']);
					$region_name = 'Undefined';
					if(isset($locate[1]))
					{
						$region = str_replace('RM', '', $locate[1]);
						$region_code = (Int)$region;
						$query_region = $this->get_region($region_code);
						$region_name = $query_region['region_name'];
					}
	
					$is_at_HQ_store = FALSE;
					$current_location_name = $region_name;
					if($row['dev_status'] == "IHQ")
					{
						$is_at_HQ_store = TRUE;
						$current_location_name = 'HQ Store';
					}
	
					$data[] = array(
						"id" => $row['dev_id'],
						"sn" => $i,
						"title" => $row['category_name'],
						"model" => $row['dev_model'],
						"serial" => $row['dev_serial_number'],
						"asset" => $row['dev_asset_number'],
						"detailed_specs" => $row['dev_detailed_specs'],
						"where_located" => $current_location_name,
						"is_available" => $is_at_HQ_store,
						"date_created" => $date_created,
					);
				}
			}
		} 
		return $data;
	}

	public function get_all_devices_by_category($category)
	{
		$category = (Int)$category;
		$this->db->where('dev_title', $category);
		$this->db->where('dev_status', "IHQ");
		$query = $this->db->get('ict_device_register');
		return $query->result_array();
	}

	public function save_data_to_table($table, $data)
	{
		if($this->db->insert($table, $data)){
			return TRUE;
		}
		else{
			return $this->db->error();
		}
	}


	public function check_if_exists($table, $column, $value, $upper=TRUE)
	{
		$value = $upper ? strtoupper($value) : strtolower($value);
		$this->db->where($column, $value);
		$query = $this->db->get($table);
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function check_if_exists_based_on_other_column($table, $column, $other_column, $value, $other_value, $upper=True)
	{
		$value = $upper ? strtoupper($value) : strtolower($value);
		$this->db->where($column, $value);
		$this->db->where($other_column, $other_value);
		$query = $this->db->get($table);
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function get_all_ict_device_categories($work=1) 
	{
		$data = [];  
		$query = $this->db->get('ict_register_category'); 
		if($query->num_rows() > 0)
		{
			if ($work == 1)
			{
				return $query->result_array();
			}
			else
			{
				foreach ($query->result_array() as $row) 
				{
					$data[] = array(
						"title"=>$row['category_name'],
						"date_created"=>date('d F, Y', strtotime($row['category_created_date'])),
						"description"=>$row['category_description'],
					);

				}
			}
		} 
		return $data;
	}
	
	public function count_devices_in_a_pool()
	{
		return $this->db->get('ict_device_pool')->num_rows();
	}

	public function get_all_ict_category_specs_ajax() 
	{
		$data = [];
		$this->db->select('spec.spec_id, spec.spec_label, spec.spec_type, spec.spec_is_required, cat.category_name');
		$this->db->join('ict_register_category cat', 'cat.category_id    = spec.spec_category', 'left');
		$query = $this->db->get('ict_device_specifications spec');
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row) 
			{
				$data[] = array(
					"category"=>$row['category_name'],
					"label"=>$row['spec_label'],
					"input_field"=>$row['spec_type'],
					"is_mandatory"=>$row['spec_is_required'] == 1 ? "Yes" : "No",
				);                     
			}
		} 
		return $data;
	}

	public function get_all_ict_device_specifications($category) 
	{
		$this->db->where('spec_category', $category); 
		$query = $this->db->get('ict_device_specifications');
		return $query->result_array();
	}

	public function get_all_regional_managers()
	{
		$this->db->order_by("region_name", "asc");
		$query = $this->db->get('em_region');
		return $query->result_array();
	}

	public function get_device_info($id)
	{
		// $this->db->select('dev_detailed_specs'); 
		$this->db->join('ict_register_category cat', 'cat.category_id = dev.dev_title', 'left');
		$this->db->where('dev.dev_id', $id);
		$query = $this->db->get('ict_device_register dev');
		if($query->num_rows() > 0)
		{
			$data = $query->row_array();
			$data['checked'] = TRUE;
			return $data;
		}
		return FALSE;
	}

	public function get_similar_devices($model, $specs, $dev_id, $category)
	{
		$this->db->select('dev_id', 'dev_detailed_specs');
		$this->db->where('dev_status', 'IHQ');
		$this->db->where('dev_title', $category);
		if(empty($specs)) $this->db->where('dev_model', $model);
		if(!empty($specs)) $this->db->like('dev_detailed_specs', $specs, 'both');		
		$query = $this->db->get('ict_device_register');

		$data = array();
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row) 
			{
				if($this->check_not_available_in_pool($row['dev_id']))
				{
					$data[] = $row['dev_id'];
				}
			}
		}
		return array(
			'records' => $data,
			'total' => count($data),
		);
	}

	public function get_device_info_to_add_pool($id)
	{
		// $this->db->select('dev_detailed_specs');
		$this->db->where('dev_id', $id);
		$this->db->where('dev_status', 'IHQ');
		$query = $this->db->get('ict_device_register');
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}

	public function check_not_available_in_pool($id)
	{
		$this->db->where('pool_device', $id);
		$query = $this->db->get('ict_device_pool');
		if($query->num_rows() > 0)
		{
			return FALSE;
		}
		return TRUE;
	}

	public function save_to_pool($data)
	{
		if($this->db->insert_batch('ict_device_pool', $data))
		{
			return TRUE;
		}
		else{
			return $this->db->error();
		}
	}

	public function get_pool_data()
	{
		$this->db->join('ict_device_register dev', 'dev.dev_id = pl.pool_device', 'left');
		$this->db->join('ict_register_category cat', 'cat.category_id = dev.dev_title', 'left');
		// $this->db->join('em_region rg', 'rg.region_id = pl.pool_destination', 'left');
		$query = $this->db->get('ict_device_pool pl');

		$data = [];
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row) 
			{
				$query_region = $this->get_region($row['pool_destination']);
				$region_name = $query_region['region_name'];

				$data[] = array(
					"id" => $row['pool_id'],
					"title" => $row['category_name'].'['.$row['dev_model'].']',
					"serial" => $row['dev_serial_number'],
					"specs" => $row['dev_detailed_specs'],
					"destination" => $region_name,
				);
			}
		} 
		return $data;
	}

	public function get_pool_data_for_confirmation()
	{
		$this->db->select('pl.pool_id, pl.pool_device, pl.pool_destination, dev.dev_date_tracker, dev.dev_status');
		$this->db->join('ict_device_register dev', 'dev.dev_id = pl.pool_device', 'left');
		return $this->db->get('ict_device_pool pl')->result_array();
	}

	public function delete_pool_by_id($id)
	{
		$this->db->where('pool_id', $id);
		$query = $this->db->delete('ict_device_pool');
	}

	public function update_sent_devices($data)
	{
		$this->db->update_batch('ict_device_register', $data, 'dev_id');
	}

	public function empty_pool_table()
	{
		$this->db->empty_table('ict_device_pool');
	}
}

?>