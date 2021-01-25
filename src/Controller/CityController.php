<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\CityType;
use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    /**
     * @Route("/city", name="city")
     */
    public function index(CityRepository $repo)
    {
        $cities = $repo->findAll();
        return $this->render('city/index.html.twig', [
            "cities" => $cities,
        ]);
    }

    /**
     * @Route("/city/create",name="city_create")
     * @Route("/city/update/{id}",name="city_update")
     */
    public function create(Request $request, City $city = null)
    {
        if (!$city) {
            $city = new City();
        }

        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($city);
            $manager->flush();

            $this->addFlash("success", "Ville ajoutée");

            return $this->redirectToRoute('city');
        }

        return $this->render('city/create.html.twig', [
            'CityForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/city/delete/{id}",name="city_delete")
     */
    public function delete(City $city)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($city);
        $manager->flush();
    }

    /**
     * @Route("/test",name="test")
     */
    public function test()
    {
        $myfile = file_get_contents("../public/cities.json");
        $json_a = json_decode($myfile, true);
        $array = [];
        foreach ($json_a as $k => $v) {
            array_push($array, $v);
        }


        $tr = count($array);
        $manager = $this->getDoctrine()->getManager();
        foreach ($array as $item){
            $city = new City();

            $city->setName($item['name'])
            ->setLongitude($item['lng'])
            ->setLatitude($item['lat']);
            $manager->persist($city);
            $manager->flush();


        };

        return $this->render('city/test.html.twig',['test'=>$tr]);
    }
}
