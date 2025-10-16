<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\WebsiteContent;
use App\Services\DeepSeekService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateAIWebsiteContent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(DeepSeekService $deepSeekService)
    {
        try {
            Log::info("🔁 Retrying AI content generation for user {$this->user->id}");

            $businessInfo = [
                'business_name' => $this->user->business_name,
                'business_industry' => $this->user->business_industry,
                'business_description' => $this->user->business_description,
                'business_currency' => $this->user->currency,
            ];

            // Define all expected pages and sections
            $expectedStructure = [
                'home' => ['hero', 'why_choose_us', 'process'],
                'faq' => ['faq'],
                'about' => ['about_hero', 'our_story', 'values', 'mission', 'vision'],
                'services' => ['services_hero', 'service_details'],
                'reviews' => ['customer_reviews'],
                'contact' => ['contact_hero', 'contact_info', 'contact_form'],
            ];


            foreach ($expectedStructure as $page => $sections) {
                foreach ($sections as $section) {
                    // Check if content already exists or is empty
                    $existing = WebsiteContent::where('user_id', $this->user->id)
                        ->where('page', $page)
                        ->where('section_type', $section)
                        ->first();

                    if (!$existing || empty($existing->content)) {
                        Log::warning("⚙️ Regenerating missing content for user {$this->user->id}: Page [$page], Section [$section]");

                        $deepSeekService->generateAndStoreSection(
                            $this->user->id,
                            $page,
                            $section,
                            $businessInfo
                        );
                    } else {
                        Log::info("✅ Section already exists for user {$this->user->id}: [$page -> $section]");
                    }
                }
            }

            Log::info("🎉 Website content regeneration completed for user {$this->user->id}");

        } catch (\Exception $e) {
            Log::error("❌ Website content generation failed for user {$this->user->id}: " . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}
