<?php

namespace Tests\Unit\Application\UseCase;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use App\Application\User\UseCase\RegisterUserUseCase;
use App\Application\User\DTO\RegisterUserRequest;
use App\Application\User\DTO\UserResponseDTO;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\Exception\UserAlreadyExistsException;
use App\Infrastructure\EventListener\UserRegisteredEventListener;
use App\Infrastructure\Persistence\EventDispatcher\EventDispatcher;

class RegisterUserUseCaseTest extends TestCase
{
    private UserRepositoryInterface|MockObject $userRepository;
    private EventDispatcher|MockObject $eventDispatcher;
    private RegisterUserUseCase $useCase;
    
    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcher::class);
        $this->useCase = new RegisterUserUseCase(
            $this->userRepository,
            $this->eventDispatcher
        );
    }
    
    public function testRegisterNewUser()
    {
        // Arrange
        $request = new RegisterUserRequest(
            'John Doe',
            'john.doe@example.com',
            'StrongP@ssw0rd123'
        );
        
        $this->userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with($this->callback(function ($email) {
                return $email->value() === 'john.doe@example.com';
            }))
            ->willReturn(null);
            
        $this->userRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(User::class));
            
        $this->eventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->anything());
            
        // Act
        $response = $this->useCase->execute($request);
        
        // Assert
        $this->assertInstanceOf(UserResponseDTO::class, $response);
        $this->assertEquals('John Doe', $response->getName());
        $this->assertEquals('john.doe@example.com', $response->getEmail());
    }
    
    public function testRegisterUserWithExistingEmailThrowsException()
    {
        // Arrange
        $request = new RegisterUserRequest(
            'John Doe',
            'existing@example.com',
            'StrongP@ssw0rd123'
        );
        
        $existingUser = $this->createMock(User::class);
        
        $this->userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with($this->callback(function ($email) {
                return $email->value() === 'existing@example.com';
            }))
            ->willReturn($existingUser);
            
        $this->userRepository
            ->expects($this->never())
            ->method('save');
            
        $this->eventDispatcher
            ->expects($this->never())
            ->method('dispatch');
            
        // Assert & Act
        $this->expectException(UserAlreadyExistsException::class);
        $this->useCase->execute($request);
    }
}