#coding: utf-8

import requests


# if __name__ == '__main__':
#     rep = requests.get('http://39.108.129.68/Exam_System_Loop/Code_Admin/web/index.php?r=exam%2Fpython%2Fmark&'
#                  'ids=000D3513343B00343B008CCF55E90EA1')
#
#     print(rep.text)

def requestMark(paper_id, mark_url):

    score = requests.get(mark_url + 'ids=' + paper_id)

    if score.status_code != requests.codes.ok:
        raise MarkException('mark error', score.url)

    return score.text


class MarkException(Exception):
    _err_message = ''
    _err_page = ''

    def __init__(self, errno, err_page):
        self._err_message = errno
        self._err_page = err_page

    def write_log(self, web):
        pass

    def __str__(self):
        return repr(self._err_message + ' detail: ' + self._err_page)