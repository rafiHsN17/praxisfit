<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Exercise;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateExercises extends Command
{
    protected $signature = 'exercises:translate';
    protected $description = 'Translate all English exercise instructions to Indonesian';

    public function handle()
    {
        $this->info('Starting translation process...');

        $exercises = Exercise::where('instructions', 'like', '% the %')
            ->orWhere('instructions', 'like', '% your %')
            ->orWhere('instructions', 'like', '% to %')
            ->get();

        $this->info('Found ' . $exercises->count() . ' exercises to translate.');
        
        $tr = new GoogleTranslate('id');
        $tr->setSource('en');

        $bar = $this->output->createProgressBar($exercises->count());
        $bar->start();

        foreach ($exercises as $ex) {
            try {
                $rawInstructions = $ex->instructions;
                $translated = $tr->translate($rawInstructions);
                
                if (!empty($translated)) {
                    $ex->instructions = $translated;
                    $ex->save();
                }
            } catch (\Exception $e) {
                sleep(2);
            }
            
            $bar->advance();
            usleep(200000); 
        }

        $bar->finish();
        $this->newLine();
        $this->info('Translation process completed.');
    }
}
