<?php
namespace app\models;

use Yii;
use yii\httpclient\Client;
use app\models\SqlCreator;

class API
{
    private static $client = null;
    private static $instance = null;
    private static $apiUrl = 'https://api.opendota.com/api/';

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new API();
            self::$client = new Client(['baseUrl' => self::$apiUrl]);
        }
        //return self::$client;
        return self::$instance;
    }

    public function sendRequest($url, $data = null, $method = 'POST')
    {
        $sql = $this->createSql('items'); // insert $data from args
        $currentUrl = str_replace([' ', '`'], '%20', $url.'?sql='.$sql);
        $response = self::$client->createRequest()
            ->setMethod($method)
            ->addHeaders(['content-type' => 'application/json'])
            //->setHeaders(['Content-Length' => '100000'])
            ->setUrl('https://api.opendota.com/api/explorer?sql=SELECT%20*%20FROM%20%20items%20')//$currentUrl)
            ->setData([])
            ->send();
        if ($response->isOK) {
            Yii::error($response->data);
            return $response->data;
        }
        Yii::error($currentUrl);
        return $response->getData();
    }

    public function createSql($table, $needed = '*', $method = 'SELECT', $whereStatement = null)
    {
        return (new SqlCreator($table, $needed, $method, $whereStatement))->getSql();
        //return $method.' '.$needed.' FROM '.$table.(!empty($whereStatement) ? 'WHERE '.$whereStatement['param'].'='.$whereStatement['value'] : '');
    }
}