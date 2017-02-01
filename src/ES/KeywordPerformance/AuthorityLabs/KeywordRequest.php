<?php

namespace ES\KeywordPerformance\AuthorityLabs;

class KeywordRequest
{
    /** @var string */
    private $authToken;
    /** @var string */
    private $keyword;
    /** @var string */
    private $engine;
    /** @var string */
    private $locale;
    /** @var string */
    private $pagesFrom;
    /** @var string */
    private $callback;
    /** @var string */
    private $geo;
    /** @var string */
    private $mobile;

    public function __construct(
        string $authToken,
        string $keyword,
        string $callback,
        string $engine = 'bing',
        string $locale = '',
        string $pagesFrom = '',
        string $geo = '',
        string $mobile = ''
    ) {
        $this->authToken = $authToken;
        $this->keyword = $keyword;
        $this->callback = $callback;
        $this->engine = $engine;
        $this->locale = $locale;
        $this->pagesFrom = $pagesFrom;
        $this->geo = $geo;
        $this->mobile = $mobile;
    }

    /**
     * @return array
     */
    public function getAsArray(): array
    {
        return [
            'auth_token' => $this->authToken,
            'keyword' => $this->keyword,
            'engine' => $this->engine,
            'locale' => $this->locale,
            'pages_from' => $this->pagesFrom,
            'callback' => $this->callback,
            'geo' => $this->geo,
            'mobile' => $this->mobile,
        ];
    }
}
