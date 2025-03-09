<?php

namespace Tests\Unit\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use App\Domain\User\ValueObject\Email;

class EmailTest extends TestCase
{
    public function testValidEmail()
    {
        $email = Email::fromString('test@example.com');
        $this->assertEquals('test@example.com', $email->value());
    }
    
    public function testInvalidEmailThrowsException()
    {
        $this->expectException(\App\Domain\User\Exception\InvalidEmailException::class);
        Email::fromString('invalid-email');
    }
    
    public function testEmailEquality()
    {
        $email1 = Email::fromString('test@example.com');
        $email2 = Email::fromString('test@example.com');
        $email3 = Email::fromString('other@example.com');
        
        $this->assertTrue($email1->equals($email2));
        $this->assertFalse($email1->equals($email3));
    }
    
    public function testEmailToString()
    {
        $email = Email::fromString('test@example.com');
        $this->assertEquals('test@example.com', (string)$email);
    }
}