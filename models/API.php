<?php
namespace app\models;

use Yii;
use yii\httpclient\Client;

class API extends Model
{
    private static $client = null;

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if (empty(self::$client)) {
            self::$client = new Client();
        }
        return self::$client;
    }

    public function sendRequest($url, $data = null, $method = 'POST')
    {
        $response = $this->createRequest()
            ->setMethod($method)
            ->setUrl($url)
            ->setData([])
    }

    public function createSql($table, $needed = '*', $method = 'SELECT', $whereStatement)
    {
        return $method.' '.$needed.' FROM '.$table.(!empty($whereStatement) ? 'WHERE '.$whereStatement['param'].'='.$whereStatement['value'] : '');
    }
}