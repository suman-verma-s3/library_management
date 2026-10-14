<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
     * Har Excel row ke liye ye method call hoga.
     * Row ka data database mein insert karega.
     */
    public function model(array $row)
    {
        return new Student([
            'student_id' => $row['student_id'],
            'name'       => $row['name'],
            'email'      => $row['email'],
            'phone'      => $row['phone'] ?? null,
            'course'     => $row['course'] ?? null,
            'status'     => 'active',
        ]);
    }
}