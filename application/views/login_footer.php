<div class="container body-content" style="">
        <hr/>
        <footer>
            <p>&copy; <?php echo date("Y"); ?>-Tanzania Posts Corporation Portal</p>
        </footer>
    </div>
</body>
</html>
<!-- Javascript for validation empty fields -->
<script>
function validateForm() {
  var x = document.forms["myForm"]["username"].value;
  var y = document.forms["myForm"]["password"].value;
  if (x == "") {
    document.getElementById("errorUsername").innerHTML = "The username is required";
    // document.getElementById("errorPassword").style.border = "#a94442";
  	document.getElementById("username").style.border = "solid #a94442";
    return false;
  }
  if(y == "")
  {
  	document.getElementById("errorPassword").innerHTML = "The password is required";
  	document.getElementById("password").style.border = "solid #a94442";
    return false;
  }
};

function myFunction()
{
	var x = document.forms["myForm"]["username"].value;

	if(x != "")
	{
		 document.getElementById("errorUsername").innerHTML = " ";
		 document.getElementById("username").style.border = "solid green";
         return false;
	}
	else
	{
		document.getElementById("errorUsername").innerHTML = "The username is required";
  	    document.getElementById("username").style.border = "solid #a94442";
        return false;
	}
	
};
function myFunction1()
{
	var y = document.forms["myForm"]["password"].value;
	
	if(y != "")
	  {
	  	document.getElementById("errorPassword").innerHTML = " ";
	    document.getElementById("password").style.border = "solid green";
	    return false;
	  }
	  else
	  {
	  	document.getElementById("errorPassword").innerHTML = "The password is required";
	  	document.getElementById("password").style.border = "solid #a94442";
	    return false;
	  }
};
</script>
