<?php
include "classes\Student.php";
include "classes\StudentData.php";

    $crud_actions = array("--action=add", "--action=edit", "--action=delete", "--action=search");
        if($argc > 1)
            if(in_array($argv[1],$crud_actions )){

                $studentData = null;
                $baseUrl = "C:/PhpTerminalProject/Bidvest Assessment/Bidvest Project/StudentManagementConsole/students";

                if($argv[1] == $crud_actions[0]){

                    //Generate Id and display it
                    $digits = 7;
                    $randomId = rand(pow(10, $digits-1), pow(10, $digits)-1);
                    fwrite(STDOUT, "Enter id : ". $randomId."\n");
                    $id = $randomId;
                    if(!is_numeric($id))
                    {
                        exit();
                    }
                    //Validate Name is not numeric or empty
                    do {
                        $validateName = false;
                        fwrite(STDOUT, "Enter name : ");
                        $name = htmlspecialchars(trim(fgets(STDIN)));

                        if($name == "" || empty($name))
                        {
                            $validateName = true;
                        }

                        if(is_numeric($name))
                        {
                            $validateName = true;
                        }

                        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $name))
                        {
                            $validateName = true;
                        }

                    } while ($validateName);

                    //Validate Surname is not numeric or empty
                    do {
                        $validateSurname = false;
                        fwrite(STDOUT, "Enter surname : " );
                        $surname = htmlspecialchars(trim(fgets(STDIN)));

                        if($surname == "" || empty($surname))
                        {
                            $validateSurname = true;
                        }

                        if(is_numeric($surname))
                        {
                            $validateSurname = true;
                        }

                        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $surname))
                        {
                            $validateSurname = true;
                        }

                    } while ($validateSurname);

                    //According to the South African Schools Act of 1996, schooling is compulsory for all South Africans from the age of six (grade 1) to the age of 15, or the completion of grade 9.
                    //Age start 6
                    //According to this criterion, the longest human lifespan is that of Jeanne Calment of France (1875–1997), who lived to age 122 years
                    //Age ends 122

                    do {
                        $validateAge = false;
                        fwrite(STDOUT, "Enter age : " );
                        $age = htmlspecialchars(trim(fgets(STDIN)));

                        if($age < 6 )
                        {
                            $validateAge = true;
                        }
                        if(!is_numeric($age))
                        {
                            $validateAge = true;
                        }

                    } while ($validateAge);

                    //Validate Curriculum
                    do {
                        $validateCurriculum = false;
                        fwrite(STDOUT, "Enter curriculum : " );
                        $curriculum = htmlspecialchars(trim(fgets(STDIN)));

                        if($curriculum == "" || empty($curriculum))
                        {
                            $validateCurriculum = true;
                        }

                        /*if(is_numeric($curriculum))
                        {
                            $validateCurriculum = true;
                        }

                        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $curriculum))
                        {
                            $validateCurriculum = true;
                        }*/

                    } while ($validateCurriculum);

                    $addStudent = new Student();
                    $addStudent->setId($id);
                    $addStudent->setName(strtolower($name));
                    $addStudent->setSurname(strtolower($surname));
                    $addStudent->setAge($age);
                    $addStudent->setCurriculum(strtolower($curriculum));

                    $studentData = new StudentData($baseUrl);

                    $studentData->addStudent($addStudent);

                }else if($argv[1] == $crud_actions[1])
                {
                    if(count($argv) == 3)
                    {
                        $studentData = new StudentData($baseUrl);
                        $partOfaction = "--id=";
                        if(strpos($argv[2], $partOfaction) !== false){
                            $argument = explode("=",$argv[2]);
                            $idLength = strlen($argument[1]);
                            if($idLength == 7)
                            {
                                if($studentData->checkDirectoryExist($argument[1])){
                                    $Id = (int)$argument[1];
                                    //Validate Name is not numeric or empty
                                    do {
                                        $validateName = false;
                                        fwrite(STDOUT, "Enter name : ");
                                        $name = htmlspecialchars(trim(fgets(STDIN)));

                                        if($name == "" || empty($name))
                                        {
                                            $validateName = true;
                                        }

                                        if(is_numeric($name))
                                        {
                                            $validateName = true;
                                        }

                                        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $name))
                                        {
                                            $validateName = true;
                                        }

                                    } while ($validateName);

                                    //Validate Surname is not numeric or empty
                                    do {
                                        $validateSurname = false;
                                        fwrite(STDOUT, "Enter surname : " );
                                        $surname = htmlspecialchars(trim(fgets(STDIN)));

                                        if($surname == "" || empty($surname))
                                        {
                                            $validateSurname = true;
                                        }

                                        if(is_numeric($surname))
                                        {
                                            $validateSurname = true;
                                        }

                                        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $surname))
                                        {
                                            $validateSurname = true;
                                        }

                                    } while ($validateSurname);

                                    //According to the South African Schools Act of 1996, schooling is compulsory for all South Africans from the age of six (grade 1) to the age of 15, or the completion of grade 9.
                                    //Age start 6
                                    //According to this criterion, the longest human lifespan is that of Jeanne Calment of France (1875–1997), who lived to age 122 years
                                    //Age ends 122

                                    do {
                                        $validateAge = false;
                                        fwrite(STDOUT, "Enter age : " );
                                        $age = htmlspecialchars(trim(fgets(STDIN)));

                                        if($age < 6 )
                                        {
                                            $validateAge = true;
                                        }
                                        if(!is_numeric($age))
                                        {
                                            $validateAge = true;
                                        }

                                    } while ($validateAge);

                                    //Validate Curriculum
                                    do {
                                        $validateCurriculum = false;
                                        fwrite(STDOUT, "Enter curriculum : " );
                                        $curriculum = htmlspecialchars(trim(fgets(STDIN)));

                                        if($curriculum == "" || empty($curriculum))
                                        {
                                            $validateCurriculum = true;
                                        }

                                    } while ($validateCurriculum);

                                    $editStudent = new Student();
                                    $editStudent->setId($Id);
                                    $editStudent->setName(strtolower($name));
                                    $editStudent->setSurname(strtolower($surname));
                                    $editStudent->setAge($age);
                                    $editStudent->setCurriculum(strtolower($curriculum));

                                    $editJSONStudent = $studentData->editStudent($editStudent,$Id);

                                }
                            }else{
                                fwrite(STDOUT, "Please these command php run.php --action=edit --id=".$argument[1].". Unique Id must be 7 digits" . "\n");
                            }
                        } else{
                            fwrite(STDOUT, "Please these command php run.php --action=edit --id=1234567" . "\n");
                        }

                    }else{
                        displayValidCommands($crud_actions);
                    }

                }else if($argv[1] == $crud_actions[2])
                {
                    if(count($argv) == 3)
                    {
                        $partOfAction = "--id=";
                        if(strpos($argv[2], $partOfAction) !== false){
                            $argument = explode("=",$argv[2]);
                            $idLength = strlen($argument[1]);
                            if($idLength == 7)
                            {
                                $Id = (int)$argument[1];

                                //check if the directory exist

                                $studentData = new StudentData($baseUrl);

                                $checked = $studentData->checkDirectoryExist($Id);
                                if($checked)
                                {
                                    $studentData->deleteStudent($Id);
                                }

                            }else{
                                fwrite(STDOUT, "Please these command php run.php --action=edit --id=".$argument[1].". Unique Id must be 7 digits" . "\n");
                            }
                        } else{
                            fwrite(STDOUT, "Please these command php run.php --action=edit --id=1234567" . "\n");
                        }
                    }else{
                        displayValidCommands($crud_actions);
                    }
                }else if($argv[1] == $crud_actions[3])
                {
                    $message = "";
                    $studentData = new StudentData($baseUrl);

                    do {
                        $validateSearchValue = false;
                        fwrite(STDOUT, "Enter Search criteria : ");
                        $searchValue = htmlspecialchars(trim(fgets(STDIN)));

                        if ($searchValue == "" || empty($searchValue)) {
                            $allStudents = $studentData->getAllStudent();
                            $mask = "|%-15.30s |%-15.30s | %-15.30s|%-7.4s|%-15.30s |\n";
                            printf($mask, 'id', 'Name','Surname','Age' ,'Curriculum');
                            foreach ($allStudents as $student)
                            {
                                printf($mask, $student->getId(), $student->getName(),$student->getSurname(),$student->getAge(),$student->getCurriculum());
                            }
                        } else {

                            $argument = explode("=", $searchValue);
                            if (sizeof($argument) == 2)
                            {
                                $studentFieldArray = array("name", "surname", "age","curriculum");
                                if (in_array($argument[0], $studentFieldArray)) {
                                   $studentsFiltered = $studentData->getStudentsByCriteria($argument[0],$argument[1]);
                                    $mask = "|%-15.30s |%-15.30s | %-15.30s|%-7.4s|%-15.30s |\n";
                                    printf($mask, 'id', 'Name','Surname','Age' ,'Curriculum');
                                    foreach ($studentsFiltered as $student)
                                    {
                                        printf($mask, $student->getId(), $student->getName(),$student->getSurname(),$student->getAge(),$student->getCurriculum());
                                    }
                                } else {
                                    $message = $argument[0] ." is not a valid criteria". "\n";
                                    $validateSearchValue = true;
                                }
                            } else {
                                displayValidCriteria();
                            }
                        }
                        if($validateSearchValue)
                        {
                            fwrite(STDOUT, $message);
                        }
                    }while ($validateSearchValue);
                }
            }else{
                fwrite(STDOUT, "Invalid argument ".$argv[1]." for Student Management Console!" . "\n");
                displayValidCommands($crud_actions);

            }
        else{
            displayValidCommands($crud_actions);
        }

    function displayValidCommands($crud_actions)
    {
        fwrite(STDOUT, "Welcome to Student Management Console" . "\n\n");
        $executeFile = "php run.php";
        $idParameter = "--id=1234567";
        fwrite(STDOUT, "Valid Commands For Student Management Console:" . "\n\n");

        foreach ($crud_actions as $action) {

            if($action == $crud_actions[1])
            {
                fwrite(STDOUT, "$executeFile ".$action." ".$idParameter. "\n");
            }else if($action == $crud_actions[2]){
                fwrite(STDOUT, "$executeFile ".$action." ".$idParameter. "\n");
            }else{
                fwrite(STDOUT, "$executeFile ".$action. "\n");
            }
        }

    }

    function displayValidCriteria()
    {
        fwrite(STDOUT, "Please use any of the below criteria " . "\n");
        fwrite(STDOUT, "name=macdonald". "\n");
        fwrite(STDOUT, "surname=nkoana". "\n");
        fwrite(STDOUT, "age=15". "\n");
        fwrite(STDOUT, "curriculum=math". "\n");

    }

    function checkCriteriaExist($searchValue)
    {
        $valid = false;
        $student = new Student();
        foreach ($student as $key => $value) {
            print_r("$key => $value\n");
        }
        return $valid;
    }


