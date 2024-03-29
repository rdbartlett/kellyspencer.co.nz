<?php
/**
 * Types-field: Radio
 *
 * Description: Displays a radio selection to the user.
 *
 * Rendering: The option title will be rendered or if set - specific value.
 * 
 * Parameters:
 * 'raw' => 'true'|'false' (display raw data stored in DB, default false)
 * 'output' => 'html' (wrap data in HTML, optional)
 * 'show_name' => 'true' (show field name before value e.g. My checkbox: $value)
 *
 * Example usage:
 * With a short code use [types field="my-radios"]
 * In a theme use types_render_field("my-radios", $parameters)
 * 
 */

/**
 * Form data for group form.
 * 
 * @return type 
 */
function wpcf_fields_radio_insert_form($form_data = array(), $parent_name = '') {
    $id = 'wpcf-fields-radio-' . mt_rand();
    $form['name'] = array(
        '#type' => 'textfield',
        '#title' => __('Name of custom field', 'wpcf'),
        '#description' => __('Under this name field will be stored in DB (sanitized)',
                'wpcf'),
        '#name' => 'name',
        '#attributes' => array('class' => 'wpcf-forms-set-legend'),
        '#validate' => array('required' => array('value' => true)),
    );
    $form['description'] = array(
        '#type' => 'textarea',
        '#title' => __('Description', 'wpcf'),
        '#description' => __('Text that describes function to user', 'wpcf'),
        '#name' => 'description',
        '#attributes' => array('rows' => 5, 'cols' => 1),
    );
    $form['options-markup-open'] = array(
        '#type' => 'markup',
        '#markup' => '<strong>' . __('Options', 'wpcf')
        . '</strong><br /><br /><div id="' . $id . '-sortable"'
        . ' class="wpcf-fields-radio-sortable wpcf-compare-unique-value-wrapper">',
    );

    $existing_options = array();
    if (!empty($form_data['data']['options'])) {
        foreach ($form_data['data']['options'] as $option_key => $option) {
            if ($option_key == 'default') {
                continue;
            }
            $option['key'] = $option_key;
            $option['default'] = isset($form_data['data']['options']['default']) ? $form_data['data']['options']['default'] : null;
            $form_option = wpcf_fields_radio_get_option('', $option);
            $existing_options[array_shift($form_option)] = $option;
            $form = $form + $form_option;
        }
    } else {
        $form_option = wpcf_fields_radio_get_option();
        $existing_options[array_shift($form_option)] = array();
        $form = $form + $form_option;
    }

    $form['options-response-close'] = array(
        '#type' => 'markup',
        '#markup' => '</div>',
    );

    $form['options-no-default'] = array(
        '#type' => 'radio',
        '#inline' => true,
        '#title' => __('No Default', 'wpcf'),
        '#name' => '[options][default]',
        '#value' => 'no-default',
        '#default_value' => isset($form_data['data']['options']['default']) ? $form_data['data']['options']['default'] : null,
    );

    if (!empty($form_data['data']['options'])) {
        $count = count($form_data['data']['options']);
    } else {
        $count = 1;
    }

    $form['options-markup-close'] = array(
        '#type' => 'markup',
        '#markup' => '<div id="'
        . $id . '-add-option"></div><br /><a href="'
        . admin_url('admin-ajax.php?action=wpcf_ajax&amp;wpcf_action=add_radio_option&amp;_wpnonce='
                . wp_create_nonce('add_radio_option') .'&amp;wpcf_ajax_update_add='
                . $id . '-sortable&amp;parent_name=' . urlencode($parent_name)
                . '&amp;count=' . $count)
        . '" onclick="wpcfFieldsFormCountOptions(jQuery(this));"'
        . ' class="button-secondary wpcf-ajax-link">'
        . __('Add option', 'wpcf') . '</a>',
    );
    $form['options-close'] = array(
        '#type' => 'markup',
        '#markup' => '<br /><br />',
    );
    $form['display'] = array(
        '#type' => 'radios',
        '#default_value' => 'db',
        '#name' => 'display',
        '#options' => array(
            'display_from_db' => array(
                '#title' => __('Display the value of this field from the database',
                        'wpcf'),
                '#name' => 'display',
                '#value' => 'db',
                '#inline' => true,
                '#after' => '<br />'
            ),
            'display_values' => array(
                '#title' => __('Show one of these values:', 'wpcf'),
                '#name' => 'display',
                '#value' => 'value',
                '#inline' => true,
            ),
        ),
        '#inline' => true,
    );
    $form['display-open'] = array(
        '#type' => 'markup',
        '#markup' => '<div id="wpcf-form-groups-radio-ajax-response-'
        . $id . '-sortable" style="margin: 10px 0 20px 0;">',
    );
    if (!empty($existing_options)) {
        foreach ($existing_options as $option_id => $option_form_data) {
            $form_option = wpcf_fields_radio_get_option_alt_text($option_id, '',
                    $option_form_data);
            $form = $form + $form_option;
        }
    }
    $form['display-close'] = array(
        '#type' => 'markup',
        '#markup' => '</div>',
    );
    return $form;
}

