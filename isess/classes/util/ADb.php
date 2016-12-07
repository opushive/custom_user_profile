<?php

namespace custom_profile;

//include_once plugin_dir_path(dirname(__FILE__)) . 'util/interfaces/IDb.php';

/**
 * Description of ADb
 *
 * @author femi
 */
class ADb implements IDb {

    //put your code here
    static $prefix = 'smash_';
    protected $fieldsToTypes = array();
    protected $id = NULL;
    protected $primaryKey = "";
    private $lastError;
    static private $mutexLock = false;

    const ARRAY_A = "ARRAY_A";
    const ARRAY_N = "ARRAY_N";
    const OBJECT = "OBJECT";
    const OBJECT_K = "OBJECT_K";

    /*
     * Class Constructor
     */

    public function __construct($_id, $_fieldlist, $_fieldToTypes, $_createOnDb = false) {

        $this->id = $_id;
        $this->fieldsToTypes = $_fieldToTypes;

        $this->setFields($_fieldlist);
        $this->primaryKey = smash_strip_interface(strtolower(get_called_class()) . "_Id",'smash');

        if ($_createOnDb) {
            $this->create();
        } else if (!is_object($this->id) && is_int(intval($this->id)) && $this->id > 0) {
            $this->get();
        }
    }

    public function lockMutex() {
        self::$mutexLock = true;
    }

    public function unlockMutex() {
        self::$mutexLock = false;
    }

    public function getMutex() {
        return self::$mutexLock;
    }

    protected function setLastError($theError) {
        $this->lastError = $theError;
    }

    protected function createDefaultMetaTags(array $_metaFields) {
        if (property_exists($this, 'meta')) {
            if (!isset($this->meta)) {
                $this->meta = array();
            }
            if (!is_array($this->meta)) {
                $this->meta = unserialize($this->meta);
                if (!is_array($this->meta)) {
                    $this->meta = array();
                }
            }
            $keys = array_keys($_metaFields);
            foreach ($keys AS $nextKey) {
                if (!key_exists($nextKey, $this->meta)) {
                    $this->meta[$nextKey] = $_metaFields[$nextKey];
                }
            }
        }
    }

    protected static function _table() {
        global $wpdb;
        $tablename = ADb::$prefix . strtolower(get_called_class());
        var_dump(strtolower(get_called_class()));
        var_dump($wpdb->prefix . $tablename);
        var_dump(smash_strip_interface($wpdb->prefix . $tablename,'wp_smash_custom_profile'));
        exit();
        return smash_strip_interface($wpdb->prefix . $tablename,'wp_smash_custom_profile');
    }

    static function time_to_date($time) {
        return gmdate('Y-m-d H:i:s', $time);
    }

    static function now() {
        return self::time_to_date(time());
    }

    static function date_to_time($date) {
        return strtotime($date . ' GMT');
    }

    static function insert_id() {
        global $wpdb;
        return $wpdb->insert_id;
    }

    // FUNCTIONS TO HANDLE GROUP OPERATIONS (MULTIPLE ROWS ETC)

