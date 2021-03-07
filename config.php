<?php

/**
 * General experiment configuration.
 */

define('TE_DATASET_FILENAME', 'dataset7.json');

/**
 * Some regular expressions for testing.
 */

/* General voltage */
define('REGEX_GENERAL_VOLTAGE', '/(2[2-3]{1}[0-9]{1})|240/');

/* General voltage, but only at string start */
define('REGEX_GENERAL_VOLTAGE_START', '/^((2[2-3]{1}[0-9]{1})|240)/');

/* Voltage, but only at string start and within tighter range, 225 to 233 */
define('REGEX_VOLTAGE_225_233', '/^(225|226|227|228|229|230|231|232|233)/');

/* Estimated power in dataset 7 */
define('REGEX_RAW_DATA_7_POWER', '/^(2090|2091|2092|2093|2094|2095|2096|2097|2098|2099|2100|2101|2102|2103|2104|2105|2106|2107|2108|2109|2110|2111|2112|2113|2114|2115|2116|2117|2118|2119|2120|2121|2122|2123|2124|2125|2126|2127|2128|2129|2130)/');

/**
 * Search experiment configuration.
 */

define('TE_SEARCH_ENABLE', true);
define('TE_SEARCH_REGEX', REGEX_RAW_DATA_7_POWER);
define('TE_SEARCH_MIN_LENGTH', 8);
define('TE_SEARCH_MAX_LENGTH', 63);

?>