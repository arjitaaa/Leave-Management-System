<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    // Create database connection
    $conn = new mysqli('localhost', 'root', '', 'leavedb');
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $email=$_POST['email'];
        $pass=$_POST['pass'];
        $rollNo=$_POST['rollNo'];
        $studentId=$_POST['studentId'];
        $registrationDate=$_POST['registrationDate'];
        $registrationTime=$_POST['registrationTime'];
        $firstName=$_POST['firstName'];
        $lastName=$_POST['lastName'];
        $branch=$_POST['branch'];
        $class=$_POST['class'];
        $semester=$_POST['semester'];
        $mobile=$_POST['mobile'];
        $internalNo=$_POST['internalNo'];
        $studentPermanentAddress=$_POST['studentPermanentAddress'];
        $studentPresentAddress=$_POST['studentPresentAddress'];
        $fatherName=$_POST['fatherName'];
        $fatherMobile=$_POST['fatherMobile'];
        $fatherAddress=$_POST['fatherAddress'];
        $motherName=$_POST['motherName'];
        $motherMobile=$_POST['motherMobile'];
        $motherAddress=$_POST['motherAddress'];

        //Handle file upload
        $photo="";
        if(isset($_FILES["photo"])&& $_FILES["photo"]["error"]==0)
        {
            $target_dir="uploads/";
            $photo=$target_dir.basename($_FILES["photo"]["name"]);
            //Create uploads directory if not exists
            if(!is_dir($target_dir))
            {
                mkdir($target_dir,0777,true);
            }
            move_uploaded_file($_FILES["photo"]["tmp_name"],$photo);
        }

        
        


        $sql="INSERT INTO student (email,pass,rollNo,studentId,registrationDate,registrationTime,firstName,
        lastName,branch,class,semester,mobile,internalNo,studentPermanentAddress,studentPresentAddress,photo,
        fatherName,fatherMobile,fatherAddress,motherName,motherMobile,motherAddress)VALUES('$email','$pass','$rollNo','$studentId',
        '$registrationDate','$registrationTime','$firstName','$lastName','$branch','$class','$semester','$mobile',
        '$internalNo','$studentPermanentAddress','$studentPresentAddress','$photo','$fatherName','$fatherMobile','$fatherAddress',
        '$motherName','$motherMobile','$motherAddress')";

        if ($conn->query($sql) === TRUE) 
        {
            echo "<script>alert('Registration successful!'); window.location.href = 'login.html';</script>";
        } 
        else 
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $conn->close();
?>