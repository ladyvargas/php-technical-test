# User Registration System

Este proyecto implementa un sistema de registro de usuarios siguiendo los principios de Domain-Driven Design (DDD) y Clean Architecture.

## Estructura del Proyecto

El proyecto está organizado en capas siguiendo la arquitectura hexagonal:

- **Domain**: Contiene las entidades, objetos de valor, eventos, excepciones y repositorios del dominio.
- **Application**: Contiene los casos de uso y DTOs que orquestan la lógica de aplicación.
- **Infrastructure**: Contiene implementaciones concretas de interfaces del dominio, controladores y configuración.

## Requisitos

- PHP 8.1 o superior
- Composer
- Docker y Docker Compose (para entorno de desarrollo)

## Instalación

1. Clonar el repositorio:

```bash
git clone https://github.com/username/user-registration-system.git
cd user-registration-system
```

2. Instalar dependencias:

```bash
composer install
```

3. Iniciar el entorno Docker:

```bash
docker-compose up -d
```

## Uso

### Registro de Usuario

Para registrar un nuevo usuario, realiza una petición POST al endpoint `/api/users/register` con los siguientes datos:

```json
{
  "name": "John Doe",
  "email": "john.doe@example.com",
  "password": "StrongPassword123!"
}
```

## Pruebas

Para ejecutar las pruebas unitarias e integradas:

```bash
make test
```

Para ver la cobertura de código:

```bash
make coverage
```

## Makefile

El proyecto incluye un Makefile con los siguientes comandos:

- `make build`: Construye los contenedores Docker
- `make start`: Inicia los contenedores Docker
- `make stop`: Detiene los contenedores Docker
- `make restart`: Reinicia los contenedores Docker
- `make test`: Ejecuta todas las pruebas
- `make coverage`: Genera informe de cobertura de código
- `make cs`: Verifica el estilo de código
- `make cs-fix`: Corrige automáticamente el estilo de código
- `make static-analysis`: Ejecuta análisis estático con PHPStan

## Licencia

Este proyecto está licenciado bajo la licencia MIT. Ver el archivo LICENSE para más detalles.
