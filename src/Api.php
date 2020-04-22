<?php

declare(strict_types=1);

namespace Tomaj\NetteApi;

use Tomaj\NetteApi\Authorization\ApiAuthorizationInterface;
use Tomaj\NetteApi\Handlers\ApiHandlerInterface;
use Tomaj\NetteApi\RateLimit\NoRateLimit;
use Tomaj\NetteApi\RateLimit\RateLimitInterface;

class Api
{
    private $endpoint;

    private $handler;

    private $authorization;

    private $rateLimit;

    public function __construct(
        EndpointInterface $endpoint,
        ApiHandlerInterface $handler,
        ApiAuthorizationInterface $authorization,
        ?RateLimitInterface $rateLimit = null
    ) {
        $this->endpoint = $endpoint;
        $this->handler = $handler;
        $this->authorization = $authorization;
        $this->rateLimit = $rateLimit ?: new NoRateLimit();
    }

    public function getEndpoint(): EndpointInterface
    {
        return $this->endpoint;
    }

    public function getHandler(): ApiHandlerInterface
    {
        return $this->handler;
    }

    public function getAuthorization(): ApiAuthorizationInterface
    {
        return $this->authorization;
    }

    public function getRateLimit(): RateLimitInterface
    {
        return $this->rateLimit;
    }
}
