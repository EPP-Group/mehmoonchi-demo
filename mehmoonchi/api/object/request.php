<?php
class Request
{
    private $conn;
    private $table_name = "request";

    public $pk_id;
    public $full_name;
    public $description;
    public $phone;
    public $date;
    public $type;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function read()
    {
        $query = "SELECT
                 pk_id,full_name,description,type,date,phone
            FROM
                " . $this->table_name . "
                ORDER BY
                date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function create()
    {
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                full_name=:full_name, phone=:phone, description=:description, type=:type, date=:date";
        $stmt = $this->conn->prepare($query);

        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->date = htmlspecialchars(strip_tags($this->date));

        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":date", $this->date);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
