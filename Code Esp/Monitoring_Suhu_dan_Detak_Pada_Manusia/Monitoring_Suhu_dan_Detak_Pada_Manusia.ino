// WIFI
#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <string>

// Wifi Password
const char* ssid = "ESP";
const char* password = "12341234";

// API WEB
const char* serverName = "http://apasaja-iot.000webhostapp.com/api.php";

// MAX30100
#include <Wire.h>
#include "MAX30100_PulseOximeter.h"
PulseOximeter max30100;
float heartRate;

// Time at which the last beat occurred
uint32_t tsLastReport = 0;
uint32_t lastsuhu = 0;
long lastPrint = 0; //Time at which the last data was printed

// DALLAS SUHU
#include "DHT.h"
#define DHTPIN D4
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);
float t;

// OLED
#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x27, 16, 2); 

void setup() {
  Serial.begin(9600);

// Connect to Wi-Fi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
  Serial.println("Connecting to WiFi..");
  delay(500);
  }
  
// DALLAS SUHU 
  dht.begin();
  
// MAX30100
  Serial.println("Initializing pulse oximeter...");
  if (!max30100.begin()) {
    Serial.println("FAILED to initialize pulse oximeter");
    for(;;);
  } else {
    Serial.println("SUCCESS");
  }

//  OLED
  lcd.init();
  lcd.backlight();
}

void loop() {
  max30100detak();
  Serial.print("Heart rate: ");
  Serial.print(heartRate);
  Serial.print(" bpm ");

  dallas();
  Serial.print("Suhu Tubuh: ");
  Serial.print(t);
  Serial.println(" °C"); 

// Upload WEB
  web();

      lcd.print("D: ");
      lcd.setCursor(4,0);
      lcd.print(heartRate);
      lcd.setCursor(10,0);
      lcd.print("bpm");
    
      lcd.setCursor(0,1);
      lcd.print("S: ");
      lcd.setCursor(4,1);
      lcd.print(t);
      lcd.setCursor(10,1);
      lcd.println("°C"); 
}

void max30100detak() {
  // Read from the MAX30100 sensor
  max30100.update();
  // Grab the updated heart rate and SpO2 levels
  if (millis() - tsLastReport >=2000) {
    heartRate = max30100.getHeartRate();
    tsLastReport = millis();    
  }
}

void dallas() {
  if (millis() - lastsuhu >=2000) {
      t = dht.readTemperature();
    lastsuhu = millis();
  }
}

void web(){
  if (millis() - lastPrint >= 10000) // Data Tiap 10 detik
  {    
    //inisialisasi variabel HTTP request
      WiFiClient client;
      HTTPClient http;
    //inisialisasi variabel pengiriman data
      String postData, Detak_Data, Suhu_Data;
    //penyimpanan data sensor ke dalam variabel pengiriman data
      Detak_Data = int(heartRate);
      Suhu_Data = float(t);
      postData = "detak=" +Detak_Data + "&suhu=" +Suhu_Data;  
    //menentukan URL hosting file API
      http.begin(client, serverName);
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    //inisialisasi variabel HTTP request
      int httpCodepost = http.POST(postData); 
      String payload = http.getString();
    //proses pengiriman data ke API file
      Serial.println(httpCodepost);
      Serial.println(payload);
      http.end();
    lastPrint = millis(); // Update the last print time
  }
}
