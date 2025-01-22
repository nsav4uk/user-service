<?php

declare(strict_types=1);

namespace User\Infrastructure\Controller;

use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use User\Application\CommandFactory\CreateUserCommandFactory;
use User\Application\QueryFactory\GetUserQueryFactory;
use User\Domain\Model\User\User;

class UserController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly MessageBusInterface $queryBus,
        private readonly ValidatorInterface $validator,
    ) {}

    #[Route('/user/{email}', name: 'user_index', methods: ['GET'])]
    #[OA\Parameter(
        name: 'email',
        description: 'User email',
        in: 'path',
        schema: new OA\Schema(type: 'string'),
        example: 'test@test.com',
)]
    #[OA\Response(
        response: 200,
        description: 'Return user',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: User::class))
        )
    )]
    #[OA\Tag(name: 'Get User')]
    public function index(
        GetUserQueryFactory $factory,
        string $email,
    ): Response {
        $query = $factory->create(['email' => $email]);
        $errors = $this->validator->validate($query);

        if ($errors->count() > 0) {
            $toReturn = [];

            foreach ($errors as $error) {
                $toReturn[$error->getPropertyPath()] = $error->getMessage();
            }

            return $this->json($toReturn, Response::HTTP_BAD_REQUEST);
        }

        /** @var HandledStamp $handler */
        $handler = $this->queryBus->dispatch($query)->last(HandledStamp::class);

        if (!$user = $handler->getResult()) {
            throw $this->createNotFoundException('User not found.');
        }

        return $this->json($user);
    }

    #[Route('/user', name: 'user_create', methods: ['POST'])]
    #[OA\RequestBody(
        description: 'Create user',
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property('email', type: 'string', example: 'test@test.com'),
                new OA\Property('password', type: 'string', example: 'password'),
            ],
            type: 'object',
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Success response',
        content: new OA\JsonContent(
            type: 'string',
            example: 'User created.'
        )
    )]
    #[OA\Tag(name: 'Create User')]
    public function create(
        Request $request,
        CreateUserCommandFactory $factory,
    ): Response {
        $command = $factory->create($request->toArray());
        $errors = $this->validator->validate($command);

        if ($errors->count() > 0) {
            $toReturn = [];

            foreach ($errors as $error) {
                $toReturn[$error->getPropertyPath()] = $error->getMessage();
            }

            return $this->json($toReturn, Response::HTTP_BAD_REQUEST);
        }

        $this->commandBus->dispatch($command);

        return $this->json(['User created!'], Response::HTTP_CREATED);
    }
}
