homework7
=========

Installation

Before installation be sure that you have Symfony3 installed and configured.

1. Clone the repository:
 
   $ git clone https://github.com/lilia86/homework7.git -b dev

2. Go to the project root

   cd homework7

3. Check if your server meets the requirements by running:

   $ php bin/symfony_requirements

4. And run the reload to install dependensies, config parameters and clearing cach for prod enviroment

   $ php bin/reload.php

Testing

For testing enter requests:

1. Method GET. URL - http://your_domain/app.php/get?method=get
   Response gives get parameters in json format

2. Method POST. URL - http://your_domain/app.php/post
   Response gives post parameters(in this case - id, name) if they seted in request in json format
   
3. Method PUT. URL - http://your_domain/app.php/put/new_user_id
   Action save in file new user or rewrite user with new_user_id from URL and any information that 
   was seted in request message body in raw format(for example name=Alice&email=some_email). Returns file content in json format
   
4. Method PATCH. URL - http://your_domain/app.php/put/new_user_id
   Action save in file new user or adding some information to user with new_user_id from URL that 
   was seted in request message body (in example above add phone=1233 for user Alice).Returns file content in json format 
      
5. Method DELETE. URL - http://your_domain/app.php/put/new_user_id
   Action delete from file user with new_user_id from URL if it exists. Returns file content in json format  
      
6. You can test GET and POST mehtods running:
      php bin/test.php