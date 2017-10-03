<?php
namespace console\controllers;

use io\db\Migration;

class MigrateController extends \io\web\Controller{
    public function actionCreate(){
        if(Migration::run()){
            if(!isset($_SERVER['argv'][2])){
                echo "Missing argument(s): migrate/create my-migration-name.";
            } else {
                $name = $_SERVER['argv'][2];
                echo "Creating migration $name: do you want to continue? (y/n): ";
                $handle = fopen ("php://stdin","r");
                $line = trim(fgets($handle));
                if($line == 'y'){
                    return Migration::new($name);
                }
            }
        } else {
            echo "Something went wrong trying to initialize the migration system. Please check your database.\r\n";
        }
    }

    public function actionPending(){
        if(Migration::run()){
            $pending = Migration::getPending();
            if($pending){
                echo "There are pending migrations: \r\n\r\n";
                foreach($pending as $migration){
                    echo "\033[32m$migration\r\n\033[0m";
                }
                echo "\r\nExecute migration(s)? (y/n):";
                $handle = fopen ("php://stdin","r");
                $line = trim(fgets($handle));

                if($line == 'y'){
                    return Migration::executePending($pending);
                }
            }
        } else {
            echo "Something went wrong trying to initialize the migration system. Please check your database.\r\n";
        }

    }

    public function actionDown(){
        if(Migration::run()){
            $completed = Migration::getCompleted();
            if($completed){
                echo "There are pending migrations: \r\n";
                foreach($completed as $migration){
                    echo "$migration\r\n";
                }
                echo "Undo migration(s)? (y/n):";
                $handle = fopen ("php://stdin","r");
                $line = trim(fgets($handle));

                if($line == 'y'){
                    return Migration::undoCompleted($completed);
                }
            }
        } else {
            echo "Something went wrong trying to initialize the migration system. Please check your database.\r\n";
        }
    }
}
?>
