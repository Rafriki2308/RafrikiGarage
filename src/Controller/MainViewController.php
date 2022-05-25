<?php

namespace App\Controller;


use App\Entity\Car;
use App\Entity\Customer;
use App\Entity\Worksheet;
use App\Form\CarType;
use App\Form\CustomerType;
use App\Form\WorksheetType;
use App\Repository\CarRepository;
use App\Repository\CustomerRepository;
use App\Repository\WorksheetRepository;
use App\Service\MainViewControllerManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Service\FileUploader;

class MainViewController extends AbstractController
{

    /**
     * @Route("/", name="homepage", methods={"GET"})
     */
    public function carInGarage(
        WorksheetRepository $worksheetRepository,
        MainViewControllerManager $mainViewControllerManager
    ): Response
    {
        $worksheetsRaw = $worksheetRepository->findAll();
        $carsInGarage = $mainViewControllerManager->checkCarIsIn($worksheetsRaw);

        return $this->render('Car/carsInGarage.html.twig', [
            'worksheets' => $carsInGarage,
        ]);
    }

    /**
     * @Route("/car/show/all", name="app_car_index", methods={"GET"})
     */
    public function indexCar(
        CarRepository $carRepository,
        MainViewControllerManager $mainViewControllerManager
    ): Response
    {
        $carsRaw = $carRepository->findAll();
        $cars = $mainViewControllerManager->cleanArray($carsRaw);
        $cars = $mainViewControllerManager->cleanUnAcitveCars($cars);

        return $this->render('Car/index.html.twig', [
            'cars' => $cars,
        ]);
    }

    /**
     * @Route("/customer/show_all", name="app_customer_index", methods={"GET"})
     */
    public function indexCustomer(
        CustomerRepository $customerRepository,
        MainViewControllerManager $mainViewControllerManager
    ): Response
    {
        $customersRaw = $customerRepository->findAll();
        $customers = $mainViewControllerManager->cleanArray($customersRaw);
        $customers = $mainViewControllerManager->cleanUnAcitveCustomers($customers);

        return $this->render('Customer/index.html.twig', [
            'customers' => $customers,
        ]);
    }

    /**
     * @Route("/worksheet/show_all", name="app_worksheet_index", methods={"GET"})
     */
    public function indexWorksheet(
        WorksheetRepository $worksheetRepository,
        MainViewControllerManager $mainViewControllerManager
    ): Response
    {
        $worksheetsRaw = $worksheetRepository->findAll();
        $worksheets = $mainViewControllerManager->cleanArray($worksheetsRaw);

        return $this->render('Worksheet/index.html.twig', [
            'worksheets' => $worksheets,
        ]);
    }

    /**
     * @Route("/new/customer", name="app_customer_new", methods={"GET", "POST"})
     */
    public function newCustomer(Request $request, CustomerRepository $customerRepository): Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customerRepository->addCustomer($customer);

