//Author : Harish Mohanty
/*
 * Distress Connect
 * @version v1.0.0
 * @link
 * Copyright (c) 2019  Distress Connect
 * @Author Team Distress Connect
 * IBM : CALL FOR CODE 2019 Global Challange
 */
//Code   : DCU-6 Transmitter

#include <SPI.h>
#include <LoRa.h>
#include <Wire.h>
#include "DHT.h"

#define DHTPIN A3
#define DHTTYPE DHT22

DHT dht(DHTPIN, DHTTYPE);
String msg = "Sorry world i am the boss of universe. so u can call me as universal boss";
int i = 1, len = 0, noOfIterations = 0, iterationLeft = 0, remainingBytes = 0, counter = 0, pointer = 0;
String msgLen = "", s;
char temp = 'a';
int toPiInterrupt = 4;
const int csPin = 10;          // LoRa radio chip select
const int resetPin = 9;       // LoRa radio reset
const int irqPin = 2;         // change for your board; must be a hardware interrupt pin
String incoming = "";
//String me="CDCU2"
bool sendFlag = false;
String me = "NODE-6";
bool dataFlag = false, reqFlag = false;
int VCC = A2;
int GND = A1;
int DATA = A3;
long current = 0, prev = 0;
int interval = 10000;
float humidity = 0, temperature = 0;
String weatherData="";
void setup() {
  Wire.begin(9);                // join i2c bus with address #8
  Wire.onReceive(requestEvent); // register event
  Serial.begin(9600);
  pinMode(VCC, OUTPUT);
  pinMode(GND, OUTPUT);
  digitalWrite(VCC, HIGH);
  digitalWrite(GND, LOW);
  Serial.println("LoRa Receiver");
  LoRa.setPins(csPin, resetPin, irqPin);
  if (!LoRa.begin(433E6)) {
    Serial.println("Starting LoRa failed!");
    delay(5000);
    while (1);
  }
  Serial.println("Lora Initiated...");
  Serial.print("I am : ");
  Serial.println(me);

  dht.begin();
}

void loop() {
  current = millis();

  if (current - prev == interval) {
    readDHT();
    dataFlag = true;
    weatherData = "ND&CDCU-2#DCU-4#21#NODE-6#DATA*" + String(temperature) + "*" + String(humidity) + "_";
    Serial.println(weatherData);
    prev = current;

    Serial.print("DataFlag : ");
    Serial.println(dataFlag);

    Serial.print("SendFlag : ");
    Serial.println(sendFlag);


  }
  if (sendFlag && !dataFlag) {
    sendData(s);
    sendFlag = false;
  }
  if (!sendFlag && dataFlag) {
    sendWeatherData(weatherData);
    dataFlag = false;
  }

}

void readDHT() {
  dataFlag = true;
  humidity = dht.readHumidity();
  temperature = dht.readTemperature();
}
void sendWeatherData(String s) {
  LoRa.beginPacket();
  LoRa.print(s.c_str());
  LoRa.endPacket();
  Serial.println("Sent to dcu");
  s = "";
}
void sendData(String s) {
  LoRa.beginPacket();
  LoRa.print(s.c_str());
  LoRa.endPacket();
  Serial.println("Sent to dcu");
  s = "";
}

void requestEvent() {

  if (Wire.available() > 0) {

    char c = Wire.read();
    //    Serial.print(c);
    if (c == '^');
    if (c != '_') {
      s += c;

    }
    else if (c == '_') {
      Serial.println(s);
      sendFlag = true;
    }
  }
}
String getValue(String data, char separator, int index)
{
  int found = 0;
  int strIndex[] = { 0, -1 };
  int maxIndex = data.length() - 1;

  for (int i = 0; i <= maxIndex && found <= index; i++) {
    if (data.charAt(i) == separator || i == maxIndex) {
      found++;
      strIndex[0] = strIndex[1] + 1;
      strIndex[1] = (i == maxIndex) ? i + 1 : i;
    }
  }
  return found > index ? data.substring(strIndex[0], strIndex[1]) : "";
}



