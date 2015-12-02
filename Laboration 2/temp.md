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
* Use a safe API which provides a parameterized interface, without using the interpreter. If none is available, escape specific special characters, using the escape syntax for that enterpretor.  [#1, page 7}
* Also,  ‘white list’ the input as part of validation, but remember that it is not a complete defence since many applications require special characters in their input – then only use API and/or escape syntax.
[#1, page 7}

###Broken Authentication and Session Management
######Estimated risk
High
######Exploitability
Average
######Abstract
Functionalities in an application which somehow relate to authentication and/or session management are often implemented incorrectly which allows attackers to access passwords, session tokens or make use of other flaws in the implementations in order to take over and use other users' identities. [#1, page 6]
######Specific findings
* Passwords do not appear to be hashed, but are stored in plain text.
* The sessions are not timed out.
* Authentication tokens should be invalidated when logged out, which they are currently not.
* Sessions ID’s does not rotate after login, at the moment they remain the same throughout the full session. 
* Data is not sent through an encrypted connection – uses http, not https.
######Consequences
None hashed passwords are a security risk since they are not protected should the database be compromised. If a logged in user doesn’t log out but simply closes the tab while sessions are not timed out another user can open the same address and automatically be logged in. Authentication tokens should not be acceptable to use once the user has been logged out.
The sessions ID does not change after a user is logged in – this makes hijacking sessions much easier.
A non encrypted connection sends all information in clear text, making interception very easy.
######Suggested measures
* Store passwords with hash in database.
* Set a time out / max length to sessions [#2, Session Expiration]
* Invalidate Authentication Tokens when user logs out of the application.
* When a successful login has been made, assign logged in user a new sessionID – [#2, Session Expiration]
* Make sure the application uses https when sending data between client and server.

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

