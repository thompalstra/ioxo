<?php
namespace io\db;

use io\db\Schema;

class Migration extends \io\base\Model{
    public static $table = "migrations";

    public static function getMigrationDirectory(){
        return \IO::$app->root . DIRECTORY_SEPARATOR . 'console' . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR;
    }

    public static function initialize(){

        return $result;
    }

    public static function isInitialized(){
        return self::tableExists('migrations');
    }

    public static function run(){
        $result = true;
        if(!self::tableExists('migrations')){
            echo "Creating migration table...";
            $migration = new self();
            $result = $migration->createTable('migrations', [
                'id' => Schema::TYPE_PK,
                'name' => 'VARCHAR(255)',
                'created_at' => 'INT(11)'
            ]);
            echo "success!\n\r";
        }
        return $result;
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

    public static function executePending($items){
        $time = time();

        foreach($items as $item){
            $class = "\\console\\migrations\\$item";
            $migration = new $class();
            $migration->up();
            $m = new Migration();
            echo "\033[32mExecuted migration $item\r\n\033[0m";
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
        $date = Migration::find()
        ->orderBy([
            'created_at' => 'desc'
        ])->one()->created_at;
        $migrations = Migration::find()->where([
            '=' => [
                'created_at' => $date
            ],
        ])->all();

        $items = [];

        foreach($migrations as $m){
            $items[] = $m->name;
        }

        return $items;
    }

    public function createTable($tableName, $columns){
        $command = "CREATE table $tableName";
        $c = [];

        foreach($columns as $k => $v){
            $c[] = "$k $v";
        }
        $command .= "(" . implode(', ', $c) . ")";

        $sth = \IO::$app->dbConnector->pdo->prepare($command);
        $result = $sth->execute();
        return $result;
    }

    public function dropTable($tableName){
        $command = "DROP TABLE $tableName";
        return $this->execute($command);
    }

    public function insert($tableName, $columns){
        foreach($columns as $attributeKey => $attributeValue){
            if($attributeKey === 'id'){ continue; }
            $keys[] = $attributeKey;
            $attributeValue = $this->sanitize($attributeValue);
            $values[] = ":$attributeKey";
        }

        $keys = implode(', ', $keys);
        $values = implode(', ', $values);

        $command = "INSERT INTO $tableName ($keys) VALUES ($values)";

        $sth = \IO::$app->dbConnector->pdo->prepare($command);

        foreach($columns as $attributeKey => $attributeValue){
            $sth->bindValue(":$attributeKey", $attributeValue);
        }


        return $sth->execute();
    }

    public function addColumn(){

    }

    public function alterColumn(){

    }
}
?>
