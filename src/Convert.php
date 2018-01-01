<?php

namespace Leedch\Convert;

/**
 * Description of Convert
 * @author leed
 */
class Convert
{
    /**
     * Converts a string into a url friendly format
     * @param string $text
     * @return string
     */
    public static function slugify(string $text) {
        $lowerText = strtolower($text);
        $arrTransform = [
            "ä" => "ae",
            "à" => "a",
            "á" => "a",
            "ą" => "a",
            "â" => "a",
            "å" => "a",
            "Æ" => "ae",
            "æ" => "ae",
            "ç" => "c",
            "é" => "e",
            "è" => "e",
            "ê" => "e",
            "ē" => "e",
            "ë" => "e",
            "í" => "i",
            "ì" => "i",
            "î" => "i",
            "ī" => "i",
            "ï" => "i",
            "ñ" => "n",
            "ö" => "oe",
            "ô" => "o",
            "ô" => "o",
            "ǫ" => "o",
            "ò" => "o",
            "õ" => "o",
            "ø" => "o",
            "ẞ" => "ss",
            "ß" => "ss",
            "ü" => "ue",
            "û" => "ue",
            "ù" => "ue",
            "ú" => "ue",
            "ȳ" => "y",
            "ŷ" => "y",
            "ŷ" => "y",
        ];
        
        foreach ($arrTransform as $key => $val) {
            $lowerText = str_replace($key, $val, $lowerText);
        }
        
        //Final check, just make sure no special chars and replace all other chars with minus
        $slug = (string) preg_replace('/[^a-z0-9-]+/', '-', $lowerText);
        return $slug;
    }
    
    /**
     * Simple wrapper function, to unify the way i decode json
     * Converts into associative ($key => $value) type array
     * @param string $json
     * @return array
     */
    public static function json_decode(string $json)
    {
        return json_decode($json, true);
    }
    
    /**
     * Just want to unify the way I encode json
     * @param array $arrData
     * @return string
     */
    public static function json_encode(array $arrData)
    {
        return json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }
}
