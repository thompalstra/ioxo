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

    public static function input($name, $value = null, $options = []){
        $options = self::attributes($options + ['name' => $name, 'value' => $value]);
        return "<input $options/>";
    }
    public static function iconInput($icon, $name, $value = null, $options = []){
        $labelOptions = [
            'for' => (isset($options['id']) ? $options['id'] : ''),
            'class' => 'icon-label'
        ];
        $options = self::attributes($options + ['name' => $name, 'value' => $value]);
        $labelOptions = self::attributes($labelOptions);
        return "<label $labelOptions><input $options/>$icon</label>";
    }
    public static function select($name, $value = null, $items = [], $options = []){
        $options = self::attributes($options + ['name' => $name]);
        $out = "<select $options>";
        foreach($items as $k => $v){
            $selected = '';
            if($value){
                if(is_array($value) && (array_search($k, $value) !== false)){
                    $selected = 'selected';
                } else if($value == $k) {
                    $selected = 'selected';
                }
            }
            $out .= "<option value='$k' $selected>$v</option>";
        }

        $out .= "</select>";

        return $out;
    }
    public static function datalist($id, $items = [], $options = []){
        $options['id'] = $id;
        $options = Html::attributes($options);
        $out = "<datalist $options>";
        foreach($items as $item){
            $out .= "<option value='$item'></option>";
        }
        $out .= "</datalist>";

        return $out;
    }
    public static function dropdown($name, $value = null, $items = [], $options = []){
        $options['name'] = $name;
        $options = Html::attributes($options);
        $out = "<select $options>";
        foreach($items as $k => $item){
            $selected = ($k === $value) ? 'selected' : '';
            $out .= "<option value='$k'>$item</option>";
        }
        $out .= "</select>";

        return $out;
    }

    public static function textarea($name, $value = null, $options = []){
        $options['name'] = $name;
        $options = Html::attributes($options);
        $out = "<textarea $options>$value</textarea>";
        return $out;
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
                $v = self::sanitizeValue($v);

                $out[] = "$k='$v'";
            }
        }
        return implode(' ', $out);
    }
    public static function arrayAttributes($options = []){
        $out = [];

        foreach($options as $k => $v){

            $v = self::sanitizeValue($v);

            $out[] = "$k: $v";
        }

        return implode('; ',$out);
    }

    public static function mergeAttributes($original, $new){
        $opt = [];

        foreach($original as $k => $v){

            $v = self::sanitizeValue($v);

            $opt[$k] = $v;
        }

        foreach($new as $k => $v){
            if(isset($original[$k])){
                if(is_array($v)){
                    $opt[$k] = self::mergeAttributes($new[$k], $original[$k]);
                } else {
                    $l = [];
                    $l[] = $opt[$k];

                    $v = self::sanitizeValue($v);

                    $l[] = $v;
                    $opt[$k] = implode(' ', $l);
                }
            } else {

                $v = self::sanitizeValue($v);

                $opt[$k] = $v;
            }
        }
        return $opt;
    }

    public static function sanitizeValue($v){
        if(is_bool($v)){
            return ($v == true) ? 'true' : 'false';
        }

        return $v;
    }
}
?>
