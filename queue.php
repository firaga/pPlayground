<?php


// 获取父进程id
$parentPid = posix_getpid();
echo "parent progress pid:{$parentPid}\n";
$childList = array();
// 创建消息队列，定义消息类型
$id = ftok(__FILE__, 'm');
$msgQueue = msg_get_queue($id);
const MSG_TYEP = 1;

// 生产者
function producer()
{
    global $msgQueue;
    $pid = posix_getpid();
    $repeatNum = 5;
    for ($i = 0; $i <= $repeatNum; $i++) {
        $str = "({$pid}) progress create! {$i}";
        msg_send($msgQueue, MSG_TYEP, $str);
        $rand = rand(1, 3);
        sleep($rand);
    }
}

// 消费者
function consumer()
{
    global $msgQueue;
    $pid = posix_getpid();
    $repeatNum = 6;
    for ($i = 1; $i <= $repeatNum; $i++) {
        $rel = msg_receive($msgQueue, MSG_TYEP, $msgType, 1024, $message);
        echo "{$message} | consumer({$pid}) destroy \n";
        $rand = rand(1, 3);
        sleep($rand);
    }
}

function createProgress($callback)
{
    $pid = pcntl_fork();
    if ($pid == -1) {
        // 创建失败
        exit("fork progresses error\n");
    } elseif ($pid == 0) {
        // 子进程执行程序
        $pid = posix_getpid();
        $callback();
        exit("({$pid})child progress end!\n");
    } else {
        // 父进程
        return $pid;
    }
}

for ($i = 0; $i < 3; $i++) {
    $pid = createProgress('producer');
    $childList[$pid] = 1;
    echo "create producer progresses: {$pid}\n";
}

for ($i = 0; $i < 2; $i++) {
    $pid = createProgress('consumer');
    $childList[$pid] = 1;
    echo "create consumer progresses: {$pid}\n";
}

while (!empty($childList)) {
    $childPid = pcntl_wait($status);
    if ($childPid > 0) {
        unset($childList[$childPid]);
    }
}
echo "({$parentPid})main progress end!\n";

