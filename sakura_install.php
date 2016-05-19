<?php
/**
 * Implements hook_enable();
 */
function sakura_copy_number_enable() {

  field_cache_clear();
  field_associate_fields('sakura_copy_number');

  if (!field_info_field('available_copies_numbers')) {
    $field = array(
      'field_name' => 'available_copies_numbers',
      'type' => 'available_copies_numbers',
    );
    $field = field_create_field($field);

    $instance['available_copies_numbers'] = array(
      'field_name' => $field['field_name'],
      'entity_type' => 'commerce_product',
      'bundle' => 'art',
      'label' => t('Available copies number'),
      'description' => t('A field to store the available copies numbers and select them'),
      'required' => TRUE,
    );

    drupal_set_message('The field '.$field['field_name'].' was created.');
  }

  if (!field_info_field('reserved_copies_numbers')) {
    $field = array(
      'field_name' => 'reserved_copies_numbers',
      'type' => 'reserved_copies_numbers',
    );
    $field = field_create_field($field);

    $instance['reserved_copies_numbers'] = array(
      'field_name' => $field['field_name'],
      'entity_type' => 'commerce_line_item',
      'bundle' => 'product',
      'label' => t('Reserved copies number'),
      'description' => t('A field to store the reserved copies numbers and select them'),
      'required' => TRUE,
    );

    drupal_set_message('The field '.$field['field_name'].' was created.');
  }

  if(!empty($instance)){
    foreach ($instance as $instance_field){
      field_create_instance($instance_field);
    }
  }
}

/**
 * Implements hook_field_schema().
 */
function sakura_copy_number_field_schema($field) {

  $schema = array();

  switch($field['type']) {

    case 'available_copies_numbers':
    
      $schema['columns'] = array(
        'total_copies' => array(
          'description' => 'Used to store the total number of available copies',
          'type' => 'int',
          'size' => 'small',
          'not null' => TRUE,
          'default' => 1
        ),
        'artist_proof' => array(
          'description' => 'Is this an artist proof',
          'type' => 'int',
          'size' => 'tiny',
          'not null' => TRUE,
          'default' => 0
        ),
        'value' => array(
          'description' => 'The string containing the available copy numbers',
          'type' => 'text',
        ),
      );

      break;

    case 'reserved_copies_numbers':

      $schema['columns']['value'] = array(
        'description' => 'The string containing the reserved numbers',
        'type' => 'text',
      );

      break;

  }

  return $schema;

}