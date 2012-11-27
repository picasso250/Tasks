<?php

/**
 * @author ryan
 */

class Model 
{
    protected $id = null;
    protected $info = null;
    
    public function __construct($para) 
    {
        if (is_array($para) && isset($para['id'])) {
            $this->id = $para['id'];
            $this->info = $para;
        } elseif (is_numeric($para)) {
            $this->id = $para;
        } else {
            d($para);
            throw new Exception("not good arg for construct");
        }
    }

    public static function create($info = array())
    {
        $self = get_called_class();
        Pdb::insert($info, $self::$table);
        return new self(Pdb::lastInsertId());
    }

    public static function read($conds = array())
    {
        list($tables, $conds) = self::buildDbArg($conds);
        $self = get_called_class();
        return Pdb::fetchAll('*', $tables, $conds);
    }

    protected function info() // this will happen?
    {
        $self = get_called_class();
        $ret = Pdb::fetchRow('*', $self::$table, $this->selfCond());
        if (empty($ret))
            throw new Exception(get_called_class() . " no id: $this->id");
        return $ret;
    }

    public function exists()
    {
        $self = get_called_class();
        return Pdb::exists($self::$table, $this->selfCond());
    }

    public function selfCond() 
    {
        return array('id=?' => $this->id);
    }

    // 废弃 or just another name, better name
    public function edit($key_or_array, $value = null)
    {
        $this->update($key_or_array, $value);
    }

    // function same as edit()
    public function update($key_or_array, $value = null)
    {
        if($value !== null) { // given by key => value
            $arr = array($key_or_array => $value);
        } else {
            $arr = $key_or_array;
        }

        $self = get_called_class();
        Pdb::update($arr, $self::$table, $this->selfCond()); // why we need that? that doesn't make any sense
        $this->info = $this->info(); // refresh data
    }

    public function __get($name) 
    {
        if ($name === 'id') return $this->id;
        if (empty($this->info)) {
            $this->info = $this->info();
        }
        $info = $this->info;
        if (is_bool($info)) {
            d($info);
        }
        if (!array_key_exists($name, $this->info)) {
            d($this->info);
            throw new Exception("no $name when get in class " . get_called_class());
        }
        return $this->info[$name];
    }

    protected static function defaultConds($conds = array()) 
    {
        return array_merge(array(
            'limit' => 10,
            'offset' => 0,
        ), $conds);
    }
}
