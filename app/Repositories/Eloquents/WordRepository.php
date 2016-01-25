<?php

namespace App\Repositories\Eloquents;
 
use App\Repositories\WordRepositoryInterface;
use Exception;
use App\Models\TransWord;
use App\Models\Word;
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
        if(\Session::has('search')) {
            $search = \Session::get('search');
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
        $transwordId = $this->model->findOrFail($id)->trans_word->delete();
        $this->model->findOrFail($id)->delete();
    }
}