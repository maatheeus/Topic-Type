<?php

namespace EscolaLms\TopicTypes\Models\TopicContent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Schema(
 *      schema="TopicPDF",
 *      required={"value"},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          @OA\Schema(
 *             type="integer",
 *         )
 *      ),
 *      @OA\Property(
 *          property="value",
 *          description="value",
 *          type="string"
 *      )
 * )
 */
class PDF extends AbstractTopicFileContent
{
    use HasFactory;

    public $table = 'topic_pdfs';

    public static function rules(): array
    {
        return [
            'value' => ['required', 'file', 'mimes:pdf'],
        ];
    }

    protected static function newFactory()
    {
        return \EscolaLms\TopicTypes\Database\Factories\TopicContent\PdfFactory::new();
    }

    public function getStoragePathFinalSegment(): string
    {
        return 'pdf';
    }

    public function fixAssetPaths(): array
    {
        $topic = $this->topic;
        $course = $topic->lesson->course;
        $basename = basename($this->value);
        $destination = sprintf('courses/%d/topic/%d/%s', $course->id, $topic->id, $basename);
        $results = [];

        if (strpos($this->value, $destination) === false && Storage::exists($this->value)) {
            if (!Storage::exists($destination)) {
                Storage::move($this->value, $destination);
            }
            $results[] = [$this->value, $destination];
            $this->value = $destination;
            $this->save();
        }

        return $results;
    }
}