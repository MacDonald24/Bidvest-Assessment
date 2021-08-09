<?php

interface JsonCrud
{
    public function addStudent(Student $student) : Student;
    public function editStudent(Student $student,int $id) : Student;
    public function deleteStudent(int $id) : int ;
    public function getAllStudent();
    public function getStudentsByCriteria(string $searchKey,string $searchValue);
    public function getStudentById(int $id) : Student;
}