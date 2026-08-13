<?php

namespace App\Controller;

use App\Entity\User;
use App\Exception\AlreadyExistsException;
use App\Exception\BadRequestException;
use App\Exception\ItemNotFoundException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/security')]
class SecurityController extends AbstractController
{
    #[Route('/register', methods: ['POST'])]
    #[OA\Post(
        path: '/api/security/register',
        summary: 'Register a new user',
        tags: ['Security'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'user@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'secret123'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'User registered successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 1),
                                new OA\Property(property: 'email', type: 'string', example: 'user@example.com'),
                                new OA\Property(property: 'roles', type: 'array', items: new OA\Items(type: 'string'), example: ['ROLE_USER']),
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Missing required fields',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Email or password missing'),
                    ]
                )
            ),
            new OA\Response(
                response: 409,
                description: 'Email already taken',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Email already taken'),
                    ]
                )
            ),
        ]
    )]
    public function register(
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        Request $request,
    )
    {
        $content = json_decode($request->getContent(), true);
        if (!isset($content['email'], $content['password']) || !$content) {
            throw new BadRequestException('Email or password missing');
        }

        $user = new User();
        $hashedPassword = $passwordHasher->hashPassword($user, $content['password']);
        $user
            ->setEmail($content['email'])
            ->setPassword($hashedPassword)
            ->setRoles([User::ROLE_USER])
        ;

        try {
            $em->persist($user);
            $em->flush();
        } catch (UniqueConstraintViolationException) {
            throw new AlreadyExistsException('Email already taken');
        }


        return $this->json(['data' => $user], 200, [], ['groups' => 'user']);
    }

    #[Route('/login', methods: ['POST'])]
    #[OA\Post(
        path: '/api/security/login',
        summary: 'Login and receive a JWT token',
        tags: ['Security'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'user@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'secret123'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Login successful',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            properties: [
                                new OA\Property(property: 'token', type: 'string', example: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...'),
                                new OA\Property(property: 'exp', type: 'integer', example: 1712700000, description: 'Token expiration timestamp (Unix)'),
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Missing credentials or invalid password',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string'),
                    ],
                    examples: [
                        'missing_credentials' => new OA\Examples(
                            example: 'missing_credentials',
                            summary: 'Missing email or password',
                            value: ['error' => 'Missing email or password']
                        ),
                        'invalid_credentials' => new OA\Examples(
                            example: 'invalid_credentials',
                            summary: 'Invalid credentials',
                            value: ['error' => 'Invalid credentials']
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'User not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'User not found'),
                    ]
                )
            ),
        ]
    )]
    public function login(
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        Request $request,
        JWTEncoderInterface $JWTEncoder
    )
    {
        $content = json_decode($request->getContent(), true);
        if (!isset($content['email'], $content['password']) || !$content) {
            throw new BadRequestException('Missing email or password');
        }

        $user = $em->getRepository(User::class)->findOneBy(['email' => $content['email']]);
        if (!$user) {
            throw new ItemNotFoundException('User not found');
        }
        if (!$passwordHasher->isPasswordValid($user, $content['password'])) {
            throw new BadRequestException('Invalid credentials');
        }

        $exp = time() + 3600 * 24;
        $token = $JWTEncoder->encode([
            'email' => $user->getEmail(),
            'exp' => $exp
        ]);

        return $this->json(['data' => ['token' => $token, 'exp' => $exp]]);
    }
}
