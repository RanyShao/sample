<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>注册确认链接</title>
</head>
<body>
  <h1> 小伙子，你即将在 我的 网站进行注册！ 你准备好了吗？</h1>

 <h3>我要再提醒你一次，当你注册这个网站的用户之后，人世间的始乱终弃不能再沾半点，否则深入苦海，苦不堪言~</h3>

  <p>
    赶快点击下面的链接完成注册啦，我赶着下班回家呢：
    <a href="{{ route('confirm_email', $user->activation_token) }}">
      {{ route('confirm_email', $user->activation_token) }}
    </a>
  </p>

  <p>
    如果这不是您本人的操作，，，，，那你邮箱很有可能有被盗的风险，要注意喽！哈哈哈。
  </p>
</body>
</html>

