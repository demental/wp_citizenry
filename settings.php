<?php
/* @see http://stackoverflow.com/questions/161738/what-is-the-best-regular-expression-to-check-if-a-string-is-a-valid-url
*/
define('URL_FORMAT',
'/^(https?):\/\/'.                                         // protocol
'(([a-z0-9$_\.\+!\*\'\(\),;\?&=-]|%[0-9a-f]{2})+'.         // username
'(:([a-z0-9$_\.\+!\*\'\(\),;\?&=-]|%[0-9a-f]{2})+)?'.      // password
'@)?(?#'.                                                  // auth requires @
')((([a-z0-9][a-z0-9-]*[a-z0-9]\.)*'.                      // domain segments AND
'[a-z][a-z0-9-]*[a-z0-9]'.                                 // top level domain  OR
'|((\d|[1-9]\d|1\d{2}|2[0-4][0-9]|25[0-5])\.){3}'.
'(\d|[1-9]\d|1\d{2}|2[0-4][0-9]|25[0-5])'.                 // IP address
')(:\d+)?'.                                                // port
')(((\/+([a-z0-9$_\.\+!\*\'\(\),;:@&=-]|%[0-9a-f]{2})*)*'. // path
'(\?([a-z0-9$_\.\+!\*\'\(\),;:@&=-]|%[0-9a-f]{2})*)'.      // query string
'?)?)?'.                                                   // path and query string optional
'(#([a-z0-9$_\.\+!\*\'\(\),;:@&=-]|%[0-9a-f]{2})*)?'.      // fragment
'$/i');

function citizenry_bridge_register_settings() {
  register_setting( 'citizenry_bridge', 'citizenry_bridge', 'citizenry_bridge_validate' );
  add_settings_section('citizenry_bridge_main', __('Main Settings'), 'citizenry_bridge_text', 'citizenry_bridge');
  add_settings_field('url', __('Url of the directory', 'citizenry_bridge'), 'citizenry_bridge_url_string', 'citizenry_bridge', 'citizenry_bridge_main');

}

function citizenry_bridge_create_menu() {

	//create new top-level menu
	add_menu_page('Citizenry Bridge Settings', 'Citizenry', 'administrator', __FILE__, 'citizenry_bridge_settings_page',plugins_url('/images/icon.png', __FILE__));
}

if ( is_admin() ){ // admin actions
  add_action( 'admin_init', 'citizenry_bridge_register_settings' );
  add_action( 'admin_menu', 'citizenry_bridge_create_menu');
} else {
  // non-admin enqueues, actions, and filters
}

function citizenry_bridge_validate($input) {
  $newinput['url'] = trim($input['url']);
  if(!preg_match(URL_FORMAT, $newinput['url'])) {
    $newinput['url'] = '';
  }
  return $newinput;
}

function citizenry_bridge_text() { return; }
function citizenry_bridge_url_string(){
  $options = get_option('citizenry_bridge');
  echo "<input id='citizenry_bridge_url' name='citizenry_bridge[url]' size='40' type='text' value='{$options['url']}' />";
}
function citizenry_bridge_settings_page() {
  ?>
<div class="wrap">
  <h2>Citizenry Bridge</h2>
  <form method="post" action="options.php">
    <?php settings_fields( 'citizenry_bridge' );?>
    <?php do_settings_sections( 'citizenry_bridge'); ?>
    <?php submit_button(); ?>
  </form>
</div>
<?php
}
