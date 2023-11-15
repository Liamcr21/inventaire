<?php
require '../php/model/user.php'; // Assurez-vous que le chemin est correct
require '../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {

    public function testCreate() {
        $dbMock = $this->createMock(PDO::class);
        $stmtMock = $this->createMock(PDOStatement::class);

        $user = new User($dbMock);
        $user->nom = "Test User";
        $user->email = "testuser@example.com";
        $user->role = "admin";

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
        $result = $user->create();

        // Assert
        $this->assertTrue($result);
    }

    public function testReadOne() {
        $dbMock = $this->createMock(PDO::class);
        $stmtMock = $this->createMock(PDOStatement::class);

        $user = new User($dbMock);
        $user->id = 1;

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
                'nom' => 'Test User',
                'email' => 'testuser@example.com',
                'role' => 'admin'
            ]);

        // Act
        $user->readOne();

        // Assert
        $this->assertEquals('Test User', $user->nom);
        $this->assertEquals('testuser@example.com', $user->email);
        $this->assertEquals('admin', $user->role);
    }

    public function testUpdate() {
        $dbMock = $this->createMock(PDO::class);
        $stmtMock = $this->createMock(PDOStatement::class);

        $user = new User($dbMock);
        $user->id = 1;
        $user->nom = "Updated User";
        $user->email = "updateduser@example.com";
        $user->role = "user";

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
        $result = $user->update();

        // Assert
        $this->assertTrue($result);
    }

    public function testDelete() {
        $dbMock = $this->createMock(PDO::class);
        $stmtMock = $this->createMock(PDOStatement::class);

        $user = new User($dbMock);
        $user->id = 1;

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
        $result = $user->delete();

        // Assert
        $this->assertTrue($result);
    }
}
