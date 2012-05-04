<?php
/**
 * @package Dioscouri
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

defined('_JEXEC') or die;

class DSC extends JObject 
{
	static $_version 		= '1.0';
	static $_build          = 'r100';
	static $_versiontype    = 'community';
	static $_copyrightyear 	= '2011';
	static $_name 			= 'dsc';
	static $_min_php		= '5.2';
	
	/**
	* Get the version
	*/
	public static function getVersion()
	{
		$version = self::$_version;
		return $version;
	}
	
	/**
	 * Get the full version string
	 */
	public static function getFullVersion()
	{
		$version = self::$_version." ".JText::_( ucfirst(self::$_versiontype) )." ".self::$_build;
		return $version;
	}

	/**
	* Get the copyright year
	*/
	public static function getBuild()
	{
		return self::$_build;
	}
	
	/**
	 * Get the copyright year
	 */
	public static function getCopyrightYear()
	{
		return self::$_copyrightyear;
	}
	
	/**
	 * Get the Name
	 */
	public static function getName()
	{
		return self::$_name;
	}
	
	/**
	 * Get the Minimum Version of Php
	 */
	public static function getMinPhp()
	{
		//get version from PHP. Note this should be in format 'x.x.x' but on some systems will look like this: eg. 'x.x.x-unbuntu5.2'
		$phpV = self::getServerPhp();
		$minV = self::$_min_php;
		$passes = false;
	
		if ($phpV[0] >= $minV[0]) {
			if (empty($minV[2]) || $minV[2] == '*') {
				$passes = true;
			} elseif ($phpV[2] >= $minV[2]) {
				if (empty($minV[4]) || $minV[4] == '*' || $phpV[4] >= $minV[4]) {
					$passes = true;
				}
			}
		}
		//if it doesn't pass raise a Joomla Notice
		if (!$passes) :
		JError::raiseNotice('VERSION_ERROR',sprintf(JText::_('ERROR_PHP_VERSION'),$minV,$phpV));
		endif;
	
		//return minimum PHP version
		return self::$_min_php;
	}
	
	public static function getServerPhp()
	{
		return PHP_VERSION;
	}
	
	public static function getApp( $app=null, $find=true )
	{
		if (empty($app) && empty($find))
		{
			return new DSC();
		}
		
		if (empty($app) && !empty($find)) 
		{
			$app = JRequest::getCmd('option');
		}
		
		if (strpos($app, 'com_') !== false) {
			$app = str_replace( 'com_', '', $app );
		}
		
		if ( !class_exists($app) ) {
			JLoader::register( $app, JPATH_ADMINISTRATOR.DS."components".DS."com_" . $app . DS ."defines.php" );
		}
		
		return $app::getInstance();
	}

	/**
	* Get the URL to the folder containing all media assets
	*
	* @param string	$type	The type of URL to return, default 'media'
	* @return 	string	URL
	*/
	public static function getURL( $type = 'media' )
	{
	    $url = '';
	
	    switch ( $type )
	    {
	        case 'media':
	            $url = JURI::root( true ) . '/media/dioscouri/';
	            break;
	        case 'css':
	            $url = JURI::root( true ) . '/media/dioscouri/css/';
	            break;
	        case 'images':
	            $url = JURI::root( true ) . '/media/dioscouri/images/';
	            break;
	        case 'js':
	            $url = JURI::root( true ) . '/media/dioscouri/js/';
	            break;
	    }
	
	    return $url;
	}
	
	/**
	 * Get the path to the folder containing all media assets
	 *
	 * @param 	string	$type	The type of path to return, default 'media'
	 * @return 	string	Path
	 */
	public static function getPath( $type = 'media' )
	{
	    $path = '';
	
	    switch ( $type )
	    {
	        case 'media':
	            $path = JPATH_SITE . '/media/dioscouri';
	            break;
	        case 'css':
	            $path = JPATH_SITE . '/media/dioscouri/css';
	            break;
	        case 'images':
	            $path = JPATH_SITE . '/media/dioscouri/images';
	            break;
	        case 'js':
	            $path = JPATH_SITE . '/media/dioscouri/js';
	            break;
	    }
	
	    return $path;
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public static function loadLibrary()
	{
		if (!class_exists('DSCLoader')) {
			jimport('joomla.filesystem.file');
			if (!JFile::exists(JPATH_SITE.'/libraries/dioscouri/loader.php')) {
				return false;
			}
			require_once JPATH_SITE.'/libraries/dioscouri/loader.php';
		}
		
		$parentPath = JPATH_SITE . '/libraries/dioscouri/library';
		DSCLoader::discover('DSC', $parentPath, true);
		
		$doc = JFactory::getDocument( );
		$uri = JURI::getInstance( );
		
		$js = "Dsc.jbase = '" . $uri->root( ) . "';\n";
		$doc->addScript( DSC::getURL('js') . 'common.js' );
		$doc->addScriptDeclaration( $js );
				
		return true;
	}

	/**
	 * Adds the Highcharts library files to the autoloader
	 * and adds the highcharts js file to the stack
	 * 
	 */
	public static function loadHighcharts()
	{
	    jimport('dioscouri.highroller.highroller.highroller');
	    jimport('dioscouri.highroller.highroller.highrollerareachart');
	    jimport('dioscouri.highroller.highroller.highrollerareasplinechart');
	    jimport('dioscouri.highroller.highroller.highrollerbarchart');
	    jimport('dioscouri.highroller.highroller.highrollercolumnchart');
	    jimport('dioscouri.highroller.highroller.highrollerlinechart');
	    jimport('dioscouri.highroller.highroller.highrollerpiechart');
	    jimport('dioscouri.highroller.highroller.highrollerscatterchart');
	    jimport('dioscouri.highroller.highroller.highrollerseriesdata');
	    jimport('dioscouri.highroller.highroller.highrollersplinechart');
	    
	    JHTML::_( 'script', 'highcharts.js', 'libraries/dioscouri/highroller/highcharts/' );
	}
}
?>
