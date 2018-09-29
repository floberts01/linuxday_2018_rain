#!/usr/bin/python
import paho.mqtt.client as mqtt
import time
import MySQLdb
import pprint


def insert_data(data, id):
	value_data = data
	print("data =>" , value_data)
	value_id_sensor = id
	print("sensore =>" , value_id_sensor)
	query = "INSERT INTO temperature (value_temperature, sensor_id) VALUES (%s,%s)" % (value_data, value_id_sensor)
	try:
		db = MySQLdb.connect(host="192.168.20.21",    # your host, usually localhost
                     user="temp_user",         # your username
                     passwd="temp_user_psw",  # your password
                     db="temperature")        # name of the data base
		print (query)
		cursor=db.cursor()
		cursor.execute (query)
		db.commit()
	except Error as e:
		print ('Error:', e)
		db.rollback()
	finally:
		cursor.close()
		db.close()

# The callback for when the client receives a CONNACK response from the server.
def on_connect(client, userdata, flags, rc):
    print("Connected with result code "+str(rc))

    # Subscribing in on_connect() means that if we lose the connection and
    # reconnect then subscriptions will be renewed.
    client.subscribe("sensors/temp/")
    client.subscribe("sensors/hygro/")
    client.subscribe("sensors/pluvio/")

# The callback for when a PUBLISH message is received from the server.
def on_message(client, userdata, msg):
	messaggio = str(msg.payload) 
	print(str(msg.payload))
	posizione = messaggio.find(";")
	print ('position: ', posizione)
	temperatura = float(messaggio[posizione+1:])
	print("data:", temperatura)
	
	sensor_id = int(messaggio[posizione-3:posizione])
	print("sensor_id: ", sensor_id)
	data = {'data' : temperatura , 'id' : sensor_id}
	pprint.pprint(data)
	insert_data(**data)
    
    

client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message

#connessione al broker MQTT porta 1883
client.connect("192.168.20.21", 1883, 60)

# Blocking call that processes network traffic, dispatches callbacks and
# handles reconnecting.
# Other loop*() functions are available that give a threaded interface and a
# manual interface.
client.loop_forever()
