<?php
defined('_JEXEC') or die;

class TrakingipTableCoretrackingip extends JTable
{

  const CORE_TRACKINGIP = '#__core_trackingip';
  
  public function __construct(&$db)
  {
    parent::__construct(self::CORE_TRACKINGIP, 'id', $db);
  }

  //Es usada para preparar los datos inmediatamente antes de ser guardados en la BD
  public function bind($array, $ignore = '')
  {
    return parent::bind($array, $ignore);
  }

  //Almacena los datos en el submit del formulario
  public function store($updateNulls = false)
  {
    return parent::store($updateNulls);
  }

  public function saveTracking($params)
  {      
      $item = new stdClass();
      $item->id = 0;
      $item->user_id = $this->getUserId($params['user']['username']);
      $item->remote_addr = $params['REMOTE_ADDR'];
      $item->http_user_agent = $params['HTTP_USER_AGENT'];
      $item->platform = $params['platform'];
      $item->payload = serialize($params);
      $db = JFactory::getDbo();
      $db->insertObject(self::CORE_TRACKINGIP, $item);    
      return $db->insertid();  
  }
		
  public function getUserId($username)
  {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select([
            $db->quoteName('g.id'),
        ])
            ->from($db->quoteName('#__users', 'g'))
            ->where("g.username = ".  $db->quote($username));
        $db->setQuery($query);
        $result = $db->loadAssoc();
        return is_null($result)?null:$result['id'];
  }        

}
