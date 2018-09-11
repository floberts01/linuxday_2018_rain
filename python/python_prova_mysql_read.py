#!/usr/bin/python
import MySQLdb

db = MySQLdb.connect(host="localhost",    # your host, usually localhost
                     user="temp_user",         # your username
                     passwd="temp_user_psw",  # your password
                     db="temperature")        # name of the data base

cursor=db.cursor()

query =("SELECT * FROM temperature")

# Use all the SQL you like
cursor.execute(query)

# print all the first cell of all the rows
for row in cursor.fetchall():
    print row[0]

#db.close()


allarme_temperatura = 27.42
cursor.execute("""SELECT date_temperature FROM temperature WHERE value_temperature >%s""", (allarme_temperatura,))
for row in cursor.fetchall():
    print row[0]
#---prende la prima risposta
#print(cursor.fetchone())


db.close()
