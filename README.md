# Workerman 实现即时通讯
## 目录
- [简介](#简介)
- [项目特点](#项目特点)
- [更新记录](#更新记录)

## 简介

基于ThinkPhP5 + Workerman实现的即时通寻功能。
如有建议请联系Email:990527551@qq.com 

## 项目特点

- [x] ThinkPhP5 + Workerman



## 更新记录

#### 2019.7.30 更新
- 新建项目
- 增加使用帮助页面
#### 2019.7.31 更新
- 点对点发送
- 聊天记录持久化
#### 2019.8.1 更新
- 完善点对点发送及面包屑功能
- 注：单发送方存在多个发送框不同接收方的时候可能存在cors不同源的多次访问问题
- 发送图片消息
- 加载图片消息
#### 2019.8.2 更新
- 长连接下QQ表情发送
- 聊天列表加载界面及实时更新
- 长连接消息读取状态变更
#### 总结
- workerman负责接收所有已连接客户端的消息，向所有已连接客户端或 单个/整组客户端发送消息，如sendToUid是向所有绑定在该uid上的页面发送消息；
- 不同客户端在发送消息的时候通过定义不同标识，服务端可以针对不同标记处理不同业务。同样地，客户端在接收到消息的时候
也可以根据不同的标记作出初始化，加载之类的自身业务处理。

