<?php

declare(strict_types=1);

namespace App\Application\User\UseCase;

use App\Application\User\DTO\RegisterUserRequest;
use App\Application\User\DTO\UserResponseDTO;
use App\Domain\User\Entity\User;
use App\Domain\User\Exception\UserAlreadyExistsException;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Password;
use App\Domain\User\ValueObject\UserId;
use App\Infrastructure\Persistence\EventDispatcher\EventDispatcher;

final class RegisterUserUseCase
{
    private UserRepositoryInterface $userRepository;
    private EventDispatcher $eventDispatcher;

    public function __construct(UserRepositoryInterface $userRepository, EventDispatcher $eventDispatcher)
    {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(RegisterUserRequest $request): UserResponseDTO
    {
        $email = Email::fromString($request->email());
        
        $existingUser = $this->userRepository->findByEmail($email);
        
        if (null !== $existingUser) {
            throw new UserAlreadyExistsException($request->email());
        }
        
        $user = User::register(
            UserId::generate(),
            Name::fromString($request->name()),
            $email,
            Password::fromPlainPassword($request->password())
        );
        
        $this->userRepository->save($user);
        
        $events = $user->releaseEvents();
        foreach ($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
        
        return UserResponseDTO::fromUser($user);
    }
}