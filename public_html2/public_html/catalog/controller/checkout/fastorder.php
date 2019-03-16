<?php 
class ControllerCheckoutFastorder extends Controller {
							
	public function send() {
		if (isset($this->request->post['phone'])) {
			$phone = $this->request->post['phone'];
		} else {
			echo '0';
			exit();
		}
		
		$html = "Телефон: ".$phone."\n\r\n\r\n\r";
		$html .= "Заказ: \n\r";
		$this->load->model('setting/extension');
		
		foreach ($this->cart->getProducts() as $product) {

							
			$option_data = array();
			
			foreach ($product['option'] as $option) {
				if ($option['type'] != 'file') {
					$value = $option['option_value'];	
				} else {
					$filename = $this->encryption->decrypt($option['option_value']);
					
					$value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
				}				
				
				$option_data[] = array(								   
					'name'  => $option['name'],
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
					'type'  => $option['type']
				);
			}

			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
			} else {
				$total = false;
			}
			$op = '';
			foreach ($option_data as $option) { 
             $op .= ' - '.$option['name'] . $option['value'].', ';
              } 
			$html .= 	$product['name'].$op.' ('.$product['model'].') Кол-то:'.$product['quantity'].', Сумма: '.$total."\n\r";							
			
		}
				// Display prices
		if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
			$sort_order = array(); 
			
			$results = $this->model_setting_extension->getExtensions('total');
			
			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}
			
			array_multisort($sort_order, SORT_ASC, $results);
			
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);
		
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
				
				$sort_order = array(); 
			  
				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}
	
				array_multisort($sort_order, SORT_ASC, $total_data);			
			}		
		}
		$html .= "Итого: \n\r";
		foreach($total_data as $td) {
			$html .= $td['title'].': '.$td['text']."\n\r";
		}
			$mail = new Mail(); 
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');			
			$mail->setTo($this->config->get('config_email'));
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender('АвтоВсе');
			$mail->setSubject('Быстрый заказ');
			$mail->setText($html);
			$mail->send();
			
			$this->cart->clear();
			
			echo '1';
	}
}
?>