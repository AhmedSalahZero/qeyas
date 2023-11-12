<?php 
namespace App\Traits;

use App\User ;

trait HasCreatedByAndUpdatedBy{
	public function getCreatedByBrowseAttribute()
	{
		$user = User::where('id',$this->created_by)->first() ;
		return $user  ? $user->name : 'لا يوجد' ;
	}
	
	public function getCreatedByReadAttribute()
	{
		$user = User::where('id',$this->created_by)->first() ;
		return $user  ? $user->name : 'لا يوجد' ;
	}
	
	public function getUpdatedByBrowseAttribute()
	{
		$updateBy = User::where('id',$this->updated_by)->first() ;
		return $updateBy ? $updateBy->name : 'لا يوجد' ;
	}
	public function getUpdatedByReadAttribute()
	{
		$updateBy = User::where('id',$this->updated_by)->first() ;
		return $updateBy ? $updateBy->name : 'لا يوجد' ;
	}
} 
