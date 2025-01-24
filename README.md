# spy_api
Prosperty assignment

## Setup instructions
```bash
docker-compose up --build
docker exec app composer install
docker exec app php artisan migrate --seed
```
docker/db/init-db.sh should be executable
Note: docker/db/init-db.sh should be executable

##  Architecture overview

The data flow : HTTP Request → Controller → DTO → Action/Command → Domain Logic → Eloquent Model → Database, with each step transforming the data as needed while maintaining isolation between layers.

HTTP requests enter through Controllers, which convert them into DTOs (Data Transfer Objects).
These DTOs then flow through Application layer Actions and Commands, which orchestrate the business .
The core Domain layer contains your Spy entity with its business rules and event handling. 
Finally, the Infrastructure layer uses Laravel's Eloquent ORM to handle database operations. 

## Todos if given more time

1) Interface and Repository pattern - This would help the project to separate concerns of queries ideally with making it both framework-agnostic and using Laravel's eloquent. Added Spy Domain model / entity for a showcase.
2) Better implementation of CreateSpy should not pass an eloquent Model
3) More sophisticated authentication service tests

