<?php
/**
 * Created by PhpStorm.
 * User: moreno
 * Date: 2/28/19
 * Time: 1:31 PM
 */

defined('_JEXEC') or die();

class plgUserTrackingip extends JPlugin{
    
    public function onUserLogin($user, $options){
        try{
            $app = JFactory::getApplication();
            $jinput = $app->input;
            $session = JFactory::getSession();
            $headers = ($jinput->server->getArray());

            $params = [
                'REMOTE_ADDR'=>$headers['REMOTE_ADDR'],
                'HTTP_USER_AGENT'=>$headers['HTTP_USER_AGENT'],
                'JINPUT'=>$headers,
                'user'=>$user,
                'platform'=>(isset($options['silent'])) ? 'app' : 'web'
            ];

            $table = $this->getTable();
            $table->saveTracking($params);          
        } catch (\Exception $ex) {

        }
    }
    
    public function getTable($type = 'Coretrackingip', $prefix = 'TrakingipTable', $config = array())
    {
        jimport('joomla.database.table');
        JTable::addIncludePath(JPATH_SITE.'/plugins/user/trackingip/tables');
        return JTable::getInstance($type, $prefix, $config);
    }
}
