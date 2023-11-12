<?php

namespace App\Policies;

use App\Exam;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the exam.
     *
     * @param  \App\User  $user
     * @param  \App\Exam  $exam
     * @return mixed
     */
	public function browse(User $user)
    {
		return true ;
    }
	public function read(User $user , $exam){
		return true ;
	}
	public function edit(User $user , Exam $exam)
	{
		return $this->canEditOrDelete($user , $exam);
	}
	public function add(User $user , Exam $exam){
		return true ;
	}
	public function delete(User $user , Exam $exam)
	{
		return $this->canEditOrDelete($user , $exam); 
	}
	protected function canEditOrDelete(User $user , Exam $exam)
	{
		return $user->is_admin() || (!$exam->available);
	}
}
