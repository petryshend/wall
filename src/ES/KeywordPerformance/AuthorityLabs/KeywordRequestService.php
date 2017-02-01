<?php

namespace ES\KeywordPerformance\AuthorityLabs;

use GuzzleHttp\Client;

class KeywordRequestService
{
    /** @var Client */
    private $httpClient;
    /** @var string */
    private $delayedQueueUrl;
    /** @var  string */
    private $immediateQueueUrl;

    public function __construct(string $delayedQueueUrl, string $immediateQueueUrl)
    {
        $this->delayedQueueUrl = $delayedQueueUrl;
        $this->immediateQueueUrl = $immediateQueueUrl;
        $this->httpClient = new Client();
    }

    public function makeDelayedRequest(KeywordRequest $keywordRequest)
    {
        $this->makeKeywordRequest($keywordRequest, $this->delayedQueueUrl);
    }

    public function makeImmediateRequest(KeywordRequest $keywordRequest)
    {
        $this->makeKeywordRequest($keywordRequest, $this->immediateQueueUrl);
    }

    private function makeKeywordRequest(KeywordRequest $keywordRequest, string $queueUrl)
    {
        $result = $this->httpClient->request(
            'POST',
            $queueUrl,
            [
               'form_params' => $keywordRequest->getAsArray(),
            ]
        );

        dump($result->getStatusCode());
    }
}
