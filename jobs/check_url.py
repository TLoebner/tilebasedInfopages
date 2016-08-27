#
# Copyright [2016] [Torsten Loebner <loebnert@gmail.com>]
# 
#   Licensed under the Apache License, Version 2.0 (the "License");
#   you may not use this file except in compliance with the License.
#   You may obtain a copy of the License at
# 
#     http://www.apache.org/licenses/LICENSE-2.0
# 
# 				or
# 
#     https://github.com/TLoebner/tilebasedInfopages/blob/master/LICENSE
# 
#   Unless required by applicable law or agreed to in writing, software
#   distributed under the License is distributed on an "AS IS" BASIS,
#   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
#   See the License for the specific language governing permissions and
#   limitations under the License.
# 


import mysql.connector
import metadata_parser
import urllib
from lxml import html
from mysql.connector import errorcode

cnx = mysql.connector.connect(user='root',database='TileInfoPage')
cursor1 = cnx.cursor()
cursor2 = cnx.cursor()
index=0

query = ("SELECT pk, name, link FROM `help_contents`")

cursor1.execute(query)

url_data=[]

index=1
for (pk, name, link) in cursor1:
    try :
        page = metadata_parser.MetadataParser(url=link)
        title = page.get_metadata('title')
        description = page.get_metadata('description')
        if (not title):
            title = " "
        if (not description):
            description = " "
        title=title.replace("\""," ")
        title=title.replace("'"," ")
        title=title.replace(";"," ")
        description=description.replace("\""," ")
        description=description.replace("'"," ")
        description=description.replace(";"," ")
        url_data.append([title,description,"OK",pk])
    except :
        try:
            page = urllib.request.urlopen(link).read()
            url_data.append([" "," ","OK",pk])
        except:
            url_data.append(["URL NOT FOUND","URL NOT FOUND","DEAD LINK",pk])
        index+=1

for items in url_data:
    #try:
        sql="""UPDATE `help_contents` SET meta_name=%s, meta_description=%s, http_result=%s WHERE pk=%s"""
        cursor2.execute(sql, tuple(items))    
        cnx.commit()
    #except :
        #print ("ERROR")
    
cursor1.close()
cursor2.close()

cursor1 = cnx.cursor()
cursor2 = cnx.cursor()

query = ("SELECT pk,name,sequence_no FROM `help_sections` ORDER BY sequence_no ASC;")

cursor1.execute(query)

section_data=[]

index=1
for (pk, name, sequence_no) in cursor1:
     section_data.append([index*10,pk])
     index+=1
     
for items in section_data:
    sql="""UPDATE `help_sections` SET sequence_no=%s WHERE pk=%s"""
    cursor2.execute(sql, tuple(items))    
    cnx.commit()
    
cursor1.close()
cursor2.close()

cursor1 = cnx.cursor()
cursor2 = cnx.cursor()

query = ("SELECT pk,name,sequence_no FROM `help_subsections` ORDER BY sequence_no ASC;")

cursor1.execute(query)

subsection_data=[]

index=1
for (pk, name, sequence_no) in cursor1:
     subsection_data.append([index*10,pk])
     index+=1
     
for items in subsection_data:
    sql="""UPDATE `help_subsections` SET sequence_no=%s WHERE pk=%s"""
    cursor2.execute(sql, tuple(items))    
    cnx.commit()
    
cursor1.close()
cursor2.close()

#query = ("SELECT help_subsection_fk,help_content_fk,sequence_no FROM `help_multicontents` ORDER BY sequence_no ASC;")

#cursor1.execute(query)

#subsection_data=[]

#index=1
#for (pk, name, sequence_no) in cursor1:
     #subsection_data.append([index*10,pk])
     #index+=1

#for items in subsection_data:
    #sql="""UPDATE `help_subsections` SET sequence_no=%i WHERE pk=%i"""
    #cursor2.execute(sql, tuple(items))
    #cnx.commit()

#cursor1.close()
#cursor2.close()

query = ("SELECT pk,name,sequence_no FROM `faq_sections` ORDER BY sequence_no ASC;")

cursor1.execute(query)

subsection_data=[]

index=1
for (pk, name, sequence_no) in cursor1:
     subsection_data.append([index*10,pk])
     index+=1

for items in subsection_data:
    sql="""UPDATE `faq_sections` SET sequence_no=%s WHERE pk=%s"""
    cursor2.execute(sql, tuple(items))
    cnx.commit()

cursor1.close()
cursor2.close()

#query = ("SELECT pk,name,sequence_no FROM `faq_contents` ORDER BY sequence_no ASC;")

#cursor1.execute(query)

#subsection_data=[]

#index=1
#for (pk, name, sequence_no) in cursor1:
     #subsection_data.append([index*10,pk])
     #index+=1

#for items in subsection_data:
    #sql="""UPDATE `help_subsections` SET sequence_no=%i WHERE pk=%i"""
    #cursor2.execute(sql, tuple(items))
    #cnx.commit()

#cursor1.close()
#cursor2.close()

cnx.close()
  
