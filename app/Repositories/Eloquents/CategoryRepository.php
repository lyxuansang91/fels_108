<?php

namespace App\Repositories\Eloquents;
 
use App\Repositories\CategoryRepositoryInterface;
use Exception;

class CategoryRepository extends Repository implements CategoryRepositoryInterface
{

    public $ruleAdd = [
        'name' => 'required|unique:categories,name',
        'image' => 'required'
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

    public function createCategory($data)
    {
        $file = $data['image'];
        $name = $file->getClientOriginalName();
        $file->move(public_path().'/images/category', $name);
        $data['image'] = '/images/category/' . $name;
        $this->create($data);
    }

    public function updateCategory($id, $data)
    {
        $category = $this->findOrFail($id);
        if(isset($data['image'])) {
            $file = $data['image'];
            $name = $file->getClientOriginalName();
            $file->move(public_path().'/images/category', $name);
            $category->image = '/images/category/' . $name;
        }
        $category->name = $data['name'];
        $category->content = $data['content'];
        $category->save();
    }
}