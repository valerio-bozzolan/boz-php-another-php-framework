<?php
# Copyright (C) 2015, 2016, 2017, 2018, 2019 Valerio Bozzolan
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.


/*
 * Configuration helpers
 *
 * Shortcuts useful when you declare a configuration file.
 */


/**
 * Define a constant if it does not exist
 *
 * @param string $name  Constant name
 * @param string $value Constant value
 */
function define_default( $name, $value ) {
	defined( $name ) or define( $name, $value );
}


/*
 * Template helpers
 *
 * Shortcuts useful when you build a page
 */


/**
 * Print a ' checked="checked"' HTML attribute under some circumstances
 *
 * This is useful for the <input type="checkbox" /> HTML tag.
 *
 * @param mixed $helper  If this is the only arg, prints
 * @param mixed $current If this matches $helper, print
 * @param bool  $force   If this is true, print
 */
function _checked( $helper = PHP_INT_MAX, $current = PHP_INT_MAX, $force = false ) {
	echo checked( $helper, $current, $force );
}

/**
 * Print a ' selected="selected"' HTML attribute under some circumstances
 *
 * This is useful for the <option> HTML tag.
 *
 * @param mixed $helper  If this is the only arg, prints
 * @param mixed $current If this matches $helper, print
 * @param bool  $force   If this is true, print
 */
function _selected( $helper = PHP_INT_MAX, $current = PHP_INT_MAX, $force = false ) {
	echo selected( $helper, $current, $force );
}

/**
 * Print a ' disabled="disabled"' HTML attribute under some circumstances
 *
 * @param mixed $helper  If this is the only arg, prints
 * @param mixed $current If this matches $helper, print
 * @param bool  $force   If this is true, print
 */
function _disabled( $helper = PHP_INT_MAX, $current = PHP_INT_MAX, $force = false ) {
	echo disabled( $helper, $current, $force );
}

/**
 * Return a ' selected="selected"' HTML attribute under some circumstances
 *
 * @param mixed $helper  If this is the only arg, return
 * @param mixed $current If this matches $helper, return
 * @param bool  $force   If this is true, return
 */
function selected( $helper = PHP_INT_MAX, $current = PHP_INT_MAX, $force = false ) {
	return html_attribute_when_matching( 'selected', 'selected', $helper, $current, $force);
}

/**
 * Return a ' checked="checked"' HTML attribute under some circumstances
 *
 * This is useful for the <input type="checkbox" /> HTML tag.
 *
 * @param mixed $helper  If this is the only arg, return
 * @param mixed $current If this matches $helper, return
 * @param bool  $force   If this is true, return
 */
function checked( $helper = PHP_INT_MAX, $current = PHP_INT_MAX, $force = false ) {
	return html_attribute_when_matching( 'checked', 'checked', $helper, $current, $force);
}

/**
 * Return a ' disabled="disabled"' HTML attribute under some circumstances
 *
 * @param mixed $helper  If this is the only arg, return
 * @param mixed $current If this matches $helper, return
 * @param bool  $force   If this is true, return
 */
function disabled( $helper = PHP_INT_MAX, $current = PHP_INT_MAX, $force = false ) {
	return html_attribute_when_matching( 'disabled', 'disabled', $helper, $current, $force );
}

/**
 * Return an HTML attribute under some circumstances
 *
 * @param string $attribute HTML attribute name e.g. 'disabled'
 * @param string $value     HTML attribute value e.g.
 * @param mixed  $helper    If this is the only arg, return
 * @param mixed  $current   If this matches $helper, return
 * @param bool   $force     If this is true, return
 */
function html_attribute_when_matching( $attribute, $value, $helper = PHP_INT_MAX, $current = PHP_INT_MAX, $force = false ) {
	if( $helper === $current || $helper && PHP_INT_MAX === $current || $force ) {
		return HTML::property( $attribute, $value );
	}
	return '';
}

/**
 * Print the HTML attribute ' value="$v"'
 *
 * The value will be sanitized.
 *
 * @param string $v
 */
function _value( $v ) {
	echo HTML::property( 'value', $v );
}

/**
 * Shortcut for htmlentities()
 *
 * Return an HTML-sanitized untrusted string to be safe from XSS.
 *
 * @param  string $s e.g. 'Hello<script>...'
 * @return string e.g. 'Hello&lt;script&gt;...'
 */
function esc_html( $s ) {
	return htmlentities( $s );
}

