<?php
require '../php/model/emprunt.php'; 
require '../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class EmpruntTest extends TestCase {

    public function testCreate() {
        // Arrange
        $dbMock = $this->createMock(PDO::class);
        $stmtMock = $this->createMock(PDOStatement::class);

        $emprunt = new Emprunt($dbMock);
        $emprunt->user_id = 1;
        $emprunt->materiel_id = 1;
        $emprunt->date_debut = '2023-01-01';
        $emprunt->date_fin = '2023-01-10';

        // Mock the necessary methods in PDO to simulate the database interactions
        $dbMock->expects($this->any())
            ->method('prepare')
            ->willReturn($stmtMock);

        $stmtMock->expects($this->any())
            ->method('bindParam')
            ->willReturn(true);

        $stmtMock->expects($this->any())
            ->method('execute')
            ->willReturn(true); // Adjust as needed based on your expectations

        // Act
        $result = $emprunt->create();

        // Assert
        $this->assertTrue($result);
    }

   

    public function testReadOne() {
        // Arrange
        $dbMock = $this->createMock(PDO::class);
        $stmtMock = $this->createMock(PDOStatement::class);

        $emprunt = new Emprunt($dbMock);
        $emprunt->id = 1;

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
                'user_id' => 1,
                'materiel_id' => 1,
                'date_debut' => '2023-01-01',
                'date_fin' => '2023-01-10'
            ]); // Adjust the data as needed

        // Act
        $emprunt->readOne();

        // Assert
        $this->assertEquals(1, $emprunt->user_id);
        $this->assertEquals(1, $emprunt->materiel_id);
        $this->assertEquals('2023-01-01', $emprunt->date_debut);
        $this->assertEquals('2023-01-10', $emprunt->date_fin);
    }

    public function testUpdate() {
        // Arrange
        $dbMock = $this->createMock(PDO::class);
        $stmtMock = $this->createMock(PDOStatement::class);

        $emprunt = new Emprunt($dbMock);
        $emprunt->user_id = 1;
        $emprunt->materiel_id = 1;
        $emprunt->date_debut = '2023-01-01';
        $emprunt->date_fin = '2023-01-10';
        $emprunt->id = 1;

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
        $result = $emprunt->update();

        // Assert
        $this->assertTrue($result);
    }

    public function testDelete() {
        $dbMock = $this->createMock(PDO::class);
        $emprunt = new Emprunt($dbMock);
    
        // Set up the necessary data for the test
        $emprunt->id = 1;
    
        // Mock the required methods in PDO to simulate the database interactions
        $stmtMock = $this->createMock(PDOStatement::class);
    
        $stmtMock->expects($this->any())
            ->method('execute')
            ->willReturn(true);
    
        $stmtMock->expects($this->any())
            ->method('fetch')
            ->willReturn(['quantite_disponible' => 2]); // Adjust the quantity as needed
    
        $dbMock->expects($this->any())
            ->method('prepare')
            ->willReturn($stmtMock);
    
        // Call the method to be tested
        $result = $emprunt->delete();
    
        // Assert the result
        $this->assertTrue($result);
    }
    

    // Add more test methods as needed for other functions in the Emprunt class
}
