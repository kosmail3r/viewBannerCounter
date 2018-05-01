<?php

namespace Classes;

class Visitor
{
    private $ip;
    private $userAgent;
    private $viewDate;
    private $url;
    private $dbInstance;

    public function __construct($ip, $userAgent, $viewDate, $url, $dbInstance)
    {
        $this->ip = $ip;
        $this->userAgent = $userAgent;
        $this->viewDate = $viewDate;
        $this->url = $url;
        $this->dbInstance = $dbInstance;
    }

    /**
     * Method which fix view action
     */
    public function entry()
    {
        $visitorRow = $this->checkIfVisitorExist($this->ip, $this->userAgent, $this->url);
        if (!is_array($visitorRow)) {
            $this->createNewVisitor($this->ip, $this->userAgent, $this->url, $this->viewDate);
        } else {
            $id = (int)$visitorRow['id'];
            $lastCount = (int)$visitorRow['views_count'];

            $this->updateVisitor($id, $lastCount, $this->viewDate);
        }
    }

    /**
     * @param $ip
     * @param $userAgent
     * @param $url
     * Method which check for viewing by this client in past
     * @return mixed
     */
    private function checkIfVisitorExist($ip, $userAgent, $url)
    {
        $result = $this->dbInstance->getRowIfExist("SELECT * FROM visitors WHERE ip_address='$ip' AND user_agent='$userAgent' AND page_url='$url' LIMIT 1", \PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * @param $ip
     * @param $userAgent
     * @param $url
     * Method which fix info about new visitor
     * @param $viewDate
     */
    private function createNewVisitor($ip, $userAgent, $url, $viewDate)
    {
        $sql = "INSERT INTO visitors (ip_address, user_agent, view_date, page_url, views_count) 
                VALUES ('" . $ip . "', '" . $userAgent . "', '" . $viewDate . "', '" . $url . "', '1')";
        $this->dbInstance->query($sql);
    }

    /**
     * @param $id
     * @param $lastCount
     * Method which fix info about existing visitor
     * @param $viewDate
     */
    private function updateVisitor($id, $lastCount, $viewDate)
    {
        $newCount = ++$lastCount;
        $sql = "UPDATE visitors SET views_count='" . $newCount . "', view_date='" . $viewDate . "'  WHERE id='" . $id . "'";

        $this->dbInstance->query($sql);
    }
}