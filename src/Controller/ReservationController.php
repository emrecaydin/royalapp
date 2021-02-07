<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CallApiController
 * @package App\Controller
 * @Route("/reservation", name="reservation_")
 * @IsGranted("ROLE_USER")
 */
class ReservationController extends AbstractController
{

    /**
     * @var ReservationRepository
     */
    private $reservationRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        ReservationRepository $reservationRepository,
        EntityManagerInterface $entityManager
    ) {

        $this->reservationRepository = $reservationRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [

        ]);
    }

    /**
     * @Route("/reservations", name="reservations")
     * @param Request $request
     * @return JsonResponse
     */
    public function reservations(Request $request): JsonResponse
    {

        $reservations = $this->reservationRepository->findReservations();
        $formatedReservations = [];
        if ($reservations) {
            foreach ($reservations as $reservation) {
                $reservationDate = $reservation['reservationDate']->format('Y-m-d');
                if (!array_key_exists($reservationDate, $formatedReservations)) {
                    $formatedReservations[$reservationDate] = [];
                }
                $formatedReservations[$reservationDate][] = $reservation;
            }
        }

        return $this->json(['success' => true, 'data' => $formatedReservations, 'message' => 'success']);
    }

    /**
     * @Route("/new", name="new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $reservation = new Reservation();
        $queryDate = $request->query->get('date');
        $form = $this->createForm(ReservationType::class, $reservation);
        if ($queryDate) {
            $form->add('reservationDate', DateType::class, [
                'label' => 'Reservation Date :',
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                'format' => 'dd-MM-yyyy',
                'data' => new \DateTime($queryDate)
            ]);
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->all();
            $reservationDate = $data['reservation']['reservationDate'];
            $day = $reservationDate['day'] < 10 ? '0' . $reservationDate['day'] : $reservationDate['day'];
            $month = $reservationDate['month'] < 10 ? '0' . $reservationDate['month'] : $reservationDate['month'];
            $year = $reservationDate['year'];
            $reservationDate = $year . '-' . $month . '-' . $day;
            $today = date('Y-m-d');
            if ($today > $reservationDate) {
                $this->addFlash('error', 'You cannot make reservations for the past day!');
                return $this->redirectToRoute('reservation_new');
            }
            $reservationDateTime = $year . '-' . $month . '-' . $day . ' ' . date('H:i:s');
            $reservationsOnThatDay = $this->reservationRepository->findReservationsByDate($reservationDate);
            if (is_array($reservationsOnThatDay) && count($reservationsOnThatDay) >= 10) {
                $this->addFlash('error', 'The reservation for today is full. Please select another day!');
                return $this->redirectToRoute('reservation_new');
            }
            $reservation->setReservationDate(new \DateTime($reservationDateTime));
            $reservation->setAdmin($this->getUser());
            $this->entityManager->persist($reservation);
            $this->entityManager->flush();
            $this->addFlash('success', 'Registration successful!');
            return $this->redirectToRoute('reservation_new');
        }

        return $this->render('reservation/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/date/{date}", name="reservations_date")
     * @param Request $request
     * @param string $date
     * @return Response
     */
    public function reservationsForDate(Request $request, string $date): Response
    {
        $reservations = $this->reservationRepository->findReservationsByDate($date);
        return $this->render('reservation/reservations.html.twig', [
            'reservations' => $reservations
        ]);
    }

    /**
     * @Route("/delete/{id<\d+$>}", name="delete")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function deleteReservation(Request $request, int $id): Response
    {
        $reservation = $this->reservationRepository->find($id);
        if ($reservation) {
            $reservation->setIsActive(false);
            $this->entityManager->persist($reservation);
            $this->entityManager->flush();
        }
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    /**
     * @Route("/activate/{id<\d+$>}", name="activate")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function activateReservation(Request $request, int $id): Response
    {
        $reservation = $this->reservationRepository->find($id);
        if ($reservation) {
            $reservation->setIsActive(true);
            $this->entityManager->persist($reservation);
            $this->entityManager->flush();
        }
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }
}