    /**
     * Retreives multiple OBJECT rows from the active table database based on the fields set and the condition
     * if any
     *
     * @param array $_fields - the fields to retrieve e.g. (line1,line2,city)
     * @param string $_condition - database condition e.g Address_Id > 4 (don't put WHERE in this field)
     * @param string $_returnType - one of many return types [ARRAY_A | ARRAY_N | OBJECT | OBJECT_K] use  ADb::ARRAY_A,ADb::ARRAY_N etc
     * @param integer $_index - the starting record
     * @param integer $_limit - number of rows to return
     * @return array - an array of objects
     */
    public static function _get($_fields = NULL, $_condition = NULL, $_returnType = ADb::OBJECT, $_index = 0, $_limit = 100) {
        global $wpdb;
        $wpdb->show_errors = TRUE;
        $wpdb->suppress_errors = FALSE;

        if ($_condition !== NULL && !is_array($_condition)) {
            $_condition = sanitize_text_field($_condition);
        }

        if (NULL === $_fields) {

            // get the fieldlist of the class
            $theCallingClass = get_called_class();


            $sampleClass = new $theCallingClass(NULL, NULL);

            // correct ambiguos primary keys
            if (count($_condition) == 2 && is_array($_condition)) {

                $currentFieldlist = array();
                $currentFieldlist[self::_table() . '.' . strtolower($theCallingClass) . '_Id'] = "";
                $currentFieldlist = array_merge($currentFieldlist, get_object_vars($sampleClass));
                unset($currentFieldlist[strtolower($theCallingClass) . '_Id']);
            } else {

                $currentFieldlist = get_object_vars($sampleClass);
            }
            unset($currentFieldlist['fieldsToTypes']);
            unset($currentFieldlist['id']);
            unset($currentFieldlist['primaryKey']);
            unset($currentFieldlist['lastError']);
        } else {
            $currentFieldlist = $_fields;
        }
        $key = array_keys($currentFieldlist);

        // get the keys
        $_fields = $key != array_keys($key) ? implode(",", array_keys($currentFieldlist)) :
                implode(",", $currentFieldlist);

        // get the keys
        $limit = "";
        if ($_index > 0) {
            $limit = $_index . ',' . $_limit;
        }

        if (NULL != $_condition) {

            // condition can be in two formats a string or an array of two fields [tables,condition]
            if (count($_condition) == 2 && is_array($_condition)) {
                if ("" != $limit) {
                    $sql = sprintf('SELECT %s FROM %s,%%s WHERE %%s LIMIT %%s', $_fields, self::_table());
                    $preparedStatement = $wpdb->prepare($sql, $_condition[0], $_condition[1], $limit);
                } else {
                    $sql = sprintf('SELECT %s FROM %s,%%s WHERE %%s', $_fields, self::_table());
                    $preparedStatement = sprintf($sql, $_condition[0], $_condition[1]);
                }
            } else {
                if ("" != $limit) {
                    $sql = sprintf('SELECT %s FROM %s WHERE %%s LIMIT %%s', $_fields, self::_table());
                    $preparedStatement = $wpdb->prepare($sql, $_condition, $limit);
                } else {
                    $sql = sprintf('SELECT %s FROM %s WHERE %s', $_fields, self::_table(), $_condition);
                    $preparedStatement = $sql;
                }
            }
        } else {

            if ("" != $limit) {
                $sql = sprintf('SELECT %s FROM %s WHERE %s LIMIT %%s', $_fields, self::_table());
                $preparedStatement = $wpdb->prepare($sql, $limit);
            } else {

                $preparedStatement = sprintf('SELECT %s FROM %s', $_fields, self::_table());
            }
        }
     
        $resultSet = $wpdb->get_results($preparedStatement, $_returnType);
        
        return $resultSet;
    }

    /**
     * Updates the set fields on the table representing the class calling this function
     * @param type $_fieldlist - an array of key value pairs eg ("line1" => 52,"city" => "london");
     * @param type $_condition - database condition e.g array("Address_Id" => 4)
     * @return boolean - true/false if succesfull or not
     */
    public static function _update(array $_fieldlist, array $_condition) {
        global $wpdb;
        $wpdb->show_errors = TRUE;
        $wpdb->suppress_errors = FALSE;

        $currentFieldlist = array();

        // check if any external fields have been set
        if (NULL != $_fieldlist) {
            // if so update the fields
            foreach ($_fieldlist AS $nextField => $value) {
                if (is_array($value)) {
                    $currentFieldlist[$nextField] = serialize($value);
                } else {
                    $currentFieldlist[$nextField] = $value;
                }
            }
        }
        // condition can be in two formats a string or an array of two fields [tables,condition] 
        $success = $wpdb->update(self::_table(), $currentFieldlist, $_condition);
        return $success;
    }

