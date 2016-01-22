<?php

namespace App\Repositories\Eloquents;
 
use App\Repositories\WordRepositoryInterface;
use Exception;

class WordRepository extends Repository implements WordRepositoryInterface
{

	public $ruleAddWord = [
		'word' => 'required|unique:words,word',
		'trans_word' => 'required',
	];

	public function addWordAndTranslate($data)
	{
		$word = $this->model->create($data);
		$transword['word_id'] = $word->id;
		$transword['trans_word'] = $data['trans_word'];
		\App\Models\TransWord::create($transword);
	}
}