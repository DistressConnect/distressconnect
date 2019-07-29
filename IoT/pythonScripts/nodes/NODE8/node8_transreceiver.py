#!bin/usr/python3
"""
 * Distress Connect
 * @version v1.0.0
 * @link
 * Copyright (c) 2019  Distress Connect
 * @Author Team Distress Connect
 * IBM : CALL FOR CODE 2019 Global Challange
"""
import RPi.GPIO as GPIO
import smbus
import time
import paho.mqtt.client as mqtt
import requests

GPIO.setmode(GPIO.BCM)

bus = smbus.SMBus(1)

address1 = 0x08
address2 = 0x09

time.sleep(1)
msg=""
res_id=0
global_res=0

cdcu_id=""
dcu_id=""
node_id=""
req_id=""
message=""

#left side is the rx and right side is the tx

from_rx_interrupt=4
to_tx_interrupt=19

def gpio_config():
    GPIO.setup(from_rx_interrupt, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)
    GPIO.setup(to_tx_interrupt, GPIO.OUT)

def sendToNodeServer():
    URL="http://192.168.0.100:4004/open_browser?cdcu_id="+cdcu_id+"&dcu_id="+dcu_id+"&req_id="+req_id+"&node_id="+node_id+"&message="+message
    PARAMS = {'cdcu_id':cdcu_id,'dcu_id':dcu_id,'request_id':req_id,'node_id':node_id,'message':message} 
    r = requests.get(url=URL,params=PARAMS)
    print "sent get : ",r.status_code

def sendToDCU(msg):
    print "Message length : ",len(msg)
     
    for i in range(0,len(msg)):
        bus.write_byte(address2, ord(msg[i+1]))
        print msg[i],
        time.sleep(0.01)
    print msg," -> Send to dcu"

def sendRequestToNode(node):
    print("Received")
    __msg__ = "^"+msg.split('#')[0]+"#"+msg.split('#')[1]+"#"+msg.split('#')[2]+"#"+node+"#"+msg.split('#')[4]+"_"
    print __msg__ 
    sendToDCU(__msg__)

def on_message(client, userdata, mssg):
    global msg,res_id,global_res
    print mssg.payload
    msg_list=mssg.payload.split('&')
    msg="^ND&"+msg_list[1]+'_'
    print msg
    sendToDCU(msg)

def on_connect(client, userdata, flags, rc):
    print("Connected with result code "+str(rc))
    client.subscribe("NODE-6")

def writeNumber(value):
    bus.write_byte(address, value)
    return -1

def on_rx(channel):
    global cdcu_id,dcu_id,node_id,req_id,message
    print "Rising edge detected on 4"
    msg=readNumber()
    print "Received Msg : ",msg
    msg_list=msg.split('#')
    cdcu_id=msg_list[0].split('&')[1]
    dcu_id=msg_list[1]
    req_id=msg_list[2]
    node_id=msg_list[3]
    message=msg_list[4]
    sendToNodeServer()

def to_tx(channel):
    print "Rising edge detected on 23"

def readNumber():
    string=""
    data=""
    data_len = ""
    time.sleep(0.5)
    number=bus.read_i2c_block_data(address1,0,3)
    
    for i in number:
        string += chr(i)
    data_len=int(string)
    msg=""
    for i in range(0,data_len):
        msg+=chr(bus.read_byte(address1)) 
    return msg

def mqtt_connect():

    client = mqtt.Client()
    client.connect("guru-cool.com",1883,60)
    client.on_connect = on_connect
    client.on_message = on_message
    client.loop_forever()

def main():
    mqtt_connect()

try:
    gpio_config()    
    GPIO.add_event_detect(from_rx_interrupt, GPIO.RISING, callback=on_rx, bouncetime=300)  
    if __name__=="__main__":
        main()
         
except KeyboardInterrupt:
    GPIO.cleanup()       # clean up GPIO on CTRL+C exit
    exit(0)
except:
    GPIO.cleanup()       # clean up GPIO on CTRL+C exit
    gpio_config()
    main()

GPIO.cleanup()           # clean up GPIO on normal exit