    /**
     * deletes an entry from the active table on the database according to the specified condition
     * @param type $_condition - database condition e.g Address_Id > 4 (don't put WHERE in this field)
     * @return boolean - true/false if succesfull or not
     */
    public static function _delete($_condition) {
        global $wpdb;
        $wpdb->show_errors = TRUE;
        $wpdb->suppress_errors = FALSE;
        $success = $wpdb->query(sprintf('DELETE FROM %s WHERE %s', self::_table(), $_condition));

        return $success;
    }

    /**
     * creates a new row on the active table of the database
     * @param type $_fieldlist - an array of key value pairs eg ("line1" => 52,"city" => "london")
     * @param type $_aExcludeFields - an optional array of fields that should nto be set in the create query. e.g. fields that have default
     * values generated by the db
     * @return boolean - true/false if succesfull or not
     */
    public function create(array $_fieldlist = NULL, $_aExcludeFields = NULL) {
        global $wpdb;
        $wpdb->show_errors = TRUE;
        $wpdb->suppress_errors = FALSE;

        // get the fieldlist of the class
        $currentFieldlist = get_object_vars($this);
        unset($currentFieldlist['fieldsToTypes']);
        unset($currentFieldlist['id']);
        unset($currentFieldlist['primaryKey']);
        unset($currentFieldlist['lastError']);
        foreach ($currentFieldlist AS $nextField => $value) {
            if (is_array($value)) {
                $currentFieldlist[$nextField] = serialize($value);
            }
            if ($value instanceof \DateTime) {
                $currentFieldlist[$nextField] = $value->format(\Utilities::DATEFORM_DBDATE);
            }
            if ($value instanceof \DateInterval) {
                $currentFieldlist[$nextField] = $value->format(\Utilities::DATEFORM_DBDATE);
            }
        }


        // check if any external fields have been set
        if (NULL != $_fieldlist) {
            // if so update the fields
            foreach ($_fieldlist AS $nextField => $value) {
                if (is_array($value)) {
                    $currentFieldlist[$nextField] = serialize($value);
                } else {
                    $currentFieldlist[$nextField] = $value;
                }
            }
        }
        // check the exclude statement for any terms to leave out
        if (NULL != $_aExcludeFields) {

            foreach ($_aExcludeFields AS $nextExclude) {

                if (isset($currentFieldlist[$nextExclude])) {

                    unset($currentFieldlist[$nextExclude]);
                }
            }
        }
        // get the field types
        foreach ($currentFieldlist as $key => $field) {
            if ($field == null) {
                unset($currentFieldlist[$key]);
            }
        }
        $types = array();
        if (NULL != $_fieldlist) {
            foreach ($_fieldlist AS $k => $nextField) {
                if (is_array($nextField)) {
                    $opt = $k;
                } else {
                    $opt = $nextField;
                }
                if (isset($this->fieldsToTypes[$opt]) && $this->fieldsToTypes[$opt]) {
//                    echo "field:" . $opt . ",type:" . $this->fieldsToTypes[$opt] . "<br />";
                    array_push($types, $this->fieldsToTypes[$opt]);
                }
            }
        } else {
            $fields = array_keys($currentFieldlist);
            foreach ($fields AS $nextField) {
                array_push($types, $this->fieldsToTypes[$nextField]);
            }
        }

//        echo "post fieldlist:" . var_dump($currentFieldlist) . var_dump($types);
        if (count($types) > 0) {
            $success = $wpdb->insert(self::_table(), $currentFieldlist, $types);
        } else {
            $success = $wpdb->insert(self::_table(), $currentFieldlist);
        }
        if ($success == 1) {

            $this->setFields($currentFieldlist);
            $this->setId(ADb::insert_id());
//            if (!self::$mutexLock) {
//                \Event::triggerEvent($this, 'CREATE', $this->getFieldlistForEventTrigger());
//            }
        } else {
            $this->lastError = $wpdb->last_errot;
            //$wpdb->last_query;
            // TODO - need to track failed creates
        }

        return $success;
    }

