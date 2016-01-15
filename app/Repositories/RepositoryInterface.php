<?php

namespace App\Repositories;

interface RepositoryInterface
{
	public function all($columns = array('*'));

	public function create($data);

	public function update($id, $data);

	public function delete($id);
}