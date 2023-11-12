<?php

namespace App\Policies;

use App\Course;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;
 
	public function browse(User $user)
    {
		return true ;
    }
	public function read(User $user , $course){
		return true ;
	}
	public function edit(User $user , Course $course)
	{
		return $this->canEditOrDelete($user , $course);
	}
	public function add(User $user , Course $course){
		return true ;
	}
	public function delete(User $user , Course $course)
	{
		return $this->canEditOrDelete($user , $course); 
	}
	protected function canEditOrDelete(User $user , Course $course)
	{
		return $user->is_admin() || ( !$course->active ) ;
	}
}
