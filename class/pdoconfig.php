<?php
// ---
// Nom : pdoconfig.php
// Par : Nicolas Montfort
// Le : 4 decembre 2012
// Description : Configuration et initialisation de PDO
// ---


class pdoconfig extends PDO
{
        public function __construct($dsn, $user=NULL, $password=NULL)
        {
                parent::__construct($dsn, $user, $password);
                $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        public function prepare($sql, $options=NULL)
        {
                $statement = parent::prepare($sql);
                if(strpos(strtoupper($sql), 'SELECT') === 0)
                {
                        $statement->setFetchMode(PDO::FETCH_ASSOC);
                }
                return $statement;
        }
}
?>
