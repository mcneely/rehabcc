<?php

namespace App\Controller;

use App\Entity\Hospital;
use App\Form\HospitalType;
use App\Repository\ContactRepository;
use App\Repository\HospitalRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     * @Template()
     * @param HospitalRepository $hospitalRepository
     * @return array
     */
    public function index(HospitalRepository $hospitalRepository, ContactRepository $contactRepository)
    {
        return [
            'hospitals' => $hospitalRepository->findBy([], ["Name" => 'ASC']),
            'contacts'  => $contactRepository->findAll(),
        ];
    }

    /**
     * @Route("/createHospital", name="create_hospital")
     * @Template("admin/hospitalform.html.twig")
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function createHospitalAction(Request $request)
    {
        $hospital = new Hospital();

        return $this->buildHospitalForm('Create', $hospital, $request);
    }

    /**
     * @Route("/updateHospital/{id})", name="update_hospital")
     * @Template("admin/hospitalform.html.twig")
     * @param Hospital $hospital
     * @param Request  $request
     * @return array|RedirectResponse
     */
    public function updateHospitalAction(Hospital $hospital, Request $request)
    {
        return $this->buildHospitalForm('Update', $hospital, $request);
    }


    /**
     * @Route("/deleteHospital/{id}", name="delete_hospital")
     * @param Hospital $hospital
     * @return RedirectResponse
     */
    public function deleteHospitalAction(Hospital $hospital)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($hospital);
        $entityManager->flush();

        return $this->redirectToRoute('admin');
    }


    private function buildHospitalForm(string $submitLabel, Hospital $hospital, Request $request)
    {
        $form = $this->createForm(HospitalType::class, $hospital);
        $form->add('submit', SubmitType::class, [
            'label' => $submitLabel,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hospital);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return [
            'form' => $form->createView(),
        ];
    }


}