    /**
     * Retreives the latest values of all the fields in this class or a selected number set in $_fields
     * for the active class instance and the condition if any
     * @param array $_fields - the fields to retrieve e.g. (line1,line2,city)
     * @param integer $_index - the starting record
     * @param string $_condition - database condition e.g Address_Id > 4 (don't put WHERE in this field)
     * @return array - the result set from the db
     */
    public function get(array $_fields = NULL, $_index = 0, $_condition = NULL) {
        global $wpdb;
        $wpdb->show_errors = TRUE;
        $wpdb->suppress_errors = FALSE;

        if (NULL == $_fields) {

            // get the fieldlist of the class
            $currentFieldlistwithvalues = get_object_vars($this);

            unset($currentFieldlistwithvalues['fieldsToTypes']);
            unset($currentFieldlistwithvalues['id']);
            unset($currentFieldlistwithvalues['primaryKey']);
            unset($currentFieldlistwithvalues['lastError']);
            $currentFieldlist = array_keys($currentFieldlistwithvalues);
        } else {
            $currentFieldlist = $_fields;
        }
        // get the keys

        $tableColumns = implode(",", $currentFieldlist);

        if (NULL != $_condition) {
            // condition can be in two formats a string or an array of two fields [tables,condition]
            if (count($_condition) == 2 && is_array($_condition)) {
                $sql = sprintf('SELECT %s FROM %s,%s WHERE %s AND %s = %%s', $tableColumns, self::_table(), $_condition[0], $_condition, $this->primaryKey);
            } else {
                $sql = sprintf('SELECT %s FROM %s WHERE %s AND %s = %%s', $tableColumns, self::_table(), $_condition, $this->primaryKey);
            }
        } else {
            $sql = sprintf('SELECT %s FROM %s WHERE %s = %%s', $tableColumns, self::_table(), $this->primaryKey);
        }

        $preparedStatement = $wpdb->prepare($sql, $this->id);

        if ($_index > 0) {
            $resultSet = $wpdb->get_row($preparedStatement, OBJECT, $_index);
        } else {
            $resultSet = $wpdb->get_row($preparedStatement);
        }

        $this->setFields($resultSet);
//        if ($resultSet) {
//            if (!self::$mutexLock) {
//                \Event::triggerEvent($this, 'READ', $this->getFieldlistForEventTrigger());
//            }
//        }
        return $resultSet;
    }

    /**
     * Updates all fields or the set fields in $_fieldlist of the active class instance (calling this function)
     * @param type $_fieldlist - an array of key value pairs eg ("line1" => 52,"city" => "london");
     * @param type $_condition - database condition e.g Address_Id > 4 (don't put WHERE in this field)
     * @return boolean - true/false if succesfull or not
     */
    public function update(array $_fieldlist = NULL, $_condition = NULL) {
        global $wpdb;
        $wpdb->show_errors = TRUE;
        $wpdb->suppress_errors = FALSE;
        if (NULL == $_fieldlist) {
            // get the fieldlist of the class
            $currentFieldlist = get_object_vars($this);
            unset($currentFieldlist['fieldsToTypes']);
            unset($currentFieldlist['id']);
            unset($currentFieldlist['primaryKey']);
            unset($currentFieldlist['lastError']);
        } else {
            $currentFieldlist = $_fieldlist;
        }
        foreach ($currentFieldlist AS $nextField => $value) {
            if (is_array($value)) {
                $currentFieldlist[$nextField] = serialize($value);
            }
            if ($value instanceof \DateTime) {
                $currentFieldlist[$nextField] = $value->format(\Utilities::DATEFORM_DBDATE);
            }
            if ($value instanceof \DateInterval) {
                $currentFieldlist[$nextField] = $value->format(\Utilities::DATEFORM_DBDATE);
            }
        }
        //unset field whose value is null so as to be able to store them as null in db table
        foreach ($currentFieldlist as $key => $field) {
            if ($field == null) {
                unset($currentFieldlist[$key]);
            }
        }
        if (NULL != $_condition) {
            // condition can be in two formats a string or an array of two fields [tables,condition]
            if (isset($currentFieldlist[$this->primaryKey])) {
                unset($currentFieldlist[$this->primaryKey]);
            }
            $conditions = explode(",", $_condition);
            $preparedConditions = array($this->primaryKey => $this->id);
            foreach ($conditions AS $nextCondition) {
                $keyAndVal = explode("=", $nextCondition);
                if (count($keyAndVal) == 2) {
                    $preparedConditions[$keyAndVal[0]] = $keyAndVal[1];
                } else {
                    throw new Exception("The condition ($_condition ) for the class " . get_called_class() . " has not been properly formatted!");
                }
            }
            $success = $wpdb->update(self::_table(), $currentFieldlist, $preparedConditions);
        } else {
            $success = $wpdb->update(self::_table(), $currentFieldlist, array($this->primaryKey => $this->id));
        }
        if ($success && NULL != $_fieldlist) {
            $this->setFields($currentFieldlist);
        }
        if ($success) {
//            if (!self::$mutexLock) {
//                \Event::triggerEvent($this, 'UPDATE', $this->getFieldlistForEventTrigger());
//            }
        } else {
            $this->setLastError($wpdb->last_error . "(" . $wpdb->last_query . ")");
        }
        return $success;
    }

