<?php

function idr($value, $prefix = true)
{
    if (!is_numeric($value)) {
        return $value;
    }

    $formatted = number_format((float) $value, 0, ',', '.');

    return $prefix ? $formatted : $formatted;
}
