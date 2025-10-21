<?php

namespace App\Http\Controllers\API\Auth;

use App\Enum\BusinessType;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AccountOTPService;
use App\Services\DeepSeekService;
use App\Traits\Functions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    use Functions;

    protected $deepSeekService;

    public function __construct(DeepSeekService $deepSeekService)
    {
        $this->deepSeekService = $deepSeekService;
    }
    public function register(Request $request)
    {
        // Validate the request data

        $validator = Validator::make($request->all(), [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'businessType' => ['required', 'string', Rule::in(BusinessType::values())],
            'businessName' => ['required', 'string', 'max:255', 'unique:users,business_name'],
            'industry' => ['required', 'string', 'max:255'],
            'ervopUrl' => ['required', 'string', 'unique:users,ervop_url'],
            'currency' => ['required', 'string'],
            'needWebsite' => ['nullable', 'string'],
            'businessDescription' => ['nullable', 'string', 'max:400'],
            'email' => ['required_if:business_type,professional,hybrid', 'nullable', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:15', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'=>false,
                'errors' => $validator->errors()
            ], 422);
        }


        try {
            // Create the user
            $user = User::create([
                'firstname' => $request->input('firstName'),
                'lastname' => $request->input('lastName'),
                'business_type' => $request->input('businessType'),
                'business_name' => $request->input('businessName'),
                'business_industry' => $request->input('industry'),
                'ervop_url' => $request->input('ervopUrl'),
                'currency' => $request->input('currency'),
                'need_website' => $request->input('needWebsite'), // 'yes' or 'no'
                'business_description' => $request->input('businessDescription'),
                'website' => $request->input('website'), // optional
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => bcrypt($request->input('password')),
            ]);

            Log::info("User created successfully. ID: {$user->id}");

            $websiteGenerated = false;

            // Generate AI website content only if the user requested a website
            if ($request->input('needWebsite') == 'yes') {
                try {
                    //Log::info("Starting AI content generation for user: {$user->id}");

                    // $websiteContent = $this->deepSeekService->generateAndStoreBusinessContent(
                    //     $user->id,
                    //     $user->business_name,
                    //     $user->business_industry,
                    //     $user->business_description,
                    //     $user->currency
                    // );

                    // $websiteGenerated = !empty($websiteContent);

                    // Log::info("AI content generation completed. Success: " . ($websiteGenerated ? 'YES' : 'NO'));

                    // if ($websiteGenerated) {
                    //     Log::info("Generated pages: " . implode(', ', array_keys($websiteContent)));
                    // } else {
                    //     Log::warning("AI content generation returned empty result");
                    // }

                } catch (\Exception $aiException) {
                    Log::error("AI content generation failed: " . $aiException->getMessage());
                    Log::error("AI Exception: " . $aiException->getTraceAsString());
                    // $websiteGenerated = false;
                }
            } else {
                Log::info("User opted out of website creation.");
            }

            // Send OTP to email
            $this->sendEmailOTP($user->email);

            return response()->json([
                'message' => 'User created successfully' . ($websiteGenerated ? ' and website content generated' : ''),
                'status' => true,
                'user' => $user,
                'website_generated' => $websiteGenerated,
            ], 201);

        } catch (\Exception $e) {
            Log::error('User registration failed: ' . $e->getMessage());
            Log::error('Registration Exception: ' . $e->getTraceAsString());

            return response()->json([
                'message' => 'User registration failed',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
}

    }

    public function secondStepValidation()
    {
        $errors = [];

        if ($this->isEmailExist()) {
            $errors['email'] = 'This email is already in use.';
        }

        if ($this->isPhoneExist()) {
            $errors['phone'] = 'This phone is already in use.';
        }

        if (!empty($errors)) {
            return response()->json([
                'status' => false,
                'errors' => $errors
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Validation passed.'
        ]);
    }


    public function otpVerification(Request $request, AccountOTPService $accountOTPService){

        return $accountOTPService->postOtpVerification($request);
    }

    // --------------------------AI WEBSITE---------------------------//
    /**
     * Generate complete website for a business (if needed separately)
     */
    public function generateCompleteWebsite(Request $request, $businessId)
    {
        try {
            $business = User::findOrFail($businessId); // Using User model since you're storing business data in users table

            // Generate ALL pages content
            $websiteContent = $this->deepSeekService->generateAndStoreBusinessContent(
                $business->id,
                $business->business_name,
                $business->business_industry,
                $business->business_description,
                $business->currency
            );

            return response()->json([
                'success' => true,
                'business_id' => $business->id,
                'content' => $websiteContent,
                'message' => 'Website content generated successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Website generation failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate website content: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate specific page for a business
     */
    public function generatePage(Request $request, $businessId, $page)
    {
        try {
            $business = User::findOrFail($businessId); // Using User model

            $pageContent = $this->deepSeekService->generatePageContent(
                $business->id,
                $business->business_name,
                $business->business_industry,
                $business->business_description,
                $business->currency,
                $page
            );

            return response()->json([
                'success' => true,
                'business_id' => $business->id,
                'page' => $page,
                'content' => $pageContent,
                'message' => "{$page} page content generated successfully"
            ]);

        } catch (\Exception $e) {
            Log::error("Page generation failed for {$page}: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => "Failed to generate {$page} page content"
            ], 500);
        }
    }

    /**
     * Get stored website content for display
     */
    public function getWebsiteContent($businessId)
    {
        try {
            $business = User::findOrFail($businessId); // Using User model
            $websiteContent = $this->deepSeekService->getBusinessContent($business->id);

            return response()->json([
                'success' => true,
                'business' => $business,
                'content' => $websiteContent
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve website content'
            ], 500);
        }
    }

    /**
     * Get specific page content for display
     */
    public function getPageContent($businessId, $page)
    {
        try {
            $business = User::findOrFail($businessId); // Using User model
            $websiteContent = $this->deepSeekService->getBusinessContent($business->id, $page);

            return response()->json([
                'success' => true,
                'business' => $business,
                'page' => $page,
                'content' => $websiteContent[$page] ?? []
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve page content'
            ], 500);
        }
    }

    /**
     * Display website page (for frontend)
     */
    public function showHomepage($businessId)
    {
        try {
            $business = User::findOrFail($businessId); // Using User model
            $content = $this->deepSeekService->getBusinessContent($business->id, 'home');

            return view('websites.home', [
                'business' => $business,
                'content' => $content['home'] ?? []
            ]);

        } catch (\Exception $e) {
            abort(404, 'Website not found');
        }
    }

    public function showFaqPage($businessId)
    {
        try {
            $business = User::findOrFail($businessId); // Using User model
            $content = $this->deepSeekService->getBusinessContent($business->id, 'faq');

            return view('websites.faq', [
                'business' => $business,
                'content' => $content['faq'] ?? []
            ]);

        } catch (\Exception $e) {
            abort(404, 'FAQ page not found');
        }
    }

    public function showAboutPage($businessId)
    {
        try {
            $business = User::findOrFail($businessId); // Using User model
            $content = $this->deepSeekService->getBusinessContent($business->id, 'about');

            return view('websites.about', [
                'business' => $business,
                'content' => $content['about'] ?? []
            ]);

        } catch (\Exception $e) {
            abort(404, 'About page not found');
        }
    }

    public function showServicesPage($businessId)
    {
        try {
            $business = User::findOrFail($businessId); // Using User model
            $content = $this->deepSeekService->getBusinessContent($business->id, 'services');

            return view('websites.services', [
                'business' => $business,
                'content' => $content['services'] ?? []
            ]);

        } catch (\Exception $e) {
            abort(404, 'Services page not found');
        }
    }

    public function showContactPage($businessId)
    {
        try {
            $business = User::findOrFail($businessId); // Using User model
            $content = $this->deepSeekService->getBusinessContent($business->id, 'contact');

            return view('websites.contact', [
                'business' => $business,
                'content' => $content['contact'] ?? []
            ]);

        } catch (\Exception $e) {
            abort(404, 'Contact page not found');
        }
    }

    /**
     * Regenerate specific section
     */
    public function regenerateSection(Request $request, $businessId, $page, $section)
    {
        try {
            $business = User::findOrFail($businessId); // Using User model

            // For regeneration, we'll generate just that page
            $pageContent = $this->deepSeekService->generatePageContent(
                $business->id,
                $business->business_name,
                $business->business_industry,
                $business->business_description,
                $business->currency,
                $page
            );

            return response()->json([
                'success' => true,
                'business_id' => $business->id,
                'page' => $page,
                'section' => $section,
                'content' => $pageContent[$section] ?? [],
                'message' => "{$section} section regenerated successfully"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Failed to regenerate {$section} section"
            ], 500);
        }
    }
}
