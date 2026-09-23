<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Exercise;
use Illuminate\Support\Facades\Http;

class TranslateExercises extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:translate-exercises';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate all exercise instructions to Indonesian';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $exercises = Exercise::all();
        $total = $exercises->count();
        $this->info("Found {$total} exercises. Starting translation...");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($exercises as $exercise) {
            $rawText = $exercise->instructions;

            // Simple heuristic to check if it's already translated or just a default short text
            if (empty(trim($rawText)) || str_contains($rawText, 'Lakukan gerakan ini') || str_contains($rawText, 'Pastikan posisi')) {
                $bar->advance();
                continue;
            }

            // check if there's any indonesian specific word
            if (str_contains(strtolower($rawText), 'dengan') && str_contains(strtolower($rawText), 'yang')) {
                $bar->advance();
                continue;
            }

            $translated = $this->translate($rawText);

            if ($translated && $translated !== $rawText) {
                $exercise->instructions = $translated;
                $exercise->save();
            }

            // Sleep to avoid rate limit
            usleep(500000); // 0.5 seconds
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Translation completed successfully!');
    }

    private function translate(string $rawText): string
    {
        try {
            // Use MyMemory API which allows 5000 requests/day with an email
            $url = 'https://api.mymemory.translated.net/get?q=' . urlencode($rawText) . '&langpair=en|id&de=admin@praxisfit.com';
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'PraxisFit App / 1.0 (admin@praxisfit.com)'
                ])
                ->timeout(10)
                ->get($url);
            
            if ($response->successful()) {
                $json = $response->json();
                if (!empty($json['responseData']['translatedText'])) {
                    $translated = $json['responseData']['translatedText'];
                    
                    // MyMemory sometimes returns MYMEMORY WARNING if limit is reached
                    if (!str_contains($translated, 'MYMEMORY')) {
                        return trim($translated);
                    }
                }
            }
        } catch (\Exception $e) {
            // fallback, do nothing
        }
        
        return $rawText;
    }
}
