<?php
/*
Plugin Name: Booli Search
Plugin URI: http://emilkaiser.se/booli-search-wp
Description: Displays search results from swedish real estate search engine Booli.se
Version: 1.0
Author: Emil Kaiser
Author URI: http://emilkaiser.com
Author Email: emilkaiser@gmail.com
Text Domain: booli-search
Domain Path: /lang/
Network: false
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2013 Emil Kaiser (emilkaiser@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Booli_Search extends WP_Widget {

	public function __construct() {

		// load plugin text domain
		add_action('init', array($this, 'widget_textdomain' ));

		parent::__construct(
			'booli-search',
			__('Booli Search', 'booli-search'),
			array(
				'description' => __('Displays search results from swedish real estate search engine Booli.se.', 'booli-search')
			)
		);
	}

	public function widget($args, $instance) {

		echo $args['before_widget'];

		$q = apply_filters('query', $instance['q']);
		if (empty($q)) {
			echo $args['before_title'] . __('Booli Search', 'booli-search') . $args['after_title'];
		} else {
			echo $args['before_title'] . __('Booli Search', 'booli-search') . ' - ' . $q . $args['after_title'];
		}

		$result = get_transient("booli_search_" . $q);
		if (empty($result)) {
			if (empty($q)) {
				$result = $this->request($instance['callerId'], $instance['key'], array('q' => $q, 'limit' => $instance['limit']));
			} else {
				$result = $this->request($instance['callerId'], $instance['key'], array('areaId' => 77104, 'limit' => $instance['limit']));
			}
			set_transient("booli_search_" . $q, $result, 1 * HOUR_IN_SECONDS);
		}

		include(plugin_dir_path( __FILE__ ) . '/views/widget.php');

		echo $args['after_widget'];
	}

	public function update($new_instance, $old_instance) {

		$instance = $old_instance;
		delete_transient("booli_search_" . $instance['q']);

		$instance['q'] = (!empty($new_instance['q'])) ? strip_tags($new_instance['q']) : '';
		$instance['callerId'] = (!empty($new_instance['callerId'])) ? strip_tags($new_instance['callerId']) : '';
		$instance['key'] = (!empty($new_instance['key'])) ? strip_tags($new_instance['key']) : '';
		$instance['limit'] = (!empty($new_instance['limit'])) ? strip_tags($new_instance['limit']) : '';

		return $instance;
	}

	public function form($instance) {

		$instance = wp_parse_args((array) $instance, array('limit' => 5));
		include( plugin_dir_path(__FILE__) . '/views/admin.php' );
	}

	public function widget_textdomain() {

		load_plugin_textdomain('booli-search', false, dirname(plugin_basename(__FILE__)) . '/lang/');
	}

	private function request($callerId, $key, $params = array()) {

		$auth = array();
		$auth['callerId'] = $callerId;
		$auth['time'] = time();
		$auth['unique'] = rand(0, PHP_INT_MAX);
		$auth['hash'] = sha1($auth['callerId'] . $auth['time'] . $key . $auth['unique']);

		$queryParams = http_build_query(array_merge($params, $auth));
		$url = "http://api.booli.se/listings?$queryParams";

		$curl = curl_init($url);
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => true
		));
		$response = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		if ($httpCode != 200) {
			// fail
		}
		$result = json_decode($response);

		return $result;
	}
}

add_action('widgets_init', create_function('', 'register_widget("Booli_Search");'));
