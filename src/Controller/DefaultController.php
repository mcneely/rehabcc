<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Hospital;
use App\Form\ContactType;
use App\Repository\HospitalRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     * @Template()
     */
    public function index()
    {
        return [
            'controller_name' => 'DefaultController',
        ];
    }

    /**
     * @Route("/hospitalList", name="hospital_list")
     * @Template()
     * @param HospitalRepository $hospitalRepository
     * @return array
     */
    public function hospitalListAction(HospitalRepository $hospitalRepository)
    {
        $hospitals = $hospitalRepository->findBy([], ["Name" => 'ASC']);

        return [
            'hospitals' => $hospitals,
        ];
    }

    /**
     * @Route("/hospitalView/{id}", name="hospital_view")
     * @Template()
     * @param Hospital $hospital
     * @param Request  $request
     * @return array
     */
    public function hospitalViewAction(Hospital $hospital, Request $request)
    {
        $message = null;

        $contact = new Contact();
        $contact->setHospital($hospital);
        $form    = $this->createForm(ContactType::class, $contact);
        $form->add(
            'submit',
            SubmitType::class,
            ['label' => 'Send']
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            $message = "Contact Form Sent.";
        }

        return [
            "message"  => $message,
            'hospital' => $hospital,
            'form'     => $form->createView(),
        ];
    }

}
