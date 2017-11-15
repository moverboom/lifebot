<?php
/**
 * Created by PhpStorm.
 * User: matthijs
 * Date: 14-11-17
 * Time: 20:02
 */

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\AccountBreach;

class HaveIBeenPwnd
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $version;

    /**
     * @var GuzzleWrapper
     */
    private $guzzle;

    /**
     * @var string
     */
    private $userAgent;

    /**
     * @var string
     */
    private $breachedAccount = '/breachedaccount';

    /**
     * @var float time in milliseconds when last request was send
     * Haveibeenpwnd API requires a 1500ms delay between requests
     */
    private $lastRequestSendAt;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * HaveIBeenPwnd constructor.
     * @param $baseUrl
     * @param $version
     * @param $userAgent
     * @param $guzzle
     * @param $em
     */
    public function __construct($baseUrl, $version, $userAgent, $guzzle, $em)
    {
        $this->baseUrl = $baseUrl;
        $this->version = $version;
        $this->userAgent = $userAgent;
        $this->guzzle = $guzzle;
        $this->em = $em;
    }

    /**
     * Get account breaches
     * @param array $accounts
     */
    public function getAccountBreaches(array $accounts)
    {
        foreach ($accounts as $account) {
            $guzzleResponse = $this->send($this->breachedAccount . '/' . $account);
            if($guzzleResponse == null) {
                continue;
            }
            $this->parseArrayToEntity(json_decode($guzzleResponse->getBody()->getContents()), $account);
        }
    }

    /**
     * Create new entity from array data and persist
     *
     * @param array $data
     * @param $account
     */
    private function parseArrayToEntity(array $data, $account)
    {
        foreach ($data as $breach) {
            $accountBreach = new AccountBreach();
            $accountBreach->setUsername($account);
            $accountBreach->setBreachDate(\DateTime::createFromFormat('Y-m-d', $breach->BreachDate));
            $accountBreach->setBreachedSite($breach->Title);
            $accountBreach->setBreachVerified($breach->IsVerified);
            $accountBreach->setBreachedData(join("/", $breach->DataClasses));
            $this->em->persist($accountBreach);
        }
        $this->em->flush();
    }

    /**
     * Send a request to haveibeenpwnd.com
     *
     * @param $endpoint
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    private function send($endpoint, array $data = [])
    {
        if($this->lastRequestSendAt) {
            sleep(2);
        }

        $endpoint = $this->baseUrl . $this->version . $endpoint;
        $this->lastRequestSendAt = time();
        return $this->guzzle->executeRequest(GuzzleWrapper::$GET, $endpoint, $data, ['User-Agent' => $this->userAgent]);
    }
}