<?php

namespace App\Controller\Admin\Gw2;

use App\Form\Admin\Gw2\ItemType;
use App\Repository\Gw2Api\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemsController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/admin/gw2/items', name: 'app_admin_gw2_items')]
    public function appAdminGw2Items(ItemRepository $itemRepository, Request $request): Response
    {
        $filters = [];
        $_is = $request->query->get('is', null);
        if(in_array($_is, ['fish', 'fish-bait', 'blackmarket'])) {
            $filters['is'] = $_is;
        }
        $items = $itemRepository->adminItems($filters);
        return $this->render('admin/gw2/items/index.html.twig', [
            'items' => $items,
        ]);
    }

    #[Route('/admin/gw2/items/{id}', name: 'app_admin_gw2_item_edit')]
    public function appAdminGw2ItemEdit($id, ItemRepository $itemRepository, Request $request): Response
    {
        $item = $itemRepository->findOneBy(['id' => $id]);
        if(!$item) {
            $this->addFlash('error', 'Objet introuvable.');
            return $this->redirectToRoute('app_admin_gw2_items');
        }

        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            if(!$item->isFish()) {
                ($item)
                    ->setFishPower(null)
                    ->setFishTime(null)
                    ->setFishSpecialization(null)
                    ->setIsFishStrangeDietAchievement(null)
                ;
            }

            if(!$item->isFishBait()) {
                $item->setFishBaitPower(null);
            }

            $this->em->persist($item);
            $this->em->flush();

            $this->addFlash('success', 'Objet enregistré');
            return $this->redirectToRoute('app_admin_gw2_items');
        }

        return $this->render('admin/gw2/items/edit.html.twig', [
            'item' => $item,
            'form' => $form->createView(),
        ]);
    }
}
