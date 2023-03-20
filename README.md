# php-chat

## Simple PHP Chat with End To End Encryption
### With Docker, NGINX and Composer

#### Test this PHP code with Docker on URL: [localhost:8080](http://localhost:8080)

#### Or drop it to your Apache live server

Simple copy all Content from [/src/](./src/) to your server Apache server.
*(Note: The project has to be started/build with docker before vendor data is available)*

##### Example URL: [https://chat.dont-use.com/](https://chat.dont-use.com/)


<br>
<br>

# Get Started

<br>

## First Create the `src/app.config.json`file:

Strter Config Code:
```
{
    "appDomain" : "<your.domain.com>",
    "appTitle":"PHP Chat",
    "appDescription":"PHP Chat",

    "appEmail":"<your.administration@email.com>",


}


```

<br>

#### Start Docker Container:
```
docker-compose up
```

#### Rebuild Docker Container:
```
docker-compose up --build
```



