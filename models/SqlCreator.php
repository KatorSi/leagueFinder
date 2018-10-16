<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

class SqlCreator
{
    protected $table;
    protected $needed;
    protected $method;
    protected $whereStatement;

    public function __construct($table, $needed, $method, $whereStatement)
    {
        $this->table = strtolower($table);
        $this->needed = strtolower($needed);
        $this->method = strtolower($method);
        $this->whereStatement = strtolower($whereStatement);
    }

    public function getSql()
    {
        $sql = new Query();
        $sqlMethod = $this->method;
        $command = $sql->$sqlMethod($this->needed)
            ->from($this->table)
            ->where($this->whereStatement)
            ->createCommand();
        return $command->sql;
    }
}