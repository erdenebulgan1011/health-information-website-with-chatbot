<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Disease;
use Illuminate\Support\Facades\Storage;

class FetchDiseases extends Command {
    protected $signature = 'fetch:diseases';
    protected $description = 'Fetch disease data from local JSON file and store it in the database';

    
    public function handle() {
        $filePath = storage_path('app/data/disease_database_en.json'); // adjust the path as needed  C:\Users\user\healthinfo\storage\app\data\disease_database_en.json
        if (!file_exists($filePath)) {
            $this->error("File not found: $filePath");
            return;
        }

        $jsonContent = file_get_contents($filePath);
        $data = json_decode($jsonContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('JSON decode error: ' . json_last_error_msg());
            return;
        }

        foreach ($data as $disease) {
            Disease::updateOrCreate(
                ['disease_id' => $disease['disease_id']],
                [
// Use 'disease' key from JSON since that's what's provided
                            'disease_name'   => $disease['disease'],
// Directly store the string values for common_symptom and treatment
                            'common_symptom' => $disease['common_symptom'],
                            'treatment'      => $disease['treatment'],
    ]
            );
        }

        $this->info('Disease data imported successfully.');
    }
}
