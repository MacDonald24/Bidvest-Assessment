<?php
include "JsonCrud.php";
class StudentData implements JsonCrud
{

    public string $basePath;

    public function __construct(string $bathPath) {
        $this->basePath = $bathPath;
    }
    /**
     * @param Student $student
     * @return Student
     */
    public function addStudent(Student $student): Student
    {
        // TODO: Implement addStudent() method.
        if(!empty($student)){

            $dir = $this->basePath."/".substr($student->getId(), 0, 2);
            $file_to_write = $student->getId().".json";
            $json = json_encode($student);

            try
            {
                if( is_dir($dir) === false )
                {
                    mkdir($dir);
                }
                $file = fopen($dir . '/' . $file_to_write,"w");
                fwrite($file,  $json);
                // closes the file
                fclose($file);

                $files = scandir($dir);
                if (in_array($student->getId().".json", $files)){
                    fwrite(STDOUT,"Student has been created ".$student->getId(). "\n");
                }else{
                    fwrite(STDOUT,"Student has not been created ".$student->getId(). "\n");
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }

        }
        return $student;
    }

    /**
     * @param Student $student
     * @param int $id
     * @return Student
     */
    public function editStudent(Student $student, int $id): Student
    {
        // TODO: Implement editStudent() method.
        $jsonEditStudent = null;
        try
        {
            if(!empty($id))
            {
                $jsonStudent = $this->getStudentById($id);
                if(!empty($jsonStudent) && !empty($student))
                {
                        $directory = substr($jsonStudent->getId(), 0, 2);
                        //Load the file
                        $contents = file_get_contents($this->basePath."/".$directory."/".$jsonStudent->getId().".json");
                        //Decode the JSON data into a PHP array.
                        $contentsDecoded = json_decode($contents, true);
                        //Modify the counter variable.
                        $contentsDecoded['name'] = $student->getName();
                        $contentsDecoded['surname'] = $student->getSurname();
                        $contentsDecoded['age'] = $student->getAge();
                        $contentsDecoded['curriculum'] = $student->getCurriculum();
                        //Encode the array back into a JSON string.
                        $json = json_encode($contentsDecoded);
                        //Save the file.
                        file_put_contents($this->basePath."/".$directory."/".$jsonStudent->getId().".json", $json);

                        $jsonEditStudent = new Student();
                        $jsonEditStudent->setId($jsonStudent->getId());
                        $jsonEditStudent->setName($contentsDecoded['name']);
                        $jsonEditStudent->setSurname($contentsDecoded['surname']);
                        $jsonEditStudent->setAge($contentsDecoded['age']);
                        $jsonEditStudent->setCurriculum($contentsDecoded['curriculum']);
                }

            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        if(isset($jsonEditStudent))
        {
            fwrite(STDOUT, "Student ".$jsonEditStudent->getId()." has successfully been updated"."\n");
        }
        return $jsonEditStudent;
    }

    /**
     * @param int $id
     * @return int
     */
    public function deleteStudent(int $id): int
    {

        // TODO: Implement deleteStudent() method.
        $jsonStudent = $this->getStudentById($id);
        if(!empty($jsonStudent))
        {

            $directory = substr($jsonStudent->getId(), 0, 2);
            $dir = $this->basePath."/".$directory;
            try
            {
                foreach(scandir($dir) as $file) {
                    if ('.' === $file || '..' === $file) continue;
                    if (is_dir("$dir/$file"))
                    {
                        rmdir_recursive("$dir/$file");
                    }else{
                        unlink("$dir/$file");
                    }
                }
                if(rmdir($dir))
                {
                    fwrite(STDOUT,"Successfully deleted directory called ".$directory." in Students Directory". "\n\n");
                }else{
                    fwrite(STDOUT,"Can't deleted directory called ".$directory." in Students Directory". "\n\n");
                }
            }catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }

        }
        return $id;
    }

    /**
     */
    public function getAllStudent()
    {
        // TODO: Implement getAllStudent() method.
        $studentsArray = array();
        $directories = scandir($this->basePath);

        if(count($directories) > 0)
        {
            foreach ($directories as $directory)
            {
                if( strlen($directory) == 2)
                {
                    if(is_numeric($directory))
                    {
                        $files  = scandir($this->basePath."/".$directory);

                        if(sizeof($files) > 0)
                        {
                            foreach ($files as $file)
                            {
                                if(strpos($file, "json") !== false){
                                    $partsOfFile = explode(".",$file);
                                    if(strlen($partsOfFile[0]) == 7  &&  $partsOfFile[1] == "json")
                                    {
                                        if(is_numeric($partsOfFile[0]))
                                        {
                                            // Read the JSON file
                                            $jsonResponse = file_get_contents($this->basePath."/".$directory."/".$file);
                                            // Decode the JSON file
                                            $studentJSON = json_decode($jsonResponse,true);

                                            if(!empty($studentJSON))
                                            {
                                                $student = new Student();
                                                $student->setId($studentJSON["id"]);
                                                $student->setName($studentJSON["name"]);
                                                $student->setSurname($studentJSON["surname"]);
                                                $student->setAge($studentJSON["age"]);
                                                $student->setCurriculum($studentJSON["curriculum"]);
                                                array_push($studentsArray, $student);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $studentsArray;
    }

    /**
     * @param string $searchKey
     * @param string $searchValue
     */
    public function getStudentsByCriteria(string $searchKey,string $searchValue)
    {

        // TODO: Implement getStudent() method.
        $students = $this->getAllStudent();
        $filteredStudent = array();
        switch ($searchKey) {
            case "name":
                $filteredStudent = array_filter($students, function ($student) use ($searchValue) {
                    return $student->name == $searchValue;
                });
            break;
            case "surname":
                $filteredStudent = array_filter($students, function ($student) use ($searchValue) {
                    return $student->surname == $searchValue;
                });
            break;
            case "age":
                $filteredStudent = array_filter($students, function ($student) use ($searchValue) {
                    return $student->age == (int)$searchValue;
                });
            break;
            case "curriculum":
                $filteredStudent = array_filter($students, function ($student) use ($searchValue) {
                    return $student->curriculum == $searchValue;
                });
                break;

            default:

        }
       return $filteredStudent;
    }

    /**
     * @param int $id
     * @return Student
     */
    public function getStudentById(int $id): Student
    {
        $student = null;
        if(!empty($id))
        {

            $directories = scandir($this->basePath);
            $lookUpDirectory = substr($id, 0, 2);
            try
            {
                if (in_array($lookUpDirectory, $directories)){

                    if(is_dir($this->basePath."/".$lookUpDirectory) === true )
                    {
                        // Read the JSON file
                        $json = file_get_contents($this->basePath."/".$lookUpDirectory."/".$id.".json");
                        // Decode the JSON file
                        $jsonStudent = json_decode($json,true);

                        if(!empty($jsonStudent))
                        {
                            $student = new Student();
                            $student->setId($jsonStudent["id"]);
                            $student->setName($jsonStudent["name"]);
                            $student->setSurname($jsonStudent["surname"]);
                            $student->setAge($jsonStudent["age"]);
                            $student->setCurriculum($jsonStudent["curriculum"]);

                        }

                    }
                }else{
                    fwrite(STDOUT,"Directory ".$lookUpDirectory." not found in Students Directory". "\n\n");
                }

            }catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }

        }

        // TODO: Implement getStudentById() method.
        return $student;
    }

    public function checkDirectoryExist(int $id): bool
    {
        $valid = false;
        $dir = $this->basePath."/".substr($id, 0, 2);
        try
        {
            if( is_dir($dir) === false )
            {
                fwrite(STDOUT,"The directory called ".substr($id, 0, 2)." does not exist in Students Directory". "\n\n");
            }else{
                $valid = true;
            }
        }catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        return $valid;
    }
}