/**
 * Returns form data for radio.
 * 
 * @param type $parent_name Used for AJAX adding options
 * @param type $form_data
 * @return type 
 */
function wpcf_fields_radio_get_option($parent_name = '', $form_data = array()) {
    $id = isset($form_data['key']) ? $form_data['key'] : 'wpcf-fields-radio-option-' . mt_rand();
    $form = array();
    $value = isset($_GET['count']) ? __('Option title', 'wpcf') . ' ' . $_GET['count'] : __('Option title',
                    'wpcf') . ' 1';
    $value = isset($form_data['title']) ? $form_data['title'] : $value;
    $form[$id . '-id'] = $id;
    $form[$id . '-title'] = array(
        '#type' => 'textfield',
        '#id' => $id . '-title',
        '#name' => $parent_name . '[options][' . $id . '][title]',
        '#value' => $value,
        '#inline' => true,
        '#attributes' => array(
            'style' => 'width:80px;',
            'class' => 'wpcf-form-groups-radio-update-title-display-value',
        ),
        '#before' => '<div class="wpcf-fields-radio-draggable"><img src="'
        . WPCF_RES_RELPATH
        . '/images/move.png" class="wpcf-fields-form-radio-move-field" alt="'
        . __('Move this option', 'wpcf') . '" /><img src="'
        . WPCF_RES_RELPATH . '/images/delete.png"'
        . ' class="wpcf-fields-radio-delete-option wpcf-pointer"'
        . ' onclick="if (confirm(\'' . __('Are you sure?', 'wpcf')
        . '\')) { jQuery(this).parent().fadeOut(function(){jQuery(this).remove(); '
        . '}); '
        . 'jQuery(\'#\'+jQuery(this).parent().find(\'input\').attr(\'id\')+\''
        . '-display-value-wrapper\').fadeOut(function(){jQuery(this).remove();}); }"'
        . 'alt="' . __('Delete this option', 'wpcf') . '" />',
    );
    $value = isset($_GET['count']) ? $_GET['count'] : 1;
    $value = isset($form_data['value']) ? $form_data['value'] : $value;
    $form[$id . '-value'] = array(
        '#type' => 'textfield',
        '#id' => $id . '-value',
        '#name' => $parent_name . '[options][' . $id . '][value]',
        '#value' => $value,
        '#inline' => true,
        '#attributes' => array(
            'style' => 'width:80px;',
            'class' => 'wpcf-compare-unique-value',
        ),
    );
    $form[$id . '-default'] = array(
        '#type' => 'radio',
        '#id' => $id . '-default',
        '#inline' => true,
        '#title' => __('Default', 'wpcf'),
        '#after' => '</div>',
        '#name' => $parent_name . '[options][default]',
        '#value' => $id,
        '#default_value' => isset($form_data['default']) ? $form_data['default'] : '',
    );
    return $form;
}

/**
 * Returns form data for radio.
 * 
 * @param type $parent_name Used for AJAX adding options
 * @param type $form_data
 * @return type 
 */
function wpcf_fields_radio_get_option_alt_text($id, $parent_name = '',
        $form_data = array()) {
    $form = array();
    $title = isset($_GET['count']) ? __('Option title', 'wpcf') . ' ' . $_GET['count'] : __('Option title',
                    'wpcf') . ' 1';
    $title = isset($form_data['title']) ? $form_data['title'] : $title;
    $value = isset($_GET['count']) ? $_GET['count'] : 1;
    $value = isset($form_data['value']) ? $form_data['value'] : $value;
    $value = isset($form_data['display_value']) ? $form_data['display_value'] : $value;
    $form[$id . '-display-value'] = array(
        '#type' => 'textfield',
        '#id' => $id . '-title-display-value',
        '#name' => $parent_name . '[options][' . $id . '][display_value]',
        '#title' => $title,
        '#value' => $value,
        '#inline' => true,
        '#before' => '<div id="' . $id . '-title-display-value-wrapper">',
        '#after' => '</div>',
    );
    return $form;
}