<?php

include_once("dbMethods.php");


if (!empty($_POST['email']))
{
   
    
    $db = new DB();
    $email = $db->sanitize('email');

    $db->doQuery("select email from jquery_validation where email='$email'");
    $result = $db->fetchAssocResult();
            
    if(count($result) > 0)
    {
        if($result[0]["email"] == $email)
        {
            echo "false";
        }
        else
        {
            echo "true";
        }
    }
    else
    {
        echo "true";
        
    }
}
