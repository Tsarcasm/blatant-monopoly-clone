<?php
require_once "entity.php";
require_once "data.php";
class Base extends Entity
{
    public $h_id;
    public $name;
    public $ip_address;
    public $created;

    public function getFarms()
    {
        return Farm::getAllWhere("base_pk = ?", [$this->pk]);
    }

    public function getLastContact()
    {
        $pdo = Database::getConnection();
        $sql = "SELECT MAX(upload_token.timestamp) AS last_contact FROM base
        INNER JOIN farm ON farm.base_pk = base.pk
        INNER JOIN upload_token ON upload_token.farm_pk = farm.pk
        WHERE base.pk = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$this->pk]);
        $row = $stmt->fetch();
        return $row["last_contact"];

    }

}

class Farm extends Entity
{
    public $base_pk;
    public $h_id;
    public $name;
    public $location;
    public $created;

    public function getMachines()
    {
        return Machine::getAllWhere("farm_pk = ?", [$this->pk]);
    }

    public function getLastContact()
    {
        $arr = Upload_Token::getAllQuery("WHERE farm_pk = ? ORDER BY timestamp DESC LIMIT 1", [$this->pk]);
        return (count($arr) > 0) ? $arr[0]->timestamp : $this->created;
    }
}

class Machine extends Entity
{
    public $farm_pk;
    public $h_id;
    public $name;
    public $created;

    public function getSensors()
    {
        return Machine_Sensor::getAllWhere("machine_pk = ? ORDER BY hardware_index ASC", [$this->pk]);
    }

    public function getData($limit)
    {
        return Machine_Segments::getAllWhere("machine_pk = ? ORDER BY pk DESC LIMIT ? ", [$this->pk, $limit]);
    }

    public function getLastContact() {
        $last = $this->getData(1);
        if (count($last) == 0) return $this->created;
        // todo make this one query
        return Upload_Token::get($last[0]->upload_token_pk)->timestamp;
    }


}
