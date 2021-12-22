<?php

class Student extends Dbh {
    private $RegNo;
    private $FullName;
    private $Cellphone;
    private $Addr;
    private $Image;

    public function __construct()
    {
        // Default
    }

    public function setAll($RegNo,$FullName,$Cellphone,$Addr,$Image){
        $this->RegNo = $RegNo;
        $this->FullName = $FullName;
        $this->Cellphone = $Cellphone;
        $this->Addr = $Addr;
        $this->Image = $Image;
    }

    // Get ALl information about All Students 
    // to fetch it on table 

    public function getAllStudents() {
        $stmt = $this->connect()->prepare("SELECT *FROM students");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // to handle registration Number 

    public function getLastRegNo(){
        $stmt = $this->connect()->prepare("SELECT RegNo FROM students ORDER BY idS DESC limit 1");
        $stmt->execute();
        return $stmt->fetch();
    } 

    // Insert Information About Student
    
    public function insertStudent($RegNo,$FullName,$Cellphone,$Addr,$Image){
        $sql = "INSERT INTO students (RegNo,Fullname,Cellphone,Addr,Image) values (?,?,?,?,?) ";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$RegNo,$FullName,$Cellphone,$Addr,$Image]);
        return $stmt->rowCount();
    }

    // get all information about a Student 

    public function getStudent($regNo) {
        $stmt = $this->connect()->prepare("SELECT * FROM students WHERE RegNo = ?");
        $stmt->execute([$regNo]);
        return $stmt->fetch();
    }

    public function updateStudent($fname,$phone,$addr,$image,$regNo){
        $stmt = $this->connect()->prepare("UPDATE students SET Fullname = ? , Cellphone = ? , Addr = ? , Image = ? WHERE RegNo = ? ");
        $stmt->execute([$fname,$phone,$addr,$image,$regNo]);
        return $stmt->rowCount();
    }

    public function deleteStudent($regNo){
        $stmt = $this->connect()->prepare("DELETE FROM students WHERE regNo = ?");
        $stmt->execute([$regNo]);
        return $stmt->rowCount();
    }

}

?>