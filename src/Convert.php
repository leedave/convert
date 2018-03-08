<?php

namespace Leedch\Convert;

/**
 * Description of Convert
 * @author leed
 */
class Convert
{
    public static function alphanumeric(
        string $text, 
        bool $allowSpaces = true
    ) : string 
    {
        $repsonse = preg_replace("/[^a-zA-Z0-9 äàáąåçéèêēëàaÆæíìîīïñöôǫòõøßẞüûùúȳŷÄÀÁĄÅÇÉÈÊĒËÀAÆÆÍÌÎĪÏÑÖÔǪÒÕØSSẞÜÛÙÚȲŶ]+/", "", $text); 
        if (!$allowSpaces) {
            $repsonse = preg_replace("/[^a-zA-Z0-9äàáąåçéèêēëàaÆæíìîīïñöôǫòõøßẞüûùúȳŷÄÀÁĄÅÇÉÈÊĒËÀAÆÆÍÌÎĪÏÑÖÔǪÒÕØSSẞÜÛÙÚȲŶ]+/", "", $text); 
        }
        return $repsonse;
    }
    
    /**
     * Converts a string into a url friendly format
     * @param string $text
     * @return string
     */
    public static function slugify(string $text) : string 
    {
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
    public static function json_decode(string $json) : array
    {
        return json_decode($json, true);
    }
    
    /**
     * Just want to unify the way I encode json
     * @param array $arrData
     * @return string
     */
    public static function json_encode(array $arrData) : string
    {
        return json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * Takes URI Params (foo=bar&key=value) and makes an associative array 
     * out of them ["foo" => "bar", "key" => "value"]
     * @param string $uriParams
     * @return array
     */
    public static function uriParams2Array(string $uriParams) : array
    {
        $stringUriParams = str_replace("?", "", $uriParams);
        $arrSingleParams = explode("&", $stringUriParams);
        
        $arrReturn = [];
        
        foreach ($arrSingleParams as $param) {
            $arrParam = explode("=", $param);
            $key = $arrParam[0];
            $val = '';
            if (isset($arrParam[1])) {
                $val = $arrParam[1];
            }
            $arrReturn[urldecode($key)] = urldecode($val);
        }
        return $arrReturn;
    }
    
    /**
     * Turns an associative array into url parameters, also slugs entries
     * from ["foo" => "bar", "key" => "val"] to foo=bar&key=val
     * @param array $arrParams
     * @return string
     */
    public static function array2UriParams(array $arrParams) : string
    {
        $arrKeyVal = [];
        foreach ($arrParams as $key => $value) {
            $arrKeyVal[] = urlencode($key)."=".urlencode($value);
            //Not using slugify, want to be able to have php decode
        }
        $arrReturn = implode("&", $arrKeyVal);
        return $arrReturn;
    }
}