/**
 * Shortcut for echoing htmlentities()
 *
 * Print an HTML-sanitized untrusted string to be safe from XSS
 *
 * @param  string $s e.g. 'Hello<script>...'
 * @return string e.g. 'Hello&lt;script&gt;...'
 */
function _esc_html( $s ) {
	echo htmlentities( $s );
}

/**
 * Enfatize a sub-string
 *
 * This is helpful when highlighting search results
 *
 * @param  string $heystack e.g. 'The quick brown fox'
 * @param  string $needle   e.g. 'quick'
 * @param  string $pre      HTML markup put before the found $needle
 * @param  string $post     HTML markup put after fhe found $needle
 * @return string e.g. 'The <b>quick</b> brown fox'
 */
function enfatize_substr( $heystack, $needle, $pre = '<b>', $post = '</b>' ) {
	return OutputUtilities::enfatizeSubstr( $heystack, $needle, $pre, $post );
}


/*
 * Conversion shortcuts
 */


/**
 * Force a variable to be an array
 *
 * @return mixed|array $a
 */
function force_array( & $a ) {
	if( ! is_array( $a ) ) {
		$a = [ $a ];
	}
}


/*
 * Database shourtcuts
 */

/**
 * Sanitize an SQL value to be safe from SQL injections
 *
 * @param  string $s
 * @return string
 */
function esc_sql( $s ) {
	return DB::instance()->escapeString( $s );
}

/**
 * Sanitize an SQL value to be safe from SQL injections and escape also '%'
 *
 * @param  string $s
 * @return string
 */
function esc_sql_like( $s ) {
	$s = str_replace( '%', '\%', $s );
	return esc_sql( $s );
}

/**
 * Execute whatever query
 *
 * @param string $query SQL query
 * @see DB#query()
 * @return object
 */
function query( $query ) {
	return DB::instance()->query( $query );
}

/**
 * Execute a query and return an array of objects
 *
 * Note: Use query_generator() if you do not need the entire array.
 *
 * @param  string $query      SQL query
 * @param  string $class_name Class name to encapsulate the result set
 * @param  array  $args       Arguments to be passed to the constructor of $class_name
 * @return array
 */
function query_results( $query, $class_name = null, $args = [] ) {
	return DB::instance()->getResults( $query, $class_name, $args );
}

/**
 * Execute a query and return a generator
 *
 * Note: Use query_results() if you need the entire array.
 *
 * @param  string $query      SQL query
 * @param  string $class_name Class name to encapsulate the result set
 * @param  array  $args       Arguments to be passed to the constructor of $class_name
 * @return array
 */
function query_generator( $query, $class_name = null, $args = [] ) {
	return DB::instance()->getGenerator( $query, $class_name, $args );
}

/**
 * Execute a query and return a single row, as an object
 *
 * @param  string       $query SQL  query
 * @param  string       $class_name Class name to encapsulate the result set
 * @return object|null              Arguments to be passed to the constructor of $class_name
 */
function query_row( $query, $class_name = null, $args = [] ) {
	return DB::instance()->getRow( $query, $class_name, $args );
}

/**
 * Execute a query and return a single column from a single row
 *
 * @param string $query SQL query
 * @param string $field Field to be returned
 * @see DB#getValue()
 */
function query_value( $query, $field, $class_name = null ) {
	return DB::instance()->getValue( $query, $field, $class_name );
}

/**
 * Executes multiple queries concatenated by a semicolon
 *
 * @param string $queries SQL queries
 */
function multiquery( $queries ) {
	return DB::instance()->multiQuery( $queries );
}

/**
 * Get a database table name, full with its prefix, eventually aliased
 *
 * Note that the prefix is declared in your configuration file as $prefix.
 *
 * @param  string  $table Table name e.g. 'test'
 * @param  boolean        If true, eventually strip the prefix with an alias
 * @return string         Table name e.g. 'site01_test'
 */
function T( $table, $as = false ) {
	return DB::instance()->getTable( $table, $as );
}

/**
 * Insert a row in a database table
 *
 * @param string  $table  Table name
 * @param DBCol[] $cols   Array of DBCol objects (with column, value and type)
 * @param array   $args   Extra arguments for the query
 */
function insert_row( $table, $cols, $args = [] ) {
	return DB::instance()->insertRow( $table, $cols, $args );
}

