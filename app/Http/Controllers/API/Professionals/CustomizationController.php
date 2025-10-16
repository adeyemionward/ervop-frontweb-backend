<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Website\AI\ClientBaseController;
use Illuminate\Http\Request;
use App\Services\DeepSeekService;
use Illuminate\Support\Facades\Auth;

class CustomizationController extends ClientBaseController
{
    protected $deepSeekService;

    public function __construct(DeepSeekService $deepSeekService)
    {
        $this->deepSeekService = $deepSeekService;
    }

    public function getAllSections()
    {
        $userId = Auth::id();
        $data = [
            'home'      => $this->deepSeekService->getPageContent($userId, 'home'),
            'about'     => $this->deepSeekService->getPageContent($userId, 'about'),
            'services'  => $this->deepSeekService->getPageContent($userId, 'services'),
            'reviews'   => $this->deepSeekService->getPageContent($userId, 'reviews'),
            'faq'       => $this->deepSeekService->getPageContent($userId, 'faq'),
            // 'contact'   => $this->deepSeekService->getPageContent($userId, 'contact'),
             'portfolio' => $this->deepSeekService->getPageContent($userId, 'portfolio'),
            // 'appointment' => $this->deepSeekService->getPageContent($userId, 'appointment'),
        ];

        return response()->json($data);
    }

    public function getSection($section)
    {
        $userId = Auth::id();
        $validSections = ['home', 'about', 'services', 'reviews', 'faq', 'contact', 'portfolio', 'appointment'];

        if (!in_array($section, $validSections)) {
            return response()->json(['error' => 'Invalid section name'], 400);
        }

        $data = $this->deepSeekService->getPageContent($userId, $section);

        return response()->json([$section => $data]);
    }
}
