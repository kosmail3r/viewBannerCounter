<?php

namespace Classes;

class VisitLogger
{
    private $dbInstance;
    private $params;
    private static $instance;

    public static function newVisit()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        self::$instance->saveVisit();
        return self::$instance;
    }

    private function __construct()
    {
        $this->dbInstance = DB::getInstance();
    }

    private function __clone()
    {
    }

    /**
     * Method which collect info about visitor
     */
    private function prepareAccessData()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $url = $_SERVER['HTTP_REFERER'];
        $ip = $_SERVER['REMOTE_ADDR'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['HTTP_CLIENT_IP'];

        $this->params = compact('userAgent', 'ip', 'url');
    }

    /**
     * Method which process data about client to visitor processor
     */
    public function saveVisit()
    {
        $this->prepareAccessData();
        $params = $this->params;
        $date = date("Y-m-d H:i:s", strtotime("now"));
        $visitor = new Visitor($params['ip'], $params['userAgent'], $date, $params['url'], $this->dbInstance);
        $visitor->entry();
    }
}