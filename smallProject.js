
var urlBase="";
var extension = "php";

function login()
{
	//
}

function logout()
{
	//
}

function hidenOrShow()
{
	//
}

function addContact()
{
	//
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

function deleteContact()
{
	//
}
