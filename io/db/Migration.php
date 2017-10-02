<?php
namespace io\db;

use io\db\Schema;

class Migration extends \io\base\Model{
    public static $table = "migrations";

    public static function getMigrationDirectory(){
        return \IO::$app->root . DIRECTORY_SEPARATOR . 'console' . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR;
    }

    public static function initialize(){
        echo "Creating migration table... \n\r";
        $migration = new self();
        $result = $migration->createTable('migrations', [
            'id' => Schema::TYPE_PK,
            'name' => 'VARCHAR(255)',
            'created_at' => 'INT(11)'
        ]);
        return $result;
    }

    public static function isInitialized(){
        return self::tableExists('migrations');
    }

    public static function run(){
        if(!self::isInitialized()){
            return self::initialize();
        }
        return true;
    }

    public static function new($name){

        $migrationName = "m$name"."_".time();

        $template = file_get_contents( \IO::$app->root . DIRECTORY_SEPARATOR . 'io' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'MigrationTemplate.php' );
        $template = str_replace('{CLASS}', $migrationName, $template);

        $dir = self::getMigrationDirectory();

        if(!is_dir($dir)){
            mkdir($dir);
        }

        return file_put_contents($dir . $migrationName . '.php', $template);
    }

    public function createTable($tableName, $columns){
        $command = "CREATE table $tableName";
        $c = [];

        foreach($columns as $k => $v){
            $c[] = "$k $v";
        }
        $command .= "(" . implode(', ', $c) . ")";
        $this->execute($command);
    }

    public function dropTable($tableName){
        $command = "DROP TABLE $tableName";

        return $this->execute($command);
    }

    public static function executePending($items){
        $time = time();

        foreach($items as $item){
            $class = "\\console\\migrations\\$item";
            $migration = new $class();
            $migration->up();
            $m = new Migration();
            $m->name = $item;
            $m->created_at = $time;
            $m->save();
        }
    }

    public static function undoCompleted($items){
        foreach($items as $item){
            $class = "\\console\\migrations\\$item";
            $migration = new $class();
            $migration->down();
            $m = Migration::find()->where([
                '=' => [
                    'name' => $item
                ]
            ])->one();
            if($m){
                if($m->delete()){
                    echo "Migration $item has been undone succesfully!\r\n";
                }
            }

        }
    }

    public static function getPending(){
        $files = scandir(self::getMigrationDirectory());
        $items = [];
        foreach($files as $k => $v){
            if($v == '.' || $v == '..'){ continue; }
            $v = str_replace('.php', '', $v);

            $exists = self::find()->where([
                '=' => [
                    'name' => $v
                ]
            ])->one();
            if(!$exists){
                $items[] = $v;
            }
        }
        return $items;
    }

    public static function getCompleted(){
        $migrations = Migration::find()->all();


        $items = [];

        foreach($migrations as $m){
            $items[] = $m->name;
        }

        return $items;
    }

    public function addColumn(){

    }

    public function alterColumn(){

    }
}
?>
