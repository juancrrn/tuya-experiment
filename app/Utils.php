<?php

class Utils
{
    
    public static function stringToBinaryA7(string $string): string
    {
        $l = strlen($string);
        $result = '';

        while ($l--) {
            $result = str_pad(decbin(ord($string[$l])), 7, '0', STR_PAD_LEFT) . '' . $result;
        }

        return $result;
    }

    public static function stringToBinaryB7(string $string): string
    {
        $characters = str_split($string);
        $binary = [];

        foreach ($characters as $character) {
            $data = unpack('H*', $character);
            $binary[] = str_pad(base_convert($data[1], 16, 2), 7, '0', STR_PAD_LEFT);
        }
    
        return implode('', $binary);    
    }

    public static function stringToBinaryC(string $string): string
    {
        /**
         * 1. Ensure that the string is UTF-8-encoded.
         * 
         * 2. Convert each character of the string to a number between 0 and
         * 255 (format code 'C' with repeater argument '*'). This is an
         * interpretation of the character as an unsigned integer in that
         * range. Other formats are available at the PHP Manual:
         *
         * https://www.php.net/manual/en/function.pack.php
         * 
         * The result of unpack() is an array containing the representations
         * of all the characters. E. g., for 'COEAA8MAAMo=':
         * 
         * [67, 79, 69, 65, 65, 56, 77, 65, 65, 77, 111, 61]
         */
        $byteArray = unpack('C*', utf8_encode($string));

        /**
         * 3. Prepare a variable to store the concatenated string.
         */
        $result = '';

        /**
         * 4. Loop through each representation.
         */
        foreach ($byteArray as $byte) {
            /**
             * 5. Convert the representation from 0 to 255, to a pure binary
             * representation.
             * 
             * 6. As 8 bits are needed to represent the range 0 to 255, pad
             * the binary representation with leading 0s.
             * 
             * 7. Add the representation to the result string.
             */
            $result .= str_pad(decbin($byte), 8, '0', STR_PAD_LEFT);
        }

        return $result;   
    }
}

?>