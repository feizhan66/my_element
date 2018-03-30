import easygui as g
import sys

while 1:
    # title = "请选择"
    g.msgbox("欢迎来到游戏界面")
    msg = "请问你想在这里学到什么知识呢？"
    title = "小游戏互动"
    choices = ['谈恋爱','编程']
    choice = g.choicebox(msg,title,choices)
    g.msgbox("你的选择是:"+str(choice),"结果")
    msg = "你希望重新开始小游戏嘛？"
    title = "请选择"
    if g.ccbox(msg,title):
        pass
    else:
        sys.exit(0)