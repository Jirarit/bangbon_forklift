<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login Form</title>
  <?php echo $this->Html->css('login/style.css'); ?>
</head>
<body>
  <section class="container">
    <div class="login">
      <h1>Login to System</h1>
        <?php echo $this->Form->create('User'); ?>
        <p><?php echo $this->Form->input('login', array('div'=>FALSE, 'label'=>FALSE, 'type'=>'text', 'placeholder'=>"Username")); ?></p>
        <p><?php echo $this->Form->input('password', array('div'=>FALSE, 'label'=>FALSE, 'type'=>'password', 'placeholder'=>"Password")); ?></p>
        
        <span style="color:red;"><?php echo $this->Session->flash(); ?></span>
        <p class="remember_me">
          <label>
            <input type="checkbox" name="data[User][remember_me]" id="remember_me">
            Remember me on this computer
          </label>
        </p>
        <p class="submit"><input type="submit"></p>
    </div>
  </section>
</body>
</html>

<script>
    window.onload = function() {
        document.getElementById("UserLogin").focus();
    };
</script>