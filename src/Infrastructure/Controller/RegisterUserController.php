<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\User\DTO\RegisterUserRequest;
use App\Application\User\UseCase\RegisterUserUseCase;
use App\Domain\User\Exception\InvalidEmailException;
use App\Domain\User\Exception\UserAlreadyExistsException;
use App\Domain\User\Exception\WeakPasswordException;

final class RegisterUserController
{
    private RegisterUserUseCase $registerUserUseCase;

    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

    public function __invoke(array $requestData): array
    {
        try {
            // Validate request data (simple validation, in a real app we might use a form validator)
            if (!isset($requestData['name']) || !isset($requestData['email']) || !isset($requestData['password'])) {
                return $this->jsonResponse(400, ['error' => 'Missing required fields']);
            }

            $request = new RegisterUserRequest(
                $requestData['name'],
                $requestData['email'],
                $requestData['password']
            );

            $response = $this->registerUserUseCase->execute($request);

            return $this->jsonResponse(201, $response->toArray());
        } catch (InvalidEmailException $e) {
            return $this->jsonResponse(400, ['error' => $e->getMessage()]);
        } catch (WeakPasswordException $e) {
            return $this->jsonResponse(400, ['error' => $e->getMessage()]);
        } catch (UserAlreadyExistsException $e) {
            return $this->jsonResponse(409, ['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return $this->jsonResponse(500, ['error' => 'An unexpected error occurred']);
        }
    }

    private function jsonResponse(int $statusCode, array $data): array
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        
        return $data;
    }
}