<?php
/*
@author	Dmitriy Kubarev
@link	http://www.simpleopencart.com
@link	http://www.opencart.com/index.php?route=extension/extension/info&extension_id=4811
*/  

class ModelToolSimpleData extends Model {

    public function select_main_city($fields) {
        $values = array();
        
        $country_id = $fields['main_country_id']['value']; // id of selected country
        $zone_id = $fields['main_zone_id']['value'];       // id of selected zone

        //echo $country_id.' -> '.$zone_id;

        // list of values for current country_id and zone_id
        $query = $this->db->query("SELECT name FROM city WHERE zone_id = '".$zone_id."' ORDER BY name ASC");

        foreach ($query->rows as $result) {
            $values[$result['name']] = $result['name'];
        }
        
        return $values;
    }

    public function init_main_city($fields) {
        return 3;
    }

    public function validate_main_city($value, $fields) {
        return empty($value) ? 'error' : '';
    }

    public function mask_main_telephone($fields) {
        $mask = '';

        // example for setting a mask by selected language

        $country_id = $fields['main_country_id']['value']; // id of selected country

        if ($country_id == 176) {
            $mask = '+7(999)999-9999';
        }

        // example for setting a mask by selected language

        $lang_code = $this->config->get('config_language');

        if ($lang_code == 'ru') {
            $mask = '+7(999)999-9999';
        } else {
            $mask = '99999999999';
        }

        return $mask;
    }

    public function status_custom_lift($fields) {
        $shippping = $this->simple->shipping_method;
        return $shippping['code'] == 'flat.flat' ? true : false;
    }

    public function status_custom_flat($fields) {
        $shippping = $this->simple->shipping_method;
        return $shippping['code'] == 'flat.flat' && $fields['custom_lift']['value'] == 1 ? true : false;
    }

    public function reload_custom_lift($fields) {
        $shippping = $this->simple->shipping_method;
        return $shippping['code'] == 'flat.flat' ? true : false;
    }
    
    public function select_custom_select($fields) {
        $values = array();
        
        /*$this->load->model('account/salesrep');
        $salesreps = $this->model_account_salesrep->getSalesReps();
        
        foreach ($salesreps as $salesrep) {
            $values[$salesrep['salesrep_id']] = $salesrep['name'];
        }*/

        // $other_field_value = $fields['field_id']['value'];
        // $zone_id = $fields['main_zone_id']['value'];

        $values[1] = 'Name 1';
        $values[2] = 'Name 2';
        $values[3] = 'Name 3';
        $values[4] = 'Name 4';
        
        return $values;
    }

    // This is example of validation method for field company_name. This method must return text of the validation error.
    public function validate_company_name($value) {
        return empty($value) ? 'error' : '';
    }
}
?>