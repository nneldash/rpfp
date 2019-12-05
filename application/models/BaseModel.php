<?php

class BaseModel extends CI_Model
{
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
        $proc,
        $params = array(),
        $libFolder = null,
        DbInstance &$db = null
    ) : ArrayObject
    {
        $list = new ArrayObject();
        if (!empty($listClass)) {
            $list = new $listClass();
        }

        $rows = $this->runStoredProcAndGetResults($proc, $params, $db);

        if ($rows !== false && (count($rows) > 0)) {
            $test_lib_folder = $libFolder;
            try {
                $this->CI->load->library($test_lib_folder . '/' . $itemClass);
            } catch (Exception $e) {
                $test_lib_folder = 'common';
                $this->CI->load->library($test_lib_folder . '/' . $itemClass);
            }

            foreach ($rows as $data) {
                $item = new $itemClass();

                $this->fillItem($item, $classDbArray, $data);
                $list->append($item);
            }
        }

        return $list;
    }

    protected function fromDbGetSpecific(
        $itemClass,
        $classDbArray,
        $proc,
        $params = array(),
        $libFolder = null,
        DbInstance &$db = null
    ) {
        $rows = $this->fromDbGetList(null, $itemClass, $classDbArray, $proc, $params, $libFolder, $db);

        if (count($rows) > 0) {
            return $rows[0];
        }
        return null;
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

    protected function fromDbGetReportList(
        $listClass,
        $itemClass,
        $classDbArray,
        $proc,
        $params = array(),
        DbInstance &$db = null,
        $libFolder = ''
    ) : ArrayObject
    {
        $list = new ArrayObject();
        if (!empty($listClass)) {
            $list = new $listClass();
        }

        $rows = $this->runStoredProcAndGetResults($proc, $params, $db);

        if ($rows !== false && (count($rows) > 0)) {
            $test_lib_folder = $libFolder;
            try {
                $this->CI->load->library($test_lib_folder . '/' . $itemClass);
            } catch (Exception $e) {
                $test_lib_folder = 'common';
                $this->CI->load->library($test_lib_folder . '/' . $itemClass);
            }

            foreach ($rows as $data) {
                $item = new $itemClass();

                $this->fillItem($item, $classDbArray, $data);
                $list->append($item);
            }
        }

        return $list;
    }

    protected function getRows(&$db, $query_string, $bind_params = false)
    {
        $res = $this->runQuery($db, $query_string, $bind_params);

        if (!$res) {
            if ($db->conn_id->more_results()) {
                $db->conn_id->next_result();
            }
            return false;
        }

        $result = $res->result();

        /* close the result set to enable other queries to run */
        if ($db->conn_id->more_results()) {
            $db->conn_id->next_result();
        }
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

    protected function getFunctionResult($func, $params = array(), DbInstance &$db = null)
    {
        $rows = $this->runStoredProcAndGetResults($func, $params, $db, $is_function = true);
        if (!empty($rows)) {
            return ($rows[0]->RESULT);
        }
        return false;
    }

    protected function saveToDb($proc, $params, DbInstance &$db = null)
    {
        $rows = $this->runStoredProcAndGetResults($proc, $params, $db);
        
        if (!empty($rows)) {
            $message = $rows[0]->MESSAGE;
            return $message;
        }
        
        return false;
    }
}
