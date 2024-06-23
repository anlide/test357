<?php

namespace Test357;

class Helpers {
    /**
     * Determines if the country is in the EU.
     *
     * @param string $countryCode The country code to check.
     * @return bool True if the country is in the EU, false otherwise.
     */
    public static function isEu(string $countryCode): bool {
        $euCountries = [
            'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES',
            'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU',
            'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'
        ];
        return in_array($countryCode, $euCountries);
    }
}
