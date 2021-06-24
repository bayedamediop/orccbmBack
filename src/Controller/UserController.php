<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Admin;
use App\Entity\Profils;
use App\Entity\Vendeur;
use App\Entity\Qualites;
use App\Entity\Customers;
use App\Entity\AteliersVW;
use App\Repository\UserRepository;
use App\Service\UserService;

use App\Services\ValidatorService;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private $encoder;
    private $manager;
    public function  __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager)
    {
        $this->encoder=$encoder;
        $this->manager=$manager;
    }
     /**
     * * @Route (
     *     name="addUser",
     *      path="/api/admin/users",
     *      methods={"POST"},
     *     defaults={
     *           "__controller"="App\Controller\UserController::addUser",
     *           "__api_ressource_class"=User::class,
     *           "__api_collection_operation_name"="add_user"
     *         }
     * )
     */
    public function addUser(SerializerInterface $serializer,Request $request, EntityManagerInterface $manager)
    {
        $user = $request->request->all();
        $img = $request->files->get("avatar");
        if($img){
            $img = fopen($img->getRealPath(), "rb");
        }
        if($user['profils'] === "custome"){
            $userObject = $serializer->denormalize($user, Customers::class);
           

        }elseif( $user['profils'] === "atelier"){
            $userObject = $serializer->denormelize($user, AteliersVW::class);

        }elseif($user['profils'] === "qualite"){
            $userObject = $serializer->denormalize($user, Qualites::class);

        }
      elseif($user['profils'] === "admin"){
            $userObject = $serializer->denormalize($user, Admin::class);

        } /* elseif($user['profils'] === "CLIENT"){
            $userObject = $serializer->denormalize($user, CompteClient::class);

        }else{
            $userObject = $serializer->denormalize($user, Vendeur::class);
        }*/
        $userObject->setAvatar($img);
        $userObject->setProfil($this->manager->getRepository(Profils::class)->findOneBy(['libelle' => $user['profils']]));
        $userObject ->setPassword ($this->encoder->encodePassword ($userObject, $user['password']));
       // $validate->validate($userObject);
       $em = $this->getDoctrine()->getManager();
       $em->persist($userObject);
       $em->flush();

       return $this->json("success",201);
        return $this->json($userObject,Response::HTTP_OK);
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
    // _______________________________archiver un user-------------------------

    /**
     * @Route(
     *  name = "archiveUser",
     *  path = "/api/admin/user/{id}",
     *  methods = {"PUT"},
     *  defaults  = {
     *      "__controller"="App\Controller\UserController::archiveUser",
     *      "__api_ressource_class"=User::class,
     *      "__api_collection_operation_name"="archive_user"
     * }
     * )
     */
    public function archiveUser($id,UserRepository $articleRepository,EntityManagerInterface $manager)
    {
        $user = $articleRepository->find($id);
       // dd($user);
        $user->setArchive(false);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->json("success!!!! User updated",Response::HTTP_OK);

    }
}
