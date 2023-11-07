<?php

//Create TableCreator class
 class TableCreator
{
	//Constructor for TableCreator class
	public function __construct()
    {
        $tbl_exist = $this->tableExists('Mock');
        if($tbl_exist != "exists"){
        	$this->create();
        }
        $this->fill();
    }


    //Create create method.Only access within the class
    private function create()
    {
        // Database connection 
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'test';
	    // Create a new PDO connection to the database
		try {
		    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
		    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
		    die("Database connection failed: " . $e->getMessage());
		}

		// SQL code to create the Test table
        $query = "CREATE TABLE Mock (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50),
            date_time DATETIME
            -- end_time DATETIME,
            -- result ENUM('normal', 'illegal', 'failed', 'success')
        )";
		$pdo->exec($query);

    }

    //Create table exist method for checking table is exist or not
    public function tableExists($tbl)
	{
		// Database connection 
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'test';
	    // Create a new PDO connection to the database
		try {
		    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
		    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
		    die("Database connection failed: " . $e->getMessage());
		}

		//Show the table
	    $results = $pdo->query("SHOW TABLES LIKE '$tbl'");
	    if(!$results) {
	        die(print_r($pdo->errorInfo(), TRUE));
	    }

	    //Count greater than 0 it will return exists
	    if($results->rowCount()>0){return 'exists';}
	}

    //Create fill method.Only access within the class
    private function fill()
    {
    	//Call random data function
    	$data = $this->randomData();

    	// Database connection 
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'test';
	    // Create a new PDO connection to the database
		try {
		    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
		    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
		    die("Database connection failed: " . $e->getMessage());
		}

    	// SQL code to insert data into the Test table
        $query = "INSERT INTO Mock (name, date_time) VALUES (?, ?)";
        $pdo->prepare($query)->execute([$data['name'], $data['date_time']]);

    }

    //Generate random data for the Test table by randomData method.
    private function randomData()
    {
    	$firstname = array(
        'Johnathon',
        'Anthony',
        'Erasmo',
        'Raleigh',
        'Nancie',
        'Tama',
        'Camellia',
        'Augustine',
        'Christeen',
        'Luz',
        'Diego',
        'Lyndia',
        'Thomas',
        'Georgianna',
        'Leigha',
        'Alejandro',
        'Marquis',
        'Joan',
        'Stephania',
        'Elroy',
        'Zonia',
        'Buffy',
        'Sharie',
        'Blythe',
        'Gaylene',
        'Elida',
        'Randy',
        'Margarete',
        'Margarett',
        'Dion',
        'Tomi',
        'Arden',
        'Clora',
        'Laine',
        'Becki',
        'Margherita',
        'Bong',
        'Jeanice',
        'Qiana',
        'Lawanda',
        'Rebecka',
        'Maribel',
        'Tami',
        'Yuri',
        'Michele',
        'Rubi',
        'Larisa',
        'Lloyd',
        'Tyisha',
        'Samatha',
    );

    $lastname = array(
        'Mischke',
        'Serna',
        'Pingree',
        'Mcnaught',
        'Pepper',
        'Schildgen',
        'Mongold',
        'Wrona',
        'Geddes',
        'Lanz',
        'Fetzer',
        'Schroeder',
        'Block',
        'Mayoral',
        'Fleishman',
        'Roberie',
        'Latson',
        'Lupo',
        'Motsinger',
        'Drews',
        'Coby',
        'Redner',
        'Culton',
        'Howe',
        'Stoval',
        'Michaud',
        'Mote',
        'Menjivar',
        'Wiers',
        'Paris',
        'Grisby',
        'Noren',
        'Damron',
        'Kazmierczak',
        'Haslett',
        'Guillemette',
        'Buresh',
        'Center',
        'Kucera',
        'Catt',
        'Badon',
        'Grumbles',
        'Antes',
        'Byron',
        'Volkman',
        'Klemp',
        'Pekar',
        'Pecora',
        'Schewe',
        'Ramage',
    );

    $name = $firstname[rand ( 0 , count($firstname) -1)];
    $name .= ' ';
    $name .= $lastname[rand ( 0 , count($lastname) -1)];
        return [
            'name' => $name,
            'date_time' => date('Y-m-d H:i:s', rand(0, time())),
            // 'end_time' => date('Y-m-d H:i:s', rand(0, time())),
            // 'result' => ['normal', 'illegal', 'failed', 'success'][rand(0, 3)],
        ];
    }

     public function get()
    {
    	// Database connection 
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'test';
    	// Create a new PDO connection to the database
		try {
		    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
		    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
		    die("Database connection failed: " . $e->getMessage());
		}
        // SQL code to select data from the Test table 
        $query = "SELECT * FROM Mock ";
        return $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

}

//Create object and access the class data
$obj = new TableCreator();
$data = $obj->get();
print_r($data);
?>
