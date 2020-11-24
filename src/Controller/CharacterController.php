<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Character;
use App\Service\CharacterServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class CharacterController extends AbstractController
{
    private $characterService;

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }


    /**
     * @Route("/character",
     *     name="character_redirect_index",
     *     methods={"GET","HEAD"}
     *     )
     */
    public function redirectIndex()
    {
        return $this->redirectToRoute('character_index');
    }

    /**
     * @Route("/character/index",
     *     name="character_index",
     *     methods={"GET","HEAD"}
     *     )
     */
    public function index(): Response
    {
        $this->denyAccessUnLessGranted('characterIndex', null);

        $characters = $this->characterService->getAll();

        return new JsonResponse($characters);
    }

    /**
     * @Route("/character/display/{identifier}",
     *      name="character_display",
     *      requirements={"identifier": "^[a-z0-9]{40}$"},
     *      methods={"GET","HEAD"}
     * )
     * @Entity("player", expr="repository.findOneByIdentifier(identifier)")
     */
    public function display(Character $character)
    {
        $this->denyAccessUnlessGranted('characterDisplay', $character);

        return new JsonResponse($character->toArray());
    }

    /**
     * @Route("/character/create",
     *      name="character_create",
     *      methods={"POST", "HEAD"})
     */
    public function create(Request $request)
    {
        $this->denyAccessUnlessGranted('characterCreate', null);

        $character = $this->characterService->create($request->getContent());
        return new JsonResponse($character->toArray());
    }

    //MODIFY
    /**
     * @Route("/character/modify/{identifier}",
     *     name="character_modify",
     *     requirements={"identifier": "^[a-z0-9]{40}$"},
     *     methods={"PUT", "HEAD"})
     */
    public function modify(Request $request, Character $character)
    {
        $this->denyAccessUnlessGranted('characterModify', $character);

        $character = $this->characterService->modify($character, $request->getContent());

        return new JsonResponse($character->toArray());
    }

    //DELETE
    /**
     * @Route("/character/delete/{identifier}",
     *     name="character_delete",
     *     requirements={"identifier": "^[a-z0-9]{40}$"},
     *     methods={"DELETE", "HEAD"})
     */
    public function delete(Character $character)
    {
        $this->denyAccessUnlessGranted('characterDelete', null);

        $reponse = $this->characterService->delete($character);

        return new JsonResponse(array('delete' => $reponse));
    }
}
