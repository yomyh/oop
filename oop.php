<?php
class Database {
    private $connection;

    public function connect($username, $password) {
        $this->connection = new PDO("mysql:host=localhost;dbname=mydatabase", $username, $password);
        echo "$password";
    }

    public function insert($tableName, $columns) {
        $columnNames = implode(",", array_keys($columns));
        $columnValues = implode(",", array_values($columns));
        $query= "INSERT INTO $tableName ($columnNames) VALUES ($columnValues)";
        $this->connection->exec($query);
        echo " $tableName";
    }

    public function select($tableName) {
        // Retrieve and print the data from the specified table
        $query = "SELECT * FROM $tableName";
        $result = $this->connection->query($query);
        echo "Data from table $tableName:\n";
        foreach ($result as $row) {
            echo implode(", ", $row) . "\n";
        }
    }

    public function update($tableName, $id, $fields) {
        $updateFields = array();
        foreach ($fields as $column => $value) {
            $updateFields[] = "$column = '$value'";
        }
        $updateFieldsString = implode(", ", $updateFields);
        $query = "UPDATE $tableName SET $updateFieldsString WHERE id = $id";
        $this->connection->exec($query);
        echo "Updated record with ID $id in table $tableName\n";
    }

    public function delete($tableName, $id) {
        $query = "DELETE FROM $tableName WHERE id = $id";
        $this->connection->exec($query);
        echo "Deleted record with ID $id from table $tableName\n";
    }
}

$db = new Database();
$db->connect("username", "password");

$db->insert("users", ["name" => "Mona Mohamed",
"email" => "mona.mohamed@example.com"
]);

$db->select("users");

$db->update("users", 1, ["name" => "Mazen Ahmed",
    "email" => "mazen.ahmed@example.com"
]);

$db->delete("users", 1);
?>