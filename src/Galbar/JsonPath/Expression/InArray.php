<?php

namespace JsonPath\Expression;

class InArray
{
    private const SEPARATOR = ',';

    public static function evaluate(&$root, &$partial, $attribute, $listExpression)
    {
        $value = Value::evaluate($root, $partial, trim($attribute));
        $list = self::prepareList($root, $partial, $listExpression);

        return in_array($value, $list, true);
    }

    private static function prepareList(&$root, &$partial, string $expression)
    {
        if (strpos($expression, self::SEPARATOR) === false) {
            return [Value::evaluate($root, $partial, trim($expression))];
        }

        return array_map(
            fn ($value) => Value::evaluate($root, $partial, trim($value)),
            explode(self::SEPARATOR, $expression)
        );
    }
}

