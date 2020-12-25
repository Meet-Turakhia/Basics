# -*- coding: utf-8 -*-
"""
Created on Wed Oct  7 15:16:02 2020

@author: hsola
"""
from selenium import webdriver
# from selenium.webdriver.support.ui import Select
from bs4 import BeautifulSoup
import pandas as pd
from numpy import arange

options = webdriver.ChromeOptions()
options.headless = True

BSE_List = pd.read_csv(
    "E:\Projects\MeshIntern\Mesh_Data_Analysis\delisted_companies_details2.csv")
BSE_Codes = BSE_List["Security Code"]

Delisted_Stocks = {}

for stock_name in BSE_Codes: 
    Delisted_Stocks[stock_name] = pd.DataFrame()

for i in range(0, len(BSE_Codes)):
    Code = BSE_Codes[i]
    Company = BSE_List["Full Name"][i]
    print(Code)

    for qtrid in arange(65.50, 109.50, 4.0):
        url = "https://www.bseindia.com/corporates/results.aspx?Code=" + \
            str(Code) + "&Company="+Company+"&qtr="+str(qtrid)+"&RType="

        # driver needs to be set everytime before a request so don't shift it out of for loop
        driver = webdriver.Chrome(options=options)
        driver.get(url)
        bs = BeautifulSoup(driver.page_source, 'html.parser')
        Type = bs.find(id="ContentPlaceHolder1_lblresulttype")
        # Type = driver.find_element_by_id('ContentPlaceHolder1_lblresulttype')
        try:
            driver.find_element_by_id(
                'ContentPlaceHolder1_lnkDetailed').click()
        except:
            pass
        finally:
            # select = driver.find_element_by_id('ContentPlaceHolder1_lnkDetailed')
            # select = select.click()
            bs = BeautifulSoup(driver.page_source, 'html.parser')
            table = bs.find_all('table')[3]

            table_rows = table.find_all('tr')

            res = []
            for tr in table_rows:
                td = tr.find_all('td')
                row = [tr.text.strip() for tr in td if tr.text.strip()]

                if row:
                    res.append(row)

            df = pd.DataFrame(res, columns=["A", "B"])
            if Delisted_Stocks[Code].empty:
                Delisted_Stocks[Code] = df
            else:
                Delisted_Stocks[Code
                                ] = Delisted_Stocks[Code].append(df)
            driver.close()
    # print(Delisted_Stocks)
    # f = input("khatam")

print(Delisted_Stocks)
