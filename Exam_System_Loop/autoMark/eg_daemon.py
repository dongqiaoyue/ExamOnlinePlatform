#coding: utf-8
import argparse
import daemon
from daemon import pidfile
import autoMark


def start_daemon(pidf, logf, begin, end):

    with daemon.DaemonContext(
            working_directory='/home/daemon',
            umask=0o002,
            pidfile=pidfile.TimeoutPIDLockFile(pidf),
    ) as context:
        autoMark.Entrance(logf).set_schedule(begin, end)


if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="Example daemon in Python")
    parser.add_argument('-p', '--pid-file', default='/home/auto_judge/eg_daemon.pid')
    parser.add_argument('-l', '--log-file', default='/home/auto_judge/eg_daemon.log')
    parser.add_argument('-b', '--begin', default='0:00')
    parser.add_argument('-e', '--end', default='6:00')
    args = parser.parse_args()

    start_daemon(args.pid_file, args.log_file, args.begin, args.end)