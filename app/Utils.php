<?php

class Utils
{
    
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