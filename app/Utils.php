<?php

class Utils
{

    /*$regexVoltageAnyWhere = '/(2[2-3]{1}[0-9]{1})|240/';
    $regexVoltageStart = '/^((2[2-3]{1}[0-9]{1})|240)/';
    $regexVoltageStartMin = '/^(225|226|227|228|229|230|231|232|233)/'; // 225 to 233
    
    $rawData6AppI = '(9[5-6]{1}[0-9]{1})|970';
    $rawData6AppP = '195|196|197|198|199|200|201|202|203|204|205';
    $rawData6AppV = '225|226|227|228';
    $rawData6App = '/^(' . $rawData6AppV . ')/'; //' . $rawData6AppI . '|' . $rawData6AppP . '|*/
    
    public const REGEX_RAW_DATA_7_POWER = '/^(2090|2091|2092|2093|2094|2095|2096|2097|2098|2099|2100|2101|2102|2103|2104|2105|2106|2107|2108|2109|2110|2111|2112|2113|2114|2115|2116|2117|2118|2119|2120|2121|2122|2123|2124|2125|2126|2127|2128|2129|2130)/';

    public static function stringToBinaryA7($string): string
    {
        $string = base64_encode($string);

        $l = strlen($string);
        $result = '';

        while ($l--) {
            $result = str_pad(decbin(ord($string[$l])), 7, '0', STR_PAD_LEFT) . '' . $result;
        }

        return $result;
    }

    public static function stringToBinaryB7($string): string
    {
        $characters = str_split($string);
        $binary = [];

        foreach ($characters as $character) {
            $data = unpack('H*', $character);
            $binary[] = str_pad(base_convert($data[1], 16, 2), 7, '0', STR_PAD_LEFT);
        }
    
        return implode('', $binary);    
    }
}

?>