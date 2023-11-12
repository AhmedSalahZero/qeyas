<?php

namespace App\Policies;

use App\Book;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;
 
	public function browse(User $user)
    {
		return true ;
    }
	public function read(User $user , $book){
		return true ;
	}
	public function edit(User $user , Book $book)
	{
		return $this->canEditOrDelete($user , $book);
	}
	public function add(User $user , Book $book){
		return true ;
	}
	public function delete(User $user , Book $book)
	{
		return $this->canEditOrDelete($user , $book); 
	}
	protected function canEditOrDelete(User $user , Book $book)
	{
		return $user->is_admin() || ( !$book->active ) ;
	}
}
