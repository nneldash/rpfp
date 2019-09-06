<?php

class BaseModel extends CI_Model
{
    const OWN_PDS   = 'own';
    const APPLICANT = 'applicant';
    const EMPLOYEE  = 'employee';
    const NO_METHOD = 'SELECT 1 FROM dual WHERE 1=0';
    const _LEVEL    = 'level';
    const _ITEMNO   = 'itemno';
    const _COUNT    = 'count';

    protected $CI;

    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
    }

    protected function fillItem(BaseInterface &$item, &$classDbArray, &$data)
    {
        foreach ($classDbArray as $field => $column) {
            if (!is_array($column)) {
                // PROPERTY OF OBJECT
                $item->$field = $data->$column;
            } else {
                // OBJECT INSIDE OBJECT
                $newItem =& $item->$field;
                $this->fillItem($newItem, $column, $data);
            }
        }
    }

    protected function fromDbGetList(
        $listClass,
        $itemClass,
        $classDbArray,
        $type,
        $procsArrray,
        $id = null,
        DbInstance &$db = null,
        $libFolder = null
    ) {
        $list = new ArrayObject();
        if (!empty($listClass)) {
            $list = new $listClass();
        }

        $close_db = false;
        if ($db == null) {
            $close_db = true;
            $db = $this->LoginModel->reconnect();
            if (!$db->connected) {
                return $list;
            }
        }

        $params = false;
        $method = self::NO_METHOD;
        switch ($type) {
            case self::OWN_PDS:
                $method = 'CALL rpfp.' . $procsArrray[self::OWN_PDS];
                break;
            case self::EMPLOYEE:
                $method = 'CALL rpfp.' . $procsArrray[self::EMPLOYEE];
                if (!isset($id)) {
                    return $list;
                }
                $params = array($id);
                break;
            case self::APPLICANT:
                $method = 'CALL rpfp.' . $procsArrray[self::APPLICANT];
                if (!isset($id)) {
                    return $list;
                }
                $params = array($id);
                break;
        }
        $rows = $this->getRows($db->database, $method, $params);

        if ($rows !== false && (count($rows) > 0)) {
            $this->CI->load->library($libFolder . '/' . $itemClass);

            foreach ($rows as $data) {
                $item = new $itemClass();

                $this->fillItem($item, $classDbArray, $data);
                $list->append($item);
            }
        }

        if ($close_db) {
            $db->database->close();
        }

        return $list;
    }

    protected function fromDbGetSpecific(
        $itemClass,
        $classDbArray,
        $type,
        $procsArrray,
        $id = null,
        DbInstance &$db = null,
        $libFolder
    ) {

        $rows = $this->fromDbGetList(null, $itemClass, $classDbArray, $type, $procsArrray, $id, $db, $libFolder);

        if (count($rows) > 0) {
            return $rows[0];
        }
        return new $itemClass();
    }

    protected function runQuery(&$db, $query_string, $bind_params = false)
    {
        $queryResult = $db->query($query_string, $bind_params, true);
        
        $err = $db->error();
        if (!empty($err->code)) {
            if (!$queryResult) {
                return false;
            }
            $queryResult->free_result();
            return false;
        }
        return $queryResult;
    }

    protected function getRows(&$db, $query_string, $bind_params = false)
    {
        $res = $this->runQuery($db, $query_string, $bind_params);
        if (!$res) {
            $db->conn_id->next_result();
            return false;
        }

        $result = $res->result();

        /* close the result set to enable other queries to run */
        $db->conn_id->next_result();
        $res->free_result();
        return $result;
    }

    protected function runStoredProcAndGetResults($proc, $params, DbInstance &$db = null, $is_function = false)
    {
        if (empty($proc)) {
            return;
        }

        $close_db = false;
        if ($db == null) {
            $close_db = true;
            $db = $this->LoginModel->reconnect();
            if (!$db->connected) {
                return false;
            }
        }

        $method = (empty($is_function) ? 'CALL' : 'SELECT') .' rpfp.' . $proc;
        
        $numParams = count($params);
        $method .= '(';
        for ($i=1; $i<=$numParams; $i++) {
            $method .= '?';
            if ($i < $numParams) {
                $method .= ', ';
            }
        }
        $method .= ')';
        $method .= (empty($is_function) ? '' : ' AS RESULT');
        
        $data = [];
        for ($i=0; $i<$numParams; $i++) {
            $data[$i] = ((strpos($params[$i], N_A) === false) ? $params[$i] : '');
        }
        
        $res = $this->getRows($db->database, $method, $data);
        
        if ($close_db) {
            $db->database->close();
        }

        return $res;
    }

    protected function getFunctionResult($func, $params, DbInstance &$db = null)
    {
        $rows = $this->runStoredProcAndGetResults($func, $params, $db, $is_function = true);
        if (!empty($rows)) {
            return ($rows[0]->RESULT);
        }
        return false;
    }

    protected function saveToDb($proc, $params, DbInstance &$db = null)
    {
        return true;
        exit;
        $rows = $this->runStoredProcAndGetResults($proc, $params, $db);
        if (!empty($rows)) {
            $message = $rows[0]->MESSAGE;
            return $message;
        }
        return false;
    }
}
