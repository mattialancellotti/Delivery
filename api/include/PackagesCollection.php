<?php
class PackagesCollection {
  private $collection;

  public function __construct() {
    $this->collection = array();
  }

  /* Returns an instance of itself */
  public function create() {
    return new self();
  }

  public function toMultiArray($mysqli_result) {
    ($mysqli_result == FALSE) and die("Problem with the query");

    while ($row = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC)) {
      array_push($this->collection,
        array(
          "idSpedizione" => 
            (isset($row['idSpedizione']) ? $row['idSpedizione'] : null),
          "clienteSrc"   =>
            (isset($row['clienteSrc'])   ? $row['clienteSrc']   : null),
          "clienteDst"   =>
            (isset($row['clienteDst'])   ? $row['clienteDst']   : null),
          "dataPartenza" =>
            (isset($row['dataPartenza']) ? $row['dataPartenza'] : null),
          "oraPartenza"  =>
            (isset($row['oraPartenza'])  ? $row['oraPartenza']  : null),
          "qrCode"       =>
            (isset($row['qrCode'])       ? $row['qrCode']       : null),
          "pagamento"    =>
            (isset($row['pagamento'])    ? $row['pagamento']    : null),
        )
      );
    }

    return $this->collection;
  }
}
?>
