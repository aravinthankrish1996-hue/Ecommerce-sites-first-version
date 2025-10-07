<?php

use Carbon\Carbon;;

if (!function_exists('prx')) {
    /**
     * Dumps a variable and dies. Useful for debugging.
     *
     * @param mixed $arr The variable to dump.
     * @return void
     */
    function prx($arr)
    {
        echo "<pre>";
        print_r($arr);
        die();
    }

    function replaceStr($str)
    {
        // Return empty string if input is null or empty
        if (empty($str)) {
            return '';
        }

        // Remove square brackets and their contents
        $string = str_replace(array('[', ']'), '', $str);

        // Remove anything within square brackets (if any remain)
        $string = preg_replace('/\[.*?\]/u', '', $string);

        // Replace HTML entities and special characters
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);

        // Convert to HTML entities
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');

        // Replace accented characters with hyphens
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig)/i', '-', $string);

        // Replace non-alphanumeric characters with hyphens
        $string = preg_replace('/[^a-z0-9]+/i', '-', $string);

        // Replace multiple consecutive hyphens with single hyphen
        $string = preg_replace('/-+/', '-', $string);

        // Convert to lowercase and trim hyphens from start and end
        $string = strtolower(trim($string, '-'));

        return $string;
    }

    /**
     * Alternative, more robust slug generation function
     * 
     * @param string $str The input string to convert
     * @return string The converted slug
     */
    function createSlug($str)
    {
        if (empty($str)) {
            return '';
        }

        // Convert to lowercase
        $slug = strtolower($str);

        // Replace common accented characters
        $accents = array(
            'à' => 'a',
            'á' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'ä' => 'a',
            'å' => 'a',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ò' => 'o',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'û' => 'u',
            'ü' => 'u',
            'ý' => 'y',
            'ÿ' => 'y',
            'ñ' => 'n',
            'ç' => 'c'
        );

        $slug = str_replace(array_keys($accents), array_values($accents), $slug);

        // Remove HTML tags
        $slug = strip_tags($slug);

        // Replace non-alphanumeric characters with hyphens
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);

        // Remove multiple consecutive hyphens
        $slug = preg_replace('/-+/', '-', $slug);

        // Trim hyphens from start and end
        $slug = trim($slug, '-');

        return $slug;
    }

    // You can use either function - replaceStr (fixed version) or createSlug (alternative)

    function checkTokenExpiryInMinutes($time, $timeDiff = 60)
    {
        // prx($time);
        $data = Carbon::parse($time->format('Y-m-d h:i:s a'));
        $now = Carbon::now();

        $diff = $data->diffInMinutes($now);

        if ($diff > $timeDiff) {
            return true;
        } else {
            return false;
        }
    }
    function generateRandomString($length = 20)
    {
        $ch = '0123456789abcdefghijklmnopqrstwxyzABCDEFGHIJKLMNOPQRSTWXYZ';
        $len = strlen($ch);
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $ch[random_int(0, $len - 1)];
        }
        return $str;
    }
}
