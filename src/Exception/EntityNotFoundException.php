<?php

declare(strict_types=1);

namespace Linio\Common\Exception;

use Throwable;

class EntityNotFoundException extends ClientException
{
    public const DEFAULT_STATUS_CODE = 404;

    /**
     * @param string $entity The entity that could not be found, for example "Telesales Agent"
     * @param string|array $identifier The id of the entity that could not be found.
     *                                 For example "test@example.com" or
     *                                 ['region' => 'Region 1', 'municipality' => 'Municipality 1']
     */
    public function __construct(
        string $entity,
        $identifier,
        string $token = ExceptionTokens::ENTITY_NOT_FOUND,
        int $statusCode = self::DEFAULT_STATUS_CODE,
        array $errors = [],
        Throwable $previous = null
    ) {
        $formattedIdentifier = $this->getIdentifier($identifier);
        $message = sprintf('Could not find [%s] identified by %s!', $entity, $formattedIdentifier);

        parent::__construct($token, $statusCode, $message, $errors, $previous);
    }

    /**
     * @param array|string $identifiers
     */
    protected function getIdentifier($identifiers): string
    {
        if (is_array($identifiers)) {
            return implode(', ', array_map(function (string $value, string $key) {
                return sprintf('[%s] = [%s]', $key, $value);
            }, $identifiers, array_keys($identifiers)));
        }

        return sprintf('[%s]', $identifiers);
    }
}
