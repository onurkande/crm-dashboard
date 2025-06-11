<?php

namespace App\Services;

use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Image;
use Illuminate\Support\Facades\Log;

class VisionService
{
    protected $imageAnnotator;

    public function __construct()
    {
        $this->imageAnnotator = new ImageAnnotatorClient([
            'credentials' => storage_path('app/google-vision/labeltranslate-693372e1263a_photo.json')
        ]);
    }

    public function detectText($imagePath)
    {
        try {
            $imageData = file_get_contents($imagePath);

            $image = (new Image())
                ->setContent($imageData);

            $feature = (new Feature())
                ->setType(Feature\Type::TEXT_DETECTION);

            $request = (new AnnotateImageRequest())
                ->setImage($image)
                ->setFeatures([$feature]);

            $batchRequest = (new BatchAnnotateImagesRequest())
                ->setRequests([$request]);

            $response = $this->imageAnnotator->batchAnnotateImages($batchRequest);

            $responses = $response->getResponses();

            if (count($responses) > 0) {
                $textAnnotations = $responses[0]->getTextAnnotations();
                if (count($textAnnotations) > 0) {
                    return $textAnnotations[0]->getDescription();
                }
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Vision API Error: ' . $e->getMessage());
            throw $e;
        } finally {
            $this->imageAnnotator->close();
        }
    }
}
