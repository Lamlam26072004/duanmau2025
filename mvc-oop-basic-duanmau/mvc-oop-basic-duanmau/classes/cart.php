<?php
$filepath = realpath(dirname(__FILE__));
require_once ($filepath.'/../lib/database.php');
require_once ($filepath.'/../helpers/format.php');

class cart 
{
    private $db;
    private $fm;
    
    public function __construct()  
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

}
?>
