//#include <readiness_io.h>
#include <Ticker.h>
#include <PubSubClient.h>
#include <ESP8266WiFi.h>
//#include <HX711.h>
#include "config_01.h"

// ===============================
// variable declaration
// ===============================

const int       LED_PIN        = 0;     // The pin connecting the LED (D3)
const int       INTERRUPT_PIN  = 14;    // The pin connect the test button (D5)
const int       RAIN_PIN  = 5;        // The pin connect the tipping bucket sensor (D1)
volatile double RAIN_HEIGHT   = 0;     // variable for storing the rain_height

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
  if (interrupt_time - last_interrupt_time >200){
    RAIN_HEIGHT += BUCKETTIP_HEIGHT; // takes the current rain height and add the amount of the bucket
    Serial.print("Curent Rain Height Collected (mm): ");
    Serial.println(RAIN_HEIGHT);  
  }
  last_interrupt_time = interrupt_time;
}

void pushButtonInterrupt() {
  interrupt++;
}

/* Interrupt timer for sending data to the Readiness.io server */
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


/*
void LeggieMandaDati(){
  //leggi il valore del sensore
  //float dato = scale.get_units();

  int peso = 75;

  InviaDati((float) peso);
}
*/



void InviaDati(float dato)
{
  
  char buffer[100];

  Serial.print( "Invio dato : [" );
  Serial.print( dato );
  Serial.print( "]   -> " );

  snprintf(buffer, 100, "{ \"rain\": %f }", dato);

  Serial.println( buffer );

 /* 
    per thinkBoard
    client.publish("v1/devices/me/telemetry", buffer);
 */

 client.publish("testTopic", buffer);
 
}


// ===============================
// SETUP
// ===============================

void setup() {
  pinMode(LED_PIN, OUTPUT);
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
  // inizializzazione collegamento al sito ThingsBoard
  delay(100);
  client.setServer(THINGSBOARD_HOST, 1883);
  // setup degli interapt per il pluviometro
  pinMode(RAIN_PIN, INPUT_PULLUP); // Set the interrupt pin for the reed/hall effect
  attachInterrupt(digitalPinToInterrupt(RAIN_PIN), rainInterrupt, RISING);  // Attach the interrupt.
  pinMode(INTERRUPT_PIN, INPUT_PULLUP); // Set the interrupt pin for the pushbutton (optional)
  attachInterrupt(digitalPinToInterrupt(INTERRUPT_PIN), pushButtonInterrupt, RISING);  // Attach the interrupt.
  timer.attach(UPDATE_RATE, timerInterrupt);
  
}


void loop() {
    if(interrupt>0){
      if ( !client.connected() ) {
      reconnect();
      }
    InviaDati((float) RAIN_HEIGHT);
    RAIN_HEIGHT = 0;  //reset the rain height
    //RAIN_HEIGHT +=1;
    interrupt=0;
    digitalWrite(LED_PIN,HIGH); // LED lights up to indicate that it the data is being transmitted
    delay(250);
    digitalWrite(LED_PIN,LOW);
  }
}
