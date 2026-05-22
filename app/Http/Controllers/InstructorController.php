<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Pagination\LengthAwarePaginator;

class InstructorController extends Controller
{
    private $InstructorModel;

    public function __construct()
    {
        $this->InstructorModel = new Instructor;
    }

    public function index()
    {
        $instructorsCount = $this->InstructorModel->InstructorCount()->InstructorsCount ?? 0;
        $allInstructors = $this->InstructorModel->GetAllInstructors();

        $perPage = 4;
        $page = (int) request()->get('page', 1);
        $offset = ($page - 1) * $perPage;
        $items = array_slice($allInstructors, $offset, $perPage);

        $instructors = new LengthAwarePaginator(
            $items,
            count($allInstructors),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('dashboard', [
            'instructorsCount' => $instructorsCount,
            'instructors' => $instructors,
        ]);
    }

    public function details(int $instructorId)
    {
        $instructor = $this->InstructorInformation($instructorId);

        $instructorvehicles = $this->InstructorModel->GetAllInstructorVehicles($instructorId);

        return view('instructor.details', [
            'instructor' => $instructor,
            'instructorvehicles' => $instructorvehicles,
        ]);
    }

    public function InstructorInformation(int $instructorId)
    {
        $instructor = $this->InstructorModel->newQuery()
            ->select(['Id', 'Firstname', 'Middlename', 'Lastname', 'StartDate', 'NumberOfStars'])
            ->find($instructorId);

        return $instructor;
    }
}
