<?php
class crudmascota
{
    private $db;
    function __construct($conn)
    {
        $this->db = $conn;
    }

    public function update($id, $nombre,$raza,$peso, $color)
    {
        try {
            $stmt = $this->db->prepare("update mascota set nombre= :nombre,raza= :raza,peso= :peso, color= :color where id= :id");
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":raza", $raza);
            $stmt->bindParam(":peso", $peso);
            $stmt->bindParam(":color", $color);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // echo $e->getMessage();
            // return false;
            throw $e;
        }
    }
    public function getID($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM mascota WHERE id=:id");
        $stmt->execute(array(":id" => $id));
        $editRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE  FROM mascota WHERE id=:id");
        $stmt->bindparam(":id", $id);
       $stmt->execute();
        return true;
    }

    //Muestra los datos en la tabla
    public function datamascota($query)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute() > 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['raza']; ?></td>
                <td><?php echo $row['peso']; ?></td>
                <td><?php echo $row['color']; ?></td>
                <td>
                <a class="btn btn-large btn-success" href="edit_mascota.php?edit_id=<?php echo $row['id'] ?>"> Editar</a>
                </td>
                <td>
                <a class="btn btn-large btn-danger" href="eliminar_mascota.php?delete_id=<?php echo $row['id'] ?>"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</a>
                </td>
            </tr>

<?php

        }
    }
}