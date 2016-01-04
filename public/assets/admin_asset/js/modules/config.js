 var colors = {
      "danger-color": "#e74c3c",
      "success-color": "#81b53e",
      "warning-color": "#f0ad4e",
      "inverse-color": "#2c3e50",
      "info-color": "#2d7cb5",
      "default-color": "#6e7882",
      "default-light-color": "#cfd9db",
      "purple-color": "#9D8AC7",
      "mustard-color": "#d4d171",
      "lightred-color": "#e15258",
      "body-bg": "#f6f6f6"
    };
    var config = {
      theme: "admin",
      skins: {
        "default": {
          "primary-color": "#3498db"
        }
      }
    };

var server = window.location.hostname;
if(server == 'localhost' || server == 'carpool.dev' || server == '127.0.0.1')
{
  var webUrl = "http://carpool.dev/";
}
else
{
  var webUrl = "http://cristiano.wwhitesoft.com/public/";
}

var apiUrl = webUrl + "api/";
var adminUrl = webUrl + "admin/";

var appConfig = {"webUrl":adminUrl, "apiUrl" : apiUrl, "adminUrl": adminUrl};
