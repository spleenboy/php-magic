<?php

namespace AxeBear\Magic\Support\Types;

class BuiltinConverter implements ConvertsType
{
    public static array $supported = [
        'bool',
        'boolean',
        'int',
        'integer',
        'float',
        'double',
        'string',
        'array',
        'object',
        'null',
    ];

    public static function supports(string $type): bool
    {
        return in_array($type, self::$supported);
    }

    public static function convert(string $type, mixed $value): mixed
    {
        if (! settype($value, $type)) {
            throw new \InvalidArgumentException("Value cannot covert to {$type} type.");
        }

        return $value;
    }
}
