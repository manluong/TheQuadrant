<?php
/**
 * Cosmos class.
 * 
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
class Cosmos {

	/**
	 * Load classes that store in /framework/* directory
	 *
	 * @param string $class The class name to initialize.
	 * @param string $module optional Load the class in /framework/modules/* directory.
	 * @return bool Whether or not the given class has been defined.
	 */
	public static function load_class( $class , $module = null ) {
		if( preg_match( '/^(?P<module>\w+)\.(?P<class>\w+)$/', $class, $matches ) ) {
			$class   = $matches['class'];
			$module  = $matches['module'];
		}

		if( !class_exists( $class ) ) {
			$path = COSMOS_THEME_DIR . '/framework/';
			$class_file = 'class-' . str_replace( '_', '-', strtolower( $class ) ) . '.php';

			if( ! empty( $module ) ) {
				$path .= "/modules/{$module}/";
			} else {
				$path .= '/includes/';
			}

			if( file_exists( $path . $class_file ) ) {
				require_once $path . $class_file;
			}
		}

		return class_exists( 'Cosmos_' . $class );
	}

	/**
	 * Creates a new class instance.
	 *
	 * @param string $class The class name.
	 * @param array $attr optional attributes assigned to the object after initialization.
	 * @return object.
	 */
	public static function new_object( $class, $attr = array() ) {
		static $o = array();

		$module  = NULL;
		if( preg_match( '/^(?P<module>\w+)\.(?P<class>\w+)$/', $class, $matches ) ) {
			$class   = $matches['class'];
			$module  = $matches['module'];
		}

		if( empty( $o[ $class ] ) ) {
			if ( self::load_class( $class, $module ) ) {
				$class_name = 'Cosmos_' . $class;
				$o[ $class ] = new $class_name();

				if( ! empty($attr) ) {
					foreach( $attr as $key => $val ) {
						$o[ $class ]->{$key}	= $val;
					}
				}

			} else {
				exit( 'Can\'t not load class '.$class );
			}
		}

		return $o[ $class ];
	}

	/**
	 * Overwrite.
	 */
	public static function __callStatic( $name, $args ) {
		if( preg_match( '/^\[(?P<class>[a-zA-Z0-9\_\.]+)\,\ *(?P<method>\w+)\]$/', $name, $match ) ) {
			if( ! empty( $match[ 'class' ] ) && ! empty( $match[ 'method' ] ) ) {
				if( self::load_class ( $match[ 'class' ] ) ) {
					$obj = self::new_object( $match[ 'class' ] );
					return call_user_func_array( array( $obj, $match['method'] ), $args );
				}
			}
		}
	}

	/**
	 * Retrieve value from $_GET/$_POST.
	 *
	 * @param string $name Key.
	 * @param mixed $default_value The default value to return if no result is found.
	 * @return mixed.
	 */
	public static function get_request_param( $name, $default_value = null ) {
		return isset( $_GET[ $name ] ) ? $_GET[ $name ] : ( isset( $_POST[ $name ] ) ? $_POST[ $name ] : $default_value );
	}

	/**
	 * Create unique id
	 * @return string
	 */
	public static function make_id() {
		return uniqid(rand());
	}
	public static function is_empty( $value, $trim = false ) {
		return $value===null || $value===array() || $value==='' || $trim && is_scalar($value) && trim($value)==='';
	}
	public static function get_value( $obj, $field, $def = '' ) {
		if( isset( $obj[ $field ] ) && ! self::is_empty( $obj[ $field ] )) {
			return $obj[ $field ];
		}
		return $def;
	}
	public static function set_meta_defaults( $defaults, $args ) {
		if( ! $args ) {
			$args = array();
		}
		$args = (array)$args;
		$out = array();
		foreach( $defaults as $name => $default) {
			if ( array_key_exists($name, $args) )
				$out[$name] = $args[$name];
			else
				$out[$name] = $default;
		}
	
		return $out;
	}
	/**
	 * Get param from theme options.
	 * 
	 * @param string $name
	 * @param string $field         Optional.
	 * @return string
	 */
	public static function get_option( $name, $field = null ) {
		global $cosmos_options;
		$theme_options = get_option('cosmos_options');
		if( empty($theme_options)){
			$default_options = Cosmos_Config::get_theme_options_init();
			if( isset($default_options[$name]) ) {
				if( $field ) {
					return ( isset( $default_options[$name][$field] ) ) ? $default_options[$name][$field] : '';
				}
				return $default_options[$name];
			}
		}
	
		if( $field ) {
			return ( isset( $cosmos_options[$name][$field] ) ) ? $cosmos_options[$name][$field] : '';
		}
		if( isset ($cosmos_options[$name] ) ) {
			return $cosmos_options[$name];
		}
		return '';
	}
	/**
	 * Set value to param of theme options
	 * 
	 * @param string $value    Value to set theme option param.
	 * @param string $name     Theme option param 1.
	 * @param string $field    Optional. Theme option param 2
	 */
	public static function set_option( $value, $name, $field = null ) {
		global $cosmos_options;
	
		if( $field ) {
			$cosmos_options[$name][$field] = $value;
		} else {
			$cosmos_options[$name] = $value;
		}
	}
}