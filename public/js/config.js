/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




var app = {
development : {
    base_url : "http://localhost:82/laravel5.3/cocpanel/public"
 
},
production : {
    base_url : "http://appsgenre.com/demo/laravel/cocpanel/public"
    
},
    
    config : function (environment){
        if (environment == "development")
            this.base_url= this.development.base_url;
        else if(environment == "production")
            this.base_url= this.production.base_url;
        
    },
    base_url : ""
};

//var app = new configuration;

app.config("development");

//app.config("production");

console.log(app.base_url);