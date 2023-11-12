<?php
namespace App\Exports;


use App\Course;
use Maatwebsite\Excel\Concerns\FromCollection;

class CourseReportExcel implements FromCollection
{
    public function collection()
    {
        return Course::all();
    }
}
