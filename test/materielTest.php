<?php
require '../php/model/materiel.php'; // Assurez-vous que le chemin est correct
require '../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class MaterielTest extends TestCase {

    public function testCreate() {
        $dbMock = $this->createMock(PDO::class);
        $stmtMock = $this->createMock(PDOStatement::class);

        $materiel = new Materiel($dbMock);
        $materiel->nom = "Test Materiel";
        $materiel->quantite_disponible = 10;

        // Mock the necessary methods in PDO to simulate the database interactions
        $dbMock->expects($this->any())
            ->method('prepare')
            ->willReturn($stmtMock);

        $stmtMock->expects($this->any())
            ->method('bindParam')
            ->willReturn(true);

        $stmtMock->expects($this->any())
            ->method('execute')
            ->willReturn(true);

        // Act
        $result = $materiel->create();

        // Assert
        $this->assertTrue($result);
    }

    public function testReadOne() {
        $dbMock = $this->createMock(PDO::class);
        $stmtMock = $this->createMock(PDOStatement::class);

        $materiel = new Materiel($dbMock);
        $materiel->id = 1;

        // Mock the necessary methods in PDO to simulate the database interactions
        $dbMock->expects($this->any())
            ->method('prepare')
            ->willReturn($stmtMock);

        $stmtMock->expects($this->any())
            ->method('bindParam')
            ->willReturn(true);

        $stmtMock->expects($this->any())
            ->method('execute')
            ->willReturn(true);

        $stmtMock->expects($this->any())
            ->method('fetch')
            ->willReturn([
                'nom' => 'Test Materiel',
                'quantite_disponible' => 10
            ]);

        // Act
        $materiel->readOne();

        // Assert
        $this->assertEquals('Test Materiel', $materiel->nom);
        $this->assertEquals(10, $materiel->quantite_disponible);
    }

    public function testUpdate() {
        $dbMock = $this->createMock(PDO::class);
        $stmtMock = $this->createMock(PDOStatement::class);

        $materiel = new Materiel($dbMock);
        $materiel->id = 1;
        $materiel->nom = "Updated Materiel";
        $materiel->quantite_disponible = 5;

        // Mock the necessary methods in PDO to simulate the database interactions
        $dbMock->expects($this->any())
            ->method('prepare')
            ->willReturn($stmtMock);

        $stmtMock->expects($this->any())
            ->method('bindParam')
            ->willReturn(true);

        $stmtMock->expects($this->any())
            ->method('execute')
            ->willReturn(true);

        // Act
        $result = $materiel->update();

        // Assert
        $this->assertTrue($result);
    }

    public function testDelete() {
        $dbMock = $this->createMock(PDO::class);
        $stmtMock = $this->createMock(PDOStatement::class);

        $materiel = new Materiel($dbMock);
        $materiel->id = 1;

        // Mock the necessary methods in PDO to simulate the database interactions
        $dbMock->expects($this->any())
            ->method('prepare')
            ->willReturn($stmtMock);

        $stmtMock->expects($this->any())
            ->method('bindParam')
            ->willReturn(true);

        $stmtMock->expects($this->any())
            ->method('execute')
            ->willReturn(true);

        // Act
        $result = $materiel->delete();

        // Assert
        $this->assertTrue($result);
    }
}
