<?php

declare(strict_types=1);

namespace User\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;
use User\Application\CommandFactory\CreateUserCommandFactory;
use User\Application\QueryFactory\GetUserQueryFactory;

class UserController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly MessageBusInterface $queryBus,
    ) {}

    #[Route('/{email}', name: 'user_index', methods: ['GET'])]
    public function index(
        GetUserQueryFactory $factory,
        string $email,
    ): Response {
        $query = $factory->create(['email' => $email]);
        /** @var HandledStamp $handler */
        $handler = $this->queryBus->dispatch($query)->last(HandledStamp::class);

        if (!$user = $handler->getResult()) {
            throw $this->createNotFoundException('User not found.');
        }

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'roles' => $user->getRoles(),
        ]);
    }

    #[Route('/', name: 'user_create', methods: ['POST'])]
    public function create(
        Request $request,
        CreateUserCommandFactory $factory,
    ): Response {
        $data = $request->toArray();
        $command = $factory->create($data);
        $this->commandBus->dispatch($command);

        return $this->json(['User created!'], Response::HTTP_CREATED);
    }
}