    private function extractArrayKeys($_theArray, &$_fieldList) {
        $keys = array_keys($_theArray);
        foreach ($keys AS $nextKey) {
            if (is_array($nextKey)) {
                $this->extractArrayKeys($nextKey, $_fieldList);
            } else {
                $_fieldList[$nextKey] = $_theArray[$nextKey];
            }
        }
    }

    private function getFieldlistForEventTrigger() {
        $fieldList = get_object_vars($this);
        $theMeta = $this->getMeta();
        if (NULL != $theMeta) {
            if (!is_array($theMeta)) {
                $theMeta = unserialize($theMeta);
            }
            if (is_array($theMeta)) {
                $keys = array_keys($theMeta);
                foreach ($keys AS $nextKey) {
                    if (is_array($nextKey)) {
                        $this->extractArrayKeys($nextKey, $fieldList);
                    } else {
                        $fieldList[$nextKey] = $theMeta[$nextKey];
                    }
                }
            }
        }
        return $fieldList;
    }

    /**
     * deletes this classes instance from the database
     * @return boolean - true/false if succesfull or not
     */
    public function delete() {
        global $wpdb;
        $wpdb->show_errors = TRUE;
        $wpdb->suppress_errors = FALSE;
        $sql = sprintf('DELETE FROM %s WHERE %s = %%s', self::_table(), $this->primaryKey);
        $result = $wpdb->query($wpdb->prepare($sql, $this->id));
//        if ($result) {
//            if (!self::$mutexLock) {
//                \Event::triggerEvent($this, 'DELETE', $this->getFieldlistForEventTrigger());
//            }
//        }
        return $result;
    }

    /**
     * returns the value of the active class instance PrimaryKey
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     *
     * sets the value of  the active class instance PrimaryKey
     * @param integer $_id
     */
    public function setId($_id) {
        $this->id = $_id;
        $primary_key = $this->primaryKey;
        $this->$primary_key = $_id;
    }

    /**
     * Override this function to return the last error that occurred by an action on this class
     * @return string
     */
    function getLastError() {
        global $wpdb;
        if (isset($wpdb->last_error)) {
            $wpdb->last_error;
        } else {
            return $this->lastError;
        }
    }

    /**
     * sets the fields on the active class with the values specified in $_fieldList
     * @param array $_fieldList - key => value set of (fields => values)
     */
    protected function setFields($_fieldList) {
        if (is_array($_fieldList)) {
            $fields = array_keys($_fieldList);
            foreach ($fields AS $nextField) {
//				echo "Setting:$nextField,to:".$_fieldList[$nextField]."<br />";
                $this->__set($nextField, $_fieldList[$nextField]);
            }
        } else if (is_object($_fieldList)) {
            $fields = array_keys(get_object_vars($_fieldList));
            foreach ($fields AS $nextField) {
//				echo "Setting:$nextField,to:".$_fieldList->$nextField."<br />";
                $this->__set($nextField, $_fieldList->$nextField);
            }
        }
    }

