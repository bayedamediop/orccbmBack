<?php

namespace App\Controller;

use App\Entity\Ors;
use App\Entity\Etats;
use App\Entity\Circuits;
use App\Service\UserService;
use App\Repository\EtatsRepository;
use App\Repository\TypesRepository;
use App\Repository\ClientsRepository;
use App\Repository\MarquesRepository;
use App\Repository\CircuitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ModeleVehiculeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrController extends AbstractController
{
    #[Route('/or', name: 'or')]
    public function index(): Response
    {
        return $this->render('or/index.html.twig', [
            'controller_name' => 'OrController',
        ]);
    }
     /**
     * * @Route (
     *     name="addOr",
     *      path="/api/admin/or",
     *      methods={"POST"},
     *     defaults={
     *           "__controller"="App\Controller\VehiculeController::addOr",
     *           "__api_ressource_class"=Vehicules::class,
     *           "__api_collection_operation_name"="add_or"
     *         }
     * )
     */
    public function addOr(SerializerInterface $serializer,Request $request,
     EntityManagerInterface $manager,ClientsRepository $clientsRepository,
     CircuitsRepository $circuit, EtatsRepository $etat,TypesRepository $type)
    {
        $json = json_decode($request->getContent(),'json');
      //  $json=$serializer->decode($request,"json");  
       // $json = $request->request->all();
       //dd($json['modele'][0]['marque'][0]['libelle']);
      // $dat=new \DateTime($json['dmc']);
       $idcircuit = $circuit->find((int)$json['circuit']);
      // dd($idcircuit);
     $idetat = $etat->find((int)$json['etat']);
       $idClient = $clientsRepository->find((int)$json['client']);

      $et = 'EN COURS';
       $newOr = new Ors();
       $newOr->setKilo9metrage($json['kilometrage']);
       $newOr->setTraveauDemande($json['traveauDemande']);
       $newOr->setObservation($json['observation']);
       $newOr->setGarantie($json['garanty']);
       $newOr->setCampagne($json['campagne']);
       $newOr->setCircuit($idcircuit);
       $newOr->setClient($idClient);
       $newOr->setEtat($idetat);
            
                $em = $this->getDoctrine()->getManager();
              $em->persist($newOr);
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
