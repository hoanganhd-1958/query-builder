<?php
require_once 'connection.php';
/**
 * class base model
 */
class BaseModel extends DB
{
    /**
     * valiable connect to DB
     */
    protected $db;

    /**
     * valiable table field
     */
    protected $table;

    /**
     * selected fiedls
     */
    protected $select_field = '';

    /**
     * where clause
     */
    protected $where_field;

    /**
     * where .. and .. clause
     */
    protected $and_where_field;

    /**
     * where .. or .. clause
     */
    protected $or_where_field;

    /**
     * order by clause
     */
    protected $order_field;

    /**
     * group by clause
     */
    protected $group_by_field = '';

    /**
     * having clause
     */
    protected $having_field;

    /**
     * limit clause
     */
    protected $limit_field;

    /**
     * get record by primery key
     */
    protected $find_field;

    /**
     * count record
     */
    protected $count_field = '';

    /**
     * array to save values of clause
     */
    protected $value = [];
    
    /**
     * construct connection to DB
     */
    public function __construct()
    {
        $this->db = parent::getConnect();
    }

    /**
     * close connetion
     */
    public function __destruct()
    {
        $this->db = parent::closeConnect();
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function select($field = '*')
    {
        $numargs = func_num_args();
        if ($numargs >= 1) {
            $args_list          = func_get_args();
            $this->select_field = implode(',', $args_list);
        } else {
            $this->select_field = $field;
        }
        return $this;
    }

    public function where($field, $value)
    {
        $numargs = func_num_args();
        if ($numargs >= 3) {
            $args_list         = func_get_args();
            $field             = self::wherePDO($args_list);
            $this->where_field = implode(' ', $field);
        } else {
            $this->where_field   = " $field = :$field ";
            $this->value[$field] = $value;
        }
        return $this;
    }

    public function andWhere($field, $value)
    {
        $numargs = func_num_args();
        if ($numargs >= 3) {
            $args_list             = func_get_args();
            $field                 = self::wherePDO($args_list);
            $this->and_where_field = implode(' ', $field);
        } else {
            $this->and_where_field = " $field = :$field ";
            $this->value[$field]   = $value;
        }
        return $this;
    }

    public function orWhere($field, $value)
    {
        $numargs = func_num_args();
        if ($numargs >= 3) {
            $args_list            = func_get_args();
            $field                = self::wherePDO($args_list);
            $this->or_where_field = implode(' ', $field);
        } else {
            $this->or_where_field = " $field = :$field";
            $this->value[$field]  = $value;
        }
        return $this;
    }

    public function wherePDO(array $arr)
    {
        $rep    = [2 => ":$arr[0]"];
        $result = array_replace($arr, $rep);
        $this->value[$arr[0]] = $arr[2];
        return $result;
    }

    public function orderBy($field = 'id', $order = 'ASC')
    {
        $this->order_field .= ($this->order_field == '') ? " $field $order" : " , $field $order";
        return $this;
    }

    public function groupBy($field)
    {
        if (func_num_args() >1) {
            $this->group_by_field = implode(', ', func_get_args());
        } else {
            $this->group_by_field = $field;
        }
        return $this;
    }

    public function having($field, $value)
    {
        if (func_num_args()>=3) {
            $field              = self::wherePDO(func_get_args());
            $this->having_field = implode(' ', $field);
        } else {
            $this->having_field  = " $field = :$field";
            $this->value[$field] = $value;
        }
        return $this;
    }

    public function limit($limit)
    {
        if (func_num_args()>1) {
            $this->limit_field = implode(', ', func_get_args());
        } else {
            $this->limit_field = " $limit";
        }
        return $this;
    }

    public function count()
    {
        $this->count_field  = " COUNT('id')";
        $this->select_field = ' ';
        return self::get();
    }

    /**
     * create final query string by clause
     * @return query string
     */
    public function getQuery()
    {
        $select_f    = ($this->select_field != '') ? $this->select_field : '*';
        $where_f     = ($this->where_field != '') ? " WHERE $this->where_field" : '';
        $and_where_f = ($this->and_where_field != '') ?  " AND $this->and_where_field": '';
        $or_where_f  = ($this->or_where_field != '') ? " OR $this->or_where_field" : '';
        $order_f     = ($this->order_field != '') ? " ORDER BY $this->order_field" : '';
        $group_by_f  = ($this->group_by_field != '') ? " GROUP BY $this->group_by_field" : '';
        $having_f    = ($this->having_field != '') ? " HAVING $this->having_field" : '';
        $limit_f     = ($this->limit_field != '') ? " LIMIT $this->limit_field" : '';
        $find_f      = ($this->find_field != '') ? $this->find_field : '';
        $count_f     = ($this->count_field != '') ? $this->count_field : '';
        
        $sql  = "SELECT $select_f $count_f FROM $this->table "
        .$where_f
        .$and_where_f
        .$or_where_f
        .$find_f
        .$order_f
        .$group_by_f
        .$having_f
        .$limit_f
        .";";
        return $sql;
    }

    public function find($id)
    {
        if (is_array($id)) {
            $where = " WHERE id in(" . implode(",", $id).")";
            $this->find_field = $where;
        } else {
            $this->find_field  = ' WHERE id = :id';
            $this->value['id'] = $id;
        }
        return self::get();
    }

    public function get()
    {
        try {
            $result = [];
            $sql    = self::getQuery();
            $stmt   = $this->db->prepare($sql);
            $stmt->execute($this->value);
            if ($stmt->rowCount() > 0) {
                // return 1;
                while (($r = $stmt->fetch(PDO::FETCH_OBJ)) != null) {
                    $result[] = $r;
                }
                return $result;
            } else {
                // return 2;
                return $stmt->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            echo "ERROR : " . $e->getMessage();
            die();
        }
    }

    public function insert(array $arr)
    {
        if (isset($arr) && !is_null($arr)) {
            try {
                $field = implode(',', array_keys($arr));
                $val   = ':' . implode(',:', array_keys($arr));
                $sql   = "INSERT INTO $this->table ($field) VALUES($val);";
                $stmt  = $this->db->prepare($sql);
                $stmt->execute($arr);
                return $stmt->rowCount();
            } catch (PDOException $e) {
                echo "ERROR : " . $e->getMessage();
                die();
            }
        }
    }

    public function update(array $arr)
    {
        if (isset($arr) && !is_null($arr)) {
            try {
                $k = '';
                foreach ($arr as $key => $value) {
                    $k .= $key . '=:' . $key . ',';
                }
                $val     = substr($k, 0, -1);
                $data    = array_merge($arr, $this->value);
                $where_f = ($this->where_field != '') ? " WHERE $this->where_field" : '';
                $sql     = "UPDATE $this->table SET $val $where_f";
                $stmt    = $this->db->prepare($sql);
                $stmt->execute($data);
                return $stmt->rowCount();
            } catch (PDOException $e) {
                echo "ERROR : " . $e->getMessage();
                die();
            }
        }
    }

    public function delete()
    {
        $where_f     = ($this->where_field != '') ? " WHERE $this->where_field" : '';
        $and_where_f = ($this->and_where_field != '') ?  " AND $this->and_where_field": '';
        $or_where_f  = ($this->or_where_field != '') ? " OR $this->or_where_field" : '';
        $sql         = "DELETE FROM $this->table $where_f $and_where_f $or_where_f";
        $stmt        = $this->db->prepare($sql);
        $stmt->execute($this->value);

        return $stmt->rowCount();
    }
}
