<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Annotations\Tag(name="Person")
 */
class PersonController extends AbstractController
{
    /**
     * @Route("/wanted-persons", methods={"POST"})
     * @Security(name="Bearer")
     *
     * @Annotations\Response(
     *     response=200,
     *     description="Returns a list of wanted persons matching search criteria",
     *     @Annotations\Schema(
     *         type="array",
     *         @Annotations\Items(ref=@Model(type=Person::class, groups={"search"}))
     *     )
     * )
     *
     * @Annotations\Parameter(
     *     name="fullName",
     *     in="body",
     *     type="string",
     *     description="The field used to find wanted persosns with a specific name.",
     *     required=true,
     *     @Annotations\Schema(
     *         type="object",
     *         example={"fullName": "fullName"}
     *     )
     * )
     */
    public function list(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['fullName'])) {
            return $this->json('Required parameter fullName is missing',JsonResponse::HTTP_BAD_REQUEST);
        }

        $persons = $entityManager
            ->getRepository(Person::class)
            ->findWantedByFullName($data['fullName']);
        $responseData = $serializer->serialize(
            $persons ?? [],
            'json',
            SerializationContext::create()->setGroups(['search'])
        );

        return JsonResponse::fromJsonString(
            $responseData,
            JsonResponse::HTTP_OK
        );
    }
}