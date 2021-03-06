<?php
/**
 * @package DSC
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

class DSCControllerSite extends DSCController 
{   
    var $_models = array();
    var $message = "";
    var $messagetype = "";
        
    /**
     * constructor
     */
    function __construct( $config=array() ) 
    {
        parent::__construct( $config );
        $this->set('suffix', 'dashboard');
        
        // Set a base path for use by the controller
        if (array_key_exists('base_path', $config)) {
            $this->_basePath    = $config['base_path'];
        } else {
            $this->_basePath    = JPATH_COMPONENT;
        }
        
        // Register Extra tasks
        $this->registerTask( 'list', 'display' );
        $this->registerTask( 'close', 'cancel' );
    }

    /**
     * Displays the footer
     * 
     * @return unknown_type
     */
    function footer()
    {
        // show a generous linkback, TIA
        $app = DSC::getApp();
        $show_linkback = $app->get('show_linkback', '1');
        $name = $app->getName();
        $model_name = $name . "ModelDashboard";
         
        $app->load( $model_name, "models.dashboard" );
        $model  = new $model_name();
        
        $format = JRequest::getVar('format');
        if ($show_linkback == '1' && $format != 'raw') 
        {
            $view   = $this->getView( 'dashboard', 'html' );
            $view->hidemenu = true;
            $view->setTask('footer');
            $view->setModel( $model, true );
            $view->setLayout('footer');
            $view->assign( 'style', '');
            $view->display();
        } 
            elseif ($format != 'raw')
        {
            $view   = $this->getView( 'dashboard', 'html' );
            $view->hidemenu = true;
            $view->setTask('footer');
            $view->setModel( $model, true );
            $view->setLayout('footer');
            $view->assign( 'style', 'style="display: none;"');
            $view->display();
        }

        return;
    }
    
}

?>