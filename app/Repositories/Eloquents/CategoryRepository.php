<?php

namespace App\Repositories\Eloquents;
 
use App\Repositories\CategoryRepositoryInterface;
use Exception;

class CategoryRepository extends Repository implements CategoryRepositoryInterface
{

	public $ruleAdd = [
		'name' => 'required|unique:categories,name',
	];


	public function categorySelection()
	{
		$categories = $this->model->all();
		$cateArray = array();
		foreach ($categories as $category) {
			$cateArray[$category->id] = $category->name;
		}

		return $cateArray;
	}
}