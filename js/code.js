// COP 4331 Group 7
// John Balbuza, Fernando Bilbao, Arisa Kitagishi, Imahd Khan, Susan Long,
// Sarah Thompson, Jonathan White
// Our website name and file locations
var urlBase = 'http://cop4331-7.xyz/LAMP';
var extension = "php";



// This function registers the users
// The user inputs their first name, last name, username and password of choice
function registerUser()
{
	// Get first name, last name, user name, and password
	var newUser = document.getElementById("usr").value;
	var passWord = document.getElementById("pass").value;
	var firstName = document.getElementById("signUpFirstName").value;
	var lastName = document.getElementById("signUpLastName").value;
	document.getElementById("registerUser").innerHTML = "";

	// Get Json
	var jsonPayload = '{"username" : "' + newUser + '", "password" : "' + passWord + '", "firstName" : "' + firstName + '", "lastName" : "' + lastName + '"}';
	var url = urlBase + '/SignUp.' + extension;

	// If any field is empty
  	if(firstName.toString() === "" || lastName.toString() === "" || newUser.toString() === "" || passWord.toString() === "" )
  	{
    	alert("Entries cannot be empty.");
  	}
  	// If first name or last name have invalid characters
  	else if(!nameIsValid(firstName) || !nameIsValid(lastName))
  	{
  		alert("First Name and Last Name cannot have special characters or numbers.");
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
				// Sucess! User was able to register successfully
				if (this.readyState == 4 && this.status == 200)
				{
					document.getElementById("registerUser").innerHTML = "User registered successfully";
				}
			};
			xhr.send(jsonPayload);
		}
		// Could not register
		catch(err)
		{
			document.getElementById("registerUser").innerHTML = err.message;
		}
 	}
}

// This function logs the user in with their username and password
function doLogin()
{
	// Variables
	userId = 0;
	firstName = "";
	lastName = "";

	// Get username and password values to log in
	var login = document.getElementById("usr").value;
	var password = document.getElementById("pass").value;

	document.getElementById("loginResult").innerHTML = "";

	// Get Json
	var jsonPayload =  '{"username" : "' + login + '", "password" : "' + password + '"}';
	var url = urlBase + '/Login.' + extension;
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, false);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	try
	{
		// Send Json
		xhr.send(jsonPayload);

		var jsonObject = JSON.parse( xhr.responseText );

		userId = jsonObject.id;

		// Show the first name and last name in the top right
		firstName = jsonObject.firstName;
		lastName = jsonObject.lastName;
		document.getElementById("usr").value = "";
		document.getElementById("pass").value = "";
		location.reload();
	}

	// Unable to login in. Check your fields of entry.
	catch(err)
	{
		document.getElementById("loginResult").innerHTML = "Incorrect Username/Password";
	}

}

// This function logs the user out
function doLogout()
{
	userId = 0;
	firstName = "";
	lastName = "";

	// Add extension
	var url = urlBase + '/Logout.' + extension;
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, false);
	try
	{
		// Send the request and refresh
		xhr.send();
		location.reload();
	}
	catch(err)
	{
		// document.getElementById("loginResult").innerHTML = "Logout";
	}
}

// This functions hides or shows the elements.
// Function given by the professor.
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

// This function allows the user to add contacts to their own contact list
function addContact()
{	
	// Get all necessary variables needed to add a contacts
	var firstName= document.getElementById("addFirstName").value;
	var lastName= document.getElementById("addLastName").value;
	var workNumber = document.getElementById("workPhone").value;
	var mobileNumber= document.getElementById("mobile").value;
	var homeNumber= document.getElementById("homePhone").value;
	var address1= document.getElementById("address1").value;
	var address2= document.getElementById("address2").value;
	var zip= document.getElementById("zip").value;
	var email= document.getElementById("email").value;

	document.getElementById("contactAddResult").innerHTML = "";

	// Get Json
	var jsonPayload = '{"userID": "' + userId + '", "firstName":"'+ firstName+'", "lastName":"'+lastName+'","workPhone" : "' + workNumber + '", "mobilePhone":"'+mobileNumber+'","homePhone" : "' + homeNumber + '", "address1":"'+ address1+ '","address2":"'+address2+'","zip":"'+zip+'","email":"'+email+'"}';
	var url = urlBase + '/AddContact.' + extension;
	
	// If entries are empty
	if(firstName.toString() === "" && lastName.toString() === "" )
	{
		alert("Entries cannot be empty.");
	}	
	// If they aren't empty
	else
	{
		// Request
	    var xhr = new XMLHttpRequest();
	  	xhr.open("POST", url, true);
	  	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
		try
		{
			xhr.onreadystatechange = function()
			{
				// Sucess! Contacts have been added
				if (this.readyState == 4 && this.status == 200)
				{
					// Show new form
	          		document.getElementById("contactForm").reset();
	          		document.getElementById("nameForm").reset();
				}
			};
		xhr.send(jsonPayload);
		}
		// Error with adding contact
		catch(err)
		{
			document.getElementById("contactAddResult").innerHTML = err.message;
		}
	}
}

