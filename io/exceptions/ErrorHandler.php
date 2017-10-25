<?php
namespace io\exceptions;

class ErrorHandler{
    public function handle( $err_severity, $err_msg, $err_file, $err_line, array $err_context ){
            if (0 === error_reporting()) { return false;}
            switch($err_severity)
            {
                case E_ERROR:               throw new \Exception  ($err_msg, 0, $err_severity, $err_file, $err_line);
                case E_WARNING:             throw new \io\exceptions\HttpNotFoundException  ($err_msg, 0, $err_severity, $err_file, $err_line);
                case E_PARSE:               throw new \Exception  ($err_msg, 0, $err_severity, $err_file, $err_line);
                case E_NOTICE:              throw new \ErrorException  ($err_msg, 0, $err_severity, $err_file, $err_line);
                case E_CORE_ERROR:          throw new \Exception  ($err_msg, 0, $err_severity, $err_file, $err_line);
                case E_CORE_WARNING:        throw new \Exception  ($err_msg, 0, $err_severity, $err_file, $err_line);
                case E_COMPILE_ERROR:       throw new \Exception  ($err_msg, 0, $err_severity, $err_file, $err_line);
                case E_COMPILE_WARNING:     throw new \Exception  ($err_msg, 0, $err_severity, $err_file, $err_line);
                case E_USER_ERROR:          throw new \Exception  ($err_msg, 0, $err_severity, $err_file, $err_line);
                case E_USER_WARNING:        throw new \Exception  ($err_msg, 0, $err_severity, $err_file, $err_line);
                case E_USER_NOTICE:         throw new \Exception  ($err_msg, 0, $err_severity, $err_file, $err_line);
                case E_STRICT:              throw new \ErrorException  ($err_msg, 0, $err_severity, $err_file, $err_line);
                case E_RECOVERABLE_ERROR:   throw new \ErrorException  ($err_msg, 0, $err_severity, $err_file, $err_line);
                case E_DEPRECATED:          throw new \Exception  ($err_msg, 0, $err_severity, $err_file, $err_line);
                case E_USER_DEPRECATED:     throw new \Exception  ($err_msg, 0, $err_severity, $err_file, $err_line);
            }
    }
}
?>
