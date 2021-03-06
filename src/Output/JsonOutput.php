<?php

declare(strict_types=1);

namespace Tomaj\NetteApi\Output;

use Tomaj\NetteApi\Response\JsonApiResponse;
use Tomaj\NetteApi\Response\ResponseInterface;
use Tomaj\NetteApi\Validation\JsonSchemaValidator;
use Tomaj\NetteApi\ValidationResult\ValidationResult;
use Tomaj\NetteApi\ValidationResult\ValidationResultInterface;

class JsonOutput implements OutputInterface
{
    private $code;

    private $schema;

    public function __construct(int $code, $schema)
    {
        $this->code = $code;
        $this->schema = $schema;
    }

    public function validate(ResponseInterface $response): ValidationResultInterface
    {
        if (!$response instanceof JsonApiResponse) {
            return new ValidationResult(ValidationResult::STATUS_ERROR);
        }
        if ($this->code !== $response->getCode()) {
            return new ValidationResult(ValidationResult::STATUS_ERROR, ['Response code doesn\'t match']);
        }

        $value = json_decode(json_encode($response->getPayload()));

        $schemaValidator = new JsonSchemaValidator();
        return $schemaValidator->validate($value, $this->schema);
    }
}
