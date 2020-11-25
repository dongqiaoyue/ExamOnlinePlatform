#coding: utf-8

import logging


class Logger(object):
    logger = None

    def __init__(self, logf):
        logger = logging.getLogger('auto_judge')
        logger.setLevel(logging.DEBUG)

        fh = logging.FileHandler(logf)
        fh.setLevel(logging.DEBUG)

        formatstr = '%(asctime)s - %(name)s - %(levelname)s - %(message)s'
        formatter = logging.Formatter(formatstr)

        fh.setFormatter(formatter)
        logger.addHandler(fh)

        self.logger = logger

    def write_log(self, message, level):

        if level == logging.INFO:
            self.logger.info(message)

        elif level == logging.ERROR:
            self.logger.error(message)

        elif level == logging.WARNING:
            self.logger.warning(message)

        elif level == logging.DEBUG:
            self.logger.debug(message)

        else:
            self.logger.info(message)