/**
 * Get the last AUTOINCREMENT value created after an INSERT query
 *
 * @return int
 */
function last_inserted_ID() {
	if( ! DB::instanced() ) {
		error_die( 'cannot obtain last inserted ID without database connection' );
	}
	return DB::instance()->getLastInsertedID();
}

/**
 * Insert multiple rows in a database table
 *
 * @param string $table  Table name
 * @param array  $cols   Array of columns with their escape e.g. [ 'id' => 'd', 'name' => 's' ]
 * @param array  $values Array of rows e.g. [ [ 1, 'stallman' ], [ 2, 'torvalds' ]
 */
function insert_values( $table, $cols, $values ) {
	return DB::instance()->insert( $table, $cols, $values );
}

/**
 * Update rows in the specified database table
 *
 * @param string  $table Table name
 * @param DBCol[] $cols  Array of DBCol objects (with column, value and type)
 * @param string  $cond  SQL condition (after the WHERE part)
 * @see DB#update()
 */
function query_update( $table, $cols, $cond, $after = '' ) {
	DB::instance()->update( $table, $cols, $cond, $after );
}

/**
 * Shortcut for htmlspecialchars()
 *
 * Get a sanitized value for an HTML attribute value (in double quotes).
 *
 * @param string $s
 * @return string
 */
function esc_attr( $s ) {
	return htmlspecialchars( $s );
}

/**
 * Shortcut for echoing htmlspecialchars()
 *
 * Print a sanitized value for an HTML attribute value (in double quotes).
 *
 * @param string $s
 */
function _esc_attr( $s ) {
	echo htmlspecialchars( $s );
}

/**
 * Associate some MIME types to a category
 *
 * @param string $category  e.g. 'compressed'
 * @param string $mimetypes e.g. [ 'tgz' => 'application/x-tar', 'gzip' => 'application/x-bzip', ]
 */
function register_mimetypes( $category, $mimetypes ) {
	MimeTypes::instance()->registerMimetypes($category, $mimetypes);
}

/**
 * Get the MIME types of a category, or all the accepteds
 *
 * @param  string $category e.g. 'image'
 * @return string
 */
function get_mimetypes( $category = null ) {
	return MimeTypes::instance()->getMimetypes( $category );
}

/**
 * Register permissions to a role
 *
 * @param string       $role        User role
 * @param array|string $permissions Permissions
 */
function register_permissions($role, $permissions) {
	Permissions::instance()->registerPermissions($role, $permissions);
}

/**
 * Give some permissions to a role, inheriting from an old one
 *
 * @param string       $role_to     Role to give permissions
 * @param string       $role_from   Role from inheriting permissions
 * @param array|string $permissions Extra permissions to be add to $role_to
 */
function inherit_permissions( $role_to, $role_from, $permissions = [] ) {
	Permissions::instance()->inheritPermissions( $role_to, $role_from, $permissions );
}

/**
 * Register a JavaScript file to be enqueued later
 *
 * @param string $uid      Script name e.g. 'jquery'
 * @param string $url      Script URL e.g. '/javascript/jquery/jquery.min.js'
 * @param string $position Choose between 'header' or 'footer'
 */
function register_js( $uid, $url, $position = null ) {
	RegisterJS::instance()->register( $uid, $url, $position );
}

/**
 * Register an inline JavaScript script and attach to a registered script
 *
 * @param string $uid      Dependent script name e.g. 'jquery'
 * @param string $data     Script body e.g. '$(document).find()...'
 * @param string $position Choose between 'after' or 'before' related to $uid execution
 */
function register_js_inline( $uid, $data, $position = 'after' ) {
	RegisterJS::instance()->registerInline($uid, $data, $position);
}

/**
 * Register an inline JavaScript variable and attach to a registered script
 *
 * @param string $uid      Dependent script name e.g. 'my-map'
 * @param string $variable Variable declaration e.g. 'var coordinates'
 * @param mixed  $value    Variable content (can be an array, an object, etc.)
 * @param string $position Choose between 'after' or 'before' related to $uid execution
 */
function register_js_var( $uid, $variable, $value, $position = 'before' ) {
	$data = json_encode( $value, DEBUG ? JSON_PRETTY_PRINT : 0 );
	register_js_inline( $uid, "$variable = $data;", $position );
}

/**
 * Mark a registered script for usage
 *
 * @param string $uid      Dependent script name e.g. 'my-map'
 * @param string $position Choose between 'header' or 'footer'
 */
