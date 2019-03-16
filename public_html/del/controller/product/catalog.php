<?php 
class ControllerProductCatalog extends Controller {  
	public function index() { 
 
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('tool/image'); 
		

					
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);	
			

	    

		
		  	$this->document->setTitle('Каталог');

			$this->document->setDescription('Каталог');
			if (isset($this->request->get['filter_model']) && isset($this->request->get['filter_motor'])) {	
				//$filter_filter = $this->model_catalog_category->getFilterByMark($this->request->get['filter_mark']);
				$filter_filter = $this->model_catalog_category->getFilterByMotor($this->request->get['filter_model'], $this->request->get['filter_motor']);
				$filter_url = '&filter_model='.$this->request->get['filter_model'].'&filter_motor='.$this->request->get['filter_motor'];
				$this->data['breadcrumbs'][] = array(
					'text'      => 'Каталог',
					'href'      => $this->url->link('product/catalog', 'filter_model='.$this->request->get['filter_model'].'&filter_motor='.$this->request->get['filter_motor']),
					'separator' => $this->language->get('text_separator')
				);
			} else {
				$filter_url = '';
				$this->data['breadcrumbs'][] = array(
					'text'      => 'Каталог',
					'href'      => $this->url->link('product/catalog'),
					'separator' => $this->language->get('text_separator')
				);
			}
			
			$this->data['heading_title'] = 'Каталог запчастей';
											
			$this->data['categories'] = array();
			$results = $this->model_catalog_category->getCategories(0);
			if(isset($_COOKIE['motor'])) {
			$sum = 0;
			$this->data['year'] = $_COOKIE['year'];
			$this->data['model'] = $this->model_catalog_category->getAvtoModel($_COOKIE['model']);
			$this->data['mark'] = $this->model_catalog_category->getAvtoMark($_COOKIE['mark']);
			$this->data['motor'] = $this->model_catalog_category->getAvtoMotor($_COOKIE['motor']);
			if (!isset($filter_filter)) {
				$this->data['heading_title'] .= ' для '.$this->data['mark'].' '.$this->data['model'].' '.$this->data['year'];
			}
			} else {
				$this->data['mark'] = $this->model_catalog_category->getAvtoMarks();
			}
			foreach ($results as $result) {
				$data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true
				);

				if(isset($_COOKIE['motor'])) {
					$data['filter_filter'] = $_COOKIE['motor'];
				}
				if (isset($filter_filter)) {	
					$data['filter_filter'] = $filter_filter;	
				} 

				

				if($this->config->get('config_product_count')) {
				$product_total = $this->model_catalog_product->getTotalProducts($data);	
				if(isset($_COOKIE['motor'])) {
					$sum += $product_total;
				}
				};	
				$ch = array();
			
					$ch_r = $this->model_catalog_category->getCategories($result['category_id']);
					
					foreach($ch_r as $ch_i) {
						$data_c = array(
						'filter_category_id'  => $ch_i['category_id'],
						'filter_sub_category' => true
						);
						if(isset($_COOKIE['motor'])) {
							$data_c['filter_filter'] = $_COOKIE['motor'];
						}
						if (isset($filter_filter)) {	
							$data_c['filter_filter'] = $filter_filter;	
						} 
						if($this->config->get('config_product_count')) {
						$product_total_c = $this->model_catalog_product->getTotalProducts($data_c);
						}
						$ch[] = array(
							'href' => $this->url->link('product/category', 'path=' . $result['category_id'] . '_' . $ch_i['category_id'].$filter_url),
							'name' => $ch_i['name'] . ($this->config->get('config_product_count') ? ' <span>(' . $product_total_c . ')</span>' : '')
						);
					}
				
				$this->data['categories'][] = array(
					'name'  => $result['name'],
					'href'  => $this->url->link('product/category', 'path=' . $result['category_id'].$filter_url),
					'thumb' => $this->model_tool_image->resize(($result['image']=='' ? 'no_image.jpg' : $result['image']), $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height')),
					'child' => $ch
				);
			}
			if(isset($_COOKIE['motor'])) {
			$sum = 0;
			if (!isset($filter_filter)) {
				$this->data['heading_title'] .= '<span>Найдено ' .$sum.' запчастей, которые подходят для выбраной модификации '.$this->data['mark'].' '.$this->data['model'].'</span>';
			}
			}

			
			$this->template = 'default/template/product/catalog.tpl';
			
			
			$this->children = array(
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
				
			$this->response->setOutput($this->render());										
  	}
}
?>
