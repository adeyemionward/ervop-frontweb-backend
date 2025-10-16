<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\BusinessContentSection;
use App\Models\WebsiteContent;
use Illuminate\Support\Facades\Log;

class DeepSeekService2
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.deepseek.key');
        $this->baseUrl = config('services.deepseek.base_url', 'https://api.deepseek.com');
        Log::info("DeepSeekService initialized. API Key: " . ($this->apiKey ? 'SET' : 'MISSING'));
    }

    /**
     * MULTI-PAGE PROMPT BUILDER
     */



    protected function buildPrompt(string $page, string $section, array $businessInfo): string
{
        $templates = [
            'home' => [
                'hero' => "Create a complete hero section for {$businessInfo['business_name']} in the {$businessInfo['business_industry']} industry.
                    Business description: {$businessInfo['business_description']}
                    Location: {$businessInfo['business_currency']}

                    Return in this exact format:
                    Tagline: Create a 3-5 word catchy tagline
                    Headline: Write a 6-8 word compelling & copyright headline
                    Subheadline: Provide a 10-15 word engaging & copyright subheadline
                    Image 1 Description: Modern professional workspace with technology elements
                    Image 2 Description: Business team collaboration in office setting

                    Do NOT provide multiple options or alternatives for any element.",


               'why_choose_us' => "Generate exactly 5 value propositions for {$businessInfo['business_name']}.
                    Business strengths: {$businessInfo['business_description']}

                    Return in this exact format:
                    Section Title: Write a 6-8 word compelling & copyright headline
                    Value Propositions:
                        Title_1: [Unique value proposition title 1]
                        Description_1: [18-22 words that explain this specific value and why clients should choose the company]

                        Title_2: [Unique value proposition title 2]
                        Description_2: [18-22 words that explain this specific value and why clients should choose the company]

                        Title_3: [Unique value proposition title 3]
                        Description_3: [18-22 words that explain this specific value and why clients should choose the company]

                        Title_4: [Unique value proposition title 4]
                        Description_4: [18-22 words that explain this specific value and why clients should choose the company]

                        Title_5: [Unique value proposition title 5]
                        Description_5: [18-22 words that explain this specific value and why clients should choose the company]

                        Do NOT provide options or alternatives.",

                'process' => "Create a 4-step business process for {$businessInfo['business_name']} in {$businessInfo['business_industry']}.
                        Business: {$businessInfo['business_description']}

                        Return in this exact format:
                        Section Title: Write a 6-8 word compelling & copyright headline

                        Title_1: [Unique consultation phase title]
                        Description_1: [1-2 sentence description]

                        Title_2: [Unique planning phase title]
                        Description_2: [1-2 sentence description]

                        Title_3: [Unique execution phase title]
                        Description_3: [1-2 sentence description]

                        Title_4: [Unique support phase title]
                        Description_4: [1-2 sentence description]

                        Make titles creative and industry-specific.",
            ],

             // ABOUT PAGE
            'about' => [
                'about_hero' => "Complete about page hero for {$businessInfo['business_name']}:
                                Industry: {$businessInfo['business_industry']}
                                Business Focus: {$businessInfo['business_description']}

                                Headline: [6-8 words about their business mission]
                                Subheadline: [8-10 words summarizing their story from the description]",

                'our_story' => "Generate about us section for {$businessInfo['business_name']}:
                                Industry: {$businessInfo['business_industry']}
                                Business Focus: {$businessInfo['business_description']}

                                Return in this exact format:
                                YoE: Get the years of experience in numbers from the description 
                                Customers Served: Get the numbers of customers from the description that the business has served
                                Headline: Give me an headline for Abou us base on the company and industry and industry
                                About Us: 60-80 words about the company's journey, mission, and values based on the business description and industry context.",


                'team' => "Generate team section for {$businessInfo['business_name']}:
                          Industry: {$businessInfo['business_industry']}
                          Business Type: {$businessInfo['business_description']}

                          Section Title: Team title
                          Team Members:
                          - Founder/Key Role based on description: 1-2 sentences about their expertise in the industry
                          - Service Delivery Role: 1-2 sentences about their role in delivering services
                          - Support Role: 1-2 sentences about customer support/operations",

                'values' => "Define company values for {$businessInfo['business_name']}:
                            Industry Context: {$businessInfo['business_industry']}
                            Business Approach: {$businessInfo['business_description']}

                            Section Title: Values title
                            Values:

                            - Core value from description: Value 1 description - 1 sentence
                            - Industry-specific value: Value 2 description - 1 sentence
                            - Customer-focused value: Value 3 description - 1 sentence",

                'mission' => "Create a mission statement for {$businessInfo['business_name']} in {$businessInfo['business_industry']}.
                            Business: {$businessInfo['business_description']}

                            Return in this exact format:
                            Mission: Clear and concise mission statement in 1-2 sentences",

                'vision' => "Create a vision statement for {$businessInfo['business_name']} in {$businessInfo['business_industry']}.
                            Business: {$businessInfo['business_description']}

                            Return in this exact format:
                            Vision: Inspiring vision statement in 1-2 sentences",

            ],

            'faq' => [
                'faq' => "Generate exactly 10 FAQ items for {$businessInfo['business_name']} in {$businessInfo['business_currency']} ,{$businessInfo['business_industry']}.
                        Business: {$businessInfo['business_description']}

                        Return in this exact format:
                        Section Title: [Creative FAQ section title]
                        
                    
                        Question 1: [Specific question about services or industry]
                        Answer 1: [1-2 sentence answer addressing the question]
                        
                        
                        Question 2: [Specific question about pricing or process]
                        Answer 2: [1-2 sentence answer addressing the question]
                        
                    
                        Question 3: [Specific question about timeline or delivery]
                        Answer 3: [1-2 sentence answer addressing the question]
                        
                    
                        Question 4: [Specific question about expertise or qualifications]
                        Answer 4: [1-2 sentence answer addressing the question]
                        
                        
                        Question 5: [Specific question about support or follow-up]
                        Answer 5: [1-2 sentence answer addressing the question]
                        
                     
                        Question 6: [Specific question about industry-specific concerns]
                        Answer 6: [1-2 sentence answer addressing the question]

                        Question 7: [Specific question about industry-specific concerns]
                        Answer 7: [1-2 sentence answer addressing the question]

                        Question 8: [Specific question about industry-specific concerns]
                        Answer 8: [1-2 sentence answer addressing the question]

                        Question 9: [Specific question about industry-specific concerns]
                        Answer 9: [1-2 sentence answer addressing the question]

                        Question 10: [Specific question about industry-specific concerns]
                        Answer 10: [1-2 sentence answer addressing the question]

                        Do NOT provide multiple options.",
            ],

            // 'services' => [
            //     'services_hero' => "Complete services page hero for {$businessInfo['business_name']}:
            //            Industry: {$businessInfo['business_industry']}
            //            Business Specialty: {$businessInfo['business_description']}

            //            Return in this exact format:
            //            Headline: [6-8 words about their specialized services]
            //            Subheadline: [6-10 words highlighting their expertise from the description]",

            //     'service_details' => "Generate 4 detailed services for {$businessInfo['business_name']}:
            //         Industry: {$businessInfo['business_industry']}
            //         Business Focus: {$businessInfo['business_description']}

            //         Return in this exact format:


            //         Service Name 1: [Creative name for Service 1]
            //         Headline 1: [6-8 words headline about service 1]
            //         Subheadline 1: [6-10 words subheadline about service 1]
            //         Service Description 1: [4-6 sentences with industry context about this specific service]
            //         What's Included_1_1: [Specific item included in Service 1]
            //         What's Included_1_2: [Specific item included in Service 1]
            //         What's Included_1_3: [Specific item included in Service 1]

            //         Who It's For 1: [4-6 sentences describing the specific target audience for Service 1]


            //         Service Name 2: [Creative name for Service 2]
            //         Headline 2: [6-8 words headline about service 2]
            //         Subheadline 2: [6-10 words subheadline about service 2]
            //         Service Description 2: [4-6 sentences with industry context about this specific service]

            //         What's Included_2_1: [Specific item included in Service 2]
            //         What's Included_2_2: [Specific item included in Service 2]
            //         What's Included_2_3: [Specific item included in Service 2]

            //         Who It's For 2: [4-6 sentences describing the specific target audience for Service 2]


            //         Service Name 3: [Creative name for Service 3]
            //         Service Description 3: [4-6 sentences with industry context about this specific service]
            //         What's Included_3_1: [Specific item included in Service 3]
            //         What's Included_3_2: [Specific item included in Service 3]
            //         What's Included_3_3: [Specific item included in Service 3]

            //         Who It's For 3: [4-6 sentences describing the specific target audience for Service 3]


            //         Service Name 4: [Creative name for Service 4]
            //         Service Description 4: [4-6 sentences with industry context about this specific service]
            //         What's Included_4_1: [Specific item included in Service 4]
            //         What's Included_4_2: [Specific item included in Service 4]
            //         What's Included_4_3: [Specific item included in Service 4]

            //         Who It's For 4: [4-6 sentences describing the specific target audience for Service 4]",

            // ],

        'services' => [
                'services_hero' => <<<EOD
            Complete services page hero for {$businessInfo['business_name']}:
            Industry: {$businessInfo['business_industry']}
            Business Specialty: {$businessInfo['business_description']}

            Return in this exact format:
            Headline: [6-8 words about their specialized services]
            Subheadline: [6-10 words highlighting their expertise from the description]
            EOD,

                'service_details' => <<<EOD
            Generate 4 detailed services for {$businessInfo['business_name']}:
            Industry: {$businessInfo['business_industry']}
            Business Focus: {$businessInfo['business_description']}

            Return in this exact format:

            Service Name 1: [Creative name for Service 1]
            Headline 1: [6-8 words headline about service 1]
            Subheadline 1: [6-10 words subheadline about service 1]
            Service Description 1: [4-6 sentences with industry context about this specific service]
            What's Included_1_1: [Specific item included in Service 1]
            What's Included_1_2: [Specific item included in Service 1]
            What's Included_1_3: [Specific item included in Service 1]

            Who It's For 1: [4-6 sentences describing the specific target audience for Service 1]

            Service Name 2: [Creative name for Service 2]
            Headline 2: [6-8 words headline about service 2]
            Subheadline 2: [6-10 words subheadline about service 2]
            Service Description 2: [4-6 sentences with industry context about this specific service]
            What's Included_2_1: [Specific item included in Service 2]
            What's Included_2_2: [Specific item included in Service 2]
            What's Included_2_3: [Specific item included in Service 2]

            Who It's For 2: [4-6 sentences describing the specific target audience for Service 2]

            Service Name 3: [Creative name for Service 3]
            Headline 3: [6-8 words headline about service 3]
            Subheadline 3: [6-10 words subheadline about service 3]
            Service Description 3: [4-6 sentences with industry context about this specific service]
            What's Included_3_1: [Specific item included in Service 3]
            What's Included_3_2: [Specific item included in Service 3]
            What's Included_3_3: [Specific item included in Service 3]

            Who It's For 3: [4-6 sentences describing the specific target audience for Service 3]

            Service Name 4: [Creative name for Service 4]
            Headline 4: [6-8 words headline about service 4]
            Subheadline 4: [6-10 words subheadline about service 4]
            Service Description 4: [4-6 sentences with industry context about this specific service]
            What's Included_4_1: [Specific item included in Service 4]
            What's Included_4_2: [Specific item included in Service 4]
            What's Included_4_3: [Specific item included in Service 4]

            Who It's For 4: [4-6 sentences describing the specific target audience for Service 4]
            EOD,
            ],


            // REVIEWS
            'reviews' => [
                'customer_reviews' => "Generate 5 authentic customer reviews for {$businessInfo['business_name']}:
                        Industry: {$businessInfo['business_industry']}
                        Location: {$businessInfo['business_currency']}
                        Business Focus: {$businessInfo['business_description']}

                        Return in this exact format:


                        Customer Name 1: [Realistic customer fullname that is base on the Location of business]
                        Star Rating 1: [4 or 5 stars]
                        Comment 1: [2-3 sentences describing their positive experience with specific details about the service and results]


                        Customer Name 2: [Realistic customer fullname that is base on the Location of business]
                        Star Rating 2: [4 or 5 stars]
                        Comment 2: [2-3 sentences describing their positive experience with specific details about the service and results]

                        Customer Name 3: [Realistic customer fullname that is base on the Location of business]
                        Star Rating 3: [4 or 5 stars]
                        Comment 3: [2-3 sentences describing their positive experience with specific details about the service and results]


                        Customer Name 4: [Realistic customer fullname that is base on the Location of business]
                        Star Rating 4: [4 or 5 stars]
                        Comment 4: [2-3 sentences describing their positive experience with specific details about the service and results]


                        Customer Name 5: [Realistic customer fullname that is base on the Location of business]
                        Star Rating 5: [4 or 5 stars]
                        Comment 5: [2-3 sentences describing their positive experience with specific details about the service and results]",
            ],

            // CONTACT PAGE
            'contact' => [
                'contact_hero' => "Complete contact page hero for {$businessInfo['business_name']}:
                                  Industry: {$businessInfo['business_industry']}

                                  Headline: [6-8 words about contacting them]
                                  Subheadline: [10-15 words encouraging engagement based on their services]",

                'contact_info' => "Generate contact information for {$businessInfo['business_name']}:
                                  Location Context: {$businessInfo['business_currency']}

                                  Section Title: [Contact title]
                                  Information:
                                  - Phone: [Generate appropriate phone number format for their location]
                                  - Email: [professional email based on business name]
                                  - Address: [Generic business address appropriate for their location context]
                                  - Hours: [Standard business hours for their industry]",

                'contact_form' => "Create contact form content for {$businessInfo['business_name']}:
                                  Industry: {$businessInfo['business_industry']}

                                  Headline: [Form title encouraging inquiries about their services]
                                  Description: [Form description - 1-2 sentences tailored to their industry]"
            ]
        ];



        return $templates[$page][$section] ?? "Generate specific content. Do NOT provide multiple options or alternatives.";
}

    /**
     * MAIN CONTENT GENERATION METHOD
     */
     public function generateAndStoreBusinessContent($userId, $businessName, $businessIndustry, $businessDescription, $businessCurrency, $pages = null)
    {
        Log::info("=== STARTING AI CONTENT GENERATION ===");
        Log::info("User ID: {$userId}, Business: {$businessName}, Industry: {$businessIndustry}");

        $pages = $pages ?? ['home', 'faq', 'about', 'services', 'reviews', 'contact'];
        $websiteContent = [];

        foreach ($pages as $page) {
            Log::info("--- Generating page: {$page} ---");

            $pageContent = $this->generatePageContent(
                $userId,
                $businessName,
                $businessIndustry,
                $businessDescription,
                $businessCurrency,
                $page
            );

            if ($pageContent && !empty($pageContent)) {
                Log::info("Page {$page} generated successfully with " . count($pageContent) . " sections");
                $websiteContent[$page] = $pageContent;
            } else {
                Log::warning("Page {$page} generation failed or returned empty");
            }
        }

        Log::info("=== AI CONTENT GENERATION COMPLETED ===");
        Log::info("Total pages generated: " . count($websiteContent));

        return $websiteContent;
    }

    /**
     * GENERATE CONTENT FOR SPECIFIC PAGE
     */
    public function generatePageContent($userId, $businessName, $businessIndustry, $businessDescription, $businessCurrency, $page)
    {
        $businessInfo = [
            'business_name' => $businessName,
            'business_industry' => $businessIndustry,
            'business_description' => $businessDescription,
            'business_currency' => $businessCurrency
        ];

        $sections = $this->getPageSections($page);
        $pageContent = [];

        Log::info("Generating page '{$page}' with sections: " . implode(', ', $sections));

        foreach ($sections as $section) {
            Log::info("Generating section: {$section}");

            $content = $this->generateAndStoreSection(
                $userId,
                $page,
                $section,
                $businessInfo
            );

            if ($content && !isset($content['error'])) {
                Log::info("Section {$section} generated successfully");
                $pageContent[$section] = $content;
            } else {
                Log::warning("Section {$section} generation failed");
            }
        }

        return $pageContent;
    }

    /**
     * GENERATE AND STORE INDIVIDUAL SECTION
     */
    // public function generateAndStoreSection($userId, $page, $section, $businessInfo)
    // {
    //     $prompt = $this->buildPrompt($page, $section, $businessInfo);
    //     Log::info("Generated prompt for {$page}.{$section}: " . substr($prompt, 0, 100) . "...");

    //     $apiResponse = $this->callDeepSeekApi($prompt);

    //     Log::info("API Response type: " . gettype($apiResponse));
    //     Log::info("API Response: " . substr($apiResponse ?? 'NULL', 0, 200));

    //     if (is_string($apiResponse)) {
    //         $parsedData = $this->parseResponseToArray($apiResponse);
    //         Log::info("Parsed data for {$page}.{$section}: " . json_encode($parsedData));

    //         if ($parsedData && !isset($parsedData['error'])) {
    //             $this->storeSectionContent($userId, $page, $section, $parsedData);
    //             Log::info("Stored section {$page}.{$section} in database");
    //             return $parsedData;
    //         } else {
    //             Log::warning("Failed to parse API response for {$page}.{$section}");
    //         }
    //     } else {
    //         Log::warning("API returned non-string response for {$page}.{$section}");
    //     }

    //     return ['error' => 'Failed to generate content'];
    // }

