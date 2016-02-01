<?php

namespace App\Repositories\Eloquents;
 
use Exception;
use App\Repositories\LessonWordRepositoryInterface;
use App\Repositories\Eloquents\WordRepository;
use App\Models\UserWord;
use App\Models\TransWord;
use App\Models\LessonWord;
use App\Models\Lesson;
use App\Models\Word;

class LessonWordRepository extends Repository implements LessonWordRepositoryInterface
{
    public function createByLesson($lessonWord, $word)
    {
        $trans_words = TransWord::where('word_id', '!=', $word->id)->orderByRaw('RAND()')->take(3)->get();
        foreach ($trans_words as $trans_word) {
            $transWords[] = $trans_word->trans_word;
        }
        $transWords[] = $word->transWord->trans_word;
        shuffle($transWords);
        foreach ($transWords as $key => $transWord) {
            $lessonWord['answer' . ($key + 1)] = $transWord;
        }
        $this->model->create($lessonWord);
    }

    public function updateResultLesson($data, $lesson)
    {
        $count = 0;
        foreach ($lesson->lessonWords as $key => $lessonWord) {
            $question = 'question' . ($key + 1);
            $word = new WordRepository(\App\Models\Word::class);
            $word = $word->findOrFail($lessonWord->word_id);
            $userWord['user_id'] = \Auth::id();
            $userWord['word_id'] = $word->id;
            $lessonWordUpdate['choosed'] = isset($data[$question]) ? $data[$question] : null;
            if(isset($data[$question]) && $word->transWord->trans_word == $data[$question]) {
                $count++;
                $result = LessonWord::CORRECT_ANSWER;
                $wordLearn = Word::LEARNED;
            } else {
                $result = LessonWord::INCORRECT_ANSWER;
                $wordLearn = Word::NOT_LEARNED;
            }
            $lessonWordUpdate['result'] = $result;
            // Update user_word table
            $word->updateUserWordAndStatus($userWord, $wordLearn);

            // Update result question 
            $this->model->findOrFail($lessonWord->id)->update($lessonWordUpdate);
        }
        // Update result lesson
        if($count >= Lesson::COUNT_PASSED_LESSON) {
            $lesson->update(['status' => Lesson::PASSED_LESSON]);
        }
        // Update activity
    }

    public function getResultLesson($id)
    {
        return $this->model->where('lesson_id', '=', $id)->get();
    }

    public function getCorrectAnswers($id)
    {
        return $this->model->where('result', '=', LessonWord::CORRECT_ANSWER)->where('lesson_id', '=', $id)->get();
    }
}