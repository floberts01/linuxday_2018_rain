# -*- coding: utf-8 -*-
import paho.mqtt.client as mqtt

mqttc = mqtt.Client()
mqttc.connect("192.168.10.21", 1883)
mqttc.publish("testTopic", "Hello, World!")
mqttc.loop(2) #timeout = 2s
