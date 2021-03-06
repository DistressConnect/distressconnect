//Author : Harish Mohanty
/*
 * Distress Connect
 * @version v1.0.0
 * @link
 * Copyright (c) 2019  Distress Connect
 * @Author Team Distress Connect
 * IBM : CALL FOR CODE 2019 Global Challange
 */
//Code   : DCU-4 Receiver

#include <SPI.h>
#include <LoRa.h>
#include <Wire.h>

String msg = "Sorry world i am the boss of universe so u can call me as universal boss";
int i = 1, len = 0, noOfIterations = 0, iterationLeft = 0, remainingBytes = 0, counter = 0, pointer = 0;
String msgLen = "";
char temp = 'a';
int toPiInterrupt = 4;
const int csPin = 10;          // LoRa radio chip select
const int resetPin = 9;       // LoRa radio reset
const int irqPin = 2;         // change for your board; must be a hardware interrupt pin
String incoming = "";
String me = "DCU-4";



void setup() {
  Wire.begin(8);                // join i2c bus with address #8
  Wire.onRequest(requestEvent); // register event
  Serial.begin(9600);

  Serial.println("LoRa Receiver");
  LoRa.setPins(csPin, resetPin, irqPin);
  if (!LoRa.begin(433E6)) {
    Serial.println("Starting LoRa failed!");
    delay(5000);
    while (1);
  }
  LoRa.onReceive(onReceive);
  LoRa.receive();



  //  len = msg.length();
  //  noOfIterations = len / 30;
  //  remainingBytes = len % 30;
  //
  //  if (remainingBytes != 0) {
  //    noOfIterations += 1;
  //  }
  //  iterationLeft = noOfIterations;
  //  if (len < 100) {
  //    msgLen = "0" + String(len);
  //  }

}

void loop() {
  delay(100);
}

void requestEvent() {
  counter++;
  if (counter == 1) {
    Wire.write(msgLen.c_str());
    temp = msg.charAt(0);
  }
  else {
    if (i <= len) {
      Wire.write(temp);
      temp = msg.charAt(i);
      //Serial.println(i);
      i++;

    }
    if (i > len) {
      i = 1;
      counter = 0;
    }
  }
}

void onReceive(int packetSize) {
  Serial.println("Lora received");
  digitalWrite(toPiInterrupt, LOW);
  if (packetSize == 0) return;          // if there's no packet, return
  incoming = "";                 // payload of packet

  while (LoRa.available()) {            // can't use readString() in callback, so
    incoming += (char)LoRa.read();      // add bytes one by one
  }
  Serial.println(incoming);
  String destination_id = getValue(incoming, '&', 0);
  Serial.println(destination_id);
  msg = incoming;
  String id = getValue(msg, '#', 1);
  if (id == "me") {
    if (destination_id == "CD" || destination_id == "ND") {

      len = msg.length();
      noOfIterations = len / 30;
      remainingBytes = len % 30;

      if (remainingBytes != 0) {
        noOfIterations += 1;
      }
      iterationLeft = noOfIterations;
      if (len < 100) {
        msgLen = "0" + String(len);
      }
      Serial.print("Msg Length : ");
      Serial.println(len);
      Serial.print("No of Iterations are ");
      Serial.println(noOfIterations);

      digitalWrite(toPiInterrupt, HIGH);
      delay(50);
      digitalWrite(toPiInterrupt, LOW);
    }
  }
  else{
    Serial.println("Not For Me!!!");
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

