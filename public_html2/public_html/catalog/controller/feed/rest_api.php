<?php

class ControllerFeedRestApi extends Controller {

	private $debugIt = false;

	/*
	* Get products
	*/
	public function products() {
        set_time_limit(0);
		$this->checkPlugin();

		$this->load->model('catalog/product');
	
		$json = array('success' => true, 'products' => array());

		/*check category id parameter*/
		if (isset($this->request->get['category'])) {
			$category_id = $this->request->get['category'];
		} else {
			$category_id = 0;
		}

		$products = $this->model_catalog_product->getProducts(array(
			'filter_category_id'        => $category_id
		));

		foreach ($products as $product) {

			if ($product['image']) {
				$image = $product['image'];
			} else {
				$image = false;
			}

			if ((float)$product['special']) {
				$special = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}

			$json['products'][] = array(
					'id'			=> $product['product_id'],
					'name'			=> $product['name'],
					'description'	=> $product['description'],
					'pirce'			=> $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'))),
					'href'			=> $this->url->link('product/product', 'product_id=' . $product['product_id']),
					'thumb'			=> $image,
					'special'		=> $special,
					'rating'		=> $product['rating']
			);
		}

		if ($this->debugIt) {
			echo '<pre>';
			print_r($json);
			echo '</pre>';
		} else {
			$this->response->setOutput(json_encode($json));
		}
	}
		

