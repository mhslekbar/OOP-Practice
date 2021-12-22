<?php

    /* Start Login */

    // check if user and pass is coming from database
    function checkUserPass($user,$pass){
        global $con;
        $stmt = $con->prepare("SELECT * FROM users WHERE username = ? AND password = ? ");
        $stmt->execute(array($user,$pass));
        $count = $stmt->rowCount();
        return $count;
    }

    /* End Login */

    /* Start Student  */ 

    // getClass
    function getClass(){
        global $con;
        $stmt = $con->prepare("SELECT * FROM classes");
        $stmt->execute();
        $class = $stmt->fetchAll();
        return $class;
    }
    // select rno Student 

    function getRnoStudent(){
        global $con;
        $stmt = $con->prepare("SELECT * FROM student ORDER BY idStudent Desc limit 1");
        $stmt->execute();
        $stud = $stmt->fetch();
        return $stud; 
    }

    // Insert Student 
    
    function insertStudent($rno,$fname,$classe,$addr){
        global $con;
        $stmt = $con->prepare("INSERT INTO student (RegNo,FullName,idClasse,Addr) values (?,?,?,?) ");
        $stmt->execute(array($rno,$fname,$classe,$addr));
        $insert = $stmt->rowCount();
        return $insert;
    }

    // getAllStudent()

    function getStudent($classe){
        global $con;
        $stmt = $con->prepare("SELECT * FROM student WHERE idClasse = ?");
        $stmt->execute(array($classe));
        $student = $stmt->fetchAll();
        return $student;
    }

    /* End  Student  */ 


?>