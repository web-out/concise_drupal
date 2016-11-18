<?php
/**
 * @file
 * template.php
 */

/**
 * Override or insert variables into the page template for HTML output.
 * 
 * For taxonomy page, insert vocabulary id class.
 * Define the variable to activate responsive behaivor.
 */
function jeet_drupal_preprocess_html(&$variables) {
  //dpm($variables['skinr']);
  if (arg(0) == 'taxonomy') {
    $tid = arg(2);
    $taxonomy = taxonomy_term_load($tid);
    $variables['classes_array'][] = 'vid-' . $taxonomy->vid;
  }
  if (theme_get_setting('is_one') && drupal_is_front_page()) {
    $variables['classes_array'][] = 'one-page';
  }
  if (theme_get_setting('toggle_responsive')) {
    $variables['mobile_friendly'] = TRUE;
  }
  else {
    $variables['mobile_friendly'] = FALSE;
  //  drupal_add_css(drupal_get_path('theme', 'jeet_drupal') . '/css/no-responsive.css', array('group' => CSS_DEFAULT, 'every_page' => TRUE));
  }
  
  $viewport = array(
      '#tag' => 'meta',
      '#attributes' => array(
        'name' => 'viewport',
        'content' => 'width=device-width, initial-scale=1, maximum-scale=1',
      ),
    );
  drupal_add_html_head($viewport, 'viewport');
    /* set title home*/
   if (drupal_is_front_page()) {
    $variables['head_title'] = theme_get_setting('home_title');
   }
}
/**
* Implements theme_html_head_alter().
* Removes the Generator tag from the head for Drupal 7
*/
function jeet_drupal_html_head_alter(&$head_elements) {
  /*D7 - Remove Meta Tag Generator*/
  if (module_exists('metatag')) {
    unset($head_elements['metatag_generator_0']);
  }
  else {
    unset($head_elements['system_meta_generator']);
  }
  /* end D7 - Remove Meta Tag Generator*/
}
/**
 * Override or insert variables into the page template for page output.
 *
 * Sets the widths of the main columns of the page.
 */
function jeet_drupal_preprocess_page(&$variables) {
  $variables['content_width'] = _jeet_drupal_content_width();
  $variables['sidebar_first_width'] = theme_get_setting('sidebar_first_width');
  $variables['sidebar_second_width'] = theme_get_setting('sidebar_second_width');
  _preprocess_menu($variables);


  if (theme_get_setting('is_one') && drupal_is_front_page()) {
    $variables['theme_hook_suggestions'][] = 'page__one';
  }
  if (theme_get_setting('collapse')) {
    $variables['collapse'] = 'collapse navbar-collapse';
  }
  else {
    $variables['collapse'] = 'not-collapse';
  }
 if (!theme_get_setting('print_content') && drupal_is_front_page()) {
    $variables['print_content'] = FALSE;
     if (module_exists('metatag')) {
      $variables['pagemetatag'] = metatag_metatags_view('global:frontpage');
    }
    else {
      $variables['pagemetatag'] = array();
    }
 }
  else {
    $variables['print_content'] = TRUE;
  }
}

/**
 * Returns with of content region.
 *
 * Calculates content width based on first and second column width parameters.
 */
function _jeet_drupal_content_width() {
  $sidebar_first_width = (_jeet_drupal_block_list('sidebar_first')) ? theme_get_setting('sidebar_first_width') : 0;
  $sidebar_second_width = (_jeet_drupal_block_list('sidebar_second')) ? theme_get_setting('sidebar_second_width') : 0;
  $content_width = 12 - $sidebar_first_width - $sidebar_second_width;
  $content_width = $content_width;
  return $content_width;
}

/**
 * Returns a list of blocks.
 *
 * Uses Drupal block interface and appends any blocks 
 * assigned by the Context module.
 * Taken from Fusion Core.
 */
function _jeet_drupal_block_list($region) {
  $drupal_list = array();
  if (module_exists('block')) {
    $drupal_list = block_list($region);
  }
  if (module_exists('context') && $context = context_get_plugin('reaction', 'block')) {
    $context_list = $context->block_list($region);
    $drupal_list = array_merge($context_list, $drupal_list);
  }
  return $drupal_list;
}

/**
 * Implements hook_element_info_alter().
 */
