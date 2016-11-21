<?php

/**
 * Include common functions used through out theme.
 */
include_once dirname(__FILE__) . '/theme/common.inc';
/**
 * Override or insert variables into the page template for HTML output.
 * 
 * For taxonomy page, insert vocabulary id class.
 * Define the variable to activate responsive behaivor.
 */
function concise_drupal_preprocess_html(&$variables) {
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
function concise_drupal_html_head_alter(&$head_elements) {
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
function concise_drupal_preprocess_page(&$variables) {
  $variables['content_width'] = _concise_drupal_content_width();
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
function _concise_drupal_content_width() {
  $sidebar_first_width = (_concise_drupal_block_list('sidebar_first')) ? theme_get_setting('sidebar_first_width') : 0;
  $sidebar_second_width = (_concise_drupal_block_list('sidebar_second')) ? theme_get_setting('sidebar_second_width') : 0;
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
function _concise_drupal_block_list($region) {
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

/**
 * Declare various hook_*_alter() hooks.
 *
 * hook_*_alter() implementations must live (via include) inside this file so
 * they are properly detected when drupal_alter() is invoked.
 */
concise_include('concise_drupal', 'theme/alter.inc');
