<?php

include_once("../include/connectionDetails.php");

class DB{
	
    protected $bDebug = 0;  //Debug flag
    protected $obDB;    //Database object we will work with
    protected $queryResult;    //Any result that might be returned

    public function __construct() {
        $this->obDB = new mysqli(HOST,USER, PASSWORD, DB);
    }
    public function setDebug($bValue)
    {
        $this->bDebug = $bValue;
    }
    /**
     * Function: doQuery
     * Purpose: Query the database based on SQL passed in. Set queryResult to 
     *          the returned string, so fetchAssocResult can use the query to 
     *          return information in an associative array
     * @param STRING $sQuery
     */
    public function doQuery($sQuery)
    {
        if($this->bDebug)
        {
            echo "<br><br>DOING QUERY:<br>";
            echo "In Query: Running statement $sQuery";
        }
        $this->queryResult = $this->obDB->query($sQuery);
    }

    /**
     * Function: sanitize
     * Purpose: Sanitizes input for submission into DB
     * @param STRING $sTarget
     * @return STRING 
     */
    function sanitize($sTarget)
    {
        $sResult = filter_input(INPUT_POST, $sTarget, FILTER_SANITIZE_MAGIC_QUOTES);

        return trim($sResult);
    }
    /**
     * Function fetchAssocResult
     * Purpose  This will fetch the complete result as an associated array
     * @return Associative Array: 
     *      Will return in this format ( [0] => Array ( [COL_NAME] => VALUE ) )
     */
    public function fetchAssocResult()
    {
        $aResults = array();

        for ($i=0; $i < $this->obDB ->affected_rows; $i++)
        {
            array_push($aResults,$this->queryResult->fetch_assoc());
        }

        $this->queryResult->data_seek(0);

        return $aResults;
    }

    /**
    * Function getPrimeKey
    * Purpose  This will just return the primary key of the last successful
    * 	insert statement. This is a critical function for working with foreign
    * 	keys when an insert table will neccessitate another insert in a diff
    * 	table linked by foreign key
    */
   public function getPrimeKey()
   {
       if($this->bDebug)
       {
           echo "<br><br>Prime Key<br>";
           echo $this->obDB->insert_id;
       }
       return $this->obDB->insert_id;
   }
}