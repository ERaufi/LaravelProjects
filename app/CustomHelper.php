<?php

// Format phone number to a specific format
if (!function_exists('formatPhoneNumber')) {
    /**
     * Format phone number to a specific format.
     *
     * @param string $phoneNumber The phone number to format.
     * @return string The formatted phone number.
     */
    function formatPhoneNumber($phoneNumber)
    {
        return '(' . substr($phoneNumber, 0, 3) . ') ' . substr($phoneNumber, 3, 3) . '-' . substr($phoneNumber, 6);
    }
}

// Generate a random string of specified length
if (!function_exists('generateRandomString')) {
    /**
     * Generate a random string of specified length.
     *
     * @param int $length The length of the random string.
     * @return string The generated random string.
     */
    function generateRandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
}

// Format a number as currency with a specified symbol and precision
if (!function_exists('formatCurrency')) {
    /**
     * Format a number as currency with a specified symbol and precision.
     *
     * @param float $amount The amount to format.
     * @param string $symbol The currency symbol.
     * @param int $precision The number of decimal places.
     * @return string The formatted currency string.
     */
    function formatCurrency($amount, $symbol = '$', $precision = 2)
    {
        return $symbol . number_format($amount, $precision);
    }
}

// Truncate a text to a specified length and append ellipsis
if (!function_exists('truncateText')) {
    /**
     * Truncate a text to a specified length and append ellipsis.
     *
     * @param string $text The text to truncate.
     * @param int $length The maximum length of the truncated text.
     * @param string $append The text to append if the text is truncated.
     * @return string The truncated text.
     */
    function truncateText($text, $length = 100, $append = '...')
    {
        return strlen($text) > $length ? substr($text, 0, $length) . $append : $text;
    }
}

// Format a date string to a specified format
if (!function_exists('formatDate')) {
    /**
     * Format a date string to a specified format.
     *
     * @param string $date The date string to format.
     * @param string $format The format to apply.
     * @return string The formatted date string.
     */
    function formatDate($date, $format = 'Y-m-d')
    {
        return date($format, strtotime($date));
    }
}

// Check if a string contains another string
if (!function_exists('containsString')) {
    /**
     * Check if a string contains another string.
     *
     * @param string $haystack The string to search in.
     * @param string $needle The string to search for.
     * @return bool True if the needle is found in the haystack, false otherwise.
     */
    function containsString($haystack, $needle)
    {
        return strpos($haystack, $needle) !== false;
    }
}

// Generate a unique code based on timestamp and random string
if (!function_exists('generateUniqueCode')) {
    /**
     * Generate a unique code based on timestamp and random string.
     *
     * @return string The generated unique code.
     */
    function generateUniqueCode()
    {
        return time() . '-' . generateRandomString(6);
    }
}

// Format bytes to human-readable format (KB, MB, GB, etc.)
if (!function_exists('formatBytes')) {
    /**
     * Format bytes to human-readable format (KB, MB, GB, etc.).
     *
     * @param int $bytes The number of bytes.
     * @param int $precision The number of decimal places.
     * @return string The formatted bytes string.
     */
    function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

// Convert minutes to hours and minutes format
if (!function_exists('convertMinutesToHoursMinutes')) {
    /**
     * Convert minutes to hours and minutes format.
     *
     * @param int $minutes The number of minutes.
     * @return string The formatted time string (HH:MM).
     */
    function convertMinutesToHoursMinutes($minutes)
    {
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        return sprintf("%02d:%02d", $hours, $remainingMinutes);
    }
}

// Calculate age from the provided date of birth
if (!function_exists('calculateAge')) {
    /**
     * Calculate age from the provided date of birth.
     *
     * @param string $dob The date of birth (YYYY-MM-DD).
     * @return int The calculated age.
     */
    function calculateAge($dob)
    {
        $dob = new DateTime($dob);
        $now = new DateTime();
        $age = $dob->diff($now);
        return $age->y;
    }
}

// Generate a random hexadecimal color code
if (!function_exists('generateRandomColorCode')) {
    /**
     * Generate a random hexadecimal color code.
     *
     * @return string The generated color code.
     */
    function generateRandomColorCode()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
}

// Format integer currency
if (!function_exists('formatIntegerCurrency')) {
    /**
     * Format an integer value as currency.
     *
     * @param int $amount The amount to format.
     * @return string The formatted currency string.
     */
    function formatIntegerCurrency($amount)
    {
        return '$' . number_format($amount, 2);
    }
}

// Format integer weight
if (!function_exists('formatIntegerWeight')) {
    /**
     * Format an integer value as weight.
     *
     * @param int $weight The weight value.
     * @return string The formatted weight string.
     */
    function formatIntegerWeight($weight)
    {
        return $weight . ' kg';
    }
}

// Generate image URL
if (!function_exists('generateImageUrl')) {
    /**
     * Generate a full URL for the image based on the provided image file name.
     *
     * @param string $imageName The image file name.
     * @return string The generated image URL.
     */
    function generateImageUrl($imageName)
    {
        return asset('images/' . $imageName);
    }
}

// Convert grams to kilograms
if (!function_exists('convertGramsToKilograms')) {
    /**
     * Convert grams to kilograms.
     *
     * @param int $grams The weight in grams.
     * @return float The weight in kilograms.
     */
    function convertGramsToKilograms($grams)
    {
        return $grams / 1000;
    }
}

// Convert kilograms to grams
if (!function_exists('convertKilogramsToGrams')) {
    /**
     * Convert kilograms to grams.
     *
     * @param float $kilograms The weight in kilograms.
     * @return int The weight in grams.
     */
    function convertKilogramsToGrams($kilograms)
    {
        return $kilograms * 1000;
    }
}


// Generate unique image name
if (!function_exists('generateUniqueImageName')) {
    /**
     * Generate a unique name for the uploaded image file.
     *
     * @param string $originalName The original name of the image file.
     * @return string The generated unique image name.
     */
    function generateUniqueImageName($originalName)
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return uniqid() . '.' . $extension;
    }
}

// Format description
if (!function_exists('formatDescription')) {
    /**
     * Format the description text (e.g., limit characters, add ellipsis).
     *
     * @param string $description The description text.
     * @param int $maxLength The maximum length of the description.
     * @param string $append The text to append if the description is truncated.
     * @return string The formatted description text.
     */
    function formatDescription($description, $maxLength = 100, $append = '...')
    {
        return strlen($description) > $maxLength ? substr($description, 0, $maxLength) . $append : $description;
    }
}

// Convert quantity to string
if (!function_exists('convertQuantityToString')) {
    /**
     * Convert quantity to a string representation (e.g., "10 items").
     *
     * @param int $quantity The quantity.
     * @return string The string representation of the quantity.
     */
    function convertQuantityToString($quantity)
    {
        return $quantity . ' items';
    }
}

// Format date for display
if (!function_exists('formatDateForDisplay')) {
    /**
     * Format the timestamp for display (e.g., "2022-01-01" to "January 1, 2022").
     *
     * @param string $date The date string.
     * @return string The formatted date for display.
     */
    function formatDateForDisplay($date)
    {
        return date('F j, Y', strtotime($date));
    }
}
