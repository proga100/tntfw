<?php

    function stla_isset_checker( $category_form_options, $field_names){
        $is_field_set = false;
        foreach($field_names as $field_name){
            if(!empty($category_form_options[$field_name])){
                $is_field_set = true;
            }
        }
        return $is_field_set;
    }