//     public function generateAndStoreSection($userId, $page, $section, $businessInfo)
// {
//     $prompt = $this->buildPrompt($page, $section, $businessInfo);
//     Log::info("Generated prompt for {$page}.{$section}: " . substr($prompt, 0, 100) . "...");

//     $apiResponse = $this->callDeepSeekApi($prompt);

//     Log::info("API Response type: " . gettype($apiResponse));
//     Log::info("API Response: " . substr($apiResponse ?? 'NULL', 0, 200));

//     if (is_string($apiResponse)) {
//         $parsedData = $this->parseResponseToArray($apiResponse);
//         Log::info("Parsed data for {$page}.{$section}: " . json_encode($parsedData));

//         if ($parsedData && !isset($parsedData['error'])) {
//             // ✅ Convert parsed data back to a raw content string for retry check
//             $content = is_array($parsedData) ? implode(' ', $parsedData) : (string)$parsedData;

//             if (empty(trim($content))) {
//                 Log::warning("⚠️ AI returned empty content for {$page}.{$section}. Retrying once...");
//                 sleep(5); // wait a bit before retry

//                 // 🌀 Try one more time recursively (only once)
//                 $retryResponse = $this->callDeepSeekApi($prompt);
//                 if (is_string($retryResponse) && !empty(trim($retryResponse))) {
//                     $retryParsed = $this->parseResponseToArray($retryResponse);
//                     if ($retryParsed && !isset($retryParsed['error'])) {
//                         $this->storeSectionContent($userId, $page, $section, $retryParsed);
//                         Log::info("✅ Stored section {$page}.{$section} after retry");
//                         return $retryParsed;
//                     }
//                 }

