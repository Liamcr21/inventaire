<?php
require '../php/model/db.php'; // Assurez-vous que le chemin est correct
require '../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class DbTest extends TestCase {

    public function testGetConnection() {
        $database = new Database();
        $conn = $database->getConnection();

        // Assert
        $this->assertInstanceOf(PDO::class, $conn);
    }
}
