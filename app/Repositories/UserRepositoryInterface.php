<?php

namespace App\Repositories;

interface UserRepositoryInterface extends RepositoryInterface
{
	public function updateProfile($id, $data);

	public function updatePassword($id, $password);
}