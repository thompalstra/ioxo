<?php
namespace io\web;

class Url{

    public function __construct($args = []){
        foreach($args as $k => $v){
            $this->$k = $v;
        }
    }

    public static function to($url, $parameters = []){
        $q = http_build_query($parameters);
        return $url . (!empty($q) ? '?' . $q : '' );
    }

    public static function matches($match, $route, $url){
        if($url == $match){
            return $route;
        } else {
            $explode = explode('/', $match);
            $originExplode = explode('/', $url);

            $length = count($explode);
            $matchCount = 0;
            $matchLength = count($originExplode);
            $c = 0;
            $arguments = [];

            if($length == $matchLength){
                foreach($explode as $ex){
                    if(strpos($ex, ':') > -1){
                        $innerExplode = explode(':', $ex);
                        $expression = substr($innerExplode[1], 0, strlen($innerExplode[1]) -1);
                        $variable = substr($innerExplode[0], 1, strlen($innerExplode[0]));

                        preg_match_all("/$expression/", $originExplode[$c], $output_array);
                        if(isset($output_array[0]) && isset($output_array[0][0])){
                            $match = $output_array[0][0];
                            $arguments[$variable] = $match;
                            $matchCount++;
                        }

                    } else {
                        if($originExplode[$c] == $ex){
                            $matchCount++;
                        }
                    }
                    $c++;
                }

                if($length == $matchCount){
                    $_GET = $_GET + $arguments;
                    return $route;
                }
            }


        }

        return false;
    }

    public static function parseRequest($url){



        return false;
    }
}
?>
