<?php

namespace App\Services;

use Google\Cloud\Translate\V3\Client\TranslationServiceClient;
use Google\Cloud\Translate\V3\TranslateTextRequest;
use Illuminate\Support\Facades\Log;

class TranslateService
{
    protected $client;
    protected $projectId;
    protected $location;

    public function __construct()
    {
        $this->client = new TranslationServiceClient([
            'credentials' => storage_path('app/google-vision/labeltranslate-translate.json'),
        ]);

        // GCP projenin ID'sini buraya yaz veya .env'den çek
        $this->projectId = 'gymlive-af576';
        $this->location = 'global'; // veya 'us-central1', 'europe-west1' gibi bölge kodu
    }

    public function translate($text, $targetLanguage, $sourceLanguage = null)
    {
        try {
            if (empty($text)) {
                return null;
            }

            $formattedParent = $this->client->locationName($this->projectId, $this->location);

            $request = new TranslateTextRequest([
                'parent' => $formattedParent,
                'contents' => [$text],
                'mime_type' => 'text/plain',
                'target_language_code' => $targetLanguage,
            ]);
            
            if ($sourceLanguage) {
                $request->setSourceLanguageCode($sourceLanguage);
            }
            
            $response = $this->client->translateText($request);

            $translations = $response->getTranslations();
            $translatedText = $translations[0]->getTranslatedText();

            return [
                'translated_text' => $translatedText,
                'source_language' => $sourceLanguage ?? null,
                'target_language' => $targetLanguage
            ];
        } catch (\Exception $e) {
            Log::error('Translate API V3 Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
