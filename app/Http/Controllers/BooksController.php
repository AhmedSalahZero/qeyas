<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

class BooksController extends Controller
{

    public function index() {
        $books = Book::paginate(10);
        $title = 'الكتب الالكترونية';
        return view('books.index', compact('books', 'title'));
    }

    public function show(Book $book) {
        $title = $book->book_title;
        return view('books.show', compact('book', 'title'));
    }

    public function view(Book $book) {
        if($book->book_price == 0 || \Auth::user()->has_book($book->id)) {
            return view('books.view', compact('book'));
        }
        return redirect()->route('books.buy', $book);
    }

    public function download(Book $book) {
        $url = storage_path("app/public/{$book->url}");
        if($book->book_price == 0 || \Auth::user()->has_book($book->id)) {
            if(file_exists($url)){
                return response()->download($url, "$book->book_title.pdf", [
                    'Content-Type: application/pdf',
                ]);
            }
            abort(404, 'الكتاب غير موجود');
        }
        return redirect()->route('books.buy', $book);
    }

    public function buy(Request $request ,Book $book) {
		// dd($request->all() ,'salah' , $book );
		$request->validate([
			'name'=>'required|max:255',
			'phone'=>'required',
			'address'=>'required',
			'email'=>'nullable|email',
			'no_books'=>'required'
		]);
		// dd($request->all());
		$name = $request->get('name');
		$phone = $request->get('phone');
		$email = $request->get('email');
		$address = $request->get('address');
		// $message = $request->get('message');
		$price = $book->getPrice();
		$quantity = $request->get('no_books',1);
		$user = auth()->user();
		$book->requests()->create([
            'user_id' => $user->id,
            'status' => $book->isFree() ? 'approved' :'awaiting',
            'user_name' => $name,
            'phone' => $phone,
            'address' => $address,
			'email'=>$email,
            // 'message' => $message,
			'price'=>$quantity * $price ,
			'no_books'=>$quantity ,
			'is_free'=> $book->isFree(),
        ]);
		
		
        if($book->book_price == 0 || \Auth::user()->has_book($book->id)){
            return redirect()->route('books.show', $book);
        }
        
			
			$breadCrumbTitle ='كتب قياس';
		$breadCrumbLink = route('books.index');
		$breadCrumbLastTitle = 'شراء كتاب ';
		$price = $book->getPrice()  ;
		$modelName ='Book';
		$productName = $book->getName();
		$productDescription='شراء كتاب  من قياس 2030';
		// $quantity = $request->get('no_books') ;
		$productId = $book ->id ;
		// dd($product);
		$title = 'شراء كتاب';
		// dd('e');
		$additionalNote = 'ملحوظه:ستتم عمليه الشحن علي العنوان المذكور في مده لا تتخطى سبع ايام عمل';
        return view('exams.buy', compact('additionalNote', 'title','breadCrumbTitle','breadCrumbLastTitle','price','productName','breadCrumbLink','productDescription','quantity','modelName','productId'));
   
	
    }
	
	public function active(Book $book){
		$book->active = 1 ;
		$book->save();
		return back()->with($this->alertSuccess('تم تفعيل الكتاب'));
		
	}
	
}
