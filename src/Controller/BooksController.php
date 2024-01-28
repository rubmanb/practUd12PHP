<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\LibraryData;

class BooksController extends AbstractController
{
    #[Route('/book/{isbn}', name: 'single_book')]
    public function book($isbn = ''): Response
    {

        $books = LibraryData::getBooks();
        $book = array();
        foreach ($books as $b) {
            if ($b['isbn'] == $isbn) {
                $book = $b;
                break;
            }
        }

        if (empty($isbn)) {
            $book = null;
        } elseif (empty($book)) {
            $book['title'] = $book;
            $book['author'] = $book;
            $book['pages'] = $book;
            $book['pub_date'] = $book;
            $book['publisher'] = $book;
        } else {
            $publishers = LibraryData::getPublishers();
            $bookPublisher = array();
            foreach ($publishers as $publisher) {
                if ($publisher['id'] == $book['publisher']) {
                    $bookPublisher[] = $publisher;
                }
            }
            $book['publisher'] = $bookPublisher;
        }

        return $this->render('books/single_book.html.twig', [
            'book' => $book,
            'page_title' => 'My Library App - Book'
        ]);
    }

    #[Route('/book_list', name: 'book_list')]
    public function bookList(): Response
    {
        return $this->render('books/book_list.html.twig', [
            'books' => LibraryData::getBooks(),
            'page_title' => 'My Library App - Book List'
        ]);
    }
}
