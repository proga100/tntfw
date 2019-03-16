<?php

if (!class_exists('ESIG_GF_VALUE')):

    abstract class ESIG_GF_VALUE {

        public static function generate_value($formid, $field_id, $entry_id, $docId, $display = "value", $option = "default") {

            $form = GFAPI::get_form($formid);
            $field = GFFormsModel::get_field($form, $field_id);

            //$label= isset($field->label)?$field->label:false;

            /* if($display =="label"){
              return $label;
              } */

            $lead = ESIG_GF_SETTINGS::getEntry($docId);
            if (!$lead) {
                $lead = GFAPI::get_entry($entry_id);
            }

            if (is_wp_error($lead)) {
                return false;
            }

            $value = self::get_default_value($lead, $field, $form, $field_id, $display, $option);
            return $value;
            /* if($display=="value"){
              return $value;
              }
              elseif($display=="label_value"){
              return $label .": " .$value;
              } */
        }

        public static function get_field_type($formid, $field_id) {
            $form = GFAPI::get_form($formid);
            $field = GFFormsModel::get_field($form, $field_id);
            return esigget('type', $field);
        }

        public static function prepareDisplay($display, $value, $label) {
            if ($display == "label") {
                return $label;
            } elseif ($display == "value") {
                return $value;
            } elseif ($display == "label_value") {
                return $label . ": " . $value;
            }
        }

        public static function get_html($entries, $field, $field_id, $forms) {
            $html = '';
            if (!empty($field->content)) {
                $content = GFCommon::replace_variables_prepopulate($field->content); // adding support for merge tags
                $content = do_shortcode($content); // adding support for short
                $html .= $content;
            }

            $html .= str_replace('{FIELD}', '', GF_Fields::get('html')->get_field_content($entries[$field_id], true, $forms));

            return $html;
        }

        public static function getRadio($lead, $field, $form, $enableChoiceValue, $display, $label) {
            $defaultValue = self::defaultValue($lead, $field, $form, false, 'text');
            $choices = esigget('choices', $field);

            if (is_array($choices) && $enableChoiceValue) {
                foreach ($choices as $options) {
                    $text = esigget("text", $options);
                    $value = esigget("value", $options);
                    if ($value == $defaultValue) {
                        return self::prepareDisplay($display, $value, $text);
                    }
                }
            }

            return $defaultValue;
        }

        public static function getCheckbox($lead, $field, $form, $enableChoiceValue, $display, $label, $option) {

            if (!$enableChoiceValue && $display == "value") {

                if ($option == "check") {
                    $value = RGFormsModel::get_lead_field_value($lead, $field);

                    if (is_array($value)) {
                        $items = '';
                        foreach ($value as $key => $item) {
                            if (!rgblank($item)) {
                                $items .= '<li><span style="font-size:16px;">&#10003;</span>' . $item . '</li>';
                            }
                        }
                    }
                    return "<ul class='esig-checkbox-tick'>$items</ul>";
                } else {

                    return self::defaultValue($lead, $field, $form, false, 'html');
                }
            }

            $defaultValue = self::defaultValue($lead, $field, $form, false, 'text');
            $defaultLabel = self::defaultValue($lead, $field, $form, true, 'text');

            return self::prepareDisplay($display, $defaultValue, $defaultLabel);
            /* $choices = esigget('choices', $field);

              if (is_array($choices)) {

              $currentValues = explode(',', $defaultValue);

              $result = '';
              foreach ($choices as $key => $options) {

              //$text = esigget("text", $options);
              $value = esigget("value", $options);
              // echo $value;
              if (in_array($value, $currentValues)) {

              $result .= $value . ', ';
              }

              }

              return substr($result, 0, strlen($result) - 2);
              } */

            //return self::defaultValue($lead, $field,$form,false,'html'); 
        }

        public static function getMultiSelect($lead, $field, $form, $enableChoiceValue, $display, $option) {
            // return self::defaultValue($lead, $field, $form, false, 'html');
            if (!$enableChoiceValue && $display == "label") {
                return self::defaultValue($lead, $field, $form, false, 'html');
            }

            $defaultValue = self::defaultValue($lead, $field, $form, false, 'text');

            $currentValues = json_decode($defaultValue);
            $result = '';

            if (!is_array($currentValues)) {
                return false;
            }

            if ($enableChoiceValue && $display == "label") {
                foreach ($field->choices as $choice) {
                   
                    foreach ($currentValues as $item) {
                        if (RGFormsModel::choice_value_match($field, $choice, $item)) {
                            $result .= $choice['text'] . ', ';
                        }
                    }
                }
            }
            if ($enableChoiceValue && $display == "label_value") {
                foreach ($field->choices as $choice) {
                    foreach ($currentValues as $item) {
                        if (RGFormsModel::choice_value_match($field, $choice, $item)) {
                            $result .= $choice['text'] . ": " .$item . ', ';
                        }
                    }
                }
            }
            if ($enableChoiceValue && $display == "value") {
                foreach ($currentValues as $key => $value) {

                    $result .= $value . ', ';
                }
            }
            return substr($result, 0, strlen($result) - 2);
        }

        public static function remove_map_it($result) {
            return true;
        }

        public static function get_address($lead, $field, $field_id, $form) {
            add_filter("gform_disable_address_map_link", array(__CLASS__, "remove_map_it"), 10, 1);
            $value = RGFormsModel::get_lead_field_value($lead, $field);
            $display_value = GFCommon::get_lead_field_display($field, $value, $lead['currency']);
            return apply_filters('gform_entry_field_value', $display_value, $field, $lead, $form);
        }

        public static function defaultValue($lead, $field, $form, $use_text = false, $format = 'html') {
            $value = RGFormsModel::get_lead_field_value($lead, $field);
            $display_value = GFCommon::get_lead_field_display($field, $value, $lead['currency'], $use_text, $format);
            return apply_filters('gform_entry_field_value', $display_value, $field, $lead, $form);
        }

        public static function get_default_value($lead, $field, $form, $field_id, $display, $option) {

            //make a condition to check input field
            $type = esigget('type', $field);
            $label = isset($field->label) ? $field->label : false;

            switch ($type):

                case "html":
                    return self::get_html($lead, $field, $field_id, $form);
                case "address":
                    return self::get_address($lead, $field, $field_id, $form);
                case "radio":
                    $enableChoiceValue = esigget("enableChoiceValue", $field);
                    return self::getRadio($lead, $field, $form, $enableChoiceValue, $display, $label);
                case "checkbox":
                    $enableChoiceValue = esigget("enableChoiceValue", $field);
                    return self::getCheckbox($lead, $field, $form, $enableChoiceValue, $display, $label, $option);
                case "select":
                    $enableChoiceValue = esigget("enableChoiceValue", $field);
                    return self::getRadio($lead, $field, $form, $enableChoiceValue, $display, $label);
                case "multiselect":
                    $enableChoiceValue = esigget("enableChoiceValue", $field);
                    return self::getMultiSelect($lead, $field, $form, $enableChoiceValue, $display, $option);
                default:
                    $value = RGFormsModel::get_lead_field_value($lead, $field);
                    $display_value = GFCommon::get_lead_field_display($field, $value, $lead['currency']);
                    $ret_value = apply_filters('gform_entry_field_value', $display_value, $field, $lead, $form);
                    return self::prepareDisplay($display, $ret_value, $label);
            endswitch;
        }

        public static function display_value($display, $document_id) {

            $display_type = ESIG_GF_SETTINGS::get_display_feed($document_id);
            if ($display_type == "underline") {
                return "<u>" . $display . "</u>";
            } else {
                return $display;
            }
        }

    }

    

    

    

    

    

    

    

    

    

    

    

endif;