<?php

class Connection
{
public PDO $pdo;
public function __construct()
{
    $dsn="mysql:server=localhost;dbname=notes";
    $user='root';
    $pass='';
    $option=array(
        PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'
    );
    $this->pdo=new PDO($dsn,$user,$pass,$option);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
public function getNotes()
{
    $statement=$this->pdo->prepare("SELECT * FROM notes ORDER BY created_at DESC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

public function getNoteById($id)
{
    $statement=$this->pdo->prepare("SELECT * FROM notes WHERE id=:id");
    $statement->bindValue('id',$id);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}
public function addNote($note)
{
    $statement = $this->pdo->prepare("
    INSERT INTO notes (title, description, created_at)  
    VALUES (:title, :description, :date)
");

    $statement->bindValue('title', $note['title']);
    $statement->bindValue('description', $note['description']);
    $statement->bindValue('date', date('Y-m-d H:i:s'));
    return $statement->execute();
}
public function updateNote($id,$note)
{
    $statement=$this->pdo->prepare("UPDATE notes SET title =:title, description=:description WHERE id=:id");
    $statement->bindValue('id',$id);
    $statement->bindValue('title',$note['title']);
    $statement->bindValue('description',$note['description']);
    $statement->execute();
}
public function removeNote($id)
{
    $statement=$this->pdo->prepare("DELETE from notes WHERE id=:id");
    $statement->bindValue('id',$id);
    $statement->execute();
}
}

return new Connection();