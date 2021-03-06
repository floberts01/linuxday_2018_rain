/*)
  TITOLO PROGETTO: Test LCD 128x64 I2C
  DATA APERTURA: 19/09/18
  DATA MODIFICA: 23/09/18
  AUTORE: LUG-VI
 
  REVISION HISTORY:
  - V00 (21/09/18): Primo rilascio per prove su pluviometro
  - V01 (23/09/18): Aggiunta gestione DHT11
  
  DESCRIZIONE: Test su LCD OLED (Le librerie Adafruit sono state modificate)
 

*/ 

#include <SPI.h>
#include <Wire.h>
#include <DHT.h>

#include <Adafruit_GFX.h>             // Versione 1.29
#include <Adafruit_SSD1306.h>         // Modificata

#define OLED_RESET 4
Adafruit_SSD1306 display(OLED_RESET); // Creazione istanza display

#define DHTPIN 2                      // Digital PIN per connessione segnale DHT11
#define DHTTYPE DHT11                 // Tipo sensore
DHT dht(DHTPIN, DHTTYPE);             // Istanza oggetto DHT

//#define NUMFLAKES 10                  // Usato per test dalle librerie
//#define XPOS 0
//#define YPOS 1
//#define DELTAY 2

#define SSD1306_LCDHEIGHT 64          //Definisce altezza LCD in pixel
#define LOGO16_GLCD_HEIGHT 16 
#define LOGO16_GLCD_WIDTH  16 

// Variabili globali di test LCD
float pioggia = 10.3;
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

//**********************
//******** SETUP *******
//********************** 

void setup()   {                
  Serial.begin(9600);

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

//**********************
//******** LOOP ********
//********************** 

void loop() {

  Leggi_DHT11();                                  // Modifica variabili globali
  
  Print_Sensors(pioggia, temperatura, umidita);

  // **** solo per test ****
  pioggia +=1;
  //temperatura +=0.5;
  //umidita +=1;
  // ***********************
}


//**********************
//***CUSTOM FUNCTIONS***
//**********************

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