	/*
	* Get orders
	*/
	public function orders() {

		$this->checkPlugin();
	
		$orderData['orders'] = array();

		$this->load->model('account/order');

		/*check offset parameter*/
		if (isset($this->request->get['offset']) && $this->request->get['offset'] != "" && ctype_digit($this->request->get['offset'])) {
			$offset = $this->request->get['offset'];
		} else {
			$offset 	= 0;
		}

		/*check limit parameter*/
		if (isset($this->request->get['limit']) && $this->request->get['limit'] != "" && ctype_digit($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit 	= 10000;
		}
		
		/*get all orders of user*/
		$results = $this->model_account_order->getOrder($offset, $limit);
		
		$orders = array();

		if(count($results)){
			foreach ($results as $result) {

				$product_total = $this->model_account_order->getTotalOrderProductsByOrderId($result['order_id']);
				$voucher_total = $this->model_account_order->getTotalOrderVouchersByOrderId($result['order_id']);

				$orders[] = array(
						'order_id'		=> $result['order_id'],
						'name'			=> $result['firstname'] . ' ' . $result['lastname'],
						'status'		=> $result['status'],
						'date_added'	=> $result['date_added'],
						'products'		=> ($product_total + $voucher_total),
						'total'			=> $result['total'],
						'currency_code'	=> $result['currency_code'],
						'currency_value'=> $result['currency_value'],
				);
			}

			$json['success'] 	= true;
			$json['orders'] 	= $orders;
		}else {
			$json['success'] 	= false;
		}
		
		if ($this->debugIt) {
			echo '<pre>';
			print_r($json);
			echo '</pre>';

		} else {
			$this->response->setOutput(json_encode($json));
		}
	}


//-------------------------UPDATE CATEGORY ----------------------------------------------------------------------------
    public function updateCategory (){
           $this->checkPlugin();

            $json_url = $this->request->post['json_url'];
            $languages = $this->request->post['languages'];
            $languages = json_decode(htmlspecialchars_decode($languages));

            $this->load->model('oneboxsync/oneboxsync');
            $onebox_json = file_get_contents($json_url);
            $onebox_content = json_decode($onebox_json);
            $lang = array();
            if (count($languages)){
                foreach ($languages as $language){
                    $langId = $this->model_oneboxsync_oneboxsync->getLanguageId($language);
                    $lang[] = array(
                        'id' => $langId[0]['language_id'],
                        'name_code' => 'name_'.$language
                    );
                }
            }
            foreach ($onebox_content as $value) {
                $ext_id = $value->code1c;
                $id = $value->id;
                $name = $value->name;
                $name_lang = array();
                if (count($lang)){
                    foreach ($lang as $lan){
                        $name_lang[] = array (
                            'lang_id' => $lan['id'],
                            'name' => $value->$lan['name_code']
                        );
                    }
                } else {
                    $name_lang[] = array (
                        'lang_id' => '1',
                        'name' => $name
                    );
                }

                $parentid = $value->parentid;

                $is_category = $this->model_oneboxsync_oneboxsync->getCategoryId($id);

                if ($is_category->num_rows == 0) {
                /*    $is_category_code1c = $this->model_oneboxsync_oneboxsync->getCategoryIdCode1c($ext_id);
                    if ($is_category_code1c->num_rows != 0) {
                        $id = $is_category_code1c->rows[0]['category_id'];
                        $json = $this->model_oneboxsync_oneboxsync->updateCategory($id,$parentid, $name, $name_lang, $ext_id);
                        break;
                    }*/

                    $json = $this->model_oneboxsync_oneboxsync->newCategory($id, $parentid, $name, $name_lang, $ext_id);
                } else {
                    $json = $this->model_oneboxsync_oneboxsync->updateCategory($id,$parentid, $name, $name_lang, $ext_id);
                }
            }


        $this->response->setOutput(json_encode($json));
    }
//----------------------------------------------------------------------------------------------------------------------
    
//--------------------------------------------update PRODUCT------------------------------------------------------------
    
    public function updateProduct (){ 
            $this->checkPlugin();
        set_time_limit(0);
            $json_url = $this->request->post['json_url'];
            $languages = $this->request->post['languages'];
            $languages = json_decode(htmlspecialchars_decode($languages));

            $this->load->model('oneboxsync/oneboxsync');
            $onebox_json = file_get_contents($json_url);

            $lang = array();
            if (count($languages)){
                foreach ($languages as $language){
                    $langId = $this->model_oneboxsync_oneboxsync->getLanguageId($language);
                    $lang[] = array(
                        'id' => $langId[0]['language_id'],
                        'name_code' => 'name_'.$language
                    );
                }
            }

            $onebox_content = json_decode($onebox_json);
            foreach ($onebox_content as $value) {
                $name = $value->name;
                $name_lang = array();

                 if (count($lang)){
                     foreach ($lang as $lan){
                         $name_lang[] = array (
                             'lang_id' => $lan['id'],
                             'name' => $value->$lan['name_code']
                         );
                     }
                 } else {
                     $name_lang[] = array (
                         'lang_id' => '1',
                         'name' => $name
                     );
                 }

                $id = $value->id;

                $quantity = $value->avail;
                $description = $value->description;
                $imageArray = $value->imageArray;
                $articul = $value->articul;
                $brandname = $value->brandname;
                $price = $value->price;
                $currency = $value->currency;
                $avail = '1';
                $availtext = $value->availtext;
                $categoryid = $value->categoryid;
 /*               if ($id == ''){
                    $is_articul = $this->model_oneboxsync_oneboxsync->getProductArticul($articul);
                    $id = $is_articul->rows['0']['product_id'];
                    $is_product1 = 1;
                    if ($id == ''){
                        $max_id = $this->model_oneboxsync_oneboxsync->getMaxProductId();
                        $id = $max_id->rows[0]['product_id']+1;
                        $is_product1 = 0;
                    }

                } else {
 */                 $is_product = $this->model_oneboxsync_oneboxsync->getProductId($id);
                    $is_product1 = $is_product->num_rows;
  //              }

                $is_currency = $this->model_oneboxsync_oneboxsync->getCurrencyValue($currency);

                if ($is_currency->num_rows == 0) {
                    $this->model_oneboxsync_oneboxsync->newCurrencyValue($currency, $currency, '1', '1');
                } else {
                    $ratio = $is_currency->row['value'];
                    $price = $price / $ratio;
                }

                $nImage = count($imageArray);
                $image = '';

                if ($nImage == 0) {
                    $image = '';
                } elseif ($nImage == 1) {
                    $file_name = basename($imageArray[0]);
                    if (!file_exists('image/oc_' . $id . $file_name)) {
                        if (!copy($imageArray[0], 'image/oc_' . $id . $file_name)) {
                            $str = "not copy image ..\n";
                        }
                    }
                    $image = preg_replace('/\//', '\/', 'oc_'. $id . $file_name);
                } else {
                    foreach ($imageArray as $idImage => $imageValue) {
                        if ($idImage == 0) {
                            $file_name = basename($imageValue);
                            if (!file_exists('image/oc_' . $id . $file_name)) {
                                if (!copy($imageValue, 'image/oc_' . $id . $file_name)) {
                                    $str = "not copy image ..\n";
                                }
                            }
                            $image = preg_replace('/\//', '\/', 'oc_' . $id . $file_name);
                        } else {
                            $file_name = basename($imageValue);
                            if (!file_exists('image/oc_' . $id . $file_name)) {
                                if (!copy($imageValue, 'image/oc_' . $id . $file_name)) {
                                    $str = "not copy image ..\n";
                                }
                            }
                            $image1 = preg_replace('/\//', '\/', 'oc_' . $id . $file_name);

           //                 $isProductImage = $this->model_oneboxsync_oneboxsync->isImage($id, $image1);
           //                 if ($isProductImage->num_rows == 0) {
                            $this->model_oneboxsync_oneboxsync->newImageValue($id, $image1);
           //                 }
                        }
                    }
                }
                $isCategoryId = $this->model_oneboxsync_oneboxsync->isCategoryId($id, $categoryid);
                if ($isCategoryId->num_rows == 0) {
                    $this->model_oneboxsync_oneboxsync->newProductCategory($id, $categoryid);
                }
                if ($brandname != '') {
                    $is_manufacturer = $this->model_oneboxsync_oneboxsync->isBrand($brandname);
                    if ($is_manufacturer->num_rows == 0) {
                        $this->model_oneboxsync_oneboxsync->newBrand($brandname);
                        $is_manufacturer = $this->model_oneboxsync_oneboxsync->isBrand($brandname);
                        $manufacturer = $is_manufacturer->row['manufacturer_id'];
                    } else {
                        $manufacturer = $is_manufacturer->row ['manufacturer_id'];
                    }
                } else {
                    $manufacturer = '';
                }

                if ($is_product1 == 0) {
//*****
//NEW PRODUCT
//*****

                    $json[] = $this->model_oneboxsync_oneboxsync->newProduct($id, $articul, $quantity, $image, $manufacturer, $price, $avail, $name, $name_lang, $description);
                } else {
//*****
//PRODUCT is IN BASE
//*****
                    $json[] = $this->model_oneboxsync_oneboxsync->updateProduct($id, $articul, $quantity, $image, $manufacturer, $price, $avail, $name, $name_lang, $description);
                }
        }
        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
//----------------------------------------------------------------------------------------------------------------------

//--------------------------------------------ORDER---------------------------------------------------------------------

    public function getOrderValue() {
        $this->checkPlugin();
        $this->load->model('oneboxsync/oneboxsync');

        $data = $this->model_oneboxsync_oneboxsync->getOrderValue();
        $json = array();

        foreach ($data as $key => $value) {

            $order_products = $this->model_oneboxsync_oneboxsync->getOrderProduct($value['order_id']);
            $order_product_value = array();
            foreach ($order_products as $product) {
                $order_products_options = $this->model_oneboxsync_oneboxsync->getOrderProductOptions($value['order_id'], $product['order_product_id']);
                $product_options = array();
                foreach ($order_products_options as $product_option){
                    $product_options[] = array(
                        'product_option_id'         => $product_option['product_option_id'],
                        'product_option_value_id'   => $product_option['product_option_value_id'],
                        'product_option_name'       => $product_option['name'],
                        'product_option_value'      => $product_option['value']
                    );
                }

                $order_product_value[] = array(
                    'product_id'         => $product['product_id'],
                    'product_name'       => $product['name'],
                    'product_model'      => $product['model'],
                    'product_quantity'   => $product['quantity'],
                    'product_store'   => $product['store'],
                    'product_articul'    => $product['BKEY'],
                    'product_brand'      => $product['AKEY'],
                    'product_price'      => $product['price'],
                    'original_price'     => $product['original_price'],
                    'product_total'      => $product['total'],
                    'product_tax'        => $product['tax'],
                    'product_reward'     => $product['reward'],
                    'product_options'    => $product_options
                );
            }
            $json[] = array(
                'order_id'               => $value['order_id'],
                'customer_id'            => $value['customer_id'],
                'firstname'              => $value['firstname'],
                'lastname'               => $value['lastname'],
                'email'                  => $value['email'],
                'telephone'              => $value['telephone'],
                'payment'                => $value['payment'],
                'manager'                => $value['manager'],
                'payment_firstname'      => $value['payment_firstname'],
                'payment_lastname'       => $value['payment_lastname'],
                'payment_company'        => $value['payment_company'],
                'payment_address_1'      => $value['payment_address_1'],
                'payment_address_2'      => $value['payment_address_2'],
                'payment_city'           => $value['payment_city'],
                'payment_postcode'       => $value['payment_postcode'],
                'payment_country'        => $value['payment_country'],
                'payment_country_id'     => $value['payment_country_id'],
                'payment_zone'           => $value['payment_zone'],
                'payment_zone_id'        => $value['payment_zone_id'],
                'payment_address_format' => $value['payment_address_format'],
                'payment_method'         => $value['payment_method'],
                'payment_code'           => $value['payment_code'],
                'shipping_firstname'     => $value['shipping_firstname'],
                'shipping_lastname'      => $value['shipping_lastname'],
                'shipping_company'       => $value['shipping_company'],
                'shipping_address_1'     => $value['shipping_address_1'],
                'shipping_address_2'     => $value['shipping_address_2'],
                'shipping_city'          => $value['shipping_city'],
                'shipping_postcode'      => $value['shipping_postcode'],
                'shipping_country'       => $value['shipping_country'],
                'shipping_country_id'    => $value['shipping_country_id'],
                'shipping_zone'          => $value['shipping_zone'],
                'shipping_zone_id'       => $value['shipping_zone_id'],
                'shipping_address_format'=> $value['shipping_address_format'],
                'shipping_method'        => $value['shipping_method'],
                'shipping_code'          => $value['shipping_code'],
                'comment'                => $value['comment'],
                'total'                  => $value['total'],
                'order_status_id'        => $value['order_status_id'],
                'affiliate_id'           => $value['affiliate_id'],
                'commission'             => $value['commission'],
                'language_id'            => $value['language_id'],
                'currency_id'            => $value['currency_id'],
                'currency_code'          => $value['currency_code'],
                'currency_value'         => $value['currency_value'],
                'customer_ip'            => $value['ip'],
                'date_added'             => $value['date_added'],
                'product'                => $order_product_value
            );
        }

        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }


    public function updateOrder (){
            $this->checkPlugin();
        
            $order_id = $this->request->post['order_id'];
            $status_id = $this->request->post['status_id'];
            $this->load->model('oneboxsync/oneboxsync');
            /*
                    $onebox_content = json_decode($onebox_json);
                    foreach ($onebox_content as $value) {           */
            $json = $this->model_oneboxsync_oneboxsync->updateStatusOrder($status_id, $order_id);
            //       }
        
        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

        public function updateOrderValue () {
            $this->checkPlugin();
            
            $json_url = $this->request->post['json_url'];
            $this->load->model('oneboxsync/oneboxsync');
            $onebox_json = file_get_contents($json_url);
            $onebox_content = json_decode($onebox_json);
            foreach ($onebox_content as $value) {
                $is_order = $this->model_oneboxsync_oneboxsync->isOrder ($value->order_id);
                if ($is_order->num_rows == 0) {
                    $json = $this->model_oneboxsync_oneboxsync->updateOrderValue ($value->order_id, $value->firstname, $value->lastname, $value->email, $value->telephone, $value->payment_firstname, $value->payment_lastname, $value->payment_company, $value->payment_address_1, $value->payment_address_2, $value->payment_city, $value->payment_postcode, $value->payment_country, $value->payment_country_id, $value->payment_zone, $value->payment_zone_id, $value->payment_address_format, $value->payment_custom_field, $value->payment_method, $value->payment_code, $value->shipping_firstname, $value->shipping_lastname, $value->shipping_company, $value->shipping_address_1, $value->shipping_address_2, $value->shipping_city, $value->shipping_postcode, $value->shipping_country, $value->shipping_country_id, $value->shipping_zone, $value->shipping_zone_id, $value->shipping_address_format, $value->shipping_custom_field, $value->shipping_method, $value->shipping_code, $value->comment, $value->total, $value->order_status_id, $value->affiliate_id, $value->commission, $value->marketing_id, $value->tracking, $value->language_id, $value->currency_id, $value->currency_code, $value->currency_value, $value->customer_ip, $value->date_added, $value->product_id, $value->product_name, $value->product_model, $value->product_quantity, $value->product_price, $value->product_total, $value->product_tax);
                    $this->model_oneboxsync_oneboxsync->updateOrderHistoryStatus ($value->order_id, $value->order_status_id);
                } else {
                    $json = $this->model_oneboxsync_oneboxsync->updateOrderValue ($value->order_id, $value->firstname, $value->lastname, $value->email, $value->telephone, $value->payment_firstname, $value->payment_lastname, $value->payment_company, $value->payment_address_1, $value->payment_address_2, $value->payment_city, $value->payment_postcode, $value->payment_country, $value->payment_country_id, $value->payment_zone, $value->payment_zone_id, $value->payment_address_format, $value->payment_custom_field, $value->payment_method, $value->payment_code, $value->shipping_firstname, $value->shipping_lastname, $value->shipping_company, $value->shipping_address_1, $value->shipping_address_2, $value->shipping_city, $value->shipping_postcode, $value->shipping_country, $value->shipping_country_id, $value->shipping_zone, $value->shipping_zone_id, $value->shipping_address_format, $value->shipping_custom_field, $value->shipping_method, $value->shipping_code, $value->comment, $value->total, $value->order_status_id, $value->affiliate_id, $value->commission, $value->marketing_id, $value->tracking, $value->language_id, $value->currency_id, $value->currency_code, $value->currency_value, $value->customer_ip, $value->date_added, $value->product_id, $value->product_name, $value->product_model, $value->product_quantity, $value->product_price, $value->product_total, $value->product_tax);
                    $is_orderHistoryStatus = $this->model_oneboxsync_oneboxsync->getOrderHistoryStatus ($value->order_id);
                    if ($is_orderHistoryStatus->row['order_status_id'] != $value->order_status_id) {
                        $this->model_oneboxsync_oneboxsync->updateOrderHistoryStatus ($value->order_id, $value->order_status_id);
                    }
                }
            }
        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
//------------------------------------------------------------------------------------------------    
    
    public function updateFiltreName () {
            $this->checkPlugin();

            $json_url = $this->request->post['json_url'];
            $languages = $this->request->post['languages'];
            $languages = json_decode(htmlspecialchars_decode($languages));

            $this->load->model('oneboxsync/oneboxsync');
            $onebox_json = file_get_contents($json_url);
            $onebox_content = json_decode($onebox_json);
        
            $is_ocfilter = $this->model_oneboxsync_oneboxsync->isOcfilter();
        
            $lang = array();
            if (count($languages)){
                foreach ($languages as $language){
                    $langId = $this->model_oneboxsync_oneboxsync->getLanguageId($language);
                    $lang[] = array(
                        'id' => $langId[0]['language_id'],
                        'name_code' => 'name_'.$language
                    );
                }
            }

            foreach ($onebox_content as $value) {
                $name = $value->name;
                $id = $value->id;
                $name_lang = array();

                if (count($lang)){
                    foreach ($lang as $lan){
                        $name_lang[] = array (
                            'lang_id' => $lan['id'],
                            'name' => $value->$lan['name_code']
                        );
                    }
                } else {
                    $name_lang[] = array (
                        'lang_id' => '1',
                        'name' => $name
                    );
                }
                $json = $this->model_oneboxsync_oneboxsync->updateStandartFiltreName($id, $name, $name_lang);
                
                if ($is_ocfilter->num_rows){
                    
                    $is_filtr = $this->model_oneboxsync_oneboxsync->getFilterId($id);
                    if ($is_filtr->num_rows == 0) {
                        $json = $this->model_oneboxsync_oneboxsync->newFiltreName($id, $name, $name_lang);
                    } else {
                        $json = $this->model_oneboxsync_oneboxsync->updateFiltreName($id, $name, $name_lang);
                    }
                }
            }

        if (isset($this->request->server['HTTP_ORIGIN'])) {
        $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
        $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        $this->response->addHeader('Access-Control-Max-Age: 1000');
        $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
    
    public function updateFiltreProductValue () {
            $this->checkPlugin();

            $json_url = $this->request->post['json_url'];
            $this->load->model('oneboxsync/oneboxsync');
            $onebox_json = file_get_contents($json_url);
            $onebox_content = json_decode($onebox_json);
            foreach ($onebox_content as $value) {
                $json = $this->model_oneboxsync_oneboxsync->updateFiltreProductValueModel($value->filterid, $value->productid, $value->filtervalue);
                
            }
        
        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    
    
    
    
    
    
    
    
    
    
	//******************************************************************
    public function category() {
            $this->checkPlugin();
        
             $this->load->model('oneboxsync/oneboxsync');
             $data['category'] = $this->model_oneboxsync_oneboxsync->getCategory();
             $json = array();
             $n_json = 0;

             foreach ($data['category'] as $key => $value) {
                 if ($n_json && $value['category_id'] == $json[$n_json - 1]['id']) {
                     $name_lang = "name_" . $value['code'];
                     $json[$n_json - 1][$name_lang] = $value['name'];
                     continue;
                 }
                 $json[$n_json]['id'] = $value['category_id'];
                 $json[$n_json]['name'] = $value['name'];
                 $name_lang = "name_" . $value['code'];
                 $json[$n_json][$name_lang] = $value['name'];
                 $json[$n_json]['parentid'] = $value['parent_id'];
                 $json[$n_json]['code1c'] = '';
                 $n_json++;
             }
     

        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
//*******************************************************************
public function product() {
             $this->checkPlugin();
            $this->load->model('oneboxsync/oneboxsync');
            $data['currency'] = $this->model_oneboxsync_oneboxsync->getCurrency();
            $data['products'] = $this->model_oneboxsync_oneboxsync->getProducts();

            $json = array();
            $n_json = 0;

            foreach ($data['products'] as $key => $value) {

                if ($n_json && $value['product_id'] == $json[$n_json - 1]['id']) {
                    $name_lang = "name_" . $value['code'];
                    $json[$n_json - 1][$name_lang] = $value['name'];
                    $newCatId = 0;
                    foreach ($json[$n_json - 1]['categoryid'] as $cat) {
                        if ($cat != $value['category_id']) {
                            $newCatId = 1;
                        } else {
                            $newCatId = 0;
                            break;
                        }
                    }
                    if ($newCatId == 1) {
                        $json[$n_json - 1]['categoryid'][] = $value['category_id'];
                    }

                    $newImage = 0;
                    foreach ($json[$n_json - 1]['imageArray'] as $cat) {
                        if ($cat != $value['image']) {
                            $newImage = 1;
                        } else {
                            $newImage = 0;
                            break;
                        }
                    }
                    if ($newImage == 1) {
                        $json[$n_json - 1]['imageArray'][] = $value['image'];
                    }
                    continue;
                }

              $json[$n_json]['id'] = $value['product_id'];
                $json[$n_json]['name'] = $value['name'];
                $json[$n_json]['description'] = $value['description'];
                $json[$n_json]['model'] = '';
                $json[$n_json]['articul'] = $value['model'];
                $json[$n_json]['categoryid'] = array();
                $json[$n_json]['categoryid'][] = $value['category_id'];
                $json[$n_json]['imageArray'] = array();
                $json[$n_json]['imageArray'][] = $value['image_osn'];
                $json[$n_json]['imageArray'][] = $value['image'];
                $json[$n_json]['code1c'] = '';
                $json[$n_json]['avail'] = $value['status'];
                $json[$n_json]['availtext'] = '';
                $json[$n_json]['price'] = $value['price'];
                $json[$n_json]['currency'] = $data['currency'];
                $json[$n_json]['brandname'] = $value['manufacturername'];
                $json[$n_json]['seriesname'] = '';
                $n_json++;
        }
        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json ));
    }
//*************************************************************************************************************************

    public function addFiles (){
             $this->checkPlugin();
            $json_url = $this->request->post['json_url'];
            $name = $this->request->post['name'];
            $onebox_json = "[" . file_get_contents($json_url) . "]";
            $onebox_json = preg_replace('/\}\s\{/', '},{', $onebox_json);
            $name = 'catalog/onebox/' . $name;
            $fp = fopen($name, 'w');
            fwrite($fp, $onebox_json);
            fclose($fp);
        
        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode('Saved'));
    }    
    
    

//*********************************************************************************************************************
    public function statusname(){
       // if (!isset($this->session->data['api_id'])) {
       //     $json['error'] = 'error_permission';
      //  } else {
            $this->load->model('oneboxsync/oneboxsync');
            $data['status_name'] = $this->model_oneboxsync_oneboxsync->getStatusName();
            $json = array();
            $n_json = 0;

            foreach ($data['status_name'] as $key => $value) {
                if ($n_json && $value['order_status_id'] == $json[$n_json - 1]['order_status_id']) {
                    $name_lang = "name_" . $value['code'];
                    $json[$n_json - 1][$name_lang] = $value['name'];
                    continue;
                }
                $json[$n_json]['order_status_id'] = $value['order_status_id'];
                $json[$n_json]['name'] = $value['name'];
                $name_lang = "name_" . $value['code'];
                $json[$n_json][$name_lang] = $value['name'];
                $n_json++;
            }
       // }

        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

//*********************************************************************************************************************
	private function checkPlugin() {

		$json = array("success"=>false);

		/*check rest api is enabled*/
		if (!$this->config->get('rest_api_status')) {
			$json["error"] = 'API is disabled. Enable it!';
		}
		
		/*validate api security key*/
		if ($this->config->get('rest_api_key') && (!isset($this->request->get['key']) || $this->request->get['key'] != $this->config->get('rest_api_key'))) {
			$json["error"] = 'Invalid secret key';
		}
		
		if(isset($json["error"])){
			$this->response->addHeader('Content-Type: application/json');
			echo(json_encode($json));
			exit;
		}else {
			$this->response->setOutput(json_encode($json));			
		}	
	}	

}
