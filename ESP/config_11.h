

const String    CHANNEL_ID    = "XXXXXXXXXXXXXX"; // The Readiness.io channel ID
const char*     SENSOR_ID_temp     = "101";
const char*     SENSOR_ID_hygro     = "201";
const char*     SENSOR_ID_pluvio    = "301"; 
//const String  TOPIC         = "sensors/rain/"; // The type of sensor or name of the data your sending
const char*     TOPIC_temp         = "sensors/temp/";
const char*     TOPIC_hygro         = "sensors/hygro/";
const char*     TOPIC_pluvio         = "sensors/pluvio/";
const String    VERSION       = "1";
const String    FORMAT        = "";

const char* MOSQUITTO_HOST="192.168.20.21";

/*
const char*     WIFI_SSID     = "LugVi"; // Your WiFi SSID / name
const char*     WIFI_PASS     = ""; // Your WiFi password
*/

const char* WIFI_SSID = "LUGVI_DEMO";
const char* WIFI_PASS = "";

const uint16_t  UPDATE_RATE   = 120; // How long to wait between sending data back (in seconds)
const uint8_t   TIMEZONE_OFFSET = 10; // The timezone the sensor is located in (eg. 10 for GMT)

const double    BUCKETTIP_HEIGHT = 0.1;    // Don't forget to change this for your own tipping bucket.
                                             // The height of rain collected by a single bucket tip (in millimietre)
                                            // determined by the volume of water collection in a single bucket tip (mL
                                            // divided by the collection area
