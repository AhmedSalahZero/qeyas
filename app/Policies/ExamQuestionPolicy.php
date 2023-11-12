<?php

namespace App\Policies;

use App\Exam;
use App\ExamQuestion;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use TCG\Voyager\Policies\BasePolicy;

// class ExamQuestionPolicy extends BasePolicy 
// {
//     use HandlesAuthorization;

  
// 	public function browse(User $user)
//     {
// 		return true ;
//     }
// 	public function read(User $user ,ExamQuestion $examQuestion){
// 		return true ;
// 	}
// 	public function edit(User $user ,ExamQuestion $examQuestion)
// 	{
// 		return $this->canEditOrDelete($user , $examQuestion);
// 	}
// 	public function add(User $user ,ExamQuestion $examQuestion){
		
// 		return $this->canEditOrDelete($user , $examQuestion); 
// 	}
// 	public function delete(User $user , ExamQuestion $examQuestion)
// 	{
// 		return $this->canEditOrDelete($user , $examQuestion); 
// 	}
// 	protected function canEditOrDelete(User $user ,ExamQuestion $examQuestion)
// 	{
// 		return $user->is_admin() || (!$examQuestion->exam->available);
// 	}
// }
