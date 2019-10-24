# mehmoonchi-demo
1. use create.sql to create database
2. just put ./mehmoonchi folder under www

# Usage
1. to create a request send following json object to http://localhost/mehmoonchi/api/request/create.php

 `{
    "full_name":"kamran ghiasvand",
	"phone":"09221233",
	"type":"birthday",
   "description":"more details"
   }`

use HTTP POST method

2. to see all request just send a GET request to   http://localhost/mehmoonchi/api/request/read.php
   
   it return arrays of above object
