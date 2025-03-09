<?php

namespace Tests\Unit\Domain\Entity;

use PHPUnit\Framework\TestCase;
use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\UserId;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Password;

class UserTest extends TestCase
{
    private UserId $userId;
    private Email $email;
    private Name $name;
    private Password $password;
    
    protected function setUp(): void
    {
        $this->userId = UserId::generate();
        $this->email = Email::fromString('john.doe@example.com');
        $this->name = Name::fromString('John Doe');
        $this->password = Password::fromPlainPassword('StrongP@ssw0rd123');
    }
    
    public function testCreateUser()
    {
        $user = User::register(
            $this->userId,
            $this->name,
            $this->email,
            $this->password
        );
        
        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($this->userId->equals($user->id()));
        $this->assertTrue($this->email->equals($user->email()));
        $this->assertTrue($this->name->equals($user->name()));
    }
    
    public function testUpdateName()
    {
        $user = User::register(
            $this->userId,
            $this->name,
            $this->email,
            $this->password
        );
        
        $newName = Name::fromString('Jane Doe');
        $user->updateName($newName);
        
        $this->assertTrue($newName->equals($user->name()));
        $this->assertFalse($this->name->equals($user->name()));
    }
    
    public function testUpdateEmail()
    {
        $user = User::register(
            $this->userId,
            $this->name,
            $this->email,
            $this->password
        );
        
        $newEmail = Email::fromString('jane.doe@example.com');
        $user->updateEmail($newEmail);
        
        $this->assertTrue($newEmail->equals($user->email()));
        $this->assertFalse($this->email->equals($user->email()));
    }
    
    public function testVerifyPassword()
    {
        $user = User::register(
            $this->userId,
            $this->name,
            $this->email,
            $this->password
        );
        
        $this->assertTrue($user->verifyPassword('StrongP@ssw0rd123'));
        $this->assertFalse($user->verifyPassword('WrongPassword123@'));
    }
    
    public function testChangePassword()
    {
        $user = User::register(
            $this->userId,
            $this->name,
            $this->email,
            $this->password
        );
        
        $newPassword = Password::fromPlainPassword('NewStrongP@ssw0rd456');
        $user->changePassword($newPassword);        
        
        $this->assertTrue($user->verifyPassword('NewStrongP@ssw0rd456'));
        $this->assertFalse($user->verifyPassword('StrongP@ssw0rd123'));
    }
}