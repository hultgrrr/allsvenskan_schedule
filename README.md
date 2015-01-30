# Allsvenskan schedule
### Usage
In the folder (`bend`) you will find all the files needed to harvest the full schedule.
You may have to install missing dependencies by yourself. Check which packages of the included ones that you are missing. You'll obviously have to put your own settings into (`mysql_info.py`) to make the script input the harvested data into the MySQL database.

In the folder (`fend`) you have the code used to create the web view of the schedule. Input your own settings into (`connect.php`) to make it connect properly with your MySQL database setup.