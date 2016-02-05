<?php

namespace App\Repositories\Eloquents;
 
use App\Repositories\WordRepositoryInterface;
use Exception;
use App\Models\TransWord;
use App\Models\Word;
use App\Models\UserWord;
use App\Repositories\Eloquents\CategoryRepository;

class WordRepository extends Repository implements WordRepositoryInterface
{

    public $ruleAddWord = [
        'word' => 'required|unique:words,word',
        'trans_word' => 'required',
    ];

    public $ruleUpdate = [
        'word' => 'required|unique:words,word',
        'trans_word' => 'required',
    ];

    /**
     * get all words with the condition.
     * @return object Word $words
     */
    public function getAllWord()
    {
        $words = array();
        if(session()->has('search')) {
            $search = session('search');
            $category = new CategoryRepository(\App\Models\Category::class);
            $cateArray = $category->categorySelection();
            foreach ($cateArray as $key => $value) {
                $words[$key] = $this->model->where('category_id', '=', $key)->where('word', 'LIKE', '%' . $search . '%')->orderBy('word')->paginate(Word::WORD_PER_PAGE);
            }
        } else {
            $category = new CategoryRepository(\App\Models\Category::class);
            $cateArray = $category->categorySelection();
            foreach ($cateArray as $key => $value) {
                $words[$key] = $this->model->where('category_id', '=', $key)->orderBy('word')->paginate(Word::WORD_PER_PAGE);
            }
        }

        return $words;
    }

    public function addWordAndTranslate($data)
    {
        $word = $this->model->create($data);
        $transword['word_id'] = $word->id;
        $transword['trans_word'] = $data['trans_word'];

        return TransWord::create($transword);
    }

    public function deleteWordAndTransWord($id)
    {
        $transwordId = $this->model->findOrFail($id)->transWord->delete();
        $this->model->findOrFail($id)->delete();
    }

    public function getFilterWord($data, $id)
    {
        $words = new Word;
        if(isset($data['category_id']) && $data['category_id'] != '') {
            $words = $words->where('category_id', '=', $data['category_id']);
        }
        if(isset($data['submit']) && $data['submit'] == 'search') {
            $words = $words->where('word', 'LIKE', '%' . $data['search'] . '%');
        }
        if(isset($data['status'])) {
            $wordIdArray = UserWord::where('status', '=', Word::LEARNED)->where('user_id', '=', $id)->lists('word_id');
            if($data['status'] == Word::LEARNED) {
                $words = $words->whereIn('id', $wordIdArray);
            } elseif($data['status'] == Word::NOT_LEARNED) {
                $words = $words->whereNotIn('id', $wordIdArray);
            }
        }
        $words = $words->orderBy('word')->paginate(Word::WORD_PER_PAGE);

        return $words;
    }
}