//                 Log::error("❌ Retry failed for {$page}.{$section} — still empty after retry");
//                 return ['error' => 'Empty content after retry'];
//             }

//             // ✅ Normal path — store first successful response
//             $this->storeSectionContent($userId, $page, $section, $parsedData);
//             Log::info("Stored section {$page}.{$section} in database");
//             return $parsedData;
//         } else {
//             Log::warning("Failed to parse API response for {$page}.{$section}");
//         }
//     } else {
//         Log::warning("API returned non-string response for {$page}.{$section}");
//     }

//     return ['error' => 'Failed to generate content'];
// }

public function generateAndStoreSection($userId, $page, $section, $businessInfo)
{
    $prompt = $this->buildPrompt($page, $section, $businessInfo);
    Log::info("Generated prompt for {$page}.{$section}: " . substr($prompt, 0, 100) . "...");

    $apiResponse = $this->callDeepSeekApi($prompt);

    Log::info("API Response type: " . gettype($apiResponse));
    Log::info("API Response: " . substr($apiResponse ?? 'NULL', 0, 200));

    if (is_string($apiResponse)) {
        $parsedData = $this->parseResponseToArray($apiResponse);
        Log::info("Parsed data for {$page}.{$section}: " . json_encode($parsedData));

        if ($parsedData && !isset($parsedData['error'])) {
            
            // ✅ Safely flatten parsed data before imploding
            if (is_array($parsedData)) {
                $flattened = [];
                array_walk_recursive($parsedData, function ($value) use (&$flattened) {
                    if (is_scalar($value)) {
                        $flattened[] = $value;
                    }
                });
                $content = implode(' ', $flattened);
            } else {
                $content = (string)$parsedData;
            }

            // ✅ Handle empty AI response
            if (empty(trim($content))) {
                Log::warning("⚠️ AI returned empty content for {$page}.{$section}. Retrying once...");
                sleep(5); // wait a bit before retry

                $retryResponse = $this->callDeepSeekApi($prompt);
                if (is_string($retryResponse) && !empty(trim($retryResponse))) {
                    $retryParsed = $this->parseResponseToArray($retryResponse);
                    if ($retryParsed && !isset($retryParsed['error'])) {
                        $this->storeSectionContent($userId, $page, $section, $retryParsed);
                        Log::info("✅ Stored section {$page}.{$section} after retry");
                        return $retryParsed;
                    }
                }

                Log::error("❌ Retry failed for {$page}.{$section} — still empty after retry");
                return ['error' => 'Empty content after retry'];
            }

            // ✅ Normal success path
            $this->storeSectionContent($userId, $page, $section, $parsedData);
            Log::info("Stored section {$page}.{$section} in database");
            return $parsedData;
        } else {
            Log::warning("Failed to parse API response for {$page}.{$section}");
        }
    } else {
        Log::warning("API returned non-string response for {$page}.{$section}");
    }

    return ['error' => 'Failed to generate content'];
}



    // protected function callDeepSeekApi(string $prompt, array $options = [])
    // {
    //     try {
    //         Log::info("📡 Calling DeepSeek API...");

    //         if (empty($this->apiKey)) {
    //             Log::error("❌ DeepSeek API key is missing!");
    //             return null;
    //         }

    //         $response = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . $this->apiKey,
    //             'Content-Type' => 'application/json',
    //         ])->timeout(30)->post($this->baseUrl . '/chat/completions', [
    //             'model' => 'deepseek-chat',
    //             'messages' => [
    //                 [
    //                     'role' => 'user',
    //                     'content' => $prompt
    //                 ]
    //             ],
    //             'max_tokens' => $options['max_tokens'] ?? 1000,
    //             'temperature' => $options['temperature'] ?? 0.8,
    //         ]);

    //         Log::info("API Response Status: " . $response->status());

    //         if ($response->successful()) {
    //             $content = $response->json()['choices'][0]['message']['content'];
    //             Log::info("✅ API call successful. Response length: " . strlen($content));
    //             return $content;
    //         } else {
    //             Log::error("❌ API call failed. Status: " . $response->status());
    //             Log::error("API Error: " . $response->body());
    //             return null;
    //         }

    //     } catch (\Exception $e) {
    //         Log::error("💥 API Exception: " . $e->getMessage());
    //         return null;
    //     }
    // }

    //  protected function callDeepSeekApi(string $prompt, array $options = []) new
    // {
    //     try {
    //         Log::info("📡 Calling Groq API...");
    //         $models = [
    //             'llama-3.1-8b-instant',      // Fastest
    //             // 'llama-3.1-70b-versatile',   // Most capable
    //             // 'mixtral-8x7b-32768',        // Good balance
    //             'gemma2-9b-it'               // Google's model
    //         ];
    //         $response = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . $this->apiKey,
    //             'Content-Type' => 'application/json',
    //         ])->timeout(30)->post($this->baseUrl . '/chat/completions', [
    //             'model' => 'gemma2-9b-it', // Free model
    //             'messages' => [
    //                 [
    //                     'role' => 'user',
    //                     'content' => $prompt
    //                 ]
    //             ],
    //             'max_tokens' => $options['max_tokens'] ?? 1000,
    //             'temperature' => $options['temperature'] ?? 0.7,
    //             'stream' => false,
    //         ]);

    //         Log::info("Groq API Status: " . $response->status());

    //         if ($response->successful()) {
    //             $content = $response->json()['choices'][0]['message']['content'];
    //             Log::info("✅ Groq API successful. Response length: " . strlen($content));
    //             return $content;
    //         } else {
    //             Log::error("❌ Groq API failed. Status: " . $response->status());
    //             Log::error("API Error: " . $response->body());
    //             return null;
    //         }

    //     } catch (\Exception $e) {
    //         Log::error("💥 Groq API Exception: " . $e->getMessage());
    //         return null;
    //     }
    // }

    protected function callDeepSeekApi(string $prompt, array $options = [])
{
    // Add strict instructions to prevent options
    $strictPrompt = $prompt . " Provide only the requested content. Do NOT generate multiple options or alternatives like **option_2**. Return only the final answer.";

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $this->apiKey,
        'Content-Type' => 'application/json',
    ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', [
        'model' => 'openai/gpt-oss-20b',
        'messages' => [
            [
                'role' => 'system',
                'content' => 'You are a content generator. Provide only the requested content. Do NOT generate multiple options or alternatives.'
            ],
            [
                'role' => 'user',
                'content' => $strictPrompt
            ]
        ],
        'max_tokens' => 1000,
        'temperature' => 0.5, // Lower temperature for less creativity
    ]);

    return $response->json()['choices'][0]['message']['content'] ?? null;
}


    protected function parseResponseToArray(string $content): array
    {
        Log::info("Parsing response: " . substr($content, 0, 200));

        try {
            $lines = explode("\n", trim($content));
            $result = [];
            $currentSection = null;
            $currentList = null;

            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;

                // Handle section titles and key-value pairs
                if (str_contains($line, ':')) {
                    list($key, $value) = explode(':', $line, 2);
                    $key = trim($key);
                    $value = trim($value);

                    // Handle main sections
                    if (in_array($key, ['Section Title', 'Tagline', 'Headline', 'Subheadline', 'Description', 'Headline', 'Content'])) {
                        $result[strtolower(str_replace(' ', '_', $key))] = $value;
                    }
                    // Handle list sections
                    elseif (in_array($key, ['Services', 'Value Propositions', 'FAQs', 'Team Members', 'Values', 'Steps', 'Packages', 'Information'])) {
                        $currentSection = strtolower(str_replace(' ', '_', $key));
                        $result[$currentSection] = [];
                        $currentList = $currentSection;
                    }
                    // Handle simple key-value
                    else {
                        $result[strtolower(str_replace(' ', '_', $key))] = $value;
                    }
                }
                // Handle list items
                elseif (str_starts_with($line, '- ')) {
                    $item = trim(substr($line, 2));

                    if (str_contains($item, ':')) {
                        // Handle items with key-value structure: "Service Name: Description"
                        list($itemKey, $itemValue) = explode(':', $item, 2);

                        if ($currentList) {
                            $result[$currentList][] = [
                                'name' => trim($itemKey),
                                'description' => trim($itemValue)
                            ];
                        } else {
                            $result[] = [
                                'name' => trim($itemKey),
                                'description' => trim($itemValue)
                            ];
                        }
                    } else {
                        // Handle simple list items
                        if ($currentList) {
                            $result[$currentList][] = $item;
                        } else {
                            $result[] = $item;
                        }
                    }
                }
            }

            Log::info("Parsed result: " . json_encode($result));
            return $result;

        } catch (\Exception $e) {
            Log::error("Parse error: " . $e->getMessage());
            return ['error' => 'Parse failed'];
        }
    }

    /**
     * STORE CONTENT IN DATABASE
     */
    protected function storeSectionContent($businessId, $page, $sectionType, $contentData)
    {
        foreach ($contentData as $key => $value) {
            if (is_array($value)) {
                // Handle arrays (services, testimonials, etc.)
                foreach ($value as $index => $item) {
                    if (is_array($item)) {
                        // For structured items like services: ['name' => '', 'description' => '']
                        foreach ($item as $subKey => $subValue) {
                            WebsiteContent::updateOrCreate(
                                [
                                    'user_id' => $businessId,
                                    'page' => $page,
                                    'section_type' => $sectionType,
                                    'content_key' => "{$key}_{$index}_{$subKey}"
                                ],
                                [
                                    'content_value' => $subValue,
                                    'word_count' => str_word_count($subValue)
                                ]
                            );
                        }
                    } else {
                        // For simple arrays
                        WebsiteContent::updateOrCreate(
                            [
                                'user_id' => $businessId,
                                'page' => $page,
                                'section_type' => $sectionType,
                                'content_key' => "{$key}_{$index}"
                            ],
                            [
                                'content_value' => $item,
                                'word_count' => str_word_count($item)
                            ]
                        );
                    }
                }
            } else {
                // Handle simple values
                WebsiteContent::updateOrCreate(
                    [
                        'user_id' => $businessId,
                        'page' => $page,
                        'section_type' => $sectionType,
                        'content_key' => $key
                    ],
                    [
                        'content_value' => $value,
                        'word_count' => str_word_count($value)
                    ]
                );
            }
        }
    }

    /**
     * GET SECTIONS FOR EACH PAGE
     */
    protected function getPageSections(string $page): array
    {
        return match($page) {
            'home' => ['hero','why_choose_us', 'process'],
            'faq' => ['faq'],
            'about' => ['about_hero','our_story', 'values', 'mission', 'vision'],
            'services' => ['services_hero', 'service_details'],
            'reviews' => ['customer_reviews'],
            'contact' => ['contact_hero', 'contact_info', 'contact_form'],
            default => []
        };
    }



    /**
     * GET STORED CONTENT FOR BUSINESS
     */
    public function getBusinessContent($businessId, $page = null)
    {
        $query = WebsiteContent::where('user_id', $businessId);

        if ($page) {
            $query->where('page', $page);
        }

        $sections = $query->get();

        return $this->reconstructContent($sections);
    }

    /**
     * RECONSTRUCT CONTENT FROM DATABASE RECORDS
     */
    protected function reconstructContent($sections)
    {
        $content = [];

        foreach ($sections->groupBy(['page', 'section_type']) as $page => $pageSections) {
            $content[$page] = [];

            foreach ($pageSections as $sectionType => $sectionItems) {
                $content[$page][$sectionType] = $this->reconstructSection($sectionItems);
            }
        }

        return $content;
    }


    public function getPageContent($userId, $page)
    {
        return WebsiteContent::where('user_id', $userId)
            ->where('page', $page)
            ->get()
            ->groupBy('section_type')
            ->map(function ($sections) {
                return $this->reconstructContent($sections);
            })
            ->toArray();
    }


    /**
     * RECONSTRUCT INDIVIDUAL SECTION
     */
    protected function reconstructSection($sectionItems)
    {
        $sectionData = [];

        foreach ($sectionItems as $item) {
            $key = $item->content_key;
            $value = $item->content_value;

            // Handle structured keys like "services_0_name"
            if (preg_match('/^(\w+)_(\d+)_(\w+)$/', $key, $matches)) {
                $mainKey = $matches[1]; // services
                $index = $matches[2];   // 0
                $subKey = $matches[3];  // name

                if (!isset($sectionData[$mainKey])) {
                    $sectionData[$mainKey] = [];
                }
                if (!isset($sectionData[$mainKey][$index])) {
                    $sectionData[$mainKey][$index] = [];
                }
                $sectionData[$mainKey][$index][$subKey] = $value;
            }
            // Handle simple array keys like "services_0"
            elseif (preg_match('/^(\w+)_(\d+)$/', $key, $matches)) {
                $mainKey = $matches[1];
                $index = $matches[2];
                $sectionData[$mainKey][$index] = $value;
            }
            // Handle simple keys
            else {
                $sectionData[$key] = $value;
            }
        }

        // Convert indexed arrays to sequential arrays
        foreach ($sectionData as $key => $value) {
            if (is_array($value) && array_keys($value) === range(0, count($value) - 1)) {
                $sectionData[$key] = array_values($value);
            }
        }

        return $sectionData;
    }

    /**
     * ESTIMATE TOKENS
     */
    public function estimateTokens(string $text): int
    {
        return ceil(str_word_count($text) * 1.3);
    }
}
