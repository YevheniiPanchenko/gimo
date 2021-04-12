<?php

namespace Src\Traits;

trait Validation
{
    public function validate($input, $rules): array
    {
        $err = [];

        foreach ($rules as $key => $options) {
            if (in_array('required', $options) && !isset($input[$key]) ) {
                $err[$key]['required'] =  'field is required';
            }
            if (array_key_exists('min', $options) && strlen($input[$key]) < $options['min']) {
                $err[$key]['min'] =  'length should be more then ' . $options['min'];
            }
            if (array_key_exists('max', $options) && strlen($input[$key]) > $options['max']) {
                $err[$key]['max'] =  'length should be less then ' . $options['max'];
            }
            if (in_array('year', $options) && isset($input[$key])) {
                if ((int) $input[$key] <= 1000 || (int) $input[$key] > 9999) {
                    $err[$key]['year'] =  'should be a valid year';
                }
            }
            if (in_array('string', $options) && !is_string($input[$key])) {
                $err[$key]['string'] =  'field should be a string';
            }
            if (in_array('int', $options) && !is_int($input[$key])) {
                $err[$key]['int'] =  'field should be an integer';
            }
        }

        return $err;
    }
}