function jeet_drupal_element_info_alter(&$elements) {
    // Element mail of module webform
    if (module_exists('webform')) {
        if (!empty($elements["webform_email"])) {
              $elements["webform_email"]['#process'][] = '_jeet_drupal_process_input';
        }
    }
}
/**
 * Add class form-control in fields
 */
function _jeet_drupal_process_input(&$element, &$form_state) {
  // Only add the "form-control" class for specific element input types.
  $types = array(
    // Elements module.
    'webform_email',
  );
  if (!empty($element['#type']) && (in_array($element['#type'], $types) || ($element['#type'] === 'file' && empty($element['#managed_file'])))) {
    $element['#attributes']['class'][] = 'form-control';
  }
  return $element;
}



function _preprocess_menu(&$variables) {
  // Primary nav.
  $variables['primary_nav'] = FALSE;
  if ($variables['main_menu']) {
    // Build links.
    $variables['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
    // Provide default theme wrapper function.
    $variables['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
  }
 // Secondary nav.
  $variables['secondary_nav'] = FALSE;
  if ($variables['secondary_menu']) {
    // Build links.
    $variables['secondary_nav'] = menu_tree(variable_get('menu_secondary_links_source', 'user-menu'));
    // Provide default theme wrapper function.
    $variables['secondary_nav']['#theme_wrappers'] = array('menu_tree__secondary');
  }
}

function jeet_drupal_skinr_elements($variables, $hook, $op) {

 // dpm($variables);
  //dpm($hook);
 // dpm($op);
  //$elements = array();
  /*if ($hook == 'block') {
    $elements['block'] = array($variables['block']->module . '__' . $variables['block']->delta);
  }
  return $elements;*/
}

function jeet_drupal_skinr_preprocess_alter(&$skins, $context) {
  /*dpm($skins);
 // $context['variables']['column'] = "";
  dpm($context);

  
    foreach ($skins as $key => $skin) {
      if ($skin->module == 'block') {
          if($skin->skin == "jeet_drupal_col-sm") {
            $option_temp = $skin->options[0];
            $context['variables']['column'] = $option_temp;
          }
      }
    }
  $skin_info = skinr_get_skin_info();

  dpm($skin_info);*/
}


function jeet_drupal_preprocess_skinr(&$variables, $hook) {
  dpm($variables);
  dpm($hook);
}

//http://api.drupalhelp.net/api/skinr/skinr.module/function/skinr_preprocess/7.2
// http://www.rit.edu/drupal/api/drupal/sites%21all%21modules%21skinr%21skinr.api.php/function/hook_skinr_preprocess_alter/7.43
/*
function yourtheme_preprocess_block(&$variables) {
  if (in_array($variables['elements']['#id'], array('mymodule_my_block'))) {
    $variables['attributes']['class'][] = 'my-nice-block';
  }
}
*/

/**
 * Implements hook_preprocess_block()
 */
 
function jeet_drupal_preprocess_block(&$variables) {

    //dpm($variables);
  
  // Add support for Skinr module classes http://drupal.org/project/skinr.
  _get_column_consice($variables['classes_array'], $variables);

}


function _get_column_consice($data, &$variables) {

  //dpm($variables);
  $column_data = "";
  $column_data_1 = "";
  $findme   = 'column-';
  $findme_1   = 'offset-';
  $findme_2   = '--';
  $num_column = array();
  foreach ($data as $key => $value) {
  //dpm($value);
    $pos = strpos($value, $findme);
    $pos_1 = strpos($value, $findme_1);
    $pos_2 = strpos($value, $findme_2);
    //dpm($pos_1);
     if($pos !== false) {
          $num_column = explode("-", $value);
          if(isset($num_column[1]) && is_numeric($num_column[1])) {
            $column_data_1 = $num_column[1];
          }
          unset($variables['classes_array'][$key]);
       }
      if($pos_1 !== false) {
        $num_column_1 = explode("-", $value);
          if(isset($num_column_1[1]) && is_numeric($num_column_1[1])) {
           // dpm($variables);
            $column_data .= " +".$num_column_1[1];
          }
          unset($variables['classes_array'][$key]);
     }
     if($pos_2 !== false) {
        $text_class = explode("--", $value);
          if(isset($text_class[1])) {
             $variables['classes_array'][$key] = "_".$text_class[1];
          }
        
         // unset($variables['classes_array'][$key]);
     }
  }

  $variables['column'] = $column_data_1.$column_data;


  //return isset($num_column[1]) ? $num_column[1] : '';
}