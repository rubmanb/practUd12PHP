<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\LibraryData;

class PublishersController extends AbstractController
{
    #[Route('/publisher/{id}', name: 'single_publisher')]
    public function publisher($id = 0): Response
    {
        $publishers = LibraryData::getPublishers();
        $publisher = array();
        foreach ($publishers as $p) {
            if ($p['id'] == $id) {
                $publisher = $p;
                break;
            }
        }

        if (empty($id)) {
            $publisher = null;
        } elseif (empty($publisher)) {
            $publisher['name'] = $publisher;
            $publisher['email'] = $publisher;
        }

        return $this->render('publishers/single_publisher.html.twig', [
            'publisher' => $publisher,
            'page_title' => 'My Library App - Publisher'
        ]);
    }

    #[Route('/publisher_list', name: 'publisher_list')]
    public function publisherList(): Response
    {
        return $this->render('publishers/publisher_list.html.twig', [
            'publisher' => LibraryData::getPublishers(),
            'page_title' => 'My Library App - Publisher List'
        ]);
    }
}
