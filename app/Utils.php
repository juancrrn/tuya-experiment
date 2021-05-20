<?php

class Utils
{

    public static function stringToBinary(string $string): string
    {
        return self::stringToBinaryC($string, true);
    }
    
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

    public static function stringToBinaryC(string $string, bool $base64_decode): string
    {
        /**
         * 1. Convert each character of the string to a number between 0 and
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
         * 
         * 1.1. If $base64_decode is true, pre-decode the string.
         */
        if ($base64_decode) {
            $byteArray = unpack('C*', base64_decode($string));
        } else {
            $byteArray = unpack('C*', $string);
        }

        /**
         * 2. Prepare a variable to store the concatenated string.
         */
        $result = '';

        /**
         * 3. Loop through each representation.
         */
        foreach ($byteArray as $byte) {
            /**
             * 4. Convert the representation from 0 to 255, to a pure binary
             * representation.
             * 
             * 5. As 8 bits are needed to represent the range 0 to 255, pad
             * the binary representation with leading 0s.
             * 
             * 6. Add the representation to the result string.
             */
            $result .= str_pad(decbin($byte), 8, '0', STR_PAD_LEFT);
        }

        return $result;   
    }

    private static function decimalPad(float $number, int $zeros): string
    {
        $parts = explode('.', $number);

        if (count($parts) == 1) {
            $string = $number . '.';

            for ($i = 0; $i < $zeros; $i++) {
                $string .= '0';
            }
            
            return $string;
        } elseif (count($parts) == 2) {
            $string = $parts[0] . '.' . $parts[1];

            for ($i = 0; $i < $zeros - strlen($parts[1]); $i++) {
                $string .= '0';
            }
            
            return $string;
        } else {
            throw new InvalidArgumentException();
        }
        //$intPart = floor($number);
        //$decPart = $number - $intPart;
    }

    public static function finalRawToInfoDecode(string $string): string
    {
        $binaryString = self::stringToBinaryC($string, true);

        $dataVoltage = self::decimalPad(bindec(substr($binaryString, 0, 16)) / 10, 1);
        $dataCurrent = self::decimalPad(bindec(substr($binaryString, 16, 24)) / 1000, 3);
        $dataPower = self::decimalPad(bindec(substr($binaryString, 40, 24)) / 1000, 3);

        return <<< HTML
        <div class="data-voltage"><span class="letter">V</span><span class="value">$dataVoltage V</span></div>
        <div class="data-current"><span class="letter">I</span><span class="value">$dataCurrent A</span></div>
        <div class="data-power"><span class="letter">P</span><span class="value">$dataPower kW</span></div>
        HTML;
    }
}

?>