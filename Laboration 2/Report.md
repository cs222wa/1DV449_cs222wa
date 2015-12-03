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
* This enables an unauthorized user to login to the application as user1 by submitting the input “ anything’ OR ‘x’=’x “ as password. (The submitted username does not affect which user that gets logged in when the SQL injection is used.) 
* The concatenation of the SQL query also means that any variable value passed from the password form, for example “DROP TABLE….” will be interpreted into the SQL query and executed accordingly, providing a large security flaw in the application. 

######Suggested measures: 
* Use a safe API which provides a parameterized interface, without using the interpreter. If none is available, escape specific special characters, using the escape syntax for that interpreter.  [#1, page 7}
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
* Session ID's are not destroyed after logout.
* Data is not sent through an encrypted connection – uses http, not https.

######Consequences
* None hashed passwords are a security risk since they are not protected when stored as clear text. 
* If a logged in user doesn’t log out but simply closes the tab (not the entire browser) when a session are not timed out another user can then open up the same address hours later and automatically be logged in, being fully authenticated as the previous user. 
* Authentication tokens should not be acceptable to use once the user has been logged out.
* If a sessions ID isn't changed after a user logs in/ terminated after a user logs out, hijacking sessions immediately becomes much easier.
* When a non-encrypted connection sends all information between the client and server in clear text, interception of sensitive information becomes very easy. [#1, page 8]

######Suggested measures
* Store passwords with hash in database. [#1, page 12]
* Set a time out / max length to sessions [#2, chapter: Session Expiration]
* Make sure sessions are terminated and authentication tokens are invalidated when a user logs out of the application. [#1, page 8]
* When a successful login has been made, assign logged in user a new session ID – [#1, page 8] [#2, Session Expiration]
* Make sure the application uses an encrypted connection while sending data between client and server. [#1, page 8]

###Cross-Site Scripting (XXS)
######Estimated risk
Average
######Exploitability
Average
######Abstract
XSS flaws occur whenever an application takes untrusted data and sends it to a web browser without proper validation or escaping. XSS allows attackers to execute scripts in the victim’s browser which can hijack user sessions, deface web sites, or redirect the user to malicious sites. [#1, page 6]
######Specific findings
* It is possible to send scripts and hostile code as messages in the application. 

######Consequences
Hostile code which reveals sensitive information like a user's session ID's and other cookie information to a potential attacker is injectable into the application, resulting in a complete account or application hijacking.
######Suggested measures
* Make sure that characters which are included in script syntaxes are escaped from the input applied in the message field of the application. This will make it impossible for the interpreter to view the input as code. [#3]
* Whitelist the input from the message form to make sure it is not hostile. [#3]
* Only allow a specific length of characters to be inserted into the message form. [#3]


###Missing Function Level Access Control
######Estimated risk
High
######Exploitability
Easy
######Abstract
Usually an application verifies a user's function level access before making the functionality visible in the UI.  However, the application should also make an authorisation check on the server whenever that function is accessed. If that request is not verified then attacks will be able to exploit that and forge requests that will enable them to access functionality without proper authorization. [#1, page 6]
######Specific findings
* Using the extensions app Postman in Google Chrome, it is possible to make a POST request to the functionality message/delete without any authorisation and get an “OK” returned in the body. 
* It is also possible for a not-logged in user to access the message board by typing “/message” into the URL field.
* The entire database and json data is accessable without being logged in as an authorized user.

######Consequences
Even though the application will not display any messages until a message is sent from a user, if a user logs out and then someone clicks the back navigation button in the browser, and then clicks the “Write your message”-button, the messages will still show. (This is a conjoined with the security problem “Broken Authentication and Session Management” since the sessions are not timed out, keeping the previous user’s session alive even after logout.)
Concerning the POST request made in Postman to the message/delete URL, it is unfortunately not possible to know if this action would actually delete any messages, since the application seems to have faulty implementation of the functionality. Calling the URL: “message/delete” through Postman OR as logged in Administrator, does not remove any messages.
The fact that the entire database and json data is accessable is on its own catastrophic since it makes it possible for any intruder or user to exploit its information of the application to the fullest.
######Suggested measures
Use a consistent authorization module which should be called by all business functionalities to make sure user is authorized to use the specific functionality. It should, by default, deny access to everything, and then grant access to specific roles for each specific function. Also, there should be authorization checks implemented in the application controller and/or business logic layer. [#1, page 13]

###Cross-Site Request Forgery (CSRF)
######Estimated risk
Moderate
######Exploitability
Average
######Abstract
When a CSRF attack is performed, it forces a victim's browser to send a forged HTTP request containing the victim's session cookie along with automatically included authentication information, to a vulnerable web application. This in turn makes it possible for an attacker to force the victim's browser to generate requests towards that application which will then be interpreted as authenticated requests from the victim. [#1, page 6]
######Specific findings
* No token is sent in the body or URL of the application.
* There is no use of any re-authentication method (like CAPTCHA) to validate a human user.
######Consequences
Attackers can trick the user’s browser to make authenticated requests, for example purchases, update account details, money transfers, login/logout etc.
######Suggested measures
* Send an unpredictable token in each HTTP request made. Include it in a hidden field in the body, not in the URL to make it less exposable to threats and attackers. [#1, page 14]
* Use at least one unique token/unique session and user. [#1, page 14]

##Performance Problems

###Expiration header
The Expiration header of the application is set to -1, meaning that nothing is saved in the application's cache. This means that each time the page is accessed, all its content must be reloaded from scratch. This causes an unnecessarily large amount of HTTP requests, slowing the application down. Instead, set the Expiration header to a value which enables the information of the application to be saved for a longer period of time, or set a max-age value to Cache-Control. This way the application will only reload information that's been added to the page.

###Resources
From what I can tell, the bootstrap.css files are loaded, but never used in the application, resulting in unnecessary loading time.
The application has a background image which is loaded, but then covered up by  background color, which makes it completely uneccesary and slows down the application.
Js is included and loaded into the application, but is not minimized, which would have made it load and run much faster.
The web page also uses a favicon which is much larger than it should be.


###Inline code
There are CSS and JavaScript code written as inline elements in the HTML code. This is considered bad coding since it both clutters the HTML syntax and slows the application down. Place the JavaScript and the CSS code in corresponding files instead and then link them into / call them from the application when needed.

###Bad placement of script-links
The script links are placed in the application page's header. This is a bad place, since it then forces the page to read the scripts before loading the body of the page, causing unnecessary loading time. Place the scripts at the bottom of the body tag instead.


##Personal Reflections

###Experience
Most of these things, including the tools used to analyse/examine them with are very new to me. It was confusing at first, not knowing where to start, how to use the tools (Postman), what to do or even what to look for, but after some reading up and discussions with classmates it all slowly began to clear, even for me.
I've definitely gained a whole different perspective about web security from this task and I've also come to realize how easy it is to overlook similar flaws in an application. It's no wonder the OWASP top ten security risks are what they are, since they are often things that people don't ever think about, or even know makes a difference.
It is important that we, as future web developers, understand these risks; not just how to prevent them, but also how they work. Because a way of doing things can change, and if they do then we must understand what it is that's changed before we can do anything about it in response. 


_"Know your enemy and know yourself, find naught in fear for 100 battles." - Sun Tzu, The Art of War._



###References
[#1] Creative Commons Attribution Share-Alike, "OWASP Top Ten Project," OWASP, June 2013. 
[PDF] Available: http://owasptop10.googlecode.com/files/OWASP%20Top%2010%20-%202013.pdf. 
[Downloaded: 2015-12-01]

[#2] 
Raul Siles (DinoSec), "Session Management Cheat Sheet," OWASP.org, September 2015. 
[Wikipedia site] Available: https://www.owasp.org/index.php/Session_Management_Cheat_Sheet#Automatic_Session_Expiration [Viewed: December 2015]

[#3] The Open Web Application Security Project, "OWASP Periodic Table of Vulnerabilities", November 2013. 
[Wikipedia site] Available: https://www.owasp.org/index.php/OWASP_Periodic_Table_of_Vulnerabilities_-_Cross-Site_Scripting_(XSS) [Viewed: December 2015]

[#4] Steve Sounders/Andy Oram, High Performance Web Sites: Essential Knowledge for Fronend Engineers, O'Reilly, September 2007. 




