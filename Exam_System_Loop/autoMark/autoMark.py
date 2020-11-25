#coding: utf-8

from threading import Thread
import time
import mySql
import random
import RequestMark
import Logger
import logging
import schedule
import queue
import configparser

papers = queue.Queue()
count = 0
logger = None
is_running = False


# 消费者最大线程数
max_thread = 10
# 数据库配置
db_host = 'localhost'
db_user = 'root'
db_pwd = 'com.exam.sql'
db_database = 'stu_system'
# 批阅地址
mark_url = 'http://127.0.0.1/Exam_System_Loop/Code_Admin/web/index.php?r=exam%2Fpython%2Fmark&'


# 模拟批阅测试
def mark(paper_id):
    sql_tool = mySql.SqlTool(db_host, db_user, db_pwd, db_database)

    time.sleep(random.randint(2, 10))
    score = random.randint(40, 90)

    sql_tool.executeUpdate("update stu_paper set score = " + str(score) + " where paper_id = " + str(paper_id))
    return score


class Producer(Thread):
    sql_tool = None

    def __init__(self, name):
        Thread.__init__(self)
        self.name = name
        self.sql_tool = mySql.SqlTool(db_host, db_user, db_pwd, db_database)

    def run(self):
        global logger

        logger.write_log("%s started!" % self.name, logging.DEBUG)
        while is_running and papers.qsize() == 0:
            try:
                result = self.sql_tool.executeSql("select PaperId from exampaper "
                                                  "where SubmitStage = 1 and DealState = 0")

            except ConnectionAbortedError:
                logger.write_log("数据库连接中断，尝试重连……", logging.WARNING)

                self.sql_tool = mySql.SqlTool(db_host, db_user, db_pwd, db_database)
                result = self.sql_tool.executeSql(
                    "select PaperId from exampaper where SubmitStage = 1 and DealState = 0")

            for row in result:
                papers.put(row[0])
                print("[join]试卷-%s加入待批阅队列" % row[0])
                logger.write_log("[join]试卷-%s加入待批阅队列" % row[0], logging.INFO)

            print("[info]共添加%d张待批阅试卷" % papers.qsize())
            logger.write_log("[info]共添加%d张待批阅试卷" % papers.qsize(), logging.INFO)

            time.sleep(600)

        print("Producer: %s end" % self.name)
        logger.write_log("Producer: %s end" % self.name, logging.DEBUG)



class Consumer(Thread):

    def __init__(self, name):
        global count

        Thread.__init__(self)
        self.name = name
        count += 1

    def run(self):
        global count, logger

        logger.write_log("%s started!" % self.name, logging.DEBUG)
        while is_running and papers.qsize() != 0:
            paper = papers.get()
            print("[pending]试卷-%s正在进行批阅" % paper)
            logger.write_log("[pending]试卷-%s正在进行批阅" % paper, logging.INFO)
            try:
                score = RequestMark.requestMark(paper, mark_url)
            except RequestMark.MarkException as e:
                print("[error]试卷-%s批阅失败 %s" % (paper, e))
                logger.write_log("[error]试卷-%s批阅失败 %s" % (paper, e), logging.ERROR)
            else:
                print("[done]试卷-%s完成批阅, 分数为%s" %(paper, score))
                print("[info]剩余%d张待批阅试卷" % papers.qsize())

                logger.write_log("[done]试卷-%s完成批阅, 分数为%s" %(paper, score), logging.INFO)
                logger.write_log("[info]剩余%d张待批阅试卷" % papers.qsize(), logging.INFO)

            time.sleep(1)

        print("Consumer: %s end" % self.name)
        logger.write_log("Consumer: %s end" % self.name, logging.DEBUG)
        count -= 1

# 消费者的工厂类
class ConsumerFactory(object):
    global count

    def get_consumer(self):
        if count < int(max_thread):
            return Consumer("Consumer-" + str(count))
        else:
            return None


# 入口类
class Entrance(object):

    def __init__(self, logf):
        """

        :param logf: 日志工作路径
        :return:
        """
        global logger
        # 注册logger
        logger = Logger.Logger(logf)

    def set_schedule(self, begin_time='0:00', end_time='6:00'):
        """

        :param begin_time: 启动时间
        :param end_time: 关闭时间
        :return:
        """
        schedule.every().day.at(begin_time).do(self.start)
        schedule.every().day.at(end_time).do(self.stop)

        while 1:
            schedule.run_pending()
            time.sleep(1)

    # 开始工作
    def start(self):
        global is_running

        # 读取配置文件
        self.read_config()
        # 开启全局线程锁
        is_running = True
        # 注册消费者控制器
        consume_controller = consumerController('consumerController')
        consume_controller.start()
        # 开启生产者线程
        producer = Producer("Producer-1")
        producer.start()

    # 结束工作
    def stop(self):
        global is_running

        print('stop function envoke')
        is_running = False

    # 读取配置文件
    def read_config(self):
        global db_host
        global db_user
        global db_pwd
        global db_database
        global max_thread
        global mark_url

        conf = configparser.ConfigParser()
        conf.read('/home/auto_judge/auto_mark.ini')
        db_host = conf.get('database', 'host')
        db_user = conf.get('database', 'username')
        db_pwd = conf.get('database', 'password')
        db_database = conf.get('database', 'database')

        max_thread = conf.get('sys', 'max_thread')
        mark_url = conf.get('sys', 'mark_url')


class consumerController(Thread):
    def __init__(self, name):
        Thread.__init__(self)
        self.name = name


    def run(self):
        consumer_factory = ConsumerFactory()
        # 待批阅队列不为空时 向消费者工厂请求消费者
        while is_running:
            if papers.qsize() != 0:
                consumer = consumer_factory.get_consumer()
                if consumer is not None:
                    consumer.start()
                else:
                    time.sleep(10)
            else:
                time.sleep(1)

            print("isStartThreadAlive? and count = %d and lenth = %d" % (count, papers.qsize()))
            logger.write_log("isStartThreadAlive? and count = %d and lenth = %d" % (count, papers.qsize()), logging.WARNING)


# 测试入口
# 作为守护进程 在eg_daemon.py中调用入口类的set_schedule方法
# if __name__ == "__main__":
# #
# #     # consumer_factory = ConsumerFactory()
# #     #
# #     # while 1:
# #     #     if len(queue) != 0:
# #     #         consumer = consumer_factory.get_consumer()
# #     #         if consumer is not None:
# #     #             consumer.start()
# #     #         else:
# #     #             time.sleep(2)
# #
#     entrance = Entrance('C:\\Users\\EndlessZ\\Desktop\\test.log')
#     entrance.set_schedule('2:49')
#     # entrance.start()