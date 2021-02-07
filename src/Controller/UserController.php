<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CallApiController
 * @package App\Controller
 * @Route("/users", name="user_")
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $userPasswordEncoder)
    {

        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @Route("/", name="index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $users = $this->userRepository->findUsers();
        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/new", name="new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return $this->redirectToRoute('user_new');
        }
        return $this->render('user/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id<^\d+$>}", name="update")
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws NonUniqueResultException
     */
    public function update(Request $request, int $id): Response
    {
        $user = new User();
        $userInfo = $this->userRepository->findUserById($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->all();
            if (!$data || !array_key_exists('user', $data)) {
                return $this->redirectToRoute('user_update', ['id' => $id]);
            }
            $data = $data['user'];
            $userInfo = $this->userRepository->findUserById($id, AbstractQuery::HYDRATE_OBJECT);
            $userInfo->setTitle($data['title']);
            $userInfo->setEmail($data['email']);
            $userInfo->setMobilePhone($data['mobilePhone']);
            $userInfo->setName($data['name']);
            $userInfo->setRoles($data['roles']);
            $userInfo->setPassword($this->userPasswordEncoder->encodePassword($userInfo, $data['password']));
            $this->entityManager->persist($userInfo);
            $this->entityManager->flush();
            return $this->redirectToRoute('user_update', ['id' => $id]);
        }
        return $this->render('user/update.html.twig', [
            'form' => $form->createView(),
            'userInfo' => $userInfo
        ]);
    }


}
