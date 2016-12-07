<?php
/**
 * @file
 * alter.inc
 *
 * Contains various implementations of hook_*_alter().
 */

/**
 * Implements hook_preprocess_block()
 */
 
function concise_drupal_preprocess_block(&$variables) {
  //_get_column_consice($variables['classes_array'], $variables);

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

function concise_drupal_css_alter(&$css) {
	// Remove Drupal core css
	 
	$exclude = array(
	'modules/aggregator/aggregator.css' => FALSE,
	'modules/block/block.css' => FALSE,
	'modules/book/book.css' => FALSE,
	'modules/comment/comment.css' => FALSE,
	'modules/dblog/dblog.css' => FALSE,
	'modules/field/theme/field.css' => FALSE,
	'modules/file/file.css' => FALSE,
	'modules/filter/filter.css' => FALSE,
	'modules/forum/forum.css' => FALSE,
	'modules/help/help.css' => FALSE,
	'modules/menu/menu.css' => FALSE,
	'modules/node/node.css' => FALSE,
	'modules/openid/openid.css' => FALSE,
	'modules/poll/poll.css' => FALSE,
	'modules/profile/profile.css' => FALSE,
	'modules/search/search.css' => FALSE,
	'modules/statistics/statistics.css' => FALSE,
	'modules/syslog/syslog.css' => FALSE,
	'modules/system/admin.css' => FALSE,
	'modules/system/maintenance.css' => FALSE,
	//'modules/system/system.css' => FALSE,
	//'modules/system/system.admin.css' => FALSE,
	//'modules/system/system.base.css' => FALSE,
	//'modules/system/system.maintenance.css' => FALSE,
	//'modules/system/system.messages.css' => FALSE,
	'modules/system/system.menus.css' => FALSE,
	//'modules/system/system.theme.css' => FALSE,
	'modules/taxonomy/taxonomy.css' => FALSE,
	'modules/tracker/tracker.css' => FALSE,
	'modules/update/update.css' => FALSE,
	'modules/user/user.css' => FALSE,
	//'misc/vertical-tabs.css' => FALSE,
	 
	// Remove contrib module CSS
	drupal_get_path('module', 'views') . '/css/views.css' => FALSE, );
	$css = array_diff_key($css, $exclude);
 
}