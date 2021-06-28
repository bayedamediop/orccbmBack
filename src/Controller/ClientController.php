<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Clients;
use App\Entity\Customers;
use App\Entity\Profils;
use App\Entity\Qualites;
use App\Entity\User;
use App\Repository\ClientsRepository;
use App\Repository\TypesRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
    /**
     * * @Route (
     *     name="c",
     *      path="/api/admin/client",
     *      methods={"POST"},
     *     defaults={
     *           "__controller"="App\Controller\UserController::addClient",
     *           "__api_ressource_class"=Clints::class,
     *           "__api_collection_operation_name"="add_client"
     *         }
     * )
     */
    public function addClient(SerializerInterface $serializer,Request $request,
     EntityManagerInterface $manager,ClientsRepository $clientsRepository,
     TypesRepository $type)
    {
        $json = json_decode($request->getContent(), 'json');
      //  $json=$serializer->decode($request,"json");  
       // $json = $request->request->all();

        //dd($json);
        $id = $clientsRepository->findOneBy([],['id'=>'desc']);
        $lastId = $id->getId()+ 1;
       // dd($lastId);
        $zero = "41100";
        $mat = $zero .= $lastId;
        //dd($mat);
        $idType = $type->find((int)  $json['type']);
     $newClient = new Clients();
     $newClient->setNom($json['nom'])
     ->setPrenom($json['prenom'])
     ->setMatricule($mat)
     ->setEmail($json['email'])
     ->setTelephone($json['telephone'])
     ->setContact($json['contact'])
     ->setAdresse($json['adresse'])
     ->setType($idType);
     $em = $this->getDoctrine()->getManager();
     $em->persist($newClient);
     $em->flush();
     return $this->json("success!!!! Client added",Response::HTTP_OK);

    }
    /**
     * @Route(
     *  name="putUser",
     *  path="/api/admin/users/{id}",
     *  methods={"PUT"},
     *  defaults={
     *           "__controller"="App\Controller\UserController::putUser",
     *           "__api_ressource_class"=User::class,
     *           "__api_collection_operation_name"="put_user"
     *  }
     * )
     * @param $id
     * @param UserService $service
     * @param Request $request
     * @return JsonResponse
     */
    public function putUser($id, UserService $service,Request $request)
    {
        $user = $service->getAttributes($request);
        $userUpdate = $this->manager->getRepository(User::class)->find($id);
        // dd($$userUpdate);
        foreach($user as $key=>$valeur){
            $setter = 'set'.ucfirst(strtolower($key));
            if(method_exists(User::class, $setter)){
                if($key === "profil"){
                    $userUpdate->$setter($this->manager->getRepository(Profils::class)->findOneBy(['libelle' => $valeur]));
                }
                elseif($key === "password"){
                    $userUpdate->$setter($this->encoder->encodePassword ($userUpdate, $valeur));
                }else{
                    $userUpdate->$setter($valeur);
                }
            }
        }
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->json("success!!!! User updated",Response::HTTP_OK);

    }
}
