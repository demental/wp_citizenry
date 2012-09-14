<?php
/*
Plugin Name: Citizenry Bridge
Plugin URI: http://github.com/demental/wp_citizenry
Description: Various wigets and shortcodes consuming the citizenry API
Version: 0.1
Author: Arnaud Sellenet
Author URI: http://github.com/demental
License: GPL2
Copyright 2012  Arnaud Sellenet  (email : arnodmental@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA*/

include plugin_dir_path(__FILE__).'/settings.php';
include plugin_dir_path(__FILE__).'./widget.php';

function citizenry_fetch($service) {
  $options = get_option('citizenry_bridge');
  $data = file_get_contents($options['url'].'/api/'.$service.'.json');
  $result = json_decode($data, true);
  if(count($result)==1) {
    return array_pop($result);
  } else {
    return $result;
  }
}
