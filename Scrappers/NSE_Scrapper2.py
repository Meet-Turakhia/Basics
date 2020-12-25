from selenium import webdriver
from selenium.webdriver.support.ui import Select
import pandas as pd
from bs4 import BeautifulSoup

#options = webdriver.ChromeOptions()
#options.headless = True

url = "https://www1.nseindia.com/products/content/derivatives/equities/historical_fo.htm"
driver = webdriver.Ie()
driver.get(url)
bs = BeautifulSoup(driver.page_source, "html.parser")

instrument = driver.find_element_by_id("instrumentType")
instrument_dropdown = Select(instrument)
instrument_dropdown.select_by_value("OPTIDX")

symbol = driver.find_element_by_id("symbol")
symbol_dropdown = Select(symbol)
symbol_dropdown.select_by_value("NIFTY")

year = driver.find_element_by_id("year")
year_dropdown = Select(year)
year_dropdown.select_by_value("2020")

expiry = driver.find_element_by_id("expiryDate")
expiry_dropdown = Select(expiry)
expiry_dropdown.select_by_value("30-01-2020")

optiontype = driver.find_element_by_id("optionType")
optiontype_dropdown = Select(optiontype)
optiontype_dropdown.select_by_value("CE")

timeperiod = driver.find_element_by_id("rdDateToDate")
timeperiod.click()

fromDate = driver.find_element_by_id("fromDate")
fromDate.send_keys("26-Dec-2019")

toDate = driver.find_element_by_id("toDate")
toDate.send_keys("30-Jan-2020")

getData = driver.find_element_by_id("getButton")
getData.click()

#driver.findElement(By.className("getdata-button")).click();

# driver.execute_script("document.getElementById('getButton').click();")
