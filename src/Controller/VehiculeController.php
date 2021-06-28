<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\Vehicules;
use App\Service\UserService;
use App\Controller\UserController;
use App\Entity\Marques;
use App\Entity\ModeleVehicule;
use App\Repository\ClientsRepository;
use App\Repository\MarquesRepository;
use App\Repository\ModeleVehiculeRepository;
use App\Repository\TypesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VehiculeController extends AbstractController
{
    #[Route('/vehicule', name: 'vehicule')]
    public function index(): Response
    {
        return $this->render('vehicule/index.html.twig', [
            'controller_name' => 'VehiculeController',
        ]);
    }
      /**
     * * @Route (
     *     name="addVehicule",
     *      path="/api/admin/vehicule",
     *      methods={"POST"},
     *     defaults={
     *           "__controller"="App\Controller\VehiculeController::addVehicule",
     *           "__api_ressource_class"=Vehicules::class,
     *           "__api_collection_operation_name"="add_vehicule"
     *         }
     * )
     */
    public function addVehicule(SerializerInterface $serializer,Request $request,
     EntityManagerInterface $manager,ClientsRepository $clientsRepository,
     ModeleVehiculeRepository $modele, MarquesRepository $marque,TypesRepository $type)
    {
        $json = json_decode($request->getContent(),'json');
      //  $json=$serializer->decode($request,"json");  
       // $json = $request->request->all();
       //dd($json['modele'][0]['marque'][0]['libelle']);
       $dat=new \DateTime($json['dmc']);
       $newVehicule = new Vehicules();
       $newVehicule->setImmatriculation($json['immatriculation']);
       $newVehicule->setChassis($json['chassis']);
       $newVehicule->setNumeroMoteur($json['numeroMoteur']);
       $newVehicule->setNumeroBC($json['numeroBc']);
       $newVehicule->setDmc($dat);
               $idModel = $modele->findOneBy(['libelle'=>$json['modele'][0]['libelle']]);
               if($idModel){
                  $newVehicule->setModele($idModel);
               }else{
                $idmarque = $marque->findOneBy(['libelle'=>$json['modele'][0]['marque'][0]['libelle']]);
                $newModele = new ModeleVehicule();
                $newModele->setLibelle($json['modele'][0]['libelle']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($newModele);
                if ($idmarque) {
                   $newModele->setMarque($idmarque);
                 }else{
                     $newMarque = new Marques();
                     $newMarque->setLibelle($json['modele'][0]['marque'][0]['libelle']);
                     $em = $this->getDoctrine()->getManager();
                     $em->persist($newMarque);
                 }
               }

               $idClient = $clientsRepository->find((int)$json['client'][0]['id']);
                    if($idClient){
                      $newVehicule->setClient($idClient);
                    }else{
                      
                  

        $id = $clientsRepository->findOneBy([],['id'=>'desc']);
        $idType = $type->find((int)$json['client'][0]['type']);
        $lastId = $id->getId()+ 1;
       // dd($lastId);
        $zero = "41100";
        $mat = $zero .= $lastId;
        //dd($mat);
       // $idType = $type->find((int)  $json['type']);
                $newClient = new Clients();
                $newClient->setNom($json['client'][0]['nom'])
                ->setPrenom($json['client'][0]['prenom'])
                ->setMatricule($mat)
                ->setEmail($json['client'][0]['email'])
                ->setTelephone($json['client'][0]['telephone'])
                ->setContact($json['client'][0]['contact'])
                ->setAdresse($json['client'][0]['adresse'])
                ->setType($idType);
                $em = $this->getDoctrine()->getManager();
                $em->persist($newClient);
                $newVehicule->setClient($newClient);
                
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($newVehicule);
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
