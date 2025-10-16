<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\WebsiteContent;
use Illuminate\Support\Facades\Log;

class MockTest
{
    public function generateAndStoreBusinessContent($userId, $businessName, $businessIndustry, $businessDescription, $businessCurrency)
    {
        Log::info("Using Mock AI Service for user: {$userId}");

        // Generate realistic mock content
        $mockContent = $this->generateMockContent($businessName, $businessIndustry, $businessDescription);
        $this->storeMockContent($userId, $mockContent);

        return $mockContent;
    }

    protected function generateMockContent($businessName, $industry, $description)
    {
        return [
            'home' => [
                'hero' => [
                    'tagline' => 'Professional Excellence',
                    'headline' => "Welcome to {$businessName}",
                    'subheadline' => "Your trusted partner for {$industry} solutions. {$description}"
                ],
                'about' => [
                    'section_title' => 'About Us',
                    'headline' => "Leading {$industry} Services",
                    'description' => "{$businessName} is dedicated to providing exceptional {$industry} services. We combine expertise with innovation to deliver outstanding results for our clients."
                ],
                'services' => [
                    'section_title' => 'Our Services',
                    'services' => [
                        ['name' => 'Consultation', 'description' => 'Expert advice and strategic guidance for your business needs.'],
                        ['name' => 'Implementation', 'description' => 'Professional execution of solutions with attention to detail.'],
                        ['name' => 'Support', 'description' => 'Ongoing assistance and maintenance services.'],
                        ['name' => 'Custom Solutions', 'description' => 'Tailored approaches designed specifically for your requirements.']
                    ]
                ],
                'why_choose_us' => [
                    'section_title' => 'Why Choose Us',
                    'value_propositions' => [
                        ['name' => 'Expert Team', 'description' => 'Highly skilled professionals with industry expertise.'],
                        ['name' => 'Quality Assurance', 'description' => 'Commitment to delivering exceptional quality in all services.'],
                        ['name' => 'Customer Focus', 'description' => 'Dedicated to understanding and meeting client needs.']
                    ]
                ]
            ],
            'faq' => [
                'faq' => [
                    'section_title' => 'Frequently Asked Questions',
                    'faqs' => [
                        ['name' => 'What services do you provide?', 'description' => 'We offer comprehensive solutions including consultation, implementation, and ongoing support services.'],
                        ['name' => 'How can I get started?', 'description' => 'Contact us for an initial consultation to discuss your specific requirements and how we can help.'],
                        ['name' => 'What makes you different?', 'description' => 'Our commitment to quality, customer satisfaction, and tailored solutions sets us apart in the industry.']
                    ]
                ]
            ]
        ];
    }

    protected function storeMockContent($userId, $content)
    {
        foreach ($content as $page => $sections) {
            foreach ($sections as $sectionType => $sectionData) {
                foreach ($sectionData as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $index => $item) {
                            if (is_array($item)) {
                                foreach ($item as $subKey => $subValue) {
                                    WebsiteContent::updateOrCreate(
                                        [
                                            'user_id' => $userId,
                                            'page' => $page,
                                            'section_type' => $sectionType,
                                            'content_key' => "{$key}_{$index}_{$subKey}"
                                        ],
                                        ['content_value' => $subValue]
                                    );
                                }
                            }
                        }
                    } else {
                        WebsiteContent::updateOrCreate(
                            [
                                'user_id' => $userId,
                                'page' => $page,
                                'section_type' => $sectionType,
                                'content_key' => $key
                            ],
                            ['content_value' => $value]
                        );
                    }
                }
            }
        }
    }
}
