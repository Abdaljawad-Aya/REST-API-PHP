<?php 
 class Category {
    // DB stuff
    private $conn;
    private $table = "categories";

    // Post Properties

    public $id;
    public $name;
    public $created_at;

    // constructor 
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Categories 
    public function read() {
        $query = 'SELECT 
            id,
            name,
            created_at 
          FROM 
         '. $this->table . '
          ORDER BY created_at DESC' ; 


        // Prepared statment 
        $stmt = $this->conn->prepare($query);

        // Execute query 
        $stmt->execute();

        return $stmt;
    }

      // Get single Post
      public function read_single() {
        $query =  'SELECT 
        id,
        name
      FROM 
     '. $this->table . '
      WHERE id = ?' ;
        
        // prepare statment 
        $stmt = $this->conn->prepare($query);

        // Bind ID 
        $stmt->bindParam(1, $this->id);

        // Execute query 
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->id  = $row['id'];
        $this->name   = $row['name'];
        
    }

    // Create Category 
    public function create() {
        // Create query 
        $query = 'INSERT INTO ' . 
           $this->table. '
          SET 
            name = :name ';

        // Prepare statment 
        $stmt = $this->conn->prepare($query);
        
        // Clean data 
        $this->name  = htmlspecialchars(strip_tags($this->name));

        // Bind data 
        $stmt->bindParam(':name',  $this->name);

         // Execute quer 
         if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong 
        printf("Error: %s.\n" , $stmt->error);

        return false;

    }

    // Update category 
    public function update() {
        // Create query 
        $query = 'UPDATE ' . $this->table . '
          SET 
            name = :name
          WHERE 
            id = :id';

        // Prepare statment
        $stmt = $this->conn->prepare($query);
        
        // Clean data 
        $this->name  = htmlspecialchars(strip_tags($this->name));
        $this->id    = htmlspecialchars(strip_tags($this->id));
        
        // Bind data 
        $stmt->bindParam(':name',  $this->name);
        $stmt->bindParam(':id',    $this->id);
        
          // Execute query
          if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong 
        printf("Error: %s.\n" , $stmt->error);

        return false;
    }

    // Delete Post 
    public function delete()
    {
        // Create query 
        $query = 'DELETE FROM ' . 
        $this->table. ' WHERE id = :id';

        //  Prepare statment 
        $stmt = $this->conn->prepare($query);
        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        // Bind data
        $stmt->bindParam(':id', $this->id);
        
         // Execute query 
         if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong 
        printf("Error: %s.\n" , $stmt->error);

        return false;
   
    }
    
}

?>