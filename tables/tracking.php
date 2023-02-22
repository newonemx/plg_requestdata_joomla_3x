<?php
/**
 * Created by PhpStorm.
 * User: moreno
 * Date: 3/1/19
 * Time: 12:54 PM
 */
defined('_JEXEC') or die;

class LoginTableTracking extends JTable
{
    /**
     *
     */
    const LOGIN_TRACKING = '#__login_tracking';
    var $loginType;
    var $username;
    var $userid;
    var $device;

    /**
     *
     * @param type $db
     */
    public function __construct(&$db)
    {
        parent::__construct(self::LOGIN_TRACKING, 'id', $db);
    }

    public function setLoginType($type){
        $this->loginType = $type;
    }

    public function setUsername($username){
        $this->username = $username;
    }

    public function setDevice($device){
        $this->device = $device;
    }

    public function setUserId($id){
        $this->userid = $id;
    }

    public function saveLogin(){
        $loginRecord = new stdClass();
        $loginRecord->user_id =$this->getUserId();
        $loginRecord->platform = $this->loginType;
        $loginRecord->device = 'N/A';
        JFactory::getDbo()->insertObject(self::LOGIN_TRACKING, $loginRecord);
    }

    public function updateLoginTracking(){
        $lastLogin = new stdClass();
        $lastLogin->id = $this->getLastLogin();
        $lastLogin->device = ($this->device == 2)?'android':'ios';
        JFactory::getDbo()->updateObject(self::LOGIN_TRACKING, $lastLogin,'id');
    }

    private function getUserId(){
        return JUserHelper::getUserId($this->username);
    }

    public function getModel($name = 'Tracking', $prefix = 'LoginModel', $config = array())
    {
        JModelLegacy::addIncludePath(JPATH_SITE.'/plugins/user/tracking/models');
        $model = JModelLegacy::getInstance($name, $prefix, $config);
        return $model;
    }

    protected function getLastLogin()
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select("id")
            ->from(self::LOGIN_TRACKING)
            ->where($db->quoteName('user_id') . ' = ' . $this->userid . ' and platform = "app"')
            ->order('id DESC')
            ->setLimit('1');
        $db->setQuery($query);
        return $db->loadResult();
    }
}