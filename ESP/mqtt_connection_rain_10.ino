#include "config_11.h"

#include <Ticker.h>
#include <PubSubClient.h>
#include <ESP8266WiFi.h>

#include <SPI.h>
#include <Wire.h>
#include <DHT.h>

#include <Adafruit_GFX.h>             // Versione 1.29 versioni superiori non funzionano
#include <Adafruit_SSD1306.h>         // Modificata


#define OLED_RESET LED_BUILTIN
Adafruit_SSD1306 display(OLED_RESET); // Creazione istanza display

#define DHTPIN 0                      // Digital PIN per connessione segnale DHT11
#define DHTTYPE DHT11                 // Tipo sensore
DHT dht(DHTPIN, DHTTYPE);             // Istanza oggetto DHT

#define SSD1306_LCDHEIGHT 64          //Definisce altezza LCD in pixel
#define LOGO16_GLCD_HEIGHT 16 
#define LOGO16_GLCD_WIDTH  16 

// ===============================
// variable declaration
// ===============================

// Variabili globali di test LCD
//float pioggia = 10.3;
float temperatura = 20.5;
float umidita = 85;

// Bitmap 64x64 con pinguino TUX
static const unsigned char PROGMEM Pinguino [] = {
0xff, 0xff, 0xff, 0xc0, 0x01, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0x80, 0x00, 0xff, 0xff, 0xff,
0xff, 0xff, 0xff, 0x00, 0x0c, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0x00, 0x0c, 0x7f, 0xff, 0xff,
0xff, 0xff, 0xff, 0x00, 0x00, 0x7f, 0xff, 0xff, 0xff, 0xff, 0xff, 0x00, 0x00, 0x3f, 0xff, 0xff,
0xff, 0xff, 0xff, 0x00, 0x00, 0x3f, 0xff, 0xff, 0xff, 0xff, 0xff, 0x00, 0x00, 0x3f, 0xff, 0xff,
0xff, 0xff, 0xff, 0x34, 0x78, 0x1f, 0xff, 0xff, 0xff, 0xff, 0xff, 0x78, 0xfc, 0x1f, 0xff, 0xff,
0xff, 0xff, 0xff, 0x78, 0xcc, 0x1f, 0xff, 0xff, 0xff, 0xff, 0xff, 0x5c, 0xc6, 0x1f, 0xff, 0xff,
0xff, 0xff, 0xff, 0x47, 0x86, 0x1f, 0xff, 0xff, 0xff, 0xff, 0xff, 0x40, 0x86, 0x1f, 0xff, 0xff,
0xff, 0xff, 0xff, 0x60, 0x0c, 0x1f, 0xff, 0xff, 0xff, 0xff, 0xff, 0x40, 0x06, 0x1f, 0xff, 0xff,
0xff, 0xff, 0xff, 0x80, 0x0a, 0x1f, 0xff, 0xff, 0xff, 0xff, 0xff, 0x80, 0x32, 0x0f, 0xff, 0xff,
0xff, 0xff, 0xff, 0xa0, 0xc2, 0x8f, 0xff, 0xff, 0xff, 0xff, 0xff, 0x5f, 0x0e, 0xe7, 0xff, 0xff,
0xff, 0xff, 0xff, 0x60, 0x1e, 0x67, 0xff, 0xff, 0xff, 0xff, 0xff, 0x78, 0x7f, 0x03, 0xff, 0xff,
0xff, 0xff, 0xfe, 0x7f, 0xff, 0x03, 0xff, 0xff, 0xff, 0xff, 0xfe, 0x7f, 0xff, 0x01, 0xff, 0xff,
0xff, 0xff, 0xf8, 0xff, 0xff, 0x80, 0xff, 0xff, 0xff, 0xff, 0xf8, 0xff, 0xff, 0x80, 0xff, 0xff,
0xff, 0xff, 0xf1, 0xff, 0xff, 0x80, 0x7f, 0xff, 0xff, 0xff, 0xe0, 0xff, 0xff, 0xc0, 0x3f, 0xff,
0xff, 0xff, 0xc0, 0xff, 0xff, 0xc0, 0x3f, 0xff, 0xff, 0xff, 0xc0, 0xff, 0xff, 0xe0, 0x1f, 0xff,
0xff, 0xff, 0x83, 0xff, 0xff, 0xe0, 0x1f, 0xff, 0xff, 0xff, 0x83, 0xff, 0xff, 0xe0, 0x0f, 0xff,
0xff, 0xff, 0x27, 0xff, 0xff, 0xf0, 0x07, 0xff, 0xff, 0xff, 0x0f, 0xff, 0xff, 0xf0, 0x87, 0xff,
0xff, 0xff, 0x4f, 0xff, 0xff, 0xf8, 0x83, 0xff, 0xff, 0xfe, 0x1f, 0xff, 0xff, 0xf8, 0x03, 0xff,
0xff, 0xfe, 0x9f, 0xff, 0xff, 0xf8, 0x03, 0xff, 0xff, 0xfe, 0x9f, 0xff, 0xff, 0xf8, 0x01, 0xff,
0xff, 0xfc, 0xbf, 0xff, 0xff, 0xf8, 0x01, 0xff, 0xff, 0xfc, 0x3f, 0xff, 0xff, 0xf8, 0x81, 0xff,
0xff, 0xfc, 0xbf, 0xff, 0xff, 0xf8, 0x81, 0xff, 0xff, 0xfc, 0x3f, 0xff, 0xff, 0xf8, 0x01, 0xff,
0xff, 0xfe, 0xff, 0xff, 0xff, 0xf8, 0x31, 0xff, 0xff, 0xfc, 0x7f, 0xff, 0xff, 0xfe, 0x0f, 0xff,
0xff, 0xf8, 0x3f, 0xff, 0xff, 0xc2, 0x0f, 0xff, 0xff, 0xf8, 0x17, 0xff, 0xff, 0xc2, 0x19, 0xff,
0xff, 0xf0, 0x1b, 0xff, 0xff, 0xc2, 0x31, 0xff, 0xff, 0xc0, 0x0d, 0xff, 0xff, 0xc3, 0xe1, 0xff,
0xfe, 0x00, 0x04, 0xff, 0xff, 0xc0, 0x00, 0xff, 0xfc, 0x00, 0x02, 0x3f, 0xff, 0xc0, 0x00, 0xff,
0xfc, 0x00, 0x01, 0x3f, 0xff, 0xc0, 0x00, 0x7f, 0xfe, 0x00, 0x01, 0x3f, 0xff, 0xc0, 0x00, 0x3f,
0xfe, 0x00, 0x00, 0x3f, 0xff, 0xc0, 0x00, 0x1f, 0xfe, 0x00, 0x00, 0xff, 0xff, 0xc0, 0x00, 0x0f,
0xfe, 0x00, 0x00, 0xff, 0xfe, 0x80, 0x00, 0x0f, 0xfe, 0x00, 0x00, 0x7f, 0xfc, 0x80, 0x00, 0x1f,
0xfc, 0x00, 0x00, 0x30, 0x00, 0x80, 0x00, 0xff, 0xfc, 0x00, 0x00, 0x10, 0x00, 0x80, 0x01, 0xff,
0xfe, 0x00, 0x00, 0x10, 0x00, 0x80, 0x07, 0xff, 0xff, 0x80, 0x00, 0x10, 0x00, 0x80, 0x0f, 0xff,
0xff, 0xf8, 0x00, 0x3f, 0xff, 0x80, 0x3f, 0xff, 0xff, 0xff, 0x00, 0x7f, 0xff, 0x80, 0x3f, 0xff,
0xff, 0xff, 0xc0, 0xff, 0xff, 0xc0, 0xff, 0xff, 0xff, 0xff, 0xfd, 0xff, 0xff, 0xf1, 0xff, 0xff
};


