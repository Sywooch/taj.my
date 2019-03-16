<?php
class ControllerModuleNovaPoshtaCron extends Controller {
	public function update() {
		if (isset($this->request->get['type'], $this->request->get['key']) && $this->request->get['key'] == $this->config->get('novaposhta_key_cron')) {			
		require_once(DIR_SYSTEM . 'helper/novaposhta.php');
					
		$novaposhta = new NovaPoshta($this->registry);
		
		$novaposhta->update($this->request->get['type']);
		
		$this->log->write('Nova Poshta ' . $this->request->get['type'] . ' updated');	
		}
	}
	
	public function shipmentsTracking() {
		if (isset($this->request->get['key']) && $this->request->get['key'] == $this->config->get('novaposhta_key_cron')) {				require_once(DIR_SYSTEM . 'helper/novaposhta.php');
						
			$novaposhta = new NovaPoshta($this->registry);

			$orders = $this->db->query("SELECT `o`.*, `l`.`code`, `l`.`directory` FROM `" . DB_PREFIX . "order` as `o` LEFT JOIN `" . DB_PREFIX . "language` as `l` ON (`l`.`language_id` = `o`.`language_id`)  WHERE `order_status_id` IN (" . implode(',', $this->config->get('novaposhta_tracking_statuses')) . ") AND `novaposhta_ei_number` != ''")->rows;
						
			if ($orders) {
				$ei_numbers = array();
				
				foreach($orders as $k => $order){
					$ei_numbers[] = $order['novaposhta_ei_number'];
					$orders[$order['novaposhta_ei_number']] = $order;
					
					unset($orders[$k]);
				}
				
				$documents = $novaposhta->tracking($ei_numbers);

				if ($documents) {
					$tracking_settings = $novaposhta->arrayKey($this->config->get('novaposhta_settings_tracking_statuses'), 'novaposhta');
					
					foreach($documents as $document){
						if ($document['Number'] && isset($tracking_settings[$document['StatusCode']]) && $tracking_settings[$document['StatusCode']]['store'] != $orders[$document['Number']]['order_status_id']) {
							// Message
							$message = '';
							$template = explode('|', $tracking_settings[$document['StatusCode']]['message']);
							
							if ($template[0]) {
								$find_order = array(
									'{order_id}',
									'{invoice}',
									'{store_name}',
									'{store_url}',
									'{name}',
									'{shipping_name}',
									'{date_added}',
									'{date_modified}'
								);
								
								$replace_order = array(
									'order_id'		=> $orders[$document['Number']]['order_id'],
									'invoice'		=> $orders[$document['Number']]['invoice_prefix'] . $orders[$document['Number']]['invoice_no'],
									'store_name'	=> $orders[$document['Number']]['store_name'],
									'store_url'		=> $orders[$document['Number']]['store_url'],
									'name'			=> $orders[$document['Number']]['lastname'] . ' ' . $orders[$document['Number']]['firstname'],
									'shipping_name'	=> $orders[$document['Number']]['shipping_lastname'] . ' ' . $orders[$document['Number']]['shipping_firstname'],
									'date_added'	=> $orders[$document['Number']]['date_added'],
									'date_modified'	=> $orders[$document['Number']]['date_modified']
								);
								
								$find_ei = array(
									'{Number}',
									'{Redelivery}',
									'{RedeliverySum}',
									'{RedeliveryNum}',
									'{RedeliveryPayer}',
									'{OwnerDocumentType}',
									'{LastCreatedOnTheBasisDocumentType}',
									'{LastCreatedOnTheBasisPayerType}',
									'{LastCreatedOnTheBasisDateTime}',
									'{LastTransactionStatusGM}',
									'{LastTransactionDateTimeGM}',
									'{DateCreated}',
									'{DocumentWeight}',
									'{CheckWeight}',
									'{DocumentCost}',
									'{SumBeforeCheckWeight}',
									'{PayerType}',
									'{RecipientFullName}',
									'{RecipientDateTime}',
									'{ScheduledDeliveryDate}',
									'{PaymentMethod}',
									'{CargoDescriptionString}',
									'{CargoType}',
									'{CitySender}',
									'{CityRecipient}',
									'{WarehouseRecipient}',
									'{CounterpartyType}',
									'{AfterpaymentOnGoodsCost}',
									'{ServiceType}',
									'{UndeliveryReasonsSubtypeDescription}',
									'{WarehouseRecipientNumber}',
									'{LastCreatedOnTheBasisNumber}',
									'{WarehouseRecipientRef}',
									'{Status}',
									'{StatusCode}'
								);
								
								$replace_ei = array(
									'Number' 								=> $document['Number'],
									'Redelivery' 							=> $document['Redelivery'],
									'RedeliverySum' 						=> $document['RedeliverySum'],
									'RedeliveryNum' 						=> $document['RedeliveryNum'],
									'RedeliveryPayer' 						=> $document['RedeliveryPayer'],
									'OwnerDocumentType' 					=> $document['OwnerDocumentType'],
									'LastCreatedOnTheBasisDocumentType'		=> $document['LastCreatedOnTheBasisDocumentType'],
									'LastCreatedOnTheBasisPayerType'	 	=> $document['LastCreatedOnTheBasisPayerType'],
									'LastCreatedOnTheBasisDateTime' 		=> $document['LastCreatedOnTheBasisDateTime'],
									'LastTransactionStatusGM' 				=> $document['LastTransactionStatusGM'],
									'LastTransactionDateTimeGM' 			=> $document['LastTransactionDateTimeGM'],
									'DateCreated' 							=> $document['DateCreated'],
									'DocumentWeight' 						=> $document['DocumentWeight'],
									'CheckWeight' 							=> $document['CheckWeight'],
									'DocumentCost' 							=> $document['DocumentCost'],
									'SumBeforeCheckWeight' 					=> $document['SumBeforeCheckWeight'],
									'PayerType' 							=> $document['PayerType'],
									'RecipientFullName' 					=> $document['RecipientFullName'],
									'RecipientDateTime' 					=> $document['RecipientDateTime'],
									'ScheduledDeliveryDate' 				=> $document['ScheduledDeliveryDate'],
									'PaymentMethod' 						=> $document['PaymentMethod'],
									'CargoDescriptionString'	 			=> $document['CargoDescriptionString'],
									'CargoType' 							=> $document['CargoType'],
									'CitySender' 							=> $document['CitySender'],
									'CityRecipient' 						=> $document['CityRecipient'],
									'WarehouseRecipient' 					=> $document['WarehouseRecipient'],
									'CounterpartyType' 						=> $document['CounterpartyType'],
									'AfterpaymentOnGoodsCost' 				=> $document['AfterpaymentOnGoodsCost'],
									'ServiceType' 							=> $document['ServiceType'],
									'UndeliveryReasonsSubtypeDescription'	=> $document['UndeliveryReasonsSubtypeDescription'],
									'WarehouseRecipientNumber' 				=> $document['WarehouseRecipientNumber'],
									'LastCreatedOnTheBasisNumber' 			=> $document['LastCreatedOnTheBasisNumber'],
									'WarehouseRecipientRef' 				=> $document['WarehouseRecipientRef'],
									'Status' 								=> $document['Status'],
									'StatusCode' 							=> $document['StatusCode']
								);
								
								$message = trim(str_replace($find_order, $replace_order, $template[0]));
								$message = str_replace($find_ei, $replace_ei, $message);
							}
							
							if (isset($template[1])) {
								$products = $this->db->query("SELECT `op`.`product_id`, `op`.`name`, `op`.`model`, `op`.`quantity`, `p`.`sku`, `p`.`weight` * `op`.`quantity` as `weight`, `p`.`weight_class_id`, `p`.`length`, `p`.`width`, `p`.`height`, `p`.`length_class_id` FROM `" . DB_PREFIX . "order_product` AS `op` INNER JOIN `" . DB_PREFIX . "product` AS `p` ON `op`.`product_id` = `p`.`product_id` AND `op`.`order_id` = " . $orders[$document['Number']]['order_id'])->rows;
								
								$find_product = array(
									'{product_name}',
									'{model}',
									'{sku}',
									'{quantity}'
								);
								
								foreach ($products as $k => $product) {
									$replace_product = array(
										'name'		=> $product['name'],
										'model'		=> $product['model'],
										'sku'		=> $product['sku'],
										'quantity'	=> $product['quantity']
									);
									
									$message .= trim(str_replace($find_product, $replace_product, $template[1]));
								}
							}
							
							// Add order history
							$notify = (isset($tracking_settings[$document['StatusCode']]['customer_notification'])) ? true : false;
							
							$this->load->model('checkout/order');
							
							$this->model_checkout_order->update($orders[$document['Number']]['order_id'], $tracking_settings[$document['StatusCode']]['store'], $message, $notify);
							
							// Customer notification
							if (isset($tracking_settings[$document['StatusCode']]['customer_notification']) && $orders[$document['Number']]['email']) {
								$language_directory = (version_compare(VERSION, '2.2', '>=')) ? 'code' : 'directory';

								$language = new Language($orders[$document['Number']][$language_directory]);
								$language->load($orders[$document['Number']][$language_directory]);
								$language->load('mail/order');

								$subject = sprintf($language->get('text_update_subject'), html_entity_decode($orders[$document['Number']]['store_name'], ENT_QUOTES, 'UTF-8'), $orders[$document['Number']]['order_id']);

								$mail = new Mail();
								$mail->protocol = $this->config->get('config_mail_protocol');
								$mail->parameter = $this->config->get('config_mail_parameter');
								$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
								$mail->smtp_username = $this->config->get('config_mail_smtp_username');
								$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
								$mail->smtp_port = $this->config->get('config_mail_smtp_port');
								$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

								$mail->setTo($orders[$document['Number']]['email']);
								$mail->setFrom($this->config->get('config_email'));
								$mail->setSender(html_entity_decode($orders[$document['Number']]['store_name'], ENT_QUOTES, 'UTF-8'));
								$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
								$mail->setHtml(html_entity_decode($message));
								$mail->send();	
							}
							
							// Admin notification
							if (isset($tracking_settings[$document['StatusCode']]['admin_notification'])) {
								$language_directory = (version_compare(VERSION, '2.2', '>=')) ? 'code' : 'directory';

								$language = new Language($orders[$document['Number']][$language_directory]);
								$language->load($orders[$document['Number']][$language_directory]);
								$language->load('mail/order');

								$subject = sprintf($language->get('text_update_subject'), html_entity_decode($orders[$document['Number']]['store_name'], ENT_QUOTES, 'UTF-8'), $orders[$document['Number']]['order_id']);

								$mail = new Mail();
								$mail->protocol = $this->config->get('config_mail_protocol');
								$mail->parameter = $this->config->get('config_mail_parameter');
								$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
								$mail->smtp_username = $this->config->get('config_mail_smtp_username');
								$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
								$mail->smtp_port = $this->config->get('config_mail_smtp_port');
								$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

								$mail->setTo($this->config->get('config_email'));
								$mail->setFrom($this->config->get('config_email'));
								$mail->setSender(html_entity_decode($orders[$document['Number']]['store_name'], ENT_QUOTES, 'UTF-8'));
								$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
								$mail->setHtml(html_entity_decode($message));
								$mail->send();	
								
								// Send to additional alert emails
								$emails = explode(',', $this->config->get('config_mail_alert'));

								foreach ($emails as $email) {
									if ($email && preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
										$mail->setTo($email);
										$mail->send();
									}
								}
							}
						}
					}
				}
			}
		}
	}
}