// This function allows you to search your contacts
function searchContacts(key)
{
	var str;
	var search;
	var contactTable = document.getElementById("contactTable");
	switch(key) 
	{
		case 0:
			search = document.getElementById("contactSearch").value;
			break;
		case 1:
			search = contactTable.getAttribute("data-last-search");
			break;
		default:
			search = "";
	}
	document.getElementById("contactSearchResult").innerHTML="";

	// Get Json
	var jsonPayload = '{"search" : "' + search + '", "userId" : ' + userId + '}';
	var url = urlBase+'/SearchContacts.' + extension;
	var xhr = new XMLHttpRequest();
	xhr.open("POST",url,true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange=function()
		{
			// Sucess! Showing contacts
			if(this.readyState==4 && this.status ==200)
			{
				$("#contactTable tbody tr").remove();
				hideOrShow("contactTable", true);
				hideOrShow("deleteContactButton", true);
				contactTable.setAttribute("data-last-search", search);
				document.getElementById("contactSearchResult").innerHTML="Contacts have been retrieved";
				var jsonObject=JSON.parse(xhr.responseText);
				var i, currObj, tableRow;

				// Create the table for the corresponding search
				for(i=0;i<jsonObject.length;i++)
				{
					tableRow = $('<tr/>');
					tableRow.append("<td>" + (jsonObject[i]['firstName']) + "</td>");
					tableRow.append("<td>" + (jsonObject[i]['lastName']) + "</td>");
					tableRow.append("<td>" + (jsonObject[i]['workPhone']) + "</td>");
					tableRow.append("<td>" + (jsonObject[i]['homePhone']) + "</td>");
					tableRow.append("<td>" + (jsonObject[i]['mobilePhone']) + "</td>");
					tableRow.append("<td>" + (jsonObject[i]['address1']) + "</td>");
					tableRow.append("<td>" + (jsonObject[i]['address2']) + "</td>");
					tableRow.append("<td>" + (jsonObject[i]['zip']) + "</td>");
					tableRow.append("<td>" + (jsonObject[i]['email']) + "</td>");
					tableRow.append("<td><input type=\"checkbox\" id=\"checkbox" + i + "\"></td>");
					$('#contactTable').append(tableRow);
				}
			}
		};
		// Send the Json
		xhr.send(jsonPayload);
	}
	// Couldn't show contacts, so catch the error
	catch(err)
	{
		document.getElementById("contactSearchResult").innerHTML = err.message;
	}
}

// This function allows you to delete your contacts.
// Can delete multiple contacts at once.
function deleteContact(tableName)
{
	// Get json array of contacts marked for deletion
	var jsonPayload = checkedTableBoxesToJSONStrings(tableName);
	var url = urlBase + '/DeleteContact.' + extension;
	var xhr;
	
	// Delete
	for (var i = 0; i < jsonPayload.length; i++)
	{
		xhr = new XMLHttpRequest();
		xhr.open("POST", url, true);
		xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
		
		try
		{
			xhr.onreadystatechange = function()
			{
				// Succesfully deleted the contacts
				if (this.readyState == 4 && this.status == 200)
				{
					document.getElementById("contactForm").reset();
					document.getElementById("nameForm").reset();
					document.getElementById("contactDeleteResult").innerHTML = "Contact(s) deleted";
				}
			};
			xhr.send(jsonPayload[i]);
		}
		// Catch the error, unable to delete
		catch(err)
		{
			document.getElementById("contactDeleteResult").innerHTML = err.message;
		}
	}
	searchContacts(1);
}

// Takes in an html table by id and returns an array of JSON formatted strings
// corresponding to each row with a checked checkbox at the end. A 
// pre-condition for this function is that each row of the table ends with a 
// cell containing a checkbox.
function checkedTableBoxesToJSONStrings(tableName) 
{
	var tableArray = parseTable(tableName);
	var htmlTableHeadings = document.getElementById(tableName).tHead.rows[0].getElementsByTagName("th");
	var jsonStrings = [];
	var currJson = [];
	var i, j;
	
	// Build a JSON formatted string for each row with a checked checkbox
	for (i = 0; i < tableArray.length; i++)
	{
		// check for checked checkbox
		if (tableArray[i][tableArray[i].length - 1])
		{
			currJson = [];
			currJson.push("{ \"");
			currJson.push("userID\" : \"");
			currJson.push(userId);
			currJson.push("\", \"");
			// get data from table row
			for (j = 0; j < tableArray[i].length - 1; j++)
			{
				currJson.push(htmlTableHeadings[j].getAttribute("name"));
				currJson.push("\":\"");
				currJson.push(tableArray[i][j]);
				currJson.push((j == tableArray[i].length - 2) ? "\"" : "\", \"");
			}
			currJson.push(" }");
			jsonStrings.push(currJson.join(""));
		}
	}
	return jsonStrings;
}

// Takes in an html table by id and returns a 2D array representation of that
// table.
function parseTable(tableName) 
{
	// Variable declarations
	var htmlTable = document.getElementById(tableName);
	var tableHeight = htmlTable.rows.length;
	var tableWidth = htmlTable.rows[0].cells.length;
	var tableData = htmlTable.getElementsByTagName("td");
	var data = [];
	var str;
	
	var j = 0;
	for (i = 0; i < tableData.length; i++)
	{
		// If a new row has just been started, then declare a row for 
		// the array and start to populate it.
		if (i % tableWidth  == 0)
		{
			data[j] = [];
			data[j][i % tableWidth] = tableData[i].innerText;
		}
		// If this is the last element on this row, then it will be a 
		// boolean based on a checkbox value. Treat it as a special case.
		if ((i + 1) % tableWidth == 0)
		{
			str = "checkbox" + Math.floor(i / tableWidth);
			data[j][i % tableWidth] = document.getElementById(str).checked;
			j++;
		}
		// Otherwise this location is somewhere in the middle of the 
		// row so just copy the data.
		else
		{
			data[j][i % tableWidth] = tableData[i].innerText;
		}
	}
	return data;
}

// Check if username is valid
function usernameIsValid(username) 
{
    return /^[0-9a-zA-Z_.-]+$/.test(username);
}

// Check if names are valid
function nameIsValid(name)
{
	return /^[a-zA-z]+$/.test(name);
}