#if (SSD1306_LCDHEIGHT != 64)                               // msg al preprocessore se si usa libreria errata
#error("Height incorrect, please fix Adafruit_SSD1306.h!");
#endif


// Variabili globali pluviometro

const int       INTERRUPT_PIN  = 14;    // The pin connect the test button (D5)
const int       RAIN_PIN  = 12;        // The pin connect the tipping bucket sensor (D0)

volatile double RAIN_HEIGHT   = 0;     // variable for storing the rain_height
char*           topic;

volatile byte interrupt = 0;

// Initialize the Ethernet client object
WiFiClient espClient;
PubSubClient client(espClient);

Ticker timer;

// ===============================
// function declaration
// ==============================

/* Interrupt for counting the number of clicks of the rain gauge */
void rainInterrupt() {
  static unsigned long last_interrupt_time = 0;
  unsigned long interrupt_time = millis();
  //se interrupt sono a meno di 200ms , considero che sia un rimbalzo e ignoro
  if (interrupt_time - last_interrupt_time >100){
    RAIN_HEIGHT += BUCKETTIP_HEIGHT; // takes the current rain height and add the amount of the bucket
    Serial.print("Curent Rain Height Collected (mm): ");
    Serial.println(RAIN_HEIGHT); 
  }
  last_interrupt_time = interrupt_time;
}

