#coding: utf-8
import pymysql

# if __name__ == '__main__':
#
#     db = pymysql.connect('39.108.129.68', 'root', 'com.exam.sql', 'python_test')
#
#     cursor = db.cursor()
#     sql = "select count(paper_id) from stu_paper where submit_state = 0 and deal_state = 1"
#
#     cursor.execute(sql)
#
#     results = cursor.fetchall()
#
#     print(results[0][0])

class SqlTool(object):

    db = None
    cursor = None

    def __init__(self, db_ip, db_user, db_pwd, db_database):
        db = pymysql.connect(db_ip, db_user, db_pwd, db_database)
        self.cursor = db.cursor()
        self.db = db

    def executeSql(self ,sql):
        # sql = "select paper_id from stu_paper where submit_state = 0 and deal_state = 1"
        self.cursor.execute(sql)

        return self.cursor.fetchall()

    def executeUpdate(self, sql):
        self.cursor.execute(sql)
        self.db.commit()