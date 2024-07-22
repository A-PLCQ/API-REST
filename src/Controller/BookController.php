<?php
namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookController extends AbstractController
{
    private $entityManager;
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    #[Route('/books', name: 'book_list', methods: ['GET'], defaults: ['_format' => 'html'])]
    public function list(): Response
    {
        $books = $this->entityManager->getRepository(Book::class)->findAll();
        
        return $this->render('book/list.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/books/new', name: 'book_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($book);
            $this->entityManager->flush();

            return $this->redirectToRoute('book_list');
        }

        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/books', name: 'book_create', methods: ['POST'])]
    public function createBook(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['title']) || empty($data['author']) || empty($data['publicationYear']) || empty($data['isbn'])) {
            return $this->json(['error' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
        }

        $book = new Book();
        $book->setTitle($data['title']);
        $book->setAuthor($data['author']);
        $book->setPublicationYear($data['publicationYear']);
        $book->setIsbn($data['isbn']);

        $errors = $this->validator->validate($book);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $this->json([
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'publicationYear' => $book->getPublicationYear(),
            'isbn' => $book->getIsbn()
        ], Response::HTTP_CREATED);
    }

    #[Route('/books/{id}', name: 'get_book', methods: ['GET'])]
    public function getBook(int $id): JsonResponse
    {
        $book = $this->entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            return $this->json(['error' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'publicationYear' => $book->getPublicationYear(),
            'isbn' => $book->getIsbn(),
        ];

        return $this->json($data);
    }

    #[Route('/books/{id}', name: 'update_book', methods: ['PUT'])]
    public function updateBook(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $book = $this->entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            return $this->json(['error' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['title'])) {
            $book->setTitle($data['title']);
        }
        if (isset($data['author'])) {
            $book->setAuthor($data['author']);
        }
        if (isset($data['publicationYear'])) {
            $book->setPublicationYear($data['publicationYear']);
        }
        if (isset($data['isbn'])) {
            $book->setIsbn($data['isbn']);
        }

        $errors = $this->validator->validate($book);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        return $this->json([
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'publicationYear' => $book->getPublicationYear(),
            'isbn' => $book->getIsbn(),
        ]);
    }

    #[Route('/books/{id}', name: 'delete_book', methods: ['DELETE'])]
    public function deleteBook(int $id): JsonResponse
    {
        $book = $this->entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            return $this->json(['error' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($book);
        $this->entityManager->flush();

        return $this->json(['message' => 'Book deleted']);
    }
    #[Route('/doc', name: 'api_documentation', methods: ['GET'])]
    public function documentation(): Response
    {
    return $this->render('book/documentation.html.twig');
    }
    
}
