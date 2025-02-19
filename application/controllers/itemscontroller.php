<?php
class ItemsController extends Controller {

    function view($id = null, $name = null) {
        $this->set('title', $name . ' - My Todo List App');
        $this->set('todo', $this->_model->select($id));
    }

    function viewall() {
        $this->set('title', 'All Items - My Todo List App');
        $this->set('todo', $this->_model->selectAll());
    }

    function add() {
        if (isset($_POST['todo'])) {
            $todo = $_POST['todo'];

            // Correction ici : utilisation correcte de getTable()
            $tableName = $this->_model->getTable();

            $query = "INSERT INTO $tableName (item_name) VALUES (:todo)";
            $stmt = $this->_model->getDbHandle()->prepare($query);
            $stmt->bindParam(':todo', $todo, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $this->set('title', 'Success - My Todo List App');
                $this->set('todo', "Item added successfully.");
            } else {
                $this->set('title', 'Error - My Todo List App');
                $this->set('todo', "Failed to add item.");
            }
        }
    }

    function delete($id = null) {
        if ($id !== null) {
            // Correction ici : utilisation correcte de getTable()
            $tableName = $this->_model->getTable();

            $query = "DELETE FROM $tableName WHERE id = :id";
            $stmt = $this->_model->getDbHandle()->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $this->set('title', 'Success - My Todo List App');
                $this->set('todo', "Item deleted successfully.");
            } else {
                $this->set('title', 'Error - My Todo List App');
                $this->set('todo', "Failed to delete item.");
            }
        }
    }
}

