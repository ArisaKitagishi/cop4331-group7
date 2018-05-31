
var urlBase = 'http://cop4331-7.xyz/LAMP';
var extension = "php";

var userId = 0;
var firstName = "";
var lastName = "";

function registerUser()
{
	var newUser = document.getElementById("usr").value;
	var passWord = document.getElementById("pass").value;
	var firstName = document.getElementById("signUpFirstName").value;
	var lastName = document.getElementById("signUpLastName").value;

	alert("username: " + newUser + "password: " + passWord + "firstname: " + firstName + "lastname: " + lastName);

	document.getElementById("registerUser").innerHTML = "";

	var jsonPayload = '{"username" : "' + newUser + '", "password" : "' + passWord + '", "firstName" : "' + firstName + '", "lastName" : "' + lastName + '"}';
	var url = urlBase + '/SignUp.' + extension;

	alert("JSON: " + jsonPayload + "     URL: " + url);
  if(firstName.toString() === "" || lastName.toString() === "" || newUser.toString() === "" || passWord.toString() === "" )
  {
    alert("You need to fill it!!!!!");
  }
  else
	{
  var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function()
		{
			if (this.readyState == 4 && this.status == 200)
			{
				document.getElementById("registerUser").innerHTML = "User registered successfully";
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("registerUser").innerHTML = err.message;
	}
 }
}

function doLogin()
{
	userId = 0;
	firstName = "";
	lastName = "";

	var login = document.getElementById("usr").value;
	var password = document.getElementById("pass").value;

	document.getElementById("loginResult").innerHTML = "";
 
	var jsonPayload =  '{"username" : "' + login + '", "password" : "' + password + '"}';
	var url = urlBase + '/Login.' + extension;

	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, false);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.send(jsonPayload);

		var jsonObject = JSON.parse( xhr.responseText );
   
		userId = jsonObject.id;

		if( userId < 1 )
		{
			document.getElementById("loginResult").innerHTML = "User/Password combination incorrect";
			return;
		}

		firstName = jsonObject.firstName;
		lastName = jsonObject.lastName;
   alert("Welcome back " + firstName + " " + lastName + " !");

		document.getElementById("userName").innerHTML = firstName + " " + lastName;

		document.getElementById("usr").value = "";
		document.getElementById("pass").value = "";
    
    alert("login successful"); 
		hideOrShow( "loggedInDiv", true);
		hideOrShow( "accessUIDiv", true);
		hideOrShow( "loginDiv", false);
	}
	catch(err)
	{
		document.getElementById("loginResult").innerHTML = "Incorrect Username/Password";
	}

}

function doLogout()
{
	userId = 0;
	firstName = "";
	lastName = "";

	hideOrShow( "loggedInDiv", false);
	hideOrShow( "accessUIDiv", false);
	hideOrShow( "loginDiv", true);
}

function hideOrShow( elementId, showState )
{
	var vis = "visible";
	var dis = "block";
	if( !showState )
	{
		vis = "hidden";
		dis = "none";
	}

	document.getElementById( elementId ).style.visibility = vis;
	document.getElementById( elementId ).style.display = dis;
}

function addContact()
{
	var firstName= document.getElementById("firstName").value;
 var  lastName= document.getElementById("lastName").value;
 var workNumber= document.getElementById("workNumber").value;
 var mobileNumber= document.getElementById("mobileNumber").value;
 var address1= document.getElementById("address1").value;
 var address2= document.getElementById("address2").value;
 var zip= document.getElementById("zip").value;
 var email= document.getElementById("email").value;
	document.getElementById("contactAddResult").innerHTML = "";

var jsonPayLoad = '{"firstName":"'+ firstName+'", "lastName":"'+workNumber+'","mobileNumber":"'+mobileNumber+'","address1":"'+ address1+ '","adress2":"'+address2+'","zip":"'+zip+'","email":"'+email+'"}';
	var url = urlBase + '/AddContact.' + extension;

	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function()
		{
			if (this.readyState == 4 && this.status == 200)
			{
				document.getElementById("contactAddResult").innerHTML = "Contact has been added";
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("contactAddResult").innerHTML = err.message;
	}

}

function searchContacts()
{
	var search = document.getElementById("searchText").value;
	document.getElementById("contactSearchResult").innerHTML="";
	var contactList = document.getElementById("contactList");
	contactList.innerHTML="";
	var conView = '{"Search" : "' + search + '"}';
	var url = urlBase+'/searchContacts.' + extension;
	var xhr = new XMLHttpRequest();
	xhr.open("POST",url,true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange=function()
		{
			if(this.readyState==4 && this.status ==200)
			{
				hidenOrShow("contactList", true);
				document.getElementById("colorSearchResult").innerHTML="Contacts have been retrieved";
				var jsonObject=JSON.parse(xhr.responseText);
				var i;
				for(i=0;i<jsonObject.results.length;i++)
				{
					var opt = document.createElement("option");
					opt.text = jsonObject.results[i];
					opt.value = "";
					contactList.options.add(opt);
				}
			}
		};
		xhr.send(conView);
	}
	catch(err)
	{
		document.getElementById("contactSearchResult").innerHTML = err.message;
	}
}
