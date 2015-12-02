#Security Report 


##Security Problems
###Injection

######Estimated risk
High
######Exploitability
Easy
######Abstract
Injection occurs when data is sent to the interpreter as part of a command or query in order to trick it to execute by the user unintended commands or accessing data without proper authorization. [#1, page 6]
######Specific findings
It is possible to perform an SQL injection in the password form on the index page using the input “ anything’ OR ‘x’=’x “. 
######Consequences
This enables an unathorized user to login to the application as user1. The submitted username does not affect which user that gets logged in when the SQL injection is used. Other code may also be injectable through this form, providing a large security flaw in the application. 
######Suggested measures: 
* Use a safe API which provides a parameterized interface, without using the interpreter. If none is available, escape specific special characters, using the escape syntax for that enterpretor.  
* Also,  ‘white list’ the input as part of validation, but remember that it is not a complete defence since many applications require special characters in their input – then only use API and/or escape syntax.
[#1, page 7}

###Broken Authentication and Session Management
######Estimated risk
######Exploitability
######Abstract
######Specific findings
######Consequences
######Suggested measures

###Missing Function Level Access Control
######Estimated risk
######Exploitability
######Abstract
######Specific findings
######Consequences
######Suggested measures

###Cross-Site Request Forgery (CSRF)
######Estimated risk
######Exploitability
######Abstract
######Specific findings
######Consequences
######Suggested measures



###References
[#1] Creative Commons Attribution Share-Alike, "Category:OWASP Top Ten Project," OWASP, June 2013. 
[PDF] Available: http://owasptop10.googlecode.com/files/OWASP%20Top%2010%20-%202013.pdf. 
[Downloaded: 2015-12-01]

