#coding: utf-8
import mySql
import time

db_ip = '39.108.129.68'
db_user = 'root'
db_pwd = 'com.exam.sql'
db_database = 'stu_system'


if __name__ == '__main__':
    sql_tool = mySql.SqlTool(db_ip, db_user, db_pwd, db_database)

    # start = time.clock()
    # result = sql_tool.executeSql("select PaperId from exampaper where SubmitStage = 1 and DealState = 0")
    #
    # for rows in result:
    #     print(rows[0])
    # end = time.clock()
    #
    # print(end - start)


    start = time.clock()
    result = sql_tool.executeSql("select count(PaperId) from exampaper where SubmitStage = 1 and DealState = 0")

    for i in range(0, result[0][0]):
        sql_tool.executeSql("select PaperId from exampaper where SubmitStage = 1 and DealState = 0 LIMIT " + str(i) + ", 1")

    end = time.clock()

    print(end - start)
