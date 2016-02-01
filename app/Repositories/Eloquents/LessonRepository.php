<?php

namespace App\Repositories\Eloquents;
 
use Exception;
use App\Repositories\LessonRepositoryInterface;
use App\Repositories\Eloquents\LessonWordRepository;
use App\Models\Word;
use App\Models\LessonWord;
use App\Models\Lesson;

class LessonRepository extends Repository implements LessonRepositoryInterface
{
    public function create($data)
    {
        $lesson = $this->model->create($data);
        $words = Word::where('category_id', '=', $data['category_id'])->orderByRaw('RAND()')->take(Lesson::QUESTION_PER_LESSON)->get();
        foreach ($words as $word) {
            $lesson_word = [
                'lesson_id' => $lesson->id,
                'word_id' => $word->id,
                'category_id' => $data['category_id'],
            ];
            $lessonWord = new LessonWordRepository(\App\Models\LessonWord::class);
            $lessonWord->createByLesson($lesson_word, $word);
        }

        return $lesson;
    }
}