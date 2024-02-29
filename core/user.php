<?php

class User{
    // properties for database stuff
    private $conn;
    private $table = 'users';

    // properties of User
    public $id;
    public $username;
    public $email;
    public $password;

    // User Constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // Getting Users from db
    public function read(){
        // Read Query
        $query = 'SELECT *
                    FROM '.$this->table.' u
                    ORDER BY u.username ASC;';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    public function read_single(){
        $query = 'SELECT *
                    FROM '.$this->table.' u
                    WHERE u.id = ? LIMIT 1;';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->username = $row['username'];
        $this->email = $row['email'];
        $this->password = $row['password'];

        return $stmt;
    }

    public function create(){
        $query = 'INSERT INTO '.$this->table.' 
                    (username, email, password)
                    VALUES(:username, :email, :password);';

        $stmt = $this->conn->prepare($query);

        // clean data sent by user (for security)
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // bind parameters to request
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()){
            return true;
        }

        printf('Error %s. \n', $stmt->error);
        return false;
    }

    public function update(){
        $query = 'UPDATE '.$this->table.'
                    SET username = :username,
                    email = :email,
                    password = :password
                    WHERE id = :id;';

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        if($stmt->execute()){
            return true;
        }

        printf('Error: %s. \n',$stmt->error);
        return false;
    }

    public function updatePassword(){
        $query = 'UPDATE '.$this->table.'
                    SET password = :password
                    WHERE id = :id;';

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':password', $this->password);

        if($stmt->execute()){
            return true;
        }

        printf('Error: %s. \n',$stmt->error);
        return false;
    }

    public function delete(){
        $query = 'DELETE FROM '.$this->table.' WHERE id = :id;';

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }

        printf('Error: %s. \n',$stmt->error);
        return false;
    }
}