function enqueue_js( $uid, $position = null ) {
	return RegisterJS::instance()->enqueue( $uid, $position );
}

/**
 * Register a CSS stylesheet
 *
 * @param string $uid Stylesheet name e.g. 'materializecss'
 * @param string $url Stylesheet URL
 */
function register_css( $uid, $url ) {
	return RegisterCSS::instance()->register( $uid, $url );
}

/**
 * Mark a registered stylesheet for usage
 *
 * @param string $uid Stylesheet name e.g. 'materializecss'
 */
function enqueue_css( $uid ) {
	return RegisterCSS::instance()->enqueue( $uid );
}

/**
 * Register some menu entries
 *
 * @param MenuEntry[] $entries
 */
function add_menu_entries( $entries ) {
	Menu::instance()->add( $entries );
}

function menu_entry($uid) {
	return Menu::instance()->getMenuEntry($uid);
}
function get_children_menu_entries($uid) {
	return Menu::instance()->getChildrenMenuEntries($uid);
}
function register_module($uid) {
	return RegisterModule::instance()->register($uid);
}
function inject_in_module($uid, $callback) {
	return RegisterModule::instance()->injectFunction($uid, $callback);
}
function load_module($uid) {
	return RegisterModule::instance()->loadModule($uid);
}
function get_table_prefix() {
	return DB::instance()->getPrefix();
}
function register_option($name) {
	return DB::instance()->registerOption($name);
}
function get_option( $name, $default = '' ) {
	return Options::instance()->get( $name, $default );
}
function set_option( $name, $value, $autoload = true ) {
	return Options::instance()->set( $name, $value, $autoload );
}
function remove_option( $name ) {
	return Options::instance()->remove( $name );
}
/**
 * Get the current logged user.
 *
 * @param null|string $property Property name
 * @return mixed|Sessionuser Property, or entire Sessionuser object.
 */
function get_user( $property = null ) {
	$user = Session::instance()->getUser();
	if( null === $property ) {
		return $user;
	}
	return $user ? $user->get( $property ) : null;
}
/**
 * Try to login using $_POST['user_uid'] and $_POST['user_password'].
 *
 * @param int $status
 * @see Session::login()
 */
function login(& $status = null, $uid = null, $pwd = null) {
	return Session::instance()->login($status, $uid, $pwd);
}
function logout() {
	return Session::instance()->destroy();
}
function register_language($code, $aliases = [], $encode = null, $iso = null, $human = null) {
	return RegisterLanguage::instance()->registerLanguage($code, $aliases, $encode, $iso, $human);
}
function register_default_language($default) {
	return RegisterLanguage::instance()->setDefaultLanguage($default);
}
function find_language($lang) {
	return RegisterLanguage::instance()->getLanguage($lang);
}
function apply_language($lang = null) {
	return RegisterLanguage::instance()->applyLanguage($lang);
}
function latest_language() {
	return RegisterLanguage::instance()->getLatestLanguageApplied();
}
function all_languages() {
	return RegisterLanguage::instance()->getAll();
}
function get_num_queries() {
	if( DB::instanced() ) {
		return DB::instance()->queries;
	}
	return 0;
}
function is_logged() {
	return Session::instance()->isLogged();
}

/**
 * @param string $permission Permission uid
 * @param User|null $user Specified user
 * @return bool
 */
function has_permission( $permission, $user = null ) {
	return Permissions::instance()->userHasPermission( $permission, $user );
}

/**
 * Add a directory to a base URL or a pathname.
 * If the base URL it is not defined, a slash ('/') is appended to the URL.
 * The base URL could end with a slash ('/') or not.
 *
 * @param string $base Base URL with/without any slash at start
 * @param string $dir Directory without any slash
 * @return string URL / Pathname
*/
function append_dir( $base, $dir = '/' ) {
	$base = rtrim( $base, '/' );
	$dir  = ltrim( $dir, '/' );
	return $base . _ . $dir;
}

/**
 * Normalize a site page
 *
 * @param $page string Whatever, a full URL, a relative pathname e.g. 'page', an absolute one, etc.
 * @param $full_url boolean As default it try to avoid full URLs
 */
