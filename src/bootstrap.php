<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Application\User\UseCase\RegisterUserUseCase;
use App\Domain\User\Event\UserRegisteredEvent;
use App\Infrastructure\EventListener\UserRegisteredEventListener;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use App\Infrastructure\Persistence\EventDispatcher\EventDispatcher;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

// Setup Doctrine
$paths = [__DIR__ . '/Infrastructure/Persistence/Doctrine/Mapping'];
$isDevMode = true;

$dbParams = [
    'driver'   => 'pdo_mysql',
    'host'     => getenv('MYSQL_HOST') ?: 'mysql',
    'user'     => getenv('MYSQL_USER') ?: 'app_user',
    'password' => getenv('MYSQL_PASSWORD') ?: 'password',
    'dbname'   => getenv('MYSQL_DATABASE') ?: 'app_db',
];

$config = ORMSetup::createXMLMetadataConfiguration($paths, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

// Setup repositories
$userRepository = new DoctrineUserRepository($entityManager);

// Setup event dispatcher
$eventDispatcher = new EventDispatcher();
$eventDispatcher->addListener(
    UserRegisteredEvent::class,
    new UserRegisteredEventListener()
);

// Setup use cases
$registerUserUseCase = new RegisterUserUseCase($userRepository, $eventDispatcher);

return [
    'entityManager' => $entityManager,
    'userRepository' => $userRepository,
    'eventDispatcher' => $eventDispatcher,
    'registerUserUseCase' => $registerUserUseCase,
];