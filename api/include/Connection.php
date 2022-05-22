<?php
  class Connection {
    # Database info
    private $db_host;
    private $db_user;
    private $db_name;

    # Connection info
    private $conn;

    # Constructor
    public function __construct($host, $user, $name) {
      $this->db_host = $host;
      $this->db_user = $user;
      $this->db_name = $name;
      $this->conn    = NULL;
    }

    public static function create() {
      return new self();
    }

    public function establish() {
      @($this->conn = new mysqli
          ($this->db_host, $this->db_user, "", $this->db_name))->connect_errno 
        and die("Impossibile stabilire la connessione");
    }

    public function getConnection() {
      return $this->conn;
    }

    public function is_dead() {
      return $this->conn == FALSE;
    }

    public function exec($query) {
      return $this->conn->query($query);
    }

    public function disconnect() {
      @mysqli_close($this->conn) or die("Impossibile chiudere la connessione");
    }
  }
?>
