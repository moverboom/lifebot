<?php
/**
 * Created by PhpStorm.
 * User: matthijs
 * Date: 14-11-17
 * Time: 20:02
 */

namespace AppBundle\Services;

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
     * HaveIBeenPwnd constructor.
     * @param $baseUrl
     * @param $version
     * @param $userAgent
     * @param $guzzle
     */
    public function __construct($baseUrl, $version, $userAgent, $guzzle)
    {
        $this->baseUrl = $baseUrl;
        $this->version = $version;
        $this->userAgent = $userAgent;
        $this->guzzle = $guzzle;
    }

    /**
     * Get account breaches
     * @param array $accounts
     */
    public function getAccountBreaches(array $accounts)
    {
        $reponse = [];
        foreach ($accounts as $account) {
            $guzzleResponse = $this->send($this->breachedAccount . '/' . $account);
            if($guzzleResponse == null) {
                continue;
            }
            $reponse[] = json_decode($guzzleResponse->getBody()->getContents());
        }
        var_dump($reponse);die;
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
        $endpoint = $this->baseUrl . $this->version . $endpoint;
        return $this->guzzle->executeRequest(GuzzleWrapper::$GET, $endpoint, $data, ['User-Agent' => $this->userAgent]);
    }
}