    /**
     * gets the field specified by $_sName
     * @param _sName
     */
    public function __get($_sName) {
        // Ensure the property exists
        if (!property_exists($this, $_sName)) {
            throw new \Exception("Property '" . __CLASS__ . "::$_sName' does not exist");
        }
        return $this->$_sName;
    }

    /**
     * sets the field specified by $_sName
     * @param _sName
     * @param _value
     */
    public function __set($_sName, $_value) {
        // Ensure the property exists
        if (property_exists($this, $_sName)) {
            $this->$_sName = $_value;
        }
        /*
          if (property_exists($this, $_sName)) {
          throw new \Exception("Property '" . __CLASS__ . "::$_sName' does not exist");
          } else {
          $this->$_sName = $_value;
          }
         */
    }

    public function toFieldlist() {
        $currentFieldlist = get_object_vars($this);
        unset($currentFieldlist['fieldsToTypes']);
        unset($currentFieldlist['id']);
        unset($currentFieldlist['primaryKey']);
        unset($currentFieldlist['lastError']);
        return $currentFieldlist;
    }

    public function getMeta($_field = NULL) {
        if (property_exists($this, 'meta')) {
            if (NULL == $_field) {
                return $this->meta;
            } else {
                if (!is_array($this->meta)) {
                    $this->meta = unserialize($this->meta);
                }
                if (!is_array($this->meta)) {
                    return NULL;
                } else {
                    if (array_key_exists($_field, $this->meta)) {
                        return $this->meta[$_field];
                    } else {
                        return false;
                    }
                }
            }
        } else {
            return NULL;
        }
    }

    public static function _getMeta($_field, $_meta) {
        $meta = $_meta;
        if (!is_array($_meta)) {
            $meta = unserialize($_meta);
        }
        if(!is_array($meta)){
 
           return false;
        }
        if (array_key_exists($_field, $meta)) {
            return $meta[$_field];
        } else {
            return false;
        }
    }

    public function setMeta($_meta, $_field = NULL) {
        if (property_exists($this, 'meta')) {
            if (!is_array($this->meta) && !is_string($this->meta)) {
                if (NULL == $_field) {
                    $this->meta = $_meta;
                } else {
                    $this->meta = array();
                    $this->meta[$_field] = $_meta;
                }
                return;
            } else if (is_string($this->meta)) {
                $this->meta = unserialize($this->meta);
            }
            if (NULL == $_field) {
                if (!is_array($_meta)) {
                    $_meta = unserialize($_meta);
                }
                $keys = array_keys($_meta);
                foreach ($keys AS $nextKey) {
                    $this->meta[$nextKey] = $_meta[$nextKey];
                }
            } else {
                $this->meta[$_field] = $_meta;
            }
        }
    }

    public function setSlug($_name) {
        if (isset($_name)) {
            $_name = str_replace("'", "", $_name);
            $slugname = str_replace(" ", "-", strtolower($_name));
            $original_slug = $slugname;
            $slug_is_unique = false;
            $i = 1;
            while (!$slug_is_unique) {
                $i++;
                if ($i >= 99) {
                    throw new \Exception("There are two many " . __CLASS__ . "with same name :" . $_name);
                }
                if ($this instanceof IDb) {
                    $query = $this->_get(array('slug'), "slug = '" . $slugname . "'");
                    if (!\Utilities::isValidDbObj($query) || count($query) == 0) {
                        $slug_is_unique = true;
                    } else {
                        $slugname = $original_slug . "-" . $i;
                    }
                } else {
                    throw new \Exception("Object is not an instance of IDb");
                }
            }
            return $slugname;
        }
    }

}
