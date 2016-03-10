<?php 
/**
 * Connection
 * Realization of singleton pattern.
 * 
 * @package    Database
 * @author     Taras Kostiuk <tarik817@gmail.com>
 */
class Connection
{
	private static $engine;
  private static $host;
  private static $database;
  private static $user;
  private static $pass;
  private static $dns;
	private static $link = null;
	/**
   * Get PDO object.
   * 
   * @package    Database
   * @return     object
   */
  private static function getLink ( ) {
    if ( self :: $link ) {
        return self :: $link ;
    }
    $ini = "config.ini" ;
		$parse = parse_ini_file ( $ini ) ;
		self :: $engine = $parse['engine']; 
    self :: $host = $parse['host']; 
    self :: $database = $parse['database']; 
    self :: $user = $parse['user']; 
    self :: $pass = $parse['pass']; 
    self :: $dns = self :: $engine.':dbname='.self :: $database.";host=".self :: $host; 
    self :: $link = new PDO( self :: $dns, self :: $user, self :: $pass ); ;
    return self :: $link ;
  }
  /**
   * Run callback on static call.
   * 
   * @return function
   */
  public static function __callStatic ( $name, $args ) {
    $callback = array ( self :: getLink ( ), $name ) ;
    return call_user_func_array ( $callback , $args ) ;
  }
}