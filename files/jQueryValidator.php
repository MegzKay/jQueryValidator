<?php
include_once("dbMethods.php");
?>
<!DOCTYPE html>
<!--
A small demo for validating with jQuery Validator
-->
<html>
    <head>
        <title>jQuery Validator</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="../../jquery/external/jquery/jquery.js"></script>
        <script type="text/javascript" src="../../jquery/jquery.validate.min.js"></script>
        
        <style>
            .form-group{
                margin: 10px 0;
            }
            label {
                display: inline-block;
                width: 200px;
                text-align: right;
             }​
             form{
                 width:1500px;
             }
             form input:not([type='submit']){
                 width:200px;
             }
             span.validation-error{
                 color:red;
                 margin-left:10px;
             }
             
        </style>
        <script>
            $(document).ready(function(){

                

                $("#frmUser").validate({
                    errorElement: 'span',//element to use for errors
                    errorClass: 'validation-error', //validator class to use for errors
                    onkeyup: false, //turn off auto validate while typing
                    rules:{
                        fname:{
                            required:true,
                            maxlength: 20
                        },
                        lname:{
                            required:true,
                            maxlength: 20
                        },
                        pNumber:{
                            phoneNumber:true
                        },
                        email:{
                            required:true,
                            email: true,
                            maxlength:50,
                            remote: {
                                url: "jQVCheckEmail.php",
                                type: "post",
                                data: {
                                    email:function()
                                    {
                                        return $( "#email" ).val();
                                    }
                                },
                                error: function(xhr, textStatus, errorThrown)
                                {
                                    alert('ajax loading error... ... ');
                                }
                            },
                        },
                        password:{
                            required:true,
                            minlength: 6,
                            maxlength: 20
                        },
                        passwordAgain:{
                            required:true,
                            minlength: 6,
                            maxlength: 20,
                            equalTo: password,
                        },
                    },
                    messages:{
                        fname:{
                            required:"This field is required",
                            maxlength: "Max characters is 20"
                        },
                        lname:{
                            required:"This field is required",
                            maxlength: "Max characters is 20"
                        },
                        pNumber:{
                            //custom validator
                        },
                        email:{
                            required:"This field is required",
                            email: "Must be in the format abc@abc.com",
                            maxlength: "Max characters is 50",
                            remote:"This email address is already registered",
                        },
                        password:{
                            required:"This field is required",
                            minlength:"Must be at least 6 characters",
                            maxlength: "Max characters is 20"
                        },
                        passwordAgain:{
                            required:"This field is required",
                            maxlength: "Max characters is 20",
                            minlength:"Must be at least 6 characters",
                            equalTo: "Passwords must be equal"
                        },
                    },
                    submitHandler: function(form)
                    {
                        console.log("test");     
                        form.submit(); 



                    }
                });
                jQuery.validator.addMethod("phoneNumber", function(value, element) {
                    return /^(\d{3}?)[\s|-]\d{3}[\s|-]\d{4}$/.test(value); 
                }, "Phone Number must be in format 111-111-1111");
            });

            
        </script>
    </head>
    <body>
        <form id='frmUser' action='' method='post'>
            <div class='form-group'>
                <label for='fname'>First Name:</label>
                <input type='text' name='fname' id='fname' /><span class='validation-error'></span>
            </div>
            <div class='form-group'>
                <label for='lname'>Last Name:</label>
                <input type='text' name='lname' id='lname' />
            </div>
            <div class='form-group'>
                <label for='pNumber'>Phone Number:</label>
                <input type='text' name='pNumber' id='pNumber' placeholder='111-111-1111' /><span class='validation-error'></span>
            </div>
            <div class='form-group'>
                <label for='email'>Email:</label>
                <input type='email' name='email' id='email' /><span class='validation-error'></span>
            </div>
            <div class='form-group'>
                <label for='password'>Password:</label>
                <input type='password' name='password' id='password' /><span class='validation-error' ></span>
            </div>
            <div class='form-group'>
                <label for='passwordAgain'>Enter Password Again:</label>
                <input type='password' name='passwordAgain' id='passwordAgain' /><span class='validation-error'></span>
            </div>
            <div class='form-group'>
                <label hidden></label>
                <input type='submit' name='submit' id='submit' value='submit'/><span class='validation-error'></span>
            </div>
            <input hidden value='hidden' name='hidden' id='hidden'/>
        </form>
        
    </body>
</html>

<?php


if(isset($_POST["hidden"]))
{
    //Set up database object
    $db = new DB();
    
    //sanitize input
    $fname = $db->sanitize("fname");
    $lname = $db->sanitize("lname");
    $pNumber = $db->sanitize("pNumber");
    $email = $db->sanitize("email");
    $password = $db->sanitize("password");

    //Uncomment to set debug mode on
    //$db->setDebug(1);
    
    //Insert data into query
    //When using for real, encrypt password
    $db->doQuery("INSERT INTO jquery_validation (fname,lname,pNumber,email,password) values ('$fname','$lname','$pNumber','$email','$password')");
    
	//Uncomment to see primary key of inserted data
	//echo "Primary Key of inserted data ".$db->getPrimeKey();
    
    
}







?>

