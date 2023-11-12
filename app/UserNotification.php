<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserNotification
 *
 * @property int $id
 * @property string $user_gender
 * @property int $city_id
 * @property string $education_level
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserNotification whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserNotification whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserNotification whereEducationLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserNotification whereUserGender($value)
 * @mixin \Eloquent
 */
class UserNotification extends Model
{
    protected $fillable =
        [
            'type','user_id','content'
        ];


//    public static function sendxxxx($tokens,$title,$msg)
//    {
//        $fields =
//            [
//            "registration_ids" => $tokens,
//            "priority" => 10,
//            'data' =>
//                [
//                'message' => $msg,
//                'title' => $title,
//                ],
//            'vibrate' => 1,
//            'sound' => 1
//            ];
//
//        $headers =
//            [
//            'accept: application/json',
//            'Content-Type: application/json',
//            'Authorization: key=' .
//            'AAAA-oBKm98:APA91bHjGL6S8WENhwmYd9bRx1XRhkfv60OznFpz78TojG0j7vY-Z_RRBoFMkT75B6V6gUu23jKBsAqtcZKSOLDSkTZRhTHP2f9wrv-CmLv-wES6m6aHCJD5V5Iwheu2ukfNhHgSgirS'
//            ];
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//        $result = curl_exec($ch);
//        //  var_dump($result);
//        if ($result === FALSE)
//        {
//            die('Curl failed: ' . curl_error($ch));
//        }
//
//        curl_close($ch);
//
//        return $result;
//    }

    public static function send($tokens,$title,$msg)
    {
	    foreach($tokens as $tokenId){
			if(empty($tokenId)) continue;
			$msg = array(
				"to"=>$tokenId,
				"notification"=>array(
							"title"=>$title,
							"body"=>$msg,
							"sound" => "default",
							"is_background" => FALSE,
				),
				"data" => array(
				  "click_action" => "",
				  //"volume" : "3.21.15",
				  "contents" => ""
				),
				"priority"=>"high",
				);
			/*$firebase_fields = array(
				'registration_ids' 	=> $registrationIds,
				'data'			=> $msg
			);*/
			//dump_exit($firebase_fields);
			$headers = array(
				'Authorization: key=' . 'AAAA-oBKm98:APA91bHjGL6S8WENhwmYd9bRx1XRhkfv60OznFpz78TojG0j7vY-Z_RRBoFMkT75B6V6gUu23jKBsAqtcZKSOLDSkTZRhTHP2f9wrv-CmLv-wES6m6aHCJD5V5Iwheu2ukfNhHgSgirS',
				'Content-Type: application/json'
			);
			 $url = 'https://fcm.googleapis.com/fcm/send';
			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, $url );
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $msg) );
			$result = curl_exec($ch );
			curl_close( $ch );
			$result_obj = json_decode($result);
		}
		/*if(!empty($result_obj)){
			return ($result_obj->success==1)?true:false;
		}else{*/
//			return $result;
		/*}*/

    }

}
