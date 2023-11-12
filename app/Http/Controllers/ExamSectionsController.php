<?php

namespace App\Http\Controllers;

use App\Exam;
use App\ExamSection;
use Illuminate\Http\Request;
use TCG\Voyager\Traits\AlertsMessages;

class ExamSectionsController extends Controller
{

    use AlertsMessages;

    public function show(Exam $exam) {
        return view('vendor.voyager.exams.sections.index', compact('exam'));
    }

    public function destroy(ExamSection $section) {
		$this->authorize('delete',$section->exam);
		$section->delete();
        return back()->with($this->alertSuccess('تم حذف قسم الاختبار بنجاح'));
    }
	
    public function edit(ExamSection $section) {
		$this->authorize('edit',$section->exam);
        return view('vendor.voyager.exams.sections.edit', compact('section'));
    }

    public function update(Request $request, ExamSection $section) {
        $this->validate($request, [
            'title' => 'required|string',
            'order' => 'required|numeric',
        ]);

        $section->update([
            'section_title' => $request->title,
            'section_order' => $request->order,
            'status' => $request->status == 'on' ? 1 : 0
        ]);

        return back()->with($this->alertSuccess('تم التعديل بنجاح'));
    }

    public function store(Request $request, Exam $exam) {
//        dd($request->title[0]);
        $this->validate($request, [
            'title.*' => 'required|string',
            'order.*' => 'required|numeric',
        ]);
        for($i=0; $i<=count($request->title) - 1; $i++){
            $exam->sections()->create([
                'section_title' => $request->title[$i],
                'section_order' => $request->order[$i],
                'status' => (isset($request->status[$i]) && $request->status[$i] == 'on') ? 1 : 0
            ]);
        }

        return redirect()->route('admin.exam_sections.show', $exam)->with($this->alertSuccess('تمت الاضافة بنجاح'));

    }

    public function create(Exam $exam) {
        return view('vendor.voyager.exams.sections.create', compact('exam'));
    }
}
