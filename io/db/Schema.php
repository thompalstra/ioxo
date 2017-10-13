<?php
namespace io\db;

class Schema{
    const TYPE_BOOLEAN = 'TINYINT(1)';
    const TYPE_TEXT = 'TEXT';
    const TYPE_CHAR = 'VARCHAR(255)';
    const TYPE_PK = "INT(11) AUTO_INCREMENT PRIMARY KEY";
    const TYPE_INT = "INT(11)";
}
?>
