from selenium import webdriver
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities
from selenium.webdriver.remote.webdriver import WebDriver
from selenium.webdriver.support.ui import Select, WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from selenium.common.exceptions import TimeoutException
import pandas as pd
from bs4 import BeautifulSoup
import time
import calendar

# options = webdriver.ChromeOptions()
# options.headless = True

capabilities = DesiredCapabilities.INTERNETEXPLORER
capabilities['ignoreProtectedModeSettings'] = True
capabilities['ignoreZoomSetting'] = True
capabilities.setdefault("nativeEvents", False)

expiry_dates = pd.read_csv("expiry_dates.csv", parse_dates=["Date", "Expiry"])
expiry_dates["Date"] = expiry_dates["Date"].dt.strftime("%d-%m-%Y")
expiry_dates["Expiry"] = expiry_dates["Expiry"].dt.strftime("%d-%m-%Y")
dates_count = expiry_dates.shape[0]
# instruments = ["FUTIDX", "OPTIDX", "FUTSTK", "OPTSTK", "FUTIVX"]
instruments = ["OPTIDX", "FUTIDX"]
option = []
# cols = ['Symbol', 'Date', 'Expiry', 'Optiontype', 'Strike Price', 'Open', 'High', 'Low', 'Close', 'LTP', 'Settle Price',
#         'No. of contracts', 'Turnover * in  Lacs', 'Premium Turnover ** in Lacs', 'Open Int', 'Change in OI', 'Underlying Value']

url = "https://www1.nseindia.com/products/content/derivatives/equities/historical_fo.htm"
driver = webdriver.Ie(desired_capabilities=capabilities)
driver.get(url)
bs = BeautifulSoup(driver.page_source, "html.parser")
# driver.save_screenshot("testing.png")

for instrument in instruments:

    for i in range(0, dates_count):

        if expiry_dates.loc[i, "Weekly"] == 1:

            totalOptiontype = 1
            s = 0

            while(s < totalOptiontype):

                # print(expiry_dates.loc[i, "Date"])
                year = expiry_dates.loc[i, "Expiry"].split("-")[2]
                fromDate = expiry_dates.loc[i, "Date"]
                toDate = expiry_dates.loc[i, "Expiry"]

                select_instrument = driver.find_element_by_id("instrumentType")
                instrument_dropdown = Select(select_instrument)
                instrument_dropdown.select_by_value(instrument)

                symbol = driver.find_element_by_id("symbol")
                symbol_dropdown = Select(symbol)
                symbol_dropdown.select_by_value("NIFTY")

                select_year = driver.find_element_by_id("year")
                year_dropdown = Select(select_year)
                year_dropdown.select_by_value(year)

                expiry = driver.find_element_by_id("expiryDate")
                expiry_dropdown = Select(expiry)
                expiry_dropdown.select_by_value(toDate)

                optiontype = driver.find_element_by_id("optionType")
                optiontype_dropdown = Select(optiontype)
                for k in optiontype_dropdown.options:
                    option.append(k.get_attribute("innerHTML"))
                totalOptiontype = len(optiontype_dropdown.options) - 1
                if instrument[0:3] == "FUT":
                    optiontype_dropdown.select_by_index(0)
                else:
                    optiontype_dropdown.select_by_index(s+1)

                driver.execute_script(
                    "document.getElementById('rdPeriod').click();")
                driver.execute_script(
                    "document.getElementById('rdDateToDate').click();")

                select_fromDate = driver.find_element_by_id("fromDate")
                select_fromDate.send_keys(fromDate)

                select_toDate = driver.find_element_by_id("toDate")
                select_toDate.send_keys(toDate)

                getData = driver.find_element_by_id("getButton")
                getData.click()

                time.sleep(1)

                bs = BeautifulSoup(driver.page_source, "html.parser")
                table_body = bs.find("tbody")
                rows = table_body.find_all('tr')
                j = 0
                df = None
                # df = pd.DataFrame(columns=cols)
                for row in rows:
                    j = j + 1
                    if j == 1 or j == 2:
                        cols = row.find_all('th')
                        cols = [x.text.strip() for x in cols]
                        print(cols)
                        print(j)
                        df = pd.DataFrame(columns=cols)
                    cols = row.find_all('td')
                    cols = [x.text.strip() for x in cols]
                    print(cols)
                    if j > 2:
                        print(j)
                        df.loc[j] = cols

                df.to_csv("NSE_scrapped_output/" +instrument +"_"+
                          option[s+1]+"_"+fromDate+"_to_"+toDate+".csv", index=False)

                s = s + 1

        else:
            continue

driver.quit()

# driver.switch_to.alert.accept
# google drive window handle to switch between different windows and work on it.
