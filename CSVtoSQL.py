import csv
import sys
import MySQLdb
import ConfigParser
import os

def startprogram():
	response = None
	#If config does not exist, create it.
	if __name__ == "__main__":
		path = "CSVtoSQL.ini"
		if not os.path.exists(path):
			print "CSVtoSQL.ini config file not found. Let's create one"
			createConfig(path)
		
	response = raw_input("Welcome to CSV-to-SQL clause converter." "\n" 
						+ "1.Save CSV as SQL to TXT file." "\n"
						+ "2.Save data to MYSQL." "\n"
						+ "3.Edit Config file." "\n"
						+ "4.Exit " "\n") 
	selectfunction(response, path)
	
#This function creates the config file if it hasn't been created already.
def createConfig(path):
	
	host = raw_input("host ")
	user = raw_input("user ")
	password = raw_input("password ")
	database = raw_input("database ")
	csvfile = raw_input("csv-file ")
	
	config = ConfigParser.ConfigParser()
	config.add_section("Settings")
	config.set("Settings", "host ", host)
	config.set("Settings", "user ", user)
	config.set("Settings", "password ", password)
	config.set("Settings","database ", database)
	config.set("Settings","csvfile ", csvfile)

	with open(path, "wb") as config_file:
		config.write(config_file)
	#this function is the use case function
def selectfunction(userinput, config_path):
	readfile = None
	targetfile = None
	
	if userinput == "1":
		readfile = raw_input("Please write file name to read from ")
		targetfile = raw_input("Please write file name to save to ")
		if not(readfile == None and targetfile == None):
			csvtosql(readfile, targetfile)
		else:
			print "There is something wrong with your inputs. Try again"
			startprogram()
	elif userinput == "2":
		config = ConfigParser.ConfigParser()
		config.read(config_path)
 
		# read some values from the config
		host = config.get("Settings", "host")
		user = config.get("Settings", "user")
		password = config.get("Settings", "password")
		database = config.get("Settings", "database")
		readfile = config.get("Settings", "csvfile")
		
		connectToDatabase(host, user, password, database, readfile)
		
	elif userinput == "3":
		crudConfig(config_path)
		
	elif userinput == "4":
		print "Goodbye! <3" "\n" "Shutting down"
		sys.exit()
	else:
		print "Please give valid input "
		startprogram()

def csvtosql(readfilename, targetfilename):
	file = open(targetfilename, "w")
	with open(readfilename, "rb") as csvfile:
		data = csv.reader(csvfile, delimiter= ";")
		next(csvfile) #skip header row
		for row in data:
			#Skip line if it's empty.
			if row[0] == "":
				continue
				
			print "INSERT INTO statement (EXTERNAL_ID, STATEMENT, CATEGORY) VALUES ('" +  row[0] + "',  '" + row[2] + "', '" + row[5] + "');" + '\n' #only print first three columns. ID, STATEMENT, CATEGORY
			file.write( "INSERT INTO statement (EXTERNAL_ID, STATEMENT, CATEGORY) VALUES ('" +  row[0] + "',  '" + row[2] + "', '" + row[5] + "');" + '\n')		
	file.close()		
	csvfile.close()
	return
	
def connectToDatabase(host, user,password, databasename, readfilename):
	
	with open(readfilename, "rb") as csvfile:
		dbdata = [host, user, password, databasename]
	
		
		#Connect to MYSQL database
		conn = MySQLdb.connect(host= dbdata[0],
						user= dbdata[1],
						passwd= dbdata[2],
						db= dbdata[3])
	
		x = conn.cursor()
	
		data = csv.reader(csvfile, delimiter= ";")
		next(csvfile) #skip header row
		for row in data:
			try:
				#Skip line if it's empty.
				if row[0] == "":
					continue
				
				x.execute("INSERT INTO statement (EXTERNAL_ID, STATEMENT, CATEGORY) VALUES ('%s', '%s', '%s');" % (row[0],  row[2], row[5]))
				conn.commit()
			except:
				conn.rollback()
			print "INSERT INTO statement (EXTERNAL_ID, STATEMENT, CATEGORY) VALUES ('%s', '%s', '%s');" % (row[0],  row[2], row[5])

		conn.close()
			
	csvfile.close()
	print "stuff worked I guess!"
	
def crudConfig(path):
	
	#Create, read, update, delete config
	if not os.path.exists(path):
		createConfig(path)
 
	config = ConfigParser.ConfigParser()
	config.read(path)
 
	# read some values from the config
	host = config.get("Settings", "host")
	user = config.get("Settings", "user")
	password = config.get("Settings", "password")
	database = config.get("Settings", "database")
	csvfile = config.get("Settings", "csvfile")
	
	print "Current values " + "\n" + host + " " + " " + user + " " + password + " " + database + " " + csvfile + " \n"
 
	# change a value in the config
	host = raw_input("Host ")
	config.set("Settings", "host ", host)
	
	user = raw_input("user ")
	config.set("Settings", "user ", user)
	
	password = raw_input("password ")
	config.set("Settings", "password ", password)
	
	database = raw_input("database ")
	config.set("Settings", "database ", database)
	
	csvfile = raw_input("csv-file ")
	config.set("Settings", "csvfile ", csvfile) 

	#delete a value from the config
	#config.remove_option("Settings", "font_style")
 
	# write changes back to the config file
	#with open(path, "wb") as config_file:
		#config.write(config_file)
	print "Stuff saved" + "\n"
	startprogram()
	 
	
startprogram()	
sys.exit()


 
 