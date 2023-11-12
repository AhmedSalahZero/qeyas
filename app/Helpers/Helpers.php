<?php

use App\Services\MoneyConverter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

function switch_module_title($_text){
    switch($_text){
        case "Categories":
            $_text = "الاقسام";
            break;
		case "Users":
            $_text = "المستخدمين";
            break;
		case "Settings":
            $_text = "الإعدادات";
            break;
		case "Exams":
            $_text = "الاختبارات";
            break;
		case "Exam-questions":
            $_text = "اسئلة الاختبارات";
            break;
		case "Question-options":
            $_text = "اختيارات الاسئلة";
            break;
		case "Courses":
            $_text = "الدورات التدريبية";
            break;
		case "Course-requests":
            $_text = "طلبات الدورات";
            break;
		case "Trainers":
            $_text = "المدربين";
            break;
		case "Books":
            $_text = "الكتب";
            break;
		case "Videos":
            $_text = "مكتبة الفيديو";
            break;
		case "User-notifications":
            $_text = "الاشعارات";
            break;
		case "Cities":
            $_text = "المدن";
            break;
		case "Adsense":
            $_text = "الاعلانات الترويجية";
            break;
		case "Payments":
            $_text = "المدفوعات";
            break;
		case "Contact-us":
            $_text = "رسائل التواصل";
            break;
		case "Qeyas-news":
            $_text = "اخبار قياس";
            break;
		case "Profile":
            $_text = "الملف الشخصي";
            break;
        case "Create":
            $_text = "اضافة جديد";
            break;
		case "Edit":
            $_text = "تعديل";
            break;
		case "Admin":
            $_text = "لوحة التحكم";
            break;
		case "Site":
            $_text = "الموقع الالكتروني";
            break;
		case "App":
            $_text = "تطبيقات الموبايل";
            break;
		case "Exam_questions":
            $_text = "اسئلة الاختبارات";
            break;
        case "Exam_sections":
            $_text = "اقسام الاختبارات";
            break;
        default:
            $_text = $_text;
            break;
    }
    return $_text;
}

function switch_numbers($str, $lang){
    $eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
    $western_arabic = array('0','1','2','3','4','5','6','7','8','9');
    if($lang == 'ar'){
        $str = str_replace($western_arabic, $eastern_arabic, $str);
    }else {
        $str = str_replace($eastern_arabic, $western_arabic, $str);
    }
    return $str;
}

function convertIntToArabicString(int $num){
	$Arabic = new \ArPHP\I18N\Arabic('Numbers'); 
	return $Arabic->int2str($num); 
}
function activeCategory($category,$cat){
	if($category->cat_parent == 0){
		return $category->id == $cat->id ;
	}
	return $category->cat_parent == $cat->id ;
}
function getMainCurrency()
{
	// return 'جنيه';
	return 'ريال';
}
function getOldAnswerKey(int $userId , int $examId ,int $questionId)
{
	return 'old_'.$userId.'for_exam'.$examId . 'question_id'.$questionId;
}
function getCache(string $key)
{
	return Cache::get($key);
}
function getLogo()
{
	return asset('images/logo.png');
}

function getPaymentServiceCurrency()
{
    return 'EGP';
}
function convertMoney($amount , $from='SAR', $to="EGP")
{
	return (new MoneyConverter())->convert($amount , $from, $to) ;
	
}
function getPaymentCurrencyAr()
{
    return getMainCurrency();
}
function getFirstAndLastNameFromName($name)
{
	
		$parts = explode(" ", $name);
		
		if(count($parts) > 1) {
			$lastname = array_pop($parts);
			$firstname = implode(" ", $parts);
		}
		else
		{
			$firstname = $name;
			$lastname = null ;
		}
		return [
			'first_name'=>$firstname  ,
			'last_name'=>$lastname 
		];
		
}
function formatDateForView(Carbon $date){
	 $ar_month = [
        'Jan' => 'يناير',
        'Feb' => 'فبراير',
        'Mar' => 'مارس',
        'Apr' => 'أبريل',
        'May' => 'مايو',
        'Jun' => 'يونيو',
        'Jul' => 'يوليو',
        'Aug' => 'أغسطس',
        'Sep' => 'سبتمبر',
        'Oct' => 'أكتوبر',
        'Nov' => 'نوفمبر',
        'Dec' => 'ديسمبر',
    ];
	return "$date->day " . $ar_month[$date->shortEnglishMonth] . " $date->year";
}
function getPaymentStatusInArr(string $status){
	return [
		'approved'=>'تم الدفع',
		'awaiting'=>'لم يتم الدفع بعد',
		'refunded'=>'تم استرجاع الاموال',
	][$status];
}
function getIds(array $items):array{
	$ids = [];
	// dd($items);
	// dd($items);
	foreach($items ??[] as $subItems){
		foreach($subItems as $item){
			$ids[] = $item['id'] ?? 0 ;
		}
	}
	return $ids;
	
}
function cacheHas($key):bool{
	if(!auth()->user()){
		return false ;
	}
	return Cache::has($key.'_'.auth()->user()->id);
	
}
function cacheGetAndForget($key){
	$message = Cache::get($key.'_'.auth()->user()->id);
	 Cache::forget($key.'_'.auth()->user()->id);
	return $message;
}
