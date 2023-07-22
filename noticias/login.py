# encoding: iso-8859-1
from mechanize import Browser #pip install mechanize
from bs4 import BeautifulSoup

br = Browser()
br.set_handle_robots(False)
br.addheaders = [("User-agent","Python Script using mechanize")]
sign_in = br.open("https://www.publituris.pt/wp-login.php")  #the login url
br.select_form(nr = 0) #accessing form by their index. Since we have only one form in this example, nr =0.
br["log"] = "direcao@presspower.pt" #the key "username" is the variable that takes the username/email value
br["pwd"] = "vitoria2013"    #the key "password" is the variable that takes the password value
logged_in = br.submit()   #submitting the login credentials
logincheck = logged_in.read()  #reading the page body that is redirected after successful login
soup = BeautifulSoup(logincheck)
#print (logged_in.code)   #print HTTP status code(200, 404...)
#print (logged_in.info()) #print server info
#print (logincheck) #printing the body of the redirected url after login

ul = soup.findAll("ul",{ "class" : "middle-widget" })[0]
li = ul.findAll("a")[0]
a = li.get('href')

inside = br.open(a)
inside_check = inside.read()
sopa = BeautifulSoup(inside_check)

title_div = sopa.findAll("div",{ "class" : "large-10 large-offset-1 columns" })[0]
title = title_div.findAll("h1")[0]
date = title_div.findAll("p", { "id" : "post-info"})[0]

text_div = sopa.findAll("div",{ "class" : "pf-content" })[0]
sub_text = text_div.findAll("strong")[0]
img = sub_text.findAll("img")[0]

text = sopa.findAll("div",{ "class" : "pf-content" })[0]
print(title)
print(date)
print(text)