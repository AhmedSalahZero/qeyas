<?php

namespace App\Providers;
use App\Category;
use App\CourseRequest;
use App\Mail\SendNewsMail;
use App\Mail\SendTestMail;
use App\News;
use App\Notifications\UserCreatedNotification;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use TCG\Voyager\Facades\Voyager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
		// $mail = ;
		require storage_path('ar-php-6.3.4/src/Arabic.php');
		
        foreach (glob(app_path('Helpers') . '/*.php') as $file) {
			require_once $file;
        }
    }

    /**
	 * Bootstrap any application services.
     *
	 * @return void
     */
	
	
	public function boot()
    {
		// $x = convertMoney('1');
		// $user->canRefund(CourseRequest::first());
		// dd($x);
		// $names = getFirstAndLastNameFromName('ahmed');
		// dd($names);
		/* Add action buttons to the admin panel */
        Voyager::addAction(\App\Actions\ExamQuestions::class);
        Voyager::addAction(\App\Actions\ActiveExam::class);
        Voyager::addAction(\App\Actions\ActiveCourse::class);
        Voyager::addAction(\App\Actions\ActiveBook::class);
        Voyager::addAction(\App\Actions\CourseExcelReport::class);
        Voyager::addAction(\App\Actions\SendNewsEmail::class);
        Voyager::addAction(\App\Actions\ExamSections::class);
		// dd();
				//  Mail::to('ahmed_mu83@yahoo.com')->send(new SendTestMail( ));
				//  Mail::to('asalahdev5@gmail.com')->send(new SendNewsMail(News::find(2)));
				//  Mail::to('asalahdev5@gmail.com')->send(new SendTestMail( ));
				//  Mail::to('ahmedconan17@yahoo.com')->send(new SendTestMail( ));
		
        $categories = Category::where('cat_parent', 0)
            ->orderBy('cat_order')
            ->take(4)
            ->get();
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
        $list_index_ar = ['', 'أ', 'ب', 'ج', 'د', 'هـ', 'و', 'ز', 'ح', 'ط', 'ي', 'ك', 'ل', 'م', 'ن'];
        $list_index_en = ['', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n'];
        view()->share(['categories' => $categories, 'ar_month' => $ar_month, 'list_index_ar' => $list_index_ar, 'list_index_en' => $list_index_en]);
    }
}
