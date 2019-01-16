Description
   ----------- 
 
 Example of simple application with backend on Laravel 5.7 and frontend on VueJS.
 There's two user roles: admin and user.
 Admin can create users, upload photos and provide users with ability to view particular photos.
 User can login and view only those photos he has rights to view according to the settings provided by admin
 
 
 Installation
   -----------
   
#### To run application please follow these instructions:

- create .env file:
  
``` 
cp .env.example .env
``` 

- create some local db connection and set it to .env file created earlier

- run install script:

``` 
bin/install.sh
```

- open Laravel dev server url in browser which should be available when install script is finished.

```
Laravel development server started: <http://127.0.0.1:8000>

``` 

- You can now login as admin with credentials:
```
email: admin@mail.com
password: admin
```

