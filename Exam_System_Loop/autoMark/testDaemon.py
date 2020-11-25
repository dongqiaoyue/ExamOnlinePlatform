#coding: utf-8

import daemon
import logging

def print_info():
    logger = logging.getLogger('log_test.log')
    formatter = logging.Formatter('%(asctime)s %(levelname)-8s: %(message)s')

    file_handler = logging.FileHandler('test.log')
    file_handler.setFormatter(formatter)

    logger.addHandler(file_handler)

    while 1:
        logger.debug("test test")


if __name__ == '__main__':
    with daemon.DaemonContext():
        print_info()