<?php

namespace App\Http\Controllers\Website\AI;

use App\Http\Controllers\Website\AI\ClientBaseController;
use App\Models\WebsiteContent;
use App\Services\DeepSeekService;
use Illuminate\Http\Request;

class HomeController extends ClientBaseController
{
    protected $deepSeekService;

    public function __construct(DeepSeekService $deepSeekService)
    {
        parent::__construct(); // 👈 required to load user/userId

        $this->deepSeekService = $deepSeekService;
    }

    public function home(){
        $homeContent = $this->deepSeekService->getPageContent($this->userId, 'home');
        $aboutContent = $this->deepSeekService->getPageContent($this->userId, 'about');
        $serviceContent = $this->deepSeekService->getPageContent($this->userId, 'services');
        $reviewContent = $this->deepSeekService->getPageContent($this->userId, 'reviews');
        //   dd($reviewContent);
        return view('aiwebsite.index', compact('homeContent','aboutContent','serviceContent','reviewContent'));
    }

    public function about(){
        $aboutContent = $this->deepSeekService->getPageContent($this->userId, 'about');
       // dd($aboutContent);
        return view('aiwebsite.about', compact('aboutContent'));
    }

    public function services(){
        $serviceContent = $this->deepSeekService->getPageContent($this->userId, 'services');
        $processContent = $this->deepSeekService->getPageContent($this->userId, 'home');
       // dd($aboutContent);
        return view('aiwebsite.services', compact('serviceContent','processContent'));
    }

// public function serviceDetails($username, $serviceName)
// {
//     // Get all service content for the user
//     $serviceContent = $this->deepSeekService->getPageContent($this->userId, 'services');
//     $processContent = $this->deepSeekService->getPageContent($this->userId, 'home');

//    // dd($serviceContent);
//     $serviceDetailsRaw = $serviceContent['service_details']['services']['service_details'] ?? [];
//     $services = [];

//     // Build the $services array
//     foreach ($serviceDetailsRaw['service_name'] ?? [] as $index => $name) {
//         $services[$index]['name'] = $name;
//         $services[$index]['headline'] = $serviceDetailsRaw['headline'][$index] ?? '';
//         $services[$index]['subheadline'] = $serviceDetailsRaw['subheadline'][$index] ?? '';
//         $services[$index]['description'] = $serviceDetailsRaw['service_description'][$index] ?? '';

//         // What's Included
//         $services[$index]['included'] = [];
//         $i = 1;
//         while (isset($serviceDetailsRaw["what's_included_{$index}_{$i}"])) {
//             $services[$index]['included'][] = $serviceDetailsRaw["what's_included_{$index}_{$i}"];
//             $i++;
//         }

//         // Who it's for
//         $services[$index]['who_for'] = $serviceDetailsRaw["who_it's_for_{$index}"] ?? '';
//     }

//     ksort($services); // optional: sort by index

//     // Normalize requested service name for matching
//     $requestedServiceName = str_replace('-', ' ', $serviceName);
//     $serviceDetail = null;

//     foreach ($services as $service) {
//         $normalizedName = str_replace([' ', '-', '_'], '', strtolower($service['name']));
//         $normalizedRequested = str_replace([' ', '-', '_'], '', strtolower($requestedServiceName));

//         if ($normalizedName === $normalizedRequested) {
//             $serviceDetail = $service;
//             break;
//         }
//     }

//     if (!$serviceDetail) {
//         abort(404, 'Service not found');
//     }

//     return view('aiwebsite.service_detail', compact('serviceDetail', 'processContent'));
// }





    public function faqs(){
        $faqContent = $this->deepSeekService->getPageContent($this->userId, 'faq');
        //  dd($faqContent);
        return view('aiwebsite.faq', compact('faqContent'));
    }

    public function contact(){
        $contactContent = $this->deepSeekService->getPageContent($this->userId, 'contact');
        //  dd($contactContent);
        return view('aiwebsite.contact', compact('contactContent'));
    }

    public function portfolio(){
        return view('aiwebsite.portfolio');
    }

    public function scheduleAppointment(){
        return view('aiwebsite.appointment');
    }

}