            return $this->redirectToRoute('app_customer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Customer/new.html.twig', [
            'customer' => $customer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/new/car/{id}", name="app_car_new", methods={"GET", "POST"})
     */
    public function newCar(
        Request $request,
        CarRepository $carRepository,
        CustomerRepository $customerRepository,
        FileUploader $fileUploader,
        $id
    ): Response
    {
        $customer = $customerRepository->find($id);

        $car = new Car();
        $car->setCustomer($customer);

        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form->get('pictureCar')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $car->setPictureCar($brochureFileName);
            }

            $carRepository->addCar($car);

            return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Car/new.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/new/worksheet/{id}", name="app_worksheet_new", methods={"GET", "POST"})
     */
    public function newWorksheet(
        Request $request,
        CarRepository $carRepository,
        WorksheetRepository $worksheetRepository,
        $id
    ): Response
    {
        $car = $carRepository->find($id);

        $worksheet = new Worksheet();
        $worksheet->setCar($car);

        $form = $this->createForm(WorksheetType::class, $worksheet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $worksheetRepository->add($worksheet);
            return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Worksheet/new.html.twig', [
            'worksheet' => $worksheet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/customer/{id}", name="app_customer_show", methods={"GET"})
     */
    public function showCustomer(Customer $customer): Response
    {
        $car = $customer->getCars();
        return $this->render('Customer/show.html.twig', [
            'customer' => $customer,
            'cars' => $car,
        ]);
    }

    /**
     * @Route("show/car/{id}", name="app_car_show", methods={"GET"})
     */
    public function showCar(Car $car): Response
    {
        $worksheets = $car->getWorksheets();
        return $this->render('Car/show.html.twig', [
            'car' => $car,
            'worksheets' => $worksheets,
        ]);
    }

    /**
     * @Route("show/worksheet/{id}", name="app_worksheet_show", methods={"GET"})
     */
    public function showWorksheet(Worksheet $worksheet): Response
    {
        return $this->render('Worksheet/show.html.twig', [
            'worksheet' => $worksheet,
        ]);
    }

    /**
     * @Route("/search_car_ById", name="app_search_car_ById", methods={"GET"})
     *
     */
    public function searchCarById(Request $request,CarRepository $carRepository)
    {
        $id = $request->query->get("id");

        $car = $carRepository->findOneCarById($id);

        if($car == null){
            return $this->renderForm('Error/car_not_found.html.twig');
        }

        $worksheets = $car->getWorksheets();

        return $this->renderForm('Car/show.html.twig', [
            'car' => $car,
            'worksheets' => $worksheets
        ]);
    }

    /**
     * @Route("/search_car_ByRegPlate", name="app_search_car_ByRegPlate", methods={"GET"})
     *
     */
    public function searchCarByRegPlate(Request $request,CarRepository $carRepository)
    {
        $regPlate = $request->query->get("regPlate");

        $car = $carRepository->findOneCarByRegPlate($regPlate);

        if($car == null){
            return $this->renderForm('Error/car_not_found.html.twig');
        }

        $worksheets = $car->getWorksheets();

        return $this->renderForm('Car/show.html.twig', [
            'car' => $car,
            'worksheets' => $worksheets
        ]);
    }

    /**
     * @Route("/search_car_ByChasisNum", name="app_search_car_ByChasisNum", methods={"GET"})
     *
     */
    public function searchCarByChasisNum(Request $request,CarRepository $carRepository)
    {
        $chasisNum = $request->query->get("chasisNum");

        $car = $carRepository->findOneCarByChasisNum($chasisNum);

        if($car == null){
            return $this->renderForm('Error/car_not_found.html.twig');
        }

        $worksheets = $car->getWorksheets();

        return $this->renderForm('Car/show.html.twig', [
            'car' => $car,
            'worksheets' => $worksheets
        ]);
    }

    /**
     * @Route("/searchByID_customer", name="app_searchById_customer", methods={"GET", "POST"})
     *
     */
    public function searchCustomerById(Request $request, CustomerRepository $customerRepository)
    {
        $idForm = $request->query->get("id");
        $customer = $customerRepository->findOneCustomerById($idForm);

        if($customer == null){
            return $this->renderForm('Error/customer_not_found.html.twig');
        }
        $cars = $customer->getCars();

        return $this->renderForm('Customer/show.html.twig', [
            'customer' => $customer,
            'cars' => $cars
        ]);
    }

    /**
     * @Route("/searchByIdCard_customer", name="app_searchByIdCard_customer", methods={"GET", "POST"})
     *
     */
    public function searchCustomerByIdCard(Request $request, CustomerRepository $customerRepository)
    {
        $idForm = $request->query->get("idCard");
        $customer = $customerRepository->findOneCustomerByIdCard($idForm);

        if($customer == null){
            return $this->renderForm('Error/customer_not_found.html.twig');
        }
        $cars = $customer->getCars();

        return $this->renderForm('Customer/show.html.twig', [
            'customer' => $customer,
            'cars' => $cars
        ]);
    }

    /**
     * @Route("/searchById_worksheet", name="app_search_worksheet_ByWorksheetNum", methods={"GET"})
     *
     */
    public function searchWorksheetByWorksheetNum(Request $request, WorksheetRepository $worksheetRepository)
    {
        $worksheetNum = $request->query->get('worksheetNum');

        $worksheet = $worksheetRepository->findOneWorksheetByWorksheetNum($worksheetNum);

        if($worksheet == null){
            return $this->renderForm('Error/worksheet_not_found.html.twig');
        }

        return $this->renderForm('Worksheet/show.html.twig', [
            'worksheet' => $worksheet,
        ]);
    }

    /**
     * @Route("/searchByRegPlate_worksheet/serch", name="app_search_worksheet_ByRegPlate", methods={"GET"})
     *
     */
    public function searchWorksheetByRegPlate(
        Request $request,
        WorksheetRepository $worksheetRepository,
        CarRepository $carRepository
    )
    {
        $regPlate = $request->query->get('worksheetRegPlate');

        $car = $carRepository->findOneCarByRegPlate($regPlate);

        if($car == null){
            return $this->renderForm('Error/worksheet_not_found.html.twig');
        }

        $worksheets = $car->getWorksheets();

        return $this->renderForm('Worksheet/index.html.twig', [
            'car' => $car,
            'worksheets' => $worksheets
        ]);
        //return new Response($regPlate);
    }

    /**
     * @Route("customer/{id}/edit", name="app_customer_edit", methods={"GET", "POST"})
     */
    public function editCustomer(Request $request, Customer $customer, CustomerRepository $customerRepository): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customerRepository->addCustomer($customer);

            return $this->redirectToRoute('app_customer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Customer/edit.html.twig', [
            'customer' => $customer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("car/{id}/edit", name="app_car_edit", methods={"GET", "POST"})
     */
    public function editCar(
        Request $request,
        Car $car,
        CarRepository $carRepository,
        FileUploader $fileUploader
    ): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form->get('pictureCar')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $car->setPictureCar($brochureFileName);
            }
            $carRepository->addCar($car);

            return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Car/edit.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    /**
     * @Route("worksheet/{id}/edit", name="app_worksheet_edit", methods={"GET", "POST"})
     */
    public function editWorksheet(
        Request $request,
        Worksheet $worksheet,
        WorksheetRepository $worksheetRepository
    ): Response
    {
        $form = $this->createForm(WorksheetType::class, $worksheet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $worksheetRepository->add($worksheet);
            return $this->redirectToRoute('app_worksheet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Worksheet/edit.html.twig', [
            'worksheet' => $worksheet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("customer/{id}/delete", name="app_customer_delete", methods={"POST"})
     */
    public function deleteCustomer(Request $request, Customer $customer, CustomerRepository $customerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$customer->getId(), $request->request->get('_token'))) {
            $customerRepository->remove($customer);
        }

        return $this->redirectToRoute('app_customer_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("car/{id}/delete", name="app_car_delete", methods={"POST"})
     */
    public function deleteCar(Request $request, Car $car, CarRepository $carRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $carRepository->remove($car);
        }

        return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/worksheet/{id}/delete", name="app_worksheet_delete", methods={"POST"})
     */
    public function deleteWorksheet(
        Request $request,
        Worksheet $worksheet,
        WorksheetRepository $worksheetRepository
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$worksheet->getId(), $request->request->get('_token'))) {
            $worksheetRepository->remove($worksheet);
        }

        return $this->redirectToRoute('app_worksheet_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/customer/{id}/softDelete", name="app_customer_softDelete", methods={"POST"})
     */
    public function softDeleteCustomer(
        Request $request,
        Customer $customer,
        Car $cars,
        Worksheet $worksheets,
        CustomerRepository $customerRepository,
        CarRepository $carRepository,
        WorksheetRepository $worksheetRepository
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$customer->getId(), $request->request->get('_token'))) {
            if($customer->getIsActive()){
                $customer->setIsActive(false);
                $cars = $customer->getCars();

                foreach ($cars as $car){
                    if($car->getIsActive()){
                        $worksheets = $car->getWorksheets();
                        foreach ($worksheets as $worksheet){
                            if($worksheet->getIsActive()){
                                $worksheet->setIsActive(false);
                                $worksheetRepository->add($worksheet);
                            }
                        }
                        $car->setIsActive(false);
                        $carRepository->addCar($car);
                    }
                }
                $customer->setIsActive(false);
                $customerRepository->addCustomer($customer);
            }
        }

        return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/car/{id}/softCar", name="app_customer_softCar", methods={"POST"})
     */
    public function softDeleteCar(
        Request $request,
        Car $car,
        Worksheet $worksheet,
        CarRepository $carRepository,
        WorksheetRepository $worksheetRepository
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            if ($car->getIsActive()) {
                $worksheets = $car->getWorksheets();

                foreach ($worksheets as $worksheet) {
                    if ($worksheet->getIsActive()) {
                        $worksheet->setIsActive(false);
                        $worksheetRepository->add($worksheet);
                    }
                }
                $car->setIsActive(false);
                $carRepository->addCar($car);
            }
        }

        return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/worksheet/{id}/softDelete", name="app_worksheet_softDelete", methods={"POST"})
     */
    public function softDeleteWorksheet(
        Request $request,
        Worksheet $worksheet,
        WorksheetRepository $worksheetRepository
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$worksheet->getId(), $request->request->get('_token'))) {
            if($worksheet->getIsActive()){
                $worksheet->setIsActive(false);
                $worksheetRepository->add($worksheet);
            }
        }

        return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/worksheet/print/{id}", name="app_worksheet_print", methods={"GET"})
     */
    public function printWorksheet(
        Worksheet $worksheet
    ): Response
    {

        $pictureRoute = __DIR__ . "/../../public/assets/RafrikiGarage.png";
        $binaryContent = file_get_contents($pictureRoute);
        $pictureBase64 = base64_encode($binaryContent);

        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $options->setIsHtml5ParserEnabled(true);

        $pdf = new Dompdf($options);
        $pdf->setPaper('A4');

        $html = ob_get_clean();
        $html = $this->renderView('Worksheet/print_form.html.twig', [
            'worksheet' => $worksheet,
            'ruta_imagen' => $pictureBase64,
        ]);
        $pdf->loadHtml($html);
        $pdf->render();

        return new Response($pdf->stream('Hoja_de_Trabajo.pdf', [
            "Attachment" => false
        ]));
    }

}