/* pushbutton to force sending data to the mqtt broker */
void pushButtonInterrupt() {
  interrupt++;
}

/* Interrupt timer for sending data to the mqtt broker */
void timerInterrupt(){
  interrupt++;
}

/* function to keep alive the connection with mqtt broker */
void reconnect() {
  // Loop until we're reconnected
  while (!client.connected()) {
    Serial.print("Attempting MQTT connection...");
    // Attempt to connect
    if (client.connect("arduinoClient")) {
      Serial.println("connected");
    } 
      else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      // Wait 5 seconds before retrying
      delay(5000);
    }
  }
}


/* function to read the data from the sensor and call the function to send the data to the mqtt broker
 *  
void LeggieMandaDati(){
  //leggi il valore del sensore
  //float dato = scale.get_units();

  int peso = 75;

  InviaDati((float) peso);
}
*/


/* function to send the data to the mqtt broker */
void InviaDati(const char* topic, const char* id, float dato)
{
  char buffer[100];

  Serial.print( "Topic : [" );
  Serial.print( topic );
  Serial.print( "]; Sensore : [" );
  Serial.print( id );
  Serial.print( "]; Dato : [" );
  Serial.print( dato );
  Serial.print( "]   sending...-> " );

  //snprintf(buffer, 100, "{ \"rain\": %f }", dato);
  snprintf(buffer, 100, "%s%s;%5.2f",topic, id, dato);
  Serial.println( buffer );

 
 client.publish(topic, buffer);
}


//*****************************************************************
//Stampa su display i dati dei sensori
//*****************************************************************
void Print_Sensors(float rain, float temperature, float humidity) {

  String buf = "";                            // Raccoglie la variabile sensore trasformata in stringa

  display.setTextSize(1);                     // Impostazione dimensione Font ( 1 o 2 )
  display.setCursor(0,0);                     // Angolo in alto a sinistra
  display.setTextColor(WHITE);                // Possibile solo bianco, ma bisogna farlo
  display.println("--- LUG-VI METEO ---");
  display.println("");
  
  buf=String(rain,1);                         // Trasforma mm piogga in stringa con un decimale
  display.println("mm pioggia: " + buf);
  display.println("");
  
  buf=String(temperature,1);                  // Trasforma temperatura in stringa con un decimale
  display.println("T = " + buf + " C");
  display.println("");
  
  buf=String(humidity,0);                     // Trasforma umidità in stringa senza decimali
  display.println("HR = " + buf + " %");
  display.println("");

  display.display();                          // Mostra i dati e refresh LCD
  delay(2000);                                // Attesa 2s per successiva visualizzazione
  display.clearDisplay();
  
}