function site_page( $page, $full_url = false ) {
	$first = @$page[ 0 ];
	if( $first === '#' ) {
		return $page; // '#anchor'
	}
	if( $first === '/' ) {
		if( @$page[ 1 ] === '/' ) {
			return $page; // "//example.org"
		}
		return append_dir( $full_url ? BASE_URL : '', $page );
	} elseif( preg_match( '#^[a-z]+://#', $page ) === 1 ) {
		return $page; // "ftp://example.org"
	}
	return append_dir( $full_url ? URL : ROOT, $page );
}

function single_quotes($s) {
	return "'$s'";
}

function double_quotes($s) {
	return '"' . $s . '"';
}

function this_folder() {
	return dirname( $_SERVER['PHP_SELF'] );
}

/**
 * Truncate a string if it's over a specific length.
 * You can specify the end of the string if it's truncated.
 *
 * @param string %s Input string
 * @param int $max_length Max string length
 * @param string $blabla Optional. If string length is over $max_length, $blabla it's appended after $string
 * @deprecated Use mb_strimwidth
 */
function str_truncate($s, $max_length, $blabla = '', $encoding = null ) {
	if( ! $encoding ) {
		$encoding = mb_internal_encoding();
	}
	return mb_strimwidth($s, 0, $max_length, $blabla, $encoding);
}

/**
 * Choose the appropriate string.
 * '%' will be replaced with the input number.
 *
 * @param int $n Input number.
 * @param string $text_multi Text displayed if n > 1
 * @param string $text_one Text displayed if n == 1
 * @param string $text_no Text displayed if n < 1
 */
function multi_text($n, $text_multi, $text_one, $text_no = '') {
	if($n > 1) {
		return str_replace('%', $n, $text_multi);
	} elseif($n == 1) {
		return $text_one;
	}
	return $text_no;
}

/**
 * Simple HTTP redirects.
 */
function http_redirect($url, $http_response_code = 0) {
	header("Location: $url", true, $http_response_code);
	exit;
}

/**
 * Check if the request is under HTTPS
 */
function is_https() {
	return ! empty( $_SERVER['HTTPS'] );
}

/**
 * Get the protocol of the request
 * @see use PROTOCOL
 */
function URL_protocol() {
	return is_https() ? 'https://' : 'http://';
}

/**
 * Get the domain of the request
 * @see DOMAIN
 */
function URL_domain() {
	return isset( $_SERVER[ 'SERVER_NAME' ] )
	            ? $_SERVER[ 'SERVER_NAME' ]
	            : php_uname( 'n' );
}

/**
 * Get the explicit port of the request
 * @see PORT
 * @return string
 */
function URL_port() {
	if( isset( $_SERVER[ 'SERVER_PORT' ] ) ) {
		$p = $_SERVER[ 'SERVER_PORT' ];
		if( '80' !== $p && '443' !== $p ) {
			return ":$p";
		}
	}
	return '';
}

function URL_root() {
	$root = this_folder();
	if( $root === '/' ) {
		return '';
	}
	return $root;
}

/**
 * Get a secured version of a string
 */
function generate_slug($s, $max_length = -1, $glue = '-', & $truncated = false) {
	return OutputUtilities::slug($s, $max_length, $glue, $truncated);
}

function http_build_get_query( $url, $data ) {
	$data = http_build_query( $data );
	return $data ? "$url?$data" : $url;
}

/**
 * HTTP 503 headers
 */
function http_503() {
	OutputUtilities::header503();
}

/**
 * It scares the user with an error message (and dies).
 */
function error_die( $msg ) {
	OutputUtilities::WSOD( $msg );
}

/**
 * It logs an error message and eventually prints it when DEBUG
 *
 * @return void
 */
function error( $msg ) {
	OutputUtilities::error( $msg );
}

/**
 * Translates a string
 *
 * @param string $msgid String to be translated
 * @return string Translated string (or original)
 */
function __( $msgid, $domain = '' ) {
	// is native GNU GETTEXT implementation?
	static $native = null;
	if( null === $native ) {
		$native = RegisterLanguage::instance()->isNative();
	}

	// low-level GNU Gettext call
	if( $native ) {
		return _( $msgid );
	}

	// high-level GNU Gettext (simpler but slower)
	return MoLoader::instance()->getTranslator( $domain )->gettext( $msgid );
}

/**
 * Shortcut for echoing a translated string
 */
function _e( $s, $domain = '' ) {
	echo __( $s, $domain );
}

function http_json_header($charset = null) {
	if( !$charset ) {
		$charset = CHARSET;
	}
	header( "Content-Type: application/json; charset=$charset" );
}

