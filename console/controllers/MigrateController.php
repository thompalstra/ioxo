<?php
namespace console\controllers;

use io\db\Migration;

class MigrateController extends \io\web\Controller{
    public function actionIndex(){
        echo 'dsa';
        die;
    }

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

        }
    }

    public function actionPending(){
        $pending = Migration::getPending();
        if($pending){
            echo "There are pending migrations: \r\n";
            foreach($pending as $migration){
                echo "$migration\r\n";
            }
            echo "Execute migrations?\r\n";
            $handle = fopen ("php://stdin","r");
            $line = trim(fgets($handle));

            if($line == 'y'){
                return Migration::executePending($pending);
            }
        }

    }

    public function actionDown(){
        $completed = Migration::getCompleted();
        if($completed){
            echo "There are pending migrations: \r\n";
            foreach($completed as $migration){
                echo "$migration\r\n";
            }
            echo "Execute migrations?\r\n";
            $handle = fopen ("php://stdin","r");
            $line = trim(fgets($handle));

            if($line == 'y'){
                return Migration::undoCompleted($completed);
            }
        }
    }
}
?>
