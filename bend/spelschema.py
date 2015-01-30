# coding utf-8
__author__ = 'macondele'

from bs4 import BeautifulSoup as BS
from urllib import request
from datetime import date, datetime
from mysql_info import *
import pymysql

# Initiate DB
conn = pymysql.connect(host=mysql_host, user=mysql_usr, passwd=mysql_pw, db=mysql_db)

def make_soup(url):
    page = request.urlopen(url).read()
    soup = BS(page)

    return soup

game_rows = []
soup = make_soup('http://svenskfotboll.se/allsvenskan/spelprogram/?scr=fixturelist&ftid=57221&showrounds=true')
table = soup.find('table', class_="clCommonGrid")

for row in table.find_all('tr'):

    # Set the current round
    if row.find('td', class_='clBold'):
        current_round = row.td.text.split(' ')[1]

    # Harvest the game data
    if row.find('td', class_='matchTid'):

        # Date and time
        date_time = row.find('td', class_='matchTid').span.text
        date = datetime.strptime(date_time.split(' ')[0], '%Y-%m-%d').date()
        weekday_int = date.weekday()
        weekdays = ['Måndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lördag', 'Söndag']
        weekday = weekdays[weekday_int]


        # Check if there is a time specified
        if len(date_time.split(' ')) > 1:
            time = date_time.split(' ')[1]
        else:
            time = ''

        # Teams
        teams = row.find_all('td')[1].a.string
        home_team = teams.split(' - ')[0]
        away_team = teams.split(' - ')[1]

        # Arena
        arena = row.find_all('td')[4].a.string

        # Add harvested data to the database
        try:
            print(current_round, date, time, home_team, away_team, weekday, arena)
            cur = conn.cursor()
            cur.execute("""INSERT INTO %s
            (round_number, date, time, home_team, away_team, weekday, arena)
            VALUES('%s', '%s', '%s','%s', '%s', '%s', '%s')
            """
            % (mysql_table, current_round, date, time, home_team, away_team, weekday, arena))
            conn.commit()
            cur.close()
        except:
            print(Error())
            conn.rollback()
            print("Something went wrong when inputting data to the database")
