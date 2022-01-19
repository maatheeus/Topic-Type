<?php

namespace Tests\APIs;

use EscolaLms\Courses\Models\Course;
use EscolaLms\Courses\Models\Lesson;
use EscolaLms\Courses\Models\Topic;
use EscolaLms\HeadlessH5P\Dtos\ContentFilterCriteriaDto;
use EscolaLms\HeadlessH5P\Models\H5PContent;
use EscolaLms\HeadlessH5P\Repositories\H5PContentRepository;
use EscolaLms\TopicTypes\Models\TopicContent\H5P;
use EscolaLms\TopicTypes\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;

class TopicTypeH5PTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $course = Course::factory()->create();
        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
        ]);
        $this->topic = Topic::factory()->create([
            'lesson_id' => $lesson->id,
        ]);
    }

    public function testH5PCountTopicUses()
    {
        /** @var H5PContentRepository $repository */
        $repository = app(H5PContentRepository::class);
        $h5p = H5PContent::query()->first();
        H5P::factory()->create(['value' => $h5p->id]);
        H5P::factory()->create(['value' => $h5p->id]);

        $list = $repository->list(new ContentFilterCriteriaDto(new Collection([])));

        $this->assertEquals(2, $list[0]->count_h5p);
        $this->assertEquals(0, $list[1]->count_h5p);
    }
}
