<?php

namespace App\Controller;

use App\Entity\Pictures;
use App\Repository\PicturesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class CallApiController
 * @package App\Controller
 * @Route("/", name="home_")
 * @IsGranted("ROLE_USER")
 */
class HomeController extends AbstractController
{

    /**
     * @var PicturesRepository
     */
    private $picturesRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(PicturesRepository $picturesRepository, EntityManagerInterface $entityManager)
    {

        $this->picturesRepository = $picturesRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $pictures = $this->picturesRepository->findPictures();
        return $this->render('home/index.html.twig', [
            'pictures' => $pictures,
        ]);
    }

    /**
     * @Route("/new-picture", name="newpicture")
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function addPicture(Request $request): RedirectResponse
    {
        if (!$_FILES) {
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

        $fileName = time() . random_int(10000, 100000) . $_FILES['image']['name'];
        $tmpFile = $_FILES['image']['tmp_name'];
        $fileType = $_FILES['image']['type'];
        $fileSize = $_FILES['image']['size'];
        $fileError = $_FILES['image']['error'];
        $acceptedImageType = ['image/png', 'image/jpg', 'image/jpeg'];
        if ($fileError) {
            $message = 'An error occured when uploading picture. Please try later again!';
            $this->addFlash('error', $message);
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        if (!in_array($fileType, $acceptedImageType)) {
            $message = 'Please select the image in .jpeg, .jpg or .png format!';
            $this->addFlash('error', $message);
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        if ($fileSize > (5 * 1024 * 1024)) {
            $message = 'Please select an image of 5 MB or below!';
            $this->addFlash('error', $message);
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        $uploadFolderPath = __DIR__ . '/../../public/assets/uploadedFiles/' . $fileName;
        $uploadFilePath = 'assets/uploadedFiles/' . $fileName;

        if (move_uploaded_file($tmpFile, $uploadFolderPath)) {
            $picture = new Pictures();
            $picture->setPath($uploadFilePath);
            $this->entityManager->persist($picture);
            $this->entityManager->flush();
            if (!$picture->getId()) {
                $this->addFlash('error', 'An error occurred while saving the image!');
                $referer = $request->headers->get('referer');
                return $this->redirect($referer);
            }
            $this->addFlash('success', 'Image uploaded successfully');
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        $this->addFlash('error', 'An error occurred while uploading the image!');
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    /**
     * @Route("/delete-picture/{id<^\d+$>}", name="deletepicture")
     * @param int $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function deletePicture(int $id, Request $request): RedirectResponse
    {
        $picture = $this->picturesRepository->find($id);
        if (!$picture) {
            $this->addFlash('error', 'No image to delete!');
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

        $picture->setIsActive(false);
        $this->entityManager->persist($picture);
        $this->entityManager->flush();

        $this->addFlash('success', 'Image successfully deleted!');
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);

    }

    /**
     * @Route("/activate-picture/{id<^\d+$>}", name="activatepicture")
     * @param int $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function activatePicture(int $id, Request $request): RedirectResponse
    {
        $picture = $this->picturesRepository->find($id);
        if (!$picture) {
            $this->addFlash('error', 'No image to activate!');
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

        $picture->setIsActive(true);
        $this->entityManager->persist($picture);
        $this->entityManager->flush();

        $this->addFlash('success', 'Picture activated successfully!');
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);

    }
}
