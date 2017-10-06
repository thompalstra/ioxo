<?php
namespace io\helpers;

class Html{

    public $options = [];

    public static function a($label, $url, $options){
        $options['href'] = $url;
        $options = self::attributes($options);

        return "<a $options>$label</a>";
    }

    public static function textInput($name, $value = null, $options = []){
        $options['name'] = $name;
        $options['value'] = $value;
        $options['type'] = 'text';

        $options = self::attributes($options);

        return "<input $options/>";
    }

    public static function hiddenInput($name, $value = null, $options = []){
        $options['name'] = $name;
        $options['value'] = $value;
        $options['type'] = 'hidden';

        $options = self::attributes($options);

        return "<input $options/>";
    }

    public static function passwordInput($name, $value = null, $options = []){
        $options['name'] = $name;
        $options['value'] = $value;
        $options['type'] = 'password';

        $options = self::attributes($options);

        return "<input $options/>";
    }

    public static function button($text, $options = []){
        $options = self::attributes($options);
        return "<button $options>$text</button>";
    }

    public static function attributes($options = []){
        $out = [];

        foreach($options as $k => $v){
            if(is_array($v)){
                $out[] = "$k='" . self::arrayAttributes($v) . "'";
            } else {
                $out[] = "$k='$v'";
            }
        }
        return implode(' ', $out);
    }
    public static function arrayAttributes($options = []){
        $out = [];

        foreach($options as $k => $v){
            $out[] = "$k: $v";
        }

        return implode('; ',$out);
    }

    public static function mergeAttributes($new, $original){
        $opt = [];

        foreach($original as $k => $v){ $opt[$k] = $v; }

        foreach($new as $k => $v){
            if(isset($original[$k])){
                if(is_array($v)){
                    $opt[$k] = self::mergeAttributes($new[$k], $original[$k]);
                } else {
                    $l = [];
                    $l[] = $opt[$k];
                    $l[] = $v;
                    $opt[$k] = implode(' ', $l);
                }
            } else {
                $opt[$k] = $v;
            }
        }
        return $opt;
    }
}
?>
