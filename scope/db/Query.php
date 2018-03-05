<?php
namespace scope\db;

use Scope;

class Query extends Scope\core\Base{

    public $select = '';
    public $update = '';
    public $from = '';
    public $offset = '';
    public $limit = '';

    public $arguments = [];

    public function showColumns( $tableName ){
        $command = "SHOW COLUMNS FROM " . $tableName;

        $sth = Scope::$app->db->conn->prepare( $command );
        $sth->execute();
        $columns = $sth->fetchAll();
        $columnNames = [];
        foreach( $columns as $column ){
            if( isset( $column['Field'] ) ){
                $columnNames[] = $column['Field'];
            }
        }
        return $columnNames;
    }

    public function select( $argument ){
        $this->select = $argument;
    }

    public function update( $argument ){
        if( class_exists( $argument )  ){
            $this->update = $argument::tableName();
        } else {
            $this->update = $argument;
        }
        return $this;
    }

    public function from( $argument ){
        if( class_exists( $argument )  ){
            $this->className = $argument;
            $this->select( $argument::tableName() . '.*' );
            $this->from( $argument::tableName() );
        } else {
            $this->from = $argument;
        }
        return $this;
    }

    public function leftJoin( $join ){
        $this->arguments[] = "LEFT JOIN $join";
    }

    public function limit( $limit ){
        $this->limit = $limit;
    }
    public function offset( $offset ){
        $this->offset = $offset;
    }

    public function set( $argument ){
        $this->arguments[] = [
            'SET' => $argument
        ];
        return $this;
    }

    public function where( $argument ){
        $this->arguments[] = [
            'WHERE' => $argument
        ];
        return $this;
    }
    public function orWhere( $argument ){
        $this->arguments[] = [
            'OR' => $argument
        ];

        return $this;
    }
    public function andWhere( $argument ){
        $this->arguments[] = [
            'WHERE' => $argument
        ];
        return $this;
    }

    public function all(){
        $sth = $this->createSth();
        return $sth->fetchAll();
    }

    public function createSth(){
        $sth = Scope::$app->db->conn->prepare( $this->createCommand() );
        $sth->setFetchMode(\PDO::FETCH_CLASS, $this->className, [
            $this->className => [
                'isNewRecord' => false
            ]
        ]);
        $sth->execute();
        return $sth;
    }

    public function one(){
        $sth = $this->createSth();
        return $sth->fetch();
    }


    public function createCommand(){

        $lines = [];

        if( $this->update ){
            $lines[] = "UPDATE $this->update";
        } else {
            $lines[] = "SELECT $this->select";
            $lines[] = "FROM $this->from";
        }

        foreach( $this->arguments as $argument ){
            if( is_string( $argument ) ){
                $lines[] = $argument;
            } else if( is_array( $argument ) ){
                foreach( $argument as $type => $data ){
                    if( in_array( strtoupper( $type ), ['WHERE', "AND", "OR", "SET"] ) ){
                        $lines[] = strtoupper( $type ) . ' ' . $this->createWhere( $data );
                    }
                }
            }
        }

        if( $this->limit ){
            $lines[] = "LIMIT $this->limit";
        }

        if( $this->offset ){
            $lines[] = "OFFSET $this->offset";
        }

        return implode(' ', $lines );
    }

    public function createWhere( $data ){
        $lines = [];

        if( isset($data[0]) && in_array( strtoupper($data[0]), ['AND', 'OR', 'WHERE'] ) ){
            $glue = $data[0];
            array_shift( $data );
            $lines[] = " ( " . $this->createGroup( $glue, $data ) . " ) ";
        } else if( isset($data[0]) ){
            $lines[] = $this->createParam( $data[1], $data[0], $data[2] );
        } else {

            $column = array_keys($data)[0];
            $value = $data[$column];
            $glue = '=';

            $lines[] = $this->createParam( $column, $glue, $value );
        }

        return implode(" ", $lines);
    }

    public function createParam( $column, $glue, $value ){

        $parts = explode('.', $column);
        foreach( $parts as $k => $v ){
            $parts[$k] = "`$v`";
        }
        $column = implode('.', $parts);

        return $column . ' ' . $glue . ' ' . $this->createValue( $value );
    }

    public function createGroup( $glue, $data ){
        $lines = [];
        foreach( $data as $k => $v ){
            $lines[] = $this->createWhere($v);
        }
        return implode( " $glue ", $lines );
    }

    public function createValue( $value ){
        if( $value === null ){
            return 'NULL';
        } else if( is_string($value) ){
            return Scope::$app->db->conn->quote( $value );
        } else if( is_array( $value ) ){
            $values = [];
            foreach( $value as $v ){
                $values[] = Scope::$app->db->conn->quote( $v );
            }
            return "( " . implode( ',', $values ) . " )";
        }
        return $value;
    }

    public function updateAll( $className, $set, $where ){

        $tableName = $className::tableName();

        if( is_array( $set ) ){
            $s = [];
            foreach( $set as $k => $v ){
                $s[] = "$k = " . $this->createValue( $v );
            }
            $set = implode(', ', $s);
        }

        if( is_array( $where ) ){
            $where = $this->createWhere($where);
        }

         $sth = Scope::$app->db->conn->prepare( "UPDATE $tableName SET $set WHERE $where" );

         $sth->execute();

         if( $sth->rowCount() > 0 ){
             $this->isNewRecord = false;
             return true;
         } else {
             $this->isNewRecord = true;
             return false;
         }
    }
}
?>
