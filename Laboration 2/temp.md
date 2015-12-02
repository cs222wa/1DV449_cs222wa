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
It is possible to perform an SQL injection in the password form on the index page. 
In the file login.js, the variables for password and username are being concatenated into the SQL query which is then run in the function “checkLogin”.
######Consequences
* This enables an unathorized user to login to the application as user1 by submitting the input “ anything’ OR ‘x’=’x “ as password. (The submitted username does not affect which user that gets logged in when the SQL injection is used.) 
* The concatenation of the SQL query also means that any variable value passed from the password form, for example “DROP TABLE….” will be interpreted into the SQL query and executed accordingly, providing a large security flaw in the application. 

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
* Session ID's are not destroyed after logoug.
* Data is not sent through an encrypted connection – uses http, not https.

######Consequences
* None hashed passwords are a security risk since they are not protected when stored as clear text. 
* If a logged in user doesn’t log out but simply closes the tab (not the entire browser) when a session are not timed out another user can then open up the same address hours later and automatically be logged in, being fully authenticated as the previous user. 
* Authentication tokens should not be acceptable to use once the user has been logged out.
* If a sessions ID isn't changed after a user logs in/ terminated after a user logs out, hijacking sessions immediately becomes much easier.
* When a non encrypted connection sends all information between the client and server in clear text, interception of sensetive information becomes very easy. [#1, page 8]

######Suggested measures
* Store passwords with hash in database. [#1, page 12]
* Set a time out / max length to sessions [#2, chapter: Session Expiration]
* Make sure sessions are terminated and authentication tokens are invalidated when a user logs out of the application. [#1, page 8]
* When a successful login has been made, assign logged in user a new sessionID – [#1, page 8] [#2, Session Expiration]
* Make sure the application uses an encrypted connection while sending data between client and server. [#1, page 8]

###Missing Function Level Access Control
######Estimated risk
High
######Exploitability
Easy
######Abstract
Usually an application verifies a user's function level access before making the functionality visible in the UI.  However, the application should also make an authorisation check on the server whenever that function is accessed. If that request is not verfified then attacks will be able to exploit that and forge requests that will enablee them to access functionality without proper authorization. [#1, page 6]
######Specific findings
* Using the extensions app Postman in Google Chrome, it is possible to make a POST request to the functionality message/delete without any authorisation and get an “OK” returned in the body. 
* It is also possible for a not-logged in user to access the message board by typing “/message” into the URL field.

######Consequences
Even though the application will not display any messages until a message is sent from a user, if a user logs out and then someone clicks the back navigation button in the browser, and then clicks the “Write your message”-button, the messages will still show. (This is a conjoined with the security problem “Broken Authentication and Session Management” since the sessions are not timed out, keeping the previous user’s session alive even after logout.)
Concerning the POST request made in Postman to the message/delete URL, it is unfortunately not possible to know if this action would actually delete any messages, since the application seems to have faulty implementation of the functionality. Calling the URL: “message/delete” through Postman OR as logged in Administrator, does not remove any messages.
######Suggested measures
Use a consistent authorization module which should be called by all business functionalities to make sure user is authorized to use the specific functionality. It should, by default, deny access to everything, and then grant access to specific roles for each specific function. Also, there should be authorization checks implemented in the application controller and/or business logic layer. [#1, page 13]

###Cross-Site Request Forgery (CSRF)
######Estimated risk
Moderate
######Exploitability
Average
######Abstract
When an CSRF attack is performed, it forces a victim's browser to send a forged HTTP request containing the victim's session cookie along with automatically included authentication information, to a vulnerable web application. This in turn makes it possible for an attacker to force the victim's browser to generate requests towards that application which will then be interpreted as authenticated requests from the victim. [#1, page 6]
######Specific findings
* No use of re-authentication (like CAPTCHA) to validate a human user.
######Consequences
Attackers can trick the user’s browser to make authenticated requests, for example purchases, update account details, money transfers, login/logout etc.
######Suggested measures
* Send an unpredictable token in each HTTP request made. Include it in a hidden field in the body, not in the URL to make it less exposable to threats and attackers. [#1, page 14]
* Use at least one unique token/unique session and user. [#1, page 14]



###References
[#1] Creative Commons Attribution Share-Alike, "Category:OWASP Top Ten Project," OWASP, June 2013. 
[PDF] Available: http://owasptop10.googlecode.com/files/OWASP%20Top%2010%20-%202013.pdf. 
[Downloaded: 2015-12-01]

[#2] 
Raul Siles (DinoSec), "Session Management Cheat Sheet," OWASP.org, September 2015. 
[Wikipedia site] Available: https://www.owasp.org/index.php/Session_Management_Cheat_Sheet#Automatic_Session_Expiration [Viewed: December 2015]



##Performance Problems

##Bootstrap
From what I can tell, the bootstrap.css files are loaded, but never used in the application, resulting in uneccesary loading time. 

