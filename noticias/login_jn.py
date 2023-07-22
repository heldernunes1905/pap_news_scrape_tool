# encoding: iso-8859-1
from mechanize import Browser #pip install mechanize
from bs4 import BeautifulSoup
from selenium.webdriver import chrome

br = Browser()
br.set_handle_robots(False)
br.addheaders = [("User-agent","Python Script using mechanize")]
sign_in = br.open("https://aminhaconta.xl.pt/LoginNonio?returnUrl=https%3a%2f%2fwww.jornaldenegocios.pt%2f%3fin")  #the login url
br.select_form(nr = 0) #accessing form by their index. Since we have only one form in this example, nr =0.
br["email"] = "direcao@presspower.pt" #the key "username" is the variable that takes the username/email value
br["password"] = "vitoria2013"    #the key "password" is the variable that takes the password value
logged_in = br.submit()   #submitting the login credentials
logincheck = logged_in.read()  #reading the page body that is redirected after successful login
#print (logged_in.code)   #print HTTP status code(200, 404...)
#print (logged_in.info()) #print server info
#print (logincheck) #printing the body of the redirected url after login
#req = br.open("https://www.jornaldenegocios.pt/").read()
print (logincheck)

#print(a)