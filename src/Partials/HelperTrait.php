<?php

namespace Barqdev\Autocrud\Partials;

trait HelperTrait
{
    public function currencyToInt($value, $request = null)
    {
        if (is_array($value)) {
            $request = $request ?? request();
            foreach ($value as $key => $val) {
                if ($request[$val] ?? false)
                    $request[$val] = str_replace([','], '', $request[$val]);
            }
            return $request;
        }
        return str_replace([','], '', $value);
    }
}
