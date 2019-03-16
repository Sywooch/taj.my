<?php
class ModelShippingNp extends Model {
	function getQuote($address) {
		$this->language->load('shipping/np');
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('np_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
	
		if (!$this->config->get('np_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();
	
		if ($status) {
			$quote_data = array();
			
      		$quote_data['np'] = array(
        		'code'         => 'np.np',
        		'title'        => $this->language->get('text_description'),
        		'cost'         => $this->config->get('np_cost'),
        		'tax_class_id' => $this->config->get('np_tax_class_id'),
				'text'         => $this->currency->format($this->tax->calculate($this->config->get('np_cost'), $this->config->get('np_tax_class_id'), $this->config->get('config_tax')))
      		);

      		$method_data = array(
        		'code'       => 'np',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('np_sort_order'),
        		'error'      => false
      		);
		}
	
		return $method_data;
	}
}
?>