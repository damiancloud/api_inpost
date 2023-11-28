<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

use App\Service\Inpost;
use App\Validator\Inpost\Constraints\StreetRequiresPostalCode;
use App\Form\Inpost\DataTransformer\CityTransformer;

class InpostController extends AbstractController
{
    #[Route('search', name: "search")]
    /**
     * @param  Request $request
     * @param  Inpost $inpostService
     * @return Response
     */
    public function searchPickupPoints(Request $request, Inpost $inpostService): Response
    {
        $builder = $this->createFormBuilder();
        $builder = $builder
            ->add('street', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length(['min' => 3, 'max' => 255]),
                    // If the street is provided, require the postal code. 
                    new StreetRequiresPostalCode(),
                ],
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3, 'max' => 255]),
                ],
            ]);

        $builder->get('city')->addModelTransformer(new CityTransformer());

        $builder->add('postal_code', TextType::class, [
            'required' => false,
            'constraints' => [
                new Regex(['pattern' => '/^\d{2}-\d{3}$/']),
            ],
        ])
            ->add('search', SubmitType::class, ['label' => 'Search']);

        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $inpostData = $inpostService->getData('points', 'city', $formData['city']);

            $searchResults = $inpostService->findItems($inpostData, $formData);
            return $this->render('inpost/search_results.html.twig', [
                'form' => $form->createView(),
                'results' => $searchResults,
            ]);
        }

        return $this->render('inpost/search_form.html.twig', [
            'form' => $form->createView(),
            'results' => null,
        ]);
    }
}