/**
 * Unset the empty values in an array or an object as well recursively
 *
 * @param $data mixed
 * @return array
 */
function array_unset_empty( $data ) {
	$is_array = is_array( $data );
	if( $is_array || is_object( $data ) ) {
		foreach( $data as $k => $v ) {
			if( is_array( $v ) || is_object( $v ) ) {
				if( $is_array ) {
					$data  [ $k ] = array_unset_empty( $v );
				} else {
					$data->{ $k } = array_unset_empty( $v );
				}
			} elseif( empty( $v ) && ! is_int( $v ) ) {
				if( $is_array ) {
					unset( $data  [ $k ] );
				} else {
					unset( $data->{ $k } );
				}
			}
   		}
	}
    return $data;
}

/**
 * Send a JSON (stripping out unuseful values) and quit
 *
 * Falsy elements are not returned
 *
 * @param $data mixed
 */
function json( $data, $flags = 0 ) {
	http_json_header();
	echo json_encode( array_unset_empty( $data ), $flags );
	exit;
}

/**
 * Send a JSON error and quit
 *
 * @param $http_code int HTTP response code
 * @param $code string Error code
 * @param $msg string Error human message
 */
function json_error( $http_code, $code, $msg = null, $flags = 0 ) {
	http_response_code( $http_code );
	json( [ 'error' => [
		'code'    => $code,
		'message' => $msg,
	] ], $flags );
}

/**
 * Get the MIME type of a file.
 * @see MimeTypes::fileMimetype()
 */
function get_mimetype($filepath, $pure = false) {
	return MimeTypes::fileMimetype( $filepath, $pure = false );
}

/**
 * Know if a file belongs to a certain category
 * @see MimeTypes::isMimetypeInCategory()
 */
function is_file_in_category($filepath, $category) {
	$mime = get_mimetype($filepath);
	return MimeTypes::instance()->isMimetypeInCategory($mime , $category);
}

/**
 * Get the file extension
 */
function get_file_extension_from_expectations($filename, $category) {
	return MimeTypes::instance()->getFileExtensionFromExpectations($filename, $category);
}

function is_image($filepath) {
	return is_file_in_category($filepath, 'image');
}

function is_audio($filepath) {
	return is_file_in_category($filepath, 'audio');
}

function is_video($filepath) {
	return is_file_in_category($filepath, 'video');
}

function is_document($filepath) {
	return is_file_in_category($filepath, 'document');
}

function is_closure($t) {
	return is_object($t) && ($t instanceof Closure);
}

/**
 * Get the human filesize from bytes
 *
 * @param $filesize int bytes
 * @param $glue string
 * @return string
 */
function human_filesize( $filesize, $glue = ' ' ) {
	return OutputUtilities::humanFilesize( $filesize, $glue );
}

/*
 * Create a directory
 *
 * @param $path string
 * @param $chmod string
 */
function create_path( $path, $chmod = null ) {
	return FileUploader::createPath( $path, $chmod );
}

/**
 * @see FileUploader::searchFreeFilename()
 */
function search_free_filename( $filepath, $filename, $ext, $args, $build_filename = null ) {
	return FileUploader::searchFreeFilename( $filepath, $filename, $ext, $args, $build_filename );
}

/**
 * I use this to clean user input before DB#insert()
 *
 * @param string $s Input string
 * @param int $max Max length
 */
function luser_input($s, $max) {
	return mb_strimwidth( trim($s), 0, $max, '');
}

/**
 * Used to know much is the page load
 *
 * @return mixed Execution time
 */
function get_page_load( $decimals = 6 ) {
	return round( microtime( true ) - $_SERVER[ 'REQUEST_TIME_FLOAT' ], $decimals );
}

// shortcuts to build SELECT * query
define('DOT',  '.');
define('STAR', '*');

/*
 * Deprecated zone
 *
 * @TODO remove the shit below this line
 */

define('T', 'T');

define('JOIN', 'JOIN');

// Stupid shurtcut for string context
$GLOBALS[T] = function($t, $as = false) {
	return T($t, $as = false);
};

// Stupid shortcut for string context for listing tables
$GLOBALS[JOIN] = function($t) {
	return DB::instance()->getTables( func_get_args() );
};

function get_menu_entry( $uid ) {
	error( "deprecated get_menu_entry()" );
	return menu_entry( $uid );
}