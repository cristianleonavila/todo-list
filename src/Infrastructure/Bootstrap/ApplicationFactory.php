<?php

namespace App\Infrastructure\Bootstrap;

use App\Application\Security\LoginUser;
use App\Application\Security\LogoutUser;
use App\Application\Security\WhoIAm;
use App\Application\User\RegisterUser;
use App\Application\Todo\CreateTodo;
use App\Application\Todo\ListUserTodos;
use App\Application\Todo\CompleteTodo;
use App\Application\Todo\DeleteTodo;
use App\Application\Todo\ReopenTodo;
use App\Application\Todo\UpdateTodo;
use App\Infrastructure\Http\Controller\TodoController;
use App\Infrastructure\Http\Controller\AuthController;
use App\Infrastructure\Http\Controller\UserController;
use App\Infrastructure\Persistence\Doctrine\DoctrineTodoRepository;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use App\Infrastructure\Security\PhpPasswordHasher;
use App\Infrastructure\Security\PhpSessionAuthentication;
use Doctrine\ORM\EntityManagerInterface;

class ApplicationFactory
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function createRegisterUser()
    {
        $userRepository = new DoctrineUserRepository(
            $this->entityManager
        );

        $passwordHasher = new PhpPasswordHasher();

        return new RegisterUser(
            $userRepository,
            $passwordHasher
        );
    }

    public function createLoginUser()
    {
        $userRepository = new DoctrineUserRepository(
            $this->entityManager
        );

        $passwordHasher = new PhpPasswordHasher();

        $authenticationSession = new PhpSessionAuthentication();

        return new LoginUser(
            $userRepository,
            $passwordHasher,
            $authenticationSession
        );
    }

    public function createCreateTodo()
    {
        $todoRepository = new DoctrineTodoRepository(
            $this->entityManager
        );

        $userRepository = new DoctrineUserRepository(
            $this->entityManager
        );

        $authenticationSession = new PhpSessionAuthentication();

        return new CreateTodo(
            $todoRepository,
            $userRepository,
            $authenticationSession
        );
    }

    public function createListUserTodos()
    {
        $todoRepository = new DoctrineTodoRepository(
            $this->entityManager
        );

        $userRepository = new DoctrineUserRepository(
            $this->entityManager
        );

        $authenticationSession = new PhpSessionAuthentication();

        return new ListUserTodos(
            $todoRepository,
            $userRepository,
            $authenticationSession
        );
    }

    public function createCompleteTodo() {
        $todoRepository = new DoctrineTodoRepository(
            $this->entityManager
        );

        $userRepository = new DoctrineUserRepository(
            $this->entityManager
        );

        $authenticationSession = new PhpSessionAuthentication();

        return new CompleteTodo(
            $todoRepository,
            $userRepository,
            $authenticationSession
        );
    }

    public function createDeleteTodo() {
        $todoRepository = new DoctrineTodoRepository(
            $this->entityManager
        );

        $userRepository = new DoctrineUserRepository(
            $this->entityManager
        );

        $authenticationSession = new PhpSessionAuthentication();

        return new DeleteTodo(
            $todoRepository,
            $userRepository,
            $authenticationSession
        );
    }
    
    public function createUpdateTodo() {
        $todoRepository = new DoctrineTodoRepository(
            $this->entityManager
        );

        $userRepository = new DoctrineUserRepository(
            $this->entityManager
        );

        $authenticationSession = new PhpSessionAuthentication();

        return new UpdateTodo(
            $todoRepository,
            $userRepository,
            $authenticationSession
        );
    }  
    
    public function createReopenTodo() {
        $todoRepository = new DoctrineTodoRepository(
            $this->entityManager
        );

        $userRepository = new DoctrineUserRepository(
            $this->entityManager
        );

        $authenticationSession = new PhpSessionAuthentication();

        return new ReopenTodo(
            $todoRepository,
            $userRepository,
            $authenticationSession
        );        
    }

    public function createTodoController(): TodoController
    {
        return new TodoController(
            $this->createListUserTodos(),
            $this->createCompleteTodo(),
            $this->createReopenTodo(),
            $this->createUpdateTodo(),
            $this->createDeleteTodo(),
            $this->createCreateTodo()
        );
    } 

    public function createLogoutUser() {
        $authenticationSession = new PhpSessionAuthentication();
        return new LogoutUser($authenticationSession);
    }
    
    public function createAuthController(): AuthController
    {
        return new AuthController(
            $this->createLoginUser(),
            $this->createLogoutUser(),
            $this->createWhoIam()
        );
    }   
    
    public function createUserController(): UserController {
        return new UserController(
            $this->createRegisterUser()
        );
    }

    public function createWhoIam(): WhoIAm {
        $userRepository = new DoctrineUserRepository(
            $this->entityManager
        );        
        return new WhoIAm(
            new PhpSessionAuthentication(),
            $userRepository
        );
    }
}