//*****************************************************************
//Lettura DHT11
//*****************************************************************
void Leggi_DHT11() {

  umidita = dht.readHumidity();                 // Lettura umidità
  temperatura = dht.readTemperature();          // Lettura temperatura
  
  if (isnan(umidita) || isnan(temperatura)) {
    //Serial.println("Errore lettura sensore DHT11");
    display.setTextSize(1);                     // Impostazione dimensione Font ( 1 o 2 )
    display.setCursor(0,0);                     // Angolo in alto a sinistra
    display.println("SENSOR DHT ERROR!");
    display.display();                          // Mostra i dati e refresh LCD
    delay(2000);                                // Attesa 1s per successiva visualizzazione
    display.clearDisplay();
    return;
  }

//  Solo per test
//  Serial.print("Humidity: ");
//  Serial.print(umidita);
//  Serial.print(" %\t");
//  Serial.print("Temperature: ");
//  Serial.print(temperatura);
//  Serial.println(" *C ");
    
}

// ===============================
// SETUP
// ===============================

void setup() {
  
  pinMode(BUILTIN_LED, OUTPUT);
  digitalWrite(BUILTIN_LED, HIGH); // internal LED is switched on when low - so we have to switch it off/
  //serial inizialization
  
  Serial.begin(115200);
  Serial.setTimeout(2000);
  while(!Serial) { } // Wait for serial to initialize.
  Serial.println("Device Started");
  
//WiFi inizialization
  //client.wifiConnection(WIFI_SSID, WIFI_PASS);
  delay(10);

// We start by connecting to a WiFi network
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(WIFI_SSID);
  WiFi.begin(WIFI_SSID, WIFI_PASS);
  while (WiFi.status() != WL_CONNECTED)
    {
      delay(500);
      Serial.print(".");
    }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
  
//inizializzazione collegamento al broker MQTT
  
  delay(100);
  client.setServer(MOSQUITTO_HOST, 1883);
  
// setup degli interrupt per il pluviometro
  
  pinMode(RAIN_PIN, INPUT_PULLUP); // Set the interrupt pin for the reed/hall effect with pull up
  attachInterrupt(digitalPinToInterrupt(RAIN_PIN), rainInterrupt, RISING);  // Attach the interrupt at rising slope.
  
  pinMode(INTERRUPT_PIN, INPUT_PULLUP); // Set the interrupt pin for the pushbutton (optional)
  attachInterrupt(digitalPinToInterrupt(INTERRUPT_PIN), pushButtonInterrupt, RISING);  // Attach the interrupt.
  
  timer.attach(UPDATE_RATE, timerInterrupt);

// inizializzazione display

  display.begin(SSD1306_SWITCHCAPVCC, 0x3C);  // Init oggetto display con indirizzo 0x3C
  dht.begin();
    
  display.display();
  delay(2000);

  display.clearDisplay();                     // Pulisce LCD

  display.setTextSize(2);                     // Impostazione dimensione Font ( 1 o 2 )
  display.setTextColor(WHITE);                // Possibile solo bianco, ma bisogna farlo
  display.setCursor(0,0);                     // Angolo alto a sinistra
  
  display.println(" LINUX DAY");              // Splash iniziale
  display.println("    2018  ");
  display.display();                          // Refresh display
  delay(4000);
  display.clearDisplay();

  display.drawBitmap( 32, 0,Pinguino, 64, 64, 1);   // Stampo bmp Pinguino
  display.display();
  delay(6000);
  display.clearDisplay(); 

  
}



void loop() {
    

    Leggi_DHT11();                                  // Modifica variabili globali
    Print_Sensors(RAIN_HEIGHT, temperatura, umidita);
  
    
    if(interrupt>0){
      if ( !client.connected() ) {
      reconnect();
      }
    
    InviaDati((const char*)TOPIC_temp, (const char*)SENSOR_ID_temp, (float) temperatura);
    InviaDati((const char*)TOPIC_hygro, (const char*)SENSOR_ID_hygro, (float) umidita);
    InviaDati((const char*)TOPIC_pluvio, (const char*)SENSOR_ID_pluvio, (float) RAIN_HEIGHT);
    RAIN_HEIGHT = 0;  //reset the rain height
    interrupt=0;
    }
 }
