<?php

namespace App\Policies;

use App\Book;
use App\ExamRequest;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamRequestPolicy
{
    use HandlesAuthorization;
 
	public function browse(User $user)
    {
		return true ;
    }
	public function read(User $user , $book){
		return true ;
	}
	public function edit(User $user , ExamRequest $book)
	{
		return false;
	}
	public function add(User $user , ExamRequest $book){
		return  false ;
	}
	public function delete(User $user , ExamRequest $book)
	{
		return false; 
	}
	// protected function canEditOrDelete(User $user , Book $book)
	// {
	// 	return $user->is_admin() || ( !$book->active ) ;
	// }
}
